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
<nav class="navbar navbar-expand-lg navbar-dark fixed-top" style="background: #212529;" id="mainNav">
    <div class="container">
        <a class="navbar-brand js-scroll-trigger" href="index.php">TURISBO</a><button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">Menú<i class="fas fa-bars ml-1"></i></button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav text-uppercase ml-auto">
                <div class="masthead-subheading text-uppercase">
                    <!-- Search form -->
                    <form action="busqueda.php" method="POST" onSubmit="return validarForm(this)">
                        <input class="form-control" name="busqueda" type="text" placeholder="Departamentos, Lugares Turisticos" aria-label="Search">  
                </div>
                        <button type="submit" name="tb_buscar" class="btn btn-primary text-uppercase js-scroll-trigger">Buscar</button>
                    </form>
            </ul>
            <ul class="navbar-nav text-uppercase ml-auto">
            <?php
            if(isset($_SESSION['name']))
            { 
            ?>
                <ul class="navbar-nav ">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle js-scroll-trigger" role="button" data-toggle="dropdown">
                    <?php if(isset($_SESSION['name']) && isset($_SESSION['app']))
                    {
                        echo $_SESSION['name']." ".$_SESSION['app']; 
                    }
                    ?></a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="perfil.php">Ver Perfil</a>
                    <div class="dropdown-divider"></div>
                    
                    <a class="dropdown-item" href="resuorces/config/desloguear.php">Cerrar Sesión</a>
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
