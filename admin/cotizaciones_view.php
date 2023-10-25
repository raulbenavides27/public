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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "cotizacionForm")) {
  $updateSQL = sprintf("UPDATE cotizaciones SET tipo=%s, estado=%s WHERE id=%s",
                       GetSQLValueString($_POST['tipo'], "text"),
                       GetSQLValueString($_POST['estado'], "text"),
                       GetSQLValueString($_POST['id'], "int"));
  $Result1 = mysqli_query($DKKadmin, $updateSQL) or die(mysqli_error($DKKadmin));

  $updateGoTo = $_SERVER['REQUEST_URI'];
  header(sprintf("Location: %s", $updateGoTo));
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "clienteForm")) {
  $updateSQL = sprintf("UPDATE cotizaciones SET nombre=%s, correo=%s, telefono=%s WHERE id=%s",
                       GetSQLValueString($_POST['nombre'], "text"),
                       GetSQLValueString($_POST['correo'], "text"),
                       GetSQLValueString($_POST['telefono'], "text"),
                       GetSQLValueString($_POST['id'], "int"));
  $Result1 = mysqli_query($DKKadmin, $updateSQL) or die(mysqli_error($DKKadmin));

  $updateGoTo = $_SERVER['REQUEST_URI'];
  header(sprintf("Location: %s", $updateGoTo));
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "precioForm")) {
  $updateSQL = sprintf("UPDATE cotizaciones SET precio=%s WHERE id=%s",
                       GetSQLValueString($_POST['precio'], "text"),
                       GetSQLValueString($_POST['id'], "int"));
  $Result1 = mysqli_query($DKKadmin, $updateSQL) or die(mysqli_error($DKKadmin));

  $updateGoTo = $_SERVER['REQUEST_URI'];
  header(sprintf("Location: %s", $updateGoTo));
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "modeloForm")) {
  $updateSQL = sprintf("UPDATE cotizaciones SET modelo=%s WHERE id=%s",
                       GetSQLValueString($_POST['modelo'], "text"),
                       GetSQLValueString($_POST['id'], "int"));
  $Result1 = mysqli_query($DKKadmin, $updateSQL) or die(mysqli_error($DKKadmin));

  $updateGoTo = $_SERVER['REQUEST_URI'];
  header(sprintf("Location: %s", $updateGoTo));
}

//Variables
$idAdmin = $_SESSION["MM_idAdmin"];
$id = $_GET["id"];
$fecha = date('Y-m-d H:i:s');
$fechaID = strtotime($fecha);
$ip = $_SERVER["REMOTE_ADDR"];

$query_datosAdmin = sprintf("SELECT * FROM admin WHERE admin.id = '$idAdmin' AND admin.estado = '1'");
$datosAdmin = mysqli_query($DKKadmin, $query_datosAdmin) or die(mysqli_error($DKKadmin));
$row_datosAdmin = mysqli_fetch_assoc($datosAdmin);
$totalRows_datosAdmin = mysqli_num_rows($datosAdmin);

$query_contactosPendientes = "SELECT * FROM contacto WHERE contacto.estado = '1' ORDER BY contacto.id DESC";
$contactosPendientes = mysqli_query($DKKadmin, $query_contactosPendientes) or die(mysqli_error($DKKadmin));
$row_contactosPendientes = mysqli_fetch_assoc($contactosPendientes);
$totalRows_contactosPendientes = mysqli_num_rows($contactosPendientes);

$query_cotizacionView = "SELECT * FROM cotizaciones WHERE cotizaciones.id = '$id'";
$cotizacionView = mysqli_query($DKKadmin, $query_cotizacionView) or die(mysqli_error($DKKadmin));
$row_cotizacionView = mysqli_fetch_assoc($cotizacionView);
$totalRows_cotizacionView = mysqli_num_rows($cotizacionView);

$correoCliente = $row_cotizacionView["correo"];
$productoSEO = $row_cotizacionView["productoSEO"];
$cotizacionID = $row_cotizacionView["id"];
$modelo = $row_cotizacionView["modelo"];

$query_infoProducto = "SELECT * FROM productos WHERE productos.nombreSEO = '$productoSEO'";
$infoProducto = mysqli_query($DKKadmin, $query_infoProducto) or die(mysqli_error($DKKadmin));
$row_infoProducto = mysqli_fetch_assoc($infoProducto);
$totalRows_infoProducto = mysqli_num_rows($infoProducto);

$productoID = $row_infoProducto["id"];

$query_modelosProducto = "SELECT * FROM productosTabla WHERE productosTabla.escalaID = '$productoID'";
$modelosProducto = mysqli_query($DKKadmin, $query_modelosProducto) or die(mysqli_error($DKKadmin));
$row_modelosProducto = mysqli_fetch_assoc($modelosProducto);
$totalRows_modelosProducto = mysqli_num_rows($modelosProducto);

$query_modeloSeleccionado = "SELECT * FROM productosTabla WHERE productosTabla.modelo = '$modelo'";
$modeloSeleccionado = mysqli_query($DKKadmin, $query_modeloSeleccionado) or die(mysqli_error($DKKadmin));
$row_modeloSeleccionado = mysqli_fetch_assoc($modeloSeleccionado);
$totalRows_modeloSeleccionado = mysqli_num_rows($modeloSeleccionado);

