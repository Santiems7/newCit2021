function copiarTexto(texto) {
  var tempElement = document.createElement("textarea");
  tempElement.value = texto;
  document.body.appendChild(tempElement);
  tempElement.select();

  try {
    var successful = document.execCommand("copy");
    var msg = successful
      ? "Texto copiado al portapapeles"
      : "Error al copiar el texto";
    alert(msg);
  } catch (err) {
    console.error("Error al intentar copiar el texto: ", err);
  }

  document.body.removeChild(tempElement);
}
