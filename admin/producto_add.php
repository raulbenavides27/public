<?php require_once('../Connections/DKKadmin.php'); 

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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "productoForm")) {
  $insertSQL = sprintf($DKKadmin, "INSERT INTO productos (id, subCategoriaSEO, nombre, nombreSEO, descripcionCorta, descripcion, precio, precioOferta, stock, keywords, imagen1, imagen2, imagen3, novedad, estado) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id'], "int"),
                       GetSQLValueString($_POST['subCategoriaSEO'], "text"),
                       GetSQLValueString($_POST['nombre'], "text"),
                       GetSQLValueString($_POST['nombreSEO'], "text"),
                       GetSQLValueString($_POST['descripcionCorta'], "text"),
                       GetSQLValueString($_POST['descripcion'], "text"),
                       GetSQLValueString($_POST['precio'], "text"),
                       GetSQLValueString($_POST['precioOferta'], "text"),
                       GetSQLValueString($_POST['stock'], "text"),
                       GetSQLValueString($_POST['keywords'], "text"),
                       GetSQLValueString($_POST['imagen1'], "text"),
                       GetSQLValueString($_POST['imagen2'], "text"),
                       GetSQLValueString($_POST['imagen3'], "text"),
                       GetSQLValueString(isset($_POST['novedad']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString($_POST['estado'], "text"));

  mysqli_select_db($database_DKKadmin);
  $Result1 = mysqli_query($DKKadmin, $insertSQL);

  $insertGoTo = "productos_add_categoria.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
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

$varIDadmin_datosAdmin = "0";
if (isset($_SESSION["MM_idAdmin"])) {
  $varIDadmin_datosAdmin = $_SESSION["MM_idAdmin"];
}
$query_datosAdmin = sprintf("SELECT * FROM admin WHERE admin.id = %s", GetSQLValueString($varIDadmin_datosAdmin, "int"));
$datosAdmin = mysqli_query($DKKadmin, $query_datosAdmin);
$row_datosAdmin = mysqli_fetch_assoc($datosAdmin);
$totalRows_datosAdmin = mysqli_num_rows($datosAdmin);

$query_mailBox = sprintf("SELECT * FROM contacto WHERE contacto.estado = '1'");
$mailBox = mysqli_query($DKKadmin, $query_mailBox);
$row_mailBox = mysqli_fetch_assoc($mailBox);
$totalRows_mailBox = mysqli_num_rows($mailBox);

$query_ultimoProductoID = sprintf("SELECT * FROM productos ORDER BY productos.id DESC");
$ultimoProductoID = mysqli_query($DKKadmin, $query_ultimoProductoID);
$row_ultimoProductoID = mysqli_fetch_assoc($ultimoProductoID);
$totalRows_ultimoProductoID = mysqli_num_rows($ultimoProductoID);
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
                                    <a href="maibox.php"><i class="si si-envelope-open"></i><span class="sidebar-mini-hide">Mailbox</span></a>
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
                                            <a href="nosotros_historia.php">Historia</a>
                                        </li>
                                        <li>
                                            <a href="nosotros_historia.php">Misi&oacute;n</a>
                                        </li>
                                        <li>
                                          <a href="nosotros_postventa.php">Post-Venta</a>
                                        </li>
                                        <li>
                                            <a href="nosotros_representantes.php">Representantes</a>
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

                              <li class="nav-main-heading"><span class="sidebar-mini-hide">Cat&aacute;logo de Productos</span></li>
                                
                                <li>
                                    <a class="nav-submenu" data-toggle="nav-submenu" href="#"><i class="si si-list"></i><span class="sidebar-mini-hide">Categor&iacute;as</span></a>
                                    <ul>
                                        <li>
                                            <a href="productos_categorias.php">Categor&iacute;as</a>
                                        </li>
                                        <li>
                                            <a href="productos_subcategorias.php">SubCategor&iacute;as</a>
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
                    <!-- 
                    <div class="row">
                        <div class="col-xs-6 col-sm-4">
                            <a class="block block-link-hover3 text-center" href="javascript:void(0)">
                                <div class="block-content block-content-full">
                                    <div class="h1 font-w700" data-toggle="countTo" data-to="250"></div>
                                </div>
                                <div class="block-content block-content-full block-content-mini bg-gray-lighter text-muted font-w600">Visitas</div>
                            </a>
                        </div>
                        <div class="col-xs-6 col-sm-4">
                            <a class="block block-link-hover3 text-center" href="javascript:void(0)">
                                <div class="block-content block-content-full">
                                    <div class="h1 font-w700" data-toggle="countTo" data-to="29"></div>
                                </div>
                                <div class="block-content block-content-full block-content-mini bg-gray-lighter text-muted font-w600">Fotograf&iacute;as</div>
                            </a>
                        </div>
                        <div class="col-xs-12 col-sm-4">
                            <a class="block block-link-hover3 text-center" href="proyectos-remove.php?id=">
                                <div class="block-content block-content-full">
                                    <div class="h1 font-w700 text-danger"><i class="fa fa-times"></i></div>
                                </div>
                                <div class="block-content block-content-full block-content-mini bg-gray-lighter text-danger font-w600">Eliminar Proyecto</div>
                            </a>
                        </div>
                    </div>
                    END header -->

                    <!-- info -->
                    <div class="block">
                        <div class="block-header bg-gray-lighter">
                            <h3 class="block-title">Informaci&oacute;n</h3>
                        </div>
                        <div class="block-content block-content-full">
                            <div class="row">
                                <div class="col-sm-8 col-sm-offset-2 col-lg-6 col-lg-offset-3">
                                    <form action="<?php echo $editFormAction; ?>" method="POST" class="form-horizontal push-30-t push-30" name="productoForm">
                                        <div class="form-group">
                                            <div class="col-xs-12">
                                                <div class="form-material form-material-primary">
                                                    <input class="form-control" type="text" id="id" name="id" value="<?php echo ($row_ultimoProductoID["id"] + 1); ?>" readonly>
                                                    <label for="id">ID</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-xs-12">
                                                <div class="form-material">
                                                  <select class="js-select2 form-control" id="subCategoriaSEO" name="subCategoriaSEO" style="width: 100%;">
													<option disabled selected>Selecciona la Categor&iacute;a</option>
													<?php $seleccionCategorias = mysqli_query($DKKadmin, "SELECT * FROM menuCategorias WHERE menuCategorias.estado = '1' ORDER BY menuCategorias.id ASC"); while($ln = mysqli_fetch_array($seleccionCategorias)){ $idCategoria = $ln['id']; ?>
                                                      <optgroup label="<?php echo $ln['categoria'];?>">
                                                          <?php $seleccionaSubCategorias = mysqli_query($DKKadmin, "SELECT * FROM menuSubCategorias WHERE menuSubCategorias.estado = '1' AND menuSubCategorias.idCategoria = '$idCategoria'  ORDER BY menuSubCategorias.idCategoria ASC"); if(mysqli_num_rows($seleccionaSubCategorias) == 0) { echo "</optgroup>"; } else { ?>
                                                       	  	<?php $counter = 1; while($lSub = mysqli_fetch_array($seleccionaSubCategorias)) { ?>
                                                              <option value="<?php echo $lSub['subCategoriaSEO'] ?>"><?php echo $lSub['subCategoria'] ?></option>
                                                            <?php } ?>
                                                        <?php } ?>
                                                      </optgroup>
                                                    <?php } ?>
                                                  </select>
                                                  <label for="subCategoriaSEO">Categor&iacute;a</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-xs-12">
                                                <div class="form-material form-material-primary">
                                                    <input class="form-control" type="text" id="nombre" name="nombre" placeholder="Ingresa el Nombre del Producto">
                                                    <label for="nombre">Nombre del Producto</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-xs-12">
                                                <div class="form-material form-material-primary">
                                                    <input class="form-control" type="text" id="nombreSEO" name="nombreSEO" placeholder="Ingresa el SEO del Producto">
                                                    <label for="nombreSEO">SEO del Producto</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-xs-12">
                                                <div class="form-material form-material-primary">
                                                    <textarea class="form-control" id="descripcionCorta" name="descripcionCorta" rows="3"></textarea>
                                                    <label for="descripcionCorta">Descripci&oacute;n Corta</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-xs-12 push-10">
                                                <div class="form-material form-material-primary">
                                                    <label>Descripci&oacute;n Completa</label>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 push-10">
                                                <textarea id="js-ckeditor" name="descripcion"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-xs-12">
                                                <div class="form-material input-group">
                                                    <input class="form-control" type="text" id="imagen1" name="imagen1" placeholder="Selecciona una fotograf&iacute;a" required>
                                                    <label for="imagen1">Fotografía (480x480px)</label>
                                                    <span class="input-group-addon"><a href="javascript:upload1();"><i class="fa fa-search"></i></a></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-xs-12">
                                                <div class="form-material input-group">
                                                    <input class="form-control" type="text" id="imagen2" name="imagen2" placeholder="Selecciona otra fotograf&iacute;a" required>
                                                    <label for="imagen2">Fotografía (480x480px)</label>
                                                    <span class="input-group-addon"><a href="javascript:upload2();"><i class="fa fa-search"></i></a></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-xs-12">
                                                <div class="form-material input-group">
                                                    <input class="form-control" type="text" id="imagen3" name="imagen3" placeholder="Selecciona otra fotograf&iacute;a" required>
                                                    <label for="imagen3">Fotografía (480x480px)</label>
                                                    <span class="input-group-addon"><a href="javascript:upload3();"><i class="fa fa-search"></i></a></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-xs-4">
                                                <div class="form-material form-material-primary">
                                                    <input class="form-control" type="number" id="precio" name="precio" placeholder="Ingresa el Precio del Producto">
                                                    <label for="precio">Precio</label>
                                                </div>
                                            </div>
                                            <div class="col-xs-4">
                                                <div class="form-material form-material-primary">
                                                    <input class="form-control" type="number" id="precioOferta" name="precioOferta" placeholder="Ingresa el Precio Oferta del Producto">
                                                    <label for="precioOferta">Precio Oferta</label>
                                                </div>
                                            </div>
                                            <div class="col-xs-4">
                                                <div class="form-material form-material-primary">
                                                    <input class="form-control" type="number" min="1" id="stock" name="stock" placeholder="Ingresa el Stock del Producto" value="1">
                                                    <label for="stock">Stock</label>
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
                                          <label class="col-xs-10">Novedad</label>
                                          <div class="col-xs-2">
                                              <label class="css-input switch switch-sm switch-primary">
                                                  <input type="checkbox" name="novedad" id="novedad"><span></span>
                                              </label>
                                          </div>
                                        </div>
                                      <div class="form-group">
                                            <label class="col-xs-8">Estado</label>
                                            <div class="col-xs-4">
                                                <label class="css-input css-radio css-radio-primary push-10-r">
                                                    <input type="radio" id="estado" name="estado" value="1" checked><span></span> Activo
                                                </label>
                                                <label class="css-input css-radio css-radio-primary">
                                                    <input type="radio" id="estado" name="estado" value="2"><span></span> Inactivo
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-xs-12">
                                                <button class="btn btn-sm btn-primary" type="submit">Guardar</button>
                                            </div>
                                        </div>
                                        <input type="hidden" name="MM_insert" value="productoForm">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END info -->
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
                    <a class="font-w600" href="https://diegokingkong.com/home" target="_blank">Origen 3.4</a> &copy; <span><?php echo date("Y"); ?></span>
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
                                  <a class="block block-rounded" href="../">
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
            jQuery(function () {
                App.initHelpers(['maxlength', 'select2', 'tags-inputs', 'ckeditor', 'appear', 'appear-countTo']);
            });
        </script>
		<!-- InstanceEndEditable -->
</body>
<!-- InstanceEnd --></html>
<?php
mysqli_free_result($datosAdmin);

mysqli_free_result($mailBox);

mysqli_free_result($ultimoProductoID);
?>
