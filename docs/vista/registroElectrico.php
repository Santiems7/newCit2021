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
$sql = "SELECT * FROM registroelectricos";
$resultado = mysqli_query($conn, $sql);
while ($fila = mysqli_fetch_assoc($resultado)) {
  echo '<tr>
<th  contenteditable="false"><button type="button" class="btn btn-eliminar" data-bs-toggle="modal" data-bs-target="#EliminarREC' . $fila["idREC"] . '"><svg class="bi" width="20" height="20"><use xlink:href="#Trash"/></svg></button></th>
<!-- Modal -->
  <div class="modal fade" id="EliminarREC' . $fila["idREC"] . '" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
          <button type="submit" class="btn btn-primary" name="eliminar' . $fila['idREC'] . '">Eliminar</button>
        </div>
      </div>
    </div>
  </div>
  <th  contenteditable="false"><textarea class="textarea textareaFolio bold-text" name="id' . $fila["idREC"] . '" readonly>' . $fila["idREC"] . '</textarea></th>
  <th  contenteditable="false"><textarea class="textarea " name="nombreREC' . $fila["idREC"] . '">' . $fila["nombreREC"] . '</textarea></th>
  <th  contenteditable="false"><textarea class="textarea textareaDescripcion" name="descripcionREC' . $fila["idREC"] . '">' . $fila["descripcionREC"] . '</textarea></th>
  <th  contenteditable="false"><textarea class="textarea " name="valorREC' . $fila["idREC"] . '">' . $fila["valorREC"] . '</textarea></th>   
  <td  contenteditable="false" class="contenedorSeclet" style="padding: 0.5rem 0 0.5rem 0.5rem ;">
    <select class="table_select form-select" name="tunelREC_T' . $fila["idREC"] . '">
    ' . $objectoSelects->tunel($fila['tunelREC_T']) . '
    </select>
  </td>
  </tr> ';
  if ($_POST['id' . $fila['idREC']] != null) {
    $listaId[] = $_POST['id' . $fila['idREC']];
  }
  /* Código php de los botones elimimar  */
  if (isset($_POST['eliminar' . $fila['idREC']])) {
    $objectoRegistroMateriales->EliminarRegistro('registroelectricos', 'idREC', $fila['idREC']);
    echo '<script 
          language="JavaScript" type="text/javascript">
          alert("' . $_POST['nombreREC' . $fila['idREC']] . ' del túnel ' . $_POST['tunelREC_T' . $fila['idREC']] . ' fue eliminado correctamente.");
          location.href="registroElectrico.php";
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
  $objectoRegistroMateriales->nuevoRegistroElectrico();
  echo '<script language="JavaScript" type="text/javascript">
          location.href="registroElectrico.php";
        </script>';
}
?>

<!-- Código php para el botón guardarCambios -->
<?php
if (isset($_POST['guardarCambios'])) {
  for ($i = 0; $i < count($listaId); $i++) {
    $objectoRegistroMateriales->actualizarRegistro('registroelectricos', intval($listaId[$i]), $_POST['nombreREC' . $listaId[$i]], $_POST['descripcionREC' . $listaId[$i]], floatval($_POST['valorREC' . $listaId[$i]]), intval($_POST['tunelREC_T' . $listaId[$i]]));
  }

  echo '<script language="JavaScript" type="text/javascript">
          alert("Los cambios se han guardado correctamente");
          location.href="registroElectrico.php";
        </script>';
}
?>

<!-- importar php footer -->
<?php
require '../templates/footer.php';
?>