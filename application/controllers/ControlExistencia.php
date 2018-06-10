<?php
/**
 * Created by PhpStorm.
 * User: Lucas
 * Date: 06-05-2018
 * Time: 0:22
 */

class ControlExistencia extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->helper('url');
    }

    function index()
    {
        $this->layout->setLayout("plantilla");
        $this->layout->view('vista');
    }

    function login()
    {
        $this->layout->setLayout("plantilla_login");
        $this->layout->view('vista_login');
    }

    function logeo()
    {
        $mensaje = new stdClass();
        $this->load->helper('array_utf8');
        $this->load->model('control_existencia_model');
        $id_perfil = $this->control_existencia_model->comprobar_usuario($this->input->post('usuario'), $this->input->post('password'));
        $perfil = "perfil";
        if ($id_perfil != null) {
            $_SESSION[$perfil] = (int)$id_perfil[0]->ID_PERFIL;
        } else {
            $_SESSION[$perfil] = 0;
        }
        if ($_SESSION[$perfil] == 1 || $_SESSION[$perfil] == 2 || $_SESSION[$perfil] == 3) {
            $mensaje->respuesta = "S";
        } else {
            $mensaje->respuesta = "N";
            $mensaje->data = "Credenciales Incorrectas";
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($mensaje));
    }

    function graficos()
    {
        $mensaje = new stdClass();
        $this->load->helper('array_utf8');
        $this->load->model('control_existencia_model');
        $mensaje->grafico_stock = $this->control_existencia_model->obtener_grafico_stock();
        $mensaje->grafico_lineal = $this->control_existencia_model->obtener_grafico_stock_lineal();
        $movimientos = $this->control_existencia_model->obtener_ultimos_movimientos();
        for ($i = 0; $i < count($movimientos); $i++) {
            if ($movimientos[$i]->TIPO_MOVIMIENTO == '1') {
                $movimientos[$i]->TIPO_MOVIMIENTO = "<span class='glyphicon glyphicon-plus' style='color:#00CC00;'> INGRESO</span>";
            } else {
                $movimientos[$i]->TIPO_MOVIMIENTO = "<span class='glyphicon glyphicon-minus' style='color:red;' > SALIDA</span>";
            }
        }
        $mensaje->movimientos = $movimientos;
        $mensaje->respuesta = "S";
        $this->output->set_content_type('application/json')->set_output(json_encode($mensaje));
    }
}