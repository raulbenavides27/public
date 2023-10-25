

        <!-- Page Plugins -->
        <script src="assets/js/plugins/chartjs/Chart.min.js"></script>

        <!-- Page JS Code -->
        <script src="assets/js/pages/base_pages_dashboard_v2.js"></script>
        <script>
            jQuery(function () {
                // Init page helpers (CountTo plugin)
                App.initHelpers('appear-countTo');
            });
        </script><?php require_once('../Connections/DKKadmin.php'); ?>
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
$fecha = date('Y-m-d H:i:s');
$fechaID = strtotime($fecha);
$fechaAyer = strtotime( '-1 day' ,$fechaID);
$fecha2dias = strtotime( '-2 day' ,$fechaID);
$fecha3dias = strtotime( '-3 day' ,$fechaID);
$fecha4dias = strtotime( '-4 day' ,$fechaID);
$fecha5dias = strtotime( '-5 day' ,$fechaID);
$fecha6dias = strtotime( '-6 day' ,$fechaID);
$fecha7dias = strtotime( '-7 day' ,$fechaID);
$fecha8dias = strtotime( '-8 day' ,$fechaID);
$fecha9dias = strtotime( '-9 day' ,$fechaID);
$fecha10dias = strtotime( '-10 day' ,$fechaID);
$fecha11dias = strtotime( '-11 day' ,$fechaID);
$fecha12dias = strtotime( '-12 day' ,$fechaID);
$fecha13dias = strtotime( '-13 day' ,$fechaID);
$fecha14dias = strtotime( '-14 day' ,$fechaID);
$fecha15dias = strtotime( '-15 day' ,$fechaID);
$fecha1mes = strtotime( '-1 month' ,$fechaID);
$fecha2meses = strtotime( '-2 month' ,$fechaID);
$fecha3meses = strtotime( '-3 month' ,$fechaID);
$fecha6meses = strtotime( '-6 month' ,$fechaID);
$fechayear = strtotime( '-1 year' ,$fechaID);


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

$query_bgRandom = "SELECT * FROM imagenesBG WHERE RAND()<(SELECT ((1/COUNT(*))*15) FROM imagenesBG) AND imagenesBG.estado = '1' ORDER BY RAND() LIMIT 1";
$bgRandom = mysqli_query($DKKadmin, $query_bgRandom) or die(mysqli_error($DKKadmin));
$row_bgRandom = mysqli_fetch_assoc($bgRandom);
$totalRows_bgRandom = mysqli_num_rows($bgRandom);

$query_visitasHoy = "SELECT * FROM visitas WHERE visitas.fechaID >= '$fechaAyer' AND visitas.fechaID <= '$fechaID' ORDER BY visitas.id DESC";
$visitasHoy = mysqli_query($DKKadmin, $query_visitasHoy) or die(mysqli_error($DKKadmin));
$row_visitasHoy = mysqli_fetch_assoc($visitasHoy);
$totalRows_visitasHoy = mysqli_num_rows($visitasHoy);

$query_visitasAyer = "SELECT * FROM visitas WHERE visitas.fechaID >= '$fecha2dias' AND visitas.fechaID <= '$fechaAyer' ORDER BY visitas.id DESC";
$visitasAyer = mysqli_query($DKKadmin, $query_visitasAyer) or die(mysqli_error($DKKadmin));
$row_visitasAyer = mysqli_fetch_assoc($visitasAyer);
$totalRows_visitasAyer = mysqli_num_rows($visitasAyer);

$query_visitas2dias = "SELECT * FROM visitas WHERE visitas.fechaID >= '$fecha3dias' AND visitas.fechaID <= '$fecha2dias' ORDER BY visitas.id DESC";
$visitas2dias = mysqli_query($DKKadmin, $query_visitas2dias) or die(mysqli_error($DKKadmin));
$row_visitas2dias = mysqli_fetch_assoc($visitas2dias);
$totalRows_visitas2dias = mysqli_num_rows($visitas2dias);

$query_visitas3dias = "SELECT * FROM visitas WHERE visitas.fechaID >= '$fecha4dias' AND visitas.fechaID <= '$fecha3dias' ORDER BY visitas.id DESC";
$visitas3dias = mysqli_query($DKKadmin, $query_visitas3dias) or die(mysqli_error($DKKadmin));
$row_visitas3dias = mysqli_fetch_assoc($visitas3dias);
$totalRows_visitas3dias = mysqli_num_rows($visitas3dias);

