<!-- importar php para session -->
<?php
require '../templates/session.php'
  ?>

<!-- importar class -->
<?php
include_once '../modelo/Classconfig.php';
include_once '../controlador/Usuarios.php';
include_once '../Controlador/Datos.php';
include_once '../Controlador/HTML.php';
require_once("../controlador/Administrador.php");
?>

<!-- creando objetos -->
<?php
$objectoClassconfig = new Classconfig();
$conn = $objectoClassconfig->openServer();
$objetoEliminarCorrespondencia = new EliminarCorrespondencia($conn, 'recibidacalma', 'idRC');
$objetoRecibidaCalma = new RecibidaCalma($conn);
$objetoActualizarR = new ActualizarCorrespondendecia($conn, 'recibidacalma');
$objetoDias = new Dias();
$objectoSelects = new Selects($conn);
$objectoIterador = new Iterador();
$objectoRadicado = new Copias();
$objectoAdministrador = new Administrador($conn, $_SESSION['correoIngreso']);
?>

<!-- importar php head: declaraciones hmtl iniciales, imagenes tipo vector y sidebar -->
<?php
require '../templates/head.php';
?>

<!-- Barra de navegación -->
<?php
require '../templates/headers/headerCorrespondencia.php';
?>


<!-- Cabezal de tabla -->
<?php
require '../templates/headT.php';
?>

<?php
$sql = "SELECT * FROM recibidacalma";
$resultado = mysqli_query($conn, $sql);
while ($fila = mysqli_fetch_assoc($resultado)) {
  //echo gettype($objectoRadicado->tablaRadicado($fila["radicadoRC"]));
  echo '<tr>
            <td>
            <button class="btn btn-eliminar" onclick="copiarTexto(`' . htmlspecialchars($objectoRadicado->tablaRadicado($fila["radicadoRC"])) . '` )">
                <svg class="bi" width="20" height="20"><use xlink:href="#Clipboard"/></svg>
            </button>
        </td>
                    <th  contenteditable="false"><button type="button" class="btn btn-eliminar" data-bs-toggle="modal" data-bs-target="#EliminarRC' . $fila["idRC"] . '"><svg class="bi" width="20" height="20"><use xlink:href="#Trash"/></svg></button></th>
                      <!-- Modal -->
                      <div class="modal fade" id="EliminarRC' . $fila["idRC"] . '" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h1 class="modal-title fs-5" id="exampleModalLabel">Eliminaci&oacute;n de correspondencia</h1>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                              <svg class="bi flex-shrink-0 me-2" role="img" aria-label="Warning:" width="25" height="25"><use xlink:href="#exclamation-triangle-fill"/></svg> Est&aacute; seguro de eliminar corresponde con radicado: ' . $fila["radicadoRC"] . '
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                              <button type="submit" class="btn btn-primary" name="eliminar' . $fila['idRC'] . '">Eliminar</button>
                            </div>
                          </div>
                        </div>
                      </div>
                      <th  contenteditable="false"><textarea class="textarea" name="referenciaRC' . $fila["idRC"] . '">' . $fila["referenciaRC"] . '</textarea></th> 
                      <th  contenteditable="false" ><textarea  class="textarea textareaFolio bold-text"   name="radicadoRC' . $fila["idRC"] . '" readonly >' . $fila["radicadoRC"] . '</textarea></th>
                      <th  contenteditable="false" ><textarea  class="textarea textareaFolio bold-text"   name="tipodocumento' . $fila["idRC"] . '" readonly >' . $fila["tipodocumentoRC_TD"] . '</textarea></th>
                      <td contenteditable="false" class="contenedorSeclet" style="padding: 0.5rem 0 0.5rem 0.5rem;">
                        <select class="table_select form-select" name="adjuntoRC' . $fila["idRC"] . '">
                          ' . $objectoIterador->iterar($fila["adjuntoRC"]) . '
                        </select>
                      </td>
                      <td  contenteditable="false" class="contenedorSeclet"><textarea class="textarea textareaFolio" name="foliosRC' . $fila["idRC"] . '">' . $fila["foliosRC"] . '</textarea></td>
                      <td  contenteditable="false" class="contenedorSeclet" ><textarea class="textarea" name="fecharecibidoRC' . $fila["idRC"] . '">' . $fila["fecharecibidoRC"] . '</textarea></td>
                      <td  contenteditable="false" class="contenedorSeclet" ><textarea class="textarea" name="fechadocumentoRC' . $fila["idRC"] . '">' . $fila["fechadocumentoRC"] . '</textarea></td>
                      <td  contenteditable="false" class="contenedorSeclet" style="padding: 0.5rem 0 0.5rem 0.5rem ;">
                        <select class="table_select form-select" name="entidadRC_E' . $fila["idRC"] . '">
                        ' . $objectoSelects->entidad($fila['entidadRC_E']) . '
                        </select>
                      </td>
                      <td  contenteditable="false" class="contenedorSeclet" ><textarea class="textarea" name="nombreRC' . $fila["idRC"] . '">' . $fila["nombreRC"] . '</textarea></td>
                      <td  contenteditable="false" class="contenedorSeclet" style="padding: 0.5rem 0 0.5rem 0.5rem ;">
                        <select class="table_select form-select" name="cargoRC_Cargo' . $fila["idRC"] . '">
                          ' . $objectoSelects->cargo($fila['cargoRC_Cargo']) . '
                        </select>
                      </td>
                      <td  contenteditable="false" class="contenedorSeclet" ><textarea class="textarea" name="asuntoRC' . $fila["idRC"] . '">' . $fila["asuntoRC"] . '</textarea></td>
                      <td  contenteditable="false" class="contenedorSeclet" style="padding: 0.5rem 0 0.5rem 0.5rem ;">
                        <select class="table_select form-select" name="requiererespuestaRC' . $fila["idRC"] . '">
                          ' . $objectoIterador->iterar($fila["requiererespuestaRC"]) . '
                        </select>
                      </td>
                      <td  contenteditable="false" class="contenedorSeclet" ><textarea class="textarea" name="responsablesRC' . $fila["idRC"] . '">' . $fila["responsablesRC"] . '</textarea></td>
                      <td  contenteditable="false" class="contenedorSeclet" style="padding: 0.5rem 0 0.5rem 0.5rem ;">
                        <select class="table_select form-select" name="areaRC_A' . $fila["idRC"] . '">
                        ' . $objectoSelects->area($fila['areaRC_A']) . '
                      </select>
                      </td>
                      <td  contenteditable="false" class="contenedorSeclet" ><textarea class="textarea" name="respuestadeRC' . $fila["idRC"] . '">' . $fila["respuestadeRC"] . '</textarea></td>
                      <td  contenteditable="false" class="contenedorSeclet" ><textarea class="textarea" name="referencia2RC' . $fila["idRC"] . '">' . $fila["referencia2RC"] . '</textarea></td>
                      <td  contenteditable="false" class="contenedorSeclet" name="tsinrespuestaRC' . $fila["idRC"] . '">' . $objetoDias->diferenciaDias($fila["fecharecibidoRC"], $fila["requiererespuestaRC"]) . '</td>
                      <td  contenteditable="false" class="contenedorSeclet" name="tderespuestaRC' . $fila["idRC"] . '">' . $fila["tderespuestaRC"] . '</td>
                     
                  </tr> ';
  if (($_POST['radicadoRC' . $fila['idRC']] != null) && $objectoAdministrador->validacionAdministrador()) {
    $listaRadicado[] = $fila['radicadoRC'];
    $listaId[] = $fila['idRC'];
  }
  /* Código php de los botones elimimar  */
  if (isset($_POST['eliminar' . $fila['idRC']]) && $objectoAdministrador->validacionAdministrador()) {
    $objetoEliminarCorrespondencia->eliminar($fila['idRC']);
    echo '<script language="JavaScript" type="text/javascript">
                            location.href="correspondencia.php";
                          </script>';
  }
}

