<?php require_once('../Connections/DKKadmin.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  global $DKKadmin;
$theValue = function_exists("mysqli_real_escape_string") ? mysqli_real_escape_string($DKKadmin, $theValue) : mysqli_escape_string($DKKadmin,$theValue);

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

$idAdmin = $_SESSION["MM_idAdmin"];

$idAdmin = $_SESSION["MM_idAdmin"];
$ip = $_SERVER["REMOTE_ADDR"];
$fecha = date('Y-m-d H:i:s');
$fechaHoy = strtotime($fecha);
$fechaAyer = strtotime( '-1 day' ,strtotime($fecha));
$fecha2dias = strtotime( '-2 day' ,strtotime($fecha));
$fecha3dias = strtotime( '-3 day' ,strtotime($fecha));
$fecha4dias = strtotime( '-4 day' ,strtotime($fecha));
$fecha5dias = strtotime( '-5 day' ,strtotime($fecha));
$fecha6dias = strtotime( '-6 day' ,strtotime($fecha));
$fecha1semana = strtotime( '-1 week' ,strtotime($fecha));
$fecha10dias = strtotime( '-10 day' ,strtotime($fecha));
$fecha15dias = strtotime( '-15 day' ,strtotime($fecha));
$fecha1mes = strtotime( '-1 month' ,strtotime($fecha));
$fecha2meses = strtotime( '-2 month' ,strtotime($fecha));
$fecha3meses = strtotime( '-3 month' ,strtotime($fecha));
$fecha6meses = strtotime( '-6 month' ,strtotime($fecha));
$fechayear = strtotime( '-1 year' ,strtotime($fecha));

;
$query_datosAdmin = "SELECT * FROM admin WHERE admin.id = '$idAdmin'";
$datosAdmin = mysqli_query($DKKadmin, $query_datosAdmin) or die(mysqli_error($DKKadmin));
$row_datosAdmin = mysqli_fetch_assoc($datosAdmin);
$totalRows_datosAdmin = mysqli_num_rows($datosAdmin);

;
$query_mensajeReply = "SELECT * FROM contacto WHERE contacto.estado = '2' ORDER BY contacto.id DESC";
$mensajeReply = mysqli_query($DKKadmin, $query_mensajeReply) or die(mysqli_error($DKKadmin));
$row_mensajeReply = mysqli_fetch_assoc($mensajeReply);
$totalRows_mensajeReply = mysqli_num_rows($mensajeReply);
?>
<?
$destinatario = "{$row_mensajeReply['correo']}";
$asunto = "Hola {$row_mensajeReply['nombre']}, te estamos respondido desde prodalum.cl.";
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
            <div class='logo' style='margin-left:auto;margin-right:auto;text-align:center;'><a href='https://www.prodalum.cl'><img src='http://www.prodalum.cl/images/logo.png' alt='Prodalum | Expertos en Escalas, Ventanas, Espejos y Shower Doors' height='auto' width='130' /></a></div>
        	<!--//logo -->
            
            <!-- contenido -->
            <div class='mensaje'>
            	<h3>Hola  <b>{$row_mensajeReply['nombre']}</b></h3>
                <p>Te estamos respondiendo desde prodalum.cl:</p>
                <p>
                <blockquote>{$row_mensajeReply['mensaje']}</blockquote><br />
              </p>
                <p>Recuerda agregarnos a tu lista de contacto para evitar caer en SPAM.</p>
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
$headers .= "From: Prodalum <prodalum@prodalum.cl>\r\n";

//dirección de respuesta, si queremos que sea distinta que la del remitente
$headers .= "Reply-To: {$row_mensajeReply['correo']}\r\n";

//direcciones que recibián copia
$headers .= "Cc: \r\n";

//direcciones que recibirán copia oculta
$headers .= "Bcc: prodalum@prodalum.cl, diego.quiroga.contreras@gmail.com\r\n";

mail($destinatario,$asunto,$cuerpo,$headers)
?>
<META HTTP-EQUIV='Refresh' CONTENT='0; URL=contactos_respondidos.php'>
<?php
mysqli_free_result($datosAdmin);

mysqli_free_result($mensajeReply);
?>
