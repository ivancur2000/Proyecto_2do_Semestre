<?php
session_start();
$titulo = "Registro de planes"; 
$ubicacion = "Plan de pago";
require_once '../../resuorces/config/database.php';
//altas de la tabla
if(isset($_POST['btn_reg'])){
    if(!empty($_POST))
    {
        $duracion = $_POST['tb_duracion'];
        $interes = $_POST['tb_interes'];
        $sql = mysqli_query($conn, "SELECT * FROM plan_pago WHERE duracion_meses = '$duracion'");
        $fila = mysqli_num_rows($sql);
        if($fila == 0)
        {
            $alta = "INSERT INTO plan_pago (duracion_meses, interes, est_plan) VALUES ('$duracion','$interes', '1')";
            if(mysqli_query($conn,$alta))
            {
                $alert = 'Registro Exitoso';
                header('refresh:1;url=lista_plan.php');
            }else
            {
                $alert = "Ocurrio un error inesperado";
            }
        }else
        {
            $alert="El plan ya existe, intente con otro";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Planes de pago</title>
    <link rel="stylesheet" href="../../css/style.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<?php include "../sidebar/sidebar.php"; ?> 
    <div class="card card-dark">
        <!-- alta de la tabla -->
        <a href="lista_plan.php" class="btn btn-success btn-block">Ver lista de planes de pago</a><br>
        <div class="card-header">
            <h4 >Todos los campos son obligatorios</h4>   
        </div> 
        <form action="registro_plan.php" id="formulario" onSubmit="return validar_clave()" method="POST">
            <div class="card-body">
                <!--Duracion de plan-->
                <div class="form-group">
                    <label for="duracion">Duracion(meses):</label>
                    <input type="number" class="form-control" placeholder="Duracion de plan de pago" name="tb_duracion" id="duracion" onkeypress="return soloNumeros(event)">
                </div>
                <!--interes del plan de pago sobre el precio base-->
                <div class="form-group">
                    <label for="interes">Interes(porcentaje):</label>
                    <input type="number" class="form-control" placeholder="Interes del plan de pago" name="tb_interes" id="interes" >
                </div>
            </div>
            <div class="card-footer">
                <input id="boton" type="submit" class="btn btn-success btn-block" value="Registrar" name="btn_reg">
				<input type="reset" class="btn btn-danger btn-block" value="Cancelar">
            </div>
        </form>
    </div>
    <?php include "../sidebar/sidebar2.php"; ?>
	<?php include "../modal_alerta/alert.php"; ?>
	<!-- jquery-validation -->
	<script src="../adminlte/plugins/jquery-validation/jquery.validate.min.js"></script>
	<script src="../adminlte/plugins/jquery-validation/additional-methods.min.js"></script>
	<script src="../../js/methods/validar.js"></script>
</body>
</html>