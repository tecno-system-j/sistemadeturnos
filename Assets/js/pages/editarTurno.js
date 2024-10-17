document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('editar-turno-form');

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        const data = new FormData(form);
        const http = new XMLHttpRequest();
        const url = `turnos/editar/${form.dataset.turnoId}`; // Asegúrate de que el ID del turno esté en un atributo data del formulario

        http.open("POST", url, true);
        http.send(data);
        http.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                const res = JSON.parse(this.responseText);
                alert(res.mensaje); // Asumiendo que el servidor responde con un mensaje
                if (res.tipo === 'success') {
                    alert('Turno actualizado exitosamente');
                }
            }
        };
    });
});