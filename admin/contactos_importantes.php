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
$idAdmin = $_SESSION["MM_idAdmin"];
?>
<?php 
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

$currentPage = $_SERVER["PHP_SELF"];

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "nuevoMensaje")) {
  $insertSQL = sprintf("INSERT INTO contacto (nombre, correo, asunto, mensaje, fecha, fechaID, ip, estado) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['nombre'], "text"),
                       GetSQLValueString($_POST['correo'], "text"),
                       GetSQLValueString($_POST['asunto'], "text"),
                       GetSQLValueString($_POST['mensaje'], "text"),
                       GetSQLValueString($_POST['fecha'], "text"),
                       GetSQLValueString($_POST['fechaID'], "text"),
                       GetSQLValueString($_POST['ip'], "text"),
                       GetSQLValueString($_POST['estado'], "text"));

  $Result1 = mysqli_query($DKKadmin, $insertSQL) or die(mysqli_error($DKKadmin));

  $insertGoTo = "contactos_send.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "replyMensaje")) {
  $insertSQL = sprintf("INSERT INTO contacto (nombre, correo, telefono, asunto, mensaje, fecha, fechaID, ip, estado, respondido) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['nombre'], "text"),
                       GetSQLValueString($_POST['correo'], "text"),
                       GetSQLValueString($_POST['telefono'], "text"),
                       GetSQLValueString($_POST['asunto'], "text"),
                       GetSQLValueString($_POST['mensaje'], "text"),
                       GetSQLValueString($_POST['fecha'], "text"),
                       GetSQLValueString($_POST['fechaID'], "text"),
                       GetSQLValueString($_POST['ip'], "text"),
                       GetSQLValueString($_POST['estado'], "text"),
                       GetSQLValueString($_POST['respondido'], "text"));

  $Result1 = mysqli_query($DKKadmin, $insertSQL) or die(mysqli_error($DKKadmin));

  $insertGoTo = "contactos_reply.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

;
$query_datosAdmin = "SELECT * FROM admin WHERE admin.id = '$idAdmin'";
$datosAdmin = mysqli_query($DKKadmin, $query_datosAdmin) or die(mysqli_error($DKKadmin));
$row_datosAdmin = mysqli_fetch_assoc($datosAdmin);
$totalRows_datosAdmin = mysqli_num_rows($datosAdmin);

;
$query_contactosPendientes = "SELECT * FROM contacto WHERE contacto.estado = '1' ORDER BY contacto.id DESC";
$contactosPendientes = mysqli_query($DKKadmin, $query_contactosPendientes) or die(mysqli_error($DKKadmin));
$row_contactosPendientes = mysqli_fetch_assoc($contactosPendientes);
$totalRows_contactosPendientes = mysqli_num_rows($contactosPendientes);

$maxRows_contactosShow = 15;
$pageNum_contactosShow = 0;
if (isset($_GET['pageNum_contactosShow'])) {
  $pageNum_contactosShow = $_GET['pageNum_contactosShow'];
}
$startRow_contactosShow = $pageNum_contactosShow * $maxRows_contactosShow;

;
$query_contactosShow = "SELECT * FROM contacto WHERE contacto.importante = '1' AND NOT contacto.estado = '0' ORDER BY contacto.id DESC";
$query_limit_contactosShow = sprintf("%s LIMIT %d, %d", $query_contactosShow, $startRow_contactosShow, $maxRows_contactosShow);
$contactosShow = mysqli_query($DKKadmin, $query_limit_contactosShow) or die(mysqli_error($DKKadmin));
$row_contactosShow = mysqli_fetch_assoc($contactosShow);

if (isset($_GET['totalRows_contactosShow'])) {
  $totalRows_contactosShow = $_GET['totalRows_contactosShow'];
} else {
  $all_contactosShow = mysqli_query($DKKadmin, $query_contactosShow);
  $totalRows_contactosShow = mysqli_num_rows($all_contactosShow);
}
$totalPages_contactosShow = ceil($totalRows_contactosShow/$maxRows_contactosShow)-1;

;
$query_contactosImportantes = "SELECT * FROM contacto WHERE contacto.importante = '1' AND NOT contacto.estado = '0' ORDER BY contacto.id DESC";
$contactosImportantes = mysqli_query($DKKadmin, $query_contactosImportantes) or die(mysqli_error($DKKadmin));
$row_contactosImportantes = mysqli_fetch_assoc($contactosImportantes);
$totalRows_contactosImportantes = mysqli_num_rows($contactosImportantes);

;
$query_contactosEnviados = "SELECT * FROM contacto WHERE contacto.estado = '2' ORDER BY contacto.id DESC";
$contactosEnviados = mysqli_query($DKKadmin, $query_contactosEnviados) or die(mysqli_error($DKKadmin));
$row_contactosEnviados = mysqli_fetch_assoc($contactosEnviados);
$totalRows_contactosEnviados = mysqli_num_rows($contactosEnviados);

;
$query_contactosRespondidos = "SELECT * FROM contacto WHERE contacto.respondido = '1' AND NOT contacto.estado = '0' ORDER BY contacto.id DESC";
$contactosRespondidos = mysqli_query($DKKadmin, $query_contactosRespondidos) or die(mysqli_error($DKKadmin));
$row_contactosRespondidos = mysqli_fetch_assoc($contactosRespondidos);
$totalRows_contactosRespondidos = mysqli_num_rows($contactosRespondidos);

;
$query_contactosArchivados = "SELECT * FROM contacto WHERE contacto.estado = '3' ORDER BY contacto.id DESC";
$contactosArchivados = mysqli_query($DKKadmin, $query_contactosArchivados) or die(mysqli_error($DKKadmin));
$row_contactosArchivados = mysqli_fetch_assoc($contactosArchivados);
$totalRows_contactosArchivados = mysqli_num_rows($contactosArchivados);

;
$query_contactosEliminados = "SELECT * FROM contacto WHERE contacto.estado = '0' ORDER BY contacto.id DESC";
$contactosEliminados = mysqli_query($DKKadmin, $query_contactosEliminados) or die(mysqli_error($DKKadmin));
$row_contactosEliminados = mysqli_fetch_assoc($contactosEliminados);
$totalRows_contactosEliminados = mysqli_num_rows($contactosEliminados);

;
$query_contactosShowTodos = "SELECT * FROM contacto WHERE contacto.importante = '1' AND NOT contacto.estado = '0' ORDER BY contacto.id DESC";
$contactosShowTodos = mysqli_query($DKKadmin, $query_contactosShowTodos) or die(mysqli_error($DKKadmin));
$row_contactosShowTodos = mysqli_fetch_assoc($contactosShowTodos);
$totalRows_contactosShowTodos = mysqli_num_rows($contactosShowTodos);

$queryString_contactosShow = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_contactosShow") == false && 
        stristr($param, "totalRows_contactosShow") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_contactosShow = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_contactosShow = sprintf("&totalRows_contactosShow=%d%s", $totalRows_contactosShow, $queryString_contactosShow);
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
                <!-- contenido -->
                <div class="content">
                    <div class="row">
                        <div class="col-sm-5 col-lg-3">
                            <button class="btn btn-block btn-primary visible-xs push" data-toggle="collapse" data-target="#inbox-nav" type="button">Navegación</button>
                            <div class="collapse navbar-collapse remove-padding" id="inbox-nav">
                                <!-- Inbox Menu -->
                                <div class="block">
                                    <div class="block-header bg-gray-lighter">
                                        <ul class="block-options">
                                            <li>
                                                <button data-toggle="modal" data-target="#nuevoMensaje" type="button"><i class="fa fa-pencil"></i> Nuevo Mensaje</button>
                                            </li>
                                        </ul>
                                        <h3 class="block-title">MailBox</h3>
                                    </div>
                                    <div class="block-content">
                                        <ul class="nav nav-pills nav-stacked push">
                                            <li>
                                                <a href="contactos.php">
                                                    <span class="badge pull-right"><?php echo $totalRows_contactosPendientes; ?></span><i class="fa fa-fw fa-inbox push-5-r"></i> Recibidos
                                                </a>
                                            </li>
                                            <li class="active">
                                                <a href="contactos_importantes.php">
                                                    <span class="badge pull-right"><?php echo $totalRows_contactosImportantes; ?></span><i class="fa fa-fw fa-star push-5-r"></i> Importantes
                                                </a>
                                            </li>
                                            <li>
                                                <a href="contactos_enviados.php">
                                                    <span class="badge pull-right"><?php echo $totalRows_contactosEnviados; ?></span><i class="fa fa-fw fa-send push-5-r"></i> Enviados
                                                </a>
                                            </li>
                                            <li>
                                                <a href="contactos_respondidos.php">
                                                    <span class="badge pull-right"><?php echo $totalRows_contactosRespondidos; ?></span><i class="fa fa-fw fa-pencil push-5-r"></i> Respondidos
                                                </a>
                                            </li>
                                            <li>
                                                <a href="contactos_archivados.php">
                                                    <span class="badge pull-right"><?php echo $totalRows_contactosArchivados; ?></span><i class="fa fa-fw fa-folder push-5-r"></i> Archivados
                                                </a>
                                            </li>
                                            <li>
                                                <a href="contactos_eliminados.php">
                                                    <span class="badge pull-right"><?php echo $totalRows_contactosEliminados; ?></span><i class="fa fa-fw fa-trash push-5-r"></i> Eliminados
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- END Mailbox -->

                                <!-- Últimos Suscritos
                                <div class="block">
                                    <div class="block-header bg-gray-lighter">
                                        <h3 class="block-title">Últimos Suscritos</h3>
                                    </div>
                                    <div class="block-content">
                                        <ul class="nav-users push">
                                            
                                            <?php do { ?>
                                            <li>
                                                <a href="mailto:<?php echo $row_ultimosSuscritos["correo"]; ?>">
                                                  <img class="img-avatar" src="img/avatars/generico.jpg" alt="">
                                                  <i class="fa fa-circle text-<?php if ($row_ultimosSuscritos["estado"] == '1') {echo"success";} if ($row_ultimosSuscritos["estado"] == '2') {echo"warning";} if ($row_ultimosSuscritos["estado"] == '0') {echo"danger";}  ?>"></i> <?php echo $row_ultimosSuscritos["correo"]; ?>
                                                  <div class="font-w400 text-muted"><small><?php echo $time.$row_ultimosSuscritos["id"] = date("d/m/Y h:i A T",$row_ultimosSuscritos["fecha"]) ; ?></small></div>
                                                </a>
                                            </li>
                                            <?php } while ($row_ultimosSuscritos = mysqli_fetch_assoc($ultimosSuscritos)); ?>

                                        </ul>
                                    </div>
                                </div>
                                END últimos suscritos -->

                            </div>
                        </div>
                        <div class="col-sm-7 col-lg-9">
                            <!-- mensajes -->
                            <div class="block">
                                <div class="block-header bg-gray-lighter">
                                    <ul class="block-options">
                                        <?php if ($pageNum_contactosShow > 0) { // Mostrar si hay más de 15 mensajes ?><li>
											<button class="js-tooltip" title="Anteriores 15 Mensajes" type="button" data-toggle="block-option" onClick="location.href='<?php printf("%s?pageNum_contactosShow=%d%s", $currentPage, max(0, $pageNum_contactosShow - 1), $queryString_contactosShow); ?>'"><i class="si si-arrow-left"></i></button>
                                        </li><?php } // Mostrar si hay más de 15 mensajes ?>
                                        <?php if ($pageNum_contactosShow < $totalPages_contactosShow) { // Mostrar si hay más de 15 mensajes ?><li>
                                            <button class="js-tooltip" title="Siguientes 15 Mensajes" type="button" data-toggle="block-option" onClick="location.href='<?php printf("%s?pageNum_contactosShow=%d%s", $currentPage, min($totalPages_contactosShow, $pageNum_contactosShow + 1), $queryString_contactosShow); ?>'"><i class="si si-arrow-right"></i></button>
                                        </li><?php } // Mostrar si hay más de 15 mensajes ?>
                                        <li>
                                            <button type="button" data-toggle="block-option" data-action="refresh_toggle" data-action-mode="demo" onClick="window.location.reload()"><i class="si si-refresh"></i></button>
                                        </li>
                                        <li>
                                            <button type="button" data-toggle="block-option" data-action="fullscreen_toggle"></button>
                                        </li>
                                    </ul>
                                    <div class="block-title text-normal">
                                        <strong><?php echo ($startRow_contactosShow + 1) ?>-<?php echo min($startRow_contactosShow + $maxRows_contactosShow, $totalRows_contactosShow) ?></strong> <span class="font-w400">de</span> <strong><?php echo $totalRows_contactosShow; ?></strong>
                                    </div>
                                </div>
                                <div class="block-content">

                                    <div class="pull-r-l">
                                        <table class="js-table-checkable table table-hover table-vcenter">
                                            <tbody>
                                                
                                                <?php do { ?>
                                                <tr>
                                                    <td class="text-center" style="width: 70px;">
                                                      <?php if ($row_contactosShow["importante"] == '1') { ?><a href='contactos_unstar.php?id=<?php echo $row_contactosShow["id"]; ?>'><i class='fa fa-star text-warning'></i></a><?php } ?>
													  <?php if ($row_contactosShow["importante"] == '0') { ?><a href='contactos_star.php?id=<?php echo $row_contactosShow["id"]; ?>'><i class='fa fa-star-o text-warning'></i></a><?php } ?>
                                                    </td>
                                                    <td class="hidden-xs font-w600" style="width: 140px;"><?php echo $row_contactosShow["nombre"]; ?></td>
                                                    <td>
                                                      <a class="font-w600" data-toggle="modal" data-target="#mensaje<?php echo $row_contactosShow["id"]; ?>"><?php echo $row_contactosShow["asunto"]; ?></a>
                                                      <div class="text-muted push-5-t"><?php echo substr($row_contactosShow["mensaje"],0,55)."..."; ?></div>
                                                    </td>
                                                    <td class="visible-lg text-muted" style="width: 120px;">
                                                      <em>
                                                      <?php  
															$fechaMailbox = "fechaMailbox".$row_contactosShow["id"];
															$segundosMailbox = "segundosMailbox".$row_contactosShow["id"];
															$diferenciaDiasMailbox = "diferenciaDiasMailbox".$row_contactosShow["id"];
															$fechaMailbox = $row_contactosShow["fecha"];
															$segundosMailbox = strtotime($fechaMailbox) - strtotime('now');
															$diferenciaDiasMailbox = intval($segundosMailbox/60/60/24);
															if ($diferenciaDiasMailbox > 0) {
															echo "hace ".(str_replace("-", " ", ($diferenciaDiasMailbox)))." días";
															}
															if ($diferenciaDiasMailbox < 1) { 
															echo "hace ".(str_replace("-", " ", (number_format($segundosMailbox/60/60,0,",","."))))." horas";
															}
														?>
                                                      </em>
                                                    </td>
                                                </tr>
                                                <?php } while ($row_contactosShow = mysqli_fetch_assoc($contactosShow)); ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- END mensajes -->
                                </div>
                            </div>
                            <!-- END mailbox -->
                        </div>
                    </div>
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
        
        <!-- nuevo mensaje -->
        <div class="modal fade" id="nuevoMensaje" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-top">
                <div class="modal-content">
                    <div class="block block-themed block-transparent remove-margin-b">
                        <div class="block-header bg-success">
                            <ul class="block-options">
                                <li>
                                    <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
                                </li>
                            </ul>
                            <h3 class="block-title"><i class="fa fa-pencil"></i> Nuevo Mensaje</h3>
                        </div>
                        <div class="block-content">
                          <form method="POST" action="<?php echo $editFormAction; ?>" class="form-horizontal push-10-t push-10" name="nuevoMensaje">
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <div class="form-material form-material-success floating input-group">
                                            <input class="form-control" type="text" id="nombre" name="nombre" required>
                                            <label for="nombre">Nombre</label>
                                            <span class="input-group-addon"><i class="si si-user"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <div class="form-material form-material-success floating input-group">
                                            <input class="form-control" type="email" id="correo" name="correo" required>
                                            <label for="correo">Email</label>
                                            <span class="input-group-addon"><i class="si si-envelope-open"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <div class="form-material form-material-success floating input-group">
                                            <input class="form-control" type="text" id="asunto" name="asunto" required>
                                            <label for="asunto">Asunto</label>
                                            <span class="input-group-addon"><i class="si si-book-open"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <div class="form-material form-material-success floating">
                                            <textarea class="form-control" id="js-ckeditor" name="mensaje"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <input type="hidden" name="ip" value="<?php echo $ip; ?>">
                                        <input type="hidden" name="fecha" value="<?php echo $fecha; ?>">
                                        <input type="hidden" name="fechaID" value="<?php echo $fechaID; ?>">
                                        <input type="hidden" name="estado" value="2">
                                        <button class="btn btn-sm btn-success" type="submit"><i class="fa fa-send push-5-r"></i> Enviar Mensaje</button>
                                    </div>
                                </div>
                                <input type="hidden" name="MM_insert" value="nuevoMensaje">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END nuevo mensaje -->

        <?php do { ?>
        <!-- mensaje #<?php echo $row_contactosShowTodos["id"]; ?> -->
        <div class="modal fade" id="mensaje<?php echo $row_contactosShowTodos["id"]; ?>" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-popout">
                <div class="modal-content">
                    <div class="block block-themed block-transparent remove-margin-b">
                        <div class="block-header bg-primary-dark">
                            <ul class="block-options">
                                <li>
                                    <button data-dismiss="modal" type="button" onClick="location.href='contactos_remove.php?id=<?php echo $row_contactosShowTodos["id"]; ?>'"><i class="si si-trash"></i></button>
                                </li>
                                <li>
                                    <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
                                </li>
                            </ul>
                            <h3 class="block-title"><?php echo strtoupper($row_contactosShowTodos["asunto"]); ?></h3>
                        </div>
                        <div class="block-content block-content-full">
                            <div class="row">
                                <div class="col-sm-6">
                                    <ul class="nav-users">
                                        <li>
                                            <a>
                                                <img class="img-avatar" src="img/avatars/generico.jpg" alt="">
                                                <i class="fa fa-circle text-<?php if ($row_contactosShowTodos["estado"] == '1') {echo"success";}; if ($row_contactosShowTodos["estado"] == '3') {echo"warning";};  if ($row_contactosShowTodos["estado"] == '0') {echo"danger";}; ?>"></i> <?php echo $row_contactosShowTodos["nombre"]; ?>
                                                <div class="font-w400 text-muted"><small><i class="fa fa-user"></i> <?php echo $row_contactosShowTodos["correo"]; ?></small></div>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-sm-6">
                                    <ul class="nav-users">
                                        <li>
                                            <a>
                                                <img class="img-avatar" src="img/avatars/<?php echo $row_datosAdmin["avatar"]; ?>" alt="Origen | <?php echo $row_datosAdmin["nombre"]; ?>">
                                                <i class="fa fa-circle text-success"></i> <span class="text-amethyst"><?php echo $row_datosAdmin["nombre"]." ".$row_datosAdmin["apellido"]; ?></span>
                                                <div class="font-w400 text-muted"><small><i class="fa fa-support"></i> <?php echo $row_datosAdmin["correo"]; ?></small></div>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="block-content block-content-full block-content-mini bg-gray-light">
                            <span class="text-muted pull-right"><em><?php  
																	$fechaMailbox = "fechaMailbox".$row_contactosShowTodos["id"];
																	$segundosMailbox = "segundosMailbox".$row_contactosShowTodos["id"];
																	$diferenciaDiasMailbox = "diferenciaDiasMailbox".$row_contactosShowTodos["id"];
																	$fechaMailbox = $row_contactosShowTodos["fecha"];
																	$segundosMailbox = strtotime($fechaMailbox) - strtotime('now');
																	$diferenciaDiasMailbox = intval($segundosMailbox/60/60/24);
																	if ($diferenciaDiasMailbox > 0) {
																	echo "hace ".(str_replace("-", " ", ($diferenciaDiasMailbox)))." días";
																	}
																	if ($diferenciaDiasMailbox < 1) { 
																	echo "hace ".(str_replace("-", " ", (number_format($segundosMailbox/60/60,0,",","."))))." horas";
																	}
																?></em></span>
                            <span class="font-w600"><?php echo $row_contactosShowTodos["asunto"]; ?></span> por
                            <a href="javascript:void(0)"><?php echo $row_contactosShowTodos["nombre"]; ?></a>
                        </div>
                        <div class="block-content">
                            <p><?php echo $row_contactosShowTodos["mensaje"]; ?></p>
                        </div>
                        <div class="block-content block-content-full block-content-mini bg-gray-light">
                            <i class="fa fa-fw fa-plus"></i> <span class="font-w600">Responder</span>
                        </div>
                        <div class="block-content">
                          <form method="POST" action="<?php echo $editFormAction; ?>" class="form-horizontal" name="replyMensaje">
                                <div class="form-group push-10">
                                    <div class="col-xs-12">
                                        <textarea class="js-summernote" name="mensaje">
                                        <br><br><blockquote><small><br>Re: <?php echo $row_contactosShowTodos["asunto"]; ?><br><?php echo $row_contactosShowTodos["nombre"]; ?> - <?php echo $row_contactosShowTodos["correo"]; ?><br><?php echo $row_contactosShowTodos["fecha"]; ?><br><br>
										<?php echo $row_contactosShowTodos["mensaje"]; ?></small></blockquote>
                                        </textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <input type="hidden" name="nombre" value="<?php echo $row_contactosShowTodos["nombre"]; ?>">
                                        <input type="hidden" name="correo" value="<?php echo $row_contactosShowTodos["correo"]; ?>">
                                        <input type="hidden" name="telefono" value="<?php echo $row_contactosShowTodos["telefono"]; ?>">
                                        <input type="hidden" name="asunto" value="Re: <?php echo $row_contactosShowTodos["asunto"]; ?>">
                                        <input type="hidden" name="fecha" value="<?php echo $fecha; ?>">
                                        <input type="hidden" name="fechaID" value="<?php echo $fechaHoy; ?>">
                                        <input type="hidden" name="ip" value="<?php echo $ip; ?>">
                                        <input type="hidden" name="estado" value="2">
                                        <input type="hidden" name="respondido" value="1">
                                        <button class="btn btn-sm btn-default" type="submit">
                                            <i class="fa fa-fw fa-reply text-success"></i> Responder
                                        </button>
                                        <button class="btn btn-sm btn-default" type="reset">
                                            <i class="fa fa-fw fa-repeat text-danger"></i> Limpiar
                                        </button>
                                    </div>
                                </div>
                                <input type="hidden" name="MM_insert" value="replyMensaje">
                            </form>
                        </div>
                        <div class="block-content block-content-full bg-gray-lighter clearfix">
                            <button class="pull-right btn btn-sm btn-rounded btn-noborder btn-primary" type="button" onClick="location.href='contactos_archivar.php?id=<?php echo $row_contactosShowTodos["id"]; ?>'">
                                <i class="fa fa-fw fa-archive"></i> Archivar
                            </button>
                            <button class="btn btn-sm btn-rounded btn-noborder btn-warning" type="button" onClick="location.href='contactos_star.php?id=<?php echo $row_contactosShowTodos["id"]; ?>'">
                                <i class="fa fa-fw fa-star"></i> Marcar como Importante
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END mensaje #<?php echo $row_contactosShowTodos["id"]; ?> -->
        <?php } while ($row_contactosShowTodos = mysqli_fetch_assoc($contactosShowTodos)); ?>
		<script src="js/plugins/easy-pie-chart/jquery.easypiechart.min.js"></script>
        <script src="js/plugins/summernote/summernote.min.js"></script>
        <script src="js/plugins/ckeditor/ckeditor.js"></script>
        <script src="js/plugins/simplemde/simplemde.min.js"></script>
        <script>
            jQuery(function ($DKKadmin) {
                App.initHelpers(['summernote', 'ckeditor', 'simplemde', 'table-tools', 'easy-pie-chart']);
            });
        </script>
    <!-- InstanceEndEditable -->
</body>
<!-- InstanceEnd --></html>
<?php
mysqli_free_result($datosAdmin);

mysqli_free_result($contactosPendientes);

mysqli_free_result($contactosShow);

mysqli_free_result($contactosImportantes);

mysqli_free_result($contactosEnviados);

mysqli_free_result($contactosRespondidos);

mysqli_free_result($contactosArchivados);

mysqli_free_result($contactosEliminados);

mysqli_free_result($contactosShowTodos);
?>
