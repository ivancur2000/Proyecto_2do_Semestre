
   
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700" rel="stylesheet" type="text/css" />
    <script type="text/javascript">
      function validarForm(formulario) 
      {
          if(formulario.busqueda.value.length==0) 
          { //¿Tiene 0 caracteres?
              formulario.busqueda.focus();  // Damos el foco al control
              return false; 
          } //devolvemos el foco  
          return true; //Si ha llegado hasta aquí, es que todo es correcto 
      }   
</script>
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/navbar.css" rel="stylesheet" />
    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
        <div class="container">
            <a class="navbar-brand js-scroll-trigger" href="#page-top">Yolita.SRL</a><button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">Menu<i class="fas fa-bars ml-1"></i></button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav text-uppercase ml-auto">
                    <li class="nav-item"><a class="nav-link js-scroll-trigger" href="#misionVision">Misión Visión</a></li>
                    <li class="nav-item"><a class="nav-link js-scroll-trigger" href="#historia">Quiénes somos</a></li>
                    <li class="nav-item"><a class="nav-link js-scroll-trigger" href="#prox_proy">Próximos Proyectos</a></li>
                    <li class="nav-item"><a class="nav-link js-scroll-trigger" href="#prox_ent">Proyectos Entregados</a></li>
                    <?php
                    if(isset($_SESSION['nom_cli']))
                    { 
                    ?>
                      <ul class="navbar-nav ">
                        <li class="nav-item dropdown">
                          <a class="nav-link dropdown-toggle js-scroll-trigger" role="button" data-toggle="dropdown">
                            <?php if(isset($_SESSION['nom_cli']) && isset($_SESSION['ape_cli']))
                            {
                              echo $_SESSION['nom_cli']." ".$_SESSION['ape_cli']; 
                            }
                          ?></a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="perfil.php">Ver Perfil</a>
                            <div class="dropdown-divider"></div>
                            
                            <a class="dropdown-item" href="resuorces/config/desloguear.php">Cerrar Secion</a>
                            </li>
                      </ul>
                      
                     <?php
                    }else
                    {
                    ?>
                    <li class="nav-item"><a class="nav-link js-scroll-trigger" href="login.php">Ingresar</a></li>
                    <li class="nav-item"><a class="btn btn-warning"  data-toggle="modal" href="#registro"><b>REGÍSTRARSE</b> </a></li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Masthead-->
    <header class="masthead">
      <div class="container">
          <div class="masthead-subheading">Todo sobre inmuebles</div>
          <form action="busqueda.php" method="POST" onSubmit="return validarForm(this)">
            <div class="masthead-subheading text-uppercase">
                <!-- Search form -->
                <div class="md-form mt-5">
                  <input class="form-control" name="busqueda" type="text" placeholder="Zona, tipo de inmueble, edifico" aria-label="Search">
                </div>
            </div>
            <button type="submit" name="tb_buscar" class="btn btn-primary btn-xl text-uppercase js-scroll-trigger">Buscar</button>
          </form>
      </div>
    </header>