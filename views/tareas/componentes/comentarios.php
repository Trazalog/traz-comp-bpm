<input class="hidden" id="case_id" value="<?php echo $case_id ?>">
<?php 
  $userdata = $this->session->userdata('user_data');
  $usrId = $userdata[0]['usrId'];     // guarda usuario logueado 
  $usrName =  $userdata[0]['usrName'];
  $usrLastName = $userdata[0]["usrLastName"];
  
  echo "<input type='text' class='hidden' id='usrName' value='$usrName' >";
  echo "<input type='text' class='hidden' id='usrLastName' value='$usrLastName' >";
?>
<div class="panel panel-primary">
    <div class="panel-heading">Comentarios</div>
    <div class="panel-body" style="max-height: 500px;overflow-y: scroll;">
        <ul id="listaComentarios">
            <?php
				foreach($comentarios as $f){

				if(strcmp($f['userId']['userName'],'System')!=0){
				echo '<hr/>';
				echo '<li><h4>'.$f['userId']['firstname'].' '.$f['userId']["lastname"].'<small style="float: right">'.date_format(date_create($f['postDate']),'H:i  d/m/Y').'</small></h4>';
				echo '<p>'.$f['content'].'</p></li>';
				}
				}
				?>
        </ul>
    </div>
</div>
<textarea id="comentario" class="form-control" placeholder="Nuevo Comentario..."></textarea>
<br />
<button class="btn btn-primary" id="guardarComentario" onclick="guardarComentario()">Agregar</button>



<script>
function ajax(options) {
    if (navigator.serviceWorker.controller) {
        navigator.serviceWorker.controller.postMessage(options.data)
    }

    return $.ajax(options);
}
//Funcion COMENTARIOS
function guardarComentario() {
    console.log("Guardar Comentarios...");
    var id = $('#case_id').val();
    var comentario = $('#comentario').val();
    var nombUsr = $('#usrName').val();
    var apellUsr = $('#usrLastName').val();

    var html = '<hr /><li><h4>' + nombUsr + ' ' + apellUsr +
        '<small style="float: right">Hace un momento</small></h4><p>' + comentario + '</p></li>';
    ajax({
        type: 'POST',
        data: {
            'processInstanceId': id,
            'content': comentario
        },
        url: 'index.php/Tarea/GuardarComentario',
        success: function(result) {
            var lista = $('#listaComentarios');
            lista.prepend(html);
            $('#comentario').val('');
        },
        error: function(result) {
            console.log("Error");

            if (!conexion()) {
                console.log('Navegador Offline');
                var task = $('#task').val() + '_comentarios';
                guardarEstado(task, html);
                var lista = $('#listaComentarios');
                lista.prepend(html);
                $('#comentario').val('');
            }

        }
    });
}
</script>