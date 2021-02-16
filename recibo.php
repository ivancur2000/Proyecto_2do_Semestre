<?php
session_start();
ob_start();
require_once 'resuorces/config/database.php';

if(isset($_GET['id']))
{
    $id=$_GET['id'];
    $sql=mysqli_query($conn, "SELECT c.nom_cli, c.ape_cli, c.nit_cli, cu.codigo,cu.monto_cancelado,i.descripcion, cu.num_cuota, cu.total_cuota, cu.fecha_cuota FROM cuota as cu INNER JOIN cliente as c ON c.id_cli = cu.id_cli INNER JOIN venta as v ON v.id_venta = cu.id_venta INNER JOIN inmueble as i ON i.id_inmueble = v.id_inmueble WHERE cu.codigo = '$id'");
    $fila = mysqli_fetch_array($sql);
}
?>
<page backtop="10mm" backbottom="10mm" backleft="20mm" backright="20mm">
 <h1 >Recibo de pago Mensual</h1>       <br>
  <b>Nombre:</b><p><?php echo $fila['nom_cli']." ".$fila['ape_cli']; ?></p><br>
  <b>NIT:</b><p><?php echo $fila['nit_cli']; ?></p><br>
  <b>Codigo:</b><p><?php echo $fila['codigo']; ?></p><br>
  <b>Monto Cancelado:</b><p><?php echo $fila['monto_cancelado']; ?></p><br> 
  <b>Inmueble: </b><p><?php echo $fila['descripcion']; ?></p><br>
</page>
<page_header> Yolita.SRL</page_header>
<page_footer>Yolita.SRL</page_footer>
<?php

  $content = ob_get_clean();
  require __DIR__.'/vendor/autoload.php';
  use Spipu\Html2Pdf\Html2Pdf;
  try
  {
      $html2pdf = new HTML2PDF('P', 'A4', 'es', true, 'UTF-8', 3);
      $html2pdf->pdf->SetDisplayMode('fullpage');
      $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
      $html2pdf->Output('recibo.pdf');
  }
  catch(HTML2PDF_exception $e) {
      echo $e;
      exit;
  }
  ?>