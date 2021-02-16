<?php 
session_start(); 
$titulo = "Ventas Activas"; 
$ubicacion = "Ventas";
//consulta a la base de datos
require_once '../../resuorces/config/database.php';
$sql = mysqli_query($conn, "SELECT v.id_venta, u.nom_us,u.app_us,c.nom_cli,c.ape_cli,i.descripcion, v.num_cuotas, v.cuotas_pagadas FROM venta as v INNER JOIN usuario as u ON u.id_us = v.id_us INNER JOIN cliente as c ON c.id_cli = v.id_cli INNER JOIN inmueble as i ON i.id_inmueble = v.id_inmueble WHERE v.est_venta = 1");
$numero = 0;
if(isset($_GET['id']))
{
    $id_des1 = $_GET['id'];
}

if(isset($_GET['id2']))
{
    $id_des3 = $_GET['id2'];
    $delete = "UPDATE venta SET est_venta = 0 WHERE id_venta = $id_des3";
    if(mysqli_query($conn, $delete))
    {
        $alert="Eliminacion exitosa";
        header('refresh:2; url=lista_venta_hab.php');
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
            Lista de Ventas activas
        </div>
        <div class="card-body">
            <table id="tabla1" class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>Num</th>
                        <th>Agente I.</th>
                        <th>Cliente</th>
                        <th>Descripcion</th>
                        <th>Numero de cuotas</th>
                        <th>Cuotas pagadas</th>
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
                        <td><?php echo $vector['num_cuotas']; ?></td>
                        <td><?php echo $vector['cuotas_pagadas']; ?></td>
                        <td><a href="lista_venta_hab.php?id=<?php echo $vector['id_venta']; ?>" class="btn btn-outline-success btn-sm">Modificar</a><a href="lista_venta_hab.php?id2=<?php echo $vector['id_venta']; ?>" class="btn btn-outline-danger btn-sm">Eliminar</a></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
<?php include "mod_venta.php"; ?>
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
        $("#mod").modal("show");
        deseado = '';
    }
    });
</script>
</body>
</html>