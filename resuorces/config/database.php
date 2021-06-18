<?php
//conexion a la base de datos
$server="localhost";
$username="root";
$password="";
$database="turismo";

	$conn=@mysqli_connect($server,$username,$password,$database);
	if(!$conn){
		echo 'Error de conexion';
	}
?>