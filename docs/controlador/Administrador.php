<?php
include_once '..\modelo\Classconfig.php';
class Administrador
{
    private $conn;
    private $correo;
    private $cargo;
    public $descripcionCargo;
    public $nombre;

    function __construct($conn, $correo)
    {
        $this->conn = $conn;
        $this->correo = $correo;
    }

    public function verificarAdministrador()
    {
        $this->cargo = null;
        $this->descripcionCargo = null;
        $stmt = $this->conn->prepare("SELECT cargoUsuario FROM usuario WHERE correoUsuario = ?");
        $stmt->bind_param("s", $this->correo);
        $stmt->execute();
        $stmt->bind_result($this->cargo);
        $stmt->fetch();
        $stmt->close();
        $stmt = $this->conn->prepare("SELECT descripcionCargo FROM cargo WHERE idCargo = ?");
        $stmt->bind_param("s", $this->cargo);
        $stmt->execute();
        $stmt->bind_result($this->descripcionCargo);
        $stmt->fetch();
        $stmt->close();
        return $this->descripcionCargo;
    }

    public function usuarioSession()
    {
        $this->nombre = null;
        $stmt = $this->conn->prepare("SELECT nombreUsuario FROM usuario WHERE correoUsuario = ?");
        $stmt->bind_param("s", $this->correo);
        $resultado = $stmt->execute();
        $stmt->bind_result($this->nombre);
        $stmt->fetch();
        $stmt->close();
        return $this->nombre;
    }

    public function validacionAdministrador()
    {
        $objectoAdministrador = new Administrador($this->conn, $this->correo);
        $cargo = $objectoAdministrador->verificarAdministrador();
        if ($cargo == 'Administrador' || $cargo == 'Auxiliar Sistemas' || $cargo == 'Auxiliar Civil') {
            return true;
        } else {
            return false;
        }
    }
}
/*$objectoAdministrador = new Administrador('svvantiago@gmail.com');
echo $objectoAdministrador->verificarAdministrador();*/

/*$objectoClassconfig = new Classconfig();
$conn = $objectoClassconfig->openServer();
$objectoU = new Administrador($conn, 'santiago.berrio2@udea.edu.co');
if ($objectoU->validacionAdministrador()) {
    echo 'hi';
}*/