$query_tiposProductos = "SELECT * FROM cotizacionesTipos WHERE cotizacionesTipos.estado = '1' ORDER BY cotizacionesTipos.id ASC";
$tiposProductos = mysqli_query($DKKadmin, $query_tiposProductos) or die(mysqli_error($DKKadmin));
$row_tiposProductos = mysqli_fetch_assoc($tiposProductos);
$totalRows_tiposProductos = mysqli_num_rows($tiposProductos);

$query_motivosCotizaciones = "SELECT * FROM cotizacionesMotivos WHERE cotizacionesMotivos.estado = '1' ORDER BY cotizacionesMotivos.id ASC";
$motivosCotizaciones = mysqli_query($DKKadmin, $query_motivosCotizaciones) or die(mysqli_error($DKKadmin));
$row_motivosCotizaciones = mysqli_fetch_assoc($motivosCotizaciones);
$totalRows_motivosCotizaciones = mysqli_num_rows($motivosCotizaciones);

//*busca cliente correo
$query_clienteExistente = "SELECT * FROM qts_clientes WHERE qts_clientes.estado = '1' AND qts_clientes.correo = '$correoCliente' ORDER BY qts_clientes.id DESC";
$clienteExistente = mysqli_query($DKKadmin, $query_clienteExistente) or die(mysqli_error($DKKadmin));
$row_clienteExistente = mysqli_fetch_assoc($clienteExistente);
$totalRows_clienteExistente = mysqli_num_rows($clienteExistente);

$query_ultimoCliente = "SELECT * FROM qts_clientes ORDER BY qts_clientes.id DESC";
$ultimoCliente = mysqli_query($DKKadmin, $query_ultimoCliente) or die(mysqli_error($DKKadmin));
$row_ultimoCliente = mysqli_fetch_assoc($ultimoCliente);
$totalRows_ultimoCliente = mysqli_num_rows($ultimoCliente);

$query_ultimaCotizacion = "SELECT * FROM qts_cotizaciones ORDER BY qts_cotizaciones.id DESC";
$ultimaCotizacion = mysqli_query($DKKadmin, $query_ultimaCotizacion) or die(mysqli_error($DKKadmin));
$row_ultimaCotizacion = mysqli_fetch_assoc($ultimaCotizacion);
$totalRows_ultimaCotizacion = mysqli_num_rows($ultimaCotizacion);

$idCotizacion = ($row_ultimaCotizacion["id"] + '1');

  $precio =  $row_cotizacionView["precio"];
  $subtotal =  $row_cotizacionView["total"];
  $iva = ($row_cotizacionView["precio"] * '0.19');
  $totalIVA = ($subtotal + $iva);

//calcular total
  $qty = $row_cotizacionView["qty"];
  $precio = $row_cotizacionView["precio"];
  $total = ($qty * $precio);
  $updateSQL = sprintf("UPDATE cotizaciones SET cotizaciones.total = '$total' WHERE cotizaciones.id = '$id'");
  $Result1 = mysqli_query($DKKadmin, $updateSQL) or die(mysqli_error($DKKadmin));

//cotizar form
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "cotizarForm")) {
  $insertSQL = sprintf("INSERT INTO qts_cotizaciones (cotizacionID, creadorID, clienteID, lugarEntrega, lugarEntregaID, tiempoEntrega, tiempoEntregaAdicional, metodoPago, metodoPagoAdicional, formaPago, ip, fecha, fechaID, tipo) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['cotizacionID'], "text"),
                       GetSQLValueString($_POST['creadorID'], "text"),
                       GetSQLValueString($_POST['clienteID'], "text"),
                       GetSQLValueString($_POST['lugarEntrega'], "text"),
                       GetSQLValueString($_POST['lugarEntregaID'], "text"),
                       GetSQLValueString($_POST['tiempoEntrega'], "text"),
                       GetSQLValueString($_POST['tiempoEntregaAdicional'], "text"),
                       GetSQLValueString($_POST['metodoPago'], "text"),
                       GetSQLValueString($_POST['metodoPagoAdicional'], "text"),
                       GetSQLValueString($_POST['formaPago'], "text"),
                       GetSQLValueString($_POST['ip'], "text"),
                       GetSQLValueString($_POST['fecha'], "text"),
                       GetSQLValueString($_POST['fechaID'], "text"),
                       GetSQLValueString($_POST['tipo'], "text"));
  $Result1 = mysqli_query($DKKadmin, $insertSQL) or die(mysqli_error($DKKadmin));
  $insertGoTo = "qts_view.php?id=".$idCotizacion;
  header(sprintf("Location: %s", $insertGoTo));
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "cotizarForm")) {
  $insertSQL = sprintf("INSERT INTO qts_cotizacionesProductos (idProducto, idModelo, idCliente, idCreador, idCotizacion, qty, precio, statusDscto, dscto, total, fecha, fechaID, ip) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['idProducto'], "text"),
                       GetSQLValueString($_POST['idModelo'], "text"),
                       GetSQLValueString($_POST['idCliente'], "text"),
                       GetSQLValueString($_POST['idCreador'], "text"),
                       GetSQLValueString($_POST['idCotizacion'], "text"),
                       GetSQLValueString($_POST['qty'], "text"),
                       GetSQLValueString($_POST['precio'], "text"),
                       GetSQLValueString($_POST['statusDscto'], "text"),
                       GetSQLValueString($_POST['dscto'], "text"),
                       GetSQLValueString($_POST['total'], "text"),
                       GetSQLValueString($_POST['fecha'], "text"),
                       GetSQLValueString($_POST['fechaID'], "text"),
                       GetSQLValueString($_POST['ip'], "text"));
  $Result1 = mysqli_query($DKKadmin, $insertSQL) or die(mysqli_error($DKKadmin));
  $insertGoTo = "qts_view.php?id=".$idCotizacion;
  header(sprintf("Location: %s", $insertGoTo));
}

