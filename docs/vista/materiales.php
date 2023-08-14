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
$sql = "SELECT * FROM electrico WHERE MONTH(fecharegistroEL) = $mes_actual";
$resultado = mysqli_query($conn, $sql);
while ($fila = mysqli_fetch_assoc($resultado)) {
  echo '<tr>
<th  contenteditable="false"><button type="button" class="btn btn-eliminar" data-bs-toggle="modal" data-bs-target="#EliminarEL' . $fila["idEL"] . '"><svg class="bi" width="20" height="20"><use xlink:href="#Trash"/></svg></button></th>
<!-- Modal -->
  <div class="modal fade" id="EliminarEL' . $fila["idEL"] . '" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
        <svg class="bi flex-shrink-0 me-2" role="img" aria-label="Warning:" width="25" height="25"><use xlink:href="#exclamation-triangle-fill"/></svg>
          <h1 class="modal-title fs-5" id="exampleModalLabel">Eliminaci&oacute;n de usuario</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            Est&aacute; seguro de eliminar el material con el nombre ' . $fila["nombreEL_REC"] . '
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary" name="eliminar' . $fila['idEL'] . '">Eliminar</button>
        </div>
      </div>
    </div>
  </div>
  <th  contenteditable="false"><textarea class="textarea textareaFolio bold-text" name="id' . $fila["idEL"] . '" readonly>' . $fila["idEL"] . '</textarea></th>
  <th  contenteditable="false"><textarea class="textarea " name="fecharegistroEL' . $fila["idEL"] . '">' . $fila["fecharegistroEL"] . '</textarea></th>
  <td  contenteditable="false" class="contenedorSeclet" style="padding: 0.5rem 0 0.5rem 0.5rem ;">
    <select class="table_select form-select" name="tunelEL_T' . $fila["idEL"] . '">
    ' . $objectoSelects->tunel($fila['tunelEL_T']) . '
    </select>
  </td>
  <th  contenteditable="false"><textarea class="textarea" name="nombreEL_REC' . $fila["idEL"] . '">' . $fila["nombreEL_REC"] . '</textarea></th>
  <th  contenteditable="false"><textarea class="textarea " name="loteEL' . $fila["idEL"] . '">' . $fila["loteEL"] . '</textarea></th> 
  <th  contenteditable="false"><textarea class="textarea textareaFolio" name="cantiadadEL' . $fila["idEL"] . '">' . $fila["cantidadEL"] . '</textarea></th>
  <th  contenteditable="false"><textarea class="textarea " name="responsableEL' . $fila["idEL"] . '">' . $fila["responsableEL"] . '</textarea></th>
  <th  contenteditable="false"><textarea class="textarea " name="valorunitarioEL' . $fila["idEL"] . '">' . $objectoRegistroMateriales->valorunitario('registroelectricos', $fila["nombreEL_REC"]) . '</textarea></th>
  <th  contenteditable="false"><textarea class="textarea " name="valortotalEL' . $fila["idEL"] . '">' . floatval($objectoRegistroMateriales->valorunitario('registroelectricos', $fila["nombreEL_REC"])) * $fila["cantidadEL"] . '</textarea></th>     
  
  </tr> ';
  if ($_POST['id' . $fila['idEL']] != null) {
    $listaId[] = $_POST['id' . $fila['idEL']];
  }
  /* Código php de los botones elimimar  */
  if (isset($_POST['eliminar' . $fila['idEL']])) {
    $objectoRegistroMateriales->EliminarRegistro('electrico', 'idEL', $fila['idEL']);
    echo '<script 
          language="JavaScript" type="text/javascript">
          alert("El material ' . $_POST['nombreEL' . $fila['idEL']] . ' fue eliminado correctamente.");
          location.href="materiales.php";
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
  $objectoRegistroMateriales->nuevoElectrico();
  echo '<script language="JavaScript" type="text/javascript">
          location.href="materiales.php";
        </script>';
}
?>

<!-- Código php para el botón guardarCambios -->
<?php
if (isset($_POST['guardarCambios'])) {
  for ($i = 0; $i < count($listaId); $i++) {
    //print_r(intval($_POST['nombreEL_REC' . $listaId[$i]]));
    $objectoRegistroMateriales->actualizarMaterial('electrico', intval($listaId[$i]), $_POST['fecharegistroEL' . $listaId[$i]], intval($_POST['tunelEL_T' . $listaId[$i]]), intval($_POST['nombreEL_REC' . $listaId[$i]]), $_POST['loteEL' . $listaId[$i]], intval($_POST['cantidadEL' . $listaId[$i]]), $_POST['responsableEL' . $listaId[$i]]);
  }
  echo '<script language="JavaScript" type="text/javascript">
          alert("Los cambios se han guardado correctamente");
          location.href="materiales.php";
        </script>';
}
?>

<!-- importar php footer -->
<?php
require '../templates/footer.php';
?>