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

								echo "<tr id='$petr_id' case_id='$case_id' data-json='" . json_encode($rsp) . "'>";

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
								
switch ($estado) {
  case 'estados_yudicaEN_CURSO':

    echo '<td><span data-toggle="tooltip" title="" class="badge bg-green">EN CURSO</span></td>';
     
    break;

    case 'estados_yudicaREPROCESO':
      echo '<td><span data-toggle="tooltip" title="" class="badge bg-yellow">REPROCESO</span></td>';
      break;

      case 'estados_yudicaENTREGADO':
        echo '<td><span data-toggle="tooltip" title="" class="badge bg-blue">ENTREGADO</span></td>';
        break;

        case 'estados_yudicaRECHAZADO':
          echo '<td><span data-toggle="tooltip" title="" class="badge bg-red">ENTREGADO</span></td>';
          break;
  
  default:
  echo '<td><button type="button" class="btn btn-secondary">'.$estado.'</button></td>';
    break;
}
                
							
								echo '</tr>';
						}
						?>
					</tbody>
				</table>
			</div>
    </div>
</div>
<!-- The Modal -->
<div class="modal modal-fade" id="mdl-vista">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="xmodal-body">
                <?php 
             
             $this->load->view(BPM.'pedidos_trabajo/mdl_pedido_detalle');
    
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
      petr_id = $(e).closest('tr').attr('id');

      case_id = $(e).closest('tr').attr('case_id');

				console.log('trae pedido N°: '+ petr_id)

        console.log('trae case_id N°: '+ case_id)

      
 var url = "<?php echo base_url(BPM); ?>Pedidotrabajo/cargar_detalle_comentario?petr_id="+petr_id+"&case_id="+case_id;
  

 var url1 = "<?php echo base_url(BPM); ?>Pedidotrabajo/cargar_detalle_formulario?petr_id="+petr_id+"&case_id="+case_id;
  

 var url2 = "<?php echo base_url(BPM); ?>Pedidotrabajo/cargar_detalle_linetiempo?case_id="+case_id;

 wo();
 wc();
 window.setTimeout(function(){
    $('#mdl-vista').modal('show');
  }, 7000);
 
   
     console.log(url);
     $("#cargar_comentario").empty();
      $("#cargar_comentario").load(url);
      
      console.log(url1);   
      $("#cargar_form").empty();
      $("#cargar_form").load(url1);

      console.log(url2);   
      $("#cargar_trazabilidad").empty();
      $("#cargar_trazabilidad").load(url2);
      wc();
      
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




