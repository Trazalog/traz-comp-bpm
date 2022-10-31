<table class="table table-hover">
    <thead>
        <th width="10%">N° Pedido</th>
        <th>Fecha Creación</th>
        <th>Estado</th>
        <th width="10%">Acciones</th>
    </thead>
    <tbody>
        <?php

            foreach ($pedidos['data'] as $o) {
                
                echo "<tr>";
                echo "<td class='text-center'>".bolita($o->pema_id,'orange')."</td>";
                echo "<td>".formatFechaPG($o->fecha)." <small class='text-gray'><cite>case: $o->case_id</cite></small></td>";
                echo "<td>".bolita($o->estado,'blue')." </td>";
                echo "<td width='20%'><button class='btn btn-link' onclick='verDetalle($o->pema_id)'><i class='fa fa-search'></i></button><button class='btn btn-link'><i class='fa fa-times text-danger'></i></button></td>";
                echo "</tr>";
                
            }

        ?>
    </tbody>
</table>
<script>
function verDetalle(pemaId) {
    $('#tab-detalle').click();
    reload('#lista-detalle', pemaId);
}
</script>