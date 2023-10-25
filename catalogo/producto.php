<?php require_once('../Connections/DKKfront.php'); ?>
<?php
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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "buscadorHeader")) {
  $insertSQL = sprintf("INSERT INTO buscador (search, estado, fecha, fechaID, ip) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['search'], "text"),
                       GetSQLValueString($_POST['estado'], "text"),
                       GetSQLValueString($_POST['fecha'], "text"),
                       GetSQLValueString($_POST['fechaID'], "text"),
                       GetSQLValueString($_POST['ip'], "text"));

  $Result1 = mysqli_query($DKKfront, $insertSQL) or die(mysqli_error($DKKfront));

  $insertGoTo = "../search.php";
  header(sprintf("Location: %s", $insertGoTo));
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "cotizarForm")) {
  $insertSQL = sprintf("INSERT INTO cotizaciones (nombre, correo, telefono, qty, producto, productoSEO, productoCategoria, productoSubCategoria, productoFamilia, modelo, mensaje, fecha, fechaID, ip, estado, aceptaTerminos, origen) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['nombre'], "text"),
                       GetSQLValueString($_POST['correo'], "text"),
                       GetSQLValueString($_POST['telefono'], "text"),
                       GetSQLValueString($_POST['qty'], "text"),
                       GetSQLValueString($_POST['producto'], "text"),
                       GetSQLValueString($_POST['productoSEO'], "text"),
                       GetSQLValueString($_POST['productoCategoria'], "text"),
                       GetSQLValueString($_POST['productoSubCategoria'], "text"),
                       GetSQLValueString($_POST['productoFamilia'], "text"),
                       GetSQLValueString($_POST['modelo'], "text"),
                       GetSQLValueString($_POST['mensaje'], "text"),
                       GetSQLValueString($_POST['fecha'], "text"),
                       GetSQLValueString($_POST['fechaID'], "text"),
                       GetSQLValueString($_POST['ip'], "text"),
                       GetSQLValueString($_POST['estado'], "text"),
                       GetSQLValueString($_POST['aceptaTerminos'], "text"),
                       GetSQLValueString($_POST['origen'], "text"));

  $Result1 = mysqli_query($DKKfront, $insertSQL) or die(mysqli_error($DKKadmin));

  $insertGoTo = "../catalogo/send.php";
  header(sprintf("Location: %s", $insertGoTo));
}

//Variables Globales
$fecha = date('Y-m-d H:i:s');
$fechaID = strtotime($fecha);
$ip = $_SERVER["REMOTE_ADDR"];
$seo = $_GET["seo"];
$pagina = 'productos/'.$seo;

$query_metaDatos = "SELECT * FROM metaDatos ORDER BY metaDatos.id DESC LIMIT 1";
$metaDatos = mysqli_query($DKKfront, $query_metaDatos);
$row_metaDatos = mysqli_fetch_assoc($metaDatos);
$totalRows_metaDatos = mysqli_num_rows($metaDatos);

$query_menuMovil = "SELECT * FROM menuCategorias WHERE menuCategorias.estado = '1' ORDER BY menuCategorias.id ASC";
$menuMovil = mysqli_query($DKKfront, $query_menuMovil);
$row_menuMovil = mysqli_fetch_assoc($menuMovil);
$totalRows_menuMovil = mysqli_num_rows($menuMovil);

$query_categoriasMenu = "SELECT * FROM menuCategorias WHERE menuCategorias.estado = '1' ORDER BY menuCategorias.id ASC";
$categoriasMenu = mysqli_query($DKKfront, $query_categoriasMenu);
$row_categoriasMenu = mysqli_fetch_assoc($categoriasMenu);
$totalRows_categoriasMenu = mysqli_num_rows($categoriasMenu);

$query_categoriasFooter = "SELECT * FROM menuCategorias WHERE menuCategorias.estado = '1' ORDER BY menuCategorias.id ASC";
$categoriasFooter = mysqli_query($DKKfront, $query_categoriasFooter);
$row_categoriasFooter = mysqli_fetch_assoc($categoriasFooter);
$totalRows_categoriasFooter = mysqli_num_rows($categoriasFooter);

$query_productoSEO = sprintf("SELECT * FROM productos WHERE productos.nombreSEO = '$seo' AND productos.estado = '1'");
$productoSEO = mysqli_query($DKKfront, $query_productoSEO);
$row_productoSEO = mysqli_fetch_assoc($productoSEO);
$totalRows_productoSEO = mysqli_num_rows($productoSEO);

$categoria = $row_productoSEO["categoriaSEO"];
$subcategoria = $row_productoSEO["subCategoriaSEO"];
$idProducto = $row_productoSEO["id"];

$query_productoTabla = "SELECT * FROM productosTabla WHERE productosTabla.escalaID = '$idProducto' AND productosTabla.estado = '1' ORDER BY productosTabla.id ASC";
$productoTabla = mysqli_query($DKKfront, $query_productoTabla);
$row_productoTabla = mysqli_fetch_assoc($productoTabla);
$totalRows_productoTabla = mysqli_num_rows($productoTabla);

$query_productoModeloShower = "SELECT * FROM productosModelos WHERE productosModelos.showerDoorID = '$idProducto' AND productosModelos.estado = '1' ORDER BY productosModelos.id ASC";
$productoModeloShower = mysqli_query($DKKfront, $query_productoModeloShower);
$row_productoModeloShower = mysqli_fetch_assoc($productoModeloShower);
$totalRows_productoModeloShower = mysqli_num_rows($productoModeloShower);

$query_tablaCotizador = "SELECT * FROM productosTabla WHERE productosTabla.escalaID = '$idProducto' AND productosTabla.estado = '1' ORDER BY productosTabla.id ASC";
$tablaCotizador = mysqli_query($DKKfront, $query_tablaCotizador);
$row_tablaCotizador = mysqli_fetch_assoc($tablaCotizador);
$totalRows_tablaCotizador = mysqli_num_rows($tablaCotizador);

$query_tablaCotizadorShowerDoors = "SELECT * FROM productosModelos WHERE productosModelos.showerDoorID = '$idProducto' AND productosModelos.estado = '1' ORDER BY productosModelos.id ASC";
$tablaCotizadorShowerDoors = mysqli_query($DKKfront, $query_tablaCotizadorShowerDoors);
$row_tablaCotizadorShowerDoors = mysqli_fetch_assoc($tablaCotizadorShowerDoors);
$totalRows_tablaCotizadorShowerDoors = mysqli_num_rows($tablaCotizadorShowerDoors);

