<style>
    .srow{background-color: #82E0AA}
</style>
<div class="table-wrapper-scroll-y my-custom-scrollbar">
    <table id="tbl-pedidos" class="table table-hover text-center t-btn">
        <thead>
            <th> <button type="button" class="btn btn-sm btn-flat btn-block mr-2"><i class="fa fa-plus"></i>
                    Nuevo Pedido Trabajo
                </button></th>
        </thead>
        <tbody>
            <?php
            foreach ($ots as $key => $o) {
                echo "<tr>";
                echo '<td><div class="btn-group">
                        <button onclick="selectPeta('.$o->petr_id.',\''.$o->cod_proyecto.'\')" style="color:#FFFFFF; background-color:#'.stringColor($o->cod_proyecto).'" type="button" class="btn code"><h4>'.$o->cod_proyecto.'</h4><img src="http://localhost/traz-tools/lib/dist/img/user2-160x160.jpg" class="user-image"  alt="User Image"></button>
                        <button style="color:#FFFFFF; background-color:#'.stringColor($o->cod_proyecto).'" type="button" class="btn dropdown-toggle" data-toggle="dropdown">
                            <span class=""><i class="fa fa-ellipsis-v"></i></span>
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Action</a></li>
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
</div>
<script>
var s_pema_row = false
var s_pema =  false;
$('#tbl-pedidos tbody').find('tr').click(function(){
    $(s_pema_row).removeClass('srow');
    s_pema_row = this;
    $(this).addClass('srow');
});

function selectPeta(id, codigo) {
    s_pema = id;
    $('peta').html(codigo);
    reload('comp#hitos', id);
    emptyTareas()
}


</script>