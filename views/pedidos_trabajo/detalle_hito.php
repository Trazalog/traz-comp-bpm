<style>
.isDisabled {
  color: currentColor;
  cursor: not-allowed;
  opacity: 0.5;
  text-decoration: none;
}
</style>
<?php
     $this->load->view('pedidos_trabajo/form_hito');
?>

<script>
    debugger;
    fillForm(<?php echo json_encode($hito) ?>,'#frm-hito');
    $('#frm-hito').find('.form-control').attr('disabled', true);
</script>