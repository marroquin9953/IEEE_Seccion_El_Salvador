<?php
    require_once("config/conexion.php");
    require_once("models/Categoria.php");

    $categoria = new Categoria();

    $currentPage = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $perPage = 8;
    $start = ($currentPage - 1 ) * $perPage;

    $categorias = $categoria ->get_categorias_paginadas($start, $perPage);
    $totalCategorias = $categoria->get_total_categorias();

    $totalPages = ceil($totalCategorias / $perPage);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php require_once("view/html/head.php");?>
    <title>AnderCode - Categorias</title>
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
                <h3 class="fs-22 fw-medium">Categorias</h3>

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
        </div>
        <div class="row">
            <?php foreach ($categorias as $cat): ?>

            <div class="col-lg-6 responsive-column-half">
                <div class="media media-card p-3 align-items-center hover-y">
                    <div class="icon-element shadow-sm flex-shrink-0 me-3 border border-gray">
                        <svg class="svg-icon-color-gray" height="32" viewbox="0 0 512 512" width="32" xmlns="http://www.w3.org/2000/svg"><g><g><path d="m163.685 407.141-.085.085c-2.938 2.92-2.951 7.669-.03 10.606 1.466 1.474 3.392 2.212 5.318 2.212 1.912 0 3.825-.727 5.288-2.182l.085-.085c2.938-2.92 2.951-7.669.03-10.606-2.919-2.937-7.668-2.951-10.606-.03z"></path><path d="m224.896 383.146-.085.085c-2.929 2.929-2.929 7.678 0 10.606 1.464 1.464 3.384 2.197 5.303 2.197s3.839-.732 5.303-2.197l.085-.085c2.929-2.929 2.929-7.678 0-10.606-2.928-2.929-7.677-2.929-10.606 0z"></path><path d="m234.213 258.792c0-15.045-12.24-27.286-27.286-27.286-15.061 0-27.313 12.24-27.313 27.286 0 15.061 12.253 27.314 27.313 27.314 15.046 0 27.286-12.253 27.286-27.314zm-39.599 0c0-6.774 5.524-12.286 12.313-12.286 6.774 0 12.286 5.511 12.286 12.286 0 6.79-5.511 12.314-12.286 12.314-6.789 0-12.313-5.524-12.313-12.314z"></path><path d="m284.709 393.223c-20.875 0-37.858 16.983-37.858 37.859 0 20.891 16.983 37.887 37.858 37.887 20.891 0 37.886-16.996 37.886-37.887 0-20.875-16.995-37.859-37.886-37.859zm0 60.747c-12.604 0-22.858-10.267-22.858-22.887 0-12.604 10.254-22.859 22.858-22.859 12.62 0 22.886 10.255 22.886 22.859 0 12.62-10.266 22.887-22.886 22.887z"></path><path d="m113.529 422.137c-14.326 0-25.981 11.643-25.981 25.954 0 14.327 11.655 25.982 25.981 25.982s25.981-11.655 25.981-25.982c0-14.312-11.655-25.954-25.981-25.954zm0 36.935c-6.055 0-10.981-4.926-10.981-10.982 0-6.04 4.926-10.954 10.981-10.954s10.981 4.914 10.981 10.954c0 6.056-4.926 10.982-10.981 10.982z"></path><path d="m404.722 387.2-.085.085c-2.929 2.929-2.929 7.678 0 10.606 1.464 1.464 3.384 2.197 5.303 2.197s3.839-.732 5.303-2.197l.085-.085c2.929-2.929 2.929-7.678 0-10.606-2.928-2.929-7.677-2.929-10.606 0z"></path><path d="m420.725 444.473-.085.085c-2.938 2.92-2.951 7.669-.03 10.606 1.466 1.474 3.392 2.212 5.318 2.212 1.912 0 3.825-.727 5.288-2.182l.085-.085c2.938-2.92 2.951-7.669.03-10.606-2.92-2.937-7.669-2.951-10.606-.03z"></path><path d="m421.534 353.968c13.873 0 25.16-11.287 25.16-25.16 0-13.889-11.287-25.188-25.16-25.188-13.889 0-25.188 11.299-25.188 25.188 0 13.873 11.299 25.16 25.188 25.16zm0-35.348c5.602 0 10.16 4.57 10.16 10.188 0 5.602-4.558 10.16-10.16 10.16-5.617 0-10.188-4.558-10.188-10.16 0-5.618 4.57-10.188 10.188-10.188z"></path><path d="m472.925 36.227h-102.782c-15.624 0-28.334 13.436-28.334 29.95 0 14.527 9.855 26.664 22.875 29.359v247.84l-78.598-103.496c-10.075-13.249-20.527-40.372-20.58-62.83l-.293-117.325c15.133-1.489 26.995-14.286 26.995-29.804.001-16.498-13.435-29.921-29.949-29.921h-110.69c-16.515 0-29.95 13.423-29.95 29.922 0 15.517 11.863 28.315 26.995 29.804v117.324c-.052 22.436-10.786 49.569-20.848 62.834l-25.058 32.996c-2.505 3.299-1.861 8.004 1.437 10.509 1.356 1.03 2.95 1.528 4.531 1.528 2.265 0 4.503-1.022 5.978-2.964l25.061-33c11.003-14.506 22.699-43.238 23.553-69.089h25.462c4.142 0 7.5-3.358 7.5-7.5s-3.358-7.5-7.5-7.5h-25.379l.063-24.997h25.317c4.142 0 7.5-3.358 7.5-7.5s-3.358-7.5-7.5-7.5h-25.279l.063-24.997h25.216c4.142 0 7.5-3.358 7.5-7.5s-3.358-7.5-7.5-7.5h-25.179l.063-24.997h86.6v117.208c.062 26.573 12.519 56.87 23.93 71.875l52.917 69.681c-17.871-5.739-35.407-6.694-53.721-3.063-19.13 3.791-37.225 12.075-56.797 22.25-39.41-28.311-98.047-22.141-137.213-8.94l14.663-19.092c2.523-3.285 1.905-7.994-1.38-10.517-3.287-2.522-7.994-1.905-10.517 1.38l-45.526 59.277c-11.658 15.199-20.404 36.102-23.996 57.349-3.869 22.885-1.571 44.467 6.47 60.769 7.64 15.488 24.12 33.95 59.25 33.95h257.238c18.876 0 34.649-5.623 46.191-16.317 10.264 10.083 24.32 16.317 39.81 16.317 31.347 0 56.85-25.503 56.85-56.852v-250.951c0-4.142-3.358-7.5-7.5-7.5s-7.5 3.358-7.5 7.5v48.215c-11.265 5.47-27.619 4.862-37.687-1.871-12.654-8.445-30.919-10.281-46.013-5.509v-28.914h25.098c4.142 0 7.5-3.358 7.5-7.5s-3.358-7.5-7.5-7.5h-25.098v-25.025h25.098c4.142 0 7.5-3.358 7.5-7.5s-3.358-7.5-7.5-7.5h-25.098v-24.997h25.098c4.142 0 7.5-3.358 7.5-7.5s-3.358-7.5-7.5-7.5h-25.098v-24.996h83.7v73.486c0 4.142 3.358 7.5 7.5 7.5s7.5-3.358 7.5-7.5v-74.049c13.02-2.695 22.875-14.833 22.875-29.359 0-16.515-12.711-29.951-28.334-29.951zm-321.356 8.646c-8.244 0-14.95-6.707-14.95-14.951 0-8.228 6.707-14.922 14.95-14.922h110.69c8.244 0 14.95 6.694 14.95 14.922 0 8.244-6.707 14.951-14.95 14.951zm-103.098 324.192 12.11-15.767c30.111-17.327 97.718-32.201 140.776-7.43-.563.302-1.119.599-1.686.902-43.488 23.296-92.546 49.548-166.947 52.625 3.967-11.503 9.407-22.065 15.747-30.33zm287.062 127.935h-257.238c-22.015 0-37.423-8.608-45.797-25.585-7.858-15.93-8.299-36.906-4.008-56.862 80.632-2.283 134.661-31.202 178.263-54.559 50.111-26.844 86.429-46.289 139.046-16.681l18.884 24.866v86.97c0 10.452 2.848 20.247 7.789 28.671-8.845 8.75-21.242 13.18-36.939 13.18zm81.831-233.986c8.081 5.404 18.454 8.106 28.834 8.105 5.865 0 11.731-.865 17.185-2.591v186.62c0 23.077-18.774 41.852-41.85 41.852s-41.85-18.774-41.85-41.852v-194.001c11.258-5.462 27.611-4.854 37.681 1.867zm55.561-181.914h-102.782c-7.353 0-13.334-6.694-13.334-14.922 0-8.244 5.982-14.95 13.334-14.95h102.782c7.353 0 13.334 6.707 13.334 14.95 0 8.227-5.982 14.922-13.334 14.922z"></path></g></g></svg>
                    </div>
                    <div class="media-body">
                        <h5 class="fs-19 fw-medium mb-1"><a href="category.html"><?php echo $cat["cat_nom"]; ?></a></h5>
                        <p class="fw-medium fs-15 text-black-50 lh-18"><?php echo $cat["total"]; ?></p>
                    </div>
                </div>
            </div>

            <?php endforeach; ?>

        </div>

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
            <p class="fs-13 pt-2">Mostrando <?php echo $start; ?>-<?php echo ($start + $perPage); ?> resultados de <?php echo $totalCategorias; ?> categorias</p>
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

<script type="text/javascript" src="view/js/category.js"></script>

</body>
</html>