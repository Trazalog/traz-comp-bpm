<input class="hidden" id="case_id" value="<?php echo $case_id ?>">
<?php 
  $userdata = $this->session->userdata('user_data');
  $usrId = $userdata[0]['usrId'];     // guarda usuario logueado 
  //$usrName =  $userdata[0]['usrName'];
  $usrName = $this->session->userdata['first_name'].
  //$usrLastName = $userdata[0]["usrLastName"];
  $usrLastName = $this->session->userdata['last_name'];
 

//$ci->session->userdata('empr_id');

  echo "<input type='text' class='hidden' id='usrName' value='$usrName' >";
  echo "<input type='text' class='hidden' id='usrLastName' value='$usrLastName' >";
?>
<div class="panel panel-primary">
    <div class="panel-heading">Comentarios</div>
    <div class="panel-body" style="max-height: 500px;overflow-y: scroll;">
        <ul id="listaComentarios">
            <?php
            $array = (array) $comentarios;

				foreach($array as $f){

				if(strcmp($f['userId']['userName'],'System')!=0){
                if($array){
				echo '<hr/>';
				echo '<li><h4><i class="fa fa-user mr-2" style="color: #0773BB;" title="User"></i>- '.$f['userId']["userName"].'<small style="float: right">'.date_format(date_create($f['postDate']),'H:i  d/m/Y').'</small></h4>';
				echo '<p><i class="fa fa-commenting-o mr-2" style="color: #0773BB;" title="comment"></i>'.$f['content'].'</p></li>';
				}
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

    debugger;
    var comentario = $('#comentario').val();
    if (comentario.length == 0 ) {
					
	Swal.fire({
				icon: 'error',
				title: 'Error...',
				text: 'Asegurate de escribir un comentario!',
				footer: ''
				});
		
		return;

                }
				else{

    console.log("Guardar Comentarios...");
    var id = $('#case_id').val();
    var comentario = $('#comentario').val();
    var nombUsr = $('#usrName').val();
    var apellUsr = $('#usrLastName').val();;
    $.ajax({
        type: 'POST',
        data: {
            'processInstanceId': id,
            'content': comentario
        },
        url: '<?php echo base_url(BPM) ?>Proceso/guardarComentario',
        success: function(result) {
            console.log("Submit");
            var lista = $('#listaComentarios');
            lista.prepend('<hr/><li><i class="fa fa-user mr-2" style="color: #0773BB;" title="User"></i><h4>' + nombUsr + ' ' + apellUsr +
                '<small style="float: right">Hace un momento</small></h4><i class="fa fa-commenting-o mr-2" style="color: #0773BB;" title="comment"></i><p>' + comentario + '</p></li>'
                );
            $('#comentario').val('');
        },
        error: function(result) {
            console.log("Error");
        }
    });
    }
}


// //Funcion COMENTARIOS OLD
// function guardarComentario_old() {
//     debugger;
//     var comentario = $('#comentario').val();
//     if (comentario.length == 0 ) {
					
// 	Swal.fire({
// 				icon: 'error',
// 				title: 'Error...',
// 				text: 'Asegurate de escribir un comentario!',
// 				footer: ''
// 				});
		
// 		return;

//                 }
// 				else{

   
//     console.log("Guardar Comentarios...");
//     var id = $('#case_id').val();
//     var comentario = $('#comentario').val();
//     var nombUsr = $('#usrName').val();
//     var apellUsr = $('#usrLastName').val();

//     var html = '<hr /><li><h4>' + nombUsr + ' ' + apellUsr +
//         '<small style="float: right">Hace un momento</small></h4><p>' + comentario + '</p></li>';
//     ajax({
//         type: 'POST',
//         data: {
//             'processInstanceId': id,
//             'content': comentario
//         },
//         url: 'index.php/Tarea/GuardarComentario',
//         success: function(result) {
//             var lista = $('#listaComentarios');
//             lista.prepend(html);
//             $('#comentario').val('');
//         },
//         error: function(result) {
//             console.log("Error");

//             if (!conexion()) {
//                 console.log('Navegador Offline');
//                 var task = $('#task').val() + '_comentarios';
//                 guardarEstado(task, html);
//                 var lista = $('#listaComentarios');
//                 lista.prepend(html);
//                 $('#comentario').val('');
//             }

//         }
//     });
//     }
// }
</script>