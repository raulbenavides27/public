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
$categoria = $_GET["categoria"];
$pagina = 'blog/'.$categoria;

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

$query_blogCategorias = "SELECT * FROM blogCategorias WHERE blogCategorias.estado = '1' ORDER BY blogCategorias.categoria ASC";
$blogCategorias = mysqli_query($DKKfront, $query_blogCategorias);
$row_blogCategorias = mysqli_fetch_assoc($blogCategorias);
$totalRows_blogCategorias = mysqli_num_rows($blogCategorias);

$query_categoriaSelect = sprintf("SELECT * FROM blogCategorias WHERE blogCategorias.categoriaSEO = '$categoria'");
$categoriaSelect = mysqli_query($DKKfront, $query_categoriaSelect);
$row_categoriaSelect = mysqli_fetch_assoc($categoriaSelect);
$totalRows_categoriaSelect = mysqli_num_rows($categoriaSelect);

$maxRows_blogPosts = 6;
$pageNum_blogPosts = 0;
if (isset($_GET['pageNum_blogPosts'])) {
  $pageNum_blogPosts = $_GET['pageNum_blogPosts'];
}
$startRow_blogPosts = $pageNum_blogPosts * $maxRows_blogPosts;

$query_blogPosts = sprintf("SELECT * FROM blog WHERE blog.categoriaSEO = '$categoria'");
$query_limit_blogPosts = sprintf("%s LIMIT %d, %d", $query_blogPosts, $startRow_blogPosts, $maxRows_blogPosts);
$blogPosts = mysqli_query($DKKfront, $query_blogPosts);
$row_blogPosts = mysqli_fetch_assoc($blogPosts);

if (isset($_GET['totalRows_blogPosts'])) {
  $totalRows_blogPosts = $_GET['totalRows_blogPosts'];
} else {
  $all_blogPosts = mysqli_query($DKKfront, $query_blogPosts);
  $totalRows_blogPosts = mysqli_num_rows($all_blogPosts);
}
$totalPages_blogPosts = ceil($totalRows_blogPosts/$maxRows_blogPosts)-1;

$queryString_blogPosts = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_blogPosts") == false && 
        stristr($param, "totalRows_blogPosts") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_blogPosts = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_blogPosts = sprintf("&totalRows_blogPosts=%d%s", $totalRows_blogPosts, $queryString_blogPosts);

$query_postsPopulares = "SELECT * FROM blog WHERE blog.estado = '1' ORDER BY blog.visitas DESC LIMIT 3";
$postsPopulares = mysqli_query($DKKfront, $query_postsPopulares);
$row_postsPopulares = mysqli_fetch_assoc($postsPopulares);
$totalRows_postsPopulares = mysqli_num_rows($postsPopulares);

