const frm = document.querySelector("#formulario");
const frmeditar = document.querySelector("#formularioeditar");

const modalRegistro = document.querySelector("#modalRegistro");

const myModal = new bootstrap.Modal(modalRegistro);

let tblUsuarios;

document.addEventListener("DOMContentLoaded", function () {
  //Cargar datos de tabla con DataTables

  tblUsuarios = $("#tblUsuarios").DataTable({
    ajax: {
      url: base_url + "usuarios/listar",
      dataSrc: "",
    },
    columns: [
      { data: "acciones" },
      { data: "id" },
      { data: "nombres" },
      { data: "correo" },
      { data: "telefono" },
      { data: "direccion" },
      { data: "perfil" },
      { data: "fecha" },
    ],
    language: {
      url: "https://cdn.datatables.net/plug-ins/1.13.3/i18n/es-ES.json",
    },
    responsive: true,
    order: [[1, "desc"]],
  });

  btnNuevo.addEventListener("click", function () {
    title.textContent = "Registrar Usuario";
    frm.id_usuario.value = "";
    frm.reset();
    frm.clave.removeAttribute("readonly", "readonly");
    myModal.show();
  });

  frm.addEventListener("submit", function (e) {
    e.preventDefault();
    if (
      frm.nombre.value == "" ||
      frm.apellido.value == "" ||
      frm.direccion.value == "" ||
      frm.telefono.value == "" ||
      frm.correo.value == "" ||
      frm.clave.value == "" ||
      frm.rol.value == ""
    ) {
      alertaPerzonalizada("warning", "Todos los campos son requeridos");
    } else {
      const data = new FormData(frm);
      console.log(data);
      const http = new XMLHttpRequest();
      const url = base_url + 'usuarios/guardar';
      http.open("POST", url, true);
      http.send(data);
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {                      
          const res = JSON.parse(this.responseText);
          alertaPerzonalizada(res.tipo, res.mensaje);
          if (res.tipo == 'success') {
            frm.reset();
            myModal.hide();
            alertaPerzonalizada("success", "Registro Exitoso");
            tblUsuarios.ajax.reload();
          }
        }
      };
    }
  });
});
function eliminar(id) {
  const url = base_url + "usuarios/delete/" + id;
  eliminarRegistro(
    "Seguro que quiere eliminar",
    "El usuario no se eliminara de forma permanente",
    "warning",
    "Si eliminar",
    url,
    tblUsuarios
  );
}

function editar(id) {
  const http = new XMLHttpRequest();

  const url = base_url + "usuarios/editar/" + id;

  http.open("GET", url, true);

  http.send();

  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      title.textContent = "Editar Usuario";
      //console.log(this.responseText);
      const res = JSON.parse(this.responseText);
      frm.id_usuario.value = res.id;
      frm.nombre.value = res.nombre;
      frm.apellido.value = res.apellido;
      frm.correo.value = res.correo;
      frm.telefono.value = res.telefono;
      frm.direccion.value = res.direccion;
      frm.clave.value = "00000000000";
      frm.clave.setAttribute("readonly", "readonly");
      frm.rol.value = res.rol;
      myModal.show();
    }
  };
}
