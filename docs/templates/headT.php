<?php
switch ($_SERVER['PHP_SELF']) {
    case '/CIT202102/vista/correspondencia.php':
        $titleTabla = 'Recibida - Calma';
        break;
    case '/CIT202102/vista/recibidaInvias.php':
        $titleTabla = 'Recibida - Invias';
        break;
    case '/CIT202102/vista/enviadaCalma.php':
        $titleTabla = 'Enviada - Calma';
        break;
    case '/CIT202102/vista/enviadaInvias.php':
        $titleTabla = 'Enviada - Invias';
        break;
    case '/CIT202102/vista/controlUsuarios.php':
        $titleTabla = 'Usuarios';
        break;
    case '/CIT202102/vista/registroElectrico.php':
        $titleTabla = 'Registro El&eacute;ctrico';
        break;
    case '/CIT202102/vista/registroITC.php':
        $titleTabla = 'Registro ITC';
        break;
    case '/CIT202102/vista/registroMecanico.php':
        $titleTabla = 'Registro Mec&aacute;nico';
        break;
    case '/CIT202102/vista/materiales.php':
        $titleTabla = 'Materiales El&eacute;ctrico';
        break;
    case '/CIT202102/vista/itc.php':
        $titleTabla = 'Materiales ITC';
        break;
    case '/CIT202102/vista/mecanico.php':
        $titleTabla = 'Materiales Mec&aacute;nicos';
        break;
    case '/CIT202102/vista/historialMateriales.php':
        $titleTabla = 'Historial El&eacute;ctricos';
        break;
    case '/CIT202102/vista/historialItc.php':
        $titleTabla = 'Hisotial ITCs';
        break;
    case '/CIT202102/vista/historialMecanico.php':
        $titleTabla = 'Historial Mec&aacute;nicos';
        break;
    default:
        $titleTabla = null;
        break;
}


