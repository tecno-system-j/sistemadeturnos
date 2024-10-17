<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="<?php echo BASE_URL . 'Assets/css/login.css'; ?>" rel="stylesheet">
    <link rel="shortcut icon" type="image/png" href="<?php echo BASE_URL . 'Assets/images/favicon.ico'; ?>" />
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer" />
</head>
<title>
    <?php echo $data['title']; ?>
</title>

<body>
    <div class="container" id="container">
        <div class="form-container register-container">
            <form>
                <h1>Regístrate aquí</h1>
                <div class="form-control">
                    <input type="text" id="username" placeholder="Nombre" />
                    <small id="username-error"></small>
                    <span></span>
                </div>
                <div class="form-control">
                    <input type="email" id="email" placeholder="Correo electrónico" />
                    <small id="email-error"></small>
                    <span></span>
                </div>
                <div class="form-control">
                    <input type="password" id="password" placeholder="Contraseña" />
                    <small id="password-error"></small>
                    <span></span>
                </div>
                <button type="submit" value="submit">Registrar</button>
                <span>o usa tu cuenta</span>
                <div class="social-container">
                    <a href="#" class="social"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" class="social"><i class="fa-brands fa-google"></i></a>
                    <a href="#" class="social"><i class="fa-brands fa-tiktok"></i></a>
                </div>
            </form>
        </div>

        <div class="form-container login-container">
            <form class="form-lg" id="formulario">
                <h1>Inicia sesión aquí</h1>
                <div class="form-control2">
                    <input type="email" class="email-2" id="correo" name="correo" placeholder="Correo electrónico" />
                    <small class="email-error-2"></small>
                    <span></span>
                </div>
                <div class="form-control2">
                    <input type="password" class="password-2" placeholder="Contraseña" name="clave" id="clave" />
                    <small class="password-error-2"></small>
                    <span></span>
                </div>

                <div class="content">
                    <div class="checkbox">
                        <input type="checkbox" name="checkbox" id="checkbox" />
                        <label for="">Recuérdame</label>
                    </div>
                    <div class="pass-link">
                        <a href="#">¿Olvidaste la contraseña?</a>
                    </div>
                </div>
                <button type="submit" value="submit">Iniciar sesión</button>
                <span>O usa tu cuenta</span>
                <div class="social-container">
                    <a href="#" class="social"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" id="googleLoginBtn" name="googleLoginBtn"  class="social" ><i class="fa-brands fa-google" ></i></a>
                    <a href="#" class="social"><i class="fa-brands fa-tiktok"></i></a>
                </div>
            </form>
        </div>

        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1 class="title">
                        Hola <br />
                        amigos
                    </h1>
                    <p>Si tienes una cuenta, inicia sesión aquí y diviértete</p>
                    <button class="ghost" id="login">
                        Iniciar sesión
                        <i class="fa-solid fa-arrow-left"></i>
                    </button>
                </div>

                <div class="overlay-panel overlay-right">
                    <h1 class="title">
                        Comienza tu <br />
                        viaje ahora
                    </h1>
                    <p>
                        Si aún no tienes una cuenta, únete a nosotros y comienza tu viaje
                    </p>
                    <button class="ghost" id="register">
                        Registrarse
                        <i class="fa-solid fa-arrow-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</body>

<!-- Javascripts -->
<script src="<?php echo BASE_URL . 'Assets/plugins/jquery/jquery-3.5.1.min.js'; ?>"></script>
<script src="<?php echo BASE_URL . 'Assets/plugins/bootstrap/js/bootstrap.min.js'; ?>"></script>
<script src="<?php echo BASE_URL . 'Assets/plugins/perfectscroll/perfect-scrollbar.min.js'; ?>"></script>
<script src="<?php echo BASE_URL . 'Assets/plugins/pace/pace.min.js'; ?>"></script>
<script src="<?php echo BASE_URL . 'Assets/js/main.min.js'; ?>"></script>
<script src="<?php echo BASE_URL . 'Assets/js/sweetalert2@11.js'; ?>"></script>
<script src="<?php echo BASE_URL . 'Assets/js/custom.js'; ?>"></script>
<script src="<?php echo BASE_URL . 'Assets/js/estiloslogin.js'; ?>"></script>
<script>
    const base_url = '<?php echo BASE_URL; ?>';
</script>
<script src="<?php echo BASE_URL . 'Assets/js/pages/login.js'; ?>"></script>

</html>