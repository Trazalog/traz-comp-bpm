<div class="form-group">
    <label>Tareas</label>
    <select id="tareas" class="select2 form-control" style="width: 100%;">
        <option value="0">Seleccionar...</option>
        <?php

            foreach ($tareas as $o) {
                echo '<option value="' . $o['tare_id'] . '">' . $o['nombre'] . ': ' . $o['descripcion'] . '</option>';
            }

        ?>
    </select>
</div>


<div class="box box-default collapsed-box box-solid">
    <div class="box-header with-border">
        <h3 id="tit_sub" class="box-title">Esperando Selección...</h3>

        <div class="box-tools pull-right">
            <button id="collapse" onclick="collapse(this)" type="button" class="btn btn-box-tool hidden"
                data-widget="collapse"><i class="fa fa-plus"></i>
            </button>
        </div>
        <!-- /.box-tools -->
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <ul id="subtareas" class="todo-list ui-sortable">

        </ul>
        <br>
        <button class="btn btn-primary" style="float:right" onclick="agregar_tarea()">Agregar</button>
    </div>
    <!-- /.box-body -->
</div>

<script>
var row =
    '<li><span class="handle ui-sortable-handle"><i class="fa fa-ellipsis-v"></i><i class="fa fa-ellipsis-v"></i></span><input type="checkbox" value=""><span class="text">Design a nice theme</span></li>';
$('select#tareas').select2().on('change', function() {
    var data = $(this).select2('data')[0];
    if (data.id == 0) return;
    $('#tit_sub').html(data.text);
    get_subtareas([data.id]);
});

function get_subtareas(ids) {
    $.ajax({
        type: 'POST',
        url: 'tareas/Tarea/getSubtareas',
        data: {
            ids
        },
        dataType: 'json',
        success: function(data) {
            $('#subtareas').empty();
            for (let i = 0; i < data.length; i++) {
                const element = data[i];
                $('#subtareas').append(
                    '<li data-json=\''+JSON.stringify(element)+'\'><span class="handle ui-sortable-handle"><i class="fa fa-ellipsis-v"></i> <i class="fa fa-ellipsis-v"></i></span><input type="checkbox" value="" checked><span class="text">' +
                    element.nombre + '  | ' + element.descripcion +
                    '</span><div class="tools"><i class="fa fa-edit"></i><i class="fa fa-trash-o"></i></div></li>'
                );
            }
            collapse_open('#collapse');
        },
        error: function(error) {
            alert('Error');
        }

    });
}

function agregar_tarea(data){
    $('#subtareas li').each(function(i){
         const e = $(this).data('json');
        $('#tareas_intancias tbody').append('<tr data-json=\''+JSON.stringify(e)+'\'><td>'+(i+1)+'</td><td>'+e.nombre+'</td><td>'+e.descripcion+'</td><td class="text-center">'+e.duracion_std+'</td><td class="text-right"><i class="fa fa-fw fa-times-circle text-light-blue" style="cursor: pointer;" title="Eliminar" onclick="$(this).closest(\'tr\').remove();"></i></td></tr>');
    });
}

</script>