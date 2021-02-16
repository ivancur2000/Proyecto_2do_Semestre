<?php
session_start();
$titulo = "Registro de Edificios"; 
$ubicacion = "Edificios";
require_once '../../resuorces/config/database.php';
//validacion si los campos estan vacios
if(!empty($_POST))
{
	//requperacion de los dato obtenidos mediante el POST
	//validacion de duplicidad de edificio
	$nombre = $_POST['tb_name'];
	$fecha_ent = $_POST['tb_fech'];
	$pisos = $_POST['tb_pisos'];
	$zona = $_POST['tb_zona'];
	$calle = $_POST['tb_calle'];
	$puerta = $_POST['tb_puerta'];
	$referencia = $_POST['tb_ref'];
	$descripcion = $_POST['tb_desc'];
	$latitud = $_POST['tb_lat'];
	$longitud = $_POST['tb_lon'];
	$stock = $_POST['tb_stock']; 
	$estado = $_POST['cb_estado'];
	$consulta= @mysqli_query($conn,"SELECT nombre_ed FROM edificio WHERE nombre_ed LIKE '$nombre'");
	$resultado= mysqli_num_rows($consulta);
	if($resultado==0)
	{	
		//alta de la tabla		
		$sql = "INSERT INTO edificio (nombre_ed, fecha_entrega, pisos_ed, zona_ed, descripcion, calle_ed, num_puerta, referencia_ed, latitud, longitud, inmu_dis, est_ed) 
							VALUES('$nombre', '$fecha_ent','$pisos','$zona','$descripcion','$calle','$puerta', '$referencia', '$latitud', '$longitud', '$stock','$estado')";
		if(mysqli_query($conn,$sql))
		{
			$alert="Datos registrados con exito";
			header('refresh:1; url=lista_edi.php');
		}else
		{
			$alert="Ocurrio un error inesperado";
		} 
	}
	else 
	{
		$alert="El dato que intenta registrar ya existe, intente con otro por favor";
	}
}//*//*
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Edificios</title>
	<link rel="stylesheet" href="../../css/style.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<?php include "../sidebar/sidebar.php"; ?> 
    <div class="card card-dark">
        <!-- alta de la tabla -->
        <a href="lista_edi.php" class="btn btn-success btn-block">Ver lista de edificios</a><br>
        <div class="card-header">
            <h4 >Todos los campos son obligatorios</h4>   
        </div> 
			<form action="registro_edi.php" method="POST" id="formulario" onSubmit="return validar_clave()">
				<div class="card-body">
					<!--Nombres-->
					<div class="form-group">
						<label for="name">Nombre:</label>
						<input type="text" name="tb_name" id="name" class="form-control" onkeypress="return validar(event)">
					</div>
					<!-- fecha de entrega -->
					<div class="form-group">
						<label for="fech">Fecha de entrega:</label>
						<input type="date" name="tb_fech" id="fech" class="form-control">
					</div>
					<!--numero de pisos-->
					<div class="form-group">
						<label for="pisos">Numero de pisos:</label>
						<input type="number" name="tb_pisos" id="pisos" class="form-control" onkeypress="return soloNumeros(event)">
					</div>
					<!--zona-->
					<div class="form-group">
						<label for="zona">Zona:</label>
						<input type="text" name="tb_zona" id="zona" class="form-control" onkeypress="return validar(event)">
					</div>
					<!--calle-->
					<div class="form-group">
						<label for="calle">Calle:</label>
						<input type="text" name="tb_calle" id="calle" class="form-control" >
					</div>
					<!--Numero de puerta-->
					<div class="form-group">
						<label for="puerta">Numero de puerta:</label>
						<input type="text" name="tb_puerta" id="puerta" class="form-control" >
					</div>
					<!--referencia-->
					<div class="form-group">
						<label for="ref">Referencia:</label>
						<input type="text" name="tb_ref" id="ref" class="form-control" onkeypress="return validar(event)">
					</div>
					<!-- latitud longitud -->
					<div class="row">
						<div class="col-6">
							<div class="form-group"> 
								<label for="direc">Latitud:</label>
								<input type="number" placeholder="Latitud" onkeypress=" return soloNumeros(event)" name="tb_lat" id="direc" class="form-control">
							</div>
						</div>
						<div class="col-6">
							<div class="form-group">
								<label for="direc">Longitud:</label>
								<input type="number" placeholder="Longitud" onkeypress=" return soloNumeros(event)" name="tb_lon" id="direc" class="form-control">
							</div>
						</div>
					</div>
					<!--Descripcion-->
					<div class="form-group">
						<label for="desc">Descripcion:</label>
						<input type="text" name="tb_desc" id="desc" class="form-control"></textarea>
					</div>
					<!-- unidades disponibles -->
					<div class="form-group">
						<label for="unidad">Unidades disponibles:</label>
						<input type="number" name="tb_stock" id="unidad" class="form-control" onkeypress="return soloNumeros(event)">
					</div>
					<!-- estado del edificio -->
					<div class="form-group">
						<label for="estado">Estado:</label>
						<input type="radio" name="cb_estado" id="estado" value="2">En construccion
						<input type="radio" name="cb_estado" id="estado" value="1">Listo para la venta
					</div>
				</div>
				<div class="card-footer">
					<input class="btn btn-success btn-block" type="submit" value="Registrar" name="btn_registrar">
					<input class="btn btn-danger btn-block" type="reset" value="Cancelar">
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

