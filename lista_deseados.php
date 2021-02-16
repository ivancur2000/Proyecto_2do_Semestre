<?php
session_start();
require_once 'resuorces/config/database.php';

if(!isset($_SESSION['id_cli']))
{
    header('location: index.php');
}
if(isset($_GET['id']))
{
    $id = $_SESSION['id_cli'];
    $id_in = $_GET['id'];
    if(isset($_SESSION['id_cli']))
    {
        $sql = "INSERT INTO deseados (id_cli, id_inmueble) VALUES ('$id','$id_in')";
        if(mysqli_query($conn,$sql))
        {
            $alert = 'Añadido correctamente';
            header('refresh: 2; url=lista_deseados.php');
        }else
        {
            $alert = 'Ocurrio un error';
        }
    }
}
if(isset($_GET['id_del']))
{
    $inmueble = $_GET['id_del'];
    $delete = "DELETE FROM deseados WHERE id_inmueble = '$inmueble'";
    if(mysqli_query($conn,$delete))
    {
        $alert = "Quitado de la lista exitosamente";
    }else
    {
        $alert = "Ocurrio un error, intentelo de nuevo";
    }
}
$cliente=$_SESSION['id_cli'];
$lista = mysqli_query($conn, "SELECT i.id_inmueble ,i.descripcion, img.img FROM deseados as d, cliente as c, imagenes as img, inmueble as i WHERE c.id_cli = d.id_cli AND i.id_inmueble = d.id_inmueble AND img.id_inmueble = i.id_inmueble AND c.id_cli LIKE '$cliente' GROUP BY d.id_des");
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
        <!-- contenido -->
        <div class="col ">
            <h1>Lista de desados</h1>
            <?php while($fila = mysqli_fetch_array($lista)){ ?>
            <div class="row border" id="lista">
                <a href="vista_inmu.php?id=<?php echo $fila['id_inmueble']; ?>">
                    <img src="img/inmuebles/<?php echo $fila['img']; ?>" class="rounded" style="width: 150px; height: 100px;" alt="inmueble">
                </a>
                    <div class="col">
                    <p><?php echo $fila['descripcion']?></p>
                    <a href="vista_inmu.php?id=<?php echo $fila['id_inmueble']; ?>" class="btn btn-success">Ver</a>
                    <a href="lista_deseados.php?id_del=<?php echo $fila['id_inmueble']; ?>" class="btn btn-danger">Quitar de la lista</a>
                </div>
            </div>
            <?php } ?>
        </div>
        <!-- pie de pagina -->
        
    </div>
</div>
<!-- alerta modal -->
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
                ?>
            </div>
            <div class="modal-footer">
                <a href="#" data-dismiss="modal" class="btn btn-danger">Cerrar</a>
            </div>
        </div>
    </div>
</div>
<footer class="footer py-4" id="footer2">
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
<script>
$("#menu-toggle").click(function(e) {
    e.preventDefault();
    $("#wrapper").toggleClass("toggled");
});
</script>
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