<?php
session_start();
require_once '../../resuorces/config/database.php';
$titulo = "Fotografias de edificios"; 
$ubicacion = "Edificios";
if(isset($_GET['id_edificio']))
{
    $edificio = $_GET['id_edificio'];
    $_SESSION['edi'] = $_GET['id_edificio'];
    $consulta = mysqli_query($conn,"SELECT * FROM edificio WHERE id_ed = '$edificio' ");
    $fila = mysqli_fetch_array($consulta);
}else
{
    header('location: lista_edi.php');
}
//consulta a la base de datos
if(!empty($_POST['btn_foto']))
{
    if(isset($_FILES['imagen']))
	{
		$nom_img = $_FILES['imagen']['name'];
		$type_img = $_FILES['imagen']['type'];
		$tam_img = $_FILES['imagen']['size'];
		if($type_img == "image/jpg" || $type_img == "image/jpeg" || $type_img == "image/png")
		{
			if($tam_img <= 1000000)
			{	
                $imagen = mysqli_query($conn, "SELECT * FROM imagenes WHERE img = '$nom_img'");
                $filas = mysqli_num_rows($imagen);
                if($filas == 0){
                    $destino = $_SERVER['DOCUMENT_ROOT'] . '/yolitaV3/img/edificios/'; 
                    move_uploaded_file($_FILES['imagen']['tmp_name'],$destino.$nom_img);
                    $alta = "INSERT INTO imagenes (img, id_ed, est_img) VALUES ('$nom_img', $edificio, 1)";
                    if(mysqli_query($conn, $alta))
                    {
                        $alert="Imagen Insertada con exito";
                        echo '<META HTTP-EQUIV="REFRESH" CONTENT="2;URL=http://localhost/yolitav3/system/edificio/foto_edi.php?id_edificio='.$edificio.'">';
                    }else
                    {
                        $alert="Ocurrio un error, intentelo de nuevo";
                    }
                }else
                {
                    $alert="La imagen ya existe";
                }
            }else
            {
                $alert="La imagen pesa demasiado";
            }
        }else
        {
            $alert = "La imagen no tiene un formato Valido";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edificios</title>
    <link rel="stylesheet" href="../../css/style.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="../adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed"> 
<?php include "../sidebar/sidebar.php"; ?> 
    <div class="col"> 
    <a href="#agregar" data-toggle="modal" class="btn btn-success">Agregar mas imagenes</a>
    <h3>Edificio: <?php echo $fila['nombre_ed']; ?></h3>
        <div class="row">
            <?php
            $sql = mysqli_query($conn,"SELECT * FROM imagenes WHERE id_ed = '$edificio' AND est_img = 1");
            $respuesta = mysqli_num_rows($sql);
            if($respuesta > 0){
                while($data = mysqli_fetch_array($sql)){
                ?>
                <a href="eliminar_img.php?id_img=<?php echo $data['id_img']; ?>">
                    <img src="../../img/edificios/<?php echo $data['img'] ?>" onmouseout="this.src='../../img/edificios/<?php echo $data['img']; ?>';" onmouseover="this.src='../../img/inmuebles/cover.png';" style="width: 350px; height:350px; margin:20px; border-radius: 10px;" alt="imagen edificio">
                </a>
            <?php
                }
            }else
            {
                echo '<p><b>No se encotraron imagenes</b></p>';
            }
             ?>
        </div>
        
    </div>
    <?php include "../sidebar/sidebar2.php"; ?>
    <?php include "../modal_alerta/alert.php"; ?>
    <!-- DataTables -->
    <script src="../adminlte/plugins/datatables/jquery.dataTables.js"></script>
    <script src="../adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="../adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="../../js/methods/tabla.js"></script>
</body>
</html>
<div class="modal fade" id="agregar" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" id="header">
                <h3>Agregar Fotografias</h3>
            </div>
            <div class="card">
                <form action="foto_edi.php?id_edificio=<?php echo $_SESSION['edi']; ?>" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id_edi"  value = "<?php echo $edificio; ?>">
                    <div class="card-body">
                        <!-- foto de perfil -->
                        <div class="form-group">
                            <label for="img">Fotografia:</label>
                            <input type="file" name="imagen" class="form-control-file" id="img">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" name="btn_foto" value="Subir" class="btn btn-success">
                        <input type="button" value="Cancelar"data-dismiss="modal" class="btn btn-danger">               
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>