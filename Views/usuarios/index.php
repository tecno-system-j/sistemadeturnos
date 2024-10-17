<?php include_once 'Views/Templates/headers.php' ?>

<?php if($_SESSION['rol'] == '0'): ?>
<div class="container">
    <div class="row">
        <div class="col">
            <div class="page-description">
                <h1>
                    <?php echo $data['title']; ?>
                </h1>
            </div>
        </div>

        <div class="col-md-12">
            <button class="btn btn-outline-primary mb-3" type="button" id="btnNuevo"> <i class="material-icons-round">
                    person_add
                </i>Nuevo</button>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover display nowrap" style="width:100%" id="tblUsuarios">
                            <thead class="thead-light">
                                <tr>
                                    <th></th>
                                    <th>Id</th>
                                    <th>Nombres</th>
                                    <th>Correo</th>
                                    <th>Teléfono</th>
                                    <th>Dirección</th>
                                    <th>Perfil</th>
                                    <th>Fecha De registro</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="modalRegistro" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="title"></h5>
                <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formulario" autocomplete="off">
                <input type="hidden" id="id_usuario" name="id_usuario">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="nombre">Nombre</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="material-icons-round">
                                        face
                                    </i>
                                </span>
                                <input class="form-control" type="text" id="nombre" name="nombre" placeholder="Nombre">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="apellido">Apellido</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="material-icons-round">

                                        badge
                                    </i>
                                </span>
                                <input class="form-control" type="text" id="apellido" name="apellido" placeholder="Apellido">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="correo">Correo</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="material-icons-round">
                                        email
                                    </i>
                                </span>
                                <input class="form-control" type="email" id="correo" name="correo" placeholder="Correo">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="direccion">Dirección</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="material-icons-round">
                                        room
                                    </i>
                                </span>
                                <input class="form-control" type="text" id="direccion" name="direccion" placeholder="Direcccion">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="telefono">Telefono</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="material-icons-round">
                                        phone
                                    </i>
                                </span>
                                <input class="form-control" type="number" id="telefono" name="telefono" placeholder="Telefono">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="contraseña">Contraseña</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="material-icons-round">
                                        password
                                    </i>
                                </span>
                                <input class="form-control" type="password" id="clave" name="clave" placeholder="Contraseña">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="rol">Rol</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="material-icons-round">
                                        supervised_user_circle
                                    </i>
                                </span>
                                <select name="rol" id="rol" class="form-control">
                                    <option value="0">Administrador</option>
                                    <option value="1">Usuario</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-outline-primary" type="submit"><i class="material-icons-round">

                            how_to_reg
                        </i>Guardar</button>
                    <button class="btn btn-outline-danger" type="button" data-bs-dismiss="modal"><i class="material-icons-round">

                            cancel
                        </i>Cancelar</button>
                </div>
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

<?php include_once 'Views/templates/footer.php'; ?>

</body>

</html>