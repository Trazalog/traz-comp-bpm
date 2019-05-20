<?php defined('BASEPATH') or exit('No direct script access allowed');

class Tarea extends CI_Controller
{
    public function __construct()
    {

        parent::__construct();
        $this->load->model('tareas/Tareas');
    }

    public function index()
    {
        $data['tareas'] = $this->Tareas->listar();
        $data['plantillas'] = $this->Tareas->getPlantillas();
        $this->load->view('tareas/view', $data);

    }

    public function getSubtareas()
    {
       echo json_encode($this->Tareas->getSubtareas($this->input->post('ids')));
    }

    public function getTareasPlantilla()
    {
        echo json_encode($this->Tareas->getTareasPlantilla($this->input->post('id')));
    }

    public function setInstanciasTareas()
    {
        $ids= $this->input->post('ids');
        echo $this->Tareas->setIntanciasTareas($ids);
    }
}