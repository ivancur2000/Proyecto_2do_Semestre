<?php
session_start();
$titulo = "Actualizacion de Cargos"; 
$ubicacion = "Cargos";
//conexion a la base de datos
require_once '../../resuorces/config/database.php';
if(!empty($_POST))
{
    //datos del metodo post
    $id_cargo = $_POST['id_car'];
    $name = $_POST['tb_name'];
    $cod = $_POST['tb_cod'];
    
    //mod de la tabla cargo
    $mod = "UPDATE cargo SET nom_cargo = '$name', cod_cargo = '$cod' WHERE id_cargo = '$id_cargo'";
    if(mysqli_query($conn, $mod))
    {
        $alert = 'Modificacion exitosa';
        header('refresh:2; url=cargo_alta.php');
    }else
    {
        $alert = 'Ocurrio un error inesperado';
    }
    
}
//
if(empty($_GET['id_car']))
{
   header('refresh:2; url= cargo_lista.php'); 
}else
{
	$id=$_GET['id_car'];
	// consulta para precargar los datos del id del cargo y validacion si esta eliminado
	$comand = mysqli_query($conn, "SELECT * FROM cargo WHERE est_cargo = '1' AND id_cargo = '$id'");
	$fila = mysqli_num_rows($comand);
	if($fila == 0)
	{
		header('refresh:1;url=lista_us.php');
	}else
	{
        while ($data = mysqli_fetch_array($comand)) 
        {
            $nombre = $data['nom_cargo'];
            $codigo = $data['cod_cargo'];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cargos</title>
    <link rel="stylesheet" href="../../css/style.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<?php include "../sidebar/sidebar.php"; ?> 
    <div class="card card-dark  ">
        <a href="cargo_lista.php" class="btn btn-danger btn-block">Atras</a><br>
    <div class="card-header">
        <h3 class="card-title">Todos los campos son oblogatorios</h3>
    </div>
    <form action="cargo_mod.php" id="formulario" onSubmit="return validar_clave()" method="POST">
        <input type="hidden" name="id_car" value="<?php echo $id; ?>">
        <div class="card-body">
            <!-- Nombre del cargo -->
            <div class="form-group">
                <label for="name">Nombre del cargo:</label>
                <input type="text" name="tb_name" id="name" onkeypress="return validar(event)" class="form-control" placeholder="Nombre del cargo" value = "<?php if(isset($nombre)){ echo $nombre; } ?>">
            </div>
            <!-- siglas del cargo -->
            <div class="form-group">
                <label for="cod">Codigo:</label>
                <input type="text" name="tb_cod" id="cod" onkeypress="return validar(event)" class="form-control" placeholder="Codigo del cargo" value = "<?php if(isset($codigo)){ echo $codigo; } ?>">
            </div>
        </div>
        <div class="card-footer">
            <input id="boton" type="submit" class="btn btn-success btn-block" value="Modificar" name="btn_registrar">
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

