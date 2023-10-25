<?php require_once('../Connections/DKKfront.php');

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

//Variables Globales
$fecha = date('Y-m-d H:i:s');
$fechaID = strtotime($fecha);
$ip = $_SERVER["REMOTE_ADDR"];
$pagina = 'catalogoPDF';

$query_metaDatos = "SELECT * FROM metaDatos ORDER BY metaDatos.id DESC LIMIT 1";
$metaDatos = mysqli_query($DKKfront, $query_metaDatos);
$row_metaDatos = mysqli_fetch_assoc($metaDatos);
$totalRows_metaDatos = mysqli_num_rows($metaDatos);

$query_catalogoPDF = "SELECT * FROM catalogoPDF WHERE catalogoPDF.estado = '1' ORDER BY catalogoPDF.titulo ASC";
$catalogoPDF = mysqli_query($DKKfront, $query_catalogoPDF);
$row_catalogoPDF = mysqli_fetch_assoc($catalogoPDF);
$totalRows_catalogoPDF = mysqli_num_rows($catalogoPDF);

//registrar visita
$updateSQL = sprintf("INSERT INTO visitas (pagina, ip, fechaID) VALUE ('$pagina', '$ip', '$fechaID')");
mysqli_select_db($DKKfront, $database_DKKfront);
$Result1 = mysqli_query($DKKfront, $updateSQL) or die(mysqli_error());
?>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo $row_metaDatos["titulo"]." | Cat&aacute;log PDF"; ?></title>
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
	<!-- multi-language support -->
	<link rel="alternate" href="https://www.prodalum.cl" hreflang="es" />
	<meta property="og:locale:alternate" content="es" />
	<!-- full responsivo  -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- favicon -->
	<link rel="shortcut icon" type="image/x-icon" href="../images/favicon.ico">
	<script type="text/javascript" src="../js/jquery.min.js"></script> 
	<script type="text/javascript" src="../js/jquery-ui.js"></script> 
    <script src="js/flipbook.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/flipbook.style.css">
    <link rel="stylesheet" type="text/css" href="css/flipbook.skin.black.css">
    <script type="text/javascript">
        $(document).ready(function () {
            $("#container").flipBook({
                pages:[
					<?php do { ?>
                    {
                        src:"../images/uploads/<?php echo $row_catalogoPDF["imagen"]; ?>",
                        thumb:"../images/uploads/thumbs/<?php echo $row_catalogoPDF["imagen"]; ?>",
                        title:"<?php echo $row_catalogoPDF["titulo"]; ?>"
                    },
					<?php } while ($row_catalogoPDF = mysqli_fetch_assoc($catalogoPDF)); ?>
                ]
            });
        })
    </script>
</head>
<body>
	<div id="container"></div>
</body>
</html>
<?php
mysqli_free_result($metaDatos);

mysqli_free_result($catalogoPDF);
?>
