<!-- importar class -->
<?php
require_once("../controlador/Administrador.php");
?>

<!-- importar php para session -->
<?php
require '../templates/session.php'
  ?>

<!-- creando objetos -->
<?php
$objectoClassconfig = new Classconfig();
$conn = $objectoClassconfig->openServer();
$objectoAdministrador = new Administrador($conn, $_SESSION['correoIngreso']);
?>

<!-- validación de administrador -->
<?php
// verifica que el usuario ingredo cuente con el cargo Administrador
$cargo = null;
$cargo = $objectoAdministrador->verificarAdministrador();
if ($cargo !== 'Administrador' && $cargo !== 'Auxiliar Sistemas' && $cargo !== 'Auxiliar Civil') {
  // Si el usuario no es adminstrador, redirígelo a la página de start.php
  header('Location: start.php');
  exit;
}
?>