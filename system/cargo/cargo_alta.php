<?php
session_start();
$titulo = "Registro de Cargos"; 
$ubicacion = "Cargos";
//conexion a la base de datos
require_once '../../resuorces/config/database.php';
if(!empty($_POST))
{
    //datos del metodo post
    $name = $_POST['tb_name'];
    $cod = $_POST['tb_cod'];
    //consulta para saber si el cargo ya existe
    $sql = mysqli_query($conn, "SELECT * FROM cargo WHERE cod_cargo = '$cod'");
    $resultado = mysqli_num_rows($sql);
    if($resultado != 0)
    {
        $alert = 'El cargo que intenta registrar ya existe, intente con otro por favor';
    }else
    {
        //alta de la tabla cargo
        $alta = "INSERT INTO cargo (nom_cargo, cod_cargo, est_cargo) VALUES ('$name', '$cod', '1')";
        if(mysqli_query($conn, $alta))
        {
            $alert = 'Registro exitoso';
            header('refresh:2; url=cargo_lista.php');
        }else
        {
            $alert = 'Ocurrio un error inesperado';
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
        <a href="cargo_lista.php" class="btn btn-success btn-block">Ver lista de cargos</a><br>
        <div class="card-header">
            <h3 class="card-title">Todos los campos son oblogatorios</h3>
        </div>
        <form action="cargo_alta.php" id="formulario" onSubmit="return validar_clave()" method="POST">
            <div class="card-body">
                <!-- Nombre del cargo -->
                <div class="form-group">
                    <label for="name">Nombre del cargo:</label>
                    <input type="text" name="tb_name" id="name" onkeypress="return validar(event)" class="form-control" placeholder="Nombre del cargo">
                </div>
                <!-- siglas del cargo -->
                <div class="form-group">
                    <label for="cod">Codigo:</label>
                    <input type="text" name="tb_cod" id="cod" onkeypress="return validar(event)" class="form-control" placeholder="Codigo del cargo">
                </div>
            </div>
            <div class="card-footer">
                <input id="boton" type="submit" class="btn btn-success btn-block" value="Registrar" name="btn_registrar">
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