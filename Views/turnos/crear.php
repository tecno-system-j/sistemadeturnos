<?php include_once 'Views/Templates/headers.php' ?>



<?php if ($_SESSION['rol'] == '0'): ?>
    <div class="container">
        <h1>Crear Turno</h1>
        <form action="<?php echo BASE_URL; ?>turnos/crear" method="post">
            <div class="form-group">
                <label for="fecha">Fecha:</label>
                <input type="date" class="form-control" id="fecha" name="fecha" required>
            </div>
            <div class="form-group">
                <label for="ocupacion">Ocupación:</label>
                <select class="form-control" id="ocupacion" name="ocupacion">
                    <option value="URG">URG</option>
                    <option value="URG2">URG2</option>
                    <option value="PROG1">PROG1</option>
                    <option value="PROG2">PROG2</option>
                    <option value="PROG3">PROG3</option>
                    <option value="PROG4">PROG4</option>
                    <option value="PROG5">PROG5</option>
                    <option value="PROG6">PROG6</option>
                    <option value="RECU">RECU</option>
                    <option value="INTER">INTER</option>
                    <option value="CPA">CPA</option>
                </select>
            </div>
            <div class="form-group">
                <label for="horario">Horario:</label>
                <select class="form-control" id="horario" name="horario">
                    <option value="7AM - 1PM">7AM - 1PM</option>
                    <option value="1PM - 7PM">1PM - 7PM</option>
                    <option value="7PM - 7AM">7PM - 7AM</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Crear Turno</button>
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