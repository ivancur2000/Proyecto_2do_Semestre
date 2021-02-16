
<?php
    if(isset($_POST['btn_foto'])){
        $nom_img = $_FILES['imagen2']['name'];
		$type_img = $_FILES['imagen2']['type'];
		$tam_img = $_FILES['imagen2']['size'];
		if($type_img == "image/jpg" || $type_img == "image/jpeg" || $type_img == "image/png")
		{
			if($tam_img <= 1000000)
			{	
                if(!empty($_POST)){
                    $id_usuario2 = $_POST['id_us2'];
                    $destino = $_SERVER['DOCUMENT_ROOT'] . '/yolitaV3/img/user_img/'; 
                    move_uploaded_file($_FILES['imagen2']['tmp_name'],$destino.$nom_img);
                    $foto = "UPDATE usuario SET foto_us = '$nom_img' WHERE id_us = '$id_usuario2'";
                    if(mysqli_query($conn,$foto)){
                        $alert= "Foto de perfil Cambiada exitosamente";
                    }
                }
            }else{
                $alert= "La imagen pesa demaciado";
            }
        }else{
            $alert="El formato de la imagen no es valido";
        }
    }
?>
    <div class="modal fade" id="foto_perfil" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" id="header">
                    <h3>Cambio de foto de perfil</h3>
                </div>
                <div class="card">
                    <input type="hidden" name="id_us2"  value = "<?php echo $id_usu; ?>">
                        <div class="card-body">
                            <!-- foto de perfil -->
                            <div class="form-group">
                                <label for="img">Foto de perfil</label>
                                <input type="file" name="imagen2" class="form-control-file" id="img">
                            </div>
                        </div>
                        <img src="../../img/user_img/<?php if(isset($foto_perfil)){ echo $foto_perfil; } ?>" alt="foto usuario" style="border-radius:50%; width: 100px; height: 100px;">
                        <div class="modal-footer">
                            <input type="submit" name="btn_foto" value="Cambiar" class="btn btn-success">
                            <input type="button" value="Cancelar"data-dismiss="modal" class="btn btn-danger">               
                        </div>
                </div>
            </div>
        </div>
    </div>