<div class="row">
    <div class="col-xs 12 col-sm-12 col-md-12">
        <h4>Hitos del pedido:</h4>
        <div id="tareas_planificadas" title="Dentro del hito se encuentran las tareas planificadas">
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
                            <ul style="list-style-type: none;">
                            <?php 
                                if(!empty($key->tareas->tarea)){
                                    foreach ($key->tareas->tarea as $tareas) {
                            ?>
                                <li>Nombre: <b><?php echo $tareas->nombre ?></b></li>
                                <li>Descripción: <b><?php echo $tareas->descripcion ?></b></li>
                                <li>Estado: <b><?php echo $tareas->estado ?></b></li>
                                <li>Asignada: <b><?php echo $tareas->user_id ?></b></li>
                                <li>Fecha Asignación: <b><?php echo $tareas->fecha ?></b></li>
                                <li>Fecha Fin: <b><?php echo $tareas->fec_fin ?></b></li>
                                <li>Case: <b><?php echo $tareas->case_id ?></b></li>
                                <li>Pedido Material: <b><?php echo $tareas->case_id ?></b></li>
                                <li>FORMULARIO: <b><?php echo $tareas->case_id ?></b></li>
                                <li>Duración: <b><?php echo $tareas->duracion ?></b></li>
                                <hr>
                            <?php
                                    }
                                }else{
                                    echo "<h5>No se planificaron tareas para este hito.</h5>";
                                }
                            ?>
                            </ul>
                        </div>
                    </div>
                </div>
            <?php
                }
            }else{
                echo "<h4>No se crearon hitos para este pedido de trabajo.</h4>";
            }
            ?>
        </div>
    </div>
</div>