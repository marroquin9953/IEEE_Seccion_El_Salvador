<?php
    require_once("../config/conexion.php");
    require_once("../models/Comentario.php");

    $comentario = new Comentario();

    switch($_GET["op"]){

        case "insert_comentario_pregunta":
            $comentario->insert_comentario_pregunta($_POST["pre_id"],$_SESSION["usu_id"],$_POST["pred_detalle"]);
            echo $_POST["pre_id"];
            break;

        case "insert_comentario_respuesta":
            $comentario->insert_comentario_respuesta($_POST["resp_id"],$_SESSION["usu_id"],$_POST["respd_detalle"]);
            echo $_POST["resp_id"];
            break;

        case "comentario_preguntas":
            $datos = $comentario->get_comentario_pregunta($_POST["pre_id"]);

            $html="";
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row){
                    $html.="<li>".
                                "<div class='comment-body'>".
                                    "<span class='comment-copy'>".$row["pred_detalle"]."</span>".
                                    "<span class='comment-separated'> - </span>".
                                    "<a href='userprofile/".$row["usu_id"]."/".$row["usu_nom_url"]."' class='comment-user'>".$row["usu_nom"]."</a>".
                                    "<span class='comment-separated'> - </span>".
                                    "<a href='#' class='comment-date'>".$row["hace"]."</a>".
                                "</div>".
                            "</li>";
                }
                echo $html;
            }
            break;
    }
?>