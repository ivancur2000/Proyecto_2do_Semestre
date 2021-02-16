<?php
session_start();
$titulo = "Registro de tipos de inmueble"; 
$ubicacion = "Tipos de inmueble";
require_once '../../resuorces/config/database.php';
//altas de la tabla
if(isset($_POST['btn_reg'])){
    if(!empty($_POST))
    {
        $tipo = $_POST['tb_name'];
        $consulta = mysqli_query($conn,"SELECT * FROM tipo_inmueble WHERE nombre_tipo = '$tipo'");
        $resultado = mysqli_num_rows($consulta);
        if($resultado == 0)
        {
            $alta = "INSERT INTO tipo_inmueble (nombre_tipo, est_tipo) VALUES ('$tipo', '1')";
            if(mysqli_query($conn,$alta))
            {
                $alert = 'Registro Exitoso';
                header('refresh:1;url=tipo_inmu_lista.php');
            }else
            {
                $alert = "Ocurrio un error inesperado";
            }
        }else
        {
            $alert = 'El dato ya exite';
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
        <a href="tipo_inmu_lista.php" class="btn btn-success btn-block">Ver lista de tipos de inmueble</a><br>
        <div class="card-header">
            <h4 >Todos los campos son obligatorios</h4>   
        </div> 
        <form action="tipo_inmu_alta.php" method="POST" id="formulario" onSubmit="return validar_clave()">
            <div class="card-body">
            <!--nombre-->
                <div class="form-group">
                    <label for="tipo">Tipo de inmueble</label>
                    <input type="text" name="tb_name" id="tipo" class="form-control" placeholder="Tipo de inmueble" onkeypress="return validar(event)">
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