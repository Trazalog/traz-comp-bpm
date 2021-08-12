<div class="box box-primary">
    <div class="box-header with-border">
        <h4 class="box-title">Listado de Pedido Trabajo</h4>
    </div>
    <div class="box-body">
        <button class="btn btn-block btn-primary" style="width: 100px; margin-top: 10px;"
            onclick="$('#mdl-peta').modal('show')">Agregar</button>
            <br>
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
								echo '<i class="fa fa-trash-o" style="cursor: pointer;margin: 3px;" title="Eliminar" onclick="Eliminar(this)"></i>';
								echo '<i class="fa fa-print" style="cursor: pointer; margin: 3px;" title="Imprimir Comprobante" onclick="modalReimpresion(this)"></i>';
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
													echo '<td><span data-toggle="tooltip" title="" class="badge bg-red">RECHAZADO

													</span></td>';
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

<?php
//HGallardo
    // carga el modal de impresion de QR
    $this->load->view( COD.'componentes/modal');
?>

<script>
	// $('#tbl-pedidos').DataTable({
	//         "order": [[ 0, "desc" ]]
	// 	});


	//   $(document).ready(function() {
	//     $('#tbl-pedidos').DataTable( {
	//         dom: 'Bfrtip',
	//         buttons: [
	//             'copy', 'csv', 'excel', 'pdf', 'print'
	//         ]
	//     } );
	// } );


	$(document).ready(function() {
			$('#tbl-pedidos').DataTable({
					dom: 'Bfrtip',
			
					buttons: [{
									extend: 'copy',
									text: 'Copiar al Portapapeles',
									className: 'btn btn-warning'
							},
							{
									extend: 'pdf',
									text: 'Exportar pdf',
									className: 'btn btn-danger'
							},
							{
									extend: 'csv',
									text: 'Exportar Excel',
									className: 'btn btn-success'
							},
							{
							extend: 'print',
							text: 'Imprimir',
							className: 'btn btn-primary'
					}
					]
			});
	});



	function verPedido(e) {
			petr_id = $(e).closest('tr').attr('id');

			case_id = $(e).closest('tr').attr('case_id');

			console.log('trae pedido N°: ' + petr_id)

			console.log('trae case_id N°: ' + case_id)


			var url = "<?php echo base_url(BPM); ?>Pedidotrabajo/cargar_detalle_comentario?petr_id=" + petr_id + "&case_id=" +
					case_id;


			var url1 = "<?php echo base_url(BPM); ?>Pedidotrabajo/cargar_detalle_formulario?petr_id=" + petr_id + "&case_id=" +
					case_id;


			var url2 = "<?php echo base_url(BPM); ?>Pedidotrabajo/cargar_detalle_linetiempo?case_id=" + case_id;

			wo();
			wc();
			window.setTimeout(function() {
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


	function Eliminar(e) {

			debugger;

			petr_id = $(e).closest('tr').attr('id');

			case_id = $(e).closest('tr').attr('case_id');

			console.log('trae pedido N°: ' + petr_id);

			console.log('trae case_id N°: ' + case_id);


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
					debugger;
					console.log(result);
					if (result.value) {
							console.log('sale por verdadero');
							EliminarPedidoTrabajo()


					} else if (result.dismiss === Swal.DismissReason.cancel) {
							console.log('sale por falso');
							swalWithBootstrapButtons.fire(
									'Cancelado',
									'',
									'error'
							)
					}
			})

	}


	function EliminarPedidoTrabajo() {

			debugger;



			$.ajax({
					type: 'GET',
					data: petr_id,
					case_id,
					cache: false,
					contentType: false,
					processData: false,
					url: '<?php base_url() ?>index.php/<?php echo BPM ?>Pedidotrabajo/eliminarPedidoTrabajo/?petr_id=' +
							petr_id + '&case_id=' + case_id,
					success: function(rsp) {
							debugger;
							console.log('data trae:' + rsp)

							linkTo('<?php  echo BPM ?>Pedidotrabajo/');
							setTimeout(() => {
									Swal.fire(

											'Perfecto!',
											'Se Elimino Pedido Correctamente!',
											'success'
									)
							}, 5000);


					},
					error: function(rsp) {
							alert("Error");
					}
			});


	}
</script>

<script>
//#HGALLARDO
	//Impresion Pedido Trabajo
		var band = 0;
		// Se peden hacer dos cosas: o un ajax con los datos o directamente
		// armar con los datos de la pantalla
		function modalCodigos(){

				if (!validarImpresion()) {
					alert('Complete los campos por favor antes de imprimir');
					return;
				}

				if (band == 0) {
						// configuracion de codigo QR
						var config = {};
								config.titulo = "Pedido de Trabajo";
								config.pixel = "5";
								config.level = "L";
								config.framSize = "2";
						// info para immprimir
						var arraydatos = {};
								arraydatos.Trabajo = $('#tipt_id option:selected').val();
								arraydatos.Cliente = $('#clie_id option:selected').text();
								arraydatos.Medida = $('select[name="medidas_yudica"] option:selected').val();
								arraydatos.Marca = $('select[name="marca_yudica"] option:selected').val();
								arraydatos.Serie = $('#num_serie').val();
						// info para grabar en codigo QR
						armarInfo(arraydatos);
						//agrega codigo QR al modal impresion
						getQR(config, arraydatos);
				}
				// llama modal con datos e img de QR ya ingresados
				verModalImpresion();
				band = 1;
		}

		function armarInfo(arraydatos){

			$("#infoEtiqueta").load("<?php echo base_url(YUDIPROC); ?>/Infocodigo/pedidoTrabajo", arraydatos);
		}

		function validarImpresion(){

			var cli = $('#clie_id option:selected').val();
			var medida = $('select[name="medidas_yudica"] option:selected').val();
			var marca = $('select[name="marca_yudica"] option:selected').val();
			var serie = $('#num_serie').val();
			if ( cli == "" || medida == "" || marca == "" || serie == "" ) {
				return false;
			} else {
				return true;
			}


		}


	// REIMPRESION ETIQUETA VIENE DEL LISTADO
  function modalReimpresion(e){

			$("#infoEtiqueta").empty();
			$("#contenedorCodigo").empty();
			$("#infoFooter").empty();
			// configuracion de codigo QR
			var config = {};
			config.titulo = "Revision Inicial";
			config.pixel = "5";
			config.level = "L";
			config.framSize = "2";

			arraydatos = $(e).closest('tr').attr('data-json');
			var datos = JSON.parse(arraydatos);
			// llama modal con datos e img de QR
			getDatos(datos, config);
			// levanta modal completo para su impresion
			verModalImpresion();
  }
	// obtine datos ya mapeados para QR y cuerpo de a etiqueta
	function getDatos(datos, config){

		var infoid = datos.info_id;
		var estado = datos.estado;
		var cliente = datos.nombre;
		var trabajo = datos.tipo_trabajo;

		$.ajax({
				type: 'GET',
				url: "<?php echo base_url(YUDIPROC); ?>Infocodigo/mapeoDatos/" + infoid,
				success: function(result) {

							var datMapeado = JSON.parse(result);
							datMapeado.Cliente = cliente;
							datMapeado.Trabajo = trabajo;
							console.log('data mapeado: ');
							console.table(datMapeado);
							cargarInfoReimp(datMapeado, estado, config);
				},
				error: function(result){

				},
				complete: function(){

				}
		});

	}
	//  carga el modal con cuerpo y codigo QR
	function cargarInfoReimp(datMapeado, estado, config){

			switch (estado) {
					case 'estados_yudicaEN_CURSO':
						//Comprobante 1
						//agrega cuerpo de la etiqueta
						$("#infoEtiqueta").load("<?php echo base_url(YUDIPROC); ?>Infocodigo/pedidoTrabajo", datMapeado);
						// agrega codigo QR al modal impresion
						getQR(config, datMapeado);
						break;

					case 'estados_yudicaREPROCESO':
						//Comprobante 1
						$("#infoEtiqueta").load("<?php echo base_url(YUDIPROC); ?>Infocodigo/pedidoTrabajo", datMapeado);
						// agrega codigo QR al modal impresion
						getQR(config, datMapeado);
						break;

					case 'estados_yudicaRECHAZADO':
						//Comprobante 2
						$("#infoEtiqueta").load("<?php echo base_url(YUDIPROC); ?>Infocodigo/rechazado", datMapeado);
						// agrega codigo QR al modal impresion
						getQR(config, datMapeado);
						break;

					case 'estados_yudicaENTREGADO':
						// Comprobante 3
						$("#infoEtiqueta").load("<?php echo base_url(YUDIPROC); ?>Infocodigo/pedidoTrabajo", datMapeado);
						// agrega codigo QR al modal impresion
						getQR(config, datMapeado);
						$("#infoFooter").load("<?php echo base_url(YUDIPROC); ?>Infocodigo/pedidoTrabajoFooter");
						break;

					default:
						// code...
						break;
			}

			return;
	}



</script>