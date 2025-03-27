<?php
    require_once("../config/conexion.php");
    require_once("../models/Respuesta.php");
    require_once("../models/Comentario.php");
    require_once("../models/Usuario.php");

    $respuesta = new Respuesta();
    $comentario = new Comentario();
    $usuario = new Usuario();

    switch($_GET["op"]){

        case "insert":
            $datos = $respuesta->insert_respuesta($_POST["pre_id"],$_SESSION["usu_id"],$_POST["resp_detalle"]);
            echo json_encode($datos);
            break;

        case "listar":
            $datos = $respuesta->get_pre_id_respuesta($_POST["pre_id"]);
            if(is_array($datos)==true and count($datos)>0){
                ?>
                    <?php foreach($datos as $row):?>
                        <div class="answer-wrap d-flex">

                            <div class="votes votes-styled w-auto">
                                <div id="vote2" class="upvotejs">
                                    <a class="upvote upvote-on" data-bs-toggle="tooltip" data-placement="right" title="This question is useful"></a>
                                    <span class="count">0</span>
                                    <a class="downvote" data-bs-toggle="tooltip" data-placement="right" title="This question is not useful"></a>
                                </div>
                            </div>

                            <div class="answer-body-wrap flex-grow-1">
                                <div class="answer-body">
                                    <?php echo $row["resp_detalle"]; ?>
                                </div>

                                <div class="question-post-user-action">

                                    <div class="post-menu">
                                        <div class="btn-group">
                                            <button class="btn dropdown-toggle after-none" type="button" id="shareDropdownMenuTwo" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Compartir</button>
                                            <div class="dropdown-menu dropdown--menu dropdown--menu-2 mt-2" aria-labelledby="shareDropdownMenuTwo">
                                                <div class="py-3 px-4">
                                                    <h4 class="fs-15 pb-2">Compartir esta pregunta</h4>
                                                    <form action="#" class="copy-to-clipboard">
                                                        <span class="text-success-message">Link Copiado!</span>
                                                        <input type="text" class="form-control form--control form-control-sm copy-input" value="https://Disilab.com/q/66552850/15319675">
                                                        <div class="btn-box pt-2 d-flex align-items-center justify-content-between">
                                                            <a href="#" class="btn-text copy-btn">Copiar Link</a>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <a href="#" class="btn">Editar</a>
                                    </div>

                                    <div class="media media-card user-media align-items-center">
                                        <a href="userprofile/<?php echo $row["usu_id"]; ?>/<?php echo $row["usu_nom_url"]; ?>" class="media-img d-block">
                                            <img src="<?php echo $row["usu_img"]; ?>" alt="avatar">
                                        </a>
                                        <div class="media-body d-flex align-items-center justify-content-between">
                                            <div>
                                                <h5 class="pb-1">
                                                    <a href="userprofile/<?php echo $row["usu_id"]; ?>/<?php echo $row["usu_nom_url"]; ?>">
                                                        <?php echo $row["usu_nom"]; ?>
                                                    </a>
                                                </h5>
                                                <div class="stats fs-12 d-flex align-items-center lh-18">
                                                    <?php
                                                        $datos2 = $usuario->get_id_usuario_perfil($row["usu_id"]);
                                                    ?>
                                                    <span class="text-black pe-2" title="Reputacion"><?php echo $datos2[5]['Total'] ?></span>
                                                    <span class="pe-2 d-inline-flex align-items-center" title="Preguntas"><span class="ball gold"></span><?php echo $datos2[0]['Total'] ?></span>
                                                    <span class="pe-2 d-inline-flex align-items-center" title="Respuestas"><span class="ball silver"></span><?php echo $datos2[1]['Total'] ?></span>
                                                    <span class="pe-2 d-inline-flex align-items-center" title="Comentarios"><span class="ball"></span><?php echo $datos2[4]['Total'] ?></span>
                                                </div>
                                            </div>
                                            <small class="meta d-block text-end">
                                                <span class="text-black d-block lh-18">Respuesta</span>
                                                <span class="d-block lh-18 fs-12"><?php echo $row["hace"]; ?></span>
                                            </small>
                                        </div>
                                    </div>
                                </div>

                                <div class="comments-wrap">
                                    <ul class="comments-list" id="list_comentario_respuesta">

                                        <?php
                                            $datos2 = $comentario->get_comentario_respuesta($row["resp_id"]);
                                            foreach($datos2 as $row2):
                                        ?>

                                        <li>
                                            <div class="comment-body">
                                                <span class="comment-copy"><?php echo $row2["respd_detalle"]; ?></span>
                                                <span class="comment-separated"> - </span>
                                                <a href="userprofile/<?php echo $row2["usu_id"]; ?>/<?php echo $row2["usu_nom_url"]; ?>" class="comment-user owner" title="Reputación"><?php echo $row2["usu_nom"]; ?></a>
                                                <span class="comment-separated"> - </span>
                                                <a href="javascript:void(0)" class="comment-date"><?php echo $row2["hace"]; ?></a>
                                            </div>
                                        </li>

                                        <?php endforeach; ?>

                                    </ul>

                                    <div class="comment-form">
                                        <div class="comment-link-wrap text-center">

                                            <?php if(isset($_SESSION['usu_id'])) : ?>
                                                <a class="collapse-btn comment-link" data-bs-toggle="collapse" href="#addCommentCollapseTwo<?php echo $row["resp_id"]; ?>" role="button" aria-expanded="false" aria-controls="addCommentCollapseTwo" title="Utiliza comentarios para solicitar más información o sugerir mejoras. Evita responder preguntas en los comentarios.">Agregar Comentario</a>
                                            <?php else : ?>
                                                <a class="collapse-btn comment-link" href="javascript:void(0)" onclick="mostrarModal()" title="Utiliza comentarios para solicitar más información o sugerir mejoras. Evita responder preguntas en los comentarios.">Agregar Comentario</a>
                                            <?php endif; ?>

                                        </div>
                                        <div class="collapse border-top border-top-gray mt-2 pt-3" id="addCommentCollapseTwo<?php echo $row["resp_id"]; ?>">

                                            <form method="post" class="mnt_comentario_respuesta row pb-3">

                                                <input type="hidden" id="resp_id" name="resp_id" value="<?php echo $row["resp_id"]; ?>"/>

                                                <div class="col-lg-12">
                                                    <h4 class="fs-16 pb-2">Mensaje</h4>
                                                    <div class="divider mb-2"><span></span></div>
                                                </div>

                                                <div class="col-lg-12">
                                                    <div class="input-box">
                                                        <div class="form-group">
                                                            <textarea class="form-control form--control form-control-sm fs-13" id="respd_detalle" name="respd_detalle" rows="5" placeholder="Su comentario aqui..."></textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-12">
                                                    <div class="input-box d-flex flex-wrap align-items-center justify-content-between">
                                                        <button class="btn theme-btn theme-btn-sm theme-btn-outline theme-btn-outline-gray" type="submit">Agregar Comentario</button>
                                                    </div>
                                                </div>

                                            </form>

                                        </div>
                                    </div>

                                </div>

                            </div>

                        </div>
                    <?php endforeach; ?>
                <?php
            }
            break;

    }
?>