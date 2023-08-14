<?php

include_once '../modelo/Classconfig.php';

class Alertas
{
    private $conn;
    private $contenido1;
    private $contenido2;
    public $contenido;
    private $tabla;


    function __construct($conn)
    {
        $this->conn = $conn;
    }

    function calma()
    {
        $this->contenido = '';
        $this->contenido1 = '';
        $this->contenido2 = '';
        $sql = "SELECT * FROM recibidacalma";
        $resultado = mysqli_query($this->conn, $sql);
        date_default_timezone_set('America/Bogota');
        $fechaActual = date('Y/m/d');
        while ($fila = mysqli_fetch_assoc($resultado)) {
            $fechaInicio = new DateTime($fila['fecharecibidoRC']);
            $fechaFin = new DateTime($fechaActual);
            $diferencia = $fechaInicio->diff($fechaFin);
            $dias = $diferencia->days;
            if ($dias > 14) {
                $this->contenido = $this->contenido . '<tr><th class="bg-danger" contenteditable="false">' . $dias . '</th><th class="bg-danger"  contenteditable="false">' . $fila['radicadoRC'] . '</th></tr>';
            } else if ($dias > 6 && $dias < 15) {
                $this->contenido1 = $this->contenido1 . '<tr><th class="bg-warning" contenteditable="false">' . $dias . '</th><th class="bg-warning" contenteditable="false">' . $fila['radicadoRC'] . '</th></tr>';
            } else if ($dias > 2 && $dias < 6) {
                $this->contenido2 = $this->contenido2 . '<tr><th contenteditable="false">' . $dias . '</th><th contenteditable="false">' . $fila['radicadoRC'] . '</th></tr>';
            }
        }
        $this->contenido = $this->contenido . $this->contenido1 . $this->contenido2;
        return $this->contenido;
    }

    function invias()
    {
        $this->contenido = '';
        $this->contenido1 = '';
        $this->contenido2 = '';
        $sql = "SELECT * FROM recibidainvias";
        $resultado = mysqli_query($this->conn, $sql);
        date_default_timezone_set('America/Bogota');
        $fechaActual = date('Y/m/d');
        while ($fila = mysqli_fetch_assoc($resultado)) {
            $fechaInicio = new DateTime($fila['fecharecibidoRI']);
            $fechaFin = new DateTime($fechaActual);
            $diferencia = $fechaInicio->diff($fechaFin);
            $dias = $diferencia->days;
            if ($dias > 14) {
                $this->contenido = $this->contenido . '<tr><th class="bg-danger" contenteditable="false">' . $dias . '</th><th class="bg-danger"  contenteditable="false">' . $fila['radicadoRI'] . '</th></tr>';
            } else if ($dias > 6 && $dias < 15) {
                $this->contenido1 = $this->contenido1 . '<tr><th class="bg-warning" contenteditable="false">' . $dias . '</th><th class="bg-warning" contenteditable="false">' . $fila['radicadoRI'] . '</th></tr>';
            } else if ($dias > 2 && $dias < 6) {
                $this->contenido2 = $this->contenido2 . '<tr><th contenteditable="false">' . $dias . '</th><th contenteditable="false">' . $fila['radicadoRI'] . '</th></tr>';
            }
        }
        $this->contenido = $this->contenido . $this->contenido1 . $this->contenido2;
        return $this->contenido;
    }

    function materiales($tabla)
    {
        $this->tabla = $tabla;

        date_default_timezone_set('America/Bogota');
        $mes_actual = date('m');

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

            default:
                null;
                break;
        }
        $fecha = 'fecharegistro' . $complemento;
        $nombre = 'nombre' . $complemento . '_' . $complemento1;
        $cantidad = 'cantidad' . $complemento;
        $this->contenido = '';
        $sql = "SELECT * FROM $this->tabla WHERE MONTH($fecha) = $mes_actual";
        $resultado = mysqli_query($this->conn, $sql);
        while ($fila = mysqli_fetch_assoc($resultado)) {
            $this->contenido = $this->contenido . '<tr><th class="bg-light" contenteditable="false">' . $fila[$nombre] . '</th><th class="bg-light"  contenteditable="false">' . $fila[$cantidad] . '</th></tr>';
        }
        return $this->contenido;
    }
}

class Selects
{
    private $conn;
    public $contenido;
    private $tunel;
    private $documento;
    private $entidad;
    private $cargo;
    private $area;

    function __construct($conn)
    {
        $this->conn = $conn;
    }

