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



            


<script>
function cerrarModalform() {
    $('#mdl-form-dinamico').modal('hide');
    $('#mdl-vista').modal('show');
}

function verForm(e){
    wo();
    info_id =  $(e).closest('tr').attr('id');
    console.log('trae info_id N°: '+ info_id)
    var url = "<?php echo base_url(BPM); ?>Pedidotrabajo/cargar_formulario_asociado?info_id="+info_id;
    $('#mdl-vista').modal('hide');
    $("#form-dinamico").empty();
    $("#form-dinamico").load(url, () => {
        $('#mdl-form-dinamico').modal('show');
        wc();
    });
}

</script>