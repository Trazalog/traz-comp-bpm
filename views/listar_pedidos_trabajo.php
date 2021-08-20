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
          echo '<td><span data-toggle="tooltip" title="" class="badge bg-red">RECHAZADO</span></td>';
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
            columns: [ 1, 2, 3, 4, 5, 6 ]
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
            columns: [ 1, 2, 3, 4, 5, 6 ]
                },
          footer: true,
          title: 'Pedidos de Trabajo',
          filename: 'Pedidos de Trabajo',
          text: '<button class="btn btn-danger ml-2 mb-2 mb-2 mt-3">Exportar a PDF <i class="fa fa-file-pdf-o mr-1"></i></button>'
        },
        {
          extend: 'copy',
          exportOptions: {
            columns: [ 1, 2, 3, 4, 5, 6 ]
                },
          footer: true,
          title: 'Pedidos de Trabajo',
          filename: 'Pedidos de Trabajo',
          text: '<button class="btn btn-primary ml-2 mb-2 mb-2 mt-3">Copiar <i class="fa fa-file-text-o mr-1"></i></button>'
        },
        {
          extend: 'print',
          exportOptions: {
            columns: [ 1, 2, 3, 4, 5, 6 ]
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

//funcion boton eliminar
//
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

//Elimina un pedido
//parametro petr_id
//
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