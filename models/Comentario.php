<?php
    class Comentario extends Conectar{

        public function insert_comentario_pregunta($pre_id,$usu_id,$pred_detalle){
            $conectar = parent::conexion();
            parent::set_names();
            $sql="
                INSERT INTO td_comentario_pregunta (pre_id,usu_id,pred_detalle)
                VALUES (?,?,?)
                ";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1,$pre_id);
            $sql->bindValue(2,$usu_id);
            $sql->bindValue(3,$pred_detalle);
            $sql->execute();
            return $sql->fetchAll();
        }

        public function get_comentario_pregunta($pre_id){
            $conectar = parent::conexion();
            parent::set_names();
            $sql="
                SELECT
                    td_comentario_pregunta.pred_id,
                    td_comentario_pregunta.pre_id,
                    td_comentario_pregunta.usu_id,
                    td_comentario_pregunta.pred_detalle,
                    td_comentario_pregunta.fech_crea,
                    tm_usuario.usu_nom,
                    tm_usuario.usu_img,
                    tm_usuario.usu_nom_url,
                    CASE
                        WHEN TIMESTAMPDIFF(MINUTE, td_comentario_pregunta.fech_crea, NOW()) < 60 THEN CONCAT('hace ', TIMESTAMPDIFF(MINUTE, td_comentario_pregunta.fech_crea, NOW()), ' minutos')
                        WHEN TIMESTAMPDIFF(HOUR, td_comentario_pregunta.fech_crea, NOW()) < 24 THEN CONCAT('hace ', TIMESTAMPDIFF(HOUR, td_comentario_pregunta.fech_crea, NOW()), ' horas')
                        WHEN TIMESTAMPDIFF(DAY, td_comentario_pregunta.fech_crea, NOW()) < 30 THEN CONCAT('hace ', TIMESTAMPDIFF(DAY, td_comentario_pregunta.fech_crea, NOW()), ' días')
                        WHEN TIMESTAMPDIFF(MONTH, td_comentario_pregunta.fech_crea, NOW()) < 12 THEN CONCAT('hace ', TIMESTAMPDIFF(MONTH, td_comentario_pregunta.fech_crea, NOW()), ' meses')
                        ELSE CONCAT('hace ', TIMESTAMPDIFF(YEAR, td_comentario_pregunta.fech_crea, NOW()), ' años')
                    END AS hace
                FROM
                    td_comentario_pregunta
                INNER JOIN
                    tm_usuario ON td_comentario_pregunta.usu_id = tm_usuario.usu_id
                WHERE
                    td_comentario_pregunta.pre_id = ?
                ";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1,$pre_id);
            $sql->execute();
            return $sql->fetchAll();
        }

        public function insert_comentario_respuesta($resp_id,$usu_id,$respd_detalle){
            $conectar = parent::conexion();
            parent::set_names();
            $sql="
                INSERT INTO td_comentario_respuesta (resp_id,usu_id,respd_detalle)
                VALUES (?,?,?)
                ";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1,$resp_id);
            $sql->bindValue(2,$usu_id);
            $sql->bindValue(3,$respd_detalle);
            $sql->execute();
            return $sql->fetchAll();
        }

        public function get_comentario_respuesta($resp_id){
            $conectar = parent::conexion();
            parent::set_names();
            $sql="
                SELECT
                    td_comentario_respuesta.respd_id,
                    td_comentario_respuesta.resp_id,
                    td_comentario_respuesta.usu_id,
                    td_comentario_respuesta.respd_detalle,
                    td_comentario_respuesta.fech_crea,
                    tm_usuario.usu_nom,
                    tm_usuario.usu_img,
                    tm_usuario.usu_nom_url,
                    CASE
                    WHEN TIMESTAMPDIFF(MINUTE, td_comentario_respuesta.fech_crea, NOW()) < 60 THEN CONCAT('hace ', TIMESTAMPDIFF(MINUTE, td_comentario_respuesta.fech_crea, NOW()), ' minutos')
                    WHEN TIMESTAMPDIFF(HOUR, td_comentario_respuesta.fech_crea, NOW()) < 24 THEN CONCAT('hace ', TIMESTAMPDIFF(HOUR, td_comentario_respuesta.fech_crea, NOW()), ' horas')
                    WHEN TIMESTAMPDIFF(DAY, td_comentario_respuesta.fech_crea, NOW()) < 30 THEN CONCAT('hace ', TIMESTAMPDIFF(DAY, td_comentario_respuesta.fech_crea, NOW()), ' días')
                    WHEN TIMESTAMPDIFF(MONTH, td_comentario_respuesta.fech_crea, NOW()) < 12 THEN CONCAT('hace ', TIMESTAMPDIFF(MONTH, td_comentario_respuesta.fech_crea, NOW()), ' meses')
                    ELSE CONCAT('hace ', TIMESTAMPDIFF(YEAR, td_comentario_respuesta.fech_crea, NOW()), ' años')
                    END AS hace
                FROM
                    td_comentario_respuesta
                INNER JOIN
                    tm_usuario ON td_comentario_respuesta.usu_id = tm_usuario.usu_id
                WHERE
                    td_comentario_respuesta.resp_id = ?
                ";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1,$resp_id);
            $sql->execute();
            return $sql->fetchAll();
        }
    }
?>