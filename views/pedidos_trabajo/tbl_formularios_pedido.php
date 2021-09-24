<?php if (isset($formularios)) {  ?>
<div class="table-responsive-md">
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Acciones</th>
                <th scope="col">Paso del Proceso</th>
                <th scope="col">Nombre de Formulario</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($formularios as $rsp){

                    $info_id = $rsp->info_id;
                                    
                    $formularios_array = $rsp->forms;
                 
                    foreach($formularios_array as $key=>$value)
                    {
                     
                        for ($i=0; $i < count($value) ; $i++) { 
                           

                            $nom_tarea = $value[$i]->nom_tarea;
                            $info_id = $value[$i]->info_id;
                            $nom_form = $value[$i]->nom_form;
                       
                      //      $formulario = getForm($info_id);
                            
                            echo "<tr id='$info_id' data-json='" . json_encode($value[$i]) . "'>"; 
                            echo '<td><i class="fa fa-eye"  style="cursor: pointer;margin: 3px;" title="Ver Formulario" onclick="verForm(this)"></i></td>';
                            echo '<td>'.$nom_tarea.'</td>';
                            echo '<td></td>';
                            echo '</tr>';
                            ?>

            <?php
                            
                        }
                      
                    }
                              
                    } 
                    ?>
        </tbody>


    </table>

</div>
<?php
             } 

         

                    ?>



            <!-- The Modal -->
            <div class="modal modal-fade" id="mdl-form-dinamico" data-backdrop="static">
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <br>
                        <div class="xmodal-body">
                            <br>
                            <div id="form-dinamico" data-frm-id="">

/-                        </div>
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
function cerrarModalform() {
    debugger;

$('#mdl-form-dinamico').modal('hide');

    // var selected3 = $('#form-dinamico').attr('data-frm-id');
    // $('#mdl-form-dinamico-'+selected3).empty();
    
    //     console.log('trae info_id N°: '+ selected3)
    // $('#mdl-form-dinamico-'+selected3).modal('hide');
    // $('#mdl-form-dinamico'+selected3).modal('toggle');
}

// function verForm() {
//     debugger;

//     var selected4 = $('#form-dinamico').attr('data-frm-id');

    
//         console.log('trae info_id N°: '+ selected4)

       
//     $('#mdl-form-dinamico-'+selected4).modal('show');

// }

// var formulario = $('#form-dinamico').attr('data-frm-id');


// $('#form-dinamico button.frm-save').addClass('oculto');


// $('#form-dinamico').find(':input').each(function() {
//     var elemento = this;
//     console.log("elemento.id=" + elemento.id);

//     $(elemento).attr('readonly', true);

//     $(elemento).attr('disabled', true);
// });


function verForm(e){
debugger;
   
   info_id =  $(e).closest('tr').attr('id');

    console.log('trae info_id N°: '+ info_id)


    var url = "<?php echo base_url(BPM); ?>Pedidotrabajo/cargar_formulario_asociado?info_id="+info_id;

  
wo();
wc();


window.setTimeout(function(){
    $('#mdl-form-dinamico').modal('show');
  }, 7000);


     console.log(url);
     $("#form-dinamico").empty();
      $("#form-dinamico").load(url);
   
}

</script>