<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
	* Laza Pedido de Trabajo con informacion variable segun proceso BPM
	*
	* @autor Kevin Marchan
	*/
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
        //$data['tipo_trabajo'] = $this->Pedidotrabajos->obtenerTabla('tipos_pedidos_trabajo')['data'];
        $data['tipo_trabajo'] = $this->Pedidotrabajos->obtenerTablaEmpr_id('tipos_pedidos_trabajo')['data'];
        
        $url_info= $_SERVER["REQUEST_URI"];

        $components = parse_url($url_info);

        parse_str($components['query'], $results);
    
        $this->load->view('pedido_trabajo', $data);
     
    }



/**
	* Trae comentarios segun Case_id
	*@param case_id (metodo GET)
    *@return view componete comentarios
	*/
public function cargar_detalle_comentario(){

$case_id = $_GET['case_id'];    

$data_aux = ['case_id' => $case_id, 'comentarios' => $this->bpm->ObtenerComentarios($case_id)];

$data['comentarios'] = $this->load->view(BPM.'tareas/componentes/comentarios', $data_aux, true);

echo $data['comentarios'];
}


/**
	* Trae trazabilidad de un pedido segun case_id
	*@param case_id ,processId. (metodo GET)
    *@return array componete BPM trazabilidad
	*/
//HARCODECHUKA processId
public function cargar_detalle_linetiempo(){

    $case_id = $_GET['case_id'];               
        
  $processId = BPM_PROCESS_ID_REPARACION_NEUMATICOS;
 
  //LINEA DE TIEMPO
  $data['timeline'] =$this->bpm->ObtenerLineaTiempo($processId, $case_id);

  echo timeline($data['timeline']);
 
}


/**
	* Trae el estado actual de la tarea de un pedido segun case_id
	*@param case_id ,processId. (metodo GET)
    *@return array componete BPM timelineInfoActual
	*/
//HARCODECHUKA processId
public function cargar_detalle_info_actual(){

    $case_id = $_GET['case_id'];               
        
   $processId = BPM_PROCESS_ID_REPARACION_NEUMATICOS;

  //LINEA DE TIEMPO
  $data['timeline'] =$this->bpm->ObtenerLineaTiempo($processId, $case_id);

  echo timelineInfoActual($data['timeline']);
 
}

/**
	* Trae formularios asociados al pedido de trabajo segun petr_id
	*@param case_id ,petr_id, processId. (metodo GET)
    *@return array forularios
	*/
//HARCODECHUKA processId
public function cargar_detalle_formulario(){

    $case_id = $_GET['case_id'];        
    
    $petr_id = $_GET['petr_id'];
        
   $processId = BPM_PROCESS_ID_REPARACION_NEUMATICOS;

   $data['formularios'] = $this->Pedidotrabajos->getFormularios($petr_id)['data'];

   $this->load->view(BPM.'pedidos_trabajo/tbl_formularios_pedido', $data);
   

}



/**
	* Trae formularios asociados al pedido de trabajo segun petr_id
	*@param case_id ,petr_id, processId. (metodo GET)
    *@return array forularios
	*/

public function cargar_detalle_formularioJson(){
   
    $this->load->model(FRM . 'Forms');

    $case_id = $_GET['case_id'];        
    
    $petr_id = $_GET['petr_id'];
        

   $data = $this->Pedidotrabajos->getFormularios($petr_id)['data'];

   $prueba = $data[0]->forms->form;
   
   foreach ($prueba as $value) {

    switch ($value->nom_form) {

        case 'Rechazo de Tarea':
            
            $info_id = $value->info_id;

            $res = $this->Forms->obtener($info_id);


              $motivo['motivo_rechazo'] = $res->items[0]->valor;
     

            break;

            default:

            break;
    }

}


   echo json_encode($motivo);

}



/**
	* Instancia un formulario asociado
	*@param info_id (metodo GET)
    *@return array forulario
	*/
