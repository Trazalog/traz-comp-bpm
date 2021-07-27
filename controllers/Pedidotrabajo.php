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

        $data['clientes'] = $this->Pedidotrabajos->getClientes(empresa())['data'];

        $data['pedidos'] = $this->Pedidotrabajos->obtener(empresa())['data'];
   
        $url_info= $_SERVER["REQUEST_URI"];

        $components = parse_url($url_info);

        parse_str($components['query'], $results);
    
        $proccessname = $results['proccessname']; 

        $this->session->set_userdata('proccessname', $proccessname);

      //  $this->load->view('pedido_trabajo', $data);
      $this->load->view('listar_pedidos_trabajo', $data);
    }


    //carga la vista de pedido trabajo
    //
    public function view_pedido()
    {
       
        $data['unidad_medida_tiempo'] = $this->Pedidotrabajos->seleccionarUnidadMedidaTiempo()['data'];
        $data['clientes'] = $this->Pedidotrabajos->getClientes(empresa())['data'];


        $url_info= $_SERVER["REQUEST_URI"];

        $components = parse_url($url_info);

        parse_str($components['query'], $results);
    
        $this->load->view('pedido_trabajo', $data);
     
    }


//trae comentarios segun Case_id
//
public function cargar_detalle_comentario(){

$case_id = $_GET['case_id'];    

$data_aux = ['case_id' => $case_id, 'comentarios' => $this->bpm->ObtenerComentarios($case_id)];

$data['comentarios'] = $this->load->view(BPM.'tareas/componentes/comentarios', $data_aux, true);

echo $data['comentarios'];
}

//trae trazabilidad de un pedido segun case_id
//y processId.
//HARCODECHUKA processId
public function cargar_detalle_linetiempo(){

    $case_id = $_GET['case_id'];               
        
   $processId = BPM_PROCESS_ID_REPARACION_NEUMATICOS;

  //LINEA DE TIEMPO
  $data['timeline'] =$this->bpm->ObtenerLineaTiempo($processId, $case_id);

  echo timeline($data['timeline']);
 
}

