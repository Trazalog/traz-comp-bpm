<?php echo $cabecera; ?>

<input id="tarea" data-info="" class="hidden">
<input type="text" class="form-control hidden" id="asignado" value="<?php echo $tarea->idUsuarioAsignado?>">
<input type="text" class="form-control hidden" id="taskId" value="<?php echo $tarea->taskId?>">
<input type="text" class="form-control hidden" id="caseId" value="<?php echo $tarea->caseId?>">

<div class="nav-tabs-custom ">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab_4" data-toggle="tab" aria-expanded="false">Acciones</a></li>
        <li class="privado"><a href="#tab_2" data-toggle="tab" aria-expanded="false">Comentarios</a></li>
        <li class="privado"><a href="#tab_3" data-toggle="tab" aria-expanded="false">Trazabilidad</a></li>
        <li class="privado"><a href="#tab_1" data-toggle="tab" aria-expanded="true">Información</a></li>
        <!-- <li class="dropdown">
			<a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
				Dropdown <span class="caret"></span>
			</a>
			<ul class="dropdown-menu">
				<li role="presentation"><a role="menuitem" tabindex="-1" href="#">Action</a></li>
				<li role="presentation"><a role="menuitem" tabindex="-1" href="#">Another action</a></li>
				<li role="presentation"><a role="menuitem" tabindex="-1" href="#">Vista Global</a></li>
				<li role="presentation" class="divider"></li>
				<li role="presentation"><a role="menuitem" tabindex="-1" href="#">Separated link</a></li>
			</ul>
		</li> -->
        <!-- <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li> -->
    </ul>
    <div class="tab-content">
        <div class="tab-pane" id="tab_1">
            <?php echo timelineInfoActual($timeline) ?>
        </div>
        <!-- /.tab-pane -->
        <div class="tab-pane" id="tab_2">
            <?php echo $comentarios ?>
        </div>
        <!-- /.tab-pane -->
        <div class="tab-pane" id="tab_3">
            <?php echo timeline($timeline) ?>
        </div>
        <!-- /.tab-pane -->
        <div class="tab-pane" id="tab_5">
        </div>
        <!-- /.tab-pane -->
        <div class="tab-pane active" id="tab_4">
            <?php
                echo "<button class='btn btn-success btn-tomar' onclick='tomarTarea()'>Tomar tarea</button>";
                echo "<button class='btn btn-danger  btn-soltar' style='display:none;' onclick='soltarTarea()'>Soltar tarea</button>";
			?>
            <button class='btn btn-success btn-iniciar pull-right' style='display:none;margin-right: 20%;' name="btnIniciar_tarea" id="btnIniciar_tarea" onclick="existFunction('IniciarTarea')">
                <i style='margin-right: 4px;' class="fa fa-play-circle" aria-hidden="true"></i>Inicializar tarea
            </button>
            <div style='margin-right: 10px' id="view" class="box">
                <div class="overlay"></div>
                <?php echo $view ?>
            </div>
            <div class="btn-group float-right">
                <button type="button" class="btn btn-warning ml-2 mb-2 mb-2 mt-3" id="btncerrarTarea" style="display:none;" onclick="existFunction('cerrarTareaParcial')">Finalizar Pedido con Entrega Parcial</button>
                <button type="button" class="btn btn-primary ml-2 mb-2 mb-2 mt-3" id="btnCerrarVistaNotificacion" style="display:block;" onclick="cerrar()">Cerrar</button>
                <button type="button" class="btn btn-success ml-2 mb-2 mb-2 mt-3" id="btnHecho" style="display:block;" onclick="existFunction('cerrarTarea')" style="">Hecho</button>
            </div>
        </div>
        <!-- /.tab-pane -->
    </div>
    <!-- /.tab-content -->
</div>



<script>
var task = <?php echo json_encode($tarea) ?>;
var nombreTarea = task.nombreTarea;

if (nombreTarea === "Entrega pedido pendiente") {
    $("#btncerrarTarea").removeAttr("style");
    $("#btnHecho").removeAttr("style");
    $("#btnHecho").prop('disabled', false);

} else if (nombreTarea ==="Tarea Generica"){
    // $btn-soltar
    $("#btnHecho").removeAttr("style");
    $("#btnHecho").text("Finalizar tarea");
    $("#btnHecho").prop('disabled', true); 
}

$('.fecha').datepicker({
    autoclose: true
}).on('change', function(e) {
    // $('#genericForm').bootstrapValidator('revalidateField',$(this).attr('name'));
    console.log('Validando Campo...' + $(this).attr('name'));
    $('#genericForm').data('bootstrapValidator').resetField($(this), false);
    $('#genericForm').data('bootstrapValidator').validateField($(this));
});