$query_visitas4dias = "SELECT * FROM visitas WHERE visitas.fechaID >= '$fecha5dias' AND visitas.fechaID <= '$fecha4dias' ORDER BY visitas.id DESC";
$visitas4dias = mysqli_query($DKKadmin, $query_visitas4dias) or die(mysqli_error($DKKadmin));
$row_visitas4dias = mysqli_fetch_assoc($visitas4dias);
$totalRows_visitas4dias = mysqli_num_rows($visitas4dias);

$query_visitas5dias = "SELECT * FROM visitas WHERE visitas.fechaID >= '$fecha6dias' AND visitas.fechaID <= '$fecha5dias' ORDER BY visitas.id DESC";
$visitas5dias = mysqli_query($DKKadmin, $query_visitas5dias) or die(mysqli_error($DKKadmin));
$row_visitas5dias = mysqli_fetch_assoc($visitas5dias);
$totalRows_visitas5dias = mysqli_num_rows($visitas5dias);

$query_visitas6dias = "SELECT * FROM visitas WHERE visitas.fechaID >= '$fecha7dias' AND visitas.fechaID <= '$fecha6dias' ORDER BY visitas.id DESC";
$visitas6dias = mysqli_query($DKKadmin, $query_visitas6dias) or die(mysqli_error($DKKadmin));
$row_visitas6dias = mysqli_fetch_assoc($visitas6dias);
$totalRows_visitas6dias = mysqli_num_rows($visitas6dias);

$query_visitas7dias = "SELECT * FROM visitas WHERE visitas.fechaID >= '$fecha8dias' AND visitas.fechaID <= '$fecha7dias' ORDER BY visitas.id DESC";
$visitas7dias = mysqli_query($DKKadmin, $query_visitas7dias) or die(mysqli_error($DKKadmin));
$row_visitas7dias = mysqli_fetch_assoc($visitas7dias);
$totalRows_visitas7dias = mysqli_num_rows($visitas7dias);

$query_visitas8dias = "SELECT * FROM visitas WHERE visitas.fechaID >= '$fecha9dias' AND visitas.fechaID <= '$fecha8dias' ORDER BY visitas.id DESC";
$visitas8dias = mysqli_query($DKKadmin, $query_visitas8dias) or die(mysqli_error($DKKadmin));
$row_visitas8dias = mysqli_fetch_assoc($visitas8dias);
$totalRows_visitas8dias = mysqli_num_rows($visitas8dias);

$query_visitas9dias = "SELECT * FROM visitas WHERE visitas.fechaID >= '$fecha10dias' AND visitas.fechaID <= '$fecha9dias' ORDER BY visitas.id DESC";
$visitas9dias = mysqli_query($DKKadmin, $query_visitas9dias) or die(mysqli_error($DKKadmin));
$row_visitas9dias = mysqli_fetch_assoc($visitas9dias);
$totalRows_visitas9dias = mysqli_num_rows($visitas9dias);

$query_visitas10dias = "SELECT * FROM visitas WHERE visitas.fechaID >= '$fecha11dias' AND visitas.fechaID <= '$fecha10dias' ORDER BY visitas.id DESC";
$visitas10dias = mysqli_query($DKKadmin, $query_visitas10dias) or die(mysqli_error($DKKadmin));
$row_visitas10dias = mysqli_fetch_assoc($visitas103dias);
$totalRows_visitas10dias = mysqli_num_rows($visitas10dias);

$query_visitas11dias = "SELECT * FROM visitas WHERE visitas.fechaID >= '$fecha12dias' AND visitas.fechaID <= '$fecha11dias' ORDER BY visitas.id DESC";
$visitas11dias = mysqli_query($DKKadmin, $query_visitas11dias) or die(mysqli_error($DKKadmin));
$row_visitas11dias = mysqli_fetch_assoc($visitas11dias);
$totalRows_visitas11dias = mysqli_num_rows($visitas11dias);

$query_visitas12dias = "SELECT * FROM visitas WHERE visitas.fechaID >= '$fecha13dias' AND visitas.fechaID <= '$fecha12dias' ORDER BY visitas.id DESC";
$visitas12dias = mysqli_query($DKKadmin, $query_visitas12dias) or die(mysqli_error($DKKadmin));
$row_visitas12dias = mysqli_fetch_assoc($visitas12dias);
$totalRows_visitas12dias = mysqli_num_rows($visitas12dias);