if ($_SERVER['PHP_SELF'] === '/CIT202102/vista/correspondencia.php' || $_SERVER['PHP_SELF'] === '/CIT202102/vista/recibidaInvias.php') {
    echo '
    <main class="ms-sm-auto col-lg-10 px-md-3">
        <!-- div del main -->
        <div class="d-flex flex-column flex-shrink-0 p-1" >  
        <div class="table-responsive" style="max-height: 38rem; overflow-y: auto; padding:0; margin:0; border:0;">
        <table class="table  table-light table-striped align-middle m-0" >
        <!--<caption>List of users</caption>-->
            <thead class="table-secondary  sticky-top p-0" style="z-index: 1; position: sticky; bottom: 0;">
            <tr>
                <th class="h1 rounded-top-4" scope="col" style="text-align: center;">' . $titleTabla . '</th>
            </tr>
            </thead>
        </table>
        </div>
        <form method="post" action="">
        <div class="table-responsive">
        <table class="table table-light table-striped align-middle m-0 w-100"  id="tabla">
        <!--<caption>List of users</caption>-->
            <thead class="table-orange sticky-top " style="z-index: 1; ">
                <tr>
                <th scope="col" style="text-align: left;"></th>
                <th scope="col" style="text-align: left;"></th>
                <th scope="col" style="text-align: left;">Referencia</th>
                <th scope="col" style="text-align: left;">Radicado</th>
                <th scope="col" style="white-space: nowrap;">Tipo de documento</th>
                <th scope="col" style="text-align: left;">Adjunto</th>
                <th scope="col" style="text-align: left;">Folios</th>
                <th scope="col" style="white-space: nowrap;">Fecha recibido</th>
                <th scope="col" style="white-space: nowrap;">Fecha documento</th>
                <th scope="col" style="text-align: left;">Entidad&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                <th scope="col" style="text-align: left;">Nombre</th>
                <th scope="col" style="text-align: left;">Cargo&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                <th scope="col" style="white-space: nowrap;">Asunto                  </th>
                <th scope="col" style="white-space: nowrap;">Requiere respuesta</th>
                <th scope="col" style="text-align: left;">Responsable</th>
                <th scope="col" style="text-align: left;">&Aacute;rea&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                <th scope="col" style="text-align: left;">respuesta de</th>
                <th scope="col" style="text-align: left;">Referecia</th>
                <th scope="col" style="white-space: nowrap;">tiempo sin respuesta</th>
                <th scope="col" style="white-space: nowrap;">tiempo de respuesta</th>
                </tr>
            </thead>
            <tbody>
            ';
    $listaRadicado = [];
    $listaId = [];
} else if ($_SERVER['PHP_SELF'] === '/CIT202102/vista/enviadaCalma.php' || $_SERVER['PHP_SELF'] === '/CIT202102/vista/enviadaInvias.php') {
    echo '
    <main class="ms-sm-auto col-lg-10 px-md-3">
    <!-- div del main -->
    <div class="d-flex flex-column flex-shrink-0 p-1" >  
        <div class="table-responsive" style="max-height: 38rem; overflow-y: auto; padding:0; margin:0; border:0;">
        <table class="table  table-light table-striped align-middle m-0" >
        <!--<caption>List of users</caption>-->
            <thead class="table-secondary  sticky-top p-0" style="z-index: 1; position: sticky; bottom: 0;">
            <tr>
                <th class="h1 rounded-top-4" scope="col" style="text-align: center;">' . $titleTabla . '</th>
            </tr>
            </thead>
        </table>
        </div>
        <form method="post" action="">
        <div class="table-responsive">
        <table class="table table-light table-striped align-middle m-0 w-100" id="tabla">
        <!--<caption>List of users</caption>-->
            <thead class="table-orange sticky-top " style="z-index: 1; "    >
            <tr>
                <th scope="col" style="text-align: left;"></th>
                <th scope="col" style="text-align: left;"></th>
                <th scope="col" style="text-align: left;">Referencia</th>
                <th scope="col" style="text-align: left;">Radicado</th>
                <th scope="col" style="white-space: nowrap;">Tipo de documento</th>
                <th scope="col" style="text-align: left;">Adjunto</th>
                <th scope="col" style="text-align: left;">Folios</th>
                <th scope="col" style="white-space: nowrap;">Fecha recibido</th>
                <th scope="col" style="white-space: nowrap;">Fecha documento</th>
                <th scope="col" style="text-align: left;">Entidad&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                <th scope="col" style="text-align: left;">Nombre</th>
                <th scope="col" style="white-space: nowrap;">Asunto</th>
                <th scope="col" style="text-align: left;">Referecia</th> 
                <th scope="col" style="text-align: left;">&Aacute;rea&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
            </tr>
            </thead>
            <tbody>       
            ';
    $listaRadicado = [];
    $listaId = [];
} else if ($_SERVER['PHP_SELF'] === '/CIT202102/vista/controlUsuarios.php') {
    echo '
    <main class="ms-sm-auto col-lg-10 px-md-3">
        <!-- div del main -->
        <div class="d-flex flex-column flex-shrink-0 p-1 mb-3" >  
            <div class="table-responsive" style="max-height: 38rem; overflow-y: auto; padding:0; margin:0; border:0;">
            <table class="table  table-light table-striped align-middle m-0" >
            <!--<caption>List of users</caption>-->
                <thead class="table-secondary  sticky-top p-0" style="z-index: 1; position: sticky; bottom: 0;">
                <tr>
                    <th class="h2 rounded-top-4" scope="col" style="text-align: center;">' . $titleTabla . '</th>
                </tr>
                </thead>
            </table>
            </div>
            <div class="table-responsive" style="max-height: 38rem; overflow-y: auto; padding:0; margin:0; border:0;">
            <table class="table  table-warning table-striped align-middle m-0" >
            <!--<caption>List of users</caption>-->
                <thead class="table-primary sticky-top p-0" style="z-index: 1; position: sticky; bottom: 0;">
                <tr>
                  <th  scope="col" style="text-align: center;">
                  <svg class="bi flex-shrink-0 me-2 " role="img" aria-label="Warning:" width="25" height="25"><use xlink:href="#exclamation-triangle-fill"/></svg>
                  
                  
                  &iexcl;Precauci&oacute;n! Esta en modo administrador y todas las aprobaciones y eliminaciones se ver&aacute;n reflejadas de manera inmediata en la base de datos y no ser&aacute; posible recuperar informaci&oacute;n. 
                  
                
                  </th>
                </tr>
                </thead>
            </table>
            </div>
            <form method="post" action="controlUsuarios.php">
            <div class="table-responsive">
            <table class="table table-light table-striped align-middle m-0 w-100" id="tabla">
            <!--<caption>List of users</caption>-->
                <thead class="table-orange sticky-top " style="z-index: 1; "    >
                <tr>
                    <th scope="col" style="white-space: nowrap;"></th>
                    <th scope="col" style="white-space: nowrap;">id</th>
                    <th scope="col" style="white-space: nowrap;">Nombre(s)</th>
                    <th scope="col" style="white-space: nowrap;">Apellidos</th>
                    <th scope="col" style="white-space: nowrap;">Correo</th>
                    <th scope="col" style="white-space: nowrap;">Clave</th>
                    <th scope="col" style="white-space: nowrap;">Cargo&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                </tr>
                </thead>
                <tbody>
    ';
    $listaId = [];
} else if ($_SERVER['PHP_SELF'] === '/CIT202102/vista/registroElectrico.php' || $_SERVER['PHP_SELF'] === '/CIT202102/vista/registroITC.php' || $_SERVER['PHP_SELF'] === '/CIT202102/vista/registroMecanico.php') {
    echo '
    <main class="ms-sm-auto col-lg-10 px-md-3">
        <!-- div del main -->
        <div class="d-flex flex-column flex-shrink-0 p-1 mb-3" >  
            <div class="table-responsive" style="max-height: 38rem; overflow-y: auto; padding:0; margin:0; border:0;">
            <table class="table  table-light table-striped align-middle m-0" >
            <!--<caption>List of users</caption>-->
                <thead class="table-secondary  sticky-top p-0" style="z-index: 1; position: sticky; bottom: 0;">
                <tr>
                    <th class="h2 rounded-top-4" scope="col" style="text-align: center;">' . $titleTabla . '</th>
                </tr>
                </thead>
            </table>
            </div>
            <div class="table-responsive" style="max-height: 38rem; overflow-y: auto; padding:0; margin:0; border:0;">
            <table class="table  table-warning table-striped align-middle m-0" >
            <!--<caption>List of users</caption>-->
                <thead class="table-warning sticky-top p-0" style="z-index: 1; position: sticky; bottom: 0;">
                <tr>
                  <th  scope="col" style="text-align: center;">
                  <svg class="bi flex-shrink-0 me-2 " role="img" aria-label="Warning:" width="25" height="25"><use xlink:href="#exclamation-triangle-fill"/></svg>
                  
                  
                  &iexcl;Precauci&oacute;n! Recuerde que en esta tabla reposan los valores del presupuesto del proyecto, cualquier modificaci&oacute;n se ver&aacute; reflejada en los informes de gastos.  
                  
                
                  </th>
                </tr>
                </thead>
            </table>
            </div>
            <form method="post" action="">
            <div class="table-responsive" >
            <table class="table table-light table-striped align-middle m-0 w-100" id="tabla">
            <!--<caption>List of users</caption>-->
                <thead class="table-orange sticky-top " style="z-index: 1;">
                <tr>
                    <th scope="col" style="white-space: nowrap;"></th>
                    <th scope="col" style="white-space: nowrap;">id</th>
                    <th scope="col" style="white-space: nowrap;">Nombre</th>
                    <th scope="col" style="white-space: nowrap;">Descripci&oacute;n</th>
                    <th scope="col" style="white-space: nowrap;">Valor</th>
                    <th scope="col" style="white-space: nowrap;">T&uacute;nel</th>
                </tr>
                </thead>
                <tbody>
    ';
    $listaId = [];
} else if ($_SERVER['PHP_SELF'] === '/CIT202102/vista/materiales.php' || $_SERVER['PHP_SELF'] === '/CIT202102/vista/itc.php' || $_SERVER['PHP_SELF'] === '/CIT202102/vista/mecanico.php' || $_SERVER['PHP_SELF'] === '/CIT202102/vista/historialMateriales.php' || $_SERVER['PHP_SELF'] === '/CIT202102/vista/historialItc.php' || $_SERVER['PHP_SELF'] === '/CIT202102/vista/historialMecanico.php') {
    echo '
    <main class="ms-sm-auto col-lg-10 px-md-3">
        <!-- div del main -->
        <div class="d-flex flex-column flex-shrink-0 p-1 mb-3" >  
            <div class="table-responsive" style="max-height: 38rem; overflow-y: auto; padding:0; margin:0; border:0;">
            <table class="table  table-light table-striped align-middle m-0" >
            <!--<caption>List of users</caption>-->
                <thead class="table-secondary  sticky-top p-0" style="z-index: 1; position: sticky; bottom: 0;">
                <tr>
                    <th class="h2 rounded-top-4" scope="col" style="text-align: center;">' . $titleTabla . '</th>
                </tr>
                </thead>
            </table>
            </div>
            <div class="table-responsive" style="max-height: 38rem; overflow-y: auto; padding:0; margin:0; border:0;">
            <table class="table  table-warning table-striped align-middle m-0" >
            <!--<caption>List of users</caption>-->
                <thead class="table-warning sticky-top p-0" style="z-index: 1; position: sticky; bottom: 0;">
                <tr>
                  <th  scope="col" style="text-align: center;">
                  <svg class="bi flex-shrink-0 me-2 " role="img" aria-label="Warning:" width="25" height="25"><use xlink:href="#exclamation-triangle-fill"/></svg>
                  
                  
                  &iexcl;Precauci&oacute;n! Recuerde que en esta tabla reposan los valores del presupuesto del proyecto, cualquier modificaci&oacute;n se ver&aacute; reflejada en los informes de gastos.  
                  
                
                  </th>
                </tr>
                </thead>
            </table>
            </div>
            <form method="post" action="">
            <div class="table-responsive" >
            <table class="table table-light table-striped align-middle m-0 w-100" id="tabla">
            <!--<caption>List of users</caption>-->
                <thead class="table-orange sticky-top " style="z-index: 1;">
                <tr>
                    <th scope="col" style="white-space: nowrap;"></th>
                    <th scope="col" style="white-space: nowrap;">id</th>
                    <th scope="col" style="white-space: nowrap;">Fecha de registro</th>
                    <th scope="col" style="white-space: nowrap;">T&uacute;nel</th>
                    <th scope="col" style="white-space: nowrap;">Nombre</th>
                    <th scope="col" style="white-space: nowrap;">Lote</th>
                    <th scope="col" style="white-space: nowrap;">cantidad</th>
                    <th scope="col" style="white-space: nowrap;">Responsable</th>
                    <th scope="col" style="white-space: nowrap;">Valor unitario</th>
                    <th scope="col" style="white-space: nowrap;">Valor Total</th>
                </tr>
                </thead>
                <tbody>
    ';
    $listaId = [];
}
?>