<?php 
session_start(); 
$titulo = "Cuotas mensuales"; 
$ubicacion = "Ventas";
//consulta a la base de datos
require_once '../../resuorces/config/database.php';
$sql = mysqli_query($conn, "SELECT u.nom_us, u.app_us, cli.nom_cli, cli.ape_cli, i.descripcion,c.monto_cancelado,c.num_cuota, c.total_cuota,c.fecha_cuota FROM cuota as c, venta as v, cliente as cli, inmueble as i, usuario as u WHERE c.id_cli = cli.id_cli AND v.id_venta = c.id_venta AND v.id_inmueble = i.id_inmueble AND v.id_us = u.id_us AND c.est_cuota = 0");
$numero = 0;
if(isset($_GET['id']))
{
    $id_des1 = $_GET['id'];
}

if(isset($_GET['id2']))
{
    $id_des3 = $_GET['id2'];
    $delete = "UPDATE cuota SET est_cuota = 1 WHERE id_cuota = $id_des3";
    if(mysqli_query($conn, $delete))
    {
        $alert="Habilitacion exitosa";
        header('refresh:2; url=ventas_des.php');
    }else
    {
        $alert = "Ocurrio un error";
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
            Lista de ventas deshabilitadas
        </div>
        <div class="card-body">
            <table id="tabla1" class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>Num</th>
                        <th>Agente I.</th>
                        <th>Cliente</th>
                        <th>Descripcion</th>
                        <th>Numero de Cuota</th>
                        <th>Monto a cancelar</th>
                        <th>Monto Cancelado</th>
                        <th>Fecha</th>
                        <th>Tarea</th>
                    </tr>
                </thead>
                <tbody>
                <?php while($vector = mysqli_fetch_array($sql)){ $numero++; ?>
                    <tr>
                        <th><?php echo $numero; ?></th>
                        <td><?php echo $vector['nom_us']." ".$vector['app_us']; ?></td>
                        <td><?php echo $vector['nom_cli']." ".$vector['ape_cli']; ?></td>
                        <td><?php echo $vector['descripcion']; ?></td>
                        <td><?php echo $vector['num_cuota']; ?></td>
                        <td><?php echo $vector['total_cuota']." Bs"; ?></td>
                        <td><?php echo $vector['monto_cancelado']." Bs"; ?></td>
                        <td><?php echo $vector['fecha_cuota']; ?></td>
                        <td><a href="ventas_des.php?id2=<?php echo $vector['id_venta']; ?>" class="btn btn-outline-success btn-sm">Habilitar</a></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
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