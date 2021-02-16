<?php 
require_once 'resuorces/config/database.php';
$id_mes=$_POST['mes'];
$interes = mysqli_query($conn, "SELECT interes FROM plan_pago WHERE id_pp = '$id_mes'");
$vector = mysqli_fetch_array($interes);
$int = $vector['interes'];

	$cadena='<div class="form-group col"><label for="interes">Interes(%)</label>
                <input type="number" id="interes"  class="form-control" value="'.$int.'"disabled>
            </div>';
    echo $cadena; 
?> 