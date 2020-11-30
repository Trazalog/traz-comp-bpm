<form id="frm-hito">
    <div class="row">
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Número:</label>
                        <input class="form-control" name="numero" <?php echo req() ?>>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Descripción:</label>
                        <input class="form-control" name="descripcion" <?php echo req() ?>>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Fecha inicio:</label>
                        <input class="form-control datepicker" name="fec_inicio" <?php echo req() ?>>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="exampleInputFile">Adjuntar Documento</label>
                        <input type="file" id="exampleInputFile" name="documento">
                        <p class="help-block">Adjuntar Documento.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Encargado:</label>
                        <?php 
                            echo selectFromFont('user_id','Seleccionar', REST_CORE.'/users', array('value'=>'id_user', 'descripcion'=> 'first_name_user'), true);
                        ?>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="form-group">
                        <label>Objetivo:</label>
                        <input type="number" class="form-control" name="objetivo" <?php echo req() ?>>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>U.Tiempo</label>
                        <?php
                            echo selectFromCore('unidad_tiempo','Seleccionar', "unidad_medida_tiempo", true);
                        ?>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Ubicación:</label>
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
    if (!frm_validar('#frm-hito')) return;
    var data = getForm('#frm-hito');
    wo();
    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        url: '<?php echo base_url(BPM) ?>Pedidotrabajo/hitos/' + s_pema,
        data,
        success: function(res) {
            if (res.status) {
                console.log(res);
                $('#mdl-hito').modal('hide');
                hecho();
                reload('comp#hitos', s_pema);
                reload('#pnl-nuevo-pema', id);
                reload('#pnl-hito', id);
            }
        },
        error: function(res) {
            error();
        },
        complete: function() {
            wc();
        }
    });
}
</script>