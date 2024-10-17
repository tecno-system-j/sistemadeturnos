<?php include_once 'Views/Templates/header2.php' ?>


    <div class="app app-error align-content-stretch d-flex flex-wrap">
        <div class="app-error-info">
            <h5>Oops!</h5>
            <span>Parece que ha ocurrido un error, intentemos de nuevo 😊</span>
            <a href="<?php echo BASE_URL . 'principal/salir'; ?>" class="btn btn-dark">Iniciar sesión</a>
        </div>
        <div class="app-error-background"></div>
    </div>
    
    <?php include_once 'Views/Templates/footer.php'; ?>

</body>
</html>