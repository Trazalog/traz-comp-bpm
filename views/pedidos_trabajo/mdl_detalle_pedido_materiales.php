<style>
.nav-tabs>li {
    font-size: 15px;
}
</style>
<div class="box" id="pnl-pedidos">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active">
                <a id="tab-lista-pedidos" href="#ptab_11" data-toggle="tab" aria-expanded="true">
                    <i class="fa fa-arrow-circle-right mr-2"></i>
                    Pedidos Tarea
                </a>
            </li>
            <li class="hidden">
                <a id="tab-detalle" href="#ptab_22" data-toggle="tab" aria-expanded="false">
                    <i class="fa fa-arrow-circle-right mr-2"></i>
                    Detalle 
                </a>
            </li>
            <!-- <li class="">
                <a href="#ptab_33" data-toggle="tab" aria-expanded="false">
                    <i class="fa fa-arrow-circle-right mr-2"></i>
                    Receta Asociada
                </a>
            </li> -->
            <li class="hidden">
                <a id="tab-nuevo-pedido" href="#ptab_44" data-toggle="tab" aria-expanded="false">
                    <i class="fa fa-arrow-circle-right mr-2"></i>
                    Nuevo Pedido
                </a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="ptab_11">
                <?php
                echo componente('lista-pedidos', base_url(BPM).'Pedidotrabajo/listadoPedidosMaterialesXTarea');
            ?>
            </div>
            <!-- /.tab-pane -->
            <div class="tab-pane" id="ptab_22">
                <?php
                    echo componente('lista-detalle', base_url(TST).'pedido/detalle');
                ?>
            </div>
            <div class="tab-pane" id="ptab_33">
                <?php
                    //   echo componente('lista-receta', base_url(TST).'pedido/verReceta');
                ?>
            </div>
            <div class="tab-pane" id="ptab_44">
                <?php
                    // echo componente('nuevo-pedido', base_url(TST) .'Pedido/verDetalle', true);
                ?>
            </div>
            <!-- /.tab-pane -->
        </div>
        <!-- /.tab-content -->
        <!-- Modal footer -->
        <div class="modal-footer">
            <button type="button" class="btn" data-dismiss="modal">Cerrar</button>
        </div>
    </div>

</div>
