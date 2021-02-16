<?php
require_once 'resuorces/config/database.php';//llamada a la base de datos
//inicio de sesion
session_start();
//contador de intentos
if(!isset($_SESSION['contador']))
{
	$_SESSION['contador'] = 0;
}
//validacion si la sesion ya fue iniciada
if(!empty($_SESSION['active']))
{
	if($_SESSION['usuario'] == 'empleado')
	{
		header('location: system/home.php');
	}else
	{
		header('Location: index.php');
	}
	
	
}else
{
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Login</title>	
	<link rel="stylesheet" href="css/login.css">
	<link rel="stylesheet" href="css/style.css">
	<link href="css/bootstrap/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">				
</head>
<body onLoad="timer()">
	<div class="login-reg-panel">							
		<div class="white-panel">
			<div class="login-show">
				<h1 class="display-3">Login</h1>
				<!-- Formilario del loguin -->
				<form action="login.php" method="POST" id="formulario">
					<input type="text" class="form-control" name="tb_us" placeholder="Usuario"><br>
					<input type="password" class="form-control" name="tb_pass" placeholder="Contraseña"><br>
					<input type="submit" value="Ingresar" id="boton" data-toggle="modal" data-target="#alert"><br>
					<?php
					//validacion si los campos esta vacios
					if(!empty($_POST))
					{
					//en mi caso yo utilizo esto por tengo dos tipos de usuarios, tu puedes quitar este if y else
					if($_POST['nivel']=="u")//*** */
					{
						//inicio del metodo de logueo
						//variables de logueo
						$user = mysqli_real_escape_string($conn, $_POST['tb_us']);
						$pass = md5(mysqli_real_escape_string($conn, $_POST['tb_pass']));
						//consulta a la base de datos para la validacion del logueo
						$sql = mysqli_query($conn, "SELECT * FROM usuario WHERE login_us = '$user' AND pass_us = '$pass' AND est_us = '1'");
						$resultado = mysqli_num_rows($sql);
						if($resultado == 1)
						{
							//datos del usuario logueado	
							$data = mysqli_fetch_array($sql);
							$_SESSION['active'] = true;
							$_SESSION['id'] = $data['id_us'];
							$_SESSION['cargo'] = $data['id_cargo'];
							$_SESSION['name'] = $data['nom_us'];
							$_SESSION['app'] = $data['app_us'];
							$_SESSION['apm'] = $data['apm_us'];
							$_SESSION['img'] = $data['foto_us'];
							$_SESSION['usuario'] = 'empleado'; 
							//redireccion a la pagina principal de usuario
							header('refresh:1; url= system/home.php');
							$alert="BIENVENIDO: ".$data['nom_us']." ".$data['app_us'];;
						}else
						{
							//contador de intentos
							$_SESSION['contador']++;
							$contador=$_SESSION['contador'];
							$alert="Usuario o contraseña incorrectos,".'<br>'." por favor intentelo de nuevo";
							if($contador == 3)
							{
								$alert = "Llego al limite de intentos";
								session_destroy();
								?>
								<!--script del bloque de boton y temporizador-->
								<script src="js/methods/bloc.js"></script>
								<div id="contador" class = "tiempo"></div>
								<script src="js/methods/temp.js"></script>
								<?php
								header('refresh:5; url=login.php');
							}
							?>
							<?php
						}
					}else//**** */
					{
						//esto es  lo mismo pero para otra tabla
						//variables de logueo
						$user = mysqli_real_escape_string($conn, $_POST['tb_us']);
						$pass = md5(mysqli_real_escape_string($conn, $_POST['tb_pass']));
						//consulta a la base de datos para la validacion del logueo
						$sql = mysqli_query($conn, "SELECT * FROM cliente WHERE email_cli = '$user' AND pass_cli = '$pass' AND est_cli = '1'");
						$resultado = mysqli_num_rows($sql);
						if($resultado == 1)
						{
							//datos del usuario logueado	
							$data = mysqli_fetch_array($sql);
							$_SESSION['active'] = true;
							$_SESSION['id_cli'] = $data['id_cli'];
							$_SESSION['nom_cli'] = $data['nom_cli'];
							$_SESSION['ape_cli'] = $data['ape_cli'];
							$_SESSION['usuario'] = 'cliente'; 
							//redireccion a la pagina principal de usuario
							header('refresh:1; url= index.php');
							$alert="BIENVENIDO: ".$data['nom_cli']." ".$data['ape_cli'];
						}else
						{
							//contador de intentos
							$_SESSION['contador']++;
							$contador=$_SESSION['contador'];
							$alert="Usuario o contraseña incorrectos,".'<br>'." por favor intentelo de nuevo";
							if($contador == 3)
							{
								$alert = "Llego al limite de intentos";
								session_destroy();
								?>
								<script src="js/methods/bloc.js"></script>
								<div id="contador" class = "tiempo"></div>
								<script src="js/methods/temp.js"></script>
								<?php
								header('refresh:5; url=login.php');
							}
							?>
							<?php
						}
					}
				}
			}
			//automatico
			?>
					<input type="radio" name="nivel" value="u" id="">Usuario
					<input type="radio" name="nivel" value="c" id="" checked>Cliente <br>
				</form>	
			</div>
		</div>
		<div class="container text-right">	
			<div class="text-rigth">
				<a href="index.php" style="color: #ffff;"><h1 class="display-3">Yolita.SRL</h1></a>
			</div>
		</div>
	</div>
	<!-- ventana modal que muestra los mensajes del sistema -->
	<div class="modal fade" id="mostrarmodal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" id="header">
                    <h3>Mensaje del sistema</h3>
                </div>
                <div class="modal-body">
                    <?php if(isset($alert))
                    {
                    echo '<div class="alert">'.$alert.'</div>';     
                    }
                    if(isset($contador)){
						echo '<div class="cont" id="cont">'."Intentos: ".$contador.'</div>';
					}
					?>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" id="boton" class="btn btn-danger">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="js/jquery/jquery.js"></script>
    <script src="js/bootstrap/bootstrap.js"></script>
	<script type="text/javascript">
	$(document).ready(function()
      {
          var mensaje = '<?php echo $alert; ?>'
        if(mensaje !== ""){
         $("#mostrarmodal").modal("show");
         mensaje="";
        }
      });
	</script>	
<!-- jquery-validation y bootstrap-->
<script src="system/adminlte/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="system/adminlte/plugins/jquery-validation/additional-methods.min.js"></script>
    
	<!-- validate jquery y proteccion de los campos -->
<script src="js/methods/validar.js"></script>
</body>
</html>