$query_productoCategoria = "SELECT * FROM menuCategorias WHERE menuCategorias.categoriaSEO = '$categoria'";
$productoCategoria = mysqli_query($DKKfront, $query_productoCategoria);
$row_productoCategoria = mysqli_fetch_assoc($productoCategoria);
$totalRows_productoCategoria = mysqli_num_rows($productoCategoria);

$categoriaSEO = $row_productoCategoria["categoriaSEO"];

$query_productoSubCategoria = "SELECT * FROM menuSubCategorias WHERE menuSubCategorias.subCategoriaSEO = '$subcategoria'";
$productoSubCategoria = mysqli_query($DKKfront, $query_productoSubCategoria);
$row_productoSubCategoria = mysqli_fetch_assoc($productoSubCategoria);
$totalRows_productoSubCategoria = mysqli_num_rows($productoSubCategoria);

$query_productosRelacionados = "SELECT * FROM productos WHERE RAND()<(SELECT ((16/COUNT(*))*120) FROM productos) AND productos.categoriaSEO = '$categoria' AND productos.estado = '1' ORDER BY RAND() LIMIT 16";
$productosRelacionados = mysqli_query($DKKfront, $query_productosRelacionados);
$row_productosRelacionados = mysqli_fetch_assoc($productosRelacionados);
$totalRows_productosRelacionados = mysqli_num_rows($productosRelacionados);

$query_ultimaCotizacion = "SELECT * FROM cotizaciones WHERE cotizaciones.estado = '1' ORDER BY cotizaciones.id DESC LIMIT 1";
$ultimaCotizacion = mysqli_query($DKKfront, $query_ultimaCotizacion);
$row_ultimaCotizacion = mysqli_fetch_assoc($ultimaCotizacion);
$totalRows_ultimaCotizacion = mysqli_num_rows($ultimaCotizacion);

//actualizar visita
  $updateSQL = sprintf("UPDATE productos SET productos.visitas = productos.visitas +1 WHERE productos.id = '$idProducto' AND productos.estado = '1'");
  $Result1 = mysqli_query($DKKfront, $updateSQL) or die(mysqli_error($DKKfront));
//registrar visita
  $updateSQL = sprintf("INSERT INTO visitas (pagina, ip, fechaID) VALUE ('$pagina', '$ip', '$fechaID')");
  $Result1 = mysqli_query($DKKfront, $updateSQL) or die(mysqli_error($DKKfront));
?>
<!DOCTYPE html>
<html lang="es"><!-- InstanceBegin template="/Templates/ppalFrontClean.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta charset="utf-8">
<!--[if IE]>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<![endif]-->
<meta http-equiv="x-ua-compatible" content="ie=edge">
<!-- InstanceBeginEditable name="doctitle" -->
<title><?php echo $row_metaDatos["titulo"]." | ".$row_productoSEO["nombre"]; ?></title>
<!-- InstanceEndEditable -->
<meta name="description" content="<?php echo $row_metaDatos["descripcion"]; ?>">
<meta name="keywords" content="<?php echo $row_metaDatos["keywords"]; ?>">
<meta name="robots" content="index,follow" />
<!-- OpenGraph metadata-->
<meta property="og:locale" content="es" />
<meta property="og:type" content="website" />
<meta property="og:title" content="<?php echo $row_metaDatos["titulo"]; ?>" />
<meta property="og:description" content="<?php echo $row_metaDatos["descripcion"]; ?>" />
<meta property="og:url" content="https://www.prodalum.cl" />
<meta property="og:site_name" content="<?php echo $row_metaDatos["titulo"]; ?>" />
<meta property="og:image" content="https://www.prodalum.cl/images/" />
<meta property='fb:admins' content='334335937080160'/>
<meta name="twitter:card" content="summary"/>
<meta name="twitter:description" content="<?php echo $row_metaDatos["descripcion"]; ?>"/>
<meta name="twitter:title" content="<?php echo $row_metaDatos["titulo"]; ?>"/>
<meta name="twitter:site" content="@ProdalumChile"/>
<meta name="twitter:creator" content="@DiegoKingKongCL"/>
<!-- Multi-language support -->
<link rel="alternate" href="https://www.prodalum.cl" hreflang="es" />
<meta property="og:locale:alternate" content="es" />
<!-- full responsivo  -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- favicon -->
<link rel="shortcut icon" type="image/x-icon" href="../images/favicon.ico">
<!-- css -->
<link rel="stylesheet" href="../css/estilo.css">
<!-- whatsapp -->
<link rel="stylesheet" href="../js/whatsapp/floating-wpp.css">
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-121057902-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-121057902-1');
</script>
<!-- InstanceBeginEditable name="head" -->
<!--<script type="text/javascript">
if (screen.width<500) {
window.location="http://mobile.prodalum.cl/home/#!/../catalogo/producto.php?seo=<?php echo $row_productoSEO["nombreSEO"]; ?>";
}
</script>-->
<style>
.btn {
  background: #565656;
  border: #505050 solid 0px;
  border-radius: 3px;
  color: #fff;
  display: inline-block;
  font-size: 14px;
  padding: 8px 15px;
  text-decoration: none;
  text-align: center;
  min-width: 120px;
  position: relative;
  transition: color .1s ease;
}
.btn:hover {
  background: #1E3875;
  color: #fff;
}
.btn.btn-big {
  font-size: 18px;
  padding: 15px 20px;
  min-width: 100px;
}
.btn-close {
  color: #aaaaaa;
  font-size: 20px;
  text-decoration: none;
  padding:10px;
  position: absolute;
  right: 7px;
  top: 0;
}
.btn-close:hover {
  color: #919191;
}
.modale:before {
  content: "";
  display: none;
  background: rgba(0, 0, 0, 0.6);
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  z-index: 10;
}
.opened:before {
  display: block;
}
.opened .modal-dialog {
  -webkit-transform: translate(0, 0);
  -ms-transform: translate(0, 0);
  transform: translate(0, 0);
  top: 20%;
}
.modal-dialog {
  background: #fefefe;
  border: #333333 solid 0px;
  border-radius: 5px;
  margin-left: -200px;
  text-align:left;
  position: fixed;
  left: 50%;
  top: -100%;
  z-index: 11;
  width: 360px;
  box-shadow:0 5px 10px rgba(0,0,0,0.3);
  -webkit-transform: translate(0, -500%);
  -ms-transform: translate(0, -500%);
  transform: translate(0, -500%);
  -webkit-transition: -webkit-transform 0.3s ease-out;
  -moz-transition: -moz-transform 0.3s ease-out;
  -o-transition: -o-transform 0.3s ease-out;
  transition: transform 0.3s ease-out;
}
.modal-body {
  padding: 20px;
}
.modal-header,
.modal-footer {
  padding: 10px 20px;
}
.modal-header {
  border-bottom: #eeeeee solid 1px;
}
.modal-header h3 {
  font-size: 16px;
}
</style>
<!-- InstanceEndEditable -->
</head>

