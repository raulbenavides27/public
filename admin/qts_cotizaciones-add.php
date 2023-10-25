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

$clienteID = $_GET["id"];

$query_qtsDatosCliente = sprintf("SELECT * FROM qts_clientes WHERE qts_clientes.id = '$clienteID'");
$qtsDatosCliente = mysqli_query($DKKadmin, $query_qtsDatosCliente);
$row_qtsDatosCliente = mysqli_fetch_assoc($qtsDatosCliente);
$totalRows_qtsDatosCliente = mysqli_num_rows($qtsDatosCliente);

$idCliente = $row_qtsDatosCliente["id"];

$query_qtsUltimaCotizacion = "SELECT * FROM qts_cotizaciones WHERE qts_cotizaciones.clienteID = '$idCliente' AND qts_cotizaciones.estado = '1' AND qts_cotizaciones.creadorID = '$idAdmin' ORDER BY qts_cotizaciones.id DESC";
$qtsUltimaCotizacion = mysqli_query($DKKadmin, $query_qtsUltimaCotizacion);
$row_qtsUltimaCotizacion = mysqli_fetch_assoc($qtsUltimaCotizacion);
$totalRows_qtsUltimaCotizacion = mysqli_num_rows($qtsUltimaCotizacion);

$idDespacho = $row_qtsUltimaCotizacion["lugarEntregaID"];
$idCotizacion = $row_qtsUltimaCotizacion["id"];

$query_qtsMetaDatos = "SELECT * FROM metaDatos ORDER BY metaDatos.id DESC";
$qtsMetaDatos = mysqli_query($DKKadmin, $query_qtsMetaDatos);
$row_qtsMetaDatos = mysqli_fetch_assoc($qtsMetaDatos);
$totalRows_qtsMetaDatos = mysqli_num_rows($qtsMetaDatos);

$query_qtsDireccionDespacho = "SELECT * FROM qts_clientesDirecciones WHERE qts_clientesDirecciones.id = '$idDespacho'";
$qtsDireccionDespacho = mysqli_query($DKKadmin, $query_qtsDireccionDespacho);
$row_qtsDireccionDespacho = mysqli_fetch_assoc($qtsDireccionDespacho);
$totalRows_qtsDireccionDespacho = mysqli_num_rows($qtsDireccionDespacho);

$query_qtsDireccionCliente = "SELECT * FROM qts_clientesDirecciones WHERE qts_clientesDirecciones.clienteID = '$idCliente' AND qts_clientesDirecciones.principal = '1'";
$qtsDireccionCliente = mysqli_query($DKKadmin, $query_qtsDireccionCliente);
$row_qtsDireccionCliente = mysqli_fetch_assoc($qtsDireccionCliente);
$totalRows_qtsDireccionCliente = mysqli_num_rows($qtsDireccionCliente);

$query_qtsProductosCotizacion = "SELECT * FROM qts_cotizacionesProductos WHERE qts_cotizacionesProductos.idCliente = '$idCliente' AND qts_cotizacionesProductos.idCotizacion = '$idCotizacion' AND qts_cotizacionesProductos.estado = '1' ORDER BY qts_cotizacionesProductos.id DESC";
$qtsProductosCotizacion = mysqli_query($DKKadmin, $query_qtsProductosCotizacion);
$row_qtsProductosCotizacion = mysqli_fetch_assoc($qtsProductosCotizacion);
$totalRows_qtsProductosCotizacion = mysqli_num_rows($qtsProductosCotizacion);

$query_qtsEditarProductosCotizacion = "SELECT * FROM qts_cotizacionesProductos WHERE qts_cotizacionesProductos.idCliente = '$idCliente' AND qts_cotizacionesProductos.idCotizacion = '$idCotizacion' AND qts_cotizacionesProductos.estado = '1' ORDER BY qts_cotizacionesProductos.id DESC";
$qtsEditarProductosCotizacion = mysqli_query($DKKadmin, $query_qtsEditarProductosCotizacion);
$row_qtsEditarProductosCotizacion = mysqli_fetch_assoc($qtsEditarProductosCotizacion);
$totalRows_qtsEditarProductosCotizacion = mysqli_num_rows($qtsEditarProductosCotizacion);

$query_qtsProductosActivos = "SELECT * FROM productos WHERE productos.estado = '1' ORDER BY productos.nombre ASC";
$qtsProductosActivos = mysqli_query($DKKadmin, $query_qtsProductosActivos);
$row_qtsProductosActivos = mysqli_fetch_assoc($qtsProductosActivos);
$totalRows_qtsProductosActivos = mysqli_num_rows($qtsProductosActivos);

