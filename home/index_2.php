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

//Variables Globales
$fecha = date('Y-m-d H:i:s');
$fechaID = strtotime($fecha);
$ip = $_SERVER["REMOTE_ADDR"];
$pagina = "home";

$query_metaDatos = "SELECT * FROM metaDatos ORDER BY metaDatos.id DESC";
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

$query_homeSlider = "SELECT * FROM homeSlider WHERE homeSlider.estado = '1' ORDER BY homeSlider.id DESC";
$homeSlider = mysqli_query($DKKfront, $query_homeSlider);
$row_homeSlider = mysqli_fetch_assoc($homeSlider);
$totalRows_homeSlider = mysqli_num_rows($homeSlider);

$query_homeBanner = "SELECT * FROM banners WHERE banners.estado = '1' ORDER BY banners.id DESC";
$homeBanner = mysqli_query($DKKfront, $query_homeBanner);
$row_homeBanner = mysqli_fetch_assoc($homeBanner);
$totalRows_homeBanner = mysqli_num_rows($homeBanner);

$query_homeProductos = "SELECT * FROM productos WHERE productos.estado = '1' AND RAND()<(SELECT ((20/COUNT(*))*150) FROM productos) ORDER BY RAND() LIMIT 20";
$homeProductos = mysqli_query($DKKfront, $query_homeProductos);
$row_homeProductos = mysqli_fetch_assoc($homeProductos);
$totalRows_homeProductos = mysqli_num_rows($homeProductos);

$query_homeMarcas = "SELECT * FROM clientes WHERE clientes.estado = '1' ORDER BY clientes.id DESC";
$homeMarcas = mysqli_query($DKKfront, $query_homeMarcas);
$row_homeMarcas = mysqli_fetch_assoc($homeMarcas);
$totalRows_homeMarcas = mysqli_num_rows($homeMarcas);

$query_homeTestimonios = "SELECT * FROM testimonios WHERE testimonios.estado = '1' ORDER BY testimonios.id DESC LIMIT 4";
$homeTestimonios = mysqli_query($DKKfront, $query_homeTestimonios);
$row_homeTestimonios = mysqli_fetch_assoc($homeTestimonios);
$totalRows_homeTestimonios = mysqli_num_rows($homeTestimonios);

$query_categoriaShower = "SELECT * FROM homeCategorias WHERE homeCategorias.id = '1'";
$categoriaShower = mysqli_query($DKKfront, $query_categoriaShower);
$row_categoriaShower = mysqli_fetch_assoc($categoriaShower);
$totalRows_categoriaShower = mysqli_num_rows($categoriaShower);

$query_categoriaVentanas = "SELECT * FROM homeCategorias WHERE homeCategorias.id = '2'";
$categoriaVentanas = mysqli_query($DKKfront, $query_categoriaVentanas);
$row_categoriaVentanas = mysqli_fetch_assoc($categoriaVentanas);
$totalRows_categoriaVentanas = mysqli_num_rows($categoriaVentanas);

$query_categoriaEspejos = "SELECT * FROM homeCategorias WHERE homeCategorias.id = '3'";
$categoriaEspejos = mysqli_query($DKKfront, $query_categoriaEspejos);
$row_categoriaEspejos = mysqli_fetch_assoc($categoriaEspejos);
$totalRows_categoriaEspejos = mysqli_num_rows($categoriaEspejos);

$query_categoriaEscalas = "SELECT * FROM homeCategorias WHERE homeCategorias.id = '4'";
$categoriaEscalas = mysqli_query($DKKfront, $query_categoriaEscalas);
$row_categoriaEscalas = mysqli_fetch_assoc($categoriaEscalas);
$totalRows_categoriaEscalas = mysqli_num_rows($categoriaEscalas);

$query_escalasAluminio = "SELECT * FROM productos WHERE productos.estado = '1' AND productos.subCategoriaSEO = 'aluminio' ORDER BY productos.id ASC LIMIT 8";
$escalasAluminio = mysqli_query($DKKfront, $query_escalasAluminio);
$row_escalasAluminio = mysqli_fetch_assoc($escalasAluminio);
$totalRows_escalasAluminio = mysqli_num_rows($escalasAluminio);

$query_escalasFibraDeVidrio = "SELECT * FROM productos WHERE productos.estado = '1' AND productos.subCategoriaSEO = 'fibra-de-vidrio' ORDER BY productos.id ASC LIMIT 8";
$escalasFibraDeVidrio = mysqli_query($DKKfront, $query_escalasFibraDeVidrio);
$row_escalasFibraDeVidrio = mysqli_fetch_assoc($escalasFibraDeVidrio);
$totalRows_escalasFibraDeVidrio = mysqli_num_rows($escalasFibraDeVidrio);

