const frm = document.querySelector("#formResponderFormulario");
const camposFormulario = document.getElementById("camposFormulario");

document.addEventListener("DOMContentLoaded", function () {
    const urls = window.location.href;
    let idform = urls.substring(urls.lastIndexOf('/') + 1);

    // Si no hay nada después del último "/", toma lo que está antes
    if (!idform || idform === '') {
        urls = urls.slice(0, urls.lastIndexOf('/'));
        idform = urls.substring(urls.lastIndexOf('/') + 1);
    }

    // Cargar el formulario para responder
    cargarFormulario(idform);

    // Función para cargar el formulario
    function cargarFormulario(id) {
        const http = new XMLHttpRequest();
        const url = base_url + "formularios/verformulario/" + id;

        http.open("GET", url, true);
        http.send();

        http.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                const res = JSON.parse(this.responseText);
                frm.idform.value = res.id;
                document.getElementById("nombreFormulario").textContent = res.nombre;

                // Renderizar los campos del formulario
                if (res.campos) {
                    res.campos.forEach(campo => {
                        agregarCampoALista(campo.label, campo.tipo, campo.nombre, campo.placeholder, campo.required);
                    });
                }
            }
        };
    }

    // Función para agregar un campo dinámico a la lista de campos del formulario
    function agregarCampoALista(label, tipo, nombre, placeholder, required) {
        let campoHTML = `
            <div class="form-group">
                <label>${label}</label>
                <input type="${tipo}" name="respuestas[${nombre}]" class="form-control mt-2" placeholder="${placeholder}" ${required ? 'required' : ''}>
            </div>
        `;
        camposFormulario.innerHTML += campoHTML;
    }

    // Manejar el envío del formulario con respuestas
    frm.addEventListener("submit", function (e) {
        e.preventDefault();

        const data = new FormData(frm);
        const http = new XMLHttpRequest();
        const url = base_url + 'formularios/registrarrespuestas'; // URL para registrar las respuestas
        http.open("POST", url, true);
        http.send(data);

        http.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                const res = JSON.parse(this.responseText);
                alertaPerzonalizada(res.tipo, res.mensaje);
                if (res.tipo === 'success') {
                    window.location.reload(); // Recargar la página después de enviar las respuestas
                }
            }
        };
    });
});
