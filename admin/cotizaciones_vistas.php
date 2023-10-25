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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "replyCotizacion")) {
  $updateSQL = sprintf("UPDATE cotizaciones SET mensaje=%s, ipReply=%s, fechaReply=%s, estado=%s WHERE id=%s",
                       GetSQLValueString($_POST['mensaje'], "text"),
                       GetSQLValueString($_POST['ipReply'], "text"),
                       GetSQLValueString($_POST['fechaReply'], "text"),
                       GetSQLValueString($_POST['estado'], "text"),
                       GetSQLValueString($_POST['id'], "int"));
  $Result1 = mysqli_query($DKKadmin, $updateSQL) or die(mysqli_error($DKKadmin));

  $updateGoTo = "cotizaciones_reply.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

//Variables
$ip = $_SERVER["REMOTE_ADDR"];
$fecha = date('Y-m-d H:i:s');
$fechaID = strtotime($fecha);

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

$query_contactosTotal = "SELECT * FROM contacto ORDER BY contacto.id DESC";
$contactosTotal = mysqli_query($DKKadmin, $query_contactosTotal) or die(mysqli_error($DKKadmin));
$row_contactosTotal = mysqli_fetch_assoc($contactosTotal);
$totalRows_contactosTotal = mysqli_num_rows($contactosTotal);

$query_suscritosTotal = "SELECT * FROM suscritos ORDER BY suscritos.id DESC";
$suscritosTotal = mysqli_query($DKKadmin, $query_suscritosTotal) or die(mysqli_error($DKKadmin));
$row_suscritosTotal = mysqli_fetch_assoc($suscritosTotal);
$totalRows_suscritosTotal = mysqli_num_rows($suscritosTotal);

$maxRows_cotizacionesShow = 15;
$pageNum_cotizacionesShow = 0;
if (isset($_GET['pageNum_cotizacionesShow'])) {
  $pageNum_cotizacionesShow = $_GET['pageNum_cotizacionesShow'];
}
$startRow_cotizacionesShow = $pageNum_cotizacionesShow * $maxRows_cotizacionesShow;

$query_cotizacionesShow = "SELECT * FROM cotizaciones WHERE cotizaciones.vista = '1' AND NOT cotizaciones.estado = '0' ORDER BY cotizaciones.id DESC";
$query_limit_cotizacionesShow = sprintf("%s LIMIT %d, %d", $query_cotizacionesShow, $startRow_cotizacionesShow, $maxRows_cotizacionesShow);
$cotizacionesShow = mysqli_query($DKKadmin, $query_limit_cotizacionesShow) or die(mysqli_error($DKKadmin));
$row_cotizacionesShow = mysqli_fetch_assoc($cotizacionesShow);

if (isset($_GET['totalRows_cotizacionesShow'])) {
  $totalRows_cotizacionesShow = $_GET['totalRows_cotizacionesShow'];
} else {
  $all_cotizacionesShow = mysqli_query($DKKadmin, $query_cotizacionesShow);
  $totalRows_cotizacionesShow = mysqli_num_rows($all_cotizacionesShow);
}
$totalPages_cotizacionesShow = ceil($totalRows_cotizacionesShow/$maxRows_cotizacionesShow)-1;

$query_cotizacionesTotal = "SELECT * FROM cotizaciones ORDER BY cotizaciones.id DESC";
$cotizacionesTotal = mysqli_query($DKKadmin, $query_cotizacionesTotal) or die(mysqli_error($DKKadmin));
$row_cotizacionesTotal = mysqli_fetch_assoc($cotizacionesTotal);
$totalRows_cotizacionesTotal = mysqli_num_rows($cotizacionesTotal);

$query_cotizacionesIngresadas = "SELECT * FROM cotizaciones WHERE cotizaciones.estado = '1' ORDER BY cotizaciones.id DESC";
$cotizacionesIngresadas = mysqli_query($DKKadmin, $query_cotizacionesIngresadas) or die(mysqli_error($DKKadmin));
$row_cotizacionesIngresadas = mysqli_fetch_assoc($cotizacionesIngresadas);
$totalRows_cotizacionesIngresadas = mysqli_num_rows($cotizacionesIngresadas);

$query_cotizacionesUrgentes = "SELECT * FROM cotizaciones WHERE cotizaciones.urgente = '1' AND NOT cotizaciones.estado = '0' ORDER BY cotizaciones.id DESC";
$cotizacionesUrgentes = mysqli_query($DKKadmin, $query_cotizacionesUrgentes) or die(mysqli_error($DKKadmin));
$row_cotizacionesUrgentes = mysqli_fetch_assoc($cotizacionesUrgentes);
$totalRows_cotizacionesUrgentes = mysqli_num_rows($cotizacionesUrgentes);

$query_cotizacionesRespondidas = "SELECT * FROM cotizaciones WHERE cotizaciones.estado = '2' ORDER BY cotizaciones.id DESC";
$cotizacionesRespondidas = mysqli_query($DKKadmin, $query_cotizacionesRespondidas) or die(mysqli_error($DKKadmin));
$row_cotizacionesRespondidas = mysqli_fetch_assoc($cotizacionesRespondidas);
$totalRows_cotizacionesRespondidas = mysqli_num_rows($cotizacionesRespondidas);

$query_cotizacionesVistas = "SELECT * FROM cotizaciones WHERE cotizaciones.vista = '1' AND NOT cotizaciones.estado = '0' ORDER BY cotizaciones.id DESC";
$cotizacionesVistas = mysqli_query($DKKadmin, $query_cotizacionesVistas) or die(mysqli_error($DKKadmin));
$row_cotizacionesVistas = mysqli_fetch_assoc($cotizacionesVistas);
$totalRows_cotizacionesVistas = mysqli_num_rows($cotizacionesVistas);

$query_cotizacionesCerradas = "SELECT * FROM cotizaciones WHERE cotizaciones.estado = '3' ORDER BY cotizaciones.id DESC";
$cotizacionesCerradas = mysqli_query($DKKadmin, $query_cotizacionesCerradas) or die(mysqli_error($DKKadmin));
$row_cotizacionesCerradas = mysqli_fetch_assoc($cotizacionesCerradas);
$totalRows_cotizacionesCerradas = mysqli_num_rows($cotizacionesCerradas);

$query_cotizacionesEliminadas = "SELECT * FROM cotizaciones WHERE cotizaciones.estado = '0' ORDER BY cotizaciones.id DESC";
$cotizacionesEliminadas = mysqli_query($DKKadmin, $query_cotizacionesEliminadas) or die(mysqli_error($DKKadmin));
$row_cotizacionesEliminadas = mysqli_fetch_assoc($cotizacionesEliminadas);
$totalRows_cotizacionesEliminadas = mysqli_num_rows($cotizacionesEliminadas);

$query_cotizacionesWeb = "SELECT * FROM cotizaciones WHERE cotizaciones.origen = 'web' ORDER BY cotizaciones.id DESC";
$cotizacionesWeb = mysqli_query($DKKadmin, $query_cotizacionesWeb) or die(mysqli_error($DKKadmin));
$row_cotizacionesWeb = mysqli_fetch_assoc($cotizacionesWeb);
$totalRows_cotizacionesWeb = mysqli_num_rows($cotizacionesWeb);

$query_cotizacionesMovil = "SELECT * FROM cotizaciones WHERE cotizaciones.origen = 'movil' ORDER BY cotizaciones.id DESC";
$cotizacionesMovil = mysqli_query($DKKadmin, $query_cotizacionesMovil) or die(mysqli_error($DKKadmin));
$row_cotizacionesMovil = mysqli_fetch_assoc($cotizacionesMovil);
$totalRows_cotizacionesMovil = mysqli_num_rows($cotizacionesMovil);

$query_cotizacionesShowTodos = "SELECT * FROM cotizaciones WHERE cotizaciones.vista = '1' AND NOT cotizaciones.estado = '0' ORDER BY cotizaciones.id DESC";
$cotizacionesShowTodos = mysqli_query($DKKadmin, $query_cotizacionesShowTodos) or die(mysqli_error($DKKadmin));
$row_cotizacionesShowTodos = mysqli_fetch_assoc($cotizacionesShowTodos);
$totalRows_cotizacionesShowTodos = mysqli_num_rows($cotizacionesShowTodos);

$query_ultimaCotizacion = "SELECT * FROM cotizaciones ORDER BY cotizaciones.id DESC LIMIT 1";
$ultimaCotizacion = mysqli_query($DKKadmin, $query_ultimaCotizacion) or die(mysqli_error($DKKadmin));
$row_ultimaCotizacion = mysqli_fetch_assoc($ultimaCotizacion);
$totalRows_ultimaCotizacion = mysqli_num_rows($ultimaCotizacion);

$queryString_cotizacionesShow = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_cotizacionesShow") == false && 
        stristr($param, "totalRows_cotizacionesShow") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_cotizacionesShow = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_cotizacionesShow = sprintf("&totalRows_cotizacionesShow=%d%s", $totalRows_cotizacionesShow, $queryString_cotizacionesShow);
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
		<link rel="stylesheet" href="js/plugins/magnific-popup/magnific-popup.min.css">
        <link rel="stylesheet" href="js/plugins/summernote/summernote.min.css">
        <link rel="stylesheet" href="js/plugins/simplemde/simplemde.min.css">
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
                <div class="content">
                    <div class="row">
                        <div class="col-sm-5 col-lg-3">
                            <button class="btn btn-block btn-primary visible-xs push" data-toggle="collapse" data-target="#tickets-nav" type="button">Men&uacute;</button>
                            <div class="collapse navbar-collapse remove-padding" id="tickets-nav">
                                <!-- menu cotizaciones -->
                                <div class="block">
                                    <div class="block-header bg-gray-lighter">
                                        <ul class="block-options">
                                            <li>
                                                <button data-toggle="modal" data-target="#modal-compose" type="button"><i class="si si-settings"></i></button>
                                            </li>
                                        </ul>
                                        <h3 class="block-title">Cotizaciones</h3>
                                    </div>
                                    <div class="block-content">
                                        <ul class="nav nav-pills nav-stacked push">
                                            <li>
                                                <a href="cotizaciones.php">
                                                    <span class="badge pull-right"><?php echo $totalRows_cotizacionesIngresadas; ?></span><i class="fa fa-fw fa-inbox push-5-r"></i> Ingresadas
                                                </a>
                                            </li>
                                            <li>
                                                <a href="cotizaciones_urgentes.php">
                                                    <span class="badge pull-right"><?php echo $totalRows_cotizacionesUrgentes; ?></span><i class="fa fa-fw fa-warning push-5-r"></i> Urgentes
                                                </a>
                                            </li>
                                            <li>
                                                <a href="cotizaciones_respondidas.php">
                                                    <span class="badge pull-right"><?php echo $totalRows_cotizacionesRespondidas; ?></span><i class="fa fa-fw fa-reply push-5-r"></i> Respondidas
                                                </a>
                                            </li>
                                            <li class="active">
                                                <a href="cotizaciones_vistas.php">
                                                    <span class="badge pull-right"><?php echo $totalRows_cotizacionesVistas; ?></span><i class="fa fa-fw fa-folder-open-o push-5-r"></i> Vistas
                                                </a>
                                            </li>
                                            <li>
                                                <a href="cotizaciones_cerradas.php">
                                                    <span class="badge pull-right"><?php echo $totalRows_cotizacionesCerradas; ?></span><i class="fa fa-fw fa-folder-o push-5-r"></i> Cerradas
                                                </a>
                                            </li>
                                            <li>
                                                <a href="cotizaciones_eliminadas.php">
                                                    <span class="badge pull-right"><?php echo $totalRows_cotizacionesEliminadas; ?></span><i class="fa fa-fw fa-trash push-5-r"></i> Eliminadas
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- END menu cotizaciones -->

                                <!-- vista rapida -->
                                <div class="block">
                                    <div class="block-header bg-gray-lighter">
                                        <h3 class="block-title">Vista R&aacute;pida</h3>
                                    </div>
                                    <div class="block-content">
                                        <table class="table table-borderless table-condensed table-vcenter font-s13">
                                            <tbody>
                                                <tr>
                                                    <td class="font-w600" style="width: 75%;">Cotizaciones</td>
                                                    <td class="text-right"><?php echo number_format($totalRows_cotizacionesTotal,0,",","."); ?></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <div class="clearfix push-5">
                                                            <span class="pull-right text-muted text-right"><?php echo number_format($totalRows_cotizacionesWeb,0,",","."); ?></span>
                                                            -- Web
                                                        </div>
                                                        <div class="clearfix push-5">
                                                            <span class="pull-right text-muted text-right"><?php echo number_format($totalRows_cotizacionesMovil,0,",","."); ?></span>
                                                            -- M&oacute;vil
                                                        </div>
                                                        <div class="clearfix push-5">
                                                            <span class="pull-right text-muted text-right"><?php echo number_format($totalRows_contactosTotal,0,",","."); ?></span>
                                                            -- Contactos
                                                        </div>
                                                        <div class="clearfix">
                                                            <span class="pull-right text-muted text-right"><?php echo number_format($totalRows_suscritosTotal,0,",","."); ?></span>
                                                            -- Suscritos
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="font-w600">Respondidas</td>
                                                    <td class="text-right"><?php echo number_format($totalRows_cotizacionesRespondidas,0,",","."); ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="font-w600">&Uacute;ltima Cotizaci&oacute;n</td>
                                                    <td class="text-right">
                                                    <?php  
														$fechaUltimaCotizacion = "fechaMailbox".$row_ultimaCotizacion["id"];
														$segundosUltimaCotizacion = "segundosMailbox".$row_ultimaCotizacion["id"];
														$diferenciaDiasUltimaCotizacion = "diferenciaDiasMailbox".$row_ultimaCotizacion["id"];
														$fechaUltimaCotizacion = $row_ultimaCotizacion["fecha"];
														$segundosUltimaCotizacion = strtotime($fechaUltimaCotizacion) - strtotime('now');
														$diferenciaDiasUltimaCotizacion = intval($segundosUltimaCotizacion/60/60/24);
														if ($diferenciaDiasUltimaCotizacion > 0) {
														echo "hace ".(str_replace("-", " ", ($diferenciaDiasUltimaCotizacion)))." días";
														}
														if ($diferenciaDiasUltimaCotizacion < 1) { 
														echo (str_replace("-", " ", (number_format($segundosUltimaCotizacion/60/60,0,",","."))))." hrs";
														}
													?>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- END vista rapida -->
                            </div>
                            <!-- END menu lateral -->
                        </div>
                        <div class="col-sm-7 col-lg-9">
                            <!-- cotizaciones -->
                            <div class="block">
                                <div class="block-header bg-gray-lighter">
                                    <ul class="block-options">
                                        <?php if ($pageNum_cotizacionesShow > 0) { // Mostrar si hay más de 15 mensajes ?><li>
											<button class="js-tooltip" title="Anteriores 15 Cotizaciones" type="button" data-toggle="block-option" onClick="location.href='<?php printf("%s?pageNum_cotizacionesShow=%d%s", $currentPage, max(0, $pageNum_cotizacionesShow - 1), $queryString_cotizacionesShow); ?>'"><i class="si si-arrow-left"></i></button>
                                        </li><?php } // Mostrar si hay más de 15 mensajes ?>
                                        <?php if ($pageNum_cotizacionesShow < $totalPages_cotizacionesShow) { // Mostrar si hay más de 15 mensajes ?><li>
                                            <button class="js-tooltip" title="Siguientes 15 Cotizaciones" type="button" data-toggle="block-option" onClick="location.href='<?php printf("%s?pageNum_cotizacionesShow=%d%s", $currentPage, min($totalPages_cotizacionesShow, $pageNum_cotizacionesShow + 1), $queryString_cotizacionesShow); ?>'"><i class="si si-arrow-right"></i></button>
                                        </li><?php } // Mostrar si hay más de 15 mensajes ?>
                                        <li>
                                            <button type="button" data-toggle="block-option" data-action="refresh_toggle" data-action-mode="demo" onClick="window.location.reload()"><i class="si si-refresh"></i></button>
                                        </li>
                                        <li>
                                            <button type="button" data-toggle="block-option" data-action="fullscreen_toggle"></button>
                                        </li>
                                    </ul>
                                    <div class="block-title text-normal">
                                        <strong><?php echo ($startRow_cotizacionesShow + 1) ?>-<?php echo min($startRow_cotizacionesShow + $maxRows_cotizacionesShow, $totalRows_cotizacionesShow) ?></strong> <span class="font-w400">de</span> <strong><?php echo $totalRows_cotizacionesShow; ?></strong>
                                    </div>
                                </div>
                                <div class="block-content">
                                    <!-- Tickets Table -->
                                    <div class="pull-r-l">
                                        <table class="table table-hover table-vcenter">
                                            <tbody>
                                                <?php do { ?>
                                                <?php 
												  $seoProductosCotizaciones = $row_cotizacionesShow["productoSEO"];
												  $seleccionaProductosCotizaciones = mysqli_query($DKKadmin,"SELECT * FROM productos WHERE productos.nombreSEO = '$seoProductosCotizaciones' AND productos.estado = '1' ORDER BY productos.id ASC"); if(mysqli_num_rows($seleccionaProductosCotizaciones) == 0) { echo ""; } else { ?>
				  								<?php
												//Datos Correo
												if ($row_cotizacionesShow["id"] < 10) {
													$idQTE = "0000".$row_cotizacionesShow["id"];
													} 
												if ($row_cotizacionesShow["id"] < 100 && $row_cotizacionesShow["id"] >= 10) {
													$idQTE = "000".$row_cotizacionesShow["id"];
													} 
												if ($row_cotizacionesShow["id"] < 1000 && $row_cotizacionesShow["id"] >= 100) {
													$idQTE = "00".$row_cotizacionesShow["id"];
													} 
												if ($row_cotizacionesShow["id"] < 10000 && $row_cotizacionesShow["id"] >= 1000) { 
													$idQTE = "0".$row_cotizacionesShow["id"];
													} 
												if ($row_cotizacionesShow["id"] < 100000 && $row_cotizacionesShow["id"] >= 10000) {
													$idQTE = $row_cotizacionesShow["id"];
													};
												?>
													<?php $counter = 1; while($pCotizaciones = mysqli_fetch_array($seleccionaProductosCotizaciones)) { ?>
                                                    <tr>
                                                    <td class="font-w600 text-center" style="width: 80px;"><?php echo "#QTE.".$idQTE; ?></td>
                                                    <td class="hidden-xs hidden-sm hidden-md text-center" style="width: 100px;">
                                                        <span class="label label-<?php if ($row_cotizacionesShow["origen"] == 'web') {echo "success";} if ($row_cotizacionesShow["origen"] == 'movil') {echo "default";} ?>"><?php echo strtoupper($row_cotizacionesShow["origen"]); ?></span>
                                                    </td>
                                                    <td>
                                                        <a class="font-w600" data-toggle="modal" data-target="#qte<?php echo $row_cotizacionesShow["id"]; ?>" href="#"><?php echo $pCotizaciones["nombre"]; ?></a>
                                                        <div class="text-muted">
                                                            <em>
                                                            <?php  
															$fechaCotizacionShow = "fechaCotizacionShow".$row_cotizacionesShow["id"];
															$segundosCotizacionShow = "segundosCotizacionShow".$row_cotizacionesShow["id"];
															$diferenciaDiasCotizacionShow = "diferenciaDiasCotizacionShow".$row_cotizacionesShow["id"];
															$fechaCotizacionShow = $row_cotizacionesShow["fecha"];
															$segundosCotizacionShow = strtotime($fechaCotizacionShow) - strtotime('now');
															$diferenciaDiasCotizacionShow = intval($segundosCotizacionShow/60/60/24);
															if ($diferenciaDiasCotizacionShow > 0) {
															echo "hace ".(str_replace("-", " ", ($diferenciaDiasCotizacionShow)))." días";
															}
															if ($diferenciaDiasCotizacionShow < 1) { 
															echo "hace ".(str_replace("-", " ", (number_format($segundosCotizacionShow/60/60,0,",","."))))." horas";
															}
															?>
                                                            </em> por <a href="javascript:void(0)"><?php echo $row_cotizacionesShow["nombre"]; ?></a>
                                                        </div>
                                                    </td>
                                                    <td class="hidden-xs hidden-sm hidden-md text-muted" style="width: 120px;">
                                                        <em><?php echo str_replace("-"," ",$pCotizaciones["categoriaSEO"]); ?></em>
                                                    </td>
                                                    <td class="hidden-xs hidden-sm hidden-md text-center">
                                                        <a href="cotizaciones_remove.php?id=<?php echo $row_cotizacionesShow["id"]; ?>"><span class="badge badge-danger"><i class="fa fa-trash"></i> </span></a>
                                                    </td>
                                                </tr>
                                                <?php } ?>
											    <?php } ?>
                                                <?php } while ($row_cotizacionesShow = mysqli_fetch_assoc($cotizacionesShow)); ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- END tabla de cotizaciones -->
                                </div>
                            </div>
                            <!-- END cotizaciones -->
                        </div>
                    </div>
                </div>
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
        <!-- cotizaciones -->
        <?php do { ?>
        <div class="modal fade" id="qte<?php echo $row_cotizacionesShowTodos["id"]; ?>" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-popout">
                <div class="modal-content">
                    <div class="block block-themed block-transparent remove-margin-b">
                        <div class="block-header bg-primary-dark">
                            <ul class="block-options">
                                <li>
                                    <span class="label label-<?php if ($row_cotizacionesShowTodos["origen"] == 'web') {echo "success";} if ($row_cotizacionesShowTodos["origen"] == 'movil') {echo "default";} ?>"><?php echo strtoupper($row_cotizacionesShowTodos["origen"]); ?></span>
                                </li>
                                <li>
                                    <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
                                </li>
                            </ul>
                            <?php 
							$seoProductosCotizacionesTodos = $row_cotizacionesShowTodos["productoSEO"];
							$seleccionaProductosCotizacionesTodos = mysqli_query($DKKadmin,"SELECT * FROM productos WHERE productos.nombreSEO = '$seoProductosCotizacionesTodos' AND productos.estado = '1' ORDER BY productos.id ASC"); if(mysqli_num_rows($seleccionaProductosCotizacionesTodos) == 0) { echo ""; } else { ?>
				  			<?php
							//Datos QTE
							if ($row_cotizacionesShowTodos["id"] < 10) {
							$idQTETodos = "0000".$row_cotizacionesShowTodos["id"];
							} 
							if ($row_cotizacionesShowTodos["id"] < 100 && $row_cotizacionesShowTodos["id"] >= 10) {
							$idQTETodos = "000".$row_cotizacionesShowTodos["id"];
							} 
							if ($row_cotizacionesShowTodos["id"] < 1000 && $row_cotizacionesShowTodos["id"] >= 100) {
							$idQTETodos = "00".$row_cotizacionesShowTodos["id"];
							} 
							if ($row_cotizacionesShowTodos["id"] < 10000 && $row_cotizacionesShowTodos["id"] >= 1000) { 
							$idQTETodos = "0".$row_cotizacionesShowTodos["id"];
							} 
							if ($row_cotizacionesShowTodos["id"] < 100000 && $row_cotizacionesShowTodos["id"] >= 10000) {
							$idQTETodos = $row_cotizacionesShowTodos["id"];
							};
							?><h3 class="block-title"><?php echo "#QTE.".$idQTETodos; ?></h3>
                            <?php $counter = 1; while($pCotizacionesTodos = mysqli_fetch_array($seleccionaProductosCotizacionesTodos)) { ?>
                        </div>
                        <div class="block-content block-content-full">
                            <div class="row">
                                <div class="col-sm-12">
                                    <ul class="nav-users">
                                        <li>
                                            <a href="mailto:<?php echo $row_cotizacionesShowTodos["correo"]; ?>">
                                                <img class="img-avatar" src="img/avatars/generico.jpg" alt="<?php echo $row_cotizacionesShowTodos["nombre"]; ?>">
                                                <i class="fa fa-circle text-success"></i> <?php echo $row_cotizacionesShowTodos["nombre"]; ?>
                                                <div class="font-w400 text-muted"><small><i class="fa fa-envelope"></i> <?php echo $row_cotizacionesShowTodos["correo"]; ?></small></div>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="block-content block-content-full block-content-mini bg-gray-light">
                            <span class="text-muted pull-right"><em><?php  
							$fechaCotizacionShowTodos = "fechaCotizacionShowTodos".$row_cotizacionesShowTodos["id"];
							$segundosCotizacionShowTodos = "segundosCotizacionShowTodos".$row_cotizacionesShowTodos["id"];
							$diferenciaDiasCotizacionShowTodos = "diferenciaDiasCotizacionShowTodos".$row_cotizacionesShowTodos["id"];
							$fechaCotizacionShowTodos = $row_cotizacionesShowTodos["fecha"];
							$segundosCotizacionShowTodos = strtotime($fechaCotizacionShowTodos) - strtotime('now');
							$diferenciaDiasCotizacionShowTodos = intval($segundosCotizacionShowTodos/60/60/24);
							if ($diferenciaDiasCotizacionShowTodos > 0) {
							echo "hace ".(str_replace("-", " ", ($diferenciaDiasCotizacionShowTodos)))." días";
							}
							if ($diferenciaDiasCotizacionShowTodos < 1) { 
							echo "hace ".(str_replace("-", " ", (number_format($segundosCotizacionShowTodos/60/60,0,",","."))))." horas";
							}
							?></em></span>
                            <span class="font-w600"><?php echo $pCotizacionesTodos["nombre"]; ?></span> en                            <a href="javascript:void(0)"><?php echo str_replace("-"," ",$pCotizacionesTodos["categoriaSEO"]); ?></a>
                        </div>
                        <div class="block-content">
                            <div class="row items-push">
	                            <div class="col-sm-6">
	                                <div class="row js-gallery">
	                                    <div class="col-xs-12 push-10">
	                                        <img class="img-responsive" src="../images/productos/<?php if (isset($pCotizacionesTodos["imagen1"])) { echo $pCotizacionesTodos["imagen1"]; } else { echo "noimagen.jpg"; }; ?>" alt="">
                                        </div>
                                    </div>
                                    <!-- END imagenes -->
                                </div>
                                <div class="col-sm-6">
                                     <!-- Vital Info -->
                                     <div class="clearfix">
	                                     <span class="h5">
    	                                     <span class="font-w600 text-success"><?php echo $pCotizacionesTodos["nombre"]; ?></span><br>
                                             <?php if (isset($row_cotizacionesShowTodos["modelo"])) { ?><small>MODELO: <?php echo $row_cotizacionesShowTodos["modelo"]; ?></small><?php } ?>
                                         </span>
                                     </div>
                                     <hr>
                                     <p><b>Nombre:</b> <?php echo $row_cotizacionesShowTodos["nombre"]; ?><br>
                                     <?php if (isset($row_cotizacionesShowTodos["correo"])) { ?><b>Correo:</b> <?php echo $row_cotizacionesShowTodos["correo"]; ?><br><?php } ?>
                                     <?php if (isset($row_cotizacionesShowTodos["telefono"])) { ?><b>Tel&eacute;fono:</b> <?php echo $row_cotizacionesShowTodos["telefono"]; ?><br><?php } ?></p>
                                     <?php if (isset($row_cotizacionesShowTodos["mensaje"])) { ?>
                                     <hr>
                                     <p><b>Notas:</b><br><?php echo $row_cotizacionesShowTodos["mensaje"]; ?></p>
                                     <?php } ?>
                                     <!-- END Vital Info -->
                                 </div>
                             </div>
 	                    </div>
                        <div class="block-content block-content-full block-content-mini bg-gray-light">
                            <i class="fa fa-fw fa-plus"></i> <span class="font-w600">Responder</span>
                        </div>
                        <div class="block-content">
                            <form class="form-horizontal" action="<?php echo $editFormAction; ?>" method="POST" name="replyCotizacion">
                                <div class="form-group push-10">
                                    <div class="col-xs-12">
                                        <textarea class="js-summernote" name="mensaje">
                                        <p>&nbsp;<p>
                                        <blockquote>
                                        <p style="font-size:12px;"><b>Producto:</b> <?php echo $pCotizacionesTodos["nombre"]; ?><br>
                                        <b>Categor&iacute;a:</b> <?php echo str_replace("-"," ",$pCotizacionesTodos["categoriaSEO"]); ?>
										<?php if (isset($row_cotizacionesShowTodos["modelo"])) { ?>
                                        <br>
                                        <b>Modelo:</b> <?php echo $row_cotizacionesShowTodos["modelo"]; ?> <?php } ?></p>
                                        <?php if (isset($row_cotizacionesShowTodos["mensaje"])) { ?><p style="font-size:12px;"><b>Notas:</b><br><?php echo $row_cotizacionesShowTodos["mensaje"]; ?></p><?php } ?>
                                        <hr><p style="font-size:10px;"><?php echo $row_cotizacionesShowTodos["nombre"]; ?><br><?php echo $row_cotizacionesShowTodos["correo"]; ?><br><?php echo $row_cotizacionesShowTodos["fecha"]; ?></p> 
                                        </blockquote>
                                        </textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <button class="btn btn-sm btn-default" type="submit" onClick="this.form.submit()">
                                            <i class="fa fa-fw fa-reply text-success"></i> Responder
                                        </button>
                                        <button class="btn btn-sm btn-default pull-right" type="button" onClick="location.href='cotizaciones_cerrar.php?id=<?php echo $row_cotizacionesShowTodos["id"]; ?>'">
                                            <i class="fa fa-fw fa-times text-danger"></i> Cerrar
                                        </button>
                                    </div>
                                </div>
                                <input type="hidden" name="fechaReply" value="<?php echo $fechaID; ?>">
                                <input type="hidden" name="ipReply" value="<?php echo $ip; ?>">
                                <input type="hidden" name="estado" value="2">
                                <input type="hidden" name="id" value="<?php echo $row_cotizacionesShowTodos["id"]; ?>">
                                <input type="hidden" name="MM_update" value="replyCotizacion">
                            </form>
                        </div>
                        <div class="block-content block-content-full bg-gray-lighter clearfix">
                            <button class="pull-right btn btn-sm btn-rounded btn-noborder btn-primary" type="button" onClick="location.href='cotizaciones_vista.php?id=<?php echo $row_cotizacionesShowTodos["id"]; ?>'">
                                <i class="fa fa-fw fa-check"></i> Marcar como Visto
                            </button>
                            <button class="btn btn-sm btn-rounded btn-noborder btn-warning" type="button" onClick="location.href='cotizaciones_urgente.php?id=<?php echo $row_cotizacionesShowTodos["id"]; ?>'">
                                <i class="fa fa-fw fa-warning"></i> Marcar como Urgente
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
		<?php } ?>
        <?php } while ($row_cotizacionesShowTodos = mysqli_fetch_assoc($cotizacionesShowTodos)); ?>
        <!-- END cotizaciones -->
		<!-- js -->
        <script src="js/plugins/magnific-popup/magnific-popup.min.js"></script>
        <script src="js/plugins/summernote/summernote.min.js"></script>
        <script src="js/plugins/ckeditor/ckeditor.js"></script>
        <script src="js/plugins/simplemde/simplemde.min.js"></script>
        <script>
            jQuery(function () {
                App.initHelpers(['appear', 'magnific-popup', 'summernote', 'ckeditor', 'simplemde']);
            });
        </script>
<!-- InstanceEndEditable -->
</body>
<!-- InstanceEnd --></html>
<?php
mysqli_free_result($datosAdmin);

mysqli_free_result($contactosPendientes);

mysqli_free_result($contactosTotal);

mysqli_free_result($suscritosTotal);

mysqli_free_result($cotizacionesShow);

mysqli_free_result($cotizacionesTotal);

mysqli_free_result($cotizacionesIngresadas);

mysqli_free_result($cotizacionesUrgentes);

mysqli_free_result($cotizacionesRespondidas);

mysqli_free_result($cotizacionesVistas);

mysqli_free_result($cotizacionesCerradas);

mysqli_free_result($cotizacionesEliminadas);

mysqli_free_result($cotizacionesWeb);

mysqli_free_result($cotizacionesMovil);

mysqli_free_result($cotizacionesShowTodos);

mysqli_free_result($ultimaCotizacion);
?>
