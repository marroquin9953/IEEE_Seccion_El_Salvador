<?php
    require_once("config/conexion.php");
    require_once("models/Usuario.php");

    $usuario = new Usuario();

    $currentPage = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $perPage = 12;
    $start = ($currentPage - 1 ) * $perPage;

    $usuarios = $usuario ->get_usuarios_paginadas($start, $perPage);
    $totalUsuarios = $usuario->get_total_usuarios();

    $totalPages = ceil($totalUsuarios / $perPage);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php require_once("view/html/head.php");?>
    <title>AnderCode - Usuarios</title>
</head>
<body>

<?php
    require_once("view/html/preloader.php");
    require_once("view/html/header.php");
?>

<section class="question-area pt-40px pb-40px">
    <div class="container">
        <div class="filters pb-3">
            <div class="d-flex flex-wrap align-items-center justify-content-between pb-3">
                <h3 class="fs-22 fw-medium">Usuarios</h3>

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

            <?php foreach ($usuarios as $usu): ?>

            <div class="col-lg-3 responsive-column-half">
                <div class="media media-card p-3">
                    <a href="userprofile/<?php echo $usu["usu_id"]; ?>/<?php echo $usu["usu_nom_url"]; ?>" class="media-img d-inline-block flex-shrink-0">
                        <img src="<?php echo $usu["usu_img"]; ?>" alt="company logo">
                    </a>
                    <div class="media-body">
                        <h5 class="fs-16 fw-medium">
                            <a href="userprofile/<?php echo $usu["usu_id"]; ?>/<?php echo $usu["usu_nom_url"]; ?>">
                            <?php echo $usu["usu_nom"]; ?>
                            </a>
                        </h5>
                    </div>
                </div>
            </div>

            <?php endforeach; ?>

        </div><!-- end row -->
        <div class="pager pt-20px">
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
            <p class="fs-13 pt-2">Mostrando <?php echo $start; ?>-<?php echo ($start + $perPage); ?> resultados de <?php echo $totalUsuarios; ?> usuarios</p>

        </div>
    </div><!-- end container -->
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

<script type="text/javascript" src="view/js/userlist.js"></script>

</body>
</html>