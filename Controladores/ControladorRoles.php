<?php

namespace Controladores;

use Controladores\ControladorEmpresa;

use Modelos\ModeloRoles;

class ControladorRoles
{
    protected static string $rolestabla = 'roles';
    protected static string $rolAccesoTabla = 'rol_acceso';

    public function __construct() {}

    // COMPROBAR CONEXIÓN 
    public static function ctrConn()
    {
        // use 80 for http or 443 for https protocol
        $item = 'rol';
        $valor = 'principal';
        $emisor = ControladorEmpresa::ctrEmisorConexion($item, $valor);

        if ($emisor['conexion'] == 's') {
            return 'ok';
        } else {
            return 'error';
        }
    }
    // MOSTRAR ROLES
    public static function ctrMostrarRoles($item, $valor)
    {
        $respuesta = ModeloRoles::mdlMostrarRoles(self::$rolestabla, $item, $valor);
        return $respuesta;
    }

    public static function ctrCrearRol($datos)
    {
        $respuesta = ModeloRoles::mdlCrearRol(self::$rolestabla, $datos);
        return $respuesta;
    }
    public static function ctrCrearAccesos($datos, $idRol)
    {
        $respuesta = ModeloRoles::mdlCrearAccesos(self::$rolAccesoTabla, $datos, $idRol);
        return $respuesta;
    }
    public static function ctrMostrarAccesos($item, $valor,  $valor2)
    {
        $respuesta = ModeloRoles::mdlMostrarAccesos(self::$rolAccesoTabla, $item, $valor, $valor2);
        return $respuesta;
    }
    public static function ctrMostrarAccesosid($item, $valor)
    {
        $respuesta = ModeloRoles::mdlMostrarAccesosid(self::$rolAccesoTabla, $item, $valor);
        return $respuesta;
    }
    public static function ctrEditarAccesos($item, $valor, $datos)
    {
        $respuesta = ModeloRoles::mdlEditarAccesos(self::$rolAccesoTabla, $item, $valor, $datos);
        return $respuesta;
    }

    public static function ctrEliminarRol($valor)
    {
        $respuesta = ModeloRoles::mdlEliminarRol(self::$rolestabla, $valor);
        return $respuesta;
    }
    public static function ctrEliminarAccesos($valor)
    {
        $respuesta = ModeloRoles::mdlEliminarAccesos(self::$rolAccesoTabla, $valor);
        return $respuesta;
    }

    public static function ctrCrearLinkAccesos($datos)
    {
        $respuesta = ModeloRoles::mdlCrearLinkAccesos(self::$rolAccesoTabla, $datos);
        return $respuesta;
    }
}