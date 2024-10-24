<?php

use Google\Service\Blogger\Post;

 defined('BASEPATH') or exit('No direct script access allowed');
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

        //$data['pedidos'] = $this->Pedidotrabajos->obtener(empresa())['data'];
   
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
    $url_info= $_SERVER["REQUEST_URI"];
    $components = parse_url($url_info);
    parse_str($components['query'], $results);
    // if (isset($results['proccessname'])) {
    //     $proccessname =$results['proccessname'];
    // } else {
    //     $proccessname = $this->session->userdata('proccessname');
    // }
    if (isset($_GET['case_id'])) {
        $case_id = $_GET['case_id'];        
    }else {
        $case_id = $this->input->get('case_id');
        // $processId = $this->input->get('proccessname');
    }
    // if ($proccessname !=''){
        //Id del proceso desde la tabla pro.procesos
        // $processId = $this->Pedidotrabajos->procesos($proccessname)->proceso->nombre_bpm;
        //LINEA DE TIEMPO
    //     $data['timeline'] =$this->bpm->ObtenerLineaTiempo($processId, $case_id);
    //     echo timeline($data['timeline']);
    // }else {
    //     $processId = $_GET['proccessname'];
        // $processId = BPM_PROCESS_ID_PROCESO_PRODUCTIVO;
        //LINEA DE TIEMPO
    //     $data['timeline'] =$this->bpm->ObtenerLineaTiempo($processId, $case_id);
    //     echo timeline($data['timeline']);
    // }
    $processId = BPM_PROCESS_ID_PEDIDOS_NORMALES;
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
    $proccessname = $this->session->userdata('proccessname');
    $processId = $this->Pedidotrabajos->procesos($proccessname)->proceso->nombre_bpm;
    $case_id = $_GET['case_id'];                  
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
    $url_info= $_SERVER["REQUEST_URI"];
    $petr_id = $_GET['petr_id'];
    $proccessname = $this->session->userdata('proccessname');
    $processId = $this->Pedidotrabajos->procesos($proccessname)->proceso->nombre_bpm;
    $data['formularios'] = $this->Pedidotrabajos->getFormularios($petr_id)['data'];
    $this->load->view(BPM.'pedidos_trabajo/tbl_formularios_pedido', $data);
}

