<!-- importar verificacion de administrador -->
<?php
require '../templates/sessionAdmin.php';
?>

<!-- importar class -->
<?php
  require_once("../controlador/Administrador.php"); 
  include_once '../modelo/Classconfig.php'; 
  include_once '../controlador/Usuarios.php';
  include_once '../Controlador/HTML.php';
?>

<!-- creando objetos -->
<?php
  $objectoClassconfig= new Classconfig();
  $conn = $objectoClassconfig->openServer();
  $objectoEliminar = new Eliminar($conn);
  $objectoActualizar = new Actualiazar($conn);
  $objectoSelects = new Selects($conn);
?>

<!-- importar php head: declaraciones hmtl iniciales, imagenes tipo vector y sidebar -->
<?php
  require '../templates/head.php';
?>  

<!-- Barra de navegación -->
<?php
  require '../templates/headers/headerControlUsuarios.php';
?>

<!-- contenido -->
<!-- Cabezal de tabla -->
<?php
  require '../templates/headT.php';
?>  

<?php
$sql = "SELECT * FROM usuario";
$resultado = mysqli_query($conn, $sql);
while ($fila = mysqli_fetch_assoc($resultado)) {

echo '<tr>
<th  contenteditable="false"><button type="button" class="btn btn-eliminar" data-bs-toggle="modal" data-bs-target="#EliminarUsuario'.$fila["idUsuario"].'"><svg class="bi" width="20" height="20"><use xlink:href="#Trash"/></svg></button></th>
<!-- Modal -->
  <div class="modal fade" id="EliminarUsuario'.$fila["idUsuario"].'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
        <svg class="bi flex-shrink-0 me-2" role="img" aria-label="Warning:" width="25" height="25"><use xlink:href="#exclamation-triangle-fill"/></svg>
          <h1 class="modal-title fs-5" id="exampleModalLabel">Eliminaci&oacute;n de usuario</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            Est&aacute; seguro de eliminar el usuario '.$fila["nombreUsuario"].'<br> con correo: '.$fila["correoUsuario"].'
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary" name="eliminar'.$fila['idUsuario'].'">Eliminar</button>
        </div>
      </div>
    </div>
  </div>
  <th  contenteditable="false"><textarea  class="textarea textareaFolio bold-text"   name="id'.$fila["idUsuario"].'" readonly>'. $fila["idUsuario"].'</textarea></th>
  <th  contenteditable="false"><textarea class="textarea" name="nombreUsuario'.$fila["idUsuario"].'">'. $fila["nombreUsuario"].'</textarea></th>
  <th  contenteditable="false"><textarea class="textarea" name="apellidosUsuario'.$fila["idUsuario"].'">'. $fila["apellidosUsuario"].'</textarea></th>  
  <th  contenteditable="false"><textarea class="textarea textareaRegistro" name="correoUsuario'.$fila["idUsuario"].'">'. $fila["correoUsuario"].'</textarea></th>
  <th  contenteditable="false"><textarea class="textarea textareaRegistro" name="claveUsuario'.$fila["idUsuario"].'">'. $fila["claveUsuario"].'</textarea></th>  
  <td  contenteditable="false" class="contenedorSeclet" style="padding: 0.5rem 0 0.5rem 0.5rem ;">
    <select class="table_select form-select" name="cargoUsuario'.$fila["idUsuario"].'">
        '.$objectoSelects->cargo($fila["cargoUsuario"]).'
    </select>
  </td>
  </tr> ';
  if($_POST['id'.$fila['idUsuario']] != null){
  $listaId[] = $_POST['id'.$fila['idUsuario']];  
  }
  if (isset($_POST['eliminar'.$fila['idUsuario']])){
    $objectoEliminar->delete($fila['idUsuario'],'usuario');
    echo '<script 
          language="JavaScript" type="text/javascript">
          alert("'.$_POST['nombreUsuario'.$fila['idUsuario']].' con el cargo: '.$_POST['cargoUsuario'.$fila['idUsuario']].' y correo: '.$_POST['correoUsuario'.$fila['idUsuario']].', fue eliminado correctamente.");location.href="controlUsuarios.php";
          </script>';
  }    
}
?>
          
<!-- Pie de tabla -->
<?php
    require '../templates/footerT.php';
?>

<!-- Código php para el botón guardarCambios -->
<?php
if (isset($_POST['guardarCambios'])){
  for($i = 0; $i < count($listaId); $i++){
  $objectoActualizar->actualizarUsuariosRegistrados($listaId[$i],$_POST['nombreUsuario'.$listaId[$i]],$_POST['apellidosUsuario'.$listaId[$i]],$_POST['correoUsuario'.$listaId[$i]],$_POST['claveUsuario'.$listaId[$i] ],$_POST['cargoUsuario'.$listaId[$i]]);
  }
echo '<script language="JavaScript" type="text/javascript">
        alert("Los cambios se han guardado correctamente");
        location.href="controlUsuarios.php";
      </script>';
}
?> 

<!-- importar php footer -->
<?php
    require '../templates/footer.php';
?>  