if ($totalRows_clienteExistente == '0') {
	if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "cotizarForm")) {
	  $insertSQL = sprintf("INSERT INTO qts_clientes (creadorID, nombre, correo, telefono, ip, fecha, fechaID) VALUES (%s, %s, %s, %s, %s, %s, %s)",
						   GetSQLValueString($_POST['creadorID'], "text"),
						   GetSQLValueString($_POST['nombre'], "text"),
						   GetSQLValueString($_POST['correo'], "text"),
						   GetSQLValueString($_POST['telefono'], "text"),
						   GetSQLValueString($_POST['ip'], "text"),
						   GetSQLValueString($_POST['fecha'], "text"),
						   GetSQLValueString($_POST['fechaID'], "text"));
	  $Result1 = mysqli_query($DKKadmin, $insertSQL) or die(mysqli_error($DKKadmin));
	  $insertGoTo = "qts_view.php?id=".$idCotizacion;
	  header(sprintf("Location: %s", $insertGoTo));
	}
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "cotizarForm")) {
  $updateSQL = sprintf("UPDATE cotizaciones SET estado=%s WHERE id=%s",
                       GetSQLValueString($_POST['estado'], "text"),
                       GetSQLValueString($_POST['id'], "int"));
  $Result1 = mysqli_query($DKKadmin, $updateSQL) or die(mysqli_error($DKKadmin));
  $updateGoTo = "qts_view.php?id=".$idCotizacion;
  header(sprintf("Location: %s", $updateGoTo));
}
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
                        <div class="col-sm-6 col-md-3">
                            <a class="block block-link-hover3 text-center" href="javascript:void(0)">
                                <div class="block-content block-content-full">
                                    <span class="item item-circle bg-success-light"><i class="fa fa-check text-success"></i></span>
                                </div>
                                <div class="block-content block-content-full block-content-mini bg-gray-lighter text-success font-w600"><?php if ($row_cotizacionView["id"] < 10) { $idQTE = "0000".$row_cotizacionView["id"]; } if ($row_cotizacionView["id"] < 100 && $row_cotizacionView["id"] >= 10) { $idQTE = "000".$row_cotizacionView["id"]; } if ($row_cotizacionView["id"] < 1000 && $row_cotizacionView["id"] >= 100) { $idQTE = "00".$row_cotizacionView["id"]; } if ($row_cotizacionView["id"] < 10000 && $row_cotizacionView["id"] >= 1000) { $idQTE = "0".$row_cotizacionView["id"]; } if ($row_cotizacionView["id"] < 100000 && $row_cotizacionView["id"] >= 10000) { $idQTE = $row_cotizacionView["id"]; } echo "#QTE.".$idQTE; ?></div>
                            </a>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <a class="block block-link-hover3 text-center" href="javascript:void(0)">
                                <div class="block-content block-content-full">
                                    <span class="item item-circle bg-<?php if ($row_cotizacionView["estado"] == '1') {echo "warning";} if ($row_cotizacionView["estado"] == '2') {echo "success";} if ($row_cotizacionView["estado"] == '3') {echo "danger";} if ($row_cotizacionView["estado"] == '0') {echo "danger";} ?>-light"><i class="fa fa-<?php if ($row_cotizacionView["estado"] == '1') {echo "inbox";} if ($row_cotizacionView["estado"] == '2') {echo "check";} if ($row_cotizacionView["estado"] == '3') {echo "trash-o";} if ($row_cotizacionView["estado"] == '0') {echo "trash";} ?> text-<?php if ($row_cotizacionView["estado"] == '1') {echo "warning";} if ($row_cotizacionView["estado"] == '2') {echo "success";} if ($row_cotizacionView["estado"] == '3') {echo "danger";} if ($row_cotizacionView["estado"] == '0') {echo "danger";} ?>"></i></span>
                                </div>
                                <div class="block-content block-content-full block-content-mini bg-gray-lighter text-<?php if ($row_cotizacionView["estado"] == '1') {echo "warning";} if ($row_cotizacionView["estado"] == '2') {echo "success";} if ($row_cotizacionView["estado"] == '3') {echo "danger";} if ($row_cotizacionView["estado"] == '0') {echo "danger";} ?> font-w600"><?php if ($row_cotizacionView["estado"] == '1') {echo "Ingresada";} if ($row_cotizacionView["estado"] == '2') {echo "Cotizada";} if ($row_cotizacionView["estado"] == '3') {echo "Eliminada";} if ($row_cotizacionView["estado"] == '0') {echo "Removida";} ?></div>
                            </a>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <a class="block block-link-hover3 text-center" href="javascript:void(0)">
                                <div class="block-content block-content-full">
                                    <span class="item item-circle bg-gray-lighter"><i class="fa fa-<?php if ($row_cotizacionView["origen"] == 'web') {echo "laptop";} if ($row_cotizacionView["origen"] == 'movil') {echo "mobile-phone";} if ($row_cotizacionView["origen"] == 'whatsapp') {echo "whatsapp";} if ($row_cotizacionView["origen"] == 'tablet') {echo "tablet";} if ($row_cotizacionView["origen"] == 'presencial') {echo "building";} if ($row_cotizacionView["estado"] == 'otro') {echo "question-circle";} ?> text-muted"></i></span>
                                </div>
                                <div class="block-content block-content-full block-content-mini bg-gray-lighter text-muted font-w600"><?php if ($row_cotizacionView["origen"] == 'web') {echo "Web";} if ($row_cotizacionView["origen"] == 'movil') {echo "M&oacute;vil";} if ($row_cotizacionView["origen"] == 'tablet') {echo "Tablet";} if ($row_cotizacionView["origen"] == 'whatsapp') {echo "WhatsApp";} if ($row_cotizacionView["origen"] == 'presencial') {echo "Presencial";} if ($row_cotizacionView["estado"] == 'otro') {echo "Otro";} ?></div>
                            </a>
                        </div>
                        <?php  if (($row_cotizacionView["estado"] != '3') && ($row_cotizacionView["estado"] != '0')) { ?>
						<div class="col-sm-6 col-md-3">
                            <a class="block block-link-hover3 text-center" href="cotizaciones_eliminar.php?id=<?php echo $id; ?>">
                                <div class="block-content block-content-full">
                                    <span class="item item-circle bg-danger-light"><i class="fa fa-times text-danger"></i></span>
                                </div>
                                <div class="block-content block-content-full block-content-mini bg-gray-lighter text-danger font-w600">Eliminar</div>
                            </a>
                        </div>
						<?php } ?>
                        <?php  if ($row_cotizacionView["estado"] == '3') { ?>
						<div class="col-sm-6 col-md-3">
                            <a class="block block-link-hover3 text-center" href="cotizaciones_remove.php?id=<?php echo $id; ?>">
                                <div class="block-content block-content-full">
                                    <span class="item item-circle bg-danger-light"><i class="fa fa-trash text-danger"></i></span>
                                </div>
                                <div class="block-content block-content-full block-content-mini bg-gray-lighter text-danger font-w600">Remover</div>
                            </a>
                        </div>
						<?php } ?>
                        <?php  if ($row_cotizacionView["estado"] == '0') { ?>
						<div class="col-sm-6 col-md-3">
                            <a class="block block-link-hover3 text-center" href="cotizaciones_ingresar.php?id=<?php echo $id; ?>">
                                <div class="block-content block-content-full">
                                    <span class="item item-circle bg-warning-light"><i class="fa fa-inbox text-warning"></i></span>
                                </div>
                                <div class="block-content block-content-full block-content-mini bg-gray-lighter text-warning font-w600">Reingresar</div>
                            </a>
                        </div>
						<?php } ?>
                    </div>
                    <!-- END header -->

                    <!-- qte -->
                    <div class="row">
                        <div class="col-lg-6">
                            <!-- cliente -->
                            <div class="block" style="height: 280px;">
                                <div class="block-header bg-gray-lighter">
                                    <h3 class="block-title">Info Cliente</h3>
                                </div>
                                <div class="block-content block-content-full">
                                    <div class="h4 push-5"><?php echo ucwords($row_cotizacionView["nombre"]); ?></div>
                                    <address>
                                        <?php if (isset($row_cotizacionView["correo"])) {echo "<i class='fa fa-phone'></i><a href='mailto:".$row_cotizacionView["correo"]."'> ".$row_cotizacionView["correo"]."</a><br>";} ?>
                                        <?php if (isset($row_cotizacionView["telefono"])) {echo "<i class='fa fa-envelope-o'></i><a href='tel:".$row_cotizacionView["telefono"]."'> ".$row_cotizacionView["telefono"]."</a><br><br>";} ?>
                                        <i class="fa fa-calendar-o"></i> <?php echo $row_cotizacionView["fecha"]; ?><br><br>
										<button class="btn btn-sm btn-primary" type="button" data-toggle="modal" data-target="#edit_cliente"><i class="fa fa-edit push-5-r"></i> Editar</button>
                                    </address>
                                </div>
                            </div>
                            <!-- END cliente -->
                        </div>
                        <div class="col-lg-6">
                            <!-- info -->
                            <div class="block" style="height: 280px;">
                                <div class="block-header bg-gray-lighter">
                                    <h3 class="block-title">Info Cotizaci&oacute;n</h3>
                                </div>
                                <div class="block-content block-content-full">
                                    <form class="form-horizontal push-5-t" action="<?php echo $editFormAction; ?>" method="post" name="cotizacionForm">
                                        <div class="form-group">
                                            <label class="col-md-4 control-label" for="tipo">Tipo de Producto</label>
                                            <div class="col-md-8">
                                                <select class="js-select2 form-control" id="tipo" name="tipo" style="width: 100%;" data-placeholder="Selecci&oacute;nalo..">
                                                    <option></option>
													<?php do { ?>
                                                    <option value="<?php echo $row_tiposProductos["id"]; ?>" <?php if ($row_cotizacionView["tipo"] == $row_tiposProductos["id"]) {echo "selected";} ?>><?php echo $row_tiposProductos["tipo"]; ?></option>
													<?php } while ($row_tiposProductos = mysqli_fetch_assoc($tiposProductos)); ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label" for="estado">Estado</label>
                                            <div class="col-md-8">
                                                <select class="js-select2 form-control" id="estado" name="estado" style="width: 100%;" data-placeholder="Selecci&oacute;nalo..">
                                                    <option></option>
                                                    <option value="1" <?php if ($row_cotizacionView["estado"] == '1') {echo "selected";} ?>>Ingresada</option>
                                                    <option value="2" <?php if ($row_cotizacionView["estado"] == '2') {echo "selected";} ?>>Cotizada</option>
                                                    <option value="3" <?php if ($row_cotizacionView["estado"] == '3') {echo "selected";} ?>>Eliminada</option>
                                                    <option value="0" <?php if ($row_cotizacionView["estado"] == '0') {echo "selected";} ?>>Removida</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-xs-12">
                                                <button class="btn btn-sm btn-primary pull-right" type="submit"><i class="fa fa-save push-5-r"></i> Guardar</button>
												<input type="hidden" name="id" value="<?php echo $id; ?>">
												<input type="hidden" name="MM_update" value="cotizacionForm">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- END info -->
                        </div>
                    </div>
                    <!-- END qte -->

                    <!-- producto -->
                    <div class="block">
                        <div class="block-header bg-gray-lighter">
							<h3 class="block-title">Producto</h3>
                        </div>
                        <div class="block-content">
                            <div class="table-responsive">
                                <table class="table table-borderless table-striped table-vcenter">
                                    <thead>
                                        <tr>
                                            <th class="text-center" style="width: 100px;">ID</th>
                                            <th>NOMBRE</th>
                                            <th>MODELO</th>
                                            <th>CATEGOR&Iacute;A</th>
                                            <?php if ($row_cotizacionView["productoCategoria"] == 'escalas') { ?><th>SUBCATEGOR&Iacute;A</th><?php } ?>
                                            <th class="text-center">QTY</th>
                                            <th class="text-center" style="width: 10%;">PRECIO</th>
                                            <th class="text-center" style="width: 10%;">TOTAL</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-center"><a href="../productos/<?php echo $row_cotizacionView["productoSEO"]; ?>" target="_blank"><strong><?php echo "ID.".$row_cotizacionView["id"]; ?></strong></a></td>
                                            <?php if ($row_cotizacionView["productoCategoria"] == 'escalas') { ?><td><a href="../productos/<?php echo $row_cotizacionView["productoSEO"]; ?>" target="_blank"><?php echo strtoupper($row_cotizacionView["producto"]) ?></a></td><?php } ?>
                                            <?php if ($row_cotizacionView["productoCategoria"] != 'escalas') { ?><td><a href="../productos/<?php echo $row_cotizacionView["productoSEO"]; ?>" target="_blank"><?php echo strtoupper($row_cotizacionView["producto"]) ?></a><br><div class="text-muted"><?php echo $row_cotizacionView["mensaje"]; ?></div></td><?php } ?>
                                            <?php if ($row_cotizacionView["modelo"] != '--') { ?>
											<td><?php echo strtoupper($row_cotizacionView["modelo"]) ?></td>
                                            <?php } ?>
                                            <?php if ($row_cotizacionView["modelo"] == '--') { ?>
											<td class="text-center">
											<form name="modeloForm" action="<?php echo $editFormAction; ?>" method="post">
												<div class="form-group">
													<div class="col-sm-12" style="margin-top: -15px;">
														<select class="js-select2 form-control" id="modelo" name="modelo" style="width: 100%; margin-top: -15px;" data-placeholder="El&iacute;gelo.." onchange="this.form.submit()">
															<option></option>
															<?php do { ?>
															<option value="<?php echo $row_modelosProducto["modelo"]; ?>"><?php echo $row_modelosProducto["modelo"]; ?></option>
                                                			<?php } while ($row_modelosProducto = mysqli_fetch_assoc($modelosProducto)); ?>
														</select>
														<input type="hidden" name="id" value="<?php echo $id; ?>">
														<input type="hidden" name="MM_update" value="modeloForm">
													</div>
												</div>
											</form>
											</td>
                                            <?php } ?>
											<td><?php echo strtoupper($row_cotizacionView["productoCategoria"]) ?></td>
                                            <?php if ($row_cotizacionView["productoCategoria"] == 'escalas') { ?><td><?php echo str_replace("-"," ",strtoupper($row_cotizacionView["productoSubCategoria"])) ?></td><?php } ?>
                                            <td class="text-center"><strong><?php echo $row_cotizacionView["qty"]; ?></strong></td>
											<?php if ($row_cotizacionView["total"] == '0') { ?>
                                            <td class="text-center">
											<form name="precioForm" action="<?php echo $editFormAction; ?>" method="post">
												<div class="form-group">
													<div class="col-sm-12">
														<input class="form-control" type="text" id="precio" style="width: 100px; margin-top: -15px;" name="precio" placeholder="Precio">
														<input type="hidden" name="id" value="<?php echo $id; ?>">
														<input type="hidden" name="MM_update" value="precioForm">
													</div>
												</div>
											</form>
											</td>
                                            <td class="text-right"><?php echo $row_cotizacionView["total"]; ?></td>
											<?php } ?>
											<?php if ($row_cotizacionView["total"] != '0') { ?>
                                            <td class="text-center"><?php echo "$".number_format($row_cotizacionView["precio"],'0',',','.'); ?></td>
                                            <td class="text-right"><?php echo "$".number_format($row_cotizacionView["total"],'0',',','.'); ?></td>
											<?php } ?>
                                        </tr>
										<?php if ($row_cotizacionView["total"] != '0') { ?>
                                        <?php if ($row_cotizacionView["productoCategoria"] == 'escalas') { ?>
                                        <tr>
                                            <td colspan="7" class="text-right"><strong>SubTotal:</strong></td>
                                            <td class="text-right"><?php echo "$".number_format(($subtotal),'0',',','.'); ?></td>
                                        </tr>
                                        <tr>
                                            <td colspan="7" class="text-right"><strong>IVA:</strong></td>
                                            <td class="text-right"><?php echo "$".number_format(($iva),'0',',','.'); ?></td>
                                        </tr>
                                        <tr class="success">
                                            <td colspan="7" class="text-right text-uppercase"><strong>Total:</strong></td>
                                            <td class="text-right"><strong><?php echo "$".number_format(($total + $iva),'0',',','.'); ?></strong></td>
                                        </tr>
										<?php } ?>
                                        <?php if ($row_cotizacionView["productoCategoria"] != 'escalas') { ?>
                                        <tr>
                                            <td colspan="6" class="text-right"><strong>SubTotal:</strong></td>
                                            <td class="text-right"><?php echo "$".number_format(($subtotal),'0',',','.'); ?></td>
                                        </tr>
                                        <tr>
                                            <td colspan="6" class="text-right"><strong>IVA:</strong></td>
                                            <td class="text-right"><?php echo "$".number_format(($iva),'0',',','.'); ?></td>
                                        </tr>
                                        <tr class="success">
                                            <td colspan="6" class="text-right text-uppercase"><strong>Total:</strong></td>
                                            <td class="text-right"><strong><?php echo "$".number_format(($total + $iva),'0',',','.'); ?></strong></td>
                                        </tr>
										<?php } ?>
										<?php } ?>
                                    </tbody>
                                </table>
                            </div>
							<?php if ($row_cotizacionView["total"] != '0') { ?>
							<div class="row">
								<div class="col-lg-12">
									<button class="btn btn-sm btn-success push-5-r push-10 pull-right" type="button" data-toggle="modal" data-target="#cotizarForm"><i class="fa fa-dollar"></i> Cotizar</button>
								</div>
							</div>
							<?php } ?>
						</div>
                    </div>
                    <!-- END producto -->
                    
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
        <!-- nueva cotización -->
        <div class="modal fade" id="cotizarForm" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-top">
                <div class="modal-content">
                    <div class="block block-themed block-transparent remove-margin-b">
                        <div class="block-header bg-primary-dark">
                            <ul class="block-options">
                                <li>
                                    <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
                                </li>
                            </ul>
                            <h3 class="block-title">Cotizar</h3>
                        </div>
                        <div class="block-content">
                            <div class="row">
                                <div class="col-xs-12">
                                  <form method="POST" action="<?php echo $editFormAction; ?>" name="cotizarForm">
                                        <div class="form-group">
                                            <label class="col-xs-12">Lugar de Entrega</label>
                                            <div class="col-xs-12">
                                                <div class="radio">
                                                    <label for="lugarEntrega1">
                                                        <input type="radio" id="lugarEntrega1" name="lugarEntrega" value="1" checked> Retiro en PRODALUM
                                                    </label>
                                                </div>
                                                <div class="radio">
                                                    <label for="lugarEntrega2">
                                                        <input type="radio" id="lugarEntrega2" name="lugarEntrega" value="2"> Por Coordinar
                                                    </label>
                                                </div>
                                                <div class="radio">
                                                    <label for="lugarEntrega3">
                                                        <input type="radio" id="lugarEntrega3" name="lugarEntrega" <?php if ($totalRows_qtsDireccionesClientes == '0') {echo "disabled='disabled'";} ?> value="3"> Despacho (Require asignar dirección)
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group" id="lugarEntrega3Activo" style="display:none;">
                                            <div class="col-xs-12">
                                                <div class="form-material">
                                                    <select class="js-select2 form-control" id="lugarEntregaID" name="lugarEntregaID" style="width: 100%;" data-placeholder="Selecciona una Dirección..">
                                                      <option></option>
                                                      <?php do { ?>
                                                      <option value="<?php echo $row_qtsDireccionesClientesCotizar['id']?>"><?php echo $row_qtsDireccionesClientesCotizar['direccion1'].", ".$row_qtsDireccionesClientesCotizar['comuna'].". ".$row_qtsDireccionesClientesCotizar['region']."."; ?></option>
                                                      <?php } while ($row_qtsDireccionesClientesCotizar = mysqli_fetch_assoc($qtsDireccionesClientesCotizar)); $rows = mysqli_num_rows($qtsDireccionesClientesCotizar); if($rows > 0) { mysqli_data_seek($qtsDireccionesClientesCotizar, 0); $row_qtsDireccionesClientesCotizar = mysqli_fetch_assoc($qtsDireccionesClientesCotizar); } ?>
                                                  </select>
                                                    <label for="lugarEntregaID">Dirección de Despacho</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-xs-12">Tiempo de Entrega</label>
                                            <div class="col-xs-12">
                                                <div class="radio">
                                                    <label for="tiempoEntrega1">
                                                        <input type="radio" id="tiempoEntrega1" name="tiempoEntrega" value="1" checked> Inmediata
                                                    </label>
                                                </div>
                                                <div class="radio">
                                                    <label for="tiempoEntrega2">
                                                        <input type="radio" id="tiempoEntrega2" name="tiempoEntrega" value="2"> 25 a 30 días
                                                    </label>
                                                </div>
                                                <div class="radio">
                                                    <label for="tiempoEntrega3">
                                                        <input type="radio" id="tiempoEntrega3" name="tiempoEntrega" value="3"> Otra (Require información adicional)
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group" id="tiempoEntrega3Activo" style="display:none;">
                                            <div class="col-xs-12">
                                                <div class="form-material form-material-primary">
                                                    <input class="form-control" type="text" id="tiempoEntregaAdicional" name="tiempoEntregaAdicional">
                                                    <label for="tiempoEntregaAdicional">Información Adicional</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-xs-12">Método de Pago</label>
                                            <div class="col-xs-12">
                                                <div class="radio">
                                                    <label for="metodoPago1">
                                                        <input type="radio" id="metodoPago1" name="metodoPago" value="1" checked> Efectivo, Débito, Crédito o Transferencia Bancaria
                                                    </label>
                                                </div>
                                                <div class="radio">
                                                    <label for="metodoPago2">
                                                        <input type="radio" id="metodoPago2" name="metodoPago" value="2"> Otro
                                                    </label>
                                                </div>
                                                <div class="radio">
                                                    <label for="metodoPago3">
                                                        <input type="radio" id="metodoPago3" name="metodoPago" value="3"> Cliente Cuenta Corriente (Requiere información adicional)
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group" id="metodoPago3Activo" style="display:none;">
                                            <div class="col-xs-12">
                                                <div class="form-material form-material-primary">
                                                    <input class="form-control" type="text" id="metodoPagoAdicional" name="metodoPagoAdicional">
                                                    <label for="metodoPagoAdicional">Información Adicional</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-xs-12">Forma de Pago</label>
                                            <div class="col-xs-12">
                                                <div class="radio">
                                                    <label for="formaPago1">
                                                        <input type="radio" id="formaPago1" name="formaPago" value="1" checked> 100%
                                                    </label>
                                                </div>
                                                <div class="radio">
                                                    <label for="formaPago2">
                                                        <input type="radio" id="formaPago2" name="formaPago" value="2"> 50% Contado / 50% Contra Entrega <small>Contado</small>
                                                    </label>
                                                </div>
                                                <div class="radio">
                                                    <label for="formaPago3">
                                                        <input type="radio" id="formaPago3" name="formaPago" value="3"> 50% Contado / 50% Contra Entrega <small>Tarjeta de Crédito</small>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-xs-12">
												<?php if ($totalRows_clienteExistente == '0') { ?>
												<input type="hidden" name="nombre" value="<?php echo $row_cotizacionView["nombre"]; ?>">
												<input type="hidden" name="correo" value="<?php echo $row_cotizacionView["correo"]; ?>">
												<input type="hidden" name="telefono" value="<?php echo $row_cotizacionView["telefono"]; ?>">
												<input type="hidden" name="idCliente" value="<?php echo ($row_ultimoCliente["id"] + '1'); ?>">
												<input type="hidden" name="clienteID" value="<?php echo ($row_ultimoCliente["id"] + '1'); ?>">
												<?php } ?>
												<?php if ($totalRows_clienteExistente > '0') { ?>
												<input type="hidden" name="clienteID" value="<?php echo $row_clienteExistente["id"]; ?>">
												<input type="hidden" name="idCliente" value="<?php echo $row_clienteExistente["id"]; ?>">
												<?php } ?>
												<input type="hidden" name="cotizacionID" value="<?php echo $cotizacionID; ?>">
												<input type="hidden" name="idProducto" value="<?php echo $row_infoProducto["id"]; ?>">
												<input type="hidden" name="idModelo" value="<?php echo $row_modeloSeleccionado["id"]; ?>">
												<input type="hidden" name="idCotizacion" value="<?php echo ($row_ultimaCotizacion["id"] + '1'); ?>">
												<input type="hidden" name="idCreador" value="<?php echo $row_datosAdmin["id"]; ?>">
												<input type="hidden" name="creadorID" value="<?php echo $row_datosAdmin["id"]; ?>">
												<input type="hidden" name="qty" value="<?php echo $row_cotizacionView["qty"]; ?>">
												<input type="hidden" name="precio" value="<?php echo $precio; ?>">
												<input type="hidden" name="total" value="<?php echo $total; ?>">
												<input type="hidden" name="ip" value="<?php echo $ip; ?>">
												<input type="hidden" name="fecha" value="<?php echo $fecha; ?>">
												<input type="hidden" name="fechaID" value="<?php echo $fechaID; ?>">
                                            	<input type="hidden" name="estado" value="2">
                                            	<input type="hidden" name="tipo" value="<?php echo $row_cotizacionView["tipo"]; ?>">
                                            	<input type="hidden" name="id" value="<?php echo $row_cotizacionView["id"]; ?>">
                                                <button class='btn btn-sm btn-primary push-20 push-20-t' type='submit'>Crear Cotización</button>
                                            </div>
                                        </div>
                                        <input type="hidden" name="MM_insert" value="cotizarForm">
                                        <input type="hidden" name="MM_update" value="cotizarForm">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END nueva cotización -->
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
        <!-- Page JS Code -->
        <script src="js/pages/base_forms_pickers_more.js"></script>
        <script>
        jQuery(function () {
			App.initHelpers(['datepicker', 'datetimepicker', 'colorpicker', 'maxlength', 'select2', 'masked-inputs', 'rangeslider', 'tags-inputs', 'autonumeric']);
        });
        </script>
        <script type="text/javascript">
			$('#lugarEntrega3').change(function() {
				$('#lugarEntrega3Activo').toggle();
			});        
			$('#tiempoEntrega3').change(function() {
				$('#tiempoEntrega3Activo').toggle();
			});        
			$('#metodoPago3').change(function() {
				$('#metodoPago3Activo').toggle();
			});        
			$('#formaPago3').change(function() {
				$('#formaPago3Activo').toggle();
			});        
		</script>
		<!-- editar cliente -->
        <div class="modal" id="edit_cliente" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="block block-themed block-transparent remove-margin-b">
                        <div class="block-header bg-primary-dark">
                            <ul class="block-options">
                                <li>
                                    <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
                                </li>
                            </ul>
                            <h3 class="block-title">Editar Cliente</h3>
                        </div>
                        <div class="block-content">
                            <form class="form-horizontal push-10-t push-10" method="post" name="clienteForm" action="<?php echo $editFormAction; ?>">
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <div class="form-material input-group">
                                            <input class="form-control" type="text" id="nombre" name="nombre" placeholder="Nombre del Cliente" required value="<?php echo $row_cotizacionView["nombre"]; ?>">
                                            <label for="nombre">Nombre</label>
                                            <span class="input-group-addon"><i class="fa fa-user-circle"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <div class="form-material input-group">
                                            <input class="form-control" type="email" id="correo" name="correo" placeholder="Correo Electr&oacute;nico" required value="<?php echo $row_cotizacionView["correo"]; ?>">
                                            <label for="correo">Email</label>
                                            <span class="input-group-addon"><i class="fa fa-envelope-o"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <div class="form-material input-group">
                                            <input class="form-control" type="text" id="telefono" name="telefono" placeholder="Tel&eacute;fono de Contacto" required value="<?php echo $row_cotizacionView["telefono"]; ?>">
                                            <label for="telefono">Tel&eacute;fono</label>
                                            <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                        </div>
                                    </div>
                                </div>
								<hr>
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <button class="btn btn-sm btn-primary pull-right" type="submit"><i class="fa fa-save push-5-r"></i> Guardar</button>
										<input type="hidden" name="id" value="<?php echo $id; ?>">
										<input type="hidden" name="MM_update" value="clienteForm">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		<!-- InstanceEndEditable -->
</body>
<!-- InstanceEnd --></html>
<?php
mysqli_free_result($datosAdmin);

mysqli_free_result($contactosPendientes);

mysqli_free_result($cotizacionView);

mysqli_free_result($infoProducto);

mysqli_free_result($modelosProducto);

mysqli_free_result($modeloSeleccionado);

mysqli_free_result($tiposProductos);

mysqli_free_result($motivosCotizaciones);

mysqli_free_result($clienteExistente);

mysqli_free_result($ultimoCliente);

mysqli_free_result($ultimaCotizacion);
?>
