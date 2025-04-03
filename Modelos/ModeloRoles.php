<?php

namespace Modelos;

use Conect\Conexion;
use PDO;

class ModeloRoles
{
    // MOSTRAR ROLES
    public static function mdlMostrarRoles($tabla, $item, $valor)
    {
        if ($item != null) {
            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla  WHERE $item = :$item");
            $stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch();
        } else {
            $stmt = Conexion::conectar()->prepare(
                "SELECT * FROM $tabla ORDER BY id asc"
            );
            //$stmt->bindParam(":".$item, $valor, PDO::PARAM_STR);    
            $stmt->execute();
            return $stmt->fetchall();
        }


        $stmt->close();
        $stmt = null;
    }

    //ROLES DE USUARIOS
    public static function mdlCrearRol($tabla, $datos)
    {

        $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(rol) VALUES (:rol)");
        $stmt->bindParam(":rol", $datos['rol'], PDO::PARAM_STR);


        if ($stmt->execute()) {

            return "ok";
        } else {

            return "error";
        }
        $stmt->close();
        $stmt = null;
    }
    public static function mdlCrearAccesos($tabla, $datos, $idRol)
    {

        $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(id_rol, nombreacceso, linkacceso) VALUES (:id_rol, :nombreacceso, :linkacceso)");
        foreach ($datos as  $v) {
            $nombre = strtoupper(strtr($v, "-", " "));
            $stmt->bindParam(":id_rol", $idRol, PDO::PARAM_INT);
            $stmt->bindParam(":nombreacceso", $nombre, PDO::PARAM_STR);
            $stmt->bindParam(":linkacceso", $v, PDO::PARAM_STR);


            $stmt->execute();
        }
    }

    public static function mdlMostrarAccesos($tabla, $item, $valor, $valor2)
    {

        if ($item != null) {

            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla  WHERE $item = :$item AND linkacceso = :linkacceso");
            $stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);
            $stmt->bindParam(":linkacceso", $valor2, PDO::PARAM_STR);

            $stmt->execute();
            return $stmt->fetch();
        } else {
            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");
            //$stmt->bindParam(":".$item, $valor, PDO::PARAM_STR);    
            $stmt->execute();
            return $stmt->fetchall();
        }


        $stmt->close();
        $stmt = null;
    }
    public static function mdlMostrarAccesosid($tabla, $item, $valor)
    {

        if ($item != null) {

            $stmt = Conexion::conectar()->prepare(
                "SELECT * FROM $tabla  WHERE $item = :$item"
            );
            $stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);

            $stmt->execute();
            return $stmt->fetchall();
        } else {
            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");
            //$stmt->bindParam(":".$item, $valor, PDO::PARAM_STR);    
            $stmt->execute();
            return $stmt->fetchall();
        }


        $stmt->close();
        $stmt = null;
    }

    // OBTENER EL ULTIMO ID COMPROBANTE
    public static function mdlObtenerUltimoRolId()
    {
        $stmt = Conexion::conectar()->prepare("SELECT * FROM roles ORDER BY id DESC LIMIT 1");

        $stmt->execute();

        return $stmt->fetch();
    }

    public static function mdlEditarAccesos($tabla, $item, $valor, $datos)
    {

        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET activo=:activo WHERE $item=:$item");

        $stmt->bindParam("" . $item, $valor, PDO::PARAM_INT);
        $stmt->bindParam(":activo", $datos['activo'], PDO::PARAM_STR);


        if ($stmt->execute()) {
            return   'ok';
        } else {
            return  'error';
        }

        $stmt->close();
        $stmt = null;
    }

    // BORRAR USUARIO
    public static function mdlEliminarRol($tabla, $valor)
    {

        $stmt = Conexion::conectar()->prepare("DELETE FROM $tabla  WHERE id=:id");
        $stmt->bindParam(":id", $valor, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return 'ok';
        } else {
            return 'error';
        }
        $stmt->close();
        $stmt = null;
    }
    // BORRAR USUARIO
    public static function mdlEliminarAccesos($tabla, $valor)
    {

        $stmt = Conexion::conectar()->prepare("DELETE FROM $tabla  WHERE id_rol=:id_rol");
        $stmt->bindParam(":id_rol", $valor, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return 'ok';
        } else {
            return 'error';
        }
        $stmt->close();
        $stmt = null;
    }

    public static function mdlCrearLinkAccesos($tabla, $datos)
    {

        $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(id_rol, nombreacceso, linkacceso) VALUES (:id_rol, :nombreacceso, :linkacceso)");


        $stmt->bindParam(":id_rol", $datos['id'], PDO::PARAM_INT);
        $stmt->bindParam(":nombreacceso", $datos['nuevoacceso'], PDO::PARAM_STR);
        $stmt->bindParam(":linkacceso", $datos['nuevolink'], PDO::PARAM_STR);

        if ($stmt->execute()) {
            return 'ok';
        } else {
            return 'error';
        }
        $stmt->close();
        $stmt = null;
    }
}