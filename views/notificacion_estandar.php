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
            <?php echo $info ?>
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

        <div class="tab-pane active" id="tab_4">

            <?php

			echo "<button class='btn btn-success btn-tomar' onclick='tomarTarea()'>Tomar tarea</button>";

			echo "<button class='btn btn-danger  btn-soltar' style='display:none;' onclick='soltarTarea()'>Soltar tarea</button><br><br>";	
			
			?>

            <div id="view" class="box">
                <div class="overlay"></div>
                <?php echo $view ?>
            </div>
            <hr>
            <!-- <div class="text-right">
                <button type="button" class="btn btn-warning" id="btncerrarTarea" style="display:none;"
                onclick="existFunction('cerrarTareaParcial')">Finalizar Pedido con Entrega Parcial</button>
                <button class="btn btn-primary btnNotifEstandar" onclick="cerrar()">Cerrar</button>
                <button class="btn btn-success btnNotifEstandar" id="btnHecho" style="display:block;"
                    onclick="existFunction('cerrarTarea')">Hecho</button>
            </div> -->
            <div class="btn-group float-right">


<button type="button" class="btn btn-warning ml-2 mb-2 mb-2 mt-3" id="btncerrarTarea" style="display:none;" onclick="existFunction('cerrarTareaParcial')">Finalizar Pedido con Entrega Parcial</button>
<button type="button" class="btn btn-primary ml-2 mb-2 mb-2 mt-3" style="display:block;" onclick="cerrar()">Cerrar</button>
<button type="button" class="btn btn-success ml-2 mb-2 mb-2 mt-3" id="btnHecho" style="display:block;" onclick="existFunction('cerrarTarea')" style="">Hecho</button>



        </div>
        </div>
        <!-- /.tab-pane -->
    </div>
    <!-- /.tab-content -->
</div>

<?php $this->load->view('scripts/tarea_std'); ?>

<script>
debugger;
var task = <?php echo json_encode($tarea) ?>;

var nombreTarea = task.nombreTarea;


if (nombreTarea === "Entrega pedido pendiente") {
    $("#btncerrarTarea").removeAttr("style");
    $("#btnHecho").removeAttr("style");

    $("#btnHecho").prop('disabled', false);
}

$('.fecha').datepicker({
    autoclose: true
}).on('change', function(e) {
    // $('#genericForm').bootstrapValidator('revalidateField',$(this).attr('name'));
    console.log('Validando Campo...' + $(this).attr('name'));
    $('#genericForm').data('bootstrapValidator').resetField($(this), false);
    $('#genericForm').data('bootstrapValidator').validateField($(this));
});



function CerrarTarea() {
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
    	  debugger;
          if(data['status'] == true)
    	  {
    		$("#modalaviso").modal("hide");
    	    linkTo('<?php echo BPM ?>Proceso/');

            setTimeout(() => {
                Swal.fire(

                    'Perfecto!',
                    'Se Finalizó la Tarea Correctamente!',
                    'success'
                )
            }, 6000);
    	  }else{
    		$("#modalaviso").modal("hide");
            Swal.fire(

'Error!',
'NO Se Finalizó la Tarea Correctamente!',
'error'
)
           

    	  }
        },
        error: function(result) {
    		debugger;
        }
    });

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