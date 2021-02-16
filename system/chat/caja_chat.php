<?php

session_start();
	require_once '../../resuorces/config/database.php';
    ///consultamos a la base
    $cliente = $_SESSION['cliente'];
    $usuario = $_SESSION['id'];
    function formatearFecha($fecha){
        return date('g:i a', strtotime($fecha));
    }
	$sql = mysqli_query($conn, "SELECT u.nom_us, ch.mensaje_cli, c.nom_cli, c.ape_cli, u.app_us,ch.mensaje_us, ch.fecha_hora FROM chat as ch INNER JOIN cliente as c ON c.id_cli=ch.id_cli INNER JOIN usuario as u ON u.id_us=ch.id_us WHERE ch.id_us='$usuario' AND ch.id_cli='$cliente' ORDER BY (ch.id_chat) ASC"); 
	while($fila = mysqli_fetch_array($sql)){ 
    ?>
    <!-- <link rel="stylesheet" href="../css/bootstrap/bootstrap.min.css"> -->
    <link rel="stylesheet" href="../css/chat.css">
	<div id="datos-chat">
        <!-- usuario -->
        <?php if($fila['mensaje_cli']==""){ ?>
        <div class="row border" id="chat2">
    		<span id="usuario" style="color: red;" class="float-left"><b><?php echo $fila['nom_us']." ".$fila['app_us']; ?></b></span>
	    	<span id="mensaje" style="margin-left: 35px;"><?php echo $fila['mensaje_us']; ?></span>
		    <span id="hora" style="margin-left: 35px;" class="float-right"><b><?php echo formatearFecha($fila['fecha_hora']); ?></b></span>
        </div>
        <?php } ?>
        <?php if($fila['mensaje_us']==""){ ?> 
        <!-- cliente -->
        <div class="row border" id="chat2">
            <span id="cliente" style="color: green;" class="float-left"><b><?php echo $fila['nom_cli']." ".$fila['ape_cli']; ?></b></span>
            <span id="mensaje" style="margin-left: 35px;"><?php echo $fila['mensaje_cli']; ?></span>
            <span id="hora" class="float-rigth" style="margin-left: 35px;"><b><?php echo formatearFecha($fila['fecha_hora']); ?></b></span>
        </div>
        <?php } ?>
	</div>
	
    <?php } ?>
    