var case_id = task.caseId;
var date = moment(); 
var fec_inicio = String(date.format("YYYY-MM-DD HH:MM:s")); 
var fec_fin = String(date.format("YYYY-MM-DD HH:MM:s")); 

////////////////////////////////////////////////////////
//Inicia la tarea tomada en notificacion estandar
function IniciarTarea() {
    url = '<?php echo TST ?>Tarea/iniciarTareaPlanificada/'+fec_inicio+'/'+case_id;
    $.ajax({
        type: 'POST',
        url: url,
        success: function(data) {
            rsp = JSON.parse(data);
            if(rsp.status == true){
                hecho('Perfecto!', 'Se inicio la tarea correctamente!');
                // $("#btnIniciar_tarea").prop('disabled', true);
                // $("#btnTerminar_tarea").prop('disabled', false);
                $('#view').css('pointer-events', 'auto');
                $('#view').find('.overlay').remove();
                $("#btnIniciar_tarea").prop('disabled',true);
                $("#btnHecho").prop('disabled', false);
                $("#listadoSubtareas").show();
                $("#formularioTarea").show();
            }else{
                error('Error!','No se inicio la tarea correctamente!');
            }
        },
        error: function(result) {
            error('Error!','Se produjo un error al iniciar la tarea');
        }
    });
}

////////////////////////////////////////////////////////
//Termina la tarea tomada en notificacion estandar
function TerminarTarea() {
   url = '<?php echo TST ?>Tarea/terminarTareaPlanificada/'+fec_fin+'/'+case_id,
    $.ajax({
        type: 'POST',
        url: url,
        success: function(data) {
          rsp = JSON.parse(data);

          if(rsp.status == true){
              // $("#btnIniciar_tarea").prop('disabled', true);
              // $("#btnTerminar_tarea").prop('disabled', false);
              $('#view').css('pointer-events', 'auto');
              $('#view').find('.overlay').remove();
              $("#btnIniciar_tarea").hide();
              $("#btnHecho").prop('disabled', false);

              hecho('Perfecto!','Se terminó la tarea correctamente!');
    	  }else{
            error('Error!','Se produjo un error al finzalizar la tarea!');
    	  }
        },
        error: function(result) {
    		error('Error!','Se produjo un error al intentar finzalizar la tarea!');
        }
    });

}

////////////////////////////////////////////////////////
//cerrar tarea en notificacion estandar
function CerrarTarea() {
    if (nombreTarea ==="Tarea Generica"){
        terminarTareaPlanificada();
        var caseid = task.caseId;
        var taskid = task.taskId;
        $.ajax({
            type: 'POST',
            data: {
                'IdtarBonita': taskid,
                'caseid':caseid
            },
            url: '<?php base_url() ?>index.php/<?php echo BPM ?>Proceso/cerrarTarea/' + taskid,
            success: function(data) {
                if(data['status'] == true){
                    $("#modalaviso").modal("hide");
                    var fun = () => {linkTo('<?php echo BPM ?>Proceso/');}
                    confRefresh(fun);
                }else{
                    $("#modalaviso").modal("hide");
                    error('Error!','No se finalizó la tarea Correctamente!');
                }
            },
            error: function(result) {
                debugger;
            }
        });
    } else{
        ////////////////////////////////////////////////////////
        //cerrar tarea en notificacion estandar
        var caseid = task.caseId;
        var taskid = task.taskId;
        $.ajax({
            type: 'POST',
            data: {
                'IdtarBonita': taskid,
                'caseid':caseid
            },
            url: '<?php base_url() ?>index.php/<?php echo BPM ?>Proceso/cerrarTarea/' + taskid,
            success: function(data) {
                if(data['status'] == true){
                    $("#modalaviso").modal("hide");
                    var fun = () => {linkTo('<?php echo BPM ?>Proceso/');}
                    confRefresh(fun);
                }else{
                    $("#modalaviso").modal("hide");
                    error('Error!','No se finalizó la tarea correctamente!');
                }
            },
            error: function(result) {
                error('Error!','No se finalizó la tarea correctamente!');
            }
        });
    }
}
</script>

<div class="modal fade bs-example-modal-lg" id="modalFormSubtarea" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="row">
                <div class="col-sm-12">
                    <div class="box">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-sm-12 col-md-12" id="contFormSubtarea">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('scripts/tarea_std'); ?>