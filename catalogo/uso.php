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

$currentPage = $_SERVER["PHP_SELF"];

//Variables Globales
$fecha = date('Y-m-d H:i:s');
$fechaID = strtotime($fecha);
$ip = $_SERVER["REMOTE_ADDR"];
$categoria = $_GET["categoria"];
$uso = $_GET["uso"];
$pagina = 'uso/'.$uso.

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

$query_familiasEscalas = "SELECT * FROM menuSubCategorias WHERE menuSubCategorias.estado = '1' ORDER BY menuSubCategorias.id ASC";
$familiasEscalas = mysqli_query($DKKfront, $query_familiasEscalas);
$row_familiasEscalas = mysqli_fetch_assoc($familiasEscalas);
$totalRows_familiasEscalas = mysqli_num_rows($familiasEscalas);

$query_productosRecomendados = "SELECT * FROM productos WHERE productos.estado = '1' AND productos.recomendado = '1' ORDER BY productos.id ASC LIMIT 3";
$productosRecomendados = mysqli_query($DKKfront, $query_productosRecomendados);
$row_productosRecomendados = mysqli_fetch_assoc($productosRecomendados);
$totalRows_productosRecomendados = mysqli_num_rows($productosRecomendados);

$query_escalasCapMax = "SELECT * FROM escalasCapMax WHERE escalasCapMax.estado = '1' ORDER BY escalasCapMax.id ASC";
$escalasCapMax = mysqli_query($DKKfront, $query_escalasCapMax);
$row_escalasCapMax = mysqli_fetch_assoc($escalasCapMax);
$totalRows_escalasCapMax = mysqli_num_rows($escalasCapMax);

$query_escalasEtiquetas = "SELECT * FROM escalasEtiquetas WHERE escalasEtiquetas.estado = '1' ORDER BY escalasEtiquetas.id ASC";
$escalasEtiquetas = mysqli_query($DKKfront, $query_escalasEtiquetas);
$row_escalasEtiquetas = mysqli_fetch_assoc($escalasEtiquetas);
$totalRows_escalasEtiquetas = mysqli_num_rows($escalasEtiquetas);

$query_escalasUsos = "SELECT * FROM escalasUsos WHERE escalasUsos.estado = '1' ORDER BY escalasUsos.id ASC";
$escalasUsos = mysqli_query($DKKfront, $query_escalasUsos);
$row_escalasUsos = mysqli_fetch_assoc($escalasUsos);
$totalRows_escalasUsos = mysqli_num_rows($escalasUsos);

$query_categoriaSelect = sprintf("SELECT * FROM menuCategorias WHERE menuCategorias.categoriaSEO = '$categoria'");
$categoriaSelect = mysqli_query($DKKfront, $query_categoriaSelect);
$row_categoriaSelect = mysqli_fetch_assoc($categoriaSelect);
$totalRows_categoriaSelect = mysqli_num_rows($categoriaSelect);

$query_valorSelect = sprintf("SELECT * FROM escalasUsos WHERE escalasUsos.usoSEO = '$uso'");
$valorSelect = mysqli_query($DKKfront, $query_valorSelect);
$row_valorSelect = mysqli_fetch_assoc($valorSelect);
$totalRows_valorSelect = mysqli_num_rows($valorSelect);

$maxRows_productosShow = 15;
$pageNum_productosShow = 0;
if (isset($_GET['pageNum_productosShow'])) {
  $pageNum_productosShow = $_GET['pageNum_productosShow'];
}
$startRow_productosShow = $pageNum_productosShow * $maxRows_productosShow;

$query_productosShow = "SELECT * FROM productos WHERE productos.estado = '1' AND productos.categoriaSEO = 'escalas' AND productos.uso = '$uso' ORDER BY productos.id ASC";
$query_limit_productosShow = sprintf("%s LIMIT %d, %d", $query_productosShow, $startRow_productosShow, $maxRows_productosShow);
$productosShow = mysqli_query($DKKfront, $query_limit_productosShow);
$row_productosShow = mysqli_fetch_assoc($productosShow);

if (isset($_GET['totalRows_productosShow'])) {
  $totalRows_productosShow = $_GET['totalRows_productosShow'];
} else {
  $all_productosShow = mysqli_query($DKKfront, $query_productosShow);
  $totalRows_productosShow = mysqli_num_rows($all_productosShow);
}
$totalPages_productosShow = ceil($totalRows_productosShow/$maxRows_productosShow)-1;