public function cargar_formulario_asociado(){

    $info_id = $_GET['info_id'];   
    
    $formulario = getForm($info_id);

    echo $formulario;
}

   
  
    /**
		*Guarda Pedido de Trabajo.
		* @param array
		* @return si guarda pedido retorna mensaje de guardado, sino guarda elimina pedido
	**/
    public function guardarPedidoTrabajo()
    {
       $proccessname = $this->session->userdata('proccessname');

       $empr_id = empresa();
       $user_app = userNick();

       //Si el proceso viene vacio usamos proceso estandar
       $proceso = $this->Pedidotrabajos->procesos($proccessname)->proceso;

        if(isset($proceso->nombre_bpm)){
            $esin_id = $proceso->esin_id;
            $lanzar_bpm = $proceso->lanzar_bpm;
        }else{
            $proccessname = PRO_STD;
            $proceso = $this->Pedidotrabajos->procesos($proccessname)->proceso;
            $esin_id = $proceso->esin_id;
            $lanzar_bpm = $proceso->lanzar_bpm;
        }

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

            log_message('ERROR', '#TRAZA | #BPM |Pedido Trabajo | guardarPedidoTrabajo  >> ERROR al guardar pedido de trabajo Status false');

            $this->eliminarPedidoTrabajo($petr_id);

            return $rsp;

        } else {

            log_message('DEBUG', '#TRAZA | #BPM |Pedido Trabajo | guardarPedidoTrabajo  >> ERROR TREMENDO');

            $this->eliminarPedidoTrabajo($petr_id);

            return $rsp;


        }

    }

     /**
		*Lanza proceso en BPM (en Pedido Trabajos).
		* @param  petr_id
		* @return 
		**/

    public function BonitaProccess($petr_id)
    {
      
        $data = array(
            'p_petrId' => $petr_id);

        $rsp = $this->Pedidotrabajos->guardarBonitaProccess($data);
        $case_id = json_decode($rsp['data']['caseId']);

        if (!$rsp['status']) {

            log_message('ERROR', '#TRAZA | #BPM |Pedido Trabajo |  BonitaProccess  >> ERROR AL GUARDAR POCESO EN BONITA');

            $this->eliminarPedidoTrabajo($petr_id);

            return;

        } else {
            log_message('DEBUG', '#TRAZA | #BPM |Pedido Trabajo | BonitaProccess  >> TODO OK - se lanzo proceso correctamente');
           #echo json_encode($data);
            $this->ActualizarCaseId($case_id, $petr_id);

        }

    }

    /**
		*Actualiza Case_id (en Pedido Trabajos).
		* @param array (case_id , petr_id)
		* @return 
		**/

    public function ActualizarCaseId($case_id, $petr_id)
    {

				$str_case_id = (string) $case_id;

        $data['_put_pedidotrabajo'] = array(

            "case_id" => $str_case_id,
            "petr_id" => $petr_id,

        );

        $rsp = $this->Pedidotrabajos->ActualizarCaseId($data);

        if (!$rsp) {

            log_message('ERROR', '#TRAZA | #BPM |Pedido Trabajo | ActualizarCaseId  >> ERROR AL ACTUALIZAR CASO DE PEDIDO');

           // $this->eliminarPedidoTrabajo($petr_id);

            return $rsp;

        } else {
            log_message('DEBUG', '#TRAZA | #BPM |Pedido Trabajo | ActualizarCaseId  >> TODO OK - se actualizo CaseId del pedido');
            #echo json_encode($data);
            //     $this->BonitaProccess($petr_id);

        }

    }

    	/**
		* Elimina Pedidos Trabajo
		* @param array $petr_id $processId,$case_id (metodo GET)
		* @return 
		*/
//HARCODECHUKA processId

    public function eliminarPedidoTrabajo()
    {
        $processId = BPM_PROCESS_ID_REPARACION_NEUMATICOS;

        if($_GET)
		{
			$case_id = $_GET["case_id"];

            $petr_id = $_GET["petr_id"];
			
		} else{
            $case_id =  $this->input->post('case_id');

            $petr_id =  $this->input->post('petr_id');
        }

        $data['_delete_pedidotrabajo'] = array(
            'petr_id' => $petr_id,
        );

        $rsp = $this->Pedidotrabajos->eliminarPedidoTrabajo($data);

        if (!$rsp) {

            log_message('ERROR', '#TRAZA | #BPM |Pedido Trabajo |  Eliminar pedido de trabajo >> Error al Eliminar Pedido de Trabajo');

           // $this->eliminarPedidoTrabajo($petr_id);

           // return $rsp;
           echo json_encode($rsp);

        } else {
            log_message('DEBUG', '#TRAZA | #BPM |Pedido Trabajo |  Eliminar pedido de trabajo   >> Se Elimino pedido de Trabajo Correctamente');
            

           //si no falla elimina el caso asociado al pedido de trabajo llamando a la API

           $rsp = $this->bpm->eliminarCaso($processId, $case_id);

           if (!$rsp) {

            log_message('ERROR', '#TRAZA | #BPM |Pedido Trabajo | Eliminar Caso  >> Error al Eliminar Case_id');

            //return $rsp;
            echo json_encode($rsp);

        } else {
            log_message('DEBUG', '#TRAZA | #BPM |Pedido Trabajo | Eliminar Caso >> Se Elimino Caso y Pedido de trabajo Correctamente');

            echo json_encode($rsp);
        
        }

    }
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