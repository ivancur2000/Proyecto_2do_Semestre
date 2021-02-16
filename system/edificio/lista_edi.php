<?php
session_start();
$titulo = "Lista de Edificios"; 
$ubicacion = "Edificios";
//consulta a la base de datos
require_once '../../resuorces/config/database.php';
$sql = mysqli_query($conn,"SELECT * FROM edificio WHERE est_ed = '1'");
//inicio  de la variable de conteo de edificios
$contador=0;
//metodo de eliminacion de edificios
if(!empty($_GET))
{
    if(empty($_GET['id']))
    {
        header('Location: lista_edi.php');
    }
    $id=$_GET['id'];
    $cmd = mysqli_query($conn,"SELECT * FROM edificio WHERE id_ed = '$id'");
    $resultado = mysqli_num_rows($cmd);
    if($resultado == 0)
    {
        header('Location: lista_edi.php');
    }else
    {
        $del="UPDATE edificio SET est_ed='0' WHERE id_ed = '$id'";
        if(mysqli_query($conn, $del))
        {
            $alert="Dato eliminado con exito";
            header('refresh:1;url=lista_edi.php');
        }else
        {
            $alert="Ocurrio un error";
        }
    }
}
if(isset($_GET['id_del']))
{
    $delete=$_GET['id_del'];
    if($delete == 4)
    {
        $alert = 'Imagen eliminada con Exito';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de edificios</title>
    <link rel="stylesheet" href="../../css/style.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="../adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed"> 
<?php include "../sidebar/sidebar.php"; ?>  
    <div class="card">
        <div class="card-header">
            <a href="registro_edi.php" class="btn btn-success btn-block">Registrar nuevos edificios</a>
            <h4 >Edificios con unidades disponibles</h4>
        </div>
        <div class="card-body">
            <table id="tabla1" class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                    <!--Cabecera de la tabla-->
                    <th>Num</th>
                    <th>Nombre</th>
                    <th>Fecha de entrega</th>
                    <th>Pisos</th>
                    <th>Direccion</th>
                    <th>Referencia</th>
                    <th>Descripcion</th>
                    <th>Unidades disponibles</th>
                    <th>Tarea</th>
                </tr>
            </thead>
            <tbody>
                <?php /*llenado de datos de la tabla*/while($vector = mysqli_fetch_array($sql)){ $contador++;?>
                <tr>
                    <!--Cuerpo de la tabla-->
                    <th><?php echo $contador; ?></th>
                    <td><?php echo $vector['nombre_ed']; ?></td>
                    <td><?php echo $vector['fecha_entrega']; ?></td>
                    <td><?php echo $vector['pisos_ed']; ?></td>
                    <td><?php echo "Zona ".$vector['zona_ed'].", calle ".$vector['calle_ed'].", num ".$vector['num_puerta']; ?></td>
                    <td><?php echo $vector['referencia_ed']; ?></td>
                    <td><?php echo $vector['descripcion']; ?></td>
                    <td><?php echo $vector['inmu_dis']?></td>
                    <td><a class="btn btn-outline-success" href="mod_edi.php?id=<?php echo $vector['id_ed']; ?>">Actualizar</a><a class="btn btn-outline-danger" href="lista_edi.php?id=<?php echo $vector['id_ed']; ?>">Eliminar</a><a class="btn btn-outline-primary" href="foto_edi.php?id_edificio=<?php echo $vector['id_ed']; ?>">Fotografias</a></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        
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