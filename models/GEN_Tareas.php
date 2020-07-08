<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class GEN_Tareas extends CI_Model
{
    public function __construct()
    {
        parent::__construct();

    }

    public function map($tarea)
    {
        $data['descripcion'] = 'Holis como estas?';
        return $data;
    }

    public function desplegarVista($tarea)
    {
        switch ($tarea->nombreTarea) {
            default:
                # code...
                break;
        }
    }

    public function getContrato($tarea, $form)
    {
        switch ($tarea->nombreTarea) {
            default:
                # code...
                break;
        }
    }


}
