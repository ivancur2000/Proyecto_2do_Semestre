<?php
session_start();
$titulo = "Actualizacion de usuarios"; 
$ubicacion = "Usuarios";
require_once '../../resuorces/config/database.php';
//validacion si los campos estan vacios
if(isset($_POST['btn_registrar']))
{
	if(!empty($_POST))
	{
	
		//requperacion de los dato obtenidos mediante el POST
		
		//validacion de duplicidad de usuario

		$nombre=$_POST['tb_name'];
		$app=$_POST['tb_app'];
		$apm=$_POST['tb_apm'];
		$email=$_POST['tb_email'];
		$ci=$_POST['tb_ci'];
		$cargo=$_POST['cb_cargo'];
		$ingreso=$_POST['dt_ing'];
		$genero=$_POST['genero'];
		$naci=$_POST['dt_naci'];
		$direccion=$_POST['tb_dir'];
		$celular=$_POST['tb_cel'];
		$celular2=$_POST['tb_cel2'];
		$salario=$_POST['tb_salario'];
		$id_usuario = $_POST['id_us'];
		
		
		//mod de la tabla		
		$sql = "UPDATE usuario SET id_cargo = '$cargo', nom_us = '$nombre', app_us = '$app', apm_us = '$apm', correo_us = '$email', ci_us = '$ci', fecha_ingreso = '$ingreso', fecha_naci = '$naci', genero = '$genero', direc_us = '$direccion', cel1_us = '$celular', cel2_us = '$celular2', salario = '$salario' WHERE id_us = '$id_usuario'";
		
		if(mysqli_query($conn, $sql))
		{
			$alert="Datos Modificados con exito";
		}else
		{
			$alert="Ocurrio un error inesperado";
		}            
		mysqli_close($conn);

	}
}
	//se recibe datos del la lista de usuarios 
