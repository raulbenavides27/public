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
$pagina = 'representantes';

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

$query_representantes = "SELECT * FROM representantes WHERE representantes.estado = '1' ORDER BY representantes.id ASC";
$representantes = mysqli_query($DKKfront, $query_representantes);
$row_representantes = mysqli_fetch_assoc($representantes);
$totalRows_representantes = mysqli_num_rows($representantes);

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
<title><?php echo $row_metaDatos["titulo"]." | Representantes"; ?></title>
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
window.location="http://mobile.prodalum.cl/home";
}
</script>-->
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
  <!--  titulo -->
  <section class="blog_post">
    <div class="container"> 
      
      <!-- Center colunm-->
      <div class="blog-wrapper">
        <div class="page-title">
          <h2>Representantes en Am&eacute;rica Latina</h2>
        </div>
        <ul class="blog-posts">
        
          <?php do { ?>
          <li class="post-item col-md-4">
           <div class="blog-box"> <a href="<?php echo $row_representantes["link"]; ?>" target="_blank"> <img class="primary-img" src="../images/representantes/<?php echo $row_representantes["imagen"]; ?>" alt="<?php echo $row_representantes["nombre"]; ?>"></a>
                <div class="blog-btm-desc">
                  <div class="blog-top-desc">
                    <h4><a href="<?php echo $row_representantes["link"]; ?>" target="_blank"><?php echo $row_representantes["nombre"]; ?></a></h4>
                    <div class="jtv-entry-meta"> <i class="fa fa-flag"></i> <strong><?php echo strtoupper($row_representantes["pais"]); ?></strong></div>
                  </div>
                  <p><i class="fa fa-map-marker"></i> <?php echo $row_representantes["direccion"]; ?></p><br>
                  <?php if (isset($row_representantes["telefono"])) { ?><p><i class="fa fa-phone"></i> <?php echo $row_representantes["telefono"]; ?></p><br><?php } ?>
                  <?php if (isset($row_representantes["link"])) { ?><a class="read-more" href="<?php echo $row_representantes["link"]; ?>" target="_blank"> Ir a la Web</a><?php } ?> </div>
              </div>
          </li>
          <?php } while ($row_representantes = mysqli_fetch_assoc($representantes)); ?>

        </ul>
      </div>
      
    </div>
  </section>
  <!-- END contenido -->
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
<!-- InstanceBeginEditable name="js" --> <!-- InstanceEndEditable -->
</body>
<!-- InstanceEnd --></html>