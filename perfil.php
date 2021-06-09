<?php
require_once 'resuorces/config/database.php';
session_start(); 
if(!isset($_SESSION['id']))
{
    header('location: index.php');
}
$id = $_SESSION['id'];
$sql=mysqli_query($conn,"SELECT * FROM usuarios WHERE idUsuario = '$id'");
$fila=mysqli_fetch_array($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">

</head>
<body>
<?php include "incluide/navfile.php"; ?>
<br><br><br><br>
<div class="d-flex" id="wrapper">

    <!-- Sidebar -->
    <div class="bg-light border-right" id="sidebar-wrapper">
      <div class="list-group list-group-flush">
        <a href="perfil.php" class="list-group-item list-group-item-action bg-light">Perfil</a>
        <a href="lista_deseados.php" class="list-group-item list-group-item-action bg-light">Lista de deseados</a>
        <a href="compras.php" class="list-group-item list-group-item-action bg-light">Ventas</a>
        <a href="conversacion.php" class="list-group-item list-group-item-action bg-light">Coversaciones</a>
        <a href="recibo_lista.php" class="list-group-item list-group-item-action bg-light">Recibos</a>      
      </div>
    </div>
    <!-- /#sidebar-wrapper -->

    <!-- Page Content -->
    <div id="page-content-wrapper">

        <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
            <button class="btn btn-primary" id="menu-toggle"><i class="fas fa-bars"></i></button>
        </nav>
        <div class="col" id="datos">
            <h3>Datos del Usuario:</h3>
            <div class="form-group row">
                <Label class="col-sm-2 col-form-label">Nombres:</Label>
                <div class="col-sm-8">
                    <input type="text" id="texto" value="<?php echo $fila['nombreUsuario']; ?>"disabled>
                </div>
            </div>
            <div class="form-group row">
                <Label class="col-sm-2 col-form-label">Apellidos</Label>
                <div class="col-sm-8">
                    <input type="text" id="texto" value="<?php echo $fila['appUsuario']; ?>"disabled>
                </div>
            </div>
            <div class="form-group row">
                <Label class="col-sm-2 col-form-label">Fecha de nacimiento:</Label>
                <div class="col-sm-8">
                    <input type="text" id="texto" value="<?php echo $fila['fechaNaci']; ?>"disabled>
                </div>
            </div>
            <div class="form-group row">
                <Label class="col-sm-2 col-form-label">Ciudad:</Label>
                <div class="col-sm-8">
                    <input type="text" id="texto" value="<?php echo $fila['ciudad']; ?>"disabled>
                </div>
            </div>
            <div class="form-group row">
                <Label class="col-sm-2 col-form-label">Pais:</Label>
                <div class="col-sm-8">
                    <input type="text" id="texto" value="<?php echo $fila['pais']; ?>"disabled>
                </div>
            </div>
            <div class="form-group row">
                <Label class="col-sm-2 col-form-label">Correo Electronico:</Label>
                <div class="col-sm-8">
                    <input type="text" id="texto" value="<?php echo $fila['correo']; ?>"disabled>
                </div>
            </div>
            <a class="btn btn-primary" href="mod_cli.php">Modificar Datos</a>
        </div>
    </div>
</div>
<br><br><br>
<!-- pie de pagina -->
<footer class="footer py-4 fixed-botom" id="footer2">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-4 text-lg-left" >Derechos de autor © Yolita.SRL 2020</div>
            <div class="col-lg-4 my-3 my-lg-0">
                <a class="btn btn-dark btn-social mx-2" href="#!"><i class="fab fa-twitter"></i></a><a class="btn btn-dark btn-social mx-2" href="#!"><i class="fab fa-facebook-f"></i></a><a class="btn btn-dark btn-social mx-2" href="#!"><i class="fab fa-linkedin-in"></i></a>
            </div>
            <div class="col-lg-4 text-lg-right"><a class="mr-3" href="#!">Privacy Policy</a><a href="#!">Terms of Use</a></div>
        </div>
    </div>
</footer>
<!-- jquery -->
<script src="js/jquery/jquery.js"></script>
<!-- bootstrap -->
<script src="js/bootstrap/bootstrap.bundle.js"></script>
<script src="js/bootstrap/bootstrap.min.js"></script>
<script src="js/methods/scripts.js"></script>
<?php include "registro_cli.php"; ?>
<script>
$("#menu-toggle").click(function(e) {
    e.preventDefault();
    $("#wrapper").toggleClass("toggled");
});
</script>
</body>
</html>