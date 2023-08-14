<?php
require_once("../modelo/Classconfig.php");
require '../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


class Correo
{
    private $conn;
    private $recipientMail;
    private $recipientName;
    private $key;
    private $cargo;
    public $correo;
    private $cargoString;

    function __construct($conn)
    {
        $this->conn = $conn;
    }


    function envio($recipientMail, $recipientName, $key, $cargo)
    {
        $this->recipientMail = $recipientMail;
        $this->recipientName = $recipientName;
        $this->key = $key;
        $this->cargo = $cargo;

        $mail = new PHPMailer(true);
        try {
            // Obtener corgo
            $this->cargoString = 25;
            $stmt = $this->conn->prepare("SELECT descripcionCargo FROM cargo WHERE idCargo = ?");
            $stmt->bind_param("i", intval($this->cargo));
            $stmt->execute();
            $stmt->bind_result($this->cargoString);
            $stmt->fetch();
            $stmt->close();
            // Configuración del servidor de correo saliente (SMTP)
            $mail->isSMTP();
            $mail->Host = 'smtp.office365.com'; // Ejemplo: smtp.gmail.com
            $mail->SMTPAuth = true;
            $mail->Username = 'svvantiago@outlook.com';
            $mail->Password = 'Wine1224';
            $mail->SMTPSecure = 'tls'; // Opcional, usa 'ssl' si es necesario
            $mail->Port = 587; // El puerto puede variar según tu proveedor de correo electrónico

            // Configuración del remitente y destinatario
            $mail->setFrom('svvantiago@outlook.com', 'CIT2021');
            $mail->addAddress($this->recipientMail, $this->recipientName);

            // Contenido del correo electrónico
            $mail->isHTML(true);
            $mail->Subject = 'Registro en CTI2021';
            $imageHead = file_get_contents('../vista/images/headCorreo1.png');
            $base64Image = base64_encode($imageHead);
            $imageSrc = 'data:image/png;base64,' . $base64Image;
            $imageFooter = file_get_contents('../vista/images/footerCorreo1.png');
            $base64Image = base64_encode($imageFooter);
            $imageSrc2 = 'data:image/png;base64,' . $base64Image;
            $mail->Body = ' <div style="text-align: center;">
                                <img src="' . $imageSrc . '" alt="Footer" style="width:100%;">
                            </div>
                            <br>
                            Nos satisface informarte que fuiste registrado con &eacute;xito en la plataforma <strong>CIT2021</strong>, en el cargo <strong>' . $this->cargoString . '</strong>. 
                            <br> 
                            <br>
                            Datos de ingreso:
                            <br> 
                            <strong>Correo: </strong> ' . $this->recipientMail . '
                            <br>
                            <strong>Clave: </strong> ' . $this->key . '
                            <br>
                            <br>
                            <div style="text-align: center;">
                              <img src="' . $imageSrc2 . '" alt="Footer" style="width:100%;">
                            </div>';
            $mail->AltBody = 'Contenido del correo electrónico en texto plano';

            // Adjuntar archivos (opcional)
            //$mail->addAttachment('ruta/al/archivo.pdf');

            // Enviar el correo electrónico
            $mail->send();
            echo 'El correo electrónico se ha enviado correctamente.';
        } catch (Exception $e) {
            echo 'Error al enviar el correo electrónico: ' . $mail->ErrorInfo;
        }
    }


    function correosRegistrados()
    {
        $this->correo = '';
        $sql = "SELECT * FROM usuario";
        $resultado = mysqli_query($this->conn, $sql);
        while ($fila = mysqli_fetch_assoc($resultado)) {
            $this->correo = $this->correo . $fila['correoUsuario'] . '|';
        }
        $this->correo = substr($this->correo, 0, -1);
        /*$this->correo = str_replace(".", "\.", $correo);*/
        return $this->correo;
    }
}

/* $objectoClassconfig= new Classconfig();
$conn = $objectoClassconfig->openServer();
$objectoRegistrados = new Correo($conn);
echo $objectoRegistrados->correosRegistrados();
*/
/*
$objectoClassconfig = new Classconfig();
$conn = $objectoClassconfig->openServer();
$objectoEnvio = new Correo($conn);
$objectoEnvio->envio('svvantiago@gmail.com', 'santiago', MD5('1234'), 1);
*/