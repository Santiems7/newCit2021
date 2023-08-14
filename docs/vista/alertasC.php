<!-- importar php para session -->
<?php
require '../templates/session.php'
?>

<!-- importar class -->
<?php
  include_once '../modelo/Classconfig.php';
  include_once '../controlador/HTML.php'; 
?> 

<!-- creando objetos -->
<?php
  $objectoClassconfig= new Classconfig();
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
  <div class="d-flex flex-column flex-shrink-0 p-3 col-10  mx-auto" >  
    <div class="row gap-5 d-flex justify-content-center">
      
      <div class="card bg-ligh rounded-4" style="width: 25rem; min-height: 79vh; ">
        <div class="table-responsive mt-3" style="max-height: 38rem; overflow-y: auto; padding:0; margin:0; border:0;">
          <table class="table  table-warning table-striped align-middle m-0" >
          <!--<caption>List of users</caption>-->
              <thead class="table-secondary sticky-top p-0" style="z-index: 1; position: sticky; bottom: 0;">
              <tr>
                <th class="h1 rounded-top-4" scope="col" style="text-align: center;">Calma</th>
              </tr>
              </thead>
          </table>
        </div>
        <div class="table-responsive" style="max-height: 38rem; overflow-y: auto; padding:0; margin:0; border:0;">
          <table class="table table-striped align-middle m-0" >
          <!--<caption>List of users</caption>-->
              <thead class="table-orange sticky-top p-0" style="z-index: 1; position: sticky; bottom: 0;">
                <tr>
                  <th scope="col" style="text-align: center;">D&iacute;as</th>
                  <th scope="col" style="text-align: center;">Referencia</th>
                </tr>
              </thead>
              <tbody>
              <?php  echo $objetoAlertaC->calma(); ?>
              </tbody>
          </table>
        </div>
      </div>
      <div class="card bg-light rounded-4" style="width: 25rem; min-height: 79vh">
        <div class="table-responsive mt-3" style="max-height: 38rem; overflow-y: auto; padding:0; margin:0; border:0;">
          <table class="table  table-warning table-striped align-middle m-0" >
          <!--<caption>List of users</caption>-->
              <thead class="table-secondary sticky-top p-0" style="z-index: 1; position: sticky; bottom: 0;">
              <tr>
                <th class="h1 rounded-top-4" scope="col" style="text-align: center;">Invias</th>
              </tr>
              </thead>
          </table>
        </div>
        <div class="table-responsive" style="max-height: 38rem; overflow-y: auto; padding:0; margin:0; border:0;">
          <table class="table table-striped align-middle m-0" >
          <!--<caption>List of users</caption>-->
              <thead class="table-orange sticky-top p-0" style="z-index: 1; position: sticky; bottom: 0;">
                <tr>
                  <th scope="col" style="text-align: center;">D&iacute;as</th>
                  <th scope="col" style="text-align: center;">Referencia</th>
                </tr>
              </thead>
              <tbody>
              <?php  echo $objetoAlertaC->invias(); ?>
              </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="container-fluid d-grid gap-2 d-md-flex justify-content-md-end ms-sm-auto p-1 sticky-bottom bg-light">
      <a href="correspondencia.php" class="btn btn-secondary m-3">Ir a Recibida-Calma</a>
      <a href="recibidaInvias.php" class="btn btn-secondary m-3">Ir a Recibida-Calma</a>
    </div>  
  </div>


<!-- importar php footer -->
<?php
  require '../templates/footer.php';
?>  