$query_qtsEditarProductosActivos = "SELECT * FROM productos WHERE productos.estado = '1' ORDER BY productos.nombre ASC";
$qtsEditarProductosActivos = mysqli_query($DKKadmin, $query_qtsEditarProductosActivos);
$row_qtsEditarProductosActivos = mysqli_fetch_assoc($qtsEditarProductosActivos);
$totalRows_qtsEditarProductosActivos = mysqli_num_rows($qtsEditarProductosActivos);

$query_subTotal = "SELECT SUM(qts_cotizacionesProductos.total) FROM qts_cotizacionesProductos WHERE qts_cotizacionesProductos.idCotizacion = '$idCotizacion' AND qts_cotizacionesProductos.estado = '1'";
$subTotal = mysqli_query($DKKadmin, $query_subTotal);
$row_subTotal = mysqli_fetch_assoc($subTotal);
$totalRows_subTotal = mysqli_num_rows($subTotal);

$query_qtsObservacionesCotizacion = "SELECT * FROM qts_cotizacionesObservaciones WHERE qts_cotizacionesObservaciones.idCotizacion = '$idCotizacion' AND qts_cotizacionesObservaciones.estado = '1'";
$qtsObservacionesCotizacion = mysqli_query($DKKadmin, $query_qtsObservacionesCotizacion);
$row_qtsObservacionesCotizacion = mysqli_fetch_assoc($qtsObservacionesCotizacion);
$totalRows_qtsObservacionesCotizacion = mysqli_num_rows($qtsObservacionesCotizacion);

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "editarProductoForm")) {
  $updateSQL = sprintf("UPDATE qts_cotizacionesProductos SET idProducto=%s, qty=%s, precio=%s, statusDscto=%s, dscto=%s WHERE id=%s",
                       GetSQLValueString($_POST['idProducto'], "text"),
                       GetSQLValueString($_POST['qty'], "text"),
                       GetSQLValueString($_POST['precio'], "text"),
                       GetSQLValueString(isset($_POST['statusDscto']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString($_POST['dscto'], "text"),
                       GetSQLValueString($_POST['id'], "int"));
  $Result1 = mysqli_query($DKKadmin, $updateSQL) or die(mysqli_error($DKKadmin));
  $updateGoTo = "qts_cotizaciones-productos-edit.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "observacionesForm")) {
  $insertSQL = sprintf("INSERT INTO qts_cotizacionesObservaciones (observacion, ip, fecha, fechaID, idCreador, idCliente, idCotizacion, estado) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['observacion'], "text"),
                       GetSQLValueString($_POST['ip'], "text"),
                       GetSQLValueString($_POST['fecha'], "text"),
                       GetSQLValueString($_POST['fechaID'], "text"),
                       GetSQLValueString($_POST['idCreador'], "text"),
                       GetSQLValueString($_POST['idCliente'], "text"),
                       GetSQLValueString($_POST['idCotizacion'], "text"),
                       GetSQLValueString($_POST['estado'], "text"));
  $Result1 = mysqli_query($DKKadmin, $insertSQL) or die(mysqli_error($DKKadmin));
  $insertGoTo = "qts_cotizaciones-view.php?id=".$idCotizacion;
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "nuevoProductoForm")) {
  $insertSQL = sprintf("INSERT INTO qts_cotizacionesProductos (idProducto, idCliente, idCreador, idCotizacion, qty, precio, statusDscto, dscto, fecha, fechaID, ip, estado) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['idProducto'], "text"),
                       GetSQLValueString($_POST['idCliente'], "text"),
                       GetSQLValueString($_POST['idCreador'], "text"),
                       GetSQLValueString($_POST['idCotizacion'], "text"),
                       GetSQLValueString($_POST['qty'], "text"),
                       GetSQLValueString($_POST['precio'], "text"),
                       GetSQLValueString(isset($_POST['statusDscto']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString($_POST['dscto'], "text"),
                       GetSQLValueString($_POST['fecha'], "text"),
                       GetSQLValueString($_POST['fechaID'], "text"),
                       GetSQLValueString($_POST['ip'], "text"),
                       GetSQLValueString($_POST['estado'], "text"));
  $Result1 = mysqli_query($DKKadmin, $insertSQL) or die(mysqli_error($DKKadmin));
  $insertGoTo = "qts_cotizaciones-productos-add.php?id=".$idCotizacion;
  header(sprintf("Location: %s", $insertGoTo));
}

$ivaCotizacion = ($row_subTotal['SUM(qts_cotizacionesProductos.total)'] * '0.19');
$totalCotizacion = ($row_subTotal['SUM(qts_cotizacionesProductos.total)'] + $ivaCotizacion);
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
                <!-- para esconder elementos de la impresión usa la clase '.hidden-print'  -->
                <div class="content bg-gray-lighter hidden-print">
                    <div class="row items-push">
                        <div class="col-sm-7">
                            <h1 class="page-heading">
                                Cotización <small>Nueva Cotización</small>
                            </h1>
                        </div>
                        <div class="col-sm-5 text-right hidden-xs">
                            <ol class="breadcrumb push-10-t">
                                <li>Dashboard</li>
                                <li><a class="link-effect" href="">Nueva Cotización</a></li>
                            </ol>
                        </div>
                    </div>
                </div>
                <!-- END header -->

                <!-- contenido -->
                <div class="content content-boxed">
                    <!-- cotización -->
                    <div class="block">
                        <div class="block-header">
                            <ul class="block-options">
                                <li>
                                    <!-- impresión: App() -> uiHelperPrint() -->
									<script>
                                        function qte<?php echo $row_qtsUltimaCotizacion["id"]; ?>()
                                        {
                                            self.name = 'opener';
                                            remote = open('../qte/qte.php?id=<?php echo $row_qtsUltimaCotizacion["id"]; ?>', 'remote', 'width=612,height=802,location=no,scrollbar=no,menubars=no,toolbars=no,resizable=no,fullscreen=no, status=yes');
    	                                    remote.focus();
	                                    }	
                                    </script>
                                    <button type="button" onclick="location.href='javascript:qte<?php echo $row_qtsUltimaCotizacion["id"]; ?>();'"><i class="si si-printer"></i> Ver PDF</button>
                                </li>
                                <li>
                                    <button type="button" data-toggle="block-option" data-action="fullscreen_toggle"></button>
                                </li>
                                <li>
                                    <button type="button" data-toggle="block-option" data-action="refresh_toggle" data-action-mode="demo"><i class="si si-refresh"></i></button>
                                </li>
                            </ul>
                            <h3 class="block-title">QTE.<?php if ($row_qtsUltimaCotizacion["id"] < 10) {echo "0000";} if ($row_qtsUltimaCotizacion["id"] < 100 && $row_qtsUltimaCotizacion["id"] > 10) {echo "000";} if ($row_qtsUltimaCotizacion["id"] < 1000 && $row_qtsUltimaCotizacion["id"] > 100) {echo "00";} if ($row_qtsUltimaCotizacion["id"] < 10000 && $row_qtsUltimaCotizacion["id"] > 1000) {echo "0";} if ($row_qtsUltimaCotizacion["id"] < 100000 && $row_qtsUltimaCotizacion["id"] > 10000) {echo "";} echo $row_qtsUltimaCotizacion["id"]; ?></h3>
                        </div>
                        <div class="block-content block-content-narrow">
                            <!-- info -->
                            <div class="h1 text-center push-30-t push-30 hidden-print">COTIZACIÓN</div>
                            <div class="row">
                            	<div class="col-xs-6 text-left">
                                	<img src="../images/logo.png" width="120" height="auto" alt="<?php echo $row_qtsMetaDatos["titulo"]; ?>">
                                    <address class="font-s12">
                                        <?php echo $row_qtsMetaDatos["direccion"]; ?><br>
                                        <i class="si si-call-end"></i> <?php echo $row_qtsMetaDatos["telefono"]; ?><br>
                                        <i class="si si-envelope"></i> <?php echo $row_qtsMetaDatos["correo"]; ?><br>
                                        <b>Fecha de Emisión:</b> <?php echo date("d/m/Y",$row_qtsUltimaCotizacion["fechaID"]); ?>
                                    </address>
                                    <span class="hidden-print label label-<?php if ($row_qtsUltimaCotizacion["estado"] == '1') { echo "warning"; } if ($row_qtsUltimaCotizacion["estado"] == '2') { echo "primary"; } if ($row_qtsUltimaCotizacion["estado"] == '3') { echo "success"; } if ($row_qtsUltimaCotizacion["estado"] == '4') { echo "danger";} if ($row_qtsUltimaCotizacion["estado"] == '5') { echo "default";} if ($row_qtsUltimaCotizacion["estado"] == '6') { echo "danger";} if ($row_qtsUltimaCotizacion["estado"] == '0') { echo "danger";} ?>"><?php if ($row_qtsUltimaCotizacion["estado"] == '1') { echo "INGRESADA"; } if ($row_qtsUltimaCotizacion["estado"] == '2') { echo "ENVIADA"; } if ($row_qtsUltimaCotizacion["estado"] == '3') { echo "APROBADA"; } if ($row_qtsUltimaCotizacion["estado"] == '4') { echo "RECHAZADA";} if ($row_qtsUltimaCotizacion["estado"] == '5') { echo "CERRADA";} if ($row_qtsUltimaCotizacion["estado"] == '6') { echo "ELIMINADA";} if ($row_qtsUltimaCotizacion["estado"] == '0') { echo "REMOVIDA";} ?></span>
                                </div>
                            	<div class="col-xs-6 text-right">
                                    <p class="h5 font-w400 push-5"><?php if (isset($row_qtsDatosCliente["razonSocial"]))   echo $row_qtsDatosCliente["razonSocial"]; else echo $row_qtsDatosCliente["nombre"]  ?> </p>
                                    <?php if ($totalRows_qtsDireccionCliente > 0) { ?>
									<?php if ($row_qtsUltimaCotizacion["lugarEntrega"] == '3') { ?>
                                    <address class="font-s12">
                                        <?php if (empty($row_qtsDatosCliente["razonSocial"])) { ?><?php echo $row_qtsDatosCliente["nombre"]; ?><br><?php } ?>
                                        <?php echo $row_qtsDireccionDespacho["direccion1"]; ?><br>
                                        <?php if (isset($row_qtsDireccionDespacho["direccion2"])) echo $row_qtsDireccionDespacho["direccion2"]."<br>"; ?>
                                        <?php echo $row_qtsDireccionDespacho["comuna"].", ".$row_qtsDireccionDespacho["ciudad"].". ".$row_qtsDireccionDespacho["region"]; ?><br>
                                        <i class="si si-call-end"></i> <?php echo $row_qtsDatosCliente["telefono"]; ?><br>
                                        <i class="si si-envelope"></i> <?php echo $row_qtsDatosCliente["correo"]; ?>
                                    </address>
                                    <?php } ?>
                                    <?php if ($row_qtsUltimaCotizacion["lugarEntrega"] != '3') { ?>
                                    <address class="font-s12">
                                        <?php echo $row_qtsDatosCliente["nombre"]; ?><br>
										<?php echo $row_qtsDireccionCliente["direccion1"]; ?><br>
                                        <?php if (isset($row_qtsDireccionCliente["direccion2"])) echo $row_qtsDireccionCliente["direccion2"]."<br>"; ?>
                                        <?php echo $row_qtsDireccionCliente["comuna"].", ".$row_qtsDireccionCliente["ciudad"].". ".$row_qtsDireccionCliente["region"]; ?><br>
                                        <i class="si si-call-end"></i> <?php echo $row_qtsDatosCliente["telefono"]; ?><br>
                                        <i class="si si-envelope"></i> <?php echo $row_qtsDatosCliente["correo"]; ?>
                                    </address>
                                    <?php } ?>
                                    <?php } //Mostrar si tiene direcciones regitradas ?>
                                    <?php if ($totalRows_qtsDireccionCliente == 0) { ?>
                                    <address class="font-s12">
                                        <?php echo $row_qtsDatosCliente["nombre"]; ?><br>
                                        <strong>RUT:</strong> <?php echo $row_qtsDatosCliente["rut"]; ?><br>
                                        <i class="si si-call-end"></i> <?php echo $row_qtsDatosCliente["telefono"]; ?><br>
                                        <i class="si si-envelope"></i> <?php echo $row_qtsDatosCliente["correo"]; ?>
                                    </address>
                                    <?php } //Mostrar si NO tiene direcciones regitradas ?>
                                    <p class="h5 font-w400 push-5">Términos</p>
                                    <address class="font-s12">
                                        <strong>Lugar de Entrega:</strong> <?php if ($row_qtsUltimaCotizacion["lugarEntrega"] == '1') {echo"Retiro en PRODALUM Ltda.";} if ($row_qtsUltimaCotizacion["lugarEntrega"] == '2') {echo"Por Coordinar";} if ($row_qtsUltimaCotizacion["lugarEntrega"] == '3') {echo"Despacho";} ?><br>
                                        <strong>Tiempo de Entrega:</strong> <?php if ($row_qtsUltimaCotizacion["tiempoEntrega"] == '1') {echo"Inmediato";} if ($row_qtsUltimaCotizacion["tiempoEntrega"] == '2') {echo"60 días";} if ($row_qtsUltimaCotizacion["tiempoEntrega"] == '3') {echo $row_qtsUltimaCotizacion["tiempoEntregaAdicional"];} ?><br>
                                        <strong>Método de Pago:</strong> <?php if ($row_qtsUltimaCotizacion["metodoPago"] == '1') {echo"Efectivo / Transferencia";} if ($row_qtsUltimaCotizacion["metodoPago"] == '2') {echo"Tarjeta de Débito";} if ($row_qtsUltimaCotizacion["metodoPago"] == '3') {echo "Tarjeta de Crédito <small>".$row_qtsUltimaCotizacion["metodoPagoAdicional"]."</small>";} ?><br>
                                        <!-- <strong>Forma de Pago:</strong> <?php if ($row_qtsUltimaCotizacion["formaPago"] == '1') {echo"100%";} if ($row_qtsUltimaCotizacion["formaPago"] == '2') {echo"30% Reserva / 70% Contra Entrega <small>Contado</small>";} if ($row_qtsUltimaCotizacion["formaPago"] == '3') {echo"30% Reserva / 70% Contra Entrega <small>Tarjeta de Crédito</small>";} ?> -->
                                    </address>
                                </div>
                            </div>
                            <hr class="hidden-print">

                            <!-- productos -->
                            <div class="table-responsive">
                                <div class="block">
                                    <div class="block-options">
                                    </div>
                                    <div class="block-header">
                                        <h4 class="block-title">Detalle</h4>
                                    </div>
                                    <div class="block-content remove-padding-l remove-padding-r">
                                        <?php if ($totalRows_qtsProductosCotizacion == 0) { ?>
                                        <p>Aún no hay productos en esta cotización. <a href="" data-toggle="modal" data-target="#nuevoProducto">Añade el primero.</a>
                                        <?php } //Si hay productos ?>
                                        <?php if ($totalRows_qtsProductosCotizacion > 0) { ?>
                                        <table class="table table-bordered table-hover font-s12">
                                            <thead>
                                                <tr>
                                                    <th style="width: 70px; text-align:center;"></th>
                                                    <th>Producto</th>
                                                    <th class="text-right" style="width: 120px;">Precio</th>
                                                    <th class="text-center" style="width: 100px;">Dscto</th>
                                                    <th class="text-center" style="width: 100px;">Qty</th>
                                                    <th class="text-right" style="width: 140px;">SubTotal</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                
												<?php do { ?>
                                                <?php 
                                                $idProductosCotizados = $row_qtsProductosCotizacion["idProducto"];
                                                $seleccionaProductosCotizados = mysqli_query($DKKadmin,"SELECT * FROM productos WHERE productos.id = '$idProductosCotizados' ORDER BY productos.id ASC"); if(mysqli_num_rows($seleccionaProductosCotizados) == 0) { echo "No hay productos"; } else { ?>
                                                  <?php $counter = 1; while($pCotizados = mysqli_fetch_array($seleccionaProductosCotizados)) { ?>

                                                <tr>
                                                    <td class="image" style="width: 70px; text-align:center;"><img src="../images/productos/<?php echo $pCotizados["imagen1"]; ?>" alt="<?php echo $pCotizados["nombre"]; ?>" width="40" height="auto"/></td>
                                                    <td>
                                                        <p class="font-w600 push-10"><?php echo $pCotizados["nombre"]; ?> <span class="small font-s12 hidden-print"><a href="qts_cotizaciones-productos-remove.php?id=<?php echo $row_qtsProductosCotizacion["id"]; ?>">(Eliminar)</a></span></p>
                                                        <div class="text-muted"><?php echo strtoupper(str_replace("-"," ",$pCotizados["categoriaSEO"])); ?></div>
                                                    </td>
                                                    <td class="text-right"><?php if ($pCotizados["statusOferta"] == '0') echo "$".number_format($pCotizados["precio"],0,",","."); if ($pCotizados["statusOferta"] == '1') echo "$".number_format($pCotizados["precioOferta"],0,",","."); ?></td>
                                                    <td class="text-right"><?php if ($row_qtsProductosCotizacion["statusDscto"] == '1') { echo "$".number_format($row_qtsProductosCotizacion["dscto"],0,",","."); } else { echo "0"; } ?></td>
                                                    <?php if ($row_qtsProductosCotizacion["qty"] >= $pCotizados["qtyMinima"]) { ?>
                                                    <td class="text-center"><span class="badge badge-primary"><?php echo $row_qtsProductosCotizacion["qty"]; ?></span></td>
                                                    <?php } ?>
                                                    <?php if ($row_qtsProductosCotizacion["qty"] < $pCotizados["qtyMinima"]) { ?>
                                                    <td class="text-center"><span class="badge badge-primary"><?php echo $pCotizados["qtyMinima"]; ?></span></td>
                                                    <?php } ?>
                                                    <td class="text-right"><?php echo "$".number_format($row_qtsProductosCotizacion["total"],0,",","."); ?></td>
                                                </tr>
                                                
                                                  <?php } ?>
                                                <?php } ?>
                                                <?php } while ($row_qtsProductosCotizacion = mysqli_fetch_assoc($qtsProductosCotizacion)); ?>
        
                                                <tr>
                                                    <td colspan="5" class="font-w600 text-right">Subtotal</td>
                                                    <td class="text-right"><?php echo "$ ".number_format($row_subTotal['SUM(qts_cotizacionesProductos.total)'],0,",","."); ?></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="5" class="font-w600 text-right">IVA</td>
                                                    <td class="text-right"><?php echo "$ ".number_format($ivaCotizacion,0,",","."); ?></td>
                                                </tr>
                                                <tr class="active">
                                                    <td colspan="5" class="font-w700 text-uppercase text-right">Total</td>
                                                    <td class="font-w700 text-right"><?php echo "$ ".number_format($totalCotizacion,0,",","."); ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <?php } //Si hay productos ?>
                                    </div>
								</div>
                                
                                <?php if ($totalRows_qtsObservacionesCotizacion > 0) { ?>
                                <div class="block block-bordered">
                                    <div class="block-header">
                                        <h4 class="block-title">Observaciones</h4>
                                    </div>
                                    <div class="block-content">
                                        <p class="font-s12"><?php echo $row_qtsObservacionesCotizacion["observacion"]; ?></p>
                                    </div>
                                </div>
                                <?php } //Mostrar si hay observaciones ?>

                            </div>
                            <!-- END productos -->

                            <!-- footer -->
                            <hr class="hidden-print">
                            <p class="text-muted text-center"><small><?php echo "PRODALUM Ltda. | ".$row_qtsMetaDatos["direccion"]." | ".$row_qtsMetaDatos["telefono"]." | ".$row_qtsMetaDatos["correo"]; ?></small></p>
                            <!-- END footer -->
                        </div>
                    </div>
                    <!-- END Invoice -->
                </div>
                <!-- END Page Content -->
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
        <!-- add obbservaciones -->
        <div class="modal fade" id="addObservaciones" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-top">
                <div class="modal-content">
                    <div class="block block-themed block-transparent remove-margin-b">
                        <div class="block-header bg-primary-dark">
                            <ul class="block-options">
                                <li>
                                    <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
                                </li>
                            </ul>
                            <h3 class="block-title">Añadir Observaciones</h3>
                        </div>
                        <div class="block-content">
                            <div class="row">
                                <div class="col-lg-12">
                                  <form method="POST" action="<?php echo $editFormAction; ?>" class="form-horizontal push-30-t push-30" name="observacionesForm">
										<div class="form-group">
                                            <label class="col-xs-12" for="example-textarea-input">Observaciones</label>
                                            <div class="col-xs-12">
                                                <textarea class="js-summernote" id="observacion" name="observacion"  placeholder="Escribe las observaciones de esta cotización"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-xs-12 text-right">
                                            	<input type="hidden" name="ip" value="<?php echo $ip; ?>">
                                                <input type="hidden" name="fecha" value="<?php echo $fecha; ?>">
                                                <input type="hidden" name="fechaID" value="<?php echo $fechaHoy; ?>">
                                                <input type="hidden" name="idCreador" value="<?php echo $idAdmin; ?>">
                                                <input type="hidden" name="idCliente" value="<?php echo $idCliente; ?>">
                                                <input type="hidden" name="idCotizacion" value="<?php echo $idCotizacion; ?>">
                                                <input type="hidden" name="estado" value="1">
                                                <button class='btn btn-sm btn-primary' type='submit'>Agregar Observaciones</button>
                                            </div>
                                        </div>
                                        <input type="hidden" name="MM_insert" value="observacionesForm">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END add obbservaciones -->
        <!-- nuevo producto -->
        <div class="modal fade" id="nuevoProducto" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-top">
                <div class="modal-content">
                    <div class="block block-themed block-transparent remove-margin-b">
                        <div class="block-header bg-primary-dark">
                            <ul class="block-options">
                                <li>
                                    <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
                                </li>
                            </ul>
                            <h3 class="block-title">Añadir Producto</h3>
                        </div>
                        <div class="block-content">
                            <div class="row">
                                <div class="col-lg-12">
                                  <form method="POST" action="<?php echo $editFormAction; ?>" class="form-horizontal push-30-t push-30" name="nuevoProductoForm">
                                        <div class="form-group">
                                            <div class="col-xs-2">
                                                    <label for="qty">Cant.</label>
                                                    <input type="number" class="form-control" id="qty" name="qty" required min="<?php echo $row_qtsProductosActivos["qtyMinima"]; ?>">
                                            </div>
                                            <div class="col-xs-6">
                                                  <label for="idProducto">Producto</label>
                                                  <select class="js-select2 form-control" id="idProducto" name="idProducto" style="width: 100%; height:45px;" data-placeholder="Selecciona el Producto...">
                                                      <option></option>
                                                      <?php do { ?>
                                                      <option value="<?php echo $row_qtsProductosActivos['id']?>"><?php echo $row_qtsProductosActivos['nombre']." ("."$ ".number_format($row_qtsProductosActivos['precio'],0,",",".").")"; ?></option>
                                                      <?php } while ($row_qtsProductosActivos = mysqli_fetch_assoc($qtsProductosActivos)); $rows = mysqli_num_rows($qtsProductosActivos); if($rows > 0) { mysqli_data_seek($qtsProductosActivos, 0); $row_qtsProductosActivos = mysqli_fetch_assoc($qtsProductosActivos); } ?>
                                                  </select>
                                            </div>
                                            <div class="col-xs-4">
                                                    <label for="precio">Precio</label>
                                                    <input type="number" class="form-control" id="precio" name="precio" required>
                                            </div>
                                        </div>
										<div class="form-group">
                                            <div class="col-xs-2">
                                            	<label for="btnDscto">Dscto.</label>
                                                <label class="css-input switch switch-sm switch-primary">
                                                   	<input type="checkbox" id="btnDscto" name="statusDscto"><span></span>
                                                </label>
                                            </div>
                                            <div class="col-xs-10" id="btnDsctoActivo" style="display:none;">
    		                                        <label for="dscto">Descuento ($)</label>
	    	                                        <input class="form-control" type="text" id="dscto" name="dscto" placeholder="Ingresa el Monto a Descontar">
	                                        </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-xs-12 text-right">
                                            	<input type="hidden" name="ip" value="<?php echo $ip; ?>">
                                                <input type="hidden" name="fecha" value="<?php echo $fecha; ?>">
                                                <input type="hidden" name="fechaID" value="<?php echo $fechaHoy; ?>">
                                                <input type="hidden" name="idCreador" value="<?php echo $idAdmin; ?>">
                                                <input type="hidden" name="idCliente" value="<?php echo $idCliente; ?>">
                                                <input type="hidden" name="idCotizacion" value="<?php echo $idCotizacion; ?>">
                                                <input type="hidden" name="estado" value="1">
                                                <button class='btn btn-sm btn-primary' type='submit'>Agregar Producto</button>
                                            </div>
                                        </div>
                                        <input type="hidden" name="MM_insert" value="nuevoProductoForm">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END nuevo producto -->
        <?php do { ?>
        <!-- editar producto -->
        <div class="modal fade" id="editQte<?php echo $row_qtsEditarProductosCotizacion["id"]; ?>" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-top">
                <div class="modal-content">
                    <div class="block block-themed block-transparent remove-margin-b">
                        <div class="block-header bg-primary-dark">
                            <ul class="block-options">
                                <li>
                                    <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
                                </li>
                            </ul>
                            <h3 class="block-title">Editar Producto</h3>
                        </div>
                        <div class="block-content">
                            <div class="row">
                                <div class="col-lg-12">
                                  <form method="POST" action="<?php echo $editFormAction; ?>" class="form-horizontal push-30-t push-30" name="editarProductoForm">
                                        <div class="form-group">
                                            <div class="col-xs-2">
                                                    <label for="qty">Cant.</label>
                                                    <input type="number" class="form-control" id="qty" name="qty" required min="<?php echo $row_qtsProductosActivos["qtyMinima"]; ?>" value="<?php echo $row_qtsEditarProductosCotizacion["qty"]; ?>">
                                            </div>
                                            <div class="col-xs-6">
                                                  <label for="idProducto">Producto</label>
                                                  <select class="js-select2 form-control" id="idProducto" name="idProducto" style="width: 100%;" data-placeholder="Selecciona el Producto...">
                                                    <option></option>
                                                    <?php do { ?>
                                                    <option value="<?php echo $row_qtsEditarProductosActivos['id']?>"<?php if (!(strcmp($row_qtsEditarProductosActivos['id'], $row_qtsEditarProductosCotizacion['idProducto']))) {echo "selected=\"selected\"";} ?>><?php echo $row_qtsEditarProductosActivos['nombre']?></option>
                                                    <?php } while ($row_qtsEditarProductosActivos = mysqli_fetch_assoc($qtsEditarProductosActivos)); $rows = mysqli_num_rows($qtsEditarProductosActivos); if($rows > 0) { mysqli_data_seek($qtsEditarProductosActivos, 0); $row_qtsEditarProductosActivos = mysqli_fetch_assoc($qtsEditarProductosActivos); } ?>
                                              </select>
                                            </div>
                                            <div class="col-xs-4">
                                                    <label for="precio">Precio</label>
                                                    <input type="number" class="form-control" id="precio" name="precio" required value="<?php echo $row_qtsEditarProductosCotizacion["precio"]; ?>">
                                            </div>
                                        </div>
										<div class="form-group">
                                            <div class="col-xs-2">
                                            	<label for="btnDscto">Dscto.</label>
                                                <label class="css-input switch switch-sm switch-primary">
                                                   	<input <?php if (!(strcmp($row_qtsEditarProductosCotizacion['statusDscto'],1))) {echo "checked=\"checked\"";} ?> type="checkbox" id="btnDsctoEditar" name="statusDscto"><span></span>
                                                </label>
                                            </div>
                                            <div class="col-xs-10" id="btnDsctoActivoEditar" style="display:<?php if ($row_qtsEditarProductosCotizacion['statusDscto'] == '1') { echo "display";} if ($row_qtsEditarProductosCotizacion['statusDscto'] == '0') {echo "none";} ?>;">
    		                                        <label for="dscto">Descuento ($)</label>
	    	                                        <input class="form-control" type="text" id="dscto" name="dscto" placeholder="Ingresa el Monto a Descontar" value="<?php echo $row_qtsEditarProductosCotizacion["dscto"]; ?>">
	                                        </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-xs-12 text-right">
                                            	<input type="hidden" name="id" value="<?php echo $row_qtsEditarProductosCotizacion["id"]; ?>">
                                                <button class='btn btn-sm btn-primary' type='submit'>Editar Producto</button>
                                            </div>
                                        </div>
                                        <input type="hidden" name="MM_update" value="editarProductoForm">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END editar producto -->
        <?php } while ($row_qtsEditarProductosCotizacion = mysqli_fetch_assoc($qtsEditarProductosCotizacion)); ?>
		<script src="js/plugins/summernote/summernote.min.js"></script>
        <script src="js/plugins/ckeditor/ckeditor.js"></script>
        <script src="js/plugins/simplemde/simplemde.min.js"></script>
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
        <script src="js/pages/base_forms_pickers_more.js"></script>
        <script>
            jQuery(function () {
                App.initHelpers(['summernote', 'ckeditor', 'simplemde', 'datepicker', 'datetimepicker', 'colorpicker', 'maxlength', 'select2', 'masked-inputs', 'rangeslider', 'tags-inputs', 'appear-countTo']);
            });
        </script>
        <script type="text/javascript">
			$('#btnDscto').change(function() {
				$('#btnDsctoActivo').toggle();
			});        
		</script>
        <!-- InstanceEndEditable -->
</body>
<!-- InstanceEnd --></html>
<?php
mysqli_free_result($datosAdmin);

mysqli_free_result($contactosPendientes);

mysqli_free_result($qtsDatosCliente);

mysqli_free_result($qtsUltimaCotizacion);

mysqli_free_result($qtsMetaDatos);

mysqli_free_result($qtsDireccionDespacho);

mysqli_free_result($qtsDireccionCliente);

mysqli_free_result($qtsProductosCotizacion);

mysqli_free_result($qtsEditarProductosCotizacion);

mysqli_free_result($qtsProductosActivos);

mysqli_free_result($qtsEditarProductosActivos);

mysqli_free_result($subTotal);

mysqli_free_result($qtsObservacionesCotizacion);
?>
