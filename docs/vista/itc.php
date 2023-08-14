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
$sql = "SELECT * FROM itc WHERE MONTH(fecharegistroITC) = $mes_actual";
$resultado = mysqli_query($conn, $sql);
while ($fila = mysqli_fetch_assoc($resultado)) {
  echo '<tr>
<th  contenteditable="false"><button type="button" class="btn btn-eliminar" data-bs-toggle="modal" data-bs-target="#EliminarITC' . $fila["idITC"] . '"><svg class="bi" width="20" height="20"><use xlink:href="#Trash"/></svg></button></th>
<!-- Modal -->
  <div class="modal fade" id="EliminarITC' . $fila["idITC"] . '" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
        <svg class="bi flex-shrink-0 me-2" role="img" aria-label="Warning:" width="25" height="25"><use xlink:href="#exclamation-triangle-fill"/></svg>
          <h1 class="modal-title fs-5" id="exampleModalLabel">Eliminaci&oacute;n de usuario</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            Est&aacute; seguro de eliminar el material con el nombre ' . $fila["nombreITC_RITC"] . '
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary" name="eliminar' . $fila['idITC'] . '">Eliminar</button>
        </div>
      </div>
    </div>
  </div>
  <th  contenteditable="false"><textarea class="textarea textareaFolio bold-text" name="id' . $fila["idITC"] . '" readonly>' . $fila["idITC"] . '</textarea></th>
  <th  contenteditable="false"><textarea class="textarea " name="fecharegistroITC' . $fila["idITC"] . '">' . $fila["fecharegistroITC"] . '</textarea></th>
  <td  contenteditable="false" class="contenedorSeclet" style="padding: 0.5rem 0 0.5rem 0.5rem ;">
    <select class="table_select form-select" name="tunelITC_T' . $fila["idITC"] . '">
    ' . $objectoSelects->tunel($fila['tunelITC_T']) . '
    </select>
  </td>
  <th  contenteditable="false"><textarea class="textarea" name="nombreITC_RITC' . $fila["idITC"] . '">' . $fila["nombreITC_RITC"] . '</textarea></th>
  <th  contenteditable="false"><textarea class="textarea " name="loteITC' . $fila["idITC"] . '">' . $fila["loteITC"] . '</textarea></th> 
  <th  contenteditable="false"><textarea class="textarea textareaFolio" name="cantiadadITC' . $fila["idITC"] . '">' . $fila["cantidadITC"] . '</textarea></th>
  <th  contenteditable="false"><textarea class="textarea " name="responsableITC' . $fila["idITC"] . '">' . $fila["responsableITC"] . '</textarea></th>
  <th  contenteditable="false"><textarea class="textarea " name="valorunitarioITC' . $fila["idITC"] . '">' . $objectoRegistroMateriales->valorunitario('registromecanico', $fila["nombreITC_RITC"]) . '</textarea></th>
  <th  contenteditable="false"><textarea class="textarea " name="valortotalITC' . $fila["idITC"] . '">' . floatval($objectoRegistroMateriales->valorunitario('registromecanico', $fila["nombreITC_RITC"])) * $fila["cantidadITC"] . '</textarea></th>     
  </tr> ';
  if ($_POST['id' . $fila['idITC']] != null) {
    $listaId[] = $_POST['id' . $fila['idITC']];
  }
  /* Código php de los botones elimimar  */
  if (isset($_POST['eliminar' . $fila['idITC']])) {
    $objectoRegistroMateriales->EliminarRegistro('itc', 'idITC', $fila['idITC']);
    echo '<script 
          language="JavaScript" type="text/javascript">
          alert("El material ' . $_POST['nombreITC' . $fila['idITC']] . ' fue eliminado correctamente.");
          location.href="itc.php";
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
  $objectoRegistroMateriales->nuevoITC();
  echo '<script language="JavaScript" type="text/javascript">
          location.href="itc.php";
        </script>';
}
?>

<!-- Código php para el botón guardarCambios -->
<?php
if (isset($_POST['guardarCambios'])) {
  for ($i = 0; $i < count($listaId); $i++) {
    //print_r(intval($_POST['nombreEL_REC' . $listaId[$i]]));
    $objectoRegistroMateriales->actualizarMaterial('itc', intval($listaId[$i]), $_POST['fecharegistroITC' . $listaId[$i]], intval($_POST['tunelITC_T' . $listaId[$i]]), intval($_POST['nombreITC_RITC' . $listaId[$i]]), $_POST['loteITC' . $listaId[$i]], intval($_POST['cantidadITC' . $listaId[$i]]), $_POST['responsableITC' . $listaId[$i]]);
  }
  echo '<script language="JavaScript" type="text/javascript">
          alert("Los cambios se han guardado correctamente");
          location.href="itc.php";
        </script>';
}
?>

<!-- importar php footer -->
<?php
require '../templates/footer.php';
?>