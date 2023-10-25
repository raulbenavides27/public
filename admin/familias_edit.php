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
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "familiasForm")) {
  $updateSQL = sprintf("UPDATE menuSubCategoriasFamilias SET subCategoriaSEO=%s, subCategoriaFamiliaSEO=%s, subCategoriaFamilia=%s, estado=%s WHERE id=%s",
                       GetSQLValueString($_POST['subCategoriaSEO'], "text"),
                       GetSQLValueString($_POST['subCategoriaFamiliaSEO'], "text"),
                       GetSQLValueString($_POST['subCategoriaFamilia'], "text"),
                       GetSQLValueString(isset($_POST['estado']) ? "true" : "", "defined","1","0"));
  $Result1 = mysqli_query($DKKadmin, $updateSQL) or die(mysqli_error($DKKadmin));
  $updateSQL = "familias_edit_categoria.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateSQL .= (strpos($updateSQL, '?')) ? "&" : "?";
    $updateSQL .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateSQL));
}

//Variables
$fecha = date('Y-m-d H:i:s');
$fechaID = strtotime($fecha);
$idFamilia = $_GET["id"];

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

$query_categoriasProductos = sprintf("SELECT * FROM menuCategorias ORDER BY menuCategorias.id ASC");
$categoriasProductos = mysqli_query($DKKadmin, $query_categoriasProductos) or die(mysqli_error($DKKadmin));
$row_categoriasProductos = mysqli_fetch_assoc($categoriasProductos);
$totalRows_categoriasProductos = mysqli_num_rows($categoriasProductos);

$query_subCategoriasProductos = sprintf("SELECT * FROM menuSubCategorias ORDER BY menuSubCategorias.id ASC");
$subCategoriasProductos = mysqli_query($DKKadmin, $query_subCategoriasProductos) or die(mysqli_error($DKKadmin));
$row_subCategoriasProductos = mysqli_fetch_assoc($subCategoriasProductos);
$totalRows_subCategoriasProductos = mysqli_num_rows($subCategoriasProductos);

$query_familiasProductos = sprintf("SELECT * FROM menuSubCategoriasFamilias ORDER BY menuSubCategoriasFamilias.id DESC");
$familiasProductos = mysqli_query($DKKadmin, $query_familiasProductos) or die(mysqli_error($DKKadmin));
$row_familiasProductos = mysqli_fetch_assoc($familiasProductos);
$totalRows_familiasProductos = mysqli_num_rows($familiasProductos);

