<?php

include_once '../modelo/Classconfig.php';
require '../vendor/autoload.php';

class Registrar
{
    private $conn;
    private $id; // Se incluye el id para completar el contenido de la tabla
    private $nombre;
    private $apellidos;
    private $correo;
    private $clave;
    private $claveI;
    private $cargo;

    function __construct($conn)
    {
        $this->conn = $conn;
    }

    function registro($nombre, $apellidos, $correo, $clave, $cargo)
    {
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->correo = $correo;
        $this->clave = $clave;
        $this->cargo = $cargo;
        $this->claveI = MD5($this->clave);
        $stmt = $this->conn->prepare("INSERT INTO usuario (nombreUsuario,apellidosUsuario,correoUsuario,claveUsuario,cargoUsuario) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $this->nombre, $this->apellidos, $this->correo, $this->claveI, $this->cargo);
        $stmt->execute();
        $stmt->close();
    }
}

class Eliminar
{
    private $id;
    private $tabla;
    private $conn;

    function __construct($conn)
    {
        $this->conn = $conn;
    }

    function delete($id, $tabla)
    {
        $this->id = $id;
        $this->tabla = $tabla;
        $stmt = $this->conn->prepare("DELETE FROM $this->tabla WHERE  idUsuario = ?");
        $stmt->bind_param("s", $this->id);
        $stmt->execute();
        $stmt->close();
    }
}

class Actualiazar
{
    private $id;
    private $nombre;
    private $apellidos;
    private $correo;
    private $clave;
    private $cargo;
    private $claveI;
    private $conn;
    private $claveInicial;

    function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function actualizarUsuariosRegistrados($id, $nombre, $apellidos, $correo, $clave, $cargo)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->correo = $correo;
        $this->clave = $clave;
        $this->cargo = $cargo;
        $this->claveI = MD5($this->clave);
        $this->claveInicial = null;
        $stmt = $this->conn->prepare("SELECT claveUsuario FROM usuario WHERE idUsuario = ?");
        $stmt->bind_param("s", $this->id);
        $stmt->execute();
        $stmt->bind_result($this->claveInicial);
        $stmt->fetch();
        $stmt->close();
        if ($this->clave != $this->claveInicial) {
            $sql = "UPDATE usuario SET nombreUsuario = ?, apellidosUsuario = ?, correoUsuario = ?, claveUsuario = ?, cargoUsuario = ? WHERE idUsuario = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("sssssi", $this->nombre, $this->apellidos, $this->correo, $this->claveI, $this->cargo, $this->id);
            $stmt->execute();
            $stmt->close();
            echo $this->nombre . '<br>';
        } else {
            $sql = "UPDATE usuario SET nombreUsuario = ?, apellidosUsuario = ?, correoUsuario = ?, cargoUsuario = ? WHERE idUsuario = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("ssssi", $this->nombre, $this->apellidos, $this->correo, $this->cargo, $this->id);
            $stmt->execute();
            $stmt->close();
            echo $this->correo . '<br>';
        }
    }
}

class Cargo
{
    private $tabla;
    private $id;

    function __construct($tabla, $id)
    {
        $this->tabla = $tabla;
        $this->id = $id;
    }

    function cargos()
    {
        $objectoClassconfig = new Classconfig();
        $conn = $objectoClassconfig->openServer();
        $stmt = $conn->prepare("SELECT descripcionCargo FROM $this->tabla WHERE idCargo = ?");
        $stmt->bind_param("s", $this->id);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            echo '<option value="' . $this->id . '">' . $row["descripcionCargo"] . '</option>';
        }

        $sql2 = "SELECT * FROM $this->tabla";
        $resultado2 = mysqli_query($conn, $sql2);
        while ($fila2 = mysqli_fetch_assoc($resultado2)) {
            if ($fila2['idCargo'] !== $this->id) {
                echo '<option value="' . $fila2["idCargo"] . '">' . $fila2["descripcionCargo"] . '</option>';
            }
        }
        /**/
        /*$sql2 = "SELECT * FROM usuario";*/
        $objectoClassconfig->closeServer();
    }
}

class Radicado
{
    private $conn;
    private $ultimo_valorRC;
    private $ultimo_valorRI;
    private $ultimo_valorEC;
    private $ultimo_valorEI;

    function __construct($conn)
    {
        $this->conn = $conn;
    }

