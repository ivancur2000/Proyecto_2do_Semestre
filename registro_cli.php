<?php
//validacion si los campos estan vacios
if(isset($_POST['btn_registrar'])){
	if(!empty($_POST))
	{
		//recuperacion de los datos obtenidos mediante el POST
		$validador=0;
		//validacion de duplicidad de usuario
		$nombreUsuario=$_POST['nombreUsuario'];
		$appUsuario=$_POST['appUsuario'];
		$fechaNaci=$_POST['fechaNaci'];
		$pais=$_POST['pais'];
		$correo=$_POST['correo'];
		$contrasena= md5($_POST['contrasena']);
		$ciudad=$_POST['ciudad'];
		$consulta= @mysqli_query($conn,"SELECT * FROM usuarios WHERE correo LIKE '$correo' AND estadoUsuario = '1'");
		$resultado= mysqli_num_rows($consulta);
		if($resultado==0)
		{	
			//alta de la tabla		
			$sql = "INSERT INTO usuarios (nombreUsuario, appUsuario, cargo, fechaNaci, pais, correo, contrasena, ciudad, estadoUsuario) VALUES('$nombreUsuario', '$appUsuario', '2','$fechaNaci', '$pais', '$correo', '$contrasena', '$ciudad','1')";
			if(mysqli_query($conn,$sql))
			{
				$last_id = mysqli_insert_id($conn);
				$query = mysqli_query($conn, "SELECT * FROM usuarios WHERE idUsuario = '$last_id'");
				$data=mysqli_fetch_array($query);
				$_SESSION['active'] = true;
				$_SESSION['id'] = $data['idUsuario'];
				$_SESSION['cargo'] = $data['nombreCargo'];
				$_SESSION['name'] = $data['nombreUsuario'];
				$_SESSION['app'] = $data['appUsuario'];
				$alert="Sus datos han sido registrados exitosamente";
			}else
			{
				$alert="Ocurrio un error inesperado, vuelva a intentar más tarde por favor";
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
		var pass1 = document.getElementById('contrasena').value;
		var pass2 = document.getElementById('ccontrasena').value;
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
								<label for="Nombres">Nombres:</label>
								<input type="text"  onkeypress="return validar(event)" id="nombreUsuario" name="nombreUsuario"  class="form-control" placeholder="Nombres">	
							</div>
							<!--apellidos-->
							<div class="form-group">
								<label for="Apellidos">Apellidos:</label>
								<input type="text"  onkeypress="return validar(event)" id="appUsuario" name="appUsuario" class="form-control" placeholder="Apellidos">
							</div>
							<!--correo-->
							<div class="form-group">
								<label for="Ciudad">Ciudad:</label>
								<input type="text" id="ciudad" name="ciudad" class="form-control" placeholder="Ciudad">
							</div>
							<!--ci-->
							<div class="form-group">
								<label for="pais">País:</label>
								<input type="text" id="pais" name="pais" class="form-control" placeholder="País">
							</div>
							<!--fecha de nacimento-->
							<div class="form-group">
								<label for="fecha">Fecha de Nacimiento:</label>
								<input type="date" id="fechaNaci" name="fechaNaci" class="form-control">
							</div>
							<!--celular-->
							<div class="form-group">
								<label for="Celular">Correo Electrónico:</label>
								<input type="text" id="correo" name="correo" class="form-control" placeholder="Correo Electrónico">
								</div>
							<!--Contrasena-->
							<div class="form-group">
								<label for="contrasena">Contraseña:</label>
								<input type="password" id="pass" name="contrasena" class="form-control" id="contrasena" placeholder="Contraseña">
							</div>	
							<span id="mensaje"></span>
							<div class="form-group">
								<label for="ccontrasena">Confirmar contraseña:</label>
								<input type="password" id="ccontrasena" name="ccontrasena" id="ccontrasena" class="form-control" placeholder="Contraseña">
							</div>
							<div id="validador_pass"style="color: #DC3545;" ></div>
							<small class="form-text text-muted">
								<ul>
									<li id = "mayus">3 Mayúsculas</li>
									<li id = "special">3 Carácteres especiales</li>
									<li id = "numbers">Dígitos</li>
									<li id = "lower">Minúsculas</li>
									<li id = "len">Mínimo 8 carácteres</li>
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
<!-- validadr de passwords -->
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