$query_visitas13dias = "SELECT * FROM visitas WHERE visitas.fechaID >= '$fecha14dias' AND visitas.fechaID <= '$fecha13dias' ORDER BY visitas.id DESC";
$visitas13dias = mysqli_query($DKKadmin, $query_visitas13dias) or die(mysqli_error($DKKadmin));
$row_visitas13dias = mysqli_fetch_assoc($visitas13dias);
$totalRows_visitas13dias = mysqli_num_rows($visitas13dias);

$query_visitasTotal = "SELECT * FROM visitas ORDER BY visitas.id DESC";
$visitasTotal = mysqli_query($DKKadmin, $query_visitasTotal) or die(mysqli_error($DKKadmin));
$row_visitasTotal = mysqli_fetch_assoc($visitasTotal);
$totalRows_visitasTotal = mysqli_num_rows($visitasTotal);

$query_cotizacionesHoy = "SELECT * FROM cotizaciones WHERE cotizaciones.fechaID >= '$fechaAyer' AND cotizaciones.fechaID <= '$fechaID' ORDER BY cotizaciones.id DESC";
$cotizacionesHoy = mysqli_query($DKKadmin, $query_cotizacionesHoy) or die(mysqli_error($DKKadmin));
$row_cotizacionesHoy = mysqli_fetch_assoc($cotizacionesHoy);
$totalRows_cotizacionesHoy = mysqli_num_rows($cotizacionesHoy);

$query_cotizacionesAyer = "SELECT * FROM cotizaciones WHERE cotizaciones.fechaID >= '$fecha2dias' AND cotizaciones.fechaID <= '$fechaAyer' ORDER BY cotizaciones.id DESC";
$cotizacionesAyer = mysqli_query($DKKadmin, $query_cotizacionesAyer) or die(mysqli_error($DKKadmin));
$row_cotizacionesAyer = mysqli_fetch_assoc($cotizacionesAyer);
$totalRows_cotizacionesAyer = mysqli_num_rows($cotizacionesAyer);

$query_cotizaciones2dias = "SELECT * FROM cotizaciones WHERE cotizaciones.fechaID >= '$fecha3dias' AND cotizaciones.fechaID <= '$fecha2dias' ORDER BY cotizaciones.id DESC";
$cotizaciones2dias = mysqli_query($DKKadmin, $query_cotizaciones2dias) or die(mysqli_error($DKKadmin));
$row_cotizaciones2dias = mysqli_fetch_assoc($cotizaciones2dias);
$totalRows_cotizaciones2dias = mysqli_num_rows($cotizaciones2dias);

$query_cotizaciones3dias = "SELECT * FROM cotizaciones WHERE cotizaciones.fechaID >= '$fecha4dias' AND cotizaciones.fechaID <= '$fecha3dias' ORDER BY cotizaciones.id DESC";
$cotizaciones3dias = mysqli_query($DKKadmin, $query_cotizaciones3dias) or die(mysqli_error($DKKadmin));
$row_cotizaciones3dias = mysqli_fetch_assoc($cotizaciones3dias);
$totalRows_cotizaciones3dias = mysqli_num_rows($cotizaciones3dias);

$query_cotizaciones4dias = "SELECT * FROM cotizaciones WHERE cotizaciones.fechaID >= '$fecha5dias' AND cotizaciones.fechaID <= '$fecha4dias' ORDER BY cotizaciones.id DESC";
$cotizaciones4dias = mysqli_query($DKKadmin, $query_cotizaciones4dias) or die(mysqli_error($DKKadmin));
$row_cotizaciones4dias = mysqli_fetch_assoc($cotizaciones4dias);
$totalRows_cotizaciones4dias = mysqli_num_rows($cotizaciones4dias);

$query_cotizaciones5dias = "SELECT * FROM cotizaciones WHERE cotizaciones.fechaID >= '$fecha6dias' AND cotizaciones.fechaID <= '$fecha5dias' ORDER BY cotizaciones.id DESC";
$cotizaciones5dias = mysqli_query($DKKadmin, $query_cotizaciones5dias) or die(mysqli_error($DKKadmin));
$row_cotizaciones5dias = mysqli_fetch_assoc($cotizaciones5dias);
$totalRows_cotizaciones5dias = mysqli_num_rows($cotizaciones5dias);

