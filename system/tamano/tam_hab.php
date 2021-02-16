<?php
session_start();
$titulo = "Lista de tamaños de inmuebles deshabilitados"; 
$ubicacion = "Tamaños";
require_once '../../resuorces/config/database.php';
//lista
$sql = mysqli_query($conn, "SELECT * FROM tamaño WHERE est_tam = '0'");
$cont = 0;
//eliminacion de datos
if(!empty($_GET)){
    if(empty($_GET['id_hab']))
    {
        header('Location: tam_hab.php');
    }
    $id = $_GET['id_hab'];
    $cmd = mysqli_query($conn,"SELECT * FROM tamaño WHERE id_tamaño = '$id'");
    $resultado2 = mysqli_num_rows($cmd);
    if($resultado2 == 0)
    {
        header('Location: tam_hab.php');
    }else
    {
        $del ="UPDATE tamaño SET est_tam='1' WHERE id_tamaño = '$id'";
        if(mysqli_query($conn, $del))
        {
            $alert="Dato habilitado con exito";
            header('refresh:1; url = tam_hab.php');
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
            <a href="cargo_alta.php" class="btn btn-success btn-block">Registrar nuevos tamaños</a>
            <h4 >Tamaños registrados deshabilitados</h4>
        </div>
        <div class="card-body">
            <table id="tabla1" class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>Num</th>
                        <th>Tamaño</th>
                        <th>Cuartos</th>
                        <th>Tarea</th>
                    </tr>
                </thead>
                <tbody>
                    <?php /*llenado de datos de la lista*/ while($vector = mysqli_fetch_array($sql)){ $cont++; ?>
                    <tr>
                        <td><?php echo $cont; ?></td>
                        <td><?php echo $vector['descrip_tam']; ?></td>
                        <td><?php echo $vector['num_cuartos']; ?></td>
                        <td> <a class="btn btn-outline-success btn-sm" href="tam_hab.php?id_hab=<?php echo $vector['id_tamaño']; ?>">Habilitar</a> </td>
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