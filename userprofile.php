<?php
    require_once("config/conexion.php");
    require_once("models/Usuario.php");

    $url = $_SERVER['REQUEST_URI'];
    $urlParts = explode('/',$url);

    /* TODO:Verificamos si hay suficientes partes en la URL */
    if(count($urlParts)<5){

    }else{
        $id = $urlParts[3];
        $nom_url = $urlParts[4];

        $usu = new Usuario();
        $datos = $usu->get_id_nom_usuario($id,$nom_url);
        $datos2 = $usu->get_id_usuario_perfil($id);
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <base href="/PERSONAL_StackOverflow/">
    <?php require_once("view/html/head.php");?>
    <title>AnderCode - Perfil de Usuario</title>
</head>
<body>

<?php require_once("view/html/preloader.php");?>

<?php require_once("view/html/header.php");?>

<section class="hero-area bg-white shadow-sm overflow-hidden pt-60px">
    <span class="stroke-shape stroke-shape-1"></span>
    <span class="stroke-shape stroke-shape-2"></span>
    <span class="stroke-shape stroke-shape-3"></span>
    <span class="stroke-shape stroke-shape-4"></span>
    <span class="stroke-shape stroke-shape-5"></span>
    <span class="stroke-shape stroke-shape-6"></span>
    <div class="container">
        <div class="row">

            <div class="col-lg-8">
                <div class="hero-content">
                    <div class="media media-card align-items-center shadow-none p-0 mb-0 rounded-0 bg-transparent">

                        <div class="media-img media--img">
                            <img src="<?php echo (!empty($datos) && isset($datos[0]['usu_img'])) ? $datos[0]['usu_img'] : 'assets/images/no-hay-resultados.png'; ?>" alt="avatar">
                        </div>

                        <div class="media-body">
                            <h5><?php echo (!empty($datos) && isset($datos[0]['usu_nom'])) ? $datos[0]['usu_nom'] : 'No se encontró perfil del usuario.'; ?></h5>
                            <small class="meta d-block lh-20 pb-2">
                                <span>Miembro desde <?php echo (!empty($datos) && isset($datos[0]['hace'])) ? $datos[0]['hace'] : ''; ?></span>
                            </small>
                            <div class="stats fs-14 fw-medium d-flex align-items-center lh-18">
                                <span class="text-black pe-2" title="Reputacion"><?php echo $datos2[5]['Total'] ?></span>
                                <span class="pe-2 d-inline-flex align-items-center" title="Preguntas"><span class="ball gold"></span><?php echo $datos2[0]['Total'] ?></span>
                                <span class="pe-2 d-inline-flex align-items-center" title="Respuestas"><span class="ball silver"></span><?php echo $datos2[1]['Total'] ?></span>
                                <span class="pe-2 d-inline-flex align-items-center" title="Comentarios"><span class="ball"></span><?php echo $datos2[4]['Total'] ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <ul class="nav nav-tabs generic-tabs generic--tabs generic--tabs-2 mt-4" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="user-profile-tab" data-bs-toggle="tab" href="#user-profile" role="tab" aria-controls="user-profile" aria-selected="true">Perfil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="user-activity-tab" data-bs-toggle="tab" href="#user-activity" role="tab" aria-controls="user-activity" aria-selected="false">Actividades</a>
                    </li>
                </ul>
            </div>

        </div>
    </div>
</section>

<section class="user-details-area pt-30px pb-60px">
    <div class="container">
        <div class="row">
            <div class="col-lg-9">
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="user-profile" role="tabpanel" aria-labelledby="user-profile-tab">
                        <div class="user-panel-main-bar">
                            <div class="user-panel mb-30px">
                                <p class="pb-2"><?php echo (!empty($datos) && isset($datos[0]['usu_descrip'])) ? $datos[0]['usu_descrip'] : 'No se encontró perfil del usuario.'; ?></p>
                            </div><!-- end user-panel -->
                            <div class="user-panel mb-30px pt-30px border-top border-top-gray">
                                <ul class="generic-list-item generic-list-item-bullet">
                                    <li class="ps-3">
                                        <a href="<?php echo (!empty($datos) && isset($datos[0]['usu_facebook'])) ? $datos[0]['usu_facebook'] : 'error.php'; ?>" target="_blank" class="d-inline-block">
                                            <?php echo (!empty($datos) && isset($datos[0]['usu_facebook'])) ? $datos[0]['usu_facebook'] : 'No se encontró perfil del usuario.'; ?>
                                        </a>
                                    </li>
                                    <li class="ps-3">
                                        <a href="<?php echo (!empty($datos) && isset($datos[0]['usu_instagram'])) ? $datos[0]['usu_instagram'] : 'error.php'; ?>" target="_blank" class="d-inline-block">
                                            <?php echo (!empty($datos) && isset($datos[0]['usu_instagram'])) ? $datos[0]['usu_instagram'] : 'No se encontró perfil del usuario.'; ?>
                                        </a>
                                    </li>
                                    <li class="ps-3">
                                        <a href="<?php echo (!empty($datos) && isset($datos[0]['usu_github'])) ? $datos[0]['usu_github'] : 'error.php'; ?>" target="_blank" class="d-inline-block">
                                            <?php echo (!empty($datos) && isset($datos[0]['usu_github'])) ? $datos[0]['usu_github'] : 'No se encontró perfil del usuario.'; ?>
                                        </a>
                                    </li>
                                    <li class="ps-3">
                                        <a href="<?php echo (!empty($datos) && isset($datos[0]['usu_web'])) ? $datos[0]['usu_web'] : 'error.php'; ?>" target="_blank" class="d-inline-block">
                                            <?php echo (!empty($datos) && isset($datos[0]['usu_web'])) ? $datos[0]['usu_web'] : 'No se encontró perfil del usuario.'; ?>
                                        </a>
                                    </li>
                                    <li class="ps-3">
                                        <a href="<?php echo (!empty($datos) && isset($datos[0]['usu_youtube'])) ? $datos[0]['usu_youtube'] : 'error.php'; ?>" target="_blank" class="d-inline-block">
                                            <?php echo (!empty($datos) && isset($datos[0]['usu_youtube'])) ? $datos[0]['usu_youtube'] : 'No se encontró perfil del usuario.'; ?>
                                        </a>
                                    </li>
                                </ul>
                            </div><!-- end user-panel -->

                        </div><!-- end user-panel-main-bar -->
                    </div><!-- end tab-pane -->
                    <div class="tab-pane fade" id="user-activity" role="tabpanel" aria-labelledby="user-activity-tab">
                        <div class="user-panel-main-bar">

                            <div class="user-panel mb-40px">
                                <div class="summary-panel">
                                    <div class="border-bottom border-bottom-gray p-3 d-flex align-items-center justify-content-between">
                                        <h4 class="fs-15 fw-regular">Answers <span>(1,979)</span></h4>
                                        <div class="filter-option-box flex-grow-1 d-flex align-items-center justify-content-end lh-1">
                                            <label class="fs-14 fw-medium me-2 mb-0">Sort</label>
                                            <div class="w-100px">
                                                <select class="select-container">
                                                    <option selected="selected" value="Votes">Votes</option>
                                                    <option value="Activity">Activity</option>
                                                    <option value="Newest">Newest</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="vertical-list">
                                        <div class="item post p-0">
                                            <div class="media media-card media--card align-items-center shadow-none rounded-0 mb-0 bg-transparent">
                                                <div class="votes answered-accepted">
                                                    <div class="vote-block" title="Votes">
                                                        <span class="vote-counts">999k</span>
                                                    </div>
                                                </div>
                                                <div class="media-body">
                                                    <h5 class="fs-15"><a href="question-details.html">How to make Git “forget” about a file that was tracked but is now in .gitignore?</a></h5>
                                                </div>
                                            </div><!-- end media -->
                                        </div><!-- end item -->
                                        <div class="item post p-0">
                                            <div class="media media-card media--card align-items-center shadow-none rounded-0 mb-0 bg-transparent">
                                                <div class="votes answered-accepted">
                                                    <div class="vote-block" title="Votes">
                                                        <span class="vote-counts">4714</span>
                                                    </div>
                                                </div>
                                                <div class="media-body">
                                                    <h5 class="fs-15"><a href="question-details.html">Undoing a git rebase</a></h5>
                                                </div>
                                            </div><!-- end media -->
                                        </div><!-- end item -->
                                        <div class="item post p-0">
                                            <div class="media media-card media--card align-items-center shadow-none rounded-0 mb-0 bg-transparent">
                                                <div class="votes answered-accepted">
                                                    <div class="vote-block" title="Votes">
                                                        <span class="vote-counts">4448</span>
                                                    </div>
                                                </div>
                                                <div class="media-body">
                                                    <h5 class="fs-15"><a href="question-details.html">Difference between “git add -A” and “git add .”</a></h5>
                                                </div>
                                            </div><!-- end media -->
                                        </div><!-- end item -->
                                        <div class="item post p-0">
                                            <div class="media media-card media--card align-items-center shadow-none rounded-0 mb-0 bg-transparent">
                                                <div class="votes answered-accepted">
                                                    <div class="vote-block" title="Votes">
                                                        <span class="vote-counts">3275</span>
                                                    </div>
                                                </div>
                                                <div class="media-body">
                                                    <h5 class="fs-15"><a href="question-details.html">How to find and restore a deleted file in a Git repository</a></h5>
                                                </div>
                                            </div><!-- end media -->
                                        </div><!-- end item -->
                                        <div class="item post p-0">
                                            <div class="media media-card media--card align-items-center shadow-none rounded-0 mb-0 bg-transparent">
                                                <div class="votes answered-accepted">
                                                    <div class="vote-block" title="Votes">
                                                        <span class="vote-counts">2822</span>
                                                    </div>
                                                </div>
                                                <div class="media-body">
                                                    <h5 class="fs-15"><a href="question-details.html">Branch from a previous commit using Git</a></h5>
                                                </div>
                                            </div><!-- end media -->
                                        </div><!-- end item -->
                                        <div class="pager pt-30px">
                                            <nav aria-label="Page navigation example">
                                                <ul class="pagination generic-pagination generic--pagination">
                                                    <li class="page-item">
                                                        <a class="page-link" href="#" aria-label="Previous">
                                                            <span aria-hidden="true"><i class="la la-arrow-left"></i></span>
                                                            <span class="sr-only">Previous</span>
                                                        </a>
                                                    </li>
                                                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                                                    <li class="page-item active"><a class="page-link" href="#">2</a></li>
                                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                                    <li class="page-item"><a class="page-link" href="#">4</a></li>
                                                    <li class="page-item">
                                                        <a class="page-link" href="#" aria-label="Next">
                                                            <span aria-hidden="true"><i class="la la-arrow-right"></i></span>
                                                            <span class="sr-only">Next</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </nav>
                                            <p class="fs-13 pt-2">Showing 1-5 of (1,979) results</p>
                                        </div>
                                    </div>
                                </div><!-- end summary-panel -->
                            </div><!-- end user-panel -->
                            <div class="user-panel mb-40px">
                                <div class="bg-gray p-3 rounded-rounded d-flex align-items-center justify-content-between">
                                    <h3 class="fs-17">Questions <span>(50)</span></h3>
                                    <div class="filter-option-box flex-grow-1 d-flex align-items-center justify-content-end lh-1">
                                        <label class="fs-14 fw-medium me-2 mb-0">Sort</label>
                                        <div class="w-100px">
                                            <select class="select-container">
                                                <option selected="selected" value="Votes">Votes</option>
                                                <option value="Activity">Activity</option>
                                                <option value="Newest">Newest</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="summary-panel">
                                    <div class="vertical-list">
                                        <div class="item post p-0">
                                            <div class="media media-card media--card align-items-center shadow-none rounded-0 mb-0 bg-transparent">
                                                <div class="votes answered-accepted">
                                                    <div class="vote-block" title="Votes">
                                                        <span class="vote-counts">2653</span>
                                                    </div>
                                                </div>
                                                <div class="media-body">
                                                    <h5 class="fs-15"><a href="question-details.html">What are the correct version numbers for C#?</a></h5>
                                                </div>
                                            </div><!-- end media -->
                                        </div><!-- end item -->
                                        <div class="item post p-0">
                                            <div class="media media-card media--card align-items-center shadow-none rounded-0 mb-0 bg-transparent">
                                                <div class="votes">
                                                    <div class="vote-block" title="Votes">
                                                        <span class="vote-counts">563</span>
                                                    </div>
                                                </div>
                                                <div class="media-body">
                                                    <h5 class="fs-15"><a href="question-details.html">Curious null-coalescing operator custom implicit conversion behaviour</a></h5>
                                                </div>
                                            </div><!-- end media -->
                                        </div><!-- end item -->
                                        <div class="item post p-0">
                                            <div class="media media-card media--card align-items-center shadow-none rounded-0 mb-0 bg-transparent">
                                                <div class="votes answered-accepted">
                                                    <div class="vote-block" title="Votes">
                                                        <span class="vote-counts">363</span>
                                                    </div>
                                                </div>
                                                <div class="media-body">
                                                    <h5 class="fs-15"><a href="question-details.html">What's your most controversial programming opinion?</a></h5>
                                                </div>
                                            </div><!-- end media -->
                                        </div><!-- end item -->
                                        <div class="item post p-0">
                                            <div class="media media-card media--card align-items-center shadow-none rounded-0 mb-0 bg-transparent">
                                                <div class="votes answered-accepted">
                                                    <div class="vote-block" title="Votes">
                                                        <span class="vote-counts">336</span>
                                                    </div>
                                                </div>
                                                <div class="media-body">
                                                    <h5 class="fs-15"><a href="question-details.html">Performance surprise with “as” and nullable types</a></h5>
                                                </div>
                                            </div><!-- end media -->
                                        </div><!-- end item -->
                                        <div class="item post p-0">
                                            <div class="media media-card media--card align-items-center shadow-none rounded-0 mb-0 bg-transparent">
                                                <div class="votes answered-accepted">
                                                    <div class="vote-block" title="Votes">
                                                        <span class="vote-counts">322</span>
                                                    </div>
                                                </div>
                                                <div class="media-body">
                                                    <h5 class="fs-15"><a href="question-details.html">What's the strangest corner case you've seen in C# or .NET? [closed]</a></h5>
                                                </div>
                                            </div><!-- end media -->
                                        </div><!-- end item -->
                                        <div class="pager pt-30px">
                                            <nav aria-label="Page navigation example">
                                                <ul class="pagination generic-pagination generic--pagination">
                                                    <li class="page-item">
                                                        <a class="page-link" href="#" aria-label="Previous">
                                                            <span aria-hidden="true"><i class="la la-arrow-left"></i></span>
                                                            <span class="sr-only">Previous</span>
                                                        </a>
                                                    </li>
                                                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                                                    <li class="page-item active"><a class="page-link" href="#">2</a></li>
                                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                                    <li class="page-item"><a class="page-link" href="#">4</a></li>
                                                    <li class="page-item">
                                                        <a class="page-link" href="#" aria-label="Next">
                                                            <span aria-hidden="true"><i class="la la-arrow-right"></i></span>
                                                            <span class="sr-only">Next</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </nav>
                                            <p class="fs-13 pt-2">Showing 1-5 of (50) results</p>
                                        </div>
                                    </div>
                                </div><!-- end summary-panel -->
                            </div><!-- end user-panel -->
                        </div><!-- end user-panel-main-bar -->
                    </div><!-- end tab-pane -->
                </div>
            </div>
            <div class="col-lg-3">
                <?php require_once("view/html/sidebar.php")?>
            </div>
        </div>
    </div>
</section>

<?php require_once("view/html/footer.php")?>

<?php require_once("view/html/backtop.php")?>

<?php require_once("view/html/loginmodal.php")?>

<?php require_once("view/html/signupmodal.php")?>

<?php require_once("view/html/recovermodal.php")?>

<?php require_once("view/html/js.php")?>

<script type="text/javascript" src="view/js/login.js"></script>

</body>
</html>