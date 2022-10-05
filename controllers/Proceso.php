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

    public function tomarTarea()
    {
        $id = $this->input->post('id');
        echo json_encode($this->bpm->setUsuario($id, userId()));
    }

    public function soltarTarea()
    {
        $id = $this->input->post('id');
        echo json_encode($this->bpm->setUsuario($id, ""));
    }

    public function cerrarTarea($taskId)
    {
        //Obtener Infomracion de Tarea
        $tarea = $this->Procesos->mapeoTarea($this->bpm->getTarea($taskId)['data']);

        //Formulario desde la Vista
        $form = $this->input->post();

        //Mapeo de Contrato
        $contrato = $this->getContrato($tarea, $form);

        //Cerrar Tarea
				$rsp = $this->bpm->cerrarTarea($taskId, $contrato);
				echo json_encode($rsp);
    }

    public function getContrato($tarea, $form)
    {
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
