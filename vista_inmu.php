<?php 
require_once 'resuorces/config/database.php';
session_start();
if(!empty($_GET['id']))
{
    $id = $_GET['id'];
    $sql = mysqli_query($conn,"SELECT * FROM inmueble WHERE id_inmueble = '$id'");
    $result = mysqli_num_rows($sql);
    if($result == 0)
    {
       header('Location: index.php');
    }
}else
{
   header('Location: index.php');
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yolita.SRL</title>
    <script src="https://kit.fontawesome.com/5e53af518b.js" crossorigin="anonymous"></script>    
    <!-- estilos de la barra -->
    <link rel="stylesheet" href="css/navbar.css">
    <!-- estilos de la pagina -->
    <link rel="stylesheet" href="css/estilo.css">
    <!-- validador de password -->
    <script language="JavaScript">
        function validar_clave ()
        {
            var pass1 = document.getElementById('pass').value;
            var pass2 = document.getElementById('cpass').value;
            if (pass1 != pass2) {
                $("#validador_pass").html("<div><b> Las contraseñas deben coincidir <b></div>");
                return false;
            }
            else {
                return true;
            }
        }
    </script>
</head>
<body>
    <!-- barra de navegacion -->
    <?php include "incluide/navfile.php"; ?>
    <br><br><br><br>
    <!-- barra de navegacion secudaria -->
    <nav class="navbar" id="navbar3">
        <div class="form-inline">
            <a role="button" href="index.php" id="link">Atras</a>
            <?php
            if(isset($_SESSION['id_cli']))
            {
            ?>
            <a role="button"  data-toggle="modal" href="#contactos" id="link">Contactate con nosotros</a>
            <?php
            }else
            {
            ?>
            <a role="button" href="login.php" id="link">Iniciar Sesión</a>
            <?php } ?>
            <a role="button" href="#target" data-toggle="modal" id="link">Modelo en Realidad Aumentada</a>
        </div>
    </nav>
    <br>
    <div id="contenedor2">
        <div class="row">
            <!-- imagenes del inmueble -->
            <div class="col-5">
                <div class="images-section">
                    <?php
                    $img = mysqli_query($conn,"SELECT * FROM imagenes WHERE id_inmueble = '$id'"); 
                    while($dato = mysqli_fetch_array($img)){ ?>
                    <div class="item">
                        <div class="imagen">
                            <img src="img/inmuebles/<?php echo $dato['img']; ?>" style="width:500px; height: 450px;" class="img-fluid img-thumbnail" alt="Edificio"> 
                        </div>
                    </div>
                    <?php } ?>
                </div>
                <div class="col-15">
                    <div class="arrows">
                        <div class="fas fa-arrow-left"></div>
                        <div class="fas fa-arrow-right"></div>
                    </div>
                </div>
            </div>
            <!-- descripcion del inmueble -->
            <div class="col-7" >
                <?php 
                $inmueble = mysqli_query($conn, "SELECT e.id_ed, i.habitaciones, i.cocinas, i.baños, i.piso, i.servicios_basicos, i.garaje, i.posicion, i.precio, i.descripcion, i.target, e.zona_ed, e.calle_ed, e.num_puerta, e.referencia_ed, e.latitud, e.longitud, e.nombre_ed, t.descrip_tam FROM inmueble as i, edificio as e, tamaño as t WHERE e.id_ed = i.id_edificio AND t.id_tamaño=i.id_tamaño AND id_inmueble = '$id'");
                $vector = mysqli_fetch_array($inmueble) ?>
                <h2 class="section-heading text-uppercase" id="letra"> <?php echo $vector['descripcion']; ?></h2>
                <br>
                <h4 class="section-heading text-uppercase" id="letra">Caracteristicas del inmueble</h4>
                <div class="row">
                    <div class="col-4">
                        <div id="caracteristicas"><i class="fas fa-bed"></i> Dormitorios: <?php echo $vector['habitaciones']; ?></div>
                        <div id="caracteristicas"><i class="fas fa-building"></i> Edificio: <p> <?php echo $vector['nombre_ed']; ?></p></div>
                        <div id="caracteristicas"><i class="fas fa-car"></i> Garaje:<?php echo $vector['garaje']; ?></div>     
                    </div>
                    <div class="col-4">
                        <div id="caracteristicas"><i class="fas fa-bath"></i> Baños: <?php echo $vector['baños']; ?></div>
                        <div id="caracteristicas"><i class="fas fa-chart-area"></i> Tamaño: <p><?php echo $vector['descrip_tam']." m2"; ?></p></div>
                        <div id="caracteristicas"><i class="fas fa-home"></i> Piso: <?php echo $vector['piso']; ?></div>
                    </div>
                    <div class="col">
                        <div id="caracteristicas"><i class="fas fa-utensils"></i> Cocina: <?php echo $vector['cocinas']; ?></div>
                        <div id="caracteristicas"><i class="fas fa-cloud-sun"></i> Posicion respecto al sol: <?php echo $vector['posicion']; ?></div>
                        <div id="caracteristicas"><i class="fas fa-lightbulb"></i> Servicios basicos: <p> <?php echo $vector['servicios_basicos']; ?></p></div>
                    </div>
                </div>
                <div class="row float-left">
                    <div id="precio" class="float-right"><i class="fas fa-money-bill-wave-alt"></i> Precio Desde: <b> <?php echo $vector['precio']." Bs"; ?></b> </div>
                    <a href="cotizador.php?id=<?php echo $id; ?>" target="_blank" class="btn btn-success">Calcular costo</a>
                </div>
            </div> 
        </div>
    </div>
    <br><br>
    <!-- mapa y direccion del inmueble -->
    <div id="mapa">
    <h3 class="section-heading text-uppercase">Direccion</h3>
        <div class="row">
            <div class="col-7">
                <div id="maps"></div>
            </div>
            <div class="col-5">
                <div class="col">
                    <div id=caracteristicas><i class="fas fa-map-marker"></i> <b>Zona: </b> <?php echo $vector['zona_ed']; ?></div>
                    <div id=caracteristicas><i class="fas fa-map-signs"></i> <b>Calle: </b> <?php echo $vector['calle_ed']; ?></div>
                    <div id=caracteristicas><i class="fas fa-door-closed"></i> <b>Numero: </b><?php echo $vector['num_puerta']; ?></div>
                    <div id=caracteristicas><i class="fas fa-map-signs"></i> <b>Referencia: </b><?php echo $vector['referencia_ed']; ?></div>
                </div>
            </div>
        </div>
    </div>
    <br><br>
    <!-- modelo en realidad aumentada -->
    <div class="container">
        <div class="row">
            <div class="col-4">
                <h3 class="section-heading text-uppercase" style="color: #ffff;">Modelo en Realidad Aumentada</h3>
                <div class="portfolio-item">
                    <a class="portfolio-link" data-toggle="modal" href="#target">
                        <img src="img/target/<?php echo $vector['target']; ?>" style="width: 350px; height: 350px;" class="img-fluid img-thumbnail" alt="Edificio"> 
                    </a>
                </div>
            </div>
            <!-- aplicacion de la pagina web -->
            <div class="col-3" id="qr">
                <h3 class="section-heading text-uppercase" style="color: #ffff;">Descarga nuestra APP</h3>
                <div class="imagen">
                    <img src="img/codigo.jpeg" style="width: 250px; height: 250px;" class="img-fluid img-thumbnail" alt="Edificio"> 
                </div>
                <a href="">www/playstore.com</a>
            </div> 
        </div>
    </div>
    <br><br>
    <div class="container" id="boton">
        <div class="row">
            <input type="hidden" name="id" value="">
            <?php
            //validacion de inicio de sesion para el boton 
            if(isset($_SESSION['id_cli']))
            {
                $cliente = $_SESSION['id_cli'];
                $consulta = mysqli_query($conn,"SELECT * FROM deseados WHERE id_cli = '$cliente' AND id_inmueble = '$id'");
                $resultado = mysqli_num_rows($consulta);
                if($resultado>0)
                {
                ?>    
                <a href="#" class="btn btn-primary">Añadido a la lista de deseados</a>
                <a data-toggle="modal" href="#contactos" class="btn btn-dark ">Contactanos</a>
                <?php                
                }else
                {
                ?>
                <a class="btn btn-primary" href="lista_deseados.php?id=<?php echo $id;?>">Añadir a la lista de deseados</a>
                <a data-toggle="modal" href="#contactos" class="btn btn-dark ">Contactanos</a>
            <?php  
                }
            }else
            {
                ?>
                <a class="btn btn-primary" href="login.php">Iniciar Sesión</a>
                <?php
            } 
            ?>
        </div>
    </div>
    <br><br><br>    
    <!-- pie de pagina -->
    <footer class="footer py-4 fixed-botom" id="footer">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-4 text-lg-left" style="color: #ffff">Derechos de autor © Yolita.SRL 2020</div>
                <div class="col-lg-4 my-3 my-lg-0">
                    <a class="btn btn-dark btn-social mx-2" href="#!"><i class="fab fa-twitter"></i></a><a class="btn btn-dark btn-social mx-2" href="#!"><i class="fab fa-facebook-f"></i></a><a class="btn btn-dark btn-social mx-2" href="#!"><i class="fab fa-linkedin-in"></i></a>
                </div>
                <div class="col-lg-4 text-lg-right"><a class="mr-3" href="#!">Privacy Policy</a><a href="#!">Terms of Use</a></div>
            </div>
        </div>
    </footer>
    <!-- del modelo en realidad aumentada-->
    <div class="portfolio-modal modal fade" id="target" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="close-modal" data-dismiss="modal"><i class="fas fa-window-close"></i></div>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="modal-body" >
                                <!-- Project Details Go Here-->
                                <h2 class="text-uppercase">Mustra esta imagen en la aplicacion</h2>
                                <p class="item-intro text-muted">Descarga nuestra aplicacion...</p>
                                <img class="img-fluid d-block mx-auto" src="img/target/<?php echo $vector['target']; ?>" alt="" />
                                <a class="btn btn-primary" type="button" href="">Imprimir imagen</a>
                                <button class="btn btn-primary" data-dismiss="modal" type="button"><i class="fas fa-times mr-1"></i>Cerrar ventana</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="portfolio-modal modal fade" id="contactos" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="close-modal" data-dismiss="modal"><i class="fas fa-window-close"></i></div>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="modal-body" >
                                <!-- Project Details Go Here-->
                                <h2 class="text-uppercase">Contactos disponibles</h2>
                                <p class="item-intro text-muted"></p>
                                <?php 
                                $edificio = $vector['id_ed'];
                                $contacto = mysqli_query($conn, "SELECT u.id_us, u.nom_us,u.app_us, u.apm_us, u.foto_us, u.correo_us, u.cel1_us, u.cel2_us FROM responsable as r INNER JOIN usuario as u ON u.id_us=r.id_us INNER JOIN edificio as e ON e.id_ed=r.id_ed WHERE r.id_ed = '$edificio'");
                                while ($data = mysqli_fetch_array($contacto)) 
                                {
                                ?>
                                    <div class="col">
                                        <div class="row" id="grupo">
                                            <img id="imagen" src="img/user_img/<?php echo $data['foto_us']; ?>" alt="foto usuario">
                                            <div class="col">
                                                <div id="contacto"><?php echo $data['nom_us']." ".$data['app_us']." ".$data['apm_us']; ?><i></i><b> Whatsapp:</b><?php echo $data['cel1_us']." ".$data['cel2_us']; ?><b> Correo: </b><?php echo $data['correo_us'] ?></div>
                                                <a class="btn btn-success" target="_blanck" href="chat/chat.php?id_us=<?php echo $data['id_us']; ?>"><i></i>Contactar</a>
                                            </div>
                                        </div>
                                    </div>
                                <?php    
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- pagina de registro -->
    <!-- script para el mapa -->
	<script>
	function mapa(){
        var coord = {lat:<?php echo $vector['latitud']; ?> ,lng: <?php echo $vector['longitud'] ?>};
        var map = new google.maps.Map(document.getElementById('maps'),{
        zoom: 19,
        center: coord
        });
        var marker = new google.maps.Marker({
        position: coord,
        map: map
        });
    }
	</script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBDaeWicvigtP9xPv919E-RNoxfvC-Hqik&callback=mapa"
    async defer></script>
    <!-- jquery -->
    <script src="js/jquery/jquery.js"></script>
    <!-- bootstrap -->
    <script src="js/bootstrap/bootstrap.bundle.js"></script>
    <script src="js/methods/imagenes.js"></script>  
    <script src="js/methods/scripts.js"></script>  
    <?php include "registro_cli.php"; ?>
 
</body>
</html> 