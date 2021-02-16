<?php
require_once 'resuorces/config/database.php';
session_start();
if(isset($_GET['id_venta']))
{
    $id = $_GET['id_venta'];
    $sql = mysqli_query($conn, "SELECT c.nom_cli, c.ape_cli FROM venta as v INNER JOIN cliente as c ON c.id_cli = v.id_cli WHERE v.id_venta = '$id'");
    $fila = mysqli_fetch_array($sql);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .credit-card-div { padding: 30px; }
        .credit-card-div  { width:650px; margin-left: 25%; }
        .credit-card-div  span { padding-top:10px; }
        .credit-card-div img { padding-top:30px; }
        .credit-card-div .small-font { font-size:9px; }
        .credit-card-div .pad-adjust { padding-top:10px; }
    </style>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <script type="text/javascript" src="https://cdn.conekta.io/js/latest/conekta.js"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>

</head>
<body>

<?php include "incluide/navfile.php";  ?>
<br><br><br><br><br><br>
<h3 style="margin-left: 25%;">Ingrese su tarjeta de credito o debito</h3>
    <form action="pago.php" class="credit-card-div border" method="POST"  id="card-form">
        <input type="hidden" name="nombre" data-conekta="card[name]" value="<?php echo $fila['nom_cli']." ".$fila['ape_cli']; ?>">
        <input type="hidden" name="id_venta" value="<?php echo $id; ?>">   
        <div class="panel panel-default" >
            <div class="panel-heading">
                <div class="row ">
                    <div class="col-md-12">
                        <input type="text"  data-conekta="card[number]" class="form-control" placeholder="Ingrese el Numero de la tarjeta" />
                    </div>
                </div>
                <br>
                <div class="row ">
                    <div class="col-md-3 col-sm-3 col-xs-3">
                        <span class="help-block text-muted" > MES</span>
                        <input type="text" class="form-control" data-conekta="card[exp_month]" placeholder="MM" />
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-3">
                        <span class="help-block text-muted" > AÑO</span>
                        <input type="text" class="form-control" data-conekta="card[exp_year]" placeholder="YY" />
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-3">
                        <span class="help-block text-muted t" >  CCV</span>
                        <input type="text" class="form-control" data-conekta="card[cvc]" placeholder="CCV" />
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-3">
                        <br>
                        <i  class="far fa-credit-card"></i>
                    </div>
                </div>
                <span class="card-errors" style="color: red;"></span>
                <div class="row ">
                    <div class="col-md-6 col-sm-6 col-xs-6 pad-adjust">
                        <input type="submit"  class="btn btn-danger" value="CANCELAR" />
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-6 pad-adjust">
                        <input type="submit"  class="btn btn-warning btn-block" value="PAGAR" />
                    </div>
                </div>
            </div>
        </div>
    </form>  
<script type="text/javascript" >
  Conekta.setPublicKey('key_Cf6xwVgweFHiqVvzixk5VEQ');

  var conektaSuccessResponseHandler = function(token) {
    var $form = $("#card-form");
    //Inserta el token_id en la forma para que se envíe al servidor
     $form.append($('<input name="conektaTokenId" id="conektaTokenId" type="hidden">').val(token.id));
    $form.get(0).submit(); //Hace submit
  };
  var conektaErrorResponseHandler = function(response) {
    var $form = $("#card-form");
    $form.find(".card-errors").text(response.message_to_purchaser);
    $form.find("button").prop("disabled", false);
  };

  //jQuery para que genere el token después de dar click en submit
  $(function () {
    $("#card-form").submit(function(event) {
      var $form = $(this);
      // Previene hacer submit más de una vez
      $form.find("button").prop("disabled", true);
      Conekta.Token.create($form, conektaSuccessResponseHandler, conektaErrorResponseHandler);
      return false;
    });
  });
</script>
<!-- jquery -->
<script src="js/jquery/jquery.js"></script>
<!-- bootstrap -->
<script src="js/bootstrap/bootstrap.bundle.js"></script>
<script src="js/bootstrap/bootstrap.min.js"></script>
<script src="js/methods/scripts.js"></script>
<?php include "registro_cli.php"; ?>
</body>
</html>