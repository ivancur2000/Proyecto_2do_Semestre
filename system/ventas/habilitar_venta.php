<?php 
session_start(); 
$titulo = "Habilitar ventas"; 
$ubicacion = "Ventas";
//consulta a la base de datos
require_once '../../resuorces/config/database.php';
$sql = mysqli_query($conn, "SELECT d.id_des, c.nom_cli, c.ape_cli, i.descripcion, i.id_inmueble, c.id_cli FROM deseados as d INNER JOIN cliente as c ON c.id_cli = d.id_cli INNER JOIN inmueble as i ON i.id_inmueble = d.id_inmueble ");
$numero = 0;
if(isset($_GET['id']))
{
    $id_des1 = $_GET['id'];
}
if(isset($_GET['id2']))
{
    $id_des2 = $_GET['id2'];
}
if(isset($_GET['id3']))
{
    $id_des3 = $_GET['id3'];
    $delete = "DELETE FROM deseados WHERE id_des = $id_des3";
    if(mysqli_query($conn, $delete))
    {
        $alert="Eliminacion exitosa";
    }else
    {
        $alert = "ocurrio un error";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ventas</title>
    <!-- DataTables -->
    <link rel="stylesheet" href="../adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<?php include "../sidebar/sidebar.php"; ?>
    <div class="card" style="margin: 15px;">
        <div class="card-header">
        </div>
        <div class="card-body">
            <table id="tabla1" class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>Num</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Inmueble</th>
                        <th>Tarea</th>
                    </tr>
                </thead>
                <tbody>
                <?php while($vector = mysqli_fetch_array($sql)){ $numero++; ?>
                    <tr>
                        <th><?php echo $numero; ?></th>
                        <td><?php echo $vector['nom_cli']; ?></td>
                        <td><?php echo $vector['ape_cli']; ?></td>
                        <td><?php echo $vector['descripcion']; ?></td>
                        <td><a href="habilitar_venta.php?id=<?php echo $vector['id_des']; ?>" class="btn btn-outline-success btn-sm">Habilitar Venta</a><a href="habilitar_venta.php?id2=<?php echo $vector['id_des']; ?>" class="btn btn-outline-primary btn-sm">Reservar</a><a href="habilitar_venta.php?id3=<?php echo $vector['id_des']; ?>" class="btn btn-outline-danger btn-sm">Eliminar</a></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
<?php include 'venta_alta.php'; ?>
<?php include "../sidebar/sidebar2.php"; ?>
<?php include "../modal_alerta/alert.php"; ?>
<!-- DataTables -->
<script src="../adminlte/plugins/datatables/jquery.dataTables.js"></script>
<script src="../adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="../../js/methods/tabla.js"></script>
<script type="text/javascript">
    $(document).ready(function()
    {
        var deseado = '<?php echo $id_des1; ?>'
    if(deseado !== "" ){
        $("#venta").modal("show");
        deseado = '';
    }
    });
</script>
<script type="text/javascript">
    $(document).ready(function()
    {
        var deseado2 = '<?php echo $id_des2; ?>'
    if(deseado2 !== "" ){
        $("#reserva").modal("show");
        deseado2 = '';
    }
    });
</script>
</body>
</html>