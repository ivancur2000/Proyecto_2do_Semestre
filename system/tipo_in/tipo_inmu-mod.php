<?php 
session_start();
$titulo = "Actualizacion de tipos de inmueble"; 
$ubicacion = "Tipos de inmueble";
require_once '../../resuorces/config/database.php';
//modificaciones
if(!empty($_POST))
{
    $tipo = $_POST['tb_name'];
    $id_tipo = $_POST['id_t'];
    $mod = "UPDATE tipo_inmueble SET nombre_tipo = '$tipo' WHERE id_tipo = '$id_tipo'";
    if(mysqli_query($conn,$mod))
    {
        $alert = 'Modificacion Exitosa';
        header('refresh:1; url=tipo_inmu_lista.php');
    }else
    {
        $alert = 'Ocurrio un error inesperado';
    }
}
if(empty($_GET['id_mod']))
{
	header('refresh:1; url=tipo_inmu_lista.php');
}else
{
	$id=$_GET['id_mod'];
	// consulta para precargar datos
	$comand = mysqli_query($conn, "SELECT * FROM tipo_inmueble WHERE id_tipo = '$id' AND est_tipo = '1'");
	$fila = mysqli_num_rows($comand);
	if($fila == 0)
	{
		header('refresh:1;url=tipo_inmu_lista.php');
	}else
	{
		//carga de datos al formulario
		while($vector=mysqli_fetch_array($comand))
		{
			//datos obtenidos del usuario
			$nombre=$vector['nombre_tipo'];
		}
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tipo de inmueble</title>
    <link rel="stylesheet" href="../../css/style.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<?php include "../sidebar/sidebar.php"; ?> 
    <div class="card card-dark">
        <!-- alta de la tabla -->
        <a href="tipo_inmu_lista.php" class="btn btn-danger btn-block">Atras</a><br>
        <div class="card-header">
            <h4 >Todos los campos son obligatorios</h4>   
        </div> 
        <form action="tipo_inmu-mod.php" method="POST" id="formulario" onSubmit="return validar_clave()">
            <input type="hidden" name="id_t" value="<?php if(isset($id)){ echo $id;} ?>">
            <div class="card-body">
            <!--nombre-->
                <div class="form-group">
                    <label for="tipo">Tipo de inmueble</label>
                    <input type="text" name="tb_name" id="tipo" class="form-control" placeholder="Tipo de inmueble" onkeypress="return validar(event)" value="<?php if(isset($nombre)){ echo $nombre;} ?>">
                </div>
            </div>
            <div class="card-footer">
                <input id="boton" type="submit" class="btn btn-success btn-block" value="Actualizar" name="btn_reg">
				<input type="reset" class="btn btn-danger btn-block" value="Cancelar">
            </div>
        </form>
    </div>
    <?php include "../sidebar/sidebar2.php"; ?>
	<?php include "../modal_alerta/alert.php"; ?>
	<!-- jquery-validation -->
	<script src="../adminlte/plugins/jquery-validation/jquery.validate.min.js"></script>
	<script src="../adminlte/plugins/jquery-validation/additional-methods.min.js"></script>
	<script src="../../js/methods/validar.js"></script>
</body>
</html>

