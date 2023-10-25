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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "notasForm")) {
  $insertSQL = sprintf("INSERT INTO qts_notas (nota, ip, fecha, fechaID, creadorID, clienteID, estado) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['nota'], "text"),
                       GetSQLValueString($_POST['ip'], "text"),
                       GetSQLValueString($_POST['fecha'], "text"),
                       GetSQLValueString($_POST['fechaID'], "text"),
                       GetSQLValueString($_POST['creadorID'], "text"),
                       GetSQLValueString($_POST['clienteID'], "text"),
                       GetSQLValueString($_POST['estado'], "text"));
  $Result1 = mysqli_query($DKKadmin, $insertSQL) or die(mysqli_error($DKKadmin));
  $insertGoTo = "clientes_view.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "nuevoContactoForm")) {
  $insertSQL = sprintf("INSERT INTO qts_clientesContactos (clienteID, creadorID, nombre, correo, telefono, celular, ip, fecha, fechaID, estado) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['clienteID'], "text"),
                       GetSQLValueString($_POST['creadorID'], "text"),
                       GetSQLValueString($_POST['nombre'], "text"),
                       GetSQLValueString($_POST['correo'], "text"),
                       GetSQLValueString($_POST['telefono'], "text"),
                       GetSQLValueString($_POST['celular'], "text"),
                       GetSQLValueString($_POST['ip'], "text"),
                       GetSQLValueString($_POST['fecha'], "text"),
                       GetSQLValueString($_POST['fechaID'], "text"),
                       GetSQLValueString(isset($_POST['estado']) ? "true" : "", "defined","1","2"));
  $Result1 = mysqli_query($DKKadmin, $insertSQL) or die(mysqli_error($DKKadmin));
  $insertGoTo = "clientes_view.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "clienteForm")) {
  $updateSQL = sprintf("UPDATE qts_clientes SET rut=%s, nombre=%s, razonSocial=%s, sitioWeb=%s, correo=%s, telefono=%s, region=%s, comuna=%s, estado=%s WHERE id=%s",
                       GetSQLValueString($_POST['rut'], "text"),
                       GetSQLValueString($_POST['nombre'], "text"),
                       GetSQLValueString($_POST['razonSocial'], "text"),
                       GetSQLValueString($_POST['sitioWeb'], "text"),
                       GetSQLValueString($_POST['correo'], "text"),
                       GetSQLValueString($_POST['telefono'], "text"),
                       GetSQLValueString($_POST['region'], "text"),
                       GetSQLValueString($_POST['comuna'], "text"),
                       GetSQLValueString(isset($_POST['estado']) ? "true" : "", "defined","1","2"),
                       GetSQLValueString($_POST['id'], "int"));
  $Result1 = mysqli_query($DKKadmin, $updateSQL) or die(mysqli_error($DKKadmin));
  $updateGoTo = "clientes_view.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "editarContactoForm")) {
  $updateSQL = sprintf("UPDATE qts_clientesContactos SET nombre=%s, correo=%s, telefono=%s, celular=%s, estado=%s WHERE id=%s",
                       GetSQLValueString($_POST['nombre'], "text"),
                       GetSQLValueString($_POST['correo'], "text"),
                       GetSQLValueString($_POST['telefono'], "text"),
                       GetSQLValueString($_POST['celular'], "text"),
                       GetSQLValueString(isset($_POST['estado']) ? "true" : "", "defined","1","2"),
                       GetSQLValueString($_POST['id'], "int"));
  $Result1 = mysqli_query($DKKadmin, $updateSQL) or die(mysqli_error($DKKadmin));
  $updateGoTo = "clientes_view.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "editarDireccionForm")) {
  $updateSQL = sprintf("UPDATE qts_clientesDirecciones SET direccion1=%s, direccion2=%s, ciudad=%s, region=%s, comuna=%s, codigoPostal=%s, telefono=%s, estado=%s, principal=%s, facturacion=%s WHERE id=%s",
                       GetSQLValueString($_POST['direccion1'], "text"),
                       GetSQLValueString($_POST['direccion2'], "text"),
                       GetSQLValueString($_POST['ciudad'], "text"),
                       GetSQLValueString($_POST['region'], "text"),
                       GetSQLValueString($_POST['comuna'], "text"),
                       GetSQLValueString($_POST['codigoPostal'], "text"),
                       GetSQLValueString($_POST['telefono'], "text"),
                       GetSQLValueString(isset($_POST['estado']) ? "true" : "", "defined","1","2"),
                       GetSQLValueString(isset($_POST['principal']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['facturacion']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString($_POST['id'], "int"));
  $Result1 = mysqli_query($DKKadmin, $updateSQL) or die(mysqli_error($DKKadmin));
  $updateGoTo = "clientes_view.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "nuevaCotizacion")) {
  $insertSQL = sprintf("INSERT INTO qts_cotizaciones (creadorID, clienteID, lugarEntrega, lugarEntregaID, tiempoEntrega, tiempoEntregaAdicional, metodoPago, metodoPagoAdicional, formaPago, ip, fecha, fechaID, estado) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
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
                       GetSQLValueString($_POST['estado'], "text"));
  $Result1 = mysqli_query($DKKadmin, $insertSQL) or die(mysqli_error($DKKadmin));
  $insertGoTo = "qts_add.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "nuevaDireccionForm")) {
  $insertSQL = sprintf("INSERT INTO qts_clientesDirecciones (direccion1, direccion2, ciudad, region, comuna, codigoPostal, telefono, pais, ip, fecha, fechaID, creadorID, clienteID, estado, principal, facturacion) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['direccion1'], "text"),
                       GetSQLValueString($_POST['direccion2'], "text"),
                       GetSQLValueString($_POST['ciudad'], "text"),
                       GetSQLValueString($_POST['region'], "text"),
                       GetSQLValueString($_POST['comuna'], "text"),
                       GetSQLValueString($_POST['codigoPostal'], "text"),
                       GetSQLValueString($_POST['telefono'], "text"),
                       GetSQLValueString($_POST['pais'], "text"),
                       GetSQLValueString($_POST['ip'], "text"),
                       GetSQLValueString($_POST['fecha'], "text"),
                       GetSQLValueString($_POST['fechaID'], "text"),
                       GetSQLValueString($_POST['creadorID'], "text"),
                       GetSQLValueString($_POST['clienteID'], "text"),
                       GetSQLValueString(isset($_POST['estado']) ? "true" : "", "defined","1","2"),
                       GetSQLValueString(isset($_POST['principal']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['facturacion']) ? "true" : "", "defined","1","0"));
  $Result1 = mysqli_query($DKKadmin, $insertSQL) or die(mysqli_error($DKKadmin));
  $insertGoTo = "clientes_view.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

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

$cotizacionID = $_GET["id"];

$query_qtsClientesView = sprintf("SELECT * FROM qts_clientes WHERE qts_clientes.id = '$cotizacionID'");
$qtsClientesView = mysqli_query($DKKadmin, $query_qtsClientesView);
$row_qtsClientesView = mysqli_fetch_assoc($qtsClientesView);
$totalRows_qtsClientesView = mysqli_num_rows($qtsClientesView);

$idCliente = $row_qtsClientesView["id"];

$query_qtsContactosClientes = "SELECT * FROM qts_clientesContactos WHERE qts_clientesContactos.clienteID = '$idCliente' AND NOT qts_clientesContactos.estado = '0' ORDER BY qts_clientesContactos.id DESC";
$qtsContactosClientes = mysqli_query($DKKadmin, $query_qtsContactosClientes);
$row_qtsContactosClientes = mysqli_fetch_assoc($qtsContactosClientes);
$totalRows_qtsContactosClientes = mysqli_num_rows($qtsContactosClientes);

$query_qtsContactosClientesEditar = "SELECT * FROM qts_clientesContactos WHERE qts_clientesContactos.clienteID = '$idCliente' AND NOT qts_clientesContactos.estado = '0' ORDER BY qts_clientesContactos.id DESC";
$qtsContactosClientesEditar = mysqli_query($DKKadmin, $query_qtsContactosClientesEditar);
$row_qtsContactosClientesEditar = mysqli_fetch_assoc($qtsContactosClientesEditar);
$totalRows_qtsContactosClientesEditar = mysqli_num_rows($qtsContactosClientesEditar);

$query_qtsDireccionesClientes = "SELECT * FROM qts_clientesDirecciones WHERE qts_clientesDirecciones.clienteID = '$idCliente' AND NOT qts_clientesDirecciones.estado = '0' ORDER BY qts_clientesDirecciones.id DESC";
$qtsDireccionesClientes = mysqli_query($DKKadmin, $query_qtsDireccionesClientes);
$row_qtsDireccionesClientes = mysqli_fetch_assoc($qtsDireccionesClientes);
$totalRows_qtsDireccionesClientes = mysqli_num_rows($qtsDireccionesClientes);

$query_qtsDireccionesClientesEditar = "SELECT * FROM qts_clientesDirecciones WHERE qts_clientesDirecciones.clienteID = '$idCliente' AND NOT qts_clientesDirecciones.estado = '0' ORDER BY qts_clientesDirecciones.id DESC";
$qtsDireccionesClientesEditar = mysqli_query($DKKadmin, $query_qtsDireccionesClientesEditar);
$row_qtsDireccionesClientesEditar = mysqli_fetch_assoc($qtsDireccionesClientesEditar);
$totalRows_qtsDireccionesClientesEditar = mysqli_num_rows($qtsDireccionesClientesEditar);

$query_qtsDireccionesClientesCotizar = "SELECT * FROM qts_clientesDirecciones WHERE qts_clientesDirecciones.clienteID = '$idCliente' AND NOT qts_clientesDirecciones.estado = '0' ORDER BY qts_clientesDirecciones.id DESC";
$qtsDireccionesClientesCotizar = mysqli_query($DKKadmin, $query_qtsDireccionesClientesCotizar);
$row_qtsDireccionesClientesCotizar = mysqli_fetch_assoc($qtsDireccionesClientesCotizar);
$totalRows_qtsDireccionesClientesCotizar = mysqli_num_rows($qtsDireccionesClientesCotizar);

$query_qtsCotizacionesClientes = "SELECT * FROM qts_cotizaciones WHERE qts_cotizaciones.clienteID = '$idCliente' AND NOT qts_cotizaciones.estado = '0' ORDER BY qts_cotizaciones.id DESC";
$qtsCotizacionesClientes = mysqli_query($DKKadmin, $query_qtsCotizacionesClientes);
$row_qtsCotizacionesClientes = mysqli_fetch_assoc($qtsCotizacionesClientes);
$totalRows_qtsCotizacionesClientes = mysqli_num_rows($qtsCotizacionesClientes);
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
		<script src="js/validarut.js" type="text/javascript"></script>
        <script type="text/javascript">
            function onRutBlur(obj) {
                if (VerificaRut(obj.value))
                    document.getElementById("validado").innerHTML = "<button class='btn btn-sm btn-primary' type='submit'>Guardar Cliente</button>",
                    document.getElementById("no-valido").innerHTML = "<div class='alert alert-success alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button><p><a class='alert-link'>Perfecto</a>, el rut es correcto. Completa los campos restantes</p></div>";
                else 
                    document.getElementById("no-valido").innerHTML = "<div class='alert alert-warning alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button><p><a class='alert-link'>Atento</a>, debes ingresa un rut válido.</p></div>";
        
            }
        </script>
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
				<?php if ($row_datosAdmin["nivel"] != '1') { ?>
                	<?php if ($row_qtsClientesView["creadorID"] != $row_datosAdmin["id"]) { ?>
                    <meta http-equiv="refresh" content="0;URL='qts_cotizaciones.php'" />
                    <?php } ?>
				<?php } ?>
                <!-- header -->
                <div class="content bg-gray-lighter">
                    <div class="row items-push">
                        <div class="col-sm-7">
                            <h1 class="page-heading">
                                <?php echo $row_qtsClientesView["nombre"]; ?> <small>Estos son los datos asociados a este cliente.</small>
                            </h1>
                        </div>
                        <div class="col-sm-5 text-right hidden-xs">
                            <ol class="breadcrumb push-10-t">
                                <li>Dashboard</li>
                                <li>Cotizaciones</li>
                                <li><a class="link-effect" href="">Clientes</a></li>
                            </ol>
                        </div>
                    </div>
                </div>
                <!-- END header -->
                <!-- contenido -->
                <div class="content">
                    <!-- Simple Blocks -->
                    <div class="row">
                        <div class="col-sm-3 col-lg-3">
                            <div class="block block-bordered">
                                <div class="block-header">
                                    <ul class="block-options">
                                        <li>
                                            <button type="button" data-toggle="modal" data-target="#editarCliente"><i class="si si-pencil"></i></button>
                                        </li>
                                    </ul>
                                    <h3 class="block-title">Datos de la Empresa</h3>
                                </div>
                                <div class="block-content">
                                    <div class="form-group">
                                        <label>Estado</label>
                                        <p><span class="label label-<?php if ($row_qtsClientesView["estado"] == '1') { echo "success"; } if ($row_qtsClientesView["estado"] == '2') { echo "warning"; } if ($row_qtsClientesView["estado"] == '3') { echo "default"; } if ($row_qtsClientesView["estado"] == '0') { echo "danger"; }; ?>"><?php if ($row_qtsClientesView["estado"] == '1') { echo "ACTIVO"; } if ($row_qtsClientesView["estado"] == '2') { echo "INACTIVO"; } if ($row_qtsClientesView["estado"] == '3') { echo "SUSPENDIDO"; } if ($row_qtsClientesView["estado"] == '0') { echo "ELIMINADO"; }; ?></span></p>
                                    </div>
                                    <div class="form-group">
                                        <label>CID</label>
                                        <p>CID.<?php if ($row_qtsClientesView["id"] < 10) {echo "0000";} if ($row_qtsClientesView["id"] < 100 && $row_qtsClientesView["id"] > 10) {echo "000";} if ($row_qtsClientesView["id"] < 1000 && $row_qtsClientesView["id"] > 100) {echo "00";} if ($row_qtsClientesView["id"] < 10000 && $row_qtsClientesView["id"] > 1000) {echo "0";} if ($row_qtsClientesView["id"] < 100000 && $row_qtsClientesView["id"] > 10000) {echo "";} echo $row_qtsClientesView["id"]; ?></p>
                                    </div>
                                    <div class="form-group">
                                        <label>RUT</label>
                                        <p><?php echo $row_qtsClientesView["rut"]; ?></p>
                                    </div>
                                    <div class="form-group">
                                        <label>Nombre</label>
                                        <p><?php echo $row_qtsClientesView["nombre"]; ?></p>
                                    </div>
                                    <?php if (isset($row_qtsClientesView["razonSocial"])) { ?>
                                    <div class="form-group">
                                        <label>Razón Social</label>
                                        <p><?php echo $row_qtsClientesView["razonSocial"]; ?></p>
                                    </div>
                                    <?php } ?>
                                    <?php if ($row_datosAdmin["nivel"] == '1') { ?>
                                    <div class="form-group">
                                        <label>Agente Responsable</label>
                                        <p><?php 
												$idAgente = $row_qtsClientesView["creadorID"];
												$datosAgente = mysqli_query($DKKadmin,"SELECT * FROM admin WHERE admin.id = '$idAgente'"); 
												while($da = mysqli_fetch_array($datosAgente)){ 
											
												$agenteResponsable = $da['nombre']." ".$da['apellido']; 
											?>
                                          	<?php echo $agenteResponsable; ?>
                                        <?php } ?></p>
                                    </div>
                                    <?php } ?>
									<?php if (isset($row_qtsClientesView["sitioWeb"])) { ?>
                                    <div class="form-group">
                                        <label>Sitio Web</label>
                                        <p><a href="<?php echo $row_qtsClientesView["sitioWeb"]; ?>" target="_blank"><?php echo $row_qtsClientesView["sitioWeb"]; ?></a></p>
                                    </div>
                                    <?php } ?>
                                    <div class="form-group">
                                        <label>Correo Electrónico</label>
                                        <p><a href="mailto:<?php echo $row_qtsClientesView["correo"]; ?>"><?php echo $row_qtsClientesView["correo"]; ?></a></p>
                                    </div>
                                    <div class="form-group">
                                        <label>Teléfono de Contacto</label>
                                        <p><a href="tel:<?php echo $row_qtsClientesView["telefono"]; ?>"><?php echo $row_qtsClientesView["telefono"]; ?></a></p>
                                    </div>
                                    <div class="form-group">
                                        <label>Comuna</label>
                                        <p><?php echo $row_qtsClientesView["comuna"]; ?></p>
                                    </div>
                                    <div class="form-group">
                                        <label>Región</label>
                                        <p><?php echo $row_qtsClientesView["region"]; ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="block block-bordered">
                                <div class="block-header">
                                    <h3 class="block-title">Notas</h3>
                                </div>
                                <div class="block-content">
                                    <form method="POST" action="<?php echo $editFormAction; ?>" name="notasForm">
                                    	<div class="form-group">
                                        <textarea class="js-summernote" name="nota" id="nota"></textarea>
                                        </div>
                                        <div class="form-group">
                                        	<input type="hidden" name="ip" value="<?php echo $ip; ?>">
                                        	<input type="hidden" name="fecha" value="<?php echo $fecha; ?>">
                                        	<input type="hidden" name="fechaID" value="<?php echo $fechaHoy; ?>">
                                        	<input type="hidden" name="creadorID" value="<?php echo $idAdmin; ?>">
                                        	<input type="hidden" name="clienteID" value="<?php echo $idCliente; ?>">
                                        	<input type="hidden" name="estado" value="1">
                                            <button class="btn btn-sm btn-primary" type="submit">Guardar</button>
                                        </div>
                                        <input type="hidden" name="MM_insert" value="notasForm">
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-9 col-lg-9">
                            <div class="block block-bordered">
                                <div class="block-options">
                                    <div class="form-group">
                                    	<div class="col-xs-12 push-10-t">
                                        	<button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#nuevoContacto" type="button">Añadir Contacto</button>
                                        </div>
                                    </div>
                                </div>
								<div class="block-header">
                                    <h3 class="block-title">Contactos</h3>
                                </div>
                                <div class="block-content">
                                    <?php if ($totalRows_qtsContactosClientes == 0) { ?>
                                    <p>Este cliente no tiene contactos asignados. <a data-toggle="modal" data-target="#nuevoContacto" href="">Añade uno nuevo.</a></p>
                                    <?php } //Mostrar si hay contactos ?>
                                    <?php if ($totalRows_qtsContactosClientes > 0) { ?>
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th class="text-center" style="width: 50px;">#</th>
                                                <th>Nombre</th>
                                                <th class="hidden-xs">Correo</th>
                                                <th class="hidden-xs" >Teléfono</th>
                                                <th class="hidden-xs" >Celular</th>
                                                <th class="hidden-xs" style="width: 80px;">Estado</th>
                                                <th class="text-center" style="width: 100px;">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php do { ?>
                                            <tr style="font-size:12px;">
                                                <td class="text-center">CCL.<?php if ($row_qtsContactosClientes["id"] < 10) {echo "0000";} if ($row_qtsContactosClientes["id"] < 100 && $row_qtsContactosClientes["id"] > 10) {echo "000";} if ($row_qtsContactosClientes["id"] < 1000 && $row_qtsContactosClientes["id"] > 100) {echo "00";} if ($row_qtsContactosClientes["id"] < 10000 && $row_qtsContactosClientes["id"] > 1000) {echo "0";} if ($row_qtsContactosClientes["id"] < 100000 && $row_qtsContactosClientes["id"] > 10000) {echo "";} echo $row_qtsContactosClientes["id"]; ?></td>
                                                <td><?php echo $row_qtsContactosClientes["nombre"]; ?></td>
                                                <td class="hidden-xs"><a href="mailto:<?php echo $row_qtsContactosClientes["correo"]; ?>"><?php echo $row_qtsContactosClientes["correo"]; ?></a></td>
                                                <td class="hidden-xs"><?php if (isset($row_qtsContactosClientes["telefono"])) { echo $row_qtsContactosClientes["telefono"]; } ?></td>
                                                <td class="hidden-xs"><?php if (isset($row_qtsContactosClientes["celular"])) { echo $row_qtsContactosClientes["celular"]; } ?></td>
                                                <td class="hidden-xs">
                                                  <span class="push-5-t label label-<?php if ($row_qtsContactosClientes["estado"] == '1') { echo "success"; } if ($row_qtsContactosClientes["estado"] == '2') { echo "warning"; } if ($row_qtsContactosClientes["estado"] == '3') { echo "default"; } if ($row_qtsContactosClientes["estado"] == '0') { echo "danger"; }; ?>"><?php if ($row_qtsContactosClientes["estado"] == '1') { echo "ACTIVO"; } if ($row_qtsContactosClientes["estado"] == '2') { echo "INACTIVO"; } if ($row_qtsContactosClientes["estado"] == '3') { echo "SUSPENDIDO"; } if ($row_qtsContactosClientes["estado"] == '0') { echo "ELIMINADO"; }; ?></span>
                                                </td>
                                                <td class="text-center">
                                                  <div class="btn-group">
                                                    <button class="btn btn-xs btn-default" type="button" data-toggle="modal" data-target="#editarContacto<?php echo $row_qtsContactosClientes["id"]; ?>"  title="Editar Contacto"><i class="fa fa-pencil"></i></button>
                                                    <button class="btn btn-xs btn-default" type="button" data-toggle="tooltip" title="Eliminar Contacto" onClick="location.href='clientes_contactos_remove.php?id=<?php echo $row_qtsContactosClientes["id"]; ?>'"><i class="fa fa-times"></i></button>
                                                    </div>
                                                </td>
                                              </tr>
                                              <?php } while ($row_qtsContactosClientes = mysqli_fetch_assoc($qtsContactosClientes)); ?>
                                        </tbody>
                                    </table>
                                    <?php } //Mostrar si hay contactos ?>
                                </div>
                            </div>
                            
                            <div class="block block-bordered">
                                <div class="block-options">
                                    <div class="form-group">
                                    	<div class="col-xs-12 push-10-t">
                                        	<button class="btn btn-sm btn-primary" type="button" data-toggle="modal" data-target="#nuevaDireccion">Nueva Dirección</button>
                                        </div>
                                    </div>
                                </div>
								<div class="block-header">
                                    <h3 class="block-title">Direcciones</h3>
                                </div>
                                <div class="block-content">
                                    <?php if ($totalRows_qtsDireccionesClientes == 0) { ?>
                                    <p>Este cliente aún no tiene direcciones asociadas. <a href="#" data-toggle="modal" data-target="#nuevaDireccion">Agrega una nueva dirección.</a></p>
                                    <?php } //Mostrar si NO hay direcciones ?>
                                    <?php if ($totalRows_qtsDireccionesClientes > 0) { ?>
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th class="text-center" style="width: 50px;">#</th>
                                                <th>Direccion</th>
                                                <th class="hidden-xs">Comuna</th>
                                                <th class="hidden-xs" >Region</th>
                                                <th align="center" style="text-align:center;">Principal</th>
                                                <th align="center" style="text-align:center;">Facturación</th>
                                                <th class="hidden-xs" style="width: 80px;">Estado</th>
                                                <th class="text-center" style="width: 100px;">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php do { ?>
                                            <tr style="font-size:12px;">
                                                <td class="text-center">DCL.<?php if ($row_qtsDireccionesClientes["id"] < 10) {echo "0000";} if ($row_qtsDireccionesClientes["id"] < 100 && $row_qtsDireccionesClientes["id"] > 10) {echo "000";} if ($row_qtsDireccionesClientes["id"] < 1000 && $row_qtsDireccionesClientes["id"] > 100) {echo "00";} if ($row_qtsDireccionesClientes["id"] < 10000 && $row_qtsDireccionesClientes["id"] > 1000) {echo "0";} if ($row_qtsDireccionesClientes["id"] < 100000 && $row_qtsDireccionesClientes["id"] > 10000) {echo "";} echo $row_qtsDireccionesClientes["id"]; ?></td>
                                                <td><?php echo $row_qtsDireccionesClientes["direccion1"]; ?></td>
                                                <td class="hidden-xs"><?php echo $row_qtsDireccionesClientes["comuna"]; ?></td>
                                                <td class="hidden-xs"><?php echo $row_qtsDireccionesClientes["region"]; ?></td>
                                                <td align="center" style="text-align:center;"><?php if ($row_qtsDireccionesClientes["principal"] == '1') {echo"<i class='fa fa-circle text-success text-center'></i>";} ?></td>
                                                <td align="center" style="text-align:center;"><?php if ($row_qtsDireccionesClientes["facturacion"] == '1') {echo"<i class='fa fa-circle text-success text-center'></i>";} ?></td>
                                                <td class="hidden-xs">
                                                  <span class="push-5-t label label-<?php if ($row_qtsDireccionesClientes["estado"] == '1') { echo "success"; } if ($row_qtsDireccionesClientes["estado"] == '2') { echo "warning"; } if ($row_qtsDireccionesClientes["estado"] == '3') { echo "default"; } if ($row_qtsDireccionesClientes["estado"] == '0') { echo "danger"; }; ?>"><?php if ($row_qtsDireccionesClientes["estado"] == '1') { echo "ACTIVO"; } if ($row_qtsDireccionesClientes["estado"] == '2') { echo "INACTIVO"; } if ($row_qtsDireccionesClientes["estado"] == '3') { echo "SUSPENDIDO"; } if ($row_qtsDireccionesClientes["estado"] == '0') { echo "ELIMINADO"; }; ?></span>
                                                </td>
                                                <td class="text-center">
                                                  <div class="btn-group">
                                                    <button class="btn btn-xs btn-default" type="button" data-toggle="modal" data-target="#editarDireccion<?php echo $row_qtsDireccionesClientes["id"]; ?>"  title="Editar Dirección"><i class="fa fa-pencil"></i></button>
                                                    <button class="btn btn-xs btn-default" type="button" data-toggle="tooltip" title="Eliminar Dirección" onClick="location.href='clientes_direcciones_remove.php?id=<?php echo $row_qtsDireccionesClientes["id"]; ?>'"><i class="fa fa-times"></i></button>
                                                    </div>
                                                </td>
                                              </tr>
                                              <?php } while ($row_qtsDireccionesClientes = mysqli_fetch_assoc($qtsDireccionesClientes)); ?>
                                        </tbody>
                                    </table>
                                    <?php } //Mostrar si hay direcciones ?>
                                </div>
                            </div>

                            <div class="block block-bordered">
                                <div class="block-options">
                                    <div class="form-group">
                                    	<div class="col-xs-12 push-10-t">
                                        	<button class="btn btn-sm btn-primary" type="button" data-toggle="modal" data-target="#nuevaCotizacion">Nueva Cotización</button>
                                        </div>
                                    </div>
                                </div>
								<div class="block-header">
                                    <h3 class="block-title">Cotizaciones</h3>
                                </div>
                                <div class="block-content">
                                    <?php if ($totalRows_qtsCotizacionesClientes == 0) { ?>
                                    <p>Este cliente aún no tiene cotizaciones. <a href="#" data-toggle="modal" data-target="#nuevaCotizacion">Crea la primera.</a></p>
                                    <?php } //Mostrar si NO hay cotzaciones ?>
                                    <?php if ($totalRows_qtsCotizacionesClientes > 0) { ?>
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th class="text-center" style="width: 50px;">#</th>
                                                <th>Fecha</th>
                                                <?php if ($row_datosAdmin["nivel"] == '1') { ?>
                                                <th class="hidden-xs">Agente</th>
                                                <?php } // Solo ADMIN ?>
                                                <th class="hidden-xs" >Tiempo Entrega</th>
                                                <th class="hidden-xs" >Método de Pago</th>
                                                <th class="hidden-xs" style="width: 80px;">Estado</th>
                                                <th class="text-center" style="width: 100px;">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php do { ?>
                                            <tr style="font-size:12px;">
                                                <td class="text-center">QTE.<?php if ($row_qtsCotizacionesClientes["id"] < 10) {echo "0000";} if ($row_qtsCotizacionesClientes["id"] < 100 && $row_qtsCotizacionesClientes["id"] > 10) {echo "000";} if ($row_qtsCotizacionesClientes["id"] < 1000 && $row_qtsCotizacionesClientes["id"] > 100) {echo "00";} if ($row_qtsCotizacionesClientes["id"] < 10000 && $row_qtsCotizacionesClientes["id"] > 1000) {echo "0";} if ($row_qtsCotizacionesClientes["id"] < 100000 && $row_qtsCotizacionesClientes["id"] > 10000) {echo "";} echo $row_qtsCotizacionesClientes["id"]; ?></td>
                                                <td><?php echo $row_qtsCotizacionesClientes["fecha"]; ?></td>
                                                <?php if ($row_datosAdmin["nivel"] == '1') { ?>
                                                <td class="hidden-xs"><?php 
														$idAgenteQTE = $row_qtsCotizacionesClientes["creadorID"];
														$datosAgenteQTE = mysqli_query($DKKadmin,"SELECT * FROM admin WHERE admin.id = '$idAgenteQTE'"); 
														while($daQTE = mysqli_fetch_array($datosAgenteQTE)){ 
													
														$agenteResponsableQTE = $daQTE['nombre']." ".$daQTE['apellido']; 
													?>
													<?php echo $agenteResponsableQTE; ?>
												<?php } ?></td>
                                                <?php } // Solo ADMIN ?>
                                                <td class="hidden-xs"><?php if ($row_qtsCotizacionesClientes["tiempoEntrega"] == '1') {echo"Inmediato";} if ($row_qtsCotizacionesClientes["tiempoEntrega"] == '2') {echo"60 días";} if ($row_qtsCotizacionesClientes["tiempoEntrega"] == '3') {echo $row_qtsCotizacionesClientes["tiempoEntregaAdicional"];} ?></td>
                                                <td class="hidden-xs"><?php if ($row_qtsCotizacionesClientes["metodoPago"] == '1') {echo"Transferencia";} if ($row_qtsCotizacionesClientes["metodoPago"] == '2') {echo"Depósito";} if ($row_qtsCotizacionesClientes["metodoPago"] == '3') {echo "TC <small>".$row_qtsCotizacionesClientes["metodoPagoAdicional"]."</small>";} ?></td>
                                                <td class="hidden-xs">
                                                  <span class="push-5-t label label-<?php if ($row_qtsCotizacionesClientes["estado"] == '1') { echo "warning"; } if ($row_qtsCotizacionesClientes["estado"] == '2') { echo "success"; } if ($row_qtsCotizacionesClientes["estado"] == '3') { echo "default"; } if ($row_qtsCotizacionesClientes["estado"] == '0') { echo "danger"; }; ?>"><?php if ($row_qtsCotizacionesClientes["estado"] == '1') { echo "INGRESADA"; } if ($row_qtsCotizacionesClientes["estado"] == '2') { echo "ENVIADA"; } if ($row_qtsCotizacionesClientes["estado"] == '3') { echo "CANCELADA"; } if ($row_qtsCotizacionesClientes["estado"] == '0') { echo "ELIMINADA"; }; ?></span>
                                                </td>
                                                <td class="text-center">
                                                  <div class="btn-group">
                                                    <button class="btn btn-xs btn-default" type="button" onClick="location.href='qts_view.php?id=<?php echo $row_qtsCotizacionesClientes["id"]; ?>'" title="Ver Cotización"><i class="fa fa-eye"></i></button>
                                                    <button class="btn btn-xs btn-default" type="button" onClick="location.href='qts_edit.php?id=<?php echo $row_qtsCotizacionesClientes["id"]; ?>'" title="Editar Cotización"><i class="fa fa-pencil"></i></button>
                                                    <button class="btn btn-xs btn-default" type="button" data-toggle="tooltip" title="Eliminar Cotización" onClick="location.href='qts_remove.php?id=<?php echo $row_qtsCotizacionesClientes["id"]; ?>'"><i class="fa fa-times"></i></button>
                                                    </div>
                                                </td>
                                              </tr>
                                              <?php } while ($row_qtsCotizacionesClientes = mysqli_fetch_assoc($qtsCotizacionesClientes)); ?>
                                        </tbody>
                                    </table>
                                    <?php } //Mostrar si hay cotzaciones ?>
                                </div>
                            </div>
                                                        
                        </div>
                    </div>
                    <!-- END info cliente -->
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
        <!-- editar cliente -->
        <div class="modal fade" id="editarCliente" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-top">
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
                            <div class="row">
                                <div class="col-lg-12">
                                  <form method="POST" action="<?php echo $editFormAction; ?>" class="form-horizontal push-30-t push-30" name="clienteForm">
                                        <div class="form-group">
                                            <div class="col-xs-12"><div id="no-valido"></div></div>
                                            <div class="col-xs-12">
                                                <div class="form-material form-material-primary">
                                                    <p>CID.<?php if ($row_qtsClientesView["id"] < 10) {echo "0000";} if ($row_qtsClientesView["id"] < 100 && $row_qtsClientesView["id"] > 10) {echo "000";} if ($row_qtsClientesView["id"] < 1000 && $row_qtsClientesView["id"] > 100) {echo "00";} if ($row_qtsClientesView["id"] < 10000 && $row_qtsClientesView["id"] > 1000) {echo "0";} if ($row_qtsClientesView["id"] < 100000 && $row_qtsClientesView["id"] > 10000) {echo "";} echo $row_qtsClientesView["id"]; ?></p>
                                                    <label for="id">CID</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-xs-12">
                                                <div class="form-material form-material-primary">
                                                    <input class="form-control" type="text" id="razonSocial" name="razonSocial" value="<?php echo $row_qtsClientesView["razonSocial"]; ?>">
                                                    <label for="razonSocial">Razón Social</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-xs-12">
                                                <div class="form-material form-material-primary">
                                                    <input class="form-control" type="text" placeholder="Ej.: 123456789-0" id="rut" name="rut" onBlur="onRutBlur(this);" required value="<?php echo $row_qtsClientesView["rut"]; ?>">
                                                    <label for="rut">RUT de la Empresa</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-xs-12">
                                                <div class="form-material form-material-primary">
                                                    <input class="form-control" type="text" id="nombre" name="nombre" required value="<?php echo $row_qtsClientesView["nombre"]; ?>">
                                                    <label for="nombre">Nombre de Contacto (*)</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-xs-12">
                                                <div class="form-material form-material-primary">
                                                    <input class="form-control" type="url" id="sitioWeb" name="sitioWeb" value="<?php echo $row_qtsClientesView["sitioWeb"]; ?>">
                                                    <label for="sitioWeb">Sitio Web</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-xs-6">
                                                <div class="form-material form-material-primary">
                                                    <input class="form-control" type="email" id="correo" name="correo" required value="<?php echo $row_qtsClientesView["correo"]; ?>">
                                                    <label for="correo">Correo Electrónico (*)</label>
                                                </div>
                                            </div>
                                            <div class="col-xs-6">
                                                <div class="form-material form-material-primary">
                                                    <input class="form-control" type="text" id="telefono" name="telefono" required value="<?php echo $row_qtsClientesView["telefono"]; ?>">
                                                    <label for="telefono">Teléfono Principal (*)</label>
                                                </div>
                                            </div>
                                        </div>
										<div class="form-group">
                                            <div class="col-xs-6">
                                                <div class="form-material">
                                                    <select class="js-select2 form-control" id="regiones" name="region" style="width: 100%; z-index: 99999;" data-placeholder="Selecciona una Región.." required>
                                                        <option></option>
                                                    </select>
                                                    <label for="regiones">Región (*)</label>
                                                </div>
                                            </div>
                                            <div class="col-xs-6">
                                                <div class="form-material">
                                                    <select class="js-select2 form-control" id="comunas" name="comuna" style="width: 100%; z-index: 99999;" data-placeholder="Selecciona una Comuna.." required>
                                                        <option></option>
                                                    </select>
                                                    <label for="comunas">Comuna (*)</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-xs-12">Estado</label>
                                            <div class="col-xs-12">
                                                <label class="css-input switch switch-sm switch-primary">
                                                    <input <?php if (!(strcmp($row_qtsClientesView['estado'],1))) {echo "checked=\"checked\"";} ?> type="checkbox" id="estado" name="estado"><span></span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-xs-12">
                                            	<input type="hidden" name="id" value="<?php echo $row_qtsClientesView["id"]; ?>">
                                                <div id="validado" class="center">
                                                  <button class='btn btn-sm btn-primary' name='send' id='send' type='submit' disabled='disabled'>Guardar Cliente</button>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" name="MM_update" value="clienteForm">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END editar cliente -->
        
        <!-- nueva dirección -->
        <div class="modal fade" id="nuevaDireccion" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-top">
                <div class="modal-content">
                    <div class="block block-themed block-transparent remove-margin-b">
                        <div class="block-header bg-primary-dark">
                            <ul class="block-options">
                                <li>
                                    <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
                                </li>
                            </ul>
                            <h3 class="block-title">Nueva Dirección</h3>
                        </div>
                        <div class="block-content">
                            <div class="row">
                                <div class="col-lg-12">
                                  <form method="POST" action="<?php echo $editFormAction; ?>" class="form-horizontal push-30-t push-30" name="nuevaDireccionForm">
                                        <div class="form-group">
                                            <div class="col-xs-12">
                                                <div class="form-material form-material-primary">
                                                    <input class="form-control" type="text" id="direccion1" name="direccion1" required>
                                                    <label for="direccion1">Dirección 1 (*)</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-xs-12">
                                                <div class="form-material form-material-primary">
                                                    <input class="form-control" type="text" id="direccion2" name="direccion2">
                                                    <label for="direccion2">Dirección 2</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-xs-12">
                                                <div class="form-material form-material-primary">
                                                    <input class="form-control" type="text" id="ciudad" name="ciudad" required>
                                                    <label for="ciudad">Ciudad (*)</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-xs-12">
                                                <div class="form-material">
                                                    <select class="form-control" id="regiones" name="region" style="width: 100%;" data-placeholder="Selecciona la Región...">
                                                        <option></option>
                                                    </select>
                                                    <label for="regiones">Región</label>
                                                </div>
                                            </div>
                                            <div class="col-xs-12">
                                                <div class="form-material">
                                                    <select class="form-control" id="comunas" name="comuna" style="width: 100%;" data-placeholder="Selecciona la Comuna...">
                                                        <option></option>
                                                    </select>
                                                    <label for="comunas">Comuna</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-xs-6">
                                                <div class="form-material form-material-primary">
                                                    <input class="form-control" type="text" id="telefono" name="telefono">
                                                    <label for="telefono">Teléfono de Contacto</label>
                                                </div>
                                            </div>
                                            <div class="col-xs-6">
                                                <div class="form-material form-material-primary">
                                                    <input class="form-control" type="text" id="codigoPostal" name="codigoPostal">
                                                    <label for="codigoPostal">Código Postal</label>
                                                </div>
                                            </div>
                                        </div>
										<div class="form-group">
                                            <div class="col-xs-12">
                                                <div class="checkbox">
                                                    <label for="principal">
                                                        <input type="checkbox" id="principal" name="principal" <?php if ($totalRows_qtsDireccionesClientes == 0) {echo"checked='checked'";} ?> > Principal
                                                    </label>
                                                </div>
                                                <div class="checkbox">
                                                    <label for="facturacion">
                                                        <input type="checkbox" id="facturacion" name="facturacion"> Facturación
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-xs-12">Estado</label>
                                            <div class="col-xs-12">
                                                <label class="css-input switch switch-sm switch-primary">
                                                    <input type="checkbox" id="estado" name="estado" checked><span></span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-xs-12">
                                            	<input type="hidden" name="pais" value="Chile">
                                            	<input type="hidden" name="ip" value="<?php echo $ip; ?>">
                                                <input type="hidden" name="fecha" value="<?php echo $fecha; ?>">
                                                <input type="hidden" name="fechaID" value="<?php echo $fechaHoy; ?>">
                                                <input type="hidden" name="creadorID" value="<?php echo $idAdmin; ?>">
                                                <input type="hidden" name="clienteID" value="<?php echo $idCliente; ?>">
                                                <button class='btn btn-sm btn-primary' type='submit'>Agregar Dirección</button>
                                            </div>
                                        </div>
                                        <input type="hidden" name="MM_insert" value="nuevaDireccionForm">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END nueva dirección -->
        <?php do { ?>
        <!-- editar dirección #<?php echo $row_qtsDireccionesClientesEditar["id"]; ?> -->
        <div class="modal fade" id="editarDireccion<?php echo $row_qtsDireccionesClientesEditar["id"]; ?>" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-top">
                <div class="modal-content">
                    <div class="block block-themed block-transparent remove-margin-b">
                        <div class="block-header bg-primary-dark">
                            <ul class="block-options">
                                <li>
                                    <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
                                </li>
                            </ul>
                            <h3 class="block-title">Editar Dirección</h3>
                        </div>
                        <div class="block-content">
                            <div class="row">
                                <div class="col-lg-12">
                                  <form method="POST" action="<?php echo $editFormAction; ?>" class="form-horizontal push-30-t push-30" name="editarDireccionForm">
                                        <div class="form-group">
                                            <div class="col-xs-12">
                                                <div class="form-material form-material-primary">
                                                    <input class="form-control" type="text" id="direccion1" name="direccion1" value="<?php echo $row_qtsDireccionesClientesEditar["direccion1"]; ?>" required>
                                                    <label for="direccion1">Dirección 1 (*)</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-xs-12">
                                                <div class="form-material form-material-primary">
                                                    <input class="form-control" type="text" id="direccion2" name="direccion2" value="<?php echo $row_qtsDireccionesClientesEditar["direccion2"]; ?>" >
                                                    <label for="direccion2">Dirección 2</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-xs-12">
                                                <div class="form-material form-material-primary">
                                                    <input class="form-control" type="text" id="ciudad" name="ciudad" value="<?php echo $row_qtsDireccionesClientesEditar["ciudad"]; ?>" required>
                                                    <label for="ciudad">Ciudad (*)</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-xs-12">
                                                <div class="form-material">
                                                    <select class="form-control" id="regiones" name="region" style="width: 100%;" data-placeholder="Selecciona la Región...">
                                                        <option value="<?php echo $row_qtsDireccionesClientesEditar["region"]; ?>" ><?php echo $row_qtsDireccionesClientesEditar["region"]; ?></option>
                                                    </select>
                                                    <label for="regiones">Región</label>
                                                </div>
                                            </div>
                                            <div class="col-xs-12">
                                                <div class="form-material">
                                                    <select class="form-control" id="comunas" name="comuna" style="width: 100%;" data-placeholder="Selecciona la Comuna...">
                                                        <option value="<?php echo $row_qtsDireccionesClientesEditar["comuna"]; ?>"><?php echo $row_qtsDireccionesClientesEditar["comuna"]; ?></option>
                                                    </select>
                                                    <label for="comunas">Comuna</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-xs-6">
                                                <div class="form-material form-material-primary">
                                                    <input class="form-control" type="text" id="telefono" value="<?php echo $row_qtsDireccionesClientesEditar["telefono"]; ?>" name="telefono">
                                                    <label for="telefono">Teléfono de Contacto</label>
                                                </div>
                                            </div>
                                            <div class="col-xs-6">
                                                <div class="form-material form-material-primary">
                                                    <input class="form-control" type="text" id="codigoPostal" value="<?php echo $row_qtsDireccionesClientesEditar["codigoPostal"]; ?>" name="codigoPostal">
                                                    <label for="codigoPostal">Código Postal</label>
                                                </div>
                                            </div>
                                        </div>
										<div class="form-group">
                                            <div class="col-xs-12">
                                                <div class="checkbox">
                                                    <label for="principal">
                                                        <input <?php if (!(strcmp($row_qtsDireccionesClientesEditar['principal'],1))) {echo "checked=\"checked\"";} ?> type="checkbox" id="principal" name="principal"> Principal
                                                    </label>
                                                </div>
                                                <div class="checkbox">
                                                    <label for="facturacion">
                                                        <input <?php if (!(strcmp($row_qtsDireccionesClientesEditar['facturacion'],1))) {echo "checked=\"checked\"";} ?> type="checkbox" id="facturacion" name="facturacion"> Facturación
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-xs-12">Estado</label>
                                            <div class="col-xs-12">
                                                <label class="css-input switch switch-sm switch-primary">
                                                    <input <?php if (!(strcmp($row_qtsDireccionesClientesEditar['estado'],1))) {echo "checked=\"checked\"";} ?> type="checkbox" id="estado" name="estado" checked><span></span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-xs-12">
                                            	<input type="hidden" name="id" value="<?php echo $row_qtsDireccionesClientesEditar["id"]; ?>">
                                                <button class='btn btn-sm btn-primary' type='submit'>Editar Dirección</button>
                                            </div>
                                        </div>
                                        <input type="hidden" name="MM_update" value="editarDireccionForm">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END editar dirección -->
        <?php } while ($row_qtsDireccionesClientesEditar = mysqli_fetch_assoc($qtsDireccionesClientesEditar)); ?>
        <!-- nueva cotización -->
        <div class="modal fade" id="nuevaCotizacion" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-top">
                <div class="modal-content">
                    <div class="block block-themed block-transparent remove-margin-b">
                        <div class="block-header bg-primary-dark">
                            <ul class="block-options">
                                <li>
                                    <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
                                </li>
                            </ul>
                            <h3 class="block-title">Nueva Cotización</h3>
                        </div>
                        <div class="block-content">
                            <div class="row">
                                <div class="col-xs-12">
                                  <form method="POST" action="<?php echo $editFormAction; ?>" name="nuevaCotizacion">
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
                                                        <input type="radio" id="tiempoEntrega2" name="tiempoEntrega" value="2"> 30 días
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
                                                        <input type="radio" id="metodoPago1" name="metodoPago" value="1" checked> Efectivo o Transferencia Bancaria
                                                    </label>
                                                </div>
                                                <div class="radio">
                                                    <label for="metodoPago2">
                                                        <input type="radio" id="metodoPago2" name="metodoPago" value="2"> Tarjeta de Crédito
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
                                            	<input type="hidden" name="estado" value="1">
                                            	<input type="hidden" name="ip" value="<?php echo $ip; ?>">
                                                <input type="hidden" name="fecha" value="<?php echo $fecha; ?>">
                                                <input type="hidden" name="fechaID" value="<?php echo $fechaHoy; ?>">
                                                <input type="hidden" name="creadorID" value="<?php echo $idAdmin; ?>">
                                                <input type="hidden" name="clienteID" value="<?php echo $idCliente; ?>">
                                                <button class='btn btn-sm btn-primary push-20 push-20-t' type='submit'>Crear Cotización</button>
                                            </div>
                                        </div>
                                        <input type="hidden" name="MM_insert" value="nuevaCotizacion">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END nueva cotización -->
        <!-- nuevo contacto -->
        <div class="modal fade" id="nuevoContacto" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-top">
                <div class="modal-content">
                    <div class="block block-themed block-transparent remove-margin-b">
                        <div class="block-header bg-primary-dark">
                            <ul class="block-options">
                                <li>
                                    <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
                                </li>
                            </ul>
                            <h3 class="block-title">Nuevo Contacto</h3>
                        </div>
                        <div class="block-content">
                            <div class="row">
                                <div class="col-lg-12">
                                  <form method="POST" action="<?php echo $editFormAction; ?>" class="form-horizontal push-30-t push-30" name="nuevoContactoForm">
                                        <div class="form-group">
                                            <div class="col-xs-12">
                                                <div class="form-material form-material-primary">
                                                    <input class="form-control" type="text" id="nombre" name="nombre" required>
                                                    <label for="nombre">Nombre (*)</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-xs-12">
                                                <div class="form-material form-material-primary">
                                                    <input class="form-control" type="email" id="correo" name="correo" required>
                                                    <label for="correo">Correo Electrónico (*)</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-xs-6">
                                                <div class="form-material form-material-primary">
                                                    <input class="form-control" type="text" id="telefono" name="telefono">
                                                    <label for="telefono">Teléfono Fijo</label>
                                                </div>
                                            </div>
                                            <div class="col-xs-6">
                                                <div class="form-material form-material-primary">
                                                    <input class="form-control" type="text" id="celular" name="celular" required>
                                                    <label for="celular">Teléfono Celular (*)</label>
                                                </div>
                                            </div>
                                        </div>
										<div class="form-group">
                                            <label class="col-xs-12">Estado</label>
                                            <div class="col-xs-12">
                                                <label class="css-input switch switch-sm switch-primary">
                                                    <input type="checkbox" id="estado" name="estado" checked><span></span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-xs-12">
                                            	<input type="hidden" name="ip" value="<?php echo $ip; ?>">
                                                <input type="hidden" name="fecha" value="<?php echo $fecha; ?>">
                                                <input type="hidden" name="fechaID" value="<?php echo $fechaHoy; ?>">
                                                <input type="hidden" name="creadorID" value="<?php echo $idAdmin; ?>">
                                                <input type="hidden" name="clienteID" value="<?php echo $idCliente; ?>">
                                                <button class='btn btn-sm btn-primary' type='submit'>Crear Contacto</button>
                                            </div>
                                        </div>
                                        <input type="hidden" name="MM_insert" value="nuevoContactoForm">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END nuevo contacto -->
        <?php do { ?>
        <!-- editar contacto #<?php echo $row_qtsContactosClientesEditar["id"]; ?> -->
        <div class="modal fade" id="editarContacto<?php echo $row_qtsContactosClientesEditar["id"]; ?>" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-top">
                <div class="modal-content">
                    <div class="block block-themed block-transparent remove-margin-b">
                        <div class="block-header bg-primary-dark">
                            <ul class="block-options">
                                <li>
                                    <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
                                </li>
                            </ul>
                            <h3 class="block-title">Editar Contacto</h3>
                        </div>
                        <div class="block-content">
                            <div class="row">
                                <div class="col-lg-12">
                                    <form method="POST" action="<?php echo $editFormAction; ?>" class="form-horizontal push-30-t push-30" name="editarContactoForm">
                                        <div class="form-group">
                                            <div class="col-xs-12">
                                                <div class="form-material form-material-primary">
                                                    <input class="form-control" type="text" id="nombre" name="nombre" required value="<?php echo $row_qtsContactosClientesEditar["nombre"]; ?>">
                                                    <label for="nombre">Nombre (*)</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-xs-12">
                                                <div class="form-material form-material-primary">
                                                    <input class="form-control" type="email" id="correo" name="correo" required value="<?php echo $row_qtsContactosClientesEditar["correo"]; ?>">
                                                    <label for="correo">Correo Electrónico</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-xs-6">
                                                <div class="form-material form-material-primary">
                                                    <input class="form-control" type="text" id="telefono" name="telefono" value="<?php echo $row_qtsContactosClientesEditar["telefono"]; ?>">
                                                    <label for="telefono">Teléfono Fijo</label>
                                                </div>
                                            </div>
                                            <div class="col-xs-6">
                                                <div class="form-material form-material-primary">
                                                    <input class="form-control" type="text" id="celular" name="celular" required value="<?php echo $row_qtsContactosClientesEditar["celular"]; ?>">
                                                    <label for="celular">Teléfono Celular (*)</label>
                                                </div>
                                            </div>
                                        </div>
										<div class="form-group">
                                            <label class="col-xs-12">Estado</label>
                                            <div class="col-xs-12">
                                                <label class="css-input switch switch-sm switch-primary">
                                                    <input <?php if (!(strcmp($row_qtsContactosClientesEditar['estado'],1))) {echo "checked=\"checked\"";} ?> type="checkbox" id="estado" name="estado"><span></span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-xs-12">
                                            	<input type="hidden" name="id" value="<?php echo $row_qtsContactosClientesEditar["id"]; ?>">
                                                <button class='btn btn-sm btn-primary' type='submit'>Editar Contacto</button>
                                            </div>
                                        </div>
                                        <input type="hidden" name="MM_update" value="editarContactoForm">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END editar contacto #<?php echo $row_qtsContactosClientesEditar["id"]; ?> -->
        <?php } while ($row_qtsContactosClientesEditar = mysqli_fetch_assoc($qtsContactosClientesEditar)); ?>
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
        <script>
		var RegionesYcomunas = {
			"regiones": [{
					"NombreRegion": "Arica y Parinacota",
					"comunas": ["Arica", "Camarones", "Putre", "General Lagos"]
			},
				{
					"NombreRegion": "Tarapacá",
					"comunas": ["Iquique", "Alto Hospicio", "Pozo Almonte", "Camiña", "Colchane", "Huara", "Pica"]
			},
				{
					"NombreRegion": "Antofagasta",
					"comunas": ["Antofagasta", "Mejillones", "Sierra Gorda", "Taltal", "Calama", "Ollagüe", "San Pedro de Atacama", "Tocopilla", "María Elena"]
			},
				{
					"NombreRegion": "Atacama",
					"comunas": ["Copiapó", "Caldera", "Tierra Amarilla", "Chañaral", "Diego de Almagro", "Vallenar", "Alto del Carmen", "Freirina", "Huasco"]
			},
				{
					"NombreRegion": "Coquimbo",
					"comunas": ["La Serena", "Coquimbo", "Andacollo", "La Higuera", "Paiguano", "Vicuña", "Illapel", "Canela", "Los Vilos", "Salamanca", "Ovalle", "Combarbalá", "Monte Patria", "Punitaqui", "Río Hurtado"]
			},
				{
					"NombreRegion": "Valparaíso",
					"comunas": ["Valparaíso", "Casablanca", "Concón", "Juan Fernández", "Puchuncaví", "Quintero", "Viña del Mar", "Isla de Pascua", "Los Andes", "Calle Larga", "Rinconada", "San Esteban", "La Ligua", "Cabildo", "Papudo", "Petorca", "Zapallar", "Quillota", "Calera", "Hijuelas", "La Cruz", "Nogales", "San Antonio", "Algarrobo", "Cartagena", "El Quisco", "El Tabo", "Santo Domingo", "San Felipe", "Catemu", "Llaillay", "Panquehue", "Putaendo", "Santa María", "Quilpué", "Limache", "Olmué", "Villa Alemana"]
			},
				{
					"NombreRegion": "Región del Libertador Gral. Bernardo O’Higgins",
					"comunas": ["Rancagua", "Codegua", "Coinco", "Coltauco", "Doñihue", "Graneros", "Las Cabras", "Machalí", "Malloa", "Mostazal", "Olivar", "Peumo", "Pichidegua", "Quinta de Tilcoco", "Rengo", "Requínoa", "San Vicente", "Pichilemu", "La Estrella", "Litueche", "Marchihue", "Navidad", "Paredones", "San Fernando", "Chépica", "Chimbarongo", "Lolol", "Nancagua", "Palmilla", "Peralillo", "Placilla", "Pumanque", "Santa Cruz"]
			},
				{
					"NombreRegion": "Región del Maule",
					"comunas": ["Talca", "ConsVtución", "Curepto", "Empedrado", "Maule", "Pelarco", "Pencahue", "Río Claro", "San Clemente", "San Rafael", "Cauquenes", "Chanco", "Pelluhue", "Curicó", "Hualañé", "Licantén", "Molina", "Rauco", "Romeral", "Sagrada Familia", "Teno", "Vichuquén", "Linares", "Colbún", "Longaví", "Parral", "ReVro", "San Javier", "Villa Alegre", "Yerbas Buenas"]
			},
				{
					"NombreRegion": "Región del Biobío",
					"comunas": ["Concepción", "Coronel", "Chiguayante", "Florida", "Hualqui", "Lota", "Penco", "San Pedro de la Paz", "Santa Juana", "Talcahuano", "Tomé", "Hualpén", "Lebu", "Arauco", "Cañete", "Contulmo", "Curanilahue", "Los Álamos", "Tirúa", "Los Ángeles", "Antuco", "Cabrero", "Laja", "Mulchén", "Nacimiento", "Negrete", "Quilaco", "Quilleco", "San Rosendo", "Santa Bárbara", "Tucapel", "Yumbel", "Alto Biobío", "Chillán", "Bulnes", "Cobquecura", "Coelemu", "Coihueco", "Chillán Viejo", "El Carmen", "Ninhue", "Ñiquén", "Pemuco", "Pinto", "Portezuelo", "Quillón", "Quirihue", "Ránquil", "San Carlos", "San Fabián", "San Ignacio", "San Nicolás", "Treguaco", "Yungay"]
			},
				{
					"NombreRegion": "Región de la Araucanía",
					"comunas": ["Temuco", "Carahue", "Cunco", "Curarrehue", "Freire", "Galvarino", "Gorbea", "Lautaro", "Loncoche", "Melipeuco", "Nueva Imperial", "Padre las Casas", "Perquenco", "Pitrufquén", "Pucón", "Saavedra", "Teodoro Schmidt", "Toltén", "Vilcún", "Villarrica", "Cholchol", "Angol", "Collipulli", "Curacautín", "Ercilla", "Lonquimay", "Los Sauces", "Lumaco", "Purén", "Renaico", "Traiguén", "Victoria", ]
			},
				{
					"NombreRegion": "Región de Los Ríos",
					"comunas": ["Valdivia", "Corral", "Lanco", "Los Lagos", "Máfil", "Mariquina", "Paillaco", "Panguipulli", "La Unión", "Futrono", "Lago Ranco", "Río Bueno"]
			},
				{
					"NombreRegion": "Región de Los Lagos",
					"comunas": ["Puerto Montt", "Calbuco", "Cochamó", "Fresia", "FruVllar", "Los Muermos", "Llanquihue", "Maullín", "Puerto Varas", "Castro", "Ancud", "Chonchi", "Curaco de Vélez", "Dalcahue", "Puqueldón", "Queilén", "Quellón", "Quemchi", "Quinchao", "Osorno", "Puerto Octay", "Purranque", "Puyehue", "Río Negro", "San Juan de la Costa", "San Pablo", "Chaitén", "Futaleufú", "Hualaihué", "Palena"]
			},
				{
					"NombreRegion": "Región Aisén del Gral. Carlos Ibáñez del Campo",
					"comunas": ["Coihaique", "Lago Verde", "Aisén", "Cisnes", "Guaitecas", "Cochrane", "O’Higgins", "Tortel", "Chile Chico", "Río Ibáñez"]
			},
				{
					"NombreRegion": "Región de Magallanes y de la Antártica Chilena",
					"comunas": ["Punta Arenas", "Laguna Blanca", "Río Verde", "San Gregorio", "Cabo de Hornos (Ex Navarino)", "AntárVca", "Porvenir", "Primavera", "Timaukel", "Natales", "Torres del Paine"]
			},
				{
					"NombreRegion": "Región Metropolitana de Santiago",
					"comunas": ["Cerrillos", "Cerro Navia", "Conchalí", "El Bosque", "Estación Central", "Huechuraba", "Independencia", "La Cisterna", "La Florida", "La Granja", "La Pintana", "La Reina", "Las Condes", "Lo Barnechea", "Lo Espejo", "Lo Prado", "Macul", "Maipú", "Ñuñoa", "Pedro Aguirre Cerda", "Peñalolén", "Providencia", "Pudahuel", "Quilicura", "Quinta Normal", "Recoleta", "Renca", "San Joaquín", "San Miguel", "San Ramón", "Vitacura", "Puente Alto", "Pirque", "San José de Maipo", "Colina", "Lampa", "TilVl", "San Bernardo", "Buin", "Calera de Tango", "Paine", "Melipilla", "Alhué", "Curacaví", "María Pinto", "San Pedro", "Talagante", "El Monte", "Isla de Maipo", "Padre Hurtado", "Peñaflor"]
			}]
		}
		
		
		jQuery(document).ready(function () {
		
			var iRegion = 0;
			var htmlRegion = '<option value="sin-region">Seleccione región</option><option value="sin-region">--</option>';
			var htmlComunas = '<option value="sin-region">Seleccione comuna</option><option value="sin-region">--</option>';
		
			jQuery.each(RegionesYcomunas.regiones, function () {
				htmlRegion = htmlRegion + '<option value="' + RegionesYcomunas.regiones[iRegion].NombreRegion + '">' + RegionesYcomunas.regiones[iRegion].NombreRegion + '</option>';
				iRegion++;
			});
		
			jQuery('#regiones').html(htmlRegion);
			jQuery('#comunas').html(htmlComunas);
		
			jQuery('#regiones').change(function () {
				var iRegiones = 0;
				var valorRegion = jQuery(this).val();
				var htmlComuna = '<option value="sin-comuna">Seleccione comuna</option><option value="sin-comuna">--</option>';
				jQuery.each(RegionesYcomunas.regiones, function () {
					if (RegionesYcomunas.regiones[iRegiones].NombreRegion == valorRegion) {
						var iComunas = 0;
						jQuery.each(RegionesYcomunas.regiones[iRegiones].comunas, function () {
							htmlComuna = htmlComuna + '<option value="' + RegionesYcomunas.regiones[iRegiones].comunas[iComunas] + '">' + RegionesYcomunas.regiones[iRegiones].comunas[iComunas] + '</option>';
							iComunas++;
						});
					}
					iRegiones++;
				});
				jQuery('#comunas').html(htmlComuna);
			});
			jQuery('#comunas').change(function () {
				if (jQuery(this).val() == 'sin-region') {
					alert('selecciones Región');
				} else if (jQuery(this).val() == 'sin-comuna') {
					alert('selecciones Comuna');
				}
			});
			jQuery('#regiones').change(function () {
				if (jQuery(this).val() == 'sin-region') {
					alert('selecciones Región');
				}
			});
		
		});
		</script>
	<!-- InstanceEndEditable -->
</body>
<!-- InstanceEnd --></html>
<?php
mysqli_free_result($datosAdmin);

mysqli_free_result($contactosPendientes);

mysqli_free_result($qtsClientesView);

mysqli_free_result($qtsContactosClientes);

mysqli_free_result($qtsContactosClientesEditar);

mysqli_free_result($qtsDireccionesClientes);

mysqli_free_result($qtsDireccionesClientesEditar);

mysqli_free_result($qtsDireccionesClientesCotizar);

mysqli_free_result($qtsCotizacionesClientes);
?>
