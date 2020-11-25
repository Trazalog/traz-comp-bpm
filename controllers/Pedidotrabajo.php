<?php defined('BASEPATH') or exit('No direct script access allowed');

class Pedidotrabajo extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    $this->load->model('Pedidotrabajos');
    }

    public function index()
    {
   $data['unidad_medida_tiempo'] = $this->Pedidotrabajos->seleccionarUnidadMedidaTiempo()['data'];
   $data['clientes'] = $this->Pedidotrabajos->getClientes()['data'];
   $this->load->view('pedido_trabajo',$data);
    }


    public function guardarPedidoTrabajo()
    {

      $data['_post_pedidotrabajo'] = array(

        'cod_proyecto' => $this->input->post('cod_proyecto'),
        'descripcion' => $this->input->post('descripcion'),
        'estado'=>'PROC_INICIAL_EN_CURSO',
        'objetivo' => $this->input->post('objetivo'),
        'fec_inicio' => $this->input->post('fec_inicio'),
        'fec_entrega' => $this->input->post('fec_entrega'),
        'usuario_app' =>'rodotest',
        'umti_id' => $this->input->post('unidad_medida_tiempo'),
        'info_id'=>'571',
        'proc_id'=>'procesosReparacion Neumaticos',
        'empr_id' =>'1',
        'clie_id' => $this->input->post('clie_id'),
        'case_id_inicial'=>'1000'
       
        
       
      );
  
      $rsp =  $this->Pedidotrabajos->guardarPedidoTrabajo($data);
      $petr_id = json_decode($rsp['data'])->respuesta->petr_id;
     
      $this->BonitaProccess($petr_id);
      
      echo json_encode($data);
    }

  

 public function BonitaProccess($petr_id)

    {

      $data = array(
          'nombre_proceso'=> 'YUDI001',
          "payload" =>  array('p_petrId' => $petr_id),
          'session' => 'X-Bonita-API-Token=14485fa7-6b5e-4972-9aa4-4571668c9321;JSESSIONID=AC637E6D080C7E5CF3EEF8407D5ACEE6;bonita.tenant=1;'
        );

        
      $data = $this->Pedidotrabajos->guardarBonitaProccess($data);
      echo json_encode($data);
    }



    public function eliminarPedidoTrabajo()
        {
          $data['_delete_pedidotrabajo'] = array(
            'petr_id' => $this->input->post('')
          );

          $data = $this->Pedidotrabajos->eliminarPedidoTrabajo($data);
        
        }


   


}
