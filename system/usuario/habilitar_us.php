<?php
session_start();
$titulo = "Lista de usuarios"; 
$ubicacion = "Usuarios";
//consulta para llenar datos en la tabla
require_once '../../resuorces/config/database.php';
$sql=mysqli_query($conn,"SELECT u.id_us, u.nom_us, u.app_us, u.apm_us, u.correo_us, u.ci_us, u.fecha_ingreso, u.fecha_salida, u.fecha_naci, u.genero, u.direc_us, u.cel1_us, u.cel2_us, u.salario, u.login_us, u.pass_us, (c.nom_cargo) as cargo,(u.id_cargo) as id_ca
FROM usuario as u INNER JOIN cargo as c ON u.id_cargo=c.id_cargo WHERE est_us = '0'");
$contador = 0;
if(!empty($_GET))
{
    if(empty($_GET['id']))
    {
        header('Location: lista_us.php');
    }
    $id=$_GET['id'];
    $cmd = mysqli_query($conn,"SELECT * FROM usuario WHERE id_us = '$id'");
    $resultado = mysqli_num_rows($cmd);
    if($resultado == 0)
    {
        header('Location: habilitar_us.php');
    }else
    {
        $fecha_atual = date("Y-m-d");
        $del="UPDATE usuario SET est_us='1', fecha_ingreso = '$fecha_atual', fecha_salida = NULL WHERE id_us = '$id'";
        if(mysqli_query($conn, $del))
        {
            $alert="Usuario habiltado con exito";
            header('refresh:1;url=habilitar_us.php');
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
    <title>Usuarios deshabilitados</title>
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<?php include "../sidebar/sidebar.php"; ?> 
    <div class="card">
        <div class="card-header">  
            <h1>Lista de usuarios deshabilitados</h1>
        </div>
        <div class="card-body">
            <table id="tabla1" class="table table-bordered table-striped">
                <thead class="thead-dark">    
                    <tr>
                    <!--cabecera de la tabla-->
                        <th scope="col">Num</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Apellido P.</th>
                        <th scope="col">Apellido M.</th>
                        <th scope="col">Cargo</th>
                        <th scope="col">Correo</th>
                        <th scope="col">C.I.</th>
                        <th scope="col">Fecha de Salida</th>
                        <th scope="col">Fecha de Nacimiento</th>
                        <th scope="col">Direccion</th>
                        <th scope="col">Celular</th>
                        <th scope="col">Celular sec.</th>
                        <th scope="col">Usuario</th>
                        <th scope="col">Tarea</th>   
                    </tr>
                </thead>
                <tbody>
                <!--cuerpo de la tabla-->
                <?php
                //metdo de llenado
                while($data= mysqli_fetch_array($sql)){ $contador++;  ?>
                    <tr>
                        <th><?php echo $contador; ?></th>
                        <td><?php echo $data['nom_us']; ?></td>
                        <td><?php echo $data['app_us']; ?></td>
                        <td><?php echo $data['apm_us']; ?></td>
                        <td><?php echo $data['cargo']; ?></td>
                        <td><?php echo $data['correo_us']; ?></td>
                        <td><?php echo $data['ci_us']; ?></td>
                        <td><?php echo $data['fecha_salida']; ?></td>
                        <td><?php echo $data['fecha_naci']; ?></td>
                        <td><?php echo $data['direc_us']; ?></td>
                        <td><?php echo $data['cel1_us']; ?></td>
                        <td><?php echo $data['cel2_us']; ?></td>
                        <td><?php echo $data['login_us']; ?></td>
                        <td><a href="habilitar_us.php?id=<?php echo $data['id_us'];?>" class="btn btn-outline-danger" >Habilitar</a></td>
                       
                    </tr>
                <?php
                }
                ?>
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