
<?php include_once 'Views/Templates/header.php'; ?>

<div class="app-content">
    <?php include_once 'Views/Templates/menus.php'; ?>
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="page-description d-flex align-items-center">
                        <div class="page-description-content flex-grow-1">
                            <h1><?php echo $data['formulario']['nombre']; ?></h1>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <form id="formularioPublico" action="formularios/enviar" method="POST">
                    <?php foreach ($data['formulario']['campos'] as $campo) { ?>
                        <div class="col-12">
                            <label for="<?php echo $campo['nombre']; ?>"><?php echo $campo['nombre']; ?></label>
                            <input type="<?php echo $campo['tipo']; ?>" name="<?php echo $campo['nombre']; ?>" class="form-control" required>
                        </div>
                    <?php } ?>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Enviar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include_once 'Views/Templates/footer.php'; ?>