$query_escalasAcero = "SELECT * FROM productos WHERE productos.estado = '1' AND productos.subCategoriaSEO = 'acero' ORDER BY productos.id ASC LIMIT 8";
$escalasAcero = mysqli_query($DKKfront, $query_escalasAcero);
$row_escalasAcero = mysqli_fetch_assoc($escalasAcero);
$totalRows_escalasAcero = mysqli_num_rows($escalasAcero);

//registrar visita
  $updateSQL = sprintf("INSERT INTO visitas (pagina, ip, fechaID) VALUE ('$pagina', '$ip', '$fechaID')");
  $Result1 = mysqli_query($DKKfront, $updateSQL) or die(mysqli_error($DKKfront));
?>
<!DOCTYPE html>
<html lang="es"><!-- InstanceBegin template="/Templates/ppalFront.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta charset="utf-8">
<!--[if IE]>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<![endif]-->
<meta http-equiv="x-ua-compatible" content="ie=edge">
<!-- InstanceBeginEditable name="doctitle" -->
<title><?php echo $row_metaDatos["titulo"]; ?></title>
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
<?php if ($row_metaDatos["popup"] == '1') { ?>
<style>
#modalOverlay {
	position: fixed;
	top: 0;
	left: 0;
	background: rgba(0, 0, 0, .5);
	z-index: 99999;
	height: 100%;
	width: 100%;
	}
.modalPopup {
	position: absolute;
	top: 50%;
	left: 50%;
	transform: translate(-50%, -50%);
	background: #fff;
	width: 70%;
	padding: 0 0 30px;
	-webkit-box-shadow: 0 2px 10px 3px rgba(0,0,0,.2);
	-moz-box-shadow: 0 2px 10px 3px rgba(0,0,0,.2);
	box-shadow: 0 2px 10px 3px rgba(0,0,0,.2);
	}
.modalContent {
	padding: 0 2em;
	}
.modalContent img {
	margin-top: 10px;
	}
.headerBar {
	width: 100%;
	background: rgba(0,0,0,1);
	margin: 0;
	text-align: center;
	}
.headerBar img {
	margin: 1em .7em;
	}
