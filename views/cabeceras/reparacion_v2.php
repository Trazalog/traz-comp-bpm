	<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true" style="margin-bottom: 7px !important;">
		<div class="panel panel-default">
			<div class="panel-heading" role="tab" id="headingOne">
				<h4 class="panel-title">
					<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
						Proceso <?php echo $nombreProceso; ?>
					</a>
				</h4>
			</div>
			<div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
				<div class="panel-body">
									<div class="col-md-3">
										<div class="form-group">
											<label for="generador" name="">Nº pedido:</label>
											<input type="text" class="form-control habilitar" style="font-family: Arial; font-size: 16pt;" id="petr_id" value="<?php echo $aux->petr_id; ?>"  readonly>
										</div>
									</div>
									<div class="col-md-12">
									<p>Datos del Cliente:</p>
									<hr>
										<div class="col-md-6 animated fadeInLeft">
											<div class="form-group">
													<label for="cliente" name="">Cliente:</label>
													<input type="text" class="form-control habilitar" id="cliente" value="<?php echo $aux_clie->cliente->nombre; ?>"  readonly>
											</div>
										</div>


										<div class="col-md-6 animated fadeInLeft">
											<div class="form-group">
													<label for="dir_entrega" name="">Dirección de Entrega:</label>
													<input type="text" class="form-control habilitar" id="dir_entrega" value="<?php echo $aux_clie->cliente->dir_entrega; ?>"  readonly>
											</div>
										</div>
								
									<div class="col-md-12">
									<br>
									<p>Datos del Proyecto:</p>
									<hr>
									<div class="col-md-12 animated fadeInLeft">
											<div class="form-group">
													<label for="tipo_proyecto" name="">Tipo de Proyecto:</label>
													<input type="text" class="form-control habilitar" id="tipo_proyecto" value="<?php echo $aux->tipo; ?>"  readonly>
											</div>
									</div>
									<!--_____________________________________________-->

									<div class="col-md-6 animated fadeInLeft">
											<div class="form-group">
													<label for="codigo_proyecto" name="">Codigo Proyecto:</label>
													<input type="text" class="form-control habilitar" id="codigo_proyecto" value="<?php echo $aux->cod_proyecto; ?>"  readonly>
											</div>
									</div>
									<!--_____________________________________________-->

									<div class="col-md-6 animated fadeInLeft">
											<div class="form-group">
													<label for="descripcion" name=""> Descripcion:</label>
													<input type="text" class="form-control habilitar" id="descripcion" value="<?php echo $aux->descripcion; ?>"  readonly>
											</div>
									</div>
									<!--_____________________________________________-->
								</div>


								<div class="col-md-12 animated fadeInLeft">

									<div class="col-md-6">
											<div class="form-group">
													<label for="fecha_inicio" name="">Fecha Inicio:</label>
													<input type="text" class="form-control habilitar" id="fec_inicio" value="<?php
															
     											$fecha_inicio = date("d-m-Y",strtotime(str_replace('T', ' ', $aux->fec_inicio)));

													echo $fecha_inicio ;
													
													?>"  readonly>
											</div>
									</div>
									<!--_____________________________________________-->

									<div class="col-md-6 animated fadeInLeft">
											<div class="form-group">
													<label for="fecha_entrega" name=""> Fecha Entrega:</label>
													<input type="text" class="form-control habilitar" id="fec_entrega" value="<?php
																									
														$fecha_entrega = date("d-m-Y",strtotime(str_replace('T', ' ', $aux->fec_entrega)));
														
														echo $fecha_entrega ;
														
														?>"  readonly>
											</div>
									</div>
									<!--_____________________________________________-->
								</div>


								<div class="col-md-12 animated fadeInLeft">

									<div class="col-md-6">
											<div class="form-group">
													<label for="objetivo" name="">Objetivo:</label>
													<input type="text" class="form-control habilitar" id="objetivo" value="<?php echo $aux->objetivo; ?>"  readonly>
											</div>
									</div>
									<div class="col-md-6">
											<div class="form-group">
													<label for="unidad_medida" name="">Unidad medida:</label>
													<input type="text" class="form-control habilitar" id="unidad_medida" value="<?php echo $aux->unidad_medida; ?>"  readonly>
											</div>
									</div>
								
									<!--_____________________________________________-->
									<div class="col-md-12 animated fadeInLeft">
									<?php
									
									if ($processId !='' )
										{
											$info_id = $aux->info_id;

											$formulario = getForm($info_id);
									
										}

										?>
									<div id="form-dinamico-cabecera" data-frm-id="<?php echo "frm-".$info_id;?>">
									<?php
											
											echo $formulario;

									?>
										<script>
											$(".frm-select").select2();
										var formulario = $('#form-dinamico-cabecera').attr('data-frm-id');
										
		
										$('#form-dinamico-cabecera button.frm-save').addClass('oculto');
										
		
										$('#form-dinamico-cabecera').find(':input').each(function() {
										var elemento= this;
										console.log("elemento.id="+ elemento.id); 

										$(elemento).attr('readonly', true); 

										$(elemento).attr('disabled',true);
												});
												
										</script>
									
									</div>

								</div>
								
<!--_____________________________________________-->

							</div>
						</div>
					</div>
					
					
				</div>
