<!-- The Modal -->
<div class="modal modal-fade" id="mdl-hito">
    <div class="modal-dialog modal-lg" id="mdl-hito">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a id="tab-hito" href="#tab_1" data-toggle="tab">Nuevo Hito</a></li>
                <li><a id="pema-list" href="#tab_2" data-toggle="tab">Pedido Materiales</a></li>
                <li class="hidden"><a id="nuevo_pedido" href="#tab_3" data-toggle="tab">Tab 3</a></li>
                <li class="hidden"><a id="entregas_pedido" href="#tab_4" data-toggle="tab">Tab 4</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                    <div class="modal-body">
                        <?php echo comp('pnl-hito', base_url(BPM.'Pedidotrabajo/hito')) ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-success" onclick="guardarHito()">Guardar</button>
                    </div>
                </div>
                <!-- /.tab-pane -->
                <div class="tab-pane" id="tab_2">
                    <button class="btn btn-primary" onclick="nuevoPedido()"><i class="fa fa-plus mr-2"></i>Nuevo Pedido</button><br><br>
                    <?php 
                        echo comp('pnl-pema', base_url(ALM.'notapedido/obtenerXOrigen/HITOS'));
                    ?>
                </div>
                <!-- /.tab-pane -->
                <div class="tab-pane" id="tab_3">
                    <div class="modal-body">
                        <?php  echo comp('pnl-nuevo-pema', base_url(ALM.'notapedido/nuevo/HITOS')); ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-success" onclick="guardarPedido2()">Guardar</button>
                    </div>

                </div>
                <div class="tab-pane" id="tab_4">
                    Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                    Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,
                    when an unknown printer took a galley of type and scrambled it to make a type specimen book.
                    It has survived not only five centuries, but also the leap into electronic typesetting,
                    remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset
                    sheets containing Lorem Ipsum passages, and more recently with desktop publishing software
                    like Aldus PageMaker including versions of Lorem Ipsum.
                </div>
                <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
        </div>
    </div>
</div>

<script>
function nuevoPedido() {
    if(s_hito) $('#nuevo_pedido').click();
    else{
        error('Oops!', 'Para crear pedidos debes crear o seleccionar un hito antes');
        $('#tab-hito').click();
    }
}
</script>