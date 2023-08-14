// script para mostrar contraseña //

// Obtener el botón de conmutación y el campo de contraseña
var togglePassword = document.getElementById("togglePassword");
var passwordField = document.getElementById("floatingPassword1");
// Función para cambiar el tipo de entrada del campo de contraseña
function togglePasswordField() {
  if (passwordField.type === "password") {
    passwordField.type = "text";
    togglePassword.innerHTML =
      '<a  class="nav-link  link-body-emphasis " ><svg class="bi pe-none me-2" width="20" height="20"><use xlink:href="#Eye slash fill"/></svg></a>';
  } else {
    passwordField.type = "password";
    togglePassword.innerHTML =
      '<a class="nav-link  link-body-emphasis " ><svg class="bi pe-none me-2" width="20" height="20"><use xlink:href="#Eye fill"/></svg></a>';
  }
}
// Escuchar el evento click del botón de conmutación
togglePassword.addEventListener("click", togglePasswordField);
