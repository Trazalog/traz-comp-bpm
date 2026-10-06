<?php defined('BASEPATH') or exit('No direct script access allowed');

class Proceso extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
//agrego helper de session para validar usuarios logeados
        $this->load->helper('sesion_helper');
        //verifica si esta iniciado
        validarInactividad();
        $this->load->model('Procesos');
    }

    public function index()
    {  
        $data['device'] = "";
        $this->load->view('bandeja_entrada', $data);
    }

    public function paginarServerSide()
    {
        $draw = intval($this->input->post('draw'));
        $start = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));
        if ($length <= 0) {
            $length = 10;
        }

        // Trae de Bonita y mapea ÚNICAMENTE las tareas de esta página ($length)
        $rsp = $this->Procesos->listarPaginaServerSide($start, $length);
        $list = ($rsp['status'] && isset($rsp['data'])) ? $rsp['data'] : [];
        $recordsTotal = ($rsp['status'] && isset($rsp['total'])) ? $rsp['total'] : 0;

        $formattedData = [];
        foreach ($list as $f) {
            $id = $f->taskId;
            $asig = $f->idUsuarioAsignado;
            $nombreTarea = $f->nombreTarea;
            $depo_id = !empty($f->info[3]->depo_id) ? $f->info[3]->depo_id : '';

            if (filtrarbyDepo($nombreTarea, $depo_id)) {
                if ($asig != "") {
                    $asigIcon = '<i class="fa fa-user text-primary mr-2" title="' . formato_fecha_hora($f->fec_asignacion) . '"></i>';
                } else {
                    $asigIcon = '<i class="fa fa-user mr-2" style="color: #d6d9db;" title="No Asignado"></i>';
                }

                $tagCase = isset($f->tagCase) && $f->tagCase ? $f->tagCase : '';
                $html = "<h4>$asigIcon <proceso style='color:{$f->color}'>{$f->nombreProceso}</proceso>  |  {$f->nombreTarea} <small class='text-gray ml-2 {$tagCase}'><cite style='color: #707069'>case: {$f->caseId}</cite></small></h4><p>" . substr($f->descripcion, 0, 500) . '</p>';

                if (!empty($f->info) && is_array($f->info)) {
                    foreach ($f->info as $o) {
                        $estilo = !empty($o->estilo) ? $o->estilo : '';
                        $html .= "<p style='{$estilo}' class='label label-{$o->color} mr-2'>{$o->texto}</p>";
                    }
                }

                $formattedData[] = [
                    'DT_RowId' => $id,
                    'DT_RowClass' => 'item',
                    'DT_RowData' => [
                        'caseId' => $f->caseId,
                        'json' => json_encode($f)
                    ],
                    '0' => $html
                ];
            }
        }

        echo json_encode([
            'draw' => $draw,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsTotal,
            'data' => $formattedData
        ]);
    }

    public function detalleTarea($taskId)
    {
        //PERMISOS PANTALLA
        $data['permission'] = $this->session->userdata('user_data')['permission'];

        //TIPO DISPOSITIVO
        $data['device'] = "";

        //INFORMACION DE TAREA
        $tarea = $this->Procesos->obtener($taskId); 

        //INFORMACION DE TAREA
        $data['tarea'] = $tarea;
        $data['info'] = '';#$this->load->view(BPM.'tareas/componentes/informacion',$data['tarea'], true);

        //LINEA DE TIEMPO
        $data['timeline'] =$this->bpm->ObtenerLineaTiempo($tarea->processId, $tarea->caseId);

        //COMENTARIOS
        $data_aux = ['case_id' => $tarea->caseId, 'comentarios' => $this->bpm->ObtenerComentarios($tarea->caseId)];
        $data['comentarios'] = $this->load->view(BPM.'tareas/componentes/comentarios', $data_aux, true);

        $data['cabecera'] = $this->deplegarCabecera($tarea);

        //DESPLEGAR VISTA
        $data['view'] = $this->deplegarVista($tarea);
        $this->load->view(BPM.'notificacion_estandar', $data);
    }
    /**
	* Le asigna la tarea enviada al userId en bonita 
	* @param integer id de la tarea en bonita
	* @return array segun resultado 
	*/
    public function tomarTarea(){
        $id = $this->input->post('id');
        $rsp = $this->bpm->setUsuario($id, userId());
        $rsp['status'] ? $rsp['user_id'] = userId() : '';
        echo json_encode($rsp);
    }

    public function soltarTarea()
    {
        $id = $this->input->post('id');
        echo json_encode($this->bpm->setUsuario($id, ""));
    }
    /**
				* Cierra la tarea enviada desde bonita, mapeando con el modelo correspondiente al proceso
				* @param integer id de la tarea en bonita
				* @return array segun resultado de la operacion
				*/
    public function cerrarTarea($taskId){
        log_message('DEBUG', "#TRAZA | #TRAZ-COMP-BPM | Proceso | cerrarTarea() task_id >> $taskId");
        //Obtener Informacion de Tarea
        $tarea = $this->Procesos->mapeoTarea($this->bpm->getTarea($taskId)['data']);
        //Formulario desde la Vista
        $form = $this->input->post();
        //Mapeo de Contrato
        $contrato = $this->getContrato($tarea, $form);
        //Cerrar Tarea
        $rsp = $this->bpm->cerrarTarea($taskId, $contrato);
        //Respuesta
        echo json_encode($rsp);
    }
    /**
				* Obtiene el contrato definido por nombre de tarea en el modelo correspondiente al proceso
				* @param array datos de la tarea; @param array datos del formulario de cierre de tarea
				* @return array datos del contrato para la tarea en cuestion
				*/
    public function getContrato($tarea, $form){
        log_message('DEBUG', "#TRAZA | #TRAZ-COMP-BPM | Proceso | getContrato()");
        $process = $this->Procesos->mapProcess($tarea->processId);
        $this->load->model($process['proyecto'].$process['model']);
        return $this->{$process['model']}->getContrato($tarea, $form);
    }

    public function deplegarVista($tarea)
    {
        $process = $this->Procesos->mapProcess($tarea->processId);

        $this->load->model($process['proyecto'].$process['model']);

        return $this->{$process['model']}->desplegarVista($tarea);
    }

    public function deplegarCabecera($tarea)
    {
        $process = $this->Procesos->mapProcess($tarea->processId);

        $this->load->model($process['proyecto'].$process['model']);

        return $this->{$process['model']}->desplegarCabecera($tarea);
    }

    public function guardarComentario()
    {
        $data = $this->input->post();
        echo $this->bpm->guardarComentario($data);
    }


				public function VistaCliente()
    {
		

								return $this->load->view(BPM . 'cliente/vista_cliente');
    }
   

}
