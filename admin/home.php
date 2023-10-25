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
$fecha = date('Y-m-d');
$fechaID = strtotime($fecha);
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

$query_visitasHoy = "SELECT * FROM visitas WHERE visitas.pagina = '$pagina' AND visitas.fecha >= '$fechaAyer' ORDER BY visitas.id DESC";
$visitasHoy = mysqli_query($DKKadmin, $query_visitasHoy) or die(mysqli_error($DKKadmin));
$row_visitasHoy = mysqli_fetch_assoc($visitasHoy);
$totalRows_visitasHoy = mysqli_num_rows($visitasHoy);

$query_visitasAyer = "SELECT * FROM visitas WHERE visitas.pagina = '$pagina' AND visitas.fecha >= '$fecha2dias' AND visitas.fecha <= '$fechaAyer' ORDER BY visitas.id DESC";
$visitasAyer = mysqli_query($DKKadmin, $query_visitasAyer) or die(mysqli_error($DKKadmin));
$row_visitasAyer = mysqli_fetch_assoc($visitasAyer);
$totalRows_visitasAyer = mysqli_num_rows($visitasAyer);

$query_visitas2dias = "SELECT * FROM visitas WHERE visitas.pagina = '$pagina' AND visitas.fecha >= '$fecha3dias' AND visitas.fecha <= '$fecha2dias' ORDER BY visitas.id DESC";
$visitas2dias = mysqli_query($DKKadmin, $query_visitas2dias) or die(mysqli_error($DKKadmin));
$row_visitas2dias = mysqli_fetch_assoc($visitas2dias);
$totalRows_visitas2dias = mysqli_num_rows($visitas2dias);

$query_visitas3dias = "SELECT * FROM visitas WHERE visitas.pagina = '$pagina' AND visitas.fecha >= '$fecha4dias' AND visitas.fecha <= '$fecha3dias' ORDER BY visitas.id DESC";
$visitas3dias = mysqli_query($DKKadmin, $query_visitas3dias) or die(mysqli_error($DKKadmin));
$row_visitas3dias = mysqli_fetch_assoc($visitas3dias);
$totalRows_visitas3dias = mysqli_num_rows($visitas3dias);

$query_visitas4dias = "SELECT * FROM visitas WHERE visitas.pagina = '$pagina' AND visitas.fecha >= '$fecha5dias' AND visitas.fecha <= '$fecha4dias' ORDER BY visitas.id DESC";
$visitas4dias = mysqli_query($DKKadmin, $query_visitas4dias) or die(mysqli_error($DKKadmin));
$row_visitas4dias = mysqli_fetch_assoc($visitas4dias);
$totalRows_visitas4dias = mysqli_num_rows($visitas4dias);

$query_visitas5dias = "SELECT * FROM visitas WHERE visitas.pagina = '$pagina' AND visitas.fecha >= '$fecha6dias' AND visitas.fecha <= '$fecha5dias' ORDER BY visitas.id DESC";
$visitas5dias = mysqli_query($DKKadmin, $query_visitas5dias) or die(mysqli_error($DKKadmin));
$row_visitas5dias = mysqli_fetch_assoc($visitas5dias);
$totalRows_visitas5dias = mysqli_num_rows($visitas5dias);

$query_visitas6dias = "SELECT * FROM visitas WHERE visitas.pagina = '$pagina' AND visitas.fecha >= '$fecha1semana' AND visitas.fecha <= '$fecha6dias' ORDER BY visitas.id DESC";
$visitas6dias = mysqli_query($DKKadmin, $query_visitas6dias) or die(mysqli_error($DKKadmin));
$row_visitas6dias = mysqli_fetch_assoc($visitas6dias);
$totalRows_visitas6dias = mysqli_num_rows($visitas6dias);

$query_visitasTotal = "SELECT * FROM visitas WHERE visitas.pagina = '$pagina' ORDER BY visitas.id DESC";
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

$query_productosTops = "SELECT * FROM productos WHERE productos.estado = '1' ORDER BY productos.visitas DESC LIMIT 10";
$productosTops = mysqli_query($DKKadmin, $query_productosTops) or die(mysqli_error($DKKadmin));
$row_productosTops = mysqli_fetch_assoc($productosTops);
$totalRows_productosTops = mysqli_num_rows($productosTops);

