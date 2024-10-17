<?php include_once 'Views/Templates/headers.php' ?>

<?php if ($_SESSION['rol'] == '0'): ?>
    <div class="app-content">
        <?php include_once 'Views/Templates/menus.php'; ?>
        <div class="content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <div class="page-description d-flex align-items-center">
                            <div class="page-description-content flex-grow-1">
                                <h1>File Manager</h1>
                            </div>
                            <div class="page-description-actions">
                                <a href="#" class="btn btn-primary" id='btnUpload' name='btnUpload'><i class="material-symbols-outlined">add</i>Nuevo Archivo</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <?php foreach ($data['carpetas'] as $carpeta) { ?>
                        <div class="col-md-4">
                            <div class="card file-manager-group">
                                <div class="card-body d-flex align-items-center">
                                    <i class="material-symbols-outlined" style="color: #<?php echo $carpeta['color']; ?>;">folder</i>
                                    <div class="file-manager-group-info flex-fill">
                                        <a href="#" id="<?php echo $carpeta['id']; ?>" nombre="<?php echo $carpeta['nombre']; ?>" class="file-manager-group-title carpetas"><?php echo $carpeta['nombre']; ?></a>
                                        <span class="file-manager-group-about"><?php echo $carpeta['fecha']; ?></span>
                                    </div>

                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>

                <!-- <div class="row">
                <?php foreach ($data['archivos'] as $archivos) { ?>
                    <div class="col-md-4">
                        <div class="card file-manager-group">
                            <div class="card-body d-flex align-items-center">
                                <i class="material-symbols-outlined"><?php if ($archivos['tipo'] == "image/png") {
                                                                            echo "badge";
                                                                        } else {
                                                                            echo "description";
                                                                        } ?></i>
                                <div class="file-manager-group-info flex-fill">
                                    <a href="#" class="file-manager-group-title"><?php echo $archivos['nombre']; ?></a>
                                    <span class="file-manager-group-about"><?php echo $archivos['fecha_create']; ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div> -->
                <div class="section-description">
                    <h1>Archivos Recientes</h1>
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

    <div id="modalfile" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="title">Subir</h5>
                    <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                    </button>
                </div>
                <div class="modal-body">
                    <div class="d-grid">
                        <button id="btnNuevaCarpeta" class="btn btn-outline-primary m-r-xs"><i class="material-symbols-outlined">folder</i>Nueva Carpeta</button>
                        <hr>
                        <input type="file" class="d-none" name="file" id="file">
                        <button type="button" id="btnSubirArchivo" class="btn btn-outline-success m-r-xs"><i class="material-symbols-outlined">upload_file</i>Subir Archivo</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div id="modalCarpeta" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="title-carpeta">Nueva Carpeta</h5>
                    <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                    </button>
                </div>
                <form id="frmCarpeta" autocomplete="off">
                    <div class="modal-body">
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="material-symbols-outlined">folder</i>
                            </span>
                            <input id="nombrecarpeta" class="form-control" type="text" name="nombre" placeholder="Nombre">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" type="submit">Crear</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="modalCompartir" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="title-compartir">Editar Carpeta: <span id="nombre-carpeta"></span></h5>
                    <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">



                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="id_carpeta">
                    <input type="hidden" id="nombrecarpeta">
                    <div class="d-grid">
                        <button id="btnSubir" class="btn btn-outline-primary m-r-xs"><i class="material-symbols-outlined">folder_zip</i>Subir Archivo</button>
                        <hr>
                        <button type="button" id="btnCompartir" class="btn btn-outline-success m-r-xs"><i class="material-symbols-outlined">share</i>Compartir</button>
                    </div>
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

</body>

</html>