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
$sql = "SELECT * FROM registroitc";
$resultado = mysqli_query($conn, $sql);
while ($fila = mysqli_fetch_assoc($resultado)) {
  echo '<tr>
<th  contenteditable="false"><button type="button" class="btn btn-eliminar" data-bs-toggle="modal" data-bs-target="#EliminarRITC' . $fila["idRITC"] . '"><svg class="bi" width="20" height="20"><use xlink:href="#Trash"/></svg></button></th>
<!-- Modal -->
  <div class="modal fade" id="EliminarRITC' . $fila["idRITC"] . '" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
          <button type="submit" class="btn btn-primary" name="eliminar' . $fila['idRITC'] . '">Eliminar</button>
        </div>
      </div>
    </div>
  </div>
  <th  contenteditable="false"><textarea class="textarea textareaFolio bold-text" name="id' . $fila["idRITC"] . '" readonly>' . $fila["idRITC"] . '</textarea></th>
  <th  contenteditable="false"><textarea class="textarea " name="nombreRITC' . $fila["idRITC"] . '">' . $fila["nombreRITC"] . '</textarea></th>
  <th  contenteditable="false"><textarea class="textarea textareaDescripcion" name="descripcionRITC' . $fila["idRITC"] . '">' . $fila["descripcionRITC"] . '</textarea></th>
  <th  contenteditable="false"><textarea class="textarea " name="valorRITC' . $fila["idRITC"] . '">' . $fila["valorRITC"] . '</textarea></th>   
  <td  contenteditable="false" class="contenedorSeclet" style="padding: 0.5rem 0 0.5rem 0.5rem ;">
    <select class="table_select form-select" name="tunelRITC_T' . $fila["idRITC"] . '">
    ' . $objectoSelects->tunel($fila['tunelRITC_T']) . '
    </select>
  </td>
  </tr> ';
  if ($_POST['id' . $fila['idRITC']] != null) {
    $listaId[] = $_POST['id' . $fila['idRITC']];
  }
  /* Código php de los botones elimimar  */
  if (isset($_POST['eliminar' . $fila['idRITC']])) {
    $objectoRegistroMateriales->EliminarRegistro('registroitc', 'idRITC', $fila['idRITC']);
    echo '<script 
          language="JavaScript" type="text/javascript">
          alert("' . $_POST['nombreRITC' . $fila['idRITC']] . ' del túnel ' . $_POST['tunelRITC_T' . $fila['idREC']] . ' fue eliminado correctamente.");
          location.href="registroITC.php";
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
  $objectoRegistroMateriales->nuevoRegistroITC();
  echo '<script language="JavaScript" type="text/javascript">
          location.href="registroITC.php";
        </script>';
}
?>

<!-- Código php para el botón guardarCambios -->
<?php
if (isset($_POST['guardarCambios'])) {
  for ($i = 0; $i < count($listaId); $i++) {
    $objectoRegistroMateriales->actualizarRegistro('registroitc', intval($listaId[$i]), $_POST['nombreRITC' . $listaId[$i]], $_POST['descripcionRITC' . $listaId[$i]], floatval($_POST['valorRITC' . $listaId[$i]]), intval($_POST['tunelRITC_T' . $listaId[$i]]));
  }

  echo '<script language="JavaScript" type="text/javascript">
          alert("Los cambios se han guardado correctamente");
          location.href="registroITC.php";
        </script>';

}
?>

<!-- importar php footer -->
<?php
require '../templates/footer.php';
?>