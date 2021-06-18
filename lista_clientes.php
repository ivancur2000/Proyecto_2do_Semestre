<?php
session_start();
require_once 'resuorces/config/database.php';
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/estilo_lista.css">
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
        <a href="lista_clientes.php" class="list-group-item list-group-item-action bg-light">Lista de Clientes</a>
        <a href="compras.php" class="list-group-item list-group-item-action bg-light">Reportes Estadísticos</a>
        <a href="conversacion.php" class="list-group-item list-group-item-action bg-light">Conversaciones</a>
        <a href="recibo_lista.php" class="list-group-item list-group-item-action bg-light">Departamentos de Bolivia</a>
      </div>
    </div>
    <!-- /#sidebar-wrapper -->
    <!-- Page Content -->
    <div id="page-content-wrapper">
        <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
            <button class="btn btn-primary" id="menu-toggle"><i class="fas fa-bars"></i></button>
        </nav>
        <!-- contenido -->
        <div class="col">
            <h1>Lista de Clientes</h1>
            <div class="row border">
                <table>
                    <tr>
                        <th>Id</th>
                        <th>Nombres</th>
                        <th>Apellidos</th>
                        <th>Cargo</th>
                        <th>Fecha Nacimiento</th>
                        <th>País</th>
                        <th>Ciudad</th>
                        <th>Acciones</th>
                    </tr>

                <?php 
                    $query = mysqli_query($conn, "SELECT idUsuario ,u.nombreUsuario, u.appUsuario, c.nombreCargo, u.fechaNaci, 
                    u.pais, u.ciudad FROM usuarios u INNER JOIN cargo c ON u.cargo = c.idCargo");

                    $result = mysqli_num_rows($query);
                    if($result > 0){
                        while($data = mysqli_fetch_array($query)){
                    ?>
                        <tr>
                            <td><?php echo $data['idUsuario']?></td>
                            <td><?php echo $data['nombreUsuario']?></td>
                            <td><?php echo $data['appUsuario']?></td>
                            <td><?php echo $data['nombreCargo']?></td>
                            <td><?php echo $data['fechaNaci']?></td>
                            <td><?php echo $data['pais']?></td>
                            <td><?php echo $data['ciudad']?></td>
                            <td>
                                <a href="" class="link_edit">Editar</a>
                                |
                                <a href="" class="link_delete">Eliminar</a>
                            </td>
                        <tr>        
                <?php            
                        }
                    }
                ?>

                </table>
            </div>
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
            <div class="col-lg-4 text-lg-left" >Derechos de autor © Manuel Jimenez</div>
            <div class="col-lg-4 my-3 my-lg-0">
                <a class="btn btn-dark btn-social mx-2" href="#!"><i class="fab fa-twitter"></i></a><a class="btn btn-dark btn-social mx-2" href="#!"><i class="fab fa-facebook-f"></i></a><a class="btn btn-dark btn-social mx-2" href="#!"><i class="fab fa-linkedin-in"></i></a>
            </div>
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