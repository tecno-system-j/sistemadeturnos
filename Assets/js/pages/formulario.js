const formulariosid = document.querySelectorAll(".forms");
const idform = document.querySelector("#idform");

formulariosid.forEach((formulario) => {
    formulario.addEventListener("click", function (e) {
      idform.value = e.target.id;
      window.location = base_url + "formularios/editar/" + idform.value;
    });

  });