$query_familiasProductosEdit = sprintf("SELECT * FROM menuSubCategoriasFamilias WHERE menuSubCategoriasFamilias.id = '$idFamilia'");
$familiasProductosEdit = mysqli_query($DKKadmin, $query_familiasProductosEdit) or die(mysqli_error($DKKadmin));
$row_familiasProductosEdit = mysqli_fetch_assoc($familiasProductosEdit);
$totalRows_familiasProductosEdit = mysqli_num_rows($familiasProductosEdit);
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
                function upload()
                {
                    self.name = 'opener';
                    remote = open('up/subcategorias.php', 'remote', 'width=410,height=200,location=no,scrollbar=no,menubars=no,toolbars=no,resizable=no,fullscreen=no, status=yes');
                    remote.focus();
                    }	
                </script>
                <!-- fin script -->
                <!-- cabecera -->
                <div class="content bg-gray-lighter">
                    <div class="row items-push">
                        <div class="col-sm-7">
                            <h1 class="page-heading">
                                Familias <small>Estas son las familias presentes en al cat&aacute;logo</small>
                            </h1>
                        </div>
                        <div class="col-sm-5 text-right hidden-xs">
                            <ol class="breadcrumb push-10-t">
                                <li>Dashboard</li>
                                <li><a class="link-effect" href="">Famiilas</a></li>
                            </ol>
                        </div>
                    </div>
                </div>
                <!-- END cabecera -->
                <!-- contenido -->
                <div class="content">
                    <div class="row">
                        <div class="col-lg-8">
                            <!-- tabla -->
                            <div class="block">
                                <div class="block-header">
                                    <h3 class="block-title">Familias</h3>
                                </div>
                                <div class="block-content">
                                    <table class="table table-bordered table-striped js-dataTable-full">
                                        <thead>
                                            <tr>
                                                <th class="text-center"></th>
                                                <th>Familia</th>
                                                <th>Categoría</th>
                                                <th>SubCategoría</th>
                                                <th class="hidden-xs">Visitas</th>
                                                <th class="hidden-xs" style="width: 15%;">Estado</th>
                                                <th class="text-center" style="width: 10%;">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php do { ?>
                                            <tr>
                                                <td class="text-center">#FSC0<?php echo $row_familiasProductos["id"]; ?></td>
                                                <td class="font-w600"><?php echo $row_familiasProductos["subCategoriaFamilia"]; ?></td>
                                                <td><?php 
												$categoriaSEO = $row_familiasProductos["categoriaSEO"];
												$categoriaMadre = mysqli_query($DKKadmin,"SELECT * FROM menuCategorias WHERE menuCategorias.categoriaSEO = '$categoriaSEO' AND menuCategorias.estado = '1' ORDER BY menuCategorias.id ASC"); if(mysqli_num_rows($categoriaMadre) == 0) { echo ""; } else { ?>
                                                <?php $counter = 1; while($cm = mysqli_fetch_array($categoriaMadre)) { ?>
                                                <?php echo $cm["categoria"]; ?>
                                                <?php } ?>
                                                <?php } ?></td>
                                                <td><?php 
												$subCategoriaSEO = $row_familiasProductos["subCategoriaSEO"];
												$subCategoriaMadre = mysqli_query($DKKadmin,"SELECT * FROM menuSubCategorias WHERE menuSubCategorias.subCategoriaSEO = '$subCategoriaSEO' AND menuSubCategorias.estado = '1' ORDER BY menuSubCategorias.id ASC"); if(mysqli_num_rows($subCategoriaMadre) == 0) { echo ""; } else { ?>
                                                <?php $counter = 1; while($scm = mysqli_fetch_array($subCategoriaMadre)) { ?>
                                                <?php echo $scm["subCategoria"]; ?>
                                                <?php } ?>
                                                <?php } ?></td>
                                                <td class="hidden-xs"><?php echo $row_familiasProductos["visitas"]; ?></td>
                                                <td class="hidden-xs">
                                                  <span class="label label-<?php if ($row_familiasProductos["estado"] == '1') { echo "success";} if ($row_familiasProductos["estado"] == '2') { echo "warning";} if ($row_familiasProductos["estado"] == '0') { echo "default";} ?>"><?php if ($row_familiasProductos["estado"] == '1') { echo "ACTIVA";} if ($row_familiasProductos["estado"] == '2') { echo "INACTIVA";} if ($row_familiasProductos["estado"] == '0') { echo "ELIMINADA";} ?></span>
                                                </td>
                                                <td class="text-center">
                                                  <div class="btn-group">
                                                    <button class="btn btn-xs btn-default" type="button" data-toggle="tooltip" title="Editar Familia" onClick="location.href='familias_edit.php?id=<?php echo $row_familiasProductos["id"]; ?>'"><i class="fa fa-pencil"></i></button>
                                                    <button class="btn btn-xs btn-default" type="button" data-toggle="tooltip" title="Eliminar Familia" onClick="location.href='familias_remove.php?id=<?php echo $row_familiasProductos["id"]; ?>'"><i class="fa fa-times"></i></button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php } while ($row_familiasProductos = mysqli_fetch_assoc($familiasProductos)); ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- END tabla -->
                        </div>
                        <div class="col-lg-4">
                            <!-- formulario -->
                            <div class="block">
                                <div class="block-header">
                                    <h3 class="block-title">Nueva Familia</h3>
                                </div>
                                <div class="block-content">
                                  <form action="<?php echo $editFormAction; ?>" class="form-horizontal push-10-t push-10" method="POST" name="familiasForm">
                                        <div class="form-group">
                                            <label class="col-xs-12">ID</label>
                                            <div class="col-xs-12">
                                                <div class="form-control-static">#FSC0<?php echo $row_familiasProductosEdit["id"]; ?></div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-xs-12">
                                                <div class="form-material">
                                                  <select class="js-select2 form-control" id="subCategoriaSEO" name="subCategoriaSEO" style="width: 100%;" data-placeholder="Selecciónala..">
                                                    <option></option>
													<?php $seleccionCategorias = mysqli_query($DKKadmin,"SELECT * FROM menuCategorias WHERE menuCategorias.estado = '1' ORDER BY menuCategorias.id ASC"); while($ln = mysqli_fetch_array($seleccionCategorias)){ $idCategoria = $ln['id']; ?>
                                                      <optgroup label="<?php echo $ln['categoria'];?>">
                                                          <?php $seleccionaSubCategorias = mysqli_query($DKKadmin,"SELECT * FROM menuSubCategorias WHERE menuSubCategorias.estado = '1' AND menuSubCategorias.idCategoria = '$idCategoria'  ORDER BY menuSubCategorias.idCategoria ASC"); if(mysqli_num_rows($seleccionaSubCategorias) == 0) { echo "</optgroup>"; } else { ?>
                                                       	  	<?php $counter = 1; while($lSub = mysqli_fetch_array($seleccionaSubCategorias)) { ?>
                                                              <option value="<?php echo $lSub['subCategoriaSEO'] ?>" <?php if ($lSub['subCategoriaSEO'] == $row_familiasProductosEdit["subCategoriaSEO"]) {echo "selected";} ?>><?php echo $lSub['subCategoria'] ?></option>
                                                            <?php } ?>
                                                        <?php } ?>
                                                      </optgroup>
                                                    <?php } ?>
                                                  </select>
                                                  <label for="subCategoriaSEO">Sub Categoría</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-xs-12">
                                                <div class="form-material">
                                                    <input class="form-control" type="text" id="subCategoriaFamilia" name="subCategoriaFamilia" placeholder="Ingresa el Nombre de la Familia" value="<?php echo $row_familiasProductosEdit["subCategoriaFamilia"]; ?>">
                                                    <label for="subCategoriaFamilia">Familia</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-xs-12">
                                                <div class="form-material">
                                                    <input class="form-control" type="text" id="subCategoriaFamiliaSEO" name="subCategoriaFamiliaSEO" placeholder="Ingresa el SEO de la Familia" value="<?php echo $row_familiasProductosEdit["subCategoriaFamiliaSEO"]; ?>">
                                                    <label for="subCategoriaFamiliaSEO">SEO de la Familia</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-xs-12">
                                                <label class="css-input switch switch-sm switch-success">
                                                    <input type="checkbox" id="estado" name="estado" <?php if ($row_familiasProductosEdit["estado"] == '1') {echo"checked";} ?>><span></span> Estado
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-xs-12">
                                                <button class="btn btn-sm btn-success" type="submit"><i class="fa fa-save push-5-r"></i> Guardar</button>
                                                <input type="hidden" name="id" value="<?php echo $row_familiasProductosEdit["id"]; ?>">
                                            </div>
                                        </div>
                                        <input type="hidden" name="MM_update" value="familiasForm">
                                    </form>
                                </div>
                            </div>
                            <!-- END formulario -->

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
        <!-- Page JS Plugins -->
        <script src="js/plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="js/pages/base_tables_datatables.js"></script>
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
		<!-- InstanceEndEditable -->
</body>
<!-- InstanceEnd --></html>
<?php
mysqli_free_result($datosAdmin);

mysqli_free_result($contactosPendientes);

mysqli_free_result($categoriasProductos);

mysqli_free_result($subCategoriasProductos);

mysqli_free_result($familiasProductos);

mysqli_free_result($familiasProductosEdit);
?>