$query_cotizaciones6dias = "SELECT * FROM cotizaciones WHERE cotizaciones.fechaID >= '$fecha7dias' AND cotizaciones.fechaID <= '$fecha6dias' ORDER BY cotizaciones.id DESC";
$cotizaciones6dias = mysqli_query($DKKadmin, $query_cotizaciones6dias) or die(mysqli_error($DKKadmin));
$row_cotizaciones6dias = mysqli_fetch_assoc($cotizaciones6dias);
$totalRows_cotizaciones6dias = mysqli_num_rows($cotizaciones6dias);

$query_cotizaciones7dias = "SELECT * FROM cotizaciones WHERE cotizaciones.fechaID >= '$fecha8dias' AND cotizaciones.fechaID <= '$fecha7dias' ORDER BY cotizaciones.id DESC";
$cotizaciones7dias = mysqli_query($DKKadmin, $query_cotizaciones7dias) or die(mysqli_error($DKKadmin));
$row_cotizaciones7dias = mysqli_fetch_assoc($cotizaciones7dias);
$totalRows_cotizaciones7dias = mysqli_num_rows($cotizaciones7dias);

$query_cotizaciones8dias = "SELECT * FROM cotizaciones WHERE cotizaciones.fechaID >= '$fecha9dias' AND cotizaciones.fechaID <= '$fecha8dias' ORDER BY cotizaciones.id DESC";
$cotizaciones8dias = mysqli_query($DKKadmin, $query_cotizaciones8dias) or die(mysqli_error($DKKadmin));
$row_cotizaciones8dias = mysqli_fetch_assoc($cotizaciones8dias);
$totalRows_cotizaciones8dias = mysqli_num_rows($cotizaciones8dias);

$query_cotizaciones9dias = "SELECT * FROM cotizaciones WHERE cotizaciones.fechaID >= '$fecha10dias' AND cotizaciones.fechaID <= '$fecha9dias' ORDER BY cotizaciones.id DESC";
$cotizaciones9dias = mysqli_query($DKKadmin, $query_cotizaciones9dias) or die(mysqli_error($DKKadmin));
$row_cotizaciones9dias = mysqli_fetch_assoc($cotizaciones9dias);
$totalRows_cotizaciones9dias = mysqli_num_rows($cotizaciones9dias);

$query_cotizaciones10dias = "SELECT * FROM cotizaciones WHERE cotizaciones.fechaID >= '$fecha11dias' AND cotizaciones.fechaID <= '$fecha10dias' ORDER BY cotizaciones.id DESC";
$cotizaciones10dias = mysqli_query($DKKadmin, $query_cotizaciones10dias) or die(mysqli_error($DKKadmin));
$row_cotizaciones10dias = mysqli_fetch_assoc($cotizaciones103dias);
$totalRows_cotizaciones10dias = mysqli_num_rows($cotizaciones10dias);

$query_cotizaciones11dias = "SELECT * FROM cotizaciones WHERE cotizaciones.fechaID >= '$fecha12dias' AND cotizaciones.fechaID <= '$fecha11dias' ORDER BY cotizaciones.id DESC";
$cotizaciones11dias = mysqli_query($DKKadmin, $query_cotizaciones11dias) or die(mysqli_error($DKKadmin));
$row_cotizaciones11dias = mysqli_fetch_assoc($cotizaciones11dias);
$totalRows_cotizaciones11dias = mysqli_num_rows($cotizaciones11dias);

$query_cotizaciones12dias = "SELECT * FROM cotizaciones WHERE cotizaciones.fechaID >= '$fecha13dias' AND cotizaciones.fechaID <= '$fecha12dias' ORDER BY cotizaciones.id DESC";
$cotizaciones12dias = mysqli_query($DKKadmin, $query_cotizaciones12dias) or die(mysqli_error($DKKadmin));
$row_cotizaciones12dias = mysqli_fetch_assoc($cotizaciones12dias);
$totalRows_cotizaciones12dias = mysqli_num_rows($cotizaciones12dias);

$query_cotizaciones13dias = "SELECT * FROM cotizaciones WHERE cotizaciones.fechaID >= '$fecha14dias' AND cotizaciones.fechaID <= '$fecha13dias' ORDER BY cotizaciones.id DESC";
$cotizaciones13dias = mysqli_query($DKKadmin, $query_cotizaciones13dias) or die(mysqli_error($DKKadmin));
$row_cotizaciones13dias = mysqli_fetch_assoc($cotizaciones13dias);
$totalRows_cotizaciones13dias = mysqli_num_rows($cotizaciones13dias);

