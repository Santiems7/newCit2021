<!-- Barra de navegación -->
<header class="container-fluid navbar justify-content-end sticky-top ms-sm-auto flex-md-nowrap bg-white p-0" >
    <ul class="nav justify-content-center">
        <li class="nav-item">
        <a class="nav-link p-1" aria-current="page" href="start.php"><button type="button" class="btn btn-light">Materiales del mes</button></a>
        </li>
        <li class="nav-item">
        <a class="nav-link p-1" href="alertasC.php"><button type="button" class="btn btn-light">Alertas correspondencia</button></a>
        </li>
        <li class="nav-item">
        <a class="nav-link p-1" href="alertasE.php"><button type="button" class="btn btn-light">Alertas muestras</button></a>
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