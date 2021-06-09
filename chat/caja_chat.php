<?php
session_start();
	require_once '../resuorces/config/database.php';
    ///consultamos a la base
    $cliente = $_SESSION['id'];
    $usuario = $_SESSION['usuario'];
    function formatearFecha($fecha){
        return date('g:i a', strtotime($fecha));
    }
    $sql = mysqli_query($conn, "CALL mostrarChat('$usuario','$cliente')");
	while($fila = mysqli_fetch_array($sql)){ 
    ?>
    <!-- <link rel="stylesheet" href="../css/bootstrap/bootstrap.min.css"> -->
    <link rel="stylesheet" href="../css/chat.css">
	<div id="datos-chat">
        <!-- usuario -->
        <?php if($fila['mensajeCli']==""){ ?>
        <div class="row" id="chat2">
	    	<span class="user"id="mensajeUs"><?php echo $fila['mensajeUs']; ?></span>
		    <span id="hora" class="float-right"><?php echo formatearFecha($fila['fechaHora']); ?></span>
        </div>
        <?php } ?>
        <?php if($fila['mensajeUs']==""){ ?>
        <!-- cliente -->
        <div class="row" id="chat2">
            <span class="cli" style="color: green" id="mensajeCli"><?php echo $fila['mensajeCli']; ?></span>
            <span id="hora" class="float-left"><?php echo formatearFecha($fila['fechaHora']); ?></span>
        </div>
        <?php } ?>
	</div>
	
    <?php } ?>
    