$query_cotizacionesTotal = "SELECT * FROM cotizaciones ORDER BY cotizaciones.id DESC";
$cotizacionesTotal = mysqli_query($DKKadmin, $query_cotizacionesTotal) or die(mysqli_error($DKKadmin));
$row_cotizacionesTotal = mysqli_fetch_assoc($cotizacionesTotal);
$totalRows_cotizacionesTotal = mysqli_num_rows($cotizacionesTotal);

$query_blogTotal = "SELECT * FROM blog WHERE blog.estado = '1' ORDER BY blog.id DESC";
$blogTotal = mysqli_query($DKKadmin, $query_blogTotal) or die(mysqli_error($DKKadmin));
$row_blogTotal = mysqli_fetch_assoc($blogTotal);
$totalRows_blogTotal = mysqli_num_rows($blogTotal);

$query_blogVisitasTotal = "SELECT SUM(blog.visitas) as totalVisitasNoticias FROM blog";
$blogVisitasTotal = mysqli_query($DKKadmin, $query_blogVisitasTotal) or die(mysqli_error($DKKadmin));
$row_blogVisitasTotal = mysqli_fetch_assoc($blogVisitasTotal);
$totalRows_blogVisitasTotal = mysqli_num_rows($blogVisitasTotal);

$query_productosTotal = "SELECT * FROM productos WHERE productos.estado = '1' ORDER BY productos.id DESC";
$productosTotal = mysqli_query($DKKadmin, $query_productosTotal) or die(mysqli_error($DKKadmin));
$row_productosTotal = mysqli_fetch_assoc($productosTotal);
$totalRows_productosTotal = mysqli_num_rows($productosTotal);

$query_productosPopulares = "SELECT * FROM productos WHERE productos.estado = '1' ORDER BY productos.visitas DESC LIMIT 10";
$productosPopulares = mysqli_query($DKKadmin, $query_productosPopulares) or die(mysqli_error($DKKadmin));
$row_productosPopulares = mysqli_fetch_assoc($productosPopulares);
$totalRows_productosPopulares = mysqli_num_rows($productosPopulares);

$query_productosVisitasTotal = "SELECT SUM(productos.visitas) as totalVisitasProductos FROM productos";
$productosVisitasTotal = mysqli_query($DKKadmin, $query_productosVisitasTotal) or die(mysqli_error($DKKadmin));
$row_productosVisitasTotal = mysqli_fetch_assoc($productosVisitasTotal);
$totalRows_productosVisitasTotal = mysqli_num_rows($productosVisitasTotal);

$query_ultimasCotizaciones = "SELECT * FROM cotizaciones ORDER BY cotizaciones.id DESC LIMIT 10";
$ultimasCotizaciones = mysqli_query($DKKadmin, $query_ultimasCotizaciones) or die(mysqli_error($DKKadmin));
$row_ultimasCotizaciones = mysqli_fetch_assoc($ultimasCotizaciones);
$totalRows_ultimasCotizaciones = mysqli_num_rows($ultimasCotizaciones);

