<?php
//conexion a la base de datos
require_once '../../resuorces/config/database.php';
//consulta para jalar datos 
$sql = mysqli_query($conn,"SELECT * FROM tarjeta WHERE est_tar= '0'");
$numero=0;
//metodo get para el id
if(!empty($_GET))
{
    if(empty($_GET['id']))
    {
        header('Location: tarjetas_lista.php');
    }else
    {
        //metodo de habilitacion logica
        $id_tarjeta = $_GET['id'];
        echo $id_tarjeta;
        $cmd = "UPDATE tarjeta SET est_tar = '1' WHERE id_tar = '$id_tarjeta'";
        if(mysqli_query($conn,$cmd))
        {
            echo 'Tarjeta habilitada con exito';
            header('refresh:3; url=tarjetas_hab.php');
        }else
        {
            echo 'Ocurrio un error inesperado';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div>
    <h1>Lista de tarjetas vinculadas</h1>
    <!-- tabla de la pagina -->
        <table>
            <thead>
                <tr>
                    <th>Num</th>
                    <th>Propietario</th>
                    <th>Numero de tarjeta</th>
                    <th>Fecha de Vencimiento</th>
                    <th>Accion</th>
                </tr>
            </thead>
            <tbody>
            <?php 
            //metodo para llenar la tabla
                while($data = mysqli_fetch_array($sql)){ 
                $numero++;
                //jalar el nombre del cliente
                $id_cli = $data['id_cli'];
                $consulta = mysqli_query($conn,"SELECT nom_cli, ape_cli FROM cliente WHERE id_cli = '$id_cli'");
                $nombre = mysqli_fetch_array($consulta);
                ?>
                <tr>
                    <th><?php if(isset($numero)){ echo $numero; } ?></th>
                    <td><?php if(isset($nombre['nom_cli'])){ echo $nombre['nom_cli']." ".$nombre['ape_cli']; } ?></td>
                    <td><?php if(isset($data['numero_tar'])){ echo $data['numero_tar']; } ?></td>
                    <td><?php if(isset($data['fech_vencimiento'])){ echo $data['fech_vencimiento']; } ?></td>
                    <td><a href="tarjetas_hab.php?id=<?php echo $data['id_tar']; ?>">Habilitar</a></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>