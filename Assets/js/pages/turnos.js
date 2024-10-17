document.addEventListener('DOMContentLoaded', function() {


    const deleteButtons = document.querySelectorAll('.btn-danger');
    const formGenerarTurnos = document.getElementById('formGenerarTurnos');

    

    // Manejo de eliminación de turnos
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const turnoId = this.getAttribute('data-id');
            if (confirm('¿Estás seguro de que quieres eliminar este turno?')) {
                const http = new XMLHttpRequest();
                const url = `turnos/eliminar/${turnoId}`;

                http.open("POST", url, true);
                http.send();
                http.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        const res = JSON.parse(this.responseText);
                        alertaPerzonalizada(res.tipo, res.mensaje); // Asumiendo que el servidor responde con un mensaje
                        if (res.tipo === 'success') {
                            alertaPerzonalizada('success','Turno eliminado exitosamente');
                            window.location.reload();
                        }
                    }
                };
            }
        });
    });

    // Manejo de generación de turnos por mes
    formGenerarTurnos.addEventListener('submit', function(e) {
        e.preventDefault();
        const mesSeleccionado = document.getElementById('mesSeleccionado').value;
        const http = new XMLHttpRequest();
        const url = `generarTurnosPorMes`;

        http.open("POST", url, true);
        http.setRequestHeader("Content-Type", "application/json");
        http.send(JSON.stringify({ mes: mesSeleccionado }));

        http.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                const res = JSON.parse(this.responseText);
                alertaPerzonalizada(res.mensaje);
                if (res.tipo === 'success') {
                    $('#modalGenerarTurnos').modal('hide');
                    alertaPerzonalizada('Turnos generados exitosamente para el mes seleccionado');
                    window.location.reload();
                }
            }
        };
    });

    let tblTurnos;

  tblTurnos = $("#tblTurnos").DataTable({
        
    ajax: {
      url: base_url + "turnos/obtenerTurnos",
      dataSrc: "",
      data: function (d) {
          d.mes = $('#mesFiltro').val(); // Asegúrate de que el mes seleccionado se envía al servidor
      }
    },
    columns: [
      { data: "id" },
      { data: "fecha" },
      { data: "ocupacion" },
      { data: "horario" },
      { data: "acciones" },
    ],
    language: {
      url: "https://cdn.datatables.net/plug-ins/1.13.3/i18n/es-ES.json",
    },
    responsive: true,
    scrollY: "300px",
    scrollCollapse: true,
    paging: false,
    order: [[0, "asc"]],
    

    initComplete: function () {
      // Apply the search
      this.api().columns().every( function () {
          var that = this;

          $( 'input', this.footer() ).on( 'keyup change clear', function () {
              if ( that.search() !== this.value ) {
                  that
                      .search( this.value )
                      .draw();
              }
          } );
      } );
    }
    
  });
  $('#tblTurnos tfoot th').each( function () {
    var title = $(this).text();
    $(this).html( '<input type="text" class="form-control" placeholder="Search '+title+'" />' );
} );

  // Añadir un manejador de eventos para el selector de mes
  document.getElementById('mesFiltro').addEventListener('change', function() {
      console.log('Mes seleccionado:', this.value);  // Esto te mostrará el mes seleccionado en la consola del navegador
      tblTurnos.ajax.reload(); // Recargar la tabla cuando cambie el mes seleccionado
  });

  

    
});

function eliminar (id) {
  const url = base_url + 'turnos/delete/' + id;
  eliminarRegistro('Seguro que quiere eliminar', 'Con esta accion el turno esta desabilitado para elegir', 'warning', 'Si eliminar', url, tblTurnos);
};