?>
<!DOCTYPE html>
<!--[if IE 9]>         <html class="ie9 no-focus" lang="es"> <![endif]-->
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
        <link rel="stylesheet" href="js/plugins/slick/slick.min.css">
        <link rel="stylesheet" href="js/plugins/slick/slick-theme.min.css">
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
                                            <a href="qts_clientes.php">Todos</a>
                                        </li>
                                        <li>
                                        	<a href="qts_clientes-add.php">Nuevo</a>
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
				
				<!-- header -->
                <div class="bg-image overflow-hidden" style="background-image: url('img/bg/1.jpg');">
                    <div class="bg-black-op">
                        <div class="content content-narrow">
                            <div class="block block-transparent">
                                <div class="block-content block-content-full">
                                    <h1 class="h1 font-w300 text-white animated fadeInDown push-50-t push-5">Dashboard</h1>
                                    <h2 class="h4 font-w300 text-white-op animated fadeInUp">Hola <?php echo $row_datosAdmin["nombre"]." ".$row_datosAdmin["apellido"]; ?></h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END header -->

                <!-- contenido -->
                <div class="content content-narrow">
                    <!-- status -->
                    <div class="row text-uppercase">
                        <div class="col-xs-6 col-sm-3">
                            <div class="block block-rounded">
                                <div class="block-content block-content-full">
                                    <div class="font-s12 font-w700">Productos Publicados</div>
                                    <a class="h2 font-w300 text-primary" href="productos.php" data-toggle="countTo" data-to="<?php echo $totalRows_productosTotal; ?>"></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-3">
                            <div class="block block-rounded">
                                <div class="block-content block-content-full">
                                    <div class="font-s12 font-w700">Visitas a los Productos</div>
                                    <a class="h2 font-w300 text-primary" href="base_comp_charts.html" data-toggle="countTo" data-to="<?php echo $row_productosVisitasTotal['totalVisitasProductos']; ?>"></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-3">
                            <div class="block block-rounded">
                                <div class="block-content block-content-full">
                                    <div class="font-s12 font-w700">Visitas Hoy</div>
                                    <a class="h2 font-w300 text-primary" href="base_comp_charts.html" data-toggle="countTo" data-to="<?php echo $totalRows_visitasHoy; ?>"></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-3">
                            <div class="block block-rounded">
                                <div class="block-content block-content-full">
                                    <div class="font-s12 font-w700">Visitas Total</div>
                                    <a class="h2 font-w300 text-primary" href="base_comp_charts.html" data-toggle="countTo" data-to="<?php echo $totalRows_visitasTotal; ?>"></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END status -->

                    <!-- graficos -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="block block-rounded block-opt-refresh-icon8">
                                <div class="block-header">
                                    <h3 class="block-title">Visitas</h3>
                                </div>
                                <div class="block-content block-content-full bg-gray-lighter text-center">
                                    <div style="height: 340px;"><canvas class="js-dash-chartjs-earnings"></canvas></div>
                                </div>                                
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="block block-rounded block-opt-refresh-icon8">
                                <div class="block-header">
                                    <h3 class="block-title">Cotizaciones</h3>
                                </div>
                                <div class="block-content block-content-full bg-gray-lighter text-center">
                                    <div style="height: 340px;"><canvas class="js-dash-chartjs-sales"></canvas></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END graficos -->

                    <!-- tablas -->
                    <div class="row">
                        <div class="col-lg-6">
                            <!-- Top Products -->
                            <div class="block block-opt-refresh-icon4">
                                <div class="block-header bg-gray-lighter">
                                    <h3 class="block-title">Productos Populares</h3>
                                </div>
                                <div class="block-content">
                                    <table class="table table-borderless table-striped table-vcenter">
                                        <tbody>
											<?php do { ?>
                                            <tr>
                                                <td class="text-center" style="width: 100px;"><a href="base_pages_ecom_product_edit.html"><strong><?php echo "PID.".$row_productosPopulares["id"]; ?></strong></a></td>
                                                <td><a href="../productos/<?php echo $row_productosPopulares["nombreSEO"]; ?>" target="_blank"><?php echo $row_productosPopulares["nombre"]; ?></a></td>
                                                <td class="hidden-xs text-center">
                                                    <div class="text-warning">
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php } while ($row_productosPopulares = mysqli_fetch_assoc($productosPopulares)); ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- END Top Products -->
                        </div>
                        <div class="col-lg-6">
                            <!-- ultimas cotizaciones -->
                            <div class="block block-opt-refresh-icon4">
                                <div class="block-header bg-gray-lighter">
                                    <h3 class="block-title">&Uacute;ltimas Cotizaciones</h3>
                                </div>
                                <div class="block-content">
                                    <table class="table table-borderless table-striped table-vcenter">
                                        <tbody>
											<?php do { ?>
                                            <tr>
                                                <td class="text-center" style="width: 100px;"><a href="cotizaciones.php"><strong><?php if ($row_ultimasCotizaciones["id"] < 10) { $idQTE = "0000".$row_ultimasCotizaciones["id"]; } if ($row_ultimasCotizaciones["id"] < 100 && $row_ultimasCotizaciones["id"] >= 10) { $idQTE = "000".$row_ultimasCotizaciones["id"]; } if ($row_ultimasCotizaciones["id"] < 1000 && $row_ultimasCotizaciones["id"] >= 100) { $idQTE = "00".$row_ultimasCotizaciones["id"]; } if ($row_ultimasCotizaciones["id"] < 10000 && $row_ultimasCotizaciones["id"] >= 1000) { $idQTE = "0".$row_ultimasCotizaciones["id"]; } if ($row_ultimasCotizaciones["id"] < 100000 && $row_ultimasCotizaciones["id"] >= 10000) { $idQTE = $row_ultimasCotizaciones["id"]; };  echo "QTE.".$idQTE; ?></strong></a></td>
                                                <td class="hidden-xs"><a href="cotizaciones.php"><?php echo $row_ultimasCotizaciones["nombre"]; ?></a></td>
                                                <td>
                                                    <span class="label label-<?php if ($row_ultimasCotizaciones["origen"] == 'web') {echo "success";} if ($row_ultimasCotizaciones["origen"] == 'movil') {echo "default";} ?>"><?php echo strtoupper($row_ultimasCotizaciones["origen"]); ?></span>
                                                </td>
                                                <td class="text-right"><strong>
												<?php 
												  $seoProductosCotizaciones = $row_ultimasCotizaciones["productoSEO"];
												  $seleccionaProductosCotizaciones = mysqli_query($DKKadmin,"SELECT * FROM productos WHERE productos.nombreSEO = '$seoProductosCotizaciones' AND productos.estado = '1' ORDER BY productos.id ASC"); if(mysqli_num_rows($seleccionaProductosCotizaciones) == 0) { echo ""; } else { $counter = 1; while($pCotizaciones = mysqli_fetch_array($seleccionaProductosCotizaciones)) { echo $pCotizaciones["nombre"]; } } ?>
												</strong></td>
                                            </tr>
                                            <?php } while ($row_ultimasCotizaciones = mysqli_fetch_assoc($ultimasCotizaciones)); ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- END ultimas cotizaciones -->
                        </div>
                    </div>
                    <!-- END tablas -->
                </div>
                <!-- END contenido -->
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
                    <a class="font-w600" href="https://diegokingkong.com/home" target="_blank">Origen 3.4</a> &copy; <span><?php echo date("Y"); ?></span>
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
                                  <a class="block block-rounded" href="../">
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
        <script src="js/plugins/chartjs/Chart.min.js"></script>
        <script src="js/pages/base_pages_dashboard_v2.js"></script>
        <script>
            jQuery(function () {
                // Init page helpers (CountTo plugin)
                App.initHelpers('appear-countTo');
            });
        </script>
        <script>
        var BasePagesDashboardv2 = function() {
			// Chart.js Chart, for more examples you can check out http://www.chartjs.org/docs
			var initDashv2ChartJS = function(){
				// Get Chart Container
				var $dashChartEarningsCon = jQuery('.js-dash-chartjs-earnings')[0].getContext('2d');
				var $dashChartSalesCon    = jQuery('.js-dash-chartjs-sales')[0].getContext('2d');

				// Visitas Chart Data
				var $dashChartEarningsData = {
					labels: ['1 SEMANA', '6 DIAS', '5 DIAS', '4 DIAS', '3 DIAS', 'AYER', 'HOY'],
					datasets: [
						{
							label: 'Esta Semana',
							fillColor: 'rgba(68, 180, 166, .25)',
							strokeColor: 'rgba(68, 180, 166, .55)',
							pointColor: 'rgba(68, 180, 166, .55)',
							pointStrokeColor: '#fff',
							pointHighlightFill: '#fff',
							pointHighlightStroke: 'rgba(68, 180, 166, 1)',
							data: [<?php echo $totalRows_visitas6dias; ?>, <?php echo $totalRows_visitas5dias; ?>, <?php echo $totalRows_visitas4dias; ?>, <?php echo $totalRows_visitas3dias; ?>, <?php echo $totalRows_visitas2dias; ?>, <?php echo $totalRows_visitasAyer; ?>, <?php echo $totalRows_visitasHoy; ?>]
						},
						{
							label: 'Semana Pasada',
							fillColor: 'rgba(68, 180, 166, .07)',
							strokeColor: 'rgba(68, 180, 166, .25)',
							pointColor: 'rgba(68, 180, 166, .25)',
							pointStrokeColor: '#fff',
							pointHighlightFill: '#fff',
							pointHighlightStroke: 'rgba(68, 180, 166, 1)',
							data: [<?php echo $totalRows_visitas13dias; ?>, <?php echo $totalRows_visitas12dias; ?>, <?php echo $totalRows_visitas11dias; ?>, <?php echo $totalRows_visitas10dias; ?>, <?php echo $totalRows_visitas9dias; ?>, <?php echo $totalRows_visitas8dias; ?>, <?php echo $totalRows_visitas7dias; ?>]
						}
					]
				};

				// Sales Chart Data
				var $dashChartSalesData = {
					labels: ['1 SEMANA', '6 DIAS', '5 DIAS', '4 DIAS', '3 DIAS', 'AYER', 'HOY'],
					datasets: [
						{
							label: 'Esta Semana',
							fillColor: 'rgba(164, 138, 212, .07)',
							strokeColor: 'rgba(164, 138, 212, .25)',
							pointColor: 'rgba(164, 138, 212, .25)',
							pointStrokeColor: '#fff',
							pointHighlightFill: '#fff',
							pointHighlightStroke: 'rgba(164, 138, 212, 1)',
							data: [<?php echo $totalRows_cotizaciones6dias; ?>, <?php echo $totalRows_cotizaciones5dias; ?>, <?php echo $totalRows_cotizaciones4dias; ?>, <?php echo $totalRows_cotizaciones3dias; ?>, <?php echo $totalRows_cotizaciones2dias; ?>, <?php echo $totalRows_cotizacionesAyer; ?>, <?php echo $totalRows_cotizacionesHoy; ?>]
						},
						{
							label: 'Semana Pasada',
							fillColor: 'rgba(164, 138, 212, .25)',
							strokeColor: 'rgba(164, 138, 212, .55)',
							pointColor: 'rgba(164, 138, 212, .55)',
							pointStrokeColor: '#fff',
							pointHighlightFill: '#fff',
							pointHighlightStroke: 'rgba(164, 138, 212, 1)',
							data: [<?php echo $totalRows_cotizaciones13dias; ?>, <?php echo $totalRows_cotizaciones12dias; ?>, <?php echo $totalRows_cotizaciones11dias; ?>, <?php echo $totalRows_cotizaciones10dias; ?>, <?php echo $totalRows_cotizaciones9dias; ?>, <?php echo $totalRows_cotizaciones8dias; ?>, <?php echo $totalRows_cotizaciones7dias; ?>]
						}
					]
				};

				// Init Earnings Chart
				var $dashChartEarnings = new Chart($dashChartEarningsCon).Line($dashChartEarningsData, {
					scaleFontFamily: "'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif",
					scaleFontColor: '#999',
					scaleFontStyle: '600',
					tooltipTitleFontFamily: "'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif",
					tooltipCornerRadius: 3,
					maintainAspectRatio: false,
					responsive: true
				});

				// Init Sales Chart
				var $dashChartSales = new Chart($dashChartSalesCon).Line($dashChartSalesData, {
					scaleFontFamily: "'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif",
					scaleFontColor: '#999',
					scaleFontStyle: '600',
					tooltipTitleFontFamily: "'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif",
					tooltipCornerRadius: 3,
					maintainAspectRatio: false,
					responsive: true
				});
			};

			return {
				init: function () {
					// Init ChartJS charts
					initDashv2ChartJS();
				}
			};
		}();

		// Initialize when page loads
		jQuery(function(){ BasePagesDashboardv2.init(); });
		</script>
		<!-- InstanceEndEditable -->
