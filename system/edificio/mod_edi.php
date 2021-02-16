<?php
session_start();
$titulo = "Actualizacion de Edificios"; 
$ubicacion = "Edificios";
require_once '../../resuorces/config/database.php';
//validacion si los campos estan vacios
if(!empty($_POST))
{
    //requperacion de los dato obtenidos mediante el POST
    
    //validacion de duplicidad de edificio
    $id_ed = $_POST['id'];
	$nombre = $_POST['tb_name'];
	$fecha_ent = $_POST['tb_fech'];
	$pisos = $_POST['tb_pisos'];
	$zona = $_POST['tb_zona'];
	$calle = $_POST['tb_calle'];
	$puerta = $_POST['tb_puerta'];
	$referencia = $_POST['tb_ref'];
	$latitud = $_POST['tb_lat'];
	$longitud = $_POST['tb_lon'];
	$descripcion = $_POST['tb_desc'];
	$stock = $_POST['tb_stock']; 
	$estado = $_POST['cb_estado'];
    $consulta= @mysqli_query($conn,"SELECT nombre_ed FROM edificio WHERE nombre_ed LIKE '$nombre'");
    $resultado= mysqli_num_rows($consulta);
    //alta de la tabla		
    $sql = "UPDATE edificio SET nombre_ed = '$nombre', inmu_dis = '$stock', fecha_entrega = '$fecha_ent', pisos_ed = '$pisos', zona_ed = '$zona', descripcion = '$descripcion', calle_ed = '$calle', num_puerta = '$puerta', latitud = '$latitud', longitud = '$longitud', referencia_ed = '$referencia' ,est_ed = '$estado' WHERE id_ed = '$id_ed'";
    if(mysqli_query($conn,$sql))
    {
        $alert="Datos modificado con exito";
        header('refresh:1; url=lista_edi.php');
    }else
    {
        $alert="Ocurrio un error inesperado";
    }
    
}
if(empty($_GET['id']))
{
	header('refresh:1; url=lista_edi.php');
	$alert2="Redireccionando";
}else
{
	$id=$_GET['id'];
	require_once '../../resuorces/config/database.php';
	// consulta para precargar los datos del id del edificio y validacion si esta eliminado
	$comand = mysqli_query($conn, "SELECT * FROM edificio WHERE id_ed = '$id'");
	$fila = mysqli_num_rows($comand);
	if($fila == 0)
	{
		header('refresh:1;url=lista_edi.php');
	}else
	{
		//carga de datos al formulario
		$option='';
		while($vector=mysqli_fetch_array($comand))
		{
			//datos obtenidos del usuario
			$name=$vector['nombre_ed'];
			$fecha_entrega = $vector['fecha_entrega'];
			$piso=$vector['pisos_ed'];
			$zona2=$vector['zona_ed'];
			$descrip=$vector['descripcion'];
			$calle2=$vector['calle_ed'];
			$puerta2=$vector['num_puerta'];
			$ref2=$vector['referencia_ed'];
			$stock2 = $vector['inmu_dis'];
			$latitud2 = $vector['latitud'];
			$longitud2 = $vector['longitud'];
			$estado2 = $vector['est_ed'];
		}
	}
}
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
        <a href="lista_edi.php" class="btn btn-danger btn-block">Atras</a><br>
        <div class="card-header">
            <h4 >Todos los campos son obligatorios</h4>   
        </div> 
			<form action="mod_edi.php" method="POST" id="formulario" onSubmit="return validar_clave()">
				<input type="hidden" name="id" value="<?php echo $id; ?>">
				<div class="card-body">
					<!--Nombres-->
					<div class="form-group">
						<label for="name">Nombre:</label>
						<input type="text" name="tb_name" id="name" class="form-control" onkeypress="return validar(event)" value="<?php echo $name; ?>">
					</div>
					<!-- fecha de entrega -->
					<div class="form-group">
						<label for="fech">Fecha de entrega:</label>
						<input type="date" name="tb_fech" id="fech" class="form-control" value="<?php echo $fecha_entrega; ?>">
					</div>
					<!--numero de pisos-->
					<div class="form-group">
						<label for="pisos">Numero de pisos:</label>
						<input type="number" name="tb_pisos" id="pisos" class="form-control" onkeypress="return soloNumeros(event)" value="<?php echo $piso; ?>">
					</div>
					<!--zona-->
					<div class="form-group">
						<label for="zona">Zona:</label>
						<input type="text" name="tb_zona" id="zona" class="form-control" onkeypress="return validar(event)" value="<?php echo $zona2; ?>">
					</div>
					<!--calle-->
					<div class="form-group">
						<label for="calle">Calle:</label>
						<input type="text" name="tb_calle" id="calle" class="form-control" value="<?php echo $calle2; ?>">
					</div>
					<!--Numero de puerta-->
					<div class="form-group">
						<label for="puerta">Numero de puerta:</label>
						<input type="text" name="tb_puerta" id="puerta" class="form-control" value="<?php echo $puerta2; ?>">
					</div>
					<!--referencia-->
					<div class="form-group">
						<label for="ref">Referencia:</label>
						<input type="text" name="tb_ref" id="ref" class="form-control" onkeypress="return validar(event)" value="<?php echo $ref2; ?>">
					</div>
					<!-- latitud longitud -->
					<div class="row">
						<div class="col-6">
							<div class="form-group"> 
								<label for="direc">Latitud:</label>
								<input type="number" onkeypress=" return soloNumeros(event)" name="tb_lat" id="direc" class="form-control" value="<?php echo $latitud2 ?>">
							</div>
						</div>
						<div class="col-6">
							<div class="form-group">
								<label for="direc">Longitud:</label>
								<input type="number" onkeypress=" return soloNumeros(event)" name="tb_lon" id="direc" class="form-control" value="<?php echo $longitud2 ?>">
							</div>
						</div>
					</div>
					<!--Descripcion-->
					<div class="form-group">
						<label for="desc">Descripcion:</label>
						<input type="text" name="tb_desc" id="desc" class="form-control" value="<?php echo $descrip; ?>">
					</div>
					<!-- unidades disponibles -->
					<div class="form-group">
						<label for="unidad">Unidades disponibles:</label>
						<input type="number" name="tb_stock" id="unidad" class="form-control" onkeypress="return soloNumeros(event)" value="<?php echo $stock2; ?>">
					</div>
					<!-- estado del edificio -->
					<div class="form-group">
						<label for="estado">Estado:</label>
						<input type="radio" name="cb_estado" id="estado" value="2" <?php if($estado2 == '2'){?> checked <?php } ?>>En construccion
						<input type="radio" name="cb_estado" id="estado" value="1" <?php if($estado2 == '1'){?> checked <?php } ?>>Listo para la venta
						<input type="radio" name="cb_estado" id="estado" value="3" <?php if($estado2 == '3'){?> checked <?php } ?>>Sin Unidades disponibles
					</div>
				</div>
				<div class="card-footer">
					<input class="btn btn-success btn-block" type="submit" value="Actualizar" name="btn_registrar">
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