    function radicadoRecibidas()
    {
        $sql = "SELECT MAX(radicadoRC) AS ultimo_valorRC FROM recibidacalma;";
        $resultado = mysqli_query($this->conn, $sql);
        if ($resultado) {
            $row = mysqli_fetch_assoc($resultado);
            $ultimo_valorRC = $row['ultimo_valorRC'];
        }
        $sql = "SELECT MAX(radicadoRI) AS ultimo_valorRI FROM recibidainvias;";
        $resultado = mysqli_query($this->conn, $sql);
        if ($resultado) {
            $row = mysqli_fetch_assoc($resultado);
            $ultimo_valorRI = $row['ultimo_valorRI'];
        }
        if ($ultimo_valorRC >= $ultimo_valorRI) {
            $ultimo_valorRC += 1;
            return $ultimo_valorRC;
        } else {
            $ultimo_valorRI += 1;
            return $ultimo_valorRI;
        }
    }

    function radicadoEnviadas()
    {
        $sql = "SELECT MAX(radicadoEC) AS ultimo_valorEC FROM enviadacalma;";
        $resultado = mysqli_query($this->conn, $sql);
        if ($resultado) {
            $row = mysqli_fetch_assoc($resultado);
            $ultimo_valorEC = $row['ultimo_valorEC'];
        }
        $sql = "SELECT MAX(radicadoEI) AS ultimo_valorEI FROM enviadainvias;";
        $resultado = mysqli_query($this->conn, $sql);
        if ($resultado) {
            $row = mysqli_fetch_assoc($resultado);
            $ultimo_valorEI = $row['ultimo_valorEI'];
        }
        if ($ultimo_valorEC >= $ultimo_valorEI) {
            $ultimo_valorEC += 1;
            return $ultimo_valorEC;
        } else {
            $ultimo_valorEI += 1;
            return $ultimo_valorEI;
        }
    }
}

class RecibidaCalma
{
    private $conn;
    private $referenciaRC = null;
    private $radicadoRC;
    private $tipodocumentoRC_TD = 'C';
    private $adjuntoRC = 0;
    private $foliosRC = null;
    private $fecharecibidoRC = '';
    private $fechadocumentoRC = '';
    private $entidadRC_E = 1;
    private $referencia2RC = null;
    private $nombreRC = '';
    private $cargoRC_Cargo = 1;
    private $asuntoRC = '';
    private $requiererespuestaRC = 1;
    private $responsablesRC = '';
    private $areaRC_A = 1;
    private $respuestadeRC = '';
    private $tderespuestaRC = null;

    function __construct($conn)
    {
        $this->conn = $conn;
    }

    function nuevo()
    {
        $objectoRadicado = new Radicado($this->conn);
        $this->radicadoRC = $objectoRadicado->radicadoRecibidas();
        $stmt = $this->conn->prepare("INSERT INTO recibidacalma( referenciaRC, radicadoRC, tipodocumentoRC_TD, adjuntoRC, foliosRC, fecharecibidoRC, fechadocumentoRC, entidadRC_E, referencia2RC, nombreRC, cargoRC_Cargo, asuntoRC, requiererespuestaRC, responsablesRC, areaRC_A, respuestadeRC, tderespuestaRC) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
        $stmt->bind_param("sisiississisisisi", $this->referenciaRC, $this->radicadoRC, $this->tipodocumentoRC_TD, $this->adjuntoRC, $this->foliosRC, $this->fecharecibidoRC, $this->fechadocumentoRC, $this->entidadRC_E, $this->referencia2RC, $this->nombreRC, $this->cargoRC_Cargo, $this->asuntoRC, $this->requiererespuestaRC, $this->responsablesRC, $this->areaRC_A, $this->respuestadeRC, $this->tderespuestaRC);
        $stmt->execute();
        $stmt->close();
    }
}

class EnviadaCalma
{
    private $conn;
    private $idEC; // Se incluye el id para completar el contenido de la tabla
    private $referenciaEC = null;
    private $radicadoEC = 3;
    private $tipodocumentoEC_TD = 'C';
    private $adjuntoEC = null;
    private $foliosEC = null;
    private $fecharecibidoEC = null;
    private $fechadocumentoEC = null;
    private $entidadEC_E = 1;
    private $referencia2EC = null;
    private $nombreEC = null;
    private $asuntoEC = null;
    private $areaEC_A = 1;

    function __construct($conn)
    {
        $this->conn = $conn;
    }

