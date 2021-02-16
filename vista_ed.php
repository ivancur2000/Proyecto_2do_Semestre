<?php
require_once 'resuorces/config/database.php';
session_start();
if(!empty($_GET['id']))
{
    $id = $_GET['id'];
    $sql = mysqli_query($conn,"SELECT * FROM edificio WHERE id_ed = '$id'");
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
</head>
<body>
    
</body>
</html><!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yolita.SRL</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
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
            <a role="button" href="#lista_in" id="link">Lista de inmuebles</a>
        </div>
    </nav>
    <div class="container" id="contenedor2">
        <div class="row">
            <!-- imagenes del inmueble -->
            <div class="col-5">
                <div class="images-section">
                    <?php
                    $img = mysqli_query($conn,"SELECT * FROM imagenes WHERE id_ed = '$id'"); 
                    while($dato = mysqli_fetch_array($img)){ ?>
                    <div class="item">
                        <div class="imagen">
                            <img src="img/edificios/<?php echo $dato['img']; ?>" style="width:500px; height: 450px;" class="img-fluid img-thumbnail" alt="Edificio"> 
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
                $edificio = mysqli_query($conn, "SELECT * FROM edificio WHERE id_ed = '$id'");
                $vector = mysqli_fetch_array($edificio) ?>
                <h2 class="section-heading text-uppercase" id="letra"><?php echo $vector['nombre_ed']; ?></h2>
                <p class="text-muted" id="caracteristicas"> <?php echo $vector['descripcion']; ?></p>
                <h3 class="section-heading text-uppercase" id="letra">Caracteristicas del Edificio</h3>
                <div class="row">
                    <div class="col">
                        <div id="caracteristicas"><i></i> Numero de pisos: <?php echo $vector['pisos_ed']; ?></div>
                        <div id="caracteristicas"><i></i> Unidades: <?php echo $vector['inmu_dis']; ?></div>
                    </div>
                    <div class="col">
                        <div id="caracteristicas"><i></i> Fecha de entrega: <?php echo $vector['fecha_entrega'];?></div>
                        <div id="caracteristicas"><i></i> Desde: <?php $minimo=mysqli_query($conn,"SELECT min(precio) as precio FROM inmueble WHERE id_edificio='$id'"); $costo = mysqli_fetch_array($minimo); echo $costo['precio']."Bs";?></div>
                    </div>
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
    <!-- lista de inmuebles disponibles del edificio -->
    <div class="col" id="lista_in">
    <h3 class="section-heading text-uppercase" id="letra">Departamentos, oficinas y locales disponibles</h3>
        <div class="row">
        <?php
        $inmueble = mysqli_query($conn, "SELECT i.id_inmueble, i.descripcion, img.img, t.nombre_tipo FROM inmueble as i INNER JOIN imagenes as img ON img.id_inmueble=i.id_inmueble INNER JOIN tipo_inmueble as t ON t.id_tipo = i.id_tipo WHERE i.id_edificio='$id' GROUP BY i.descripcion");
        while($data = mysqli_fetch_array($inmueble))
        {
        ?>
        
            <div class="col-lg-4 col-sm-6 mb-4">
                <div class="portfolio-item">
                    <a class="portfolio-link" href="vista_inmu.php?id=<?php echo $data['id_inmueble']; ?>">
                        <img class="img-fluid" onmouseout="this.src='img/inmuebles/<?php echo $data['img']; ?>';" onmouseover="this.src='img/inmuebles/cover.png';" src="img/inmuebles/<?php echo $data['img']; ?>" style=" width: 350px; height: 250px;" alt=""
                    /></a>
                    <div class="portfolio-caption">
                        <div class="portfolio-caption-heading" style="color:#ffff;"><?php echo $data['descripcion'];?></div>
                        <div class="portfolio-caption-subheading" id="letra"><?php echo $data['nombre_tipo'] ?></div>
                    </div>
                </div>
            </div>
        <?php
        }
        ?>ç
        </div>
    </div>
    <!-- pie de pagina -->
    <footer class="footer py-4 fixed-botom" id="footer">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-4 text-lg-left" style="color:#ffff;">Derechos de autor © Yolita.SRL 2020</div>
                <div class="col-lg-4 my-3 my-lg-0">
                    <a class="btn btn-dark btn-social mx-2" href="#!"><i class="fab fa-twitter"></i></a><a class="btn btn-dark btn-social mx-2" href="#!"><i class="fab fa-facebook-f"></i></a><a class="btn btn-dark btn-social mx-2" href="#!"><i class="fab fa-linkedin-in"></i></a>
                </div>
                <div class="col-lg-4 text-lg-right"><a class="mr-3" href="#!">Privacy Policy</a><a href="#!">Terms of Use</a></div>
            </div>
        </div>
    </footer>
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
                                $contacto = mysqli_query($conn, "SELECT u.nom_us,u.app_us, u.apm_us, u.foto_us, u.correo_us, u.cel1_us, u.cel2_us FROM responsable as r INNER JOIN usuario as u ON u.id_us=r.id_us INNER JOIN edificio as e ON e.id_ed=r.id_ed WHERE r.id_ed = '$id'");
                                while ($datos = mysqli_fetch_array($contacto)) 
                                {
                                ?>
                                    <div class="col">
                                        <div class="row" id="grupo">
                                            <img id="imagen" src="img/user_img/<?php echo $datos['foto_us']; ?>" alt="foto usuario">
                                            <div class="col">
                                                <div id="contacto"><?php echo $data['nom_us']." ".$datos['app_us']." ".$datos['apm_us']; ?><i></i><b> Whatsapp:</b><?php echo $datos['cel1_us']." ".$datos['cel2_us']; ?><b> Correo: </b><?php echo $datos['correo_us'] ?></div>
                                                <a class="btn btn-success" href=""><i></i>Contactar</a>
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
    <script src="js/bootstrap/bootstrap.min.js"></script>
    <script src="js/methods/scripts.js"></script>
    <script src="js/methods/imagenes.js"></script>   
    <?php include "registro_cli.php"; ?>
</body>
</html> 