<?php
require_once "../vendor/autoload.php";

use Controladores\ControladorAgencias;
use Controladores\ControladorGuiasTuristicos;

class AjaxGuiasTuristicos
{

    public function ajaxCreatGuiaTuristico()
    {

        $datosPost = $_POST;

        $respuesta = ControladorGuiasTuristicos::ctrCrearGuiaTuristico($datosPost);
        echo $respuesta;
    }

    public function ajaxEditarGuiaTuristico()
    {

        $datosPost = $_POST;
        // var_dump($datosPost);
        // exit();
        $respuesta = ControladorGuiasTuristicos::ctrEditarGuiaTuristico($datosPost);
        echo $respuesta;
    }
    // TRAER LOS CLIENTES PARA  EDITAR
    public $idGuiaTuristico;
    public function ajaxTraerGuiaTuristico()
    {

        $item = "id";
        $valor = $this->idGuiaTuristico;

        $resultado = ControladorGuiasTuristicos::ctrMostrarGuiasTuristicos($item, $valor);

        echo json_encode($resultado);
    }

    // ELIMINAR CLIENTE
    public $idEliminarGuiaTuristico;
    public function ajaxEliminarGuiaTuristico()
    {

        $item = 'guia_turismo_id';
        $valor = $this->idEliminarGuiaTuristico;
        $ventas = ControladorAgencias::ctrMostrarAgenciaGuias($item, $valor);
        if (!empty($ventas)) {
            echo 'ESTE GUÍA NO PUEDE SER ELIMINADO PORQUE TIENE AGENCIAS RELACIONADOS';
        } else {
            $datos = $this->idEliminarGuiaTuristico;
            $resultado = ControladorGuiasTuristicos::ctrEliminarGuiaTuristico($datos);
        }
    }
    // BUSCAR RUC O DNI
    public $rucCliente;
    public $tipoDoc;
    public function ajaxBuscarRuc()
    {

        $numDoc = $this->rucCliente;
        $tipoDoc = $this->tipoDoc;
        $resultado = ControladorGuiasTuristicos::ctrBuscarRuc($numDoc, $tipoDoc);
    }
    // VER SI EXISTE EL CLIENTE EN LA BD
    public function ajaxExisteGuiaTuristico($numDocumento)
    {
        if (strlen($numDocumento)  == 8) {
            $item = "documento";
        }
        if (strlen($numDocumento) > 8) {
            $item = "ruc";
        }
        $valor = $numDocumento;
        $respuesta = ControladorGuiasTuristicos::ctrMostrarGuiasTuristicos($item, $valor);
        echo json_encode($respuesta);
    }

    // BUSCAR CLIENTE PARA COMPROBANTE
    public function ajaxBuscarGuiaTuristico($numeroDoc)
    {
        $valor = $numeroDoc;
        $respuesta = ControladorGuiasTuristicos::ctrBucarGuiaTuristico($valor);
        // echo json_encode($respuesta);
        foreach ($respuesta as $k => $v) {
            if ($_POST['tipoDocumento'] == '6' and $v['ruc'] != '' and $v['activo'] != 'n') {

                echo '<legend style="margin:0px !important; padding:4px !important; font-size: 17px;"><a href="#" class="btn-add" idCliente="' . $v['id'] . '" > ' . $v['ruc'] . ' - <b style="font-size: 13px; color: #444; font-weight: 600; letter-spacing: 1px;">' . $v['razon_social'] . '</b></a></legend>';
            } else {
                if ($_POST['tipoDocumento'] != '6' and $v['documento'] != '' and $v['activo'] != 'n') {

                    echo '<legend style="margin:0px !important; padding:4px !important; font-size: 17px;"><a href="#" class="btn-add" idCliente="' . $v['id'] . '" > ' . $v['documento'] . ' - <b style="font-size: 13px; color: #444; font-weight: 600; letter-spacing: 1px;">' . $v['nombre'] . '</b></a></legend>';
                }
            }
        }
    }

    public function ajaxActivarDesactivarGuiaTuristico()
    {
        $datos = array(
            "id" => $_POST['id_guiap'],
            "modo" => $_POST['activos']
        );
        $resultado = ControladorGuiasTuristicos::ctrActivaDesactivaGuiaTuristico($datos);
    }
}

// CREAR CLIENTES
if (isset($_POST['nuevonumdoc'])) {

    $idCliente = new AjaxGuiasTuristicos();
    $idCliente->ajaxCreatGuiaTuristico();
}
if (isset($_POST['editarnumdoc'])) {

    $idCliente = new AjaxGuiasTuristicos();
    $idCliente->ajaxEditarGuiaTuristico();
}
// TRAER PARA EDITAR CLIENTES
if (isset($_POST['idGuiaTuristico'])) {

    $idGuiaTuristico = new AjaxGuiasTuristicos();
    $idGuiaTuristico->idGuiaTuristico = $_POST['idGuiaTuristico'];
    $idGuiaTuristico->ajaxTraerGuiaTuristico();
}
// ELIMINAR CLIENTE
if (isset($_POST['idEliminarGuiaTuristico'])) {

    $eliminar = new AjaxGuiasTuristicos();
    $eliminar->idEliminarGuiaTuristico = $_POST['idEliminarGuiaTuristico'];
    $eliminar->ajaxEliminarGuiaTuristico();
}
// BUSCAR RUC CLIENTE
if (isset($_POST['rucCliente'])) {
    $rucCliente = new AjaxGuiasTuristicos();
    $rucCliente->rucCliente = trim($_POST['rucCliente']);
    $rucCliente->tipoDoc = $_POST['tipoDoc'];
    $rucCliente->ajaxBuscarRuc();
}
// SI EXISTE EL  CLIENTE
if (isset($_POST['numDocumento'])) {
    $existeCliente = new AjaxGuiasTuristicos();
    //$existeCliente->numDocumento = $_POST['numDocumento'];
    $existeCliente->ajaxExisteGuiaTuristico(trim($_POST['numDocumento']));
}
// BUSCAR CLIENTE PARA COMPROBANTE
if (isset($_POST['numeroDoc'])) {
    $existeCliente = new AjaxGuiasTuristicos();
    //$existeCliente->numeroDoc = $_POST['numDocumento'];
    $existeCliente->ajaxBuscarGuiaTuristico(trim($_POST['numeroDoc']));
}
if (isset($_POST['id_guiap'])) {
    $actDesa = new AjaxGuiasTuristicos();
    $actDesa->ajaxActivarDesactivarGuiaTuristico();
}
