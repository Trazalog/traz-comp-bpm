<style>
#contenedorImageQR img { 
    width:50%;
    height:75%;
    margin:2px auto;
}

</style>
<div id="cabecera"></div>
<input id="tarea" data-info="" class="hidden">
<input type="text" class="form-control hidden" id="asignado" value="">
<input type="text" class="form-control hidden" id="taskId" value="">
<input type="text" class="form-control hidden" id="caseId" value="">

<div class="nav-tabs-custom ">
    <ul class="nav nav-tabs">
        <!-- <li class="active"><a href="#tab_4" data-toggle="tab" aria-expanded="false">Acciones</a></li> -->
        
        <li class="active"><a href="#tab_3" data-toggle="tab" aria-expanded="false">Trazabilidad</a></li>
        <li class="privado"><a href="#tab_2" data-toggle="tab" aria-expanded="false">Comentarios</a></li>
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
                  <div id="cargar_info_actual"></div>
                </div>
                <!-- /.tab-pane -->
                <div class="tab-pane" id="tab_2">
                    <div id="cargar_comentario"></div>
                </div>
                <!-- /.tab-pane -->
                <div class="tab-pane active" id="tab_3">
                <div id="cargar_trazabilidad"></div>
                </div>

                <!-- /.tab-pane -->
                <div class="tab-pane" id="tab_5">
                    <div id="cargar_form"></div>
                </div>
        </div>
    </div>

<script>
// $(document).ready(function() { 
   
//     $("#cargar_comentario").load();
      
//       $("#cargar_form").load();

//       $("#cargar_trazabilidad").load();
  
//     }); 
     
   
</script>