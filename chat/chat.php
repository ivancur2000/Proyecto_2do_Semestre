<?php 
session_start();
require_once '../resuorces/config/database.php';
if(!isset($_SESSION['id']))
{
	header('location: ../index.php');
}
if(isset($_GET['id_us']))
{
	$_SESSION['usuario'] = $_GET['id_us'];
}else
{
	header('location: ../index.php');
}
$usuario=$_SESSION['usuario'];
$cliente=$_SESSION['id'];

date_default_timezone_set('America/La_Paz');
$fecha= date('Y-m-d H:i:s');
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<script src="https://kit.fontawesome.com/5e53af518b.js" crossorigin="anonymous"></script>
	<link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700" rel="stylesheet" type="text/css" />
	<link href="../css/navbar.css" rel="stylesheet" />
	<link rel="stylesheet" href="../css/estilo.css">
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
<body>
<!-- cabcera -->
<nav class="navbar navbar-expand-lg navbar-dark fixed-top" style="background: #212529;" id="mainNav">
    <div class="container">
        <a class="navbar-brand js-scroll-trigger" href="../index.php">TURISBO</a><button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">Menú<i class="fas fa-bars ml-1"></i></button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav text-uppercase ml-auto">
                <div class="masthead-subheading text-uppercase">
                    <!-- Search form -->
                    <form action="busqueda.php" method="POST" onSubmit="return validarForm(this)">
                        <input class="form-control" name="busqueda" type="text" placeholder="Departamentos, lugares turísticos, hoteles, comidas" aria-label="Search">  
                </div>
                        <button type="submit" name="tb_buscar" class="btn btn-primary text-uppercase js-scroll-trigger">Buscar</button>
                    </form>
            </ul>
            <ul class="navbar-nav text-uppercase ml-auto">
            <?php
            if(isset($_SESSION['id']))
            { 
            ?>
                <ul class="navbar-nav ">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle js-scroll-trigger" role="button" data-toggle="dropdown">
                    <?php if(isset($_SESSION['name']) && isset($_SESSION['app']))
                    {
                        echo $_SESSION['name']." ".$_SESSION['app']; 
                    }
                    ?></a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="../perfil.php">Ver Perfil</a>
                    <div class="dropdown-divider"></div>
                    
                    <a class="dropdown-item" href="../resuorces/config/desloguear.php">Cerrar Sesión</a>
                    </li>
                </ul>
                
                <?php
            }else
            {
            ?>
            <li class="nav-item"><a class="nav-link js-scroll-trigger" href="login.php">Ingresar</a></li>
            <li class="nav-item"><a class="btn btn-warning"  data-toggle="modal" href="#registro"><b>REGÍSTRARSE</b> </a></li>
            <?php } ?>
            </ul>
        </div>
    </div>
</nav>
<br><br><br><br><br>
<!-- chat -->
    <div class="container col-5" id="caja">
		<div id="caja-chat" class="row overflow-auto">
			<div id="chat"></div>
		</div>
		<form method="POST" action="chat.php?id_us=<?php echo $_SESSION['usuario']; ?>">
			<input type="hidden" name="usuario" value="<?php echo $id_us; ?>">			
			<textarea name="mensaje" class="form-control" placeholder="Ingresa tu mensaje"></textarea>
			<input type="submit" name="enviar" class="btn btn-success btn-block" value="Enviar">
		</form>

		<?php
			if (isset($_POST['enviar'])) {
				$mensaje=$_POST['mensaje'];

				$consulta = "INSERT INTO chat (usuario, cliente, mensajeCli, fechaHora, estadoChat) VALUES ('$usuario', '$cliente', '$mensaje','$fecha', 1)";
				if (mysqli_query($conn,$consulta)) {
					echo "<embed loop='false' src='beep.mp3' hidden='true' autoplay='true'>";
				}
			}

		?>
	</div>
	<!-- pie de pagina -->
    <footer class="footer py-4 fixed-botom" id="footer">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-4 text-lg-left" style="color: #ffff">Derechos de autor © Manuel Jimenez</div>
                <div class="col-lg-4 my-3 my-lg-0">
                    <a class="btn btn-dark btn-social mx-2" href="#!"><i class="fab fa-twitter"></i></a><a class="btn btn-dark btn-social mx-2" href="#!"><i class="fab fa-facebook-f"></i></a><a class="btn btn-dark btn-social mx-2" href="#!"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
        </div>
    </footer>
<!-- jquery -->
<script src="../js/jquery/jquery.js"></script>
<!-- bootstrap -->
<script src="../js/bootstrap/bootstrap.bundle.js"></script>
<script src="../js/bootstrap/bootstrap.min.js"></script>
<script src="../js/methods/scripts.js"></script>
</body>
</html>