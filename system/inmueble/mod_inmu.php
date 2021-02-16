<?php
$titulo = "Modificacion de Inmueble"; 
$ubicacion = "Inmuebles";
session_start();
//conexion a la base de datos
require '../../resuorces/config/database.php';
if(!empty($_POST))
{
    if(isset($_POST['btn_registrar']))
    {
        $id_inmueble = $_POST['id_inmu'];
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
        $sql = "UPDATE inmueble SET habitaciones = '$habitacion', cocinas = '$cocina', baños = '$banos', piso = '$piso', servicios_basicos = '$servicios', garaje = '$garaje', posicion = '$posicion', precio = '$precio', id_edificio = '$edificio', id_tipo = '$tipo' , id_tamaño = '$tama', descripcion = '$descrip', est_inm = '$estado' WHERE id_inmueble = '$id_inmueble'";
        if(mysqli_query($conn,$sql))
        {
            $alert = "Datos Modificados con exito";
            header('refresh:1; url=lista_inmu.php');
        }else
        {
            $alert = "Ocurrio un error inesperado";
        } 
    }
    if(isset($_POST['btn_foto']))
    {
        if(!empty($_FILES['imagen2']))
        {
            $id_inmueble = $_POST['id_inmu'];
            $nom_img = $_FILES['imagen2']['name'];
            $type_img = $_FILES['imagen2']['type'];
            $tam_img = $_FILES['imagen2']['size'];
            if($type_img == "image/jpg" || $type_img == "image/jpeg" || $type_img == "image/png")
            {
                if($tam_img <= 1000000)
                {	
                    $destino = $_SERVER['DOCUMENT_ROOT'] . '/yolitaV3/img/target/'; 
                    move_uploaded_file($_FILES['imagen2']['tmp_name'],$destino.$nom_img);				
                    //validacion contraseña mediante java scrip
                    //alta de la tabla		
                    $sql = "UPDATE inmueble SET target = '$nom_img' WHERE id_inmueble = '$id_inmueble'";
                    if(mysqli_query($conn,$sql))
                    {
                        $alert = "Target modificado con exito";
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
        }else
        {
            echo 'hola';
        }	
    }
    
}

//validacion del metodo get
if(empty($_GET['id']))
{
    //header('refresh:2; url=lista_inmu.php');
}else
{
    $id_in = $_GET['id'];
    //validacion si el campo get es borrado o no existe
    $cmd = mysqli_query($conn, "SELECT * FROM inmueble WHERE id_inmueble = '$id_in'");
    $respuesta = mysqli_num_rows($cmd);
    if($respuesta == 0)
    {
        header('location: lista_inmu.php');
    }else
    {
        //obtencion y llenado de datos
        while ($data = mysqli_fetch_array($cmd)) 
        {
            $precioo = $data['precio'];
            $habitad = $data['habitaciones'];
            $cocinas = $data['cocinas'];
            $banoo = $data['baños'];
            $pisos = $data['piso'];
            $edifi = $data['id_edificio'];
            $tipo_in = $data['id_tipo'];
            $tamano = $data['id_tamaño'];
            $descripcion = $data['descripcion'];
            $estado_in = $data['est_inm'];
            $servicos_basicos = $data['servicios_basicos'];
            $garaje1=$data['garaje'];
            $posicion1 = $data['posicion'];
            if($servicos_basicos != "")
            {
                $servicio = 1;
            }
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
    <div class="row">
        <a href="lista_inmu.php" class="btn btn-danger">Atras</a><a href="#target" data-toggle="modal" class="btn btn-primary">Cambiar Target</a><br>
    </div>
    <div class="card-header">
        <h3 class="card-title">Todos los campos son obligatorios</h3>
    </div>
        <form action="mod_inmu.php" id="formulario" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id_inmu" value="<?php echo $id_in; ?>">
            <div class="card-body">
                <!-- precio basico-->
                <div class="form-group"> 
                    <label for="precio">Precio base del inmueble(Bs):</label>
                    <input type="number" value="<?php if(isset($precioo)){ echo $precioo; } ?>" placeholder="Precio del inmueble" name="tb_precio" id="precio" onkeypress="return soloNumeros(event)" class="form-control">
                </div>
                <!--Habitaciones-->
                <div class="form-group">
                    <label for="hab">Numero de Habitaciones:</label>
                    <input type="number" value="<?php if(isset($habitad)){ echo $habitad; } ?>" placeholder="Numero de habitaciones" name="tb_hab" id="hab" class="form-control" onkeypress="return soloNumeros(event)" >
                </div>
                <!--Cocinas-->
                <div class="form-group">
                    <label for="cocina">Numero de cocinas:</label>
                    <input type="number" value="<?php if(isset($cocinas)){ echo $cocinas; } ?>" name="tb_coc" id="cocina" placeholder="Numero de cocinas" class="form-control" onkeypress="return soloNumeros(event)">
                </div>
                <!--Baños-->
                <div class="form-group">
                    <label for="banos">Numero de Baños:</label>
                    <input type="number" value="<?php if(isset($banoo)){ echo $banoo; } ?>" name="tb_ban" id="banos" placeholder="Numero de baños" class="form-control" onkeypress="return soloNumeros(event)">
                </div>
                <!--Piso-->
                <div class="form-group">
                    <label for="piso">Piso:</label>
                    <input type="number" value="<?php if(isset($pisos)){ echo $pisos; } ?>" name="tb_piso" id="piso" placeholder="Cantidad de pisos" class="form-control" onkeypress="return soloNumero(event)">
                </div>
                <!-- servicios basicos -->
                <div class="form-group">
                    <label for="servicios">Servicios Basicos</label>
					<div class="form-check-inline">
						<input type="checkbox" class="form-check-input" <?php if(isset($servicos_basicos)){ if($servicio == 1){ ?>checked<?php } } ?> name="tb_servi1" id="luz" value="Luz">
						<label for="luz" class="form-check-label">Luz</label>
					</div>
					<div class="form-check-inline">
						<input type="checkbox" class="form-check-input" <?php if(isset($servicos_basicos)){ if($servicio == 1){ ?>checked<?php } } ?> name="tb_servi2" id="agua" value="Agua">
						<label for="agua" class="form-check-label">Agua</label> 
					</div>
					<div class="form-check-inline">
						<input type="checkbox" class="form-check-input" <?php if(isset($servicos_basicos)){ if($servicio == 1){ ?>checked<?php } } ?> name="tb_servi3" id="gas" value="Gas">
						<label for="gas" class="form-check-label">Gas Natural</label>  			
					</div>	
				</div>
                <!-- garaje -->
                <div class="form-group">
                    <label for="e">Garaje</label>
					<div class="form-check-inline">
						<input type="radio" class="form-check-input" name="tb_garaje" id="garaje" <?php  if(isset($garaje1)){ if($garaje1 == 'Si'){ ?>checked<?php } }  ?> value="Si">
						<label for="garaje" class="form-check-label">Si</label>
					</div>
					<div class="form-check-inline">
						<input type="radio" class="form-check-input" name="tb_garaje" <?php  if(isset($garaje1)){ if($garaje1 == 'No'){ ?>checked<?php } }  ?> id="no" value="No">
						<label for="no" class="form-check-label">No</label> 
					</div>
                </div>
                <!-- posicion -->
                <div class="form-group">
                    <label for="posicion">Posicion respecto al sol:</label>
                    <input type="text" name="tb_posi" id="posicion" placeholder="Posicion" class="form-control" onkeypress="return validar(event)" value="<?php if(isset($posicion1)){ echo $posicion1; } ?>">
                </div>
                <!--Edificio-->
                <div class="form-group">
                    <label for="edificio">Edificio:</label>
                    <select name="cb_ed" id="edificio" class="form-control">
                        <?php
                        $cmd1_1=mysqli_query($conn,"SELECT * FROM edificio WHERE est_ed = '1' AND est_ed = '2' AND id_ed='$edifi'");
                        while($result_1 = mysqli_fetch_array($cmd1_1))
                        {
                            ?>
                            <option value="<?php echo $result_1['id_ed'] ?>"><?php echo $result_1['nombre_ed']; ?></option>
                            <?php
                        }
                        $cmd = @mysqli_query($conn,"SELECT * FROM edificio WHERE est_ed != '0'");
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
                        <?php
                        $cmd1_2=mysqli_query($conn,"SELECT * FROM tipo_inmueble WHERE est_tipo = '1'  AND id_tipo='$tipo_in'");
                        while($result_2 = mysqli_fetch_array($cmd1_2))
                        {
                            ?>
                            <option value="<?php echo $result_2['id_tipo'] ?>"><?php echo $result_2['nombre_tipo']; ?></option>
                            <?php
                        }
                        $cmd2 = @mysqli_query($conn,"SELECT * FROM tipo_inmueble WHERE est_tipo = '1'");
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
                        <?php
                        $cmd1_3=mysqli_query($conn,"SELECT * FROM tamaño WHERE est_tam = '1' AND id_tamaño='$tamano'");
                        while($result_3 = mysqli_fetch_array($cmd1_3))
                        {
                            ?>
                            <option value="<?php echo $result_3['id_tamaño'] ?>"><?php echo $result_3['descrip_tam']; ?></option>
                            <?php
                        }
                        $cmd3 = @mysqli_query($conn,"SELECT * FROM tamaño WHERE est_tam = '1'");
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
                <!--Descripcion-->
                <div class="form-group">
                    <label for="desc">Descripcion:</label>
                    <input type="text" value="<?php if(isset($descripcion)){ echo $descripcion; } ?>" name="tb_desc" id="desc" class="form-control" placeholder="Una descripcion del inmueble" onkeypress="return validar(event)">
                </div>
            </div>
            <div class="card-footer"> 
				<input id="boton" type="submit" class="btn btn-success btn-block" value="Modificar" name="btn_registrar">
				<input type="reset" class="btn btn-danger btn-block" value="Cancelar">
			</div>
            <div class="modal fade" id="target" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header" id="header">
                            <h3>Cambio de target</h3>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <!-- foto de perfil -->
                                <div class="form-group">
                                    <label for="img">Target</label>
                                    <input type="file" name="imagen2" class="form-control-file" id="img">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <input type="submit" name="btn_foto" value="Cambiar" class="btn btn-success">
                                <input type="button" value="Cancelar"data-dismiss="modal" class="btn btn-danger">               
                            </div>
                        </div>
                    </div>
                </div>
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





