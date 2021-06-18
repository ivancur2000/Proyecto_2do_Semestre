<?php 
session_start();
require_once 'resuorces/config/database.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Turismo Bolivia</title>
    <link rel="canonical" href="https://ge  tbootstrap.com/docs/4.0/examples/carousel/">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://kit.fontawesome.com/5e53af518b.js" crossorigin="anonymous"></script>    
</head>
<body id="page-top">
    <!-- barra de navegacion -->
    <?php include "incluide/navbar.php"; ?>
<!-- acá va el contenido de la pagina -->
    <section class="page-section" id="MisionVision">
        <div class="container">
            <div class="text-center">
                <h2 class="section-heading text-uppercase">Misión-Visión</h2>
            </div>
            <div class="row text-center">
                <div class="col-md-6">
                <img src="img/mision2.jpg" height="250" alt="">
                    <!--<span class="fa-stack fa-4x"><i class="fas fa-circle fa-stack-2x text-primary"></i><i class="fas fa-shopping-cart fa-stack-1x fa-inverse"></i></span>-->
                    <h4 class="my-3">Misión</h4>
                    <p class="text-muted">Contribuir a que tu experiencia conociendo el país sea gratificante y maravillosa, ayudarte a lograr visitar todos los lugares posibles durante tu estadía.</p>
                </div>
                <div class="col-md-6">
                <img src="img/vision2.jpg" width="450" height="250" alt="">
                    <!--<span class="fa-stack fa-4x"><i class="fas fa-circle fa-stack-2x text-primary"></i><i class="fas fa-laptop fa-stack-1x fa-inverse"></i></span>-->
                    <h4 class="my-3">Visión</h4>
                    <p class="text-muted">Llegar a todas las personas interesadas en conocer sobre las costumbres, culturas, actividades recreativas del país y fomentar el cuidado de nuestro ecosistema.</p>
                </div>
            </div>
        </div>
    </section>
    <!-- destinos turísticos más vistados-->
    <section class="page-section" id="Destinos">
        <div class="container">
            <div class="text-center">
                <h2 class="section-heading text-uppercase">Destinos Turísticos más visitados</h2>
            </div>
            <ul class="timeline">
                <li>
                    <div class="timeline-image"><img class="rounded-circle img-fluid" src="assets/img/about/1.jpg" alt="" /></div>
                    <div class="timeline-panel">
                        <div class="timeline-heading">
                            <h4>2018</h4>
                            <h4 class="subheading">Salar de Uyuni</h4>
                        </div>
                        <div class="timeline-body"><p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sunt ut voluptatum eius sapiente, totam reiciendis temporibus qui quibusdam, recusandae sit vero unde, sed, incidunt et ea quo dolore laudantium consectetur!</p></div>
                    </div>
                </li>
                <li class="timeline-inverted">
                    <div class="timeline-image"><img class="rounded-circle img-fluid" src="assets/img/about/2.jpg" alt="" /></div>
                    <div class="timeline-panel">
                        <div class="timeline-heading">
                            <h4>2019</h4>
                            <h4 class="subheading">Parque Nacional Madidi</h4>
                        </div>
                        <div class="timeline-body"><p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sunt ut voluptatum eius sapiente, totam reiciendis temporibus qui quibusdam, recusandae sit vero unde, sed, incidunt et ea quo dolore laudantium consectetur!</p></div>
                    </div>
                </li>
                <li>
                    <div class="timeline-image"><img class="rounded-circle img-fluid" src="assets/img/about/3.jpg" alt="" /></div>
                    <div class="timeline-panel">
                        <div class="timeline-heading">
                            <h4> 2020</h4>
                            <h4 class="subheading">Lago Titicaca</h4>
                        </div>
                        <div class="timeline-body"><p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sunt ut voluptatum eius sapiente, totam reiciendis temporibus qui quibusdam, recusandae sit vero unde, sed, incidunt et ea quo dolore laudantium consectetur!</p></div>
                    </div>
                </li>
                <li class="timeline-inverted">
                    <div class="timeline-image"><img class="rounded-circle img-fluid" src="assets/img/about/4.jpg" alt="" /></div>
                    <div class="timeline-panel">
                        <div class="timeline-heading">
                            <h4>2021</h4>
                            <h4 class="subheading">Parque Nacional Sajama</h4>
                        </div>
                        <div class="timeline-body"><p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sunt ut voluptatum eius sapiente, totam reiciendis temporibus qui quibusdam, recusandae sit vero unde, sed, incidunt et ea quo dolore laudantium consectetur!</p></div>
                    </div>
                </li>
                <li class="timeline-inverted">
                    <div class="timeline-image">
                        <h4>Animate <br />a vivir<br />una aventura</h4>
                    </div>
                </li>
            </ul>
        </div>
    </section>
        <!-- hoteles de bolivia-->
        
        <section class="page-section bg-light" id="Hoteles">
        <div class="container">
            <div class="text-center">
                <h2 class="section-heading text-uppercase">Hoteles</h2>
                <h3 class="section-subheading text-muted">Ambientes donde podrás descansar</h3>
            <div class="row">
                <?php 
                require_once 'resuorces/config/database.php';
                $sql = mysqli_query($conn, "SELECT e.id_ed, e.nombre_ed, e.descripcion, i.img FROM edificio as e INNER JOIN imagenes as i ON i.id_ed=e.id_ed WHERE e.est_ed = 2 GROUP BY e.nombre_ed");
                while ($edificio = mysqli_fetch_array($sql)) {
                ?>
                <div class="col-lg-4 col-sm-6 mb-4">
                    <div class="portfolio-item">
                        <a class="portfolio-link" href="vista_ed.php?id=<?php echo $edificio['id_ed']; ?>">
                            <img class="img-fluid" style=" width: 350px; height: 550px;" src="img/edificios/<?php echo $edificio['img']; ?>" alt=""/>
                        </a>
                        <div class="portfolio-caption">
                            <div class="portfolio-caption-heading"><?php echo $edificio['nombre_ed']; ?></div>
                            <div class="portfolio-caption-subheading text-muted"><?php echo $edificio['descripcion']; ?></div>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </section>
    <!-- restaurantes en bolivia -->
    <section class="page-section bg-light" id="Gastronomia">
        <div class="container">
            <div class="text-center">
                <h2 class="section-heading text-uppercase">Gastronomía</h2>
                <h3 class="section-subheading text-muted">Degusta nuestra comida nacional</h3>
            </div>
            <div class="row">
                <?php 
                require_once 'resuorces/config/database.php';
                $sql = mysqli_query($conn, "SELECT e.id_ed, e.nombre_ed, e.descripcion, i.img FROM edificio as e INNER JOIN imagenes as i ON i.id_ed=e.id_ed WHERE e.est_ed = 1 GROUP BY e.nombre_ed");
                while ($edificio = mysqli_fetch_array($sql)) {
                ?>
                <div class="col-lg-4 col-sm-6 mb-4">
                    <div class="portfolio-item">
                        <a class="portfolio-link" href="vista_ed.php?id=<?php echo $edificio['id_ed']; ?>">
                            <img class="img-fluid" style=" width: 350px; height: 550px;" src="img/edificios/<?php echo $edificio['img']; ?>" alt=""/>
                        </a>
                        <div class="portfolio-caption">
                            <div class="portfolio-caption-heading"><?php echo $edificio['nombre_ed']; ?></div>
                            <div class="portfolio-caption-subheading text-muted"><?php echo $edificio['descripcion']; ?></div>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </section>
    <!-- clientes destacados o famosos-->
    <!-- Footer-->
    <footer class="footer py-4">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-4 text-lg-left">Derechos de autor © Manuel Jimenez</div>
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
<!-- formulario de registro en modal -->    
<?php include "registro_cli.php"; ?>
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
                    echo '<div class="alert">'.$alert.'</div><META HTTP-EQUIV="REFRESH" CONTENT="2;URL=index.php">';    
                }
                ?>
            </div>
            <div class="modal-footer">
                <a href="#" data-dismiss="modal" class="btn btn-danger">Cerrar</a>
            </div>
        </div>
    </div>
</div>
</body>
</html>