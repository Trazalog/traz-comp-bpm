<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
	* Laza Pedido de Trabajo con informacion variable segun proceso BPM
	*
	* @autor Kevin Marchan
	*/
class Pedidotrabajos extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

      /**
		*Obtiene datos facha 
		* @param 
		* @return array {mes,dia,año}
		**/
    public function seleccionarUnidadMedidaTiempo()
    {
        $resource = '/tablas/unidad_medida_tiempo';
        $url = REST_CORE . $resource;
        return wso2($url);
    }

   
   /**
		*Obtiene datos de clientes 
		* @param empr_id
		* @return lista de clientes por empresa
		**/
    public function getClientes($empr_id)
    {
        $resource = "/clientes/porEmpresa/$empr_id/porEstado/ACTIVO";
        $url = REST_CORE . $resource;
        return wso2($url);                                
    }

    public function obtenerTabla($tabla)
    {
        $url = REST_CORE . "/tablas/$tabla";
        return wso2($url);
    }
    /**
	* Obtiene los datos cargados en core.tablas por empr_id
	* @param string columna tabla a buscar
	* @return array listado de coincidencias
	*/
    public function obtenerTablaEmpr_id($tabla)
    {
        $url = REST_CORE."/tabla/$tabla/empresa/".empresa();
        return wso2($url);
    }
   
     /**
		*Obtiene los formularios asociados a un pedido de trabajo
		* @param petr_id
		* @return lista de formularios por petr_id
		**/
    public function getFormularios($petr_id)
    {
        $resource = "/pedidoTrabajo/petr_id/$petr_id";
        $url = REST_PRO . $resource;
        return wso2($url);     
                                   
    }

 
/**
		*Guardar Pedido de Trabajo
		* @param array
		* @return $rsp de guardado
		**/
    public function guardarPedidoTrabajo($data)
    {
        $url = REST_PRO . '/pedidoTrabajo';
        $rsp = $this->rest->callApi('POST', $url, $data);
        return $rsp;
    }

    /**
		*ELimina Pedido de Trabajo
		* @param array ($petr_id $processId,$case_id)
		* @return $rsp de eliminado
		**/
    public function eliminarPedidoTrabajo($data)
    {
        $url = REST_PRO . "/pedidoTrabajo";
        return wso2($url, 'DELETE', $data);
    }

// Guardar BonitaProccess
    public function guardarBonitaProccess($contract)
    {

        //obtengo processname
        $proccessname = $this->session->userdata('proccessname');

         //Si el proceso viene vacio usamos proceso estandar
       $proceso = $this->Pedidotrabajos->procesos($proccessname)->proceso;

       if(isset($proceso->nombre_bpm)){
         
        $nombre_bpm = $proceso->nombre_bpm;

       $rsp =  $this->bpm->lanzarProceso($nombre_bpm, $contract);
        return $rsp;
      }
}
    /**
		*Busca el proceso asociado a $processname en la tabla pro.procesos
		* @param array $processname
		* @return data del proceso asociado
    **/
    public function procesos($proccessname)
    {
        $resource = ($proccessname == PRO_STD) ? "/proceso/nombre/$proccessname/empresa/". empresa() : "/proceso/nombre/$proccessname/empresa/" . empresa();

        $url = REST_PRO . $resource;
        
        $array = $this->rest->callApi('GET', $url);

        return json_decode($array['data']);
    }

