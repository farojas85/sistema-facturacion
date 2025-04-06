<?php
require_once "../vendor/autoload.php";

use Controladores\ControladorAgencias;

class AjaxAgencias
{
    // EDITAR CATEGORIA

    public $idAgencia;
    public function ajaxEditarAgencia()
    {

        $item = 'id';
        $valor = $this->idAgencia;

        $respuesta = ControladorAgencias::ctrMostrarAgencias($item, $valor);

        echo json_encode($respuesta);
    }

    public $idEliminar;
    public function ajaxEliminarAgencia()
    {

        $datos = $this->idEliminar;

        $respuesta = ControladorAgencias::ctrEliminarAgencia($datos);
    }
    // VALIDAR NO REPETIR CATEGORÍA
    public $validarAgencia;

    public function ajaxValidarAgencia()
    {

        $item = 'nombre';
        $valor = $this->validarAgencia;
        $respuesta = ControladorAgencias::ctrMostrarAgencias($item, $valor);

        echo json_encode($respuesta);
    }
}

// OBJETO EDITAR CATEGORIA
if (isset($_POST['idAgencia'])) {

    $agencia = new AjaxAgencias();
    $agencia->idAgencia = $_POST['idAgencia'];
    $agencia->ajaxEditarAgencia();
}
// OBJETO ELIMINAR CATEGORIA
if (isset($_POST['idEliminar'])) {

    $agenciaD = new AjaxAgencias();
    $agenciaD->idEliminar = $_POST['idEliminar'];
    $agenciaD->ajaxEliminarAgencia();
}
// VALIDAR CATEGORÍA
if (isset($_POST['validarAgencia'])) {

    $validar = new AjaxAgencias();
    $validar->validarAgencia = $_POST['validarAgencia'];
    $validar->ajaxValidarAgencia();
}
