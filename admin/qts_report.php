<?php require_once('../Connections/DKKadmin.php');

if (!isset($_SESSION)) {
  session_start($DKKadmin);
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  $isValid = False; 

  if (!empty($UserName)) { 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
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

//variables
$idAdmin = $_SESSION["MM_idAdmin"];
$fecha = date('Y-m-d H:i:s');
$fechaID = strtotime($fecha);
$fechaHoy = date('Y-m-d');
$hoy = strtotime($fechaHoy);
$ayer = strtotime('-1 day',$hoy);
$dia1 = strtotime(date('Y-m-'.'1'));
$dia2 = strtotime(date('Y-m-'.'2'));
$dia3 = strtotime(date('Y-m-'.'3'));
$dia4 = strtotime(date('Y-m-'.'4'));
$dia5 = strtotime(date('Y-m-'.'5'));
$dia6 = strtotime(date('Y-m-'.'6'));
$dia7 = strtotime(date('Y-m-'.'7'));
$dia8 = strtotime(date('Y-m-'.'8'));
$dia9 = strtotime(date('Y-m-'.'9'));
$dia10 = strtotime(date('Y-m-'.'10'));
$dia11 = strtotime(date('Y-m-'.'11'));
$dia12 = strtotime(date('Y-m-'.'12'));
$dia13 = strtotime(date('Y-m-'.'13'));
$dia14 = strtotime(date('Y-m-'.'14'));
$dia15 = strtotime(date('Y-m-'.'15'));
$dia16 = strtotime(date('Y-m-'.'16'));
$dia17 = strtotime(date('Y-m-'.'17'));
$dia18 = strtotime(date('Y-m-'.'18'));
$dia19 = strtotime(date('Y-m-'.'19'));
$dia20 = strtotime(date('Y-m-'.'20'));
$dia21 = strtotime(date('Y-m-'.'21'));
$dia22 = strtotime(date('Y-m-'.'22'));
$dia23 = strtotime(date('Y-m-'.'23'));
$dia24 = strtotime(date('Y-m-'.'24'));
$dia25 = strtotime(date('Y-m-'.'25'));
$dia26 = strtotime(date('Y-m-'.'26'));
$dia27 = strtotime(date('Y-m-'.'27'));
$dia28 = strtotime(date('Y-m-'.'28'));
$dia29 = strtotime(date('Y-m-'.'29'));
$dia30 = strtotime(date('Y-m-'.'30'));
$dia31 = strtotime(date('Y-m-'.'31'));
$nextMonth = strtotime('+1 month' ,(date('Y-m-'.'1')));
$mes = strtotime(date('Y-m-'.'1'));
$mesPasado = strtotime('-1 month' ,(date('Y-m-'.'1')));
$enero = strtotime(date('Y'.'-1-1'));
$febrero = strtotime(date('Y'.'-2-1'));
$marzo = strtotime(date('Y'.'-3-1'));
$abril = strtotime(date('Y'.'-4-1'));
$mayo = strtotime(date('Y'.'-5-1'));
$junio = strtotime(date('Y'.'-6-1'));
$julio = strtotime(date('Y'.'-7-1'));
$agosto = strtotime(date('Y'.'-8-1'));
$septiembre = strtotime(date('Y'.'-9-1'));
$octubre = strtotime(date('Y'.'-10-1'));
$noviembre = strtotime(date('Y'.'-11-1'));
$diciembre = strtotime(date('Y'.'-12-1'));
$nextYear = strtotime('+1 year' ,(date('Y'.'-1-1')));
$ip = $_SERVER["REMOTE_ADDR"];
$estado = $_GET["estado"];

if ((date('n')) == '1') {
	$mesActual = 'Enero';
}
if ((date('n')) == '2') {
	$mesActual = 'Febrero';
}
if ((date('n')) == '3') {
	$mesActual = 'Marzo';
}
if ((date('n')) == '4') {
	$mesActual = 'Abril';
}
if ((date('n')) == '5') {
	$mesActual = 'Mayo';
}
if ((date('n')) == '6') {
	$mesActual = 'Junio';
}
if ((date('n')) == '7') {
	$mesActual = 'Julio';
}
if ((date('n')) == '8') {
	$mesActual = 'Agosto';
}
if ((date('n')) == '9') {
	$mesActual = 'Septiembre';
}
if ((date('n')) == '10') {
	$mesActual = 'Octubre';
}
if ((date('n')) == '11') {
	$mesActual = 'Noviembre';
}
if ((date('n')) == '12') {
	$mesActual = 'Diciembre';
}

$query_datosAdmin = sprintf("SELECT * FROM admin WHERE admin.id = '$idAdmin' AND admin.estado = '1'");
$datosAdmin = mysqli_query($DKKadmin, $query_datosAdmin) or die(mysqli_error($DKKadmin));
$row_datosAdmin = mysqli_fetch_assoc($datosAdmin);
$totalRows_datosAdmin = mysqli_num_rows($datosAdmin);

$query_contactosPendientes = "SELECT * FROM contacto WHERE contacto.estado = '1' ORDER BY contacto.id DESC";
$contactosPendientes = mysqli_query($DKKadmin, $query_contactosPendientes) or die(mysqli_error($DKKadmin));
$row_contactosPendientes = mysqli_fetch_assoc($contactosPendientes);
$totalRows_contactosPendientes = mysqli_num_rows($contactosPendientes);

$query_cotizacionesIngresadasEnero = "SELECT * FROM cotizaciones WHERE cotizaciones.fechaID >= '$enero' AND cotizaciones.fechaID <= '$febrero' ORDER BY cotizaciones.id DESC";
$cotizacionesIngresadasEnero = mysqli_query($DKKadmin, $query_cotizacionesIngresadasEnero) or die(mysqli_error($DKKadmin));
$row_cotizacionesIngresadasEnero = mysqli_fetch_assoc($cotizacionesIngresadasEnero);
$totalRows_cotizacionesIngresadasEnero = mysqli_num_rows($cotizacionesIngresadasEnero);

$query_cotizacionesIngresadasFebrero = "SELECT * FROM cotizaciones WHERE cotizaciones.fechaID >= '$febrero' AND cotizaciones.fechaID <= '$marzo' ORDER BY cotizaciones.id DESC";
$cotizacionesIngresadasFebrero = mysqli_query($DKKadmin, $query_cotizacionesIngresadasFebrero) or die(mysqli_error($DKKadmin));
$row_cotizacionesIngresadasFebrero = mysqli_fetch_assoc($cotizacionesIngresadasFebrero);
$totalRows_cotizacionesIngresadasFebrero = mysqli_num_rows($cotizacionesIngresadasFebrero);

$query_cotizacionesIngresadasMarzo = "SELECT * FROM cotizaciones WHERE cotizaciones.fechaID >= '$marzo' AND cotizaciones.fechaID <= '$abril' ORDER BY cotizaciones.id DESC";
$cotizacionesIngresadasMarzo = mysqli_query($DKKadmin, $query_cotizacionesIngresadasMarzo) or die(mysqli_error($DKKadmin));
$row_cotizacionesIngresadasMarzo = mysqli_fetch_assoc($cotizacionesIngresadasMarzo);
$totalRows_cotizacionesIngresadasMarzo = mysqli_num_rows($cotizacionesIngresadasMarzo);

$query_cotizacionesIngresadasAbril = "SELECT * FROM cotizaciones WHERE cotizaciones.fechaID >= '$abril' AND cotizaciones.fechaID <= '$mayo' ORDER BY cotizaciones.id DESC";
$cotizacionesIngresadasAbril = mysqli_query($DKKadmin, $query_cotizacionesIngresadasAbril) or die(mysqli_error($DKKadmin));
$row_cotizacionesIngresadasAbril = mysqli_fetch_assoc($cotizacionesIngresadasAbril);
$totalRows_cotizacionesIngresadasAbril = mysqli_num_rows($cotizacionesIngresadasAbril);

$query_cotizacionesIngresadasMayo = "SELECT * FROM cotizaciones WHERE cotizaciones.fechaID >= '$mayo' AND cotizaciones.fechaID <= '$junio' ORDER BY cotizaciones.id DESC";
$cotizacionesIngresadasMayo = mysqli_query($DKKadmin, $query_cotizacionesIngresadasMayo) or die(mysqli_error($DKKadmin));
$row_cotizacionesIngresadasMayo = mysqli_fetch_assoc($cotizacionesIngresadasMayo);
$totalRows_cotizacionesIngresadasMayo = mysqli_num_rows($cotizacionesIngresadasMayo);

$query_cotizacionesIngresadasJunio = "SELECT * FROM cotizaciones WHERE cotizaciones.fechaID >= '$junio' AND cotizaciones.fechaID <= '$julio' ORDER BY cotizaciones.id DESC";
$cotizacionesIngresadasJunio = mysqli_query($DKKadmin, $query_cotizacionesIngresadasJunio) or die(mysqli_error($DKKadmin));
$row_cotizacionesIngresadasJunio = mysqli_fetch_assoc($cotizacionesIngresadasJunio);
$totalRows_cotizacionesIngresadasJunio = mysqli_num_rows($cotizacionesIngresadasJunio);

$query_cotizacionesIngresadasJulio = "SELECT * FROM cotizaciones WHERE cotizaciones.fechaID >= '$julio' AND cotizaciones.fechaID <= '$agosto' ORDER BY cotizaciones.id DESC";
$cotizacionesIngresadasJulio = mysqli_query($DKKadmin, $query_cotizacionesIngresadasJulio) or die(mysqli_error($DKKadmin));
$row_cotizacionesIngresadasJulio = mysqli_fetch_assoc($cotizacionesIngresadasJulio);
$totalRows_cotizacionesIngresadasJulio = mysqli_num_rows($cotizacionesIngresadasJulio);

$query_cotizacionesIngresadasAgosto = "SELECT * FROM cotizaciones WHERE cotizaciones.fechaID >= '$agosto' AND cotizaciones.fechaID <= '$septiembre' ORDER BY cotizaciones.id DESC";
$cotizacionesIngresadasAgosto = mysqli_query($DKKadmin, $query_cotizacionesIngresadasAgosto) or die(mysqli_error($DKKadmin));
$row_cotizacionesIngresadasAgosto = mysqli_fetch_assoc($cotizacionesIngresadasAgosto);
$totalRows_cotizacionesIngresadasAgosto = mysqli_num_rows($cotizacionesIngresadasAgosto);

$query_cotizacionesIngresadasSeptiembre = "SELECT * FROM cotizaciones WHERE cotizaciones.fechaID >= '$septiembre' AND cotizaciones.fechaID <= '$octubre' ORDER BY cotizaciones.id DESC";
$cotizacionesIngresadasSeptiembre = mysqli_query($DKKadmin, $query_cotizacionesIngresadasSeptiembre) or die(mysqli_error($DKKadmin));
$row_cotizacionesIngresadasSeptiembre = mysqli_fetch_assoc($cotizacionesIngresadasSeptiembre);
$totalRows_cotizacionesIngresadasSeptiembre = mysqli_num_rows($cotizacionesIngresadasSeptiembre);

$query_cotizacionesIngresadasOctubre = "SELECT * FROM cotizaciones WHERE cotizaciones.fechaID >= '$octubre' AND cotizaciones.fechaID <= '$noviembre' ORDER BY cotizaciones.id DESC";
$cotizacionesIngresadasOctubre = mysqli_query($DKKadmin, $query_cotizacionesIngresadasOctubre) or die(mysqli_error($DKKadmin));
$row_cotizacionesIngresadasOctubre = mysqli_fetch_assoc($cotizacionesIngresadasOctubre);
$totalRows_cotizacionesIngresadasOctubre = mysqli_num_rows($cotizacionesIngresadasOctubre);

$query_cotizacionesIngresadasNoviembre = "SELECT * FROM cotizaciones WHERE cotizaciones.fechaID >= '$noviembre' AND cotizaciones.fechaID <= '$diciembre' ORDER BY cotizaciones.id DESC";
$cotizacionesIngresadasNoviembre = mysqli_query($DKKadmin, $query_cotizacionesIngresadasNoviembre) or die(mysqli_error($DKKadmin));
$row_cotizacionesIngresadasNoviembre = mysqli_fetch_assoc($cotizacionesIngresadasNoviembre);
$totalRows_cotizacionesIngresadasNoviembre = mysqli_num_rows($cotizacionesIngresadasNoviembre);

$query_cotizacionesIngresadasDiciembre = "SELECT * FROM cotizaciones WHERE cotizaciones.fechaID >= '$diciembre' AND cotizaciones.fechaID <= '$nextYear' ORDER BY cotizaciones.id DESC";
$cotizacionesIngresadasDiciembre = mysqli_query($DKKadmin, $query_cotizacionesIngresadasDiciembre) or die(mysqli_error($DKKadmin));
$row_cotizacionesIngresadasDiciembre = mysqli_fetch_assoc($cotizacionesIngresadasDiciembre);
$totalRows_cotizacionesIngresadasDiciembre = mysqli_num_rows($cotizacionesIngresadasDiciembre);

$query_cotizacionesIngresadasMes = "SELECT * FROM cotizaciones WHERE cotizaciones.fechaID >= '$mes' ORDER BY cotizaciones.id DESC";
$cotizacionesIngresadasMes = mysqli_query($DKKadmin, $query_cotizacionesIngresadasMes) or die(mysqli_error($DKKadmin));
$row_cotizacionesIngresadasMes = mysqli_fetch_assoc($cotizacionesIngresadasMes);
$totalRows_cotizacionesIngresadasMes = mysqli_num_rows($cotizacionesIngresadasMes);

$query_cotizacionesIngresadasHoy = "SELECT * FROM cotizaciones WHERE cotizaciones.fechaID >= '$hoy' ORDER BY cotizaciones.id DESC";
$cotizacionesIngresadasHoy = mysqli_query($DKKadmin, $query_cotizacionesIngresadasHoy) or die(mysqli_error($DKKadmin));
$row_cotizacionesIngresadasHoy = mysqli_fetch_assoc($cotizacionesIngresadasHoy);
$totalRows_cotizacionesIngresadasHoy = mysqli_num_rows($cotizacionesIngresadasHoy);

$query_cotizacionesIngresadasAyer = "SELECT * FROM cotizaciones WHERE cotizaciones.fechaID <= '$ayer' AND cotizaciones.fechaID >= '$fecha2dias' ORDER BY cotizaciones.id DESC";
$cotizacionesIngresadasAyer = mysqli_query($DKKadmin, $query_cotizacionesIngresadasAyer) or die(mysqli_error($DKKadmin));
$row_cotizacionesIngresadasAyer = mysqli_fetch_assoc($cotizacionesIngresadasAyer);
$totalRows_cotizacionesIngresadasAyer = mysqli_num_rows($cotizacionesIngresadasAyer);

$query_cotizacionesIngresadas2dias = "SELECT * FROM cotizaciones WHERE cotizaciones.fechaID >= '$fecha3dias' AND cotizaciones.fechaID <= '$fecha2dias' ORDER BY cotizaciones.id DESC";
$cotizacionesIngresadas2dias = mysqli_query($DKKadmin, $query_cotizacionesIngresadas2dias) or die(mysqli_error($DKKadmin));
$row_cotizacionesIngresadas2dias = mysqli_fetch_assoc($cotizacionesIngresadas2dias);
$totalRows_cotizacionesIngresadas2dias = mysqli_num_rows($cotizacionesIngresadas2dias);

$query_cotizacionesIngresadas3dias = "SELECT * FROM cotizaciones WHERE cotizaciones.fechaID >= '$fecha4dias' AND cotizaciones.fechaID <= '$fecha3dias' ORDER BY cotizaciones.id DESC";
$cotizacionesIngresadas3dias = mysqli_query($DKKadmin, $query_cotizacionesIngresadas3dias) or die(mysqli_error($DKKadmin));
$row_cotizacionesIngresadas3dias = mysqli_fetch_assoc($cotizacionesIngresadas3dias);
$totalRows_cotizacionesIngresadas3dias = mysqli_num_rows($cotizacionesIngresadas3dias);

$query_cotizacionesIngresadas4dias = "SELECT * FROM cotizaciones WHERE cotizaciones.fechaID >= '$fecha5dias' AND cotizaciones.fechaID <= '$fecha4dias' ORDER BY cotizaciones.id DESC";
$cotizacionesIngresadas4dias = mysqli_query($DKKadmin, $query_cotizacionesIngresadas4dias) or die(mysqli_error($DKKadmin));
$row_cotizacionesIngresadas4dias = mysqli_fetch_assoc($cotizacionesIngresadas4dias);
$totalRows_cotizacionesIngresadas4dias = mysqli_num_rows($cotizacionesIngresadas4dias);

$query_cotizacionesIngresadas5dias = "SELECT * FROM cotizaciones WHERE cotizaciones.fechaID >= '$fecha6dias' AND cotizaciones.fechaID <= '$fecha5dias' ORDER BY cotizaciones.id DESC";
$cotizacionesIngresadas5dias = mysqli_query($DKKadmin, $query_cotizacionesIngresadas5dias) or die(mysqli_error($DKKadmin));
$row_cotizacionesIngresadas5dias = mysqli_fetch_assoc($cotizacionesIngresadas5dias);
$totalRows_cotizacionesIngresadas5dias = mysqli_num_rows($cotizacionesIngresadas5dias);

$query_cotizacionesIngresadas6dias = "SELECT * FROM cotizaciones WHERE cotizaciones.fechaID >= '$fecha7dias' AND cotizaciones.fechaID <= '$fecha6dias' ORDER BY cotizaciones.id DESC";
$cotizacionesIngresadas6dias = mysqli_query($DKKadmin, $query_cotizacionesIngresadas6dias) or die(mysqli_error($DKKadmin));
$row_cotizacionesIngresadas6dias = mysqli_fetch_assoc($cotizacionesIngresadas6dias);
$totalRows_cotizacionesIngresadas6dias = mysqli_num_rows($cotizacionesIngresadas6dias);

$query_cotizacionesCotizadasEnero = "SELECT * FROM qts_cotizaciones WHERE qts_cotizaciones.fechaID >= '$enero' AND qts_cotizaciones.fechaID <= '$febrero' ORDER BY qts_cotizaciones.id DESC";
$cotizacionesCotizadasEnero = mysqli_query($DKKadmin, $query_cotizacionesCotizadasEnero) or die(mysqli_error($DKKadmin));
$row_cotizacionesCotizadasEnero = mysqli_fetch_assoc($cotizacionesCotizadasEnero);
$totalRows_cotizacionesCotizadasEnero = mysqli_num_rows($cotizacionesCotizadasEnero);

$query_cotizacionesCotizadasFebrero = "SELECT * FROM qts_cotizaciones WHERE qts_cotizaciones.fechaID >= '$febrero' AND qts_cotizaciones.fechaID <= '$marzo' ORDER BY qts_cotizaciones.id DESC";
$cotizacionesCotizadasFebrero = mysqli_query($DKKadmin, $query_cotizacionesCotizadasFebrero) or die(mysqli_error($DKKadmin));
$row_cotizacionesCotizadasFebrero = mysqli_fetch_assoc($cotizacionesCotizadasFebrero);
$totalRows_cotizacionesCotizadasFebrero = mysqli_num_rows($cotizacionesCotizadasFebrero);

$query_cotizacionesCotizadasMarzo = "SELECT * FROM qts_cotizaciones WHERE qts_cotizaciones.fechaID >= '$marzo' AND qts_cotizaciones.fechaID <= '$abril' ORDER BY qts_cotizaciones.id DESC";
$cotizacionesCotizadasMarzo = mysqli_query($DKKadmin, $query_cotizacionesCotizadasMarzo) or die(mysqli_error($DKKadmin));
$row_cotizacionesCotizadasMarzo = mysqli_fetch_assoc($cotizacionesCotizadasMarzo);
$totalRows_cotizacionesCotizadasMarzo = mysqli_num_rows($cotizacionesCotizadasMarzo);

$query_cotizacionesCotizadasAbril = "SELECT * FROM qts_cotizaciones WHERE qts_cotizaciones.fechaID >= '$abril' AND qts_cotizaciones.fechaID <= '$mayo' ORDER BY qts_cotizaciones.id DESC";
$cotizacionesCotizadasAbril = mysqli_query($DKKadmin, $query_cotizacionesCotizadasAbril) or die(mysqli_error($DKKadmin));
$row_cotizacionesCotizadasAbril = mysqli_fetch_assoc($cotizacionesCotizadasAbril);
$totalRows_cotizacionesCotizadasAbril = mysqli_num_rows($cotizacionesCotizadasAbril);

$query_cotizacionesCotizadasMayo = "SELECT * FROM qts_cotizaciones WHERE qts_cotizaciones.fechaID >= '$mayo' AND qts_cotizaciones.fechaID <= '$junio' ORDER BY qts_cotizaciones.id DESC";
$cotizacionesCotizadasMayo = mysqli_query($DKKadmin, $query_cotizacionesCotizadasMayo) or die(mysqli_error($DKKadmin));
$row_cotizacionesCotizadasMayo = mysqli_fetch_assoc($cotizacionesCotizadasMayo);
$totalRows_cotizacionesCotizadasMayo = mysqli_num_rows($cotizacionesCotizadasMayo);

$query_cotizacionesCotizadasJunio = "SELECT * FROM qts_cotizaciones WHERE qts_cotizaciones.fechaID >= '$junio' AND qts_cotizaciones.fechaID <= '$julio' ORDER BY qts_cotizaciones.id DESC";
$cotizacionesCotizadasJunio = mysqli_query($DKKadmin, $query_cotizacionesCotizadasJunio) or die(mysqli_error($DKKadmin));
$row_cotizacionesCotizadasJunio = mysqli_fetch_assoc($cotizacionesCotizadasJunio);
$totalRows_cotizacionesCotizadasJunio = mysqli_num_rows($cotizacionesCotizadasJunio);

$query_cotizacionesCotizadasJulio = "SELECT * FROM qts_cotizaciones WHERE qts_cotizaciones.fechaID >= '$julio' AND qts_cotizaciones.fechaID <= '$agosto' ORDER BY qts_cotizaciones.id DESC";
$cotizacionesCotizadasJulio = mysqli_query($DKKadmin, $query_cotizacionesCotizadasJulio) or die(mysqli_error($DKKadmin));
$row_cotizacionesCotizadasJulio = mysqli_fetch_assoc($cotizacionesCotizadasJulio);
$totalRows_cotizacionesCotizadasJulio = mysqli_num_rows($cotizacionesCotizadasJulio);

$query_cotizacionesCotizadasAgosto = "SELECT * FROM qts_cotizaciones WHERE qts_cotizaciones.fechaID >= '$agosto' AND qts_cotizaciones.fechaID <= '$septiembre' ORDER BY qts_cotizaciones.id DESC";
$cotizacionesCotizadasAgosto = mysqli_query($DKKadmin, $query_cotizacionesCotizadasAgosto) or die(mysqli_error($DKKadmin));
$row_cotizacionesCotizadasAgosto = mysqli_fetch_assoc($cotizacionesCotizadasAgosto);
$totalRows_cotizacionesCotizadasAgosto = mysqli_num_rows($cotizacionesCotizadasAgosto);

$query_cotizacionesCotizadasSeptiembre = "SELECT * FROM qts_cotizaciones WHERE qts_cotizaciones.fechaID >= '$septiembre' AND qts_cotizaciones.fechaID <= '$octubre' ORDER BY qts_cotizaciones.id DESC";
$cotizacionesCotizadasSeptiembre = mysqli_query($DKKadmin, $query_cotizacionesCotizadasSeptiembre) or die(mysqli_error($DKKadmin));
$row_cotizacionesCotizadasSeptiembre = mysqli_fetch_assoc($cotizacionesCotizadasSeptiembre);
$totalRows_cotizacionesCotizadasSeptiembre = mysqli_num_rows($cotizacionesCotizadasSeptiembre);

$query_cotizacionesCotizadasOctubre = "SELECT * FROM qts_cotizaciones WHERE qts_cotizaciones.fechaID >= '$octubre' AND qts_cotizaciones.fechaID <= '$noviembre' ORDER BY qts_cotizaciones.id DESC";
$cotizacionesCotizadasOctubre = mysqli_query($DKKadmin, $query_cotizacionesCotizadasOctubre) or die(mysqli_error($DKKadmin));
$row_cotizacionesCotizadasOctubre = mysqli_fetch_assoc($cotizacionesCotizadasOctubre);
$totalRows_cotizacionesCotizadasOctubre = mysqli_num_rows($cotizacionesCotizadasOctubre);

$query_cotizacionesCotizadasNoviembre = "SELECT * FROM qts_cotizaciones WHERE qts_cotizaciones.fechaID >= '$noviembre' AND qts_cotizaciones.fechaID <= '$diciembre' ORDER BY qts_cotizaciones.id DESC";
$cotizacionesCotizadasNoviembre = mysqli_query($DKKadmin, $query_cotizacionesCotizadasNoviembre) or die(mysqli_error($DKKadmin));
$row_cotizacionesCotizadasNoviembre = mysqli_fetch_assoc($cotizacionesCotizadasNoviembre);
$totalRows_cotizacionesCotizadasNoviembre = mysqli_num_rows($cotizacionesCotizadasNoviembre);

$query_cotizacionesCotizadasDiciembre = "SELECT * FROM qts_cotizaciones WHERE qts_cotizaciones.fechaID >= '$diciembre' AND qts_cotizaciones.fechaID <= '$nextYear' ORDER BY qts_cotizaciones.id DESC";
$cotizacionesCotizadasDiciembre = mysqli_query($DKKadmin, $query_cotizacionesCotizadasDiciembre) or die(mysqli_error($DKKadmin));
$row_cotizacionesCotizadasDiciembre = mysqli_fetch_assoc($cotizacionesCotizadasDiciembre);
$totalRows_cotizacionesCotizadasDiciembre = mysqli_num_rows($cotizacionesCotizadasDiciembre);

$query_cotizacionesCotizadasMes = "SELECT * FROM qts_cotizaciones WHERE qts_cotizaciones.fechaID >= '$mes' ORDER BY qts_cotizaciones.id DESC";
$cotizacionesCotizadasMes = mysqli_query($DKKadmin, $query_cotizacionesCotizadasMes) or die(mysqli_error($DKKadmin));
$row_cotizacionesCotizadasMes = mysqli_fetch_assoc($cotizacionesCotizadasMes);
$totalRows_cotizacionesCotizadasMes = mysqli_num_rows($cotizacionesCotizadasMes);

$query_cotizacionesAprobadasMes = "SELECT * FROM qts_cotizaciones WHERE qts_cotizaciones.fechaID >= '$mes' AND qts_cotizaciones.estado = '3' ORDER BY qts_cotizaciones.id DESC";
$cotizacionesAprobadasMes = mysqli_query($DKKadmin, $query_cotizacionesAprobadasMes) or die(mysqli_error($DKKadmin));
$row_cotizacionesAprobadasMes = mysqli_fetch_assoc($cotizacionesAprobadasMes);
$totalRows_cotizacionesAprobadasMes = mysqli_num_rows($cotizacionesAprobadasMes);

$query_cotizacionesAprobadasEnero = "SELECT * FROM qts_cotizaciones WHERE qts_cotizaciones.fechaID >= '$enero' AND qts_cotizaciones.fechaID <= '$febrero' AND qts_cotizaciones.estado = '3' ORDER BY qts_cotizaciones.id DESC";
$cotizacionesAprobadasEnero = mysqli_query($DKKadmin, $query_cotizacionesAprobadasEnero) or die(mysqli_error($DKKadmin));
$row_cotizacionesAprobadasEnero = mysqli_fetch_assoc($cotizacionesAprobadasEnero);
$totalRows_cotizacionesAprobadasEnero = mysqli_num_rows($cotizacionesAprobadasEnero);

$query_cotizacionesAprobadasFebrero = "SELECT * FROM qts_cotizaciones WHERE qts_cotizaciones.fechaID >= '$febrero' AND qts_cotizaciones.fechaID <= '$marzo' AND qts_cotizaciones.estado = '3' ORDER BY qts_cotizaciones.id DESC";
$cotizacionesAprobadasFebrero = mysqli_query($DKKadmin, $query_cotizacionesAprobadasFebrero) or die(mysqli_error($DKKadmin));
$row_cotizacionesAprobadasFebrero = mysqli_fetch_assoc($cotizacionesAprobadasFebrero);
$totalRows_cotizacionesAprobadasFebrero = mysqli_num_rows($cotizacionesAprobadasFebrero);

$query_cotizacionesAprobadasMarzo = "SELECT * FROM qts_cotizaciones WHERE qts_cotizaciones.fechaID >= '$marzo' AND qts_cotizaciones.fechaID <= '$abril' AND qts_cotizaciones.estado = '3' ORDER BY qts_cotizaciones.id DESC";
$cotizacionesAprobadasMarzo = mysqli_query($DKKadmin, $query_cotizacionesAprobadasMarzo) or die(mysqli_error($DKKadmin));
$row_cotizacionesAprobadasMarzo = mysqli_fetch_assoc($cotizacionesAprobadasMarzo);
$totalRows_cotizacionesAprobadasMarzo = mysqli_num_rows($cotizacionesAprobadasMarzo);

$query_cotizacionesAprobadasAbril = "SELECT * FROM qts_cotizaciones WHERE qts_cotizaciones.fechaID >= '$abril' AND qts_cotizaciones.fechaID <= '$mayo' AND qts_cotizaciones.estado = '3' ORDER BY qts_cotizaciones.id DESC";
$cotizacionesAprobadasAbril = mysqli_query($DKKadmin, $query_cotizacionesAprobadasAbril) or die(mysqli_error($DKKadmin));
$row_cotizacionesAprobadasAbril = mysqli_fetch_assoc($cotizacionesAprobadasAbril);
$totalRows_cotizacionesAprobadasAbril = mysqli_num_rows($cotizacionesAprobadasAbril);

$query_cotizacionesAprobadasMayo = "SELECT * FROM qts_cotizaciones WHERE qts_cotizaciones.fechaID >= '$mayo' AND qts_cotizaciones.fechaID <= '$junio' AND qts_cotizaciones.estado = '3' ORDER BY qts_cotizaciones.id DESC";
$cotizacionesAprobadasMayo = mysqli_query($DKKadmin, $query_cotizacionesAprobadasMayo) or die(mysqli_error($DKKadmin));
$row_cotizacionesAprobadasMayo = mysqli_fetch_assoc($cotizacionesAprobadasMayo);
$totalRows_cotizacionesAprobadasMayo = mysqli_num_rows($cotizacionesAprobadasMayo);

$query_cotizacionesAprobadasJunio = "SELECT * FROM qts_cotizaciones WHERE qts_cotizaciones.fechaID >= '$junio' AND qts_cotizaciones.fechaID <= '$julio' AND qts_cotizaciones.estado = '3' ORDER BY qts_cotizaciones.id DESC";
$cotizacionesAprobadasJunio = mysqli_query($DKKadmin, $query_cotizacionesAprobadasJunio) or die(mysqli_error($DKKadmin));
$row_cotizacionesAprobadasJunio = mysqli_fetch_assoc($cotizacionesAprobadasJunio);
$totalRows_cotizacionesAprobadasJunio = mysqli_num_rows($cotizacionesAprobadasJunio);

$query_cotizacionesAprobadasJulio = "SELECT * FROM qts_cotizaciones WHERE qts_cotizaciones.fechaID >= '$julio' AND qts_cotizaciones.fechaID <= '$agosto' AND qts_cotizaciones.estado = '3' ORDER BY qts_cotizaciones.id DESC";
$cotizacionesAprobadasJulio = mysqli_query($DKKadmin, $query_cotizacionesAprobadasJulio) or die(mysqli_error($DKKadmin));
$row_cotizacionesAprobadasJulio = mysqli_fetch_assoc($cotizacionesAprobadasJulio);
$totalRows_cotizacionesAprobadasJulio = mysqli_num_rows($cotizacionesAprobadasJulio);

$query_cotizacionesAprobadasAgosto = "SELECT * FROM qts_cotizaciones WHERE qts_cotizaciones.fechaID >= '$agosto' AND qts_cotizaciones.fechaID <= '$septiembre' AND qts_cotizaciones.estado = '3' ORDER BY qts_cotizaciones.id DESC";
$cotizacionesAprobadasAgosto = mysqli_query($DKKadmin, $query_cotizacionesAprobadasAgosto) or die(mysqli_error($DKKadmin));
$row_cotizacionesAprobadasAgosto = mysqli_fetch_assoc($cotizacionesAprobadasAgosto);
$totalRows_cotizacionesAprobadasAgosto = mysqli_num_rows($cotizacionesAprobadasAgosto);

$query_cotizacionesAprobadasSeptiembre = "SELECT * FROM qts_cotizaciones WHERE qts_cotizaciones.fechaID >= '$septiembre' AND qts_cotizaciones.fechaID <= '$octubre' AND qts_cotizaciones.estado = '3' ORDER BY qts_cotizaciones.id DESC";
$cotizacionesAprobadasSeptiembre = mysqli_query($DKKadmin, $query_cotizacionesAprobadasSeptiembre) or die(mysqli_error($DKKadmin));
$row_cotizacionesAprobadasSeptiembre = mysqli_fetch_assoc($cotizacionesAprobadasSeptiembre);
$totalRows_cotizacionesAprobadasSeptiembre = mysqli_num_rows($cotizacionesAprobadasSeptiembre);

$query_cotizacionesAprobadasOctubre = "SELECT * FROM qts_cotizaciones WHERE qts_cotizaciones.fechaID >= '$octubre' AND qts_cotizaciones.fechaID <= '$noviembre' AND qts_cotizaciones.estado = '3' ORDER BY qts_cotizaciones.id DESC";
$cotizacionesAprobadasOctubre = mysqli_query($DKKadmin, $query_cotizacionesAprobadasOctubre) or die(mysqli_error($DKKadmin));
$row_cotizacionesAprobadasOctubre = mysqli_fetch_assoc($cotizacionesAprobadasOctubre);
$totalRows_cotizacionesAprobadasOctubre = mysqli_num_rows($cotizacionesAprobadasOctubre);

$query_cotizacionesAprobadasNoviembre = "SELECT * FROM qts_cotizaciones WHERE qts_cotizaciones.fechaID >= '$noviembre' AND qts_cotizaciones.fechaID <= '$diciembre' AND qts_cotizaciones.estado = '3' ORDER BY qts_cotizaciones.id DESC";
$cotizacionesAprobadasNoviembre = mysqli_query($DKKadmin, $query_cotizacionesAprobadasNoviembre) or die(mysqli_error($DKKadmin));
$row_cotizacionesAprobadasNoviembre = mysqli_fetch_assoc($cotizacionesAprobadasNoviembre);
$totalRows_cotizacionesAprobadasNoviembre = mysqli_num_rows($cotizacionesAprobadasNoviembre);

$query_cotizacionesAprobadasDiciembre = "SELECT * FROM qts_cotizaciones WHERE qts_cotizaciones.fechaID >= '$diciembre' AND qts_cotizaciones.fechaID <= '$nextYear' AND qts_cotizaciones.estado = '3' ORDER BY qts_cotizaciones.id DESC";
$cotizacionesAprobadasDiciembre = mysqli_query($DKKadmin, $query_cotizacionesAprobadasDiciembre) or die(mysqli_error($DKKadmin));
$row_cotizacionesAprobadasDiciembre = mysqli_fetch_assoc($cotizacionesAprobadasDiciembre);
$totalRows_cotizacionesAprobadasDiciembre = mysqli_num_rows($cotizacionesAprobadasDiciembre);

$query_cotizacionesAprobadasTotal = "SELECT * FROM qts_cotizaciones WHERE qts_cotizaciones.estado = '3' ORDER BY qts_cotizaciones.id DESC";
$cotizacionesAprobadasTotal = mysqli_query($DKKadmin, $query_cotizacionesAprobadasTotal) or die(mysqli_error($DKKadmin));
$row_cotizacionesAprobadasTotal = mysqli_fetch_assoc($cotizacionesAprobadasTotal);
$totalRows_cotizacionesAprobadasTotal = mysqli_num_rows($cotizacionesAprobadasTotal);

$query_cotizacionesRechazadasMes = "SELECT * FROM qts_cotizaciones WHERE qts_cotizaciones.fechaID >= '$mes' AND qts_cotizaciones.estado = '4' ORDER BY qts_cotizaciones.id DESC";
$cotizacionesRechazadasMes = mysqli_query($DKKadmin, $query_cotizacionesRechazadasMes) or die(mysqli_error($DKKadmin));
$row_cotizacionesRechazadasMes = mysqli_fetch_assoc($cotizacionesRechazadasMes);
$totalRows_cotizacionesRechazadasMes = mysqli_num_rows($cotizacionesRechazadasMes);

$query_cotizacionesRechazadasEnero = "SELECT * FROM qts_cotizaciones WHERE qts_cotizaciones.fechaID >= '$enero' AND qts_cotizaciones.fechaID <= '$febrero' AND qts_cotizaciones.estado = '4' ORDER BY qts_cotizaciones.id DESC";
$cotizacionesRechazadasEnero = mysqli_query($DKKadmin, $query_cotizacionesRechazadasEnero) or die(mysqli_error($DKKadmin));
$row_cotizacionesRechazadasEnero = mysqli_fetch_assoc($cotizacionesRechazadasEnero);
$totalRows_cotizacionesRechazadasEnero = mysqli_num_rows($cotizacionesRechazadasEnero);

$query_cotizacionesRechazadasFebrero = "SELECT * FROM qts_cotizaciones WHERE qts_cotizaciones.fechaID >= '$febrero' AND qts_cotizaciones.fechaID <= '$marzo' AND qts_cotizaciones.estado = '4' ORDER BY qts_cotizaciones.id DESC";
$cotizacionesRechazadasFebrero = mysqli_query($DKKadmin, $query_cotizacionesRechazadasFebrero) or die(mysqli_error($DKKadmin));
$row_cotizacionesRechazadasFebrero = mysqli_fetch_assoc($cotizacionesRechazadasFebrero);
$totalRows_cotizacionesRechazadasFebrero = mysqli_num_rows($cotizacionesRechazadasFebrero);

$query_cotizacionesRechazadasMarzo = "SELECT * FROM qts_cotizaciones WHERE qts_cotizaciones.fechaID >= '$marzo' AND qts_cotizaciones.fechaID <= '$abril' AND qts_cotizaciones.estado = '4' ORDER BY qts_cotizaciones.id DESC";
$cotizacionesRechazadasMarzo = mysqli_query($DKKadmin, $query_cotizacionesRechazadasMarzo) or die(mysqli_error($DKKadmin));
$row_cotizacionesRechazadasMarzo = mysqli_fetch_assoc($cotizacionesRechazadasMarzo);
$totalRows_cotizacionesRechazadasMarzo = mysqli_num_rows($cotizacionesRechazadasMarzo);

$query_cotizacionesRechazadasAbril = "SELECT * FROM qts_cotizaciones WHERE qts_cotizaciones.fechaID >= '$abril' AND qts_cotizaciones.fechaID <= '$mayo' AND qts_cotizaciones.estado = '4' ORDER BY qts_cotizaciones.id DESC";
$cotizacionesRechazadasAbril = mysqli_query($DKKadmin, $query_cotizacionesRechazadasAbril) or die(mysqli_error($DKKadmin));
$row_cotizacionesRechazadasAbril = mysqli_fetch_assoc($cotizacionesRechazadasAbril);
$totalRows_cotizacionesRechazadasAbril = mysqli_num_rows($cotizacionesRechazadasAbril);

$query_cotizacionesRechazadasMayo = "SELECT * FROM qts_cotizaciones WHERE qts_cotizaciones.fechaID >= '$mayo' AND qts_cotizaciones.fechaID <= '$junio' AND qts_cotizaciones.estado = '4' ORDER BY qts_cotizaciones.id DESC";
$cotizacionesRechazadasMayo = mysqli_query($DKKadmin, $query_cotizacionesRechazadasMayo) or die(mysqli_error($DKKadmin));
$row_cotizacionesRechazadasMayo = mysqli_fetch_assoc($cotizacionesRechazadasMayo);
$totalRows_cotizacionesRechazadasMayo = mysqli_num_rows($cotizacionesRechazadasMayo);

$query_cotizacionesRechazadasJunio = "SELECT * FROM qts_cotizaciones WHERE qts_cotizaciones.fechaID >= '$junio' AND qts_cotizaciones.fechaID <= '$julio' AND qts_cotizaciones.estado = '4' ORDER BY qts_cotizaciones.id DESC";
$cotizacionesRechazadasJunio = mysqli_query($DKKadmin, $query_cotizacionesRechazadasJunio) or die(mysqli_error($DKKadmin));
$row_cotizacionesRechazadasJunio = mysqli_fetch_assoc($cotizacionesRechazadasJunio);
$totalRows_cotizacionesRechazadasJunio = mysqli_num_rows($cotizacionesRechazadasJunio);

$query_cotizacionesRechazadasJulio = "SELECT * FROM qts_cotizaciones WHERE qts_cotizaciones.fechaID >= '$julio' AND qts_cotizaciones.fechaID <= '$agosto' AND qts_cotizaciones.estado = '4' ORDER BY qts_cotizaciones.id DESC";
$cotizacionesRechazadasJulio = mysqli_query($DKKadmin, $query_cotizacionesRechazadasJulio) or die(mysqli_error($DKKadmin));
$row_cotizacionesRechazadasJulio = mysqli_fetch_assoc($cotizacionesRechazadasJulio);
$totalRows_cotizacionesRechazadasJulio = mysqli_num_rows($cotizacionesRechazadasJulio);

$query_cotizacionesRechazadasAgosto = "SELECT * FROM qts_cotizaciones WHERE qts_cotizaciones.fechaID >= '$agosto' AND qts_cotizaciones.fechaID <= '$septiembre' AND qts_cotizaciones.estado = '4' ORDER BY qts_cotizaciones.id DESC";
$cotizacionesRechazadasAgosto = mysqli_query($DKKadmin, $query_cotizacionesRechazadasAgosto) or die(mysqli_error($DKKadmin));
$row_cotizacionesRechazadasAgosto = mysqli_fetch_assoc($cotizacionesRechazadasAgosto);
$totalRows_cotizacionesRechazadasAgosto = mysqli_num_rows($cotizacionesRechazadasAgosto);

$query_cotizacionesRechazadasSeptiembre = "SELECT * FROM qts_cotizaciones WHERE qts_cotizaciones.fechaID >= '$septiembre' AND qts_cotizaciones.fechaID <= '$octubre' AND qts_cotizaciones.estado = '4' ORDER BY qts_cotizaciones.id DESC";
$cotizacionesRechazadasSeptiembre = mysqli_query($DKKadmin, $query_cotizacionesRechazadasSeptiembre) or die(mysqli_error($DKKadmin));
$row_cotizacionesRechazadasSeptiembre = mysqli_fetch_assoc($cotizacionesRechazadasSeptiembre);
$totalRows_cotizacionesRechazadasSeptiembre = mysqli_num_rows($cotizacionesRechazadasSeptiembre);

$query_cotizacionesRechazadasOctubre = "SELECT * FROM qts_cotizaciones WHERE qts_cotizaciones.fechaID >= '$octubre' AND qts_cotizaciones.fechaID <= '$noviembre' AND qts_cotizaciones.estado = '4' ORDER BY qts_cotizaciones.id DESC";
$cotizacionesRechazadasOctubre = mysqli_query($DKKadmin, $query_cotizacionesRechazadasOctubre) or die(mysqli_error($DKKadmin));
$row_cotizacionesRechazadasOctubre = mysqli_fetch_assoc($cotizacionesRechazadasOctubre);
$totalRows_cotizacionesRechazadasOctubre = mysqli_num_rows($cotizacionesRechazadasOctubre);

$query_cotizacionesRechazadasNoviembre = "SELECT * FROM qts_cotizaciones WHERE qts_cotizaciones.fechaID >= '$noviembre' AND qts_cotizaciones.fechaID <= '$diciembre' AND qts_cotizaciones.estado = '4' ORDER BY qts_cotizaciones.id DESC";
$cotizacionesRechazadasNoviembre = mysqli_query($DKKadmin, $query_cotizacionesRechazadasNoviembre) or die(mysqli_error($DKKadmin));
$row_cotizacionesRechazadasNoviembre = mysqli_fetch_assoc($cotizacionesRechazadasNoviembre);
$totalRows_cotizacionesRechazadasNoviembre = mysqli_num_rows($cotizacionesRechazadasNoviembre);

$query_cotizacionesRechazadasDiciembre = "SELECT * FROM qts_cotizaciones WHERE qts_cotizaciones.fechaID >= '$diciembre' AND qts_cotizaciones.fechaID <= '$nextYear' AND qts_cotizaciones.estado = '4' ORDER BY qts_cotizaciones.id DESC";
$cotizacionesRechazadasDiciembre = mysqli_query($DKKadmin, $query_cotizacionesRechazadasDiciembre) or die(mysqli_error($DKKadmin));
$row_cotizacionesRechazadasDiciembre = mysqli_fetch_assoc($cotizacionesRechazadasDiciembre);
$totalRows_cotizacionesRechazadasDiciembre = mysqli_num_rows($cotizacionesRechazadasDiciembre);

$query_cotizacionesPendientesMes = "SELECT * FROM qts_cotizaciones WHERE qts_cotizaciones.fechaID >= '$mes' AND qts_cotizaciones.estado = '2' ORDER BY qts_cotizaciones.id DESC";
$cotizacionesPendientesMes = mysqli_query($DKKadmin, $query_cotizacionesPendientesMes) or die(mysqli_error($DKKadmin));
$row_cotizacionesPendientesMes = mysqli_fetch_assoc($cotizacionesPendientesMes);
$totalRows_cotizacionesPendientesMes = mysqli_num_rows($cotizacionesPendientesMes);

$query_cotizacionesPendientesEnero = "SELECT * FROM qts_cotizaciones WHERE qts_cotizaciones.fechaID >= '$enero' AND qts_cotizaciones.fechaID <= '$febrero' AND qts_cotizaciones.estado = '2' ORDER BY qts_cotizaciones.id DESC";
$cotizacionesPendientesEnero = mysqli_query($DKKadmin, $query_cotizacionesPendientesEnero) or die(mysqli_error($DKKadmin));
$row_cotizacionesPendientesEnero = mysqli_fetch_assoc($cotizacionesPendientesEnero);
$totalRows_cotizacionesPendientesEnero = mysqli_num_rows($cotizacionesPendientesEnero);

$query_cotizacionesPendientesFebrero = "SELECT * FROM qts_cotizaciones WHERE qts_cotizaciones.fechaID >= '$febrero' AND qts_cotizaciones.fechaID <= '$marzo' AND qts_cotizaciones.estado = '2' ORDER BY qts_cotizaciones.id DESC";
$cotizacionesPendientesFebrero = mysqli_query($DKKadmin, $query_cotizacionesPendientesFebrero) or die(mysqli_error($DKKadmin));
$row_cotizacionesPendientesFebrero = mysqli_fetch_assoc($cotizacionesPendientesFebrero);
$totalRows_cotizacionesPendientesFebrero = mysqli_num_rows($cotizacionesPendientesFebrero);

$query_cotizacionesPendientesMarzo = "SELECT * FROM qts_cotizaciones WHERE qts_cotizaciones.fechaID >= '$marzo' AND qts_cotizaciones.fechaID <= '$abril' AND qts_cotizaciones.estado = '2' ORDER BY qts_cotizaciones.id DESC";
$cotizacionesPendientesMarzo = mysqli_query($DKKadmin, $query_cotizacionesPendientesMarzo) or die(mysqli_error($DKKadmin));
$row_cotizacionesPendientesMarzo = mysqli_fetch_assoc($cotizacionesPendientesMarzo);
$totalRows_cotizacionesPendientesMarzo = mysqli_num_rows($cotizacionesPendientesMarzo);

$query_cotizacionesPendientesAbril = "SELECT * FROM qts_cotizaciones WHERE qts_cotizaciones.fechaID >= '$abril' AND qts_cotizaciones.fechaID <= '$mayo' AND qts_cotizaciones.estado = '2' ORDER BY qts_cotizaciones.id DESC";
$cotizacionesPendientesAbril = mysqli_query($DKKadmin, $query_cotizacionesPendientesAbril) or die(mysqli_error($DKKadmin));
$row_cotizacionesPendientesAbril = mysqli_fetch_assoc($cotizacionesPendientesAbril);
$totalRows_cotizacionesPendientesAbril = mysqli_num_rows($cotizacionesPendientesAbril);

$query_cotizacionesPendientesMayo = "SELECT * FROM qts_cotizaciones WHERE qts_cotizaciones.fechaID >= '$mayo' AND qts_cotizaciones.fechaID <= '$junio' AND qts_cotizaciones.estado = '2' ORDER BY qts_cotizaciones.id DESC";
$cotizacionesPendientesMayo = mysqli_query($DKKadmin, $query_cotizacionesPendientesMayo) or die(mysqli_error($DKKadmin));
$row_cotizacionesPendientesMayo = mysqli_fetch_assoc($cotizacionesPendientesMayo);
$totalRows_cotizacionesPendientesMayo = mysqli_num_rows($cotizacionesPendientesMayo);

$query_cotizacionesPendientesJunio = "SELECT * FROM qts_cotizaciones WHERE qts_cotizaciones.fechaID >= '$junio' AND qts_cotizaciones.fechaID <= '$julio' AND qts_cotizaciones.estado = '2' ORDER BY qts_cotizaciones.id DESC";
$cotizacionesPendientesJunio = mysqli_query($DKKadmin, $query_cotizacionesPendientesJunio) or die(mysqli_error($DKKadmin));
$row_cotizacionesPendientesJunio = mysqli_fetch_assoc($cotizacionesPendientesJunio);
$totalRows_cotizacionesPendientesJunio = mysqli_num_rows($cotizacionesPendientesJunio);

$query_cotizacionesPendientesJulio = "SELECT * FROM qts_cotizaciones WHERE qts_cotizaciones.fechaID >= '$julio' AND qts_cotizaciones.fechaID <= '$agosto' AND qts_cotizaciones.estado = '2' ORDER BY qts_cotizaciones.id DESC";
$cotizacionesPendientesJulio = mysqli_query($DKKadmin, $query_cotizacionesPendientesJulio) or die(mysqli_error($DKKadmin));
$row_cotizacionesPendientesJulio = mysqli_fetch_assoc($cotizacionesPendientesJulio);
$totalRows_cotizacionesPendientesJulio = mysqli_num_rows($cotizacionesPendientesJulio);

$query_cotizacionesPendientesAgosto = "SELECT * FROM qts_cotizaciones WHERE qts_cotizaciones.fechaID >= '$agosto' AND qts_cotizaciones.fechaID <= '$septiembre' AND qts_cotizaciones.estado = '2' ORDER BY qts_cotizaciones.id DESC";
$cotizacionesPendientesAgosto = mysqli_query($DKKadmin, $query_cotizacionesPendientesAgosto) or die(mysqli_error($DKKadmin));
$row_cotizacionesPendientesAgosto = mysqli_fetch_assoc($cotizacionesPendientesAgosto);
$totalRows_cotizacionesPendientesAgosto = mysqli_num_rows($cotizacionesPendientesAgosto);

$query_cotizacionesPendientesSeptiembre = "SELECT * FROM qts_cotizaciones WHERE qts_cotizaciones.fechaID >= '$septiembre' AND qts_cotizaciones.fechaID <= '$octubre' AND qts_cotizaciones.estado = '2' ORDER BY qts_cotizaciones.id DESC";
$cotizacionesPendientesSeptiembre = mysqli_query($DKKadmin, $query_cotizacionesPendientesSeptiembre) or die(mysqli_error($DKKadmin));
$row_cotizacionesPendientesSeptiembre = mysqli_fetch_assoc($cotizacionesPendientesSeptiembre);
$totalRows_cotizacionesPendientesSeptiembre = mysqli_num_rows($cotizacionesPendientesSeptiembre);

$query_cotizacionesPendientesOctubre = "SELECT * FROM qts_cotizaciones WHERE qts_cotizaciones.fechaID >= '$octubre' AND qts_cotizaciones.fechaID <= '$noviembre' AND qts_cotizaciones.estado = '2' ORDER BY qts_cotizaciones.id DESC";
$cotizacionesPendientesOctubre = mysqli_query($DKKadmin, $query_cotizacionesPendientesOctubre) or die(mysqli_error($DKKadmin));
$row_cotizacionesPendientesOctubre = mysqli_fetch_assoc($cotizacionesPendientesOctubre);
$totalRows_cotizacionesPendientesOctubre = mysqli_num_rows($cotizacionesPendientesOctubre);

$query_cotizacionesPendientesNoviembre = "SELECT * FROM qts_cotizaciones WHERE qts_cotizaciones.fechaID >= '$noviembre' AND qts_cotizaciones.fechaID <= '$diciembre' AND qts_cotizaciones.estado = '2' ORDER BY qts_cotizaciones.id DESC";
$cotizacionesPendientesNoviembre = mysqli_query($DKKadmin, $query_cotizacionesPendientesNoviembre) or die(mysqli_error($DKKadmin));
$row_cotizacionesPendientesNoviembre = mysqli_fetch_assoc($cotizacionesPendientesNoviembre);
$totalRows_cotizacionesPendientesNoviembre = mysqli_num_rows($cotizacionesPendientesNoviembre);

$query_cotizacionesPendientesDiciembre = "SELECT * FROM qts_cotizaciones WHERE qts_cotizaciones.fechaID >= '$diciembre' AND qts_cotizaciones.fechaID <= '$nextYear' AND qts_cotizaciones.estado = '2' ORDER BY qts_cotizaciones.id DESC";
$cotizacionesPendientesDiciembre = mysqli_query($DKKadmin, $query_cotizacionesPendientesDiciembre) or die(mysqli_error($DKKadmin));
$row_cotizacionesPendientesDiciembre = mysqli_fetch_assoc($cotizacionesPendientesDiciembre);
$totalRows_cotizacionesPendientesDiciembre = mysqli_num_rows($cotizacionesPendientesDiciembre);

$query_whatsappMes = "SELECT * FROM visitas WHERE visitas.pagina = 'whatsapp' AND visitas.fechaID >= '$mes' ORDER BY visitas.id DESC";
$whatsappMes = mysqli_query($DKKadmin, $query_whatsappMes) or die(mysqli_error($DKKadmin));
$row_whatsappMes = mysqli_fetch_assoc($whatsappMes);
$totalRows_whatsappMes = mysqli_num_rows($whatsappMes);

$query_whatsapp1 = "SELECT * FROM visitas WHERE visitas.pagina = 'whatsapp' AND visitas.fechaID >= '$dia1' AND visitas.fechaID <= '$dia2' ORDER BY visitas.id DESC";
$whatsapp1 = mysqli_query($DKKadmin, $query_whatsapp1) or die(mysqli_error($DKKadmin));
$row_whatsapp1 = mysqli_fetch_assoc($whatsapp1);
$totalRows_whatsapp1 = mysqli_num_rows($whatsapp1);

$query_whatsapp2 = "SELECT * FROM visitas WHERE visitas.pagina = 'whatsapp' AND visitas.fechaID >= '$dia2' AND visitas.fechaID <= '$dia3' ORDER BY visitas.id DESC";
$whatsapp2 = mysqli_query($DKKadmin, $query_whatsapp2) or die(mysqli_error($DKKadmin));
$row_whatsapp2 = mysqli_fetch_assoc($whatsapp2);
$totalRows_whatsapp2 = mysqli_num_rows($whatsapp2);

$query_whatsapp3 = "SELECT * FROM visitas WHERE visitas.pagina = 'whatsapp' AND visitas.fechaID >= '$dia3' AND visitas.fechaID <= '$dia4' ORDER BY visitas.id DESC";
$whatsapp3 = mysqli_query($DKKadmin, $query_whatsapp3) or die(mysqli_error($DKKadmin));
$row_whatsapp3 = mysqli_fetch_assoc($whatsapp3);
$totalRows_whatsapp3 = mysqli_num_rows($whatsapp3);

$query_whatsapp4 = "SELECT * FROM visitas WHERE visitas.pagina = 'whatsapp' AND visitas.fechaID >= '$dia4' AND visitas.fechaID <= '$dia5' ORDER BY visitas.id DESC";
$whatsapp4 = mysqli_query($DKKadmin, $query_whatsapp4) or die(mysqli_error($DKKadmin));
$row_whatsapp4 = mysqli_fetch_assoc($whatsapp4);
$totalRows_whatsapp4 = mysqli_num_rows($whatsapp4);

$query_whatsapp5 = "SELECT * FROM visitas WHERE visitas.pagina = 'whatsapp' AND visitas.fechaID >= '$dia5' AND visitas.fechaID <= '$dia6' ORDER BY visitas.id DESC";
$whatsapp5 = mysqli_query($DKKadmin, $query_whatsapp5) or die(mysqli_error($DKKadmin));
$row_whatsapp5 = mysqli_fetch_assoc($whatsapp5);
$totalRows_whatsapp5 = mysqli_num_rows($whatsapp5);

$query_whatsapp6 = "SELECT * FROM visitas WHERE visitas.pagina = 'whatsapp' AND visitas.fechaID >= '$dia6' AND visitas.fechaID <= '$dia7' ORDER BY visitas.id DESC";
$whatsapp6 = mysqli_query($DKKadmin, $query_whatsapp6) or die(mysqli_error($DKKadmin));
$row_whatsapp6 = mysqli_fetch_assoc($whatsapp6);
$totalRows_whatsapp6 = mysqli_num_rows($whatsapp6);

$query_whatsapp7 = "SELECT * FROM visitas WHERE visitas.pagina = 'whatsapp' AND visitas.fechaID >= '$dia7' AND visitas.fechaID <= '$dia8' ORDER BY visitas.id DESC";
$whatsapp7 = mysqli_query($DKKadmin, $query_whatsapp7) or die(mysqli_error($DKKadmin));
$row_whatsapp7 = mysqli_fetch_assoc($whatsapp7);
$totalRows_whatsapp7 = mysqli_num_rows($whatsapp7);

$query_whatsapp8 = "SELECT * FROM visitas WHERE visitas.pagina = 'whatsapp' AND visitas.fechaID >= '$dia8' AND visitas.fechaID <= '$dia9' ORDER BY visitas.id DESC";
$whatsapp8 = mysqli_query($DKKadmin, $query_whatsapp8) or die(mysqli_error($DKKadmin));
$row_whatsapp8 = mysqli_fetch_assoc($whatsapp8);
$totalRows_whatsapp8 = mysqli_num_rows($whatsapp8);

$query_whatsapp9 = "SELECT * FROM visitas WHERE visitas.pagina = 'whatsapp' AND visitas.fechaID >= '$dia9' AND visitas.fechaID <= '$dia10' ORDER BY visitas.id DESC";
$whatsapp9 = mysqli_query($DKKadmin, $query_whatsapp9) or die(mysqli_error($DKKadmin));
$row_whatsapp9 = mysqli_fetch_assoc($whatsapp9);
$totalRows_whatsapp9 = mysqli_num_rows($whatsapp9);

$query_whatsapp10 = "SELECT * FROM visitas WHERE visitas.pagina = 'whatsapp' AND visitas.fechaID >= '$dia10' AND visitas.fechaID <= '$dia11' ORDER BY visitas.id DESC";
$whatsapp10 = mysqli_query($DKKadmin, $query_whatsapp10) or die(mysqli_error($DKKadmin));
$row_whatsapp10 = mysqli_fetch_assoc($whatsapp10);
$totalRows_whatsapp10 = mysqli_num_rows($whatsapp10);

$query_whatsapp11 = "SELECT * FROM visitas WHERE visitas.pagina = 'whatsapp' AND visitas.fechaID >= '$dia11' AND visitas.fechaID <= '$dia12' ORDER BY visitas.id DESC";
$whatsapp11 = mysqli_query($DKKadmin, $query_whatsapp11) or die(mysqli_error($DKKadmin));
$row_whatsapp11 = mysqli_fetch_assoc($whatsapp11dias);
$totalRows_whatsapp11 = mysqli_num_rows($whatsapp11);

$query_whatsapp12 = "SELECT * FROM visitas WHERE visitas.pagina = 'whatsapp' AND visitas.fechaID >= '$dia12' AND visitas.fechaID <= '$dia13' ORDER BY visitas.id DESC";
$whatsapp12 = mysqli_query($DKKadmin, $query_whatsapp12) or die(mysqli_error($DKKadmin));
$row_whatsapp12 = mysqli_fetch_assoc($whatsapp12);
$totalRows_whatsapp12 = mysqli_num_rows($whatsapp12);

$query_whatsapp13 = "SELECT * FROM visitas WHERE visitas.pagina = 'whatsapp' AND visitas.fechaID >= '$dia13' AND visitas.fechaID <= '$dia14' ORDER BY visitas.id DESC";
$whatsapp13 = mysqli_query($DKKadmin, $query_whatsapp13) or die(mysqli_error($DKKadmin));
$row_whatsapp13 = mysqli_fetch_assoc($whatsapp13);
$totalRows_whatsapp13 = mysqli_num_rows($whatsapp13);

$query_whatsapp14 = "SELECT * FROM visitas WHERE visitas.pagina = 'whatsapp' AND visitas.fechaID >= '$dia14' AND visitas.fechaID <= '$dia15' ORDER BY visitas.id DESC";
$whatsapp14 = mysqli_query($DKKadmin, $query_whatsapp14) or die(mysqli_error($DKKadmin));
$row_whatsapp14 = mysqli_fetch_assoc($whatsapp14);
$totalRows_whatsapp14 = mysqli_num_rows($whatsapp14);

$query_whatsapp15 = "SELECT * FROM visitas WHERE visitas.pagina = 'whatsapp' AND visitas.fechaID >= '$dia15' AND visitas.fechaID <= '$dia16' ORDER BY visitas.id DESC";
$whatsapp15 = mysqli_query($DKKadmin, $query_whatsapp15) or die(mysqli_error($DKKadmin));
$row_whatsapp15 = mysqli_fetch_assoc($whatsapp15);
$totalRows_whatsapp15 = mysqli_num_rows($whatsapp15);

$query_whatsapp16 = "SELECT * FROM visitas WHERE visitas.pagina = 'whatsapp' AND visitas.fechaID >= '$dia16' AND visitas.fechaID <= '$dia17' ORDER BY visitas.id DESC";
$whatsapp16 = mysqli_query($DKKadmin, $query_whatsapp16) or die(mysqli_error($DKKadmin));
$row_whatsapp16 = mysqli_fetch_assoc($whatsapp16dias);
$totalRows_whatsapp16 = mysqli_num_rows($whatsapp16);

$query_whatsapp17 = "SELECT * FROM visitas WHERE visitas.pagina = 'whatsapp' AND visitas.fechaID >= '$dia17' AND visitas.fechaID <= '$dia18' ORDER BY visitas.id DESC";
$whatsapp17 = mysqli_query($DKKadmin, $query_whatsapp17) or die(mysqli_error($DKKadmin));
$row_whatsapp17 = mysqli_fetch_assoc($whatsapp17);
$totalRows_whatsapp17 = mysqli_num_rows($whatsapp17);

$query_whatsapp18 = "SELECT * FROM visitas WHERE visitas.pagina = 'whatsapp' AND visitas.fechaID >= '$dia18' AND visitas.fechaID <= '$dia19' ORDER BY visitas.id DESC";
$whatsapp18 = mysqli_query($DKKadmin, $query_whatsapp18) or die(mysqli_error($DKKadmin));
$row_whatsapp18 = mysqli_fetch_assoc($whatsapp18);
$totalRows_whatsapp18 = mysqli_num_rows($whatsapp18);

$query_whatsapp19 = "SELECT * FROM visitas WHERE visitas.pagina = 'whatsapp' AND visitas.fechaID >= '$dia19' AND visitas.fechaID <= '$dia20' ORDER BY visitas.id DESC";
$whatsapp19 = mysqli_query($DKKadmin, $query_whatsapp19) or die(mysqli_error($DKKadmin));
$row_whatsapp19 = mysqli_fetch_assoc($whatsapp19);
$totalRows_whatsapp19 = mysqli_num_rows($whatsapp19);

$query_whatsapp20 = "SELECT * FROM visitas WHERE visitas.pagina = 'whatsapp' AND visitas.fechaID >= '$dia20' AND visitas.fechaID <= '$dia21' ORDER BY visitas.id DESC";
$whatsapp20 = mysqli_query($DKKadmin, $query_whatsapp20) or die(mysqli_error($DKKadmin));
$row_whatsapp20 = mysqli_fetch_assoc($whatsapp20);
$totalRows_whatsapp20 = mysqli_num_rows($whatsapp20);

$query_whatsapp21 = "SELECT * FROM visitas WHERE visitas.pagina = 'whatsapp' AND visitas.fechaID >= '$dia21' AND visitas.fechaID <= '$dia22' ORDER BY visitas.id DESC";
$whatsapp21 = mysqli_query($DKKadmin, $query_whatsapp21) or die(mysqli_error($DKKadmin));
$row_whatsapp21 = mysqli_fetch_assoc($whatsapp21dias);
$totalRows_whatsapp21 = mysqli_num_rows($whatsapp21);

$query_whatsapp22 = "SELECT * FROM visitas WHERE visitas.pagina = 'whatsapp' AND visitas.fechaID >= '$dia22' AND visitas.fechaID <= '$dia23' ORDER BY visitas.id DESC";
$whatsapp22 = mysqli_query($DKKadmin, $query_whatsapp22) or die(mysqli_error($DKKadmin));
$row_whatsapp22 = mysqli_fetch_assoc($whatsapp22);
$totalRows_whatsapp22 = mysqli_num_rows($whatsapp22);

$query_whatsapp23 = "SELECT * FROM visitas WHERE visitas.pagina = 'whatsapp' AND visitas.fechaID >= '$dia23' AND visitas.fechaID <= '$dia24' ORDER BY visitas.id DESC";
$whatsapp23 = mysqli_query($DKKadmin, $query_whatsapp23) or die(mysqli_error($DKKadmin));
$row_whatsapp23 = mysqli_fetch_assoc($whatsapp23);
$totalRows_whatsapp23 = mysqli_num_rows($whatsapp23);

$query_whatsapp24 = "SELECT * FROM visitas WHERE visitas.pagina = 'whatsapp' AND visitas.fechaID >= '$dia24' AND visitas.fechaID <= '$dia25' ORDER BY visitas.id DESC";
$whatsapp24 = mysqli_query($DKKadmin, $query_whatsapp24) or die(mysqli_error($DKKadmin));
$row_whatsapp24 = mysqli_fetch_assoc($whatsapp24);
$totalRows_whatsapp24 = mysqli_num_rows($whatsapp24);

$query_whatsapp25 = "SELECT * FROM visitas WHERE visitas.pagina = 'whatsapp' AND visitas.fechaID >= '$dia25' AND visitas.fechaID <= '$dia26' ORDER BY visitas.id DESC";
$whatsapp25 = mysqli_query($DKKadmin, $query_whatsapp25) or die(mysqli_error($DKKadmin));
$row_whatsapp25 = mysqli_fetch_assoc($whatsapp25);
$totalRows_whatsapp25 = mysqli_num_rows($whatsapp25);

$query_whatsapp26 = "SELECT * FROM visitas WHERE visitas.pagina = 'whatsapp' AND visitas.fechaID >= '$dia26' AND visitas.fechaID <= '$dia27' ORDER BY visitas.id DESC";
$whatsapp26 = mysqli_query($DKKadmin, $query_whatsapp26) or die(mysqli_error($DKKadmin));
$row_whatsapp26 = mysqli_fetch_assoc($whatsapp26dias);
$totalRows_whatsapp26 = mysqli_num_rows($whatsapp26);

$query_whatsapp27 = "SELECT * FROM visitas WHERE visitas.pagina = 'whatsapp' AND visitas.fechaID >= '$dia27' AND visitas.fechaID <= '$dia28' ORDER BY visitas.id DESC";
$whatsapp27 = mysqli_query($DKKadmin, $query_whatsapp27) or die(mysqli_error($DKKadmin));
$row_whatsapp27 = mysqli_fetch_assoc($whatsapp27);
$totalRows_whatsapp27 = mysqli_num_rows($whatsapp27);

$query_whatsapp28 = "SELECT * FROM visitas WHERE visitas.pagina = 'whatsapp' AND visitas.fechaID >= '$dia28' AND visitas.fechaID <= '$dia29' ORDER BY visitas.id DESC";
$whatsapp28 = mysqli_query($DKKadmin, $query_whatsapp28) or die(mysqli_error($DKKadmin));
$row_whatsapp28 = mysqli_fetch_assoc($whatsapp28);
$totalRows_whatsapp28 = mysqli_num_rows($whatsapp28);

$query_whatsapp29 = "SELECT * FROM visitas WHERE visitas.pagina = 'whatsapp' AND visitas.fechaID >= '$dia29' AND visitas.fechaID <= '$dia30' ORDER BY visitas.id DESC";
$whatsapp29 = mysqli_query($DKKadmin, $query_whatsapp29) or die(mysqli_error($DKKadmin));
$row_whatsapp29 = mysqli_fetch_assoc($whatsapp29);
$totalRows_whatsapp29 = mysqli_num_rows($whatsapp29);

$query_whatsapp30 = "SELECT * FROM visitas WHERE visitas.pagina = 'whatsapp' AND visitas.fechaID >= '$dia30' AND visitas.fechaID <= '$dia31' ORDER BY visitas.id DESC";
$whatsapp30 = mysqli_query($DKKadmin, $query_whatsapp30) or die(mysqli_error($DKKadmin));
$row_whatsapp30 = mysqli_fetch_assoc($whatsapp30);
$totalRows_whatsapp30 = mysqli_num_rows($whatsapp30);

$query_whatsapp31 = "SELECT * FROM visitas WHERE visitas.pagina = 'whatsapp' AND visitas.fechaID >= '$dia31' AND visitas.fechaID <= '$nextMonth' ORDER BY visitas.id DESC";
$whatsapp31 = mysqli_query($DKKadmin, $query_whatsapp31) or die(mysqli_error($DKKadmin));
$row_whatsapp31 = mysqli_fetch_assoc($whatsapp31dias);
$totalRows_whatsapp31 = mysqli_num_rows($whatsapp31);

$query_whatsappTotal = "SELECT * FROM visitas WHERE visitas.pagina = 'whatsapp' ORDER BY visitas.id DESC";
$whatsappTotal = mysqli_query($DKKadmin, $query_whatsappTotal) or die(mysqli_error($DKKadmin));
$row_whatsappTotal = mysqli_fetch_assoc($whatsappTotal);
$totalRows_whatsappTotal = mysqli_num_rows($whatsappTotal);

$query_webMes = "SELECT * FROM cotizaciones WHERE cotizaciones.fechaID >= '$mes' ORDER BY cotizaciones.id DESC";
$webMes = mysqli_query($DKKadmin, $query_webMes) or die(mysqli_error($DKKadmin));
$row_webMes = mysqli_fetch_assoc($webMes);
$totalRows_webMes = mysqli_num_rows($webMes);

$query_web1 = "SELECT * FROM cotizaciones WHERE cotizaciones.fechaID >= '$dia1' AND cotizaciones.fechaID <= '$dia2' ORDER BY cotizaciones.id DESC";
$web1 = mysqli_query($DKKadmin, $query_web1) or die(mysqli_error($DKKadmin));
$row_web1 = mysqli_fetch_assoc($web1);
$totalRows_web1 = mysqli_num_rows($web1);

$query_web2 = "SELECT * FROM cotizaciones WHERE cotizaciones.fechaID >= '$dia2' AND cotizaciones.fechaID <= '$dia3' ORDER BY cotizaciones.id DESC";
$web2 = mysqli_query($DKKadmin, $query_web2) or die(mysqli_error($DKKadmin));
$row_web2 = mysqli_fetch_assoc($web2);
$totalRows_web2 = mysqli_num_rows($web2);

$query_web3 = "SELECT * FROM cotizaciones WHERE cotizaciones.fechaID >= '$dia3' AND cotizaciones.fechaID <= '$dia4' ORDER BY cotizaciones.id DESC";
$web3 = mysqli_query($DKKadmin, $query_web3) or die(mysqli_error($DKKadmin));
$row_web3 = mysqli_fetch_assoc($web3);
$totalRows_web3 = mysqli_num_rows($web3);

$query_web4 = "SELECT * FROM cotizaciones WHERE cotizaciones.fechaID >= '$dia4' AND cotizaciones.fechaID <= '$dia5' ORDER BY cotizaciones.id DESC";
$web4 = mysqli_query($DKKadmin, $query_web4) or die(mysqli_error($DKKadmin));
$row_web4 = mysqli_fetch_assoc($web4);
$totalRows_web4 = mysqli_num_rows($web4);

$query_web5 = "SELECT * FROM cotizaciones WHERE cotizaciones.fechaID >= '$dia5' AND cotizaciones.fechaID <= '$dia6' ORDER BY cotizaciones.id DESC";
$web5 = mysqli_query($DKKadmin, $query_web5) or die(mysqli_error($DKKadmin));
$row_web5 = mysqli_fetch_assoc($web5);
$totalRows_web5 = mysqli_num_rows($web5);

$query_web6 = "SELECT * FROM cotizaciones WHERE cotizaciones.fechaID >= '$dia6' AND cotizaciones.fechaID <= '$dia7' ORDER BY cotizaciones.id DESC";
$web6 = mysqli_query($DKKadmin, $query_web6) or die(mysqli_error($DKKadmin));
$row_web6 = mysqli_fetch_assoc($web6);
$totalRows_web6 = mysqli_num_rows($web6);

$query_web7 = "SELECT * FROM cotizaciones WHERE cotizaciones.fechaID >= '$dia7' AND cotizaciones.fechaID <= '$dia8' ORDER BY cotizaciones.id DESC";
$web7 = mysqli_query($DKKadmin, $query_web7) or die(mysqli_error($DKKadmin));
$row_web7 = mysqli_fetch_assoc($web7);
$totalRows_web7 = mysqli_num_rows($web7);

$query_web8 = "SELECT * FROM cotizaciones WHERE cotizaciones.fechaID >= '$dia8' AND cotizaciones.fechaID <= '$dia9' ORDER BY cotizaciones.id DESC";
$web8 = mysqli_query($DKKadmin, $query_web8) or die(mysqli_error($DKKadmin));
$row_web8 = mysqli_fetch_assoc($web8);
$totalRows_web8 = mysqli_num_rows($web8);

$query_web9 = "SELECT * FROM cotizaciones WHERE cotizaciones.fechaID >= '$dia9' AND cotizaciones.fechaID <= '$dia10' ORDER BY cotizaciones.id DESC";
$web9 = mysqli_query($DKKadmin, $query_web9) or die(mysqli_error($DKKadmin));
$row_web9 = mysqli_fetch_assoc($web9);
$totalRows_web9 = mysqli_num_rows($web9);

$query_web10 = "SELECT * FROM cotizaciones WHERE cotizaciones.fechaID >= '$dia10' AND cotizaciones.fechaID <= '$dia11' ORDER BY cotizaciones.id DESC";
$web10 = mysqli_query($DKKadmin, $query_web10) or die(mysqli_error($DKKadmin));
$row_web10 = mysqli_fetch_assoc($web10);
$totalRows_web10 = mysqli_num_rows($web10);

$query_web11 = "SELECT * FROM cotizaciones WHERE cotizaciones.fechaID >= '$dia11' AND cotizaciones.fechaID <= '$dia12' ORDER BY cotizaciones.id DESC";
$web11 = mysqli_query($DKKadmin, $query_web11) or die(mysqli_error($DKKadmin));
$row_web11 = mysqli_fetch_assoc($web11dias);
$totalRows_web11 = mysqli_num_rows($web11);

$query_web12 = "SELECT * FROM cotizaciones WHERE cotizaciones.fechaID >= '$dia12' AND cotizaciones.fechaID <= '$dia13' ORDER BY cotizaciones.id DESC";
$web12 = mysqli_query($DKKadmin, $query_web12) or die(mysqli_error($DKKadmin));
$row_web12 = mysqli_fetch_assoc($web12);
$totalRows_web12 = mysqli_num_rows($web12);

$query_web13 = "SELECT * FROM cotizaciones WHERE cotizaciones.fechaID >= '$dia13' AND cotizaciones.fechaID <= '$dia14' ORDER BY cotizaciones.id DESC";
$web13 = mysqli_query($DKKadmin, $query_web13) or die(mysqli_error($DKKadmin));
$row_web13 = mysqli_fetch_assoc($web13);
$totalRows_web13 = mysqli_num_rows($web13);

$query_web14 = "SELECT * FROM cotizaciones WHERE cotizaciones.fechaID >= '$dia14' AND cotizaciones.fechaID <= '$dia15' ORDER BY cotizaciones.id DESC";
$web14 = mysqli_query($DKKadmin, $query_web14) or die(mysqli_error($DKKadmin));
$row_web14 = mysqli_fetch_assoc($web14);
$totalRows_web14 = mysqli_num_rows($web14);

$query_web15 = "SELECT * FROM cotizaciones WHERE cotizaciones.fechaID >= '$dia15' AND cotizaciones.fechaID <= '$dia16' ORDER BY cotizaciones.id DESC";
$web15 = mysqli_query($DKKadmin, $query_web15) or die(mysqli_error($DKKadmin));
$row_web15 = mysqli_fetch_assoc($web15);
$totalRows_web15 = mysqli_num_rows($web15);

$query_web16 = "SELECT * FROM cotizaciones WHERE cotizaciones.fechaID >= '$dia16' AND cotizaciones.fechaID <= '$dia17' ORDER BY cotizaciones.id DESC";
$web16 = mysqli_query($DKKadmin, $query_web16) or die(mysqli_error($DKKadmin));
$row_web16 = mysqli_fetch_assoc($web16dias);
$totalRows_web16 = mysqli_num_rows($web16);

$query_web17 = "SELECT * FROM cotizaciones WHERE cotizaciones.fechaID >= '$dia17' AND cotizaciones.fechaID <= '$dia18' ORDER BY cotizaciones.id DESC";
$web17 = mysqli_query($DKKadmin, $query_web17) or die(mysqli_error($DKKadmin));
$row_web17 = mysqli_fetch_assoc($web17);
$totalRows_web17 = mysqli_num_rows($web17);

$query_web18 = "SELECT * FROM cotizaciones WHERE cotizaciones.fechaID >= '$dia18' AND cotizaciones.fechaID <= '$dia19' ORDER BY cotizaciones.id DESC";
$web18 = mysqli_query($DKKadmin, $query_web18) or die(mysqli_error($DKKadmin));
$row_web18 = mysqli_fetch_assoc($web18);
$totalRows_web18 = mysqli_num_rows($web18);

$query_web19 = "SELECT * FROM cotizaciones WHERE cotizaciones.fechaID >= '$dia19' AND cotizaciones.fechaID <= '$dia20' ORDER BY cotizaciones.id DESC";
$web19 = mysqli_query($DKKadmin, $query_web19) or die(mysqli_error($DKKadmin));
$row_web19 = mysqli_fetch_assoc($web19);
$totalRows_web19 = mysqli_num_rows($web19);

$query_web20 = "SELECT * FROM cotizaciones WHERE cotizaciones.fechaID >= '$dia20' AND cotizaciones.fechaID <= '$dia21' ORDER BY cotizaciones.id DESC";
$web20 = mysqli_query($DKKadmin, $query_web20) or die(mysqli_error($DKKadmin));
$row_web20 = mysqli_fetch_assoc($web20);
$totalRows_web20 = mysqli_num_rows($web20);

$query_web21 = "SELECT * FROM cotizaciones WHERE cotizaciones.fechaID >= '$dia21' AND cotizaciones.fechaID <= '$dia22' ORDER BY cotizaciones.id DESC";
$web21 = mysqli_query($DKKadmin, $query_web21) or die(mysqli_error($DKKadmin));
$row_web21 = mysqli_fetch_assoc($web21dias);
$totalRows_web21 = mysqli_num_rows($web21);

$query_web22 = "SELECT * FROM cotizaciones WHERE cotizaciones.fechaID >= '$dia22' AND cotizaciones.fechaID <= '$dia23' ORDER BY cotizaciones.id DESC";
$web22 = mysqli_query($DKKadmin, $query_web22) or die(mysqli_error($DKKadmin));
$row_web22 = mysqli_fetch_assoc($web22);
$totalRows_web22 = mysqli_num_rows($web22);

$query_web23 = "SELECT * FROM cotizaciones WHERE cotizaciones.fechaID >= '$dia23' AND cotizaciones.fechaID <= '$dia24' ORDER BY cotizaciones.id DESC";
$web23 = mysqli_query($DKKadmin, $query_web23) or die(mysqli_error($DKKadmin));
$row_web23 = mysqli_fetch_assoc($web23);
$totalRows_web23 = mysqli_num_rows($web23);

$query_web24 = "SELECT * FROM cotizaciones WHERE cotizaciones.fechaID >= '$dia24' AND cotizaciones.fechaID <= '$dia25' ORDER BY cotizaciones.id DESC";
$web24 = mysqli_query($DKKadmin, $query_web24) or die(mysqli_error($DKKadmin));
$row_web24 = mysqli_fetch_assoc($web24);
$totalRows_web24 = mysqli_num_rows($web24);

$query_web25 = "SELECT * FROM cotizaciones WHERE cotizaciones.fechaID >= '$dia25' AND cotizaciones.fechaID <= '$dia26' ORDER BY cotizaciones.id DESC";
$web25 = mysqli_query($DKKadmin, $query_web25) or die(mysqli_error($DKKadmin));
$row_web25 = mysqli_fetch_assoc($web25);
$totalRows_web25 = mysqli_num_rows($web25);

$query_web26 = "SELECT * FROM cotizaciones WHERE cotizaciones.fechaID >= '$dia26' AND cotizaciones.fechaID <= '$dia27' ORDER BY cotizaciones.id DESC";
$web26 = mysqli_query($DKKadmin, $query_web26) or die(mysqli_error($DKKadmin));
$row_web26 = mysqli_fetch_assoc($web26dias);
$totalRows_web26 = mysqli_num_rows($web26);

$query_web27 = "SELECT * FROM cotizaciones WHERE cotizaciones.fechaID >= '$dia27' AND cotizaciones.fechaID <= '$dia28' ORDER BY cotizaciones.id DESC";
$web27 = mysqli_query($DKKadmin, $query_web27) or die(mysqli_error($DKKadmin));
$row_web27 = mysqli_fetch_assoc($web27);
$totalRows_web27 = mysqli_num_rows($web27);

$query_web28 = "SELECT * FROM cotizaciones WHERE cotizaciones.fechaID >= '$dia28' AND cotizaciones.fechaID <= '$dia29' ORDER BY cotizaciones.id DESC";
$web28 = mysqli_query($DKKadmin, $query_web28) or die(mysqli_error($DKKadmin));
$row_web28 = mysqli_fetch_assoc($web28);
$totalRows_web28 = mysqli_num_rows($web28);

$query_web29 = "SELECT * FROM cotizaciones WHERE cotizaciones.fechaID >= '$dia29' AND cotizaciones.fechaID <= '$dia30' ORDER BY cotizaciones.id DESC";
$web29 = mysqli_query($DKKadmin, $query_web29) or die(mysqli_error($DKKadmin));
$row_web29 = mysqli_fetch_assoc($web29);
$totalRows_web29 = mysqli_num_rows($web29);

$query_web30 = "SELECT * FROM cotizaciones WHERE cotizaciones.fechaID >= '$dia30' AND cotizaciones.fechaID <= '$dia31' ORDER BY cotizaciones.id DESC";
$web30 = mysqli_query($DKKadmin, $query_web30) or die(mysqli_error($DKKadmin));
$row_web30 = mysqli_fetch_assoc($web30);
$totalRows_web30 = mysqli_num_rows($web30);

$query_web31 = "SELECT * FROM cotizaciones WHERE cotizaciones.fechaID >= '$dia31' AND cotizaciones.fechaID <= '$nextMonth' ORDER BY cotizaciones.id DESC";
$web31 = mysqli_query($DKKadmin, $query_web31) or die(mysqli_error($DKKadmin));
$row_web31 = mysqli_fetch_assoc($web31dias);
$totalRows_web31 = mysqli_num_rows($web31);

$query_webTotal = "SELECT * FROM cotizaciones ORDER BY cotizaciones.id DESC";
$webTotal = mysqli_query($DKKadmin, $query_webTotal) or die(mysqli_error($DKKadmin));
$row_webTotal = mysqli_fetch_assoc($webTotal);
$totalRows_webTotal = mysqli_num_rows($webTotal);

$query_tiposCotizaciones = "SELECT * FROM cotizacionesTipos ORDER BY cotizacionesTipos.id ASC";
$tiposCotizaciones = mysqli_query($DKKadmin, $query_tiposCotizaciones) or die(mysqli_error($DKKadmin));
$row_tiposCotizaciones = mysqli_fetch_assoc($tiposCotizaciones);
$totalRows_tiposCotizaciones = mysqli_num_rows($tiposCotizaciones);

$query_tiposCotizacionesVariables = "SELECT * FROM cotizacionesTipos ORDER BY cotizacionesTipos.id ASC";
$tiposCotizacionesVariables = mysqli_query($DKKadmin, $query_tiposCotizacionesVariables) or die(mysqli_error($DKKadmin));
$row_tiposCotizacionesVariables = mysqli_fetch_assoc($tiposCotizacionesVariables);
$totalRows_tiposCotizacionesVariables = mysqli_num_rows($tiposCotizacionesVariables);

$query_tiposCotizacionesYear = "SELECT * FROM cotizacionesTipos ORDER BY cotizacionesTipos.id ASC";
$tiposCotizacionesYear = mysqli_query($DKKadmin, $query_tiposCotizacionesYear) or die(mysqli_error($DKKadmin));
$row_tiposCotizacionesYear = mysqli_fetch_assoc($tiposCotizacionesYear);
$totalRows_tiposCotizacionesYear = mysqli_num_rows($tiposCotizacionesYear);

$query_tiposCotizacionesYearVariables = "SELECT * FROM cotizacionesTipos ORDER BY cotizacionesTipos.id ASC";
$tiposCotizacionesYearVariables = mysqli_query($DKKadmin, $query_tiposCotizacionesYearVariables) or die(mysqli_error($DKKadmin));
$row_tiposCotizacionesYearVariables = mysqli_fetch_assoc($tiposCotizacionesYearVariables);
$totalRows_tiposCotizacionesYearVariables = mysqli_num_rows($tiposCotizacionesYearVariables);

$query_motivosPendiente = "SELECT * FROM cotizacionesMotivos WHERE cotizacionesMotivos.estadoCotizacion = '2' ORDER BY cotizacionesMotivos.id ASC";
$motivosPendiente = mysqli_query($DKKadmin, $query_motivosPendiente) or die(mysqli_error($DKKadmin));
$row_motivosPendiente = mysqli_fetch_assoc($motivosPendiente);
$totalRows_motivosPendiente = mysqli_num_rows($motivosPendiente);

$query_motivosCompra = "SELECT * FROM cotizacionesMotivos WHERE cotizacionesMotivos.estadoCotizacion = '3' ORDER BY cotizacionesMotivos.id ASC";
$motivosCompra = mysqli_query($DKKadmin, $query_motivosCompra) or die(mysqli_error($DKKadmin));
$row_motivosCompra = mysqli_fetch_assoc($motivosCompra);
$totalRows_motivosCompra = mysqli_num_rows($motivosCompra);

$query_motivosRechazo = "SELECT * FROM cotizacionesMotivos WHERE cotizacionesMotivos.estadoCotizacion = '4' ORDER BY cotizacionesMotivos.id ASC";
$motivosRechazo = mysqli_query($DKKadmin, $query_motivosRechazo) or die(mysqli_error($DKKadmin));
$row_motivosRechazo = mysqli_fetch_assoc($motivosRechazo);
$totalRows_motivosRechazo = mysqli_num_rows($motivosRechazo);

$query_totalPendienteMes = "SELECT SUM(qts_cotizaciones.total) FROM qts_cotizaciones WHERE qts_cotizaciones.estado = '2' AND qts_cotizaciones.fechaID >= '$mes'";
$totalPendienteMes = mysqli_query($DKKadmin, $query_totalPendienteMes) or die(mysqli_error($DKKadmin));
$row_totalPendienteMes = mysqli_fetch_assoc($totalPendienteMes);
$totalRows_totalPendienteMes = mysqli_num_rows($totalPendienteMes);

$query_totalCompraMes = "SELECT SUM(qts_cotizaciones.total) FROM qts_cotizaciones WHERE qts_cotizaciones.estado = '3' AND qts_cotizaciones.fechaID >= '$mes'";
$totalCompraMes = mysqli_query($DKKadmin, $query_totalCompraMes) or die(mysqli_error($DKKadmin));
$row_totalCompraMes = mysqli_fetch_assoc($totalCompraMes);
$totalRows_totalCompraMes = mysqli_num_rows($totalCompraMes);

$query_totalRechazoMes = "SELECT SUM(qts_cotizaciones.total) FROM qts_cotizaciones WHERE qts_cotizaciones.estado = '4' AND qts_cotizaciones.fechaID >= '$mes'";
$totalRechazoMes = mysqli_query($DKKadmin, $query_totalRechazoMes) or die(mysqli_error($DKKadmin));
$row_totalRechazoMes = mysqli_fetch_assoc($totalRechazoMes);
$totalRows_totalRechazoMes = mysqli_num_rows($totalRechazoMes);

$query_tiposProductos = "SELECT * FROM cotizacionesTipos ORDER BY cotizacionesTipos.id ASC";
$tiposProductos = mysqli_query($DKKadmin, $query_tiposProductos) or die(mysqli_error($DKKadmin));
$row_tiposProductos = mysqli_fetch_assoc($tiposProductos);
$totalRows_tiposProductos = mysqli_num_rows($tiposProductos);

$query_listaProductos = "SELECT * FROM productos ORDER BY productos.visitas DESC";
$listaProductos = mysqli_query($DKKadmin, $query_listaProductos) or die(mysqli_error($DKKadmin));
$row_listaProductos = mysqli_fetch_assoc($listaProductos);
$totalRows_listaProductos = mysqli_num_rows($listaProductos);
?>
<!DOCTYPE html>
<!--[if IE 9]>         <html class="ie9 no-focus" lang="es"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-focus" lang="es"><!-- InstanceBegin template="/Templates/adminClean.dwt.php" codeOutsideHTMLIsLocked="false" --> <!--<![endif]-->
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
		<style>
		@media all {
		   div.saltopagina{
			  display: none;
		   }
		}

		@media print{
		   div.saltopagina{
			  display:block;
			  page-break-before:always;
		   }
		}
		</style>
		<!-- InstanceEndEditable -->
    <!-- END estilos -->
    </head>
    <body>
        <!-- contenido -->
        <div id="page-container">
            <!-- main -->
            <main id="main-container">
                <!-- contenido -->
                <!-- InstanceBeginEditable name="contenido" -->
                <!-- header -->
                <div class="content bg-gray-lighter">
                    <div class="row items-push">
                        <div class="col-sm-7">
                            <h1 class="page-heading">
                                Reporte Mensual <?php echo $mesActual." del ".date('Y'); ?> <small>Estos son los n&uacute;meros del mes de <?php echo $mesActual." del ".date('Y'); ?></small>
                            </h1>
                        </div>
                        <div class="col-sm-5 text-right hidden-xs">
                            <ul class="block-options">
                                <li>
                                    <button type="button" onclick="App.initHelper('print-page');"><i class="fa fa-file-pdf-o"></i> Guardar PDF</button>
                                </li>
                                <li>
                                    <button type="button" onClick="window.location.reload();"><i class="si si-refresh"></i></button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- END header -->
				<div class="content content-narrow">
					<p>N&uacute;meros de cotizaciones seg&uacute;n estado del mes de <?php echo $mesActual." del ".date('Y'); ?></p>
                    <!-- status -->
                    <div class="row text-uppercase">
                        <div class="col-xs-6 col-sm-3">
                            <div class="block block-rounded">
                                <div class="block-content block-content-full">
                                    <div class="font-s12 font-w700">Cotizaciones Ingresadas</div>
                                    <a class="h2 font-w300 text-primary"><?php echo $totalRows_cotizacionesIngresadasMes; ?></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-3">
                            <div class="block block-rounded">
                                <div class="block-content block-content-full">
                                    <div class="font-s12 font-w700">Cotizaciones Cotizadas</div>
                                    <a class="h2 font-w300 text-primary"><?php echo $totalRows_cotizacionesCotizadasMes; ?></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-3">
                            <div class="block block-rounded">
                                <div class="block-content block-content-full">
                                    <div class="font-s12 font-w700">Cotizaciones Aprobadas</div>
                                    <a class="h2 font-w300 text-success"><?php echo $totalRows_cotizacionesAprobadasMes; ?></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-3">
                            <div class="block block-rounded">
                                <div class="block-content block-content-full">
                                    <div class="font-s12 font-w700">Cotizaciones Rechazadas</div>
                                    <a class="h2 font-w300 text-danger"><?php echo $totalRows_cotizacionesRechazadasMes; ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END status -->
					<div class="saltopagina"></div>
					<p>Gr&aacute;fico <?php echo date('Y'); ?> de variación mensual. Las <strong>cotizaciones ingresadas</strong> son exclusivamente las recibidas mediante formulario de cotizaci&oacute;n web. Las <strong>cotizaciones cotizadas</strong> son todas las que han sido atendidas, incluyendo las recibidas mediante <strong>formulario de cotizaci&oacute;n, formulario de contacto y contactos v&iacute;a whatsapp</strong>. </p>
                    <!-- graficos -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="block block-rounded block-opt-refresh-icon8">
                                <div class="block-header">
                                    <h3 class="block-title">Ingresadas vs Cotizadas</h3>
                                </div>
                                <div class="block-content block-content-full text-center">
                                    <canvas class="js-chartjs2-bars" style="width: 100%;"></canvas>
                                </div>                                
                            </div>
                        </div>
						<div class="col-md-12">
							<hr>
						</div>
						<div class="saltopagina"></div>
                        <div class="col-md-12">
							<p>Gr&aacute;ficos de Rendimiento <?php echo $mesActual." del ".date('Y'); ?> de variación diario indicando la cantidad de cotizaciones recibidas y los contactos v&iacute;a whatsapp. </p>
						</div>
                        <div class="col-md-6">
                            <div class="block block-rounded block-opt-refresh-icon8">
                                <div class="block-header">
                                    <h3 class="block-title">Web</h3>
                                </div>
                                <div class="block-content block-content-full text-center">
                                    <canvas class="js-chartjs2-bars-web" style="width: 100%; height: 400px;"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="block block-rounded block-opt-refresh-icon8">
                                <div class="block-header">
                                    <h3 class="block-title">WhatsApp</h3>
                                </div>
                                <div class="block-content block-content-full text-center">
                                    <canvas class="js-chartjs2-bars-whatsapp" style="width: 100%;"></canvas>
                                </div>
                            </div>
                        </div>
						<div class="col-md-12">
							<hr>
						</div>
						<div class="saltopagina"></div>
                        <div class="col-md-12">
							<p>Gr&aacute;fico de Rendimiento <?php echo $mesActual." del ".date('Y'); ?> indicando la cantidad de productos cotizados seg&uacute;n categor&iacute;as de clasificaci&oacute;n interna. </p>
						</div>
                        <div class="col-md-12">
                            <div class="block block-rounded block-opt-refresh-icon8">
                                <div class="block-header">
                                    <h3 class="block-title">Tipos de Productos</h3>
                                </div>
                                <div class="block-content block-content-full text-center">
                                    <canvas class="js-chartjs2-bars-tipos" style="width: 100%;"></canvas>
                                </div>                                
                            </div>
                        </div>
						<div class="col-md-12">
							<hr>
						</div>
						<div class="saltopagina"></div>
                        <div class="col-md-8">
							<p>Gr&aacute;fico de cotizaciones aprobadas, rechazadas y pendientes de cada mes del a&ntilde;o <?php echo date('Y'); ?>. </p>
                            <div class="block block-rounded block-opt-refresh-icon8">
                                <div class="block-header">
                                    <h3 class="block-title">Aprobadas / Rechazadas / Pendientes</h3>
                                </div>
                                <div class="block-content block-content-full text-center">
                                    <canvas class="js-chartjs2-bars-aprobadas-rechazadas" style="width: 100%;"></canvas>
                                </div>
                            </div>
							<hr>
							<p>De todas las cotizaciones enviadas y respondidas por el cliente se obtienen las razones de rechazo, aprobaci&oacute;n o pendiente. </p>
							<div class="block block-rounded block-opt-refresh-icon8">
                                <div class="block-header">
                                    <h3 class="block-title">Motivos de Rechazo</h3>
                                </div>
                                <div class="block-content">
                                    <table class="table table-bordered table-striped" id="indextable">
                                        <thead>
                                            <tr>
                                                <th class="text-left"><a href="javascript:SortTable(0,'T');">Motivo</a></th>
                                                <th class="text-right"><a href="javascript:SortTable(1,'N');">Total</a></th>
                                            </tr>
                                        </thead>
                                        <tbody>
											<?php do { 
											$idMotivo = $row_motivosRechazo["id"];
											$seleccionaMotivos = mysqli_query($DKKadmin, "SELECT * FROM qts_cotizaciones WHERE qts_cotizaciones.motivo = '$idMotivo' AND qts_cotizaciones.fechaID >= '$mes' ORDER BY qts_cotizaciones.id ASC"); { ?>
											<tr>
												<td class="text-left"><?php echo $row_motivosRechazo["motivo"]; ?></td>
												<td class="text-right"><?php echo mysqli_num_rows($seleccionaMotivos); ?></td>
											</tr>
											<?php } } while ($row_motivosRechazo = mysqli_fetch_assoc($motivosRechazo)); ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
							<div class="block block-rounded block-opt-refresh-icon8">
                                <div class="block-header">
                                    <h3 class="block-title">Motivos de la Compra</h3>
                                </div>
                                <div class="block-content">
                                    <table class="table table-bordered table-striped" id="indextable">
                                        <thead>
                                            <tr>
                                                <th class="text-left"><a href="javascript:SortTable(2,'T');">Motivo</a></th>
                                                <th class="text-right"><a href="javascript:SortTable(3,'N');">Total</a></th>
                                            </tr>
                                        </thead>
                                        <tbody>
											<?php do { 
											$idMotivo = $row_motivosCompra["id"];
											$seleccionaMotivos = mysqli_query($DKKadmin, "SELECT * FROM qts_cotizaciones WHERE qts_cotizaciones.motivo = '$idMotivo' AND qts_cotizaciones.fechaID >= '$mes' ORDER BY qts_cotizaciones.id ASC"); { ?>
											<tr>
												<td class="text-left"><?php echo $row_motivosCompra["motivo"]; ?></td>
												<td class="text-right"><?php echo mysqli_num_rows($seleccionaMotivos); ?></td>
											</tr>
											<?php } } while ($row_motivosCompra = mysqli_fetch_assoc($motivosCompra)); ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
							<div class="block block-rounded block-opt-refresh-icon8">
                                <div class="block-header">
                                    <h3 class="block-title">Motivos del Pendiente</h3>
                                </div>
                                <div class="block-content">
                                    <table class="table table-bordered table-striped" id="indextable2">
                                        <thead>
                                            <tr>
                                                <th class="text-left"><a href="javascript:SortTable(4,'T');">Motivo</a></th>
                                                <th class="text-right"><a href="javascript:SortTable(5,'N');">Total</a></th>
                                            </tr>
                                        </thead>
                                        <tbody>
											<?php do { 
											$idMotivo = $row_motivosPendiente["id"];
											$seleccionaMotivos = mysqli_query($DKKadmin, "SELECT * FROM qts_cotizaciones WHERE qts_cotizaciones.motivo = '$idMotivo' AND qts_cotizaciones.fechaID >= '$mes' ORDER BY qts_cotizaciones.id ASC"); { ?>
											<tr>
												<td class="text-left"><?php echo $row_motivosPendiente["motivo"]; ?></td>
												<td class="text-right"><?php echo mysqli_num_rows($seleccionaMotivos); ?></td>
											</tr>
											<?php } } while ($row_motivosPendiente = mysqli_fetch_assoc($motivosPendiente)); ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
							<hr>
							<p>Todo nuestro cat&aacute;logo de productos indicando la cantidad de cotizaciones recibidas en cada uno de ellos.</p>
							<div class="block block-rounded block-opt-refresh-icon8">
                                <div class="block-header">
                                    <h3 class="block-title">Cotizaciones x Productos</h3>
                                </div>
                                <div class="block-content">
                                    <table class="table table-bordered table-striped" id="indextable3">
                                        <thead>
                                            <tr>
                                                <th class="text-left"><a href="javascript:SortTable(6,'T');">Producto</a></th>
                                                <th class="text-right"><a href="javascript:SortTable(7,'N');">Cotizaciones</a></th>
                                            </tr>
                                        </thead>
                                        <tbody>
											<?php do { ?>
											  <tr>
												<td class="text-left"><?php echo $row_listaProductos["nombre"]; ?></td>
												<td class="text-right"><?php 
													$seoProducto = $row_listaProductos["nombreSEO"];
													$r = mysqli_query($DKKadmin, "SELECT * FROM cotizaciones WHERE cotizaciones.productoSEO = '$seoProducto'");
													$f = mysqli_num_rows($r);
													echo $f;
													?></td>
											</tr>
											<?php } while ($row_listaProductos = mysqli_fetch_assoc($listaProductos)); ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
							<p>Cotizaciones aprobadas, rechazadas y pendientes del mes de <?php echo $mesActual; ?>. </p>
                            <div class="block block-rounded block-opt-refresh-icon8">
                                <div class="block-header">
                                    <h3 class="block-title">Totales</h3>
                                </div>
                                <div class="block-content block-content-full text-center">
                                    <canvas class="js-chartjs2-pie"></canvas>
                                </div>
                            </div>
							<hr>
							<p>Cotizaciones recibidas por cada tipo de producto durante el mes de <?php echo $mesActual; ?>. </p>
                            <div class="block">
                                <div class="block-header">
                                    <h3 class="block-title">Tipos</h3>
                                </div>
                                <div class="block-content block-content-full text-center">
                                    <canvas class="js-chartjs2-radar-tipos-year"></canvas>
                                </div>
                            </div>
							<hr>
							<p>Totales ($) en cada uno de los estados de las cotizaciones enviadas. </p>
							<div class="block">
								<div class="block-content block-content-full clearfix">
                                    <div class="pull-right push-15-t push-15">
                                        <i class="fa fa-check fa-2x text-success"></i>
                                    </div>
                                    <div class="h2 text-success"><?php echo "$ ".number_format($row_totalCompraMes['SUM(qts_cotizaciones.total)'],'0',',','.'); ?></div>
                                    <div class="text-uppercase font-w600 font-s12 text-muted">Aprobados</div>
                                </div>
                            </div>
							<div class="block">
								<div class="block-content block-content-full clearfix">
                                    <div class="pull-right push-15-t push-15">
                                        <i class="fa fa-times fa-2x text-danger"></i>
                                    </div>
                                    <div class="h2 text-danger"><?php echo "$ ".number_format($row_totalRechazoMes['SUM(qts_cotizaciones.total)'],'0',',','.'); ?></div>
                                    <div class="text-uppercase font-w600 font-s12 text-muted">Rechazados</div>
                                </div>
                            </div>
							<div class="block">
								<div class="block-content block-content-full clearfix">
                                    <div class="pull-right push-15-t push-15">
                                        <i class="fa fa-asterisk fa-2x text-warning"></i>
                                    </div>
									<div class="h2 text-warning"><?php echo "$ ".number_format($row_totalPendienteMes['SUM(qts_cotizaciones.total)'],'0',',','.'); ?></div>
                                    <div class="text-uppercase font-w600 font-s12 text-muted">Pendientes</div>
                                </div>
                            </div>
							<hr>
							<p>Totales ($) en cada uno de los tipos de productos de las cotizaciones enviadas durante <?php echo $mesActual." del ".date('Y'); ?>. </p>
							<div class="block block-rounded block-opt-refresh-icon8">
                                <div class="block-header">
                                    <h3 class="block-title">Totales por Tipos</h3>
                                </div>
                                <div class="block-content">
                                    <table class="table table-bordered table-striped" id="indextable4">
                                        <thead>
                                            <tr>
                                                <th class="text-left"><a href="javascript:SortTable(8,'T');">Tipo Producto</a></th>
                                                <th class="text-right"><a href="javascript:SortTable(9,'N');">Total</a></th>
                                            </tr>
                                        </thead>
                                        <tbody>
											<?php do { ?>
											  <tr>
												<td class="text-left"><?php echo $row_tiposProductos["tipo"]; ?></td>
												<td class="text-right"><?php 
													$idTipoProducto = $row_tiposProductos["id"];
													$r = mysqli_query($DKKadmin, "SELECT SUM(qts_cotizaciones.total) AS suma FROM qts_cotizaciones WHERE qts_cotizaciones.tipo = '$idTipoProducto' AND qts_cotizaciones.fechaID >= '$mes'");
													$f = mysqli_fetch_assoc($r);
													echo "$ ".number_format($f["suma"],'0',',','.');
													?></td>
											</tr>
											<?php } while ($row_tiposProductos = mysqli_fetch_assoc($tiposProductos)); ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END graficos -->
				</div>
			
				<!-- InstanceEndEditable -->
                <!-- END contenido -->
            </main>
            <!-- END main -->

            <!-- footer -->
            <footer id="page-footer" class="content-mini content-mini-full font-s12 bg-gray-lighter clearfix">
                <div class="pull-right">
                    Hecho con el <i class="fa fa-heart text-city"></i> por <a class="font-w600">DKK.CO</a>
                </div>
                <div class="pull-left">
                    <a class="font-w600">Origen 3.5</a> &copy; <span><?php echo date("Y"); ?></span>
                </div>
            </footer>
            <!-- END footer -->
        </div>
        <!-- END contenido -->
    
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
        <script src="js/plugins/chartjsv2/Chart.min.js"></script>
        <script>
		var BaseCompChartJSv2 = function() {
			// Chart.js v2 Charts, for more examples you can check out http://www.chartjs.org/docs
			var initChartsChartJSv2 = function () {
				// Set Global Chart.js configuration
				Chart.defaults.global.defaultFontColor              = '#999';
				Chart.defaults.global.defaultFontFamily             = 'Open Sans';
				Chart.defaults.global.defaultFontStyle              = '600';
				Chart.defaults.scale.gridLines.color               = "rgba(0,0,0,.05)";
				Chart.defaults.scale.gridLines.zeroLineColor       = "rgba(0,0,0,.1)";
				Chart.defaults.global.elements.line.borderWidth     = 2;
				Chart.defaults.global.elements.point.radius         = 4;
				Chart.defaults.global.elements.point.hoverRadius    = 6;
				Chart.defaults.global.tooltips.titleFontFamily      = 'Source Sans Pro';
				Chart.defaults.global.tooltips.bodyFontFamily       = 'Open Sans';
				Chart.defaults.global.tooltips.cornerRadius         = 3;
				Chart.defaults.global.legend.labels.boxWidth        = 15;
				// Get Chart Containers
				var $chart2LinesCon  = jQuery('.js-chartjs2-lines');
				var $chart2BarsCon   = jQuery('.js-chartjs2-bars');
				var $chart2RadarCon  = jQuery('.js-chartjs2-radar');
				var $chart2LinesConWhatsApp  = jQuery('.js-chartjs2-lines-whatsapp');
				var $chart2BarsConWhatsApp   = jQuery('.js-chartjs2-bars-whatsapp');
				var $chart2RadarConWhatsApp  = jQuery('.js-chartjs2-radar-whatsapp');
				var $chart2LinesConWeb  = jQuery('.js-chartjs2-lines-web');
				var $chart2BarsConWeb   = jQuery('.js-chartjs2-bars-web');
				var $chart2RadarConWeb  = jQuery('.js-chartjs2-radar-web');
				var $chart2LinesConTipos  = jQuery('.js-chartjs2-lines-tipos');
				var $chart2BarsConTipos   = jQuery('.js-chartjs2-bars-tipos');
				var $chart2RadarConTipos  = jQuery('.js-chartjs2-radar-tipos');
				var $chart2LinesConAprobadasRechazadas  = jQuery('.js-chartjs2-lines-aprobadas-rechazadas');
				var $chart2BarsConAprobadasRechazadas   = jQuery('.js-chartjs2-bars-aprobadas-rechazadas');
				var $chart2RadarConAprobadasRechazadas  = jQuery('.js-chartjs2-radar-aprobadas-rechazadas');
				var $chart2LinesConTiposYear  = jQuery('.js-chartjs2-lines-tipos-year');
				var $chart2BarsConTiposYear   = jQuery('.js-chartjs2-bars-tipos-year');
				var $chart2RadarConTiposYear  = jQuery('.js-chartjs2-radar-tipos-year');
				var $chart2PolarCon  = jQuery('.js-chartjs2-polar');
				var $chart2PieCon    = jQuery('.js-chartjs2-pie');
				var $chart2DonutCon  = jQuery('.js-chartjs2-donut');
				// Set Chart and Chart Data variables
				var $chart2Lines, $chart2Bars, $chart2Radar, $chart2LinesWhatsApp, $chart2BarsWhatsApp, $chart2RadarWhatsApp, $chart2LinesWeb, $chart2BarsWeb, $chart2RadarWeb, $chart2LinesTipos, $chart2BarsTipos, $chart2RadarTipos, $chart2LinesAprobadasRechazadas, $chart2BarsAprobadasRechazadas, $chart2RadarAprobadasRechazadas, $chart2LinesTiposYear, $chart2BarsTiposYear, $chart2RadarTiposYear, $chart2Polar, $chart2Pie, $chart2Donut;
				var $chart2LinesBarsRadarData, $chart2LinesBarsRadarDataWhatsApp, $chart2PolarPieDonutData;

				// cotizaciones ingresadas vs cotizadas
				var $chart2LinesBarsRadarData = {
					labels: ['ENE', 'FEB', 'MAR', 'ABR', 'MAY', 'JUN', 'JUL', 'AGO', 'SEPT', 'OCT', 'NOV', 'DIC'],
					datasets: [
						{
							label: 'Ingresadas',
							fill: true,
							backgroundColor: 'rgba(220,220,220,.3)',
							borderColor: 'rgba(220,220,220,1)',
							pointBackgroundColor: 'rgba(220,220,220,1)',
							pointBorderColor: '#fff',
							pointHoverBackgroundColor: '#fff',
							pointHoverBorderColor: 'rgba(220,220,220,1)',
							data: [<?php echo $totalRows_cotizacionesIngresadasEnero.", ".$totalRows_cotizacionesIngresadasFebrero.", ".$totalRows_cotizacionesIngresadasMarzo.", ".$totalRows_cotizacionesIngresadasAbril.", ".$totalRows_cotizacionesIngresadasMayo.", ".$totalRows_cotizacionesIngresadasJunio.", ".$totalRows_cotizacionesIngresadasJulio.", ".$totalRows_cotizacionesIngresadasAgosto.", ".$totalRows_cotizacionesIngresadasSeptiembre.", ".$totalRows_cotizacionesIngresadasOctubre.", ".$totalRows_cotizacionesIngresadasNoviembre.", ".$totalRows_cotizacionesIngresadasDiciembre ?>]
						},
						{
							label: 'Cotizadas',
							fill: true,
							backgroundColor: 'rgba(171, 227, 125, .3)',
							borderColor: 'rgba(171, 227, 125, 1)',
							pointBackgroundColor: 'rgba(171, 227, 125, 1)',
							pointBorderColor: '#fff',
							pointHoverBackgroundColor: '#fff',
							pointHoverBorderColor: 'rgba(171, 227, 125, 1)',
							data: [<?php echo $totalRows_cotizacionesCotizadasEnero.", ".$totalRows_cotizacionesCotizadasFebrero.", ".$totalRows_cotizacionesCotizadasMarzo.", ".$totalRows_cotizacionesCotizadasAbril.", ".$totalRows_cotizacionesCotizadasMayo.", ".$totalRows_cotizacionesCotizadasJunio.", ".$totalRows_cotizacionesCotizadasJulio.", ".$totalRows_cotizacionesCotizadasAgosto.", ".$totalRows_cotizacionesCotizadasSeptiembre.", ".$totalRows_cotizacionesCotizadasOctubre.", ".$totalRows_cotizacionesCotizadasNoviembre.", ".$totalRows_cotizacionesCotizadasDiciembre ?>]
						}
					]
				};

				// whatsapp
				var $chart2LinesBarsRadarDataWhatsApp = {
					labels: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31' ],
					datasets: [
						{
							label: 'WhatsApp',
							fill: true,
							backgroundColor: 'rgba(37, 211, 102,.3)',
							borderColor: 'rgba(37, 211, 102,1)',
							pointBackgroundColor: 'rgba(37, 211, 102,1)',
							pointBorderColor: '#fff',
							pointHoverBackgroundColor: '#fff',
							pointHoverBorderColor: 'rgba(37, 211, 102,1)',
							data: [<?php echo $totalRows_whatsapp1.", ".$totalRows_whatsapp2.", ".$totalRows_whatsapp3.", ".$totalRows_whatsapp4.", ".$totalRows_whatsapp5.", ".$totalRows_whatsapp6.", ".$totalRows_whatsapp7.", ".$totalRows_whatsapp8.", ".$totalRows_whatsapp9.", ".$totalRows_whatsapp10.", ".$totalRows_whatsapp11.", ".$totalRows_whatsapp12.", ".$totalRows_whatsapp13.", ".$totalRows_whatsapp14.", ".$totalRows_whatsapp15.", ".$totalRows_whatsapp16.", ".$totalRows_whatsapp17.", ".$totalRows_whatsapp18.", ".$totalRows_whatsapp19.", ".$totalRows_whatsapp20.", ".$totalRows_whatsapp21.", ".$totalRows_whatsapp22.", ".$totalRows_whatsapp23.", ".$totalRows_whatsapp24.", ".$totalRows_whatsapp25.", ".$totalRows_whatsapp26.", ".$totalRows_whatsapp27.", ".$totalRows_whatsapp28.", ".$totalRows_whatsapp29.", ".$totalRows_whatsapp30.", ".$totalRows_whatsapp31 ?>]
						}
					]
				};

				// web
				var $chart2LinesBarsRadarDataWeb = {
					labels: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31' ],
					datasets: [
						{
							label: 'Web',
							fill: true,
							backgroundColor: 'rgba(117, 176, 235,.3)',
							borderColor: 'rgba(117, 176, 235,1)',
							pointBackgroundColor: 'rgba(117, 176, 235,1)',
							pointBorderColor: '#fff',
							pointHoverBackgroundColor: '#fff',
							pointHoverBorderColor: 'rgba(117, 176, 235,1)',
							data: [<?php echo $totalRows_web1.", ".$totalRows_web2.", ".$totalRows_web3.", ".$totalRows_web4.", ".$totalRows_web5.", ".$totalRows_web6.", ".$totalRows_web7.", ".$totalRows_web8.", ".$totalRows_web9.", ".$totalRows_web10.", ".$totalRows_web11.", ".$totalRows_web12.", ".$totalRows_web13.", ".$totalRows_web14.", ".$totalRows_web15.", ".$totalRows_web16.", ".$totalRows_web17.", ".$totalRows_web18.", ".$totalRows_web19.", ".$totalRows_web20.", ".$totalRows_web21.", ".$totalRows_web22.", ".$totalRows_web23.", ".$totalRows_web24.", ".$totalRows_web25.", ".$totalRows_web26.", ".$totalRows_web27.", ".$totalRows_web28.", ".$totalRows_web29.", ".$totalRows_web30.", ".$totalRows_web31 ?>]
						}
					]
				};

				// tipos de cotizaciones
				var $chart2LinesBarsRadarDataTipos = {
					labels: [<?php do { echo "'".$row_tiposCotizaciones["tipoSEO"]."', "; } while ($row_tiposCotizaciones = mysqli_fetch_assoc($tiposCotizaciones)); ?>],
					datasets: [
						{
							label: 'Tipos de Productos',
							fill: true,
							backgroundColor: 'rgba(255, 102, 0,.3)',
							borderColor: 'rgba(255, 102, 0,1)',
							pointBackgroundColor: 'rgba(255, 102, 0,1)',
							pointBorderColor: '#fff',
							pointHoverBackgroundColor: '#fff',
							pointHoverBorderColor: 'rgba(255, 102, 0,1)',
							data: [<?php do {
								$idTipo = $row_tiposCotizacionesVariables["id"];
								$seleccionaCotizaciones = mysqli_query($DKKadmin, "SELECT * FROM cotizaciones WHERE cotizaciones.tipo = '$idTipo' AND cotizaciones.fechaID >= '$mes' ORDER BY cotizaciones.id ASC"); {
									echo mysqli_num_rows($seleccionaCotizaciones).", ";
								}
							} while ($row_tiposCotizacionesVariables = mysqli_fetch_assoc($tiposCotizacionesVariables)); ?>]
						}
					]
				};

				// cotizaciones aprobadas vs rechazadas mes y mes pasado
				var $chart2LinesBarsRadarDataAprobadasRechazadas = {
					labels: ['ENE', 'FEB', 'MAR', 'ABR', 'MAY', 'JUN', 'JUL', 'AGO', 'SEPT', 'OCT', 'NOV', 'DIC'],
					datasets: [
						{
							label: 'Aprobadas',
							fill: true,
							backgroundColor: 'rgba(51, 153, 102,.3)',
							borderColor: 'rgba(51, 153, 102,1)',
							pointBackgroundColor: 'rgba(51, 153, 102,1)',
							pointBorderColor: '#fff',
							pointHoverBackgroundColor: '#fff',
							pointHoverBorderColor: 'rgba(51, 153, 102,1)',
							data: [<?php echo $totalRows_cotizacionesAprobadasEnero.", ".$totalRows_cotizacionesAprobadasFebrero.", ".$totalRows_cotizacionesAprobadasMarzo.", ".$totalRows_cotizacionesAprobadasAbril.", ".$totalRows_cotizacionesAprobadasMayo.", ".$totalRows_cotizacionesAprobadasJunio.", ".$totalRows_cotizacionesAprobadasJulio.", ".$totalRows_cotizacionesAprobadasAgosto.", ".$totalRows_cotizacionesAprobadasSeptiembre.", ".$totalRows_cotizacionesAprobadasOctubre.", ".$totalRows_cotizacionesAprobadasNoviembre.", ".$totalRows_cotizacionesAprobadasDiciembre; ?>]
						},
						{
							label: 'Rechazadas',
							fill: true,
							backgroundColor: 'rgba(220, 20, 60, .3)',
							borderColor: 'rgba(220, 20, 60, 1)',
							pointBackgroundColor: 'rgba(220, 20, 60, 1)',
							pointBorderColor: '#fff',
							pointHoverBackgroundColor: '#fff',
							pointHoverBorderColor: 'rgba(220, 20, 60, 1)',
							data: [<?php echo $totalRows_cotizacionesRechazadasEnero.", ".$totalRows_cotizacionesRechazadasFebrero.", ".$totalRows_cotizacionesRechazadasMarzo.", ".$totalRows_cotizacionesRechazadasAbril.", ".$totalRows_cotizacionesRechazadasMayo.", ".$totalRows_cotizacionesRechazadasJunio.", ".$totalRows_cotizacionesRechazadasJulio.", ".$totalRows_cotizacionesRechazadasAgosto.", ".$totalRows_cotizacionesRechazadasSeptiembre.", ".$totalRows_cotizacionesRechazadasOctubre.", ".$totalRows_cotizacionesRechazadasNoviembre.", ".$totalRows_cotizacionesRechazadasDiciembre; ?>]
						},
						{
							label: 'Pendientes',
							fill: true,
							backgroundColor: 'rgba(255, 165, 0, .3)',
							borderColor: 'rgba(255, 165, 0, 1)',
							pointBackgroundColor: 'rgba(255, 165, 0, 1)',
							pointBorderColor: '#fff',
							pointHoverBackgroundColor: '#fff',
							pointHoverBorderColor: 'rgba(255, 165, 0, 1)',
							data: [<?php echo $totalRows_cotizacionesPendientesEnero.", ".$totalRows_cotizacionesPendientesFebrero.", ".$totalRows_cotizacionesPendientesMarzo.", ".$totalRows_cotizacionesPendientesAbril.", ".$totalRows_cotizacionesPendientesMayo.", ".$totalRows_cotizacionesPendientesJunio.", ".$totalRows_cotizacionesPendientesJulio.", ".$totalRows_cotizacionesPendientesAgosto.", ".$totalRows_cotizacionesPendientesSeptiembre.", ".$totalRows_cotizacionesPendientesOctubre.", ".$totalRows_cotizacionesPendientesNoviembre.", ".$totalRows_cotizacionesPendientesDiciembre; ?>]
						}
					]
				};

				// tipos de cotizaciones year
				var $chart2LinesBarsRadarDataTiposYear = {
					labels: [<?php do { echo "'".$row_tiposCotizacionesYear["tipoSEO"]."', "; } while ($row_tiposCotizacionesYear = mysqli_fetch_assoc($tiposCotizacionesYear)); ?>],
					datasets: [
						{
							label: 'Tipos de Productos',
							fill: true,
							backgroundColor: 'rgba(220,220,220,.3)',
							borderColor: 'rgba(220,220,220,1)',
							pointBackgroundColor: 'rgba(220,220,220,1)',
							pointBorderColor: '#fff',
							pointHoverBackgroundColor: '#fff',
							pointHoverBorderColor: 'rgba(220,220,220,1)',
							data: [<?php do {
								$idTipo = $row_tiposCotizacionesYearVariables["id"];
								$seleccionaCotizacionesYear = mysqli_query($DKKadmin, "SELECT * FROM cotizaciones WHERE cotizaciones.tipo = '$idTipo' AND cotizaciones.fechaID >= '$enero' ORDER BY cotizaciones.id ASC"); {
									echo mysqli_num_rows($seleccionaCotizacionesYear).", ";
								}
							} while ($row_tiposCotizacionesYearVariables = mysqli_fetch_assoc($tiposCotizacionesYearVariables)); ?>]
						}
					]
				};

				// totales mensuales
				var $chart2PolarPieDonutData = {
					labels: [
						'Aprobadas',
						'Rechazadas',
						'Pendientes'
					],
					datasets: [{
						data: [
							<?php echo $totalRows_cotizacionesAprobadasMes; ?>,
							<?php echo $totalRows_cotizacionesRechazadasMes; ?>,
							<?php echo $totalRows_cotizacionesPendientesMes; ?>
						],
						backgroundColor: [
							'rgba(171, 227, 125, 1)',
							'rgba(220, 20, 60, 1)',
							'rgba(255, 165, 0, 1)'
						],
						hoverBackgroundColor: [
							'rgba(171, 227, 125, .75)',
							'rgba(220, 20, 60, .75)',
							'rgba(255, 165, 0, .75)'
						],
						borderWidth: [
							0,
							0,
							0
						]
					}]
				};

				// Init Charts
				$chart2Lines = new Chart($chart2LinesCon, { type: 'line', data: $chart2LinesBarsRadarData });
				$chart2Bars  = new Chart($chart2BarsCon, { type: 'bar', data: $chart2LinesBarsRadarData });
				$chart2Radar = new Chart($chart2RadarCon, { type: 'radar', data: $chart2LinesBarsRadarData });
				$chart2LinesWhatsApp = new Chart($chart2LinesConWhatsApp, { type: 'line', data: $chart2LinesBarsRadarDataWhatsApp });
				$chart2BarsWhatsApp  = new Chart($chart2BarsConWhatsApp, { type: 'bar', data: $chart2LinesBarsRadarDataWhatsApp });
				$chart2RadarWhatsApp = new Chart($chart2RadarConWhatsApp, { type: 'radar', data: $chart2LinesBarsRadarDataWhatsApp });
				$chart2LinesWeb = new Chart($chart2LinesConWeb, { type: 'line', data: $chart2LinesBarsRadarDataWeb });
				$chart2BarsWeb  = new Chart($chart2BarsConWeb, { type: 'bar', data: $chart2LinesBarsRadarDataWeb });
				$chart2RadarWeb = new Chart($chart2RadarConWeb, { type: 'radar', data: $chart2LinesBarsRadarDataWeb });
				$chart2LinesTipos = new Chart($chart2LinesConTipos, { type: 'line', data: $chart2LinesBarsRadarDataTipos });
				$chart2BarsTipos  = new Chart($chart2BarsConTipos, { type: 'bar', data: $chart2LinesBarsRadarDataTipos });
				$chart2RadarTipos = new Chart($chart2RadarConTipos, { type: 'radar', data: $chart2LinesBarsRadarDataTipos });
				$chart2LinesAprobadasRechazadas = new Chart($chart2LinesConAprobadasRechazadas, { type: 'line', data: $chart2LinesBarsRadarDataAprobadasRechazadas });
				$chart2BarsAprobadasRechazadas  = new Chart($chart2BarsConAprobadasRechazadas, { type: 'bar', data: $chart2LinesBarsRadarDataAprobadasRechazadas });
				$chart2RadarAprobadasRechazadas = new Chart($chart2RadarConAprobadasRechazadas, { type: 'radar', data: $chart2LinesBarsRadarDataAprobadasRechazadas });
				$chart2LinesTiposYear = new Chart($chart2LinesConTiposYear, { type: 'line', data: $chart2LinesBarsRadarDataTiposYear });
				$chart2BarsTiposYear  = new Chart($chart2BarsConTiposYear, { type: 'bar', data: $chart2LinesBarsRadarDataTiposYear });
				$chart2RadarTiposYear = new Chart($chart2RadarConTiposYear, { type: 'radar', data: $chart2LinesBarsRadarDataTiposYear });
				$chart2Polar = new Chart($chart2PolarCon, { type: 'polarArea', data: $chart2PolarPieDonutData });
				$chart2Pie   = new Chart($chart2PieCon, { type: 'pie', data: $chart2PolarPieDonutData });
				$chart2Donut = new Chart($chart2DonutCon, { type: 'doughnut', data: $chart2PolarPieDonutData });
			};

			return {
				init: function () {
					// Init charts
					initChartsChartJSv2();
				}
			};
		}();

		// Initialize when page loads
		jQuery(function(){ BaseCompChartJSv2.init(); });
			
        jQuery(function () {
            App.initHelpers('appear-countTo');
        });
        </script>
		<!-- InstanceEndEditable -->
</body>
<!-- InstanceEnd --></html>
<?php
mysqli_free_result($datosAdmin);

mysqli_free_result($contactosPendientes);

mysqli_free_result($cotizacionesIngresadasEnero);

mysqli_free_result($cotizacionesIngresadasFebrero);

mysqli_free_result($cotizacionesIngresadasMarzo);

mysqli_free_result($cotizacionesIngresadasAbril);

mysqli_free_result($cotizacionesIngresadasMayo);

mysqli_free_result($cotizacionesIngresadasJunio);

mysqli_free_result($cotizacionesIngresadasJulio);

mysqli_free_result($cotizacionesIngresadasAgosto);

mysqli_free_result($cotizacionesIngresadasSeptiembre);

mysqli_free_result($cotizacionesIngresadasOctubre);

mysqli_free_result($cotizacionesIngresadasNoviembre);

mysqli_free_result($cotizacionesIngresadasDiciembre);

mysqli_free_result($cotizacionesIngresadasMes);

mysqli_free_result($cotizacionesCotizadasEnero);

mysqli_free_result($cotizacionesCotizadasFebrero);

mysqli_free_result($cotizacionesCotizadasMarzo);

mysqli_free_result($cotizacionesCotizadasAbril);

mysqli_free_result($cotizacionesCotizadasMayo);

mysqli_free_result($cotizacionesCotizadasJunio);

mysqli_free_result($cotizacionesCotizadasJulio);

mysqli_free_result($cotizacionesCotizadasAgosto);

mysqli_free_result($cotizacionesCotizadasSeptiembre);

mysqli_free_result($cotizacionesCotizadasOctubre);

mysqli_free_result($cotizacionesCotizadasNoviembre);

mysqli_free_result($cotizacionesCotizadasDiciembre);

mysqli_free_result($cotizacionesCotizadasMes);

mysqli_free_result($cotizacionesAprobadasEnero);

mysqli_free_result($cotizacionesAprobadasFebrero);

mysqli_free_result($cotizacionesAprobadasMarzo);

mysqli_free_result($cotizacionesAprobadasAbril);

mysqli_free_result($cotizacionesAprobadasMayo);

mysqli_free_result($cotizacionesAprobadasJunio);

mysqli_free_result($cotizacionesAprobadasJulio);

mysqli_free_result($cotizacionesAprobadasAgosto);

mysqli_free_result($cotizacionesAprobadasSeptiembre);

mysqli_free_result($cotizacionesAprobadasOctubre);

mysqli_free_result($cotizacionesAprobadasNoviembre);

mysqli_free_result($cotizacionesAprobadasDiciembre);

mysqli_free_result($cotizacionesRechazadasEnero);

mysqli_free_result($cotizacionesRechazadasFebrero);

mysqli_free_result($cotizacionesRechazadasMarzo);

mysqli_free_result($cotizacionesRechazadasAbril);

mysqli_free_result($cotizacionesRechazadasMayo);

mysqli_free_result($cotizacionesRechazadasJunio);

mysqli_free_result($cotizacionesRechazadasJulio);

mysqli_free_result($cotizacionesRechazadasAgosto);

mysqli_free_result($cotizacionesRechazadasSeptiembre);

mysqli_free_result($cotizacionesRechazadasOctubre);

mysqli_free_result($cotizacionesRechazadasNoviembre);

mysqli_free_result($cotizacionesRechazadasDiciembre);

mysqli_free_result($whatsapp1);

mysqli_free_result($whatsapp2);

mysqli_free_result($whatsapp3);

mysqli_free_result($whatsapp4);

mysqli_free_result($whatsapp5);

mysqli_free_result($whatsapp6);

mysqli_free_result($whatsapp7);

mysqli_free_result($whatsapp8);

mysqli_free_result($whatsapp9);

mysqli_free_result($whatsapp10);

mysqli_free_result($whatsapp11);

mysqli_free_result($whatsapp12);

mysqli_free_result($whatsapp13);

mysqli_free_result($whatsapp14);

mysqli_free_result($whatsapp15);

mysqli_free_result($whatsapp16);

mysqli_free_result($whatsapp17);

mysqli_free_result($whatsapp18);

mysqli_free_result($whatsapp19);

mysqli_free_result($whatsapp20);

mysqli_free_result($whatsapp21);

mysqli_free_result($whatsapp22);

mysqli_free_result($whatsapp23);

mysqli_free_result($whatsapp24);

mysqli_free_result($whatsapp25);

mysqli_free_result($whatsapp26);

mysqli_free_result($whatsapp23);

mysqli_free_result($whatsapp28);

mysqli_free_result($whatsapp29);

mysqli_free_result($whatsapp30);

mysqli_free_result($whatsapp31);

mysqli_free_result($whatsappTotal);

mysqli_free_result($web1);

mysqli_free_result($web2);

mysqli_free_result($web3);

mysqli_free_result($web4);

mysqli_free_result($web5);

mysqli_free_result($web6);

mysqli_free_result($web7);

mysqli_free_result($web8);

mysqli_free_result($web9);

mysqli_free_result($web10);

mysqli_free_result($web11);

mysqli_free_result($web12);

mysqli_free_result($web13);

mysqli_free_result($web14);

mysqli_free_result($web15);

mysqli_free_result($web16);

mysqli_free_result($web17);

mysqli_free_result($web18);

mysqli_free_result($web19);

mysqli_free_result($web20);

mysqli_free_result($web21);

mysqli_free_result($web22);

mysqli_free_result($web23);

mysqli_free_result($web24);

mysqli_free_result($web25);

mysqli_free_result($web26);

mysqli_free_result($web23);

mysqli_free_result($web28);

mysqli_free_result($web29);

mysqli_free_result($web30);

mysqli_free_result($web31);

mysqli_free_result($webTotal);

mysqli_free_result($tiposCotizaciones);

mysqli_free_result($tiposCotizacionesVariables);

mysqli_free_result($tiposCotizacionesYear);

mysqli_free_result($tiposCotizacionesYearVariables);

mysqli_free_result($motivosPendiente);

mysqli_free_result($motivosCompra);

mysqli_free_result($motivosRechazo);

mysqli_free_result($totalPendienteMes);

mysqli_free_result($totalCompraMes);

mysqli_free_result($totalRechazoMes);

mysqli_free_result($tiposProductos);

mysqli_free_result($listaProductos);
?>
