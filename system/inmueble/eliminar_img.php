<?php
session_start();
require_once '../../resuorces/config/database.php';
if($_GET['id_img'])
{
    $id=$_SESSION['inmu'];
    $imagen=$_GET['id_img'];
    $sql = "UPDATE imagenes SET est_img = '2' WHERE id_inmueble = '$id' AND id_img = '$imagen'";
    if(mysqli_query($conn,$sql))
    {
        echo '<META HTTP-EQUIV="REFRESH" CONTENT="0;URL=http://localhost/yolitav3/system/inmueble/lista_inmu.php">';
    }else
    {
        echo 'ocurrio un error';
    }
}else
{
    header('location: lista_inmu.php');
}
?>