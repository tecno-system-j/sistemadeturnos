<?php include_once 'Views/Templates/headers.php' ?>
<?php if ($_SESSION['rol'] == '0'): ?>
    <div class="app-content">
        <div class="content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <div class="page-description d-flex align-items-center">
                            <div class="page-description-content flex-grow-1">
                                <h1>Crear Formulario de Turnos</h1>
                            </div>
                        </div>
                    </div>
                </div>

                <form id="formCrearTurnos">
                    <!-- Campos específicos para la creación de formularios de turnos -->
                    <!-- Aquí se incluirían campos como selección de fecha, ocupación, horario, etc. -->
                    <div class="form-group">
                        <label for="fecha">Fecha</label>
                        <input type="date" id="fecha" name="fecha" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary">Crear Formulario de Turnos</button>
                </form>
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