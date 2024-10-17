const frm = document.querySelector("#formEditarFormulario");
const agregarCampoBtn = document.getElementById("agregarCampo");
const listaCampos = document.getElementById("listaCampos");
const tablaMetricas = document.getElementById("tablaMetricas");
const tablaRespuestasHeader = document.getElementById("tablaRespuestasHeader");
const tablaRespuestas = document.getElementById("tablaRespuestas");

document.addEventListener("DOMContentLoaded", function () {
    let urls = window.location.href;

    // Obtener todo lo que está después del último "/"
    let idform = urls.substring(urls.lastIndexOf('/') + 1);

    // Si no hay nada después del último "/", toma lo que está antes
    if (!idform || idform === '') {
        // Elimina el último "/" y toma lo que queda antes de él
        urls = urls.slice(0, urls.lastIndexOf('/'));
        idform = urls.substring(urls.lastIndexOf('/') + 1);
    }

    if (!idform) {
        alertaPerzonalizada("error", "Id de formulario invalido");

        return;
    }

    // Cargar los datos del formulario para editar
    cargarFormulario(idform);

    // Cargar las métricas, gráficas y respuestas
    cargarMetricasYGraficas(idform);

    // Función para cargar los datos del formulario
    function cargarFormulario(id) {
        const http = new XMLHttpRequest();
        const url = base_url + "formularios/editarform/" + id;

        http.open("GET", url, true);
        http.send();

        http.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                const res = JSON.parse(this.responseText);
                frm.idform.value = res.id;
                frm.nombreFormulario.value = res.nombre;
                frm.descripcion.value = res.descripcion;

                // Si hay campos asociados al formulario, los renderizamos
                if (res.campos) {
                    res.campos.forEach(campo => {
                        agregarCampoALista(campo.label, campo.tipo, campo.nombre, campo.placeholder, campo.required);
                    });

                    // Agregar los nombres de los campos a la tabla de respuestas
                    tablaRespuestasHeader.innerHTML = '';
                    res.campos.forEach(campo => {
                        const th = document.createElement('th');
                        th.innerText = campo.label; // Mostrar el nombre del campo
                        tablaRespuestasHeader.appendChild(th);
                    });
                }

                // Añadir lógica para cargar turnos disponibles si corresponde
                if (res.tipo === 'turnos') {
                    cargarTurnosDisponibles(id);
                }
            }
        };
    }

    // Función para cargar las métricas, gráficas y respuestas
    function cargarMetricasYGraficas(id) {
        const http = new XMLHttpRequest();
        const url = base_url + "formularios/metricas/" + id;

        http.open("GET", url, true);
        http.send();

        http.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                const res = JSON.parse(this.responseText);

                // Cargar la tabla de respuestas
                cargarTablaRespuestas(id);
            }
        };
    }

    // Función para cargar la tabla de respuestas
    function cargarTablaRespuestas(id) {
        const http = new XMLHttpRequest();
        const url = base_url + "formularios/respuestas/" + id;

        http.open("GET", url, true);
        http.send();

        http.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                const res = JSON.parse(this.responseText);

                // Limpiar la tabla de respuestas antes de llenarla
                tablaRespuestas.innerHTML = '';
                tablaRespuestasHeader.innerHTML = '';

                // Llenar los encabezados de la tabla
                res.campos.forEach(campo => {
                    const th = document.createElement('th');
                    th.innerText = campo.nombre;
                    tablaRespuestasHeader.appendChild(th);
                });

                // Llenar la tabla de respuestas
                res.respuestas.forEach(respuesta => {
                    const row = document.createElement('tr');
                    res.campos.forEach(campo => {
                        const td = document.createElement('td');
                        td.innerText = respuesta[campo.nombre] || '';
                        row.appendChild(td);
                    });
                    tablaRespuestas.appendChild(row);
                });

                // Inicializar o reinicializar DataTable
                if ($.fn.DataTable.isDataTable('#datatable1')) {
                    $('#datatable1').DataTable().destroy();
                }
                $('#datatable1').DataTable({
                    language: {
                        url: "https://cdn.datatables.net/plug-ins/1.13.3/i18n/es-ES.json",
                    },
                    responsive: true,
                    order: [[1, "desc"]],
                });
            }
        };
    }

    // Función para agregar un campo dinámico a la lista dentro de una tarjeta (card)
    function agregarCampoALista(label = "", tipo = "text", nombre = "", placeholder = "", required = false) {
        const nuevoCampo = document.createElement("li");
        nuevoCampo.classList.add("list-group-item");

        nuevoCampo.innerHTML = `
            <div class="card mt-2">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 col-lg-4">
                            <div class="form-group">
                                <label>Label del Campo</label>
                                <input type="text" name="campo_label[]" class="form-control mt-2" placeholder="Label" value="${label}">
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-4">
                            <div class="form-group">
                                <label>Tipo de Campo</label>
                                <select name="campo_tipo[]" class="form-control mt-2">
                                    <option value="text" ${tipo === "text" ? "selected" : ""}>Texto</option>
                                    <option value="email" ${tipo === "email" ? "selected" : ""}>Email</option>
                                    <option value="number" ${tipo === "number" ? "selected" : ""}>Número</option>
                                    <option value="date" ${tipo === "date" ? "selected" : ""}>Fecha</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-4">
                            <div class="form-group">
                                <label>Nombre del Campo (name)</label>
                                <input type="text" name="campo_nombre[]" class="form-control mt-2" placeholder="Nombre del campo" value="${nombre}">
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-4">
                            <div class="form-group">
                                <label>Placeholder</label>
                                <input type="text" name="campo_placeholder[]" class="form-control mt-2" placeholder="Placeholder" value="${placeholder}">
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-2">
                            <div class="form-group d-flex align-items-center mt-4">
                                <label class="me-2">¿Requerido?</label>
                                <input type="checkbox" name="campo_required[]" class="form-check-input" ${required ? "checked" : ""}>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-2 d-flex align-items-center justify-content-end">
                            <button type="button" class="btn btn-danger eliminar mt-2">Eliminar</button>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        listaCampos.appendChild(nuevoCampo);

        // Asignar el evento click al botón "Eliminar"
        const eliminarBtn = nuevoCampo.querySelector('.eliminar');
        eliminarBtn.addEventListener('click', function() {
            eliminarCampo(eliminarBtn);
        });
    }

    // Función para permitir el reordenamiento de campos usando Sortable.js
    new Sortable(listaCampos, {
        animation: 150,
        onEnd: function (/**Event*/evt) {
            const items = evt.from.children;
            console.log('Nuevo orden:', [...items].map(item => item.innerText.trim()));
            // Aquí puedes actualizar el orden en la base de datos si lo necesitas
        }
    });

    // Evento para agregar un campo nuevo
    agregarCampoBtn.addEventListener("click", function () {
        agregarCampoALista();
    });

    // Función para eliminar un campo
    function eliminarCampo(btn) {
        const campo = btn.parentNode.parentNode;
        campo.parentNode.removeChild(campo);
    }

    // Manejar el envío del formulario de edición
    frm.addEventListener("submit", function (e) {
        e.preventDefault();

        const data = new FormData(frm);
        const http = new XMLHttpRequest();
        const url = base_url + 'formularios/actualizar'; // URL para actualizar el formulario
        http.open("POST", url, true);
        http.send(data);

        http.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                const res = JSON.parse(this.responseText);
                alertaPerzonalizada(res.tipo, res.mensaje);
                if (res.tipo === 'success') {
                    window.location.reload(); // Recargar la página después de la actualización exitosa
                }
            }
        };
    });

    // Función para cargar turnos disponibles
    function cargarTurnosDisponibles(id) {
        const http = new XMLHttpRequest();
        const url = base_url + "formularios/turnosDisponibles/" + id;
        http.open("GET", url, true);
        http.send();
        http.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                const turnos = JSON.parse(this.responseText);
                turnos.forEach(turno => {
                    if (turno.disponible) {
                        agregarTurnoALista(turno.ocupacion, turno.horario);
                    }
                });
            }
        };
    }

    // Función para agregar un turno a la lista
    function agregarTurnoALista(ocupacion, horario) {
        const nuevoTurno = document.createElement("li");
        nuevoTurno.classList.add("list-group-item");

        nuevoTurno.innerHTML = `
            <div class="card mt-2">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 col-lg-4">
                            <div class="form-group">
                                <label>Label del Turno</label>
                                <input type="text" name="turno_label[]" class="form-control mt-2" placeholder="Label" value="${ocupacion}">
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-4">
                            <div class="form-group">
                                <label>Tipo de Turno</label>
                                <select name="turno_tipo[]" class="form-control mt-2">
                                    <option value="turno" selected>Turno</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-4">
                            <div class="form-group">
                                <label>Nombre del Turno (name)</label>
                                <input type="text" name="turno_nombre[]" class="form-control mt-2" placeholder="Nombre del turno" value="${horario}">
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-2">
                            <div class="form-group d-flex align-items-center mt-4">
                                <label class="me-2">¿Disponible?</label>
                                <input type="checkbox" name="turno_disponible[]" class="form-check-input" checked>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-2 d-flex align-items-center justify-content-end">
                            <button type="button" class="btn btn-danger eliminar mt-2">Eliminar</button>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        listaCampos.appendChild(nuevoTurno);

        // Asignar el evento click al botón "Eliminar"
        const eliminarTurnoBtn = nuevoTurno.querySelector('.eliminar');
        eliminarTurnoBtn.addEventListener('click', function() {
            eliminarTurno(eliminarTurnoBtn);
        });
    }

    // Función para eliminar un turno
    function eliminarTurno(btn) {
        const turno = btn.parentNode.parentNode;
        turno.parentNode.removeChild(turno);
    }

});
