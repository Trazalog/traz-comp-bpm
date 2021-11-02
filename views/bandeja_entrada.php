<!-- Main content -->
<div class="row">
    <div id="bandeja" class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <i class="fa fa-list"></i>
                    Bandeja de Tareas
                </h3>
            </div>
            <div class="box-body table-responsive">
                <table id="tareas" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th class='text-center'></th>
                    </tr>
                </thead>

                    <tbody>
                   
                        <?php
                            #Validacion de bandeja vacia
                            if(!empty($list)){

                                foreach ($list as $f) {
                                    
                                    $id = $f->taskId;
                                    $asig = $f->idUsuarioAsignado;
                                    $nombreTarea = $f->nombreTarea;
																		$depo_id = $f->info[3]->depo_id;

																		if (filtrarbyDepo($nombreTarea, $depo_id)) {
                                    
                                      echo "<tr class='item' id='$id' data-caseId='$f->caseId' data-json='".json_encode($f)."'  style='cursor: pointer;'>";
                                    
                                      if ($asig != "") {
                                          $asig = '<i class="fa fa-user text-primary mr-2" title="' . formato_fecha_hora($f->fec_asignacion) . '"></i>';
                                      } else {
                                          $asig = '<i class="fa fa-user mr-2" style="color: #d6d9db;" title="No Asignado"></i>';
                                      }
                                      
                                      // TAREA	
                                      echo "<td><h4>$asig <proceso style='color:$f->color'>$f->nombreProceso</proceso>  |  $f->nombreTarea <small class='text-gray ml-2'><cite style='color: #707069'>case: $f->caseId</cite></small></h4>".'<p>' . substr($f->descripcion, 0, 500) .'</p>';
                                      
                                      foreach ($f->info as $o) {
                                          echo "<p class='label label-$o->color mr-2'>$o->texto</p>";
                                      }
                                      
                                      echo '</td>';
                                      echo '</tr>';
																		}
                                    
                                }
                            }else{
                                echo "<td class='text-center'><h4>Sin Tareas en este momento...</h4></td>";
                            }
                            ?>

                    </tbody>
                </table>
                <!-- /.table -->
            </div>
            <!-- /.mail-box-messages -->
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /. box -->
    <div id="miniView" class="view col-sm-8">

    </div>
</div>


<!-- /.col -->
</div>
<!-- /.row -->

<script>

$(document).ready( function () {
    $('#tareas').DataTable();
} );

$('.item').single_double_click(function() {
    wo()
    $('body').addClass('sidebar-collapse');
    $('.oculto').hide();
    $('#bandeja').removeClass().addClass('hidden-xs col-sm-4');
    // $('#miniView').html('<div class="box"><div class="overlay"><i class="fa fa-refresh fa-spin"></i></div></div>');
    $('#miniView').load('<?php echo BPM ?>Proceso/detalleTarea/' + $(this).attr('id'), function(){
        wc();   
    });
}, function() {
    linkTo('<?php echo BPM ?>Proceso/detalleTarea/' + $(this).attr('id'));
});

function closeView() {
    $('#miniView').empty();
    $('.oculto').show();
    $('#bandeja').removeClass().addClass('col-md-12');
}

$('input').iCheck({
    checkboxClass: 'icheckbox_flat',
    radioClass: 'iradio_flat'
});

</script>