if(empty($_GET['id']))
{
	header('refresh:1;url=lista_us.php');
	$alert2="Redireccionando";
}else
{
	$id_usu=$_GET['id'];
	require_once '../../resuorces/config/database.php';
	//consulta para precargar los datos del id del usuario y validacion si esta eliminado
	$comand = mysqli_query($conn, "SELECT u.foto_us, u.id_cargo, u.nom_us, u.app_us, u.apm_us, u.correo_us, u.ci_us, u.fecha_ingreso, u.fecha_salida, u.fecha_naci, u.genero, u.direc_us, u.cel1_us, u.cel2_us, u.salario, u.login_us, u.pass_us, (c.nom_cargo) as cargo,(u.id_cargo) as id_ca
	FROM usuario as u INNER JOIN cargo as c ON u.id_cargo=c.id_cargo WHERE u.id_us = '$id_usu' AND est_us = '1'");
	$fila = mysqli_num_rows($comand);
	if($fila == 0)
	{
	}else
	{
		//carga de datos al formulario
		$option='';
		while($vector=mysqli_fetch_array($comand))
		{
			//datos obtenidos del usuario
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
			$cargo2=$vector['id_cargo'];
			$id_cargo=$vector['id_ca'];
			$foto_perfil = $vector['foto_us'];
			$password = $vector['pass_us'];
			//lenado del radio button y del select
			$selec=0;
			
			if($gen == 'M')
			{
				$selec = 1;
			}else if($gen == 'F')
			{
				$selec = 2;
			}else if($gen == 'O')
			{
				$selec = 3;
			}
		}
	}
}

?>
<html> 
<head>
	<title>Actualizacion de Usuarios</title>	
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<?php include "../sidebar/sidebar.php"; ?>  
<div class="card">
	<div class="card-header">
		<div class="row">
			<a href="lista_us.php" class="btn btn-danger">Atras</a>
			<button class="btn btn-success" data-toggle="modal" data-target="#foto_perfil" >Cambiar Foto de perfil</button>
			<button class="btn btn-primary" data-toggle="modal" data-target="#c_pass">Cambiar contraseña</button>
		</div>
		<h6 class="card-title">(*)Obligatorio</h6>
	</div>
	<form action="mod_us.php" id="formulario" method="POST" enctype="multipart/form-data">
		<div class="card-body">
			<input type="hidden" name="id_us"  value = "<?php echo $id_usu; ?>">
			<!--Nombres-->
			<div class="form-group">
				<label for="nombre">Nombres:</label>
				<input type="text" name="tb_name" id="nombre" placeholder="Nombre*" onkeypress="return validar(event)" class="form-control" autofocus value="<?php if(isset($name)){echo $name; }?>">
			</div>
			<!--apellido paterno-->
			<div class="form-group">
				<label for="app">Apellido Paterno:</label>
				<input type="text" name="tb_app" id="app" placeholder="Apellido Paterno*" onkeypress="return validar(event)" class="form-control" autofocus value="<?php if(isset($app2)){ echo $app2;} ?>">
			</div>
			<!--apellido materno-->
			<div class="form-group">
				<label for="apm">Apellido Materno:</label>
				<input type="text" name="tb_apm" id="apm" placeholder="Apellido Materno*" onkeypress="return validar(event)"class="form-control" autofocus value="<?php if(isset($apm2)){echo $apm2;} ?>">
			</div>
			<!--correo-->
			<div class="form-group">
				<label for="email">Correo Electronico:</label>
				<input type="email" name="tb_email" id="email" placeholder="Email*"  class="form-control" autofocus value="<?php if(isset($correo)){ echo $correo; }?>">
			</div>
			<!--ci-->
			<div class="form-group">
				<label for="ci">CI*:</label>
				<input type="text" name="tb_ci" id="ci" class="form-control" autofocus value="<?php if(isset($carnet)){ echo $carnet;} ?>">
			</div>
			<!--cargo-->
			<div class="form-group">
				<label for="cargo">Cargo*:</label>
				<select name="cb_cargo" id="cargo" class="form-control" autofocus>
				<?php
				require_once '../../resuorces/config/database.php';
				$cmd2 = @mysqli_query($conn,"SELECT * FROM cargo WHERE id_cargo = '$cargo2'");
				$result2 = mysqli_num_rows($cmd2);
				if($result2 > 0)
				{
					while($valor2 = mysqli_fetch_array($cmd2))
					{
					?>
						<option value="<?php echo $valor2['id_cargo']; ?>"><?php echo $valor2['nom_cargo']; ?></option>
					<?php
					}
				}
				//jalar datos de la base de datos para el combo box

				$cmd = @mysqli_query($conn,"SELECT * FROM cargo WHERE id_cargo != 9 AND est_cargo =1");
				$result = mysqli_num_rows($cmd);            
				if($result > 0) 
				{
					echo $option;
					while($valor = mysqli_fetch_array($cmd))
					{
					?>
						<option value="<?php echo $valor['id_cargo']; ?>"><?php echo $valor['nom_cargo']; ?></option>
					<?php
					}
				}
				?>	
				</select>
			</div>
			<!--Fecha de ingreso-->
			<div class="form-group">
				<label for="fecha_in">Fecha de ingreso*:</label>
				<input type="date" name="dt_ing" id="fecha_in" class="form-control" autofocus value="<?php if(isset($fech_ingreso)){ echo $fech_ingreso; }?>" >
			</div>
			<!--fecha de nacimento-->
			<div class="form-group">
				<label for="fecha_naci">Fecha de nacimiento*:</label>
				<input type="date" name="dt_naci" id="fecha_naci"class="form-control" autofocus value="<?php if(isset($fech_naci)){ echo $fech_naci;} ?>">
			</div>
			<!--genero-->
			<div class="form-group">
					<label for="gen">Genero:</label>
					<div class="form-check-inline">
						<input type="radio" class="form-check-input" name="genero" id="gen" value="F" <?php if(isset($selec)){ if ($selec == 2 && isset($selec)){ echo "checked"; } } ?>>
						<label for="fen" class="form-check-label">Femenino</label>
					</div>
					<div class="form-check-inline">
						<input type="radio" class="form-check-input" name="genero" id="mas" value="M" <?php if(isset($selec)){ if ($selec == 1 && isset($selec)){ echo "checked"; } } ?>>
						<label for="mas" class="form-check-label">Masculino</label> 
					</div>
					<div class="form-check-inline">
						<input type="radio" class="form-check-input" name="genero" id="otro" value="O" <?php if(isset($selec)){ if ($selec == 3 && isset($selec)){ echo "checked"; } } ?>>
						<label for="otro" class="form-check-label">Otro</label>  			
					</div>	
				</div>
			<!--celular--> 
			<div class="form-group">
				<label for="cel">Celular*:</label>
				<input type="number" name="tb_cel" placeholder="Celuar*" id="cel" class="form-control" autofocus onkeypress="return soloNumeros(event)"value="<?php if(isset($cel)){ echo $cel; }?>">
			</div>
			<!--celular segundario-->
			<div class="form-group">
				<label for="cel2">Celular secundario:</label>
				<input type="number" name="tb_cel2" id="cel2" placeholder="Celuar sec." class="form-control" autofocus onkeypress="return soloNumeros(event)"value="<?php if(isset($cel2)){ echo $cel2; }?>">
			</div>
			<!--direccion-->
			<div class="form-group">
				<label for="direc">Direccion*:</label>
				<textarea  name="tb_dir" id="direc" rows = "2" cols="40" class="form-control" autofocus><?php if(isset($direc)){ echo $direc;}?></textarea>
			</div>
			<!--salario-->
			<div class="form-group">
				<label for="sal">Salario*:</label>
				<input type="number" name="tb_salario" id="sal" class="form-control" autofocus onkeypress="return soloNumeros(event)"value="<?php if(isset($sal)){echo $sal;} ?>">
			</div>
		</div>
		<div class="card-footer">
			<input type="submit" value="Actualizar" name="btn_registrar" class="btn btn-success btn-block">
			<input type="reset" value="Cancelar" class="btn btn-danger btn-block"><br>
		</div>  
		
		<?php include "cambio_foto.php"; ?> 
	</form>
	</div> 
	<?php include "cambio_pass.php"; ?>
	<?php include "../sidebar/sidebar2.php"; ?>  
	<?php include "../modal_alerta/alert.php"; ?>
	<script src="../../js/methods/validar.js"></script>
	<!-- jquery-validation -->
	<script src="../adminlte/plugins/jquery-validation/jquery.validate.min.js"></script>
	<script src="../adminlte/plugins/jquery-validation/additional-methods.min.js"></script>

</body>
</html>