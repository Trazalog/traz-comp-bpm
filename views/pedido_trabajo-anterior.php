<style>
.frm-save {
    display: none;
}
/* .espaciado{
    margin-bottom: 20px;
} */
</style>

<?php
    // carga el modal de impresion de QR
    $this->load->view( COD.'componentes/modalYudica');
?>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Nuevo Pedido de Trabajo</h3>
    </div>
    <div class="panel-body" id="div_pedido_trabajo">
        <div class="row">
            <form class="form-inline" id="frm-PedidoTrabajo">
                <fieldset>
                    <!-- Codigo proyecto-->
                    <div class="col-md-6 espaciado" style="margin-bottom:5px">
                        <div class="form-group">
                            <label class="control-label" for="cod_proyecto">Número Pedido <strong style="color: #dd4b39">*</strong>:</label>
                            <input id="cod_proyecto" name="cod_proyecto" type="text" placeholder="Código proyecto" class="form-control input-md" data-bv-notempty data-bv-notempty-message="Campo Obligatorio *" required>
                        </div>
                    </div>
                    <!-- ***************** -->
                    <!-- Objetivo -->
                    <div class="col-md-6 espaciado">
                        <div class="form-group" style="display:inline-flex">
                            <label class="control-label" for="objetivo">Objetivo:</label>
                            <div class="input-group" style="display:inline-flex;">
                                <input id="objetivo" name="objetivo" type="number" placeholder="" class="form-control input-md" data-bv-notempty="false">
                            
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
                            <label class=" control-label" for="tipt_id">Trabajo <strong style="color: #dd4b39">*</strong>:</label>
                            <select id="tipt_id" name="tipt_id" class="form-control" data-bv-notempty data-bv-notempty-message="Campo Obligatorio *" required>
                                <option value="" disabled selected> -Seleccionar- </option>
                                <option value="tipos_pedidos_trabajoneumaticos">Reparacion Neumaticos</option>
                            </select>
                        </div>
                    </div>  
                    <br>

                    <!-- Button -->

                </fieldset>
            </form>

            <div class="frm-new" data-form="35"></div>

            <div class="form-group">
                <div class="col-xs-12 col-xs-offset-5 col-sm-12 col-sm-offset-6 col-md-6 col-md-offset-8">
                    <button type="button" class="btn btn-danger" onclick="cerrarModal()">Cerrar</button>

										<button type="button" id="btn-accion" class="btn btn-success btn-guardar"
                        onclick="modalCodigos()">Imprimir</button>

                    <button type="button" id="btn-accion" class="btn btn-primary btn-guardar"
                        onclick="frmGuardar($('.frm-new').find('form'),guardarPedidoTrabajo)">Guardar</button>
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
    clie_id
    $(window).on('show.bs.modal', function (e) {
        fecha = new Date();
        
        dia = fecha.getDate();
        mes = fecha.getMonth()+1;
        anio = fecha.getFullYear();

        if(dia<10){dia='0'+dia;} 
        if(mes<10){mes='0'+mes;}
        
        hoy = anio+'-'+mes+'-'+dia;  
        $("#fec_inicio").val(hoy);
    });
    
    $("#fec_entrega").on("change", function (e) {
        if($("#fec_entrega").val() < $("#fec_inicio").val()){
            alert("La fecha de entrega no puede ser anterior a la fecha de inicio");
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
    //$('#mdl-peta').modal('hide')
  
    var formData = new FormData($('#frm-PedidoTrabajo')[0]);
    formData.append('info_id', $('.frm').attr('data-ninfoid'));

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

									console.log('status esta en saliendo por success:' + result);
									wc();
							if (rsp.status) {
									console.log("Exito al guardar Formulario");
									Swal.fire(
											'Guardado!',
											'El Pedido de Trabajo se Guardo Correctamente',
											'success'
									 )
							}
									//Imprimir();
									// $('#frm-PedidoTrabajo')[0].reset();
									// linkTo('<?php //echo BPM ?>Proceso/');


									//lineas del checho #CHUKA
									//   reload('#pedidos-trabajos');
									//   $('#mdl-peta').modal('hide');
									//   reload('#frm-peta')
									//   detectarForm();
									//   initForm();

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
</script>


<script>
//#HGALLARDO

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

		var d = new Date();
		var month = d.getMonth()+1;
		var day = d.getDate();
		var fecha_actual = ((''+day).length<2 ? '0' : '') + day + '/' +
				((''+month).length<2 ? '0' : '') + month + '/' +
				d.getFullYear();

		var num = $('#num_cubiertas').val();

		var html =

					"<div class'row'>" +
									"<div class='col-md-2'>" +
										"<p>" + num + "</p>" +
									"</div>" +
									//"<div class='col-md-8 col-sm-8 col-xs-12'>" +
									"<div class='col-md-8 col-sm-8 center-block'>" +
										"<h3 class='center-block'>YUDICA NEUMATICOS</h3>"+
									"</div>" +
									"<div class='col-md-2'>" +
										"<p>" + fecha_actual + "</p>"+
									"</div>" +
							"</div>" +
					"</div>" +
					"<table class='table table-bordered table-striped'>"+
							"<thead class='thead-dark' bgcolor='#eeeeee'>" +
								"<th>Cliente</th>" +
								"<th>Medida</th>" +
								"<th>Marca</th>" +
								"<th>Serie</th>" +
							"</thead>" +
							"<tbody>" +
								"<tr>" +
									"<td>" + arraydatos.Cliente + "</td>" +
									"<td>" + arraydatos.Medida + "</td>" +
									"<td>" + arraydatos.Marca + "</td>" +
									"<td>" + arraydatos.Serie + "</td>" +
								"</tr>" +
							"</tbody>" +
					"</table>"
				;

		$("#infoEtiqueta").append(html);
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
</script>