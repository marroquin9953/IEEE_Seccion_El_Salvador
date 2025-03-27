<?php
    require_once("config/conexion.php");
    require_once("models/Pregunta.php");
    require_once("models/Usuario.php");

    $url = $_SERVER['REQUEST_URI'];
    $urlParts = explode('/',$url);

    /* TODO:Verificamos si hay suficientes partes en la URL */
    if(count($urlParts)<5){

    }else{
        $id = $urlParts[3];
        $nom_url = $urlParts[4];

        $pre = new Pregunta();
        $datos = $pre->get_id_titulo_preguntas($id,$nom_url);

        $usuario = new Usuario();
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <base href="/PERSONAL_StackOverflow/">
    <?php require_once("view/html/head.php");?>

    <link rel="stylesheet" href="include/node_modules/@stackoverflow/stacks/dist/css/stacks.css" />
    <link rel="stylesheet" href="include/node_modules/@stackoverflow/stacks-editor/dist/styles.css" />

    <title>AnderCode - <?php echo (!empty($datos) && isset($datos[0]['pre_titulo'])) ? $datos[0]['pre_titulo'] : 'Error'; ?></title>
</head>
<body>

<?php
    require_once("view/html/preloader.php");
    require_once("view/html/header.php");
?>

<section class="user-details-area pt-30px pb-60px">
    <div class="container">
        <div class="row">

            <div class="col-lg-9">
                <div class="question-main-bar mb-50px">
                    <div class="question-highlight">
                        <div class="media media-card shadow-none rounded-0 mb-0 bg-transparent p-0">
                            <div class="media-body">
                                <h5 class="fs-20">
                                    <a href="question-details.html">
                                        <?php echo (!empty($datos) && isset($datos[0]['pre_titulo'])) ? $datos[0]['pre_titulo'] : 'Error'; ?>
                                    </a>
                                </h5>
                                <div class="meta d-flex flex-wrap align-items-center fs-13 lh-20 py-1">
                                    <div class="pe-3">
                                        <?php echo (!empty($datos) && isset($datos[0]['hace'])) ? $datos[0]['hace'] : 'Error'; ?>
                                    </div>
                                    <div class="pe-3">
                                        <span class="pe-1">Vistas</span>
                                        <span class="text-black">89 times</span>
                                    </div>
                                </div>
                                <div class="tags">
                                    <?php
                                        $etiquetas = explode(',' , $datos[0]["etiquetas"]);

                                        foreach ($etiquetas as $etiqueta){
                                            echo '<a href="#" class="tag-link">' . $etiqueta . '</a>';
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="question d-flex">

                        <div class="votes votes-styled w-auto">
                            <div id="vote" class="upvotejs">
                                <a class="upvote upvote-on" data-bs-toggle="tooltip" data-placement="right" title="This question is useful"></a>
                                <span class="count">1</span>
                                <a class="downvote" data-bs-toggle="tooltip" data-placement="right" title="This question is not useful"></a>
                            </div>
                        </div>

                        <div class="question-post-body-wrap flex-grow-1">

                            <div class="question-post-body">
                                <?php echo (!empty($datos) && isset($datos[0]['pre_detalle'])) ? $datos[0]['pre_detalle'] : 'Error'; ?>
                            </div>

                            <div class="question-post-user-action">

                                <div class="post-menu">
                                    <div class="btn-group">
                                        <button class="btn dropdown-toggle after-none" type="button" id="shareDropdownMenu" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Compartir</button>
                                        <div class="dropdown-menu dropdown--menu dropdown--menu-2 mt-2" aria-labelledby="shareDropdownMenu">
                                            <div class="py-3 px-4">
                                                <h4 class="fs-15 pb-2">Compartir el Link de esta pregunta</h4>
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

                                <div class="media media-card user-media owner align-items-center">
                                    <a href="userprofile/<?php echo $datos[0]['usu_id']?>/<?php echo $datos[0]['usu_nom_url']?>" class="media-img d-block">
                                        <img src="<?php echo (!empty($datos) && isset($datos[0]['usu_img'])) ? $datos[0]['usu_img'] : 'assets/images/no-hay-resultados.png'; ?>" alt="avatar">
                                    </a>
                                    <div class="media-body d-flex flex-wrap align-items-center justify-content-between">
                                        <div>
                                            <h5 class="pb-1">
                                                <a href="userprofile/<?php echo $datos[0]['usu_id']?>/<?php echo $datos[0]['usu_nom_url']?>">
                                                    <?php echo (!empty($datos) && isset($datos[0]['usu_nom'])) ? $datos[0]['usu_nom'] : 'Error'; ?>
                                                </a>
                                            </h5>
                                            <div class="stats fs-12 d-flex align-items-center lh-18">
                                                <?php
                                                    $datos2 = $usuario->get_id_usuario_perfil($datos[0]['usu_id']);
                                                ?>
                                                <span class="text-black pe-2" title="Reputacion"><?php echo $datos2[5]['Total'] ?></span>
                                                <span class="pe-2 d-inline-flex align-items-center" title="Preguntas"><span class="ball gold"></span><?php echo $datos2[0]['Total'] ?></span>
                                                <span class="pe-2 d-inline-flex align-items-center" title="Respuestas"><span class="ball silver"></span><?php echo $datos2[1]['Total'] ?></span>
                                                <span class="pe-2 d-inline-flex align-items-center" title="Comentarios"><span class="ball"></span><?php echo $datos2[4]['Total'] ?></span>
                                            </div>
                                        </div>
                                        <small class="meta d-block text-end">
                                            <?php echo (!empty($datos) && isset($datos[0]['hace'])) ? $datos[0]['hace'] : 'Error'; ?>
                                        </small>
                                    </div>
                                </div>

                            </div>

                            <div class="comments-wrap">

                                <ul class="comments-list" id="list_comentario_preguntas">

                                </ul>

                                <div class="comment-form">

                                    <div class="comment-link-wrap text-center">

                                    <?php if(isset($_SESSION['usu_id'])) : ?>
                                        <a class="collapse-btn comment-link" data-bs-toggle="collapse" href="#addCommentCollapse" role="button" aria-expanded="false" aria-controls="addCommentCollapse" title="Utiliza comentarios para solicitar más información o sugerir mejoras. Evita responder preguntas en los comentarios.">Agregar Comentario</a>
                                    <?php else : ?>
                                        <a class="collapse-btn comment-link" href="javascript:void(0)" onclick="mostrarModal()" title="Utiliza comentarios para solicitar más información o sugerir mejoras. Evita responder preguntas en los comentarios.">Agregar Comentario</a>
                                    <?php endif; ?>

                                    </div>
                                    <div class="collapse border-top border-top-gray mt-2 pt-3" id="addCommentCollapse">

                                        <form method="post" id="mnt_comentario_pregunta" class="row pb-3">

                                            <input type="hidden" id="pre_id" name="pre_id" value="<?php echo (!empty($datos) && isset($datos[0]['pre_id'])) ? $datos[0]['pre_id'] : '0'; ?>"/>

                                            <div class="col-lg-12">
                                                <h4 class="fs-16 pb-2">Mensaje</h4>
                                                <div class="divider mb-2"><span></span></div>
                                            </div>

                                            <div class="col-lg-12">
                                                <div class="input-box">
                                                    <div class="form-group">
                                                        <textarea class="form-control form--control form-control-sm fs-13" id="pred_detalle" name="pred_detalle" rows="5" placeholder="Su comentario aqui..."></textarea>
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

                    <div class="subheader d-flex align-items-center justify-content-between">
                        <div class="subheader-title">
                            <h3 class="fs-16">Respuestas</h3>
                        </div>
                    </div>

                    <div id="listpregunta">

                    </div>

                    <div class="subheader">
                        <div class="subheader-title">
                            <h3 class="fs-16">Tu Respuesta</h3>
                        </div>
                    </div>

                    <div class="post-form">
                        <form method="post" id="mnt_respuesta" class="pt-3">
                            <div class="input-box">
                                <label class="fs-14 text-black lh-20 fw-medium">Respuesta Detalle</label>
                                <div class="form-group">
                                    <div id="respuesta-container"></div>
                                </div>
                            </div>

                            <?php if(isset($_SESSION['usu_id'])) : ?>
                                <button class="btn theme-btn theme-btn-sm" type="submit">Publicar tu Respuesta</button>
                            <?php else : ?>
                                <button class="btn theme-btn theme-btn-sm" type="button" onclick="mostrarModal()">Publicar tu Respuesta</button>
                            <?php endif; ?>
                        </form>
                    </div>

                </div>
            </div>

            <div class="col-lg-3">
                <?php require_once("view/html/sidebar.php")?>
            </div>

        </div>
    </div>
</section>

<?php
    require_once("view/html/footer.php");
    require_once("view/html/backtop.php");
    require_once("view/html/loginmodal.php");
    require_once("view/html/signupmodal.php");
    require_once("view/html/recovermodal.php");
    require_once("view/html/js.php");
?>

<script src="//unpkg.com/@highlightjs/cdn-assets@latest/highlight.min.js"></script>
<script src="include/node_modules/@stackoverflow/stacks/dist/js/stacks.min.js"></script>
<script src="include/node_modules/@stackoverflow/stacks-editor/dist/app.bundle.js"></script>

<script type="text/javascript" src="view/js/login.js"></script>
<script type="text/javascript" src="view/js/detailsquestion.js"></script>


</body>
</html>