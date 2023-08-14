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
$objetoEliminarCorrespondencia = new EliminarCorrespondencia($conn, 'enviadainvias', 'idEI');
$objetoEnviadaInvias = new EnviadaInvias($conn);
$objetoActualizarE = new ActualizarCorrespondendecia($conn, 'enviadainvias');
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
$objectoClassconfig = new ClassConfig();
//$conn = $objectoClassconfig->openServer();
$sql = "SELECT * FROM enviadainvias";
$conn = $objectoClassconfig->openServer();
$resultado = mysqli_query($conn, $sql);
$datos = array();
$arrayIds = array();
while ($fila = mysqli_fetch_assoc($resultado)) {
  echo '<tr>
                      <th  contenteditable="false"><button type="submit" class="btn btn-eliminar" name="radicado' . $fila["idEI"] . '" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Generar radicado"><svg class="bi" width="20" height="20"><use xlink:href="#File earmark arrow down"/></svg></button></th>
                      <th  contenteditable="false"><button type="button" class="btn btn-eliminar" data-bs-toggle="modal" data-bs-target="#EliminarEI' . $fila["idEI"] . '"><svg class="bi" width="20" height="20"><use xlink:href="#Trash"/></svg></button></th>
                      <!-- Modal -->
                      <div class="modal fade" id="EliminarEI' . $fila["idEI"] . '" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h1 class="modal-title fs-5" id="exampleModalLabel">Eliminaci&oacute;n de correspondencia</h1>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                              <svg class="bi flex-shrink-0 me-2" role="img" aria-label="Warning:" width="25" height="25"><use xlink:href="#exclamation-triangle-fill"/></svg> Est&aacute; seguro de eliminar corresponde con radicado: ' . $fila["radicadoEI"] . '
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                              <button type="submit" class="btn btn-primary" name="eliminar' . $fila['idEI'] . '">Eliminar</button>
                            </div>
                          </div>
                        </div>
                      </div>
                      <th  contenteditable="false" ><textarea class="textarea" name="referenciaEI' . $fila["idEI"] . '">' . $fila["referenciaEI"] . '</textarea></th> 
                      <th  contenteditable="false" ><textarea  class="textarea textareaFolio bold-text"   name="radicadoEI' . $fila["idEI"] . '" readonly >' . $fila["radicadoEI"] . '</textarea></th>
                      <th  contenteditable="false" ><textarea  class="textarea textareaFolio bold-text"   name="tipodocumento' . $fila["idEI"] . '" readonly >' . $fila["tipodocumentoEI_TD"] . '</textarea></th>
                      <td contenteditable="false" class="contenedorSeclet" style="padding: 0.5rem 0 0.5rem 0.5rem;">
                        <select class="table_select form-select" name="adjuntoEI' . $fila["idEI"] . '">
                          ' . $objectoIterador->iterar($fila["adjuntoEI"]) . '
                        </select>
                      </td>
                      <td  contenteditable="false"><textarea class="textarea textareaFolio" name="foliosEI' . $fila["idEI"] . '">' . $fila["foliosEI"] . '</textarea></td>
                      <td  contenteditable="false" class="contenedorSeclet" ><textarea class="textarea" name="fecharecibidoEI' . $fila["idEI"] . '">' . $fila["fecharecibidoEI"] . '</textarea></td>
                      <td  contenteditable="false" class="contenedorSeclet" ><textarea class="textarea" name="fechadocumentoEI' . $fila["idEI"] . '">' . $fila["fechadocumentoEIC"] . '</textarea></td>
                      <td  contenteditable="false" class="contenedorSeclet" style="padding: 0.5rem 0 0.5rem 0.5rem ;">
                        <select class="table_select form-select" name="entidadEI_E' . $fila["idEI"] . '">
                          ' . $objectoSelects->entidad($fila['entidadEI_E']) . '
                        </select>
                      </td>
                      <td  contenteditable="false" class="contenedorSeclet" ><textarea class="textarea" name="nombreEI' . $fila["idEI"] . '">' . $fila["nombreEI"] . '</textarea></td>
                      <td  contenteditable="false" class="contenedorSeclet" ><textarea class="textarea" name="asuntoEI' . $fila["idEI"] . '">' . $fila["asuntoEI"] . '</textarea></td>
                      <td  contenteditable="false" class="contenedorSeclet" ><textarea class="textarea" name="referencia2EI' . $fila["idEI"] . '">' . $fila["referencia2EI"] . '</textarea></td>
                      <td  contenteditable="false" class="contenedorSeclet" style="padding: 0.5rem 0 0.5rem 0.5rem ;">
                        <select class="table_select form-select" name="areaEI_A' . $fila["idEI"] . '">
                        ' . $objectoSelects->area($fila['areaEI_A']) . '
                      </select>
                      </td>
                    </div>
                  </tr> ';
  if (($_POST['radicadoEI' . $fila['idEI']] != null) && $objectoAdministrador->validacionAdministrador()) {
    $listaRadicado[] = $fila['radicadoEI'];
    $listaId[] = $fila['idEI'];
  }
  /* Código php de los botones elimimar  */
  if (isset($_POST['eliminar' . $fila['idEI']]) && $objectoAdministrador->validacionAdministrador()) {
    $objetoEliminarCorrespondencia->eliminar($fila['idEI']);
    echo '<script language="JavaScript" type="text/javascript">
                            location.href="enviadaInvias.php";
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
  $objetoEnviadaInvias->nuevo();
  echo '<script language="JavaScript" type="text/javascript">
              location.href="enviadaInvias.php";
            </script>';
}
?>
<!-- Código php para el botón guardarCambios -->
<?php

if (isset($_POST['guardarCambios']) && $objectoAdministrador->validacionAdministrador()) {
  for ($i = 0; $i < count($listaId); $i++) {
    $objetoActualizarE->actualizarE(intval($listaId[$i]), $_POST['referenciaEI' . $listaId[$i]], intval($listaRadicado[$i]), $_POST['tipodocumento' . $listaId[$i]], intval($_POST['adjuntoEI' . $listaId[$i]]), intval($_POST['foliosEI' . $listaId[$i]]), $_POST['fecharecibidoEI' . $listaId[$i]], $_POST['fechadocumentoEI' . $listaId[$i]], intval($_POST['entidadEI_E' . $listaId[$i]]), $_POST['referencia2EI' . $listaId[$i]], $_POST['nombreEI' . $listaId[$i]], $_POST['asuntoEI' . $listaId[$i]], intval($_POST['areaEI_A' . $listaId[$i]]));
  }
  echo '<script language="JavaScript" type="text/javascript">
              alert("Los cambios se han guardado correctamente");
              location.href="enviadaInvias.php";
            </script>';
}
?>
<!-- importar php footer -->
<?php
require '../templates/footer.php';
?>