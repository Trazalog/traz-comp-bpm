<?php defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('userId')) {

    function userId()
    {
        return 101; //!HARDCODE

        $ci = &get_instance();
        $userdata = $ci->session->userdata('user_data');
        return $userdata[0]['userBpm'];
    }
}

if (!function_exists('userNick')) {

    function userNick()
    {   
        return 'almacen.tools'; //!HARDCODE
        $ci = &get_instance();
        return $ci->session->userdata('email');
    }
}

if (!function_exists('userPass')) {

    function userPass()
    {
        return 'bpm';
    }
}

if (!function_exists('empresa')) {

    function empresa()
    {
        return 1; //!HARDCODE
        $ci = &get_instance();
        $userdata = $ci->session->userdata('user_data');
        return empresa();
    }
}

if (!function_exists('validarSesion')) {

    function validarSesion()
    {
        $ci = &get_instance();
        $userdata = $ci->session->userdata('user_data');
        if (empty($userdata)) {
            redirect(base_url() . 'Login');
        }

    }

}
