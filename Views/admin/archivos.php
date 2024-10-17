<?php include_once 'Views/Templates/headers.php' ?>
<?php if($_SESSION['rol'] == '0'): ?>
    <div class="app-content">
    <?php include_once 'Views/Templates/menus.php'; ?>
    <div class="content-wrapper">

        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="page-description d-flex align-items-center">
                        <div class="page-description-content flex-grow-1">
                            <h1>Lista archivos</h1>
                        </div>
                        <div class="page-description-actions">
                            <a href="#" class="btn btn-primary" id='btnUpload' name='btnUpload'><i class="material-symbols-outlined">add</i>Nuevo Archivo</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <?php foreach ($data['archivos'] as $archivo) { ?>
                    <div class="col-xxl-6">
                        <div class="card file-manager-recent-item">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <i class="material-symbols-outlined align-middle m-r-sm"><?php if ($archivo['tipo'] == "image/png") {
                                                                                                    echo "badge";
                                                                                                } else {
                                                                                                    echo "description";
                                                                                                } ?></i>
                                    <a href="#" data-id="<?php echo $archivo['id']; ?>" class="file-manager-recent-item-title flex-fill"><?php echo $archivo['nombre']; ?></a>
                                    <span class="p-h-sm"><?php
                                                            $bytes = $archivo['size'];
                                                            $units = array('B', 'KB', 'MB', 'GB', 'TB');
                                                            for ($i = 0; $bytes >= 1024 && $i < count($units) - 1; $i++) $bytes /= 1024;
                                                            echo round($bytes, 2) . ' ' . $units[$i];
                                                            ?></span>
                                    <span class="p-h-sm text-muted"><?php echo $archivo['fecha_create']; ?></span>
                                    <a href="#" class="dropdown-toggle file-manager-recent-file-actions" id="file-manager-recent-1" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-symbols-outlined">more_vert</i></a>
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="file-manager-recent-1">
                                        <li><a class="dropdown-item" href="#">Share</a></li>
                                        <li><a class="dropdown-item" href="#">Download</a></li>
                                        <li><a class="dropdown-item" href="#">Move to folder</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                    </div>
                <?php } ?>
            </div>

        </div>
    </div>


</div>
<?php else: ?>
<div class="app app-error align-content-stretch d-flex flex-wrap">
    <div class="app-error-info">
        <h5>Oops!</h5>
        <span>Parece que ha ocurrido un error, intentemos de nuevo 😊</span>
        <a href="<?php echo BASE_URL; ?>" class="btn btn-dark">iniciar sesión</a>
    </div>
    <div class="app-error-background"></div>
</div>
<?php endif; ?>





<?php include_once 'Views/Templates/footer.php'; ?>
