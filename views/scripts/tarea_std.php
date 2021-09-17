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

            if (data['status']) {
                habilitar();
            } else {
                alert(data['msj']);
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
            lista.prepend(
                '<div class="item"><p class="message"><a href="#" class="name"><small class="text-muted pull-right"><i class="fa fa-clock-o"></i> 2:15</small>' +
                nombUsr + ' ' + apellUsr +
                '</a><br><br>' + comentario + '</p></div>'

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