    function nuevo()
    {
        $objectoRadicado = new Radicado($this->conn);
        $this->radicadoEC = $objectoRadicado->radicadoEnviadas();
        $stmt = $this->conn->prepare("INSERT INTO enviadacalma(referenciaEC, radicadoEC, tipodocumentoEC_TD, adjuntoEC, foliosEC, fecharecibidoEC, fechadocumentoEC, entidadEC_E, referencia2EC, nombreEC, asuntoEC, areaEC_A) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)");
        $stmt->bind_param("sisiississsi", $this->referenciaEC, $this->radicadoEC, $this->tipodocumentoEC_TD, $this->adjuntoEC, $this->foliosEC, $this->fecharecibidoEC, $this->fechadocumentoEC, $this->entidadEC_E, $this->referencia2EC, $this->nombreEC, $this->asuntoEC, $this->areaEC_A);
        $stmt->execute();
        $stmt->close();
    }
}

class RecibidaInvias
{
    private $conn;
    private $idRI; // Se incluye el id para completar el contenido de la tabla
    private $referenciaRI = null;
    private $radicadoRI = null;
    private $tipodocumentoRI_TD = 'C';
    private $adjuntoRI = 0;
    private $foliosRI = null;
    private $fecharecibidoRI = null;
    private $fechadocumentoRI = null;
    private $entidadRI_E = 1;
    private $referencia2RI = null;
    private $nombreRI = null;
    private $cargoRI_Cargo = 1;
    private $asuntoRI = null;
    private $requiererespuestaRI = 1;
    private $responsablesRI = null;
    private $areaRI_A = 1;
    private $respuestadeRI = null;
    private $tderespuestaRI = null;

    function __construct($conn)
    {
        $this->conn = $conn;
    }

    function nuevo()
    {
        $objectoRadicado = new Radicado($this->conn);
        $this->radicadoRI = $objectoRadicado->radicadoRecibidas();
        $stmt = $this->conn->prepare("INSERT INTO recibidainvias(referenciaRI, radicadoRI, tipodocumentoRI_TD, adjuntoRI, foliosRI, fecharecibidoRI, fechadocumentoRI, entidadRI_E, referencia2RI, nombreRI, cargoRI_Cargo, asuntoRI, requiererespuestaRI, responsablesRI, areaRI_A, respuestadeRI, tderespuestaRI) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
        $stmt->bind_param("sisiississisisisi", $this->referenciaRI, $this->radicadoRI, $this->tipodocumentoRI_TD, $this->adjuntoRI, $this->foliosRI, $this->fecharecibidoRI, $this->fechadocumentoRI, $this->entidadRI_E, $this->referencia2RI, $this->nombreRI, $this->cargoRI_Cargo, $this->asuntoRI, $this->requiererespuestaRI, $this->responsablesRI, $this->areaRI_A, $this->respuestadeRI, $this->tderespuestaRI);
        $stmt->execute();
        $stmt->close();
    }
}

class EnviadaInvias
{
    private $conn;
    private $idEI; // Se incluye el id para completar el contenido de la tabla
    private $referenciaEI = null;
    private $radicadoEI = null;
    private $tipodocumentoEI_TD = 'C';
    private $adjuntoEI = null;
    private $foliosEI = null;
    private $fecharecibidoEI = null;
    private $fechadocumentoEI = null;
    private $entidadEI_E = 1;
    private $referencia2EI = null;
    private $nombreEI = null;
    private $asuntoEI = null;
    private $areaEI_A = 1;

    function __construct($conn)
    {
        $this->conn = $conn;
    }

    function nuevo()
    {
        $objectoRadicado = new Radicado($this->conn);
        $this->radicadoEI = $objectoRadicado->radicadoEnviadas();
        $stmt = $this->conn->prepare("INSERT INTO enviadainvias(referenciaEI, radicadoEI, tipodocumentoEI_TD, adjuntoEI, foliosEI, fecharecibidoEI, fechadocumentoEI, entidadEI_E, referencia2EI, nombreEI, asuntoEI, areaEI_A) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)");
        $stmt->bind_param("sisiississsi", $this->referenciaEI, $this->radicadoEI, $this->tipodocumentoEI_TD, $this->adjuntoEI, $this->foliosEI, $this->fecharecibidoEI, $this->fechadocumentoEI, $this->entidadEI_E, $this->referencia2EI, $this->nombreEI, $this->asuntoEI, $this->areaEI_A);
        $stmt->execute();
        $stmt->close();
    }
}

class Eliminarcorrespondencia
{
    private $conn;
    private $tabla;
    private $nombreColumna;
    private $id;

    function __construct($conn, $tabla, $nombreColumna)
    {
        $this->conn = $conn;
        $this->tabla = $tabla;
        $this->nombreColumna = $nombreColumna;
    }

