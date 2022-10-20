<style>
    #tareas_planificadas ul{
        background-color: #e1e1e1;
        border-radius: 35px;
        border: 1px solid black;
    }
</style>
<div class="row">
    <div class="col-xs 12 col-sm-12 col-md-12">
        <div id="tareas_planificadas" title="Click para ver detalle">
            <?php 
            if(!empty($listadoHitos)){
                foreach ($listadoHitos as $key) {
            ?>
                <div class='form-group' data-json='<?php echo json_encode($key) ?>'>
                    <button class="btn btn-primary item-tarea-planificada" data-toggle="collapse" href="#<?php echo $key->hito_id ?>" role="button" aria-expanded="false" aria-controls="<?php echo $key->hito_id ?>"> 
                        <?php echo "<b>$key->numero - $key->descripcion</b>" ?>
                    </button>
                    <div class="collapse" id="<?php echo $key->hito_id ?>">
                        <div class="card card-body">
                            <?php 
                                if(!empty($key->tareas->tarea)){
                                    foreach ($key->tareas->tarea as $tareas) {
                            ?>
                            <ul>
                                <div data-json='<?php echo json_encode($tareas) ?>'>
                                    <li><u>Nombre</u>: <b><?php echo $tareas->nombre ?></b></li>
                                    <li><u>Descripción</u>: <b><?php echo $tareas->descripcion ?></b></li>
                                    <li><u>Estado</u>: <b><?php echo $tareas->estado ?></b></li>
                                    <li><u>Asignada</u>: <b><?php echo $tareas->user_id ?></b></li>
                                    <li><u>Fecha</u> Asignación: <b><?php echo $tareas->fecha ?></b></li>
                                    <li><u>Fecha</u> Fin: <b><?php echo $tareas->fec_fin ?></b></li>
                                    <li><u>Case</u>: <b><?php echo $tareas->case_id ?></b></li>
                                    <li><u>Duración</u>: <b><?php echo $tareas->duracion ?></b></li>
                                    <li><u>Pedido de Materiales</u>: <a class="btn btn-sm btn-link" title="Pedido de materiales" onclick="verDetallePedido(this);">Ver detalle</a></li>
                                    <li><u>Formulario Asociado</u>: <a class="btn btn-sm btn-link" title="Formulario asociado a la tarea" onclick="showForm(this)">Ver detalle</a></li>
                                </div>
                            </ul>
                            <?php
                                    }
                                }else{
                                    echo "<h5 class='centrar'>No se planificaron tareas para este hito.</h5>";
                                }
                            ?>
                        </div>
                    </div>
                </div>
            <?php
                }
            }else{
                echo "<h4 class='centrar'>No se crearon hitos para este pedido de trabajo.</h4>";
            }
            ?>
        </div>
    </div>
</div>