<?php 
session_start();
$titulo = "Actualizacion de tamaños"; 
$ubicacion = "Tamaños";
require_once '../../resuorces/config/database.php';
//modificaciones
if(!empty($_POST))
{
    $id_tam = $_POST['id'];
    $desc = $_POST['tb_tam'];
    $room = $_POST['tb_cuartos'];
   
    $mod = "UPDATE tamaño SET descrip_tam = '$desc', num_cuartos = '$room' WHERE id_tamaño = '$id_tam'";
    if(mysqli_query($conn,$mod))
    {
        $alert = 'Modificacion Exitosa';
        header('refresh:1; url=tam_lista.php');
    }else
    {
        $alert = "Ocurrio un error inesperado";
    }

}
if(empty($_GET['id_mod']))
{
	header('refresh:1; url=tam_lista.php');
}else
{
	$id=$_GET['id_mod'];
	// consulta para precargar datos
	$comand = mysqli_query($conn, "SELECT * FROM tamaño WHERE id_tamaño = '$id' AND est_tam = '1'");
	$fila = mysqli_num_rows($comand);
	if($fila == 0)
	{
		header('refresh:1;url=tam_lista.php');
	}else
	{
		//carga de datos al formulario
		while($vector=mysqli_fetch_array($comand))
		{
			//datos obtenidos del usuario
            $tam = $vector['descrip_tam'];
            $cuartos = $vector['num_cuartos'];
		}
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tamaño</title>
    <link rel="stylesheet" href="../../css/style.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<?php include "../sidebar/sidebar.php"; ?> 
    <div class="card card-dark">
        <!-- alta de la tabla -->
        <a href="tam_lista.php" class="btn btn-danger btn-block">Atras</a><br>
        <div class="card-header">
            <h4 >Todos los campos son obligatorios</h4>   
        </div> 
        <form action="tam_mod.php" id="formulario" onSubmit="return validar_clave()" method="POST">
        <input type="hidden" name="id" value="<?php if(isset($id)){ echo $id; } ?>">
            <div class="card-body">
                <!--tamaño-->
                <div class="form-group">
                    <label for="tam">Tamaño del inmueble</label>
                    <input type="text" class="form-control" placeholder="Tamaño en metros cuadrados" onkeypress="return soloNumeros(event)" name="tb_tam" id="tam" value="<?php if(isset($tam)){ echo $tam; } ?>">
                </div>
                <!--numero de cuartos-->
                <div class="form-group">
                    <label for="cuartos">Numero de cuartos</label>
                    <input type="number" class="form-control" placeholder="Numero de cuartos" name="tb_cuartos" id="cuartos" onkeypress="return soloNumeros(event)" value="<?php if(isset($cuartos)){ echo $cuartos; } ?>">
                </div>
            </div>
            <div class="card-footer">
                <input id="boton" type="submit" class="btn btn-success btn-block" value="Modificar" name="btn_reg">
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

