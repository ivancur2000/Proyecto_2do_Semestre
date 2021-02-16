<?php
if(isset($_POST['btn_pass']))
{
   
    $newpass = md5($_POST['pass']);
    $pass_mod = "UPDATE usuario SET pass_us = '$newpass' WHERE id_us = '$id_usuario'";
    if(mysqli_query($conn, $pass_mod))
    {
        $alert = "Contraseña Modificada con exito";
        header('refresh:2; url=lista_us.php');
    }else
    {
        $alert = "Ocurrio un error, intentelo de nuevo";
    }
    
}
?>
<script language="JavaScript">
	function validar_clave ()
	{
		var pass1 = document.getElementById('pass').value;
		var pass2 = document.getElementById('cpass').value;
        var pass3 = document.getElementById('pass1').value;
		var pass4 = document.getElementById('cpass1').value;
        if (pass3 != pass4) {
            $("#validador_pass2").html("<div><b> Contraseña incorrecta <b></div>");
            return false;
		}
		else 
		{
			if (pass1 != pass2) {
			$("#validador_pass").html("<div><b> Las contraseñas deben coincidir <b></div>");
			return false;
            }
            else 
            {
                return true;
            }
      	}
    }
	</script>
<!-- alerta modal -->
<div class="modal fade" id="c_pass" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" id="header">
                <h3>Cambio de contraseña</h3>
            </div>
            <div class="modal-body">
                <div class="col">
                    <form action="mod_us.php" method="POST" onSubmit="return validar_clave()">
                        <div class="form-group">
                            <label for="pass1">Ponga su contraseña:</label>
                            <input id="pass1" type="password" name="id_pass" class="form-control">
                            <input type="hidden" id="cpass1" name="lol" value="<?php echo $password; ?>">
                            <div id="validador_pass2"style="color: #DC3545;" ></div>
                        </div>
                        <div class="form-group">
                            <label for="">Nueva contraseña:</label>
                            <input id="pass" type="password" name="pass" class="form-control"required>
                        </div>
                        <span id="mensaje"></span>
                        <small class="form-text text-muted">
                            <ul>
                                <li id = "mayus">3 Mayusculas</li>
                                <li id = "special">3 Caracteres especiales</li>
                                <li id = "numbers">Digitos</li>
                                <li id = "lower">Minusculas</li>
                                <li id = "len">Minimo 8 caracteres</li>
                            </ul>
                        </small>
                        <div class="form-group">
                            <label for="">Confirme contraseña:</label>
                            <input id="cpass" type="password" name="id_pass" class="form-control"required>
                        </div>
                        <div id="validador_pass"style="color: #DC3545;" ></div>
                </div>
            </div>
            <div class="modal-footer">
                    <input type="submit"  class="btn btn-success" name="btn_pass" value="Cambiar">
                    <a href="#" data-dismiss="modal" class="btn btn-danger">Cerrar</a>
                </form>
            </div>
        </div>
    </div>
</div> 