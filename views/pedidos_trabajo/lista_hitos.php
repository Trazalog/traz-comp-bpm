<style>
.srow {
    background-color: #82E0AA
}
</style>
<table id="tbl-hitos" class="table table-hover t-btn">
    <thead>
        <th><button onclick="nuevoHito()" class="btn btn-sm btn-block btn-flat"><i class="fa fa-plus mr-2"></i>Nuevo Hito</button></th>
    </thead>
    <tbody>
        <?php
            foreach ($hitos as $key => $o) {
                echo "<tr>";
                echo '<td><div class="btn-group">
                        <button onclick="reload(\'#tareas_planificadas\','.$o->hito_id.');" type="button" class="btn code"><h4>'.$o->numero.'</h4><img src="http://localhost/traz-tools/lib/dist/img/user2-160x160.jpg" class="user-image" alt="User Image" data-user="'.$o->user_id.'"></button>
                        <button type="button" class="btn dropdown-toggle" data-toggle="dropdown">
                            <span class=""><i class="fa fa-ellipsis-v"></i></span>
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                            <li><a onclick="selectHito('.$o->hito_id.',\''.$o->numero.'\');$(\'#mdl-hito\').modal(\'show\')" href="#">Ver Detalle</a></li>
                            <li><a href="#">Another action</a></li>
                            <li><a href="#">Something else here</a></li>
                            <li class="divider"></li>
                            <li><a href="#">Separated link</a></li>
                        </ul>
                        </div></td>';
                echo "</tr>";
            }
        ?>
    </tbody>
</table>

<script>
var s_hito_row = false;
var s_hito =  false;
$('#tbl-hitos tbody').find('tr').click(function(){
    $(s_hito_row).removeClass('srow');
    s_hito_row = this;
    $(this).addClass('srow');
});

function selectHito(id, codigo) {
    s_hito = id;
    $('#tab-hito').click();
    reload('#tareas_planificadas', id);
    reload('#pnl-pema', id);
    reload('#pnl-nuevo-pema', id);
    reload('#pnl-hito', id); 
}

function nuevoHito() 
{
    s_hito = false;
    reload('#pnl-hito');
    $('#tab-hito').click();
    $('#mdl-hito').modal('show');
    $('#pnl-pema').empty();
}
</script>