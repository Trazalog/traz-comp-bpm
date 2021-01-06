<!-- The Modal -->
<div class="modal modal-fade" id="mdl-peta">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="xmodal-body">
                <?php 
                   echo comp('frm-peta', base_url(BPM."Pedidotrabajo/index"), true);
                ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn" data-dismiss="modal">Cancelar</button>
                <button type="button" id="btn-accion" class="btn btn-primary btn-guardar" onclick="guardarTodo()">Guardar</button>
            </div>
        </div>
    </div>
</div>