    function eliminar($id)
    {
        $this->id = $id;
        $stmt = $this->conn->prepare("DELETE FROM $this->tabla WHERE  $this->nombreColumna = ?");
        $stmt->bind_param("s", $this->id);
        $stmt->execute();
        $stmt->close();
    }
}

class ActualizarCorrespondendecia
{
    private $conn;
    private $tabla;
    private $id;
    private $referencia;
    private $radicado;
    private $tipodocumento;
    private $adjunto;
    private $folios;
    private $fecharecibido;
    private $fechadocumento;
    private $entidad;
    private $referencia2;
    private $nombre;
    private $cargo;
    private $asunto;
    private $requiererespuesta;
    private $responsables;
    private $area;
    private $respuestade;
    private $tiempoRespuesta;
    public $respuesta;
    private $requiere;

    function __construct($conn, $tabla)
    {
        $this->conn = $conn;
        $this->tabla = $tabla;
    }

    function actualizarR($id, $referencia, $radicado, $tipodocumento, $adjunto, $folios, $fecharecibido, $fechadocumento, $entidad, $referencia2, $nombre, $cargo, $asunto, $requiererespuesta, $responsables, $area, $respuestade)
    {
        $this->id = $id;
        $this->referencia = $referencia;
        $this->radicado = $radicado;
        $this->tipodocumento = $tipodocumento;
        $this->adjunto = $adjunto;
        $this->folios = $folios;
        $this->fecharecibido = $fecharecibido;
        $this->fechadocumento = $fechadocumento;
        $this->entidad = $entidad;
        $this->referencia2 = $referencia2;
        $this->nombre = $nombre;
        $this->cargo = $cargo;
        $this->asunto = $asunto;
        $this->requiererespuesta = $requiererespuesta;
        $this->responsables = $responsables;
        $this->area = $area;
        $this->respuestade = $respuestade;
        $this->tiempoRespuesta = null;

        date_default_timezone_set('America/Bogota');

        switch ($this->tabla) {
            case 'recibidacalma':
                $sqlRequiere = "SELECT requiererespuestaRC AS requiere FROM recibidacalma WHERE idRC = $id;";
                $resultadoRequiere = mysqli_query($this->conn, $sqlRequiere);
                if ($resultadoRequiere) {
                    $row = mysqli_fetch_assoc($resultadoRequiere);
                    $requiere = $row['requiere'];
                    $requiere = intval($requiere);
                } else {
                    $requiere = 0;
                }
                //echo $requiere.'<br>';

                if ($this->requiererespuesta === 0 && $requiere === 0 || $this->requiererespuesta === 1 && $requiere === 1) {
                    //echo 1;
                    $sql = "UPDATE $this->tabla SET referenciaRC = ?, radicadoRC = ?, tipodocumentoRC_TD = ?, adjuntoRC = ?, foliosRC = ?, fecharecibidoRC = ?, fechadocumentoRC = ?, entidadRC_E = ?, referencia2RC = ?, nombreRC = ?, cargoRC_Cargo = ?, asuntoRC = ?, responsablesRC = ?, areaRC_A = ?, respuestadeRC = ? WHERE idRC = ?";
                    $stmt = $this->conn->prepare($sql);
                    $stmt->bind_param("sisiissississisi", $this->referencia, $this->radicado, $this->tipodocumento, $this->adjunto, $this->folios, $this->fecharecibido, $this->fechadocumento, $this->entidad, $this->referencia2, $this->nombre, $this->cargo, $this->asunto, $this->responsables, $this->area, $this->respuestade, $this->id);
                    $stmt->execute();
                    $stmt->close();
                } else if ($this->requiererespuesta === 0 && $requiere === 1) {
                    //echo '2';
                    $fechaActual = date('Y/m/d');
                    $fechaInicio = new DateTime($this->fecharecibido);
                    $fechaFin = new DateTime($fechaActual);
                    $diferencia = $fechaInicio->diff($fechaFin);
                    $this->tiempoRespuesta = $diferencia->days;
                    $sql = "UPDATE $this->tabla SET referenciaRC = ?, radicadoRC = ?, tipodocumentoRC_TD = ?, adjuntoRC = ?, foliosRC = ?, fecharecibidoRC = ?, fechadocumentoRC = ?, entidadRC_E = ?, referencia2RC = ?, nombreRC = ?, cargoRC_Cargo = ?, asuntoRC = ?, requiererespuestaRC = ?, responsablesRC = ?, areaRC_A = ?, respuestadeRC = ?, tderespuestaRC = ? WHERE idRC = ?";
                    $stmt = $this->conn->prepare($sql);
                    if ($stmt === false) {
                        die("Error en la preparación de la consulta: " . $this->conn->error);
                    }
                    $stmt->bind_param("sisiississisisisii", $this->referencia, $this->radicado, $this->tipodocumento, $this->adjunto, $this->folios, $this->fecharecibido, $this->fechadocumento, $this->entidad, $this->referencia2, $this->nombre, $this->cargo, $this->asunto, $this->requiererespuesta, $this->responsables, $this->area, $this->respuestade, $this->tiempoRespuesta, $this->id);
                    $stmt->execute();
                    $stmt->close();
                } else if ($this->requiererespuesta === 1 && $requiere === 0) {
                    //echo 3;
                    $this->tiempoRespuesta = null;
                    $sql = "UPDATE $this->tabla SET referenciaRC = ?, radicadoRC = ?, tipodocumentoRC_TD = ?, adjuntoRC = ?, foliosRC = ?, fecharecibidoRC = ?, fechadocumentoRC = ?, entidadRC_E = ?, referencia2RC = ?, nombreRC = ?, cargoRC_Cargo = ?, asuntoRC = ?, requiererespuestaRC = ?, responsablesRC = ?, areaRC_A = ?, respuestadeRC = ?, tderespuestaRC = ? WHERE idRC = ?";
                    $stmt = $this->conn->prepare($sql);
                    $stmt->bind_param("sisiississisisisii", $this->referencia, $this->radicado, $this->tipodocumento, $this->adjunto, $this->folios, $this->fecharecibido, $this->fechadocumento, $this->entidad, $this->referencia2, $this->nombre, $this->cargo, $this->asunto, $this->requiererespuesta, $this->responsables, $this->area, $this->respuestade, $this->tiempoRespuesta, $this->id);
                    $stmt->execute();
                    $stmt->close();
                }
                break;
            case 'recibidainvias':
                $sqlRequiere = "SELECT requiererespuestaRI AS requiere FROM recibidainvias  WHERE idRI = $id;";
                $resultadoRequiere = mysqli_query($this->conn, $sqlRequiere);
                if ($resultadoRequiere) {
                    $row = mysqli_fetch_assoc($resultadoRequiere);
                    $requiere = $row['requiere'];
                    $requiere = intval($requiere);
                } else {
                    $requiere = 0;
                }
                if ($this->requiererespuesta === 0 && $requiere === 0 || $this->requiererespuesta === 1 && $requiere === 1) {
                    $sql = "UPDATE $this->tabla SET referenciaRI = ?, radicadoRI = ?, tipodocumentoRI_TD = ?, adjuntoRI = ?, foliosRI = ?, fecharecibidoRI = ?, fechadocumentoRI = ?, entidadRI_E = ?, referencia2RI = ?, nombreRI = ?, cargoRI_Cargo = ?, asuntoRI = ?, responsablesRI = ?, areaRI_A = ?, respuestadeRI = ? WHERE idRI = ?";
                    $stmt = $this->conn->prepare($sql);
                    $stmt->bind_param("sisiissississisi", $this->referencia, $this->radicado, $this->tipodocumento, $this->adjunto, $this->folios, $this->fecharecibido, $this->fechadocumento, $this->entidad, $this->referencia2, $this->nombre, $this->cargo, $this->asunto, $this->responsables, $this->area, $this->respuestade, $this->id);
                    $stmt->execute();
                    $stmt->close();
                    //echo 'cambio en invias';
                } else if ($this->requiererespuesta === 0 && $requiere === 1) {
                    $fechaActual = date('Y/m/d');
                    $fechaInicio = new DateTime($this->fecharecibido);
                    $fechaFin = new DateTime($fechaActual);
                    $diferencia = $fechaInicio->diff($fechaFin);
                    $this->tiempoRespuesta = $diferencia->days;
                    $sql = "UPDATE $this->tabla SET referenciaRI = ?, radicadoRI = ?, tipodocumentoRI_TD = ?, adjuntoRI = ?, foliosRI = ?, fecharecibidoRI = ?, fechadocumentoRI = ?, entidadRI_E = ?, referencia2RI = ?, nombreRI = ?, cargoRI_Cargo = ?, asuntoRI = ?, requiererespuestaRI = ?, responsablesRI = ?, areaRI_A = ?, respuestadeRI = ?, tderespuestaRI = ? WHERE idRI = ?";
                    $stmt = $this->conn->prepare($sql);
                    $stmt->bind_param("sisiississisisisii", $this->referencia, $this->radicado, $this->tipodocumento, $this->adjunto, $this->folios, $this->fecharecibido, $this->fechadocumento, $this->entidad, $this->referencia2, $this->nombre, $this->cargo, $this->asunto, $this->requiererespuesta, $this->responsables, $this->area, $this->respuestade, $this->tiempoRespuesta, $this->id);
                    $stmt->execute();
                    $stmt->close();
                    //echo 'cambio en invias';
                } else if ($this->requiererespuesta === 1 && $requiere === 0) {
                    $this->tiempoRespuesta = null;
                    $sql = "UPDATE $this->tabla SET referenciaRI = ?, radicadoRI = ?, tipodocumentoRI_TD = ?, adjuntoRI = ?, foliosRI = ?, fecharecibidoRI = ?, fechadocumentoRI = ?, entidadRI_E = ?, referencia2RI = ?, nombreRI = ?, cargoRI_Cargo = ?, asuntoRI = ?, requiererespuestaRI = ?, responsablesRI = ?, areaRI_A = ?, respuestadeRI = ?, tderespuestaRI = ? WHERE idRI = ?";
                    $stmt = $this->conn->prepare($sql);
                    $stmt->bind_param("sisiississisisisii", $this->referencia, $this->radicado, $this->tipodocumento, $this->adjunto, $this->folios, $this->fecharecibido, $this->fechadocumento, $this->entidad, $this->referencia2, $this->nombre, $this->cargo, $this->asunto, $this->requiererespuesta, $this->responsables, $this->area, $this->respuestade, $this->tiempoRespuesta, $this->id);
                    $stmt->execute();
                    $stmt->close();
                    //echo 'cambio en invias';
                }
                break;
            default:
                break;
        }

    }

