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
				$empr_id = empresa();

        foreach ($data as $o) {

						$process = $this->mapProcess($o['processId']);

					if(bandejaEmpresa($o['caseId'], $empr_id)){

							$aux = new StdClass();
							$aux->taskId = $o['id'];
							$aux->caseId = $o['caseId'];
							$aux->processId = $o['processId'];
							$aux->nombreTarea = $o['displayName'];
							$aux->nombreProceso =  $process?$process['nombre']:'';
							$aux->color =  $o['state'] == 'failed'?'#d33724': ($process?$process['color']:'');
							$aux->descripcion = '-';
							$aux->fec_vencimiento = $o['dueDate'];
							$aux->usuarioAsignado = 'Nombre Apellido';
							$aux->idUsuarioAsignado = $o['assigned_id'];
							$aux->fec_asignacion = $o['assigned_date'];
							$aux->prioridad = $o['priority'];
		
							$array[] = $aux;
					}
        }
        
        return $array;
        
    }
    /**
	* Funcion para obtener desde el modelo especificado en el constants la configuracion en bandeja de entrada
	* @param array informacion de tareas enviados por bonita 
	* @return array con informacion parseada para armar las notificaiones en bandeja de entrada
	*/
    public function map($data)
    {
        foreach ($data as $key => $o) {

            $process = $this->mapProcess($o->processId);
            if($process){
                if($process['proyecto'] != TST){
                    $model = $process['model'];
                    $this->load->model($process['proyecto'].$model);
                    $res = $this->{$model}->map($o);
                    $data[$key]->info = isset($res['info'])?$res['info']:[];
                    $data[$key]->descripcion = isset($res['descripcion'])?$res['descripcion']:'Sin Descripción';
                    $data[$key]->tagCase = isset($res['tagCase']) ? $res['tagCase'] : '';
                }else{
                    $model = $process['model'];
                    $this->load->model($process['proyecto'].$model);
                    $res = $this->{$model}->map($o);
                    $data[$key]->info = isset($res['info'])?$res['info']:[];
                    $data[$key]->descripcion = isset($res['descripcion'])?$res['descripcion']:'Sin Descripción';
                    $data[$key]->nombreTarea = isset($res['nombreTarea'])?$res['nombreTarea']:'';
                    $data[$key]->nombreProceso = isset($res['nombreProceso'])?$res['nombreProceso']:'';
                    $data[$key]->tagCase = isset($res['tagCase']) ? $res['tagCase'] : '';
                }
            }
        }

        return $data;
		}
		
		function mapeoTarea($data){
							
			$aux = new StdClass();

			$aux->taskId = $data['id'];
			$aux->caseId = $data['caseId'];
			$aux->processId = $data['processId'];
			$aux->nombreTarea = $data['name'];
			$aux->nombreProceso =  json_decode(BPM_PROCESS,true)[$data['processId']]['nombre'];
			$aux->color =  json_decode(BPM_PROCESS,true)[$data['processId']]['color'];
			$aux->descripcion = 'Esto es una Descripcion de la Tarea...<p>Esto es un texto de la solcitud de servicio que puede ser muy larga</p><span class="label label-danger">Urgente</span> <span class="label label-primary">#PonganseLasPilas</span>';
			$aux->fec_vencimiento = 'dd/mm/aaaa';
			$aux->usuarioAsignado = 'Nombre Apellido';
			$aux->idUsuarioAsignado = $data['assigned_id'];
			$aux->fec_asignacion = $data['assigned_date'];
			$aux->prioridad = $data['priority'];

			return $aux;
	}

    public function listar()
    {
        $rsp =  $this->bpm->getToDoList();

        if(!$rsp['status']) return $rsp;
        if(empresa() != ''){
            $rsp['data'] = $this->map($this->mapeo($rsp['data']));

        }

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
       
        return isset($aux[$processId])?$aux[$processId]:array('proyecto'=>'', 'model'=>'Gentareas');
    }
}