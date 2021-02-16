<?php
session_start();
$titulo = "Registro de tamaños"; 
$ubicacion = "Tamaños";
require_once '../../resuorces/config/database.php';
//altas de la tabla
if(isset($_POST['btn_reg'])){
    if(!empty($_POST))
    {
        $tamaño = $_POST['tb_tam'];
        $cuarto = $_POST['tb_cuartos'];
        $alta = "INSERT INTO tamaño (descrip_tam, num_cuartos, est_tam) VALUES ('$tamaño', '$cuarto', '1')";
        if(mysqli_query($conn,$alta))
        {
            $alert = 'Registro Exitoso';
            header('refresh:1;url=tam_lista.php');
        }else
        {
            $alert = "Ocurrio un error inesperado";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tipos de inmueble</title>
    <link rel="stylesheet" href="../../css/style.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<?php include "../sidebar/sidebar.php"; ?> 
    <div class="card card-dark">
        <!-- alta de la tabla -->
        <a href="tam_lista.php" class="btn btn-success btn-block">Ver lista de tamaños</a><br>
        <div class="card-header">
            <h4 >Todos los campos son obligatorios</h4>   
        </div> 
        <form action="tam_alta.php" id="formulario" onSubmit="return validar_clave()" method="POST">
            <div class="card-body">
                <!--tamaño-->
                <div class="form-group">
                    <label for="tam">Tamaño del inmueble</label>
                    <input type="text" class="form-control" placeholder="Tamaño en metros cuadrados" onkeypress="return soloNumeros(event)" name="tb_tam" id="tam" >
                </div>
                <!--numero de cuartos-->
                <div class="form-group">
                    <label for="cuartos">Numero de cuartos</label>
                    <input type="number" class="form-control" placeholder="Numero de cuartos" name="tb_cuartos" id="cuartos" onkeypress="return soloNumeros(event)">
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