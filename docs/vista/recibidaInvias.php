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
$objetoEliminarCorrespondencia = new EliminarCorrespondencia($conn, 'recibidainvias', 'idRI');
$objetoRecibidaInvias = new RecibidaInvias($conn);
$objetoActualizarR = new ActualizarCorrespondendecia($conn, 'recibidainvias');
$objetoDias = new Dias();
$objectoSelects = new Selects($conn);
$objectoIterador = new Iterador();
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
$sql = "SELECT * FROM recibidainvias";
$resultado = mysqli_query($conn, $sql);
while ($fila = mysqli_fetch_assoc($resultado)) {
  echo '<tr>
                      <th  contenteditable="false"><button type="submit" class="btn btn-eliminar" name="radicado' . $fila["idRI"] . '" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Generar radicado"><svg class="bi" width="20" height="20"><use xlink:href="#File earmark arrow down"/></svg></button></th>
                      <th  contenteditable="false"><button type="button" class="btn btn-eliminar" data-bs-toggle="modal" data-bs-target="#EliminarRI' . $fila["idRI"] . '"><svg class="bi" width="20" height="20"><use xlink:href="#Trash"/></svg></button></th>
                      <!-- Modal -->
                      <div class="modal fade" id="EliminarRI' . $fila["idRI"] . '" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h1 class="modal-title fs-5" id="exampleModalLabel">Eliminaci&oacute;n de correspondencia</h1>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                              <svg class="bi flex-shrink-0 me-2" role="img" aria-label="Warning:" width="25" height="25"><use xlink:href="#exclamation-triangle-fill"/></svg> Est&aacute; seguro de eliminar corresponde con radicado: ' . $fila["radicadoRI"] . '
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                              <button type="submit" class="btn btn-primary" name="eliminar' . $fila['idRI'] . '">Eliminar</button>
                            </div>
                          </div>
                        </div>
                      </div>
                      <th  contenteditable="false"><textarea class="textarea" name="referenciaRI' . $fila["idRI"] . '">' . $fila["referenciaRI"] . '</textarea></th> 
                      <th  contenteditable="false" ><textarea  class="textarea textareaFolio bold-text"   name="radicadoRI' . $fila["idRI"] . '" readonly >' . $fila["radicadoRI"] . '</textarea></th>
                      <th  contenteditable="false" ><textarea  class="textarea textareaFolio bold-text"   name="tipodocumento' . $fila["idRI"] . '" readonly >' . $fila["tipodocumentoRI_TD"] . '</textarea></th>
                      <td contenteditable="false" class="contenedorSeclet" style="padding: 0.5rem 0 0.5rem 0.5rem;">
                        <select class="table_select form-select" name="adjuntoRI' . $fila["idRI"] . '">
                          ' . $objectoIterador->iterar($fila["adjuntoRI"]) . '
                        </select>
                      </td>
                      <td  contenteditable="false" class="contenedorSeclet"><textarea class="textarea textareaFolio" name="foliosRI' . $fila["idRI"] . '">' . $fila["foliosRI"] . '</textarea></td>
                      <td  contenteditable="false" class="contenedorSeclet" ><textarea class="textarea" name="fecharecibidoRI' . $fila["idRI"] . '">' . $fila["fecharecibidoRI"] . '</textarea></td>
                      <td  contenteditable="false" class="contenedorSeclet" ><textarea class="textarea" name="fechadocumentoRI' . $fila["idRI"] . '">' . $fila["fechadocumentoRI"] . '</textarea></td>
                      <td  contenteditable="false" class="contenedorSeclet" style="padding: 0.5rem 0 0.5rem 0.5rem ;">
                        <select class="table_select form-select" name="entidadRI_E' . $fila["idRI"] . '">
                        ' . $objectoSelects->entidad($fila['entidadRI_E']) . '
                        </select>
                      </td>
                      <td  contenteditable="false" class="contenedorSeclet" ><textarea class="textarea" name="nombreRI' . $fila["idRI"] . '">' . $fila["nombreRI"] . '</textarea></td>
                      <td  contenteditable="false" class="contenedorSeclet" style="padding: 0.5rem 0 0.5rem 0.5rem ;">
                        <select class="table_select form-select" name="cargoRI_Cargo' . $fila["idRI"] . '">
                        ' . $objectoSelects->cargo($fila['cargoRI_Cargo']) . '
                      </select>
                      </td>
                      <td  contenteditable="false" class="contenedorSeclet" ><textarea class="textarea" name="asuntoRI' . $fila["idRI"] . '">' . $fila["asuntoRI"] . '</textarea></td>
                      <td  contenteditable="false" class="contenedorSeclet" style="padding: 0.5rem 0 0.5rem 0.5rem ;">
                        <select class="table_select form-select" name="requiererespuestaRI' . $fila["idRI"] . '">
                          ' . $objectoIterador->iterar($fila["requiererespuestaRI"]) . '
                        </select>
                      </td>
                      <td  contenteditable="false" class="contenedorSeclet" ><textarea class="textarea" name="responsablesRI' . $fila["idRI"] . '">' . $fila["responsablesRI"] . '</textarea></td>
                      <td  contenteditable="false" class="contenedorSeclet" style="padding: 0.5rem 0 0.5rem 0.5rem ;">
                        <select class="table_select form-select" name="areaRI_A' . $fila["idRI"] . '">
                        ' . $objectoSelects->area($fila['areaRC_A']) . '
                      </select>
                      </td>
                      <td  contenteditable="false" class="contenedorSeclet" ><textarea class="textarea" name="respuestadeRI' . $fila["idRI"] . '">' . $fila["respuestadeRI"] . '</textarea></td>
                      <td  contenteditable="false" class="contenedorSeclet" ><textarea class="textarea" name="referencia2RI' . $fila["idRI"] . '">' . $fila["referencia2RI"] . '</textarea></td>
                      <td  contenteditable="false" class="contenedorSeclet" name="tsinrespuestaRI' . $fila["idRI"] . '">' . $objetoDias->diferenciaDias($fila["fecharecibidoRI"], $fila["requiererespuestaRI"]) . '</td>
                      <td  contenteditable="false" class="contenedorSeclet" name="tderespuestaRI' . $fila["idRI"] . '">' . $fila["tderespuestaRI"] . '</td>
                     
                  </tr> ';
  if (($_POST['radicadoRI' . $fila['idRI']] != null) && $objectoAdministrador->validacionAdministrador()) {
    $listaRadicado[] = $fila['radicadoRI'];
    $listaId[] = $fila['idRI'];
  }
  /* Código php de los botones elimimar  */
  if (isset($_POST['eliminar' . $fila['idRI']]) && $objectoAdministrador->validacionAdministrador()) {
    $objetoEliminarCorrespondencia->eliminar($fila['idRI']);
    echo '<script language="JavaScript" type="text/javascript">
                            location.href="recibidaInvias.php";
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
if (isset($_POST['agregar']) && $objectoAdministrador->validacionAdministrador()) {
  $objetoRecibidaInvias->nuevo();
  echo '<script language="JavaScript" type="text/javascript">
              location.href="recibidaInvias.php";
            </script>';
}
?>
<!-- Código php para el botón guardarCambios -->
<?php
if (isset($_POST['guardarCambios']) && $objectoAdministrador->validacionAdministrador()) {
  for ($i = 0; $i < count($listaId); $i++) {
    $objetoActualizarR->actualizarR(intval($listaId[$i]), $_POST['referenciaRI' . $listaId[$i]], intval($listaRadicado[$i]), $_POST['tipodocumento' . $listaId[$i]], intval($_POST['adjuntoRI' . $listaId[$i]]), intval($_POST['foliosRI' . $listaId[$i]]), $_POST['fecharecibidoRI' . $listaId[$i]], $_POST['fechadocumentoRI' . $listaId[$i]], intval($_POST['entidadRI_E' . $listaId[$i]]), $_POST['referencia2RI' . $listaId[$i]], $_POST['nombreRI' . $listaId[$i]], intval($_POST['cargoRI_Cargo' . $listaId[$i]]), $_POST['asuntoRI' . $listaId[$i]], intval($_POST['requiererespuestaRI' . $listaId[$i]]), $_POST['responsablesRI' . $listaId[$i]], intval($_POST['areaRI_A' . $listaId[$i]]), $_POST['respuestadeRI' . $listaId[$i]]);
  }
  echo '<script language="JavaScript" type="text/javascript">
              alert("Los cambios se han guardado correctamente");
              location.href="recibidaInvias.php";
            </script>';
}
?>
<!-- importar php footer -->
<?php
require '../templates/footer.php';
?>