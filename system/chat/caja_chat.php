<?php

session_start();
	require_once '../../resuorces/config/database.php';
    ///consultamos a la base
    $cliente = $_SESSION['cliente'];
    $usuario = $_SESSION['id'];
    function formatearFecha($fecha){
        return date('g:i a', strtotime($fecha));
    }
	$sql = mysqli_query($conn, "CALL mostrarChat('$usuario', '$cliente')"); 
	while($fila = mysqli_fetch_array($sql)){ 
    ?>
    <!-- <link rel="stylesheet" href="../css/bootstrap/bootstrap.min.css"> -->
    <link rel="stylesheet" href="../css/chat.css">
	<div id="datos-chat">
        <!-- usuario -->
        <?php if($fila['mensajeCli']==""){ ?>
        <div class="row border" id="chat2">
    		<span id="usuario" style="color: red;" class="float-left"><b><?php echo $fila['nombreUsuario']; ?></b></span>
	    	<span id="mensaje" style="margin-left: 35px;"><?php echo $fila['mensajeUs']; ?></span>
		    <span id="hora" style="margin-left: 35px;" class="float-right"><b><?php echo formatearFecha($fila['fechaHora']); ?></b></span>
        </div>
        <?php } ?>
        <?php if($fila['mensajeUs']==""){ ?> 
        <!-- cliente -->
        <div class="row border" id="chat2">
            <span id="cliente" style="color: green;" class="float-left"><b><?php echo $fila['nombreUsuario']; ?></b></span>
            <span id="mensaje" style="margin-left: 35px;"><?php echo $fila['mensajeCli']; ?></span>
            <span id="hora" class="float-rigth" style="margin-left: 35px;"><b><?php echo formatearFecha($fila['fechaHora']); ?></b></span>
        </div>
        <?php } ?>
	</div>
	
    <?php } ?>
    