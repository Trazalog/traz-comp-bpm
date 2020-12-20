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

        // $this->procesos();

        $this->load->view('pedido_trabajo', $data);
    }

    public function guardarPedidoTrabajo()
    {

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
            'proc_id' => 'YUDI-NEUMATICOS', // cambiar 'YUDI-NEUMATICOS' por proc_id
            'empr_id' => $empr_id,
            'clie_id' => $this->input->post('clie_id'),

        );

        $rsp = $this->Pedidotrabajos->guardarPedidoTrabajo($data);
        $petr_id = json_decode($rsp['data'])->respuesta->petr_id;

        if ($rsp) {

            echo json_encode($rsp);

            if ($lanzar_bpm == "true") {
                $this->BonitaProccess($petr_id);
            } else {
                log_message('DEBUG', '#TRAZA | #BPM >> BonitaProccess  >> lanzar_bpm viene false');
            }

        } elseif (!$rsp) {

            log_message('ERROR', '#TRAZA | #BPM >> guardarPedidoTrabajo  >> ERROR');

            $this->eliminarPedidoTrabajo($petr_id);

        } else {

            log_message('DEBUG', '#TRAZA | #BPM >> guardarPedidoTrabajo  >> ERROR TREMENDO');

        }

    }

    public function BonitaProccess($petr_id)
    {
        $nombre_bpm = $this->Pedidotrabajos->procesos()->proceso->nombre_bpm;

        $data = array(
            'nombre_proceso' => $nombre_bpm,
            "payload" => array('p_petrId' => $petr_id),
            'session' => 'X-Bonita-API-Token=14485fa7-6b5e-4972-9aa4-4571668c9321;JSESSIONID=AC637E6D080C7E5CF3EEF8407D5ACEE6;bonita.tenant=1;',
        );

        $rsp = $this->Pedidotrabajos->guardarBonitaProccess($data);
        $case_id = json_decode($rsp['data'])->payload->caseId;

        if (!$rsp) {

            log_message('ERROR', '#TRAZA | #BPM >> BonitaProccess  >> ERROR AL GUARDAR');

            // $this->eliminarPedidoTrabajo($petr_id);

        } else {
            log_message('DEBUG', '#TRAZA | #BPM >> BonitaProccess  >> TODO OK');
           #echo json_encode($data);
            $this->ActualizarCaseId($case_id, $petr_id);

        }

    }

    public function ActualizarCaseId($case_id, $petr_id)
    {

        $data['_put_pedidotrabajo'] = array(

            "case_id" => "$case_id",
            "petr_id" => $petr_id,

        );

        $rsp = $this->Pedidotrabajos->ActualizarCaseId($data);

        if (!$rsp) {

            log_message('ERROR', '#TRAZA | #BPM >> ActualizarCaseId  >> ERROR AL ACTUALIZAR');

            // $this->eliminarPedidoTrabajo($petr_id);

        } else {
            log_message('DEBUG', '#TRAZA | #BPM >> ActualizarCaseId  >> TODO OK');
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

    public function dash()
    {
      $this->load->view('pedidos_trabajo/dash', $data);
    }

    public function pedidosTrabajos($emprId)
    {

        $data['ots'] = $this->Pedidotrabajos->obtener($emprId)['data'];
        $this->load->view('pedidos_trabajo/lista_pedidos', $data);
    }

    public function hitos($petrId)
    {
        $post = $this->input->post();
        if($post)
        {
            $rsp = $this->Pedidotrabajos->guardarHito($petrId, $post);
            echo json_encode($rsp);
        }else{
            $data['hitos'] = $this->Pedidotrabajos->obtenerHitosXPedido($petrId)['data'];
            $data['info_id']="0".$this->Pedidotrabajos->obtenerInfoId($petrId)['data'];
            $data['petr_id'] = "0".$petrId;
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
