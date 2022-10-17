<div class="row">
    <div class="col-xs 12 col-sm-12 col-md-12">
        <h4>Hitos del pedido:</h4>
        <div id="tareas_planificadas" title="Dentro del hito se encuentran las tareas planificadas">
            <?php 
            if(!empty($listadoHitos)){
                foreach ($listadoHitos as $key) {
            ?>
                <div class='form-group dataTemporal' data-json='<?php echo json_encode($key) ?>'>
                    <span data-toggle="collapse" href="#<?php echo $key->hito_id ?>" role="button" aria-expanded="false" aria-controls="<?php echo $key->hito_id ?>"> 
                        <?php echo "<b>$key->numero - $key->descripcion</b>" ?>
                    </span>
                    <div class="collapse" id="<?php echo $key->hito_id ?>">
                        <div class="card card-body">
                            <ul style="list-style-type: none;">
                                <li>Objetivo: <b><?php echo $key->objetivo ?></b></li>
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