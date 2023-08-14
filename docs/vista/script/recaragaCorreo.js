
document.getElementById("submit-button").addEventListener("click", function() {
  var xhr = new XMLHttpRequest();
  var formData = new FormData(document.getElementById("formulario"));

  xhr.onreadystatechange = function() {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        // Se recibió una respuesta satisfactoria del servidor
        alert("Usuario registrado correctamente.");
        // Aquí puedes realizar cualquier otra acción después del registro exitoso
      } else {
        // Ocurrió un error en la solicitud AJAX
        alert("Error al registrar el usuario.");
      }
    }
  };

  xhr.open("POST", "registro.php", true);
  xhr.send(formData);
});