?>


<!-- Pie de tabla -->
<?php
require '../templates/footerT.php';
?>

<!-- Código de validación de las funciones -->
<?php
$cargo = null;
$cargo = $objectoAdministrador->verificarAdministrador();
if ($cargo !== 'Administrador' && $cargo !== 'Auxiliar Sistemas' && $cargo !== 'Auxiliar Civil') {
  $validacion = true;
} else {
  $validacion = false;
}
?>
<!-- Código php del boton agregar -->
<?php
if (isset($_POST['agregar']) && $objectoAdministrador->validacionAdministrador()) {
  $objetoRecibidaCalma->nuevo();
  echo '<script language="JavaScript" type="text/javascript">
          location.href="correspondencia.php";
        </script>';
}
?>

<!-- Código php para el botón guardarCambios -->
<?php
if (isset($_POST['guardarCambios']) && $objectoAdministrador->validacionAdministrador()) {
  for ($i = 0; $i < count($listaId); $i++) {
    $objetoActualizarR->actualizarR(intval($listaId[$i]), $_POST['referenciaRC' . $listaId[$i]], intval($listaRadicado[$i]), $_POST['tipodocumento' . $listaId[$i]], intval($_POST['adjuntoRC' . $listaId[$i]]), intval($_POST['foliosRC' . $listaId[$i]]), $_POST['fecharecibidoRC' . $listaId[$i]], $_POST['fechadocumentoRC' . $listaId[$i]], intval($_POST['entidadRC_E' . $listaId[$i]]), $_POST['referencia2RC' . $listaId[$i]], $_POST['nombreRC' . $listaId[$i]], intval($_POST['cargoRC_Cargo' . $listaId[$i]]), $_POST['asuntoRC' . $listaId[$i]], intval($_POST['requiererespuestaRC' . $listaId[$i]]), $_POST['responsablesRC' . $listaId[$i]], intval($_POST['areaRC_A' . $listaId[$i]]), $_POST['respuestadeRC' . $listaId[$i]]);
  }
  echo '<script language="JavaScript" type="text/javascript">
          alert("Los cambios se han guardado correctamente");
          location.href="correspondencia.php";
        </script>';
}
?>

<!-- importar php footer -->
<?php
require '../templates/footer.php';
?>