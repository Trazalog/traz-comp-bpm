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
            ["linkTo('" . BPM . "Proceso/')", "linkTo('" . BPM . "Proceso')"],
            ["linkTo('" . BPM . "Proceso2/')", "linkTo('" . BPM . "Proceso2')"],
            $salida
        );
        $this->output->set_output($salida);
    }
}
