<?php 
session_start();
require_once 'resuorces/config/database.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yolita.SRL</title>
    <link rel="canonical" href="https://ge  tbootstrap.com/docs/4.0/examples/carousel/">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://kit.fontawesome.com/5e53af518b.js" crossorigin="anonymous"></script>    
</head>
<body id="page-top">
    <!-- barra de navegacion -->
    <?php include "incluide/navbar.php"; ?>
<!-- aca va el contenido de la pagina -->
    <section class="page-section" id="misionVision">
        <div class="container">
            <div class="text-center">
                <h2 class="section-heading text-uppercase">Visión-Misión</h2>
            </div>
            <div class="row text-center">
                <div class="col-md-6">
                    <span class="fa-stack fa-4x"><i class="fas fa-circle fa-stack-2x text-primary"></i><i class="fas fa-shopping-cart fa-stack-1x fa-inverse"></i></span>
                    <h4 class="my-3">Misión</h4>
                    <p class="text-muted">Lorem ipsum dolor sit amet consectetur adipisicing elit. Possimus, perspiciatis. Animi laboriosam, vitae nisi quas esse id ipsam consectetur cum impedit ipsa minima necessitatibus blanditiis quisquam, veniam suscipit! Ipsam repellat minus quod voluptas fugit, autem veniam maiores praesentium dolorum dignissimos vel error itaque sint ducimus dicta, blanditiis laudantium illo doloribus.</p>
                </div>
                <div class="col-md-6">
                    <span class="fa-stack fa-4x"><i class="fas fa-circle fa-stack-2x text-primary"></i><i class="fas fa-laptop fa-stack-1x fa-inverse"></i></span>
                    <h4 class="my-3">Visión</h4>
                    <p class="text-muted">Lorem ipsum dolor sit amet consectetur adipisicing elit. Amet doloribus sed quidem similique, nulla earum at illo facere ducimus sit aspernatur debitis repudiandae itaque eligendi? Nesciunt eligendi facere natus commodi!.</p>
                </div>
            </div>
        </div>
    </section>
    <!-- historia de la empresa-->
    <section class="page-section" id="historia">
        <div class="container">
            <div class="text-center">
                <h2 class="section-heading text-uppercase">Historia de la empresa</h2>
            </div>
            <ul class="timeline">
                <li>
                    <div class="timeline-image"><img class="rounded-circle img-fluid" src="assets/img/about/1.jpg" alt="" /></div>
                    <div class="timeline-panel">
                        <div class="timeline-heading">
                            <h4>2009-2011</h4>
                            <h4 class="subheading">Fundación de YOLITA.SRL</h4>
                        </div>
                        <div class="timeline-body"><p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sunt ut voluptatum eius sapiente, totam reiciendis temporibus qui quibusdam, recusandae sit vero unde, sed, incidunt et ea quo dolore laudantium consectetur!</p></div>
                    </div>
                </li>
                <li class="timeline-inverted">
                    <div class="timeline-image"><img class="rounded-circle img-fluid" src="assets/img/about/2.jpg" alt="" /></div>
                    <div class="timeline-panel">
                        <div class="timeline-heading">
                            <h4>2011</h4>
                            <h4 class="subheading">Construción de su primer edificio</h4>
                        </div>
                        <div class="timeline-body"><p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sunt ut voluptatum eius sapiente, totam reiciendis temporibus qui quibusdam, recusandae sit vero unde, sed, incidunt et ea quo dolore laudantium consectetur!</p></div>
                    </div>
                </li>
                <li>
                    <div class="timeline-image"><img class="rounded-circle img-fluid" src="assets/img/about/3.jpg" alt="" /></div>
                    <div class="timeline-panel">
                        <div class="timeline-heading">
                            <h4> 2012</h4>
                            <h4 class="subheading">Siguente edificio</h4>
                        </div>
                        <div class="timeline-body"><p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sunt ut voluptatum eius sapiente, totam reiciendis temporibus qui quibusdam, recusandae sit vero unde, sed, incidunt et ea quo dolore laudantium consectetur!</p></div>
                    </div>
                </li>
                <li class="timeline-inverted">
                    <div class="timeline-image"><img class="rounded-circle img-fluid" src="assets/img/about/4.jpg" alt="" /></div>
                    <div class="timeline-panel">
                        <div class="timeline-heading">
                            <h4>2014</h4>
                            <h4 class="subheading">El tercero</h4>
                        </div>
                        <div class="timeline-body"><p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sunt ut voluptatum eius sapiente, totam reiciendis temporibus qui quibusdam, recusandae sit vero unde, sed, incidunt et ea quo dolore laudantium consectetur!</p></div>
                    </div>
                </li>
                <li class="timeline-inverted">
                    <div class="timeline-image">
                        <h4>Se parte <br />de esta<br />familia</h4>
                    </div>
                </li>
            </ul>
        </div>
    </section>
        <!-- Proyectos futuros de la empresa-->
        
        <section class="page-section bg-light" id="prox_proy">
        <div class="container">
            <div class="text-center">
                <h2 class="section-heading text-uppercase">Próximos Proyectos</h2>
                <h3 class="section-subheading text-muted">Nuestra Familia sigue creciendo</h3>
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
    <!-- proyecto acabados de la empresa -->
    <section class="page-section bg-light" id="prox_ent">
        <div class="container">
            <div class="text-center">
                <h2 class="section-heading text-uppercase">Proyectos Entregados</h2>
                <h3 class="section-subheading text-muted">Las mejores ofertas en el mercado</h3>
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
                <div class="col-lg-4 text-lg-left">Derechos de autor © Yolita.SRL 2020</div>
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