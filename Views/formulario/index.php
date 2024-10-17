<?php include_once 'Views/Templates/headers.php' ?>

<?php if ($_SESSION['rol'] == '0'): ?>
    <div class="app-content">
        <div class="content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <div class="page-description d-flex align-items-center">
                            <div class="page-description-content flex-grow-1">
                                <h1>Formularios disponibles</h1>
                            </div>
                            <div class="page-description-actions">
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tipoFormularioModal">Crear Formulario</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <?php foreach ($data['formularios'] as $formulario) { ?>

                        <div class="col-xxl-6">
                            <div class="card">
                                <div class="card-body">
                                    <input type="hidden" id="idform" name="idform">
                                    <h5 class="card-title"><?php echo $formulario['nombre']; ?></h5>
                                    <a href="#" id="<?php echo $formulario['id']; ?>" class="btn btn-info forms">Ver Formulario</a>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para seleccionar el tipo de formulario -->
    <div class="modal fade" id="tipoFormularioModal" tabindex="-1" aria-labelledby="tipoFormularioModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tipoFormularioModalLabel">Seleccionar Tipo de Formulario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="d-grid gap-2">
                        <a href="<?php echo BASE_URL . 'formularios/crearNormal'; ?>" class="btn btn-secondary">Formulario Normal</a>
                        <a href="<?php echo BASE_URL . 'formularios/crearTurnos'; ?>" class="btn btn-secondary">Formulario de Turnos</a>
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