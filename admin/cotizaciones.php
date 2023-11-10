<?php require_once('../Connections/DKKadmin.php');


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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "cotizarForm")) {
  $insertSQL = sprintf("INSERT INTO cotizaciones (nombre, correo, telefono, qty, productoSEO,modelo, fecha, fechaID, ip, estado, aceptaTerminos, origen) VALUES (%s,%s,%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['nombre'], "text"),
                       GetSQLValueString($_POST['correo'], "text"),
                       GetSQLValueString($_POST['telefono'], "text"),
                       GetSQLValueString($_POST['qty'], "text"),
                       GetSQLValueString($_POST['productoSEO'], "text"),
                       GetSQLValueString($_POST['modelo'], "text"),
                       GetSQLValueString($_POST['fecha'], "text"),
                       GetSQLValueString($_POST['fechaID'], "text"),
                       GetSQLValueString($_POST['ip'], "text"),
                       GetSQLValueString($_POST['estado'], "text"),
                       GetSQLValueString($_POST['aceptaTerminos'], "text"),
                       GetSQLValueString($_POST['origen'], "text"));


  $Result1 = mysqli_query($DKKadmin, $insertSQL) or die(mysqli_error($DKKadmin));
  $insertGoTo = "cotizaciones_add.php";
  header(sprintf("Location: %s", $insertGoTo));
}

//variables
$idAdmin = $_SESSION["MM_idAdmin"];
$fecha = date('Y-m-d H:i:s');
$fechaID = strtotime($fecha);
$fechaHoy = date('Y-m-d');
$hoy = strtotime($fechaHoy);
$ayer = strtotime('-1 day',$hoy);
$mes = strtotime(date('Y-m-'.'1'));
$ip = $_SERVER["REMOTE_ADDR"];
$estado = $_GET["estado"];

$query_datosAdmin = sprintf("SELECT * FROM admin WHERE admin.id = '$idAdmin' AND admin.estado = '1'");
$datosAdmin = mysqli_query($DKKadmin, $query_datosAdmin) or die(mysqli_error($DKKadmin));
$row_datosAdmin = mysqli_fetch_assoc($datosAdmin);
$totalRows_datosAdmin = mysqli_num_rows($datosAdmin);

$query_contactosPendientes = "SELECT * FROM contacto WHERE contacto.estado = '1' ORDER BY contacto.id DESC";
$contactosPendientes = mysqli_query($DKKadmin, $query_contactosPendientes) or die(mysqli_error($DKKadmin));
$row_contactosPendientes = mysqli_fetch_assoc($contactosPendientes);
$totalRows_contactosPendientes = mysqli_num_rows($contactosPendientes);

if (empty($estado)) {
	$query_cotizacionesLista = "SELECT * FROM cotizaciones ORDER BY cotizaciones.id DESC";
	$cotizacionesLista = mysqli_query($DKKadmin, $query_cotizacionesLista) or die(mysqli_error($DKKadmin));
	$row_cotizacionesLista = mysqli_fetch_assoc($cotizacionesLista);
	$totalRows_cotizacionesLista = mysqli_num_rows($cotizacionesLista);
}

if (isset($estado)) {
	$query_cotizacionesLista = "SELECT * FROM cotizaciones WHERE cotizaciones.estado = '$estado' ORDER BY cotizaciones.id DESC";
	$cotizacionesLista = mysqli_query($DKKadmin, $query_cotizacionesLista) or die(mysqli_error($DKKadmin));
	$row_cotizacionesLista = mysqli_fetch_assoc($cotizacionesLista);
	$totalRows_cotizacionesLista = mysqli_num_rows($cotizacionesLista);
}

$query_cotizacionesIngresadas = "SELECT * FROM cotizaciones WHERE cotizaciones.estado = '1' ORDER BY cotizaciones.id DESC";
$cotizacionesIngresadas = mysqli_query($DKKadmin, $query_cotizacionesIngresadas) or die(mysqli_error($DKKadmin));
$row_cotizacionesIngresadas = mysqli_fetch_assoc($cotizacionesIngresadas);
$totalRows_cotizacionesIngresadas = mysqli_num_rows($cotizacionesIngresadas);