$query_categoriasSide = "SELECT * FROM menuCategorias WHERE menuCategorias.estado = '1' AND NOT menuCategorias.categoriaSEO = '$categoria' ORDER BY menuCategorias.id ASC";
$categoriasSide = mysqli_query($DKKfront, $query_categoriasSide);
$row_categoriasSide = mysqli_fetch_assoc($categoriasSide);
$totalRows_categoriasSide = mysqli_num_rows($categoriasSide);

$query_banner = "SELECT * FROM banners WHERE RAND()<(SELECT ((1/COUNT(*))*12) FROM banners) AND banners.estado = '1' AND banners.tipo = '1' ORDER BY RAND() LIMIT 1";
$banner = mysqli_query($DKKfront, $query_banner);
$row_banner = mysqli_fetch_assoc($banner);
$totalRows_banner = mysqli_num_rows($banner);

$queryString_productosShow = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_productosShow") == false && 
        stristr($param, "totalRows_productosShow") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_productosShow = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_productosShow = sprintf("&totalRows_productosShow=%d%s", $totalRows_productosShow, $queryString_productosShow);

//registrar visita
  $updateSQL = sprintf("INSERT INTO visitas (pagina, ip, fechaID) VALUE ('$pagina', '$ip', '$fechaID')");
  $Result1 = mysqli_query($DKKfront, $updateSQL) or die(mysqli_error($DKKfront));
?>
<!DOCTYPE html>
<html lang="es"><!-- InstanceBegin template="/Templates/ppalFrontCatalogo.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta charset="utf-8">
<!--[if IE]>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<![endif]-->
<meta http-equiv="x-ua-compatible" content="ie=edge">
<!-- InstanceBeginEditable name="doctitle" -->
<title><?php echo $row_metaDatos["titulo"]." | ".$row_categoriaSelect["categoria"]." | Uso ".$row_valorSelect["uso"]; ?></title>
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
<!--<script type="text/javascript">
if (screen.width<500) {
window.location="http://mobile.prodalum.cl/home/#!/../catalogo/categoria.php?categoria=escalas";
}
</script>-->
<!-- InstanceEndEditable -->
</head>

