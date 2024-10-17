const btnUpload = document.querySelector("#btnUpload");
const btnNuevaCarpeta = document.querySelector("#btnNuevaCarpeta");
const btnSubirArchivo = document.querySelector("#btnSubirArchivo");
const file = document.querySelector("#file");


// Capturing modals


const id_carpeta = document.querySelector("#id_carpeta");

const modalFile = document.querySelector("#modalfile");

const myModal = new bootstrap.Modal(modalfile);

const modalCarpeta = document.querySelector("#modalCarpeta");
const myModal1 = new bootstrap.Modal(modalCarpeta);

//edicion de carpetas
const modalCompartir = document.querySelector("#modalCompartir");
const myModalCompartir = new bootstrap.Modal(modalCompartir);
const carpetas = document.querySelectorAll(".carpetas");
const btnSubir = document.querySelector("#btnSubir");
const nombrecarpeta = document.querySelector("#nombre-carpeta");
const nombrecarpetad = document.querySelector("#nombrecarpeta");



// Capturing form
const frmCarpeta = document.querySelector("#frmCarpeta");

document.addEventListener("DOMContentLoaded", function () {
  btnUpload.addEventListener("click", function () {
    myModal.show();
  });

  btnNuevaCarpeta.addEventListener("click", function () {
    myModal.hide();
    myModal1.show();
  });

  frmCarpeta.addEventListener("submit", function (e) {
    e.preventDefault();
    if (frmCarpeta.nombrecarpeta.value == "") {
      alertaPerzonalizada("warning", "Ingrese el nombre de la carpeta");
    } else {
      const data = new FormData(frmCarpeta);
      const http = new XMLHttpRequest();
      const url = base_url + "admin/crearcarpeta";
      http.open("POST", url, true);
      http.send(data);
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          alertaPerzonalizada(res.tipo, res.mensaje);
          if (res.tipo == "success") {
            setTimeout(() => {
              window.location.reload();
            }, 1500);
          }
        }
      };
    }
  });

  //subir archivos
  btnSubirArchivo.addEventListener("click", function () {
    file.click();
    myModal.hide();
  });

  file.addEventListener("change", function (e) {
    console.log(e.target.files[0]);
    const data = new FormData();
    data.append('file', e.target.files[0]); // Correctly append the file
    data.append('id_carpeta', id_carpeta.value);
    data.append('nombrecarpeta', nombrecarpeta.textContent);
    console.log(nombrecarpeta.textContent); // Ensure id_carpeta is appended correctly

    const http = new XMLHttpRequest();
    const url = base_url + "admin/subirarchivo";
    http.open("POST", url, true);
    http.send(data);
    http.onreadystatechange = function () {
      
      if (this.readyState == 4 && this.status == 200) {
        console.log(this.responseText);
        const res = JSON.parse(this.responseText);
        alertaPerzonalizada(res.tipo, res.mensaje);
        if (res.tipo == "success") {
          setTimeout(() => {
            window.location.reload();
          }, 1500);
        }
      }
    };
  });


//edicion de carpetas
  carpetas.forEach((carpeta) => {
    carpeta.addEventListener("click", function (e) {
      id_carpeta.value = e.target.id;
      window.location = base_url + "admin/ver/" + id_carpeta.value;
    });


    carpeta.addEventListener("contextmenu", function (e) {
      e.preventDefault();

      console.log(e.target.id);
      id_carpeta.value = e.target.id;
      nombrecarpetad.value = e.target.nombre;
      myModalCompartir.show();
      nombrecarpeta.textContent = e.target.textContent;
    });

  });




});

btnSubir.addEventListener("click", function () {
  file.click();
  myModalCompartir.hide();
});


//----------------------------------------------------------------------------------------------------------------------


