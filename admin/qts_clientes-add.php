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

$query_qtsClientesTotal = "SELECT * FROM qts_clientes  WHERE qts_clientes.estado = '1' ORDER BY qts_clientes.id DESC";
$qtsClientesTotal = mysqli_query($DKKadmin, $query_qtsClientesTotal);
$row_qtsClientesTotal = mysqli_fetch_assoc($qtsClientesTotal);
$totalRows_qtsClientesTotal = mysqli_num_rows($qtsClientesTotal);

$query_qtsClientesUsuario = "SELECT * FROM qts_clientes WHERE qts_clientes.estado = '1' AND qts_clientes.creadorID = '$idAdmin' ORDER BY qts_clientes.id DESC";
$qtsClientesUsuario = mysqli_query($DKKadmin, $query_qtsClientesUsuario);
$row_qtsClientesUsuario = mysqli_fetch_assoc($qtsClientesUsuario);
$totalRows_qtsClientesUsuario = mysqli_num_rows($qtsClientesUsuario);

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "blogForm")) {
  $insertSQL = sprintf("INSERT INTO blog (titulo, tituloSEO, categoriaSEO, imagen, bajada, contenido, autor, dia, mes, ano, visitas, fecha, fechaID, ip, keywords, estado) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s %s, %s)",
                       GetSQLValueString($_POST['titulo'], "text"),
                       GetSQLValueString($_POST['tituloSEO'], "text"),
                       GetSQLValueString($_POST['categoriaSEO'], "text"),
                       GetSQLValueString($_POST['imagen'], "text"),
                       GetSQLValueString($_POST['bajada'], "text"),
                       GetSQLValueString($_POST['contenido'], "text"),
                       GetSQLValueString($_POST['autor'], "text"),
                       GetSQLValueString($_POST['dia'], "text"),
                       GetSQLValueString($_POST['mes'], "text"),
                       GetSQLValueString($_POST['ano'], "text"),
                       GetSQLValueString($_POST['fecha'], "text"),
                       GetSQLValueString($_POST['fechaID'], "text"),
                       GetSQLValueString($_POST['ip'], "text"),
                       GetSQLValueString($_POST['keywords'], "text"),
                       GetSQLValueString($_POST['visitas'], "text"),
                       GetSQLValueString(isset($_POST['estado']) ? "true" : "", "defined","1","0"));
  $Result1 = mysqli_query($DKKadmin, $insertSQL) or die(mysqli_error($DKKadmin));
  $insertGoTo = "blog.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "clientesForm")) {
  $insertSQL = sprintf("INSERT INTO qts_clientes (rut, nombre, razonSocial, sitioWeb, correo, telefono, region, comuna, ip, fecha, fechaID, creadorID, estado) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['rut'], "text"),
                       GetSQLValueString($_POST['nombre'], "text"),
                       GetSQLValueString($_POST['razonSocial'], "text"),
                       GetSQLValueString($_POST['sitioWeb'], "text"),
                       GetSQLValueString($_POST['correo'], "text"),
                       GetSQLValueString($_POST['telefono'], "text"),
                       GetSQLValueString($_POST['region'], "text"),
                       GetSQLValueString($_POST['comuna'], "text"),
                       GetSQLValueString($_POST['ip'], "text"),
                       GetSQLValueString($_POST['fecha'], "text"),
                       GetSQLValueString($_POST['fechaID'], "text"),
                       GetSQLValueString($_POST['creadorID'], "text"),
                       GetSQLValueString(isset($_POST['estado']) ? "true" : "", "defined","1","2"));
  $Result1 = mysqli_query($DKKadmin, $insertSQL) or die(mysqli_error($DKKadmin));
  $insertGoTo = "qts_clientes-view.php?id=".($row_qtsClientesTotal["id"]+'1');
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
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
                <!-- contenido -->
                <div class="content content-boxed">
                    <!-- header -->
                    <div class="row">
                        <div class="col-xs-6 col-sm-6">
                            <a class="block block-link-hover3 text-center" href="javascript:void(0)">
                                <div class="block-content block-content-full">
                                    <div class="h1 font-w700" data-toggle="countTo" data-to="<?php echo $totalRows_qtsClientesTotal; ?>"></div>
                                </div>
                                <div class="block-content block-content-full block-content-mini bg-gray-lighter text-muted font-w600">Total Clientes</div>
                            </a>
                        </div>
                        <div class="col-xs-6 col-sm-6">
                            <a class="block block-link-hover3 text-center" href="javascript:void(0)">
                                <div class="block-content block-content-full">
                                    <div class="h1 font-w700" data-toggle="countTo" data-to="<?php echo $totalRows_qtsClientesUsuario; ?>"></div>
                                </div>
                                <div class="block-content block-content-full block-content-mini bg-gray-lighter text-muted font-w600">Creados por ti</div>
                            </a>
                        </div>
                    </div>
                    <!-- END header -->

                    <!-- Info -->
                    <div class="block">
                        <div class="block-header bg-gray-lighter">
                            <h3 class="block-title">Info</h3>
                        </div>
                        <div class="block-content block-content-full">
                            <div class="row">
                                <div class="col-sm-8 col-sm-offset-2 col-lg-6 col-lg-offset-3">
                                    <form method="POST" action="<?php echo $editFormAction; ?>" class="form-horizontal push-30-t push-30" name="clientesForm">
                                        <div class="form-group">
                                            <div class="col-xs-12"><div id="no-valido"></div></div>
                                            <div class="col-xs-12">
                                                <div class="form-material form-material-primary">
                                                    <p>CID.<?php if ($row_qtsClientesTotal["id"] < 10) {echo "0000";} if ($row_qtsClientesTotal["id"] < 100 && $row_qtsClientesTotal["id"] > 10) {echo "000";} if ($row_qtsClientesTotal["id"] < 1000 && $row_qtsClientesTotal["id"] > 100) {echo "00";} if ($row_qtsClientesTotal["id"] < 10000 && $row_qtsClientesTotal["id"] > 1000) {echo "0";} if ($row_qtsClientesTotal["id"] < 100000 && $row_qtsClientesTotal["id"] > 10000) {echo "";} echo ($row_qtsClientesTotal["id"] + '1'); ?></p>
                                                    <label for="id">CID</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-xs-12">
                                                <div class="form-material form-material-primary">
                                                    <input class="form-control" type="text" id="razonSocial" name="razonSocial">
                                                    <label for="razonSocial">Razón Social</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-xs-12">
                                                <div class="form-material form-material-primary">
                                                    <input class="form-control" type="text" placeholder="Ej.: 123456789-0" id="rut" name="rut" onBlur="onRutBlur(this);" required>
                                                    <label for="rut">RUT de la Empresa</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-xs-12">
                                                <div class="form-material form-material-primary">
                                                    <input class="form-control" type="text" id="nombre" name="nombre" required>
                                                    <label for="nombre">Nombre de Contacto (*)</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-xs-12">
                                                <div class="form-material form-material-primary">
                                                    <input class="form-control" type="url" id="sitioWeb" name="sitioWeb">
                                                    <label for="sitioWeb">Sitio Web</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-xs-6">
                                                <div class="form-material form-material-primary">
                                                    <input class="form-control" type="email" id="correo" name="correo" required>
                                                    <label for="correo">Correo Electrónico (*)</label>
                                                </div>
                                            </div>
                                            <div class="col-xs-6">
                                                <div class="form-material form-material-primary">
                                                    <input class="form-control" type="text" id="telefono" name="telefono" required>
                                                    <label for="telefono">Teléfono Principal (*)</label>
                                                </div>
                                            </div>
                                        </div>
										<div class="form-group">
                                            <div class="col-xs-6">
                                                <div class="form-material">
                                                    <select class="js-select2 form-control" id="regiones" name="region" style="width: 100%;" data-placeholder="Selecciona una Región.." required>
                                                        <option></option>
                                                    </select>
                                                    <label for="regiones">Región (*)</label>
                                                </div>
                                            </div>
                                            <div class="col-xs-6">
                                                <div class="form-material">
                                                    <select class="js-select2 form-control" id="comunas" name="comuna" style="width: 100%;" data-placeholder="Selecciona una Comuna.." required>
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
                                                <div id="validado" class="center">
                                                  <button class='btn btn-sm btn-primary' name='send' id='send' type='submit' disabled='disabled'>Guardar Cliente</button>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" name="MM_insert" value="clientesForm">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END Info -->

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
                App.initHelpers(['datepicker', 'datetimepicker', 'colorpicker', 'maxlength', 'select2', 'masked-inputs', 'rangeslider', 'tags-inputs', 'appear-countTo']);

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

mysqli_free_result($qtsClientesTotal);

mysqli_free_result($qtsClientesUsuario);
?>
