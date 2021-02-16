<?php
require_once '../../resuorces/config/database.php';
 session_start();
 $titulo = "Registro de usuarios"; 
 $ubicacion = "Usuarios";
//validacion si los campos estan vacios
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
	$ingreso=$_POST['año1']."-".$_POST['mes1']."-".$_POST['dia1'];
	$genero=$_POST['genero'];
	$naci=$_POST['año2']."-".$_POST['mes2']."-".$_POST['dia2'];
	$direccion=$_POST['tb_dir'];
	$celular=$_POST['tb_cel'];
	$celular2=$_POST['tb_cel2'];
	$salario=$_POST['tb_salario'];
	$pass=md5($_POST['tb_pass']);
	$cpass=$_POST['tb_confirm'];
	///llenado del login
	$query = mysqli_query($conn, "SELECT * FROM cargo WHERE id_cargo = '$cargo'");
	while($data = mysqli_fetch_array($query))
	{
		$cod_cargo = $data['cod_cargo'];
	}
	$login = $cod_cargo.$ci;
	//validacion de la imagen recivida
	if(isset($_FILES['imagen']))
	{
		$nom_img = $_FILES['imagen']['name'];
		$type_img = $_FILES['imagen']['type'];
		$tam_img = $_FILES['imagen']['size'];
		if($type_img == "image/jpg" || $type_img == "image/jpeg" || $type_img == "image/png")
		{
			if($tam_img <= 1000000)
			{	
				$destino = $_SERVER['DOCUMENT_ROOT'] . '/yolitaV3/img/user_img/'; 
				move_uploaded_file($_FILES['imagen']['tmp_name'],$destino.$nom_img);
				$consulta= @mysqli_query($conn,"SELECT ci_us FROM usuario WHERE ci_us LIKE '$ci' AND est_us = '1'");
				$resultado= mysqli_num_rows($consulta);
				if($resultado==0)
				{	
					//validacion contraseña mediante java scrip
					//alta de la tabla		
					$sql = "INSERT INTO usuario (foto_us, id_cargo, nom_us, app_us, apm_us, correo_us, ci_us, fecha_ingreso, fecha_naci, genero, direc_us, cel1_us, cel2_us, salario, login_us, pass_us, est_us) VALUES( '$nom_img', '$cargo','$nombre', '$app', '$apm', '$email', '$ci', '$ingreso', '$naci', '$genero', '$direccion', '$celular', '$celular2', '$salario', '$login', '$pass', '1')";
					if(mysqli_query($conn,$sql))
					{
						$alert="Datos registrados con exito"."<br>"."Su usuario es "."<b>".$login."<b>";
						header('refresh:5; url=lista_us.php');
					}else
					{
						//reemplazar por un scrip
						$alert="Ocurrio un error inesperado";
					}
				}
				else 
				{
					//reemplazar por un scrip
					$alert="El usuario que intenta registrar ya existe, intente con otro por favor";
				}
			}else
			{
				$alert = 'La imagen es demasiado grande';
			}
		}else
		{
			$alert = 'El formato de imagen no es valido';
		}
	}
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<title>Registro de Usuarios</title>
	<link rel="stylesheet" href="../../css/style.css">
	<script language="JavaScript">
	function validar_clave ()
	{
		var pass1 = document.getElementById('pass').value;
		var pass2 = document.getElementById('cpass').value;
		if (pass1 != pass2) {
			$("#validador_pass").html("<div><b> Las contraseñas deben coincidir <b></div>");
			return false;
		}
		else 
		{
			return true;
			} 
	}
	</script>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<?php include "../sidebar/sidebar.php"; ?>  
	<div class="card card-dark">
		<a href="lista_us.php" class="btn btn-success btn-block">Ver usuarios</a><br>
		<div class="card-header">
			<h3 class="card-title">(*) obligatorio</h3>
		</div>
		<form action="registro_us.php" id="formulario" method="POST" onSubmit="return validar_clave()" enctype="multipart/form-data">
			<div class="card-body">
				<!--Nombres-->
				<div class="form-group">
					<label for="nombre">Nombre:</label>
					<input type="text" onkeypress="return validar(event)" name="tb_name" id="nombre" class="form-control" placeholder="Nombre*" autofocus>
				</div>
				<!--apellido paterno-->
				<div class="form-group">
					<label for="app">Apellido Paterno:</label>
					<input type="text" onkeypress="return validar(event)" name="tb_app" id="app" class="form-control" placeholder="Apellido Paterno*" autofocus>
				</div>
				<!--apellido materno-->
				<div class="form-group">
					<label for="apm">Apellido Materno:</label>
					<input type="text" onkeypress="return validar(event)" name="tb_apm" id="apm" class="form-control" placeholder="Apellido Materno*" autofocus>
				</div>
				<!--correo-->
				<div class="form-group">
					<label for="email">Correo Electronico</label>
					<input type="email"  name="tb_email" id="email" class="form-control"placeholder="Correo Electronico*" autofocus>
				</div>
				<!--ci-->
				<div class="form-group">
					<label for="ci">Cedula de Identidad:</label>
					<input type="text" name="tb_ci" id="ci" class="form-control"placeholder="CI*" autofocus>
				</div>
				<!--cargo-->
				<div class="form-group">
					<label for="cargo_us">Cargo</label>
					<select name="cb_cargo" id="cargo_us" class="form-control"  autofocus>
						<option value="">Seleccione un cargo</option>
						<?php
						//jalar datos de la base de datos para el combo box
						require_once '../../resuorces/config/database.php';
						$cmd = @mysqli_query($conn,"SELECT * FROM cargo WHERE id_cargo != 9 AND est_cargo =1");
						$result = mysqli_num_rows($cmd);
						if($result > 0)
						{
							while($valor = mysqli_fetch_array($cmd))
							{
								?>
								<option value="<?php echo $valor['id_cargo']; ?>"><?php echo $valor['nom_cargo']; ?></option>
								
								<?php
							}
						}
						echo $valor['cod_cargo'];
						?>	
					</select>
				</div>
				<!--Fecha de ingreso-->
				<div class="form-group">
					<label for="fecha_in">Fecha de ingreso</label>
					<div class="row">
						<div class="row-4">
							<label for="">Dia:</label>
							<select name="dia1" id="cargo_us" class="form-control"><option value=""></option><?php for($dias=1; $dias<=31; $dias++ ){ echo '<option value="'.$dias.'">'.$dias.'</option>';  } ?></select>
						</div class="row-3">
						<div>
							<label for="">Mes:</label>
							<select name="mes1" id="cargo_us" class="form-control"><option value=""></option><?php for($meses=1; $meses<=12; $meses++ ){ echo '<option value="'.$meses.'">'.$meses.'</option>';  } ?></select>
						</div class="row-3">
						<div>
							<label for="">Año:</label>
							<select name="año1" id="cargo_us" class="form-control"><option value=""></option><?php for($años=2013; $años<=2020; $años++ ){ echo '<option value="'.$años.'">'.$años.'</option>';  } ?></select>
						</div>
					</div>
				</div>
				<!--fecha de nacimento-->
				<div class="form-group">
					<label for="fecha_naci">Fecha de nacimiento</label>
					<div class="row">
						<div class="row-4">
							<label for="">Dia:</label>
							<select name="dia2" id="cargo_us" class="form-control"><option value=""></option><?php for($dias=1; $dias<=31; $dias++ ){ echo '<option value="'.$dias.'">'.$dias.'</option>';  } ?></select>
						</div class="row-3">
						<div>
							<label for="">Mes:</label>
							<select name="mes2" id="cargo_us" class="form-control"><option value=""></option><?php for($meses=1; $meses<=12; $meses++ ){ echo '<option value="'.$meses.'">'.$meses.'</option>';  } ?></select>
						</div class="row-3">
						<div>
							<label for="">Año:</label>
							<select name="año2" id="cargo_us" class="form-control"><option value=""></option><?php for($años=1940; $años<=2001; $años++ ){ echo '<option value="'.$años.'">'.$años.'</option>';  } ?></select>
						</div>
					</div>
				</div>
				<!--genero-->
				<div class="form-group">
					<label for="gen">Genero:</label>
					<div class="form-check-inline">
						<input type="radio" class="form-check-input" name="genero" id="fen" value="F">
						<label for="fen" class="form-check-label">Femenino</label>
					</div>
					<div class="form-check-inline">
						<input type="radio" class="form-check-input" name="genero" id="mas" value="M">
						<label for="mas" class="form-check-label">Masculino</label> 
					</div>
					<div class="form-check-inline">
						<input type="radio" class="form-check-input" name="genero" id="otro" value="O">
						<label for="otro" class="form-check-label">Otro</label>  			
					</div>	
				</div>
				<!--celular-->
				<div class="form-group">
					<label for="cel">Celular</label>
					<input type="number" onkeypress="return soloNumeros(event)" name="tb_cel" id="cel" class="form-control" placeholder="Celular*" autofocus>
				</div>
				<!--celular segundario-->
				<div class="form-group">
					<label for="cel2">Celular Secundario</label>
					<input type="number" onkeypress="return soloNumeros(event)" name="tb_cel2" id="cel2" class="form-control" placeholder="Celular Sec." autofocus>
				</div>		
				<!--direccion-->
				<div class="form-group">
					<label for="direc">Direccion:</label>
					<textarea  name="tb_dir" id="direc" rows = "2" cols="40" placeholder="Direccion*" class="form-control" autofocus></textarea>
				</div>
				<!--salario-->	
				<div class="form-group">
					<label for="salario">Salario:</label>
					<input type="number" onkeypress="return soloNumeros(event)" name="tb_salario" id="salario" placeholder="Salario*" class="form-control" autofocus>
				</div>
				<!-- foto de perfil -->
				<div class="form-group">
					<label for="img">Foto de perfil</label>
					<input type="file" name="imagen" class="form-control-file" id="img">
				</div>
				<!--password-->
				<div class="form-group">
					<label for="pass">Contraseña:</label>
					<input type="password" name="tb_pass" id="pass" placeholder="Contraseña*" class="form-control" autofocus>
				</div>
				<span id="mensaje"></span>
				<!--confirmar password-->
				<div class="form-group">
					<label for="cpass">Confirmar Contraseña</label>
					<input type="password" name="tb_confirm" id="cpass" placeholder="Confirmar contraseña" class="form-control" autofocus>
				</div>
				<div id="validador_pass"style="color: red" ></div>
				<small class="form-text text-muted">
					<ul>
						<li id = "mayus">3 Mayusculas</li>
						<li id = "special">3 Caracteres especiales</li>
						<li id = "numbers">Digitos</li>
						<li id = "lower">Minusculas</li>
						<li id = "len">Minimo 8 caracteres</li>
					</ul>
				</small>
			</div>
			<div class="card-footer"> 
				<input id="boton" type="submit" class="btn btn-success btn-block" value="Registrar" name="btn_registrar">
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
	<script src="../../js/methods/password.js"></script>
</body>
</html> 
