<?php
// error_reporting(E_ALL);
// ini_set("display_errors", 1);
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

    public $validarAgenciaAgenciaId;
    public $validarAgenciaGuiaId;
    public function ajaxValidarAgenciaGuia()
    {

        $item = 'agencia_id';
        $valor = $this->validarAgencia;
        $respuesta = ControladorAgencias::ctrMostrarAgenciaGuiasById($item, $valor);

        echo json_encode($respuesta);
    }

    // VALIDAR NO REPETIR CATEGORÍA
    public $asignarAgencia;
    public function ajaxAsignarGuiaAgencia()
    {
        $respuesta = ControladorAgencias::ctrAgregarAgenciGuia($_POST);

        //echo json_encode($respuesta);
    }

    public $idListarAgencia;
    public function ajaxListarGuiasPorAgencia()
    {
        $item = 'agencia_id';
        $valor = $this->idListarAgencia;
        $respuesta = ControladorAgencias::ctrMostrarAgenciaGuiasById($item, $valor);
        echo json_encode($respuesta);
    }

    public $idAgenciaGuiaEliminar;
    public function ajaxEliminarGuiaAgencia()
    {

        $datos = $this->idAgenciaGuiaEliminar;

        $respuesta = ControladorAgencias::ctrEliminarGuiaAgencia($datos);
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

// OBJETO ELIMINAR CATEGORIA
if (isset($_GET['idListarAgencia'])) {
    $agenciaD = new AjaxAgencias();
    $agenciaD->idListarAgencia = $_GET['idListarAgencia'];
    $agenciaD->ajaxListarGuiasPorAgencia();
}

// VALIDAR CATEGORÍA
if (isset($_POST['validarAgencia'])) {

    $validar = new AjaxAgencias();
    $validar->validarAgencia = $_POST['validarAgencia'];
    $validar->ajaxValidarAgencia();
}

if (isset($_POST['validarAgenciaGuia'])) {

    $validar = new AjaxAgencias();
    $validar->validarAgenciaAgenciaId = $_POST['validarAgenciaGuia'];
    $validar->ajaxValidarAgencia();
}

if (isset($_POST['asignarAgencia'])) {

    $agenciaID = new AjaxAgencias();
    $agenciaID->asignarAgencia = $_POST['asignarAgencia'];
    $agenciaID->ajaxAsignarGuiaAgencia();
}

if (isset($_POST['idAgenciaGuiaEliminar'])) {

    $agenciaID = new AjaxAgencias();
    $agenciaID->idAgenciaGuiaEliminar = $_POST['idAgenciaGuiaEliminar'];
    $agenciaID->ajaxEliminarGuiaAgencia();
}
