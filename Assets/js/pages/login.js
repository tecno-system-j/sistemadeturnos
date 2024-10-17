const frm = document.querySelector("#formulario");
const correo = document.querySelector("#correo");
const clave = document.querySelector("#clave");
const googleLoginBtn = document.querySelector("#googleLoginBtn"); // Botón para iniciar sesión con Google

document.addEventListener("DOMContentLoaded", function () {
    frm.addEventListener("submit", function (e) {
        e.preventDefault();

        if (correo.value === "" || clave.value === "") {
            alertaPerzonalizada("warning", "No pueden estar los campos vacíos");
        } else {
            const data = new FormData(frm);
            const http = new XMLHttpRequest();
            const url = base_url + "principal/validar";

            http.open("POST", url, true);
            http.send(data);

            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    console.log(res.licencaestado);
                    alertaPerzonalizada(res.tipo, res.mensaje); // Mostrar alerta personalizada
                    if (res.tipo === "success") {
                        console.log(res);
                        let timerInterval;
                        Swal.fire({
                            title: res.mensaje,
                            html: "Sera redireccionado en <b></b> milliseconds.",
                            timer: 2000,
                            icon: "success",
                            timerProgressBar: true,
                            didOpen: () => {
                                Swal.showLoading();
                                const b = Swal.getHtmlContainer().querySelector("b");
                                timerInterval = setInterval(() => {
                                    b.textContent = Swal.getTimerLeft();
                                }, 100);
                            },
                            willClose: () => {
                                clearInterval(timerInterval);
                            },
                        }).then((result) => {
                            if (result.dismiss === Swal.DismissReason.timer) {
                                window.location = base_url + "inicio"; // Redirigir solo si es éxito
                            }
                        });
                    } else {
                        // La alerta ya se muestra arriba, no es necesario repetir
                    }
                }
            };
        }
    });

    // Evento para iniciar sesión con Google
    googleLoginBtn.addEventListener("click", function () {
        window.location.href = base_url + "principal/loginGoogle"; // Redirigir a la ruta de login con Google
    });
});
