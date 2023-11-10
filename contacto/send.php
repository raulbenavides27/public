<?php require_once('../Connections/DKKfront.php');
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  global $DKKfront;
$theValue = function_exists("mysqli_real_escape_string") ? mysqli_real_escape_string($DKKfront, $theValue) : mysqli_escape_string($DKKfront,$theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

//Variables
$ip = $_SERVER["REMOTE_ADDR"];
$fecha = date('Y-m-d H:i:s');
$fechaID = strtotime($fecha);

$query_metaDatos = "SELECT * FROM metaDatos ORDER BY metaDatos.id DESC";
$metaDatos = mysqli_query($DKKfront, $query_metaDatos) or die(mysqli_error($DKKfront));
$row_metaDatos = mysqli_fetch_assoc($metaDatos);
$totalRows_metaDatos = mysqli_num_rows($metaDatos);

//$whatsapp = str_replace('+','',str_replace(' ','',$row_metaDatos['whatsapp']));

$query_ultimoContacto = "SELECT * FROM contacto ORDER BY contacto.id DESC LIMIT 1";
$ultimoContacto = mysqli_query($DKKfront, $query_ultimoContacto) or die(mysqli_error($DKKfront));
$row_ultimoContacto = mysqli_fetch_assoc($ultimoContacto);
$totalRows_ultimoContacto = mysqli_num_rows($ultimoContacto);
?>
<?
$destinatario = "{$row_ultimoContacto['correo']}";
$asunto = "Prodalum | Hola {$row_ultimoContacto['nombre']}, hemos recibido con exito tu contacto";
$cuerpo = "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//ES' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml' lang='es'>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
<title>Prodalum | Expertos en Escalas, Ventanas, Espejos y Shower Doors</title>
<link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'>
<style>
body {
	background-color: #EAEAEA;
	font-family: 'Roboto', sans-serif;
}
.wrapper {
	width:100%;
	height:auto;
	float:left;
}
.cuerpo {
	background-color: #FFF;
	margin-top:20px;
	margin-bottom:20px;
	margin-left:auto;
	margin-right:auto;
	max-width:620px;
	height:auto;
}
.contenido {
	width:90%;
	height:auto;
	margin:auto;
}
.logo {
	width:100%;
	margin-top:20px;
	margin-bottom:20px;
}
.mensaje {
	width:100%;
	margin-top:20px;
	margin-bottom:20px;
}
.text-center {
	text-align:center;
}
.margin-top {
	margin-top:20px;
}
.boton {
	background: #fff;
	display: inline-block;
	font-size: 12px;
	letter-spacing: 0.5px;
	line-height: normal;
	padding: 10px 16px;
	text-transform: uppercase;
	font-weight: 600;
	background-color: #ff9b00;
	color: #fff;
	border: 1px #ff9b00 solid;
}
.footer {
	font-size:10px;
	text-align:center;
	}
</style>
</head>

<body>

<div class='wrapper'>
    <div class='cuerpo'>
        <div class='contenido'>
        
        	<!-- logo -->
            <div class='logo' style='margin-left:auto;margin-right:auto;text-align:center;'><a href='http://www.prodalum.cl'><img src='http://www.prodalum.cl/images/logo.png' alt='Prodalum | Expertos en Escalas, Ventanas, Espejos y Shower Doors ' height='auto' width='130' /></a></div>
        	<!--//logo -->
            
            <!-- contenido -->
            <div class='mensaje'>
            	<h3>Hola  <b>{$row_ultimoContacto['nombre']} {$row_ultimoContacto['apellido']}</b></h3>
                <p>Hemos recibido con &eacute;xito tu contacto, te responderemos a la brevedad.</p>
                <p>Aprovechamos de adjuntarte la copia de lo que nos escribiste:</p>
                <div style='width:100%;float:left;'>
                    <p>
					<b>Nombre:</b> {$row_ultimoContacto['nombre']} {$row_ultimoContacto['apellido']}<br />
                    <b>Correo:</b> {$row_ultimoContacto['correo']}<br />
                    <b>Tel&eacute;fono:</b> {$row_ultimoContacto['telefono']}<br />
                    <b>Mensaje:</b> {$row_ultimoContacto['mensaje']}<br />
                    </p>
                </div>
              </p>
                <p>Recuerda agregarnos a tu lista de contactos para evitar caer en SPAM.</p>
            </div>
            <!--//contenido -->
            
            <!-- footer -->
            <div class='footer'>
                <p>Prodalum | Todos los derechos reservados.</p>
            </div>
            <!--//footer -->
            
        </div>
    </div>
</div>

</body>
</html>";

//para el envío en formato HTML
$headers  = "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";

//dirección del remitente
$headers .= "From: Prodalum <raulbenavides.v@gmail.com>\r\n";

//dirección de respuesta, si queremos que sea distinta que la del remitente
$headers .= "Reply-To: raulbenavides.v@gmail.com\r\n";

//direcciones que recibián copia
$headers .= "Cc: \r\n";

//direcciones que recibirán copia oculta
$headers .= "Bcc: raulbenavides.v@gmail.com\r\n";

mail($destinatario,$asunto,$cuerpo,$headers)
?>
 <meta http-equiv="refresh" content="0; url=../contacto" />