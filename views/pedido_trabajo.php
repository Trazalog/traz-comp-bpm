<style>
.frm-save {
    display: none;
}
.espaciado{
    margin-bottom: 20px;
}
</style>

<?php 
        //obtengo processname

$proccessname = $this->session->userdata('proccessname'); 


?>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Nuevo Pedido de Trabajo</h3>
    </div>
    <div class="panel-body" id="div_pedido_trabajo">
	<input type="hidden" id="petr_id" value=""  readonly>
	<input type="hidden" id="proccessname" value="<?php echo $proccessname;?>"  readonly>
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
			

			//Si el proceso viene vacio usamos proceso estandar
			if(isset($proccessname)){
				$form_id = $this->Pedidotrabajos->procesos($proccessname)->proceso->form_id;
			}else{
				$proccessname = PRO_STD;
				$form_id = $this->Pedidotrabajos->procesos($proccessname)->proceso->form_id;
			}
		
			echo (!empty($form_id)) ? '<div class="frm-new" data-form="'.$form_id.'"></div>' : '<div class="frm-new" data-form="0"></div>';
			
			?>

			<!-- Campo oculto para almacenar form_id -->
			<input type="hidden" id="FormId" value="<?php echo $form_id; ?>">

 </div>
            <div class="form-group">
                <div class="col-xs-12 col-sm-12 col-md-12" style="text-align: right">
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
		proccesname = $('#proccessname').val();
		console.log('el proceso es :'+proccesname);
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
				error('Error...','La fecha de entrega no puede ser anterior a la fecha de inicio');
				$("#fec_entrega").val('');
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

	var guardarPedidoTrabajo = function(info_id = '') {
			$('#mdl-peta').modal('hide');
			var formData = new FormData($('#frm-PedidoTrabajo')[0]);
			if(_isset(info_id)){
				formData.append('info_id', info_id);
			}

			$.ajax({
					type: 'POST',
					dataType: 'JSON',
					url: '<?php echo base_url(BPM) ?>Pedidotrabajo/guardarPedidoTrabajo',
					data: formData,
					cache: false,
					contentType: false,
					processData: false,
					success: function(rsp) {
					var result = rsp.status.toString(); 

					var pedido = rsp.data
						var num_pedido = JSON.parse(pedido);
				
					
					console.log('status esta en saliendo por success:' + result);

					console.log('se genero pedido numero:' + num_pedido);

					var petr_id = num_pedido.respuesta['petr_id'];

					$('#petr_id').val(petr_id);
				
							if (rsp.status) {
							
							
								if (proccesname == 'SEIN-SERVICIOS-INDUSTRIALES'){
										
									console.log("Exito al guardar Formulario");

									const swalWithBootstrapButtons1 = Swal.mixin({
									customClass: {
										confirmButton: 'btn btn-success',
										cancelButton: 'btn btn-danger'
									},
									buttonsStyling: false
									})

									swalWithBootstrapButtons1.fire({
									title: 'Exito!',
									text: 'Pedido de trabajo Número: ' +petr_id+ ' generado y enviado por correo con éxito'+'¿Desea imprimir codigo QR?',
									type: 'success',
									showCancelButton: true,
									confirmButtonText: 'Imprimir',
									cancelButtonText: 'Cerrar',
									reverseButtons: true
									}).then((result) => {
									if (result.value) {
										crearUrlQr();  
									
										setTimeout(function(){
											modalCodigosSein();
											// $('#frm-PedidoTrabajo')[0].reset();
											resetFormAndSelect2();
									}, 2000);
																		
									} else if (
										/* Read more about handling dismissals below */
										result.dismiss === Swal.DismissReason.cancel
									) {
										swalWithBootstrapButtons1.fire(
										'Cancelado',
										'Recuerda que puedes imprimir el pedido luego',
										'info'
										)

										// $('#frm-PedidoTrabajo')[0].reset();
										resetFormAndSelect2();
										linkTo('<?php  echo BPM ?>Proceso/');
									}
									})
											} 
								if(proccesname == 'YUDI-NEUMATICOS'){
										

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
										confirmButtonText: 'Imprimir',
										cancelButtonText: 'Cerrar',
										reverseButtons: true
										}).then((result) => {
										if (result.value) {
											modalCodigosPedido();
											// $('#frm-PedidoTrabajo')[0].reset();											
										} else if (
											/* Read more about handling dismissals below */
											result.dismiss === Swal.DismissReason.cancel
										) {
											swalWithBootstrapButtons.fire(
											'Cancelado',
											'Recuerda que puedes imprimir el pedido luego',
											'info'
											)

											// $('#frm-PedidoTrabajo')[0].reset();											
											linkTo();
										}
										})
											}

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



	function modalCodigosPedido(){
		//Limpio la data del modal
		$("#infoEtiqueta").empty();
		$("#contenedorCodigo").empty();
		$("#infoFooter").empty();
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
        arraydatos.Fecha_inicio = dateFormat($('#fec_inicio').val());
		arraydatos.Prioridad = $('select[name="prioridad_yudica"]').select2('data')[0].text;
		arraydatos.int_pedi_id = $('select[name="int_pedi_id"]').select2('data')[0].text;

		// si la etiqueta es derechazo
		arraydatos.Motivo = $('#motivo_rechazo').val();			
		// info para grabar en codigo QR
		armarInfo(arraydatos);
		//agrega codigo QR al modal impresion
		getQR(config, arraydatos, 'codigosQR/Traz-comp-Yudica');
		// llama modal con datos e img de QR ya ingresados
		verModalImpresion();
	}

	//Se debe validar el formulario antes de cerrar el modal
	// de lo contrario frm_validar() retorna true; y no lo es
	async function cierraPedidoTrabajo(){
		idFormDinamico = "#"+$('.frm-new').find('form').attr('id');
		//valido para obtener los campos con error
		$("#frm-PedidoTrabajo").bootstrapValidator("validate");
		if($("#objetivo").val() != ""){
			if($("#unidad_medida_tiempo").val() == null){
				error('Error..','Si completo objetivo, seleccione medida de tiempo');
				return;
			}
		}

		if(!$("#frm-PedidoTrabajo").data("bootstrapValidator").isValid()){
			error('Error..','Debes completar los campos obligatorios (*)');
			return;
		}
		
		if(idFormDinamico != "#undefined"){
			frm_validar(idFormDinamico)
			if(!frm_validar(idFormDinamico)){
					error('Error..','Debes completar los campos obligatorios (*)');
					return;
			}
			wo();
			var newInfoID = await frmGuardarConPromesa($(idFormDinamico));
			guardarPedidoTrabajo(newInfoID);
		}else{
			guardarPedidoTrabajo();
		}
	}

	function crearUrlQr() {
    	var datos = {};
   		petr_id = $('#petr_id').val();
		// case_id = $('#caseId').val();
		datos.id = petr_id;
		datos.funcion= 'PRO.verEstadoPedidoTrabajo';
		$.ajax({
			type: 'POST',
			data: datos,
			url: '<?php echo COD ?>Url/generarLink',
			success: function(data) {
				url = JSON.parse(data)
				console.log("la url es:"+ url.url);

				dato_linck = url.url;

				$('#url_link').val(dato_linck);
			},
			error: function(data) {
				wc();
				error('',"Se produjo un error al cerrar la tarea");
			}
		});
	}
  	var band = 0;// Esta variable esta para que no repita el QR en el modal
	// Se peden hacer dos cosas: o un ajax buscando datos o directamente
	// armar con los datos de la pantalla  
  	function modalCodigosSein(){
		if (band == 0) {
			// configuracion de codigo QR
			var config = {};
				config.titulo = "Servicios Industriales";
				config.pixel = "3";
				config.level = "S";
				config.framSize = "2";
			// info para immprimir  
			var arraydatos = {};
				arraydatos.N_orden = $('#petr_id').val();
				arraydatos.Fabricado = 'Servicios Industriales';
				arraydatos.Cliente = $('#clie_id option:selected').text();
				arraydatos.fec_fabricacion = $('#fec_fabricacion').val();
				arraydatos.fec_entrega = $('#fec_entrega').val();
				arraydatos.dato_linck =   $('#url_link').val();
			// info para grabar en codigo QR
			armarInfo(arraydatos);
			getQR(config, arraydatos, 'codigosQR/Sein-almpantar');
      	}
		// llama modal con datos e img de QR ya ingresados
		verModalImpresionPedido();
      	band = 1;
  	}

  	function armarInfo(arraydatos){
		proccesname = $('#proccessname').val();
		console.log('el proceso es de armarInfo es: '+proccesname);
		if(proccesname == 'YUDI-NEUMATICOS'){
			$("#infoEtiqueta").load("<?php echo base_url(YUDIPROC); ?>/Infocodigo/pedidoTrabajo", arraydatos);
		} 
		if (proccesname == 'SEIN-SERVICIOS-INDUSTRIALES'){
    		$("#infoEtiqueta").load("<?php echo base_url(SEIN); ?>/Infocodigo/pedidoTrabajoFinal", arraydatos);
  		}
	}

	function resetFormAndSelect2() {
		$('#frm-PedidoTrabajo')[0].reset();
		// Destruye select2 antes de reinicializar
		$('.select2').each(function() {
			if ($(this).data('select2')) {
				$(this).select2('destroy');
			}
		});

		var form_id = $('#hiddenFormId').val();
		$('.frm-new').attr('data-form', form_id);
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
				error('Error...','La fecha de entrega no puede ser anterior a la fecha de inicio');
				$("#fec_entrega").val('');
				e.preventDefault();
			}
		});

		// Reinicializa select2
		$('.select2').select2();

		detectarForm();
		initForm();
	}
</script>
