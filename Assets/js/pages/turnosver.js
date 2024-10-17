let tblTurnosdisponibles;
let tblTurnosAsignados;

document.addEventListener('DOMContentLoaded', function() {
    

      tblTurnosdisponibles = $("#tblTurnosDisponibles").DataTable({
          
      ajax: {
        url: base_url + "turnos/obtenerTurnosdisponibles",
        dataSrc: "",
        data: function (d) {
            d.mes = $('#mesFiltro').val(); // Asegúrate de que el mes seleccionado se envía al servidor
        }
      },
      columns: [
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
    $('#tblTurnosDisponibles tfoot th').each( function () {
      var title = $(this).text();
      $(this).html( '<input type="text" class="form-control" placeholder="Search '+title+'" />' );

  } );








  // Añadir un manejador de eventos para el selector de mes
  document.getElementById('mesFiltro').addEventListener('change', function() {
      console.log('Mes seleccionado:', this.value);  // Esto te mostrará el mes seleccionado en la consola del navegador
      tblTurnosAsignados.ajax.reload(); // Recargar la tabla cuando cambie el mes seleccionado
  });




  tblTurnosAsignados = $("#tblTurnosAsignados").DataTable({
          
      ajax: {
        url: base_url + "turnos/obtenerTurnosasigandosnombre",
        dataSrc: "",
        data: function (d) {
            d.mes = $('#mesFiltro').val(); // Asegúrate de que el mes seleccionado se envía al servidor
        }
      },
      columns: [
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
    $('#tblTurnosAsignados tfoot th').each( function () {
      var title = $(this).text();
      $(this).html( '<input type="text" class="form-control" placeholder="Search '+title+'" />' );
  } );

  

});

function eliminar (id) {
    const url = base_url + 'turnos/liberar/' + id;
    liberarturno('Seguro que quiere liberar', 'Con esta accion el turno se podra eleigir por otros usuarios', 'warning', 'Si liberar', url, tblTurnosAsignados);
    tblTurnosAsignados.ajax.reload();
  };

  function asignar (id, fecha, ocupacion, horario) {
    const url = base_url + 'turnos/asignar/' + id;
    asignaralerta('Asignar', 'Desea asignar el turno?', 'success', 'Si Asignar', url, fecha, ocupacion, horario);
    tblTurnosAsignados.ajax.reload();
    tblTurnosdisponibles.ajax.reload();
    /* const data = { fecha: fecha, ocupacion: ocupacion, horario: horario };
    console.log(data);

      const http = new XMLHttpRequest();
      const urlc = base_url + 'turnos/enviarcorreo';
      http.open("POST", urlc, true);
      http.send(data);
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {                      
          const res = JSON.parse(this.responseText);
          alertaPerzonalizada(res.tipo, res.mensaje);
          if (res.tipo == 'success') {
            alertaPerzonalizada("success", "Envio exitoso");
            tblTurnosAsignados.ajax.reload();
            tblTurnosdisponibles.ajax.reload();
          }
        }
      }; */ 
  };

