<?php include_once 'Views/Templates/headers.php' ?>


<div class="app-content">
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="page-description d-flex align-items-center">
                        <div class="page-description-content flex-grow-1">
                            <h1>Responder Formulario</h1>
                        </div>
                    </div>
                </div>
            </div>

            <form id="formResponderFormulario">
                <input type="hidden" id="idform" name="idform">

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="nombreFormulario">Formulario: <strong id="nombreFormulario"></strong></label>
                        </div>
                    </div>
                </div>

                <!-- Aquí se cargarán dinámicamente los campos del formulario -->
                <div id="camposFormulario"></div>
                <ul class="divider"></ul>
                <button type="submit" class="btn btn-primary">Enviar Respuestas</button>
            </form>
        </div>
    </div>
</div>

<?php include_once 'Views/Templates/footer.php'; ?>