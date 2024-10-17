<?php include_once 'Views/Templates/headers.php' ?>
<?php if ($_SESSION['rol'] == '0'): ?>
    <div class="container">
    <div class="example-content">
                                                <div class="page-description d-flex align-items-center">
                                                    <div class="page-description-content flex-grow-1">
                                                        <h1>Listado de turnos</h1>
                                                    </div>
                                                    <div class="page-description-actions">
                                                    <a href="<?php echo BASE_URL . 'turnos/ver'; ?>" class="btn btn-primary" ><i class="material-icons">add</i>Ver turnos</a>
                                                        <a href="#" class="btn btn-primary"  data-bs-toggle="modal" data-bs-target="#modalGenerarTurnos"><i class="material-icons">add</i>Generar turnos disponibles</a>
                                                    </div>
                                                </div>
                                            </div>
        <!-- Selector de Mes -->
        <div class="mb-3">
            <label for="mesFiltro" class="form-label">Filtrar por Mes:</label>
            <select id="mesFiltro" class="form-control">
                <option value="">Seleccione un Mes</option>
                <option value="2024-11">Noviembre 2024</option>
                <option value="2024-10">Octubre 2024</option>
                <!-- Añade más opciones según sea necesario -->
            </select>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover display nowrap" style="width:100%" id="tblTurnos">
                        <thead class="thead-light">
                            <tr>
                                <th>Id</th>
                                <th>Fecha</th>
                                <th>Ocupacion</th>
                                <th>Horario</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Id</th>
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

    <!-- Modal para generar turnos -->
    <div class="modal fade" id="modalGenerarTurnos" tabindex="-1" aria-labelledby="modalGenerarTurnosLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalGenerarTurnosLabel">Generar Turnos para un Mes</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formGenerarTurnos">
                        <div class="mb-3">
                            <label for="mesSeleccionado" class="form-label">Seleccione el Mes:</label>
                            <input type="month" class="form-control" id="mesSeleccionado" required>
                        </div>
                        <button type="submit" class="btn btn-success">Generar</button>
                    </form>
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Cargar meses disponibles
        fetch('<?= BASE_URL ?>turnos/obtenerMesesDisponibles')
            .then(response => response.json())
            .then(data => {
                const mesFiltro = document.getElementById('mesFiltro');
                mesFiltro.innerHTML = '<option value="">Seleccione un Mes</option>'; // Limpiar opciones anteriores
                data.forEach(mes => {
                    mesFiltro.innerHTML += `<option value="${mes.mes}">${mes.mes.split('-')[1]} de ${mes.mes.split('-')[0]}</option>`;
                });
            })
            .catch(error => console.error('Error al cargar los meses:', error));
    });
</script>