<body class="shop_grid_page">
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
  <div class="breadcrumbs">
    <div class="container">
      <div class="row">
        <div class="col-xs-12">
          <ul>
            <li class="home"> <a title="Ir al Home" href="../">Home</a><span>&raquo;</span></li>
            <li class=""> <a title="Ir al Catálogo" href="../catalogo">Cat&aacute;logo</a><span>&raquo;</span></li>
            <li class=""> <a title="Ir a la Categoría" href="../categoria/<?php echo $row_categoriaSelect["categoriaSEO"]; ?>"><?php echo $row_categoriaSelect["categoria"]; ?></a><span>&raquo;</span></li>
            <li><strong><?php echo "Uso ".$row_valorSelect["uso"]; ?></strong></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <!-- END titulo --> 
  <!-- contenido -->
  <div class="main-container col2-left-layout">
    <div class="container">
      <div class="row">
        <div class="col-main col-sm-9 col-xs-12 col-sm-push-3">
          <?php if ($row_categoriaSelect["categoriaSEO"] != 'shower-door') { ?>
          <div class="shop-inner">
            <div class="page-title">
              <h2><?php echo $row_categoriaSelect["categoria"]; ?> / Uso <?php echo $row_valorSelect["uso"]; ?></h2>
            </div>
            <div class="toolbar">
              <!-- <div class="view-mode">
                <ul>
                  <li class="active"> <a href="../catalogo/"> <i class="fa fa-th-large"></i> </a> </li>
                  <li> <a href="../catalogo/lista.php"> <i class="fa fa-th-list"></i> </a> </li>
                </ul>
              </div> -->
            </div>
            <div class="product-grid-area">
              <ul class="products-grid">
                <?php if ($totalRows_productosShow == 0) { ?>
                <li class="col-lg-12">
                  <p>Aqu&iacute; no hay productos que mostrar.</p>
                </li>
	            <?php } ?>
		        <?php } //Header diferente a shower door?>

          <?php if ($row_categoriaSelect["categoriaSEO"] == 'shower-door') { ?>
          <div class="shop-inner">
            <div class="page-title">
              <h2><?php echo $row_categoriaSelect["categoria"]; ?></h2>
            </div>
            <div class="toolbar">
              <!-- <div class="view-mode">
                <ul>
                  <li class="active"> <a href="../catalogo/"> <i class="fa fa-th-large"></i> </a> </li>
                  <li> <a href="../catalogo/lista.php"> <i class="fa fa-th-list"></i> </a> </li>
                </ul>
              </div> -->
            </div>
            <div class="product-grid-area">
              <ul class="products-grid">
		        <?php } //Header de shower door ?>
                
                <?php if ($row_categoriaSelect["categoriaSEO"] == 'escalas') { ?>
				<?php if ($totalRows_productosShow > 0) { ?>
				<?php do { ?>
                  <li class="item col-lg-4 col-md-4 col-sm-6 col-xs-6 ">
                    <div class="product-item">
                      <div class="item-inner">
                        <div class="product-thumbnail">
                          <?php if (isset($row_productosShow["precioOferta"])) { ?><div class="icon-sale-label sale-left">Oferta</div><?php } ?>
                          <?php if ($row_productosShow["novedad"] == '1') { ?><div class="icon-new-label new-right">Nuevo</div><?php } ?>
                          <div class="pr-img-area"> <a title="<?php echo $row_productosShow["nombre"]; ?>" href="../productos/<?php echo $row_productosShow["nombreSEO"]; ?>">
                            <figure> <img class="first-img" src="../images/productos/<?php echo $row_productosShow["imagen1"]; ?>" alt="<?php echo $row_productosShow["nombre"]; ?>"> <img class="hover-img" src="../images/productos/<?php echo $row_productosShow["imagen1"]; ?>" alt="<?php echo $row_productosShow["nombre"]; ?>"></figure>
                            </a> </div>
                        </div>
                        <div class="item-info">
                          <div class="info-inner">
                            <div class="item-title"> <a title="<?php echo $row_productosShow["nombre"]; ?>" href="../productos/<?php echo $row_productosShow["nombreSEO"]; ?>"><?php echo $row_productosShow["nombre"]; ?> </a> </div>
                            <div class="item-content">
				              <?php if (isset($row_productosShow["precio"])) { ?>
                              <div class="item-price">
				                <?php if (isset($row_productosShow["precioOferta"])) { ?>
                                <div class="price-box">
				                  <p class="special-price"> <span class="price-label">Precio Oferta</span> <span class="price"> <?php echo "$".number_format(0,$row_productosShow["precioOferta"],",","."); ?> </span> </p>
				                  <p class="old-price"> <span class="price-label">Precio Normal</span> <span class="price"> <?php echo "$".number_format(0,$row_productosShow["precio"],",","."); ?> </span> </p>
			                    </div>
                                <?php } ?>
				                <?php if (empty($row_productosShow["precioOferta"])) { ?>
                                <div class="price-box">
				                  <p class="special-price"> <span class="price-label">Precio</span> <span class="price"> <?php echo "$".number_format(0,$row_productosShow["precio"],",","."); ?> </span> </p>
			                    </div>
                                <?php } ?>
			                  </div>
                              <?php } ?>
                              <div class="pro-action">
                                <button type="button" class="add-to-cart" onClick="location.href='../productos/<?php echo $row_productosShow["nombreSEO"]; ?>'"><span> Ver Producto</span> </button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </li>
                <?php } while ($row_productosShow = mysqli_fetch_assoc($productosShow)); ?>
                <?php } ?>
                <?php } // Categoría Escalas ?>

                <?php if ($row_categoriaSelect["categoriaSEO"] == 'ventanas') { ?>
				<?php if ($totalRows_productosShow > 0) { ?>
				<?php do { ?>
                  <li class="item col-lg-4 col-md-4 col-sm-6 col-xs-6 ">
                    <div class="product-item">
                      <div class="item-inner">
                        <div class="product-thumbnail">
                          <?php if (isset($row_productosShow["precioOferta"])) { ?><div class="icon-sale-label sale-left">Oferta</div><?php } ?>
                          <?php if ($row_productosShow["novedad"] == '1') { ?><div class="icon-new-label new-right">Nuevo</div><?php } ?>
                          <div class="pr-img-area"> <a title="<?php echo $row_productosShow["nombre"]; ?>" href="../productos/<?php echo $row_productosShow["nombreSEO"]; ?>">
                            <figure> <img class="first-img" src="../images/productos/<?php echo $row_productosShow["imagen1"]; ?>" alt="<?php echo $row_productosShow["nombre"]; ?>"> <img class="hover-img" src="../images/productos/<?php echo $row_productosShow["imagen1"]; ?>" alt="<?php echo $row_productosShow["nombre"]; ?>"></figure>
                            </a> </div>
                        </div>
                        <div class="item-info">
                          <div class="info-inner">
                            <div class="item-title"> <a title="<?php echo $row_productosShow["nombre"]; ?>" href="../productos/<?php echo $row_productosShow["nombreSEO"]; ?>"><?php echo $row_productosShow["nombre"]; ?> </a> </div>
                            <div class="item-content">
				              <?php if (isset($row_productosShow["precio"])) { ?>
                              <div class="item-price">
				                <?php if (isset($row_productosShow["precioOferta"])) { ?>
                                <div class="price-box">
				                  <p class="special-price"> <span class="price-label">Precio Oferta</span> <span class="price"> <?php echo "$".number_format(0,$row_productosShow["precioOferta"],",","."); ?> </span> </p>
				                  <p class="old-price"> <span class="price-label">Precio Normal</span> <span class="price"> <?php echo "$".number_format(0,$row_productosShow["precio"],",","."); ?> </span> </p>
			                    </div>
                                <?php } ?>
				                <?php if (empty($row_productosShow["precioOferta"])) { ?>
                                <div class="price-box">
				                  <p class="special-price"> <span class="price-label">Precio</span> <span class="price"> <?php echo "$".number_format(0,$row_productosShow["precio"],",","."); ?> </span> </p>
			                    </div>
                                <?php } ?>
			                  </div>
                              <?php } ?>
                              <div class="pro-action">
                                <button type="button" class="add-to-cart" onClick="location.href='../productos/<?php echo $row_productosShow["nombreSEO"]; ?>'"><span> Ver Producto</span> </button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </li>
                <?php } while ($row_productosShow = mysqli_fetch_assoc($productosShow)); ?>
                <?php } ?>
                <?php } //Categoría Ventanas ?>

                <?php if ($row_categoriaSelect["categoriaSEO"] == 'espejos') { ?>
				<?php if ($totalRows_productosShow > 0) { ?>
				<?php do { ?>
                  <li class="item col-lg-3 col-md-3 col-sm-6 col-xs-6 ">
                    <div class="product-item">
                      <div class="item-inner">
                        <div class="product-thumbnail">
                          <?php if (isset($row_productosShow["precioOferta"])) { ?><div class="icon-sale-label sale-left">Oferta</div><?php } ?>
                          <?php if ($row_productosShow["novedad"] == '1') { ?><div class="icon-new-label new-right">Nuevo</div><?php } ?>
                          <div class="pr-img-area"> <a title="<?php echo $row_productosShow["nombre"]; ?>" href="../productos/<?php echo $row_productosShow["nombreSEO"]; ?>">
                            <figure> <img class="first-img" src="../images/productos/<?php echo $row_productosShow["imagen1"]; ?>" alt="<?php echo $row_productosShow["nombre"]; ?>"> <img class="hover-img" src="../images/productos/<?php echo $row_productosShow["imagen1"]; ?>" alt="<?php echo $row_productosShow["nombre"]; ?>"></figure>
                            </a> </div>
                        </div>
                        <div class="item-info">
                          <div class="info-inner">
                            <div class="item-title"> <a title="<?php echo $row_productosShow["nombre"]; ?>" href="../productos/<?php echo $row_productosShow["nombreSEO"]; ?>"><?php echo $row_productosShow["nombre"]; ?> </a> </div>
                            <div class="item-content">
				              <?php if (isset($row_productosShow["precio"])) { ?>
                              <div class="item-price">
				                <?php if (isset($row_productosShow["precioOferta"])) { ?>
                                <div class="price-box">
				                  <p class="special-price"> <span class="price-label">Precio Oferta</span> <span class="price"> <?php echo "$".number_format(0,$row_productosShow["precioOferta"],",","."); ?> </span> </p>
				                  <p class="old-price"> <span class="price-label">Precio Normal</span> <span class="price"> <?php echo "$".number_format(0,$row_productosShow["precio"],",","."); ?> </span> </p>
			                    </div>
                                <?php } ?>
				                <?php if (empty($row_productosShow["precioOferta"])) { ?>
                                <div class="price-box">
				                  <p class="special-price"> <span class="price-label">Precio</span> <span class="price"> <?php echo "$".number_format(0,$row_productosShow["precio"],",","."); ?> </span> </p>
			                    </div>
                                <?php } ?>
			                  </div>
                              <?php } ?>
                              <div class="pro-action">
                                <button type="button" class="add-to-cart" onClick="location.href='../productos/<?php echo $row_productosShow["nombreSEO"]; ?>'"><span> Ver Producto</span> </button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </li>
                <?php } while ($row_productosShow = mysqli_fetch_assoc($productosShow)); ?>
                <?php } ?>
                <?php } //Categoría Espejos ?>

                <?php if ($row_categoriaSelect["categoriaSEO"] == 'accesorios') { ?>
				<?php if ($totalRows_productosShow > 0) { ?>
				<?php do { ?>
                  <li class="item col-lg-4 col-md-4 col-sm-6 col-xs-6 ">
                    <div class="product-item">
                      <div class="item-inner">
                        <div class="product-thumbnail">
                          <?php if (isset($row_productosShow["precioOferta"])) { ?><div class="icon-sale-label sale-left">Oferta</div><?php } ?>
                          <?php if ($row_productosShow["novedad"] == '1') { ?><div class="icon-new-label new-right">Nuevo</div><?php } ?>
                          <div class="pr-img-area"> <a title="<?php echo $row_productosShow["nombre"]; ?>" href="../productos/<?php echo $row_productosShow["nombreSEO"]; ?>">
                            <figure> <img class="first-img" src="../images/productos/<?php echo $row_productosShow["imagen1"]; ?>" alt="<?php echo $row_productosShow["nombre"]; ?>"> <img class="hover-img" src="../images/productos/<?php echo $row_productosShow["imagen1"]; ?>" alt="<?php echo $row_productosShow["nombre"]; ?>"></figure>
                            </a> </div>
                        </div>
                        <div class="item-info">
                          <div class="info-inner">
                            <div class="item-title"> <a title="<?php echo $row_productosShow["nombre"]; ?>" href="../productos/<?php echo $row_productosShow["nombreSEO"]; ?>"><?php echo $row_productosShow["nombre"]; ?> </a> </div>
                            <div class="item-content">
				              <?php if (isset($row_productosShow["precio"])) { ?>
                              <div class="item-price">
				                <?php if (isset($row_productosShow["precioOferta"])) { ?>
                                <div class="price-box">
				                  <p class="special-price"> <span class="price-label">Precio Oferta</span> <span class="price"> <?php echo "$".number_format(0,$row_productosShow["precioOferta"],",","."); ?> </span> </p>
				                  <p class="old-price"> <span class="price-label">Precio Normal</span> <span class="price"> <?php echo "$".number_format(0,$row_productosShow["precio"],",","."); ?> </span> </p>
			                    </div>
                                <?php } ?>
				                <?php if (empty($row_productosShow["precioOferta"])) { ?>
                                <div class="price-box">
				                  <p class="special-price"> <span class="price-label">Precio</span> <span class="price"> <?php echo "$".number_format(0,$row_productosShow["precio"],",","."); ?> </span> </p>
			                    </div>
                                <?php } ?>
			                  </div>
                              <?php } ?>
                              <div class="pro-action">
                                <button type="button" class="add-to-cart" onClick="location.href='../productos/<?php echo $row_productosShow["nombreSEO"]; ?>'"><span> Ver Producto</span> </button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </li>
                <?php } while ($row_productosShow = mysqli_fetch_assoc($productosShow)); ?>
                <?php } ?>
                <?php } //Categoría Ventanas ?>

                <?php if ($row_categoriaSelect["categoriaSEO"] == 'shower-door') { ?>
                  <li class="col-lg-12 a-center">
                  	<div class="product-item">
                    	<iframe src="https://player.vimeo.com/video/33563667" width="90%" height="360" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                    </div>
                  </li>
				<?php if ($totalRows_productosShow > 0) { ?>
				<?php do { ?>
                  <li class="item col-lg-3 col-md-3 col-sm-6 col-xs-6 ">
                    <div class="product-item">
                      <div class="item-inner">
                        <div class="product-thumbnail">
                          <?php if (isset($row_productosShow["precioOferta"])) { ?><div class="icon-sale-label sale-left">Oferta</div><?php } ?>
                          <?php if ($row_productosShow["novedad"] == '1') { ?><div class="icon-new-label new-right">Nuevo</div><?php } ?>
                          <div class="pr-img-area"> <a title="<?php echo $row_productosShow["nombre"]; ?>" href="../productos/<?php echo $row_productosShow["nombreSEO"]; ?>">
                            <figure> <img class="first-img" src="../images/productos/<?php echo $row_productosShow["imagen1"]; ?>" alt="<?php echo $row_productosShow["nombre"]; ?>"> <img class="hover-img" src="../images/productos/<?php echo $row_productosShow["imagen1"]; ?>" alt="<?php echo $row_productosShow["nombre"]; ?>"></figure>
                            </a> </div>
                        </div>
                        <div class="item-info">
                          <div class="info-inner">
                            <div class="item-title"> <a title="<?php echo $row_productosShow["nombre"]; ?>" href="../productos/<?php echo $row_productosShow["nombreSEO"]; ?>"><?php echo $row_productosShow["nombre"]; ?> </a> </div>
                            <div class="item-content">
				              <?php if (isset($row_productosShow["precio"])) { ?>
                              <div class="item-price">
				                <?php if (isset($row_productosShow["precioOferta"])) { ?>
                                <div class="price-box">
				                  <p class="special-price"> <span class="price-label">Precio Oferta</span> <span class="price"> <?php echo "$".number_format(0,$row_productosShow["precioOferta"],",","."); ?> </span> </p>
				                  <p class="old-price"> <span class="price-label">Precio Normal</span> <span class="price"> <?php echo "$".number_format(0,$row_productosShow["precio"],",","."); ?> </span> </p>
			                    </div>
                                <?php } ?>
				                <?php if (empty($row_productosShow["precioOferta"])) { ?>
                                <div class="price-box">
				                  <p class="special-price"> <span class="price-label">Precio</span> <span class="price"> <?php echo "$".number_format(0,$row_productosShow["precio"],",","."); ?> </span> </p>
			                    </div>
                                <?php } ?>
			                  </div>
                              <?php } ?>
                              <div class="pro-action">
                                <button type="button" class="add-to-cart" onClick="location.href='../productos/<?php echo $row_productosShow["nombreSEO"]; ?>'"><span> Ver Producto</span> </button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </li>
                <?php } while ($row_productosShow = mysqli_fetch_assoc($productosShow)); ?>
                <?php } ?>
                <?php } //Categoría Shower Doors ?>

              </ul>
            </div>
            <div class="pagination-area">

              <ul>
                <?php if ($pageNum_productosShow > 0) { // Show if not first page ?><li><a href="<?php printf("%s?pageNum_productosShow=%d%s", $currentPage, 0, $queryString_productosShow); ?>"><i class="fa fa-angle-double-left"></i></a></li><?php } // Show if not first page ?>
                <?php if ($pageNum_productosShow > 0) { // Show if not first page ?><li><a href="<?php printf("%s?pageNum_productosShow=%d%s", $currentPage, max(0, $pageNum_productosShow - 1), $queryString_productosShow); ?>"><i class="fa fa-angle-left"></i></a></li><?php } // Show if not first page ?>
                <?php if ($pageNum_productosShow < $totalPages_productosShow) { // Show if not last page ?><li><a href="<?php printf("%s?pageNum_productosShow=%d%s", $currentPage, min($totalPages_productosShow, $pageNum_productosShow + 1), $queryString_productosShow); ?>"><i class="fa fa-angle-right"></i></a></li><?php } // Show if not last page ?>
                <?php if ($pageNum_productosShow < $totalPages_productosShow) { // Show if not last page ?><li><a href="<?php printf("%s?pageNum_productosShow=%d%s", $currentPage, $totalPages_productosShow, $queryString_productosShow); ?>"><i class="fa fa-angle-double-right"></i></a></li><?php } // Show if not last page ?>
              </ul>
              
            </div>
          </div>
        </div>
        <aside class="sidebar col-sm-3 col-xs-12 col-sm-pull-9">
          <div class="block category-sidebar">
            <div class="sidebar-title">
              <h3>Categor&iacute;as</h3>
            </div>
            <ul class="product-categories">
              <?php $seleccionCategorias = mysqli_query($DKKfront, "SELECT * FROM menuCategorias WHERE menuCategorias.estado = '1' ORDER BY menuCategorias.id ASC"); while($ln = mysqli_fetch_array($seleccionCategorias)){ $idCategoria = $ln['id']; ?>
                <li class="cat-item current-cat cat-parent"><a href="../categoria/<?php echo $ln["categoriaSEO"]; ?>"><?php echo $ln["categoria"]; ?></a>
                  <?php $seleccionaSubCategorias = mysqli_query($DKKfront, "SELECT * FROM menuSubCategorias WHERE menuSubCategorias.estado = '1' AND menuSubCategorias.idCategoria = '$idCategoria'  ORDER BY menuSubCategorias.subCategoria ASC"); if(mysqli_num_rows($seleccionaSubCategorias) == 0) { echo "</li>"; } else { ?>
				    <ul class="children">
					<?php $counter = 1; while($lSub = mysqli_fetch_array($seleccionaSubCategorias)) { ?>
                      <li class="cat-item"><a href="../<?php echo $ln["categoriaSEO"]; ?>/<?php echo $lSub["subCategoriaSEO"]; ?>"><i class="fa fa-angle-right"></i>&nbsp; <?php echo $lSub["subCategoria"]; ?></a></li>
                    <?php } ?>
                    </ul>
                  </li>
                <?php } ?>
              <?php } ?>
            </ul>
          </div>
          <?php if ($row_categoriaSelect["categoriaSEO"] == 'escalas') { ?>
          <div class="block shop-by-side">
            <div class="sidebar-bar-title">
              <h3>Categor&iacute;as</h3>
            </div>
            <div class="block-content">
	          <?php do { ?>
              <div class="manufacturer-area">
                <h2 class="saider-bar-title"><a href="../escalas/<?php echo $row_familiasEscalas["subCategoriaSEO"]; ?>"><?php echo $row_familiasEscalas["subCategoria"]; ?></a></h2>
                <div class="saide-bar-menu">
                  <ul>
					<?php 
					$familiaSEO = $row_familiasEscalas["subCategoriaSEO"];
					$seleccionFamilias = mysqli_query($DKKfront, "SELECT * FROM menuSubCategoriasFamilias WHERE menuSubCategoriasFamilias.subCategoriaSEO = '$familiaSEO' AND menuSubCategoriasFamilias.estado = '1' ORDER BY menuSubCategoriasFamilias.id ASC"); while($sf = mysqli_fetch_array($seleccionFamilias)){ $seoFamilia = $sf['subCategoriaFamiliaSEO']; ?>
                    <li><a href="../<?php echo $sf["categoriaSEO"]; ?>/<?php echo $sf["subCategoriaSEO"]; ?>/<?php echo $sf["subCategoriaFamiliaSEO"]; ?>"><i class="fa fa-angle-right"></i> <?php echo $sf["subCategoriaFamilia"]; ?></a></li>
                    <?php } ?>                  
                  </ul>
                </div>
              </div>
	          <?php } while ($row_familiasEscalas = mysqli_fetch_assoc($familiasEscalas)); ?>
            </div>
          </div>
            
          <div class="block shop-by-side">
		    <div class="color-area">
              <h2 class="saider-bar-title">Etiqueta</h2>
              <div class="color">
                <ul>
                  <?php do { ?>
                  <li><a href="../etiqueta/<?php echo $row_escalasEtiquetas["etiquetaSEO"]; ?>"></a></li>
                  <?php } while ($row_escalasEtiquetas = mysqli_fetch_assoc($escalasEtiquetas)); ?>
                </ul>
              </div>
            </div>
          </div>
            
          <div class="block shop-by-side">
            <div class="manufacturer-area">
              <h2 class="saider-bar-title">Capacidad M&aacute;x. (kgs.)</h2>
              <div class="tag">
                <ul>
                  <?php do { ?>
                  <li><a href="../cap-max/<?php echo $row_escalasCapMax["capMaxSEO"]; ?>"><?php echo $row_escalasCapMax["capMax"]; ?></a></li>
                  <?php } while ($row_escalasCapMax = mysqli_fetch_assoc($escalasCapMax)); ?>
                </ul>
              </div>
            </div>
          </div>
            
          <div class="block shop-by-side">
            <div class="manufacturer-area">
              <h2 class="saider-bar-title">Usos</h2>
              <div class="saide-bar-menu">
                <ul>
                  <?php do { ?>
                  <li><a href="../uso/<?php echo $row_escalasUsos["usoSEO"]; ?>"><i class="fa fa-angle-right"></i> <?php echo $row_escalasUsos["uso"]; ?></a></li>
                  <?php } while ($row_escalasUsos = mysqli_fetch_assoc($escalasUsos)); ?>
                </ul>
              </div>
            </div>
          </div>
          <?php } //Si son escalas ?>
          <div class="block shop-by-side">
            <div class="sidebar-bar-title">
              <h3>Otros Productos</h3>
            </div>
            <div class="block-content">
              <div class="manufacturer-area">
                <div class="saide-bar-menu">
                  <ul>
                    <?php do { ?>
                    <li><a href="../categoria/<?php echo $row_categoriasSide["categoriaSEO"]; ?>"><i class="fa fa-angle-right"></i> <?php echo $row_categoriasSide["categoria"]; ?></a></li>
                    <?php } while ($row_categoriasSide = mysqli_fetch_assoc($categoriasSide)); ?>
                  </ul>
                </div>
              </div>
            </div>
          </div>

          <div class="block special-product">
            <div class="sidebar-bar-title">
              <h3>Recomendados</h3>
            </div>
            <div class="block-content">
              <ul>
              
                <?php do { ?>
                <li class="item">
                  <div class="products-block-left"> <a href="../productos/<?php echo $row_productosRecomendados["nombreSEO"]; ?>" title="<?php echo $row_productosRecomendados["nombre"]; ?>" class="product-image"><img src="../images/productos/<?php echo $row_productosRecomendados["imagen1"]; ?>" alt="<?php echo $row_productosRecomendados["nombre"]; ?>"></a></div>
                  <div class="products-block-right">
                    <p class="product-name"> <a href="../productos/<?php echo $row_productosRecomendados["nombreSEO"]; ?>"><?php echo $row_productosRecomendados["nombre"]; ?></a> </p>
                    <?php if (isset($row_productosRecomendados["precio"])) { ?><span class="price"><?php echo "$".number_format("0",$row_productosRecomendados["nombreSEO"],",","."); ?></span><?php } ?>
                    <!-- <div class="rating"> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star-o"></i> </div> -->
                  </div>
                </li>
                <?php } while ($row_productosRecomendados = mysqli_fetch_assoc($productosRecomendados)); ?>

              </ul>
              <a class="link-all" href="../catalogo">Ver todos</a> 
            </div>
          </div>
          
          <div class="jtv-banner3">
            <div class="jtv-banner3-inner"><a href="<?php echo $row_banner["link"]; ?>" target="_blank"><img src="../images/<?php echo $row_banner["imagen"]; ?>" alt="Visítanos"></a>
              <div class="hover_content">
                <div class="hover_data">
                  <div class="title"> <?php echo $row_banner["titulo"]; ?> </div>
                  <div class="desc-text"><?php echo $row_banner["llamado"]; ?></div>
                  <span><?php echo $row_banner["bajada"]; ?></span>
                  <p><a href="<?php echo $row_banner["link"]; ?>" class="shop-now" target="_blank"><?php echo $row_banner["accion"]; ?></a></p>
                </div>
              </div>
            </div>
          </div>
          
        </aside>

      </div>
    </div>
  </div>
  <!-- END contenido -->
  <!-- InstanceEndEditable -->
  <!-- END contenido -->
  
  <!-- atributos -->
  <div class="jtv-service-area">
    <div class="container">
      <div class="row">
        <div class="col col-md-6 col-sm-6 col-xs-12">
          <div class="block-wrapper ship">
            <div class="text-des">
              <div class="icon-wrapper"><i class="fa fa-paper-plane"></i></div>
              <div class="service-wrapper">
                <h3>Despacho a todo Chile</h3>
                <p>Conoce los términos y condiciones</p>
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