    function actualizarE($id, $referencia, $radicado, $tipodocumento, $adjunto, $folios, $fecharecibido, $fechadocumento, $entidad, $referencia2, $nombre, $asunto, $area)
    {
        $this->id = $id;
        $this->referencia = $referencia;
        $this->radicado = $radicado;
        $this->tipodocumento = $tipodocumento;
        $this->adjunto = $adjunto;
        $this->folios = $folios;
        $this->fecharecibido = $fecharecibido;
        $this->fechadocumento = $fechadocumento;
        $this->entidad = $entidad;
        $this->referencia2 = $referencia2;
        $this->nombre = $nombre;
        $this->asunto = $asunto;
        $this->area = $area;

        switch ($this->tabla) {
            case 'enviadacalma':
                $sql = "UPDATE $this->tabla SET referenciaEC = ?, radicadoEC = ?, tipodocumentoEC_TD = ?, adjuntoEC = ?, foliosEC = ?, fecharecibidoEC = ?, fechadocumentoEC = ?, entidadEC_E = ?, referencia2EC = ?, nombreEC = ?, asuntoEC = ?, areaEC_A = ? WHERE idEC = ?";
                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param("sisiississsii", $this->referencia, $this->radicado, $this->tipodocumento, $this->adjunto, $this->folios, $this->fecharecibido, $this->fechadocumento, $this->entidad, $this->referencia2, $this->nombre, $this->asunto, $this->area, $this->id);
                $stmt->execute();
                $stmt->close();
                break;
            case 'enviadainvias':
                $sql = "UPDATE $this->tabla SET referenciaEI = ?, radicadoEI = ?, tipodocumentoEI_TD = ?, adjuntoEI = ?, foliosEI = ?, fecharecibidoEI = ?, fechadocumentoEI = ?, entidadEI_E = ?, referencia2EI = ?, nombreEI = ?, asuntoEI = ?, areaEI_A = ? WHERE idEI = ?";
                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param("sisiississsii", $this->referencia, $this->radicado, $this->tipodocumento, $this->adjunto, $this->folios, $this->fecharecibido, $this->fechadocumento, $this->entidad, $this->referencia2, $this->nombre, $this->asunto, $this->area, $this->id);
                $stmt->execute();
                $stmt->close();
                break;
            default:
                break;
        }

    }
}

class Copias
{
    private $radicado;
    public $tabla;


