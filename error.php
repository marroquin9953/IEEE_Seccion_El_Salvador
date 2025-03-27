<!DOCTYPE html>
<html lang="es">
<head>
    <?php require_once("view/html/head.php");?>
    <title>AnderCode - 404</title>
</head>
<body>

<?php 
    require_once("view/html/preloader.php");
    require_once("view/html/header.php");
?>

<section class="error-area section-padding position-relative">
    <span class="icon-shape icon-shape-1"></span>
    <span class="icon-shape icon-shape-2"></span>
    <span class="icon-shape icon-shape-3"></span>
    <span class="icon-shape icon-shape-4"></span>
    <span class="icon-shape icon-shape-5"></span>
    <span class="icon-shape icon-shape-6"></span>
    <span class="icon-shape icon-shape-7"></span>
    <div class="container">
        <div class="text-center">
            <img src="assets/images/error-img.png" alt="error-image" class="img-fluid mb-40px">
            <h2 class="section-title pb-3">Oops! Pagina no encontrada!</h2>
            <p class="section-desc pb-4">Lo sentimos, no pudimos encontrar la página que solicitaste.</p>
            <a class="btn theme-btn" href="index"> Regresar al Inicio </a>
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

</body>
</html>