<?php
session_start();
 $titulo = "Registro de inmuebles"; 
 $ubicacion = "Inmuebles";
//conexion a la base de datos
require '../../resuorces/config/database.php';
if(!empty($_POST))
{
	//requperacion de los datos obtenidos mediante el POST
    $precio = $_POST['tb_precio'];
    $descrip = $_POST['tb_desc'];
	$habitacion = $_POST['tb_hab'];
	$cocina = $_POST['tb_coc'];
	$banos = $_POST['tb_ban'];
    $piso = $_POST['tb_piso'];
    $servicios = $_POST['tb_servi1']." ".$_POST['tb_servi2']." ".$_POST['tb_servi3'];
    $garaje = $_POST['tb_garaje'];
    $posicion = $_POST['tb_posi'];
	$edificio = $_POST['cb_ed'];
    $tipo = $_POST['cb_tipo'];  
    $tama = $_POST['cb_tam'];
    //estado del inmueble 
    $est = mysqli_query($conn,"SELECT * FROM edificio WHERE id_ed = '$edificio'");
    $vector = mysqli_fetch_array($est);
    $estado = $vector['est_ed'];
    if(isset($_FILES['imagen']))
	{
		$nom_img = $_FILES['imagen']['name'];
		$type_img = $_FILES['imagen']['type'];
		$tam_img = $_FILES['imagen']['size'];
		if($type_img == "image/jpg" || $type_img == "image/jpeg" || $type_img == "image/png")
		{
			if($tam_img <= 1000000)
			{	
				$destino = $_SERVER['DOCUMENT_ROOT'] . '/yolitaV3/img/target/'; 
				move_uploaded_file($_FILES['imagen']['tmp_name'],$destino.$nom_img);				
                //validacion contraseña mediante java scrip
                //alta de la tabla		
                $sql = "INSERT INTO inmueble (habitaciones, cocinas, baños, piso, servicios_basicos, garaje, posicion, precio, id_edificio, id_tipo, id_tamaño, descripcion, target, est_inm) VALUES('$habitacion','$cocina','$banos','$piso', '$servicios', '$garaje', '$posicion', '$precio','$edificio','$tipo', '$tama', '$descrip', '$nom_img', '$estado')";
                if(mysqli_query($conn,$sql))
                {
                    $alert = "Datos registrados con exito";
                    header('refresh:1; url=lista_inmu.php');
                }else
                {
                    $alert = "Ocurrio un error inesperado";
                } 
			}else
			{
				$alert = 'La imagen es demasiado grande';
			}
		}else
		{
			$alert = 'El formato de imagen no es valido';
		}	
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inmuebles</title>
    <link rel="stylesheet" href="../../css/style.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <?php include "../sidebar/sidebar.php"; ?>
    <div class="card card-dark">
    <a href="lista_inmu.php" class="btn btn-success btn-block">Lista de inmuebles</a><br>
    <div class="card-header">
        <h3 class="card-title">Todos los campos son obligatorios</h3>
    </div>
        <form action="registro_inmu.php" id="formulario" method="POST" enctype="multipart/form-data">
            <div class="card-body">
                <!-- precio basico-->
                <div class="form-group"> 
                    <label for="precio">Precio base del inmueble(Bs):</label>
                    <input type="number" placeholder="Precio del inmueble" name="tb_precio" id="precio" onkeypress="return soloNumeros(event)" class="form-control">
                </div>
                <!--Habitaciones-->
                <div class="form-group">
                    <label for="hab">Numero de Habitaciones:</label>
                    <input type="number" placeholder="Numero de habitaciones" name="tb_hab" id="hab" class="form-control" onkeypress="return soloNumeros(event)" >
                </div>
                <!--Cocinas-->
                <div class="form-group">
                    <label for="cocina">Numero de cocinas:</label>
                    <input type="number" name="tb_coc" id="cocina" placeholder="Numero de cocinas" class="form-control" onkeypress="return soloNumeros(event)">
                </div>
                <!--Baños-->
                <div class="form-group">
                    <label for="banos">Numero de Baños:</label>
                    <input type="number" name="tb_ban" id="banos" placeholder="Numero de baños" class="form-control" onkeypress="return soloNumeros(event)">
                </div>
                <!--Piso-->
                <div class="form-group">
                    <label for="piso">Piso:</label>
                    <input type="number" name="tb_piso" id="piso" placeholder="Cantidad de pisos" class="form-control" onkeypress="return soloNumero(event)">
                </div>
                <!-- servicios basicos -->
                <div class="form-group">
                    <label for="servicios">Servicios Basicos</label>
					<div class="form-check-inline">
						<input type="checkbox" class="form-check-input" name="tb_servi1" id="luz" value="Luz">
						<label for="luz" class="form-check-label">Luz</label>
					</div>
					<div class="form-check-inline">
						<input type="checkbox" class="form-check-input" name="tb_servi2" id="agua" value="Agua">
						<label for="agua" class="form-check-label">Agua</label> 
					</div>
					<div class="form-check-inline">
						<input type="checkbox" class="form-check-input" name="tb_servi3" id="gas" value="Gas">
						<label for="gas" class="form-check-label">Gas Natural</label>  			
					</div>	
				</div>
                <!-- garaje -->
                <div class="form-group">
                    <label for="e">Garaje</label>
					<div class="form-check-inline">
						<input type="radio" class="form-check-input" name="tb_garaje" id="garaje" value="Si">
						<label for="garaje" class="form-check-label">Si</label>
					</div>
					<div class="form-check-inline">
						<input type="radio" class="form-check-input" name="tb_garaje" id="no" value="No">
						<label for="no" class="form-check-label">No</label> 
					</div>
                </div>
                <!-- posicion -->
                <div class="form-group">
                    <label for="posicion">Posicion respecto al sol:</label>
                    <input type="text" name="tb_posi" id="posicion" placeholder="Posicion" class="form-control" onkeypress="return validar(event)">
                </div>
                <!--Edificio-->
                <div class="form-group">
                    <label for="edificio">Edificio:</label>
                    <select name="cb_ed" id="edificio" class="form-control">
                        <option value="">Seleccione una opcion</option>
                        <?php
                        $cmd = @mysqli_query($conn,"SELECT * FROM edificio WHERE est_ed != '0' ");
                        $result = mysqli_num_rows($cmd);
                            if($result > 0)
                            {
                                while($valor = mysqli_fetch_array($cmd))
                                {
                                ?>
                                    <option value="<?php echo $valor['id_ed']; ?>"><?php echo $valor['nombre_ed']; ?></option>
                                <?php
                                }
                            }
                        ?>	
                    </select>
                </div>
                <!--Tipo-->
                <div class="form-group">
                    <label for="tipo">Tipo:</label>
                    <select name="cb_tipo" id="tipo" class="form-control">
                        <option value="">Seleccione una opcion</option>
                        <?php
                        $cmd2 = @mysqli_query($conn,"SELECT * FROM tipo_inmueble ");
                        $result2 = mysqli_num_rows($cmd2);
                            if($result2 > 0)
                            {
                                while($valor2 = mysqli_fetch_array($cmd2))
                                {
                                ?>
                                    <option value="<?php echo $valor2['id_tipo']; ?>"><?php echo $valor2['nombre_tipo']; ?></option>
                                <?php
                                }
                            }
                        ?>
                    </select>
                </div>
                <!--Tamaño-->
                <div class="form-group">
                    <label for="tam">Tamaño:</label>
                    <select name="cb_tam" id="tam" class="form-control"> 
                        <option value="">Selecione una opcion</option>
                        <?php
                        $cmd3 = @mysqli_query($conn,"SELECT * FROM tamaño ");
                        $result3 = mysqli_num_rows($cmd3);
                            if($result3 > 0)
                            {
                                while($valor3 = mysqli_fetch_array($cmd3))
                                {
                                ?>
                                    <option value="<?php echo $valor3['id_tamaño']; ?>"><?php echo $valor3['descrip_tam']; ?></option>
                                <?php
                                }
                            }
                        ?>
                    </select>
                </div>
                <!--target-->
                <div class="form-group">
                    <label for="img">Target del inmueble:</label>
                    <input type="file" name="imagen" id="img" class="form-control-file">
                </div>
                <!--Descripcion-->
                <div class="form-group">
                    <label for="desc">Descripcion:</label>
                    <input type="text" name="tb_desc" id="desc" class="form-control" placeholder="Una descripcion del inmueble" >
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
	<script src="../../js/methods/password.js"></script>
</body>
</html>