    function tablaRadicado($radicado)
    {
        $this->radicado = $radicado;

        $tabla = '| Encabezado 1 | Encabezado 2 | Encabezado 3 |
|-------------|-------------|-------------|
| Celda 1-1   | Celda 1-2   | Celda 1-3   |
| Celda 2-1   | Celda 2-2   | Celda 2-3   |
| Celda 3-1   | Celda 3-2   | ' . $this->radicado . '   |';
        return $tabla;
    }

}

class RegistrosMateriales
{
    private $conn;
    private $tabla;
    private $nombreColumna;
    private $id; // Se incluye el id para completar el contenido de la tabla
    private $nombre = null;
    private $descripcion = null;
    private $valor = null;
    private $tunel = null;
    private $lote = null;
    private $cantidad = 1;
    private $responsable = null;
    private $fecha;

    function __construct($conn)
    {
        $this->conn = $conn;
    }

    function nuevoRegistroElectrico()
    {
        $stmt = $this->conn->prepare("INSERT INTO registroElectricos(nombreREC, descripcionREC, valorREC, tunelREC_T) VALUES (?,?,?,?)");
        $stmt->bind_param("ssdi", $this->nombre, $this->descripcion, $this->valor, $this->tunel);
        $stmt->execute();
        $stmt->close();
    }