/**
	* Trae formularios asociados al pedido de trabajo segun petr_id
	*@param case_id ,petr_id, processId. (metodo GET)
    *@return array forularios
*/
public function cargar_detalle_formularioJson(){
    log_message('DEBUG', '#TRAZA | #TRAZ-COMP-BPM | Pedidotrabajo | cargar_detalle_formularioJson()');
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

    /**
        * Busca en el case especificado, que el proceso se encuentre parado actualmente sobre la tarea enviada y la cierra
        *@param array $post con estado, case_id, proc_id y petr_id
        *@return array respuesta según servicio
    */
    public function finalizarTrabajo(){
        log_message('DEBUG','#TRAZA | TRAZ-COMP-BPM | Pedidotrabajo | finalizarTrabajo()');
        $post  = $this->input->post();
        $proceso = $this->Pedidotrabajos->procesos($post['proc_id'])->proceso;
        $taskObtenido = $this->bpm->ObtenerTaskidXNombre($proceso->nombre_bpm,$post['case_id'], TAREA_IT);
        if(!empty($taskObtenido)){
            $aux = $this->bpm->setUsuario($taskObtenido,userId());
            $auxi = $this->bpm->cerrarTarea($taskObtenido);
            $rsp = $this->Pedidotrabajos->cambiarEstado($post['petr_id'], $post['estado']);
        }else{
            $rsp['status'] = false;
            $rsp['msj'] = "El case especificado no se encuentra en el paso de la TAREA IT";
        }
        echo json_encode($rsp);
    }
    
    /**
        * Trae cabecera relacionada con el proceso
        *@param $case_id (metodo GET)
        *@return array forularios
    */
    public function cargar_detalle_cabecera(){
        $case_id = $this->input->get('case_id');
        // $case_id = $this->input->post('case_id');
        $proccessname = $this->session->userdata('proccessname');

        if ($proccessname == 'YUDI-NEUMATICOS') {
            $this->load->model(YUDIPROC.'Yudiproctareas');
        }

        //Id del proceso desde la tabla pro.procesos
        $processId = $this->Pedidotrabajos->procesos($proccessname)->proceso->nombre_bpm;

        $tarea = new StdClass();
        $tarea->caseId = $case_id;
        $tarea->processId = $processId;
        $tarea->nombreTarea = '';

        if ($proccessname == 'YUDI-NEUMATICOS') {
            $cabecera = $this->Yudiproctareas->desplegarCabecera($tarea);
        }else{
            $this->load->model(SEIN.'Proceso_tareas');
            $cabecera = $this->Proceso_tareas->desplegarCabecera($tarea);
        }
        echo $cabecera;
    }
    /**
        * Trae listado de hitos con sus respectivas tareas para el pedido de trabajo
        *@param $petr_id (método GET)
        *@return array forularios
    */
    public function cargar_detalle_tareas_planificadas(){
        $petr_id = $this->input->get('petr_id');
        $proccessname = $this->session->userdata('proccessname');

        //Id del proceso desde la tabla pro.procesos
        $processId = $this->Pedidotrabajos->procesos($proccessname)->proceso->nombre_bpm;
        $rsp = $this->Pedidotrabajos->obtenerHitosXPedido($petr_id);
        $data['listadoHitos'] = $rsp['status'] ? $rsp['data'] : null;

        $this->load->view(BPM.'pedidos_trabajo/tbl_tareas_planificadas', $data);
    }
    /**
        * Crea la vista con el detalle con listado de pedidos de materiales las tareas planificadas
        *@param $tapl_id (método GET)
        *@return view vista listado de pedidos de materiales
    */
    public function listadoPedidosMaterialesXTarea($tapl_id){
        $this->load->model(TST.'Pedidos');
        $data['pedidos'] = $this->Pedidos->obtenerXTarea($tapl_id);
        $this->load->view('pedidos_trabajo/listado_pedidos_materiales', $data);
    }


    /**
	* Genera el listado de los pedidos de trabajo paginado
	* @param integer;integer;string start donde comienza el listado; length cantidad de registros; search cadena a buscar
	* @return array listado paginado y la cantidad
	*/
	public function paginado(){//server side processing

		$start = $this->input->post('start');
		$length = $this->input->post('length');
		$search = $this->input->post('search')['value'];
		$PedidosFinalizados = $this->input->post('PedidosFinalizados');
        
        //recibo los datos que vienen del dataTable
        $myData = array(
            'order' =>  $this->input->post('order[0][dir]'),
            'columna' => intval($this->input->post('order[0][column]')),
            'petr_id' => $this->input->post('columns[1][data]'),
            'cod_proyecto' => $this->input->post('columns[2][data]'),
            'nombre' => $this->input->post('columns[3][data]'),
            'dir_entrega' => $this->input->post('columns[4][data]'),
            'tipo_trabajo' => $this->input->post('columns[5][data]'),
            'fec_inicio' => $this->input->post('columns[6][data]')
        );
      

        //consulta si trae los pedidos finalizados o los no finalizados
        if($PedidosFinalizados)
        {
            $r = $this->Pedidotrabajos->pedidosTrabajoFinalizadosPaginados($start,$length,$search,$myData);
        }
        else{
            // echo var_dump($start,$length,$search,$myData);
            $r = $this->Pedidotrabajos->pedidosTrabajoPaginados($start,$length,$search,$myData);
        }

		$datos =$r['datos'];
		$totalDatos = $r['numDataTotal'];
		$datosPagina = count($datos);

		$json_data = array(
			"draw" 				=> intval($this->input->post('draw')),
			"recordsTotal"  	=> intval($datosPagina),
			"recordsFiltered"	=> intval($totalDatos),
			"data" 				=> $datos,
            "filtro" => $r['filtro'],
            "estadoFinal" => $r['estadoFinal'],
            'search' => $search,
            "mydata" => $r['mydata']
            
		);
		echo json_encode($json_data);
	}


     /**
	* Trae fecha de tarea finalizada desde bonita
	* @return $fecha fin de tarea
	*/
    public function fechaFinTareaDesdeBonita(){
        $case_id = $_GET['case_id'];
        $proc_id =  $_GET['proc_id'];   
        $proceso = $this->Pedidotrabajos->procesos($proc_id)->proceso;
        $datos = $this->Pedidotrabajos->traeDatosPedidoEntregadoBonita($case_id, $proceso->nombre_bpm);
        $fecha = $datos[0]['reached_state_date'];
        echo $fecha;
    }
}