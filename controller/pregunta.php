<?php
    require_once("../config/conexion.php");
    require_once("../models/Pregunta.php");

    $pregunta = new Pregunta();

    switch($_GET["op"]){

        case "insert":
            $datos = $pregunta->insert_pregunta($_SESSION["usu_id"],$_POST["cat_id"],$_POST["pre_titulo"],$_POST["pre_detalle"],$_POST["pre_alerta"]);
            if(isset($_POST["tags"]) && is_array($_POST["tags"])){
                foreach($_POST["tags"] as $tag){
                    $pregunta->insert_etiqueta($datos[0]["pre_id"],trim($tag));
                }
            }
            echo json_encode($datos);
            break;

    }
?>