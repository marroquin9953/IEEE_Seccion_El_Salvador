<?php
    class Usuario extends Conectar{

        public function login($usu_email,$usu_pass){
            $conectar = parent::conexion();
            parent::set_names();
            $sql="
                SELECT * FROM tm_usuario
                WHERE
                usu_email = ?
                AND usu_pass = ?
                ";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1,$usu_email);
            $sql->bindValue(2,$usu_pass);
            $sql->execute();
            return $sql->fetchAll();
        }

        public function insert_usuario($usu_nom,$usu_email,$usu_pass,$usu_img){
            $conectar = parent::conexion();

            $usu_nom_url=strtolower($usu_nom);
            $usu_nom_url=preg_replace('/[^a-z0-9]+/','-',$usu_nom_url);
            $usu_nom_url=trim($usu_nom_url,'-');
            $usu_nom_url=urlencode($usu_nom_url);

            parent::set_names();
            $sql="
                INSERT INTO tm_usuario (usu_nom, usu_email, usu_pass,usu_nom_url,usu_img)
                VALUES (?,?,?,?,?)
                ";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1,$usu_nom);
            $sql->bindValue(2,$usu_email);
            $sql->bindValue(3,$usu_pass);
            $sql->bindValue(4,$usu_nom_url);
            $sql->bindValue(5,$usu_img);
            $sql->execute();

            $sql1 = "SELECT last_insert_id() as 'usu_id', usu_nom_url
                    FROM tm_usuario
                    WHERE usu_id = last_insert_id()";
            $sql1 = $conectar->prepare($sql1);
            $sql1->execute();

            return $sql1->fetchAll(pdo::FETCH_ASSOC);
        }

        public function get_email_usuario($usu_email){
            $conectar = parent::conexion();
            parent::set_names();
            $sql="
                SELECT * FROM tm_usuario
                WHERE usu_email = ?
                ";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1,$usu_email);
            $sql->execute();
            return $sql->fetchAll();
        }

        public function get_id_usuario($usu_id){
            $conectar = parent::conexion();
            parent::set_names();
            $sql="
                SELECT * FROM tm_usuario
                WHERE usu_id = ?
                ";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1,$usu_id);
            $sql->execute();
            return $sql->fetchAll();
        }

        public function get_id_nom_usuario($usu_id,$usu_nom_url){
            $conectar = parent::conexion();
            parent::set_names();
            $sql="
                SELECT *,
                    CASE
                        WHEN TIMESTAMPDIFF(MINUTE, fech_crea, NOW()) < 60 THEN CONCAT('hace ', TIMESTAMPDIFF(MINUTE, fech_crea, NOW()), ' minutos')
                        WHEN TIMESTAMPDIFF(HOUR, fech_crea, NOW()) < 24 THEN CONCAT('hace ', TIMESTAMPDIFF(HOUR, fech_crea, NOW()), ' horas')
                        WHEN TIMESTAMPDIFF(DAY, fech_crea, NOW()) < 30 THEN CONCAT('hace ', TIMESTAMPDIFF(DAY, fech_crea, NOW()), ' días')
                        WHEN TIMESTAMPDIFF(MONTH, fech_crea, NOW()) < 12 THEN CONCAT('hace ', TIMESTAMPDIFF(MONTH, fech_crea, NOW()), ' meses')
                        ELSE CONCAT('hace ', TIMESTAMPDIFF(YEAR, fech_crea, NOW()), ' años')
                    END AS hace
                FROM tm_usuario
                WHERE
                    usu_id = ?
                    AND usu_nom_url = ?
                ";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1,$usu_id);
            $sql->bindValue(2,$usu_nom_url);
            $sql->execute();
            return $sql->fetchAll();
        }

        public function update_usuario($usu_id,$usu_nom,$usu_descrip,$usu_facebook,$usu_instagram,$usu_github,$usu_web,$usu_youtube,$usu_img){
            $conectar = parent::conexion();
            parent::set_names();

            $usu_descrip = $this->filtrar_datos($usu_descrip);

            $usu_nom_url=strtolower($usu_nom);
            $usu_nom_url=preg_replace('/[^a-z0-9]+/','-',$usu_nom_url);
            $usu_nom_url=trim($usu_nom_url,'-');
            $usu_nom_url=urlencode($usu_nom_url);

            $sql="
                UPDATE tm_usuario
                SET
                    usu_nom = ?,
                    usu_descrip = ?,
                    usu_facebook = ?,
                    usu_instagram = ?,
                    usu_github = ?,
                    usu_web = ?,
                    usu_youtube = ?,
                    usu_nom_url = ?,
                    usu_img = ?,
                    fech_modi = NOW()
                WHERE
                    usu_id = ?
                ";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1,$usu_nom);
            $sql->bindValue(2,$usu_descrip);
            $sql->bindValue(3,$usu_facebook);
            $sql->bindValue(4,$usu_instagram);
            $sql->bindValue(5,$usu_github);
            $sql->bindValue(6,$usu_web);
            $sql->bindValue(7,$usu_youtube);
            $sql->bindValue(8,$usu_nom_url);
            $sql->bindValue(9,$usu_img);
            $sql->bindValue(10,$usu_id);
            $sql->execute();
            return $sql->fetchAll();
        }

        public function filtrar_datos($dato) {
            $filtro = '/[^\p{L}\p{N}\s]/u';
            return preg_replace($filtro, '', $dato);
        }

        public function get_id_usuario_perfil($usu_id){
            $conectar = parent::conexion();
            parent::set_names();
            $sql="
                SELECT Perfil,Total
                    FROM (
                        SELECT 'Preguntas' as Perfil, COUNT(*) AS Total
                        FROM tm_pregunta
                        WHERE usu_id = ?

                        UNION ALL

                        SELECT 'Respuestas' as Perfil, COUNT(*) AS Total
                        FROM tm_respuesta
                        WHERE usu_id = ?

                        UNION ALL

                        SELECT 'Comentarios_respuesta' as Perfil, COUNT(*) AS Total
                        FROM td_comentario_respuesta
                        WHERE usu_id = ?

                        UNION ALL

                        SELECT 'Comentarios_pregunta' as Perfil, COUNT(*) AS Total
                        FROM td_comentario_pregunta
                        WHERE usu_id = ?

                        UNION ALL

                        SELECT 'Total_Comentarios' AS Perfil,
                            (
                                SELECT COUNT(*)
                                FROM td_comentario_respuesta
                                WHERE usu_id = ?
                            ) +
                            (
                                SELECT COUNT(*)
                                FROM td_comentario_pregunta
                                WHERE usu_id = ?
                            ) AS Total

                        UNION ALL

                        SELECT 'Total_total' AS Perfil,
                            (
                                SELECT COUNT(*) FROM tm_pregunta WHERE usu_id = ?
                            )+
                            (
                                SELECT COUNT(*) FROM tm_respuesta WHERE usu_id = ?
                            )+
                            (
                                SELECT COUNT(*) FROM td_comentario_respuesta WHERE usu_id = ?
                            )+
                            (
                                SELECT COUNT(*) FROM td_comentario_pregunta WHERE usu_id = ?
                            ) AS Total
                    ) AS all_data
                ";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1,$usu_id);
            $sql->bindValue(2,$usu_id);
            $sql->bindValue(3,$usu_id);
            $sql->bindValue(4,$usu_id);
            $sql->bindValue(5,$usu_id);
            $sql->bindValue(6,$usu_id);
            $sql->bindValue(7,$usu_id);
            $sql->bindValue(8,$usu_id);
            $sql->bindValue(9,$usu_id);
            $sql->bindValue(10,$usu_id);
            $sql->execute();
            return $sql->fetchAll();
        }

        public function get_usuarios_paginadas($start, $perPage){
            $conectar = parent::conexion();
            parent::set_names();
            $sql="
                SELECT
                    usu_nom,
                    usu_img,
                    usu_id,
                    usu_nom_url,
                    COUNT(*) AS total
                FROM
                    tm_usuario
                GROUP BY
                    usu_nom,usu_img,
                    usu_id,
                    usu_nom_url
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

        public function get_total_usuarios(){
            $conectar = parent::conexion();
            parent::set_names();
            $sql="
                SELECT COUNT(DISTINCT usu_nom) AS total_usuarios FROM tm_usuario
            ";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            /* TODO:Obtener directamente el valor de la columna total_preguntas */
            return $sql->fetchColumn();
        }

        public function update_usuario_password($usu_id,$usu_pass){
            $conectar = parent::conexion();
            parent::set_names();
            $sql="
                UPDATE tm_usuario
                SET
                    usu_pass = ?
                WHERE
                    usu_id = ?
                ";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1,$usu_pass);
            $sql->bindValue(2,$usu_id);
            $sql->execute();
            return $sql->fetchAll();
        }

        public function delete_usuario($usu_id){
            $conectar = parent::conexion();
            parent::set_names();
            $sql="
                UPDATE tm_usuario
                SET
                    est = 0,
                    fech_elim = NOW()
                WHERE
                    usu_id = ?
                ";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1,$usu_id);
            $sql->execute();
            return $sql->fetchAll();
        }



    }
?>