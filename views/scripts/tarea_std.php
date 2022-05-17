<script>
//Script para Vista Standar  
initForm();
evaluarEstado();

function evaluarEstado() {

    if (task.idUsuarioAsignado != "") {
        habilitar();
    } else {
        deshabilitar();
    }
}

function habilitarInicioTareaEstandar() {
    wo();
$(".btn-soltar").show();
$(".btn-tomar").hide();
//la vista se habilita luego de iniciar la tarea.
$("#btnIniciar_tarea").show();

    
wc();
}


function habilitar() {

    $(".btn-soltar").show();
    $(".btn-tomar").hide();
    $('#view').css('pointer-events', 'auto');
    $('#view').find('.overlay').remove();
}

function deshabilitar() {
    $(".btn-soltar").hide();
    $(".btn-tomar").show();
    $('#view').css('pointer-events', 'none');
    $('#view').append('<div class="overlay"></div>');
}

function tomarTarea() {
    $.ajax({
        type: 'POST',
        data: {
            id: task.taskId
        },
        url: '<?php echo BPM ?>Proceso/tomarTarea',
        success: function(data) {
            debugger;
            var nombreTarea = task.nombreTarea;
     if (nombreTarea ==="Tarea Generica"){    
            if (data['status']) {
                habilitarInicioTareaEstandar();
            } else {
                alert(data['msj']);
            }
         } else {
            if (data['status']) {
                habilitar();
            } else {
                alert(data['msj']);
            }
         }
        },
        error: function(result) {
            alert('Error');
        },
        dataType: 'json'
    });
}
// Soltar tarea en BPM
function soltarTarea() {
    $.ajax({
        type: 'POST',
        data: {
            id: task.taskId
        },
        url: '<?php echo BPM ?>Proceso/soltarTarea',
        success: function(data) {
            debugger;
            var nombreTarea = task.nombreTarea;
     if (nombreTarea ==="Tarea Generica"){    
        if (data['status']) {
            $("#btnIniciar_tarea").hide();
            $("#btnHecho").removeAttr("style");
            $("#btnHecho").prop('disabled', true);
                deshabilitar();
            }
        }
            // toma a tarea exitosamente
            if (data['status']) {
                deshabilitar();
            }
        },
        error: function(result) {
            console.log(result);
        },
        dataType: 'json'
    });
}

function cerrar() {
    if ($('#miniView').length == 0) {
        $('#mdl-vista').modal('hide');
        linkTo('<?php echo BPM ?>Proceso');
    } else {
        existFunction('closeView');
    }
}

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
    var nombUsr = $('#usrName').val();
    var apellUsr = $('#usrLastName').val();
    var comentario = $('#comentario').val();

    $.ajax({
        type: 'POST',
        data: {
            'processInstanceId': task.caseId,
            'content': comentario
        },
        url: '<?php echo BPM ?>Proceso/guardarComentario',
        success: function(result) {
            var lista = $('#listaComentarios');
            // lista.prepend(
            //     '<div class="item"><p class="message"><a href="#" class="name"><small class="text-muted pull-right"><i class="fa fa-clock-o"></i> 2:15</small>' +
            //     nombUsr + ' ' + apellUsr +
            //     '</a><br><br>' + comentario + '</p></div>'

            // );
            lista.prepend('<li><i class="fa fa-user mr-2" style="color: #0773BB;" title="User"></i><h4>' + nombUsr + ' ' + apellUsr +
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
</script>