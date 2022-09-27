<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>TRAZALOG | TOOLS</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Manifest para el desarrollo de la PWA -->
    <link rel="manifest" crossorigin="use-credentials" href="<?php echo base_url();?>manifest.json">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="<?php echo base_url();?>lib/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo base_url();?>lib/bower_components/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="<?php echo base_url();?>lib/bower_components/Ionicons/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url();?>lib/dist/css/AdminLTE.min.css">
    <!-- css iconos redondos -->
    <link rel="stylesheet" href="<?php echo base_url();?>lib/iconcurved.css">
    <!-- css tabla scroll dispositivo movil -->
    <link rel="stylesheet" href="<?php echo base_url();?>lib/table-scroll.css">

    <!-- css sweetalert -->
    <link rel="stylesheet" href="<?php echo base_url();?>lib/sweetalert/sweetalert.css">
    <!-- Estilos case image + vista previa -->
    <link rel="stylesheet" href="<?php echo base_url();?>lib/imageForms/styleImgForm.css">
    
    <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="<?php echo base_url();?>lib/dist/css/skins/_all-skins.min.css">

    <link rel="stylesheet" href="<?php echo base_url();?>lib/plugins/datetimepicker/css/bootstrap-datetimepicker.min.css">

    <link rel="stylesheet"
        href="<?php echo base_url()?>lib/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">

        <!-- Select2 -->
        <link rel="stylesheet" href="<?php echo base_url()?>lib/bower_components/select2/dist/css/select2.min.css">

        
    <link rel="stylesheet" href="<?php echo base_url() ?>lib/bower_components/select2/dist/css/boostrap.css">



    <link rel="stylesheet" href="<?php echo base_url()?>lib/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

    <link rel="stylesheet" href="<?php echo base_url()?>lib/bower_components/bootstrap-daterangepicker/daterangepicker.css">

    <!-- Bootstrap datetimepicker -->
    <link rel="stylesheet" href="<?php echo base_url();?>lib/plugins/datetimepicker/css/bootstrap-datetimepicker.min.css">

    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="<?php echo base_url();?>lib/plugins/iCheck/all.css">

    <link rel="stylesheet" href="<?php echo base_url();?>lib/bootstrapValidator/bootstrapValidator.min.css" />

    <!-- alertifyjs -->

    <link rel="stylesheet" href="<?php  echo base_url();?>lib/alertify/css/alertify.css">
    <link rel="stylesheet" href="<?php  echo base_url();?>lib/alertify/css/themes/bootstrap.css">

    <!-- animate.css -->

    <link rel="stylesheet" href="<?php  echo base_url();?>lib/animate/animate.css">

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <link rel="stylesheet" href="<?php echo base_url() ?>lib/swal/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>lib\timepicker\jquery.timepicker.min.css">

    <link href='<?php  echo base_url();?>assets/fullcalendar/lib/main.min.css' rel='stylesheet' />

    <!-- Lupa imagenes -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnify/2.3.3/css/magnify.css" integrity="sha512-JxBFHHd+xyHl++SdVJYCCgxGPJKCTTaqndOl/n12qI73hgj7PuGuYDUcCgtdSHTeXSHCtW4us4Qmv+xwPqKVjQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        .mr-2{
            margin-right: 5px;
        }

        .oculto {
            display: none;
        }

        .trazalog:after {
            /*content: "\A TOOLS";*/
            content: " TOOLS";
            font-size: 12px;
            /*white-space: pre-line;*/
            
        }  

        .calendar {
            max-width: 1100px;
            margin: 0 auto;
        }

        .panel-primary>.panel-heading {
        color: #fff;
        background-color: #dd4b39 !important;
        border-color: #dd4b39 !important;
        }   

    </style>
<style>
.frm-save {
    display: none;
}
</style>

    <?php $this->load->view('layout/general_scripts');
    
    
    $url_info= $_SERVER["REQUEST_URI"];

    $components = parse_url($url_info);

    parse_str($components['query'], $results);

    $petr_id =$results['id'];
   
    $proccessname =$results['proccessname'];

    $ci =& get_instance();
    $ci->load->model(SEIN . 'Proceso_tareas');

    
    $aux = $ci->rest->callAPI("GET",REST_PRO."/pedidoTrabajo/petr_id/".$petr_id);
    $data_generico =json_decode($aux["data"]);
    $aux = $data_generico->pedidos_info->pedido_info[0];


   $case_id = $aux->case_id;



    ?>
 


