<?php

namespace Controladores;

use Modelos\ModeloAgencias;
use Modelos\ModeloVentas;

class ControladorAgencias
{
    public function ctrCrearAgencia()
    {

        if (isset($_POST['nuevaAgencia'])) {
            if (preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST['nuevaAgencia'])) {
                $table = "agencia";
                $datos = strtoupper($_POST['nuevaAgencia']);
                $respuesta = ModeloAgencias::mdlCrearAgencia($table, $datos);
                if ($respuesta == 'ok') {
                    echo "<script>
                    Swal.fire({
                        title: '¡La agencia ha sido agregada corréctamente!',
                        text: '...',
                        icon: 'success',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Cerrar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                        window.location = 'agencias';
                        }
                    })</script>";
                }
            } else {

                echo "<script>
                    Swal.fire({
                        title: '¡La agencia no puede ir vacía o llevar caracteres especiales!',
                        text: '...',
                        icon: 'error',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Cerrar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                        window.location = 'agencias';
                        }
                    })</script>";
            }
        }
    }

    // MOSTRAR, LISTAR CATEGORÍAS
    public static function ctrMostrarAgencias($item, $valor)
    {

        $tabla = "agencia";
        $respuesta = ModeloAgencias::mdlMostrarAgencias($tabla, $item, $valor);
        return $respuesta;
    }

    // EDITAR CATEGORIA
    public function ctrEditarAgencia()
    {

        if (isset($_POST['editarAgencia'])) {
            if (preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST['editarAgencia'])) {

                $table = "agencia";
                $datos = array(
                    'nombre' => strtoupper($_POST['editarAgencia']),
                    'id' => $_POST['idAgencia']
                );

                $respuesta = ModeloAgencias::mdlEditarAgencia($table, $datos);

                if ($respuesta == 'ok') {
                    echo "<script>
                    Swal.fire({
                        title: '¡La agencia ha sido cambiada corréctamente!',
                        text: '...',
                        icon: 'success',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Cerrar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                        window.location = 'agencias';
                        }
                    })</script>";
                }
            } else {

                echo "<script>
                    Swal.fire({
                        title: '¡La agencia no puede ir vacía o llevar caracteres especiales!',
                        text: '...',
                        icon: 'error',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Cerrar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                        window.location = 'agencias';
                        }
                    })</script>";
            }
        }
    }

    // MOSTRAR, LISTAR CATEGORÍAS
    public static function ctrMostrarAgenciaGuias($item, $valor)
    {
        $tabla = "agencia_guia";
        $respuesta = ModeloAgencias::mdlMostrarAgenciaGuias($tabla, $item, $valor);
        return $respuesta;
    }

    // MOSTRAR, LISTAR AGENCIAS
    public static function ctrMostrarAgenciaGuiasById($item, $valor)
    {
        $tabla = "agencia_guia";
        $respuesta = ModeloAgencias::mdlMostrarAgenciaGuiasById($tabla, $item, $valor);
        return $respuesta;
    }

    public static function ctrAgregarAgenciGuia($datosPost)
    {

        $datos = array(
            "agencia_id" => $datosPost['idAgenciaAsignar'],
            "guia_turismo_id" => $datosPost['guiaAgencia'],
            "estado" => 1
        );
        $validar = ModeloAgencias::mdlValidarAgenciaGuiasById('agencia_guia', $datos);

        if ($validar == 0) {
            $tabla = "agencia_guia";
            $respuesta = ModeloAgencias::mdlAgregarGuiaAgencia($tabla, $datos);

            if ($respuesta == "ok") {
                echo 'success';
            }
        } else {
            echo "found";
        }
        //return $respuesta;
    }

    public static function ctrEliminarAgencia($datos)
    {
        if (isset($datos)) {
            $tabla = 'agencia_guia';
            $item = 'agencia_id';
            $valor = $datos;
            $producto = ModeloAgencias::mdlMostrarAgenciaGuias($tabla, $item, $valor);

            if (!$producto) {

                $tabla = 'agencia';
                $respuesta = ModeloAgencias::mdlEliminarAgencia($tabla, $datos);
                if ($respuesta == 'ok') {
                    echo 'success';
                }
            } else {
                echo 'error';
            }
        }
    }

    public static function ctrEliminarGuiaAgencia(int $datos)
    {
        if (isset($datos)) {
            $tabla = 'venta';
            $item = 'agencia_guia_id';
            $valor = $datos;
            $ventas = ModeloVentas::mdlValidarAgenciaGuiasById($tabla, $valor);
            if ($ventas == 0) {
                $tabla = 'agencia_guia';
                $respuesta = ModeloAgencias::mdlEliminarAgencia($tabla, $valor);
                if ($respuesta == 'ok') {
                    echo 'success';
                }
            } else {
                echo 'error';
            }
        }
    }
}
