<?php 
session_start();
require_once '../resuorces/config/database.php';
if(!isset($_SESSION['id']))
{
  header('location: ../../index.php');
} 
$cargo = $_SESSION['cargo'];
$id_usuario=$_SESSION['id'];
?>
<!DOCTYPE html>
<html>
<head>
	<title>Pagina principal Yolita.srl</title>
	<meta charset="uft-8">
	<link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
	<link href="../complements/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="../complements/estilos/style2.css">
	<!-- Font Awesome Icons -->
	<link rel="stylesheet" href="adminlte/plugins/fontawesome-free/css/all.min.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="adminlte/css/adminlte.min.css">
	<!-- Google Font: Source Sans Pro -->
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  	<!-- overlayScrollbars -->
	<link rel="stylesheet" href="adminlte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
<div class="wrapper">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
	<!-- Navbar -->
	<nav class="main-header navbar navbar-expand navbar-dark">
	<!-- Left navbar links -->
	<ul class="navbar-nav">
		<li class="nav-item">
		<a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
		</li>
		<li class="nav-item d-none d-sm-inline-block">
		<a href="home.php" class="nav-link">Pagina Principal</a>
		</li>
	</ul>


	<!-- Right navbar links -->
	<ul class="navbar-nav ml-auto ">
		<!-- Messages Dropdown Menu -->
		<li class="nav-item dropdown">
		<a class="nav-link" data-toggle="dropdown" href="#">
			<i class="far fa-comments"></i>
		</a>
      <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
      <?php  $mensajes = mysqli_query($conn,"CALL mostrarChatUser(".$_SESSION['id'].")");
      while($data_mensaje = mysqli_fetch_array($mensajes)){
      ?>
        <a href="chat/chat.php?idCli=<?php echo $data_mensaje['idUsuario'];?>" class="dropdown-item">
          <!-- Message Start -->
          <div class="media">
            <div class="media-body">
              <h3 class="dropdown-item-title">
                <?php echo $data_mensaje['mensajeCli']; ?>
                <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
              </h3>
              <p class="text-sm"><?php echo $data_mensaje['mensajeCli']; ?></p>
            </div>
          </div>
          <!-- Message End -->
        </a>
        <?php } ?>
		</li>
	</ul>
	</nav>
  	<!-- /.navbar -->

	<!-- Main Sidebar Container -->
	<aside class="main-sidebar sidebar-dark-primary elevation-4" style="background:#2E2E2E;">
  <!-- Brand Logo -->
  <a href="home.php" class="brand-link">
    <img src="../img/yolita.jpg" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
          style="opacity: .8">
    <span class="brand-text font-weight-light">Yolita.SRL</span>
  </a>
  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="../img/user_img/<?php if(isset($_SESSION['img'])){ echo $_SESSION['img']; } ?>" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block"><?php if(isset($_SESSION['id'])){ echo $_SESSION['name']." ".$_SESSION['app']; }else{ echo "aUsusario"; } ?></a>
      </div>
    </div>
		 <!-- Sidebar Menu -->
     <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
              with font-awesome or any other icon font library -->
              <!--Usuarios-->
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link ">
            <i class="nav-icon fas fa-user-alt"></i>
            <p>
              Usuario
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="usuario/lista_us.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Usuarios Activos </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="usuario/habilitar_us.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Usuarios Desabilitados</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="usuario/registro_us.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Registrar Usuarios</p>
              </a>
            </li>
            <li class="nav-item has-treeview">
              <a href="usuario/responsable.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>
                  Responsables
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Cargos</p>
                <i class="right fas fa-angle-left"></i>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="cargo/cargo_lista.php" class="nav-link">
                    <i class="far fa-dot-circle nav-icon"></i>
                    <p>Lista de cargos</p>
                  </a>
                </li>
                <li class="nav-item has-treeview">
                  <a href="cargo/cargo_alta.php" class="nav-link">
                    <i class="far fa-dot-circle nav-icon"></i>
                    <p>
                      Registrar nuevos cargos 
                    </p>
                  </a>
                </li>
                <li class="nav-item has-treeview">
                  <a href="cargo/cargo_hab.php" class="nav-link">
                    <i class="far fa-dot-circle nav-icon"></i>
                    <p>
                      Cargos Deshabilitados 
                    </p>
                  </a>
                </li>
              </ul>   
            </li>
          </ul>
        </li>
        <li class="nav-item">
          <a href="../resuorces/config/desloguear.php" class="nav-link">
            <!-- <i class="nav-icon fas fa-calendar-alt"></i> -->
            <i class="nav-icon fas fa-door-open"></i>
            <p>
              Cerrar Sesion
            </p>
          </a>
        </li>
      </ul>
    </nav>
		<!-- /.sidebar-menu -->
	</div>
	<!-- /.sidebar -->
	</aside>

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
			<h1 class="m-0 text-dark"><?php if(isset($titulo)){ echo $titulo; } ?></h1>
			</div><!-- /.col -->
			<div class="col-sm-6">
			<ol class="breadcrumb float-sm-right">
				<li class="breadcrumb-item"><a href="#">Pagina principal</a></li>
				<li class="breadcrumb-item active"><?php if(isset($ubicacion)){ echo $ubicacion; } ?></li>
			</ol>
			</div><!-- /.col -->
		</div><!-- /.row -->
		</div><!-- /.container-fluid -->
	</div>
	
		<div class="cuerpo">
      <h1>Bienvenido </h1>
		</div>
		<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Alias vel, necessitatibus ad tenetur repellendus autem iure, minima saepe nesciunt at maiores esse fugit quis? Ut perspiciatis ipsa qui soluta illo?</p>
		<!-- /.content -->
	</div>
	<!-- /.content-wrapper -->
	<!-- Main Footer -->
	<footer class="main-footer">
		<!-- To the right -->
		<div class="float-right d-none d-sm-inline">
		Todo sobre Departamentos
		</div>
		<!-- Default to the left -->
		<strong>Derechos de Autor &copy; 2020 Yolita.SRL.</strong>Todos los derechos reservados
	</footer>
	</div>
	<!-- ./wrapper -->

	<!-- REQUIRED SCRIPTS -->

	<!-- jQuery -->
	<script src="adminlte/plugins/jquery/jquery.min.js"></script>
	<!-- Bootstrap 4 -->
	<script src="adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
	<!-- AdminLTE App -->
	<script src="adminlte/js/adminlte.min.js"></script>
	<!-- overlayScrollbars -->
	<script src="adminlte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
</body>
</html>
