<?php
session_start();
$titulo = "Lista de tipos de inmueble"; 
$ubicacion = "Tipos de inmueble";
require_once '../../resuorces/config/database.php';
//lista
$sql = mysqli_query($conn, "SELECT * FROM tipo_inmueble WHERE est_tipo = '1'");
$cont = 0;
//eliminacion de datos
if(!empty($_GET)){
    if(empty($_GET['id_del']))
    {
        header('Location: tipo_inmu_lista.php');
    }
    $id = $_GET['id_del'];
    $cmd = mysqli_query($conn,"SELECT * FROM tipo_inmueble WHERE id_tipo = '$id'");
    $resultado2 = mysqli_num_rows($cmd);
    if($resultado2 == 0)
    {
        header('Location: tipo_inmu_lista.php');
    }else
    {
        $del ="UPDATE tipo_inmueble SET est_tipo='0' WHERE id_tipo = '$id'";
        if(mysqli_query($conn, $del))
        {
            $alert="Dato eliminado con exito";
            header('refresh:1;url=tipo_inmu_lista.php');
        }else
        {
            $alert="Ocurrio un error";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de tipos de inmueble</title>
    <link rel="stylesheet" href="../../css/style.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="../adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed"> 
<?php include "../sidebar/sidebar.php"; ?>  
    <div class="card">
        <div class="card-header">
            <a href="tipo_inmu_alta.php" class="btn btn-success btn-block">Registrar nuevos tipos de inmueble</a>
            <h4 >Tipos de inmuebles</h4>
        </div>
        <div class="card-body">
            <table id="tabla1" class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>Num</th>
                        <th>Nombre</th>
                        <th>Tarea</th>
                    </tr>
                </thead>
                <tbody>
                    <?php /*llenado de datos de la lista*/ while($vector = mysqli_fetch_array($sql)){ $cont++; ?>
                    <tr>
                        <td><?php echo $cont; ?></td>
                        <td><?php echo $vector['nombre_tipo']; ?></td>
                        <td> <a class="btn btn-outline-success btn-sm" href="tipo_inmu-mod.php?id_mod=<?php echo $vector['id_tipo']; ?>">Modificar</a><a class="btn btn-outline-danger btn-sm" href="tipo_inmu_lista.php?id_del=<?php echo $vector['id_tipo']; ?>">Eliminar</a> </td>
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