$query_blogTops = "SELECT * FROM blog WHERE blog.estado = '1' ORDER BY blog.visitas DESC LIMIT 10";
$blogTops = mysqli_query($DKKadmin, $query_blogTops) or die(mysqli_error($DKKadmin));
$row_blogTops = mysqli_fetch_assoc($blogTops);
$totalRows_blogTops = mysqli_num_rows($blogTops);
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
                <div class="content content-boxed">
                    <!-- header -->
                    <div class="row">
                        <div class="col-sm-6 col-md-3">
                            <a class="block block-link-hover3 text-center" href="javascript:void(0)">
                                <div class="block-content block-content-full">
                                    <div class="h1 font-w700 text-primary" data-toggle="countTo" data-to="<?php echo $totalRows_productosTotal; ?>"></div>
                                </div>
                                <div class="block-content block-content-full block-content-mini bg-gray-lighter text-muted font-w600">Proyectos Productos</div>
                            </a>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <a class="block block-link-hover3 text-center" href="javascript:void(0)">
                                <div class="block-content block-content-full">
                                    <div class="h1 font-w700 text-success" data-toggle="countTo" data-to="<?php echo $row_productosVisitasTotal["totalVisitasProductos"]; ?>"></div>
                                </div>
                                <div class="block-content block-content-full block-content-mini bg-gray-lighter text-muted font-w600">Visitas Productos</div>
                            </a>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <a class="block block-link-hover3 text-center" href="javascript:void(0)">
                                <div class="block-content block-content-full">
                                    <div class="h1 font-w700" data-toggle="countTo" data-to="<?php echo $totalRows_visitasTotal; ?>"></div>
                                </div>
                                <div class="block-content block-content-full block-content-mini bg-gray-lighter text-muted font-w600">Visitas Home</div>
                            </a>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <a class="block block-link-hover3 text-center" href="javascript:void(0)">
                                <div class="block-content block-content-full">
                                    <div class="h1 font-w700"><span data-toggle="countTo" data-to="<?php echo $totalRows_visitasHoy; ?>"></span></div>
                                </div>
                                <div class="block-content block-content-full block-content-mini bg-gray-lighter text-muted font-w600">Visitas Hoy</div>
                            </a>
                        </div>
                    </div>
                    <!-- END header  -->

                    <!-- grafico -->
                    <div class="block block-opt-refresh-icon4">
                        <div class="block-header bg-gray-lighter">
                            <h3 class="block-title">Visitas Semanales</h3>
                        </div>
                        <div class="block-content block-content-full">
                            <!-- Chart.js Charts (initialized in js/pages/base_pages_ecom_dashboard.js), for more examples you can check out http://www.chartjs.org/docs/ -->
                            <div style="height: 400px;"><canvas class="js-chartjs-overview"></canvas></div>
                        </div>
                    </div>
                    <!-- END grafico -->

                    <!-- Top Products and Latest Orders -->
                    <div class="row">
                        <div class="col-lg-6">
                            <!-- Top Products -->
                            <div class="block block-opt-refresh-icon4">
                                <div class="block-header bg-gray-lighter">
                                    <h3 class="block-title">Productos TOP</h3>
                                </div>
                                <div class="block-content">
                                    <table class="table table-borderless table-striped table-vcenter">
                                        <tbody>
                                          <?php do { ?>
                                          <tr>
                                            <td class="text-center" style="width: 100px;"><a href="productos_edit.php?id=<?php echo $row_productosTops["id"]; ?>"><strong>ID.<?php if ($row_productosTops["id"] < 10) echo "00".$row_productosTops["id"]; if ($row_productosTops["id"] >= 10 && $row_productosTops["id"] < 100) echo "0".$row_productosTops["id"]; if ($row_productosTops["id"] >= 100) echo $row_productosTops["id"]; ?></strong></a></td>
                                            <td class="hidden-xs"><a href="https://www.prodalum.cl/<?php echo $row_productosTops["categoriaSEO"]; ?>/<?php echo $row_productosTops["nombreSEO"]; ?>" target="_blank"><?php echo $row_productosTops["nombre"]; ?></a></td>
                                            <td><span class="label label-<?php if ($row_productosTops["estado"] == '1') {echo "success";}; if ($row_productosTops["estado"] == '2') {echo "warning";}; if ($row_productosTops["estado"] == '0') {echo "danger";}; ?>"><?php if ($row_productosTops["estado"] == '1') {echo "ACTIVO";}; if ($row_productosTops["estado"] == '2') {echo "INACTIVO";}; if ($row_productosTops["estado"] == '0') {echo "ELIMINADO";}; ?></span></td>
                                            <td class="text-right"><strong><?php echo number_format($row_productosTops["visitas"],0,",","."); ?></strong> visitas</td>
                                          </tr>
                                          <?php } while ($row_productosTops = mysqli_fetch_assoc($productosTops)); ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- END Top Products -->
                        </div>
                        <div class="col-lg-6">
                            <!-- Latest Orders -->
                            <div class="block block-opt-refresh-icon4">
                                <div class="block-header bg-gray-lighter">
                                    <h3 class="block-title">Posts Populares</h3>
                                </div>
                                <div class="block-content">
                                    <table class="table table-borderless table-striped table-vcenter">
                                        <tbody>
                                          <?php do { ?>
                                          <tr>
                                            <td class="text-center" style="width: 100px;"><a href="blog_edit.php?id=<?php echo $row_blogTops["id"]; ?>"><strong>BLG.<?php if ($row_blogTops["id"] < 10) echo "00".$row_blogTops["id"]; if ($row_blogTops["id"] >= 10 && $row_blogTops["id"] < 100) echo "0".$row_blogTops["id"]; if ($row_blogTops["id"] >= 100) echo $row_blogTops["id"]; ?></strong></a></td>
                                            <td class="hidden-xs maximoletras"><a href="https://www.prodalum.cl/blog/<?php echo $row_blogTops["tituloSEO"]; ?>" target="_blank"><?php echo $row_blogTops["titulo"]; ?></a></td>
                                            <td><span class="label label-<?php if ($row_blogTops["estado"] == '1') {echo "success";}; if ($row_blogTops["estado"] == '2') {echo "warning";}; if ($row_blogTops["estado"] == '0') {echo "danger";}; ?>"><?php if ($row_blogTops["estado"] == '1') {echo "ACTIVO";}; if ($row_blogTops["estado"] == '2') {echo "INACTIVO";}; if ($row_blogTops["estado"] == '0') {echo "ELIMINADO";}; ?></span></td>
                                            <td class="text-right"><strong><?php echo number_format($row_blogTops["visitas"],0,",","."); ?></strong> visitas</td>
                                          </tr>
                                          <?php } while ($row_blogTops = mysqli_fetch_assoc($blogTops)); ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- END Latest Orders -->
                        </div>
                    </div>
                    <!-- END Top Products and Latest Orders -->
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
        <script src="js/plugins/chartjs/Chart.min.js"></script>
        <script>
        var BasePagesEcomDashboard = function() {
			// Chart.js Chart, for more examples you can check out http://www.chartjs.org/docs
			var initOverviewChart = function(){
				// Get Chart Container
				var $chartOverviewCon = jQuery('.js-chartjs-overview')[0].getContext('2d');
		
				// Set Chart Options
				var $chartOverviewOptions = {
					scaleFontFamily: "'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif",
					scaleFontColor: '#999',
					scaleFontStyle: '600',
					tooltipTitleFontFamily: "'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif",
					tooltipCornerRadius: 3,
					maintainAspectRatio: false,
					responsive: true
				};
		
				// Overview Chart Data
				var $chartOverviewData = {
					labels: ['1 SEMANA', '6 DIAS', '5 DIAS', '4 DIAS', '3 DIAS', 'AYER', 'HOY'],
					datasets: [
						{
							label: 'Esta Semana',
							fillColor: 'rgba(171, 227, 125, .3)',
							strokeColor: 'rgba(171, 227, 125, 1)',
							pointColor: 'rgba(171, 227, 125, 1)',
							pointStrokeColor: '#fff',
							pointHighlightFill: '#fff',
							pointHighlightStroke: 'rgba(171, 227, 125, 1)',
							data: [<?php echo $totalRows_visitas6dias; ?>, <?php echo $totalRows_visitas5dias; ?>, <?php echo $totalRows_visitas4dias; ?>, <?php echo $totalRows_visitas3dias; ?>, <?php echo $totalRows_visitas2dias; ?>, <?php echo $totalRows_visitasAyer; ?>, <?php echo $totalRows_visitasHoy; ?>]
						}
					]
				};
		
				// Init Overview Chart
				var $chartOverview = new Chart($chartOverviewCon).Line($chartOverviewData, $chartOverviewOptions);
			};
		
			return {
				init: function () {
					// Init Overview Chart
					initOverviewChart();
				}
			};
		}();
		
		// Initialize when page loads
		jQuery(function(){ BasePagesEcomDashboard.init(); });
        </script>
        <script>
            jQuery(function () {
                App.initHelpers(['appear', 'appear-countTo']);
            });
        </script>
		<script>
		$("td.maximoletras").text(function(index, currentText) {
			return currentText.substr(0, 25)+'...';
		});
		</script>
		<!-- InstanceEndEditable -->
</body>
<!-- InstanceEnd --></html>
<?php
mysqli_free_result($datosAdmin);

mysqli_free_result($contactosPendientes);

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

mysqli_free_result($productosTops);

mysqli_free_result($blogTops);
?>
