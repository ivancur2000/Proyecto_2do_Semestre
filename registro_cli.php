<?php
//validacion si los campos estan vacios
if(isset($_POST['btn_registrar'])){
	if(!empty($_POST))
	{
		//requperacion de los dato obtenidos mediante el POST
		$validador=0;
		//validacion de duplicidad de usuario
		$nombre=$_POST['tb_name'];
		$app=$_POST['tb_app'];
		$email=$_POST['tb_email'];
		$ci=$_POST['tb_ci'];
		$naci=$_POST['dt_naci'];
		$direccion=$_POST['tb_dir'];
		$celular=$_POST['tb_cel'];
		$celular2=$_POST['tb_cel2'];
		$pass = md5($_POST['tb_pass']);
		$consulta= @mysqli_query($conn,"SELECT * FROM cliente WHERE email_cli LIKE '$email' AND est_cli = '1'");
		$resultado= mysqli_num_rows($consulta);
		if($resultado==0)
		{	
			//alta de la tabla		
			$sql = "INSERT INTO cliente (nom_cli, ape_cli, fech_naci, cel1_cli, cel2_cli, email_cli, nit_cli, direc_cli, pass_cli,est_cli) VALUES('$nombre', '$app', '$naci', '$celular', '$celular2', '$email', '$ci', '$direccion', '$pass','1')";
			if(mysqli_query($conn,$sql))
			{
				$last_id = mysqli_insert_id($conn);
				$query = mysqli_query($conn, "SELECT * FROM cliente WHERE id_cli = '$last_id'");
				$data=mysqli_fetch_array($query);
				$_SESSION['active'] = true;
				$_SESSION['id_cli'] = $data['id_cli'];
				$_SESSION['nom_cli'] = $data['nom_cli'];
				$_SESSION['ape_cli'] = $data['ape_cli'];
				$alert="Sus datos han sido registrados exitosamente";
			}else
			{
				$alert="Ocurrio un error inesperado, vuelva a intentar mas tarde por favor";
			} 
		}
		else 
		{
			$alert="Este correo ya esta en uso, intente con otro por favor";
		}
	}
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<title>Registro de Clientes</title>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<!-- 	<link rel="stylesheet" href="css/bootstrap/bootstrap.min.css"> -->
	<!-- estilos del modal -->
	<link rel="stylesheet" href="css/style.css">
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
<body>


<!-- Modal -->
<div class="modal fade" id="registro" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header" id="header">
        <h3 class="modal-title" id="modal1">Registro</h3>
        <button type="button" class="close" data-dismiss="modal" id="close" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="">
		  <!--contenido del form-->
	  <div class="container-fluid"> 
        <div class="row">
			<div class="col-md-12">
				<div class="card card-primary" id="body">
					<form action="index.php" id="formulario" method="POST"  onSubmit="return validar_clave()">
						<div class="card-body">
							<!--Nombres-->
							<div class="form-group">
								<label for="Nombres">Nombres*:</label>
								<input type="text"  onkeypress="return validar(event)" id="name" name="tb_name"  class="form-control" placeholder="Nombres">	
							</div>
							<!--apellidos-->
							<div class="form-group">
								<label for="Apellidos">Apellidos*:</label>
								<input type="text"  onkeypress="return validar(event)" id="app" name="tb_app" class="form-control" placeholder="Apellidos">
							</div>
							<!--correo-->
							<div class="form-group">
								<label for="Email">Correo Electronico*:</label>
								<input type="email" id="email" name="tb_email" class="form-control" id="Email" placeholder="Email">
							</div>
							<!--ci-->
							<div class="form-group">
								<label for="NIT">NIT*:</label>
								<input type="text" id="nit" name="tb_ci" class="form-control" placeholder="NIT">
							</div>
							<!--fecha de nacimento-->
							<div class="form-group">
								<label for="fecha">Fecha de nacimiento*:</label>
								<input type="date" id="fecha" name="dt_naci" class="form-control">
							</div>
							<!--celular-->
							<div class="form-group">
								<label for="Celular">Celular*:</label>
								<input type="number" onkeypress="return soloNumeros(event)" id="cel" name="tb_cel" class="form-control" placeholder="Celular">
								</div>
							<!--celular segundario-->
							<div class="form-group">
								<label for="Celular sec.">Celular secundario:</label>
								<input type="number" onkeypress="return soloNumeros(event)" id="cel2" name="tb_cel2" class="form-control" placeholder="Celular sec.">
							</div>
							<!--direccion-->
							<div class="form-group">
								<label for="Direccion">Direccion*:</label>
								<input type="text" id="dir" name="tb_dir" id="" class="form-control" placeholder="Direccion">
							</div>
							<!--Contrasena-->
							<div class="form-group">
								<label for="Password">Contraseña:</label>
								<input type="password" id="pass" name="tb_pass" class="form-control" id="Password" placeholder="Contraseña">
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
				</div>
			</div>
		</div>
	</div>
      </div>
      <div class="modal-footer"id="footer2">
	  <!-- botones del formulario -->
	  		<input type="submit" data-toggle="modal" data-target="#alert" value="Registrar" class="btn btn-success" name="btn_registrar" class="btn btn-primary  btn-lg">
			<input type="reset" value="Cancelar"  data-dismiss="modal" class="btn btn-danger">
	  </div>
	  </form>
    </div>
  </div>
</div>
<!-- validadr de passords -->
<script src="js/methods/password.js"></script>
<!-- validate jquery y proteccion de los campos -->
<script src="js/methods/validar.js"></script>	
<!-- jquery-validation y bootstrap-->
<script src="system/adminlte/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="system/adminlte/plugins/jquery-validation/additional-methods.min.js"></script>
<!-- ventana de alerta modal -->
<script type="text/javascript">
	$(document).ready(function()
	{
		var mensaje = '<?php echo $alert; ?>'
	if(mensaje !== "" ){
		$("#mostrarmodal").modal("show");
		mensaje="";
	}
	});
</script>
</body>
</html>
