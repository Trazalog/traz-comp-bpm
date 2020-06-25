<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Tests extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getTodoList()
    {
        $resource = 'API/bpm/humanTask?p=0&c=1000&f=user_id%3D';

        $url = 'http://10.142.0.3:8080/bonita/' . $resource . "8";

        $rsp = $this->rest->callAPI('GET', $url, false, $this->bpm->loggin('suptest1', '123'));

        if (!$rsp['status']) {

            log_message('DEBUG', '#TRAZA | #BPM >> ' . ASP_111);

            return $this->bpm->msj(false, ASP_111);

        }

        return $this->bpm->msj(true, 'OK', json_decode($rsp['data'], true));
    }


}