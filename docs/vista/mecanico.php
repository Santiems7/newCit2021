<!-- importar php para session -->
<?php
require '../templates/session.php'
  ?>

<!-- importar class -->
<?php
include_once '../modelo/Classconfig.php';
include_once '../controlador/Usuarios.php';
include_once '../Controlador/HTML.php';
?>

<!-- creando objetos -->
<?php
$objectoClassconfig = new Classconfig();
$conn = $objectoClassconfig->openServer();
$objectoEliminar = new Eliminar($conn);
$objectoSelects = new Selects($conn);
$objectoRegistroMateriales = new RegistrosMateriales($conn);
?>

<!-- importar php head: declaraciones hmtl iniciales, imagenes tipo vector y sidebar -->
<?php
require '../templates/head.php';
?>

<!-- Barra de navegación -->
<?php
require '../templates/headers/headerMateriales.php';
?>

<!-- contenido -->
<!-- Cabezal de tabla -->
<?php
require '../templates/headT.php';
?>

<?php
date_default_timezone_set('America/Bogota');
$mes_actual = date('m'); // Obtener el mes actual en formato numérico (por ejemplo, "08" para agosto)
$sql = "SELECT * FROM mecanico WHERE MONTH(fecharegistroME) = $mes_actual";
$resultado = mysqli_query($conn, $sql);
while ($fila = mysqli_fetch_assoc($resultado)) {
  echo '<tr>
<th  contenteditable="false"><button type="button" class="btn btn-eliminar" data-bs-toggle="modal" data-bs-target="#EliminarME' . $fila["idME"] . '"><svg class="bi" width="20" height="20"><use xlink:href="#Trash"/></svg></button></th>
<!-- Modal -->
  <div class="modal fade" id="EliminarME' . $fila["idME"] . '" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
        <svg class="bi flex-shrink-0 me-2" role="img" aria-label="Warning:" width="25" height="25"><use xlink:href="#exclamation-triangle-fill"/></svg>
          <h1 class="modal-title fs-5" id="exampleModalLabel">Eliminaci&oacute;n de usuario</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            Est&aacute; seguro de eliminar el material con el nombre ' . $fila["nombreME_RME"] . '
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary" name="eliminar' . $fila['idME'] . '">Eliminar</button>
        </div>
      </div>
    </div>
  </div>
  <th  contenteditable="false"><textarea class="textarea textareaFolio bold-text" name="id' . $fila["idME"] . '" readonly>' . $fila["idME"] . '</textarea></th>
  <th  contenteditable="false"><textarea class="textarea " name="fecharegistroME' . $fila["idME"] . '">' . $fila["fecharegistroME"] . '</textarea></th>
  <td  contenteditable="false" class="contenedorSeclet" style="padding: 0.5rem 0 0.5rem 0.5rem ;">
    <select class="table_select form-select" name="tunelME_T' . $fila["idME"] . '">
    ' . $objectoSelects->tunel($fila['tunelME_T']) . '
    </select>
  </td>
  <th  contenteditable="false"><textarea class="textarea" name="nombreME_RME' . $fila["idME"] . '">' . $fila["nombreME_RME"] . '</textarea></th>
  <th  contenteditable="false"><textarea class="textarea " name="loteME' . $fila["idME"] . '">' . $fila["loteME"] . '</textarea></th> 
  <th  contenteditable="false"><textarea class="textarea textareaFolio" name="cantiadadME' . $fila["idME"] . '">' . $fila["cantidadME"] . '</textarea></th>
  <th  contenteditable="false"><textarea class="textarea " name="responsableME' . $fila["idME"] . '">' . $fila["responsableME"] . '</textarea></th>
  <th  contenteditable="false"><textarea class="textarea " name="valorunitarioME' . $fila["idME"] . '">' . $objectoRegistroMateriales->valorunitario('registromecanico', $fila["nombreME_RME"]) . '</textarea></th>
  <th  contenteditable="false"><textarea class="textarea " name="valortotalME' . $fila["idME"] . '">' . floatval($objectoRegistroMateriales->valorunitario('registromecanico', $fila["nombreME_RME"])) * $fila["cantidadME"] . '</textarea></th>     
  </tr> ';
  if ($_POST['id' . $fila['idME']] != null) {
    $listaId[] = $_POST['id' . $fila['idME']];
  }
  /* Código php de los botones elimimar  */
  if (isset($_POST['eliminar' . $fila['idME']])) {
    $objectoRegistroMateriales->EliminarRegistro('mecanico', 'idME', $fila['idME']);
    echo '<script 
          language="JavaScript" type="text/javascript">
          alert("El material ' . $_POST['nombreME' . $fila['idME']] . ' fue eliminado correctamente.");
          location.href="mecanico.php";
          </script>';
  }
}
?>

<!-- Pie de tabla -->
<?php
require '../templates/footerT.php';
?>

<!-- Código php del boton agregar -->
<?php
if (isset($_POST['agregar'])) {
  $objectoRegistroMateriales->nuevoMecanico();
  echo '<script language="JavaScript" type="text/javascript">
          location.href="mecanico.php";
        </script>';
}
?>

<!-- Código php para el botón guardarCambios -->
<?php
if (isset($_POST['guardarCambios'])) {
  for ($i = 0; $i < count($listaId); $i++) {
    //print_r(intval($_POST['nombreEL_REC' . $listaId[$i]]));
    $objectoRegistroMateriales->actualizarMaterial('mecanico', intval($listaId[$i]), $_POST['fecharegistroME' . $listaId[$i]], intval($_POST['tunelME_T' . $listaId[$i]]), intval($_POST['nombreME_RME' . $listaId[$i]]), $_POST['loteME' . $listaId[$i]], intval($_POST['cantidadME' . $listaId[$i]]), $_POST['responsableME' . $listaId[$i]]);
  }
  echo '<script language="JavaScript" type="text/javascript">
          alert("Los cambios se han guardado correctamente");
          location.href="mecanico.php";
        </script>';
}
?>

<!-- importar php footer -->
<?php
require '../templates/footer.php';
?>