//registrar visita
$updateSQL = sprintf("INSERT INTO visitas (pagina, ip, fechaID) VALUE ('$pagina', '$ip', '$fechaID')");
mysqli_select_db($DKKfront, $database_DKKfront);
$Result1 = mysqli_query($DKKfront, $updateSQL) or die(mysqli_error());

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
<title><?php echo $row_metaDatos["titulo"]." | Blog | ".$row_categoriaSelect["categoria"]; ?></title>
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
window.location="http://mobile.prodalum.cl/home/";
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
  <!--  titulo -->
  <section class="blog_post">
    <div class="container"> 
      <div class="row"> 
        <!-- posts -->
        <div class="col-xs-12 col-sm-9 col-sm-push-3" id="center_column">
          <div class="center_column">
            <div class="page-title">
              <h2>Blog</h2>
            </div>
            <?php if ($totalRows_blogPosts == 0) { ?>
            <p>Aqu&iacute; no hay posts que mostrar.</p>
		    <?php } ?>
            <?php if ($totalRows_blogPosts > 0) { ?>
            <ul class="blog-posts">

			  <?php do { ?>
              <li class="post-item">
                <article class="entry">
                  <div class="row">
                    <div class="col-sm-5">
                      <div class="entry-thumb image-hover2"> <a href="../posts/<?php echo $row_blogPosts["tituloSEO"]; ?>">
                        <figure><img src="../images/blog/<?php echo $row_blogPosts["imagen"]; ?>" alt="<?php echo $row_blogPosts["titulo"]; ?>"></figure>
                        </a> </div>
                    </div>
                    <div class="col-sm-7">
                      <h3 class="entry-title"><a href="../posts/<?php echo $row_blogPosts["tituloSEO"]; ?>"><?php echo $row_blogPosts["titulo"]; ?></a></h3>
                      <div class="entry-meta-data"> <span class="author"> <i class="pe-7s-user"></i>&nbsp; por: <a href="#"><?php echo $row_blogPosts["autor"]; ?></a></span> <span class="cat"> <i class="pe-7s-folder"></i>&nbsp; <a href="../blog/<?php echo $row_blogPosts["categoriaSEO"]; ?>"><?php echo strtoupper(str_replace("-"," ",$row_blogPosts["categoriaSEO"])); ?></a> </span> <span class="comment-count"> <i class="pe-7s-comment"></i>&nbsp; <span class="fb-comments-count" data-href="https://www.prodalum.cl/posts/<?php echo $row_blogPosts["tituloSEO"]; ?>"></span> </span> <span class="date"><i class="pe-7s-date"></i>&nbsp; <?php echo $row_blogPosts["dia"]." ".$row_blogPosts["mes"]." ".$row_blogPosts["ano"]; ?></span> </div>
                      <div class="entry-excerpt"><?php echo $row_blogPosts["bajada"]; ?></div>
                      <a href="../posts/<?php echo $row_blogPosts["tituloSEO"]; ?>" class="button read-more">Leer m&aacute;s <i class="fa fa-angle-double-right"></i></a> </div>
                  </div>
                </article>
              </li>
              <?php } while ($row_blogPosts = mysqli_fetch_assoc($blogPosts)); ?>

            </ul>
            <?php } ?>
            <div class="sortPagiBar">
              <div class="pagination-area " >
                <ul>
                  <?php if ($pageNum_blogPosts > 0) { // Show if not first page ?><li><a href="<?php printf("%s?pageNum_blogPosts=%d%s", $currentPage, 0, $queryString_blogPosts); ?>"><i class="fa fa-angle-double-left"></i></a></li><?php } // Show if not first page ?>
                  <?php if ($pageNum_blogPosts > 0) { // Show if not first page ?><li><a href="<?php printf("%s?pageNum_blogPosts=%d%s", $currentPage, max(0, $pageNum_blogPosts - 1), $queryString_blogPosts); ?>"><i class="fa fa-angle-left"></i></a></li><?php } // Show if not first page ?>
                  <?php if ($pageNum_blogPosts < $totalPages_blogPosts) { // Show if not last page ?><li><a href="<?php printf("%s?pageNum_blogPosts=%d%s", $currentPage, min($totalPages_blogPosts, $pageNum_blogPosts + 1), $queryString_blogPosts); ?>"><i class="fa fa-angle-right"></i></a></li><?php } // Show if not last page ?>
                  <?php if ($pageNum_blogPosts < $totalPages_blogPosts) { // Show if not last page ?><li><a href="<?php printf("%s?pageNum_blogPosts=%d%s", $currentPage, $totalPages_blogPosts, $queryString_blogPosts); ?>"><i class="fa fa-angle-double-right"></i></a></li><?php } // Show if not last page ?>
                </ul>
              </div>
            </div>
          </div>
        </div>
        <!-- END posts --> 
        <!-- costado -->
        <aside class="sidebar col-xs-12 col-sm-3 col-sm-pull-9"> 
          <!-- categorías -->
          <div class="block blog-module">
            <div class="sidebar-bar-title">
              <h3>Categor&iacute;as</h3>
            </div>
            <div class="block_content"> 
              <div class="layered layered-category">
                <div class="layered-content">
                  <ul class="tree-menu">
                  	<?php do { ?>
                    <li><i class="fa fa-angle-right"></i>&nbsp; <a href="../blog/<?php echo $row_blogCategorias["categoriaSEO"]; ?>"><?php echo $row_blogCategorias["categoria"]; ?></a></li>
                    <?php } while ($row_blogCategorias = mysqli_fetch_assoc($blogCategorias)); ?>
                  </ul>
                </div>
              </div>
            </div>
          </div>
          <!-- END categorías  --> 
          <!-- post populares -->
          <div class="block blog-module">
            <div class="sidebar-bar-title">
              <h3>Posts Populares</h3>
            </div>
            <div class="block_content"> 
              <div class="layered">
                <div class="layered-content">
                  <ul class="blog-list-sidebar">
                  
                    <?php do { ?>
                    <li>
                      <div class="post-thumb"> <a href="../posts/<?php echo $row_postsPopulares["tituloSEO"]; ?>"><img src="../images/blog/<?php echo $row_postsPopulares["imagen"]; ?>" alt="<?php echo $row_postsPopulares["titulo"]; ?>"></a> </div>
                      <div class="post-info">
                        <h5 class="entry_title"><a href="../posts/<?php echo $row_postsPopulares["tituloSEO"]; ?>"><?php echo $row_postsPopulares["titulo"]; ?></a></h5>
                        <div class="post-meta"> <span class="date"><i class="pe-7s-date"></i> <?php echo $row_postsPopulares["dia"]." ".$row_postsPopulares["mes"]." ".$row_postsPopulares["ano"]; ?></span> <span class="comment-count"> <i class="pe-7s-comment-o"></i> <span class="fb-comments-count" data-href="https://www.prodalum.cl/posts/<?php echo $row_postsPopulares["tituloSEO"]; ?>"></span> </span> </div>
                      </div>
                    </li>
                    <?php } while ($row_postsPopulares = mysqli_fetch_assoc($postsPopulares)); ?>

                  </ul>
                </div>
              </div>
            </div>
          </div>
          <!-- END post populares --> 
          
        </aside>
        <!-- END costado -->
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
<!-- InstanceBeginEditable name="js" --> <!-- InstanceEndEditable -->
</body>
<!-- InstanceEnd --></html>