<body class="404error_page">
<div id="whatsApp"></div>
<!-- menu celular -->
<div id="mobile-menu">
  <ul>
    <li><a href="../">Home</a></li>
    <li><a href="#" class="home1">Nosotros</a>
      <ul>
        <li><a href="../historia"><span>Historia</span></a></li>
        <li><a href="../mision"><span>Misi&oacute;n</span></a></li>
        <li><a href="../post-venta"><span>Post Venta</span></a></li>
        <li><a href="../representantes"><span>Representantes</span></a></li>
      </ul>
    </li>
    <li><a href="#" class="home1">Productos</a>
      <ul>
      
        <?php do { ?>
        <li><a href="../categoria/<?php echo $row_menuMovil["categoriaSEO"]; ?>"><span><?php echo $row_menuMovil["categoria"]; ?></span></a></li>
        <?php } while ($row_menuMovil = mysqli_fetch_assoc($menuMovil)); ?>
        
      </ul>
    </li>
    <li><a href="../blog">Blog</a></li>
    <li><a href="../contacto">Contacto</a></li>
  </ul>
</div>
<!-- END menu celular -->
<div id="page"> 

  <!-- header -->
  <header>
    <div class="header-container">
      <div class="header-top">
        <div class="container">
          <div class="row">
            <div class="col-sm-4 col-md-4 col-xs-12"> 
              <div class="welcome-msg hidden-xs hidden-sm">Bienvenidos a PRODALUM! </div>
              <div class="language-currency-wrapper">
                <div class="inner-cl">
                  <div class="block block-language form-language">
                    <div class="lg-cur"><span><img src="../images/flag_cl.jpg" alt="Chile"><span class="lg-fr">Chile</span><i class="fa fa-angle-down"></i></span></div>
                    <ul>
                      <li><a class="selected" href="#"><img src="../images/flag_cl.jpg" alt="Chile"><span>Chile</span></a></li>
                      <!-- <li><a href="#"><img src="../images/flag_en.png" alt="Inglés"><span>Inglés</span></a></li>
                      <li><a href="#"><img src="../images/flag_br.jpg" alt="Portugués"><span>Portugués</span></a></li> -->
                    </ul>
                  </div>
                </div>
              </div>
            </div>
            
            <!-- menu top -->
            <div class="headerlinkmenu col-md-8 col-sm-8 col-xs-12"> <span class="phone  hidden-xs hidden-sm">Llámanos: <?php echo $row_metaDatos["telefono"]; ?></span>
              <ul class="links">
                <li class="hidden-xs"><a title="Post Venta" href="../post-venta"><span>Post Venta</span></a></li>
                <li><a title="Sala de Ventas" href="../sala-de-ventas"><span>Sala de Ventas</span></a></li>
                <li><a title="Contacto" href="../contacto"><span>Contacto</span></a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>

      <div class="header-inner">
        <div class="container">
          <div class="row">
            <div class="col-sm-3 col-xs-12 jtv-logo-block"> 
              <!-- logo -->
              <div class="logo"><a title="<?php echo $row_metaDatos["titulo"]; ?>" href="../"><img alt="<?php echo $row_metaDatos["titulo"]; ?>" title="<?php echo $row_metaDatos["titulo"]; ?>" src="../images/logo.png"></a> </div>
            </div>
            <div class="col-xs-12 col-sm-5 col-md-6 jtv-top-search"> 
              <!-- buscador -->
              <div class="top-search">
                <div id="search">
                  <form method="POST" action="<?php echo $editFormAction; ?>" name="buscadorHeader">
                    <div class="input-group">
                      <input type="text" class="form-control" placeholder="Busca tu producto..." name="search">
                      <button class="btn-search" type="submit"><i class="fa fa-search"></i></button>
                      <input type="hidden" name="ip" value="<?php echo $ip; ?>">
                      <input type="hidden" name="fecha" value="<?php echo $fecha; ?>">
                      <input type="hidden" name="fechaID" value="<?php echo $fechaID; ?>">
                      <input type="hidden" name="estado" value="1">
                    </div>
                    <input type="hidden" name="MM_insert" value="buscadorHeader">
                  </form>
                </div>
              </div>
              <!-- END buscador --> 
              
            </div>
            <div class="col-xs-12 col-sm-4 col-md-3 top-cart">
              <div class="link-wishlist hidden-resp"> <a href="tel:<?php echo $row_metaDatos["telefono"]; ?>"> <i class="icons icon-phone"></i><span style="font-size:12px;"> Llámanos</span></a> </div>
              <div class="link-wishlist hidden-resp"> <a href="../contacto"> <i class="icons icon-bubble"></i><span style="font-size:12px;"> Contáctanos</span></a> </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </header>
  <!-- END header -->

  <nav>
    <div class="container">
      <div class="row">
        <div class="mm-toggle-wrap">
          <div class="mm-toggle"><i class="fa fa-align-justify"></i> </div>
          <span class="mm-label">Categorías</span> </div>
        <div class="col-md-3 col-sm-3 mega-container hidden-xs">
          <div class="navleft-container">
            <div class="mega-menu-title">
              <h3><span>Categorías</span></h3>
            </div>
            
            <!-- categorías -->
            <div class="mega-menu-category">
              <ul class="nav">
			    <?php $seleccionCategorias = mysqli_query($DKKfront, "SELECT * FROM menuCategorias WHERE menuCategorias.estado = '1' ORDER BY menuCategorias.id ASC"); while($ln = mysqli_fetch_array($seleccionCategorias)){ $idCategoria = $ln['id']; ?>
                <li><a href="../categoria/<?php echo $ln["categoriaSEO"]; ?>"><strong><?php echo $ln["categoria"]; ?></strong> </a>
                  <?php $seleccionaSubCategorias = mysqli_query($DKKfront, "SELECT * FROM menuSubCategorias WHERE menuSubCategorias.estado = '1' AND menuSubCategorias.idCategoria = '$idCategoria'  ORDER BY menuSubCategorias.id ASC"); if(mysqli_num_rows($seleccionaSubCategorias) == 0) { echo " "; } else { ?>
				    <div class="wrap-popup column1">
                      <div class="popup">
                        <ul class="nav">
					    <?php $counter = 1; while($lSub = mysqli_fetch_array($seleccionaSubCategorias)) { ?>
                        <li><a href="../<?php echo $ln["categoriaSEO"]; ?>/<?php echo $lSub["subCategoriaSEO"]; ?>"><span><strong><?php echo $lSub["subCategoria"]; ?></strong></span></a></li>
                        <?php } ?>
                      </ul>
                    </div>
                  </div>
                  <?php } ?>
                <?php } ?>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-md-9 col-sm-9 jtv-megamenu">
          <div class="mtmegamenu">
            <ul class="hidden-xs">
              <li class="mt-root">
                <div class="mt-root-item">
                  <a href="../"><div class="title title_font"><span class="title-text">Home</span> </div></a>
                </div>
              </li>
              <li class="mt-root demo_custom_link_cms">
                <div class="mt-root-item">
                  <a href="#"><div class="title title_font"><span class="title-text">Nosotros</span></div></a>
                </div>
                <ul class="menu-items col-md-3 col-sm-4 col-xs-12">
                  <li class="menu-item depth-1">
                    <div class="title"> <a href="../historia"><span>Historia</span></a></div>
                  </li>
                  <li class="menu-item depth-1">
                    <div class="title"> <a href="../mision"><span>Misi&oacute;n</span></a></div>
                  </li>
                  <li class="menu-item depth-1">
                    <div class="title"> <a href="../post-venta"><span>Post Venta</span></a></div>
                  </li>
                  <li class="menu-item depth-1">
                    <div class="title"> <a href="../representantes"><span>Representantes</span></a></div>
                  </li>
                </ul>
              </li>
              <li class="mt-root demo_custom_link_cms">
                <div class="mt-root-item"><a href="../catalogo">
                  <div class="title title_font"><span class="title-text">Productos</span></div>
                </a></div>
                <ul class="menu-items col-md-3 col-sm-4 col-xs-12">
                  
                  <?php do { ?>
                  <li class="menu-item depth-1">
                    <div class="title"> <a href="../categoria/<?php echo $row_categoriasMenu["categoriaSEO"]; ?>"><span><?php echo $row_categoriasMenu["categoria"]; ?></span></a></div>
                  </li>
                  <?php } while ($row_categoriasMenu = mysqli_fetch_assoc($categoriasMenu)); ?>

                </ul>
              </li>
              <li class="mt-root">
                <div class="mt-root-item"><a href="../buscador">
                  <div class="title title_font"><span class="title-text">Buscador de Escaleras</span> </div>
                </a></div>
              </li>
              <li class="mt-root">
                <div class="mt-root-item"><a href="https://www.webpay.cl/portalpagodirecto/pages/institucion.jsf?idEstablecimiento=57813066" target="_blank">
                  <div class="title title_font"><span class="title-text">Pago WebPay</span> </div>
                </a></div>
              </li>
              <li><a href="../contacto">Contacto</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </nav>
  <!-- END navegación -->
  
  <!-- contenido -->
  <!-- InstanceBeginEditable name="contenido" -->
  <div id="fb-root"></div>
  <script>
  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = 'https://connect.facebook.net/es_ES/sdk.js#xfbml=1&version=v2.12&appId=271042170025178&autoLogAppEvents=1';
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));
  </script>
  <!-- título --> 
  <div class="breadcrumbs">
    <div class="container">
      <div class="row">
        <div class="col-xs-12">
          <ul>
            <li class="home"> <a title="Ir al Home" href="../">Home</a><span>&raquo;</span></li>
            <li class=""> <a title="Ir a la Categoría" href="../categoria/<?php echo $row_productoSEO["categoriaSEO"]; ?>"><?php echo $row_productoCategoria["categoria"]; ?></a><span>&raquo;</span></li>
            <li><strong><?php echo $row_productoSEO["nombre"]; ?></strong></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <!-- END título --> 
  <!-- Main Container -->
  <div class="main-container col1-layout">
    <div class="container">
      <div class="row">
        <div class="col-main">
          <div class="product-view-area">
            <div class="product-big-image col-xs-12 col-sm-5 col-lg-5 col-md-5">
              <?php if (isset($row_productoSEO["precioOferta"])) { ?><div class="icon-sale-label sale-left">Oferta</div><?php } ?>
              <?php if ($row_productoSEO["novedad"] == '1') { ?><div class="icon-new-label new-right">Nuevo</div><?php } ?>
              <div class="large-image"> <a href="../images/productos/<?php echo $row_productoSEO["imagen1"]; ?>" class="cloud-zoom" id="zoom1" rel="useWrapper: false, adjustY:0, adjustX:20"> <img class="zoom-img" src="../images/productos/<?php echo $row_productoSEO["imagen1"]; ?>" alt="<?php echo $row_productoSEO["nombre"]; ?>"> </a> </div>
              <div class="flexslider flexslider-thumb">
                <ul class="previews-list slides">
                  <li><a href='../images/productos/<?php echo $row_productoSEO["imagen1"]; ?>' class='cloud-zoom-gallery' rel="useZoom: 'zoom1', smallImage: '../images/productos/<?php echo $row_productoSEO["imagen1"]; ?>' "><img src="../images/productos/<?php echo $row_productoSEO["imagen1"]; ?>" alt = "<?php echo $row_productoSEO["nombre"]; ?>"/></a></li>
                  <li><a href='../images/productos/<?php echo $row_productoSEO["imagen2"]; ?>' class='cloud-zoom-gallery' rel="useZoom: 'zoom1', smallImage: '../images/productos/<?php echo $row_productoSEO["imagen2"]; ?>' "><img src="../images/productos/<?php echo $row_productoSEO["imagen2"]; ?>" alt = "<?php echo $row_productoSEO["nombre"]; ?>"/></a></li>
                  <li><a href='../images/productos/<?php if(isset($row_productoSEO["imagen3"])) {echo $row_productoSEO["imagen3"];} else {echo"no-imagen.jpg";}; ?>' class='cloud-zoom-gallery' rel="useZoom: 'zoom1', smallImage: '../images/productos/<?php echo $row_productoSEO["imagen3"]; ?>' "><img src="../images/productos/<?php if(isset($row_productoSEO["imagen3"])) {echo $row_productoSEO["imagen3"];} else {echo"no-imagen.jpg";}; ?>" alt = "<?php echo $row_productoSEO["nombre"]; ?>"/></a></li>
                </ul>
              </div>
              
            </div>
            <div class="col-xs-12 col-sm-7 col-lg-7 col-md-7 product-details-area">
              <div class="product-name">
                <h1><?php echo $row_productoSEO["nombre"]; ?></h1>
              </div>
              <?php if (isset($row_productoSEO["precio"])) { ?>
			  <?php if (isset($row_productoSEO["precioOferta"])) { ?>
              <div class="price-box">
                <p class="special-price"> <span class="price-label">Precio Oferta:</span> <span class="price"> <?php echo "$".number_format(0,$row_productoSEO["precioOferta"],",","."); ?> </span> </p>
                <p class="old-price"> <span class="price-label">Precio Normal:</span> <span class="price"> <?php echo "$".number_format(0,$row_productoSEO["precio"],",","."); ?> </span> </p>
              </div>
              <?php } ?>
              <?php if (empty($row_productoSEO["precioOferta"])) { ?>
              <div class="price-box">
                <p class="special-price"> <span class="price-label">Precio:</span> <span class="price"> <?php echo "$".number_format(0,$row_productoSEO["precio"],",","."); ?> </span> </p>
              </div>
              <?php } ?>
              <?php } ?>
              <div class="ratings">
                <p class="rating-links"> <a href="#"><span class="fb-comments-count" data-href="https://www.prodalum.cl/productos/<?php echo $row_productoSEO["nombreSEO"]; ?>"></span> Comentario(s)</a> </p>
              </div>
              <div class="short-description">
                <h2>Descripción</h2>
                <p><?php echo $row_productoSEO["descripcionCorta"]; ?></p>
              </div>
			  <div class="pro-tags">
                <div class="pro-tags-title">Keywords:</div>
                <a href="#"><?php echo str_replace(",","</a>, <a href='#'>",$row_productoSEO["keywords"]); ?></a> </div>
              <?php if ($categoriaSEO == 'escalas') { ?>
              <div class="share-box">
                <a href="#" class="btn btn-big openmodale"><span> Cotizar</span></a>
              </div>
              <?php } ?>
              <?php if ($categoriaSEO == 'shower-door') { ?>
              <div class="share-box">
                <a href="#" class="btn btn-big openmodale"><span> Cotizar</span></a>
              </div>
              <?php } ?>
              <div class="share-box">
                <div class="title">Compártelo en Redes Sociales</div>
                <div class="socials-box"> 
                  <a href="https://www.facebook.com/sharer/sharer.php?u=https://www.prodalum.cl/productos/<?php echo $row_productoSEO["nombreSEO"]; ?>" target="_blank"><i class="fa fa-facebook"></i></a> 
                  <a href="https://twitter.com/?status=<?php echo $row_productoSEO["nombre"]; ?> #PRODALUM - https://www.prodalum.cl/productos/<?php echo $row_productoSEO["nombreSEO"]; ?>" target="_blank"><i class="fa fa-twitter"></i></a> 
                  <a href="https://plus.google.com/share?url=https://www.prodalum.cl/productos/<?php echo $row_productoSEO["nombreSEO"]; ?>" target="_blank"><i class="fa fa-google-plus"></i></a> 
                  <a href="http://www.linkedin.com/shareArticle?url=<?php echo $row_productoSEO["nombreSEO"]; ?>"><i class="fa fa-linkedin"></i></a> 
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="product-overview-tab">
          <div class="container">
            <div class="row">
              <div class="col-xs-12">
                <div class="product-tab-inner">
                  <ul id="product-detail-tab" class="nav nav-tabs product-tabs">
                    <?php if ($totalRows_productoTabla > 0) { ?>
                    <li class="active"> <a href="#tabla" data-toggle="tab"> Tabla </a> </li>
                    <?php } ?>
                    <?php if ($totalRows_productoModeloShower > 0) { ?>
                    <li class="active"> <a href="#modelos" data-toggle="tab"> Modelos </a> </li>
                    <?php } ?>
                    <li class="<?php if (($totalRows_productoTabla == 0) && ($totalRows_productoModeloShower == 0)) { echo"active";} ?>"> <a href="#descripcion" data-toggle="tab"> Descripción </a> </li>
                    <li> <a href="#comentarios" data-toggle="tab">Comentarios</a> </li>
                  </ul>
                  <div id="productTabContent" class="tab-content">
                    <?php if ($totalRows_productoTabla > 0) { ?>
                    <div class="tab-pane fade in active" id="tabla">
                      <div class="std">
                        <table align="center">
                          <thead style="background-color:#1e3875;color:#fff;text-align:center;">
                            <tr>
                              <?php if (isset($row_productoTabla["modelo"])) { ?><td style="padding-left:5px;padding-right:5px;border-right:solid;border-right-color:#fff;border-right-width:2px;">Modelo Escala</td><?php } ?>
                              <?php if (isset($row_productoTabla["peso"])) { ?><td style="padding-left:5px;padding-right:5px;border-right:solid;border-right-color:#fff;border-right-width:2px;">Peso (kgs.)</td><?php } ?>
                              <?php if (isset($row_productoTabla["peldanos"])) { ?><td style="padding-left:5px;padding-right:5px;border-right:solid;border-right-color:#fff;border-right-width:2px;">N&deg; de Pelda&ntilde;os</td><?php } ?>
                              <?php if (isset($row_productoTabla["alturaTotal"])) { ?><td style="padding-left:5px;padding-right:5px;border-right:solid;border-right-color:#fff;border-right-width:2px;">Altura Total (mts.)</td><?php } ?>
                              <?php if (isset($row_productoTabla["alturaUtil"])) { ?><td style="padding-left:5px;padding-right:5px;border-right:solid;border-right-color:#fff;border-right-width:2px;">Altura &Uacute;til (mts.)</td><?php } ?>
                              <?php if (isset($row_productoTabla["alcanceMaximo"])) { ?><td style="padding-left:5px;padding-right:5px;border-right:solid;border-right-color:#fff;border-right-width:2px;">Alcance M&aacute;ximo (mts.)</td><?php } ?>
                            </tr>
                          </thead>
                          <tbody>
                            <?php do { ?>
                            <tr style="background-color:#fff;color:#000;text-align:center;">
                              <?php if (isset($row_productoTabla["modelo"])) { ?><td style="text-align:center;"><?php echo $row_productoTabla["modelo"]; ?></td><?php } ?>
                              <?php if (isset($row_productoTabla["peso"])) { ?><td style="text-align:center;"><?php echo $row_productoTabla["peso"]; ?></td><?php } ?>
                              <?php if (isset($row_productoTabla["peldanos"])) { ?><td style="text-align:center;"><?php echo $row_productoTabla["peldanos"]; ?></td><?php } ?>
                              <?php if (isset($row_productoTabla["alturaTotal"])) { ?><td style="text-align:center;"><?php echo $row_productoTabla["alturaTotal"]; ?></td><?php } ?>
                              <?php if (isset($row_productoTabla["alturaUtil"])) { ?><td style="text-align:center;"><?php echo $row_productoTabla["alturaUtil"]; ?></td><?php } ?>
                              <?php if (isset($row_productoTabla["alcanceMaximo"])) { ?><td style="text-align:center;"><?php echo $row_productoTabla["alcanceMaximo"]; ?></td><?php } ?>
                            </tr>
                            <?php } while ($row_productoTabla = mysqli_fetch_assoc($productoTabla)); ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                    <?php } ?>
                    <?php if ($totalRows_productoModeloShower > 0) { ?>
                    <div class="tab-pane fade in active" id="modelos">
                      <?php do { ?>
                      <div class=" col-lg-4">
                        <table align="center" width="100%">
                          <thead style="background-color:#1e3875;color:#fff;text-align:center;">
                            <tr>
                              <td style="padding-left:5px;padding-right:5px;border-right:solid;border-right-color:#fff;border-right-width:2px;text-align:center;" align="center"><?php echo $row_productoModeloShower["tipo"]; ?></td>
                            </tr>
                          </thead>
                          <tbody>
                            <tr style="background-color:#fff;color:#000;text-align:center;">
                              <?php if (isset($row_productoModeloShower["descripcion"])) { ?><td style="text-align:center;"><?php echo $row_productoModeloShower["descripcion"]; ?><p><b>Color:</b><br> <?php echo $row_productoModeloShower["color"]; ?>.</p></td><?php } ?>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                      <?php } while ($row_productoModeloShower = mysqli_fetch_assoc($productoModeloShower)); ?>
                    </div>
                    <?php } ?>
                    <div class="tab-pane fade in <?php if (($totalRows_productoTabla == 0) && ($totalRows_productoModeloShower == 0)) { echo"active";} ?>" id="descripcion">
                      <div class="std">
                        <p><?php echo $row_productoSEO["descripcion"]; ?></p>
                      </div>
                    </div>
                    <div id="comentarios" class="tab-pane fade">
                      <div class="col-sm-12 col-lg-12 col-md-12">
                        <div class="reviews-content-left">
                          <h2>Comentarios</h2>
                          <div class="fb-comments" data-href="https://www.prodalum.cl/productos/<?php echo $row_productoSEO["nombreSEO"]; ?>" data-width="100%" data-numposts="10"></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- END producto --> 
  
  <?php if ($totalRows_productosRelacionados > 0) { ?>
  <!-- productos relacionados -->
  <div class="container">
    <div class="row">
      <div class="col-xs-12">
        <div class="related-product-area">
          <div class="page-header">
            <h2>Productos Relacionados</h2>
          </div>
          <div class="related-products-pro">
            <div class="slider-items-products">
              <div id="related-product-slider" class="product-flexslider hidden-buttons">
                <div class="slider-items slider-width-col4 fadeInUp">
                
                  <?php do { ?>
                  <div class="product-item">
                    <div class="item-inner">
                      <?php if (isset($row_productosRelacionados["precioOferta"])) { ?><div class="icon-sale-label sale-left">Oferta</div><?php } ?>
                      <?php if ($row_productosRelacionados["novedad"] == '1') { ?><div class="icon-new-label new-right">Nuevo</div><?php } ?>
                      <div class="product-thumbnail">
                        <div class="pr-img-area"> <a title="<?php echo $row_productosRelacionados["nombre"]; ?>" href="../productos/<?php echo $row_productosRelacionados["nombreSEO"]; ?>">
                          <figure> <img class="first-img" src="../images/productos/<?php echo $row_productosRelacionados["imagen1"]; ?>" alt="<?php echo $row_productosRelacionados["nombre"]; ?>"> <img class="hover-img" src="../images/productos/<?php echo $row_productosRelacionados["imagen1"]; ?>" alt="<?php echo $row_productosRelacionados["nombre"]; ?>"></figure>
                          </a> </div>
                      </div>
                      <div class="item-info">
                        <div class="info-inner">
                          <div class="item-title"> <a title="<?php echo $row_productosRelacionados["nombre"]; ?>" href="../productos/<?php echo $row_productosRelacionados["nombreSEO"]; ?>"><?php echo $row_productosRelacionados["nombre"]; ?> </a> </div>
                          <div class="item-content">
                            <?php if (isset($row_productosRelacionados["precio"])) { ?>
                            <div class="item-price">
                              <?php if (isset($row_productosRelacionados["precioOferta"])) { ?>
                              <div class="price-box">
                                <p class="special-price"> <span class="price-label">Precio Oferta</span> <span class="price"> <?php echo "$".number_format(0,$row_productosRelacionados["precioOferta"],",",","); ?> </span> </p>
                                <p class="old-price"> <span class="price-label">Precio Normal</span> <span class="price"> <?php echo "$".number_format(0,$row_productosRelacionados["precio"],",",","); ?> </span> </p>
                              </div>
                              <?php } ?>
                              <?php if (empty($row_productosRelacionados["precioOferta"])) { ?>
                              <div class="price-box"><span class="regular-price"> <span class="price"><?php echo "$".number_format(0,$row_productosRelacionados["precio"],",",","); ?></span> </span> </div>
                              <?php } ?>
                            </div>
                            <?php } ?>
                            <div class="pro-action">
                              <button type="button" class="add-to-cart" onClick="location.href='../productos/<?php echo $row_productosRelacionados["nombreSEO"]; ?>'"><span> Ver Producto</span> </button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <?php } while ($row_productosRelacionados = mysqli_fetch_assoc($productosRelacionados)); ?>

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- END productos relacionados --> 
  <?php } ?>
  
  <!-- InstanceEndEditable -->
  <!-- END contenido -->
  
  <!-- atributos -->
  <div class="jtv-service-area">
    <div class="container">
      <div class="row">
        <div class="col col-md-6 col-sm-6 col-xs-12 ">
          <div class="block-wrapper return">
            <div class="text-des">
              <div class="icon-wrapper"><i class="fa fa-rotate-right"></i></div>
              <div class="service-wrapper">
                <h3>Pagos 100% Seguros</h3>
                <p>Efectivo / Transferencia / Transbank / WebPay </p>
              </div>
            </div>
          </div>
        </div>
        <div class="col col-md-6 col-sm-6 col-xs-12">
          <div class="block-wrapper support">
            <div class="text-des">
              <div class="icon-wrapper"><i class="fa fa-umbrella"></i></div>
              <div class="service-wrapper">
                <h3>Post Venta</h3>
                <p>Llámanos: <?php echo $row_metaDatos["telefono"]; ?></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Footer -->
  <footer>
    <div class="footer-contact">
      <div class="container">
        <div class="row">
          
          <div class="col-sm-4">
            <div class="footer-contact-item">
              <div class="footer-contact-icon"> <i class="fa fa-phone"></i> </div>
              <div class="footer-contact-text"> <?php echo $row_metaDatos["telefono"]; ?> </div>
            </div>
          </div>
          
        </div>
      </div>
    </div>
    <div class="container">
      <div class="row">
        <div class="col-sm-6 col-md-3 col-xs-12">
          <div class="footer-logo"><a href="../"><img src="../images/footer-logo.png" alt="<?php echo $row_metaDatos["titulo"]; ?>"></a> </div>
          <p><?php echo $row_metaDatos["descripcionFooter"]; ?></p>
          <div class="social">
            <ul class="inline-mode">
              <?php if (isset($row_metaDatos["facebook"])) { ?><li class="social-network fb"><a title="Encuéntranos en Facebook" target="_blank" href="<?php echo $row_metaDatos["facebook"]; ?>"><i class="fa fa-facebook"></i></a></li><?php } ?>
              <?php if (isset($row_metaDatos["twitter"])) { ?><li class="social-network tw"><a title="Síguenos en Twitter" target="_blank" href="<?php echo $row_metaDatos["twitter"]; ?>"><i class="fa fa-twitter"></i></a></li><?php } ?>
              <?php if (isset($row_metaDatos["youtube"])) { ?><li class="social-network rss"><a title="Suscríbete a nuestro YouTube" target="_blank" href="<?php echo $row_metaDatos["youtube"]; ?>"><i class="fa fa-youtube"></i></a></li><?php } ?>
            </ul>
          </div>
        </div>
        <div class="col-sm-6 col-md-3 col-xs-12 collapsed-block">
          <div class="footer-links">
            <h3 class="links-title">Tienda<a class="expander visible-xs" href="#TabBlock-1">+</a></h3>
            <div class="tabBlock" id="TabBlock-1">
              <ul class="list-links list-unstyled">
                <?php do { ?><li><a href="../categoria/<?php echo $row_categoriasFooter["categoriaSEO"]; ?>"><?php echo $row_categoriasFooter["categoria"]; ?></a></li><?php } while ($row_categoriasFooter = mysqli_fetch_assoc($categoriasFooter)); ?>
                <li><a href="../post-venta">Post Venta</a></li>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-sm-6 col-md-3 col-xs-12 collapsed-block">
          <div class="footer-links">
            <h3 class="links-title">Menú<a class="expander visible-xs" href="#TabBlock-3">+</a></h3>
            <div class="tabBlock" id="TabBlock-3">
              <ul class="list-links list-unstyled">
                <li><a href="../">Home</a></li>
                <li><a href="../historia">Historia</a></li>
                <li><a href="../mision">Misi&oacute;n</a></li>
                <li><a href="../buscador">Buscador de Escaleras</a></li>
                <li><a href="../blog">Blog</a></li>
                <li><a href="../contacto">Contacto</a></li>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-sm-6 col-md-3 col-xs-12 collapsed-block">
          <div class="footer-links">
            <h3 class="links-title">Horario de Atención<a class="expander visible-xs" href="#TabBlock-5">+</a></h3>
            <div class="tabBlock" id="TabBlock-5">
              <div class="footer-description">Nuestra tienda online funciona 24/7.<br>Horario Sala de Ventas:</div>
              <div class="footer-description"><?php echo $row_metaDatos["horario"]; ?></div>
              <div class="payment">
                <ul>
                  <li><a href="https://www.webpay.cl/portalpagodirecto/pages/institucion.jsf?idEstablecimiento=57813066" target="_blank"><img title="Transbank" alt="Transbank" src="../images/webpay-footer.png"></a></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="footer-coppyright">
      <div class="container">
        <div class="row">
          <div class="col-sm-6 col-xs-12 coppyright"> Copyright © <?php echo date ("Y"); ?> <a href="../"> PRODALUM </a>. Todos los derechos reservados. </div>
          <div class="col-sm-6 col-xs-12">
            <!-- <ul class="footer-company-links">
              <li> <a href="about_us.html">About ShopMart</a> </li>
              <li> <a href="#">Careers</a> </li>
              <li> <a href="#">Privacy Policy</a> </li>
            </ul> -->
          </div>
        </div>
      </div>
    </div>
  </footer>
  <a href="#" id="back-to-top" title="Subir"><i class="fa fa-angle-up"></i></a> </div>
