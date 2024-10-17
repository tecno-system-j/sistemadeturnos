<?php include_once 'Views/Templates/headers.php'; ?>
<?php if (isset($_SESSION['rol'])): // Asegúrate de que el rol sea el correcto para los médicos 
?>
    <div class="container">
        <h1>Turnos Disponibles</h1>

        <!-- Selector de Mes -->
        <div class="mb-3">
            <label for="mesFiltro" class="form-label">Filtrar por Mes:</label>
            <select id="mesFiltro" class="form-control">
                <option value="">Seleccione un Mes</option>
                <!-- Las opciones se llenarán automáticamente con AJAX -->
            </select>
        </div>

        <!-- Pestañas -->
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="turnos-disponibles-tab" data-bs-toggle="tab" href="#turnos-disponibles" role="tab" aria-controls="turnos-disponibles" aria-selected="true">Turnos Disponibles</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="turnos-asignados-tab" data-bs-toggle="tab" href="#turnos-asignados" role="tab" aria-controls="turnos-asignados" aria-selected="false">Turnos Asignados</a>
            </li>
        </ul>

        <div class="tab-content" id="myTabContent">
            <!-- Turnos Disponibles -->
            <div class="tab-pane fade show active" id="turnos-disponibles" role="tabpanel" aria-labelledby="turnos-disponibles-tab">
                <div class="card mt-3">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover display nowrap" style="width:100%" id="tblTurnosDisponibles">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Ocupacion</th>
                                        <th>Horario</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Ocupacion</th>
                                        <th>Horario</th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Turnos Asignados -->
            <div class="tab-pane fade" id="turnos-asignados" role="tabpanel" aria-labelledby="turnos-asignados-tab">
            <div class="card mt-3">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover display nowrap" style="width:100%" id="tblTurnosAsignados">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Ocupacion</th>
                                        <th>Horario</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Ocupacion</th>
                                        <th>Horario</th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include_once 'Views/Templates/footer.php'; ?>

<?php else: ?>
    <div class="app app-error align-content-stretch d-flex flex-wrap">
        <div class="app-error-info">
            <h5>Oops!</h5>
            <span>Parece que no tienes permiso para acceder a esta página.</span>
            <a href="<?php echo BASE_URL; ?>" class="btn btn-dark">Iniciar sesión</a>
        </div>
        <div class="app-error-background"></div>
    </div>
<?php endif; ?>

<script>
    fetch('<?= BASE_URL ?>turnos/obtenerMesesDisponibles')
            .then(response => response.json())
            .then(data => {
                const mesFiltro = document.getElementById('mesFiltro');
                mesFiltro.innerHTML = '<option value="">Seleccione un Mes</option>'; // Limpiar opciones anteriores
                let ultimoMes = data.reduce((max, item) => item.mes > max ? item.mes : max, '');
                data.forEach(mes => {
                    let selected = mes.mes === ultimoMes ? 'selected' : '';
                    mesFiltro.innerHTML += `<option value="${mes.mes}" ${selected}>${mes.mes.split('-')[1]} de ${mes.mes.split('-')[0]}</option>`;
                });
            })
            .catch(error => console.error('Error al cargar los meses:', error));
</script>