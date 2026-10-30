<?php defined('BASEPATH') or exit('No direct script access allowed');

require_once __DIR__ . '/Proceso.php';

/**
 * Bandeja de entrada 2 (traz-comp-bpm/Proceso2): misma pantalla que Proceso, pero el paginado y la búsqueda
 * se resuelven en la base (modelo Procesos2 / BandejaDataService). Convive con Proceso para poder comparar
 * las dos bandejas. Tomar, soltar, cerrar y comentar tareas se heredan de Proceso sin cambios.
 * Ver doc/v3/bandeja-paginado-real.md en traz-tools.
 */
class Proceso2 extends Proceso
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Procesos2');
    }

    public function index()
    {
        $data['device'] = "";
        $this->load->view('bandeja_entrada2', $data);
    }

    public function paginarServerSide()
    {
        // Mismo armado de filas que Proceso::paginarServerSide(), con los datos de Procesos2
        $procesos = $this->Procesos;
        $this->Procesos = $this->Procesos2;
        parent::paginarServerSide();
        $this->Procesos = $procesos;
    }

    public function detalleTarea($taskId)
    {
        parent::detalleTarea($taskId);

        // Al cerrar la tarea, la vista compartida vuelve a la bandeja vieja: que vuelva a esta
        $salida = $this->output->get_output();
        $salida = str_replace(
            [
                "linkTo('" . BPM . "Proceso/')",
                "linkTo('" . BPM . "Proceso')",
                "linkTo('" . base_url(BPM) . "Proceso/')",
                "linkTo('" . base_url(BPM) . "Proceso')"
            ],
            [
                "linkTo('" . BPM . "Proceso2/')",
                "linkTo('" . BPM . "Proceso2')",
                "linkTo('" . BPM . "Proceso2/')",
                "linkTo('" . BPM . "Proceso2')"
            ],
            $salida
        );
        $this->output->set_output($salida);
    }

    public function detalleTareaV2($taskId)
    {
        $inicioTotal = microtime(true);
        $data['permission'] = $this->session->userdata('user_data')['permission'];
        $data['device'] = "";

        $tarea = $this->Procesos->obtenerV2($taskId);

        if (!$tarea) {
            show_404();
            return;
        }

        $data['tarea'] = $tarea;
        $data['info'] = '';
        $data['timeline'] = null;
        $data['comentarios'] = '';
        $data['cabecera'] = $this->deplegarCabeceraV2($tarea);
        $data['view'] = $this->deplegarVistaV2($tarea);

        log_message('DEBUG', '#TRAZA | #PROCESO2 | detalleTareaV2 | task ' . $taskId . ' >> ' . round((microtime(true) - $inicioTotal) * 1000, 2) . ' ms');

        $this->load->view(BPM.'notificacion_estandar', $data);

        $salida = $this->output->get_output();
        $salida = str_replace(
            [
                "linkTo('" . BPM . "Proceso/')",
                "linkTo('" . BPM . "Proceso')",
                "linkTo('" . base_url(BPM) . "Proceso/')",
                "linkTo('" . base_url(BPM) . "Proceso')"
            ],
            [
                "linkTo('" . BPM . "Proceso2/')",
                "linkTo('" . BPM . "Proceso2')",
                "linkTo('" . BPM . "Proceso2/')",
                "linkTo('" . BPM . "Proceso2')"
            ],
            $salida
        );
        $this->output->set_output($salida);
    }

    public function deplegarCabeceraV2($tarea)
    {
        $this->load->helper('infoproceso_v2');

        return infoproceso_v2($tarea);
    }

    public function deplegarVistaV2($tarea)
    {
        $process = $this->Procesos->mapProcessV2($tarea->processId);

        $this->load->model($process['proyecto'].$process['model']);

        return $this->{$process['model']}->desplegarVista($tarea);
    }
}
