<!-- importar verificacion de administrador -->
<?php
require '../templates/sessionAdmin.php'
  ?>

<!-- importar class -->
<?php
include_once '../modelo/Classconfig.php';
include_once '../controlador/Usuarios.php';
include_once '../controlador/Correo.php';
include_once '../Controlador/HTML.php';
?>

<!-- creando objetos -->
<?php
$objectoClassconfig = new Classconfig();
$conn = $objectoClassconfig->openServer();
$objectoRegistrar = new Registrar($conn);
$objectoRegistrados = new Correo($conn);
$objectoSelects = new Selects($conn);
?>

<!-- importar php head: declaraciones hmtl iniciales, imagenes tipo vector y sidebar -->
<?php
require '../templates/head.php';
?>

<!-- Barra de navegación -->
<?php
require '../templates/headers/headerControlUsuarios.php';
?>

<!-- contenido -->
<main class="ms-sm-auto col-lg-10 px-md-3">
  <!-- div del segundo nav -->



  <!-- div del main -->
  <div class="d-flex flex-column flex-shrink-0 p-3 col-8  mx-auto">

    <div class="alert alert-light d-flex align-items-center justify-content-center" id="tituloRegistro" role="alert">

      <label class="h1" for="tituloRegistro"><strong>Registro</strong></label>
    </div>

    <!-- formato de registro -->
    <form method="post" action="registro.php" id="formulario">
      <!-- input: nombre -->
      <div class="form-floating mb-3 ">
        <input type="text" class="form-control" id="floatingInput1" placeholder="Nombre" name="nombreUsuario" value=''
          required>
        <label for="floatingInput1">Nombre *</label>
      </div>
      <!-- input: Apellidos -->
      <div class="form-floating mb-3 ">
        <input type="text" class="form-control" id="floatingInput2" placeholder="Apellido" name="apellidosUsuario"
          value='' required>
        <label for="floatingInput2">Apellidos *</label>
        <div class="valid-feedback">correcto!</div>
      </div>
      <!-- input: correo -->
      <div class="form-floating mb-3 ">
        <input type="email" class="form-control" id="floatingInput3"
          placeholder="Direcci&oacute;n de correo electr&oacute;nico" name="correoUsuario" value="" pattern="^(?!.*(<?php
          echo $objectoRegistrados->correosRegistrados(); ?>)).*$" title="El correo ya est&aacute; registrado."
          required>
        <label for="floatingInput3">Direcci&oacute;n de correo electr&oacute;nico *</label>
      </div>
      <!-- input: contraseña -->
      <?php $typePassword = "password"; ?>
      <div class="row rowPassword">
        <div class="col-11">
          <div class="form-floating">
            <input type="<?php echo $typePassword; ?>" class="form-control" id="floatingPassword1"
              placeholder="Contrase&ntilde;a" name="claveUsuario" value=''
              pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@#$%^&+=])[a-zA-Z\d@#$%^&+=]{8,}$" required>
            <label for="floatingPassword1">Contrase&ntilde;a *</label>
          </div>
        </div>
        <div class="col-1">
          <button type="button" id="togglePassword" class="form-control buttonEyes">
            <a class="nav-link  link-body-emphasis ">
              <svg class="bi pe-none me-2" width="20" height="20">
                <use xlink:href="#Eye fill" />
              </svg>
            </a>
          </button>
        </div>
        <label class="activeLabel mb-3">La contrase&ntilde;a debe tener al menos una letra min&uacute;scula, una
          may&uacute;scula y un n&uacute;mero, y tener una longitud m&iacute;nima de 8 caracteres.</label>
      </div>
      <!-- select: cargo -->
      <label class="activeLabel">Seleccione el cargo asignado.</label>
      <div class="centrarSelect form-floating mb-3">
        <select class="form-select " aria-label="Default select example" name="cargoUsuario">
          <?php echo $objectoSelects->cargoBasico(); ?>
        </select>
      </div>
      <hr class="my-4">

      <div class="d-grid gap-2 d-md-flex justify-content-md-end">
        <button type="submit" class="btn btn-primary" name="registrar" value="registrar"
          id="submit-button">Registrar</button>
      </div>


    </form>


    <!-- Agrega el código JavaScript para enviar el formulario mediante AJAX -->

    <!-- php para el form de registro -->
    <?php
    if (isset($_POST['registrar'])) {
      try {
        // Enviar el correo electrónico
        $objectoRegistrados->envio($_POST['correoUsuario'], $_POST['nombreUsuario'] . ' ' . $_POST['apellidosUsuario'], $_POST['claveUsuario'], $_POST['cargoUsuario']);
        // Realizar registro
        $objectoRegistrar->Registro($_POST['nombreUsuario'], $_POST['apellidosUsuario'], $_POST['correoUsuario'], $_POST['claveUsuario'], $_POST['cargoUsuario']);

        echo "<script language='JavaScript' type='text/javascript'>
        alert('Usuario registrado correctamente.');
        </script>";
      } catch (Exception $e) {
        echo "<script language='JavaScript' type='text/javascript'>
        alert('Error al registrar el usuario: " . $e->getMessage() . "');
        </script>";
      }
      exit();
    }
    ?>
  </div>

  <!-- importar php footer -->
  <?php
  require '../templates/footer.php';
  ?>