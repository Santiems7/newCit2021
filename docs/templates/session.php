<?php
// iniciar sesión 
session_start();
// verifica si valido el ingreso 
if (!isset($_SESSION['correoIngreso'])) {
  // Si el usuario no ha iniciado sesión, redirígelo a la página de inicio de sesión
  header('Location: ingreso.php');
  exit;
}
?>
<?php
if (isset($_POST['cerrar_sesion'])) {
  // Destruye la sesión
  session_destroy();
  // Redirige al usuario a la página de inicio de sesión
  header('Location: ingreso.php');
  exit;
}
?>