$query_cotizacionesCotizadas = "SELECT * FROM cotizaciones WHERE cotizaciones.estado = '2' ORDER BY cotizaciones.id DESC";
$cotizacionesCotizadas = mysqli_query($DKKadmin, $query_cotizacionesCotizadas) or die(mysqli_error($DKKadmin));
$row_cotizacionesCotizadas = mysqli_fetch_assoc($cotizacionesCotizadas);
$totalRows_cotizacionesCotizadas = mysqli_num_rows($cotizacionesCotizadas);

$query_cotizacionesEliminadas = "SELECT * FROM cotizaciones WHERE cotizaciones.estado = '3' ORDER BY cotizaciones.id DESC";
$cotizacionesEliminadas = mysqli_query($DKKadmin, $query_cotizacionesEliminadas) or die(mysqli_error($DKKadmin));
$row_cotizacionesEliminadas = mysqli_fetch_assoc($cotizacionesEliminadas);
$totalRows_cotizacionesEliminadas = mysqli_num_rows($cotizacionesEliminadas);

$query_cotizacionesRemovidas = "SELECT * FROM cotizaciones WHERE cotizaciones.estado = '0' ORDER BY cotizaciones.id DESC";
$cotizacionesRemovidas = mysqli_query($DKKadmin, $query_cotizacionesRemovidas) or die(mysqli_error($DKKadmin));
$row_cotizacionesRemovidas = mysqli_fetch_assoc($cotizacionesRemovidas);
$totalRows_cotizacionesRemovidas = mysqli_num_rows($cotizacionesRemovidas);

$query_cotizacionesTotal = "SELECT * FROM cotizaciones ORDER BY cotizaciones.id DESC";
$cotizacionesTotal = mysqli_query($DKKadmin, $query_cotizacionesTotal) or die(mysqli_error($DKKadmin));
$row_cotizacionesTotal = mysqli_fetch_assoc($cotizacionesTotal);
$totalRows_cotizacionesTotal = mysqli_num_rows($cotizacionesTotal);

$query_cotizacionesHoy = "SELECT * FROM cotizaciones WHERE cotizaciones.fechaID >= '$hoy' ORDER BY cotizaciones.id DESC";
$cotizacionesHoy = mysqli_query($DKKadmin, $query_cotizacionesHoy) or die(mysqli_error($DKKadmin));
$row_cotizacionesHoy = mysqli_fetch_assoc($cotizacionesHoy);
$totalRows_cotizacionesHoy = mysqli_num_rows($cotizacionesHoy);

$query_cotizacionesAyer = "SELECT * FROM cotizaciones WHERE cotizaciones.fechaID >= '$ayer' AND cotizaciones.fechaID < '$hoy' ORDER BY cotizaciones.id DESC";
$cotizacionesAyer = mysqli_query($DKKadmin, $query_cotizacionesAyer) or die(mysqli_error($DKKadmin));
$row_cotizacionesAyer = mysqli_fetch_assoc($cotizacionesAyer);
$totalRows_cotizacionesAyer = mysqli_num_rows($cotizacionesAyer);

$query_cotizacionesMes = "SELECT * FROM cotizaciones WHERE cotizaciones.fechaID >= '$mes' ORDER BY cotizaciones.id DESC";
$cotizacionesMes = mysqli_query($DKKadmin, $query_cotizacionesMes) or die(mysqli_error($DKKadmin));
$row_cotizacionesMes = mysqli_fetch_assoc($cotizacionesMes);
$totalRows_cotizacionesMes = mysqli_num_rows($cotizacionesMes);

$query_productosListado = "SELECT * FROM productos WHERE productos.estado = '1' ORDER BY productos.id ASC";
$productosListado = mysqli_query($DKKadmin, $query_productosListado) or die(mysqli_error($DKKadmin));
$row_productosListado = mysqli_fetch_assoc($productosListado);
$totalRows_productosListado = mysqli_num_rows($productosListado);

