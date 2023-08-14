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
$sql = "SELECT * FROM registromecanico";
$resultado = mysqli_query($conn, $sql);
while ($fila = mysqli_fetch_assoc($resultado)) {
  echo '<tr>
<th  contenteditable="false"><button type="button" class="btn btn-eliminar" data-bs-toggle="modal" data-bs-target="#EliminarRME' . $fila["idRME"] . '"><svg class="bi" width="20" height="20"><use xlink:href="#Trash"/></svg></button></th>
<!-- Modal -->
  <div class="modal fade" id="EliminarRME' . $fila["idRME"] . '" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
        <svg class="bi flex-shrink-0 me-2" role="img" aria-label="Warning:" width="25" height="25"><use xlink:href="#exclamation-triangle-fill"/></svg>
          <h1 class="modal-title fs-5" id="exampleModalLabel">Eliminaci&oacute;n de usuario</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            Est&aacute; seguro de eliminar 
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary" name="eliminar' . $fila['idRME'] . '">Eliminar</button>
        </div>
      </div>
    </div>
  </div>
  <th  contenteditable="false"><textarea class="textarea textareaFolio bold-text" name="id' . $fila["idRME"] . '" readonly>' . $fila["idRME"] . '</textarea></th>
  <th  contenteditable="false"><textarea class="textarea " name="nombreRME' . $fila["idRME"] . '">' . $fila["nombreRME"] . '</textarea></th>
  <th  contenteditable="false"><textarea class="textarea textareaDescripcion" name="descripcionRME' . $fila["idRME"] . '">' . $fila["descripcionRME"] . '</textarea></th>
  <th  contenteditable="false"><textarea class="textarea " name="valorRME' . $fila["idRME"] . '">' . $fila["valorRME"] . '</textarea></th>   
  <td  contenteditable="false" class="contenedorSeclet" style="padding: 0.5rem 0 0.5rem 0.5rem ;">
    <select class="table_select form-select" name="tunelRME_T' . $fila["idRME"] . '">
    ' . $objectoSelects->tunel($fila['tunelRME_T']) . '
    </select>
  </td>
  </tr> ';
  if ($_POST['id' . $fila['idRME']] != null) {
    $listaId[] = $_POST['id' . $fila['idRME']];
  }
  /* Código php de los botones elimimar  */
  if (isset($_POST['eliminar' . $fila['idRME']])) {
    $objectoRegistroMateriales->EliminarRegistro('registromecanico', 'idRME', $fila['idRME']);
    echo '<script 
          language="JavaScript" type="text/javascript">
          alert("' . $_POST['nombreRME' . $fila['idRME']] . ' del túnel ' . $_POST['tunelRME_T' . $fila['idRME']] . ' fue eliminado correctamente.");
          location.href="registroMecanico.php";
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
  $objectoRegistroMateriales->nuevoRegistroMecanico();
  echo '<script language="JavaScript" type="text/javascript">
          location.href="registroMecanico.php";
        </script>';
}
?>

<!-- Código php para el botón guardarCambios -->
<?php
if (isset($_POST['guardarCambios'])) {
  for ($i = 0; $i < count($listaId); $i++) {
    $objectoRegistroMateriales->actualizarRegistro('registromecanico', intval($listaId[$i]), $_POST['nombreRME' . $listaId[$i]], $_POST['descripcionRME' . $listaId[$i]], floatval($_POST['valorRME' . $listaId[$i]]), intval($_POST['tunelRME_T' . $listaId[$i]]));
  }

  echo '<script language="JavaScript" type="text/javascript">
          alert("Los cambios se han guardado correctamente");
          location.href="registroMecanico.php";
        </script>';

}
?>

<!-- importar php footer -->
<?php
require '../templates/footer.php';
?>