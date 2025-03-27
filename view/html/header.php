<header class="header-area bg-white">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-2">
                <div class="logo-box">
                    <a href="index" class="logo"><img src="assets/images/Logo IEEE.png" alt="logo" style="width: 125px; height: auto;"></a>
                    <div class="user-action">
                        <div class="search-menu-toggle icon-element icon-element-xs shadow-sm me-1" data-bs-toggle="tooltip" data-placement="top" title="Buscar">
                            <i class="la la-search"></i>
                        </div>
                        <div class="off-canvas-menu-toggle icon-element icon-element-xs shadow-sm" data-bs-toggle="tooltip" data-placement="top" title="Main menu">
                            <i class="la la-bars"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-10">
                <div class="menu-wrapper border-left border-left-gray ps-4 justify-content-end">
                    <form method="get" action="question" class="me-4">
                        <div class="form-group mb-0">
                            <input class="form-control form--control form--control-bg-gray" type="text" name="search" placeholder="Escribe las palabras de búsqueda.." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                            <button class="form-btn" type="button"><i class="la la-search"></i></button>
                        </div>
                    </form>

                    <div class="nav-right-button">

                        <?php
                            if(isset($_SESSION["usu_id"])){
                                echo
                                    '<ul class="user-action-wrap d-flex align-items-center">'.
                                    '<li class="dropdown">'.
                                        '<span class="ball red ball-lg noti-dot"></span>'.
                                        '<a class="nav-link dropdown-toggle dropdown--toggle" href="#" id="notificationDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'.
                                            '<i class="la la-bell"></i>'.
                                        '</a>'.
                                        '<div class="dropdown-menu dropdown--menu dropdown-menu-right mt-3 keep-open" aria-labelledby="notificationDropdown">'.
                                            '<h6 class="dropdown-header"><i class="la la-bell pe-1 fs-16"></i>Notifications</h6>'.
                                            '<div class="dropdown-divider border-top-gray mb-0"></div>'.
                                            '<div class="dropdown-item-list">'.
                                                '<a class="dropdown-item" href="notifications.html">'.
                                                    '<div class="media media-card media--card shadow-none mb-0 rounded-0 align-items-center bg-transparent">'.
                                                        '<div class="media-img media-img-sm flex-shrink-0">'.
                                                            '<img src="assets/images/img3.jpg" alt="avatar">'.
                                                        '</div>'.
                                                        '<div class="media-body p-0 border-left-0">'.
                                                            '<h5 class="fs-14 fw-regular">John Doe following your post</h5>'.
                                                            '<small class="meta d-block lh-24">'.
                                                                '<span>45 secs ago</span>'.
                                                            '</small>'.
                                                        '</div>'.
                                                    '</div>'.
                                                '</a>'.
                                                '<a class="dropdown-item" href="notifications.html">'.
                                                    '<div class="media media-card media--card shadow-none mb-0 rounded-0 align-items-center bg-transparent">'.
                                                        '<div class="media-img media-img-sm flex-shrink-0">'.
                                                            '<img src="assets/images/img4.jpg" alt="avatar">'.
                                                        '</div>'.
                                                        '<div class="media-body p-0 border-left-0">'.
                                                            '<h5 class="fs-14 fw-regular">Arnold Smith answered on your post</h5>'.
                                                            '<small class="meta d-block lh-24">'.
                                                                '<span>5 mins ago</span>'.
                                                            '</small>'.
                                                        '</div>'.
                                                    '</div>'.
                                                '</a>'.
                                                '<a class="dropdown-item" href="notifications.html">'.
                                                    '<div class="media media-card media--card shadow-none mb-0 rounded-0 align-items-center bg-transparent">'.
                                                        '<div class="media-img media-img-sm flex-shrink-0">'.
                                                            '<img src="assets/images/img4.jpg" alt="avatar">'.
                                                        '</div>'.
                                                        '<div class="media-body p-0 border-left-0">'.
                                                            '<h5 class="fs-14 fw-regular">Saeed bookmarked your post</h5>'.
                                                            '<small class="meta d-block lh-24">'.
                                                                '<span>1 hour ago</span>'.
                                                            '</small>'.
                                                        '</div>'.
                                                    '</div>'.
                                                '</a>'.
                                            '</div>'.
                                            '<a class="dropdown-item pb-1 border-bottom-0 text-center btn-text fw-regular" href="notifications.html">View All Notifications <i class="la la-arrow-right icon ms-1"></i></a>'.
                                        '</div>'.
                                    '</li>'.
                                    '<li class="dropdown user-dropdown">'.
                                        '<a class="nav-link dropdown-toggle dropdown--toggle ps-2" href="#" id="userMenuDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'.
                                            '<div class="media media-card media--card shadow-none mb-0 rounded-0 align-items-center bg-transparent">'.
                                                '<div class="media-img media-img-xs flex-shrink-0 rounded-full me-2">'.
                                                    '<img src="'. $_SESSION["usu_img"] .'" alt="avatar" class="rounded-full">'.
                                                '</div>'.
                                                '<div class="media-body p-0 border-left-0">'.
                                                    '<h5 class="fs-14">'. $_SESSION["usu_nom"] .'</h5>'.
                                                '</div>'.
                                            '</div>'.
                                        '</a>'.
                                        '<div class="dropdown-menu dropdown--menu dropdown-menu-right mt-3 keep-open" aria-labelledby="userMenuDropdown">'.
                                            '<h6 class="dropdown-header">Hola, '. $_SESSION["usu_nom"] .'</h6>'.
                                            '<div class="dropdown-divider border-top-gray mb-0"></div>'.
                                            '<div class="dropdown-item-list">'.
                                                '<a class="dropdown-item" href="userprofile/'.$_SESSION["usu_id"] .'/'.$_SESSION["usu_nom_url"].'"><i class="la la-user me-2"></i>Perfil</a>'.
                                                '<a class="dropdown-item" href="notifications.html"><i class="la la-bell me-2"></i>Notificaciones</a>'.
                                                '<a class="dropdown-item" href="usereditprofile.php"><i class="la la-gear me-2"></i>Configuración</a>'.
                                                '<a class="dropdown-item" href="view/components/logout.php"><i class="la la-power-off me-2"></i>Cerrar Sesión</a>'.
                                            '</div>'.
                                        '</div>'.
                                    '</li>'.
                                '</ul>';
                            } else{
                                echo
                                    '<a href="#" class="btn theme-btn theme-btn-outline me-2" data-bs-toggle="modal" data-bs-target="#loginModal"><i class="la la-sign-in me-1"></i> Acceder</a>'.
                                    '<a href="#" class="btn theme-btn" data-bs-toggle="modal" data-bs-target="#signUpModal"><i class="la la-user me-1"></i> Registrarse</a>';
                            }
                        ?>

                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="off-canvas-menu custom-scrollbar-styled">
        <div class="off-canvas-menu-close icon-element icon-element-sm shadow-sm" data-bs-toggle="tooltip" data-placement="left" title="Close menu">
            <i class="la la-times"></i>
        </div><!-- end off-canvas-menu-close -->
        <div class="off-canvas-btn-box px-4 pt-5 text-center">
            <a href="#" class="btn theme-btn theme-btn-sm theme-btn-outline" data-bs-toggle="modal" data-bs-target="#loginModal"><i class="la la-sign-in me-1"></i> Acceder</a>
            <span class="fs-15 fw-medium d-inline-block mx-2">Or</span>
            <a href="#" class="btn theme-btn theme-btn-sm" data-bs-toggle="modal" data-bs-target="#signUpModal"><i class="la la-plus me-1"></i> Registrarse</a>
        </div>
    </div><!-- end off-canvas-menu -->
    <div class="mobile-search-form">
        <div class="d-flex align-items-center">
            <form method="post" class="flex-grow-1 me-3">
                <div class="form-group mb-0">
                    <input class="form-control form--control pl-40px" type="text" name="search" placeholder="Escribe las palabras de búsqueda..">
                    <span class="la la-search input-icon"></span>
                </div>
            </form>
            <div class="search-bar-close icon-element icon-element-sm shadow-sm">
                <i class="la la-times"></i>
            </div><!-- end off-canvas-menu-close -->
        </div>
    </div><!-- end mobile-search-form -->
    <div class="body-overlay"></div>
</header>