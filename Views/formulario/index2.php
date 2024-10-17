<?php include_once 'Views/Templates/headers.php' ?>

<div class="container">
    <h1><?php echo $data['title']; ?></h1>
    <button class="btn btn-primary" id="btnNuevoFormulario">Crear Nuevo Formulario</button>
    
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody id="tablaFormularios">
            <?php foreach ($data['formularios'] as $formulario): ?>
                <tr>
                    <td><?php echo $formulario['id']; ?></td>
                    <td><?php echo $formulario['nombre']; ?></td>
                    <td><button class="btn btn-info">Editar</button></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Modal para crear formulario -->
<div class="modal fade" id="modalFormulario" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nuevo Formulario</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="formNuevoFormulario">
                    <div class="form-group">
                        <label for="nombre">Nombre del Formulario</label>
                        <input type="text" id="nombre" class="form-control" required>
                    </div>
                    <div id="camposFormulario"></div>
                    <button type="button" class="btn btn-success" id="btnAgregarCampo">Agregar Campo</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="btnGuardarFormulario">Guardar</button>
            </div>
        </div>
    </div>
</div>

<?php include_once 'Views/Templates/footer.php'; ?>
