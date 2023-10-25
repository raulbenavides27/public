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
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "productosForm")) {
  $insertSQL = sprintf("INSERT INTO productos (codInterno, categoriaSEO, subCategoriaSEO, subCategoriaFamiliaSEO, nombre, nombreSEO, descripcionCorta, descripcion, etiqueta, uso, capMax, precio, precioDistribuidor, precioOferta, stock, keywords, imagen1, imagen2, imagen3, novedad, recomendado, estado) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['codInterno'], "text"),
                       GetSQLValueString($_POST['categoriaSEO'], "text"),
                       GetSQLValueString($_POST['subCategoriaSEO'], "text"),
                       GetSQLValueString($_POST['subCategoriaFamiliaSEO'], "text"),
                       GetSQLValueString($_POST['nombre'], "text"),
                       GetSQLValueString($_POST['nombreSEO'], "text"),
                       GetSQLValueString($_POST['descripcionCorta'], "text"),
                       GetSQLValueString($_POST['descripcion'], "text"),
                       GetSQLValueString($_POST['etiqueta'], "text"),
                       GetSQLValueString($_POST['uso'], "text"),
                       GetSQLValueString($_POST['capMax'], "text"),
                       GetSQLValueString($_POST['precio'], "text"),
                       GetSQLValueString($_POST['precioOferta'], "text"),
                       GetSQLValueString($_POST['stock'], "text"),
                       GetSQLValueString($_POST['keywords'], "text"),
                       GetSQLValueString($_POST['imagen1'], "text"),
                       GetSQLValueString($_POST['imagen2'], "text"),
                       GetSQLValueString($_POST['imagen3'], "text"),
                       GetSQLValueString(isset($_POST['novedad']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['recomendado']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['estado']) ? "true" : "", "defined","1","0"));
  $Result1 = mysqli_query($DKKadmin, $insertSQL) or die(mysqli_error($DKKadmin));
  $insertGoTo = "productos.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

//Variables
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

$varIDproducto_productoEdit = "0";
if (isset($GET["id"])) {
  $varIDproducto_productoEdit = $GET["id"];
}
$query_productoEdit = sprintf("SELECT * FROM productos WHERE productos.id = %s", GetSQLValueString($varIDproducto_productoEdit, "int"));
$productoEdit = mysqli_query($DKKadmin, $query_productoEdit) or die(mysqli_error($DKKadmin));
$row_productoEdit = mysqli_fetch_assoc($productoEdit);
$totalRows_productoEdit = mysqli_num_rows($productoEdit);

$query_categoriasProductos = sprintf("SELECT * FROM menuCategorias ORDER BY menuCategorias.id ASC");
$categoriasProductos = mysqli_query($DKKadmin, $query_categoriasProductos) or die(mysqli_error($DKKadmin));
$row_categoriasProductos = mysqli_fetch_assoc($categoriasProductos);
$totalRows_categoriasProductos = mysqli_num_rows($categoriasProductos);

$query_subCategoriasProductos = sprintf("SELECT * FROM menuSubCategorias ORDER BY menuSubCategorias.id ASC");
$subCategoriasProductos = mysqli_query($DKKadmin, $query_subCategoriasProductos) or die(mysqli_error($DKKadmin));
$row_subCategoriasProductos = mysqli_fetch_assoc($subCategoriasProductos);
$totalRows_subCategoriasProductos = mysqli_num_rows($subCategoriasProductos);

$query_familiasProductos = sprintf("SELECT * FROM menuSubCategoriasFamilias ORDER BY menuSubCategoriasFamilias.id ASC");
$familiasProductos = mysqli_query($DKKadmin, $query_familiasProductos) or die(mysqli_error($DKKadmin));
$row_familiasProductos = mysqli_fetch_assoc($familiasProductos);
$totalRows_familiasProductos = mysqli_num_rows($familiasProductos);

$query_etiquetas = sprintf("SELECT * FROM escalasEtiquetas ORDER BY escalasEtiquetas.id ASC");
$etiquetas = mysqli_query($DKKadmin, $query_etiquetas) or die(mysqli_error($DKKadmin));
$row_etiquetas = mysqli_fetch_assoc($etiquetas);
$totalRows_etiquetas = mysqli_num_rows($etiquetas);

$query_usos = sprintf("SELECT * FROM escalasUsos ORDER BY escalasUsos.id ASC");
$usos = mysqli_query($DKKadmin, $query_usos) or die(mysqli_error($DKKadmin));
$row_usos = mysqli_fetch_assoc($usos);
$totalRows_usos = mysqli_num_rows($usos);

$query_capacidades = sprintf("SELECT * FROM escalasCapMax ORDER BY escalasCapMax.id ASC");
$capacidades = mysqli_query($DKKadmin, $query_capacidades) or die(mysqli_error($DKKadmin));
$row_capacidades = mysqli_fetch_assoc($capacidades);
$totalRows_capacidades = mysqli_num_rows($capacidades);

$query_ultimoProducto = sprintf("SELECT * FROM productos ORDER BY productos.id DESC LIMIT 1");
$ultimoProducto = mysqli_query($DKKadmin, $query_ultimoProducto) or die(mysqli_error($DKKadmin));
$row_ultimoProducto = mysqli_fetch_assoc($ultimoProducto);
$totalRows_ultimoProducto = mysqli_num_rows($ultimoProducto);
?>
<!--[if IE 9]>         <html class="ie9 no-focus" lang="es"> <![endif]-->
<!--[if gt IE 9]><!--> <!DOCTYPE html><html class="no-focus" lang="es"><!-- InstanceBegin template="/Templates/admin.dwt.php" codeOutsideHTMLIsLocked="false" --> <!--<![endif]-->
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
        <link rel="stylesheet" href="js/plugins/select2/select2.min.css">
        <link rel="stylesheet" href="js/plugins/select2/select2-bootstrap.min.css">
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
                <!-- script subida de imagenes -->
                <script>
                function upload1()
                {
                    self.name = 'opener';
                    remote = open('up/productos1.php', 'remote', 'width=410,height=200,location=no,scrollbar=no,menubars=no,toolbars=no,resizable=no,fullscreen=no, status=yes');
                    remote.focus();
                    }	
                function upload2()
                {
                    self.name = 'opener';
                    remote = open('up/productos2.php', 'remote', 'width=410,height=200,location=no,scrollbar=no,menubars=no,toolbars=no,resizable=no,fullscreen=no, status=yes');
                    remote.focus();
                    }	
                function upload3()
                {
                    self.name = 'opener';
                    remote = open('up/productos3.php', 'remote', 'width=410,height=200,location=no,scrollbar=no,menubars=no,toolbars=no,resizable=no,fullscreen=no, status=yes');
                    remote.focus();
                    }	
                </script>
                <!-- fin script -->
                <!-- contenido -->
                <div class="content content-boxed">
                    <!-- info -->
                    <div class="block">
                        <div class="block-header bg-gray-lighter">
                            <h3 class="block-title">Nuevo Producto</h3>
                        </div>
                        <div class="block-content block-content-full">
                            <div class="row">
                                <div class="col-sm-8 col-sm-offset-2 col-lg-6 col-lg-offset-3">
                                    <form class="form-horizontal push-30-t push-30" name="productosForm" action="<?php echo $editFormAction; ?>" method="post">
                                        <div class="form-group">
                                            <div class="col-xs-12">
                                                <div class="form-material form-material-primary">
                                                    <input class="form-control" type="text" id="id" name="id" value="<?php echo $row_ultimoProducto["id"] + 1; ?>" readonly >
                                                    <label for="id">ID</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-xs-12">
                                                <div class="form-material">
                                                    <select class="js-select2 form-control" id="categoriaSEO" name="categoriaSEO" style="width: 100%;" data-placeholder="Selecciona su categor&iacute;a..">
                                                        <option></option>
                                                        <?php do { ?>
                                                        <option value="<?php echo $row_categoriasProductos["categoriaSEO"]; ?>"><?php echo $row_categoriasProductos["categoria"]; ?></option>
                                                        <?php } while ($row_categoriasProductos = mysqli_fetch_assoc($categoriasProductos)); ?>
                                                    </select>
                                                    <label for="categoriaSEO">Categor&iacute;a</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div  class="escalasCategoria" id="escalas" style="display:none;">
                                            <div class="form-group">
                                                <div class="col-xs-12">
                                                    <div class="form-material">
                                                        <select class="js-select2 form-control" id="subCategoriaSEO" name="subCategoriaSEO" style="width: 100%;" data-placeholder="Selecciona su subcategor&iacute;a..">
                                                            <option></option>
                                                            <?php do { ?>
                                                            <option value="<?php echo $row_subCategoriasProductos["subCategoriaSEO"]; ?>"><?php echo $row_subCategoriasProductos["subCategoria"]; ?></option>
                                                            <?php } while ($row_subCategoriasProductos = mysqli_fetch_assoc($subCategoriasProductos)); ?>
                                                        </select>
                                                        <label for="subCategoriaSEO">SubCategor&iacute;a</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-xs-12">
                                                    <div class="form-material">
                                                      <select class="js-select2 form-control" id="subCategoriaFamiliaSEO" name="subCategoriaFamiliaSEO" style="width: 100%;" data-placeholder="Selecciónala..">
                                                        <option></option>
                                                        <?php $seleccionSubCategorias = mysqli_query($DKKadmin,"SELECT * FROM menuSubCategorias WHERE menuSubCategorias.estado = '1' ORDER BY menuSubCategorias.id ASC"); while($ln = mysqli_fetch_array($seleccionSubCategorias)){ $subCategoriaSEO = $ln['subCategoriaSEO']; ?>
                                                          <optgroup label="<?php echo $ln['subCategoria'];?>">
                                                              <?php $seleccionaFamilias = mysqli_query($DKKadmin,"SELECT * FROM menuSubCategoriasFamilias WHERE menuSubCategoriasFamilias.estado = '1' AND menuSubCategoriasFamilias.subCategoriaSEO = '$subCategoriaSEO'  ORDER BY menuSubCategoriasFamilias.id ASC"); if(mysqli_num_rows($seleccionaFamilias) == 0) { echo "</optgroup>"; } else { ?>
                                                                <?php $counter = 1; while($lSub = mysqli_fetch_array($seleccionaFamilias)) { ?>
                                                                  <option value="<?php echo $lSub['subCategoriaFamiliaSEO'] ?>"><?php echo $lSub['subCategoriaFamilia'] ?></option>
                                                                <?php } ?>
                                                            <?php } ?>
                                                          </optgroup>
                                                        <?php } ?>
                                                      </select>
                                                      <label for="subCategoriaFamiliaSEO">Familia Escala</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-xs-4">
                                                    <div class="form-material">
                                                        <select class="js-select2 form-control" id="etiqueta" name="etiqueta" style="width: 100%;" data-placeholder="Selecciona su etiqueta..">
                                                            <option></option>
                                                            <?php do { ?>
                                                            <option value="<?php echo $row_etiquetas["etiquetaSEO"]; ?>"><?php echo $row_etiquetas["etiqueta"]; ?></option>
                                                            <?php } while ($row_etiquetas = mysqli_fetch_assoc($etiquetas)); ?>
                                                        </select>
                                                        <label for="etiqueta">Etiqueta</label>
                                                    </div>
                                                </div>
                                                <div class="col-xs-4">
                                                    <div class="form-material">
                                                        <select class="js-select2 form-control" id="uso" name="uso" style="width: 100%;" data-placeholder="Selecciona su uso..">
                                                            <option></option>
                                                            <?php do { ?>
                                                            <option value="<?php echo $row_usos["usoSEO"]; ?>"><?php echo $row_usos["uso"]; ?></option>
                                                            <?php } while ($row_usos = mysqli_fetch_assoc($usos)); ?>
                                                        </select>
                                                        <label for="etiqueta">Uso</label>
                                                    </div>
                                                </div>
                                                <div class="col-xs-4">
                                                    <div class="form-material">
                                                        <select class="js-select2 form-control" id="capMax" name="capMax" style="width: 100%;" data-placeholder="Selecciona su capacidad..">
                                                            <option></option>
                                                            <?php do { ?>
                                                            <option value="<?php echo $row_capacidades["capMaxSEO"]; ?>"><?php echo $row_capacidades["capMax"]; ?></option>
                                                            <?php } while ($row_capacidades = mysqli_fetch_assoc($capacidades)); ?>
                                                        </select>
                                                        <label for="etiqueta">Cap. Máx.</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-xs-12">
                                                <div class="form-material form-material-primary">
                                                    <input class="form-control" type="text" id="nombre" name="nombre">
                                                    <label for="nombre">Nombre</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-xs-12">
                                                <div class="form-material form-material-primary">
                                                    <input class="form-control" type="text" id="nombreSEO" name="nombreSEO">
                                                    <label for="nombreSEO">Nombre SEO</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-xs-12">
                                                <div class="form-material">
                                                    <textarea class="form-control" id="descripcionCorta" name="descripcionCorta" rows="3" placeholder="Ingresa una breve descripci&oacute;n del producto"></textarea>
                                                    <label for="descripcionCorta">Descripci&oacute;n Corta</label>
                                                </div>
                                            </div>
                                        </div>
										<div class="form-group">
                                            <div class="col-xs-12 push-10">
                                                <div class="form-material form-material-primary">
                                                    <label>Descripci&oacute;n</label>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 push-10">
                                                <!-- CKEditor Container -->
                                                <textarea id="js-ckeditor" name="descripcion"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-xs-4">
                                                <div class="form-material form-material-primary">
                                                    <input class="form-control" type="number" id="precio" name="precio">
                                                    <label for="precio">Precio</label>
                                                </div>
                                            </div>
                                            <div class="col-xs-4">
                                                <div class="form-material form-material-primary">
                                                    <input class="form-control" type="number" id="precioDistribuidor" name="precioDistribuidor">
                                                    <label for="precioDistribuidor">Precio Distribuidor</label>
                                                </div>
                                            </div>
                                            <div class="col-xs-4">
                                                <div class="form-material form-material-primary">
                                                    <input class="form-control" type="number" id="precioOferta" name="precioOferta">
                                                    <label for="precioOferta">Precio Oferta</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <div class="input-group">
                                                    <label for="fotos">Fotos del Producto</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <div class="input-group">
                                                    <input class="form-control" type="text" id="imagen1" name="imagen1" placeholder="Selecciona una imagen (600x600 px)" readonly required>
                                                    <span class="input-group-btn">
                                                        <a href="javascript:upload1();"><button class="btn btn-default" type="button">Buscar</button></a>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <div class="input-group">
                                                    <input class="form-control" type="text" id="imagen2" name="imagen2" placeholder="Selecciona una imagen (600x600 px)" readonly required>
                                                    <span class="input-group-btn">
                                                        <a href="javascript:upload2();"><button class="btn btn-default" type="button">Buscar</button></a>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <div class="input-group">
                                                    <input class="form-control" type="text" id="imagen3" name="imagen3" placeholder="Selecciona una imagen (600x600 px)" readonly required>
                                                    <span class="input-group-btn">
                                                        <a href="javascript:upload3();"><button class="btn btn-default" type="button">Buscar</button></a>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-xs-12">
                                                <div class="form-material form-material-primary">
                                                    <input class="js-tags-input form-control" type="text" id="keywords" name="keywords">
                                                    <label for="keywords">Keywords</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-xs-12">Stock</label>
                                            <div class="col-xs-12">
                                                <label class="css-input css-radio css-radio-primary push-10-r">
                                                    <input type="radio" id="con-stock" name="stock" value="1" checked><span></span> Con Stock
                                                </label>
                                                <label class="css-input css-radio css-radio-primary">
                                                    <input type="radio" id="sin-stock" name="stock" value="0"><span></span> Sin Stock
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-xs-12">Novedad</label>
                                            <div class="col-xs-12">
                                                <label class="css-input switch switch-sm switch-primary">
                                                    <input type="checkbox" id="novedad" name="novedad" ><span></span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-xs-12">Recomendado</label>
                                            <div class="col-xs-12">
                                                <label class="css-input switch switch-sm switch-primary">
                                                    <input type="checkbox" id="recomendado" name="recomendado" ><span></span>
                                                </label>
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
                                                <button class="btn btn-sm btn-primary" type="submit">Guardar</button>
                                        		<input type="hidden" name="MM_insert" value="productosForm">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END imagenes -->
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
        <script src="js/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js"></script>
        <script src="js/plugins/select2/select2.full.min.js"></script>
        <script src="js/plugins/dropzonejs/dropzone.min.js"></script>
        <script src="js/plugins/jquery-tags-input/jquery.tagsinput.min.js"></script>
        <script src="js/plugins/ckeditor/ckeditor.js"></script>
        <script>
            jQuery(function ($DKKadmin) {
                App.initHelpers(['maxlength', 'select2', 'tags-inputs', 'ckeditor', 'appear', 'appear-countTo']);
            });
        </script>
        <script type="text/javascript">
			$(function() {
				$('#categoriaSEO').change(function(){
					$('.escalasCategoria').hide();
					$('#' + $(this).val()).show();
				});
			});       
		</script>
		<!-- InstanceEndEditable -->
</body>
<!-- InstanceEnd --></html>
<?php
mysqli_free_result($datosAdmin);

mysqli_free_result($contactosPendientes);

mysqli_free_result($productoEdit);

mysqli_free_result($categoriasProductos);

mysqli_free_result($subCategoriasProductos);

mysqli_free_result($familiasProductos);

mysqli_free_result($etiquetas);

mysqli_free_result($usos);

mysqli_free_result($capacidades);

mysqli_free_result($ultimoProducto);
?>
