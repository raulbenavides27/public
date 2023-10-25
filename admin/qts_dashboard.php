<?php require_once('../Connections/DKKadmin.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start($DKKadmin);
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "login.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
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

//Variables
$idAdmin = $_SESSION["MM_idAdmin"];
$ip = $_SERVER["REMOTE_ADDR"];
$fecha = date('Y-m-d H:i:s');
$fechaID = strtotime($fecha);
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

$varIDadmin_datosAdmin = "0";
if (isset($_SESSION["MM_idAdmin"])) {
  $varIDadmin_datosAdmin = $_SESSION["MM_idAdmin"];
}
$query_datosAdmin = sprintf("SELECT * FROM admin WHERE admin.id = %s AND admin.estado = '1'", GetSQLValueString($varIDadmin_datosAdmin, "int"));
$datosAdmin = mysqli_query($DKKadmin, $query_datosAdmin) or die(mysqli_error($DKKadmin));
$row_datosAdmin = mysqli_fetch_assoc($datosAdmin);
$totalRows_datosAdmin = mysqli_num_rows($datosAdmin);

$query_contactosPendientes = "SELECT * FROM contacto WHERE contacto.estado = '1' ORDER BY contacto.id DESC";
$contactosPendientes = mysqli_query($DKKadmin, $query_contactosPendientes) or die(mysqli_error($DKKadmin));
$row_contactosPendientes = mysqli_fetch_assoc($contactosPendientes);
$totalRows_contactosPendientes = mysqli_num_rows($contactosPendientes);

$query_cotizacionesIngresadasQTS = "SELECT * FROM qts_cotizaciones WHERE qts_cotizaciones.estado = '1' ORDER BY qts_cotizaciones.id DESC";
$cotizacionesIngresadasQTS = mysqli_query($DKKadmin, $query_cotizacionesIngresadasQTS);
$row_cotizacionesIngresadasQTS = mysqli_fetch_assoc($cotizacionesIngresadasQTS);
$totalRows_cotizacionesIngresadasQTS = mysqli_num_rows($cotizacionesIngresadasQTS);

$query_cotizacionesIngresadasQTSAgente = "SELECT * FROM qts_cotizaciones WHERE qts_cotizaciones.creadorID = '$idAdmin' AND qts_cotizaciones.estado = '1' ORDER BY qts_cotizaciones.id DESC";
$cotizacionesIngresadasQTSAgente = mysqli_query($DKKadmin, $query_cotizacionesIngresadasQTSAgente);
$row_cotizacionesIngresadasQTSAgente = mysqli_fetch_assoc($cotizacionesIngresadasQTSAgente);
$totalRows_cotizacionesIngresadasQTSAgente = mysqli_num_rows($cotizacionesIngresadasQTSAgente);

$query_ultimosClientesQTS = "SELECT * FROM qts_clientes WHERE NOT qts_clientes.estado = '0' ORDER BY qts_clientes.id DESC LIMIT 12";
$ultimosClientesQTS = mysqli_query($DKKadmin, $query_ultimosClientesQTS);
$row_ultimosClientesQTS = mysqli_fetch_assoc($ultimosClientesQTS);
$totalRows_ultimosClientesQTS = mysqli_num_rows($ultimosClientesQTS);

$query_ultimosClientesQTSAgente = "SELECT * FROM qts_clientes WHERE qts_clientes.creadorID = '$idAdmin' AND NOT qts_clientes.estado = '0' ORDER BY qts_clientes.id DESC LIMIT 12";
$ultimosClientesQTSAgente = mysqli_query($DKKadmin, $query_ultimosClientesQTSAgente);
$row_ultimosClientesQTSAgente = mysqli_fetch_assoc($ultimosClientesQTSAgente);
$totalRows_ultimosClientesQTSAgente = mysqli_num_rows($ultimosClientesQTSAgente);

$query_ultimasCotizacionesQTS = "SELECT * FROM qts_cotizaciones WHERE NOT qts_cotizaciones.estado = '0' ORDER BY qts_cotizaciones.id DESC LIMIT 12";
$ultimasCotizacionesQTS = mysqli_query($DKKadmin, $query_ultimasCotizacionesQTS);
$row_ultimasCotizacionesQTS = mysqli_fetch_assoc($ultimasCotizacionesQTS);
$totalRows_ultimasCotizacionesQTS = mysqli_num_rows($ultimasCotizacionesQTS);

$query_ultimasCotizacionesQTSAgente = "SELECT * FROM qts_cotizaciones WHERE qts_cotizaciones.creadorID = '$idAdmin' AND NOT qts_cotizaciones.estado = '0' ORDER BY qts_cotizaciones.id DESC LIMIT 12";
$ultimasCotizacionesQTSAgente = mysqli_query($DKKadmin, $query_ultimasCotizacionesQTSAgente);
$row_ultimasCotizacionesQTSAgente = mysqli_fetch_assoc($ultimasCotizacionesQTSAgente);
$totalRows_ultimasCotizacionesQTSAgente = mysqli_num_rows($ultimasCotizacionesQTSAgente);

$query_cotizacionesEnviadasQTS = "SELECT * FROM qts_cotizaciones WHERE qts_cotizaciones.estado = '2' ORDER BY qts_cotizaciones.id DESC";
$cotizacionesEnviadasQTS = mysqli_query($DKKadmin, $query_cotizacionesEnviadasQTS);
$row_cotizacionesEnviadasQTS = mysqli_fetch_assoc($cotizacionesEnviadasQTS);
$totalRows_cotizacionesEnviadasQTS = mysqli_num_rows($cotizacionesEnviadasQTS);

$query_cotizacionesEnviadasQTSAgente = "SELECT * FROM qts_cotizaciones WHERE qts_cotizaciones.creadorID = '$idAdmin' AND qts_cotizaciones.estado = '2' ORDER BY qts_cotizaciones.id DESC";
$cotizacionesEnviadasQTSAgente = mysqli_query($DKKadmin, $query_cotizacionesEnviadasQTSAgente);
$row_cotizacionesEnviadasQTSAgente = mysqli_fetch_assoc($cotizacionesEnviadasQTSAgente);
$totalRows_cotizacionesEnviadasQTSAgente = mysqli_num_rows($cotizacionesEnviadasQTSAgente);

$query_cotizacionesHoy = "SELECT * FROM qts_cotizaciones WHERE qts_cotizaciones.fechaID < '$fechaHoy' AND qts_cotizaciones.fechaID  > '$fechaAyer' AND NOT qts_cotizaciones.estado = '0' ORDER BY qts_cotizaciones.id DESC";
$cotizacionesHoy = mysqli_query($DKKadmin, $query_cotizacionesHoy);
$row_cotizacionesHoy = mysqli_fetch_assoc($cotizacionesHoy);
$totalRows_cotizacionesHoy = mysqli_num_rows($cotizacionesHoy);

$query_cotizacionesAyer = "SELECT * FROM qts_cotizaciones WHERE qts_cotizaciones.fechaID < '$fecha2dias' AND qts_cotizaciones.fechaID  > '$fechaAyer' AND NOT qts_cotizaciones.estado = '0' ORDER BY qts_cotizaciones.id DESC";
$cotizacionesAyer = mysqli_query($DKKadmin, $query_cotizacionesAyer);
$row_cotizacionesAyer = mysqli_fetch_assoc($cotizacionesAyer);
$totalRows_cotizacionesAyer = mysqli_num_rows($cotizacionesAyer);

$query_cotizaciones2dias = "SELECT * FROM qts_cotizaciones WHERE qts_cotizaciones.fechaID < '$fechaAyer' AND qts_cotizaciones.fechaID  > '$fecha2dias' AND NOT qts_cotizaciones.estado = '0' ORDER BY qts_cotizaciones.id DESC";
$cotizaciones2dias = mysqli_query($DKKadmin, $query_cotizaciones2dias);
$row_cotizaciones2dias = mysqli_fetch_assoc($cotizaciones2dias);
$totalRows_cotizaciones2dias = mysqli_num_rows($cotizaciones2dias);

$query_cotizaciones3dias = "SELECT * FROM qts_cotizaciones WHERE qts_cotizaciones.fechaID < '$fecha2dias' AND qts_cotizaciones.fechaID  > '$fecha3dias' AND NOT qts_cotizaciones.estado = '0' ORDER BY qts_cotizaciones.id DESC";
$cotizaciones3dias = mysqli_query($DKKadmin, $query_cotizaciones3dias);
$row_cotizaciones3dias = mysqli_fetch_assoc($cotizaciones3dias);
$totalRows_cotizaciones3dias = mysqli_num_rows($cotizaciones3dias);

$query_cotizaciones4dias = "SELECT * FROM qts_cotizaciones WHERE qts_cotizaciones.fechaID < '$fecha3dias' AND qts_cotizaciones.fechaID  > '$fecha4dias' AND NOT qts_cotizaciones.estado = '0' ORDER BY qts_cotizaciones.id DESC";
$cotizaciones4dias = mysqli_query($DKKadmin, $query_cotizaciones4dias);
$row_cotizaciones4dias = mysqli_fetch_assoc($cotizaciones4dias);
$totalRows_cotizaciones4dias = mysqli_num_rows($cotizaciones4dias);

$query_cotizaciones5dias = "SELECT * FROM qts_cotizaciones WHERE qts_cotizaciones.fechaID < '$fecha4dias' AND qts_cotizaciones.fechaID  > '$fecha5dias' AND NOT qts_cotizaciones.estado = '0' ORDER BY qts_cotizaciones.id DESC";
$cotizaciones5dias = mysqli_query($DKKadmin, $query_cotizaciones5dias);
$row_cotizaciones5dias = mysqli_fetch_assoc($cotizaciones5dias);
$totalRows_cotizaciones5dias = mysqli_num_rows($cotizaciones5dias);

$query_cotizaciones6dias = "SELECT * FROM qts_cotizaciones WHERE qts_cotizaciones.fechaID < '$fecha5dias' AND qts_cotizaciones.fechaID  > '$fecha6dias' AND NOT qts_cotizaciones.estado = '0' ORDER BY qts_cotizaciones.id DESC";
$cotizaciones6dias = mysqli_query($DKKadmin, $query_cotizaciones6dias);
$row_cotizaciones6dias = mysqli_fetch_assoc($cotizaciones6dias);
$totalRows_cotizaciones6dias = mysqli_num_rows($cotizaciones6dias);

$query_cotizaciones1semana = "SELECT * FROM qts_cotizaciones WHERE qts_cotizaciones.fechaID < '$fecha6dias' AND qts_cotizaciones.fechaID  > '$fecha1semana' AND NOT qts_cotizaciones.estado = '0' ORDER BY qts_cotizaciones.id DESC";
$cotizaciones1semana = mysqli_query($DKKadmin, $query_cotizaciones1semana);
$row_cotizaciones1semana = mysqli_fetch_assoc($cotizaciones1semana);
$totalRows_cotizaciones1semana = mysqli_num_rows($cotizaciones1semana);

$query_clientesHoy = "SELECT * FROM qts_clientes WHERE qts_clientes.fechaID < '$fechaHoy' AND qts_clientes.fechaID  > '$fechaAyer' AND NOT qts_clientes.estado = '0' ORDER BY qts_clientes.id DESC";
$clientesHoy = mysqli_query($DKKadmin, $query_clientesHoy);
$row_clientesHoy = mysqli_fetch_assoc($clientesHoy);
$totalRows_clientesHoy = mysqli_num_rows($clientesHoy);

$query_clientesAyer = "SELECT * FROM qts_clientes WHERE qts_clientes.fechaID < '$fecha2dias' AND qts_clientes.fechaID  > '$fechaAyer' AND NOT qts_clientes.estado = '0' ORDER BY qts_clientes.id DESC";
$clientesAyer = mysqli_query($DKKadmin, $query_clientesAyer);
$row_clientesAyer = mysqli_fetch_assoc($clientesAyer);
$totalRows_clientesAyer = mysqli_num_rows($clientesAyer);

$query_clientes2dias = "SELECT * FROM qts_clientes WHERE qts_clientes.fechaID < '$fechaAyer' AND qts_clientes.fechaID  > '$fecha2dias' AND NOT qts_clientes.estado = '0' ORDER BY qts_clientes.id DESC";
$clientes2dias = mysqli_query($DKKadmin, $query_clientes2dias);
$row_clientes2dias = mysqli_fetch_assoc($clientes2dias);
$totalRows_clientes2dias = mysqli_num_rows($clientes2dias);

$query_clientes3dias = "SELECT * FROM qts_clientes WHERE qts_clientes.fechaID < '$fecha2dias' AND qts_clientes.fechaID  > '$fecha3dias' AND NOT qts_clientes.estado = '0' ORDER BY qts_clientes.id DESC";
$clientes3dias = mysqli_query($DKKadmin, $query_clientes3dias);
$row_clientes3dias = mysqli_fetch_assoc($clientes3dias);
$totalRows_clientes3dias = mysqli_num_rows($clientes3dias);

$query_clientes4dias = "SELECT * FROM qts_clientes WHERE qts_clientes.fechaID < '$fecha3dias' AND qts_clientes.fechaID  > '$fecha4dias' AND NOT qts_clientes.estado = '0' ORDER BY qts_clientes.id DESC";
$clientes4dias = mysqli_query($DKKadmin, $query_clientes4dias);
$row_clientes4dias = mysqli_fetch_assoc($clientes4dias);
$totalRows_clientes4dias = mysqli_num_rows($clientes4dias);

$query_clientes5dias = "SELECT * FROM qts_clientes WHERE qts_clientes.fechaID < '$fecha4dias' AND qts_clientes.fechaID  > '$fecha5dias' AND NOT qts_clientes.estado = '0' ORDER BY qts_clientes.id DESC";
$clientes5dias = mysqli_query($DKKadmin, $query_clientes5dias);
$row_clientes5dias = mysqli_fetch_assoc($clientes5dias);
$totalRows_clientes5dias = mysqli_num_rows($clientes5dias);

$query_clientes6dias = "SELECT * FROM qts_clientes WHERE qts_clientes.fechaID < '$fecha5dias' AND qts_clientes.fechaID  > '$fecha6dias' AND NOT qts_clientes.estado = '0' ORDER BY qts_clientes.id DESC";
$clientes6dias = mysqli_query($DKKadmin, $query_clientes6dias);
$row_clientes6dias = mysqli_fetch_assoc($clientes6dias);
$totalRows_clientes6dias = mysqli_num_rows($clientes6dias);

$query_clientes1semana = "SELECT * FROM qts_clientes WHERE qts_clientes.fechaID < '$fecha6dias' AND qts_clientes.fechaID  > '$fecha1semana' AND NOT qts_clientes.estado = '0' ORDER BY qts_clientes.id DESC";
$clientes1semana = mysqli_query($DKKadmin, $query_clientes1semana);
$row_clientes1semana = mysqli_fetch_assoc($clientes1semana);
$totalRows_clientes1semana = mysqli_num_rows($clientes1semana);

//Agente

$query_cotizacionesHoyAgente = "SELECT * FROM qts_cotizaciones WHERE qts_cotizaciones.creadorID = '$idAdmin' AND qts_cotizaciones.fechaID < '$fechaHoy' AND qts_cotizaciones.fechaID  > '$fechaAyer' AND NOT qts_cotizaciones.estado = '0' ORDER BY qts_cotizaciones.id DESC";
$cotizacionesHoyAgente = mysqli_query($DKKadmin, $query_cotizacionesHoyAgente);
$row_cotizacionesHoyAgente = mysqli_fetch_assoc($cotizacionesHoyAgente);
$totalRows_cotizacionesHoyAgente = mysqli_num_rows($cotizacionesHoyAgente);

$query_cotizacionesAyerAgente = "SELECT * FROM qts_cotizaciones WHERE qts_cotizaciones.creadorID = '$idAdmin' AND qts_cotizaciones.fechaID < '$fecha2dias' AND qts_cotizaciones.fechaID  > '$fechaAyer' AND NOT qts_cotizaciones.estado = '0' ORDER BY qts_cotizaciones.id DESC";
$cotizacionesAyerAgente = mysqli_query($DKKadmin, $query_cotizacionesAyerAgente);
$row_cotizacionesAyerAgente = mysqli_fetch_assoc($cotizacionesAyerAgente);
$totalRows_cotizacionesAyerAgente = mysqli_num_rows($cotizacionesAyerAgente);

$query_cotizaciones2diasAgente = "SELECT * FROM qts_cotizaciones WHERE qts_cotizaciones.creadorID = '$idAdmin' AND qts_cotizaciones.fechaID < '$fechaAyer' AND qts_cotizaciones.fechaID  > '$fecha2dias' AND NOT qts_cotizaciones.estado = '0' ORDER BY qts_cotizaciones.id DESC";
$cotizaciones2diasAgente = mysqli_query($DKKadmin, $query_cotizaciones2diasAgente);
$row_cotizaciones2diasAgente = mysqli_fetch_assoc($cotizaciones2diasAgente);
$totalRows_cotizaciones2diasAgente = mysqli_num_rows($cotizaciones2diasAgente);

$query_cotizaciones3diasAgente = "SELECT * FROM qts_cotizaciones WHERE qts_cotizaciones.creadorID = '$idAdmin' AND qts_cotizaciones.fechaID < '$fecha2dias' AND qts_cotizaciones.fechaID  > '$fecha3dias' AND NOT qts_cotizaciones.estado = '0' ORDER BY qts_cotizaciones.id DESC";
$cotizaciones3diasAgente = mysqli_query($DKKadmin, $query_cotizaciones3diasAgente);
$row_cotizaciones3diasAgente = mysqli_fetch_assoc($cotizaciones3diasAgente);
$totalRows_cotizaciones3diasAgente = mysqli_num_rows($cotizaciones3diasAgente);

$query_cotizaciones4diasAgente = "SELECT * FROM qts_cotizaciones WHERE qts_cotizaciones.creadorID = '$idAdmin' AND qts_cotizaciones.fechaID < '$fecha3dias' AND qts_cotizaciones.fechaID  > '$fecha4dias' AND NOT qts_cotizaciones.estado = '0' ORDER BY qts_cotizaciones.id DESC";
$cotizaciones4diasAgente = mysqli_query($DKKadmin, $query_cotizaciones4diasAgente);
$row_cotizaciones4diasAgente = mysqli_fetch_assoc($cotizaciones4diasAgente);
$totalRows_cotizaciones4diasAgente = mysqli_num_rows($cotizaciones4diasAgente);

$query_cotizaciones5diasAgente = "SELECT * FROM qts_cotizaciones WHERE qts_cotizaciones.creadorID = '$idAdmin' AND qts_cotizaciones.fechaID < '$fecha4dias' AND qts_cotizaciones.fechaID  > '$fecha5dias' AND NOT qts_cotizaciones.estado = '0' ORDER BY qts_cotizaciones.id DESC";
$cotizaciones5diasAgente = mysqli_query($DKKadmin, $query_cotizaciones5diasAgente);
$row_cotizaciones5diasAgente = mysqli_fetch_assoc($cotizaciones5diasAgente);
$totalRows_cotizaciones5diasAgente = mysqli_num_rows($cotizaciones5diasAgente);

$query_cotizaciones6diasAgente = "SELECT * FROM qts_cotizaciones WHERE qts_cotizaciones.creadorID = '$idAdmin' AND qts_cotizaciones.fechaID < '$fecha5dias' AND qts_cotizaciones.fechaID  > '$fecha6dias' AND NOT qts_cotizaciones.estado = '0' ORDER BY qts_cotizaciones.id DESC";
$cotizaciones6diasAgente = mysqli_query($DKKadmin, $query_cotizaciones6diasAgente);
$row_cotizaciones6diasAgente = mysqli_fetch_assoc($cotizaciones6diasAgente);
$totalRows_cotizaciones6diasAgente = mysqli_num_rows($cotizaciones6diasAgente);

$query_cotizaciones1semanaAgente = "SELECT * FROM qts_cotizaciones WHERE qts_cotizaciones.creadorID = '$idAdmin' AND qts_cotizaciones.fechaID < '$fecha6dias' AND qts_cotizaciones.fechaID  > '$fecha1semana' AND NOT qts_cotizaciones.estado = '0' ORDER BY qts_cotizaciones.id DESC";
$cotizaciones1semanaAgente = mysqli_query($DKKadmin, $query_cotizaciones1semanaAgente);
$row_cotizaciones1semanaAgente = mysqli_fetch_assoc($cotizaciones1semanaAgente);
$totalRows_cotizaciones1semanaAgente = mysqli_num_rows($cotizaciones1semanaAgente);

$query_clientesHoyAgente = "SELECT * FROM qts_clientes WHERE qts_clientes.creadorID = '$idAdmin' AND qts_clientes.fechaID < '$fechaHoy' AND qts_clientes.fechaID  > '$fechaAyer' AND NOT qts_clientes.estado = '0' ORDER BY qts_clientes.id DESC";
$clientesHoyAgente = mysqli_query($DKKadmin, $query_clientesHoyAgente);
$row_clientesHoyAgente = mysqli_fetch_assoc($clientesHoyAgente);
$totalRows_clientesHoyAgente = mysqli_num_rows($clientesHoyAgente);

$query_clientesAyerAgente = "SELECT * FROM qts_clientes WHERE qts_clientes.creadorID = '$idAdmin' AND qts_clientes.fechaID < '$fecha2dias' AND qts_clientes.fechaID  > '$fechaAyer' AND NOT qts_clientes.estado = '0' ORDER BY qts_clientes.id DESC";
$clientesAyerAgente = mysqli_query($DKKadmin, $query_clientesAyerAgente);
$row_clientesAyerAgente = mysqli_fetch_assoc($clientesAyerAgente);
$totalRows_clientesAyerAgente = mysqli_num_rows($clientesAyerAgente);

$query_clientes2diasAgente = "SELECT * FROM qts_clientes WHERE qts_clientes.creadorID = '$idAdmin' AND qts_clientes.fechaID < '$fechaAyer' AND qts_clientes.fechaID  > '$fecha2dias' AND NOT qts_clientes.estado = '0' ORDER BY qts_clientes.id DESC";
$clientes2diasAgente = mysqli_query($DKKadmin, $query_clientes2diasAgente);
$row_clientes2diasAgente = mysqli_fetch_assoc($clientes2diasAgente);
$totalRows_clientes2diasAgente = mysqli_num_rows($clientes2diasAgente);

$query_clientes3diasAgente = "SELECT * FROM qts_clientes WHERE qts_clientes.creadorID = '$idAdmin' AND qts_clientes.fechaID < '$fecha2dias' AND qts_clientes.fechaID  > '$fecha3dias' AND NOT qts_clientes.estado = '0' ORDER BY qts_clientes.id DESC";
$clientes3diasAgente = mysqli_query($DKKadmin, $query_clientes3diasAgente);
$row_clientes3diasAgente = mysqli_fetch_assoc($clientes3diasAgente);
$totalRows_clientes3diasAgente = mysqli_num_rows($clientes3diasAgente);

$query_clientes4diasAgente = "SELECT * FROM qts_clientes WHERE qts_clientes.creadorID = '$idAdmin' AND qts_clientes.fechaID < '$fecha3dias' AND qts_clientes.fechaID  > '$fecha4dias' AND NOT qts_clientes.estado = '0' ORDER BY qts_clientes.id DESC";
$clientes4diasAgente = mysqli_query($DKKadmin, $query_clientes4diasAgente);
$row_clientes4diasAgente = mysqli_fetch_assoc($clientes4diasAgente);
$totalRows_clientes4diasAgente = mysqli_num_rows($clientes4diasAgente);

$query_clientes5diasAgente = "SELECT * FROM qts_clientes WHERE qts_clientes.creadorID = '$idAdmin' AND qts_clientes.fechaID < '$fecha4dias' AND qts_clientes.fechaID  > '$fecha5dias' AND NOT qts_clientes.estado = '0' ORDER BY qts_clientes.id DESC";
$clientes5diasAgente = mysqli_query($DKKadmin, $query_clientes5diasAgente);
$row_clientes5diasAgente = mysqli_fetch_assoc($clientes5diasAgente);
$totalRows_clientes5diasAgente = mysqli_num_rows($clientes5diasAgente);

$query_clientes6diasAgente = "SELECT * FROM qts_clientes WHERE qts_clientes.creadorID = '$idAdmin' AND qts_clientes.fechaID < '$fecha5dias' AND qts_clientes.fechaID  > '$fecha6dias' AND NOT qts_clientes.estado = '0' ORDER BY qts_clientes.id DESC";
$clientes6diasAgente = mysqli_query($DKKadmin, $query_clientes6diasAgente);
$row_clientes6diasAgente = mysqli_fetch_assoc($clientes6diasAgente);
$totalRows_clientes6diasAgente = mysqli_num_rows($clientes6diasAgente);

$query_clientes1semanaAgente = "SELECT * FROM qts_clientes WHERE qts_clientes.creadorID = '$idAdmin' AND qts_clientes.fechaID < '$fecha6dias' AND qts_clientes.fechaID  > '$fecha1semana' AND NOT qts_clientes.estado = '0' ORDER BY qts_clientes.id DESC";
$clientes1semanaAgente = mysqli_query($DKKadmin, $query_clientes1semanaAgente);
$row_clientes1semanaAgente = mysqli_fetch_assoc($clientes1semanaAgente);
$totalRows_clientes1semanaAgente = mysqli_num_rows($clientes1semanaAgente);

?>
<!DOCTYPE html>
<!--[if IE 9]>         <html class="ie9 no-focus"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-focus" lang="es"><!-- InstanceBegin template="/Templates/admin.dwt.php" codeOutsideHTMLIsLocked="false" --> <!--<![endif]-->
    <head>
        <meta charset="utf-8">

        <title>Origen | Panel de Administraci&oacute;n</title>

        <meta name="description" content="Plataforma de administración de contenido, productos, posicionamiento e información de tu sitio web realizado por DKK.CO">
        <meta name="author" content="DKK.CO">
        <meta name="robots" content="noindex, nofollow">
        <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0">

        <!-- favicons -->
        <link rel="shortcut icon" href="img/favicons/favicon.png">
        <link rel="icon" type="image/png" href="img/favicons/favicon-16x16.png" sizes="16x16">
        <link rel="icon" type="image/png" href="img/favicons/favicon-32x32.png" sizes="32x32">
        <link rel="icon" type="image/png" href="img/favicons/favicon-96x96.png" sizes="96x96">
        <link rel="icon" type="image/png" href="img/favicons/favicon-160x160.png" sizes="160x160">
        <link rel="icon" type="image/png" href="img/favicons/favicon-192x192.png" sizes="192x192">
        <link rel="apple-touch-icon" sizes="57x57" href="img/favicons/apple-touch-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="img/favicons/apple-touch-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="img/favicons/apple-touch-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="img/favicons/apple-touch-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="img/favicons/apple-touch-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="img/favicons/apple-touch-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="img/favicons/apple-touch-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="img/favicons/apple-touch-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="img/favicons/apple-touch-icon-180x180.png">
        <!-- END favicons -->

        <!-- estilos -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400italic,600,700%7COpen+Sans:300,400,400italic,600,700">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" id="css-main" href="css/oneui.css">
		<link rel="stylesheet" id="css-theme" href="css/themes/flat.min.css">
        <!-- InstanceBeginEditable name="head" -->
        <!-- InstanceEndEditable -->
    <!-- END estilos -->
    </head>
    <body>
        <!-- contenido -->
        <div id="page-container" class="sidebar-l sidebar-o side-scroll header-navbar-fixed">

            <!-- nav -->
            <nav id="sidebar">
                <div id="sidebar-scroll">
                    <div class="sidebar-content">
                        <!-- nav header -->
                        <div class="side-header side-content bg-white-op">
                            <button class="btn btn-link text-gray pull-right hidden-md hidden-lg" type="button" data-toggle="layout" data-action="sidebar_close">
                                <i class="fa fa-times"></i>
                            </button>
                            <a class="h5 text-white" href="../admin">
                                <i class="fa fa-circle-o-notch text-primary"></i> <span class="h4 font-w600 sidebar-mini-hide">rigen</span>
                            </a>
                        </div>
                        <!-- END nav header -->

                        <!-- menu -->
                        <div class="side-content side-content-full">
                            <ul class="nav-main">
                                <li>
                                    <a href="../admin"><i class="si si-speedometer"></i><span class="sidebar-mini-hide">Dashboard</span></a>
                                </li>
                                <li>
                                    <a href="contactos.php"><i class="si si-envelope-open"></i><span class="sidebar-mini-hide">Mailbox</span></a>
                                </li>
                                <li>
                                    <a href="cotizaciones.php"><i class="si si-briefcase"></i><span class="sidebar-mini-hide">Cotizaciones</span></a>
                                </li>

                                <li class="nav-main-heading"><span class="sidebar-mini-hide">Cotizaciones</span></li>
                                
                                <li>
                                    <a href="qts_dashboard.php"><i class="si si-graph"></i><span class="sidebar-mini-hide">Dashboard</span></a>
                                </li>
                                <li>
                                    <a href="qts_cotizaciones.php"><i class="si si-briefcase"></i><span class="sidebar-mini-hide">Cotizaciones</span></a>
                                </li>
                                <li>
                                    <a class="nav-submenu" data-toggle="nav-submenu" href="#"><i class="si si-users"></i><span class="sidebar-mini-hide">Clientes</span></a>
                                    <ul>
                                        <li>
                                            <a href="clientes.php">Todos</a>
                                        </li>
                                        <li>
                                        	<a href="clientes-add.php">Nuevo</a>
                                        </li>
                                    </ul>
                                </li>
                                
                                <li class="nav-main-heading"><span class="sidebar-mini-hide">Cat&aacute;logo de Productos</span></li>
                                
                                <li>
                                    <a class="nav-submenu" data-toggle="nav-submenu" href="#"><i class="si si-list"></i><span class="sidebar-mini-hide">Categor&iacute;as</span></a>
                                    <ul>
                                        <li>
                                            <a href="categorias.php">Categor&iacute;as</a>
                                        </li>
                                        <li>
                                            <a href="subcategorias.php">SubCategor&iacute;as</a>
                                        </li>
                                        <li>
                                            <a href="familias.php">Familias</a>
                                        </li>
                                    </ul>
                                </li>

                                <li>
                                    <a class="nav-submenu" data-toggle="nav-submenu" href="#"><i class="si si-briefcase"></i><span class="sidebar-mini-hide">Productos</span></a>
                                    <ul>
                                        <li>
                                            <a href="productos.php">Todos los Productos</a>
                                        </li>
                                        <li>
                                            <a href="productos_add.php">Nuevo Productos</a>
                                        </li>
                                    </ul>
                                </li>

                                <li class="nav-main-heading"><span class="sidebar-mini-hide">Sitio Web</span></li>

                                <li>
                                    <a class="nav-submenu" data-toggle="nav-submenu" href="#"><i class="si si-home"></i><span class="sidebar-mini-hide">Home</span></a>
                                    <ul>
                                        <li>
                                            <a href="home_slider.php">Slider</a>
                                        </li>
                                        <li>
                                            <a href="home_categorias.php">Categor&iacute;as</a>
                                        </li>
                                        <li>
                                            <a href="home_banner.php">Banner</a>
                                        </li>
                                    </ul>
                                </li>

                                <li>
                                    <a class="nav-submenu" data-toggle="nav-submenu" href="#"><i class="si si-heart"></i><span class="sidebar-mini-hide">Nosotros</span></a>
                                    <ul>
                                        <li>
                                            <a href="nosotros.php">Historia</a>
                                        </li>
                                        <li>
                                            <a href="mision.php">Misi&oacute;n</a>
                                        </li>
                                        <li>
                                          <a href="postventa.php">Post-Venta</a>
                                        </li>
                                        <li>
                                            <a href="representantes.php">Representantes</a>
                                        </li>
                                    </ul>
                                </li>

                                <li>
                                    <a class="nav-submenu" data-toggle="nav-submenu" href="#"><i class="si si-book-open"></i><span class="sidebar-mini-hide">Blog</span></a>
                                    <ul>
                                        <li>
                                            <a href="blog.php">Todos los Posts</a>
                                        </li>
                                        <li>
                                            <a href="blog_add.php">Nuevo Post</a>
                                        </li>
                                    </ul>
                                </li>

                                <li class="nav-main-heading"><span class="sidebar-mini-hide">Apps</span></li>
                                
                                <li>
                                    <a href="https://clientes.diegokingkong.com" target="_blank"><i class="si si-moustache"></i><span class="sidebar-mini-hide">DKK.CO</span></a>
                                </li>
                                <li>
                                  <a href="../chat/php/app.php?login" target="_blank"><i class="si si-bubble"></i><span class="sidebar-mini-hide">Chat</span></a>
                                </li>

                          </ul>
                        </div>
                        <!-- END menu -->
                    </div>
                </div>
            </nav>
            <!-- END nav -->

            <!-- header -->
            <header id="header-navbar" class="content-mini content-mini-full">
                <ul class="nav-header pull-right">
                    <li>
                        <div class="btn-group">
                            <button class="btn btn-default btn-image dropdown-toggle" data-toggle="dropdown" type="button">
                                <img src="img/avatars/<?php echo $row_datosAdmin["avatar"]; ?>" alt="<?php echo $row_datosAdmin["nombre"]." ".$row_datosAdmin["apellido"]; ?>">
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li class="dropdown-header">Perfil</li>
                                <li>
                                    <a tabindex="-1" href="mailbox.php">
                                        <i class="si si-envelope-open pull-right"></i>
                                        <span class="badge badge-primary pull-right"><?php echo $totalRows_mailBox; ?></span>Mailbox
                                  </a>
                                </li>
                                <li>
                                    <a tabindex="-1" href="miperfil.php">
                                        <i class="si si-user pull-right"></i>Mi Perfil
                                  </a>
                                </li>
                                <li>
                                    <a tabindex="-1" href="ajustes.php">
                                        <i class="si si-settings pull-right"></i>Ajustes
                                  </a>
                                </li>
                                <li class="divider"></li>
                                <li class="dropdown-header">Acciones</li>
                                <li>
                                    <a tabindex="-1" href="lock.php">
                                        <i class="si si-lock pull-right"></i>Bloquear
                                  </a>
                                </li>
                                <li>
                                    <a tabindex="-1" href="logout.php">
                                        <i class="si si-logout pull-right"></i>Salir
                                  </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>

                <ul class="nav-header pull-left">
                    <li class="hidden-md hidden-lg">
                        <button class="btn btn-default" data-toggle="layout" data-action="sidebar_toggle" type="button">
                            <i class="fa fa-navicon"></i>
                        </button>
                    </li>
                    <li class="hidden-xs hidden-sm">
                        <button class="btn btn-default" data-toggle="layout" data-action="sidebar_mini_toggle" type="button">
                            <i class="fa fa-ellipsis-v"></i>
                        </button>
                    </li>
                    <li>
                        <button class="btn btn-default pull-right" data-toggle="modal" data-target="#apps-modal" type="button">
                            <i class="si si-grid"></i>
                        </button>
                    </li>
                </ul>
            </header>
            <!-- END header -->

            <!-- main -->
            <main id="main-container">
                <!-- contenido -->
                <!-- InstanceBeginEditable name="contenido" -->
                <?php if ($row_datosAdmin["nivel"] == '1') { ?>
                <!-- contenido -->
                <div class="content content-boxed">
                    <!-- header -->
                    <div class="row">
                        <div class="col-sm-6 col-md-3">
                            <a class="block block-link-hover3 text-center" href="qts_cotizaciones.php">
                                <div class="block-content block-content-full">
                                    <div class="h1 font-w700 text-primary" data-toggle="countTo" data-to="<?php echo $totalRows_cotizacionesIngresadasQTS; ?>"></div>
                                </div>
                                <div class="block-content block-content-full block-content-mini bg-gray-lighter text-muted font-w600">Cotizaciones Ingresadas</div>
                            </a>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <a class="block block-link-hover3 text-center" href="qts_cotizaciones.php">
                                <div class="block-content block-content-full">
                                    <div class="h1 font-w700 text-success" data-toggle="countTo" data-to="<?php echo $row_cotizacionesEnviadasQTS; ?>"></div>
                                </div>
                                <div class="block-content block-content-full block-content-mini bg-gray-lighter text-muted font-w600">Cotizaciones Enviadas</div>
                            </a>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <a class="block block-link-hover3 text-center" href="qts_cotizaciones.php">
                                <div class="block-content block-content-full">
                                    <div class="h1 font-w700" data-toggle="countTo" data-to="<?php echo $totalRows_cotizacionesHoy; ?>"></div>
                                </div>
                                <div class="block-content block-content-full block-content-mini bg-gray-lighter text-muted font-w600">Cotizaciones Hoy</div>
                            </a>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <a class="block block-link-hover3 text-center" href="clientes-add.php">
                                <div class="block-content block-content-full">
                                    <div class="h1 font-w700 text-success"><i class="fa fa-plus"></i></div>
                                </div>
                                <div class="block-content block-content-full block-content-mini bg-gray-lighter text-success font-w600">Nuevo Cliente</div>
                            </a>

                        </div>
                    </div>
                    <!-- END header -->

                    <!-- grafico -->
                    <div class="block block-opt-refresh-icon4">
                        <div class="block-header bg-gray-lighter">
                            <h3 class="block-title">Resumen</h3>
                        </div>
                        <div class="block-content block-content-full">
                            <div style="height: 400px;"><canvas class="js-chartjs-overview"></canvas></div>
                        </div>
                    </div>
                    <!-- END grafico -->

                    <!-- Últimos Clientes y Últimas Cotizaciones -->
                    <div class="row">
                        <div class="col-lg-6">
                            <!-- Últimos Clientes -->
                            <div class="block block-opt-refresh-icon4">
                                <div class="block-header bg-gray-lighter">
                                    <h3 class="block-title">Últimos Clientes</h3>
                                </div>
                                <div class="block-content">
                                    <table class="table table-borderless table-striped table-vcenter">
                                        <tbody>
                                            
                                            <?php do { ?>
                                            <tr>
                                                <td class="text-center" style="width: 100px;"><a href="clientes_view.php?id=<?php echo $row_ultimosClientesQTS["id"]; ?>"><strong>CID.<?php if ($row_ultimosClientesQTS["id"] < 10) {echo "0000";} if ($row_ultimosClientesQTS["id"] < 100 && $row_ultimosClientesQTS["id"] > 10) {echo "000";} if ($row_ultimosClientesQTS["id"] < 1000 && $row_ultimosClientesQTS["id"] > 100) {echo "00";} if ($row_ultimosClientesQTS["id"] < 10000 && $row_ultimosClientesQTS["id"] > 1000) {echo "0";} if ($row_ultimosClientesQTS["id"] < 100000 && $row_ultimosClientesQTS["id"] > 10000) {echo "";} echo $row_ultimosClientesQTS["id"]; ?></strong></a></td>
                                                <td><a href="clientes_view.php?id=<?php echo $row_ultimosClientesQTS["id"]; ?>"><?php if (isset($row_ultimosClientesQTS["razonSocial"])) echo $row_ultimosClientesQTS["razonSocial"]; else echo $row_ultimosClientesQTS["nombre"]." ".$row_ultimosClientesQTS["apellido"]; ?></a></td>
                                                <td class="hidden-xs text-center"><?php echo $time = date("d/m/y h:i",$row_ultimosClientesQTS["fechaID"]); ?></td>
                                                <td class="hidden-xs text-center"><?php 
													$idAgenteResponsable = $row_ultimosClientesQTS["creadorID"];
													$agenteResponsable = mysqli_query($DKKadmin,"SELECT * FROM admin WHERE admin.id = '$idAgenteResponsable'"); 
													while($ar = mysqli_fetch_array($agenteResponsable)){ 
													$nombreAgenteResponsable = $ar['nombre']." ".$ar['apellido'];
												?>
                                            	<?php echo $nombreAgenteResponsable; ?>
                                            	<?php } ?></td>
                                            </tr>
                                            <?php } while ($row_ultimosClientesQTS = mysqli_fetch_assoc($ultimosClientesQTS)); ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- END Últimos Clientes -->
                        </div>
                        <div class="col-lg-6">
                            <!-- Últimas Cotizaciones -->
                            <div class="block block-opt-refresh-icon4">
                                <div class="block-header bg-gray-lighter">
                                    <h3 class="block-title">Últimas Cotizaciones</h3>
                                </div>
                                <div class="block-content">
                                    <table class="table table-borderless table-striped table-vcenter">
                                        <tbody>
                                            <?php do { ?>
                                            <tr>
                                                <td class="text-center" style="width: 100px;"><a href="qts_view.php?id=<?php echo $row_ultimasCotizacionesQTS["id"]; ?>"><strong>QTE.<?php if ($row_ultimasCotizacionesQTS["id"] < 10) {echo "0000";} if ($row_ultimasCotizacionesQTS["id"] < 100 && $row_ultimasCotizacionesQTS["id"] > 10) {echo "000";} if ($row_ultimasCotizacionesQTS["id"] < 1000 && $row_ultimasCotizacionesQTS["id"] > 100) {echo "00";} if ($row_ultimasCotizacionesQTS["id"] < 10000 && $row_ultimasCotizacionesQTS["id"] > 1000) {echo "0";} if ($row_ultimasCotizacionesQTS["id"] < 100000 && $row_ultimasCotizacionesQTS["id"] > 10000) {echo "";} echo $row_ultimasCotizacionesQTS["id"]; ?></strong></a></td>
                                                <td class="hidden-xs"><a href="clientes_view.php?id=<?php echo $row_ultimasCotizacionesQTS["clienteID"]; ?>">
												<?php 
													$idCliente = $row_ultimasCotizacionesQTS["clienteID"];
													$datosCliente = mysqli_query($DKKadmin,"SELECT * FROM qts_clientes WHERE qts_clientes.id = '$idCliente'"); 
													while($dc = mysqli_fetch_array($datosCliente)){ 
													if (isset($dc['razonSocial'])) {
													$nombreCliente = $dc['razonSocial']; 
													}
													else {
													$nombreCliente = $dc['nombre']." ".$dc['apellido']; 
													}
												?>
                                            	<?php echo $nombreCliente; ?>
                                            	<?php } ?></a></td>
                                                <td><span class="label label-<?php if ($row_ultimasCotizacionesQTS["estado"] == '1') { echo "warning"; } if ($row_ultimasCotizacionesQTS["estado"] == '2') { echo "primary"; } if ($row_ultimasCotizacionesQTS["estado"] == '3') { echo "success"; } if ($row_ultimasCotizacionesQTS["estado"] == '4') { echo "danger";} if ($row_ultimasCotizacionesQTS["estado"] == '5') { echo "default";} if ($row_ultimasCotizacionesQTS["estado"] == '6') { echo "danger";} if ($row_ultimasCotizacionesQTS["estado"] == '0') { echo "danger";} ?>"><?php if ($row_ultimasCotizacionesQTS["estado"] == '1') { echo "INGRESADA"; } if ($row_ultimasCotizacionesQTS["estado"] == '2') { echo "ENVIADA"; } if ($row_ultimasCotizacionesQTS["estado"] == '3') { echo "APROBADA"; } if ($row_ultimasCotizacionesQTS["estado"] == '4') { echo "RECHAZADA";} if ($row_ultimasCotizacionesQTS["estado"] == '5') { echo "CERRADA";} if ($row_ultimasCotizacionesQTS["estado"] == '6') { echo "ELIMINADA";} if ($row_ultimasCotizacionesQTS["estado"] == '0') { echo "REMOVIDA";} ?></span></td>
                                                <td class="hidden-xs"><a href="">
												<?php 
													$idAgenteQTE = $row_ultimasCotizacionesQTS["creadorID"];
													$datosAgenteQTE = mysqli_query($DKKadmin,"SELECT * FROM admin WHERE admin.id = '$idAgenteQTE'"); 
													while($daq = mysqli_fetch_array($datosAgenteQTE)){ 
													$nombreAgenteQTE = $daq['nombre']." ".$daq['apellido']; 
												?>
                                            	<?php echo $nombreCliente; ?>
                                            	<?php } ?></a></td>
                                                <td class="text-right"><?php echo $timeQTS = date("d/m/y h:i",$row_ultimasCotizacionesQTS["fechaID"]); ?></td>
                                            </tr>
											<?php } while ($row_ultimasCotizacionesQTS = mysqli_fetch_assoc($ultimasCotizacionesQTS)); ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- END Últimas Cotizaciones -->
                        </div>
                    </div>
                    <!-- END Últimos Clientes y Últimas Cotizaciones -->
                </div>
                <!-- END contenido -->
                <?php } // si es ADMIN ?>
                <?php if ($row_datosAdmin["nivel"] == '2') { ?>
                <!-- contenido -->
                <div class="content content-boxed">
                    <!-- header -->
                    <div class="row">
                        <div class="col-sm-6 col-md-3">
                            <a class="block block-link-hover3 text-center" href="qts_cotizaciones.php">
                                <div class="block-content block-content-full">
                                    <div class="h1 font-w700 text-primary" data-toggle="countTo" data-to="<?php echo $totalRows_cotizacionesIngresadasQTSAgente; ?>"></div>
                                </div>
                                <div class="block-content block-content-full block-content-mini bg-gray-lighter text-muted font-w600">Cotizaciones Ingresadas</div>
                            </a>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <a class="block block-link-hover3 text-center" href="qts_cotizaciones.php">
                                <div class="block-content block-content-full">
                                    <div class="h1 font-w700 text-success" data-toggle="countTo" data-to="<?php echo $row_cotizacionesEnviadasQTSAgente; ?>"></div>
                                </div>
                                <div class="block-content block-content-full block-content-mini bg-gray-lighter text-muted font-w600">Cotizaciones Enviadas</div>
                            </a>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <a class="block block-link-hover3 text-center" href="qts_cotizaciones.php">
                                <div class="block-content block-content-full">
                                    <div class="h1 font-w700" data-toggle="countTo" data-to="<?php echo $totalRows_cotizacionesHoyAgente; ?>"></div>
                                </div>
                                <div class="block-content block-content-full block-content-mini bg-gray-lighter text-muted font-w600">Cotizaciones Hoy</div>
                            </a>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <a class="block block-link-hover3 text-center" href="clientes-add.php">
                                <div class="block-content block-content-full">
                                    <div class="h1 font-w700 text-success"><i class="fa fa-plus"></i></div>
                                </div>
                                <div class="block-content block-content-full block-content-mini bg-gray-lighter text-success font-w600">Nuevo Cliente</div>
                            </a>

                        </div>
                    </div>
                    <!-- END header -->

                    <!-- grafico -->
                    <div class="block block-opt-refresh-icon4">
                        <div class="block-header bg-gray-lighter">
                            <h3 class="block-title">Resumen</h3>
                        </div>
                        <div class="block-content block-content-full">
                            <div style="height: 400px;"><canvas class="js-chartjs-overview"></canvas></div>
                        </div>
                    </div>
                    <!-- END grafico -->

                    <!-- Últimos Clientes y Últimas Cotizaciones -->
                    <div class="row">
                        <div class="col-lg-6">
                            <!-- Últimos Clientes -->
                            <div class="block block-opt-refresh-icon4">
                                <div class="block-header bg-gray-lighter">
                                    <h3 class="block-title">Últimos Clientes</h3>
                                </div>
                                <div class="block-content">
                                    <table class="table table-borderless table-striped table-vcenter">
                                        <tbody>
                                            
                                            <?php do { ?>
                                            <tr>
                                                <td class="text-center" style="width: 100px;"><a href="clientes_view.php?id=<?php echo $row_ultimosClientesQTSAgente["id"]; ?>"><strong>CID.<?php if ($row_ultimosClientesQTSAgente["id"] < 10) {echo "0000";} if ($row_ultimosClientesQTSAgente["id"] < 100 && $row_ultimosClientesQTSAgente["id"] > 10) {echo "000";} if ($row_ultimosClientesQTSAgente["id"] < 1000 && $row_ultimosClientesQTSAgente["id"] > 100) {echo "00";} if ($row_ultimosClientesQTSAgente["id"] < 10000 && $row_ultimosClientesQTSAgente["id"] > 1000) {echo "0";} if ($row_ultimosClientesQTSAgente["id"] < 100000 && $row_ultimosClientesQTSAgente["id"] > 10000) {echo "";} echo $row_ultimosClientesQTSAgente["id"]; ?></strong></a></td>
                                                <td><a href="clientes_view.php?id=<?php echo $row_ultimosClientesQTSAgente["id"]; ?>"><?php if (isset($row_ultimosClientesQTSAgente["razonSocial"])) echo $row_ultimosClientesQTSAgente["razonSocial"]; else echo $row_ultimosClientesQTSAgente["nombre"]." ".$row_ultimosClientesQTSAgente["apellido"]; ?></a></td>
                                                <td class="hidden-xs text-center"><?php echo $time = date("d/m/y h:i",$row_ultimosClientesQTSAgente["fechaID"]); ?></td>
                                            </tr>
                                            <?php } while ($row_ultimosClientesQTSAgente = mysqli_fetch_assoc($ultimosClientesQTSAgente)); ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- END Últimos Clientes -->
                        </div>
                        <div class="col-lg-6">
                            <!-- Últimas Cotizaciones -->
                            <div class="block block-opt-refresh-icon4">
                                <div class="block-header bg-gray-lighter">
                                    <h3 class="block-title">Últimas Cotizaciones</h3>
                                </div>
                                <div class="block-content">
                                    <table class="table table-borderless table-striped table-vcenter">
                                        <tbody>
                                            <?php do { ?>
                                            <tr>
                                                <td class="text-center" style="width: 100px;"><a href="qts_view.php?id=<?php echo $row_ultimasCotizacionesQTSAgente["id"]; ?>"><strong>ORD.<?php if ($row_ultimasCotizacionesQTSAgente["id"] < 10) {echo "0000";} if ($row_ultimasCotizacionesQTSAgente["id"] < 100 && $row_ultimasCotizacionesQTSAgente["id"] > 10) {echo "000";} if ($row_ultimasCotizacionesQTSAgente["id"] < 1000 && $row_ultimasCotizacionesQTSAgente["id"] > 100) {echo "00";} if ($row_ultimasCotizacionesQTSAgente["id"] < 10000 && $row_ultimasCotizacionesQTSAgente["id"] > 1000) {echo "0";} if ($row_ultimasCotizacionesQTSAgente["id"] < 100000 && $row_ultimasCotizacionesQTSAgente["id"] > 10000) {echo "";} echo $row_ultimasCotizacionesQTSAgente["id"]; ?></strong></a></td>
                                                <td class="hidden-xs"><a href="clientes_view.php?id=<?php echo $row_ultimasCotizacionesQTSAgente["clienteID"]; ?>">
												<?php 
													$idCliente = $row_ultimasCotizacionesQTSAgente["clienteID"];
													$datosCliente = mysqli_query("SELECT * FROM qts_clientes WHERE qts_clientes.id = '$idCliente'"); 
													while($dc = mysqli_fetch_array($datosCliente)){ 
													if (isset($dc['razonSocial'])) {
													$nombreCliente = $dc['razonSocial']; 
													}
													else {
													$nombreCliente = $dc['nombre']." ".$dc['apellido']; 
													}
												?>
                                            	<?php echo $nombreCliente; ?>
                                            	<?php } ?></a></td>
                                                <td><span class="label label-<?php if ($row_ultimasCotizacionesQTSAgente["estado"] == '1') { echo "warning"; } if ($row_ultimasCotizacionesQTSAgente["estado"] == '2') { echo "primary"; } if ($row_ultimasCotizacionesQTSAgente["estado"] == '3') { echo "success"; } if ($row_ultimasCotizacionesQTSAgente["estado"] == '4') { echo "danger";} if ($row_ultimasCotizacionesQTSAgente["estado"] == '5') { echo "default";} if ($row_ultimasCotizacionesQTSAgente["estado"] == '6') { echo "danger";} if ($row_ultimasCotizacionesQTSAgente["estado"] == '0') { echo "danger";} ?>"><?php if ($row_ultimasCotizacionesQTSAgente["estado"] == '1') { echo "INGRESADA"; } if ($row_ultimasCotizacionesQTSAgente["estado"] == '2') { echo "ENVIADA"; } if ($row_ultimasCotizacionesQTSAgente["estado"] == '3') { echo "APROBADA"; } if ($row_ultimasCotizacionesQTSAgente["estado"] == '4') { echo "RECHAZADA";} if ($row_ultimasCotizacionesQTSAgente["estado"] == '5') { echo "CERRADA";} if ($row_ultimasCotizacionesQTSAgente["estado"] == '6') { echo "ELIMINADA";} if ($row_ultimasCotizacionesQTSAgente["estado"] == '0') { echo "REMOVIDA";} ?></span></td>
                                                <td class="text-right"><?php echo $timeQTSAgente = date("d/m/y h:i",$row_ultimasCotizacionesQTSAgente["fechaID"]); ?></td>
                                            </tr>
											<?php } while ($row_ultimasCotizacionesQTSAgente = mysqli_fetch_assoc($ultimasCotizacionesQTSAgente)); ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- END Últimas Cotizaciones -->
                        </div>
                    </div>
                    <!-- END Últimos Clientes y Últimas Cotizaciones -->
                </div>
                <!-- END contenido -->
                <?php } // si es AGENTE ?>
              	<!-- InstanceEndEditable -->
                <!-- END contenido -->
            </main>
            <!-- END main -->

            <!-- footer -->
            <footer id="page-footer" class="content-mini content-mini-full font-s12 bg-gray-lighter clearfix">
                <div class="pull-right">
                    Hecho con el <i class="fa fa-heart text-city"></i> por <a class="font-w600" href="https://diegokingkong.com/home" target="_blank">DKK.CO</a>
                </div>
                <div class="pull-left">
                    <a class="font-w600" href="https://diegokingkong.com/home" target="_blank">Origen 3.5</a> &copy; <span><?php echo date("Y"); ?></span>
                </div>
            </footer>
            <!-- END footer -->
        </div>
        <!-- END contenido -->

        <!-- apps -->
        <div class="modal fade" id="apps-modal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-sm modal-dialog modal-dialog-top">
                <div class="modal-content">
                    <div class="block block-themed block-transparent">
                        <div class="block-header bg-primary-dark">
                            <ul class="block-options">
                                <li>
                                    <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
                                </li>
                            </ul>
                            <h3 class="block-title">Apps</h3>
                        </div>
                        <div class="block-content">
                            <div class="row text-center">
                                <div class="col-xs-6">
                                  <a class="block block-rounded" href="https://clientes.diegokingkong.com" target="_blank">
                                        <div class="block-content text-white bg-default">
                                            <i class="si si-speedometer fa-2x"></i>
                                            <div class="font-w600 push-15-t push-15">DKK.CO</div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-xs-6">
                                  <a class="block block-rounded" href="../" target="_blank">
                                        <div class="block-content text-white bg-modern bg-smooth-dark">
                                            <i class="si si-rocket fa-2x"></i>
                                            <div class="font-w600 push-15-t push-15">Front</div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END apps -->

    <script src="js/core/jquery.min.js"></script>
        <script src="js/core/bootstrap.min.js"></script>
        <script src="js/core/jquery.slimscroll.min.js"></script>
        <script src="js/core/jquery.scrollLock.min.js"></script>
        <script src="js/core/jquery.appear.min.js"></script>
        <script src="js/core/jquery.countTo.min.js"></script>
        <script src="js/core/jquery.placeholder.min.js"></script>
        <script src="js/core/js.cookie.min.js"></script>
        <script src="js/app.js"></script>
        <!-- InstanceBeginEditable name="js" -->
        <!-- Page JS Plugins -->
        <script src="js/plugins/chartjs/Chart.min.js"></script>
        <?php if ($row_datosAdmin["nivel"] == '1') { ?>
		<script>
		var BasePagesEcomDashboard = function() {
			var initOverviewChart = function(){
				var $chartOverviewCon = jQuery('.js-chartjs-overview')[0].getContext('2d');
				var $chartOverviewOptions = {
					scaleFontFamily: "'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif",
					scaleFontColor: '#999',
					scaleFontStyle: '600',
					tooltipTitleFontFamily: "'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif",
					tooltipCornerRadius: 3,
					maintainAspectRatio: false,
					responsive: true
				};
				var $chartOverviewData = {
					labels: ['1 SEMANA', '6 DIAS', '5 DIAS', '4 DIAS', '3 DÍAS', '2 DIAS', 'AYER', 'HOY'],
					datasets: [
						{
							label: 'Cotizaciones',
							fillColor: 'rgba(220,220,220,.3)',
							strokeColor: 'rgba(220,220,220,1)',
							pointColor: 'rgba(220,220,220,1)',
							pointStrokeColor: '#fff',
							pointHighlightFill: '#fff',
							pointHighlightStroke: 'rgba(220,220,220,1)',
							data: [<?php echo $totalRows_cotizaciones1semana; ?>, <?php echo $totalRows_cotizaciones6dias; ?>, <?php echo $totalRows_cotizaciones5dias; ?>, <?php echo $totalRows_cotizaciones4dias; ?>, <?php echo $totalRows_cotizaciones3dias; ?>, <?php echo $totalRows_cotizaciones2dias; ?>, <?php echo $totalRows_cotizacionesAyer; ?>, <?php echo $totalRows_cotizacionesHoy; ?>]
						},
						{
							label: 'Clientes',
							fillColor: 'rgba(171, 227, 125, .3)',
							strokeColor: 'rgba(171, 227, 125, 1)',
							pointColor: 'rgba(171, 227, 125, 1)',
							pointStrokeColor: '#fff',
							pointHighlightFill: '#fff',
							pointHighlightStroke: 'rgba(171, 227, 125, 1)',
							data: [<?php echo $totalRows_clientes1semana; ?>, <?php echo $totalRows_clientes6dias; ?>, <?php echo $totalRows_clientes5dias; ?>, <?php echo $totalRows_clientes4dias; ?>, <?php echo $totalRows_clientes3dias; ?>, <?php echo $totalRows_clientes2dias; ?>, <?php echo $totalRows_clientesAyer; ?>, <?php echo $totalRows_clientesHoy; ?>]
						}
					]
				};
				var $chartOverview = new Chart($chartOverviewCon).Line($chartOverviewData, $chartOverviewOptions);
			};
			return {
				init: function () {
					initOverviewChart();
				}
			};
		}();
		jQuery(function(){ BasePagesEcomDashboard.init(); });
        </script>
		<?php } // solo ADMIN ?>
        <?php if ($row_datosAdmin["nivel"] == '2') { ?>
		<script>
		var BasePagesEcomDashboard = function() {
			var initOverviewChart = function(){
				var $chartOverviewCon = jQuery('.js-chartjs-overview')[0].getContext('2d');
				var $chartOverviewOptions = {
					scaleFontFamily: "'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif",
					scaleFontColor: '#999',
					scaleFontStyle: '600',
					tooltipTitleFontFamily: "'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif",
					tooltipCornerRadius: 3,
					maintainAspectRatio: false,
					responsive: true
				};
				var $chartOverviewData = {
					labels: ['1 SEMANA', '6 DIAS', '5 DIAS', '4 DIAS', '3 DÍAS', '2 DIAS', 'AYER', 'HOY'],
					datasets: [
						{
							label: 'Cotizaciones',
							fillColor: 'rgba(220,220,220,.3)',
							strokeColor: 'rgba(220,220,220,1)',
							pointColor: 'rgba(220,220,220,1)',
							pointStrokeColor: '#fff',
							pointHighlightFill: '#fff',
							pointHighlightStroke: 'rgba(220,220,220,1)',
							data: [<?php echo $totalRows_cotizaciones1semanaAgente; ?>, <?php echo $totalRows_cotizaciones6diasAgente; ?>, <?php echo $totalRows_cotizaciones5diasAgente; ?>, <?php echo $totalRows_cotizaciones4diasAgente; ?>, <?php echo $totalRows_cotizaciones3diasAgente; ?>, <?php echo $totalRows_cotizaciones2diasAgente; ?>, <?php echo $totalRows_cotizacionesAyerAgente; ?>, <?php echo $totalRows_cotizacionesHoyAgente; ?>]
						},
						{
							label: 'Clientes',
							fillColor: 'rgba(171, 227, 125, .3)',
							strokeColor: 'rgba(171, 227, 125, 1)',
							pointColor: 'rgba(171, 227, 125, 1)',
							pointStrokeColor: '#fff',
							pointHighlightFill: '#fff',
							pointHighlightStroke: 'rgba(171, 227, 125, 1)',
							data: [<?php echo $totalRows_clientes1semanaAgente; ?>, <?php echo $totalRows_clientes6diasAgente; ?>, <?php echo $totalRows_clientes5diasAgente; ?>, <?php echo $totalRows_clientes4diasAgente; ?>, <?php echo $totalRows_clientes3diasAgente; ?>, <?php echo $totalRows_clientes2diasAgente; ?>, <?php echo $totalRows_clientesAyerAgente; ?>, <?php echo $totalRows_clientesHoyAgente; ?>]
						}
					]
				};
				var $chartOverview = new Chart($chartOverviewCon).Line($chartOverviewData, $chartOverviewOptions);
			};
			return {
				init: function () {
					initOverviewChart();
				}
			};
		}();
		jQuery(function(){ BasePagesEcomDashboard.init(); });
        </script>
		<?php } // solo AGENTE ?>
        <script>
            jQuery(function () {
                App.initHelpers(['appear', 'appear-countTo']);
            });
        </script>
        <!-- InstanceEndEditable -->
</body>
<!-- InstanceEnd --></html>
<?php
mysqli_free_result($datosAdmin);

mysqli_free_result($contactosPendientes);

mysqli_free_result($cotizacionesIngresadasQTS);

mysqli_free_result($cotizacionesIngresadasQTSAgente);

mysqli_free_result($ultimosClientesQTS);

mysqli_free_result($ultimosClientesQTSAgente);

mysqli_free_result($ultimasCotizacionesQTS);

mysqli_free_result($ultimasCotizacionesQTSAgente);

mysqli_free_result($cotizacionesEnviadasQTS);

mysqli_free_result($cotizacionesEnviadasQTSAgente);

mysqli_free_result($cotizacionesHoy);

mysqli_free_result($cotizacionesAyer);

mysqli_free_result($cotizaciones2dias);

mysqli_free_result($cotizaciones3dias);

mysqli_free_result($cotizaciones4dias);

mysqli_free_result($cotizaciones5dias);

mysqli_free_result($cotizaciones6dias);

mysqli_free_result($cotizaciones1semana);

mysqli_free_result($clientesHoy);

mysqli_free_result($clientesAyer);

mysqli_free_result($clientes2dias);

mysqli_free_result($clientes3dias);

mysqli_free_result($clientes4dias);

mysqli_free_result($clientes5dias);

mysqli_free_result($clientes6dias);

mysqli_free_result($clientes1semana);

mysqli_free_result($cotizacionesHoyAgente);

mysqli_free_result($cotizacionesAyerAgente);

mysqli_free_result($cotizaciones2diasAgente);

mysqli_free_result($cotizaciones3diasAgente);

mysqli_free_result($cotizaciones4diasAgente);

mysqli_free_result($cotizaciones5diasAgente);

mysqli_free_result($cotizaciones6diasAgente);

mysqli_free_result($cotizaciones1semanaAgente);

mysqli_free_result($clientesHoyAgente);

mysqli_free_result($clientesAyerAgente);

mysqli_free_result($clientes2diasAgente);

mysqli_free_result($clientes3diasAgente);

mysqli_free_result($clientes4diasAgente);

mysqli_free_result($clientes5diasAgente);

mysqli_free_result($clientes6diasAgente);

mysqli_free_result($clientes1semanaAgente);

?>
