<?php
require_once 'resuorces/config/database.php';
session_start(); 
if(!isset($_SESSION['id_cli']))
{
    header('location: index.php');
}
$id = $_SESSION['id_cli'];
$sql=mysqli_query($conn,"SELECT * FROM cliente WHERE id_cli = '$id'");
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

    <!-- Page Content -->
    <div id="page-content-wrapper">

        <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
            <button class="btn btn-primary" id="menu-toggle"><i class="fas fa-bars"></i></button>
        </nav>
        <!-- contenido  -->
        <div class="container" style="margin: 15px;">
            <div class="col">
                <h3>Lista de compras</h3>
                <?php
                $ventas = mysqli_query($conn, "SELECT v.id_venta, v.cuotas_pagadas,p.duracion_meses ,img.img ,v.est_venta, u.nom_us, u.app_us, i.descripcion, v.cuotas_pagadas, v.num_cuotas, v.precio_cuota,v.precio_total FROM venta as v INNER JOIN usuario as u ON u.id_us = v.id_us INNER JOIN cliente as c ON c.id_cli = v.id_cli INNER JOIN inmueble as i ON i.id_inmueble = v.id_inmueble INNER JOIN imagenes as img on img.id_inmueble = i.id_inmueble INNER JOIN plan_pago as p ON p.id_pp = v.id_pp WHERE c.id_cli = '$id' AND v.est_venta != 0 GROUP BY v.id_venta");  
                while($vector = mysqli_fetch_array($ventas))
                {
                    ?>
                    <div class="row border-bottom" style="margin:15px;">
                        <img class="rounded" src="img/inmuebles/<?php echo $vector['img']; ?>" style="width: 150px; height: 120px; margin:5px;" alt="foto_inmueble">
                        <div class="col">
                            <div class="col-9">
                                <p>Agente: <?php echo $vector['nom_us']." ".$vector['app_us'] ?></p>
                                <p>Descripcion: <?php echo $vector['descripcion']; ?></p>
                            </div>
                        </div>
                        <div class="col-3">
                            <p>Precio: <?php echo $vector['precio_total']." Bs."; ?></p>
                            <p>Cuotas: <?php echo $vector['precio_cuota']." Bs."; ?></p>
                            <p>Numero de cuota: <?php if(empty($vector['cuotas_pagadas'])){ echo 0; }else{ echo $vector['cuotas_pagadas'];} ?>/<?php echo $vector['duracion_meses']; ?></p>
                        </div>
                        <div class="col-3">
                            <a href="cobro.php?id_venta=<?php echo $vector['id_venta'] ?>" class="btn btn-success">Pagar cuota</a>
                            <br>
                            <br>
                            <p>Estado: <?php if($vector['est_venta']==1){ echo 'Venta'; }else if($vector['est_venta']==2){ echo 'Reserva'; }else if($vector['est_venta']==3){ echo 'Comprado'; } ?></p>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
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