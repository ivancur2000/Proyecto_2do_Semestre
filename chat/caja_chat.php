<?php
session_start();
	require_once '../resuorces/config/database.php';
    ///consultamos a la base
    $cliente = $_SESSION['id_cli'];
    $usuario = $_SESSION['usuario'];
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
        <div class="row" id="chat2">
    		<span id="usuario" class="float-left"><b><?php echo $fila['nom_us']." ".$fila['app_us']; ?></b></span>
	    	<span id="mensaje"><?php echo $fila['mensaje_us']; ?></span>
		    <span id="hora" class="float-right"><?php echo formatearFecha($fila['fecha_hora']); ?></span>
        </div>
        <?php } ?>
        <?php if($fila['mensaje_us']==""){ ?>
        <!-- cliente -->
        <div class="row" id="chat2">
            <span id="cliente" class="float-left"><b><?php echo $fila['nom_cli']." ".$fila['ape_cli']; ?></b></span>
            <span id="mensaje"><?php echo $fila['mensaje_cli']; ?></span>
            <span id="hora" class="float-left"><?php echo formatearFecha($fila['fecha_hora']); ?></span>
        </div>
        <?php } ?>
	</div>
	
    <?php } ?>
    