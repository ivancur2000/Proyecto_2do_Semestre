<?php
session_start();
$titulo = "Lista de clientes"; 
$ubicacion = "Clientes";
//consulta a la base de datos
require_once '../../resuorces/config/database.php';
$sql = mysqli_query($conn,"SELECT * FROM cliente WHERE est_cli = '1'");
//inicio  de la variable de conteo de clientes
$contador=0;
//metodo de eliminacion de clientes
if(!empty($_GET))
{
    if(empty($_GET['id']))
    {
        header('Location: lista_us.php');
    }
    $id=$_GET['id'];
    $cmd = mysqli_query($conn,"SELECT * FROM cliente WHERE id_cli = '$id'");
    $resultado = mysqli_num_rows($cmd);
    if($resultado == 0)
    {
        header('Location: lista_cli.php');
    }else
    {
        $del="UPDATE cliente SET est_cli='0' WHERE id_cli = '$id'";
        if(mysqli_query($conn, $del))
        {
            $alert="Cliente eliminado con exito";
            header('refresh:1;url=lista_cli.php');
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
    <title>Clientes</title>
    <link rel="stylesheet" href="../../css/style.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="../adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
</head> 
<body class="hold-transition sidebar-mini layout-fixed">
    <?php include "../sidebar/sidebar.php"; ?>  
    <div class="card">
        <div class="card-header">
            <a href="registro_cli.php" class="btn btn-success btn-block">Registrar nuevos Clientes</a>
            <h4>Clientes Activos</h4>
        </div>
        <div class="card-body">
        <table id="tabla1" class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <!--Cabecera de la tabla-->
                    <th scope="col">Num</th>
                    <th scope="col">Nombres</th>
                    <th scope="col">Apellidos</th>
                    <th scope="col">Correo</th>
                    <th scope="col">Fecha de Nacimiento</th>
                    <th scope="col">NIT</th>
                    <th scope="col">Celulares</th>
                    <th scope="col">Direccion</th>
                    <th scope="col">Tarea</th>
                </tr>
            </thead>
            <tbody>
                <?php /*llenado de datos de la tabla*/while($vector = mysqli_fetch_array($sql)){ $contador++;?>
                <tr>
                    <!--Cuerpo de la tabla-->
                    <th><?php echo $contador; ?></th>
                    <td><?php echo $vector['nom_cli']; ?></td>
                    <td><?php echo $vector['ape_cli']; ?></td>
                    <td><?php echo $vector['email_cli']; ?></td>
                    <td><?php echo $vector['fech_naci']; ?></td>
                    <td><?php echo $vector['nit_cli']; ?></td>
                    <td><?php if($vector['cel2_cli'] != 0){ echo $vector['cel1_cli']."-".$vector['cel2_cli']; }else{ echo $vector['cel1_cli']; } ?></td>
                    <td><?php echo $vector['direc_cli']; ?></td>
                    <td><a class="btn btn-outline-success btn-sm" href="mod_cli.php?id=<?php echo $vector['id_cli']; ?>">Actualizar</a><a class="btn btn-outline-danger btn-sm" href="lista_cli.php?id=<?php echo $vector['id_cli']; ?>">Eliminar</a></td>
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