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
        $resource = '/tablas/unidad_medida_tiempo';
        $url = REST_CORE . $resource;
        return wso2($url);
    }

    public function getClientes()
    {
        $resource = '/clientes/porEmpresa/1/porEstado/ACTIVO';
        $url = REST_CORE . $resource;
        return wso2($url);
    }

// Guardar guardar Pedido de Trabajo
    public function guardarPedidoTrabajo($data)
    {
        $url = REST_PRO . '/pedidoTrabajo';
        $rsp = $this->rest->callApi('POST', $url, $data);
        return $rsp;
    }

    public function eliminarPedidoTrabajo($data)
    {
        //   DELETE http://10.142.0.7:8280/services/PRODataService/pedidoTrabajo
        $url = REST_PRO . "/pedidoTrabajo";
        return wso2($url, 'DELETE', $data);
    }

// Guardar guardar BonitaProccess
    public function guardarBonitaProccess($contract)
    {
        //REST_PRD  http://10.142.0.7:8280/tools/bpm/proceso/instancia
        //define('REST_BPM', 'http://10.142.0.7:8280/tools/bpm');

        // $url = REST_BPM . '/proceso/instancia';
        // $rsp = $this->rest->callApi('POST', $url, $data);
        // return $rsp;

        $rsp =  $this->bpm->lanzarProceso(BPM_PROCESS_ID_REPARACION_NEUMATICOS, $contract);
        return $rsp;
    }

/// GET

    // lanzar proceso
    public function procesos()
    {
        $proccessname = "YUDI-NEUMATICOS";
// http://10.142.0.7:8280/services/PRODataService/proceso/nombre/YUDI-NEUMATICOS/empresa/1
        $resource = "/proceso/nombre/$proccessname/empresa/" . empresa();
        $url = REST_PRO . $resource;
        //  return wso2($url);
        $array = $this->rest->callApi('GET', $url);
        return json_decode($array['data']);
    }

    public function ActualizarCaseId($data)
    {
        $url = REST_PRO . "/pedidoTrabajo";
        $rsp = $this->rest->callApi('PUT', $url, $data);
        return $rsp;

    }

    public function obtener($emprId)
    {
        $url = REST_PRO . "/pedidoTrabajo/$emprId";
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
