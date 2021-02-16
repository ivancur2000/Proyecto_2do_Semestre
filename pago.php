<?php
session_start();
require_once 'resuorces/config/database.php';
$id_venta = $_POST['id_venta'];
$sql=mysqli_query($conn, "SELECT v.cuotas_pagadas, v.id_venta ,c.nom_cli, c.ape_cli, c.cel1_cli , c.email_cli, c.nit_cli, c.id_cli,v.precio_total,v.precio_cuota, v.id_inmueble, i.descripcion FROM venta as v INNER JOIN cliente as c ON c.id_cli = v.id_cli INNER JOIN inmueble as i ON i.id_inmueble = v.id_inmueble WHERE v.id_venta = '$id_venta'");
$fila = mysqli_fetch_array($sql);
$precio = round($fila['precio_cuota']/6.96);
//conekta
require_once("lib/Conekta.php");
\Conekta\Conekta::setApiKey("key_Ax9YM8UMUQQUxHAeehKv9g");
\Conekta\Conekta::setApiVersion("2.0.0");

$token_id=$_POST["conektaTokenId"];

try {
  $customer = \Conekta\Customer::create(
    array( 
      "name" => $fila['nom_cli'],
      "email" => $fila['email_cli'],
      "phone" => $fila['cel1_cli']."00",
      "payment_sources" => array(
        array(
            "type" => "card",
            "token_id" => $token_id
        )
      )//payment_sources
    )//customer
  );
} catch (\Conekta\ProccessingError $error){
  echo $error->getMesage();
} catch (\Conekta\ParameterValidationError $error){
  echo $error->getMessage();
} catch (\Conekta\Handler $error){
  echo $error->getMessage();
}


try{
  $order = \Conekta\Order::create(
    array(
      "line_items" => array(
        array(
          "name" => $fila['descripcion'],
          "unit_price" => $precio,
          "quantity" => 1
        )//first line_item
      ), //line_items
      "shipping_lines" => array(
        array(
          "amount" => $precio,
           "carrier" => "Yolita"
        )
      ), //shipping_lines - physical goods only
      "currency" => "USD",
      "customer_info" => array(
        "customer_id" => $customer->id
      ), //customer_info
      "shipping_contact" => array(
        "address" => array(
          "street1" => "Calle 123, int 2",
          "postal_code" => "06100",
          "country" => "BO"
        )//address
      ), //shipping_contact - required only for physical goods
      "metadata" => array("reference" => "7524307900", "more_info" => "yolita.com"),
      "charges" => array(
          array(
              "payment_method" => array(
                      "type" => "default"
              ) //payment_method - use customer's default - a card
                //to charge a card, different from the default,
                //you can indicate the card's source_id as shown in the Retry Card Section
          ) //first charge
      ) //charges
    )//order
  );
} catch (\Conekta\ProcessingError $error){
  echo $error->getMessage();
} catch (\Conekta\ParameterValidationError $error){
  echo $error->getMessage();
} catch (\Conekta\Handler $error){
  echo $error->getMessage();
}

/* echo "ID: ". $order->id;
echo "<br>Status: ". $order->payment_status;
echo "<br>$". $order->amount . $order->currency;
echo "<br>Order";
echo $order->line_items[0]->quantity .
      "-". $order->line_items[0]->name .
      "- $". $order->line_items[0]->unit_price/100;
echo "<br>Payment info";
echo "<br>CODE:". $order->charges[0]->payment_method->auth_code;
echo "<br>Card info:" .
      "- ". $order->charges[0]->payment_method->name .
      "- ". $order->charges[0]->payment_method->last4 .
      "- ". $order->charges[0]->payment_method->brand .
      "- ". $order->charges[0]->payment_method->type; */
// Response
// ID: ord_2fsQdMUmsFNP2WjqS
// $ 135.0 MXN
// Order
// 12 - Tacos - $10.0
// Payment info
// CODE: 035315
// Card info: 4242 - visa - banco - credit
$codigo = $order->charges[0]->payment_method->auth_code;
if(!empty($codigo))
{
    $cliente = $fila['id_cli'];
    $monto_can = $fila['precio_cuota'];
    $pagadas = $fila['cuotas_pagadas'] + 1;
    $total = $fila['precio_total'];
    $venta = $fila['id_venta'];
    $fecha = date('y-m-d');

    $inmueble = $fila['descipcion'];
    $alta = "INSERT INTO cuota (codigo, id_cli, monto_cancelado, num_cuota, total_cuota, id_venta, fecha_cuota) VALUES ('$codigo', '$cliente', '$monto_can', '$pagadas', '$total', '$venta', '$fecha')";
    if(mysqli_query($conn, $alta))
    {
        $alert = "Transaccion Exitosa";
        $mod = mysqli_query($conn,"UPDATE venta SET cuotas_pagadas = '$pagadas' WHERE id_venta = '$venta'");
    }else
    {
        $alert = "Ocurrio un error";
    }
}else
{
    //header('location: index.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recibo</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
</head>
<body>
<?php include "incluide/navfile.php";  ?>
<br><br><br><br>
    <div class="container">
        <div class="col">
            <h3>Datos de la transaccion</h3>
            <div class="col-group">
                <label for="">Codigo</label>
                <label for=""><?php echo $codigo; ?></label>
            </div>
            <div>
                <label for="">Cliente</label>
                <label for=""><?php echo $fila['nom_cli']." ".$fila['ape_cli']; ?></label>
            </div>
            <div class="col-group">
                <label for="">NIT</label>
                <label for=""><?php echo $fila['nit_cli']; ?></label>
            </div>
            <div class="col-group"> 
                <label for="">Monto calcelado</label>
                <label for=""><?php echo $monto_can." Bs"; ?></label>
            </div>
            <div class="col-group">
                <label for="">Numero de Cuota</label>
                <label for=""><?php echo $pagadas; ?></label>
            </div>
            <div class="col-group">
                <label for="">Monto Total</label>
                <label for=""><?php echo $total." Bs"; ?></label>
            </div>
            <div class="col-group">
                <label for="">Descripcion del inmueble</label>
                <label for=""><?php echo $fila['descripcion'] ?></label>
            </div>
            <div class="col-group">
                <label for="">Fecha</label>
                <label for=""><?php echo $fecha; ?></label>
            </div>
            <div class="row">
                <a href="recibo.php?id=<?php echo $codigo; ?>"target="_blank" class="btn btn-success">Ver Recibo</a>
                <a href="index.php" class="btn btn-primary">Pagina principan</a>
            </div>
        </div>
    </div>
<!-- jquery -->
<script src="js/jquery/jquery.js"></script>
<!-- bootstrap -->
<script src="js/bootstrap/bootstrap.bundle.js"></script>
<script src="js/bootstrap/bootstrap.min.js"></script>
<script src="js/methods/scripts.js"></script>
</body>
</html>