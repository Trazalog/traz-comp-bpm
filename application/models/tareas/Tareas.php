<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Tareas extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function setIntanciasTareas($ids)
    {
        $subtareas = $this->getSubtareas($ids);
        
    }

    public function getTareasPlantilla($id)
    {
        $this->db->where('plan_id', $id);
        $this->db->from('tst_rel_tareas_plantillas T');
        $this->db->join('tst_tareas A','A.tare_id = T.tare_id');
        return $this->db->get()->result_array();
    }

    public function getPlantillas()
    {   
        $this->db->where('eliminado',0);
        return $this->db->get('tst_plantillas')->result_array();
    }
    public function getSubtareas($ids)
    {   
        $this->db->where('eliminado',0);
        $this->db->where_in('tare_id',$ids);
        return $this->db->get('tst_subtareas')->result_array();
    }

    public function listar()
    {
        $this->db->where('eliminado',0);
        return $this->db->get('tst_tareas')->result_array();
    }

    public function obtener($id)
    {
      
    }

    public function editar($id, $data)
    {
        # code...
    }

    public function eliminar($id)
    {
        # code...
    }
}
