
<!-- importar class -->
<?php
require_once("../controlador/Administrador.php");
?> 

<!-- creando objetos -->
<?php
  $objectoClassconfig= new Classconfig();
  $conn = $objectoClassconfig->openServer();
  $objectoAdministrador = new Administrador($conn,$_SESSION['correoIngreso']);
?>

<!-- sidebar menu -->
<div class="container-fluid" style="z-index: 4;">
    <div class="row">
        <div class="sidebar rounded-4 fixed-top  border border-right col-md-3 col-lg-2 p-0 m-2 bg-lightorange">
            <div class="offcanvas-lg offcanvas-end bg-lightorange rounded-4" tabindex="-1" id="sidebarMenu" aria-labelledby="sidebarMenuLabel">
                <div class="offcanvas-header">
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#sidebarMenu" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body d-md-flex flex-column p-0 pt-lg-3 overflow-y-auto">
                    <ul class="nav flex-column align-items-center bg-lightorange">
                        <li class="nav-item">
                            <a href="" class="d-flex  mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
                                <img src="images/iconCIT2021.png" width="70" height="70" alt="Icon Procesar">
                            </a>
                        </li>
                    </ul>
                    <hr>
                    <ul class="nav flex-column bg-lightorange">
                        <li class="nav-item">
                            <a href="start.php" class="nav-link  link-body-emphasis " >
                                <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#House fill"/></svg>
                                Home
                            </a>
                        </li>
                        <li class="nav-item bg-lightorange">
                            <a href="informes.php" class="nav-link link-body-emphasis">
                                <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#File earmark text fill"/></svg>
                                Informes
                            </a>
                        </li>
                        <li class="nav-item bg-lightorange">
                            <a href="materiales.php" class="nav-link link-body-emphasis">
                                <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#Bricks"/></svg>
                                Materiales
                            </a>
                        </li>
                        <li class="nav-item bg-lightorange">
                            <a href="muestras.php" class="nav-link link-body-emphasis">
                                <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#rulers"/></svg>
                                Muestras
                            </a>
                        </li>
                        <li class="nav-item bg-lightorange">
                            <a href="correspondencia.php" class="nav-link link-body-emphasis">
                                <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#Mailbox2"/></svg>
                                Correspondencia
                            </a>
                        </li>
                        <li class="nav-item bg-lightorange">
                            <a href="presupuesto.php" class="nav-link link-body-emphasis">
                                <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#Cash stack"/></svg>
                                Presupuesto
                            </a>
                        </li>
                        <li class="nav-item bg-lightorange">
                            <a href="certificados.php" class="nav-link link-body-emphasis">
                                <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#Folder check"/></svg>
                                Certificados
                            </a>
                        </li>
                        <li class="nav-item bg-lightorange">
                            <a href="historialMateriales.php" class="nav-link link-body-emphasis">
                                <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#Archive fill"/></svg>
                                Historial de materiales
                            </a>
                        </li>
                        <?php
                        if ($objectoAdministrador->verificarAdministrador() === 'Administrador') {
                            // Mostrar la sección de HTML que solo debe aparecer para el usuario en específico
                            echo '<li class="nav-item bg-lightorange">
                            <a href="controlUsuarios.php" class="nav-link link-body-emphasis">
                            <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#Person fill gear"/></svg>
                            Control de usuarios
                            </a>
                        </li>';
                        }
                        ?>
                    </ul>
                    <hr class="my-3">
                    <form method="post" >
                    <ul class="nav flex-column mb-auto">
                        <li class="nav-item">
                        <a class="nav-link d-flex align-items-center gap-2" href="#">
                            <svg class="bi" width="16" height="16"><use xlink:href="#door-closed"/></svg>
                            <button type="submit" class="dropdown-item" name="cerrar_sesion">Cerrar sesi&oacute;n</button>
                        </a>
                        </li>
                    </ul>
                    </form>
                    <!--<div class="dropdown px-2">
                        <a href="#" class="d-flex align-items-center link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="https://us.123rf.com/450wm/thesomeday123/thesomeday1231712/thesomeday123171200009/91087331-icono-de-perfil-de-avatar-predeterminado-para-hombre-marcador-de-posici%C3%B3n-de-foto-gris-vector-de.jpg?ver=6" alt="An&oacute;nimo" width="32" height="32" class="rounded-circle me-2">
                            <strong>Usuario</strong>
                        </a>
                        <ul class="dropdown-menu text-small shadow">
                            <li><a class="dropdown-item" href="#">Configuraci&oacute;n</a></li>
                            <li><a class="dropdown-item" href="#">Perfil</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#">Cerrar sesi&oacute;n</a></li>
                        </ul>
                    </div>-->
                </div>
            </div>
        </div>
    </div>
</div>
