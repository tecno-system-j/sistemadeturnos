<?php include_once 'Views/Templates/headers.php' ?>


<?php if ($_SESSION['rol'] == '0'): ?>
    <div class="container">
        <h1>Editar Turno</h1>
        <form action="<?php echo BASE_URL; ?>turnos/actualizar/<?php echo $data['turno']['id']; ?>" method="post">
            <div class="form-group">
                <label for="fecha">Fecha:</label>
                <input type="date" class="form-control" id="fecha" name="fecha" value="<?php echo $data['turno']['fecha']; ?>" required>
            </div>
            <div class="form-group">
                <label for="ocupacion">Ocupación:</label>
                <input type="text" class="form-control" id="ocupacion" name="ocupacion" value="<?php echo $data['turno']['ocupacion']; ?>" required>
            </div>
            <div class="form-group">
                <label for="horario">Horario:</label>
                <input type="text" class="form-control" id="horario" name="horario" value="<?php echo $data['turno']['horario']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Actualizar Turno</button>
        </form>
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