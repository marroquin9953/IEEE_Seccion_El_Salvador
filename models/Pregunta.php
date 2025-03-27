<?php
    class Pregunta extends Conectar{

        public function insert_pregunta($usu_id,$cat_id,$pre_titulo,$pre_detalle,$pre_alerta){
            $conectar = parent::conexion();

            $pre_titulo_url=strtolower($pre_titulo);
            $pre_titulo_url=preg_replace('/[^a-z0-9]+/','-',$pre_titulo_url);
            $pre_titulo_url=trim($pre_titulo_url,'-');
            $pre_titulo_url=urlencode($pre_titulo_url);

            parent::set_names();
            $sql="
                INSERT INTO tm_pregunta (usu_id,cat_id,pre_titulo,pre_detalle,pre_titulo_url,pre_alerta) 
                VALUES
                (?,?,?,?,?,?)
                ";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1,$usu_id);
            $sql->bindValue(2,$cat_id);
            $sql->bindValue(3,$pre_titulo);
            $sql->bindValue(4,$pre_detalle);
            $sql->bindValue(5,$pre_titulo_url);
            $sql->bindValue(6,$pre_alerta);
            $sql->execute();

            $sql1 = "select last_insert_id() as 'pre_id'";
            $sql1 = $conectar->prepare($sql1);
            $sql1->execute();

            return $sql1->fetchAll(pdo::FETCH_ASSOC);
        }

        public function insert_etiqueta($pre_id,$eti_nom){
            $conectar = parent::conexion();
            parent::set_names();
            $sql="
                INSERT INTO tm_etiqueta (pre_id,eti_nom) 
                VALUES (?,?)
                ";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1,$pre_id);
            $sql->bindValue(2,$eti_nom);
            $sql->execute();
            return $sql->fetchAll();
        }

        public function get_total_preguntas(){
            $conectar = parent::conexion();
            parent::set_names();
            $sql="
                SELECT COUNT(*) AS total_preguntas FROM tm_pregunta
            ";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            /* TODO:Obtener directamente el valor de la columna total_preguntas */
            return $sql->fetchColumn();
        }

        public function get_preguntas_paginadas($start, $perPage){
            $conectar = parent::conexion();
            parent::set_names();
            $sql="
                SELECT
                    tm_pregunta.pre_id,
                    tm_pregunta.usu_id,
                    tm_pregunta.pre_titulo,
                    tm_pregunta.pre_detalle,
                    tm_pregunta.pre_titulo_url,
                    tm_pregunta.pre_alerta,
                    tm_usuario.usu_nom,
                    tm_usuario.usu_email,
                    tm_usuario.usu_img,
                    tm_usuario.usu_nom_url,
                    tm_categoria.cat_nom,
                    GROUP_CONCAT(tm_etiqueta.eti_nom ORDER BY tm_etiqueta.eti_nom SEPARATOR ', ') AS etiquetas,
                    CASE
                    WHEN TIMESTAMPDIFF(MINUTE, tm_pregunta.fech_crea, NOW()) < 60 THEN CONCAT('hace ', TIMESTAMPDIFF(MINUTE, tm_pregunta.fech_crea, NOW()), ' minutos')
                    WHEN TIMESTAMPDIFF(HOUR, tm_pregunta.fech_crea, NOW()) < 24 THEN CONCAT('hace ', TIMESTAMPDIFF(HOUR, tm_pregunta.fech_crea, NOW()), ' horas')
                    WHEN TIMESTAMPDIFF(DAY, tm_pregunta.fech_crea, NOW()) < 30 THEN CONCAT('hace ', TIMESTAMPDIFF(DAY, tm_pregunta.fech_crea, NOW()), ' días')
                    WHEN TIMESTAMPDIFF(MONTH, tm_pregunta.fech_crea, NOW()) < 12 THEN CONCAT('hace ', TIMESTAMPDIFF(MONTH, tm_pregunta.fech_crea, NOW()), ' meses')
                    ELSE CONCAT('hace ', TIMESTAMPDIFF(YEAR, tm_pregunta.fech_crea, NOW()), ' años')
                    END AS hace
                FROM
                    tm_pregunta
                INNER JOIN
                    tm_usuario ON tm_pregunta.usu_id = tm_usuario.usu_id
                INNER JOIN
                    tm_categoria ON tm_pregunta.cat_id = tm_categoria.cat_id
                LEFT JOIN
                    tm_etiqueta ON tm_pregunta.pre_id = tm_etiqueta.pre_id
                GROUP BY
                    tm_pregunta.pre_id
                LIMIT
                    :start, :perPage
            ";
            $sql=$conectar->prepare($sql);
            $sql->bindParam(':start',$start,PDO::PARAM_INT);
            $sql->bindParam(':perPage',$perPage,PDO::PARAM_INT);
            $sql->execute();
            /* TODO:Obtener directamente el valor de la columna total_preguntas */
            return $sql->fetchAll();
        }

        public function get_total_preguntas_con_busqueda($search){
            $conectar = parent::conexion();
            parent::set_names();

            /* TODO:Dividir la cadena de busqueda en palabras individuales */
            $keywords = explode(" ", $search);
            $searchConditions = [];
            foreach ($keywords as $keyword){
                $searchConditions[] = "(pre_titulo LIKE :keyword OR pre_detalle LIKE :keyword)";
            }
            $searchQuery = implode(" OR ", $searchConditions);

            /* TODO:Contruir la consulta SQL de manera dinamica */
            $sql="
                SELECT COUNT(*) AS total_preguntas
                FROM tm_pregunta
                WHERE " .  $searchQuery;
            $sql=$conectar->prepare($sql);

            /* TODO:Vincular cada palabra clave a la consulta SQL */
            foreach ($keywords as $key => $keyword){
                $searchParam = "%$keyword%";
                $sql->bindParam(":keyword",$searchParam,PDO::PARAM_STR);
            }

            $sql->execute();
            /* TODO:Obtener directamente el valor de la columna total_preguntas */
            return $sql->fetchColumn();
        }

        public function get_preguntas_paginadas_con_busqueda($start, $perPage, $search){
            $conectar = parent::conexion();
            parent::set_names();

            /* TODO:Dividir la cadena de busqueda en palabras individuales */
            $keywords = explode(" ", $search);
            $searchConditions = [];
            foreach ($keywords as $keyword){
                $searchConditions[] = "(tm_pregunta.pre_titulo LIKE :keyword OR tm_pregunta.pre_detalle LIKE :keyword)";
            }
            $searchQuery = implode(" OR ", $searchConditions);

            $sql="
                SELECT
                    tm_pregunta.pre_id,
                    tm_pregunta.usu_id,
                    tm_pregunta.pre_titulo,
                    tm_pregunta.pre_detalle,
                    tm_pregunta.pre_titulo_url,
                    tm_pregunta.pre_alerta,
                    tm_usuario.usu_nom,
                    tm_usuario.usu_email,
                    tm_usuario.usu_img,
                    tm_usuario.usu_nom_url,
                    tm_categoria.cat_nom,
                    GROUP_CONCAT(tm_etiqueta.eti_nom ORDER BY tm_etiqueta.eti_nom SEPARATOR ', ') AS etiquetas,
                    CASE
                    WHEN TIMESTAMPDIFF(MINUTE, tm_pregunta.fech_crea, NOW()) < 60 THEN CONCAT('hace ', TIMESTAMPDIFF(MINUTE, tm_pregunta.fech_crea, NOW()), ' minutos')
                    WHEN TIMESTAMPDIFF(HOUR, tm_pregunta.fech_crea, NOW()) < 24 THEN CONCAT('hace ', TIMESTAMPDIFF(HOUR, tm_pregunta.fech_crea, NOW()), ' horas')
                    WHEN TIMESTAMPDIFF(DAY, tm_pregunta.fech_crea, NOW()) < 30 THEN CONCAT('hace ', TIMESTAMPDIFF(DAY, tm_pregunta.fech_crea, NOW()), ' días')
                    WHEN TIMESTAMPDIFF(MONTH, tm_pregunta.fech_crea, NOW()) < 12 THEN CONCAT('hace ', TIMESTAMPDIFF(MONTH, tm_pregunta.fech_crea, NOW()), ' meses')
                    ELSE CONCAT('hace ', TIMESTAMPDIFF(YEAR, tm_pregunta.fech_crea, NOW()), ' años')
                    END AS hace
                FROM
                    tm_pregunta
                INNER JOIN
                    tm_usuario ON tm_pregunta.usu_id = tm_usuario.usu_id
                INNER JOIN
                    tm_categoria ON tm_pregunta.cat_id = tm_categoria.cat_id
                LEFT JOIN
                    tm_etiqueta ON tm_pregunta.pre_id = tm_etiqueta.pre_id
                WHERE
                    " . $searchQuery . "
                GROUP BY
                    tm_pregunta.pre_id
                LIMIT
                    :start, :perPage
            ";
            $sql=$conectar->prepare($sql);
            $sql->bindParam(':start',$start,PDO::PARAM_INT);
            $sql->bindParam(':perPage',$perPage,PDO::PARAM_INT);

            /* TODO:Vincular cada palabra clave a la consulta SQL */
            foreach ($keywords as $key => $keyword){
                $searchParam = "%$keyword%";
                $sql->bindParam(":keyword",$searchParam,PDO::PARAM_STR);
            }

            $sql->execute();
            /* TODO:Obtener directamente el valor de la columna total_preguntas */
            return $sql->fetchAll();
        }

        public function get_id_titulo_preguntas($pre_id, $pre_titulo_url){
            $conectar = parent::conexion();
            parent::set_names();
            $sql="
                SELECT
                    tm_pregunta.pre_id,
                    tm_pregunta.usu_id,
                    tm_pregunta.pre_titulo,
                    tm_pregunta.pre_detalle,
                    tm_pregunta.pre_titulo_url,
                    tm_pregunta.pre_alerta,
                    tm_usuario.usu_nom,
                    tm_usuario.usu_email,
                    tm_usuario.usu_img,
                    tm_usuario.usu_nom_url,
                    tm_categoria.cat_nom,
                    GROUP_CONCAT(tm_etiqueta.eti_nom ORDER BY tm_etiqueta.eti_nom SEPARATOR ', ') AS etiquetas,
                    CASE
                    WHEN TIMESTAMPDIFF(MINUTE, tm_pregunta.fech_crea, NOW()) < 60 THEN CONCAT('hace ', TIMESTAMPDIFF(MINUTE, tm_pregunta.fech_crea, NOW()), ' minutos')
                    WHEN TIMESTAMPDIFF(HOUR, tm_pregunta.fech_crea, NOW()) < 24 THEN CONCAT('hace ', TIMESTAMPDIFF(HOUR, tm_pregunta.fech_crea, NOW()), ' horas')
                    WHEN TIMESTAMPDIFF(DAY, tm_pregunta.fech_crea, NOW()) < 30 THEN CONCAT('hace ', TIMESTAMPDIFF(DAY, tm_pregunta.fech_crea, NOW()), ' días')
                    WHEN TIMESTAMPDIFF(MONTH, tm_pregunta.fech_crea, NOW()) < 12 THEN CONCAT('hace ', TIMESTAMPDIFF(MONTH, tm_pregunta.fech_crea, NOW()), ' meses')
                    ELSE CONCAT('hace ', TIMESTAMPDIFF(YEAR, tm_pregunta.fech_crea, NOW()), ' años')
                    END AS hace
                FROM
                    tm_pregunta
                INNER JOIN
                    tm_usuario ON tm_pregunta.usu_id = tm_usuario.usu_id
                INNER JOIN
                    tm_categoria ON tm_pregunta.cat_id = tm_categoria.cat_id
                LEFT JOIN
                    tm_etiqueta ON tm_pregunta.pre_id = tm_etiqueta.pre_id
                WHERE
                    tm_pregunta.pre_id = ?
                    AND tm_pregunta.pre_titulo_url= ?
                GROUP BY
                    tm_pregunta.pre_id
            ";
            $sql=$conectar->prepare($sql);
            $sql->bindParam(1,$pre_id);
            $sql->bindParam(2,$pre_titulo_url);
            $sql->execute();
            return $sql->fetchAll();
        }

    }
?>