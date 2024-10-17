<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Responsive Admin Dashboard Template">
    <meta name="keywords" content="admin,dashboard">
    <meta name="author" content="stacks">
    <!-- The above 6 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <!-- Title -->
    <title>
        <?php echo $data['title']; ?>
    </title>

    <!-- Styles -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp" rel="stylesheet">
    <link href="<?php echo BASE_URL . 'Assets/plugins/bootstrap/css/bootstrap.min.css'; ?>" rel="stylesheet">
    <link href="<?php echo BASE_URL . 'Assets/plugins/perfectscroll/perfect-scrollbar.css'; ?>" rel="stylesheet">
    <link href="<?php echo BASE_URL . 'Assets/plugins/pace/pace.css'; ?>" rel="stylesheet">


    <!-- Theme Styles -->
    <link href="<?php echo BASE_URL . 'Assets/css/main.css'; ?>" rel="stylesheet">
    <link href="<?php echo BASE_URL . 'Assets/css/ligth.css'; ?>" id="light-theme" rel="stylesheet">
    <link href="<?php echo BASE_URL . 'Assets/css/darktheme.css'; ?>" id="dark-theme" rel="stylesheet" disabled>
    <link rel="stylesheet" href="<?php echo BASE_URL . 'Assets/plugins/DataTables/datatables.min.css'; ?>" />
    <link href="<?php echo BASE_URL . 'Assets/css/custom.css'; ?>" rel="stylesheet">
    <link rel="icon" type="image/png" href="<?php echo BASE_URL . 'Assets/images/favicon.ico'; ?>" />


    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo BASE_URL . 'Assets/images/neptune.png'; ?>" />
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo BASE_URL . 'Assets/images/neptune.png'; ?>" />

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif] -->

</head>



<body>
    <div class="app align-content-stretch d-flex flex-wrap">
        <div class="app-sidebar">
            <div class="logo logo-sm">
                <a href="#">CentralHub</a>
                <!-- <a href="index.html">Neptune</a> -->
            </div>
            <div class="app-menu">
                <ul class="accordion-menu">
                    <li>
                    </li>
                    <li class="nav-item"><a class="nav-link" id=toggle-theme-btn> <i class="material-symbols-outlined ">dark_mode</i>Cambiar tema</a></li>
                    <li class="nav-item"><a class="nav-link toggle-search" href="#"><i class="material-symbols-outlined">search</i>Buscar</a>
                    <li class="nav-item">
                        <a href=""><i class="material-icons-two-tone">manage_accounts</i>Cuenta<i class="material-icons has-sub-menu">keyboard_arrow_right</i></a>
                        <ul class="sub-menu" style="display: none;">
                            <li>
                                <a href="<?php echo BASE_URL . 'principal/salir'; ?>">Salir</a>
                            </li>
                            <!-- <li>
                                <a href="ui-avatars.html">Avatars</a>
                            </li> -->
                        </ul>
                    </li>
                    <li>
                        <a href="<?php echo BASE_URL . 'turnos/ver'; ?>"><i class="material-symbols-outlined">assignment_add</i>Turnos</a>
                    </li>
                    

                </ul>
            </div>
        </div>
        <div class="app-container">
            <div class="search">
                <form>
                    <input class="form-control" type="text" placeholder="Type here..." aria-label="Search">
                </form>
                <a href="#" class="toggle-search"><i class="material-symbols-outlined">close</i></a>
            </div>
            <div class="app-header">
                <nav class="navbar navbar-light navbar-expand-lg">
                    <div class="container-fluid">
                        <div class="navbar-nav" id="navbarNav">
                            <ul class="navbar-nav">
                                <li class="nav-item">
                                    <a class="nav-link hide-sidebar-toggle-button" href="#"><i class="material-symbols-outlined">first_page</i></a>
                                </li>
                                <li class="nav-item dropdown hidden-on-mobile">
                                    <a class="nav-link dropdown-toggle" href="#" id="addDropdownLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="material-symbols-outlined">add</i>
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="addDropdownLink">
                                        <li><a class="dropdown-item" href="#">Nuevo Usuario</a></li>
                                        <li><a class="dropdown-item" href="#">Subir Archivo</a></li>
                                        <li><a class="dropdown-item" href="#">Create Project</a></li>
                                    </ul>
                                </li>

                            </ul>

                        </div>
                        <div class="d-flex">
                            <ul class="navbar-nav">
                                <li class="nav-item">
                                    <a class="nav-link nav-notifications-toggle" id="notificationsDropDown" href="#" data-bs-toggle="dropdown">
                                        <i class="material-symbols-outlined">
                                            manage_accounts
                                        </i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end notifications-dropdown" aria-labelledby="notificationsDropDown">
                                        <h6 class="dropdown-header">Inicio</h6>
                                        <div class="notifications-dropdown-list">
                                            <a href="#">
                                                <div class="notifications-dropdown-item">
                                                    <div class="notifications-dropdown-item-image">
                                                        <i class="material-symbols-outlined">manage_accounts</i>
                                                    </div>
                                                    <div class="notifications-dropdown-item-text">
                                                        <p>Perfil</p>
                                                    </div>
                                                </div>
                                            </a>
                                            <a href="<?php echo BASE_URL . 'principal/salir'; ?>">
                                                <div class="notifications-dropdown-item">
                                                    <div class="notifications-dropdown-item-image">
                                                        <i class="material-symbols-outlined">logout</i>
                                                    </div>
                                                    <div class="notifications-dropdown-item-text">
                                                        <p>Salir</p>
                                                    </div>
                                                </div>
                                            </a>

                                        </div>
                                    </div>
                                </li>

                            </ul>
                        </div>
                    </div>
                </nav>
            </div>



            <div class="app-content">
                <div class="content-wrapper">