<?php
include_once '../modelo/Classconfig.php';
// Esta clase alimentos de options a un select con los administradores registrados en la DB
class SelectAdministradores
{
    private $conn;

    function __contruct($conn)
    {
        $this->conn = $conn;
    }

    function getAdministradores()
    {
        $sql = "SELECT * FROM usuario";
        $resultado = mysqli_query($this->conn, $sql);
        while ($fila = mysqli_fetch_assoc($resultado)) {
            if ($fila['cargoUsuario'] === 'Administrador') {
                echo "<option class='optionCargo' value='" . $fila['correoUsuario'] . "'>" . $fila['correoUsuario'] . "</option>";
            }
        }
        ;
    }
}
?>