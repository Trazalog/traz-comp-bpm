
<?php 
        //obtengo processname

$proccessname = $this->session->userdata('proccessname'); 

//dependiendo de el prccessename
    // carga el modal de impresion de QR
if ($proccessname == 'YUDI-NEUMATICOS') {
   
    $this->load->view( COD.'componentes/modalYudica');

} elseif ($proccessname == 'SEIN-SERVICIOS-INDUSTRIALES'){
  
    // $this->load->view( COD.'componentes/modalGenerico');
    $this->load->view( COD.'componentes/modalPedidoTrabajo');

}
?>
<div class="box box-primary">
    <div class="box-header with-border">
    <input type="hidden" id="proccessname" value="<?php echo $proccessname;?>"  readonly>
        <h4 class="box-title">Listado de Pedido Trabajo</h4>
    </div>
    <div class="box-body">
        <button id="btn-agregarPedido" class="btn btn-block btn-primary" style="width: 100px; margin-top: 10px;"
            onclick="$('#mdl-peta').modal('show')">Agregar</button>
        <br>
        <div class="box-body table-scroll table-responsive">
            <table id="tbl-pedidos" class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Acciones</th>
                        <th>Número de Pedido</th>
                        <th>Código de Pedido</th>
                        <th>Cliente</th>
                        <th>Domicilio</th>
                        <th>Tipo de Trabajo</th>
                        <th>Fecha de Inicio</th>
                        <th width="10%">Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $proceso = $this->Pedidotrabajos->procesos($proccessname)->proceso;
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
                        $cod_proyecto = $rsp->cod_proyecto;

                        echo "<tr id='$petr_id' case_id='$case_id' data-json='" . json_encode($rsp) . "'>";
                        echo "<td class='text-center text-light-blue'>";
                        echo '<i class="fa fa-trash-o" style="cursor: pointer;margin: 3px;" title="Eliminar" onclick="Eliminar(this)"></i>';
                        echo '<i class="fa fa-print" style="cursor: pointer; margin: 3px;" title="Imprimir Comprobante" onclick="modalReimpresion(this)"></i>';
                        echo '<i class="fa fa-search"  style="cursor: pointer;margin: 3px;" title="Ver Pedido" onclick="verPedido(this)"></i>';
                        echo "</td>";
                        echo '<td>'.$petr_id.'</td>';
                        echo '<td>'.$cod_proyecto.'</td>';
                        echo '<td>'.$nombre_cliente.'</td>';
                        echo '<td>'.$dir_entrega.'</td>';
                        echo '<td>'.$tipo_trabajo.'</td>';
                        echo '<td>'.formatFechaPG($fec_inicio).'</td>';
                        if ($estado == NULL) {
                            $estado ="SIN ESTADO";
                        }
                        if ($proccessname == 'YUDI-NEUMATICOS') {
                            switch ($estado) {
                                case 'estados_procesosPROC_EN_CURSO':
                                    echo '<td class="text-center"><span data-toggle="tooltip" title="" class="badge bg-green">EN CURSO</span></td>';
                                break;
                
                                case 'estados_yudicaEN_CURSO':
                                    echo '<td><span data-toggle="tooltip" title="" class="badge bg-green">EN CURSO</span></td>';
                                break;
                
                                case 'estados_yudicaREPROCESO':
                                    echo '<td><span data-toggle="tooltip" title="" class="badge bg-yellow">REPROCESO</span></td>';
                                break;
                
                                case 'estados_yudicaENTREGADO':
                                    echo '<td><span data-toggle="tooltip" title="" class="badge">ENTREGADO</span></td>';
                                break;
                
                                case 'estados_yudicaRECHAZADO':
                                    echo '<td><span data-toggle="tooltip" title="" class="badge bg-red">RECHAZADO</span></td>';
                                break;
                            
                                default:
                                    echo '<td><button type="button" class="btn btn-secondary">'.$estado.'</button></td>';
                                break;
                            }
                        }else{
                            switch ($estado) {
                                case 'estados_seinEN_CURSO':
                                    echo '<td class="text-center"><span data-toggle="tooltip" title="" class="badge bg-green">EN CURSO</span></td>';
                                break;
                                case 'estados_seinCOTIZACION_ENVIADA':
                                    echo '<td class="text-center"><span data-toggle="tooltip" title="" class="badge bg-navy">COTIZACION ENVIADA</span></td>';
                                break;
                                case 'estados_seinENTREGA_PENDIENTE':
                                    echo '<td class="text-center"><span data-toggle="tooltip" title="" class="badge bg-orange">ENTREGA PENDIENTE</span></td>';                               
                                break;
                                case 'estados_seinCORRECCION_NC':
                                    echo '<td class="text-center"><span data-toggle="tooltip" title="" class="badge bg-teal">CORRECCION NC</span></td>';
                                break;
                                case 'estados_seinRECHAZADO':
                                    echo '<td class="text-center"><span data-toggle="tooltip" title="" class="badge bg-red">RECHAZADO</span></td>';
                                break;
                                case 'estados_seinCANCELADO_NC':
                                    echo '<td class="text-center"><span data-toggle="tooltip" title="" class="badge bg-red">CANCELADO NC</span></td>';
                                break;
                                case 'estados_seinCONTRATADA':
                                    echo '<td class="text-center"><span style="background-color:#0b5a36 !important" data-toggle="tooltip" title="" class="badge">CONTRATADO</span></td>';
                                break;
                                case 'estados_procesosTRABAJO_TERMINADO':
                                    echo '<td class="text-center"><span style="background-color: #818387 !important;" data-toggle="tooltip" title="" class="badge">TRABAJO TERMINADO</span></td>';
                                break;
                                case 'estados_seinENTREGADO':
                                    echo '<td class="text-center"><span data-toggle="tooltip" title="" class="badge bg-gray">ENTREGADO</span></td>';
                                break;
                                default:
                                    echo '<td class="text-center"><button type="button" class="btn btn-secondary">'.$estado.'</button></td>';
                                break;
                            }
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
                <?php $this->load->view(BPM.'pedidos_trabajo/mdl_pedido_detalle'); ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<?php
    $this->load->view('pedidos_trabajo/mdl_pedidos_trabajo');
?>
<!-- The Modal -->
<div class="modal modal-fade" id="mdl-form-dinamico" data-backdrop="static">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <br>
            <div class="xmodal-body">
                <br>
                <div id="form-dinamico" data-frm-id="">
                </div>
                <br>
            </div>
            <br>
            <div class="modal-footer">
                <br>
                <button type="button" class="btn" onclick="cerrarModalform()">Cerrar</button>
                <!--       <button type="button" id="btn-accion" class="btn btn-primary btn-guardar" onclick="guardarTodo()">Guardar</button>-->
            </div>
        </div>
    </div>
</div>
<script>
//Funcion de datatable para extencion de botones exportar
//excel, pdf, copiado portapapeles e impresion

$(document).ready(function() {
    $('#tbl-pedidos').DataTable({
        responsive: true,
        language: {
            url: '<?php base_url() ?>lib/bower_components/datatables.net/js/es-ar.json' //Ubicacion del archivo con el json del idioma.
        },
        dom: 'lBfrtip',
        buttons: [{
                //Botón para Excel
                extend: 'excel',
                exportOptions: {
                    columns: [1, 2, 3, 4, 5, 6]
                },
                footer: true,
                title: 'Pedido de Trabajo',
                filename: 'pedido_trabajo',

                //Aquí es donde generas el botón personalizado
                text: '<button class="btn btn-success ml-2 mb-2 mb-2 mt-3">Exportar a Excel <i class="fa fa-file-excel-o"></i></button>'
            },
            // //Botón para PDF
            {
                extend: 'pdf',
                exportOptions: {
                    columns: [1, 2, 3, 4, 5, 6]
                },
                footer: true,
                title: 'Pedidos de Trabajo',
                filename: 'Pedidos de Trabajo',
                text: '<button class="btn btn-danger ml-2 mb-2 mb-2 mt-3">Exportar a PDF <i class="fa fa-file-pdf-o mr-1"></i></button>'
            },
            {
                extend: 'copy',
                exportOptions: {
                    columns: [1, 2, 3, 4, 5, 6]
                },
                footer: true,
                title: 'Pedidos de Trabajo',
                filename: 'Pedidos de Trabajo',
                text: '<button class="btn btn-primary ml-2 mb-2 mb-2 mt-3">Copiar <i class="fa fa-file-text-o mr-1"></i></button>'
            },
            {
                extend: 'print',
                exportOptions: {
                    columns: [1, 2, 3, 4, 5, 6]
                },
                footer: true,
                title: 'Pedidos de Trabajo',
                filename: 'Pedidos de Trabajo',
                text: '<button class="btn btn-default ml-2 mb-2 mb-2 mt-3">Imprimir <i class="fa fa-print mr-1"></i></button>'
            }
        ]
    });
});
//funcion ver pedido
// parametro petr_id y case_id
//
function verPedido(e) {
	wo();
	petr_id = $(e).closest('tr').attr('id');
	case_id = $(e).closest('tr').attr('case_id');
	console.log('trae pedido N°: ' + petr_id)
	console.log('trae case_id N°: ' + case_id)

	var url = "<?php echo base_url(BPM); ?>Pedidotrabajo/cargar_detalle_comentario?petr_id=" + petr_id + "&case_id=" + case_id;
	var url1 = "<?php echo base_url(BPM); ?>Pedidotrabajo/cargar_detalle_formulario?petr_id=" + petr_id + "&case_id=" + case_id;
	var url2 = "<?php echo base_url(BPM); ?>Pedidotrabajo/cargar_detalle_linetiempo?case_id=" + case_id;
	var url3 = "<?php echo base_url(BPM); ?>Pedidotrabajo/cargar_detalle_info_actual?case_id=" + case_id;
    header = "<?php echo base_url(BPM); ?>Pedidotrabajo/cargar_detalle_cabecera?case_id=" + case_id;

    $("#cabecera").empty();
    $("#cabecera").load(header);

	$("#cargar_comentario").empty();
	$("#cargar_comentario").load(url, () => {
		$('#mdl-vista').modal('show');
		wc();
	});

	$("#cargar_form").empty();
	$("#cargar_form").load(url1, () => {
		$('#mdl-vista').modal('show');
		wc();
	});

	$("#cargar_trazabilidad").empty();
	$("#cargar_trazabilidad").load(url2, () => {
		$('#mdl-vista').modal('show');
		wc();
	});

	$("#cargar_info_actual").empty();
	$("#cargar_info_actual").load(url3, () => {
		$('#mdl-vista').modal('show');
		wc();
	});
	
}

//funcion boton eliminar
//
function Eliminar(e) {

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
        type: 'warning',
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

//Elimina un pedido
//parametro petr_id
//
function EliminarPedidoTrabajo() {

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
            linkTo();
            setTimeout(() => {
                hecho('Perfecto!','Se Elimino Pedido Correctamente!');
            }, 5000);
        },
        error: function(rsp) {
            console.log('rsp sale por errro trae: ' + rsp);
            Swal.fire(
                'Cancelado!',
                'No se Elimino Pedido de trabajo',
                'error'
            )
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
function modalCodigos() {
    if (band == 0) {
        // configuracion de codigo QR
        var config = {};
        config.titulo = "Pedido de Trabajo";
        config.pixel = "2";
        config.level = "S";
        config.framSize = "3";
        // info para immprimir
        var arraydatos = {};
        arraydatos.Codigo_proyecto = $('#codigo_proyecto').val();
        arraydatos.Trabajo = $('#tipt_id option:selected').val();
        arraydatos.Cliente = $('#clie_id option:selected').text();
        arraydatos.Medida = $('select[name="medidas_yudica"]').select2('data')[0].text;
        arraydatos.Marca = $('select[name="marca_yudica"]').select2('data')[0].text;
        arraydatos.Serie = $('#num_serie').val();
        arraydatos.Banda = $('select[name="banda_yudica"]').select2('data')[0].text;
        // si la etiqueta es derechazo
        arraydatos.Motivo = $('#motivo_rechazo').val();
        // info para grabar en codigo QR
        armarInfo(arraydatos);
        //agrega codigo QR al modal impresion
        getQR(config, arraydatos, 'codigosQR/Traz-comp-Yudica');
    }
    // llama modal con datos e img de QR ya ingresados
    verModalImpresionPedido();
    band = 1;
}

function armarInfo(arraydatos) {
    $("#infoEtiqueta").load("<?php echo base_url(YUDIPROC); ?>/Infocodigo/pedidoTrabajo", arraydatos);
}

function validarImpresion() {

    var cli = $('#clie_id option:selected').val();
    var medida = $('select[name="medidas_yudica"] option:selected').val();
    var marca = $('select[name="marca_yudica"] option:selected').val();
    var serie = $('#num_serie').val();
    if (cli == "" || medida == "" || marca == "" || serie == "") {
        return false;
    } else {
        return true;
    }
}
// REIMPRESION ETIQUETA VIENE DEL LISTADO
function modalReimpresion(e) {
    $("#infoEtiqueta").empty();
    $("#contenedorCodigo").empty();
    $("#infoFooter").empty();

    // configuracion de codigo QR
    var config = {};
    config.titulo = "Reimpresion de Etiqueta";
    config.pixel = "2";
    config.level = "S";
    config.framSize = "3";

    arraydatos = $(e).closest('tr').attr('data-json');

    var datos = JSON.parse(arraydatos);
    petr_id = datos.petr_id;
	case_id = datos.case_id;
    estado_pedido = datos.estado;
	proccesname = $('#proccessname').val();
    if(proccesname == 'YUDI-NEUMATICOS'){
        if (estado_pedido == "estados_yudicaRECHAZADO") {
            $.ajax({
                type: 'GET',
                data: petr_id,
                case_id,
                cache: false,
                contentType: false,
                processData: false,
                url: '<?php base_url() ?>index.php/<?php echo BPM ?>Pedidotrabajo/cargar_detalle_formularioJson?petr_id=' +
                    petr_id + '&case_id=' + case_id,

                success: function(rsp) {
                    var motivo = JSON.parse(rsp);
                    datos.motivo_rechazo = motivo.motivo_rechazo;
                    // llama modal con datos e img de QR
                    getDatos(datos, config);
                    // levanta modal completo para su impresion
                    verModalImpresion();
                },

                error: function(rsp) {
                    console.log('rsp sale por errro trae: ' + rsp);
                    Swal.fire(
                        'Cancelado!',
                        'No se Elimino Pedido de trabajo',
                        'error'
                    )
                },
                complete: function() {
                }
            });
        }
    }
    if (proccesname == 'SEIN-SERVICIOS-INDUSTRIALES'){
        // llama modal con datos e img de QR
        getDatosSein(datos, config);
        // levanta modal completo para su impresion
        // verModalImpresion();
        verModalImpresionPedido();
    }

    if(proccesname == 'YUDI-NEUMATICOS'){
        // llama modal con datos e img de QR
        getDatos(datos, config);
        // levanta modal completo para su impresion
        // verModalImpresion();
        verModalImpresion();
    }

    if (proccesname == 'SEIN-SERVICIOS-INDUSTRIALES'){
        // llama modal con datos e img de QR
        getDatosSein(datos, config);
        // levanta modal completo para su impresion
        // verModalImpresion();
        verModalImpresionPedido();

    }
}
// obtine datos ya mapeados para QR y cuerpo de a etiqueta
function getDatos(datos, config) {

     var infoid = datos.info_id;
     var estado = datos.estado;
      var cliente = datos.nombre;
     var trabajo = datos.tipo_trabajo;
     var N_orden = datos.petr_id;
     var Cod_proyecto = datos.cod_proyecto;
     var motivo = datos.motivo_rechazo;

    $.ajax({
        type: 'GET',
        url: "<?php echo base_url(YUDIPROC); ?>Infocodigo/mapeoDatos/" + infoid,
        success: function(result) {
            var datMapeado = JSON.parse(result);
            datMapeado.Cliente = cliente;
            datMapeado.Trabajo = trabajo;
            datMapeado.N_orden = N_orden;
            datMapeado.Motivo = motivo;

            console.log('data mapeado: ');
            console.table(datMapeado);
    
            cargarInfoReimp(datMapeado, estado, config, 'codigosQR/Traz-comp-Yudica');
        },
        error: function(result) {

        },
        complete: function() {

        }
    });
}
// obtine datos ya mapeados para QR y cuerpo de a etiqueta
function getDatosSein(datos, config) {
    var infoid = datos.info_id;
    var estado = datos.estado;
    var cliente = datos.nombre;
    var trabajo = datos.tipo_trabajo;
    var N_orden = datos.petr_id;
    var Cod_proyecto = datos.cod_proyecto;
    var motivo = datos.motivo_rechazo;

    $.ajax({
        type: 'GET',
        url: "<?php echo base_url(SEIN); ?>Infocodigo/mapeoDatos/" + infoid,
        success: function(result) {
            var datMapeado = JSON.parse(result);
            // datMapeado.Cliente = cliente;
            // datMapeado.Trabajo = trabajo;
            // datMapeado.N_orden = N_orden;
            // datMapeado.Motivo = motivo;

            console.log('data mapeado: ');
            console.table(datMapeado);
            cargarInfoReimp(datMapeado, estado, config, 'codigosQR/Sein-almpantar');
        },
        error: function(result) {

        },
        complete: function() {

        }
    });
}

//  carga el modal con cuerpo y codigo QR
function cargarInfoReimp(datMapeado, estado, config, direccion) {
    switch (estado) {
        case 'estados_yudicaEN_CURSO':
            //Comprobante 1
            //agrega cuerpo de la etiqueta
            $("#infoEtiqueta").load("<?php echo base_url(YUDIPROC); ?>Infocodigo/pedidoTrabajo", datMapeado);
            // agrega codigo QR al modal impresion
            getQR(config, datMapeado, direccion);
            break;

        case 'estados_yudicaREPROCESO':
            //Comprobante 1
            $("#infoEtiqueta").load("<?php echo base_url(YUDIPROC); ?>Infocodigo/pedidoTrabajo", datMapeado);
            // agrega codigo QR al modal impresion
            getQR(config, datMapeado, direccion);
            break;

        case 'estados_yudicaRECHAZADO':
            //Comprobante 2
            $("#infoEtiqueta").load("<?php echo base_url(YUDIPROC); ?>Infocodigo/rechazado", datMapeado);
            // agrega codigo QR al modal impresion
            // getQR(config, datMapeado, direccion);
            break;

        case 'estados_yudicaENTREGADO':
            // Comprobante 3
            $("#infoEtiqueta").load("<?php echo base_url(YUDIPROC); ?>Infocodigo/pedidoTrabajoFinal", datMapeado);
            // agrega codigo QR al modal impresion
            getQR(config, datMapeado, direccion);
            $("#infoFooter").load("<?php echo base_url(YUDIPROC); ?>Infocodigo/pedidoTrabajoFooter");
            break;

        default:
            // code...
            break;
    }

    return;
}
</script>