<script src="../../js/jquery/ajax.js"></script>
<script language="JavaScript">
    function calcular()
    {
        var meses = document.getElementById('mes').value;
        var precio = document.getElementById('precio2').value;
        var interes = document.getElementById('interes').value;
        if(interes === "0")
        {
            var total = precio-reserva;
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
<div class="modal fade" id="mod" tabindex="-1" role="dialog" aria-labelledby="basicModal" data-backdrop="static" data-keyboard="false" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" id="header">
                <h3>Modificar venta</h3>
            </div>
            <?php
            $consulta = mysqli_query($conn,"SELECT v.precio_total, v.id_venta,v.id_pp, u.nom_us, u.app_us, c.nom_cli, c.ape_cli, i.descripcion, i.precio, v.precio_cuota, i.id_inmueble, c.id_cli FROM venta as v INNER JOIN usuario as u ON u.id_us = v.id_us INNER JOIN cliente as c ON c.id_cli = v.id_cli INNER JOIN inmueble as i ON i.id_inmueble = v.id_inmueble WHERE v.id_venta = '$id_des1'");
            $data = mysqli_fetch_array($consulta);
            if(!empty($_POST))
            {
                if(isset($_POST['btn_registro']))
                {
                    $venta = $_POST['venta'];
                    $user = $_SESSION['id'];
                    $cliente = $_POST['cliente'];
                    $inmueble = $_POST['inmueble'];
                    $mes = $_POST['cb_mes'];
                    $precio_total = $_POST['total'];
                    $cuotas = $_POST['cuota'];
                    $mes1 = mysqli_query($conn, "SELECT * FROM plan_pago WHERE id_pp = '$mes'");
                    $mes2 = mysqli_fetch_array($mes1);
                    $numero_cuotas = $mes2['duracion_meses'];
                    $alta = "UPDATE venta SET id_us = '$user', id_inmueble = '$inmueble', id_cli = '$cliente', id_pp = '$mes', precio_total = '$precio_total', precio_cuota = '$cuotas', num_cuotas = '$numero_cuotas', est_venta = '1'WHERE id_venta= '$venta'";
                    if(mysqli_query($conn, $alta))
                    {
                        $alert = "Modificacion exitosa";
                        echo '<META HTTP-EQUIV="REFRESH" CONTENT="2;URL=http://localhost/yolitav3/system/ventas/lista_venta_hab.php">';
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
                        <form action="lista_venta_hab.php" method="POST">
                            <div clas="form-group">
                                <label for="">Cliente:</label>
                                <input type="text" name="" value="<?php echo $data['nom_cli']." ".$data['ape_cli'] ?>" class="form-control"id="">
                                <input type="hidden" name="cliente" value="<?php echo $data['id_cli'] ?>">
                                <input type="hidden" name="inmueble" value="<?php echo $data['id_inmueble']; ?>">                            
                                <input type="hidden" name="venta" value="<?php echo $id_des1; ?>">
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
                                <?php
                                $id_pp = $data['id_pp'];
                                $plan2 = mysqli_query($conn, "SELECT p.id_pp, p.duracion_meses, p.interes FROM plan_pago as p WHERE p.id_pp = '$id_pp'");
                                while($fila2=mysqli_fetch_array($plan2))
                                {
                                    ?>
                                    <option select value="<?php echo $fila2['id_pp']; ?>"><?php if($fila2['duracion_meses']==1){ echo $fila2['duracion_meses']." mes"; }else{ echo $fila2['duracion_meses']." meses"; } ?></option> 
                                    <?php
                                }
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
                                <input type="number" name="cuota" value="<?php echo $data['precio_cuota']; ?>" class="form-control" id="cuota">
                            </div>
                            <div class="form-group">
                                <label for="total">Total(Bs)</label>
                                <input type="number" name="total" value="<?php echo $data['precio_total']; ?>" class="form-control" id="total">
                            </div>
                            <button type="button" class="btn btn-primary" onclick="return calcular()">Calcular</button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" name="btn_registro" value="Modificar" class="btn btn-success">
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
