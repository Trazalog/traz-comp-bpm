<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class ALM_Tareas extends CI_Model
{
    public function __construct()
    {
        parent::__construct();

    }

    public function map($tarea)
    {
        $array = array();
        $rsp = $this->getInfoPedMateriales($tarea->caseId);

        if(!$rsp['data']){
            return $array;
        }

        $infoPema = $rsp['data'];
        
        if(isset($infoPema->pema_id)){
            
            $aux = new StdClass();
            $aux->color = 'warning';
            $aux->texto = "N° Pedido: $infoPema->pema_id";
            $array['info'][] = $aux;

            $aux = new StdClass();
            $aux->color = 'warning';
            $aux->texto = "Lote: $infoPema->lote_id";
            $array['info'][] =$aux;

            $aux = new StdClass();
            $aux->color = 'warning';
            $aux->texto = "Estado: $infoPema->estado";
            $array['info'][] = $aux;

            $aux = new StdClass();
            $aux->color = 'default';
            $aux->texto = "Fecha: ".formatFechaPG($infoPema->fecha);
            $array['info'][] = $aux;

            $array['descripcion'] = $infoPema->justificacion?$infoPema->justificacion:'Pedido Materiales sin Justificación';
        }


        return $array;
    }

    public function desplegarVista($tarea)
    {
        switch ($tarea->nombreTarea) {

            default:

                return $this->load->view('view_proceso/test', ['tarea' => $tarea], true);

                break;

        }
    }

    public function getContrato($tarea, $form)
    {
        switch ($tarea->nombreTarea) {
            case 'Aprueba pedido de Recursos Materiales':

                $this->Notapedidos->setMotivoRechazo($form['pema_id'], $form['motivo_rechazo']);

                $contrato['apruebaPedido'] = $form['result'];

                return $contrato;

                break;

            case 'Entrega pedido pendiente':

                $contrato['entregaCompleta'] = $form['completa'];

                return $contrato;

                break;

            // ?PEDIDO MATERIALES EXTRAORDINARIOS

            case 'Aprueba pedido de Recursos Materiales Extraordinarios':

                $this->Pedidoextra->setMotivoRechazo($form['peex_id'], $form['motivo_rechazo']);

                $contrato['apruebaPedido'] = $form['result'];

                return $contrato;

                break;

            case 'Comunica Rechazo':

                $contrato['motivo'] = $form['motivo'];

                return $contrato;

                break;

            case 'Solicita Compra de Recursos Materiales Extraordiinarios':

                $this->Pedidoextra->setMotivoRechazo($form['peex_id'], $form['motivo_rechazo']);

                $contrato['apruebaCompras'] = $form['result'];

                return $contrato;

                break;

            case 'Comunica Rechazo por Compras':

                $contrato['motivo'] = $form['motivo'];

                return $contrato;

                break;

            case 'Generar Pedido de Materiales':

                $this->Pedidoextra->setPemaId($form['peex_id'], $form['pema_id']);

                $this->Notapedidos->setCaseId($form['pema_id'], $tarea['rootCaseId']);

                return;

                break;

            default:
                # code...
                break;
        }
    }

    public function getInfoPedMateriales($caseId)
    {
        $resource = 'pedidoMateriales';

        $url = REST . $resource . '/' . $caseId;

        $rsp = $this->rest->callAPI('GET', $url);

        if ($rsp['status']) {

            $rsp['data'] = json_decode($rsp['data'])->info;
           
        }

        return $rsp;
    }
}