    function tipoDocumento($documento)
    {
        $this->documento = $documento;
        $this->contenido = '';
        $stmt = $this->conn->prepare("SELECT tipoDocumentoTD FROM tipodocumento WHERE idTD = ?");
        $stmt->bind_param("s", $this->documento);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $this->contenido = $this->contenido . '<option value="' . $this->documento . '">' . $row["tipoDocumentoTD"] . '</option>';
        }
        $sql2 = "SELECT * FROM tipodocumento";
        $resultado2 = mysqli_query($this->conn, $sql2);
        while ($fila2 = mysqli_fetch_assoc($resultado2)) {
            if ($fila2['idTD'] !== $this->documento) {
                $this->contenido = $this->contenido . '<option value="' . $fila2["idTD"] . '">' . $fila2["tipoDocumentoTD"] . '</option>';
            }
        }
        return $this->contenido;
    }

    function entidad($entidad)
    {
        $this->entidad = $entidad;
        $this->contenido = '';
        $stmt = $this->conn->prepare("SELECT entidadE FROM entidad WHERE idE = ?");
        $stmt->bind_param("s", $this->entidad);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $this->contenido = $this->contenido . '<option value="' . $this->entidad . '">' . $row["entidadE"] . '</option>';
        }
        $sql2 = "SELECT * FROM entidad";
        $resultado2 = mysqli_query($this->conn, $sql2);
        while ($fila2 = mysqli_fetch_assoc($resultado2)) {
            if ($fila2['idE'] !== $this->entidad) {
                $this->contenido = $this->contenido . '<option value="' . $fila2["idE"] . '">' . $fila2["entidadE"] . '</option>';
            }
        }
        return $this->contenido;
    }

    function cargo($cargo)
    {
        $this->cargo = $cargo;
        $this->contenido = '';
        $stmt = $this->conn->prepare("SELECT descripcionCargo FROM cargo WHERE idCargo = ?");
        $stmt->bind_param("s", $this->cargo);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $this->contenido = $this->contenido . '<option value="' . $this->cargo . '">' . $row["descripcionCargo"] . '</option>';
        }
        $sql2 = "SELECT * FROM cargo";
        $resultado2 = mysqli_query($this->conn, $sql2);
        while ($fila2 = mysqli_fetch_assoc($resultado2)) {
            if ($fila2['idCargo'] !== $this->cargo) {
                $this->contenido = $this->contenido . '<option value="' . $fila2["idCargo"] . '">' . $fila2["descripcionCargo"] . '</option>';
            }
        }
        return $this->contenido;
    }

    function cargoBasico()
    {
        $this->contenido = '';
        $sql2 = "SELECT * FROM cargo";
        $resultado2 = mysqli_query($this->conn, $sql2);
        while ($fila2 = mysqli_fetch_assoc($resultado2)) {
            $this->contenido = $this->contenido . '<option value="' . $fila2["idCargo"] . '">' . $fila2["descripcionCargo"] . '</option>';
        }
        return $this->contenido;
    }

    function area($area)
    {
        $this->area = $area;
        $this->contenido = '';
        $stmt = $this->conn->prepare("SELECT areaA FROM area WHERE idA = ?");
        $stmt->bind_param("i", $this->area);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $this->contenido = $this->contenido . '<option value="' . $this->area . '">' . $row["areaA"] . '</option>';
        }
        $sql2 = "SELECT * FROM area";
        $resultado2 = mysqli_query($this->conn, $sql2);
        while ($fila2 = mysqli_fetch_assoc($resultado2)) {
            if ($fila2['idA'] !== $this->area) {
                $this->contenido = $this->contenido . '<option value="' . $fila2["idA"] . '">' . $fila2["areaA"] . '</option>';
            }
        }
        return $this->contenido;
    }

    function tunel($tunel)
    {
        $this->tunel = $tunel;
        $this->contenido = '';
        $stmt = $this->conn->prepare("SELECT nombreT FROM tunel WHERE idT = ?");
        $stmt->bind_param("i", $this->tunel);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $this->contenido = $this->contenido . '<option value="' . $this->tunel . '">' . $row["nombreT"] . '</option>';
        }
        $sql2 = "SELECT * FROM tunel";
        $resultado2 = mysqli_query($this->conn, $sql2);
        while ($fila2 = mysqli_fetch_assoc($resultado2)) {
            if ($fila2['idT'] !== $this->tunel) {
                $this->contenido = $this->contenido . '<option value="' . $fila2["idT"] . '">' . $fila2["nombreT"] . '</option>';
            }
        }
        return $this->contenido;
    }

}

class Iterador
{
    private $valorInicial;
    public $contenido;
    private $opcionInicial;

    function iterar($valorInicial)
    {
        $this->valorInicial = $valorInicial;
        if ($this->valorInicial == 1) {
            $this->opcionInicial = 'Si';
        } else {
            $this->opcionInicial = 'No';
        }
        $this->contenido = '<option value="' . $this->valorInicial . '">' . $this->opcionInicial . '</option>'
            . '<option value="' . (($this->valorInicial == 1) ? 0 : 1) . '">' . (($this->valorInicial == 1) ? "No" : "Si") . '</option>';
        return $this->contenido;
    }
}
/*$objectoClassconfig= new Classconfig();
    $conn = $objectoClassconfig->openServer();
    $objetoAlertaC = new Alertas($conn);
echo $objetoAlertaC->calma();*/

/*$objectoIterador = new Iterador();
echo $objectoIterador->iterar(0);*/

/*$objectoClassconfig= new Classconfig();
$conn = $objectoClassconfig->openServer();
$objectoSelects = new Selects($conn);
echo $objectoSelects->area(1);*/

/*$objectoClassconfig= new Classconfig();
$conn = $objectoClassconfig->openServer();
$objectoSelects = new Selects($conn);
echo $objectoSelects->tunel(3);*/