<?php
    require_once("../config/conexion.php");
    require_once("../models/Usuario.php");

    $usuario = new Usuario();

    switch($_GET["op"]){

        case "login":
            $datos = $usuario->login($_POST["usu_email"],$_POST["usu_pass"]);
            if(is_array($datos) && count($datos)>0){
                $_SESSION["usu_id"] = $datos[0]["usu_id"];
                $_SESSION["usu_nom"] = $datos[0]["usu_nom"];
                $_SESSION["usu_email"] = $datos[0]["usu_email"];
                $_SESSION["usu_img"] = $datos[0]["usu_img"];
                $_SESSION["usu_nom_url"] = $datos[0]["usu_nom_url"];

                echo "1";
            }else{
                echo "0";
            }
            break;

        case "insert":
            $datos = $usuario->get_email_usuario($_POST["usu_email_register"]);
            if(is_array($datos) && count($datos)>0){
                echo "0";
            }else{
                $datos1 = $usuario->insert_usuario($_POST["usu_nom_register"],$_POST["usu_email_register"],$_POST["usu_pass_register"],'assets/images/usuario.png');
                if(is_array($datos1) && count($datos1)>0){
                    $datos2 = $usuario->get_id_usuario($datos1[0]["usu_id"]);
                    $_SESSION["usu_id"] = $datos2[0]["usu_id"];
                    $_SESSION["usu_nom"] = $datos2[0]["usu_nom"];
                    $_SESSION["usu_email"] = $datos2[0]["usu_email"];
                    $_SESSION["usu_img"] = $datos2[0]["usu_img"];
                    $_SESSION["usu_nom_url"] = $datos2[0]["usu_nom_url"];
                }
                echo "1";
            }
            break;

        case "mostrar":
            $datos = $usuario->get_id_usuario($_SESSION["usu_id"]);
            if(is_array($datos) && count($datos)>0){
                foreach($datos as $row){
                    $output["usu_id"] = $row["usu_id"];
                    $output["usu_nom"] = $row["usu_nom"];
                    $output["usu_email"] = $row["usu_email"];
                    $output["usu_pais"] = $row["usu_pais"];
                    $output["usu_descrip"] = $row["usu_descrip"];
                    $output["usu_facebook"] = $row["usu_facebook"];
                    $output["usu_instagram"] = $row["usu_instagram"];
                    $output["usu_github"] = $row["usu_github"];
                    $output["usu_web"] = $row["usu_web"];
                    $output["usu_youtube"] = $row["usu_youtube"];
                    $output["usu_img"] = $row["usu_img"];
                    $output["usu_nom_url"] = $row["usu_nom_url"];
                }
                echo json_encode($output);
            }else{
                echo "0";
            }
            break;

        case "update":
            if (!empty($_FILES['file']['name'])){
                $nombreArchivo = uniqid('archivo_') . '_' . $_FILES['file']['name'];
                $archivoTemp = $_FILES['file']['tmp_name'];
                move_uploaded_file($archivoTemp,'../assets/images/'. $nombreArchivo);
                $guardarimg = 'assets/images/'.$nombreArchivo;
            } else {
                $guardarimg = 'assets/images/usuario.png';
            }

            $usuario->update_usuario(
                $_SESSION["usu_id"],
                $_POST["usu_nom_edit"],
                $_POST["usu_descrip_edit"],
                $_POST["usu_facebook_edit"],
                $_POST["usu_instagram_edit"],
                $_POST["usu_github_edit"],
                $_POST["usu_web_edit"],
                $_POST["usu_youtube_edit"],
                $guardarimg
            );
            echo "1";
            break;

        case "password":
            $usuario->update_usuario_password($_SESSION["usu_id"],$_POST["usu_pass"]);
            echo "1";
            break;

        case "eliminar":
            $usuario->delete_usuario($_SESSION["usu_id"]);
            session_destroy();
            echo "1";
            break;

        case "registrargoogle":
            if($_SERVER["REQUEST_METHOD"] === "POST" && $_SERVER["CONTENT_TYPE"] === "application/json"){
                $jsonStr = file_get_contents('php://input');
                $jsonObj = json_decode($jsonStr);

                if(!empty($jsonObj->request_type) && $jsonObj->request_type == 'user_auth'){
                    $credential = !empty($jsonObj->credential) ? $jsonObj->credential : '';

                    $parts = explode(".",$credential);
                    $header = base64_decode($parts[0]);
                    $payload = base64_decode($parts[1]);
                    $signature = base64_decode($parts[2]);

                    $responsePayload = json_decode($payload);

                    if(!empty($responsePayload)){
                        $nombre = !empty($responsePayload->name) ? $responsePayload->name : '';
                        $email = !empty($responsePayload->email) ? $responsePayload->email : '';
                        $picture = !empty($responsePayload->picture) ? $responsePayload->picture : '';
                    }

                    $datos = $usuario->get_email_usuario($email);
                    if(is_array($datos) == true && count($datos) == 0){
                        $datos1 = $usuario->insert_usuario($nombre,$email,"password123456",$picture);

                        $_SESSION["usu_id"] = $datos1[0]["usu_id"];
                        $_SESSION["usu_nom"] =  $nombre;
                        $_SESSION["usu_email"] = $email;
                        $_SESSION["usu_img"] = $picture;
                        $_SESSION["usu_nom_url"] = $datos1[0]["usu_nom_url"];

                        echo "1";
                    }else{
                        $_SESSION["usu_id"] = $datos[0]["usu_id"];
                        $_SESSION["usu_nom"] =  $nombre;
                        $_SESSION["usu_email"] = $email;
                        $_SESSION["usu_img"] = $picture;
                        $_SESSION["usu_nom_url"] = $datos[0]["usu_nom_url"];

                        echo "1";
                    }
                }
            }
            break;
    }
?>