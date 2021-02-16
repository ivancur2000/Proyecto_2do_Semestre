    <div class="modal fade" id="mostrarmodal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" id="header">
                    <h3><b>Mensaje del sistema</b></h3>
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