<?php

namespace Modelos;

use Conect\Conexion;
use PDO;

class ModeloUsuarios
{

    // MOSTRAR USUARIOS
    public static function mdlMostrarUsuarios($tabla, $item, $valor)
    {
        if ($item != null) {
            $stmt = Conexion::conectar()->prepare(
                "SELECT *
                 FROM $tabla  WHERE $item = :$item"
            );
            $stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);

            $stmt->execute();
            return $stmt->fetch();
        } else {
            $stmt = Conexion::conectar()->prepare(
                "SELECT * FROM $tabla"
            );
            //$stmt->bindParam(":".$item, $valor, PDO::PARAM_STR);    
            $stmt->execute();
            return $stmt->fetchall();
        }

        $stmt->close();
        $stmt = null;
    }

    // REGISTRO DE USUARIOS
    public static function mdlNuevoUsuario($tabla, $datos)
    {

        $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(nombre, usuario, password, perfil, dni, email, foto, id_sucursal) VALUES (:nombre, :usuario, :password, :perfil, :dni, :email, :foto, :id_sucursal)");
        $stmt->bindParam(":nombre", $datos['nombre'], PDO::PARAM_STR);
        $stmt->bindParam(":usuario", $datos['usuario'], PDO::PARAM_STR);
        $stmt->bindParam(":password", $datos['password'], PDO::PARAM_STR);
        $stmt->bindParam(":perfil", $datos['perfil'], PDO::PARAM_STR);
        $stmt->bindParam(":dni", $datos['dni'], PDO::PARAM_STR);
        $stmt->bindParam(":email", $datos['email'], PDO::PARAM_STR);
        $stmt->bindParam(":foto", $datos['foto'], PDO::PARAM_STR);
        $stmt->bindParam(":id_sucursal", $datos['id_sucursal'], PDO::PARAM_INT);

        if ($stmt->execute()) {

            return "ok";
        } else {

            return "error";
        }
        $stmt->close();
        $stmt = null;
    }
    //EDITAR USUARIOS
    public static function mdlEditarUsuario($tabla, $datos)
    {

        $stmt = Conexion::conectar()->prepare(
            "UPDATE $tabla SET nombre = :nombre, password = :password, perfil= :perfil, 
                    dni = :dni, email = :email, foto = :foto, id_sucursal = :id_sucursal,
                    usuario = :usuario
            WHERE  id= :id"
        );

        $stmt->bindParam(":nombre", $datos['nombre'], PDO::PARAM_STR);
        $stmt->bindParam(":password", $datos['password'], PDO::PARAM_STR);
        $stmt->bindParam(":perfil", $datos['perfil'], PDO::PARAM_STR);
        $stmt->bindParam(":dni", $datos['dni'], PDO::PARAM_STR);
        $stmt->bindParam(":email", $datos['email'], PDO::PARAM_STR);
        $stmt->bindParam(":foto", $datos['foto'], PDO::PARAM_STR);
        $stmt->bindParam(":id_sucursal", $datos['id_sucursal'], PDO::PARAM_INT);
        $stmt->bindParam(":usuario", $datos['usuario'], PDO::PARAM_STR);
        $stmt->bindParam(":id", $datos['id'], PDO::PARAM_INT);

        if ($stmt->execute()) {

            return 'ok';
        } else {
            return 'error';
        }
        $stmt->close();
        $stmt = null;
    }

    // ACTUALIZAR USUARIO ESTADO
    public static function mdlActualizarUsuario($tabla, $item1, $valor1, $item2, $valor2)
    {
        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item1 = :$item1 WHERE $item2 = :$item2");

        $stmt->bindParam(":" . $item1, $valor1, PDO::PARAM_STR);
        $stmt->bindParam(":" . $item2, $valor2, PDO::PARAM_STR);

        if ($stmt->execute()) {
            return 'ok';
        } else {
            return 'error';
        }
        $stmt->close();
        $stmt = null;
    }

    // BORRAR USUARIO
    public static function mdlBorrarUsuario($tabla, $datos)
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
}