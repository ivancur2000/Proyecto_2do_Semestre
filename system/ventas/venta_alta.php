<script src="../../js/jquery/ajax.js"></script>
<script language="JavaScript">
    function calcular()
    {
        var meses = document.getElementById('mes').value;
        var precio = document.getElementById('precio2').value;
        var interes = document.getElementById('interes').value;
        if(interes === "0")
        {
            var total = precio;
            document.getElementById('total').value=total;
        }else{
            var cuota = precio*(((Math.pow(1+(interes/100),meses))*(interes/100))/((Math.pow(1+(interes/100),meses))-1))
            var cuota_mes = Math.round(cuota);
            var total = cuota_mes*meses ;
            document.getElementById('cuota').value=cuota_mes;
            document.getElementById('total').value=total;
        }
    }
    </script>
<div class="modal fade" id="venta" tabindex="-1" role="dialog" aria-labelledby="basicModal" data-backdrop="static" data-keyboard="false" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" id="header">
                <h3>Registrar nueva venta</h3>
            </div>
            <?php
            $consulta = mysqli_query($conn,"SELECT  i.id_edificio ,d.id_des, c.nom_cli, c.ape_cli, i.descripcion, d.id_inmueble, d.id_cli, i.precio FROM inmueble as i, deseados as d, cliente as c WHERE d.id_cli = c.id_cli AND d.id_inmueble = i.id_inmueble AND d.id_des = '$id_des1'");
            $data = mysqli_fetch_array($consulta);
            if(!empty($_POST))
            {
                if(isset($_POST['btn_registro']))
                {
                    $id_edi = $_POST['edi'];
                    $deseo = $_POST['deseo'];
                    $user = $_SESSION['id'];
                    $cliente = $_POST['cliente'];
                    $inmueble = $_POST['inmueble'];
                    $mes = $_POST['cb_mes'];
                    $precio_total = $_POST['total'];
                    $cuotas = $_POST['cuota'];
                    $mes1 = mysqli_query($conn, "SELECT * FROM plan_pago WHERE id_pp = '$mes'");
                    $mes2 = mysqli_fetch_array($mes1);
                    $numero_cuotas = $mes2['duracion_meses'];
                    $alta = "INSERT INTO venta (id_us, id_inmueble, id_cli, id_pp, precio_total, precio_cuota, num_cuotas, est_venta) VALUES ('$user','$inmueble', '$cliente', '$mes', '$precio_total', '$cuotas','$numero_cuotas','1')";
                    if(mysqli_query($conn, $alta))
                    {
                        $alert = "Registro Exitoso";
                        echo '<META HTTP-EQUIV="REFRESH" CONTENT="2;URL=http://localhost/yolitav3/system/ventas/habilitar_venta.php">';
                        $venta = mysqli_query($conn,"UPDATE inmueble SET est_inm = '3' WHERE id_inmueble='$inmueble'");
                        $edificio = mysqli_query($conn, "UPDATE edificio SET inmu_dis = inmu_dis - 1 WHERE id_ed='$id_edi'");
                        $deseo = mysqli_query($conn,"DELETE FROM deseados WHERE id_des='$deseo'");
                    }else
                    {
                        $alert = "Ocurrio un error, intentelo de nuevo";
                    }
                } 
            }
            ?>
            <div class="card">
                <div class="card-body">
                    <!-- foto de perfil -->
                    <div class="form-group">
                        <form action="habilitar_venta.php" method="POST">
                            <div clas="form-group">
                                <label for="">Cliente:</label>
                                <input type="text" class="form-control" value="<?php echo $data['nom_cli']." ".$data['ape_cli']; ?>" disabled>
                            </div>
                            <input type="hidden" name="edi" value="<?php echo $data['id_edificio']; ?>">
                            <input type="hidden" name="deseo" value="<?php echo $id_des1; ?>">
                            <input type="hidden" name="cliente" value="<?php echo $data['id_cli'] ?>">
                            <input type="hidden" name="inmueble" value="<?php echo $data['id_inmueble']; ?>">
                            <div clas="form-group">
                                <label for="">Inmueble::</label>
                                <textarea name="" class="form-control" id="" cols="10" rows="3" disabled><?php echo $data['descripcion']; ?></textarea>
                            </div>
                            <div class="form-group col">
                                <label for="precio2">Precio(Bs)</label>
                                <input type="number" class="form-control" value="<?php echo $data['precio'] ?>" id="precio2" disabled>
                            </div>
                            <div class="form-group">
                                <label for="mes">Plazo a pagar:(meses)</label>
                                <select name="cb_mes" class="form-control" id="mes">
                                    <option value=""></option>
                                <?php 
                                $plan = mysqli_query($conn, "SELECT p.id_pp, p.duracion_meses, p.interes FROM plan_pago as p WHERE p.est_plan = 1"); 
                                while($fila=mysqli_fetch_array($plan))
                                {
                                    ?>
                                    <option value="<?php echo $fila['id_pp']; ?>"><?php if($fila['duracion_meses']==1){ echo $fila['duracion_meses']." mes"; }else{ echo $fila['duracion_meses']." meses"; } ?></option> 
                                    <?php
                                }
                                ?>
                                </select>
                            </div>
                            <div id="select2lista"></div>
                            <div class="form-group">
                                <label for="cuota">Cuota Mensual(Bs)</label>
                                <input type="number" name="cuota" class="form-control" id="cuota">
                            </div>
                            <div class="form-group">
                                <label for="total">Total(Bs)</label>
                                <input type="number" name="total" class="form-control" id="total">
                            </div>
                            <button type="button" class="btn btn-primary" onclick="return calcular()">Calcular</button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" name="btn_registro" value="Registrar" class="btn btn-success">
                    <input type="button" value="Cancelar"data-dismiss="modal" class="btn btn-danger"> 
                        </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$('#mes').val(1);
		recargarLista();

		$('#mes').change(function(){
			recargarLista();
		});
	})
