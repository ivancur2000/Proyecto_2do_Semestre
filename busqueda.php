<?php 
require_once 'resuorces/config/database.php';
session_start();   
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yolita.SRL</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/estilo.css">
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
<!-- saltos de linea para poder ver el contenido -->
       
    <br><br><br><br>
    <br>
     <!-- resultados de la busqueda -->
    <div class="container" id="contenedor" style="background: #ffff; width: 75%;">
        <div class="text-center">
            <h2 class="section-heading text-uppercase">Resultados de la búsqueda</h2>
        </div>
        <div class="row">
            <?php
            $busqueda=$_POST['busqueda'];
            $sql = mysqli_query($conn,"SELECT i.id_inmueble, i.habitaciones, i.cocinas, i.baños, i.garaje, i.posicion, i.descripcion, img.img as imagen, e.zona_ed, ti.nombre_tipo FROM inmueble as i INNER JOIN imagenes as img ON img.id_inmueble = i.id_inmueble INNER JOIN edificio as e ON e.id_ed = i.id_edificio INNER JOIN tipo_inmueble as ti ON ti.id_tipo = i.id_tipo WHERE i.est_inm = 1 AND i.est_inm = 2 OR ti.nombre_tipo LIKE '%$busqueda%' OR e.zona_ed LIKE '%$busqueda%' GROUP BY i.id_inmueble");
            $resultado = mysqli_num_rows($sql);
            if($resultado > 0)
            {
                while($data=mysqli_fetch_array($sql))
                {
            ?>
            <div class="col-lg-4 col-sm-6 mb-4">
                <div class="portfolio-item">
                    <ul class="list-inline">
                        <li>
                            <a class="portfolio-link" href="vista_inmu.php?id=<?php echo $data['id_inmueble'];?>">
                                <img class="img-fluid" onmouseout="this.src='img/inmuebles/<?php echo $data['imagen']; ?>';" onmouseover="this.src='img/inmuebles/cover.png';" id="imagenes" src="img/inmuebles/<?php echo $data['imagen']; ?>" style=" width:300px; height: 300px;" alt="foto departamento"/>
                            </a>
                            <div class="portfolio-caption">
                                <div class="portfolio-caption-heading"><?php echo $data['descripcion']; ?></div>
                                <div class="portfolio-caption-subheading text-muted">Zona: <?php echo $data['zona_ed']."<br>"." Tipo: ".$data['nombre_tipo'];  ?></div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <?php    
                }
            }else
            {
                $query = mysqli_query($conn, "SELECT e.id_ed, e.nombre_ed, e.descripcion, e.zona_ed, i.img FROM edificio as e INNER JOIN imagenes as i ON i.id_ed = e.id_ed where e.nombre_ed LIKE '%$busqueda%' GROUP BY e.descripcion");
                $filas= mysqli_num_rows($query);
                if($filas > 0)
                {
                    while ($edi = mysqli_fetch_array($query))
                    {
                    ?>
                        <div class="col-lg-4 col-sm-6 mb-4">
                            <div class="portfolio-item">
                                <a class="portfolio-link" href="vista_ed.php?id=<?php echo $edi['id_ed'];?>">
                                    <img class="img-fluid" onmouseout="this.src='img/edificios/<?php echo $edi['img']; ?>';" onmouseover="this.src='img/inmuebles/cover.png';" id="imagenes" src="img/edificios/<?php echo $edi['img']; ?>" style=" width:300px; height: 300px;" alt="foto edificio"/>
                                </a>
                                <div class="portfolio-caption">
                                    <div class="portfolio-caption-heading"><?php echo $edi['nombre_ed']; ?></div>
                                    <div class="portfolio-caption-subheading text-muted"><?php echo $edi['descripcion'];  ?></div>
                                </div>
                            </div>
                        </div>
                    <?php    
                    }
                }else
                {
                    echo "<div>No se encontraron resultados</div>";
                }
            }
            ?>
        </div>
    </div>
    
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
    <script laguage="Javascript">
    $(document).ready(function(){
		var tipo = $('#tipo'),
            zona = $('#zona'),
            dormitorio = $('#dormitorio'),
            bano = $('#bano'),
            garaje = $('#garaje'),
            posicion = $('#posicion'),
            elementos = $('ul li div a');
            $(elementos).each(function(){
			var li = $(this);
			//si presionamos la tecla
			$(tipo).keyup(function(){
				
				//ocultamos toda la lista
				$(li).parent().hide();
				//valor del h3
				var txt = $(this).val();
				//si hay coincidencias en la búsqueda cambiando a minusculas
				if($(li).text().toLowerCase().indexOf(txt) > -1){
					//mostramos las listas que coincidan
					$(li).parent().show();
				}
			});
		});
    });
    </script>
    <!-- jquery -->
    <script src="js/jquery/jquery.js"></script>
    <!-- bootstrap -->
    <script src="js/bootstrap/bootstrap.bundle.js"></script>
    <script src="js/bootstrap/bootstrap.min.js"></script>
    <script src="js/methods/scripts.js"></script>
    <!-- formulario de registro de clientes -->
    <?php include "registro_cli.php"; ?>
</body>
</html>