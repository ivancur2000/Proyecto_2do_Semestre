<?php
session_start();
$titulo = "Lista de inmuebles vendidos"; 
$ubicacion = "Inmuebles";
//conexion a la base de datos
require '../../resuorces/config/database.php';
//consulta para llenar la tabla
$sql = mysqli_query($conn,"SELECT i.id_inmueble, e.nombre_ed, e.zona_ed, e.calle_ed, e.num_puerta, e.referencia_ed, ti.nombre_tipo, t.descrip_tam, i.precio, i.habitaciones, i.cocinas, i.baños, i.descripcion FROM inmueble as i, edificio as e, tipo_inmueble as ti, tamaño as t WHERE i.id_edificio = e.id_ed AND i.id_tipo = ti.id_tipo AND i.id_tamaño = t.id_tamaño AND i.est_inm = '3'");
$number = 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inmuebles</title>
    <link rel="stylesheet" href="../../css/style.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="../adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed"> 
<?php include "../sidebar/sidebar.php"; ?>   
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Inmuebles deshabilitados</h4>
        </div>
        <div class = "card-body">     
            <table id="tabla1" class="table table-bordered table-striped">
                <thead class="thead-dark">    
                    <tr>
                    <!-- cabecera de la tabla -->
                        <th>Num</th>
                        <th>Edificio</th>
                        <th>Ubicacion</th>
                        <th>Tipo de inmueble</th>
                        <th>Tamaño</th>
                        <th>Espacios</th>
                        <th>Precio</th>
                        <th>Descripcion</th>
                        <th>Tarea</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($data = mysqli_fetch_array($sql)){ $number++; ?>
                    <tr>
                    <!-- cuerpo de la tabla -->
                        <th><?php if(isset($number)){ echo $number; } ?></th>
                        <td><?php if(isset($data['nombre_ed'])){ echo $data['nombre_ed']; } ?></td>
                        <td><?php if(isset($data['zona_ed']) || isset($data['calle_ed']) || isset($data['num_puerta'])){ echo "Zona ".$data['zona_ed'].", calle ".$data['calle_ed'].", # ".$data['num_puerta']; } ?></td>
                        <td><?php if(isset($data['nombre_tipo'])){ echo $data['nombre_tipo']; } ?></td>
                        <td><?php if(isset($data['descrip_tam'])){ echo $data['descrip_tam']." metros"; } ?></td>
                        <td><?php if(isset($data['habitaciones']) || isset($data['cocinas']) || isset($data['baños'])){ echo $data['habitaciones']." habitacion(es), ".$data['cocinas']." cocina(s), ".$data['baños']." baño(s)"; } ?></td>
                        <td><?php if(isset($data['precio'])){ echo $data['precio']." Bs"; } ?></td>
                        <td><?php if(isset($data['descripcion'])){ echo $data['descripcion']; } ?></td>
                        <td><a class="btn btn-outline-success btn-sm" href="mod_inmu.php?id=<?php echo $data['id_inmueble'];?>">Actualizar</a></td>
                    </tr>
                    <?php } ?>
                </tbody> 
            </table>
        </div>
    </div>
    <?php include "../sidebar/sidebar2.php"; ?>
    <?php include "../modal_alerta/alert.php"; ?>
    <!-- DataTables -->
    <script src="../adminlte/plugins/datatables/jquery.dataTables.js"></script>
    <script src="../adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="../adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="../../js/methods/tabla.js"></script>
</body>
</html>