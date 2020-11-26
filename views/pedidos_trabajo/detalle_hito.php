<?php
     $this->load->view('pedidos_trabajo/form_hito');
?>

<script>
    fillForm(<?php echo json_encode($hito) ?>,'#frm-hito');
    $('#frm-hito').find('.form-control').attr('disabled', true);
</script>