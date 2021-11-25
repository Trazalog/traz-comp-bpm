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
        $rsp =  $this->bpm->lanzarProceso(BPM_PROCESS_ID_REPARACION_NEUMATICOS, $contract);
        return $rsp;
    }

    /**
		*Busca el proceso asociado a $processname en la tabla pro.procesos
		* @param array $processname
		* @return data del proceso asociado
    **/
    public function procesos($proccessname)
    {
        $resource = ($proccessname == PRO_STD) ? "/proceso/nombre/$proccessname/empresa/" : "/proceso/nombre/$proccessname/empresa/" . empresa();

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
    public function obtener($emprId)
    {
        $url = REST_PRO . "/pedidoTrabajo/$emprId";
        log_message('DEBUG', '#Model BPM PedidoTrabajo *Obtiene lista pedido de trabajo por emprId >  | $empresa_id: ' .$emprId);
        log_message('DEBUG', '#Model BPM PedidoTrabajo *Obtiene lista pedido de trabajo por emprId   | Lista Pedidos: ' .json_encode(wso2($url)));
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
        return payToStr($data);
    }

    public function guardarHito($petrId, $data)
    {
        $data['petr_id'] = $petrId;
        $xdata['_post_hitos'] = $this->mapHito($data);
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

}