//Luego de crear un pedido de trabajo esta funcion actualiza el caseId del pedido
  /**
		*Actualiza Case_id (en Pedido Trabajos).
		* @param array case_id , petr_id
		* @return 
		**/

    public function ActualizarCaseId($data)
    {
        $url = REST_PRO . "/pedidoTrabajo";
        $rsp = $this->rest->callApi('PUT', $url, $data);
        return $rsp;

    }

 
     /**
		*Obtiene lista pedido de trabajo por emprId (todos los pedidos de una empresa)
		* @param  $emprId
		* @return lista de pedido de trabajo
		**/
    public function obtener($emprId){
        log_message('DEBUG', '#TRAZA | #TRAZ-COMP-BPM | PedidoTrabajos | obtener($emprId)  | $emprId: ' .$emprId);

        $proccessname = $this->session->userdata('proccessname');
        $this->db->select('p.esfi_id');
        $this->db->from('pro.procesos p');
        $this->db->where('p.proc_id', $proccessname);
        $this->db->limit(1);

        $query = $this->db->get();
        
        if($query->num_rows() > 0){
            $estadoFinal = $query->result_object()[0]->esfi_id;
        }else{
            $estadoFinal = "estados_procesosFINALIZADO";
        }

        $url = REST_PRO . "/pedidoTrabajoNoFinalizado/$emprId/$estadoFinal/ ";
        return wso2($url);
        
    }

    public function obtenerHitosXPedido($petrId)
    {
        $url = REST_TST . "/pedidostrabajo/hitos/$petrId";
        return wso2($url);
    }

    public function obtenerHito($hitoId)
    {
        $url = REST_TST . "/hitos/$hitoId";
        return wso2($url);
    }

    public function mapHito($data)
    {
        $data['fec_inicio'] = date('Y-m-d', strtotime($data['fec_inicio'])) . '+00:00:00';
        $data['documento'] = isset($data['documento']) ? $data['documento'] : '';
        $data['nombre_documento'] = isset($_FILES['documento']['name']) ? $data['nombre_documento'] : '';

      if(!empty($_FILES['documento']['tmp_name'])){
      $data['documento'] = base64_encode(file_get_contents($_FILES['documento']['tmp_name']));
/////////// nombre documento
      $data['nombre_documento'] = $_FILES['documento']['name'];

      }
        return payToStr($data);
    }

    public function guardarHito($petrId, $data)
    {
        $data['petr_id'] = $petrId;
        $xdata['_post_hitos'] = $this->mapHito($data);

            
            // if(!empty($_FILES['documento']['tmp_name'])){
            //  //  $xdata = base64_encode(file_get_contents($_FILES['documento']['tmp_name']));
            
            // //   return;
            // }

        $url = REST_TST."/hitos";
        return wso2($url, 'POST', $xdata);
    }

    public function cambiarEstado($petrId, $estado)
    {
        $data['_put_pedidoTrabajo_estado'] = array('estado' => $estado, 'petr_id'=>"$petrId");
        $url = REST_PRO."/pedidoTrabajo/estado";
        return wso2($url, 'PUT', $data);
	}

	// AGREGADO DE MERGE DE CHECHO
	public function obtenerInfoId($petrId)
	{
		$url = REST_PRO . "/info_id/$petrId";
		return wso2($url);
	}
    // FIN AGREGADO DE MERGE DE CHECHO

  
    /**
	*Genera lista pedido de trabajo paginados
	* @param integer;integer;string start donde comienza el listado; length cantidad de registros; search cadena a buscar
	* @return array listadopaginado y la cantidad
	**/
    public function pedidosTrabajoPaginados($start,$length,$search,$myData){
        log_message('DEBUG', '#TRAZA | #TRAZ-COMP-BPM | PedidoTrabajos | pedidosTrabajoPaginados($start,$length,$search,$myData)  | $start: ' .$start .'$length:'.$length.'$search:'.$search.'$myData:'.$myData);

        $emprId = empresa();
        $proccessname = $this->session->userdata('proccessname');
        $this->db->select('p.esfi_id');
        $this->db->from('pro.procesos p');
        $this->db->where('p.proc_id', $proccessname);
        $this->db->limit(1);
        
        $query = $this->db->get();
        
        if($query->num_rows() > 0){
            $estadoFinal = $query->result_object()[0]->esfi_id;
        }else{
            $estadoFinal = "estados_procesosFINALIZADO";
        }

        $url = REST_PRO . "/pedidoTrabajoNoFinalizado/$emprId/$estadoFinal/$search";

        $data =  wso2($url);
        if($data['status'])
        {
            $arrayDatos = $data['data'];
            $query_total = count($arrayDatos);
            if ($query_total > 0) {
                $query_total = $query_total;
            } else {
                return array('status', 'Error al traer los pedidos de trabajo');
            }
        }
        $filtro= "";
        // si es asc devuelvo los registros de manera asc en el dataTable
        if (strpos($myData["order"],"asc") !== false) {
            // evaluo la columna clickeada en el th del dataable
            switch ($myData["columna"]) {
                case 1:
                    $filtro = $myData["petr_id"];
                    break;
                case 2:
                    $filtro = $myData["cod_proyecto"];
                    break;
                case 3:
                    $filtro = $myData["nombre"];
                    break;
                case 4:
                    $filtro = $myData["dir_entrega"];
                    break;
                case 5:
                    $filtro = $myData["tipo_trabajo"];
                    break;
                case 6:
                    $filtro = $myData["fec_inicio"];
                    break;

                default:
                    $filtro = "";
                     break;
            }
            
            $resp = REST_PRO . "/pedidoTrabajoPaginadoAscV2/$emprId/$estadoFinal/$length/$start/$search/$filtro";
            $pedidosTrabajoPaginados = wso2($resp);

            if($pedidosTrabajoPaginados['status'])
             {
                 $result = array(
                     'numDataTotal' => $query_total,
                     'datos' => $pedidosTrabajoPaginados['data'],
                     "filtro" => $filtro,
                     "estadoFinal" => $estadoFinal,
                     "mydata" => $myData
                 );
             }
            
            else
            {
                return array('status', 'Error al traer los pedidos de trabajo');
            }
        } 
        // si es dec se devuelve los registros de manera desc en el dataTable
        else {
            
            $resp = REST_PRO . "/pedidoTrabajoPaginado/$emprId/$estadoFinal/$length/$start/$search";
            $pedidosTrabajoPaginados = wso2($resp);

            if($pedidosTrabajoPaginados['status'])
            {
                $result = array(
                    'numDataTotal' => $query_total,
                    'datos' => $pedidosTrabajoPaginados['data'],
                    "filtro" => $filtro,
                    "estadoFinal" => $estadoFinal,
                    "mydata" => $myData
                    
                );
            }
            else
            {
                return array('status', 'Error al traer los pedidos de trabajo');
            }
        }
        
       
        return $result;
    }

     /**
	*Genera lista pedido de trabajo paginados junto con los finalizados
	* @param integer;integer;string start donde comienza el listado; length cantidad de registros; search cadena a buscar
	* @return array listadopaginado y la cantidad
	**/
    public function pedidosTrabajoFinalizadosPaginados($start,$length,$search,$myData){
        log_message('DEBUG', '#TRAZA | #TRAZ-COMP-BPM | PedidoTrabajos | pedidosTrabajoFinalizadosPaginados($start,$length,$search,$myData)  | $start: ' .$start .'$length:'.$length.'$search:'.$search.'$myData:'.$myData);

        $emprId = empresa();

        $url = REST_PRO . "/pedidoTrabajo/$emprId/$search";

        $data =  wso2($url);
        if($data['status'])
        {
            $arrayDatos = $data['data'];
            $query_total = count($arrayDatos);
            if ($query_total > 0) {
                $query_total = $query_total;
            } else {
                return array('status', 'Error al traer los pedidos de trabajo');
            }
        }

        $filtro="";
        // si $order esquivale a ASC devuelvo los registros de manera Asc en datatable
        if (strpos($myData['order'],"asc") !== false) {
            switch ($myData["columna"]) {
                case 1:
                    $filtro = $myData["petr_id"];
                    break;
                case 2:
                    $filtro = $myData["cod_proyecto"];
                    break;
                case 3:
                    $filtro = $myData["nombre"];
                    break;
                case 4:
                    $filtro = $myData["dir_entrega"];
                    break;
                case 5:
                    $filtro = $myData["tipo_trabajo"];
                    break;
                case 6:
                    $filtro = $myData["fec_inicio"];
                    break;

                default:
                    $filtro = "nombre";
                     break;
            }
            // $resp = REST_PRO . "/pedidoTrabajoFinalizadosPaginadoAsc/$emprId/$length/$start/$search/$filtro";
            $resp = REST_PRO . "/pedidoTrabajoPaginadoAscV2/$emprId/$estadoFinal/$length/$start/$search/$filtro";
            //$resp = REST_PRO . "/pedidoTrabajoFinalizadosPaginado/$emprId/$length/$start/$search";
            $pedidosTrabajoPaginados = wso2($resp);
            if($pedidosTrabajoPaginados['status'])
            {
                $result = array(
                    'numDataTotal' => $query_total,
                    'datos' => $pedidosTrabajoPaginados['data'],
                    "filtro" => $filtro,
                    "estadoFinal" => $estadoFinal,
                    "mydata" => $myData
                );
            }
            else
            {
                return array('status', 'Error al traer los pedidos de trabajo');
            }
        } 
        // si $order equivale a desc devuelvo los registros de manera desc en DataTable
        else {
            $resp = REST_PRO . "/pedidoTrabajoFinalizadosPaginado/$emprId/$length/$start/$search";
            $pedidosTrabajoPaginados = wso2($resp);
            if($pedidosTrabajoPaginados['status'])
            {
                $result = array(
                    'numDataTotal' => $query_total,
                    'datos' => $pedidosTrabajoPaginados['data']
                );
            }
            else
            {
                return array('status', 'Error al traer los pedidos de trabajo');
            }
        }
        
       
        return $result;
    }

    /**
	*Trae datos de la tarea desde bonita
	* @param integer;integer; case_id ; proc_id
	* @return $data tarea
	**/
    public function traeDatosPedidoEntregadoBonita($case_id, $proc_id){
        log_message('DEBUG', '#TRAZA | #TRAZ-COMP-BPM | PedidoTrabajos | traeDatosPedidoEntregadoBonita($case_id, $proc_id)  | $case_id: ' .$case_id .'$proc_id:'.$proc_id);
       $data = $this->bpm->ObtenerActividadesArchivadas($proc_id, $case_id);
        return $data;
    }


}
