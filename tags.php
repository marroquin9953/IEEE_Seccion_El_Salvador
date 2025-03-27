<?php
    require_once("config/conexion.php");
    require_once("models/Etiqueta.php");

    $etiqueta = new Etiqueta();

    $currentPage = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $perPage = 8;
    $start = ($currentPage - 1 ) * $perPage;

    $etiquetas = $etiqueta ->get_etiquetas_paginadas($start, $perPage);
    $totalEtiquetas = $etiqueta->get_total_etiquetas();

    $totalPages = ceil($totalEtiquetas / $perPage);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php require_once("view/html/head.php");?>
    <title>AnderCode - Etiquetas</title>
</head>
<body>

<?php
    require_once("view/html/preloader.php");
    require_once("view/html/header.php");
?>

<section class="question-area pt-40px pb-40px">
    <div class="container">
        <div class="filters pb-3">
            <div class="d-flex flex-wrap align-items-center justify-content-between pb-4">
                <div class="pe-3">
                    <h3 class="fs-22 fw-medium">Etiquetas</h3>
                    <p class="fs-15 lh-22 my-2">Una etiqueta es una palabra clave o etiqueta que categoriza tu pregunta con otras preguntas similares.
                        <br> Utilizar las etiquetas adecuadas facilita que otros encuentren y respondan tu pregunta.</p>
                </div>

                <?php
                    if(isset($_SESSION['usu_id'])){
                        echo '<a href="askquestion" class="btn theme-btn theme-btn-sm">Nueva Pregunta</a>';
                    }else{
                        echo '<a class="btn theme-btn theme-btn-sm" onclick="mostrarModal()">Nueva Pregunta</a>';
                    }
                ?>

            </div>
            <div class="d-flex flex-wrap align-items-center justify-content-between">

            </div>
        </div><!-- end filters -->
        <div class="row">

            <?php foreach ($etiquetas as $eti): ?>

            <div class="col-lg-3 responsive-column-half">
                <div class="card card-item">
                    <div class="card-body">
                        <div class="tags pb-1">
                            <a href="#" class="tag-link tag-link-md tag-link-blue"><?php echo $eti["eti_nom"]; ?></a>
                        </div>
                        <p class="card-text fs-14 truncate-4 lh-24 text-black-50">
                            Esta etiqueta se ha utilizado en un total de preguntas.
                        </p>
                        <div class="d-flex tags-info fs-14 pt-3 border-top border-top-gray mt-3">
                            <p class="pe-1 lh-18">Total preguntas:</p>
                            <p class="lh-18"><?php echo $eti["total"]; ?></p>
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
            <p class="fs-13 pt-2">Mostrando <?php echo $start; ?>-<?php echo ($start + $perPage); ?> resultados de <?php echo $totalEtiquetas; ?> etiquetas</p>
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

<script type="text/javascript" src="view/js/tags.js"></script>

</body>
</html>