//trae formularios asociados al pedido de trabajo segun petr_id
//
public function cargar_detalle_formulario(){

    $case_id = $_GET['case_id'];        
    
    $petr_id = $_GET['petr_id'];
        
   $processId = BPM_PROCESS_ID_REPARACION_NEUMATICOS;

   $data['formularios'] = $this->Pedidotrabajos->getFormularios($petr_id)['data'];

   $this->load->view(BPM.'pedidos_trabajo/tbl_formularios_pedido', $data);
   

}

   
  

    public function guardarPedidoTrabajo()
    {
       $proccessname = $this->session->userdata('proccessname');


        $empr_id = empresa();
        $user_app = userNick();
        $esin_id = $this->Pedidotrabajos->procesos()->proceso->esin_id;

       $lanzar_bpm = $this->Pedidotrabajos->procesos()->proceso->lanzar_bpm;


        $data['_post_pedidotrabajo'] = array(

            'cod_proyecto' => $this->input->post('cod_proyecto'),
            'descripcion' => $this->input->post('descripcion'),
            'estado' => $esin_id,
            'objetivo' => $this->input->post('objetivo'),
            'fec_inicio' => $this->input->post('fec_inicio'),
            'fec_entrega' => $this->input->post('fec_entrega'),
            'usuario_app' => $user_app,
            'umti_id' => $this->input->post('unidad_medida_tiempo'),
            'info_id' => $this->input->post('info_id'),
            'proc_id' =>  $proccessname,
            'empr_id' => $empr_id,
            'clie_id' => $this->input->post('clie_id'),
            'tipt_id' => $this->input->post('tipt_id'), 

        );

        $rsp = $this->Pedidotrabajos->guardarPedidoTrabajo($data);

        $status = ($rsp['status']);

        $dato  = json_decode($rsp['data']);

        $petr_id  = $dato->respuesta->petr_id;


        if ($status == true) {

            $respuesta = json_encode($rsp);

            echo $respuesta;

            if ($lanzar_bpm == "true") {
                $this->BonitaProccess($petr_id);

                return $rsp;

            } else {
                log_message('DEBUG', '#TRAZA | #BPM >> BonitaProccess  >> lanzar_bpm viene false');
            }

        } elseif ($status == false) {

            log_message('ERROR', '#TRAZA | #BPM >> guardarPedidoTrabajo  >> ERROR al guardar pedido de trabajo Status false');

            $this->eliminarPedidoTrabajo($petr_id);

            return $rsp;

        } else {

            log_message('DEBUG', '#TRAZA | #BPM >> guardarPedidoTrabajo  >> ERROR TREMENDO');

            $this->eliminarPedidoTrabajo($petr_id);

            return $rsp;


        }

    }

    public function BonitaProccess($petr_id)
    {
      
        $data = array(
            'p_petrId' => $petr_id);

        $rsp = $this->Pedidotrabajos->guardarBonitaProccess($data);
        $case_id = json_decode($rsp['data']['caseId']);

        if (!$rsp['status']) {

            log_message('ERROR', '#TRAZA | #BPM >> BonitaProccess  >> ERROR AL GUARDAR');

            $this->eliminarPedidoTrabajo($petr_id);

            return;

        } else {
            log_message('DEBUG', '#TRAZA | #BPM >> BonitaProccess  >> TODO OK - se lanzo proceso correctamente');
           #echo json_encode($data);
            $this->ActualizarCaseId($case_id, $petr_id);

        }

    }

    public function ActualizarCaseId($case_id, $petr_id)
    {

				$str_case_id = (string) $case_id;

        $data['_put_pedidotrabajo'] = array(

            "case_id" => $str_case_id,
            "petr_id" => $petr_id,

        );

        $rsp = $this->Pedidotrabajos->ActualizarCaseId($data);

        if (!$rsp) {

            log_message('ERROR', '#TRAZA | #BPM >> ActualizarCaseId  >> ERROR AL ACTUALIZAR');

           // $this->eliminarPedidoTrabajo($petr_id);

            return $rsp;

        } else {
            log_message('DEBUG', '#TRAZA | #BPM >> ActualizarCaseId  >> TODO OK - se actualizo CaseId del pedido');
            #echo json_encode($data);
            //     $this->BonitaProccess($petr_id);

        }

    }

    public function eliminarPedidoTrabajo($petr_id)
    {
        $data['_delete_pedidotrabajo'] = array(
            'petr_id' => $petr_id,
        );

        $data = $this->Pedidotrabajos->eliminarPedidoTrabajo($data);

    }
		/**
		* Levanta pantalla Planificacion de Pedido de Trabajo
		* @param
		* @return
		*/
    public function dash()
    {
      $this->load->view('pedidos_trabajo/dash', $data);
    }
		/**
		* Agrega componente Pedidos Trabajo(en Planificacion Trabajos)
		* @param
		* @return 
		*/
    public function pedidosTrabajos($emprId)
    {

        $data['ots'] = $this->Pedidotrabajos->obtener($emprId)['data'];
        $this->load->view('pedidos_trabajo/lista_pedidos', $data);
    }
		/**
		* Agrega componente Hitos(en Planificacion Trabajos) si envia datos.
		* sino es asi,trae el listado de hitos guardados para ese pedido ese trabajo
		* @param
		* @return view listado de hitos de un pedido de trabajo
		*/
    public function hitos($petrId)
    {
        $post = $this->input->post();
        if($post)
        {
            $rsp = $this->Pedidotrabajos->guardarHito($petrId, $post);
            echo json_encode($rsp);
        }else{
						$data['hitos'] = $this->Pedidotrabajos->obtenerHitosXPedido($petrId)['data'];
					// AGREGADO DE MERGE DE CHECHO
						$data['info_id']="0".$this->Pedidotrabajos->obtenerInfoId($petrId)['data'];
						$data['petr_id'] = "0".$petrId;
					// FIN AGREGADO DE MERGE DE CHECHO
            $this->load->view('pedidos_trabajo/lista_hitos', $data);
        }
    }

    public function hito($hitoId = false)
    {  
        if($hitoId){
            $data['hito'] = $this->Pedidotrabajos->obtenerHito($hitoId)['data'][0];
            $this->load->view('pedidos_trabajo/detalle_hito', $data);
        }else{
            $this->load->view('pedidos_trabajo/form_hito');
        }
    }

    public function cambiarEstado()
    {
        $post  = $this->input->post();
        $rsp = $this->Pedidotrabajos->cambiarEstado($post['petrId'], $post['estado']);
        echo json_encode($rsp);
    }
}
