<?php

namespace Modelos;

use Conect\Conexion;
use PDO;

class ModeloAgencias
{

    public static function mdlCrearAgencia($tabla, $datos)
    {
        $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(nombre) VALUES (:nombre) ");
        $stmt->bindParam(":nombre", $datos, PDO::PARAM_STR);

        if ($stmt->execute()) {
            return 'ok';
        } else {
            return 'error';
        }
        $stmt->close();
        $stmt = null;
    }

    public static function mdlMostrarAgencias($tabla, $item, $valor)
    {
        if ($item != null) {

            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla  WHERE $item = :$item");
            $stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);

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
    // EDITAR CATEGORIA
    public static function mdlEditarAgencia($tabla, $datos)
    {
        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombre = :nombre WHERE id = :id ");
        $stmt->bindParam(":nombre", $datos['nombre'], PDO::PARAM_STR);
        $stmt->bindParam(":id", $datos['id'], PDO::PARAM_INT);

        if ($stmt->execute()) {
            return 'ok';
        } else {
            return 'error';
        }
        $stmt->close();
        $stmt = null;
    }

    // ELIMINAR CATEGORIA
    public static function mdlEliminarAgencia($tabla, $datos)
    {

        $stmt = Conexion::conectar()->prepare("DELETE FROM $tabla  WHERE id=:id");
        $stmt->bindParam(":id", $datos, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return 'ok';
        } else {
            return 'error';
        }
        $stmt->close();
        $stmt = null;
    }

    public static function mdlMostrarAgenciaGuida($tabla, $datos)
    {

        $stmt = Conexion::conectar()->prepare("DELETE FROM $tabla  WHERE id=:id");
        $stmt->bindParam(":id", $datos, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return 'ok';
        } else {
            return 'error';
        }
        $stmt->close();
        $stmt = null;
    }

    public static function mdlMostrarAgenciaGuias($tabla, $item, $valor)
    {
        if ($item != null) {
            $stmt = Conexion::conectar()->prepare(
                "SELECT * FROM $tabla  WHERE $item = :$item ORDER BY id DESC"
            );
            $stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);

            $stmt->execute();
            return $stmt->fetch();
        } else {
            return [];
            // $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla  WHERE id_sucursal = $idsucursal");
            // //$stmt->bindParam(":".$item, $valor, PDO::PARAM_STR);    
            // $stmt->execute();
            // return $stmt->fetchall();
        }


        $stmt->close();
        $stmt = null;
    }

    public static function mdlAgregarGuiaAgencia($tabla, $datos)
    {
        $stmt = Conexion::conectar()->prepare(
            "INSERT INTO $tabla(agencia_id,guia_turismo_id,estado) 
            VALUES (:agencia_id,:guia_turismo_id,:estado) "
        );
        $stmt->bindParam(":agencia_id", $datos['agencia_id'], PDO::PARAM_STR);
        $stmt->bindParam(":guia_turismo_id", $datos['guia_turismo_id'], PDO::PARAM_STR);
        $stmt->bindParam(":estado", $datos['estado'], PDO::PARAM_STR);


        if ($stmt->execute()) {
            return 'ok';
        } else {
            return 'error';
        }
        $stmt->close();
        $stmt = null;
    }

    public static function mdlMostrarAgenciaGuiasById($tabla, $item, $valor)
    {
        if ($item != null) {

            $stmt = Conexion::conectar()->prepare(
                "SELECT 
                    agencia_guia.id, agencia_guia.agencia_id,agencia_guia.guia_turismo_id,
                    gt.documento,gt.nombre as guia,agencia_guia.estado
                FROM $tabla  
                INNER JOIN guias_turista as gt ON agencia_guia.guia_turismo_id = gt.id
                WHERE $item = :$item ORDER BY agencia_guia.id DESC"
            );
            $stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);

            $stmt->execute();
            return $stmt->fetchAll();
        } else {
            return [];
            // $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla  WHERE id_sucursal = $idsucursal");
            // //$stmt->bindParam(":".$item, $valor, PDO::PARAM_STR);    
            // $stmt->execute();
            // return $stmt->fetchall();
        }


        $stmt->close();
        $stmt = null;
    }

    public static function mdlValidarAgenciaGuiasById(string $tabla, array $datos)
    {
        $stmt = Conexion::conectar()->prepare(
            "SELECT COUNT(agencia_guia.id) as cantidad_registros
            FROM $tabla
            WHERE guia_turismo_id=:guia_turismo_id"
        );
        //$stmt->bindParam(":agencia_id", $datos["agencia_id"], PDO::PARAM_STR);
        $stmt->bindParam(":guia_turismo_id", $datos["guia_turismo_id"], PDO::PARAM_STR);

        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        // Cerrar la conexión
        $stmt->closeCursor();
        $stmt = null;

        return $resultado ? (int)$resultado['cantidad_registros'] : 0;

        //---------------------------------------------------------------------------
    }
}
