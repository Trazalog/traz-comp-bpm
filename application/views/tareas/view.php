<div class="box box-primary">
    <div class="box-body">
        <div class="row">
            <div class="col-sm-6">
                <?php $this->load->view('tareas/componentes/view_tareas'); ?>
            </div>
            <div class="col-sm-6">
                <?php $this->load->view('tareas/componentes/view_plantillas'); ?>
            </div>
        </div>
    </div>
</div>

<div class="box box-primary">
    <div class="box-body">
        <table class="table table-striped table-hover table-bordered" id="tareas_intancias">
            <thead class="text-light-blue" style="font-size:110%">
                <tr>
                    <th>#</td>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th class="text-center">Duración STD</th>
                    <th class="text-right">Acciones</th>
                </tr>
            </thead>
            <tbody>
               
            </tbody>
        </table>
        <button class="btn btn-primary" style="float:right" onclick="guardar_instancias()">Guardar</button>
    </div>
</div>

<script>
function guardar_instancias() {
    var ids = [];

    $('#tareas_intancias tbody tr').each(function() {
        ids.push($(this).data('json').suta_id);
    });

    $.ajax({
        type: 'POST',
        url: 'tareas/Tarea/setInstanciasTareas',
        data: {
            ids
        },
        success: function(data) {
           alert('Holis');
        },
        error: function(error) {
            alert('Error');
        }

    });
    
}
</script>