<div class="box box-primary">
    <div class="box-header with-border">
        <h4 class="box-title">Listado de Pedido Trabajo</h4>
    </div>
    <div class="box-body">
			<button class="btn btn-block btn-primary" style="width: 100px; margin-top: 10px;" onclick="$('#mdl-peta').modal('show')">Agregar</button>
			<div class="box-body table-scroll table-responsive">
				<table id="tbl-pedidos" class="table table-striped table-hover">
					<thead>
							<tr>
									<th>Acciones</th>
									<th>Numero de Pedido</th>
									<th>Cliente</th>
									<th>Domicilio</th>
									<th>Tipo de Trabajo</th>
									<th>Fecha de Inicio</th>
									<th width="10%">Estado</th>
							</tr>
					</thead>
					<tbody>
						<?php
							foreach($pedidos as $rsp){

								$petr_id = $rsp->petr_id;
								$nombre_cliente = $rsp->nombre;
								$tipo = $rsp->tipo;
								$descripcion = $rsp->descripcion;
								$fec_inicio = $rsp->fec_inicio;
                $estado = $rsp->estado;
                $case_id = $rsp->case_id;
                $proc_id = $rsp->proc_id;
                $tipo_trabajo = $rsp->tipo_trabajo;
                $dir_entrega = $rsp->dir_entrega;

								echo "<tr id='$petr_id' data-json='" . json_encode($rsp) . "'>";

								echo "<td class='text-center text-light-blue'>";
								echo '<i class="fa fa-trash-o" style="cursor: pointer;margin: 3px;" title="Eliminar" onclick="EliminarPedido()"></i>';
								echo '<i class="fa fa-print" style="cursor: pointer; margin: 3px;" title="Imprimir Comprobante"></i>';
								echo '<i class="fa fa-search"  style="cursor: pointer;margin: 3px;" title="Ver Pedido" onclick="verPedido(this)"></i>';
								echo "</td>";
								echo '<td>'.$petr_id.'</td>';
                                echo '<td>'.$nombre_cliente.'</td>';
								echo '<td>'.$dir_entrega.'</td>';
                                echo '<td>'.$tipo_trabajo.'</td>';
								echo '<td>'.formatFechaPG($fec_inicio).'</td>';
								
								echo '<td>'.$estado.'</td>';
								echo '</tr>';
						}
						?>
					</tbody>
				</table>
			</div>
    </div>
</div>
<?php
  
        //informacion del proceso
        $data['info'] = '';#$this->load->view(BPM.'tareas/componentes/informacion',$data['tarea'], true);

        //LINEA DE TIEMPO
        $data['timeline'] =$this->bpm->ObtenerLineaTiempo($tarea->processId, $case_id);

        //COMENTARIOS DEL PEDIDO
        $data_aux = ['case_id' => $case_id, 'comentarios' => $this->bpm->ObtenerComentarios($case_id)];
        $data['comentarios'] = $this->load->view(BPM.'tareas/componentes/comentarios', $data_aux, true);
        
        $data['formularios'] = $this->Pedidotrabajos->getFormularios($petr_id);

        
?>
<!-- The Modal -->
<div class="modal modal-fade" id="mdl-vista">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="xmodal-body">
                <?php 
                
                   $this->load->view(BPM.'notificacion_estandar', $data);
                ?>
            </div>
            <!-- <div class="modal-footer">
                <button type="button" class="btn" data-dismiss="modal">Cancelar</button>
                <button type="button" id="btn-accion" class="btn btn-primary btn-guardar" onclick="guardarTodo()">Guardar</button>
            </div> -->
        </div>
    </div>
</div>



<?php

$this->load->view('pedidos_trabajo/mdl_pedidos_trabajo');
?>

<script>

$('#tbl-pedidos').DataTable({
        "order": [[ 0, "desc" ]]
	});


    function verPedido(e) {
				selected = $(e).closest('tr').attr('id');

				console.log('trae pedido N°: '+ selected)

            $('#mdl-vista').modal('show');       
	} 
	

function EliminarPedido(){

    const swalWithBootstrapButtons = Swal.mixin({
  customClass: {
    confirmButton: 'btn btn-success',
    cancelButton: 'btn btn-danger'
  },
  buttonsStyling: false
})

swalWithBootstrapButtons.fire({
  title: 'Estas Seguro?',
  text: "Esta accion no puede ser revertida!",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonText: 'Si, Eliminar!',
  cancelButtonText: 'No, cancelar!',
  reverseButtons: true
}).then((result) => {
  if (result.isConfirmed) {
    swalWithBootstrapButtons.fire(
      'Eliminado!',
      'Pedido de trabajo eliminado con Exioto.',
      'success'
    )
  } else if (
    /* Read more about handling dismissals below */
    result.dismiss === Swal.DismissReason.cancel
  ) {
    swalWithBootstrapButtons.fire(
      'Cancelado',
      '',
      'error'
    )
  }
})

}
   
</script>




