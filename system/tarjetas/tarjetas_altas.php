<?php
//conexion a la base de datos
require_once '../../resuorces/config/database.php';
//validaion de informacion nula
//enlasar con el formulario de clientes para llenar el id
if(!empty($_POST))
{
    //recuperacion de datos del formulario
    $id_cli = 1;
    $tipo_tar = $_POST['tipo_tar'];
    $num_tar = $_POST['tb_number'];
    $fecha_ven = $_POST['tb_fecha'];
    $cod_tar = $_POST['tb_cod'];
    //consulta de existencia
    $cmd = mysqli_query($conn,"SELECT * FROM tarjeta WHERE numero_tar = '$num_tar'");
    $resultado = mysqli_num_rows($cmd);
    if($resultado == 1)
    {
        echo "La tarjeta ya esta vinculada, intente con otra por favor";
    }else
    {
        //alta de la tabla
        $sql = "INSERT INTO tarjeta (id_cli, tipo_tar, numero_tar, fech_vencimiento, codigo_seg, est_tar) VALUES ('$id_cli', '$tipo_tar', '$num_tar','$fecha_ven', '$cod_tar', '1')";
        if(mysqli_query($conn, $sql))
        {
            echo "Registro Exitoso";
        }else
        {
            echo "Ocurrio un error inesperado";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tajetas de credito</title>
</head>
<body>
    <div>
        <h1>Registro de tarjetas:</h1>
        <form action="tarjetas_altas.php" method="POST">
            <!-- Tipo de tarjeta -->
            <label for="tipo">Tipo de Tarjeta:</label>
            <select name="tipo_tar" id="tipo">
                <option value=""></option>
                <option value="visa">Visa</option>
                <option value="mcard">Master card</option>
            </select><br>
            <!-- numero de la tarjeta -->
            <label for="num_tar">Numero de la tarjeta:</label>
            <input type="number" name="tb_number" id="num_tar"><br>
            <!-- fecha de vencimiento -->
            <label for="fv">Fecha de Vencimiento:</label>
            <input type="date" name="tb_fecha" id="fv"><br>
            <!-- codigo de seguridad -->
            <label for="cod">Codigo de Seguridad:</label>
            <input type="password" name="tb_cod" id="cod"><br>
            
            <input type="submit" value="Enviar">
            <input type="reset" value="Cancelar">
        </form>
    </div>    
</body>
</html>