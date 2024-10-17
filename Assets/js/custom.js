// Here goes your custom javascript

function alertaPerzonalizada(type, mensaje, icon, color) {
  const Toast = Swal.mixin({
    toast: true,

    position: "top-end",

    showConfirmButton: false,

    timer: 2000,

    iconHtml: icon,

    iconColor: color,

    timerProgressBar: true,

    didOpen: (toast) => {
      toast.addEventListener("mouseenter", Swal.stopTimer);

      toast.addEventListener("mouseleave", Swal.resumeTimer);

      toast.addEventListener("click", Swal.close);
    },
  });

  Toast.fire({
    icon: type,

    title: mensaje,
  });
}

function eliminarRegistro(title, text, icono, accion, url) {
  Swal.fire({
    title: title,

    text: text,

    icon: "warning",

    showCancelButton: true,

    confirmButtonColor: "#3085d6",

    cancelButtonColor: "#d33",

    confirmButtonText: accion,
  }).then((result) => {
    if (result.isConfirmed) {
      const http = new XMLHttpRequest();

      http.open("GET", url, true);

      http.send();

      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          alertaPerzonalizada(res.tipo, res.mensaje);
          if (res.tipo == "success") {
            tblUsuarios.ajax.reload();
            tblTurnosAsignados.ajax.reload();
          }
        }
      };
    }
  });
}

function liberarturno(title, text, icono, accion, url) {
  Swal.fire({
    title: title,

    text: text,

    icon: "warning",

    showCancelButton: true,

    confirmButtonColor: "#3085d6",

    cancelButtonColor: "#d33",

    confirmButtonText: accion,
  }).then((result) => {
    if (result.isConfirmed) {
      const http = new XMLHttpRequest();

      http.open("GET", url, true);

      http.send();

      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          alertaPerzonalizada(res.tipo, res.mensaje);
          if (res.tipo == "success") {
            tblTurnosAsignados.ajax.reload();
            tblTurnosdisponibles.ajax.reload();

          }
        }
      };
    }
  });
}

function asignaralerta(title,text,icon,accion,url,fecha,ocupacion,horario) {
  Swal.fire({
    title: title,
    text: text,
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: accion,
  }).then((result) => {
    if (result.isConfirmed) {
      const http = new XMLHttpRequest();
      http.open("GET", url, true);
      http.send();
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          alertaPerzonalizada(res.tipo, res.mensaje);
          if (res.tipo == "success") {
            tblTurnosAsignados.ajax.reload();
            tblTurnosdisponibles.ajax.reload();
            const data = {
              fecha: fecha,
              ocupacion: ocupacion,
              horario: horario,
            };
            console.log(data);

            const http = new XMLHttpRequest();
            const urlc = base_url + "turnos/enviarcorreo";
            http.open("POST", urlc, true);
            http.setRequestHeader(
              "Content-Type",
              "application/x-www-form-urlencoded"
            ); // Asegúrate de establecer el tipo de contenido
            const datosEnviar = `fecha=${encodeURIComponent(
              fecha
            )}&ocupacion=${encodeURIComponent(
              ocupacion
            )}&horario=${encodeURIComponent(horario)}`;
            http.send(datosEnviar); // Enviar datos
            http.onreadystatechange = function () {
              
            };
          }
        }
      };
    }
  });
}

function acceso(params) {
  let timerInterval;

  Swal.fire({
    title: "Auto close alert!",

    html: "I will close in <b></b> milliseconds.",

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
    /* Read more about handling dismissals below */

    if (result.dismiss === Swal.DismissReason.timer) {
      console.log("Cerrado por el tiempo");
    }
  });
}

function cargando(type, mensaje, icon) {
  const Toast = Swal.mixin({
    toast: true,

    position: "top-end",

    showConfirmButton: false,

    timer: 3000,

    iconHtml: icon,

    timerProgressBar: true,

    didOpen: (toast) => {
      toast.addEventListener("mouseenter", Swal.resumeTimer);

      toast.addEventListener("mouseleave", Swal.resumeTimer);
    },
  });

  Toast.fire({
    icon: "info",

    title: "Cargando",
  });
}

function correcto(type, mensaje, icon) {
  const Toast = Swal.mixin({
    toast: true,

    position: "top-end",

    showConfirmButton: false,

    timer: 5000,

    iconHtml: icon,

    timerProgressBar: true,

    didOpen: (toast) => {
      toast.addEventListener("mouseenter", Swal.resumeTimer);

      toast.addEventListener("mouseleave", Swal.resumeTimer);
    },
  });

  Toast.fire({
    icon: "success",

    title: mensaje,
  });
}
