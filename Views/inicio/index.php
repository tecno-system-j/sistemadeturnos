<?php include_once 'Views/Templates/headers.php' ?>




<div class="app-content">
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="page-description d-flex align-items-center">
                        <div class="page-description-content flex-grow-1">
                            <h1>Dashboard</h1>
                        </div>
                    </div>
                </div>

                <div class="row">
                            <div class="col-xl-8">
                                <div class="card widget widget-action-list">
                                    <div class="card-body">
                                        <div class="widget-action-list-container">
                                            <ul class="list-unstyled d-flex no-m">
                                                <li class="widget-action-list-item">
                                                    <a href="#">
                                                        <span class="widget-action-list-item-icon">
                                                            <i class="material-icons text-primary">swap_horiz</i>
                                                        </span>

                                                    </a>
                                                </li>
                                                <li class="widget-action-list-item">
                                                    <a href="#">
                                                        <span class="widget-action-list-item-icon">
                                                            <i class="material-icons-outlined text-success">payment</i>
                                                        </span>

                                                    </a>
                                                </li>
                                                <li class="widget-action-list-item">
                                                    <a href="<?php echo BASE_URL . 'principal/salir'; ?>">
                                                        <span class="widget-action-list-item-icon">
                                                            <i class="material-icons-outlined text-danger">lock</i>
                                                        </span>

                                                    </a>
                                                </li>
                                                <li class="widget-action-list-item">
                                                    <a href="<?php echo BASE_URL . 'usuarios'; ?>">
                                                        <span class="widget-action-list-item-icon">
                                                            <i class="material-icons text-info">add</i>
                                                        </span>

                                                    </a>
                                                </li>
                                                <li class="widget-action-list-item">
                                                    <a href="#">
                                                        <span class="widget-action-list-item-icon">
                                                            <i class="material-icons text-warning">settings</i>
                                                        </span>

                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="card widget-tweet">
                                    <div class="card-body">
                                        <div class="widget-tweet-container">
                                            <div class="widget-tweet-content">
                                                <p class="widget-tweet-text">"El conocimiento es el poder más grande que puedes tener."</p>
                                                <p class="widget-tweet-author">- Sir Francis Bacon</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
            </div>
        </div>



<?php include_once 'Views/Templates/footer.php'; ?>
</body>

</html>