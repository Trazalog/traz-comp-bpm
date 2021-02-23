<style>
.frm-save {
    display: none;
}
</style>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Nuevo Pedido de Trabajo</h3>
    </div>
    <div class="panel-body" id="div_pedido_trabajo">
        <div class="col-md-12">
            <form class="form-horizontal" id="frm-PedidoTrabajo">
                <fieldset>
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="clie_id">Cliente</label>
                        <div class="col-md-3">
                            <select id="clie_id" name="clie_id" class="form-control" required>
                                <option value="" disabled selected> - Seleccionar cliente- </option>
                                <?php 
                                if(is_array($clientes)){
                                foreach ($clientes as $i) {
                                echo "<option value = $i->clie_id>$i->nombre</option>";
                                        }                   
                                    }
                                ?>
                            </select>
                        </div>
                        <label class="col-md-2 control-label" for="objetivo">Objetivo</label>
                        <div class="col-md-2">
                            <input id="objetivo" name="objetivo" type="number" placeholder=""
                                class="form-control input-md">
                        </div>
                        <div class="col-md-2">
                            <select name="unidad_medida_tiempo" id="unidad_medida_tiempo" class="form-control">
                                <option value="" disabled selected> - Seleccionar - </option>
                                <?php 
                                if(is_array($unidad_medida_tiempo)){
                                foreach ($unidad_medida_tiempo as $i) {
                                echo "<option value = $i->tabl_id>$i->valor</option>";
                                        }                   
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="cod_proyecto">Código proyecto</label>
                        <div class="col-md-3">
                            <input id="cod_proyecto" name="cod_proyecto" type="text" placeholder="codigo"
                                class="form-control input-md">
                            <span class="help-block">ingresa el código de proyecto</span>
                        </div>
                    </div>

                    <!-- Textarea -->
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="descripcion">Descripción</label>
                        <div class="col-md-10">
                            <textarea class="form-control" id="descripcion" name="descripcion"></textarea>
                        </div>
                    </div>

                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="fec_inicio">Fecha inicio</label>
                        <div class="col-md-2">
                            <input id="fec_inicio" name="fec_inicio" type="date" placeholder=""
                                class="form-control input-md">

                        </div>

                        <label class="col-md-2 control-label" for="fec_entrega">Fecha entrega</label>
                        <div class="col-md-2">
                            <input id="fec_entrega" name="fec_entrega" type="date" placeholder=""
                                class="form-control input-md">

                        </div>
                    </div>
                    <br>

                    <!-- Button -->

                </fieldset>
            </form>
            <div class="frm-new" data-form="35"></div>
            
            <div class="form-group">
                <div class="col-md-6 col-md-offset-6">
                    <button type="button" class="btn btn-danger">Cerrar</button>

                    <button type="button" id="btn-accion" class="btn btn-primary btn-guardar"
                        onclick="guardarTodo()">Guardar</button>
                </div>

            </div> 

            <!-- ************************************************************ -->
        </div>
    </div>
</div>


<script>
function guardarTodo() {
    if ($('.frm-save').lenght == 1) {
        $('.frm-save').click();
        var info_id = $('.frm').attr('data-ninfoid');
        console.log('info_id:' + info_id);
    } else {
        guardarPedidoTrabajo()
    }
}

function frmPosGuardado() {
    guardarPedidoTrabajo();
}

$('#minimizar_tarea').click(function() {
    $('#div_tarea').toggle(1000);
});
$('#minimizar_pedido_trabajo').click(function() {
    $('#div_pedido_trabajo').toggle(1000);
});

detectarForm();
initForm();

function guardarPedidoTrabajo() {
    var formData = new FormData($('#frm-PedidoTrabajo')[0]);
    var infoId = $('.frm').attr('data-ninfoid');
    formData.append('info_id', infoId?infoId:"0");
    wo();
    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        url: '<?php echo base_url(BPM) ?>Pedidotrabajo/guardarPedidoTrabajo',
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function(rsp) {

            if (rsp.status) {
                console.log("Exito al guardar Formulario");
                Swal.fire(
                    'Guardado!',
                    'El registro se Guardo Correctamente',
                    'success'
                )
                $('#frm-PedidoTrabajo')[0].reset();
                linkTo();
                //lineas del checho #CHUKA
             //   reload('#pedidos-trabajos');
             //   $('#mdl-peta').modal('hide');
             //   reload('#frm-peta')
             //   detectarForm();
             //   initForm();
            
              } else {
                Swal.fire(
                    'Oops...',
                    'No se Guardo Pedido de Trabajo',
                    'error'
                )
            }
        },

        error: function(rsp) {
            console.log("Error al guardar Formulario");
            Swal.fire(
                'Oops...',
                'No se Guardo Pedido de Trabajo',
                'error'
            )
        },
        complete: function() {
            wc();
        }
    });
}
</script>