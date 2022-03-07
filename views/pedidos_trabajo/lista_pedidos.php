<style>
.srow {
    background-color: #82E0AA
}
.petr-finalizado{
    color: #00a65a !important
}
/* .block-disabled{
     background 
} */
</style>
<div class="table-wrapper-scroll-y my-custom-scrollbar">
    <table id="tbl-pedidos" class="table table-hover text-center t-btn">
        <thead>
            <th> <button type="button" class="btn btn-sm btn-flat btn-block mr-2"
                    onclick="$('#mdl-peta').modal('show')"><i class="fa fa-plus"></i>
                    Nuevo Pedido Trabajo
                </button></th>
        </thead>
        <style>
          .tarea {
                    display:inline-block;
                    text-align: left;
                    white-space: none;
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
        <tbody>
            <?php
            foreach ($ots as $key => $o) {
                echo "<tr class='block-disabled'>";
                echo '<td><div class="btn-group">
                        <button onclick="selectPeta('.$o->petr_id.',\''.$o->cod_proyecto.'\')" style="color:#FFFFFF; background-color:'.stringColor($o->cod_proyecto, (strpos($o->estado,'FINALIZADO') !== FALSE)?0.3:1).'" type="button" class="tarea"><cite><h5 class="box-title pull-left">'.$o->cod_proyecto.'</h5></cite></button>
                        <button style="color:#FFFFFF; background-color:'.stringColor($o->cod_proyecto, (strpos($o->estado,'FINALIZADO') !== FALSE)?0.3:1).'" type="button" class="btn dropdown-toggle" data-toggle="dropdown">
                            <span class=""><i class="fa fa-ellipsis-v"></i></span>
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>';
                echo '<ul class="dropdown-menu" role="menu">';
      
                echo "<li><a class='".((strpos($o->estado,'FINALIZADO') !== FALSE)?'petr-finalizado':'')."' href='#' onclick='cambiarEstado($o->petr_id, this)'><i class='fa fa-check mr-2'></i><estado>".((strpos($o->estado,'FINALIZADO') !== FALSE)?'Finalizado':'Marcar como Finalizado')."</estado></a></li>";
            
                echo '</ul> </div></td>';
                echo "</tr>";
            }
        ?>
        </tbody>
    </table>
</div>
<script>
function cambiarEstado(petrId, obj) {
    var estado = $(obj).hasClass('petr-finalizado') ? 'EN CURSO' : 'FINALIZADO';
    wo();
    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        url: `<?php echo base_url(BPM)?>Pedidotrabajo/cambiarEstado`,
        data: {
            petrId,
            estado
        },
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
var s_pema_row = false
var s_pema = false;
$('#tbl-pedidos tbody').find('tr').click(function() {
    $(s_pema_row).removeClass('srow');
    s_pema_row = this;
    $(this).addClass('srow');
});

function selectPeta(id, codigo) {
	debugger;
    s_pema = id;
    $('peta').html(codigo);
    reload('comp#hitos', id);
    emptyTareas()
}
</script>