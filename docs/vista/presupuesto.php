<!-- importar php para session -->
<?php
require '../templates/session.php'
?>

<!-- importar class -->
<?php
?> 

<!-- importar php head: declaraciones hmtl iniciales, imagenes tipo vector y sidebar -->
<?php
  require '../templates/head.php';
?>  

<!-- Barra de navegación -->
  <header class="container-fluid navbar justify-content-end sticky-top ms-sm-auto flex-md-nowrap bg-white p-0">
        <ul class="nav justify-content-center">
          <li class="nav-item">
            <a class="nav-link p-1" aria-current="page" href="start.php"><button type="button" class="btn btn-light">Materiales del mes</button></a>
          </li>
          <li class="nav-item">
            <a class="nav-link p-1" href="alertasC.php"><button type="button" class="btn btn-light">Alertas correspondencia</button></a>
          </li>
          <li class="nav-item">
            <a class="nav-link p-1" href="alertasE.php"><button type="button" class="btn btn-light">Alertas ensayos</button></a>
          </li>
          <li>
            <a class="nav-link p-1" disabled><button type="button" class="btn "><svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#People circle"/></svg><?php echo $objectoAdministrador->usuarioSession(); ?></button></a>          
          </li>
          <li>
              <ul class="navbar-nav flex-row d-md-none justify-content-end">
                  <li class="nav-item text-nowrap">
                      <button class="nav-link px-3 text-black" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
                          <svg class="bi" width="20" height="20"><use xlink:href="#list"/></svg>
                      </button>
                  </li>
              </ul>
          </li> 
        </ul>
</header>
   
  <main class="ms-sm-auto col-lg-10 px-md-3">



  <div class="table-responsive" style="max-height: 38rem; overflow-y: auto; padding:0; margin:0; border:0;">
  <table class="table rounded-4 table-light table-striped align-middle m-0">
    <!--<caption>List of users</caption>-->
    <thead class="table-secondary rounded-4 sticky-top p-0" style="z-index: 1; position: sticky; bottom: 0;">
      <tr>
        <th class="h1 rounded-4" scope="col" style="text-align: center;">Recibida - Calma</th>
      </tr>
    </thead>
  </table>
</div>
<form method="post" action="correspondencia.php">
  <div class="table-responsive" style="max-height: 36.9rem; overflow-y: auto;">
    <table class="table table-light table-striped align-middle">
      <!--<caption>List of users</caption>-->

      <thead class="table-orange sticky-top" style="z-index: 1;">
        <!-- Resto del código del encabezado de la tabla -->
      </thead>

      <tbody>
        <!-- Contenido de la tabla -->
        
      </tbody>
    </table>
  </div>
</form>
<!-- importar php footer -->
<?php
  require '../templates/footer.php';
?>  