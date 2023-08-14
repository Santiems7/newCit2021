<!-- importar php para session -->
<?php
require '../templates/session.php'
    ?>

<!-- importar class -->
<?php
include_once '../controlador/Usuarios.php';
?>

<!-- creando objetos -->
<?php
$objectoClassconfig = new Classconfig();
$conn = $objectoClassconfig->openServer();
?>


<!-- importar php head: declaraciones hmtl iniciales, imagenes tipo vector y sidebar -->
<?php
require '../templates/head.php';
?>

<!-- Barra de navegación -->
<?php
require '../templates/headers/headerInformes.php';
?>

<main class="ms-sm-auto col-lg-10 px-md-3">
    <div class="card" style="width: 18rem;">
        <div class="card-body">
            <h5 class="card-title">Informe de prueba en Excel</h5>
            <h6 class="card-subtitle mb-2 text-body-secondary">Materiales</h6>
            <p class="card-text">Este informe sirve como ejemplo de evalución en la exposici&oacute;n de la fase 1 del
                proyecto CIT2021</p>
            <!-- Para la redirección -->
            <a class="btn btn-secondary" href="../templates/informes/inf1m.php">
                <svg class="bi flex-shrink-0 me-2" role="img" aria-label="Warning:" width="16" height="16">
                    <use xlink:href="#Cloud arrow down" />
                </svg> Descargar informe
            </a>
        </div>
    </div>


    <!-- importar php footer -->
    <?php
    require '../templates/footer.php';
    ?>