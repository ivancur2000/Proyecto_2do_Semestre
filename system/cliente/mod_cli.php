<?php
session_start();
$titulo = "Actualizacion de clientes"; 
$ubicacion = "Cliente";
//validacion si los campos estan vacios
require_once '../../resuorces/config/database.php';
if(!empty($_POST))
{
	//requperacion de los dato obtenidos mediante el POST
	$id = $_POST['id'];
	$nombre=$_POST['tb_name'];
	$app=$_POST['tb_app'];
	$email=$_POST['tb_email'];
	$ci=$_POST['tb_ci'];
	$naci=$_POST['dt_naci'];
	$direccion=$_POST['tb_dir'];
	$celular=$_POST['tb_cel'];
	$celular2=$_POST['tb_cel2'];	
	//modificacion de la tabla		
	$sql = "UPDATE cliente SET nom_cli = '$nombre', ape_cli = '$app', fech_naci = '$naci', cel1_cli = '$celular', cel2_cli = '$celular2', email_cli = '$email', nit_cli = '$ci', direc_cli = '$direccion' WHERE id_cli = '$id'";
	if(mysqli_query($conn,$sql))
	{
		$alert="Datos alterados con exito";
		header('refresh:1; url=lista_cli.php');
	}else
	{
		$alert="Ocurrio un error inesperado";
	}
	mysqli_close($conn);
    
}
if(empty($_GET['id']))
{
	header('refresh:1; url=lista_cli.php');
	$alert2="Redireccionando";
}else
{
	$id_cli=$_GET['id'];
	require_once '../../resuorces/config/database.php';
	// consulta para precargar los datos del id del cliente y validacion si esta eliminado
	$comand = mysqli_query($conn, "SELECT * FROM cliente WHERE id_cli = '$id_cli' AND est_cli = '1'");
	$fila = mysqli_num_rows($comand);
	if($fila == 0)
	{
		header('refresh:1;url=lista_us.php');
	}else
	{
		//carga de datos al formulario
		$option='';
		while($vector=mysqli_fetch_array($comand))
		{
			//datos obtenidos del usuario
			$name=$vector['nom_cli'];
			$aps=$vector['ape_cli'];
			$correo=$vector['email_cli'];
			$nit=$vector['nit_cli'];
			$fech_naci=$vector['fech_naci'];
			$direc=$vector['direc_cli'];
			$cel=$vector['cel1_cli'];
			$cel2=$vector['cel2_cli'];
		}
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Clientes</title>
	<link rel="stylesheet" href="../../css/style.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<?php include "../sidebar/sidebar.php"; ?>
	<div class="card">
		<a href="lista_cli.php" class="btn btn-danger btn-block">Atras</a>
		<div class="card-header">
			<h3 class="card-title">(*)Obligatorio</h3>
		</div>
		<form action="mod_cli.php"  onSubmit="return validar_clave()" id="formulario" method="POST">
			<div class="card-body">
				<input type="hidden" name="id" value="<?php echo $id_cli; ?>">
				<!--Nombres-->
				<div class="form-group">
					<label for="name">Nombres*:</label>
					<input type="text" name="tb_name" onkeypress="return validar(event)" id="name"  class="form-control" placeholder="Nombre" value="<?php if(isset($name)){ echo $name; } ?>">
				</div>
				<!--apellidos-->
				<div class="form-group">
					<label for="app">Apellidos*:</label>
					<input type="text"  onkeypress="return validar(event)" id="app" name="tb_app" class="form-control" placeholder="Apellidos" value="<?php if(isset($aps)){ echo $aps; } ?>">
				</div>
				<!--correo-->
				<div class="form-group">
					<label for="email">Correo Electronico:</label>
					<input type="email" id="email" name="tb_email" class="form-control" id="Email" placeholder="Email" value="<?php if(isset($correo)){ echo $correo; } ?>">
				</div>
				<!--ci-->
				<div class="form-group">
					<label for="nit">NIT*:</label>
					<input type="text" id="nit" name="tb_ci" class="form-control" placeholder="NIT" value="<?php if(isset($nit)){ echo $nit; } ?>">
				</div>
				<!--fecha de nacimento-->
				<div class="form-group">
					<label for="fecha">Fecha de nacimiento*:</label>
					<input  type="date" id="fecha" name="dt_naci" class="form-control" value="<?php if(isset($fech_naci)){ echo $fech_naci; } ?>" >
				</div>
				<!--celular-->
				<div class="form-group">
					<label for="cel">Celular*:</label>
					<input type="number" onkeypress="return soloNumeros(event)" id="cel" name="tb_cel" class="form-control" placeholder="Celular" value="<?php if(isset($cel)){ echo $cel; } ?>">
				</div>
				<!--celular segundario-->
				<div class="form-group">
					<label for="cel2">Celular secundario:</label>
					<input type="number" onkeypress="return soloNumeros(event)" id="cel2" name="tb_cel2" class="form-control" placeholder="Celular sec." value="<?php if(isset($cel2)){ echo $cel2; } ?>">
				</div>
				<!--direccion-->
				<div class="form-group">
					<label for="direc">Direccion*:</label>
					<textarea type="text" id="dir" name="tb_dir" id="direc" class="form-control" placeholder="Direccion" ><?php if(isset($direc)){ echo $direc; } ?></textarea>
				</div>
			</div>
			<div class="card-footer">
				<!-- botones del formulario -->
				<input id="boton" type="submit" class="btn btn-success btn-block" value="Modificar" name="btn_registrar">
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
