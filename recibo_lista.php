<?php
session_start();
require_once 'resuorces/config/database.php';

if(!isset($_SESSION['id_cli']))
{
    header('location: index.php');
}
$cliente=$_SESSION['id_cli'];
$lista = mysqli_query($conn, "SELECT c.num_cuota, c.monto_cancelado, c.codigo FROM cuota as c WHERE c.id_cli = '$cliente'");
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
            <h1>Lista de recibos</h1>
            <div class="row border" id="lista">
                    
                    <table class="table">
                        <thead class="thead-dark">
                            <tr>
                                <th>Codigo</th>
                                <th>Numero de cuotas</th>
                                <th>Monto Cancelado</th>
                                <th>Tarea</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php while($fila = mysqli_fetch_array($lista)){ ?>
                            <tr>
                                <td><?php echo $fila['codigo']; ?></td> 
                                <td><?php echo $fila['num_cuota']; ?></td>
                                <td><?php echo $fila['monto_cancelado']; ?></td>  
                                <td><a href="recibo.php?id=<?php echo $fila['codigo']; ?>"target="_blank" class="btn btn-success">Ver Recibo</a></td>     
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- pie de pagina -->
        <br><br>
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
<!-- JQVMap -->
<script src="plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="plugins/jquery-knob/jquery.knob.min.js"></script>
</body>
</html>