    function nuevoRegistroITC()
    {
        $stmt = $this->conn->prepare("INSERT INTO registroitc(nombreRITC, descripcionRITC, valorRITC, tunelRITC_T) VALUES (?,?,?,?)");
        $stmt->bind_param("ssdi", $this->nombre, $this->descripcion, $this->valor, $this->tunel);
        $stmt->execute();
        $stmt->close();
    }

    function nuevoRegistroMecanico()
    {
        $stmt = $this->conn->prepare("INSERT INTO registromecanico(nombreRME, descripcionRME, valorRME, tunelRME_T) VALUES (?,?,?,?)");
        $stmt->bind_param("ssdi", $this->nombre, $this->descripcion, $this->valor, $this->tunel);
        $stmt->execute();
        $stmt->close();
    }

    function nuevoElectrico()
    {
        date_default_timezone_set('America/Bogota');
        $fechaActual = date('Y/m/d');
        $stmt = $this->conn->prepare("INSERT INTO electrico(fecharegistroEL, tunelEL_T, nombreEL_REC, loteEL, cantidadEL, responsableEL) VALUES (?,?,?,?,?,?)");
        $stmt->bind_param("siisis", $fechaActual, $this->tunel, $this->nombre, $this->lote, $this->cantidad, $this->responsable);
        $stmt->execute();
        $stmt->close();
    }

    function nuevoITC()
    {
        date_default_timezone_set('America/Bogota');
        $fechaActual = date('Y/m/d');
        $stmt = $this->conn->prepare("INSERT INTO itc(fecharegistroITC, tunelITC_T, nombreITC_RITC, loteITC, cantidadITC, responsableITC) VALUES (?,?,?,?,?,?)");
        $stmt->bind_param("siisis", $fechaActual, $this->tunel, $this->nombre, $this->lote, $this->cantidad, $this->responsable);
        $stmt->execute();
        $stmt->close();
    }

    function nuevoMecanico()
    {
        date_default_timezone_set('America/Bogota');
        $fechaActual = date('Y/m/d');
        $stmt = $this->conn->prepare("INSERT INTO mecanico(fecharegistroME, tunelME_T, nombreME_RME, loteME, cantidadME, responsableME) VALUES (?,?,?,?,?,?)");
        $stmt->bind_param("siisis", $fechaActual, $this->tunel, $this->nombre, $this->lote, $this->cantidad, $this->responsable);
        $stmt->execute();
        $stmt->close();
    }

    function actualizarRegistro($tabla, $id, $nombre, $descripcion, $valor, $tunel)
    {
        $this->tabla = $tabla;
        $this->id = $id;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->valor = $valor;
        $this->tunel = $tunel;

        switch ($this->tabla) {
            case 'registroelectricos':
                $complemento = 'REC';
                break;
            case 'registroitc':
                $complemento = 'RITC';
                break;
            case 'registromecanico':
                $complemento = 'RME';
                break;
        }

        $nombreNC = 'nombre' . $complemento;
        $descripcionNC = 'descripcion' . $complemento;
        $valorNC = 'valor' . $complemento;
        $tunelNC = 'tunel' . $complemento . '_T';
        $idNC = 'id' . $complemento;

        $sql = "UPDATE $this->tabla SET $nombreNC = ?, $descripcionNC = ?, $valorNC = ?, $tunelNC = ? WHERE $idNC= ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssdii", $this->nombre, $this->descripcion, $this->valor, $this->tunel, $this->id);
        if ($stmt->execute()) {
        } else {
            echo 'Error al actualizar: ' . $stmt->error;
        }
        $stmt->close();
    }

    function actualizarMaterial($tabla, $id, $fecha, $tunel, $nombre, $lote, $cantidad, $responsable)
    {
        $this->tabla = $tabla;
        $this->id = $id;
        $this->fecha = $fecha;
        $this->tunel = $tunel;
        $this->nombre = $nombre;
        $this->lote = $lote;
        $this->cantidad = $cantidad;
        $this->responsable = $responsable;

        switch ($this->tabla) {
            case 'electrico':
                $complemento = 'EL';
                $complemento1 = 'REC';
                break;
            case 'itc':
                $complemento = 'ITC';
                $complemento1 = 'RITC';
                break;
            case 'mecanico':
                $complemento = 'ME';
                $complemento1 = 'RME';
                break;
        }
        $fechaNC = 'fecharegistro' . $complemento;
        $tunelNC = 'tunel' . $complemento . '_T';
        $nombreNC = 'nombre' . $complemento . '_' . $complemento1;
        $loteNC = 'lote' . $complemento;
        $cantidadNC = 'cantidad' . $complemento;
        $responsableNC = 'responsable' . $complemento;
        $idNC = 'id' . $complemento;
        echo $nombreNC;
        $sql = "UPDATE $this->tabla SET $fechaNC = ?, $tunelNC = ?, $nombreNC = ?, $loteNC = ?, $cantidadNC = ?, $responsableNC = ? WHERE $idNC= ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("siisisi", $this->fecha, $this->tunel, $this->nombre, $this->lote, $this->cantidad, $this->responsable, $this->id);
        if ($stmt->execute()) {
        } else {
            echo 'Error al actualizar: ' . $stmt->error;
        }
        $stmt->close();
    }

