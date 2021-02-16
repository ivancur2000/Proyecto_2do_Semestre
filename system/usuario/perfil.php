<?php
//llamada de sesion del login
session_start();
require_once '../../resuorces/config/database.php';
if(isset($_SESSION['id']))
{
    $id=$_SESSION['id'];
    $sql= mysqli_query($conn, "SELECT u.nom_us, u.app_us, u.apm_us, u.correo_us, u.ci_us, u.fecha_ingreso, u.fecha_salida, u.fecha_naci, u.genero, u.direc_us, u.cel1_us, u.cel2_us, u.salario, u.login_us, u.pass_us, (c.nom_cargo) as cargo,(u.id_cargo) as id_ca
    FROM usuario as u INNER JOIN cargo as c ON u.id_cargo=c.id_cargo WHERE u.id_us = '$id' AND est_us = '1'");
    $fila = mysqli_num_rows($sql);
    if($fila == 0)
    {
        header('Location: lista_us.php');
    }else
    {
        //datos del usuario logueado
        $vector=mysqli_fetch_array($sql);
        $name=$vector['nom_us'];
        $app2=$vector['app_us'];
        $apm2=$vector['apm_us'];
        $correo=$vector['correo_us'];
        $carnet=$vector['ci_us'];
        $fech_ingreso=$vector['fecha_ingreso'];
        $gen=$vector['genero'];
        $fech_naci=$vector['fecha_naci'];
        $direc=$vector['direc_us'];
        $cel=$vector['cel1_us'];
        $cel2=$vector['cel2_us'];
        $sal=$vector['salario'];
        $login2=$vector['login_us'];
        $pass2=$vector['pass_us'];
        $cargo2=$vector['cargo'];
        $id_cargo=$vector['id_ca'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
</head>
<body>
    <div>
        <h1>Perfil de usuario</h1>
        <label for="">Nombres:</label><label for=""><?php if(isset($name)){echo $name;} ?></label><br><br>
        <label for="">Apellidos:</label><label for=""><?php if(isset($app2)&&isset($apm2)){ echo $app2." ".$apm2;} ?></label><br><br>
        <label for="">Cargo:</label><label for=""></label><?php if(isset($cargo2)){echo $cargo2;} ?><br><br>
        <label for="">Fecha De Nacimento:</label><label for=""><?php if(isset($fech_naci)){ echo $fech_naci;} ?></label><br><br>
        <label for="">Correo:</label><label for=""></label><br><?php if(isset($correo)){echo $correo;} ?><br>
        <label for="">Usuario:</label><label for=""><?php if(isset($login2)){echo $login2;}  ?></label>
    </div>
</body>
</html>