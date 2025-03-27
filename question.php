<?php
    require_once("config/conexion.php");
    require_once("models/Pregunta.php");
    require_once("models/Usuario.php");

    $pregunta = new Pregunta();
    $usuario = new Usuario();

    $currentPage = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $perPage = 10;
    $start = ($currentPage - 1 ) * $perPage;

    /* TODO:Validar parametro de busqueda */
    $search = isset($_GET['search']) ? $_GET['search'] : '';

    if(!empty($search)){
        /* TODO: Obtener preguntas paginadas con filtro de búsqueda */
        $preguntas = $pregunta->get_preguntas_paginadas_con_busqueda($start, $perPage, $search);
        /* TODO: Obtener el total de preguntas filtradas para calcular el número total de páginas */
        $totalPreguntas = $pregunta->get_total_preguntas_con_busqueda($search);
    }else{
        /* TODO: Obtener preguntas para la página actual */
        $preguntas = $pregunta ->get_preguntas_paginadas($start, $perPage);
        /* TODO: Obtener el total de preguntas para calcular el número total de páginas */
        $totalPreguntas = $pregunta->get_total_preguntas();
    }

    $totalPages = ceil($totalPreguntas / $perPage);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php require_once("view/html/head.php");?>
    <title>AnderCode - Preguntas</title>
</head>
<body>

<?php
    require_once("view/html/preloader.php");
    require_once("view/html/header.php");
?>

