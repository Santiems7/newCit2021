<!-- importar php para session -->
<?php
require '../templates/session.php';
?>

<!-- importar class -->
<?php
include_once '../modelo/Classconfig.php';
include_once '../controlador/HTML.php';
?>

<!-- creando objetos -->
<?php
$objectoClassconfig = new Classconfig();
$conn = $objectoClassconfig->openServer();
$objetoAlertaC = new Alertas($conn);
?>

<!-- importar php head: declaraciones hmtl iniciales, imagenes tipo vector y sidebar -->
<?php
require '../templates/head.php';
?>

<!-- Barra de navegación -->
<?php
require '../templates/headers/headerHome.php';
?>

<!-- contenido -->
<main class="ms-sm-auto col-lg-10 px-md-4">
  <!-- div del main -->
  <div class="d-flex flex-column flex-shrink-0 p-3 col-10  mx-auto">
    <div class="row gap-5 d-flex justify-content-center">

      <div class="card bg-ligh rounded-4" style="width: 15rem; min-height: 79vh; ">
        <div class="table-responsive mt-3" style="max-height: 38rem; overflow-y: auto; padding:0; margin:0; border:0;">
          <table class="table  table-warning table-striped align-middle m-0">
            <!--<caption>List of users</caption>-->
            <thead class="table-secondary sticky-top p-0" style="z-index: 1; position: sticky; bottom: 0;">
              <tr>
                <th class="h1 rounded-top-4" scope="col" style="text-align: center;">El&eacute;ctricos</th>
              </tr>
            </thead>
          </table>
        </div>
        <div class="table-responsive" style="max-height: 38rem; overflow-y: auto; padding:0; margin:0; border:0;">
          <table class="table table-striped align-middle m-0">
            <!--<caption>List of users</caption>-->
            <thead class="table-orange sticky-top p-0" style="z-index: 1; position: sticky; bottom: 0;">
              <tr>
                <th scope="col" style="text-align: center;">Nombre</th>
                <th scope="col" style="text-align: center;">Cantidad</th>
              </tr>
            </thead>
            <tbody>
              <?php echo $objetoAlertaC->materiales('electrico'); ?>
            </tbody>
          </table>
        </div>
      </div>
      <div class="card bg-light rounded-4" style="width: 15rem; min-height: 79vh">
        <div class="table-responsive mt-3" style="max-height: 38rem; overflow-y: auto; padding:0; margin:0; border:0;">
          <table class="table  table-warning table-striped align-middle m-0">
            <!--<caption>List of users</caption>-->
            <thead class="table-secondary sticky-top p-0" style="z-index: 1; position: sticky; bottom: 0;">
              <tr>
                <th class="h1 rounded-top-4" scope="col" style="text-align: center;">ITCs</th>
              </tr>
            </thead>
          </table>
        </div>
        <div class="table-responsive" style="max-height: 38rem; overflow-y: auto; padding:0; margin:0; border:0;">
          <table class="table table-striped align-middle m-0">
            <!--<caption>List of users</caption>-->
            <thead class="table-orange sticky-top p-0" style="z-index: 1; position: sticky; bottom: 0;">
              <tr>
                <th scope="col" style="text-align: center;">Nombre</th>
                <th scope="col" style="text-align: center;">Cantidad</th>
              </tr>
            </thead>
            <tbody>
              <?php echo $objetoAlertaC->materiales('itc'); ?>
            </tbody>
          </table>
        </div>
      </div>

      <div class="card bg-light rounded-4" style="width: 15rem; min-height: 79vh">
        <div class="table-responsive mt-3" style="max-height: 38rem; overflow-y: auto; padding:0; margin:0; border:0;">
          <table class="table  table-warning table-striped align-middle m-0">
            <!--<caption>List of users</caption>-->
            <thead class="table-secondary sticky-top p-0" style="z-index: 1; position: sticky; bottom: 0;">
              <tr>
                <th class="h1 rounded-top-4" scope="col" style="text-align: center;">Mec&aacute;nicos</th>
              </tr>
            </thead>
          </table>
        </div>
        <div class="table-responsive" style="max-height: 38rem; overflow-y: auto; padding:0; margin:0; border:0;">
          <table class="table table-striped align-middle m-0">
            <!--<caption>List of users</caption>-->
            <thead class="table-orange sticky-top p-0" style="z-index: 1; position: sticky; bottom: 0;">
              <tr>
                <th scope="col" style="text-align: center;">Nombre</th>
                <th scope="col" style="text-align: center;">Cantidad</th>
              </tr>
            </thead>
            <tbody>
              <?php echo $objetoAlertaC->materiales('mecanico'); ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div class="container-fluid d-grid gap-2 d-md-flex justify-content-md-end ms-sm-auto p-1 sticky-bottom bg-light">
      <a href="materiales.php" class="btn btn-secondary m-3">Ir a El&eacute;ctricos del mes</a>
      <a href="itc.php" class="btn btn-secondary m-3">Ir a ITCs del mes</a>
      <a href="mecanico.php" class="btn btn-secondary m-3">Ir a Mec&aacute;nicos del mes</a>
    </div>
  </div>


  <!-- importar php footer -->
  <?php
  require '../templates/footer.php';
  ?>