<!-- Main content -->
<div class="row">
    <div id="bandeja" class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <i class="fa fa-list"></i>
                    Bandeja de Tareas
                </h3>
            </div>
            <div class="box-body table-responsive">
                <table id="tareas" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th class='text-center'></th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                <!-- /.table -->
            </div>
            <!-- /.mail-box-messages -->
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /. box -->
    <div id="miniView" class="view col-sm-8">

    </div>
</div>


<!-- /.col -->
</div>
<!-- /.row -->

<script>

$(document).ready( function () {
    var table = $('#tareas').DataTable({
        "processing": true,
        "serverSide": true,
        "pageLength": 10,
        "searching": true,
        "ordering": false,
        "dom": 'lfrtip',
        "language": {
            "url": "<?php echo base_url() ?>lib/bower_components/datatables.net/js/es-ar.json"
        },
        "ajax": {
            "url": "<?php echo BPM ?>Proceso/paginarServerSide",
            "type": "POST"
        },
        "createdRow": function(row, data, dataIndex) {
            $(row).attr('style', 'cursor: pointer;');
        },
        "initComplete": function() {
            var $searchInput = $('#tareas_filter input');
            // Removemos los eventos que DataTables le asigna por defecto
            $searchInput.unbind();
            $searchInput.off('.DT');
            // Asignamos nuestro evento personalizado
            $searchInput.on('keyup', function(e) {
                var value = $(this).val();
                if (value.length >= 3 || value.length === 0 || e.keyCode == 13) {
                    table.search(value).draw();
                }
            });
        }
    });
});

$(document).on('click', '.item', function() {
    var id = $(this).attr('id');
    wo();
    $('body').addClass('sidebar-collapse');
    $('.oculto').hide();
    $('#bandeja').removeClass().addClass('hidden-xs col-sm-4');
    $('#miniView').load('<?php echo BPM ?>Proceso/detalleTarea/' + id, function(){
        wc();   
    });
});

function closeView() {
    $('#miniView').empty();
    $('.oculto').show();
    $('#bandeja').removeClass().addClass('col-md-12');
}

$('input').iCheck({
    checkboxClass: 'icheckbox_flat',
    radioClass: 'iradio_flat'
});

</script>