<?php require_once('../Connections/DKKfront.php'); ?>
<?php
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

$whatsapp = str_replace('+','',str_replace(' ','',$row_metaDatos['whatsapp']));

$query_cotizacion = "SELECT * FROM cotizaciones ORDER BY cotizaciones.id DESC LIMIT 1";
$cotizacion = mysqli_query($DKKfront, $query_cotizacion) or die(mysqli_error($DKKfront));
$row_cotizacion = mysqli_fetch_assoc($cotizacion);
$totalRows_cotizacion = mysqli_num_rows($cotizacion);

$seoProducto = $row_cotizacion["productoSEO"];

if (isset($row_cotizacion["mensaje"])) {
	$mensaje = "<b>Notas:</b> ".$row_cotizacion["mensaje"];
}

if (isset($row_cotizacion["modelo"])) {
	$modelo = "<b>Modelo:</b> ".$row_cotizacion["modelo"];
}

$query_productoID = "SELECT * FROM productos WHERE productos.nombreSEO = '$seoProducto'";
$productoID = mysqli_query($DKKfront, $query_productoID) or die(mysqli_error($DKKfront));
$row_productoID = mysqli_fetch_assoc($productoID);
$totalRows_productoID = mysqli_num_rows($productoID);
?>
<?
$destinatario = "{$row_cotizacion['correo']}";
$asunto = "Prodalum | Hola {$row_cotizacion['nombre']}, hemos recibido con exito tu solicitud de cotizacion";
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
            <div class='logo' style='margin-left:auto;margin-right:auto;text-align:center;'><a href='http://www.prodalum.cl'><img src='http://www.prodalum.cl/images/logo.png' alt='Prodalum | Expertos en Escalas, Ventanas, Espejos y Shower Doors' height='auto' width='130' /></a></div>
        	<!--//logo -->
            
            <!-- contenido -->
            <div class='mensaje'>
            	<h3>Hola  <b>{$row_cotizacion['nombre']}</b></h3>
                <p>Hemos recibido con &eacute;xito tu solicitud de cotizaci&oacute;n. Aprovechamos de adjuntarte los datos de lo cotizado:</p>
                <div style='width:100%;float:left;'>
                    <div style='width:50%;float:left;'>
                        <img src='http://www.prodalum.cl/images/productos/{$row_productoID['imagen1']}' width='80%' height='auto' >
                    </div>
                    <div style='width:50%;float:right;'>
                        <p><b>Nombre:</b> {$row_cotizacion['nombre']}<br />
                        <b>Correo:</b> {$row_cotizacion['correo']}<br />
                        <b>Tel&eacute;fono:</b> {$row_cotizacion['telefono']}<br />
                        <b>Producto:</b> {$row_productoID['nombre']}<br />
                        {$modelo}<br />
                        {$mensaje}</p>
                    </div>
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
$headers .= "From: Prodalum <prodalum@prodalum.cl>\r\n";

//dirección de respuesta, si queremos que sea distinta que la del remitente
$headers .= "Reply-To: prodalum@prodalum.cl\r\n";

//direcciones que recibián copia
$headers .= "Cc: \r\n";

//direcciones que recibirán copia oculta
$headers .= "Bcc: prodalum@prodalum.cl\r\n";

mail($destinatario,$asunto,$cuerpo,$headers)
?>
<meta http-equiv="refresh" content="0; url=../<?php echo "productos/".$row_productoID["nombreSEO"]; ?>" />