</script>
<script type="text/javascript">
	function recargarLista(){
		$.ajax({
			type:"POST",
			url:"lista_mes.php",
			data:"mes=" + $('#mes').val(),
			success:function(r){
				$('#select2lista').html(r);
			}
		});
	}
</script>
<!-- reserva -->
<script language="JavaScript">
    function calcular2()
    {
        var precio = document.getElementById('precio3').value;
        var porcentaje = precio*0.01;
        document.getElementById('cuota2').value = porcentaje;
    }
    </script>
<div class="modal fade" id="reserva" tabindex="-1" role="dialog" aria-labelledby="basicModal" data-backdrop="static" data-keyboard="false" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" id="header">
                <h3>Registrar nueva Reserva</h3>
            </div>
            <?php
            $consulta = mysqli_query($conn,"SELECT d.id_des, c.nom_cli, c.ape_cli, i.descripcion, d.id_inmueble, d.id_cli, i.precio FROM inmueble as i, deseados as d, cliente as c WHERE d.id_cli = c.id_cli AND d.id_inmueble = i.id_inmueble AND d.id_des = '$id_des2'");
            $data = mysqli_fetch_array($consulta);
            if(!empty($_POST))
            {
                if(isset($_POST['btn_registro2']))
                {
                    $deseo = $_POST['deseo2'];
                    $user = $_SESSION['id'];
                    $cliente = $_POST['cliente2'];
                    $inmueble = $_POST['inmueble2'];
                    $cuotas = $_POST['cuota2'];
                    $alta = "INSERT INTO venta (id_us, id_inmueble, id_cli,  precio_cuota, est_venta) VALUES ('$user','$inmueble', '$cliente', '$cuotas','2')";
                    if(mysqli_query($conn, $alta))
                    {
                        $alert = "Registro Exitoso";
                        echo '<META HTTP-EQUIV="REFRESH" CONTENT="2;URL=http://localhost/yolitav3/system/ventas/habilitar_venta.php">';
                        $venta = mysqli_query($conn,"UPDATE inmueble SET est_inm = '4' WHERE id_inmueble='$inmueble'");
                        $deseo = mysqli_query($conn,"DELETE FROM deseados WHERE id_des='$deseo'");
                    }else
                    {
                        $alert = "Ocurrio un error, intentelo de nuevo";
                    }
                } 
            }
            ?>
            <div class="card">
                <div class="card-body">
                    <!-- foto de perfil -->
                    <div class="form-group">
                        <form action="habilitar_venta.php" method="POST">
                            <div clas="form-group">
                                <label for="">Cliente:</label>
                                <input type="text" class="form-control" value="<?php echo $data['nom_cli']." ".$data['ape_cli']; ?>" disabled>
                            </div>
                            <input type="hidden" name="deseo2" value="<?php echo $id_des2; ?>">
                            <input type="hidden" name="cliente2" value="<?php echo $data['id_cli'] ?>">
                            <input type="hidden" name="inmueble2" value="<?php echo $data['id_inmueble']; ?>">
                            <div clas="form-group">
                                <label for="">Inmueble::</label>
                                <textarea name="" class="form-control" id="" cols="10" rows="3" disabled><?php echo $data['descripcion']; ?></textarea>
                            </div>
                            <div class="form-group col">
                                <label for="precio3">Precio(Bs)</label>
                                <input type="number" class="form-control" value="<?php echo $data['precio'] ?>" id="precio3" disabled>
                            </div>
                            <div class="form-group">
                                <label for="cuota2">Cuota Mensual(Bs)</label>
                                <input type="number" name="cuota2" class="form-control" id="cuota2">
                            </div>
                            <button class="btn btn-primary" type="button" onclick="return calcular2()">Calcular</button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" name="btn_registro2" value="Registrar" class="btn btn-success">
                    <input type="button" value="Cancelar"data-dismiss="modal" class="btn btn-danger"> 
                        </form>
                </div>
            </div>
        </div>
    </div>
</div>