// campo agregado  raul.b

  
//$query_idproducto = "SELECT id FROM productos WHERE productos.nombreSEO =  ;
$query_modeloListado = "SELECT * FROM productosTabla join productos on productosTabla.escalaID = productos.id  WHERE productosTabla.estado = '1' ORDER BY productosTabla.id ASC";
$modeloListado = mysqli_query($DKKadmin, $query_modeloListado) or die(mysqli_error($DKKadmin));
$row_modeloListado = mysqli_fetch_assoc($modeloListado);

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
        <link rel="stylesheet" href="js/plugins/datatables/jquery.dataTables.min.css">
        <link rel="stylesheet" href="js/plugins/bootstrap-datepicker/bootstrap-datepicker3.min.css">
        <link rel="stylesheet" href="js/plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.min.css">
        <link rel="stylesheet" href="js/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
        <link rel="stylesheet" href="js/plugins/select2/select2.min.css">
        <link rel="stylesheet" href="js/plugins/select2/select2-bootstrap.min.css">
        <link rel="stylesheet" href="js/plugins/jquery-auto-complete/jquery.auto-complete.min.css">
        <link rel="stylesheet" href="js/plugins/ion-rangeslider/css/ion.rangeSlider.min.css">
        <link rel="stylesheet" href="js/plugins/ion-rangeslider/css/ion.rangeSlider.skinHTML5.min.css">
        <link rel="stylesheet" href="js/plugins/dropzonejs/dropzone.min.css">
        <link rel="stylesheet" href="js/plugins/jquery-tags-input/jquery.tagsinput.min.css">
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
                        <div class="col-sm-6 col-md-2">
                            <a class="block block-link-hover3 text-center" href="javascript:void(0)" data-toggle="modal" data-target="#add_cotizacion">
                                <div class="block-content block-content-full">
                                	<div class="h1 font-w700 text-success"><i class="fa fa-plus"></i></div>
                                </div>
                            	<div class="block-content block-content-full block-content-mini bg-gray-lighter text-success font-w600">Nueva</div>
                        	</a>
                        </div>
                        <div class="col-sm-6 col-md-2">
                            <a class="block block-link-hover3 text-center" href="cotizaciones.php?estado=1">
                                <div class="block-content block-content-full">
                                    <div class="h1 font-w700 text-warning" data-toggle="countTo" data-to="<?php echo $totalRows_cotizacionesIngresadas; ?>"></div>
                                </div>
                                <div class="block-content block-content-full block-content-mini bg-gray-lighter text-muted font-w600">Ingresadas</div>
                            </a>
                        </div>
                        <div class="col-sm-6 col-md-2">
                            <a class="block block-link-hover3 text-center" href="cotizaciones.php?estado=2">
                                <div class="block-content block-content-full">
                                    <div class="h1 font-w700 text-success" data-toggle="countTo" data-to="<?php echo $totalRows_cotizacionesCotizadas; ?>"></div>
                                </div>
                                <div class="block-content block-content-full block-content-mini bg-gray-lighter text-muted font-w600">Cotizadas</div>
                            </a>
                        </div>
                        <div class="col-sm-6 col-md-2">
                            <a class="block block-link-hover3 text-center" href="javascript:void(0)">
                                <div class="block-content block-content-full">
                                    <div class="h1 font-w700" data-toggle="countTo" data-to="<?php echo $totalRows_cotizacionesHoy; ?>"></div>
                                </div>
                                <div class="block-content block-content-full block-content-mini bg-gray-lighter text-muted font-w600">Hoy</div>
                            </a>
                        </div>
                        <div class="col-sm-6 col-md-2">
                            <a class="block block-link-hover3 text-center" href="javascript:void(0)">
                                <div class="block-content block-content-full">
                                    <div class="h1 font-w700" data-toggle="countTo" data-to="<?php echo $totalRows_cotizacionesAyer; ?>"></div>
                                </div>
                                <div class="block-content block-content-full block-content-mini bg-gray-lighter text-muted font-w600">Ayer</div>
                            </a>
                        </div>
                        <div class="col-sm-6 col-md-2">
                            <a class="block block-link-hover3 text-center" href="javascript:void(0)">
                                <div class="block-content block-content-full">
                                    <div class="h1 font-w700" data-toggle="countTo" data-to="<?php echo $totalRows_cotizacionesMes; ?>"></div>
                                </div>
                                <div class="block-content block-content-full block-content-mini bg-gray-lighter text-muted font-w600">Este Mes</div>
                            </a>
                        </div>
                    </div>
                    <!-- END header -->

                    <!-- cotizaciones -->
                    <div class="block">
                        <div class="block-header bg-gray-lighter">
                            <ul class="block-options">
                                <li class="dropdown">
                                    <button type="button" data-toggle="dropdown">Filtros <span class="caret"></span></button>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li>
                                            <a tabindex="-1" href="cotizaciones.php?estado=1"><span class="badge pull-right"><?php echo $totalRows_cotizacionesIngresadas; ?></span>Ingresadas</a>
                                        </li>
                                        <li>
                                            <a tabindex="-1" href="cotizaciones.php?estado=2"><span class="badge pull-right"><?php echo $totalRows_cotizacionesCotizadas; ?></span>Cotizadas</a>
                                        </li>
                                        <li>
                                            <a tabindex="-1" href="cotizaciones.php?estado=3"><span class="badge pull-right"><?php echo $totalRows_cotizacionesEliminadas; ?></span>Eliminadas</a>
                                        </li>
                                        <li>
                                            <a tabindex="-1" href="cotizaciones.php?estado=0"><span class="badge pull-right"><?php echo $totalRows_cotizacionesRemovidas; ?></span>Removidas</a>
                                        </li>
                                        <li>
                                            <a tabindex="-1" href="cotizaciones.php"><span class="badge pull-right"><?php echo $totalRows_cotizacionesTotal; ?></span>Todas</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                            <h3 class="block-title"><?php if (empty($estado)) {echo "Todos las Cotizaciones";} if ($estado == '1') {echo "Cotizaciones Ingresadas";} if ($estado == '2') {echo "Cotizaciones Cotizadas";} if ($estado == '3') {echo "Cotizaciones Eliminadas";} if ($estado == '0') {echo "Cotizaciones Removidas";} ?></h3>
                        </div>
                        <div class="block-content">
                            <table class="table table-borderless table-striped table-vcenter js-dataTable-full">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="width: 100px;">ID</th>
                                        <th class="hidden-xs text-center">Creaci&oacute;n</th>
                                        <th>Estado</th>
                                        <th class="visible-lg">Cliente</th>
                                        <th class="visible-lg text-center">Producto Cotizado</th>
                                        <th class="visible-lg text-center">Cant.</th>
                                        <th class="hidden-xs text-right">Total</th>
                                        <th class="text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php do { ?>
									<tr>
                                        <td class="text-center">
                                            <a class="font-600" href="cotizaciones_view.php?id=<?php echo $row_cotizacionesLista["id"]; ?>">
                                                <strong><?php echo $row_cotizacionesLista["id"]; ?></strong>
                                            </a>
                                        </td>
                                        <td class="hidden-xs text-center"><?php $fechaCreacion = $row_cotizacionesLista["fechaID"]; echo gmdate("d/m/Y", $fechaCreacion); ?></td>
                                        <td>
                                            <span class="label label-<?php if ($row_cotizacionesLista["estado"] == '1') {echo "warning";} if ($row_cotizacionesLista["estado"] == '2') {echo "success";} if ($row_cotizacionesLista["estado"] == '3') {echo "danger";} if ($row_cotizacionesLista["estado"] == '0') {echo "default";} ?>"><?php if ($row_cotizacionesLista["estado"] == '1') {echo "Ingresada";} if ($row_cotizacionesLista["estado"] == '2') {echo "Cotizada";} if ($row_cotizacionesLista["estado"] == '3') {echo "Eliminada";} if ($row_cotizacionesLista["estado"] == '0') {echo "Removida";} ?></span>
                                        </td>
                                        <td class="visible-lg">
                                          	<?php if (isset($row_cotizacionesLista["nombre"])) {echo $row_cotizacionesLista["nombre"];} else {echo "--";} ?>
                                        </td>
                                        <td class="text-center visible-lg">
                                            <a href="cotizaciones_view.php?id=<?php echo $row_cotizacionesLista["id"]; ?>"><?php if (isset($row_cotizacionesLista["producto"])) {echo $row_cotizacionesLista["producto"];} else {echo "--";} ?></a>
                                        </td>
                                        <td class="text-center visible-lg">
                                            <a href="cotizaciones_view.php?id=<?php echo $row_cotizacionesLista["id"]; ?>"><?php echo $row_cotizacionesLista["qty"]; ?></a>
                                        </td>
                                        <td class="text-right hidden-xs">
                                            <strong><?php echo "$".number_format($row_cotizacionesLista["total"],'0',',','.'); ?></strong>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group btn-group-xs">
                                                <a href="cotizaciones_view.php?id=<?php echo $row_cotizacionesLista["id"]; ?>" data-toggle="tooltip" title="Ver" class="btn btn-default"><i class="fa fa-eye"></i></a>
                                                <?php if ($row_cotizacionesLista["estado"] != '0') { ?><a href="cotizaciones_remove.php?id=<?php echo $row_cotizacionesLista["id"]; ?>" data-toggle="tooltip" title="Eliminar" class="btn btn-default"><i class="fa fa-times text-danger"></i></a><?php } ?>
                                                <?php if ($row_cotizacionesLista["estado"] == '0') { ?><a href="cotizaciones_ingresar.php?id=<?php echo $row_cotizacionesLista["id"]; ?>" data-toggle="tooltip" title="Ingresar" class="btn btn-default"><i class="fa fa-check text-success"></i></a><?php } ?>
                                            </div>
                                        </td>
                                    </tr>
									<?php } while ($row_cotizacionesLista = mysqli_fetch_assoc($cotizacionesLista)); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- END All Orders -->
                </div>
                <!-- END Page Content --><!-- InstanceEndEditable -->
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
		<!-- nueva cotizacion -->
        <div class="modal" id="add_cotizacion" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="block block-themed block-transparent remove-margin-b">
                        <div class="block-header bg-primary-dark">
                            <ul class="block-options">
                                <li>
                                    <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
                                </li>
                            </ul>
                            <h3 class="block-title">Nueva Cotizaci&oacute;n</h3>
                        </div>
                        <div class="block-content">
                            <form class="form-horizontal push-10-t push-10" method="post" name="cotizarForm" action="<?php echo $editFormAction; ?>">
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <div class="form-material input-group">
                                            <input class="form-control" type="text" id="nombre" name="nombre" placeholder="Nombre del Cliente" required>
                                            <label for="nombre">Nombre</label>
                                            <span class="input-group-addon"><i class="fa fa-user-circle"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <div class="form-material input-group">
                                            <input class="form-control" type="email" id="correo" name="correo" placeholder="Correo Electr&oacute;nico" required>
                                            <label for="correo">Email</label>
                                            <span class="input-group-addon"><i class="fa fa-envelope-o"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <div class="form-material input-group">
                                            <input class="form-control" type="text" id="telefono" name="telefono" placeholder="Tel&eacute;fono de Contacto" required>
                                            <label for="telefono">Tel&eacute;fono</label>
                                            <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-xs-3">
                                        <div class="form-material">
                                            <input class="form-control" type="number" min="1" value="1" id="qty" name="qty" placeholder="Cantidad" required>
                                            <label for="qty">Cant.</label>
                                        </div>
                                    </div>
									<div class="col-xs-9">
									    
                                        <div class="form-material">
                                            <select class="js-select2 form-control" id="productoSEO" name="productoSEO" style="width: 100%; height: 35px;">
                                                <option></option>
												<?php do { ?>
										    	<option value="<?php echo $row_productosListado["nombreSEO"]; ?>"><?php echo $row_productosListado["nombre"]; ?></option>
												<?php } while ($row_productosListado = mysqli_fetch_assoc($productosListado)); ?>
												
                                            </select>
                                            <label for="productoSEO">Producto</label>
                                        </div>
                                    <br>
                                          <!--editado raul.b -->
                                          
                                            <div class="form-material">
                                            <select class="js-select2 form-control" id="modelo" name="modelo" style="width: 100%; height: 35px;">
                                        
                                                <option></option>
												<?php do { ?>
										    	<option value="<?php echo $row_modeloListado["modelo"]; ?>"><?php echo $row_modeloListado["modelo"]; ?></option>
												<?php } while ($row_modeloListado = mysqli_fetch_assoc($modeloListado));?>
												
                                            </select>
                                            <label for="modelo">Modelo</label>
                                        </div>
                                        <!-- fin edicion -->
                                                </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-12">Origen</label>
                                    <div class="col-xs-12">
                                        <label class="radio-inline" for="whatsapp">
                                            <input type="radio" id="whatsapp" name="origen" value="whatsapp" checked> WhatsApp
                                        </label>
                                        <label class="radio-inline" for="presencial">
                                            <input type="radio" id="presencial" name="origen" value="presencial"> Presencial
                                        </label>
                                        <label class="radio-inline" for="telefonica">
                                            <input type="radio" id="telefonica" name="origen" value="telefonica"> Telef&oacute;nica
                                        </label>
                                    </div>
                                </div>
								<hr>
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <button class="btn btn-sm btn-success" type="submit"><i class="fa fa-check push-5-r"></i> Crear</button>
										<input type="hidden" name="fecha" value="<?php echo $fecha; ?>">
										<input type="hidden" name="fechaID" value="<?php echo $fechaID; ?>">
										<input type="hidden" name="ip" value="<?php echo $ip; ?>">
										<input type="hidden" name="estado" value="1">
										<input type="hidden" name="aceptaTerminos" value="1">
										<input type="hidden" name="MM_insert" value="cotizarForm">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END nueva cotizacion -->
        <script src="js/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
        <script src="js/plugins/bootstrap-datetimepicker/moment.min.js"></script>
        <script src="js/plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js"></script>
        <script src="js/plugins/bootstrap-colorpicker/bootstrap-colorpicker.min.js"></script>
        <script src="js/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js"></script>
        <script src="js/plugins/select2/select2.full.min.js"></script>
        <script src="js/plugins/masked-inputs/jquery.maskedinput.min.js"></script>
        <script src="js/plugins/jquery-auto-complete/jquery.auto-complete.min.js"></script>
        <script src="js/plugins/ion-rangeslider/js/ion.rangeSlider.min.js"></script>
        <script src="js/plugins/dropzonejs/dropzone.min.js"></script>
        <script src="js/plugins/jquery-tags-input/jquery.tagsinput.min.js"></script>
        <script src="js/plugins/autonumeric/autoNumeric.min.js"></script>
        <script src="js/pages/base_forms_pickers_more.js"></script>
        <script src="js/plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="js/pages/base_tables_datatables.js"></script>
        <script>
        jQuery(function () {
			App.initHelpers(['datepicker', 'datetimepicker', 'colorpicker', 'maxlength', 'select2', 'masked-inputs', 'rangeslider', 'tags-inputs', 'autonumeric', 'appear', 'appear-countTo']);
        });
        </script>
		<!-- InstanceEndEditable -->
</body>
<!-- InstanceEnd --></html>
<?php
mysqli_free_result($datosAdmin);

mysqli_free_result($contactosPendientes);

mysqli_free_result($cotizacionesLista);

mysqli_free_result($cotizacionesIngresadas);

mysqli_free_result($cotizacionesCotizadas);

mysqli_free_result($cotizacionesEliminadas);

mysqli_free_result($cotizacionesRemovidas);

mysqli_free_result($cotizacionesTotal);

mysqli_free_result($productosListado);
?>
