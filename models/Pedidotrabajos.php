<?php
defined('BASEPATH') or exit('No direct script access allowed');
// Model ABM No Consumibles
class Pedidotrabajos extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    
public function seleccionarUnidadMedidaTiempo()
{
  $resource = 'tablas/unidad_medida_tiempo';
  $url = REST_CORE . $resource;
  return wso2($url);
}


    
public function getClientes()
{
$resource = 'clientes/porEmpresa/1/porEstado/ACTIVO';
$url = REST_CORE . $resource;
return wso2($url);   
}         


// Guardar guardar Pedido de Trabajo
public function guardarPedidoTrabajo($data)
{ 
    $url = REST_PROD . '/pedidoTrabajo';
  $rsp = $this->rest->callApi('POST', $url, $data);
  return $rsp;
  if (!$rsp) {

    log_message('ERROR', '#TRAZA | #BPM >> guardarPedidoTrabajo  >> ERROR');

   

}else{
  log_message('DEBUG', '#TRAZA | #BPM >> guardarPedidoTrabajo  >> TODO OK');
}


}


     function eliminarPedidoTrabajo($data)
  	{
   //   DELETE http://10.142.0.7:8280/services/PRODataService/pedidoTrabajo 
        $url = REST_PROD . "/pedidoTrabajo";
        return wso2($url, 'DELETE',$data);
         }


// Guardar guardar BonitaProccess
public function guardarBonitaProccess($data)
{  
   //REST_PRD  http://10.142.0.7:8280/tools/bpm/proceso/instancia 
   //define('REST_BPM', 'http://10.142.0.7:8280/tools/bpm');
   
    $url = REST_BPM . '/proceso/instancia';
    $rsp = $this->rest->callApi('POST', $url, $data);
    return $rsp;

    if (!$rsp) {

      log_message('ERROR', '#TRAZA | #BPM >> guardarBonitaProccess  >> ERROR');

    

  }else{
    log_message('DEBUG', '#TRAZA | #BPM >> guardarBonitaProccess  >> TODO OK');
  }


}
    


}
