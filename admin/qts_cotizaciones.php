<?php require_once('../Connections/DKKadmin.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
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

$MM_restrictGoTo = "../admin/login.php";
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

$query_cotizaciones = "SELECT * FROM qts_cotizaciones WHERE NOT qts_cotizaciones.estado = '0' ORDER BY qts_cotizaciones.id DESC";
$cotizaciones = mysqli_query($DKKadmin, $query_cotizaciones);
$row_cotizaciones = mysqli_fetch_assoc($cotizaciones);
$totalRows_cotizaciones = mysqli_num_rows($cotizaciones);

$query_cotizacionesHoy = "SELECT * FROM qts_cotizaciones WHERE NOT qts_cotizaciones.estado = '0' AND qts_cotizaciones.fechaID > '$fecha2dias' AND qts_cotizaciones.fechaID < '$fechaHoy' ORDER BY qts_cotizaciones.id DESC";
$cotizacionesHoy = mysqli_query($DKKadmin, $query_cotizacionesHoy);
$row_cotizacionesHoy = mysqli_fetch_assoc($cotizacionesHoy);
$totalRows_cotizacionesHoy = mysqli_num_rows($cotizacionesHoy);

$query_cotizacionesAyer = "SELECT * FROM qts_cotizaciones WHERE NOT qts_cotizaciones.estado = '0' AND qts_cotizaciones.fechaID > '$fechaAyer' AND qts_cotizaciones.fechaID < '$fechaHoy' ORDER BY qts_cotizaciones.id DESC";
$cotizacionesAyer = mysqli_query($DKKadmin, $query_cotizacionesAyer);
$row_cotizacionesAyer = mysqli_fetch_assoc($cotizacionesAyer);
$totalRows_cotizacionesAyer = mysqli_num_rows($cotizacionesAyer);

$query_cotizacionesSemana = "SELECT * FROM qts_cotizaciones WHERE NOT qts_cotizaciones.estado = '0' AND qts_cotizaciones.fechaID > '$fechaSemana' AND qts_cotizaciones.fechaID < '$fechaHoy' ORDER BY qts_cotizaciones.id DESC";
$cotizacionesSemana = mysqli_query($DKKadmin, $query_cotizacionesSemana);
$row_cotizacionesSemana = mysqli_fetch_assoc($cotizacionesSemana);
$totalRows_cotizacionesSemana = mysqli_num_rows($cotizacionesSemana);

$query_cotizacionesMes = "SELECT * FROM qts_cotizaciones WHERE NOT qts_cotizaciones.estado = '0' AND qts_cotizaciones.fechaID > '$fecha1mes' AND qts_cotizaciones.fechaID < '$fechaHoy' ORDER BY qts_cotizaciones.id DESC";
$cotizacionesMes = mysqli_query($DKKadmin, $query_cotizacionesMes);
$row_cotizacionesMes = mysqli_fetch_assoc($cotizacionesMes);
$totalRows_cotizacionesMes = mysqli_num_rows($cotizacionesMes);

$query_cotizacionesAgente = "SELECT * FROM qts_cotizaciones WHERE qts_cotizaciones.creadorID = '$idAdmin' AND NOT qts_cotizaciones.estado = '0' ORDER BY qts_cotizaciones.id DESC";
$cotizacionesAgente = mysqli_query($DKKadmin, $query_cotizacionesAgente);
$row_cotizacionesAgente = mysqli_fetch_assoc($cotizacionesAgente);
$totalRows_cotizacionesAgente = mysqli_num_rows($cotizacionesAgente);

$query_cotizacionesHoyAgente = "SELECT * FROM qts_cotizaciones WHERE qts_cotizaciones.creadorID = '$idAdmin' AND NOT qts_cotizaciones.estado = '0' AND qts_cotizaciones.fechaID > '$fecha2dias' AND qts_cotizaciones.fechaID < '$fechaHoy' ORDER BY qts_cotizaciones.id DESC";
$cotizacionesHoyAgente = mysqli_query($DKKadmin, $query_cotizacionesHoyAgente);
$row_cotizacionesHoyAgente = mysqli_fetch_assoc($cotizacionesHoyAgente);
$totalRows_cotizacionesHoyAgente = mysqli_num_rows($cotizacionesHoyAgente);

$query_cotizacionesAyerAgente = "SELECT * FROM qts_cotizaciones WHERE qts_cotizaciones.creadorID = '$idAdmin' AND NOT qts_cotizaciones.estado = '0' AND qts_cotizaciones.fechaID > '$fechaAyer' AND qts_cotizaciones.fechaID < '$fechaHoy' ORDER BY qts_cotizaciones.id DESC";
$cotizacionesAyerAgente = mysqli_query($DKKadmin, $query_cotizacionesAyerAgente);
$row_cotizacionesAyerAgente = mysqli_fetch_assoc($cotizacionesAyerAgente);
$totalRows_cotizacionesAyerAgente = mysqli_num_rows($cotizacionesAyerAgente);

$query_cotizacionesSemanaAgente = "SELECT * FROM qts_cotizaciones WHERE qts_cotizaciones.creadorID = '$idAdmin' AND NOT qts_cotizaciones.estado = '0' AND qts_cotizaciones.fechaID > '$fechaSemana' AND qts_cotizaciones.fechaID < '$fechaHoy' ORDER BY qts_cotizaciones.id DESC";
$cotizacionesSemanaAgente = mysqli_query($DKKadmin, $query_cotizacionesSemanaAgente);
$row_cotizacionesSemanaAgente = mysqli_fetch_assoc($cotizacionesSemanaAgente);
$totalRows_cotizacionesSemanaAgente = mysqli_num_rows($cotizacionesSemanaAgente);

$query_cotizacionesMesAgente = "SELECT * FROM qts_cotizaciones WHERE qts_cotizaciones.creadorID = '$idAdmin' AND NOT qts_cotizaciones.estado = '0' AND qts_cotizaciones.fechaID > '$fecha1mes' AND qts_cotizaciones.fechaID < '$fechaHoy' ORDER BY qts_cotizaciones.id DESC";
$cotizacionesMesAgente = mysqli_query($DKKadmin, $query_cotizacionesMesAgente);
$row_cotizacionesMesAgente = mysqli_fetch_assoc($cotizacionesMesAgente);
$totalRows_cotizacionesMesAgente = mysqli_num_rows($cotizacionesMesAgente);
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
        <link rel="stylesheet" href="js/plugins/datatables/jquery.dataTables.min.css">
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
				<?php if ($row_datosAdmin["nivel"] == '1') { // Nivel ADMIN ?>
                <!-- pag -->
                <div class="content content-boxed">
                    <!-- cabecera -->
                    <div class="row">
                        <div class="col-sm-6 col-md-3">
                            <a class="block block-link-hover3 text-center" href="javascript:void(0)">
                                <div class="block-content block-content-full">
                                    <div class="h1 font-w700" data-toggle="countTo" data-to="<?php echo $totalRows_cotizacionesHoy; ?>"></div>
                                </div>
                                <div class="block-content block-content-full block-content-mini bg-gray-lighter text-muted font-w600">Hoy</div>
                            </a>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <a class="block block-link-hover3 text-center" href="javascript:void(0)">
                                <div class="block-content block-content-full">
                                    <div class="h1 font-w700" data-toggle="countTo" data-to="<?php echo $totalRows_cotizacionesSemana; ?>"></div>
                                </div>
                                <div class="block-content block-content-full block-content-mini bg-gray-lighter text-muted font-w600">Esta Semana</div>
                            </a>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <a class="block block-link-hover3 text-center" href="javascript:void(0)">
                                <div class="block-content block-content-full">
                                    <div class="h1 font-w700" data-toggle="countTo" data-to="<?php echo $totalRows_cotizacionesMes; ?>"></div>
                                </div>
                                <div class="block-content block-content-full block-content-mini bg-gray-lighter text-muted font-w600">Este Mes</div>
                            </a>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <a class="block block-link-hover3 text-center" href="javascript:void(0)">
                                <div class="block-content block-content-full">
                                    <div class="h1 font-w700" data-toggle="countTo" data-to="<?php echo $totalRows_cotizaciones; ?>"></div>
                                </div>
                                <div class="block-content block-content-full block-content-mini bg-gray-lighter text-muted font-w700">Total Cotizaciones</div>
                            </a>
                        </div>
                    </div>
                    <!-- END cabecera -->

                    <!-- todos los cotizaciones -->
                    <div class="block">
                        <div class="block-header bg-gray-lighter">
                            <!--<ul class="block-options">
                                <li class="dropdown">
                                    <button type="button" data-toggle="dropdown">Filtros <span class="caret"></span></button>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li>
                                            <a tabindex="-1" href="cotizaciones-.php"><span class="badge pull-right">12</span>Variable</a>
                                        </li>
                                        <li class="divider"></li>
                                        <li>
                                            <a tabindex="-1" href="cotizaciones.php"><span class="badge pull-right"><?php echo $totalRows_cotizaciones; ?></span>Todos</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul> -->
                            <h3 class="block-title">Todos los Clientes</h3>
                        </div>
                        <div class="block-content">
                            <table class="table table-borderless table-striped table-vcenter js-dataTable-full">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="width: 100px;">ID</th>
                                        <th class="visible-lg">Cliente</th>
                                        <th class="hidden-xs text-center">Agente</th>
                                        <th>Estado</th>
                                        <th class="hidden-xs text-center">Creación</th>
                                        <th class="text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php do { ?>
                                    <tr>
                                        <td class="text-center">
                                            <a class="font-" href="qts_view.php?id=<?php echo $row_cotizaciones["id"]; ?>">
                                                <strong>QTE.<?php if ($row_cotizaciones["id"] < 10) {echo "0000";} if ($row_cotizaciones["id"] < 100 && $row_cotizaciones["id"] > 10) {echo "000";} if ($row_cotizaciones["id"] < 1000 && $row_cotizaciones["id"] > 100) {echo "00";} if ($row_cotizaciones["id"] < 10000 && $row_cotizaciones["id"] > 1000) {echo "0";} if ($row_cotizaciones["id"] < 100000 && $row_cotizaciones["id"] > 10000) {echo "";} echo $row_cotizaciones["id"]; ?></strong>
                                            </a>
                                        </td>
                                        <td class="visible-lg">
                                            <a href="clientes_view.php?id=<?php echo $row_cotizaciones["clienteID"]; ?>"><?php 
														$idCliente = $row_cotizaciones["clienteID"];
														$datosClienteID = mysqli_query($DKKadmin,"SELECT * FROM qts_clientes WHERE qts_clientes.id = '$idCliente'"); 
														while($daCLI = mysqli_fetch_array($datosClienteID)){ 
													
														if (isset($daCLI["razonSocial"])) {
														$datosCliente = $daCLI['razonSocial']; 
														}
														else {
														$datosCliente = $daCLI['nombre']." ".$daCLI['apellido']; 
														}
													?>
													<?php echo $datosCliente; ?>
												<?php } ?></a>
                                        </td>
                                        <td class="hidden-xs text-center text-muted"><?php 
														$idAgente = $row_cotizaciones["creadorID"];
														$datosAgente = mysqli_query($DKKadmin,"SELECT * FROM admin WHERE admin.id = '$idAgente'"); 
														while($daAGE = mysqli_fetch_array($datosAgente)){ 
													
														$agenteResponsable = $daAGE['nombre']." ".$daAGE['apellido']; 
													?>
													<?php echo $agenteResponsable; ?>
												<?php } ?></td>
                                        <td>
                                            <span class="label label-<?php if ($row_cotizaciones["estado"] == '1') { echo "warning"; } if ($row_cotizaciones["estado"] == '2') { echo "primary"; } if ($row_cotizaciones["estado"] == '3') { echo "success"; } if ($row_cotizaciones["estado"] == '4') { echo "danger"; }; if ($row_cotizaciones["estado"] == '5') { echo "default"; }; if ($row_cotizaciones["estado"] == '6') { echo "danger"; }; if ($row_cotizaciones["estado"] == '0') { echo "danger"; }; ?>"><?php if ($row_cotizaciones["estado"] == '1') { echo "INGRESADA"; } if ($row_cotizaciones["estado"] == '2') { echo "ENVIADA"; } if ($row_cotizaciones["estado"] == '3') { echo "APROBADA"; } if ($row_cotizaciones["estado"] == '4') { echo "RECHAZADA"; }; if ($row_cotizaciones["estado"] == '5') { echo "CERRADA"; }; if ($row_cotizaciones["estado"] == '6') { echo "ELIMINADA"; }; if ($row_cotizaciones["estado"] == '0') { echo "REMOVIDA"; }; ?></span>
                                        </td>
                                        <td class="text-center hidden-xs"><?php echo $time = date("d/m/y h:i",$row_cotizaciones["fechaID"]); ?></td>
                                        <td class="text-center">
                                            <div class="btn-group btn-group-xs">
                                                <a href="qts_edit.php?id=<?php echo $row_cotizaciones["id"]; ?>" data-toggle="tooltip" title="Editar" class="btn btn-default"><i class="fa fa-pencil"></i></a>
                                                <a href="qts_view.php?id=<?php echo $row_cotizaciones["id"]; ?>" data-toggle="tooltip" title="Ver" class="btn btn-default"><i class="fa fa-eye"></i></a>
                                                <a href="qts_eliminar.php?id=<?php echo $row_cotizaciones["id"]; ?>" data-toggle="tooltip" title="Eliminar" class="btn btn-default"><i class="fa fa-times text-danger"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php } while ($row_cotizaciones = mysqli_fetch_assoc($cotizaciones)); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- END todos los cotizaciones -->
                </div>
                <!-- END pag -->
                <?php } ?>
				<?php if ($row_datosAdmin["nivel"] != '1') { // Nivel NO ADMIN ?>
                <!-- pag -->
                <div class="content content-boxed">
                    <!-- cabecera -->
                    <div class="row">
                        <div class="col-sm-6 col-md-3">
                            <a class="block block-link-hover3 text-center" href="javascript:void(0)">
                                <div class="block-content block-content-full">
                                    <div class="h1 font-w700" data-toggle="countTo" data-to="<?php echo $totalRows_cotizacionesHoyAgente; ?>"></div>
                                </div>
                                <div class="block-content block-content-full block-content-mini bg-gray-lighter text-muted font-w600">Hoy</div>
                            </a>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <a class="block block-link-hover3 text-center" href="javascript:void(0)">
                                <div class="block-content block-content-full">
                                    <div class="h1 font-w700" data-toggle="countTo" data-to="<?php echo $totalRows_cotizacionesSemanaAgente; ?>"></div>
                                </div>
                                <div class="block-content block-content-full block-content-mini bg-gray-lighter text-muted font-w600">Esta Semana</div>
                            </a>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <a class="block block-link-hover3 text-center" href="javascript:void(0)">
                                <div class="block-content block-content-full">
                                    <div class="h1 font-w700" data-toggle="countTo" data-to="<?php echo $totalRows_cotizacionesMesAgente; ?>"></div>
                                </div>
                                <div class="block-content block-content-full block-content-mini bg-gray-lighter text-muted font-w600">Este Mes</div>
                            </a>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <a class="block block-link-hover3 text-center" href="javascript:void(0)">
                                <div class="block-content block-content-full">
                                    <div class="h1 font-w700" data-toggle="countTo" data-to="<?php echo $totalRows_cotizacionesAgente; ?>"></div>
                                </div>
                                <div class="block-content block-content-full block-content-mini bg-gray-lighter text-muted font-w700">Total Cotizaciones</div>
                            </a>
                        </div>
                    </div>
                    <!-- END cabecera -->

                    <!-- todos los cotizaciones -->
                    <div class="block">
                        <div class="block-header bg-gray-lighter">
                            <!--<ul class="block-options">
                                <li class="dropdown">
                                    <button type="button" data-toggle="dropdown">Filtros <span class="caret"></span></button>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li>
                                            <a tabindex="-1" href="cotizaciones-.php"><span class="badge pull-right">12</span>Variable</a>
                                        </li>
                                        <li class="divider"></li>
                                        <li>
                                            <a tabindex="-1" href="cotizaciones.php"><span class="badge pull-right"><?php echo $totalRows_cotizaciones; ?></span>Todos</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul> -->
                            <h3 class="block-title">Todos los Clientes</h3>
                        </div>
                        <div class="block-content">
                            <table class="table table-borderless table-striped table-vcenter js-dataTable-full">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="width: 100px;">ID</th>
                                        <th class="visible-lg">Cliente</th>
                                        <th>Estado</th>
                                        <th class="hidden-xs text-center">Creación</th>
                                        <th class="text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php do { ?>
                                    <tr>
                                        <td class="text-center">
                                            <a class="font-" href="qts_view.php?id=<?php echo $row_cotizacionesAgente["id"]; ?>">
                                                <strong>QTE.<?php if ($row_cotizacionesAgente["id"] < 10) {echo "0000";} if ($row_cotizacionesAgente["id"] < 100 && $row_cotizacionesAgente["id"] > 10) {echo "000";} if ($row_cotizacionesAgente["id"] < 1000 && $row_cotizacionesAgente["id"] > 100) {echo "00";} if ($row_cotizacionesAgente["id"] < 10000 && $row_cotizacionesAgente["id"] > 1000) {echo "0";} if ($row_cotizacionesAgente["id"] < 100000 && $row_cotizacionesAgente["id"] > 10000) {echo "";} echo $row_cotizacionesAgente["id"]; ?></strong>
                                            </a>
                                        </td>
                                        <td class="visible-lg">
                                            <a href="clientes_view.php?id=<?php echo $row_cotizacionesAgente["clienteID"]; ?>"><?php 
														$idCliente = $row_cotizacionesAgente["clienteID"];
														$datosClienteID = mysqli_query("SELECT * FROM qts_clientes WHERE qts_clientes.id = '$idCliente'"); 
														while($daCLI = mysqli_fetch_array($datosClienteID)){ 
													
														if (isset($daCLI["razonSocial"])) {
														$datosCliente = $daCLI['razonSocial']; 
														}
														else {
														$datosCliente = $daCLI['nombre']." ".$daCLI['apellido']; 
														}
													?>
													<?php echo $datosCliente; ?>
												<?php } ?></a>
                                        </td>
                                        <td>
                                            <span class="label label-<?php if ($row_cotizacionesAgente["estado"] == '1') { echo "warning"; } if ($row_cotizacionesAgente["estado"] == '2') { echo "success"; } if ($row_cotizacionesAgente["estado"] == '3') { echo "primary"; } if ($row_cotizacionesAgente["estado"] == '0') { echo "danger"; }; ?>"><?php if ($row_cotizacionesAgente["estado"] == '1') { echo "INGRESADA"; } if ($row_cotizacionesAgente["estado"] == '2') { echo "ENVIADA"; } if ($row_cotizacionesAgente["estado"] == '3') { echo "CANCELADA"; } if ($row_cotizacionesAgente["estado"] == '0') { echo "ELIMINADA"; }; ?></span>
                                        </td>
                                        <td class="hidden-xs text-center text-muted"><?php echo $time = date("d/m/y h:i",$row_cotizacionesAgente["fechaID"]); ?></td>
                                        <td class="text-center">
                                            <div class="btn-group btn-group-xs">
                                                <a href="qts_view.php?id=<?php echo $row_cotizacionesAgente["id"]; ?>" data-toggle="tooltip" title="Ver" class="btn btn-default"><i class="fa fa-eye"></i></a>
                                                <a href="qts_remove.php?id=<?php echo $row_cotizacionesAgente["id"]; ?>" data-toggle="tooltip" title="Eliminar" class="btn btn-default"><i class="fa fa-times text-danger"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php } while ($row_cotizacionesAgente = mysqli_fetch_assoc($cotizacionesAgente)); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- END todos los cotizaciones -->
                </div>
                <!-- END pag -->
                <?php } ?>
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
        <script src="js/plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="js/pages/base_tables_datatables.js"></script>
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

mysqli_free_result($cotizaciones);

mysqli_free_result($cotizacionesHoy);

mysqli_free_result($cotizacionesAyer);

mysqli_free_result($cotizacionesSemana);

mysqli_free_result($cotizacionesMes);

mysqli_free_result($cotizacionesAgente);

mysqli_free_result($cotizacionesHoyAgente);

mysqli_free_result($cotizacionesAyerAgente);

mysqli_free_result($cotizacionesSemanaAgente);

mysqli_free_result($cotizacionesMesAgente);
?>
