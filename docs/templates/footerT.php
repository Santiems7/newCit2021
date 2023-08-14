<?php
if ($_SERVER['PHP_SELF'] === '/CIT202102/vista/correspondencia.php' || $_SERVER['PHP_SELF'] === '/CIT202102/vista/recibidaInvias.php' || $_SERVER['PHP_SELF'] === '/CIT202102/vista/enviadaCalma.php' || $_SERVER['PHP_SELF'] === '/CIT202102/vista/enviadaInvias.php' || $_SERVER['PHP_SELF'] === '/CIT202102/vista/registroElectrico.php' || $_SERVER['PHP_SELF'] === '/CIT202102/vista/registroITC.php' || $_SERVER['PHP_SELF'] === '/CIT202102/vista/registroMecanico.php' || $_SERVER['PHP_SELF'] === '/CIT202102/vista/mecanico.php' || $_SERVER['PHP_SELF'] === '/CIT202102/vista/materiales.php' || $_SERVER['PHP_SELF'] === '/CIT202102/vista/itc.php' || $_SERVER['PHP_SELF'] === '/CIT202102/vista/historialMateriales.php' || $_SERVER['PHP_SELF'] === '/CIT202102/vista/historialItc.php' || $_SERVER['PHP_SELF'] === '/CIT202102/vista/historialMecanico.php') {
  echo ' 
        </tbody>
      </table>
      </div>
      <div class="container-fluid d-grid gap-2 d-md-flex justify-content-md-end ms-sm-auto p-1 sticky-bottom bg-light">
        <button type="submit" class="btn btn-secondary" name="agregar" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="Agregar"><svg class="bi" width="20" height="20"><use xlink:href="#Patch plus"/></svg></button>
        <button type="submit" class="btn btn-secondary" name="guardarCambios" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="Guardar cambios"><svg class="bi" width="20" height="20"><use xlink:href="#Database fill up"/></svg></button>
      </div>  
    </form>
  </div>
    ';
} else if ($_SERVER['PHP_SELF'] === '/CIT202102/vista/controlUsuarios.php') {
  echo '
      </tbody>
      </table>
      </div>
      <div class="container-fluid d-grid gap-2 d-md-flex justify-content-md-end ms-sm-auto p-1 sticky-bottom bg-light">
        <button type="submit" class="btn btn-secondary" name="guardarCambios" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="Guardar cambios"><svg class="bi" width="20" height="20"><use xlink:href="#Database fill up"/></svg></button>
      </div>  
    </form>
    </div>
  ';
}