.buttonStyle {
	margin-top: 10px;
	border: transparent;
	border-radius: 0;
	background: #6d6d6d;
	color: #eee !important;
	cursor: pointer;
	font-weight: bold;
	font-size: 14px;
	text-transform: uppercase;
	padding: 6px 25px;
	text-decoration: none;
	background: -moz-linear-gradient(top, #6d6d6d 0%, #1e1e1e 100%);
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#6d6d6d), color-stop(100%,#1e1e1e));
	background: -webkit-linear-gradient(top, #6d6d6d 0%,#1e1e1e 100%);
	background: -o-linear-gradient(top, #6d6d6d 0%,#1e1e1e 100%);
	background: -ms-linear-gradient(top, #6d6d6d 0%,#1e1e1e 100%);
	background: linear-gradient(to bottom, #6d6d6d 0%,#1e1e1e 100%);
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#6d6d6d', endColorstr='#1e1e1e',GradientType=0 );
	/*	-webkit-box-shadow: 0 2px 4px 0 #999;
		box-shadow: 0 2px 4px 0 #999; */
		-webkit-transition: all 1s ease;
		-moz-transition: all 1s ease;
		-ms-transition: all 1s ease;
		-o-transition: all 1s ease;
		transition: all 1s ease;
	}
.buttonStyle:hover {
	background: #1e1e1e;
	color: #fff;
	background: -moz-linear-gradient(top, #1e1e1e 0%, #6d6d6d 100%, #6d6d6d 100%);
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#1e1e1e), color-stop(100%,#6d6d6d), color-stop(100%,#6d6d6d));
	background: -webkit-linear-gradient(top, #1e1e1e 0%,#6d6d6d 100%,#6d6d6d 100%);
	background: -o-linear-gradient(top, #1e1e1e 0%,#6d6d6d 100%,#6d6d6d 100%);
	background: -ms-linear-gradient(top, #1e1e1e 0%,#6d6d6d 100%,#6d6d6d 100%);
	background: linear-gradient(to bottom, #1e1e1e 0%,#6d6d6d 100%,#6d6d6d 100%);
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#1e1e1e', endColorstr='#6d6d6d',GradientType=0 );
	}
.returnToProfile {
	text-align: center; 
	margin:3em;
	}
.returnToProfile a, .returnToProfile a:visited {
	color: #ddd;
	}
.returnToProfile a:hover {
	color: #fff;
	}
</style>
<?php } ?>
<!--<script type="text/javascript">
if (screen.width<500) {
window.location="http://mobile.prodalum.cl/home";
}
</script>-->
<!-- InstanceEndEditable -->
</head>

<body class="cms-index-index cms-home-page">
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
  <!-- slider  -->
  <div class="main-slider" id="home">
    <div class="container">
      <div class="row">
        <div class="col-md-3 col-sm-3 col-xs-12 banner-left hidden-xs"><img src="../images/banner-left.jpg" alt="banner"></div>
        <div class="col-sm-9 col-md-9 col-lg-9 col-xs-12 jtv-slideshow">
          <div id="jtv-slideshow">
            <div id='rev_slider_4_wrapper' class='rev_slider_wrapper fullwidthbanner-container' >
              <div id='rev_slider_4' class='rev_slider fullwidthabanner'>
                <ul>
                <?php do { ?>
                  
                  <?php if ($row_homeSlider["tipo"] == '3') { ?>
                  <li data-transition='fade' data-slotamount='7' data-masterspeed='1000' data-thumb=''><img src='../images/slider/<?php echo $row_homeSlider["imagen"]; ?>' data-bgposition='left top' data-bgfit='cover' data-bgrepeat='no-repeat' alt="<?php echo $row_homeSlider["titular"]." | ".$row_homeSlider["llamado"]." | ".$row_homeSlider["bajada"]; ?>"/>
                    <div class="caption-inner">
                      <div class='tp-caption LargeTitle sft  tp-resizeme' data-x='250'  data-y='110'  data-endspeed='500'  data-speed='500' data-start='1300' data-easing='Linear.easeNone' data-splitin='none' data-splitout='none' data-elementdelay='0.1' data-endelementdelay='0.1' style='z-index:3; white-space:nowrap;'><?php echo $row_homeSlider["llamado"]; ?></div>
                      <div class='tp-caption ExtraLargeTitle sft  tp-resizeme' data-x='200'  data-y='160'  data-endspeed='500'  data-speed='500' data-start='1100' data-easing='Linear.easeNone' data-splitin='none' data-splitout='none' data-elementdelay='0.1' data-endelementdelay='0.1' style='z-index:2; white-space:nowrap;'><?php echo $row_homeSlider["titular"]; ?></div>
                      <div class='tp-caption' data-x='310'  data-y='230'  data-endspeed='500'  data-speed='500' data-start='1100' data-easing='Linear.easeNone' data-splitin='none' data-splitout='none' data-elementdelay='0.1' data-endelementdelay='0.1' style='z-index:2; white-space:nowrap; color:#f8f8f8;'><?php echo $row_homeSlider["bajada"]; ?></div>
                      <div class='tp-caption sfb  tp-resizeme ' data-x='370'  data-y='280'  data-endspeed='500'  data-speed='500' data-start='1500' data-easing='Linear.easeNone' data-splitin='none' data-splitout='none' data-elementdelay='0.1' data-endelementdelay='0.1' style='z-index:4; white-space:nowrap;'><a href='<?php echo $row_homeSlider["link"]; ?>' class="buy-btn"><?php echo $row_homeSlider["boton"]; ?></a> </div>
                    </div>
                  </li>
                  <?php } ?>
                  <?php if ($row_homeSlider["tipo"] == '2') { ?>
                  <li data-transition='fade' data-slotamount='7' data-masterspeed='1000' data-thumb=''><img src='../images/slider/<?php echo $row_homeSlider["imagen"]; ?>' data-bgposition='left top' data-bgfit='cover' data-bgrepeat='no-repeat' alt="<?php echo $row_homeSlider["titular"]." | ".$row_homeSlider["llamado"]." | ".$row_homeSlider["bajada"]; ?>"/>
                    <div class="caption-inner left">
                      <div class='tp-caption LargeTitle sft  tp-resizeme' data-x='50'  data-y='110'  data-endspeed='500'  data-speed='500' data-start='1300' data-easing='Linear.easeNone' data-splitin='none' data-splitout='none' data-elementdelay='0.1' data-endelementdelay='0.1' style='z-index:3; white-space:nowrap;'><?php echo $row_homeSlider["llamado"]; ?></div>
                      <div class='tp-caption ExtraLargeTitle sft  tp-resizeme' data-x='50'  data-y='160'  data-endspeed='500'  data-speed='500' data-start='1100' data-easing='Linear.easeNone' data-splitin='none' data-splitout='none' data-elementdelay='0.1' data-endelementdelay='0.1' style='z-index:2; white-space:nowrap;'><?php echo $row_homeSlider["titular"]; ?></div>
                      <div class='tp-caption' data-x='72'  data-y='230'  data-endspeed='500'  data-speed='500' data-start='1100' data-easing='Linear.easeNone' data-splitin='none' data-splitout='none' data-elementdelay='0.1' data-endelementdelay='0.1' style='z-index:2; white-space:nowrap; color:#f8f8f8;'><?php echo $row_homeSlider["bajada"]; ?></div>
                      <div class='tp-caption sfb  tp-resizeme ' data-x='72'  data-y='280'  data-endspeed='500'  data-speed='500' data-start='1500' data-easing='Linear.easeNone' data-splitin='none' data-splitout='none' data-elementdelay='0.1' data-endelementdelay='0.1' style='z-index:4; white-space:nowrap;'><a href='<?php echo $row_homeSlider["link"]; ?>' class="buy-btn"><?php echo $row_homeSlider["boton"]; ?></a> </div>
                    </div>
                  </li>
                  <?php } ?>
                  <?php if ($row_homeSlider["tipo"] == '1') { ?>
                  <li data-transition='fade' data-slotamount='7' data-masterspeed='1000' data-thumb=''><img src='../images/slider/<?php echo $row_homeSlider["imagen"]; ?>' data-bgposition='left top' data-bgfit='cover' data-bgrepeat='no-repeat' alt="<?php echo $row_homeSlider["titular"]." | ".$row_homeSlider["llamado"]." | ".$row_homeSlider["llamado2"]." | ".$row_homeSlider["bajada"]; ?>"/>
                    <div class="caption-inner left">
                      <div class='tp-caption LargeTitle sft  tp-resizeme' data-x='350'  data-y='100'  data-endspeed='500'  data-speed='500' data-start='1300' data-easing='Linear.easeNone' data-splitin='none' data-splitout='none' data-elementdelay='0.1' data-endelementdelay='0.1' style='z-index:3; white-space:nowrap;'><?php echo $row_homeSlider["llamado"]; ?></div>
                      <div class='tp-caption ExtraLargeTitle sft  tp-resizeme' data-x='350'  data-y='140'  data-endspeed='500'  data-speed='500' data-start='1100' data-easing='Linear.easeNone' data-splitin='none' data-splitout='none' data-elementdelay='0.1' data-endelementdelay='0.1' style='z-index:2; white-space:nowrap;'><?php echo $row_homeSlider["titular"]; ?></div>
                      <div class='tp-caption ExtraLargeTitle sft  tp-resizeme' data-x='350'  data-y='185'  data-endspeed='500'  data-speed='500' data-start='1100' data-easing='Linear.easeNone' data-splitin='none' data-splitout='none' data-elementdelay='0.1' data-endelementdelay='0.1' style='z-index:2; white-space:nowrap;'><?php echo $row_homeSlider["titular2"]; ?></div>
                      <div class='tp-caption' data-x='375'  data-y='245'  data-endspeed='500'  data-speed='500' data-start='1100' data-easing='Linear.easeNone' data-splitin='none' data-splitout='none' data-elementdelay='0.1' data-endelementdelay='0.1' style='z-index:2; white-space:nowrap; color:#f8f8f8;'><?php echo $row_homeSlider["bajada"]; ?></div>
                      <div class='tp-caption sfb  tp-resizeme ' data-x='375'  data-y='290'  data-endspeed='500'  data-speed='500' data-start='1500' data-easing='Linear.easeNone' data-splitin='none' data-splitout='none' data-elementdelay='0.1' data-endelementdelay='0.1' style='z-index:4; white-space:nowrap;'><a href='<?php echo $row_homeSlider["link"]; ?>' class="buy-btn"><?php echo $row_homeSlider["boton"]; ?> </a> </div>
                    </div>
                  </li>
                  <?php } ?>
                  <?php } while ($row_homeSlider = mysqli_fetch_assoc($homeSlider)); ?>
                </ul>
                <div class="tp-bannertimer"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="inner-box">
    <div class="container">
      <hr>
      <div class="row"> 
        <!-- banner -->
        <div class="col-md-3 top-banner hidden-sm">
          <div class="jtv-banner3">
            <div class="jtv-banner3-inner"><a href="<?php echo $row_homeBanner["link"]; ?>" target="_blank"><img src="../images/<?php echo $row_homeBanner["imagen"]; ?>" alt="Visítanos"></a>
              <div class="hover_content">
                <div class="hover_data">
                  <div class="title"> <?php echo $row_homeBanner["titulo"]; ?> </div>
                  <div class="desc-text"><?php echo $row_homeBanner["llamado"]; ?></div>
                  <span><?php echo $row_homeBanner["bajada"]; ?></span>
                  <p><a href="<?php echo $row_homeBanner["link"]; ?>" class="shop-now" target="_blank"><?php echo $row_homeBanner["accion"]; ?></a></p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- productos -->
        <div class="col-sm-12 col-md-9 jtv-best-sale special-pro">
          
			<div class="home-tab">
			  <div class="tab-title text-left">
				<h2>Escalas</h2>
				<ul class="nav home-nav-tabs home-product-tabs">
				  <li class="active"><a href="#aluminio" data-toggle="tab" aria-expanded="false">Aluminio</a></li>
				  <li><a href="#fibra-de-vidrio" data-toggle="tab" aria-expanded="false">Fibra de Vidrio</a></li>
				  <li><a href="#acero" data-toggle="tab" aria-expanded="false">Acero</a></li>
				</ul>
			  </div>
			  <div id="productTabContent" class="tab-content">
				<div class="tab-pane active in" id="aluminio">
				  <div class="featured-pro">
					<div class="slider-items-products">
					  <div id="computer-slider" class="product-flexslider hidden-buttons">
						<div class="slider-items slider-width-col4">

						  <?php do { ?>
						  <div class="product-item">
							<div class="item-inner">
							  <div class="product-thumbnail">
								<?php if ($row_escalasAluminio["novedad"] == '1') { ?><div class="icon-new-label new-left">Nuevo</div><?php } ?>
								<div class="pr-img-area"> <a title="<?php echo $row_escalasAluminio["nombre"]; ?>" href="../productos/<?php echo $row_escalasAluminio["nombreSEO"]; ?>">
								  <figure> <img class="first-img" src="../images/productos/<?php echo $row_escalasAluminio["imagen1"]; ?>" alt="<?php echo $row_metaDatos["titulo"]." | ".$row_escalasAluminio["nombre"]; ?>"> <img class="hover-img" src="../images/productos/<?php echo $row_escalasAluminio["imagen1"]; ?>" alt="<?php echo $row_metaDatos["titulo"]." | ".$row_escalasAluminio["nombre"]; ?>"></figure>
								  </a> </div>
							  </div>
							  <div class="item-info">
								<div class="info-inner">
								  <div class="item-title"> <a title="<?php echo $row_escalasAluminio["nombre"]; ?>" href="../productos/<?php echo $row_escalasAluminio["nombreSEO"]; ?>"><?php echo $row_escalasAluminio["nombre"]; ?></a> </div>
								  <div class="item-content">
									<div class="pro-action">
									  <button type="button" class="add-to-cart" onClick="location.href='../productos/<?php echo $row_escalasAluminio["nombreSEO"]; ?>'"><span> Ver Producto</span> </button>
									</div>
								  </div>
								</div>
							  </div>
							</div>
						  </div>
						  <?php } while ($row_escalasAluminio = mysqli_fetch_assoc($escalasAluminio)); ?>

						</div>
					  </div>
					</div>
				  </div>
				</div>
				<div class="tab-pane" id="fibra-de-vidrio">
				  <div class="top-sellers-pro">
					<div class="slider-items-products">
					  <div id="smartphone-slider" class="product-flexslider hidden-buttons">
						<div class="slider-items slider-width-col4 ">

						  <?php do { ?>
						  <div class="product-item">
							<div class="item-inner">
							  <div class="product-thumbnail">
								<?php if ($row_escalasFibraDeVidrio["novedad"] == '1') { ?><div class="icon-new-label new-left">Nuevo</div><?php } ?>
								<div class="pr-img-area"> <a title="<?php echo $row_escalasFibraDeVidrio["nombre"]; ?>" href="../productos/<?php echo $row_escalasFibraDeVidrio["nombreSEO"]; ?>">
								  <figure> <img class="first-img" src="../images/productos/<?php echo $row_escalasFibraDeVidrio["imagen1"]; ?>" alt="<?php echo $row_metaDatos["titulo"]." | ".$row_escalasFibraDeVidrio["nombre"]; ?>"> <img class="hover-img" src="../images/productos/<?php echo $row_escalasFibraDeVidrio["imagen1"]; ?>" alt="<?php echo $row_metaDatos["titulo"]." | ".$row_escalasFibraDeVidrio["nombre"]; ?>"></figure>
								  </a> </div>
							  </div>
							  <div class="item-info">
								<div class="info-inner">
								  <div class="item-title"> <a title="<?php echo $row_escalasFibraDeVidrio["nombre"]; ?>" href="../productos/<?php echo $row_escalasFibraDeVidrio["nombreSEO"]; ?>"><?php echo $row_escalasFibraDeVidrio["nombre"]; ?></a> </div>
								  <div class="item-content">
									<div class="pro-action">
									  <button type="button" class="add-to-cart" onClick="location.href='../productos/<?php echo $row_escalasFibraDeVidrio["nombreSEO"]; ?>'"><span> Ver Producto</span> </button>
									</div>
								  </div>
								</div>
							  </div>
							</div>
						  </div>
						  <?php } while ($row_escalasFibraDeVidrio = mysqli_fetch_assoc($escalasFibraDeVidrio)); ?>

						</div>
					  </div>
					</div>
				  </div>
				</div>
				<div class="tab-pane" id="acero">
				  <div class="top-sellers-pro">
					<div class="slider-items-products">
					  <div id="watches-slider" class="product-flexslider hidden-buttons">
						<div class="slider-items slider-width-col4 ">

						  <?php do { ?>
						  <div class="product-item">
							<div class="item-inner">
							  <div class="product-thumbnail">
								<?php if ($row_escalasAcero["novedad"] == '1') { ?><div class="icon-new-label new-left">Nuevo</div><?php } ?>
								<div class="pr-img-area"> <a title="<?php echo $row_escalasAcero["nombre"]; ?>" href="../productos/<?php echo $row_escalasAcero["nombreSEO"]; ?>">
								  <figure> <img class="first-img" src="../images/productos/<?php echo $row_escalasAcero["imagen1"]; ?>" alt="<?php echo $row_metaDatos["titulo"]." | ".$row_escalasAcero["nombre"]; ?>"> <img class="hover-img" src="../images/productos/<?php echo $row_escalasAcero["imagen1"]; ?>" alt="<?php echo $row_metaDatos["titulo"]." | ".$row_escalasAcero["nombre"]; ?>"></figure>
								  </a> </div>
							  </div>
							  <div class="item-info">
								<div class="info-inner">
								  <div class="item-title"> <a title="<?php echo $row_escalasAcero["nombre"]; ?>" href="../productos/<?php echo $row_escalasAcero["nombreSEO"]; ?>"><?php echo $row_escalasAcero["nombre"]; ?></a> </div>
								  <div class="item-content">
									<div class="pro-action">
									  <button type="button" class="add-to-cart" onClick="location.href='../productos/<?php echo $row_escalasAcero["nombreSEO"]; ?>'"><span> Ver Producto</span> </button>
									</div>
								  </div>
								</div>
							  </div>
							</div>
						  </div>
						  <?php } while ($row_escalasAcero = mysqli_fetch_assoc($escalasAcero)); ?>

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
  <div class="container">
	<hr>
    <div class="jtv-best-sale-list">
      <div class="wpb_wrapper">
        <div class="best-title text-left">
          <h2>Nuestros Productos</h2>
        </div>
      </div>
      <div class="slider-items-products">
        <div id="jtv-best-sale-slider" class="product-flexslider">
          <div class="slider-items">
                  
            <?php if ($totalRows_homeProductos == '0') { ?>
            <p>Aún no hay productos que mostrar.</p>
			<?php } ?>
            <?php if ($totalRows_homeProductos >= '1') { ?>
			<?php do { ?>
            <div class="product-item">
              <div class="item-inner">
                <div class="product-thumbnail">
                  <?php if ($row_homeProductos["novedad"] == '1') { ?><div class="icon-new-label new-left">Nuevo</div><?php } ?>
                  <div class="pr-img-area"> <a title="<?php echo $row_homeProductos["nombre"]; ?>" href="../productos/<?php echo $row_homeProductos["nombreSEO"]; ?>">
                    <figure> <img class="first-img" src="../images/productos/<?php echo $row_homeProductos["imagen1"]; ?>" alt="<?php echo $row_metaDatos["titulo"]." | ".$row_homeProductos["nombre"]; ?>"> <img class="hover-img" src="../images/productos/<?php echo $row_homeProductos["imagen1"]; ?>" alt="<?php echo $row_metaDatos["titulo"]." | ".$row_homeProductos["nombre"]; ?>"></figure>
                    </a> </div>
                </div>
                <div class="item-info">
                  <div class="info-inner">
                    <div class="item-title"> <a title="<?php echo $row_homeProductos["nombre"]; ?>" href="../productos/<?php echo $row_homeProductos["nombreSEO"]; ?>"><?php echo $row_homeProductos["nombre"]; ?></a> </div>
                    <div class="item-content">
                      <div class="pro-action">
                        <button type="button" class="add-to-cart" onClick="location.href='../productos/<?php echo $row_homeProductos["nombreSEO"]; ?>'"><span> Ver Producto</span> </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <?php } while ($row_homeProductos = mysqli_fetch_assoc($homeProductos)); ?>
            <?php } ?>

          </div>
        </div>
      </div>
    </div>
	
  </div>
  
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
  <!-- categorías -->
  <section class="banner-area">
    <div class="container">
  	  <hr>
      <div class="row">
        <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
          <div class="row">
            <div class="col-xs-12 col-sm-6 col-lg-6 col-md-6">
              <div class="banner-block"> <a href="<?php echo $row_categoriaShower["link"]; ?>"> <img src="../images/<?php echo $row_categoriaShower["imagen"]; ?>" alt="<?php echo $row_categoriaShower["titulo"]; ?>"> </a>
                <div class="text-des-container">
                  <div class="text-des">
                    <h2><?php echo $row_categoriaShower["titulo"]; ?></h2>
                    <p><?php echo $row_categoriaShower["bajada"]; ?></p>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-lg-6 col-md-6">
              <div class="banner-block"> <a href="<?php echo $row_categoriaVentanas["link"]; ?>"> <img src="../images/<?php echo $row_categoriaVentanas["imagen"]; ?>" alt="<?php echo $row_categoriaVentanas["titulo"]; ?>"> </a>
                <div class="text-des-container">
                  <div class="text-des">
                    <h2><?php echo $row_categoriaVentanas["titulo"]; ?></h2>
                    <p><?php echo $row_categoriaVentanas["bajada"]; ?></p>
                  </div>
                </div>
              </div>
              <div class="banner-block"> <a href="<?php echo $row_categoriaEspejos["link"]; ?>"> <img src="../images/<?php echo $row_categoriaEspejos["imagen"]; ?>" alt="<?php echo $row_categoriaEspejos["titulo"]; ?>"> </a>
                <div class="text-des-container">
                  <div class="text-des">
                    <h2><?php echo $row_categoriaEspejos["titulo"]; ?></h2>
                    <p><?php echo $row_categoriaEspejos["bajada"]; ?></p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xs-12 col-sm-4 col-lg-4 col-md-4">
          <div class="banner-block"> <a href="<?php echo $row_categoriaEscalas["link"]; ?>"> <img src="../images/<?php echo $row_categoriaEscalas["imagen"]; ?>" alt="<?php echo $row_categoriaEscalas["titulo"]; ?>"> </a>
            <div class="text-des-container">
              <div class="text-des">
                <h2><?php echo $row_categoriaEscalas["titulo"]; ?></h2>
                <p><?php echo $row_categoriaEscalas["bajada"]; ?></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- categorías -->
  <?php if ($totalRows_homeMarcas > '0') { ?>
  <div class="container">
    <div class="row">
      <div class="col-md-12 col-xs-12">
        <div class="our-clients">
          <div class="slider-items-products">
            <div id="our-clients-slider" class="product-flexslider hidden-buttons">
              <div class="slider-items slider-width-col6">
              
                <?php do { ?>
                <div class="item"><a href="<?php echo $row_homeMarcas["link"]; ?>"><img src="../images/<?php echo $row_homeMarcas["logo"]; ?>" alt="<?php echo $row_homeMarcas["nombre"]; ?>"></a> </div>
                <?php } while ($row_homeMarcas = mysqli_fetch_assoc($homeMarcas)); ?>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php } ?>
  
  <div class="footer-newsletter">
    <div class="container">
      <div class="row"> 
        <?php if ($totalRows_homeTestimonios == '0') { ?>
        <!-- newsletter -->
        <div class="col-md-12 col-sm-12">
          <form action="<?php echo $editFormAction; ?>" id="newsletter-validate-detail" method="POST" name="homeSuscripcion">
            <h3>Suscríbete a nuestro newsletter</h3>
            <div class="title-divider"><span></span></div>
            <p class="sub-title text-center">Sorpréndete</p>
            <div class="newsletter-inner">
              <input class="newsletter-email" name='correo' placeholder='Ingresa tu correo'/>
              <button class="button subscribe" type="submit" title="Suscríbete">Suscríbete</button>
              <input type="hidden" name="ip" value="<?php echo $ip; ?>">
              <input type="hidden" name="fecha" value="<?php echo $fecha; ?>">
              <input type="hidden" name="fechaID" value="<?php echo $fechaID; ?>">
            </div>
            <input type="hidden" name="MM_insert" value="homeSuscripcion">
          </form>
          <?php
            if((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "homeSuscripcion")){
            $servername = "localhost";
            $username = "prodalum_admin";
            $password = "m3nd1gO5Ol4nO";
            $dbname = "prodalum_w3";
            
			// Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);
            // Check connection
            if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
            }
            
			$sql = "INSERT INTO suscritos (correo,ip,fecha,fechaID)
            VALUES ('".$_POST["correo"]."','".$_POST["ip"]."','".$_POST["fecha"]."','".$_POST["fechaID"]."')";
            
			if ($conn->query($sql) === TRUE) {
			echo "<script type= 'text/javascript'>alert('Te has suscrito con éxito.');</script>";
			} else {
			echo "<script type= 'text/javascript'>alert('Ups, hubo un error al suscribirte, inténtalo nuevamente. Error: " . $sql . "<br>" . $conn->error."');</script>";
			}
            }
          ?>
        </div>
        <?php } ?>
        
        <?php if ($totalRows_homeTestimonios > '0') { ?>
        <div class="col-md-6 col-sm-6">
          <form action="<?php echo $editFormAction; ?>" id="newsletter-validate-detail" method="POST" name="homeSuscripcion">
            <h3>Suscríbete a nuestro newsletter</h3>
            <div class="title-divider"><span></span></div>
            <p class="sub-title text-center">Sorpréndete</p>
            <div class="newsletter-inner">
              <input class="newsletter-email" name='correo' placeholder='Ingresa tu correo'/>
              <button class="button subscribe" type="submit" title="Suscríbete">Suscríbete</button>
              <input type="hidden" name="ip" value="<?php echo $ip; ?>">
              <input type="hidden" name="fecha" value="<?php echo $fecha; ?>">
              <input type="hidden" name="fechaID" value="<?php echo $fechaID; ?>">
            </div>
            <input type="hidden" name="MM_insert" value="homeSuscripcion">
          </form>
          <?php
            if((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "homeSuscripcion")){
            $servername = "localhost";
            $username = "prodalum_admin";
            $password = "m3nd1gO5Ol4nO";
            $dbname = "prodalum_w3";
            
			// Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);
            // Check connection
            if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
            }
            
			$sql = "INSERT INTO suscritos (correo,ip,fecha,fechaID)
            VALUES ('".$_POST["correo"]."','".$_POST["ip"]."','".$_POST["fecha"]."','".$_POST["fechaID"]."')";
            
			if ($conn->query($sql) === TRUE) {
			echo "<script type= 'text/javascript'>alert('Te has suscrito con éxito.');</script>";
			} else {
			echo "<script type= 'text/javascript'>alert('Ups, hubo un error al suscribirte, inténtalo nuevamente. Error: " . $sql . "<br>" . $conn->error."');</script>";
			}
            }
          ?>
        </div>
        <!-- nuestros clientes -->
        <div class="col-sm-6 col-xs-12 testimonials">
          <div class="page-header">
            <h2>¿Qué dicen nuestros clientes?</h2>
          </div>
          <div class="slider-items-products">
            <div id="testimonials-slider" class="product-flexslider hidden-buttons home-testimonials">
              <div class="slider-items slider-width-col4 ">
              
                <div class="holder">
                  <blockquote><?php echo $row_homeTestimonios["testimonio"]; ?></blockquote>
                  <div class="thumb"> <img src="../images/<?php echo $row_homeTestimonios["imagen"]; ?>" alt="<?php echo $row_homeTestimonios["nombre"]; ?>"> </div>
                  <div class="holder-info"> <strong class="name"><?php echo $row_homeTestimonios["nombre"]; ?></strong> <strong class="designation"><?php echo $row_homeTestimonios["cargo"]; ?></strong></div>
                </div>

              </div>
            </div>
          </div>
        </div>
        <?php } ?>
      </div>
    </div>
  </div>
  <!-- InstanceEndEditable -->
  <!-- END contenido -->
  
  <!-- footer -->
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
			phone: '56959454541',
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
<?php if ($row_metaDatos["popup"] == '1') { ?>
<!-- popup -->
<div id="modalOverlay">
	<div class="modalPopup">
		<div class="headerBar">
			<img src="../images/logo.png" alt="<?php echo $row_metaDatos["titulo"]; ?>">
		</div>
		<div class="modalContent" style="text-align: right;">
			<img src="../images/<?php echo $row_metaDatos["popupImagen"]; ?>" alt="<?php echo "Informaci&oacute;n Importante | ".$row_metaDatos["titulo"]; ?>" width="100%" height="auto">
			<br>
			<button id="button" class="buttonStyle">Cerrar Aviso</button>
		</div>
	</div>
</div>
<script>
	window.onload = function() {
	  document.getElementById('button').onclick = function() {
		document.getElementById('modalOverlay').style.display = 'none'
	  };
	};
</script>
<!-- END popup -->
<?php } ?>
<script type="text/javascript" src="../js/countdown.js"></script> 
<script type="text/javascript" src="../js/revolution-slider.js"></script> 
<script type='text/javascript'>
jQuery(document).ready(function(){
  jQuery('#rev_slider_4').show().revolution({
    dottedOverlay: 'none',
    delay: 5000,
    startwidth: 865,
	startheight: 450,

    hideThumbs: 200,
    thumbWidth: 200,
    thumbHeight: 50,
    thumbAmount: 2,

    navigationType: 'thumb',
    navigationArrows: 'solo',
    navigationStyle: 'round',

    touchenabled: 'on',
    onHoverStop: 'on',
                
	swipe_velocity: 0.7,
    swipe_min_touches: 1,
    swipe_max_touches: 1,
    drag_block_vertical: false,
            
    spinner: 'spinner0',
    keyboardNavigation: 'off',

    navigationHAlign: 'center',
    navigationVAlign: 'bottom',
    navigationHOffset: 0,
    navigationVOffset: 20,

    soloArrowLeftHalign: 'left',
    soloArrowLeftValign: 'center',
    soloArrowLeftHOffset: 20,
    soloArrowLeftVOffset: 0,

    soloArrowRightHalign: 'right',
    soloArrowRightValign: 'center',
    soloArrowRightHOffset: 20,
    soloArrowRightVOffset: 0,

    shadow: 0,
    fullWidth: 'on',
    fullScreen: 'off',

    stopLoop: 'off',
    stopAfterLoops: -1,
    stopAtSlide: -1,

    shuffle: 'off',

    autoHeight: 'off',
    forceFullWidth: 'on',
    fullScreenAlignForce: 'off',
    minFullScreenHeight: 0,
    hideNavDelayOnMobile: 1500,
            
    hideThumbsOnMobile: 'off',
    hideBulletsOnMobile: 'off',
    hideArrowsOnMobile: 'off',
    hideThumbsUnderResolution: 0,

    hideSliderAtLimit: 0,
    hideCaptionAtLimit: 0,
    hideAllCaptionAtLilmit: 0,
    startWithSlide: 0,
    fullScreenOffsetContainer: ''
  });
});
</script>
<!-- InstanceEndEditable -->
</body>
<!-- InstanceEnd --></html>