</body>
<!-- InstanceEnd --></html>
<?php
mysqli_free_result($datosAdmin);

mysqli_free_result($contactosPendientes);

mysqli_free_result($bgRandom);

mysqli_free_result($visitasHoy);

mysqli_free_result($visitasAyer);

mysqli_free_result($visitas2dias);

mysqli_free_result($visitas3dias);

mysqli_free_result($visitas4dias);

mysqli_free_result($visitas5dias);

mysqli_free_result($visitas6dias);

mysqli_free_result($visitas7dias);

mysqli_free_result($visitas8dias);

mysqli_free_result($visitas9dias);

mysqli_free_result($visitas10dias);

mysqli_free_result($visitas11dias);

mysqli_free_result($visitas12dias);

mysqli_free_result($visitas13dias);

mysqli_free_result($visitasTotal);

mysqli_free_result($cotizacionesHoy);

mysqli_free_result($cotizacionesAyer);

mysqli_free_result($cotizaciones2dias);

mysqli_free_result($cotizaciones3dias);

mysqli_free_result($cotizaciones4dias);

mysqli_free_result($cotizaciones5dias);

mysqli_free_result($cotizaciones6dias);

mysqli_free_result($cotizaciones7dias);

mysqli_free_result($cotizaciones8dias);

mysqli_free_result($cotizaciones9dias);

mysqli_free_result($cotizaciones10dias);

mysqli_free_result($cotizaciones11dias);

mysqli_free_result($cotizaciones12dias);

mysqli_free_result($cotizaciones13dias);

mysqli_free_result($cotizacionesTotal);

mysqli_free_result($blogTotal);

mysqli_free_result($blogVisitasTotal);

mysqli_free_result($productosTotal);

mysqli_free_result($productosVisitasTotal);

mysqli_free_result($productosPopulares);

mysqli_free_result($ultimasCotizaciones);

?>
