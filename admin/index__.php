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
$fecha = date('Y-m-d H:i:s');
$fechaID = strtotime($fecha);
$fechaAyer = strtotime( '-1 day' ,$fechaID);
$fecha2dias = strtotime( '-2 day' ,$fechaID);
$fecha3dias = strtotime( '-3 day' ,$fechaID);
$fecha4dias = strtotime( '-4 day' ,$fechaID);
$fecha5dias = strtotime( '-5 day' ,$fechaID);
$fecha6dias = strtotime( '-6 day' ,$fechaID);
$fecha1semana = strtotime( '-1 week' ,$fechaID);
$fecha10dias = strtotime( '-10 day' ,$fechaID);
$fecha15dias = strtotime( '-15 day' ,$fechaID);
$fecha1mes = strtotime( '-1 month' ,$fechaID);
$fecha2meses = strtotime( '-2 month' ,$fechaID);
$fecha3meses = strtotime( '-3 month' ,$fechaID);
$fecha6meses = strtotime( '-6 month' ,$fechaID);
$fechayear = strtotime( '-1 year' ,$fechaID);
$pagina= 'home';


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

$query_visitas6dias = "SELECT * FROM visitas WHERE visitas.fechaID >= '$fecha1semana' AND visitas.fechaID <= '$fecha6dias' ORDER BY visitas.id DESC";
$visitas6dias = mysqli_query($DKKadmin, $query_visitas6dias) or die(mysqli_error($DKKadmin));
$row_visitas6dias = mysqli_fetch_assoc($visitas6dias);
$totalRows_visitas6dias = mysqli_num_rows($visitas6dias);

$query_visitasTotal = "SELECT * FROM visitas ORDER BY visitas.id DESC";
$visitasTotal = mysqli_query($DKKadmin, $query_visitasTotal) or die(mysqli_error($DKKadmin));
$row_visitasTotal = mysqli_fetch_assoc($visitasTotal);
$totalRows_visitasTotal = mysqli_num_rows($visitasTotal);

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

