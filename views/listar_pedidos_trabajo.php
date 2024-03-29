<style>
    .item-tarea-planificada {
        width: 100%;
    }
</style>
<?php

//obtengo processname
$proccessname = $this->session->userdata('proccessname');
//dependiendo de el prccessename
// carga el modal de impresion de QR
if ($proccessname == 'YUDI-NEUMATICOS') {
    $this->load->view(COD . 'componentes/modalYudica');
} elseif ($proccessname == 'SEIN-SERVICIOS-INDUSTRIALES') {
    // $this->load->view( COD.'componentes/modalGenerico');
    $this->load->view(COD . 'componentes/modalPedidoTrabajo');
}
?>

<div class="box box-primary">
    <div class="box-header with-border">
        <input type="hidden" id="proccessname" value="<?php echo $proccessname; ?>" readonly>
        <h4 class="box-title">Listado de Pedido Trabajo</h4>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-md-3">
                <button id="btn-agregarPedido" class="btn btn-block btn-primary" style="width: 100px; margin-top: 10px;" onclick="$('#mdl-peta').modal('show')">Agregar</button>
            </div>
            <div class="col-md-5">
                <div id="botonToggleOnOff" style="text-align: center;" class="form-group col-xs-3 col-sm-3 col-md-3 col-lg-6">
                    <div class="form-check">
                        <label class="checkboxtext">Mostrar Pedidos Terminados</label>
                    </div>
                    <label class="switch">
                        <input type="checkbox" id="pedidos_finalizados" name="pedidos_finalizados" onclick="ActualizaTabla()">
                        <span class="slider round"></span>
                    </label>
                </div>
            </div>
        </div>
        <br>
        <div class="box-body table-scroll table-responsive">
            <table id="tbl-pedidos" class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Acciones</th>
                        <th id="n_pedido">Número de Pedido</th>
                        <th id="c_pedido">Código de Pedido</th>
                        <th id="cliente">Cliente</th>
                        <th id="domicilio">Domicilio</th>
                        <th t_trabajo>Tipo de Trabajo</th>
                        <th id="fecha">Fecha de Inicio</th>
                        <th width="10%">Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Definicion en inicio de datatable -->
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
                <?php $this->load->view(BPM . 'pedidos_trabajo/mdl_pedido_detalle'); ?>
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
<!-- MODAL DETALLE PEDIDO DE MATERIALES EN LAS TAREAS PLANIFICADAS -->
<div class="modal modal-fade" id="mdl-detalle-pedidosMateriales">
    <div class="modal-dialog modal-lm">
        <?php $this->load->view(BPM . 'pedidos_trabajo/mdl_detalle_pedido_materiales'); ?>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#tbl-pedidos').DataTable({
            //Funcion de datatable para extencion de botones exportar
            //excel, pdf, copiado portapapeles e impresion
            responsive: true,
            ordering: true,
            order: [
                [1, 'desc']
            ],
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
            ],
            //Funcion de datatable para paginacion de los pedidos de trabajo
            'lengthMenu': [
                [10, 25, 50, 100, ],
                [10, 25, 50, 100]
            ],
            'paging': true,
            'processing': true,
            'serverSide': true,
            'ajax': {
                type: 'POST',
                url: '<?php base_url() ?>index.php/<?php echo BPM ?>Pedidotrabajo/paginado',
               
            },
            'columnDefs': [{
                    //Agregado para que funcione cabecera de imprimir,descargar excel o pdf.   
                    "defaultContent": "-",
                    "targets": "_all",
                },
                {
                    'targets': [0],
                    //agregado de class con el estilo de las acciones
                    'createdCell': function(td, cellData, rowData, row, col) {
                        $(td).attr('class', 'text-center text-light-blue');
                    },
                    'data': 'acciones',
                    'render': function(data, type, row) {
                        var petr_id = row['petr_id'];
                        var case_id = row['case_id'];
                        var json = JSON.stringify(row);
                        var r = `<tr>`;
                        r += '<td><i class="fa fa-trash-o" style="cursor: pointer;margin: 3px;" title="Eliminar" onclick="Eliminar(this)"></i>';
                        r += '<i class="fa fa-print" style="cursor: pointer; margin: 3px;" title="Imprimir Comprobante" onclick="modalReimpresion(this)"></i>';
                        r += '<i class="fa fa-search"  style="cursor: pointer;margin: 3px;" title="Ver Pedido" onclick="verPedido(this)"></i>';
                        r += "</td>";
                        return r;
                    }
                },
                {
                    'targets': [1],
                    'data': 'petr_id',
                    'render': function(data, type, row) {
                        return `<td class="petr_id">${row['petr_id']}</td>`;
                    }
                },
                {
                    'targets': [2],
                    'data': 'cod_proyecto',
                    'render': function(data, type, row) {
                        return `<td class="cod_proyecto">${row['cod_proyecto']}</td>`;
                    }
                },
                {
                    'targets': [3],
                    'data': 'nombre',
                    'render': function(data, type, row) {
                        return `<td class="nombre_cliente">${row['nombre']}</td>`;
                    }
                },
                {
                    'targets': [4],
                    'data': 'dir_entrega',
                    'render': function(data, type, row) {
                        return `<td class="dir_entrega">${row['dir_entrega']}</td>`;
                    }
                },
                {
                    'targets': [5],
                    'data': 'tipo_trabajo',
                    'render': function(data, type, row) {
                        return `<td class="tipo_trabajo">${row['tipo_trabajo']}</td>`;
                    }
                },
                {
                    'targets': [6],
                    'data': 'fec_inicio',
                    'render': function(data, type, row) {
                        var fec_inicio = '';
                        fec_inicio = dateFormat(row['fec_inicio']);
                        return `<td class="fec_inicio">${fec_inicio}</td>`;
                    }
                },
                {
                    'targets': [7],
                    'data': 'tipo_trabajo',
                    'render': function(data, type, row) {
                        var proccessname = '<?php echo $proccessname ?>';
                        var r = '';
                        var estado = row['estado']
                        if (!estado) {
                            estado = "SIN ESTADO";
                        }
                        if (proccessname == 'YUDI-NEUMATICOS') {
                            switch (estado) {
                                case 'estados_procesosPROC_EN_CURSO':
                                    r = '<td>' + bolita('EN CURSO', 'green') + '</td></tr>';
                                    break;

                                case 'estados_yudicaEN_CURSO':
                                    r = '<td>' + bolita('EN CURSO', 'green') + '</td></tr>';
                                    break;

                                case 'estados_yudicaREPROCESO':
                                    r = '<td>' + bolita('REPROCESO', 'yellow') + '</td></tr>';
                                    break;

                                case 'estados_yudicaENTREGADO':
                                    r = '<td>' + bolita('ENTREGADO', 'gray') + '</td></tr>';
                                    break;

                                case 'estados_yudicaRECHAZADO':
                                    r = '<td>' + bolita('RECHAZADO', 'red') + '</td></tr>';
                                    break;

                                default:
                                    r = '<td><button type="button" class="btn btn-secondary">' + estado + '</button></td></tr>';
                                    break;
                            }
                        } else {
                            switch (estado) {
                                case 'estados_seinEN_CURSO':
                                    r = '<td>' + bolita('EN CURSO', 'green') + '</td></tr>';
                                    break;
                                case 'estados_seinCOTIZACION_ENVIADA':
                                    r = '<td>' + bolita('COTIZACION ENVIADA', 'navy') + '</td></tr>';
                                    break;
                                case 'estados_seinENTREGA_PENDIENTE':
                                    r = '<td>' + bolita('ENTREGA PENDIENTE', 'orange') + '</td></tr>';
                                    break;
                                case 'estados_seinCORRECCION_NC':
                                    r = '<td>' + bolita('CORRECCION NC', 'teal') + '</td></tr>';
                                    break;
                                case 'estados_seinRECHAZADO':
                                    r = '<td>' + bolita('RECHAZADO', 'red') + '</td></tr>';
                                    break;
                                case 'estados_seinCANCELADO_NC':
                                    r = '<td>' + bolita('CANCELADO NC', 'red') + '</td></tr>';
                                    break;
                                case 'estados_seinCONTRATADA':
                                    r = '<td>' + bolita('CONTRATADO', '0b5a36') + '</td></tr>';
                                    break;
                                case 'estados_procesosTRABAJO_TERMINADO':
                                    r = '<td>' + bolita('TRABAJO TERMINADO', '0b5a36') + '</td></tr>';
                                    break;
                                case 'estados_seinENTREGADO':
                                    r = '<td>' + bolita('ENTREGADO', 'gray') + '</td></tr>';
                                    break;
                                default:
                                    r = '<td class="text-center"><button type="button" class="btn btn-secondary">' + estado + '</button></td></tr>';
                                    break;
                            }
                        }

                        return r;
                    }
                }
            ],
            //agregado de data-json al tr de la tabla
            createdRow: function(row, data, dataIndex) {
                json = JSON.stringify(data);
                $(row).attr('data-json', json);
                $(row).attr('id', data['petr_id']);
                $(row).attr('case_id', data['case_id']);
            },
        });

         /**
         * FUNCION QUE REALIZAD EL ORDENAMIENTO DE
         * REISTROS DE LA TABLA
         */
        const filterAsc = (data) => {

            checkFilter = !checkFilter;
            
            if (checkFilter) {
                const dataOrde = data.sort((a, b) => (a.id < b.id) ? -1 : (a.id > b.id) ? 1 : 0);
                $("table tbody").html(dataOrde);
                  $('#tbl-pedidos').DataTable().destroy();
                 $('#tbl-pedidos').DataTable({
                     'ajax': null
                 });
               
               
            } else {
                const dataOrde = data.sort((a, b) => (a.id > b.id) ? -1 : (a.id < b.id) ? 1 : 0);
                $("table tbody").html(dataOrde);
                  $('#tbl-pedidos').DataTable().destroy();
                 $('#tbl-pedidos').DataTable({
                    'ajax': {
                        type: 'POST',
                        url: '<?php base_url() ?>index.php/<?php echo BPM ?>Pedidotrabajo/paginado',
                    
                     }
                 });
                
                
            }
           
           console.log(checkFilter);

        }
        /**
         * Funcion para obtener todos los registros del datatable
         * devuelve los registros de la tabla
         */
        const getRowTabla = () => {

            const dataTable = $("table tbody").find('tr');

            console.log(dataTable);

            filterAsc(dataTable);

        }

        /**
         * LLamada a la funcion que guarda los datos de la tabla
         * @variable checkFilter controla que el objeto este odenado de manera asc y desc
         */
        var checkFilter = false;
        // const table = $("table thead tr th").click(function (e) {
            
        //     e.preventDefault();
            
        //     const id = $(this).attr('id');
            
        //     getRowTabla();
        // });

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
        var url4 = "<?php echo base_url(BPM); ?>Pedidotrabajo/cargar_detalle_tareas_planificadas?petr_id=" + petr_id;
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
        $("#cargar_listado_hitos").empty();
        $("#cargar_listado_hitos").load(url4, () => {
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
                    hecho('Perfecto!', 'Se Elimino Pedido Correctamente!');
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
            debugger;
            var arraydatos = {};
            arraydatos.Codigo_proyecto = $('#codigo_proyecto').val();
            arraydatos.Trabajo = $('#tipt_id option:selected').val();
            arraydatos.Cliente = $('#clie_id option:selected').text();
            arraydatos.Medida = $('select[name="medidas_yudica"]').select2('data')[0].text;
            arraydatos.Marca = $('select[name="marca_yudica"]').select2('data')[0].text;
            arraydatos.Serie = $('#num_serie').val();
            arraydatos.Banda = $('select[name="banda_yudica"]').select2('data')[0].text;
            array.datos.Fecha = $('#fec_inicio').val();
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
        proc_id = datos.proc_id;
        estado_pedido = datos.estado;
        proccesname = $('#proccessname').val();
        if (proccesname == 'YUDI-NEUMATICOS') {
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
                    complete: function() {}
                });
            }
        }
        if (proccesname == 'SEIN-SERVICIOS-INDUSTRIALES') {
            // llama modal con datos e img de QR
            getDatosSein(datos, config);
            // levanta modal completo para su impresion
            // verModalImpresion();
            verModalImpresionPedido();
        }
        if (proccesname == 'YUDI-NEUMATICOS') {
            //obtengo fecha final en caso de que este entregado el pedido
            if (estado_pedido == "estados_yudicaENTREGADO") {
                $.ajax({
                    type: 'GET',
                    data: case_id,
                    cache: false,
                    contentType: false,
                    processData: false,
                    url: '<?php base_url() ?>index.php/<?php echo BPM ?>Pedidotrabajo/fechaFinTareaDesdeBonita?case_id=' +
                        case_id + '&proc_id=' + proc_id,
                    success: function(rsp) {
                        datos.fecha_fin = rsp.slice(0, -13);
                        // llama modal con datos e img de QR
                        getDatos(datos, config);
                        // levanta modal completo para su impresion
                        verModalImpresion();
                    },
                    error: function(rsp) {
                        console.log('rsp sale por errro trae: ' + rsp);
                    }
                });
            } else {
                // llama modal con datos e img de QR
                getDatos(datos, config);
                // levanta modal completo para su impresion
                verModalImpresion();
            }
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
        var fecha_inicio = dateFormat(datos.fec_inicio);
        var int_pedi_id = datos.int_pedi_id;
        var fecha_fin = (datos.fecha_fin) ? dateFormat(datos.fecha_fin) : '';

        $.ajax({
            type: 'GET',
            url: "<?php echo base_url(YUDIPROC); ?>Infocodigo/mapeoDatos/" + N_orden + "/" + infoid,
            success: function(result) {
                var datMapeado = JSON.parse(result);
                datMapeado.Cliente = cliente;
                datMapeado.Trabajo = trabajo;
                datMapeado.N_orden = N_orden;
                datMapeado.Motivo = motivo;
                datMapeado.Fecha_inicio = fecha_inicio;
                datMapeado.int_pedi_id = int_pedi_id;
                datMapeado.Fecha_entrega = fecha_fin;

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
        debugger;
        var infoid = datos.info_id;
        var estado = datos.estado;
        var cliente = datos.nombre;
        var N_orden = datos.petr_id;
        var descripcion = datos.descripcion;
        var fec_inicio = datos.fec_inicio;
        config.pixel = "3";

        $.ajax({
            type: 'GET',
            url: "<?php echo base_url(SEIN); ?>Infocodigo/mapeoDatos/" + infoid,
            success: function(result) {
                var datMapeado = JSON.parse(result);
                datMapeado.fabricante = "Servicios Industriales";
                datMapeado.cliente = cliente;
                datMapeado.numero_pedido = N_orden;
                datMapeado.descripcion = descripcion;
                datMapeado.fec_inicio = fec_inicio;

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
                //agrega cuerpo de la etiqueta
                $("#infoEtiqueta").load("<?php echo base_url(SEIN); ?>Infocodigo/pedidoTrabajoFinal", datMapeado);
                // agrega codigo QR al modal impresion
                getQR(config, datMapeado, direccion);
                break;
        }

        return;
    }
    //Ver detalle del pedido de materiales en el pedido de trabajo, seccion tareas planificadas
    var detalletarea = null;

    function verDetallePedido(tag) {
        debugger;
        // if($('#batch_id').val() == "0")
        // {
        //     notificar('Er','Se necesita iniciar etapa para podes hacer pedidos de materiales');
        //     return;
        // }
        var data = JSON.parse($(tag).closest('div').attr('data-json'));
        // var data = getJson2(detalletarea);
        reload('#lista-pedidos', data.tapl_id);
        if (data.rece_id != "0") reload('#lista-receta', data.rece_id);
        $('#mdl-detalle-pedidosMateriales').modal('show');
    }
    //Muestra la instacia del formulario dinamico asociada a la TAREA STANDAR
    function showForm(tag) {
        debugger;
        var data = JSON.parse($(tag).closest('div').attr('data-json'));
        $mdl = $('#mdl-generico');
        $mdl.find('.modal-title').html('Formulario Asociado');
        $mdl.find('.modal-body').empty();
        if (!data.info_id || data.info_id == "false") {

            Swal.fire({
                type: 'info',
                title: 'Info',
                text: 'Aún no se completó formulario asociado!'

            })
            return;
        }
        wo();
        $.ajax({
            type: 'GET',
            dataType: 'JSON',
            url: '<?php echo base_url(FRM) ?>Form/obtener/' + data.info_id,
            success: function(res) {
                $mdl.find('.modal-body').html(res.html);
                $mdl.modal('show');
            },
            error: function(res) {
                error();
            },
            complete: function() {
                wc();
            }
        });
    }


    ////////// Actualizacion de tabla pedidos con/sin finalizados////////////
    //var pedidos = <?php echo json_encode($pedidos) ?>;
    function ActualizaTabla() {
        check = $('#pedidos_finalizados').is(':checked');
        $('#tbl-pedidos').DataTable();
        wo();
        if (check) {
            // tabla.destroy();
            $('#tbl-pedidos').DataTable().destroy();
            $('#tbl-pedidos').DataTable({
                //Funcion de datatable para extencion de botones exportar
                //excel, pdf, copiado portapapeles e impresion
                responsive: true,
                ordering: true,
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
                ],
                //Funcion de datatable para paginacion de los pedidos de trabajo
                'lengthMenu': [
                    [10, 25, 50, 100, ],
                    [10, 25, 50, 100]
                ],
                'paging': true,
                'processing': true,
                'serverSide': true,
                'ajax': {
                    type: 'POST',
                    url: '<?php base_url() ?>index.php/<?php echo BPM ?>Pedidotrabajo/paginado',
                    data: {
                        PedidosFinalizados: true
                    }
                },
                'columnDefs': [{
                        //Agregado para que funcione cabecera de imprimir,descargar excel o pdf.   
                        "defaultContent": "-",
                        "targets": "_all",
                    },
                    {
                        'targets': [0],
                        //agregado de class con el estilo de las acciones
                        'createdCell': function(td, cellData, rowData, row, col) {
                            $(td).attr('class', 'text-center text-light-blue');
                        },
                        'data': 'acciones',
                        'render': function(data, type, row) {
                            var petr_id = row['petr_id'];
                            var case_id = row['case_id'];
                            var json = JSON.stringify(row);
                            var r = `<tr>`;
                            r += '<td><i class="fa fa-trash-o" style="cursor: pointer;margin: 3px;" title="Eliminar" onclick="Eliminar(this)"></i>';
                            r += '<i class="fa fa-print" style="cursor: pointer; margin: 3px;" title="Imprimir Comprobante" onclick="modalReimpresion(this)"></i>';
                            r += '<i class="fa fa-search"  style="cursor: pointer;margin: 3px;" title="Ver Pedido" onclick="verPedido(this)"></i>';
                            r += "</td>";
                            return r;
                        }
                    },
                    {
                        'targets': [1],
                        'data': 'petr_id',
                        'render': function(data, type, row) {
                            return `<td class="petr_id">${row['petr_id']}</td>`;
                        }
                    },
                    {
                        'targets': [2],
                        'data': 'cod_proyecto',
                        'render': function(data, type, row) {
                            return `<td class="cod_proyecto">${row['cod_proyecto']}</td>`;
                        }
                    },
                    {
                        'targets': [3],
                        'data': 'nombre',
                        'render': function(data, type, row) {
                            return `<td class="nombre_cliente">${row['nombre']}</td>`;
                        }
                    },
                    {
                        'targets': [4],
                        'data': 'dir_entrega',
                        'render': function(data, type, row) {
                            return `<td class="dir_entrega">${row['dir_entrega']}</td>`;
                        }
                    },
                    {
                        'targets': [5],
                        'data': 'tipo_trabajo',
                        'render': function(data, type, row) {
                            return `<td class="tipo_trabajo">${row['tipo_trabajo']}</td>`;
                        }
                    },
                    {
                        'targets': [6],
                        'data': 'fec_inicio',
                        'render': function(data, type, row) {
                            var fec_inicio = '';
                            fec_inicio = dateFormat(row['fec_inicio']);
                            return `<td class="fec_inicio">${fec_inicio}</td>`;
                        }
                    },
                    {
                        'targets': [7],
                        'data': 'tipo_trabajo',
                        'render': function(data, type, row) {
                            var proccessname = '<?php echo $proccessname ?>';
                            var r = '';
                            var estado = row['estado']
                            if (!estado) {
                                estado = "SIN ESTADO";
                            }
                            if (proccessname == 'YUDI-NEUMATICOS') {
                                switch (estado) {
                                    case 'estados_procesosPROC_EN_CURSO':
                                        r = '<td>' + bolita('EN CURSO', 'green') + '</td></tr>';
                                        break;

                                    case 'estados_yudicaEN_CURSO':
                                        r = '<td>' + bolita('EN CURSO', 'green') + '</td></tr>';
                                        break;

                                    case 'estados_yudicaREPROCESO':
                                        r = '<td>' + bolita('REPROCESO', 'yellow') + '</td></tr>';
                                        break;

                                    case 'estados_yudicaENTREGADO':
                                        r = '<td>' + bolita('ENTREGADO', 'gray') + '</td></tr>';
                                        break;

                                    case 'estados_yudicaRECHAZADO':
                                        r = '<td>' + bolita('RECHAZADO', 'red') + '</td></tr>';
                                        break;

                                    default:
                                        r = '<td><button type="button" class="btn btn-secondary">' + estado + '</button></td></tr>';
                                        break;
                                }
                            } else {
                                switch (estado) {
                                    case 'estados_seinEN_CURSO':
                                        r = '<td>' + bolita('EN CURSO', 'green') + '</td></tr>';
                                        break;
                                    case 'estados_seinCOTIZACION_ENVIADA':
                                        r = '<td>' + bolita('COTIZACION ENVIADA', 'navy') + '</td></tr>';
                                        break;
                                    case 'estados_seinENTREGA_PENDIENTE':
                                        r = '<td>' + bolita('ENTREGA PENDIENTE', 'orange') + '</td></tr>';
                                        break;
                                    case 'estados_seinCORRECCION_NC':
                                        r = '<td>' + bolita('CORRECCION NC', 'teal') + '</td></tr>';
                                        break;
                                    case 'estados_seinRECHAZADO':
                                        r = '<td>' + bolita('RECHAZADO', 'red') + '</td></tr>';
                                        break;
                                    case 'estados_seinCANCELADO_NC':
                                        r = '<td>' + bolita('CANCELADO NC', 'red') + '</td></tr>';
                                        break;
                                    case 'estados_seinCONTRATADA':
                                        r = '<td>' + bolita('CONTRATADO', '0b5a36') + '</td></tr>';
                                        break;
                                    case 'estados_procesosTRABAJO_TERMINADO':
                                        r = '<td>' + bolita('TRABAJO TERMINADO', '0b5a36') + '</td></tr>';
                                        break;
                                    case 'estados_seinENTREGADO':
                                        r = '<td>' + bolita('ENTREGADO', 'gray') + '</td></tr>';
                                        break;
                                    default:
                                        r = '<td class="text-center"><button type="button" class="btn btn-secondary">' + estado + '</button></td></tr>';
                                        break;
                                }
                            }

                            return r;
                        }
                    }
                ],
                //agregado de data-json al tr de la tabla
                createdRow: function(row, data, dataIndex) {
                    json = JSON.stringify(data);
                    $(row).attr('data-json', json);
                    $(row).attr('id', data['petr_id']);
                    $(row).attr('case_id', data['case_id']);
                },
                "initComplete": function(settings, json) {
                    wc();
                }
            });
        } else {
            // tabla.destroy();
            $('#tbl-pedidos').DataTable().destroy();
            $('#tbl-pedidos').DataTable({
                //Funcion de datatable para extencion de botones exportar
                //excel, pdf, copiado portapapeles e impresion
                responsive: true,
                ordering:true,
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
                ],
                //Funcion de datatable para paginacion de los pedidos de trabajo
                'lengthMenu': [
                    [10, 25, 50, 100, ],
                    [10, 25, 50, 100]
                ],
                'paging': true,
                'processing': true,
                'serverSide': true,
                'ajax': {
                    type: 'POST',
                    url: '<?php base_url() ?>index.php/<?php echo BPM ?>Pedidotrabajo/paginado'
                },
                'columnDefs': [{
                        //Agregado para que funcione cabecera de imprimir,descargar excel o pdf.   
                        "defaultContent": "-",
                        "targets": "_all",
                    },
                    {
                        'targets': [0],
                        //agregado de class con el estilo de las acciones
                        'createdCell': function(td, cellData, rowData, row, col) {
                            $(td).attr('class', 'text-center text-light-blue');
                        },
                        'data': 'acciones',
                        'render': function(data, type, row) {
                            var petr_id = row['petr_id'];
                            var case_id = row['case_id'];
                            var json = JSON.stringify(row);
                            var r = `<tr>`;
                            r += '<td><i class="fa fa-trash-o" style="cursor: pointer;margin: 3px;" title="Eliminar" onclick="Eliminar(this)"></i>';
                            r += '<i class="fa fa-print" style="cursor: pointer; margin: 3px;" title="Imprimir Comprobante" onclick="modalReimpresion(this)"></i>';
                            r += '<i class="fa fa-search"  style="cursor: pointer;margin: 3px;" title="Ver Pedido" onclick="verPedido(this)"></i>';
                            r += "</td>";
                            return r;
                        }
                    },
                    {
                        'targets': [1],
                        'data': 'petr_id',
                        'render': function(data, type, row) {
                            return `<td class="petr_id">${row['petr_id']}</td>`;
                        }
                    },
                    {
                        'targets': [2],
                        'data': 'cod_proyecto',
                        'render': function(data, type, row) {
                            return `<td class="cod_proyecto">${row['cod_proyecto']}</td>`;
                        }
                    },
                    {
                        'targets': [3],
                        'data': 'nombre',
                        'render': function(data, type, row) {
                            return `<td class="nombre_cliente">${row['nombre']}</td>`;
                        }
                    },
                    {
                        'targets': [4],
                        'data': 'dir_entrega',
                        'render': function(data, type, row) {
                            return `<td class="dir_entrega">${row['dir_entrega']}</td>`;
                        }
                    },
                    {
                        'targets': [5],
                        'data': 'tipo_trabajo',
                        'render': function(data, type, row) {
                            return `<td class="tipo_trabajo">${row['tipo_trabajo']}</td>`;
                        }
                    },
                    {
                        'targets': [6],
                        'data': 'fec_inicio',
                        'render': function(data, type, row) {
                            var fec_inicio = '';
                            fec_inicio = dateFormat(row['fec_inicio']);
                            return `<td class="fec_inicio">${fec_inicio}</td>`;
                        }
                    },
                    {
                        'targets': [7],
                        'data': 'tipo_trabajo',
                        'render': function(data, type, row) {
                            var proccessname = '<?php echo $proccessname ?>';
                            var r = '';
                            var estado = row['estado']
                            if (!estado) {
                                estado = "SIN ESTADO";
                            }
                            if (proccessname == 'YUDI-NEUMATICOS') {
                                switch (estado) {
                                    case 'estados_procesosPROC_EN_CURSO':
                                        r = '<td>' + bolita('EN CURSO', 'green') + '</td></tr>';
                                        break;

                                    case 'estados_yudicaEN_CURSO':
                                        r = '<td>' + bolita('EN CURSO', 'green') + '</td></tr>';
                                        break;

                                    case 'estados_yudicaREPROCESO':
                                        r = '<td>' + bolita('REPROCESO', 'yellow') + '</td></tr>';
                                        break;

                                    case 'estados_yudicaENTREGADO':
                                        r = '<td>' + bolita('ENTREGADO', 'gray') + '</td></tr>';
                                        break;

                                    case 'estados_yudicaRECHAZADO':
                                        r = '<td>' + bolita('RECHAZADO', 'red') + '</td></tr>';
                                        break;

                                    default:
                                        r = '<td><button type="button" class="btn btn-secondary">' + estado + '</button></td></tr>';
                                        break;
                                }
                            } else {
                                switch (estado) {
                                    case 'estados_seinEN_CURSO':
                                        r = '<td>' + bolita('EN CURSO', 'green') + '</td></tr>';
                                        break;
                                    case 'estados_seinCOTIZACION_ENVIADA':
                                        r = '<td>' + bolita('COTIZACION ENVIADA', 'navy') + '</td></tr>';
                                        break;
                                    case 'estados_seinENTREGA_PENDIENTE':
                                        r = '<td>' + bolita('ENTREGA PENDIENTE', 'orange') + '</td></tr>';
                                        break;
                                    case 'estados_seinCORRECCION_NC':
                                        r = '<td>' + bolita('CORRECCION NC', 'teal') + '</td></tr>';
                                        break;
                                    case 'estados_seinRECHAZADO':
                                        r = '<td>' + bolita('RECHAZADO', 'red') + '</td></tr>';
                                        break;
                                    case 'estados_seinCANCELADO_NC':
                                        r = '<td>' + bolita('CANCELADO NC', 'red') + '</td></tr>';
                                        break;
                                    case 'estados_seinCONTRATADA':
                                        r = '<td>' + bolita('CONTRATADO', '0b5a36') + '</td></tr>';
                                        break;
                                    case 'estados_procesosTRABAJO_TERMINADO':
                                        r = '<td>' + bolita('TRABAJO TERMINADO', '0b5a36') + '</td></tr>';
                                        break;
                                    case 'estados_seinENTREGADO':
                                        r = '<td>' + bolita('ENTREGADO', 'gray') + '</td></tr>';
                                        break;
                                    default:
                                        r = '<td class="text-center"><button type="button" class="btn btn-secondary">' + estado + '</button></td></tr>';
                                        break;
                                }
                            }

                            return r;
                        }
                    }
                ],
                //agregado de data-json al tr de la tabla
                createdRow: function(row, data, dataIndex) {
                    json = JSON.stringify(data);
                    $(row).attr('data-json', json);
                    $(row).attr('id', data['petr_id']);
                    $(row).attr('case_id', data['case_id']);
                },
                "initComplete": function(settings, json) {
                    wc();
                }
            });
        }
    }
</script>