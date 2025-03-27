<?php
    class Categoria extends Conectar{

        public function get_categoria(){
            $conectar = parent::conexion();
            parent::set_names();
            $sql="
                SELECT * FROM tm_categoria 
                WHERE est=1
                ";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $sql->fetchAll();
        }

        public function get_categorias_paginadas($start, $perPage){
            $conectar = parent::conexion();
            parent::set_names();
            $sql="
                SELECT 
                    tm_categoria.cat_nom,
                    COUNT(DISTINCT tm_pregunta.pre_id) AS total
                FROM
                    tm_pregunta
                INNER JOIN 
                    tm_categoria ON tm_pregunta.cat_id = tm_categoria.cat_id
                GROUP BY
                    tm_categoria.cat_nom
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

        public function get_total_categorias(){
            $conectar = parent::conexion();
            parent::set_names();
            $sql="
                SELECT COUNT(*) AS total_categorias FROM tm_categoria
            ";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            /* TODO:Obtener directamente el valor de la columna total_preguntas */
            return $sql->fetchColumn();
        }


    }
?>