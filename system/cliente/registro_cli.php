<?php
session_start();
$titulo = "Registro de clientes"; 
$ubicacion = "Cliente";
require_once '../../resuorces/config/database.php';
//incompleto...s
//validacion si los campos estan vacios
if(!empty($_POST))
{
    
		//requperacion de los dato obtenidos mediante el POST
		
        //validacion de duplicidad de usuario
        $nombre=$_POST['tb_name'];
        $app=$_POST['tb_app'];
        $email=$_POST['tb_email'];
        $ci=$_POST['tb_ci'];
        $naci=$_POST['año2']."-".$_POST['mes2']."-".$_POST['dia2'];
        $direccion=$_POST['tb_dir'];
        $celular=$_POST['tb_cel'];
        $celular2=$_POST['tb_cel2'];
		$pass = $_POST['tb_pass'];
		$consulta= @mysqli_query($conn,"SELECT nit_cli FROM cliente WHERE nit_cli LIKE '$ci'");
		$resultado= mysqli_num_rows($consulta);
		if($resultado==0)
		{	
			//alta de la tabla		
			$sql = "INSERT INTO cliente (nom_cli, ape_cli, fech_naci, cel1_cli, cel2_cli, email_cli, nit_cli, direc_cli, pass_cli,est_cli) VALUES('$nombre', '$app', '$naci', '$celular', '$celular2', '$email', '$ci', '$direccion', '$pass','1')";
			if(mysqli_query($conn,$sql))
			{
				$alert="Datos registrados con exito";
				header('refresh:1; url=lista_cli.php');
			}else
			{
				$alert="Ocurrio un error inesperado";
			} 
		}
		else 
		{
			$alert="El usuario que intenta registrar ya existe, intente con otro por favor";
		}
    
}//*//*
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Registro de Clientes</title>
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
		<a href="lista_cli.php" class="btn btn-success btn-block">Ver clientes</a><br>
		<div class="card-header">
			<h3 class="card-title">(*) Obligatorio</h3>
		</div>
		<form action="registro_cli.php" id="formulario" onSubmit="return validar_clave()" method="POST">
			<div class="card-body">
			
					<!--Nombres-->
				<div class="form-group">
					<label for="name">Nombres*:</label>
					<input type="text"  onkeypress="return validar(event)" id="name" name="tb_name"  class="form-control" placeholder="Nombres">	
				</div>
				<!--apellidos-->
				<div class="form-group">
					<label for="app">Apellidos*:</label>
					<input type="text"  onkeypress="return validar(event)" id="app" name="tb_app" class="form-control" placeholder="Apellidos">
				</div>
				<!--correo-->
				<div class="form-group">
					<label for="email">Correo Electronico*:</label>
					<input type="email" id="email" name="tb_email" class="form-control" id="Email" placeholder="Email">
				</div>
				<!--ci-->
				<div class="form-group">
					<label for="nit">NIT*:</label>
					<input type="text" id="nit" name="tb_ci" class="form-control" placeholder="NIT">
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
				<!--celular-->
				<div class="form-group">
					<label for="cel">Celular*:</label>
					<input type="number" onkeypress="return soloNumeros(event)" id="cel" name="tb_cel" class="form-control" placeholder="Celular">
					</div>
				<!--celular segundario-->
				<div class="form-group">
					<label for="cel2">Celular secundario:</label>
					<input type="number" onkeypress="return soloNumeros(event)" id="cel2" name="tb_cel2" class="form-control" placeholder="Celular sec.">
				</div>
				<!--direccion-->
				<div class="form-group">
					<label for="direc">Direccion*:</label>
					<input type="text" id="dir" name="tb_dir" id="direc" class="form-control" placeholder="Direccion">
				</div>
				<!--Contrasena-->
				<div class="form-group">
					<label for="Password">Contraseña:</label>
					<input type="password" id="pass" name="tb_pass" id="" class="form-control" id="Password" placeholder="Contraseña">
				</div>	
				<span id="mensaje"></span>
				<div class="form-group">
					<label for="tb_cpass">Confirmar contraseña:</label>
					<input type="password" id="cpass" name="tb_confirm" id="Cpassword" class="form-control" placeholder="Contraseña">
				</div>
				<div id="validador_pass"style="color: #DC3545;" ></div>
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
				<!-- botones del formulario -->
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
