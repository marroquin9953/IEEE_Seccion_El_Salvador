<?php
    class Etiqueta extends Conectar{

        public function get_etiquetas_paginadas($start, $perPage){
            $conectar = parent::conexion();
            parent::set_names();
            $sql="
                SELECT
                    eti_nom,
                    COUNT(*) AS total
                FROM 
                    tm_etiqueta
                GROUP BY
                    eti_nom
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

        public function get_total_etiquetas(){
            $conectar = parent::conexion();
            parent::set_names();
            $sql="
                SELECT COUNT(DISTINCT eti_nom) AS total_etiquetas FROM tm_etiqueta
            ";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            /* TODO:Obtener directamente el valor de la columna total_preguntas */
            return $sql->fetchColumn();
        }
    }
?>