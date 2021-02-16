<?php 
require_once 'resuorces/config/database.php';
session_start();
if(!empty($_GET['id']))
{
    $id = $_GET['id'];
    $sql = mysqli_query($conn,"SELECT * FROM inmueble WHERE id_inmueble = '$id'");
    $data = mysqli_fetch_array($sql);
    $result = mysqli_num_rows($sql);
    if($result == 0)
    {
       header('Location: index.php');
    }
}else
{
   header('Location: index.php');
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yolita.SRL</title>
    <script src="https://kit.fontawesome.com/5e53af518b.js" crossorigin="anonymous"></script>    
    <!-- estilos de la barra -->
    <link rel="stylesheet" href="css/navbar.css">
    <!-- estilos de la pagina -->
    <link rel="stylesheet" href="css/estilo.css">
    <!-- validador de password -->
    <script language="JavaScript">
        function validar_clave ()
        {
            var pass1 = document.getElementById('pass').value;
            var pass2 = document.getElementById('cpass').value;
            if (pass1 != pass2) {
                $("#validador_pass").html("<div><b> Las contraseñas deben coincidir <b></div>");
                return false;
            }
            else {
                return true;
            }
        }
    </script>
    <script src="js/jquery/ajax.js"></script>
</head>
<body>
<!-- barra de navegacion -->
<?php include "incluide/navfile.php"; ?>
    <br><br><br><br>
    <!-- cotizacion -->
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
    <div class="container"  id="calculadora">
    <h3>Cotización</h3>
        <div class="col">
            <div class="form-group col">
                <label for="mes">Tiempo a pagar:</label>
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
            <div class="form-group col">
                <label for="precio2">Precio(Bs)</label>
                <input type="number" class="form-control" value="<?php echo $data['precio'] ?>" id="precio2" disabled>
            </div>
            <div id="select2lista"></div>
            <div class="form-group col">
                <label for="cuota">Cuota Mensual(Bs)</label>
                <input type="number" class="form-control" id="cuota" disabled>
            </div>
            <div class="form-group col">
                <label for="total">Total(Bs)</label>
                <input type="number" class="form-control" id="total" disabled>
            </div>
            <button class="btn btn-primary" onclick="return calcular()">Calcular</button>
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
			url:"lista_meses.php",
			data:"mes=" + $('#mes').val(),
			success:function(r){
				$('#select2lista').html(r);
			}
		});
	}
</script>
     <!-- jquery -->
     <script src="js/jquery/jquery.js"></script>
    <!-- bootstrap -->
    <script src="js/bootstrap/bootstrap.bundle.js"></script>
    <script src="js/methods/imagenes.js"></script>  
    <script src="js/methods/scripts.js"></script>  
    <script src="js/methods/money.js"></script>
    <?php include "registro_cli.php"; ?>
</body>
</html>