<!-- END footer -->
<!-- js --> 
<script type="text/javascript" src="../js/jquery.min.js"></script> 
<script type="text/javascript" src="../js/bootstrap.min.js"></script> 
<script type="text/javascript" src="../js/owl.carousel.min.js"></script> 
<script type="text/javascript" src="../js/jquery.bxslider.js"></script> 
<script type="text/javascript" src="../js/mobile-menu.js"></script> 
<script type="text/javascript" src="../js/jquery-ui.js"></script> 
<script type="text/javascript" src="../js/main.js"></script>
<script type="text/javascript" src="../js/whatsapp/floating-wpp.js"></script>
<script type="text/javascript">
	$(function () {
		$('#whatsApp').floatingWhatsApp({
			phone: '56966569288',
			popupMessage: 'Hola, ¿cómo podemos ayudarte?',
			message: "",
			position: 'right',
			showPopup: true,
			showOnIE: false,
			headerTitle: 'Escríbenos en WhatsApp',
			headerColor: 'green',
			backgroundColor: 'green',
			buttonImage: '<img src="../images/whatsapp/whatsapp.svg" />'
		});
	});
</script>
<!-- InstanceBeginEditable name="js" -->
<!-- Modal -->
<div class="modale" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-header">
      <h3>Cotizar <b>"<?php echo $row_productoSEO["nombre"]; ?>"</b> </h3>
      <a href="#" class="btn-close closemodale" aria-hidden="true">&times;</a>
    </div>
    <form method="POST" action="<?php echo $editFormAction; ?>" name="cotizarForm">
    <div class="modal-body">
      <div class="contact-form-box">
        <div class="form-selector" style="width: 20%; float: left;">
          <label>Cant. (*)</label>
          <input type="number" class="form-control input-sm" id="qty" name="qty" placeholder="Ingresa la Cantidad" min="1" value="1" required="required" />
        </div>
        <?php if ($row_tablaCotizador > 0) { ?>
        <div class="form-selector" style="width: 78%; float: right;">
          <label>Pelda&ntilde;os (*)</label>
          <select class="form-control input-sm" id="modelo" name="modelo" placeholder="Selecciona el modelo a cotizar" required="required" >
            <option selected disabled>-- Selecciona los pelda&ntilde;os que necesitas --</option>
			<?php do { ?>
            <option value="<?php echo $row_tablaCotizador["modelo"]; ?>"><?php echo $row_tablaCotizador["modelo"]." (".$row_tablaCotizador["peldanos"]." Pelda&ntilde;os)"; ?></option>
            <?php } while ($row_tablaCotizador = mysqli_fetch_assoc($tablaCotizador)); ?>
          </select>
        </div>
        <?php } ?>
        <?php if ($row_tablaCotizadorShowerDoors > 0) { ?>
        <div class="form-selector" style="width: 78%; float: right;">
          <label>Modelo (*)</label>
          <select class="form-control input-sm" id="modelo" name="modelo" placeholder="Selecciona el modelo a cotizar" required="required" >
            <?php do { ?>
            <option value="<?php echo $row_tablaCotizadorShowerDoors["tipo"]; ?>"><?php echo $row_tablaCotizadorShowerDoors["titulo"]; ?></option>
            <?php } while ($row_tablaCotizadorShowerDoors = mysqli_fetch_assoc($tablaCotizadorShowerDoors)); ?>
          </select>
        </div>
        <?php } ?>
        <div class="form-selector">
          <label>Nombre (*)</label>
          <input type="text" class="form-control input-sm" id="name" name="nombre" placeholder="Ingresa tu Nombre" required="required" />
        </div>
        <div class="form-selector">
          <label>Correo (*)</label>
          <input type="email" class="form-control input-sm" id="email" name="correo" placeholder="Ingresa tu correo electr&oacute;nico" required="required" />
        </div>
        <div class="form-selector">
          <label>Tel&eacute;fono</label>
          <input type="tel" class="form-control input-sm" id="phone" name="telefono" placeholder="Si quieres, ingresa tu tel&eacute;fono" required="required" />
        </div>
       <?php if ($categoriaSEO == 'escalas') { ?>
        <div class="form-selector">
          <label>Informaci&oacute;n Adicional</label>
          <textarea class="form-control input-sm" rows="10" id="message" name="mensaje" style="height:100px;" placeholder="Si es necesario ingresa aqu&iacute; informaci&oacute;n importante o adicional."></textarea>
        </div>
        <?php } ?>
       <?php if ($categoriaSEO == 'shower-door') { ?>
        <div class="form-selector">
          <label>Informaci&oacute;n Importante</label>
          <textarea class="form-control input-sm" rows="10" id="message" name="mensaje" style="height:100px;" placeholder="Ingresa las medidas aproximadas del Shower Door que buscas." required="required" ></textarea>
        </div>
        <?php } ?>
      </div>
    </div>
    <div class="modal-footer">
      <?php if ($row_tablaCotizador > 0) { ?><input type="hidden" name="modelo" value="Modelo &Uacute;nico"><?php } ?>
      <input type="hidden" name="producto" value="<?php echo $row_productoSEO["nombre"]; ?>">
      <input type="hidden" name="productoSEO" value="<?php echo $row_productoSEO["nombreSEO"]; ?>">
      <input type="hidden" name="productoCategoria" value="<?php echo $row_productoSEO["categoriaSEO"]; ?>">
      <?php if ($categoriaSEO == 'escalas') { ?>
      <input type="hidden" name="productoSubCategoria" value="<?php echo $row_productoSEO["subCategoriaSEO"]; ?>">
      <input type="hidden" name="productoFamilia" value="<?php echo $row_productoSEO["subCategoriaFamiliaSEO"]; ?>">
      <?php } ?>
      <?php if ($categoriaSEO == 'shower-door') { ?>
      <input type="hidden" name="productoSubCategoria" value="--">
      <input type="hidden" name="productoFamilia" value="--">
      <?php } ?>
      <input type="hidden" name="ip" value="<?php echo $ip; ?>">
      <input type="hidden" name="fecha" value="<?php echo $fecha; ?>">
      <input type="hidden" name="fechaID" value="<?php echo $fechaID; ?>">
      <input type="hidden" name="estado" value="1">
      <input type="hidden" name="aceptaTerminos" value="1">
      <input type="hidden" name="origen" value="<?php
		$tablet_browser = 0;
		$mobile_browser = 0;
		$body_class = 'desktop';
		 
		if (preg_match('/(tablet|ipad|playbook)|(android(?!.*(mobi|opera mini)))/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
			$tablet_browser++;
			$body_class = "tablet";
		}
		 
		if (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|android|iemobile)/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
			$mobile_browser++;
			$body_class = "mobile";
		}
		 
		if ((strpos(strtolower($_SERVER['HTTP_ACCEPT']),'application/vnd.wap.xhtml+xml') > 0) or ((isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE'])))) {
			$mobile_browser++;
			$body_class = "mobile";
		}
		 
		$mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'], 0, 4));
		$mobile_agents = array(
			'w3c ','acs-','alav','alca','amoi','audi','avan','benq','bird','blac',
			'blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno',
			'ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-',
			'maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-',
			'newt','noki','palm','pana','pant','phil','play','port','prox',
			'qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar',
			'sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-',
			'tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp',
			'wapr','webc','winw','winw','xda ','xda-');
		 
		if (in_array($mobile_ua,$mobile_agents)) {
			$mobile_browser++;
		}
		 
		if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'opera mini') > 0) {
			$mobile_browser++;
			//Check for tablets on opera mini alternative headers
			$stock_ua = strtolower(isset($_SERVER['HTTP_X_OPERAMINI_PHONE_UA'])?$_SERVER['HTTP_X_OPERAMINI_PHONE_UA']:(isset($_SERVER['HTTP_DEVICE_STOCK_UA'])?$_SERVER['HTTP_DEVICE_STOCK_UA']:''));
			if (preg_match('/(tablet|ipad|playbook)|(android(?!.*mobile))/i', $stock_ua)) {
			  $tablet_browser++;
			}
		}
		if ($tablet_browser > 0) {
		// Si es tablet has lo que necesites
		   print 'tablet';
		}
		else if ($mobile_browser > 0) {
		// Si es dispositivo mobil has lo que necesites
		   print 'movil';
		}
		else {
		// Si es ordenador de escritorio has lo que necesites
		   print 'web';
		}  
	  ?>">
      <button type="submit" class="btn">Cotizar</button>
    </div>
    <input type="hidden" name="MM_insert" value="cotizarForm">
    </form>
  </div>
</div>
<!-- /Modal -->
<script>
$('.openmodale').click(function (e) {
         e.preventDefault();
         $('.modale').addClass('opened');
    });
$('.closemodale').click(function (e) {
         e.preventDefault();
         $('.modale').removeClass('opened');
    });
</script>
<script type="text/javascript" src="../js/cloud-zoom.js"></script> 
<script type="text/javascript" src="../js/jquery.flexslider.js"></script> 
<script type="text/javascript" src="../js/countdown.js"></script>
<!-- InstanceEndEditable -->
</body>
<!-- InstanceEnd --></html>