$query_productosVisitasTotal = "SELECT SUM(productos.visitas) as totalVisitasProductos FROM productos";
$productosVisitasTotal = mysqli_query($DKKadmin, $query_productosVisitasTotal) or die(mysqli_error($DKKadmin));
$row_productosVisitasTotal = mysqli_fetch_assoc($productosVisitasTotal);
$totalRows_productosVisitasTotal = mysqli_num_rows($productosVisitasTotal);

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
				<!-- header -->
                <div class="content bg-image overflow-hidden" style="background-image: url('img/bg/1.jpg');">
                    <div class="push-50-t push-15">
                        <h1 class="h2 text-white animated zoomIn">Dashboard</h1>
                        <h2 class="h5 text-white-op animated zoomIn">Hola <?php echo $row_datosAdmin["nombre"]." ".$row_datosAdmin["apellido"]; ?>.</h2>
                    </div>
                </div>
                <!-- END header -->

                <!-- estadísticas -->
                <div class="content bg-white border-b">
                    <div class="row items-push text-uppercase">
                        <div class="col-xs-6 col-sm-3">
                            <div class="font-w700 text-gray-darker animated fadeIn">Productos Publicados</div>
                            <div class="text-muted animated fadeIn"><small><i class="si si-briefcase"></i> Total</small></div>
                            <a class="h2 font-w300 text-primary animated flipInX" href="productos.php"><?php echo $totalRows_productosTotal; ?></a>
                        </div>
                        <div class="col-xs-6 col-sm-3">
                            <div class="font-w700 text-gray-darker animated fadeIn">Visitas a los Productos</div>
                            <div class="text-muted animated fadeIn"><small><i class="si si-eye"></i> Total</small></div>
                            <a class="h2 font-w300 text-primary animated flipInX" href="productos.php"><?php echo number_format($row_productosVisitasTotal['totalVisitasProductos'],0,",","."); ?></a>
                        </div>
                        <div class="col-xs-6 col-sm-3">
                            <div class="font-w700 text-gray-darker animated fadeIn">Visitas Hoy</div>
                            <div class="text-muted animated fadeIn"><small><i class="si si-clock"></i> &Uacute;ltimas 24 hrs.</small></div>
                            <a class="h2 font-w300 text-primary animated flipInX" href="home.php"><?php echo $totalRows_visitasHoy; ?></a>
                        </div>
                        <div class="col-xs-6 col-sm-3">
                            <div class="font-w700 text-gray-darker animated fadeIn">Visitas Hist&oacute;rico</div>
                            <div class="text-muted animated fadeIn"><small><i class="si si-calendar"></i> Todos los tiempos</small></div>
                            <a class="h2 font-w300 text-primary animated flipInX" href="home.php"><?php echo $totalRows_visitasTotal; ?></a>
                        </div>
                    </div>
                </div>
                <!-- END estadísticas -->

                <!-- contenido -->
                <div class="content">
                    <div class="row">
                        <div class="col-lg-8">
                            <!-- grafico de la ultima semana -->
                            <div class="block">
                                <div class="block-header">
                                    <h3 class="block-title">&Uacute;ltima Semana</h3>
                                </div>
                                <div class="block-content block-content-full bg-gray-lighter text-center">
                                    <div style="height: 374px;"><canvas class="js-dash-chartjs-lines"></canvas></div>
                                </div>
                                <div class="block-content text-center">
                                    <div class="row items-push text-center">
                                        <div class="col-xs-6 col-lg-3">
                                            <div class="push-10"><i class="si si-share fa-2x"></i></div>
                                            <div class="h5 font-w300 text-muted"><?php echo number_format($totalRows_blogTotal,0,",","."); ?> Noticias</div>
                                        </div>
                                        <div class="col-xs-6 col-lg-3">
                                            <div class="push-10"><i class="si si-users fa-2x"></i></div>
                                            <div class="h5 font-w300 text-muted"><?php echo number_format($row_blogVisitasTotal['totalVisitasNoticias'],0,",","."); ?> Visitas</div>
                                        </div>
                                        <div class="col-xs-6 col-lg-3 visible-lg">
                                            <div class="push-10"><i class="si si-star fa-2x"></i></div>
                                            <div class="h5 font-w300 text-muted"><?php echo number_format($totalRows_visitasHoy,0,",","."); ?> Visitantes Hoy</div>
                                        </div>
                                        <div class="col-xs-6 col-lg-3 visible-lg">
                                            <div class="push-10"><i class="si si-graph fa-2x"></i></div>
                                            <div class="h5 font-w300 text-muted"><?php echo number_format($totalRows_visitasAyer,0,",","."); ?> Visitantes Ayer</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- END grafico ultima semana -->
                        </div>

                        <div class="col-lg-4">
                            <div class="content-grid">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <!-- tu perfil -->
                                        <a class="block block-link-hover2" href="miperfil.php">
                                            <div class="block-header">
                                                <h3 class="block-title text-center">Tus Datos</h3>
                                            </div>
                                            <div class="block-content block-content-full text-center bg-image" style="background-image: url('img/bg/2.jpg');">
                                                <div>
                                                    <img class="img-avatar img-avatar96 img-avatar-thumb" src="img/avatars/<?php echo $row_datosAdmin["avatar"]; ?>" alt="<?php echo $row_datosAdmin["aka"]; ?>">
                                                </div>
                                                <div class="h5 text-white push-15-t push-5"><?php echo $row_datosAdmin["nombre"]; ?></div>
                                                <div class="h5 text-white-op"><?php echo $row_datosAdmin["correo"]; ?></div>
                                            </div>
                                            <div class="block-content">
                                                <div class="row items-push text-center">
                                                    <div class="col-xs-6">
                                                        <div class="push-5"><i class="si si-eyeglasses fa-2x"></i></div>
                                                        <div class="h5 font-w300 text-muted"><?php echo $totalRows_blogTotal; ?> Noticias</div>
                                                    </div>
                                                    <div class="col-xs-6">
                                                        <div class="push-5"><i class="si si-star fa-2x"></i></div>
                                                        <div class="h5 font-w300 text-muted"><?php echo $totalRows_productosTotal; ?> Productos</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                        <!-- END tu perfil -->

                                        <!-- mini estadisticas -->
                                        <a class="block block-link-hover3" href="javascript:void(0)">
                                            <table class="block-table text-center">
                                                <tbody>
                                                    <tr>
                                                        <td style="width: 50%;">
                                                            <div class="push-30 push-30-t">
                                                                <i class="si si-graph fa-3x text-primary"></i>
                                                            </div>
                                                        </td>
                                                        <td class="bg-gray-lighter" style="width: 50%;">
                                                            <div class="h1 font-w700"><span class="h2 text-muted"><?php if ($totalRows_visitasHoy > $totalRows_visitasAyer) {echo"+";}; ?></span> <?php echo number_format(($totalRows_visitasHoy - $totalRows_visitasAyer),0,",","."); ?></div>
                                                            <div class="h5 text-muted text-uppercase push-5-t">vs. Ayer</div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </a>
                                        <a class="block block-link-hover3" href="javascript:void(0)">
                                            <table class="block-table text-center">
                                                <tbody>
                                                    <tr>
                                                        <td style="width: 50%;">
                                                            <div class="push-30 push-30-t">
                                                                <i class="si si-social-dribbble fa-3x text-smooth"></i>
                                                            </div>
                                                        </td>
                                                        <td class="bg-gray-lighter" style="width: 50%;">
                                                            <div class="h1 font-w700"><?php echo number_format($totalRows_visitasHoy,0,",","."); ?></div>
                                                            <div class="h5 text-muted text-uppercase push-5-t">Visitas Hoy</div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </a>
                                        <a class="block block-link-hover3" href="javascript:void(0)">
                                            <table class="block-table text-center">
                                                <tbody>
                                                    <tr>
                                                        <td style="width: 50%;">
                                                            <div class="push-30 push-30-t">
                                                                <i class="si si-users fa-3x text-primary-dark"></i>
                                                            </div>
                                                        </td>
                                                        <td class="bg-gray-lighter" style="width: 50%;">
                                                            <div class="h1 font-w700"><?php echo number_format($totalRows_visitasTotal,0,",","."); ?></div>
                                                            <div class="h5 text-muted text-uppercase push-5-t"> Visitas</div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </a>
                                        <!-- END mini estadisticas -->
                                    </div>
                                </div>
                            </div>
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
        <script src="js/plugins/slick/slick.min.js"></script>
        <script src="js/plugins/chartjs/Chart.min.js"></script>
        <script>
        var BasePagesDashboard = function() {
			// Chart.js Chart, for more examples you can check out http://www.chartjs.org/docs
			var initDashChartJS = function(){
				// Get Chart Container
				var $dashChartLinesCon  = jQuery('.js-dash-chartjs-lines')[0].getContext('2d');
		
				// Set Chart and Chart Data variables
				var $dashChartLines, $dashChartLinesData;
		
				// Lines Chart Data
				var $dashChartLinesData = {
					labels: ['1 SEMANA', '6 DIAS', '5 DIAS', '4 DIAS', '3 DIAS', 'AYER', 'HOY'],
					datasets: [
						{
							label: 'This Week',
							fillColor: 'rgba(44, 52, 63, .07)',
							strokeColor: 'rgba(44, 52, 63, .25)',
							pointColor: 'rgba(44, 52, 63, .25)',
							pointStrokeColor: '#fff',
							pointHighlightFill: '#fff',
							pointHighlightStroke: 'rgba(44, 52, 63, 1)',
							data: [<?php echo $totalRows_visitas6dias; ?>, <?php echo $totalRows_visitas5dias; ?>, <?php echo $totalRows_visitas4dias; ?>, <?php echo $totalRows_visitas3dias; ?>, <?php echo $totalRows_visitas2dias; ?>, <?php echo $totalRows_visitasAyer; ?>, <?php echo $totalRows_visitasHoy; ?>]
						},
					]
				};
		
				// Init Lines Chart
				$dashChartLines = new Chart($dashChartLinesCon).Line($dashChartLinesData, {
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
					// Init ChartJS chart
					initDashChartJS();
				}
			};
		}();
		
		// Initialize when page loads
		jQuery(function(){ BasePagesDashboard.init(); });
		</script>
        <script>
            jQuery(function () {
                App.initHelpers('slick');
            });
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

mysqli_free_result($visitasTotal);

mysqli_free_result($blogTotal);

mysqli_free_result($blogVisitasTotal);

mysqli_free_result($productosTotal);

mysqli_free_result($productosVisitasTotal);

?>