<section class="question-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-2 pr-0">
                <?php require_once("view/html/menu.php")?>
            </div>
            <div class="col-lg-7 px-0">
                <div class="question-main-bar border-left border-left-gray pt-40px pb-40px">
                    <div class="filters pb-4 ps-3">
                        <div class="d-flex flex-wrap align-items-center justify-content-between pb-3">
                            <h3 class="fs-22 fw-medium">Todos los eventos</h3>

                            <?php
                                if(isset($_SESSION['usu_id'])){
                                    echo '<a href="askquestion" class="btn theme-btn theme-btn-sm">Nuevo evento</a>';
                                }else{
                                    echo '<a class="btn theme-btn theme-btn-sm" onclick="mostrarModal()">Nuevo evento</a>';
                                }
                            ?>

                        </div>
                        <div class="d-flex flex-wrap align-items-center justify-content-between">
                            <p class="pt-1 fs-15 fw-medium lh-20">
                                <?php echo $totalPreguntas; ?> Eventos
                            </p>
                        </div>
                    </div>
                    <div class="questions-snippet border-top border-top-gray">

                        <?php foreach ($preguntas as $pre): ?>

                        <div class="media media-card rounded-0 shadow-none mb-0 bg-transparent p-3 border-bottom border-bottom-gray">
                            <div class="votes text-center votes-2">
                                <div class="vote-block">
                                    <span class="vote-counts d-block text-center pr-0 lh-20 fw-medium">3</span>
                                    <span class="vote-text d-block fs-13 lh-18">votes</span>
                                </div>
                                <div class="answer-block answered my-2">
                                    <span class="answer-counts d-block lh-20 fw-medium">3</span>
                                    <span class="answer-text d-block fs-13 lh-18">answers</span>
                                </div>
                                <div class="view-block">
                                    <span class="view-counts d-block lh-20 fw-medium">12</span>
                                    <span class="view-text d-block fs-13 lh-18">views</span>
                                </div>
                            </div>
                            <div class="media-body">
                                <h5 class="mb-2 fw-medium">
                                    <a href="detailsquestion/<?php echo $pre["pre_id"]; ?>/<?php echo $pre["pre_titulo_url"]; ?>">
                                        <?php
                                            $search = str_replace('%', '',$search);
                                            $palabrasBuscadas = explode(' ',$search);

                                            $titulo = $pre["pre_titulo"];

                                            foreach ($palabrasBuscadas as $palabra){
                                                $titulo = str_ireplace($palabra,'<span style="background-color: yellow;">'.$palabra.'</span>', $titulo);
                                            }

                                            echo $titulo;
                                        ?>
                                    </a>
                                </h5>
                                <p class="mb-2 truncate lh-20 fs-15">
                                    <?php
                                        $search = str_replace('%', '',$search);
                                        $palabrasBuscadas = explode(' ',$search);

                                        $detalle = $pre["pre_detalle"];

                                        foreach ($palabrasBuscadas as $palabra){
                                            $detalle = str_ireplace($palabra,'<span style="background-color: yellow;">'.$palabra.'</span>', $detalle);
                                        }

                                        echo $detalle;
                                    ?>
                                </p>
                                <div class="tags">
                                    <?php
                                        $etiquetas = explode(',' , $pre["etiquetas"]);

                                        foreach ($etiquetas as $etiqueta){
                                            echo '<a href="#" class="tag-link">' . $etiqueta . '</a>';
                                        }
                                    ?>
                                </div>
                                <div class="media media-card user-media align-items-center px-0 border-bottom-0 pb-0">
                                    <a href="userprofile/<?php echo $pre["usu_id"]; ?>/<?php echo $pre["usu_nom_url"]; ?>" class="media-img d-block">
                                        <img src="<?php echo $pre["usu_img"]; ?>" alt="avatar">
                                    </a>
                                    <div class="media-body d-flex flex-wrap align-items-center justify-content-between">
                                        <div>
                                            <h5 class="pb-1"><a href="userprofile/<?php echo $pre["usu_id"]; ?>/<?php echo $pre["usu_nom_url"]; ?>"><?php echo $pre["usu_nom"]; ?></a></h5>
                                            <div class="stats fs-12 d-flex align-items-center lh-18">
                                                <?php
                                                    $datos2 = $usuario->get_id_usuario_perfil($pre["usu_id"]);
                                                ?>
                                                <span class="text-black pe-2" title="Reputacion"><?php echo $datos2[5]['Total'] ?></span>
                                                <span class="pe-2 d-inline-flex align-items-center" title="Preguntas"><span class="ball gold"></span><?php echo $datos2[0]['Total'] ?></span>
                                                <span class="pe-2 d-inline-flex align-items-center" title="Respuestas"><span class="ball silver"></span><?php echo $datos2[1]['Total'] ?></span>
                                                <span class="pe-2 d-inline-flex align-items-center" title="Comentarios"><span class="ball"></span><?php echo $datos2[4]['Total'] ?></span>
                                            </div>
                                        </div>
                                        <small class="meta d-block text-end">
                                            <span class="text-black d-block lh-18">pregunta</span>
                                            <span class="d-block lh-18 fs-12"><?php echo $pre["hace"]; ?></span>
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php endforeach; ?>

                    </div>

                    <div class="pager pt-30px px-3">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination generic-pagination pe-1">

                                <li class="page-item">
                                    <a class="page-link" href="?page=<?php echo $currentPage > 1 ? $currentPage - 1 : 1; ?>" aria-label="Previous">
                                        <span aria-hidden="true"><i class="la la-arrow-left"></i></span>
                                        <span class="sr-only">Anterior</span>
                                    </a>
                                </li>

                                <?php
                                    //TODO: Límite de páginas a mostrar inicialmente
                                    $numPagesToShow = 5;

                                    //TODO: Calcular el rango de páginas a mostrar
                                    $startPage = max(1,$currentPage - floor($numPagesToShow / 2));
                                    $endPage = min($totalPages, $startPage + $numPagesToShow - 1);

                                    //TODO: Mostrar puntos suspensivos si hay páginas anteriores disponibles
                                    if($startPage > 1){
                                        echo '<li class="page-item"><span class="page-link">...</span></li>';
                                    }

                                    //TODO: Mostrar las Paginas
                                    for($i = $startPage; $i <= $endPage; $i++){
                                        echo '<li class="page-item '. ($i == $currentPage ? 'active' : '') .'"><a class="page-link" href="?page=' . $i . (isset($_GET['search']) ? '&search=' . urlencode($_GET['search']) : '') . '">' . $i . '</a></li>';
                                    }

                                    //TODO: Mostrar puntos suspensivos si hay páginas posteriores disponibles
                                    if($endPage < $totalPages){
                                        echo '<li class="page-item"><span class="page-link">...</span></li>';
                                    }
                                ?>

                                <li class="page-item">
                                    <a class="page-link" href="?page=<?php echo $currentPage < $totalPages ? $currentPage + 1 : $totalPages; ?>" aria-label="Next">
                                        <span aria-hidden="true"><i class="la la-arrow-right"></i></span>
                                        <span class="sr-only">Siguiente</span>
                                    </a>
                                </li>

                            </ul>
                        </nav>
                        <p class="fs-13 pt-2">Mostrando <?php echo $start; ?>-<?php echo ($start + $perPage); ?> resultados de <?php echo $totalPreguntas; ?> preguntas</p>
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
    require_once("view/html/ctaarea.php");
    require_once("view/html/footer.php");
    require_once("view/html/backtop.php");
    require_once("view/html/loginmodal.php");
    require_once("view/html/signupmodal.php");
    require_once("view/html/recovermodal.php");
    require_once("view/html/js.php");
?>

<script type="text/javascript" src="view/js/login.js"></script>
<script type="text/javascript" src="view/js/question.js"></script>

</body>
</html>