const frmCrear = document.querySelector("#formularios");

document.addEventListener("DOMContentLoaded", function () {
    frmCrear.addEventListener("submit", function (e) {
        e.preventDefault();
        const data = new FormData(frmCrear);
        const http = new XMLHttpRequest();
        const url = base_url + 'formularios/crear';
        http.open("POST", url, true);
        http.send(data);
        http.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                const res = JSON.parse(this.responseText);
                alertaPerzonalizada(res.tipo, res.mensaje);
                if (res.tipo === 'success') {
                    frmCrear.reset(); // Limpia el formulario tras la creación exitosa
                }
            }
        };
    });
});
    