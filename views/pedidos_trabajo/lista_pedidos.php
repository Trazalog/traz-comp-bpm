<style>
.srow {
    background-color: #82E0AA
}
.petr-finalizado{
    display: none
}
.tarea {
    text-align: left;
    flex-grow: 1;
}
.btnPedidoTrabajo {
    border-radius: 0;
    -webkit-box-shadow: none;
    -moz-box-shadow: none;
    box-shadow: none;
    border-width: 1px;
    width: auto;
}
</style>
<div class="table-wrapper-scroll-y my-custom-scrollbar">
    <table id="tbl-pedidos" class="table table-hover text-center t-btn">
        <thead>
            <th> <button type="button" class="btn btn-sm btn-flat btn-block mr-2"
                    onclick="$('#mdl-peta').modal('show')"><i class="fa fa-plus"></i>
                   <cite> Nuevo Pedido Trabajo</cite>
                </button></th>
        </thead>
        <tbody>
            <?php
            foreach ($ots as $key => $o) {
                echo "<tr class='block-disabled'>";
                echo "<td class='".((strpos($o->estado,'FINALIZADO') !== FALSE)?'petr-finalizado':'')."' data-json='".json_encode($o)."'>";
                echo '<div class="btn-group">
                        <button onclick="selectPeta('.$o->petr_id.',\''.$o->cod_proyecto.'\')" style="color:#FFFFFF; background-color:'.stringColor($o->cod_proyecto, (strpos($o->estado,'FINALIZADO') !== FALSE)?0.3:1).'" type="button" class="btn code"><cite><h5 class="box-title pull-left">'.$o->cod_proyecto.'</h5></cite></button>
                        <button style="color:#FFFFFF; background-color:'.stringColor($o->cod_proyecto, (strpos($o->estado,'FINALIZADO') !== FALSE)?0.3:1).'" type="button" class="btn dropdown-toggle" data-toggle="dropdown">
                            <span class=""><i class="fa fa-ellipsis-v"></i></span>
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>';
                echo '<ul class="dropdown-menu" role="menu">';
                echo "<li><a href='#' onclick='finalizarTrabajo(this)'><i class='fa fa-check mr-2'></i><estado>".((strpos($o->estado,'FINALIZADO') !== FALSE)?'Finalizado':'Trabajo Terminado')."</estado></a></li>";
                echo '</ul> </div></td>';
                echo "</tr>";
            }
        ?>
        </tbody>
    </table>
</div>
<script>
function finalizarTrabajo(obj) {
    var data = {};
    var datos = JSON.parse($(obj).closest('td').attr('data-json'));
    data.estado = 'estados_procesosTRABAJO_TERMINADO';
    data.case_id = datos.case_id;
    data.proc_id = datos.proc_id;
    data.petr_id = datos.petr_id;
    wo();
    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        url: `<?php echo base_url(BPM)?>Pedidotrabajo/finalizarTrabajo`,
        data: data,
        success: function(res) {
            if (res.status) {
                if ($(obj).hasClass('petr-finalizado')) {
                    $(obj).removeClass('petr-finalizado')
                    $(obj).find('estado').html('Marcar como Finalizado');
                    $(obj).closest('tr').find('.btn').css('opacity', '1');
                } else {
                    $(obj).addClass('petr-finalizado')
                    $(obj).find('estado').html('Finalizado');
                    $(obj).closest('tr').find('.btn').css('opacity', '0.3');
                }
            }
        },
        error: function(res) {
            error();
        },
        complete: function() {
            wc();
        }
    });
}
var s_pema_row = false;
var s_pema = false;
var case_id_pedido_trabajo = '';
var proc_id_pedido_trabajo = '';
$('#tbl-pedidos tbody').find('tr').click(function() {
    $(s_pema_row).removeClass('srow');
    s_pema_row = this;
    var data = getJson($(s_pema_row).find('td'));
    case_id_pedido_trabajo = data.case_id;
    proc_id_pedido_trabajo = data.proc_id;
    $(this).addClass('srow');
});

function selectPeta(id, codigo) {
    s_pema = id;
    $('peta').html(codigo);
    reload('comp#hitos', id);
    emptyTareas();
}
</script>