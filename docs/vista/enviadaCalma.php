<!-- importar php para session -->
<?php
require '../templates/session.php'
  ?>

<!-- importar class -->
<?php
include_once '../modelo/Classconfig.php';
include_once '../controlador/Usuarios.php';
include_once '../Controlador/HTML.php';
require_once("../controlador/Administrador.php");
?>

<!-- creando objetos -->
<?php
$objectoClassconfig = new Classconfig();
$conn = $objectoClassconfig->openServer();
$objetoEliminarCorrespondencia = new EliminarCorrespondencia($conn, 'enviadacalma', 'idEC');
$objetoEnviadaCalma = new EnviadaCalma($conn);
$objetoActualizarE = new ActualizarCorrespondendecia($conn, 'enviadacalma');
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
$sql = "SELECT * FROM enviadacalma";
$resultado = mysqli_query($conn, $sql);
while ($fila = mysqli_fetch_assoc($resultado)) {
  echo '<tr>
                      <th  contenteditable="false"><button type="submit" class="btn btn-eliminar" name="radicado' . $fila["idEC"] . '" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Generar radicado"><svg class="bi" width="20" height="20"><use xlink:href="#File earmark arrow down"/></svg></button></th>
                      <th  contenteditable="false"><button type="button" class="btn btn-eliminar" data-bs-toggle="modal" data-bs-target="#EliminarEC' . $fila["idEC"] . '"><svg class="bi" width="20" height="20"><use xlink:href="#Trash"/></svg></button></th>
                      <!-- Modal -->
                      <div class="modal fade" id="EliminarEC' . $fila["idEC"] . '" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h1 class="modal-title fs-5" id="exampleModalLabel">Eliminaci&oacute;n de correspondencia</h1>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                              <svg class="bi flex-shrink-0 me-2" role="img" aria-label="Warning:" width="25" height="25"><use xlink:href="#exclamation-triangle-fill"/></svg> Est&aacute; seguro de eliminar corresponde con radicado: ' . $fila["radicadoEC"] . '
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                              <button type="submit" class="btn btn-primary" name="eliminar' . $fila['idEC'] . '">Eliminar</button>
                            </div>
                          </div>
                        </div>
                      </div>
                      <th  contenteditable="false" ><textarea class="textarea" name="referenciaEC' . $fila["idEC"] . '">' . $fila["referenciaEC"] . '</textarea></th> 
                      <th  contenteditable="false" ><textarea  class="textarea textareaFolio bold-text"   name="radicadoEC' . $fila["idEC"] . '" readonly >' . $fila["radicadoEC"] . '</textarea></th>
                      <th  contenteditable="false" ><textarea  class="textarea textareaFolio bold-text"   name="tipodocumento' . $fila["idEC"] . '" readonly >' . $fila["tipodocumentoEC_TD"] . '</textarea></th>
                      <td contenteditable="false" class="contenedorSeclet" style="padding: 0.5rem 0 0.5rem 0.5rem;">
                        <select class="table_select form-select" name="adjuntoEC' . $fila["idEC"] . '">
                          ' . $objectoIterador->iterar($fila["adjuntoEC"]) . '
                        </select>
                      </td>
                      <td  contenteditable="false"><textarea class="textarea textareaFolio" name="foliosEC' . $fila["idEC"] . '">' . $fila["foliosEC"] . '</textarea></td>
                      <td  contenteditable="false" class="contenedorSeclet" ><textarea class="textarea" name="fecharecibidoEC' . $fila["idEC"] . '">' . $fila["fecharecibidoEC"] . '</textarea></td>
                      <td  contenteditable="false" class="contenedorSeclet" ><textarea class="textarea" name="fechadocumentoEC' . $fila["idEC"] . '">' . $fila["fechadocumentoEC"] . '</textarea></td>
                      <td  contenteditable="false" class="contenedorSeclet" style="padding: 0.5rem 0 0.5rem 0.5rem ;">
                        <select class="table_select form-select" name="entidadEC_E' . $fila["idEC"] . '">
                        ' . $objectoSelects->entidad($fila['entidadEC_E']) . '
                      </select>
                      </td>
                      <td  contenteditable="false" class="contenedorSeclet" ><textarea class="textarea" name="nombreEC' . $fila["idEC"] . '">' . $fila["nombreEC"] . '</textarea></td>
                      <td  contenteditable="false" class="contenedorSeclet" ><textarea class="textarea" name="asuntoEC' . $fila["idEC"] . '">' . $fila["asuntoEC"] . '</textarea></td>
                      <td  contenteditable="false" class="contenedorSeclet" ><textarea class="textarea" name="referencia2EC' . $fila["idEC"] . '">' . $fila["referencia2EC"] . '</textarea></td>
                      <td  contenteditable="false" class="contenedorSeclet" style="padding: 0.5rem 0 0.5rem 0.5rem ;">
                        <select class="table_select form-select" name="areaEC_A' . $fila["idEC"] . '">
                          ' . $objectoSelects->area($fila['areaEC_A']) . '
                        </select>
                      </td>
                    </div>
                  </tr> ';
  if (($_POST['radicadoEC' . $fila['idEC']] != null) && $objectoAdministrador->validacionAdministrador()) {
    $listaRadicado[] = $fila['radicadoEC'];
    $listaId[] = $fila['idEC'];
  }
  /* Código php de los botones elimimar  */
  if (isset($_POST['eliminar' . $fila['idEC']]) && $objectoAdministrador->validacionAdministrador()) {
    $objetoEliminarCorrespondencia->eliminar($fila['idEC']);
    echo '<script language="JavaScript" type="text/javascript">
                            location.href="enviadaCalma.php";
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
  $objetoEnviadaCalma->nuevo();
  echo '<script language="JavaScript" type="text/javascript">
              location.href="enviadaCalma.php";
            </script>';
}
?>
<!-- Código php para el botón guardarCambios -->
<?php
if (isset($_POST['guardarCambios']) && $objectoAdministrador->validacionAdministrador()) {
  for ($i = 0; $i < count($listaId); $i++) {
    $objetoActualizarE->actualizarE(intval($listaId[$i]), $_POST['referenciaEC' . $listaId[$i]], intval($listaRadicado[$i]), $_POST['tipodocumento' . $listaId[$i]], intval($_POST['adjuntoEC' . $listaId[$i]]), intval($_POST['foliosEC' . $listaId[$i]]), $_POST['fecharecibidoEC' . $listaId[$i]], $_POST['fechadocumentoEC' . $listaId[$i]], intval($_POST['entidadEC_E' . $listaId[$i]]), $_POST['referencia2EC' . $listaId[$i]], $_POST['nombreEC' . $listaId[$i]], $_POST['asuntoEC' . $listaId[$i]], intval($_POST['areaEC_A' . $listaId[$i]]));
  }
  echo '<script language="JavaScript" type="text/javascript">
              alert("Los cambios se han guardado correctamente");
              location.href="enviadaCalma.php";
            </script>';
}
?>
<!-- importar php footer -->
<?php
require '../templates/footer.php';
?>