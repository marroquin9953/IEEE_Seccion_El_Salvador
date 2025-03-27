<?php
    class Respuesta extends Conectar{

        public function insert_respuesta($pre_id,$usu_id,$resp_detalle){
            $conectar = parent::conexion();
            parent::set_names();
            $sql="
                INSERT INTO tm_respuesta (pre_id,usu_id,resp_detalle)
                VALUES (?,?,?)
                ";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1,$pre_id);
            $sql->bindValue(2,$usu_id);
            $sql->bindValue(3,$resp_detalle);
            $sql->execute();

            $sql1 = "select last_insert_id() as 'resp_id'";
            $sql1 = $conectar->prepare($sql1);
            $sql1->execute();

            return $sql1->fetchAll(pdo::FETCH_ASSOC);
        }

        public function get_pre_id_respuesta($pre_id){
            $conectar = parent::conexion();
            parent::set_names();
            $sql="
                SELECT
                    tm_respuesta.resp_id,
                    tm_respuesta.pre_id,
                    tm_respuesta.usu_id,
                    tm_respuesta.resp_detalle,
                    tm_respuesta.fech_crea,
                    tm_usuario.usu_nom,
                    tm_usuario.usu_img,
                    tm_usuario.usu_nom_url,
                    CASE
                        WHEN TIMESTAMPDIFF(MINUTE, tm_respuesta.fech_crea, NOW()) < 60 THEN CONCAT('hace ', TIMESTAMPDIFF(MINUTE, tm_respuesta.fech_crea, NOW()), ' minutos')
                        WHEN TIMESTAMPDIFF(HOUR, tm_respuesta.fech_crea, NOW()) < 24 THEN CONCAT('hace ', TIMESTAMPDIFF(HOUR, tm_respuesta.fech_crea, NOW()), ' horas')
                        WHEN TIMESTAMPDIFF(DAY, tm_respuesta.fech_crea, NOW()) < 30 THEN CONCAT('hace ', TIMESTAMPDIFF(DAY, tm_respuesta.fech_crea, NOW()), ' días')
                        WHEN TIMESTAMPDIFF(MONTH, tm_respuesta.fech_crea, NOW()) < 12 THEN CONCAT('hace ', TIMESTAMPDIFF(MONTH, tm_respuesta.fech_crea, NOW()), ' meses')
                    ELSE CONCAT('hace ', TIMESTAMPDIFF(YEAR, tm_respuesta.fech_crea, NOW()), ' años')
                    END AS hace
                FROM
                    tm_respuesta
                INNER JOIN
                    tm_usuario ON tm_respuesta.usu_id = tm_usuario.usu_id
                WHERE 
                    tm_respuesta.pre_id = ?
                ";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1,$pre_id);
            $sql->execute();
            return $sql->fetchAll();
        }
    }
?>