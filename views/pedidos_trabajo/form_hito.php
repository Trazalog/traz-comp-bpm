<form id="frm-hito" method="post" enctype="multipart/form-data">
    <div class="row">
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Código<strong style="color: #dd4b39">*</strong>:</label>
                        <input class="form-control" name="numero" minlength="4" maxlength="10" size="12" <?php echo req() ?>>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Descripción<strong style="color: #dd4b39">*</strong>:</label>
                        <input class="form-control" name="descripcion" <?php echo req() ?>>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Fecha inicio<strong style="color: #dd4b39">*</strong>:</label>
                        <input class="form-control datepicker" name="fec_inicio" <?php echo req() ?>>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="documento">Adjuntar Documento</label>
                        <input type="file" id="documento" name="documento" accept="pdf/*,image/*" class="form-control">
                        <p class="help-block">Adjuntar Documento.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Encargado<strong style="color: #dd4b39">*</strong>:</label>
                        <?php 
                            echo selectFromFont('user_id','Seleccionar', REST_CORE.'/users/'.empresa(), array('value'=>'id', 'descripcion'=> 'first_name'), true);
                        ?>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="form-group">
                        <label>Objetivo<strong style="color: #dd4b39">*</strong>:</label>
                        <input type="number" class="form-control" name="objetivo" min="0" <?php echo req() ?>>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>U.Tiempo<strong style="color: #dd4b39">*</strong>:</label>
                        <?php
                            echo selectFromCore('unidad_tiempo','Seleccionar', "unidad_medida_tiempo", true);
                        ?>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Ubicación<strong style="color: #dd4b39">*</strong>:</label>
                        
                        <?php
                            echo selectFromFont('esta_id','Seleccionar', REST_PRD.'/establecimientos/'.empresa(), array('value'=>'esta_id', 'descripcion'=> 'nombre'), true);
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<script>
initForm();

function guardarHito() {
    debugger;
    if (!frm_validar('#frm-hito')) return;
  
  var data = new FormData($('#frm-hito')[0]);

    wo();
    $.ajax({
        type: 'POST',
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        url: '<?php echo base_url(BPM) ?>Pedidotrabajo/hitos/' + s_pema,
      
        success: function(rsp) {
         debugger;
            resp = JSON.parse(rsp);

            if(resp.status == true) {
                console.log(resp);
                $('#mdl-hito').modal('hide');
                hecho();
                reload('comp#hitos', s_pema);
                // reload('#pnl-nuevo-pema', id);
                // reload('#pnl-hito', id);
            }
        },
        error: function(resp) {
            error();
        },
        complete: function() {
            wc();
        }
    });
}
</script>