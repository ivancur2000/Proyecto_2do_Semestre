<?php
session_start();
$titulo = "Lista de Cargos"; 
 $ubicacion = "Cargos";
//conexion a la base de datos
require_once '../../resuorces/config/database.php';
$sql = mysqli_query($conn,"SELECT * FROM cargo WHERE est_cargo = '1'");
$numero=0;
//validacion del metodo get
if(!empty($_GET))
{
    if(empty($_GET['id']))
    {
        header('location: cargo_lista.php');
    }else
    {
        $id_cargo = $_GET['id'];
        //metodo de elminicion logica
        $cmd = "UPDATE cargo SET est_cargo = '0' WHERE id_cargo = '$id_cargo'";
        if(mysqli_query($conn,$cmd))
        {
            $alert = 'Cargo eliminado con exito';
            header('refresh:3; url=cargo_lista.php');
        }else
        {
            $alert = 'Ocurrio un error inesperado';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cargos</title>
    <link rel="stylesheet" href="../../css/style.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="../adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed"> 
<?php include "../sidebar/sidebar.php"; ?>  
    <div class="card">
        <div class="card-header">
            <a href="cargo_alta.php" class="btn btn-success btn-block">Registrar Nuevos cargos</a>
            <h4 >Cargos de la empresa</h4>
        </div>
        <div class="card-body">
            <table id="tabla1" class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>Num</th>
                        <th>Nombre</th>
                        <th>Codigo</th>
                        <th>Tarea</th>
                    </tr>
                </thead>
                <tbody>
                <?php while($data = mysqli_fetch_array($sql)){ $numero++;?>
                    <tr>
                        <th><?php if(isset($numero)){ echo $numero; } ?></th>
                        <td><?php if(isset($data['nom_cargo'])){ echo $data['nom_cargo']; } ?></td>
                        <td><?php if(isset($data['cod_cargo'])){ echo $data['cod_cargo']; } ?></td>
                        <td><a class="btn btn-outline-success btn-sm" href="cargo_mod.php?id_car=<?php if(isset($data['id_cargo'])){ echo $data['id_cargo']; } ?>">Actualizar</a><a class="btn btn-outline-danger btn-sm" href="cargo_lista.php?id=<?php if(isset($data['id_cargo'])){ echo $data['id_cargo']; } ?>">Eliminar</a></td>
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