    function EliminarRegistro($tabla, $nombreColumna, $id)
    {
        $this->tabla = $tabla;
        $this->nombreColumna = $nombreColumna;
        $this->id = $id;

        $stmt = $this->conn->prepare("DELETE FROM $this->tabla WHERE  $this->nombreColumna = ?");
        $stmt->bind_param("s", $this->id);
        $stmt->execute();
        $stmt->close();
    }

    function valorunitario($tabla, $id)
    {
        $this->tabla = $tabla;
        $this->id = $id;

        switch ($this->tabla) {
            case 'registroelectricos':
                $complemento = 'REC';
                break;
            case 'registroitc':
                $complemento = 'RITC';
                break;
            case 'registromecanico':
                $complemento = 'RME';
                break;
        }
        $this->valor = 'valor' . $complemento;
        $idSQL = 'id' . $complemento;

        $sqlRequiere = "SELECT $this->valor AS valorunitario FROM $this->tabla WHERE $idSQL = $this->id;";
        $resultadoRequiere = mysqli_query($this->conn, $sqlRequiere);
        if ($resultadoRequiere) {
            $row = mysqli_fetch_assoc($resultadoRequiere);
            $valorunitario = $row['valorunitario'];
            $valorunitario = intval($valorunitario);
        } else {
            $valorunitario = 0;
        }
        return $valorunitario;
    }
}

/*$this->radicado = $radicado = new Radicado(); // Instancia de la clase Radicado
$radicado->maximoRecibidas();*/
/*$objetoRecibidaInvias = new RecibidaInvias(null = ?,2,1,0,200,'2023/07/07','2023/07/07',1,200,'nombre',1,'asunto',0,'responsable',1,'respuestade',200)
$objetoRecibidaInvias->nuevo();*/
/*$objectoRegistrar = new Registrar('marcela','vega','svvantiago@outlook.com','81dc9bdb52d04dc20036dbd8313ed055','Operario');
$objectoRegistrar->registro();*/

/*$objectoEliminar = new Eliminar(64);
$objectoEliminar->deletePreRegistro();*/

/*$objectoActualizar = new Actualiazar('164');
$objectoActualizar->actualizarUsuariosRegistrados('Missy','Vega Jimenez','missy@gmail.com','1234','Administrador');*/

/* $objetoEnviadaInvias = new EnviadaInvias(null,3,1,null,null,'','',1,'','','',1);
$objetoEnviadaInvias->nuevo();*/
/*$objectoClassconfig= new Classconfig();
    $conn = $objectoClassconfig->openServer();
    $objetoActualizarR = new ActualizarCorrespondendecia($conn,'enviadainvias');
$objetoActualizarR->actualizarE(6,'INV-TOYO-INT-595-23',2,1,null,null,'','',1,'','','',1);*/
/*$objetoActualizarR->actualizarR(85,null,2,1,0,200,'2023/07/07','2023/07/07',1,'','nombre',1,'asunto',0,'responsable',1,'respuestade');*/

/*$objectoRadicado = new Copias();
echo $objectoRadicado->tablaRadicado('1');*/

/*$objectoClassconfig= new Classconfig();
$conn = $objectoClassconfig->openServer();
$objectoRegistrosMateriales = new RegistrosMateriales($conn);
$objectoRegistrosMateriales->nuevoRegistroElectrico();
*/
/*
$objectoClassconfig = new Classconfig();
$conn = $objectoClassconfig->openServer();
$objectoRegistroMateriales = new RegistrosMateriales($conn);
$objectoRegistroMateriales->actualizarRegistroElectrico('registroelectricos', 331, '18,1,3', '13', 2, 2);
*/
/*
$objectoClassconfig = new Classconfig();
$conn = $objectoClassconfig->openServer();
$objectoRegistroMateriales = new RegistrosMateriales($conn);
echo $objectoRegistroMateriales->valorunitario(1);
*/
?>