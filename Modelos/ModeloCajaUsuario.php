<?php

namespace Modelos;

use Conect\Conexion;
use PDO;

class ModeloCajaUsuario
{
    // MOSTRAR USUARIOS
    public static function mdlMostrarUsuariosCaja($tabla, $caja_id)
    {

        if ($caja_id != null) {

            $stmt = Conexion::conectar()->prepare(
                "SELECT  cajausu.id, cajausu.caja_id,cajausu.usuario_id,
                    CONCAT(c.nombre,' ',c.numero_caja) AS

                FROM $tabla cajausu INNER JOIN cajas c ON c.id = cajausu.caja_id
                    INNER JOIN usuarios u ON u.id = cajausu.usuario_id
                WHERE cajausau.estado=1 AND caja_id = :caja_id"
            );
            $stmt->bindParam(":caja_id", $caja_id, PDO::PARAM_INT);

            $stmt->execute();
            return $stmt->fetchAll();
        } else {
            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE estado = 1");
            //$stmt->bindParam(":".$item, $valor, PDO::PARAM_STR);    
            $stmt->execute();
            return $stmt->fetchall();
        }


        $stmt->close();
        $stmt = null;
    }
}