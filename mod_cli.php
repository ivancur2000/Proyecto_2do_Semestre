<?php
require_once 'resuorces/config/database.php';
session_start(); 
$id = $_SESSION['id_cli'];
if(!isset($_SESSION['id_cli']))
{
    header('location: index.php');
}
if(isset($_POST['btn_mod']))
{
    if(!empty($_POST))
    {
        $name = $_POST['tb_name'];
        $app = $_POST['tb_app'];
        $nacimiento = $_POST['dt_naci'];
        $cel = $_POST['tb_cel1'];
        $cel2 = $_POST['tb_cel2'];
        $email = $_POST['tb_email'];
        $direc = $_POST['tb_direc'];
        $nit = $_POST['tb_ci'];
        $modificacion = "UPDATE cliente SET nom_cli = '$name', ape_cli = '$app', fech_naci = '$nacimiento', cel1_cli = '$cel', cel2_cli = '$cel2', email_cli = '$email', nit_cli = '$nit', direc_cli = '$direc' WHERE id_cli = '$id'";
        if(mysqli_query($conn, $modificacion))
        {
            $_SESSION['nom_cli']=$name;
            $_SESSION['ape_cli']=$app;
            $alert = "Modificacion Exitosa";
            header('refresh: 2; url=perfil.php');
        }else
        {
            $alert = "Ocurrio un error, Intentelo mas tarde";
        } 
    }
}
if(isset($_POST['btn_pass']))
{
    if(!empty($_POST))
    {
        $newpass = $_POST['pass'];
        $pass_mod = "UPDATE cliente SET pass_cli = '$newpass' WHERE id_cli = '$id'";
        if(mysqli_query($conn, $pass_mod))
        {
            $alert = "Contraseña Modificada con exito";
            header('refresh:2; url=perfil.php');
        }else
        {
            $alert = "Ocurrio un error, intentelo de nuevo";
        }
    }
}
$id = $_SESSION['id_cli'];
$sql=mysqli_query($conn,"SELECT * FROM cliente WHERE id_cli = '$id'");
$fila=mysqli_fetch_array($sql);
$password = $fila['pass_cli'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
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
</head>
<body>
<?php include "incluide/navfile.php"; ?>
<br><br><br><br>
<div class="d-flex" id="wrapper">

    <!-- Sidebar -->
    <div class="bg-light border-right" id="sidebar-wrapper">
      <div class="list-group list-group-flush">
        <a href="perfil.php" class="list-group-item list-group-item-action bg-light">Perfil</a>
        <a href="lista_deseados.php" class="list-group-item list-group-item-action bg-light">Lista de deseados</a>
        <a href="compras.php" class="list-group-item list-group-item-action bg-light">Ventas</a>
        <a href="conversacion.php" class="list-group-item list-group-item-action bg-light">Coversaciones</a>
        <a href="recibo_lista.php" class="list-group-item list-group-item-action bg-light">Recibos</a>
      </div>
    </div>
    <!-- /#sidebar-wrapper -->

    <!-- Page Content -->
    <div id="page-content-wrapper">

      <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
        <button class="btn btn-primary" id="menu-toggle"><i class="fas fa-bars"></i></button>
      </nav>
        <div class="col" id="datos">
            <h3>Datos del Usuario:</h3>
            <form action="mod_cli.php" method="POST">
                <div class="form-group row">
                    <Label class="col-sm-2 col-form-label">Nombres:</Label>
                    <div class="col-sm-8">
                        <input type="text" name="tb_name" id="texto" value="<?php echo $fila['nom_cli']; ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <Label class="col-sm-2 col-form-label">Apellidos:</Label>
                    <div class="col-sm-8">
                        <input type="text" name="tb_app" id="texto" value="<?php echo $fila['ape_cli']; ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <Label class="col-sm-2 col-form-label">Fecha de nacimiento:</Label>
                    <div class="col-sm-8">
                        <input type="text" name="dt_naci" id="texto" value="<?php echo $fila['fech_naci']; ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <Label class="col-sm-2 col-form-label">Celular:</Label>
                    <div class="col-sm-8">
                        <input type="text" name="tb_cel1" id="texto" value="<?php echo $fila['cel1_cli']; ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <Label class="col-sm-2 col-form-label">Celular Secundario:</Label>
                    <div class="col-sm-8">
                        <input type="text" name="tb_cel2" id="texto" value="<?php echo $fila['cel2_cli']; ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <Label class="col-sm-2 col-form-label">Correo Electronico:</Label>
                    <div class="col-sm-8">
                        <input type="text" name="tb_email" id="texto" value="<?php echo $fila['email_cli']; ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <Label class="col-sm-2  col-form-label" >Direccion:</Label>
                    <div class="col-sm-8">
                        <input type="text" name="tb_direc" id="texto" value="<?php echo $fila['direc_cli']; ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <Label class="col-sm-2 col-form-label">NIT:</Label>
                    <div class="col-sm-8">
                        <input type="text" name="tb_ci" id="texto" value="<?php echo $fila['nit_cli']; ?>">
                    </div>
                </div>
                <a href="#password" data-toggle="modal" class="btn btn-success">Cambiar Contraseña</a>
                <input type="submit" class="btn btn-primary" name="btn_mod" value="Modificar Datos">
            </form>
        </div>
    </div>
</div>
<!-- pie de pagina -->
<footer class="footer py-4 fixed-botom" id="footer2">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-4 text-lg-left" >Derechos de autor © Yolita.SRL 2020</div>
                    <div class="col-lg-4 my-3 my-lg-0">
                        <a class="btn btn-dark btn-social mx-2" href="#!"><i class="fab fa-twitter"></i></a><a class="btn btn-dark btn-social mx-2" href="#!"><i class="fab fa-facebook-f"></i></a><a class="btn btn-dark btn-social mx-2" href="#!"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                    <div class="col-lg-4 text-lg-right"><a class="mr-3" href="#!">Privacy Policy</a><a href="#!">Terms of Use</a></div>
                </div>
            </div>
        </footer>
<!-- alerta modal -->
<div class="modal fade" id="mostrarmodal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" id="header">
                <h3>Mensaje del sistema</h3>
            </div>
            <div class="modal-body">
                <?php if(isset($alert))
                {
                    echo '<div class="alert">'.$alert.'</div>';    
                }
                ?>
            </div>
            <div class="modal-footer">
                <a href="#" data-dismiss="modal" class="btn btn-danger">Cerrar</a>
            </div>
        </div>
    </div>
</div>
<!-- alerta modal -->
<div class="modal fade" id="password" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" id="header">
                <h3>Cambio de contraseña</h3>
            </div>
            <div class="modal-body">
                <div class="col">
                    <form action="mod_cli.php" method="POST" onSubmit="return validar_clave()">
                        <div class="form-group">
                            <label for="pass1">Ponga su contraseña:</label>
                            <input id="pass1" type="password" name="id_pass" class="form-control">
                            <input type="hidden" id="cpass1" name="lol" value="<?php echo $password; ?>">
                            <div id="validador_pass2"style="color: #DC3545;" ></div>
                        </div>
                        <div class="form-group">
                            <label for="">Nueva contraseña:</label>
                            <input id="pass" type="password" name="pass" class="form-control">
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
                            <input id="cpass" type="password" name="id_pass" class="form-control">
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
<!-- jquery -->
<script src="js/jquery/jquery.js"></script>
<!-- bootstrap -->
<script src="js/bootstrap/bootstrap.bundle.js"></script>
<script src="js/bootstrap/bootstrap.min.js"></script>
<script src="js/methods/scripts.js"></script>
<script src="js/methods/password.js"></script>
<script>
$("#menu-toggle").click(function(e) {
    e.preventDefault();
    $("#wrapper").toggleClass("toggled");
});
</script>
<!-- ventana de alerta modal -->
<script type="text/javascript">
	$(document).ready(function()
	{
		var mensaje = '<?php echo $alert; ?>'
	if(mensaje !== "" ){
		$("#mostrarmodal").modal("show");
		mensaje="";
	}
	});
</script>
</body>
</html>
