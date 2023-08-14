<?php
class Dias
{
    private $fechaRegistrada;
    private $fechaActual;
    private $diferencia;
    private $fechaInicio;
    private $fechaFin;
    public $dias;
    private $requiereRespuesta;

    /*function __construct($fechaRegistrada){
        $this->fechaRegistrada = $fechaRegistrada;
    }*/

    function diferenciaDias($fechaRegistrada, $requiereRespuesta)
    {
        $this->fechaRegistrada = $fechaRegistrada;
        $this->requiereRespuesta = $requiereRespuesta;

        switch ($this->requiereRespuesta) {
            case 1:
                date_default_timezone_set('America/Bogota');
                $this->fechaActual = date('Y/m/d');
                // Convertir las fechas en objetos DateTime
                $this->fechaInicio = new DateTime($this->fechaRegistrada);
                $fechaFin = new DateTime($this->fechaActual);
                // Calcular la diferencia entre las fechas
                $this->diferencia = $this->fechaInicio->diff($fechaFin);
                // Obtener el resultado en días
                $dias = $this->diferencia->days;
                return $dias;
            case 0:
                $dias = null;
                return $dias;
            default:
                $dias = null;
                return $dias;
        }
    }
}

/*$objetoDias = new Dias();
$objetoDias->diferenciaDias('2023-06-10');*/