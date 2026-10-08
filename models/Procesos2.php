<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require_once __DIR__ . '/Procesos.php';

/**
 * Bandeja de entrada 2: misma bandeja que Procesos, pero paginando y buscando en la base (BandejaDataService)
 * en vez de traer y enriquecer todas las tareas de Bonita. Convive con Procesos para poder comparar las dos
 * (controller Proceso2 / vista bandeja_entrada2). El resto (map(), mapProcess(), obtener()...) se hereda sin cambios.
 * Ver doc/v3/bandeja-paginado-real.md en traz-tools.
 */
class Procesos2 extends Procesos
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
	* Pagina la bandeja de entrada de la empresa activa.
    * Las tareas del usuario, el filtro por empresa (core.case_empresa), la búsqueda, el orden y los totales salen de
    * una sola query (BandejaDataService); solo se enriquecen con map() las tareas de la página.
    * La búsqueda es la misma de siempre: "contiene" sin distinguir mayúsculas sobre nombre de tarea, proceso, case,
    * descripción, tagCase y etiquetas de la tarea. El DataService arma ese mismo texto en SQL a partir de las
    * mismas tablas que leen los map() de cada proceso.
	* @param integer $start offset; @param integer $length tamaño de página; @param string $search texto a buscar
	* @return array status, total, filtered y data (tareas enriquecidas de la página)
	*/
    public function listarPaginaServerSide($start = 0, $length = 10, $search = ''){
        $empr_id = empresa();
        if ($empr_id == '') {
            return ['status' => true, 'total' => 0, 'filtered' => 0, 'data' => []];
        }

        $user_id = userId();
        $buscar = empty($search) ? '' : strtolower(trim($search));

        if (!empty($search) && $buscar === '') {
            // Búsqueda de solo espacios: como antes, no coincide nada
            $rsp = $this->obtenerTareasBandeja($user_id, $empr_id, 0, 1);
            if (!$rsp['status']) return $rsp;
            return ['status' => true, 'total' => $rsp['total'], 'filtered' => 0, 'data' => []];
        }

        $rsp = $this->obtenerTareasBandeja($user_id, $empr_id, $start, $length, $buscar);
        if (!$rsp['status']) return $rsp;

        $total = $rsp['total'];
        $filtered = $rsp['filtered'];
        if (empty($rsp['data'])) {
            // Sin filas (sin coincidencias o página fuera de rango): los totales salen de otra consulta
            $rspTotal = $this->obtenerTareasBandeja($user_id, $empr_id, 0, 1);
            $total = $rspTotal['status'] ? $rspTotal['total'] : 0;
            if ($buscar === '') {
                $filtered = $total;
            } elseif ($start > 0) {
                $rspFiltro = $this->obtenerTareasBandeja($user_id, $empr_id, 0, 1, $buscar);
                $filtered = $rspFiltro['status'] ? $rspFiltro['filtered'] : 0;
            }
        }

        return [
            'status' => true,
            'total' => $total,
            'filtered' => $filtered,
            'data' => $this->map($rsp['data'])
        ];
    }

    /**
	* Trae una página de la bandeja de entrada desde BandejaDataService (tareas pendientes del usuario en Bonita
    * filtradas por empresa y por búsqueda, ordenadas por fecha de llegada desc)
	* @param integer $user_id id de usuario en Bonita; @param string $empr_id empresa;
    * @param integer $offset; @param integer $limit (0 = todas); @param string $buscar texto en minúsculas ('' = sin filtro)
	* @return array status, total (bandeja de la empresa), filtered (coincidencias) y data (tareas sin enriquecer)
	*/
    protected function obtenerTareasBandeja($user_id, $empr_id, $offset, $limit, $buscar = ''){
        $procesos = [];
        foreach (json_decode(BPM_PROCESS, true) as $processId => $proceso) {
            $procesos[$processId] = [
                'nombre' => $proceso['nombre'],
                'model' => $proceso['model'],
                'tst' => $proceso['proyecto'] == TST
            ];
        }

        $url = REST_BANDEJA . '/bandeja/tareas/usuario/' . intval($user_id) . '/empresa/' . intval($empr_id)
            . '/offset/' . intval($offset) . '/limit/' . intval($limit)
            . '?buscar=' . rawurlencode($buscar) . '&procesos=' . rawurlencode(json_encode($procesos));

        $rsp = wso2($url);
        if (!$rsp['status']) {
            log_message('ERROR', "#TRAZA | #TRAZ-COMP-BPM | Procesos | obtenerTareasBandeja() ERROR >> $url");
            return ['status' => false, 'msj' => ASP_111, 'data' => []];
        }

        $items = is_array($rsp['data']) ? json_decode(json_encode($rsp['data']), true) : [];

        $tareas = [];
        foreach ($items as $o) {
            $tareas[] = $this->armarTarea($o);
        }

        return [
            'status' => true,
            'total' => !empty($items) ? intval($items[0]['total']) : 0,
            'filtered' => !empty($items) ? intval($items[0]['filtered']) : 0,
            'data' => $tareas
        ];
    }

    /**
	* Arma el objeto tarea de bandeja a partir de una tarea con el formato de API/bpm/humanTask
	* @param array tarea de bonita (id, caseId, processId, displayName, state, dueDate, assigned_id, assigned_date, priority)
	* @return object tarea para bandeja de entrada (sin enriquecer)
	*/
    protected function armarTarea($o){
        $process = $this->mapProcess($o['processId']);

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

        return $aux;
    }
}
