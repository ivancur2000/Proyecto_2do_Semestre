<?php 
$titulo = "Chat de clientes"; 
$ubicacion = "chat";
session_start();
require_once '../../resuorces/config/database.php';
//validacion de inicio de secion
if(!isset($_SESSION['id']))
{
	header('location: ../../index.php');
}
// validacion del metodo get
if(isset($_GET['idCli']))
{
	$_SESSION['cliente'] = $_GET['idCli'];
}else
{
	// header('location: ../../index.php');
}
//almacenamiento de las variables del chat
$usuario = $_SESSION['id'];
$cliente = $_SESSION['cliente'];

date_default_timezone_set('America/La_Paz');
$fecha= date('Y-m-d H:i:s');

?> 
<!DOCTYPE html>
<html lang="es">
<head>
	<!-- script del chat -->
	<script type="text/javascript">
      function validarForm(formulario) 
      {
          if(formulario.busqueda.value.length==0) 
          { //¿Tiene 0 caracteres?
              formulario.busqueda.focus();  // Damos el foco al control
              return false; 
          } //devolvemos el foco  
          return true; //Si ha llegado hasta aquí, es que todo es correcto 
      }   
</script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Chat</title>
	<script type="text/javascript">
		function ajax(){
			var req = new XMLHttpRequest();

			req.onreadystatechange = function(){
				if (req.readyState == 4 && req.status == 200) {
					document.getElementById('chat').innerHTML = req.responseText;
				}
			}

			req.open('GET', 'caja_chat.php', true);
			req.send();
		}

		//linea que hace que se refreseque la pagina cada segundo
		setInterval(function(){ajax();}, 1000);
	</script>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<!-- sidebar -->
<?php include "../sidebar/sidebar.php"; ?> 
<!-- chat -->
    <div class="card col-8" style="margin-left: 20%;"id="caja">
		<div class="card-header" style="background: green; color: white;"><h3>Chat</h3></div>
		<div id="caja-chat" class="card-body">
			<div id="chat"></div>
		</div>
		<form method="POST" action="chat.php?id_cli=<?php echo $_SESSION['cliente']; ?>">
			<input type="hidden" name="cliente" value="<?php echo $_SESSION['cliente']; ?>">			
			<textarea name="mensaje" class="form-control" placeholder="Ingresa tu mensaje"></textarea>
			<input type="submit" name="enviar" class="btn btn-success btn-block" value="Enviar">
		</form>

		<?php
			if (isset($_POST['enviar'])) {
				$mensaje=$_POST['mensaje'];
				$consulta = "INSERT INTO chat (usuario, cliente, mensajeUs, fechaHora, estadoChat) VALUES ('$usuario', '$cliente', '$mensaje','$fecha', 1)";
				if (mysqli_query($conn,$consulta)) {
					echo "<embed loop='false' src='beep.mp3' hidden='true' autoplay='true'>";
				}else{
					echo mysqli_error($conn);
				}
			}

		?>
	</div>    
	<?php include "../sidebar/sidebar2.php"; ?>
</body>
</html>