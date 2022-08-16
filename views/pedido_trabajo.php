<style>
.frm-save {
    display: none;
}
.espaciado{
    margin-bottom: 20px;
}
</style>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Nuevo Pedido de Trabajo</h3>
    </div>
    <div class="panel-body" id="div_pedido_trabajo">
	<input type="hidden" id="petr_id" value=""  readonly>
        <div class="row">
            <form class="form-inline" id="frm-PedidoTrabajo">
                <fieldset>
                    <!-- Codigo proyecto-->
                    <div class="col-md-6 espaciado" style="margin-bottom:5px">
                        <div class="form-group">
                            <label class="control-label" for="cod_proyecto">Código Pedido <strong style="color: #dd4b39">*</strong>:</label>
                            <input id="cod_proyecto" name="cod_proyecto" type="text" placeholder="Código Pedido"  minlength="4" maxlength="10" size="12" class="form-control input-md" data-bv-notempty data-bv-notempty-message="Campo Obligatorio *" required>
                        </div>
                    </div>
                    <!-- ***************** -->
                    <!-- Objetivo -->
                    <div class="col-md-6 espaciado">
                        <div class="form-group" style="display:inline-flex">
                            <label class="control-label" for="objetivo">Objetivo<strong style="color: #dd4b39">*</strong>:</label>
                            <div class="input-group" style="display:inline-flex;">
                                <input id="objetivo" name="objetivo" type="number" placeholder="" class="form-control input-md" min="1" data-bv-notempty data-bv-notempty-message="Campo Obligatorio *" required>
                            
                                <select name="unidad_medida_tiempo" id="unidad_medida_tiempo" class="form-control" style="width: auto" data-bv-notempty="false">
                                    <option value="" disabled selected> -Seleccionar- </option>
                                    <?php 
                                    if(is_array($unidad_medida_tiempo)){
                                    foreach ($unidad_medida_tiempo as $i) {
                                    echo "<option value = $i->tabl_id>$i->valor</option>";
                                            }                   
                                        }
                                    ?>
                                </select>
                            
                            </div>
                        </div>
                    </div>
                    <!-- ***************** -->           
                    <!-- Cliente-->
                    <div class="col-md-6 espaciado">
                        <div class="form-group">

                            <label class="control-label" for="clie_id">Cliente <strong style="color: #dd4b39">*</strong>:</label>
                            <select id="clie_id" name="clie_id" class="form-control select2" data-bv-notempty data-bv-notempty-message="Campo Obligatorio *" required>
                                <option value="" disabled selected> -Seleccionar- </option>
                                <?php 
                                if(is_array($clientes)){
                                
                                $array = json_decode(json_encode($clientes), true);

                                foreach ($array as $i) {
                                    $clie_id= $i['clie_id']; $dir_entrega=$i['dir_entrega']; $nombre= $i['nombre'];

                                    $dir_entrega= strval ($dir_entrega);

                                echo '<option value ="'.$clie_id.'" data-dir="'.$dir_entrega.'"> '.$nombre.'</option>';
                                        }
                                                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <!-- ***************** -->
                    <!-- Direccion Entrega -->
                    <div class="col-md-6 espaciado">                                            
                        <div class="form-group">
                            <label class=" control-label" for="dir_entrega" name="">Dirección de Entrega:</label>
                            <input type="text" class="form-control habilitar" id="dir_entrega" value="" readonly>
                        </div>
                    </div>
                    <!-- ***************** --> 
					<!-- Fecha Inicio-->
                    <div class="col-md-6 espaciado">
                        <div class="form-group">
                            <label class="control-label" for="fec_inicio">Fecha inicio <strong style="color: #dd4b39">*</strong>:</label>
                            <input id="fec_inicio" name="fec_inicio" type="date" placeholder="" class="form-control input-md" readonly>
                        </div>
                    </div>
                    <!-- ***************** -->
                    <!-- Fecha Entrega-->                                            
                    <div class="col-md-6 espaciado">
                        <div class="form-group">                                                
                            <label class="control-label" for="fec_entrega">Fecha entrega:</label>
                            <input id="fec_entrega" name="fec_entrega" type="date" placeholder="" class="form-control input-md">
                        </div>
                    </div>
                    <!-- ***************** -->
                    <!-- tipo trabajo -->
                    <div class="col-md-12 espaciado">
                        <div class="form-group">
                            <label class="control-label" for="tipt_id">Tipo de trabajo <strong style="color: #dd4b39">*</strong>:</label>
                            <select id="tipt_id" name="tipt_id" style="width: 100%;" class="select2 col-md-6" data-bv-notempty data-bv-notempty-message="Campo Obligatorio *" required>
                                <option value="" disabled selected> -Seleccionar- </option>
                                <!-- <option value="tipos_pedidos_trabajoneumaticos">Reparacion Neumaticos</option> 
							-->
							<?php 
                                if(is_array($tipo_trabajo)){
                                
                                $array = json_decode(json_encode($tipo_trabajo), true);

                                foreach ($array as $i) {
                                    $tabl_id= $i['tabl_id'];  $valor= $i['valor'];

                                    $valor1= strval ($valor);

                                echo '<option value ="'.$tabl_id.'"> '.$valor1.'</option>';
                                        }
                                                                }
                                ?>
                            </select>
                        </div>
                    </div>  
					 <!-- Descripción -->
					 <div class="col-md-12 espaciado">
                        <div class="form-group" style="width: 100%">                                       
                            <label class="control-label" for="descripcion">Descripción <strong style="color: #dd4b39">*</strong>:</label>
                            <div class="input-group" style="width:100%">
                                <textarea class="form-control" id="descripcion" name="descripcion" data-bv-notempty data-bv-notempty-message="Campo Obligatorio *" required></textarea>
                            </div>
                        </div>
                    </div>
                    <!-- ***************** -->
                    <br>

                    <!-- Button -->

                </fieldset>
            </form>

			<div class="col-md-12 espaciado">
			<?php  
			 $proccessname = $this->session->userdata('proccessname');

			//Si el proceso viene vacio usamos proceso estandar
			if(isset($proccessname)){
				$form_id = $this->Pedidotrabajos->procesos($proccessname)->proceso->form_id;
			}else{
				$proccessname = PRO_STD;
				$form_id = $this->Pedidotrabajos->procesos($proccessname)->proceso->form_id;
			}
		
			echo (!empty($form_id)) ? '<div class="frm-new" data-form="'.$form_id.'"></div>' : '<div class="frm-new" data-form="0"></div>';
			
			?>

 </div>
            <div class="form-group">
                <div class="col-xs-12 col-sm-12 col-md-12" style="text-align: right">
                    <button type="button" class="btn btn-danger" onclick="cerrarModal()">Cerrar</button>
                    <!-- <button type="button" id="btn-accion" class="btn btn-success btn-guardar" onclick="modalCodigos()">Imprimir</button> -->
                    <button type="button" id="btn-accion" class="btn btn-primary btn-guardar" onclick="cierraPedidoTrabajo()">Guardar</button>
                </div>

            </div>

            <!-- ************************************************************ -->
        </div>
    </div>
</div>


<script>
	//Capturo el evento de apertura del modal
	$(document).ready(function () {
		$('.select2').select2();
		
		//Script setear fecha actual en Fecha Inicio
		fecha = new Date();
		
		dia = fecha.getDate();
		mes = fecha.getMonth()+1;
		anio = fecha.getFullYear();

		if(dia<10){dia='0'+dia;} 
		if(mes<10){mes='0'+mes;}
		
		hoy = anio+'-'+mes+'-'+dia;  
		$("#fec_inicio").val(hoy);
		//Fin script
		
		$("#fec_entrega").on("change", function (e) {
			if($("#fec_entrega").val() < $("#fec_inicio").val()){
				
				Swal.fire(
						'Error...',
						'La fecha de entrega no puede ser anterior a la fecha de inicio',
						'error'
							);

				e.preventDefault();
			}
		});
	});

	$("#clie_id").change(function() {
			nuevaDireccion = $(this).children(':selected').data('dir');
			console.log(nuevaDireccion);

			$(this).next('input').focus().val(nuevaDireccion);
			$('#dir_entrega').val(nuevaDireccion);
	});

	function cerrarModal() {
			$('#mdl-peta').modal('hide');
	}

	$('#minimizar_tarea').click(function() {
			$('#div_tarea').toggle(1000);
	});
	$('#minimizar_pedido_trabajo').click(function() {
			$('#div_pedido_trabajo').toggle(1000);
	});

	detectarForm();
	initForm();

	var guardarPedidoTrabajo = function() {
			debugger;
			$('#mdl-peta').modal('hide');
		
			var formData = new FormData($('#frm-PedidoTrabajo')[0]);

			if($('.frm').attr('data-ninfoid') != undefined){
				formData.append('info_id', $('.frm').attr('data-ninfoid'));
			}else{
				formData.append('info_id', '');
			}

			wo();
			$.ajax({
					type: 'POST',
					dataType: 'JSON',
					url: '<?php echo base_url(BPM) ?>Pedidotrabajo/guardarPedidoTrabajo',
					data: formData,
					cache: false,
					contentType: false,
					processData: false,
					success: function(rsp) {
debugger;
					var result = rsp.status.toString(); 

					var pedido = rsp.data
						var num_pedido = JSON.parse(pedido);
				
					
					console.log('status esta en saliendo por success:' + result);

					console.log('se genero pedido numero:' + num_pedido);

					var petr_id = num_pedido.respuesta['petr_id'];

					$('#petr_id').val(petr_id);
				

							if (rsp.status) {
									console.log("Exito al guardar Formulario");

									const swalWithBootstrapButtons = Swal.mixin({
										customClass: {
											confirmButton: 'btn btn-success',
											cancelButton: 'btn btn-danger'
										},
										buttonsStyling: false
										})

										swalWithBootstrapButtons.fire({
										title: 'Exito!',
										text: 'Desea imprimir el pedido Número: ' +petr_id+' antes de salir?',
										type: 'success',
										showCancelButton: true,
										confirmButtonText: 'SI, Imprimir!',
										cancelButtonText: 'No, cancelar!',
										reverseButtons: true
										}).then((result) => {
											debugger;
										if (result.value) {
											modalCodigos();
										} else if (
											/* Read more about handling dismissals below */
											result.dismiss === Swal.DismissReason.cancel
										) {
											swalWithBootstrapButtons.fire(
											'Cancelado',
											'Recuerda que puedes imprimir el pedido luego',
											'info'
											)

											 $('#frm-PedidoTrabajo')[0].reset();
											 linkTo('<?php  echo BPM ?>Proceso/');
										}
										})
						

							} else {
									Swal.fire(
											'Oops...',
											'No se Guardo Pedido de Trabajo',
											'error'
									)
									console.log("Error al guardar Formulario de Pedido de trabajo");
							}
					},

					error: function(rsp) {

							var result = rsp.status.toString(); 
					
					console.log('status esta saliendo por error:' + result);

							console.log("Error al guardar Formulario");
							Swal.fire(
									'Oops...',
									'No se Guardo Formulario',
									'error'
							)
					},
					complete: function() {
							wc();
					}
			});
	}

	function modalCodigos(){
debugger;
				// if (!validarImpresion()) {
				// 	alert('Complete los campos por favor antes de imprimir');
				// 	return;
				// }

				if (band == 0) {
						// configuracion de codigo QR
						var config = {};
								config.titulo = "Pedido de Trabajo";
								config.pixel = "2";
								config.level = "S";
								config.framSize = "2";
						// info para immprimir
						var arraydatos = {};
								arraydatos.N_orden = $('#petr_id').val();
								arraydatos.Codigo_proyecto = $('#codigo_proyecto').val();
								arraydatos.Cliente = $('#clie_id option:selected').text();
								arraydatos.Medida = $('select[name="medidas_yudica"]').select2('data')[0].text;
								arraydatos.Marca = $('select[name="marca_yudica"]').select2('data')[0].text;
								arraydatos.Serie = $('#num_serie').val();
								arraydatos.Num = $('#num_cubiertas').val();
								arraydatos.Zona = $('#zona').val();
								arraydatos.Trabajo = $('select[name="tipt_id"]').select2('data')[0].text;
								arraydatos.Banda = $('select[name="banda_yudica"]').select2('data')[0].text;


						// si la etiqueta es derechazo
						arraydatos.Motivo = $('#motivo_rechazo').val();			
						// info para grabar en codigo QR
						armarInfo(arraydatos);
						//agrega codigo QR al modal impresion
						getQR(config, arraydatos, 'codigosQR/Traz-comp-Yudica');
				}
				// llama modal con datos e img de QR ya ingresados
				verModalImpresion();
				band = 1;
		}




	//Se debe validar el formulario antes de cerrar el modal
	// de lo contrario frm_validar() retorna true; y no lo es
	function cierraPedidoTrabajo(){
			idFormDinamico = "#"+$('.frm-new').find('form').attr('id');

			//valido para obtener los campos con error
			$("#frm-PedidoTrabajo").bootstrapValidator("validate");

			if($("#objetivo").val() != ""){
					if($("#unidad_medida_tiempo").val() == null){

						Swal.fire(
							'Error..',
							'Si completo objetivo, seleccione medida de tiempo',
							'error'
					);
	
							return;
					}
			}

			if(!$("#frm-PedidoTrabajo").data("bootstrapValidator").isValid()){
					Swal.fire(
							'Error..',
							'Debes completar los campos obligatorios (*)',
							'error'
					);
					return;
			}
			
			if(idFormDinamico != "#undefined"){
				frm_validar(idFormDinamico)
				if(!frm_validar(idFormDinamico)){
						Swal.fire(
								'Error..',
								'Debes completar los campos obligatorios (*)',
								'error'
						);
						return;
				}
				frmGuardar($('.frm-new').find('form'),guardarPedidoTrabajo);
			}else{
				guardarPedidoTrabajo();
			}
			

	}
</script>
