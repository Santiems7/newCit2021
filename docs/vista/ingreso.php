<?php 
  session_start();
?>

<!-- importar class -->
<?php
  require_once("../modelo/Classconfig.php");
  require_once("../controlador/Usuarios.php");
  require_once("../controlador/SelectAdministradores.php");
  require_once("../controlador/Correo.php");
?>

<!-- creando objetos -->
<?php
  $objectoClassconfig= new Classconfig();
  $conn = $objectoClassconfig->openServer();
  $objetoEliminarCorrespondencia = new EliminarCorrespondencia($conn,'recibidacalma','idRC');
  $objetoRecibidaInvias = new RecibidaInvias($conn);
  $objetoActualizarR = new ActualizarCorrespondendecia($conn,'recibidacalma');
?>

<?php
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sql = "SELECT * FROM usuario";
    $resultado = mysqli_query($conn, $sql);
    while ($fila = mysqli_fetch_assoc($resultado)) {
        if($fila['correoUsuario'] === $_POST['correoIngreso'] && $fila['claveUsuario'] === MD5($_POST['claveIngreso'])){
          echo 'hola';
          $_SESSION['correoIngreso'] = $_POST['correoIngreso'];
          header('Location: start.php');
          exit;
        }else{
          $error = 'Nombre de usuario o contraseña incorrectos.';
        }
    }
  }
?>

<!-- Importes -->
<?php 

?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
  <link rel="stylesheet" href="css/mycss.css">
  <link rel="icon" href="images/iconCIT2021.png">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <title>CIT2021</title>
</head>
<body class="d-flex align-items-center py-4 bg-body-tertiary" >
  

  <main class="form-signin w-100 m-auto">
    <form method="post" action="">
      <figure class="text-center" >
        <img class="mb-5 " src="images/iconCIT2021.png" alt="" width="150" height="150">
      </figure>
      
      <div class="form-floating">
        <input type="email" class="form-control mb-1" id="floatingInput" placeholder="name@example.com" name="correoIngreso">
        <label for="floatingInput">Direcci&oacute;n de correo electr&oacute;nico</label>
      </div>
      
      <div class="form-floating">
        <input type="password" class="form-control mb-1" id="floatingPassword" placeholder="Password" name="claveIngreso" >
        <label for="floatingPassword">Contraseña</label>
      </div>

      <div class="form-check text-start my-3">
        <input class="form-check-input" type="checkbox" value="remember-me" id="flexCheckDefault">
        <label class="form-check-label" for="flexCheckDefault">
          Recordar 
        </label>
      </div>
      <button class="btn btn-primary w-100 py-2" type="submit">Ingresar</button>
    </form>
    
    <p class="mt-5 mb-3 text-body-secondary">&copy; CIT2021. Created-2023</p>
    
  
<?php
  require '../templates/footer.php';
?>     
  


