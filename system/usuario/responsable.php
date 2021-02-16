<?php 
require_once '../../resuorces/config/database.php';
session_start();
$titulo = "Responsables de cada edificio"; 
$ubicacion = "Usuarios";
$sql = mysqli_query($conn, "SELECT r.id_res, u.nom_us, u.app_us, e.nombre_ed FROM responsable as r INNER JOIN edificio as e ON e.id_ed = r.id_ed INNER JOIN usuario as u ON u.id_us = r.id_us");
$numero=0;
if(isset($_GET['id_res']))
{
    $id_res = $_GET['id_res'];
    $del = "DELETE FROM responsable WHERE id_res = '$id_res'";
    if(mysqli_query($conn, $del))
    {
        $alert="Dato eliminado con exito";
        echo '<META HTTP-EQUIV="REFRESH" CONTENT="2;URL=http://localhost/yolitav3/system/usuario/responsable.php">';
    }else
    {
        $alert="Ocurrio un error, intentelo de nuevo";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuario</title>
    <link rel="stylesheet" href="../../css/style.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="../adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<?php include "../sidebar/sidebar.php"; ?>
<br>
<a href="#registrar" data-toggle="modal" style="margin: 15px;" class="btn btn-success">Agregar mas responsables</a>
<div class="card" style="margin: 15px;">
    <div class="card-header" style="background: #091F92; color: #ffff;">
        <h3>Responsables</h3>
    </div>
    <div class="card-body">
        <table id="tabla1" class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>Num</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Edificio</th>
                    <th>Tarea</th>
                </tr>
            </thead>
            <tbody>
                <?php while($vector = mysqli_fetch_array($sql)){ $numero++; ?>
                <tr>
                    <td><?php echo $numero; ?></td>
                    <td><?php echo $vector['nom_us']; ?></td>
                    <td><?php echo $vector['app_us']; ?></td>
                    <td><?php echo $vector['nombre_ed']; ?></td>
                    <td><a href="responsable.php?id_res=<?php echo $vector['id_res']; ?>" class="btn btn-outline-danger">Eliminar</a></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <div class="card-footer">
    </div>
</div>
<div class="modal fade" id="registrar" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" id="header">
                <h3>Registrar nuevos responsables</h3>
            </div>
            <?php
            if(!empty($_POST))
            {
                if(isset($_POST['btn_registro']))
                {
                    $usuario = $_POST['cb_usuario'];
                    $edificio = $_POST['cb_edificio'];
                    $alta = "INSERT INTO responsable (id_us, id_ed) VALUES ('$usuario','$edificio')";
                    if(mysqli_query($conn, $alta))
                    {
                        $alert = "Registro Exitoso";
                        echo '<META HTTP-EQUIV="REFRESH" CONTENT="2;URL=http://localhost/yolitav3/system/usuario/responsable.php">';
                    }else
                    {
                        $alert = "Ocurrio un error, intentelo de nuevo";
                    }
                }
            }
            ?>
            <div class="card">
                <div class="card-body">
                    <!-- foto de perfil -->
                    <div class="form-group">
                        <form action="responsable.php" method="POST">
                            <div class="form-group">
                                <label for="usuario">Agente Inmobiliario:</label>
                                <select name="cb_usuario" id="usuario" class="form-control">
                                    <option value=""></option>
                                    <?php
                                    $mysql = mysqli_query($conn, "SELECT * FROM Usuario WHERE id_cargo ='12' AND est_us = '1'");  
                                    while($fila = mysqli_fetch_array($mysql)){
                                    ?>
                                    <option value="<?php echo $fila['id_us'] ?>"><?php echo $fila['nom_us']." ".$fila['app_us']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="edificio">Edificio:</label>
                                <select name="cb_edificio" id="edificio" class="form-control">
                                    <option value=""></option>
                                    <?php
                                    $mysql1 = mysqli_query($conn, "SELECT * FROM edificio WHERE est_ed != '0'");  
                                    while($fila1 = mysqli_fetch_array($mysql1)){
                                    ?>
                                    <option value="<?php echo $fila1['id_ed'] ?>"><?php echo $fila1['nombre_ed']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" name="btn_registro" value="Registrar" class="btn btn-success">
                    <input type="button" value="Cancelar"data-dismiss="modal" class="btn btn-danger"> 
                        </form>
                </div>
            </div>
        </div>
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
