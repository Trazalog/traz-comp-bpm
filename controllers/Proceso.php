<?php defined('BASEPATH') or exit('No direct script access allowed');

class Proceso extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Procesos');
    }

    public function index()
    {
        $data['device'] = "";
        $rsp =  $this->Procesos->listar();
        if($rsp['status']){

            $data['list'] = $rsp['data'];
        }
        $this->load->view('bandeja_entrada', $data);
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
        $data['info'] = '';#$this->load->view(BPM.'tareas/componentes/informacion',null,true);

        //LINEA DE TIEMPO
        $data['timeline'] =$this->bpm->ObtenerLineaTiempo($tarea->processId, $tarea->caseId);

        //COMENTARIOS
        $data_aux = ['case_id' => $tarea->caseId, 'comentarios' => $this->bpm->ObtenerComentarios($tarea->caseId)];
        $data['comentarios'] = '';#$this->load->view('componentes/comentarios', $data_aux, true);

        //DESPLEGAR VISTA
        $data['view'] = $this->deplegarVista($tarea);
        $this->load->view(BPM.'notificacion_estandar', $data);
    }

    public function tomarTarea()
    {
        $id = $this->input->post('id');
        echo json_encode($this->bpm->setUsuario($id, $this->session->userdata('user_data')['userId']));
    }

    public function soltarTarea()
    {
        $id = $this->input->post('id');
        echo json_encode($this->bpm->setUsuario($id, ""));
    }

    public function cerrarTarea($taskId)
    {
        //Obtener Infomracion de Tarea
        $tarea = $this->bpm->getTarea($taskId)['data'];

        //Formulario desde la Vista
        $form = $this->input->post();

        //Mapeo de Contrato
        $contrato = $this->getContrato($tarea, $form);

        //Cerrar Tarea
        $this->bpm->cerrarTarea($taskId, $contrato);
    }

    public function getContrato($tarea, $form)
    {
        $model = $this->Procesos->mapProcessModel($tarea->processId);

        $this->load->model("$model/Tareas");

        return $this->Tareas->getContrato($tarea);
    }

    public function deplegarVista($tarea)
    {
        $process = $this->Procesos->mapProcess($tarea->processId);

        $this->load->model($process['proyecto'].$process['model']);

        return $this->{$process['model']}->desplegarVista($tarea);
    }

    public function guardarComentario()
    {
        echo $this->bpm->guardarComentario($this->input->post());
    }
}
