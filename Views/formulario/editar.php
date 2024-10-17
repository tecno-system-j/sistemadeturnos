<?php include_once 'Views/Templates/headers.php' ?>
<?php if ($_SESSION['rol'] == '0'): ?>
    <div class="app-content">
        <div class="content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <div class="page-description d-flex align-items-center">
                            <div class="page-description-content flex-grow-1">
                                <h1>Editar Formulario</h1>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pestañas para Editar y Ver Métricas -->
                <ul class="nav nav-tabs" id="tabFormulario" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="editar-tab" data-bs-toggle="tab" href="#editar" role="tab" aria-controls="editar" aria-selected="true">Editar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="metricas-tab" data-bs-toggle="tab" href="#metricas" role="tab" aria-controls="metricas" aria-selected="false">Métricas y Respuestas</a>
                    </li>
                </ul>

                <div class="tab-content" id="tabContentFormulario">
                    <!-- Pestaña Editar -->
                    <div class="tab-pane fade show active" id="editar" role="tabpanel" aria-labelledby="editar-tab">
                        <form id="formEditarFormulario">
                            <!-- Seleccionar tipo de formulario -->
                            <div class="form-group">
                                <label for="tipoFormulario">Tipo de Formulario</label>
                                <select id="tipoFormulario" class="form-control">
                                    <option value="normal">Formulario Normal</option>
                                    <option value="turnos">Formulario de Turnos</option>
                                </select>
                            </div>

                            <!-- Campos comunes -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="hidden" name="idform" id="idform">
                                        <label for="nombreFormulario">Nombre del Formulario</label>
                                        <input type="text" name="nombreFormulario" id="nombreFormulario" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="descripcion">Descripción del Formulario</label>
                                        <textarea name="descripcion" id="descripcion" class="form-control" required></textarea>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-secondary" id="agregarCampo">Agregar Campo</button>
                            <ul class="divider"></ul>
                            <!-- Botón para cargar la plantilla de turnos -->
                            <div id="cargarPlantillaTurnos" class="d-none">
                                <button type="button" class="btn btn-primary" onclick="cargarPlantillaTurnos()">Cargar Plantilla de Turnos</button>
                            </div>

                            <!-- Campos dinámicos agregados aquí -->
                            <ul id="listaCampos"></ul>

                            <div id="turnosDisponibles" class="row d-none">
                                <div class="col-md-12">
                                    <h3>Turnos Disponibles</h3>
                                    <ul id="listaTurnos"></ul>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Actualizar Formulario</button>
                        </form>
                    </div>

                    <!-- Pestaña Métricas y Respuestas -->
                    <div class="tab-pane fade" id="metricas" role="tabpanel" aria-labelledby="metricas-tab">
                        <div class="row">
                            <div class="col-md-6">
                                <!-- Métricas pueden ser insertadas aquí -->
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="section-description">
                                <h1><br> Respuestas</h1>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover display nowrap" style="width:100%" id="datatable1">
                                            <thead class="thead-light">
                                                <tr id="tablaRespuestasHeader">
                                                    <!-- Cabecera dinámica de los campos -->
                                                </tr>
                                            </thead>
                                            <tbody id="tablaRespuestas">
                                                <!-- Se llenará dinámicamente -->
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>

                        </div>
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