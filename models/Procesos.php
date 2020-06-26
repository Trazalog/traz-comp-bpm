<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Procesos extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function mapeo($data)
    {
        $array = [];

        foreach ($data as $o) {
            
            $process = $this->mapProcess($o['processId']);
            
            $aux = new StdClass();
            $aux->taskId = $o['id'];
            $aux->caseId = $o['caseId'];
            $aux->processId = $o['processId'];
            $aux->nombreTarea = $o['name'];
            $aux->nombreProceso =  $process?$process['nombre']:'';
            $aux->color =  $process?$process['color']:'';						
            $aux->descripcion = '-';
            $aux->fec_vencimiento = $o['dueDate'];
            $aux->usuarioAsignado = 'Nombre Apellido';
            $aux->idUsuarioAsignado = $o['assigned_id'];
            $aux->fec_asignacion = $o['assigned_date'];
            $aux->prioridad = $o['priority'];					
	
            $array[] = $aux;
        }
        
        return $array;
        
    }

    public function map($data)
    {
        foreach ($data as $key => $o) {

            $process = $this->mapProcess($o->processId);
            if($process){
                $model = $process['model'];
                $this->load->model($model);
                $res = $this->{$model}->map($o);
                $data[$key]->info = isset($res['info'])?$res['info']:[];
                $data[$key]->descripcion = isset($res['descripcion'])?$res['descripcion']:'Sin Descripción';
            }
        }

        return $data;
    }

    public function listar()
    {
        $rsp =  $this->bpm->getToDoList();

        if(!$rsp['status']) return $rsp;

        $rsp['data'] = $this->map($this->mapeo($rsp['data']));

        return $rsp;
    }

    public function obtener($id)
    {
        return $this->mapeo(array($this->bpm->getTarea($id)['data']))[0];
    }

    public function editar($id, $data)
    {
        # code...
    }

    public function eliminar($id)
    {
        # code...
    }

    public function mapProcess($processId)
    {
        $aux = json_decode(BPM_PROCESS,'true');
       
        return isset($aux[$processId])?$aux[$processId]:'GEN_Tareas';
    }
}