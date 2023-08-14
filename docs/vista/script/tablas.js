// Inicialización de DataTables en tu tabla
$(document).ready(function () {
  var table = $("#tabla").DataTable({
    searching: true,
    language: {
      url: "../node_modules/datatables.net-plugins/i18n/es-CL.json",
    },
    scrollY: " 30rem", // Altura fija vertical de la tabla (ajústala según tus necesidades)
    scrollX: true,
    // Permitir el desplazamiento horizontal
    scrollCollapse: true, // Permitir el colapso del desplazamiento
    // Puedes agregar más opciones y configuraciones según tus necesidades
  });
});