</head>
<body class="hold-transition skin-red sidebar-mini">
    <div class="box box-primary" id="view_cliente">
        <div class="box-header with-border">
            <h4 class="box-title">Informe del Proceso</h4>
        </div>
        <div class="box-body" id="mdl-vista">

            <div id="cabecera"></div>
    <input id="tarea" data-info="" class="hidden">
    <input type="text" class="form-control hidden" id="processId" value="<?php echo $proccessname; ?>">
    <input type="text" class="form-control hidden" id="petr_id" value="<?php echo $petr_id; ?>">
    <input type="text" class="form-control hidden" id="caseId" value="<?php echo $case_id; ?>">

    <div class="nav-tabs-custom ">
        <ul class="nav nav-tabs">
            <!-- <li class="active"><a href="#tab_4" data-toggle="tab" aria-expanded="false">Acciones</a></li> -->
            
            <li class="active"><a href="#tab_3" data-toggle="tab" aria-expanded="false">Trazabilidad</a></li>
            <li class="privado"><a href="#tab_2" data-toggle="tab" aria-expanded="false">Comentarios</a></li>
            <li class="privado"><a href="#tab_1" data-toggle="tab" aria-expanded="true">Información</a></li>
            <li class="privado"><a href="#tab_5" data-toggle="tab" aria-expanded="true">Formulario</a></li>
            <!-- <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                    Dropdown <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Action</a></li>
                    <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Another action</a></li>
                    <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Vista Global</a></li>
                    <li role="presentation" class="divider"></li>
                    <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Separated link</a></li>
                </ul>
            </li> -->
            <!-- <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li> -->

        </ul>
        <div class="tab-content">
    
            <div class="tab-pane" id="tab_1">
                    <div id="cargar_info_actual"></div>
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="tab_2">
                        <div id="cargar_comentario"></div>
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane active" id="tab_3">
                    <div id="cargar_trazabilidad"></div>
                    </div>

                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="tab_5">
                        <div id="cargar_form"></div>
                    </div>
            </div>
        </div>
            </div>
        </div>
    </div>
    <!-- The Modal -->
    <div class="modal modal-fade">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="xmodal-body">
    


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>


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



    //funcion ver pedido
    // parametro petr_id y case_id
    //
    function verPedido() {
debugger;

        wo();

    petr_id =   $('#petr_id').val();
	case_id =   $('#caseId').val();
   

    processId =   $('#processId').val();

	console.log('trae pedido N°: ' + petr_id);
	console.log('trae case_id N°: ' + case_id);
    console.log('trae processId : ' + processId);

     header = "<?php echo base_url(BPM); ?>Pedidotrabajo/cargar_detalle_cabecera?case_id=" + case_id;
        var url = "<?php echo base_url(BPM); ?>Pedidotrabajo/cargar_detalle_comentario?petr_id=" + petr_id + "&case_id=" + case_id;
        var url1 = "<?php echo base_url(BPM); ?>Pedidotrabajo/cargar_detalle_formulario?petr_id=" + petr_id + "&case_id=" + case_id;
        var url2 = "<?php echo base_url(BPM); ?>Pedidotrabajo/cargar_detalle_linetiempo?case_id=" + case_id+ "&processId=" + processId;
        var url3 = "<?php echo base_url(BPM); ?>Pedidotrabajo/cargar_detalle_info_actual?case_id=" + case_id;
      

        $("#cabecera").empty();
        $("#cabecera").load(header);

        $("#cargar_comentario").empty();
        $("#cargar_comentario").load(url, () => {
            // $('#mdl-vista').modal('show');
            wc();
        });

        $("#cargar_form").empty();
        debugger;
        $("#cargar_form").load(url1, () => {
            // $('#mdl-vista').modal('show');
            wc();
        });

        $("#cargar_trazabilidad").empty();
        $("#cargar_trazabilidad").load(url2,() => {
            // $('#mdl-vista').modal('show');
            wc();
        });

        $("#cargar_info_actual").empty();
        $("#cargar_info_actual").load(url3, () => {
            // $('#mdl-vista').modal('show');
            wc();
        });
        
    }



////////////////////////////////

// $('#view').ready(function() {
// wo();
//     alertify.success("Cargando datos en la vista aguarde...");
    
//     setTimeout(function() {
//         wc();    
//         verPedido();
// }, 9000);
   
    
// });


////////////////////////////////

  $('#view').ready(function() {
    wbox('#view_cliente');  
    alertify.success("Cargando datos en la vista aguarde...");
   
    setTimeout(function() {
        verPedido();
          wbox();  
    }, 6000);
    });

    </script>
</body>
</html>