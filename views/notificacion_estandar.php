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
        <li class="privado"><a href="#tab_5" data-toggle="tab" aria-expanded="true">Formulario</a></li>
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
            <?php ?>
<br>
<h3>Formularios</h3>
<br><br>
            <div class="table-responsive-md">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Acciones</th>
                            <th scope="col">Paso del Proceso</th>
                            <th scope="col">Nombre de Formulario</th>
                        </tr>
                    </thead>
                    <tbody>
                       <?php foreach($formularios as $rsp){

                           $info_id = $rsp->info_id;
                           $nom_tarea = $rsp->nom_tarea;
                           $task_id = $rsp->task_id;

                          echo "<tr id='$' data-json='" . json_encode($rsp) . "'>"; 
                          echo '<td>'.$nom_tarea.'</td>';
                          echo '<td>'.$info_id.'</td>';
						  echo '<td>'.$task_id.'</td>';
                          echo '</tr>';
                        } 
                           ?>
                    </tbody>
                </table>
            </div>
<br><br><br>
        </div>

        <div class="tab-pane active" id="tab_4">

            <?php

			echo "<button class='btn btn-success btn-tomar' onclick='tomarTarea()'>Tomar tarea</button>";

			echo "<button class='btn btn-danger  btn-soltar' onclick='soltarTarea()'>Soltar tarea</button><br><br>";	
			
			?>

            <div id="view" class="box">
                <div class="overlay"></div>
                <?php echo $view ?>
            </div>
            <hr>
            <div class="text-right">
                <button class="btn btn-primary btnNotifEstandar" onclick="cerrar()">Cerrar</button>
                <button class="btn btn-success btnNotifEstandar" onclick="existFunction('cerrarTarea')">Hecho</button>
            </div>

        </div>
        <!-- /.tab-pane -->
    </div>
    <!-- /.tab-content -->
</div>


<script>
var task = <?php echo json_encode($tarea) ?>;
</script>
<?php $this->load->view('scripts/tarea_std'); ?>