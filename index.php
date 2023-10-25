<?php require_once('Connections/DKKfront.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysqli_real_escape_string") ? mysqli_real_escape_string($theValue) : mysqli_escape_string($theValue);

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

$query_metaDatos = "SELECT * FROM metaDatos ORDER BY metaDatos.id DESC";
$metaDatos = mysqli_query($DKKfront, $query_metaDatos) or die(mysqli_error());
$row_metaDatos = mysqli_fetch_assoc($metaDatos);
$totalRows_metaDatos = mysqli_num_rows($metaDatos);
?>
<html>
<title><?php echo $row_metaDatos['titulo']; ?></title>
<meta name="subject" content="<?php echo $row_metaDatos['titulo']; ?>"/>
<meta name="description" content="<?php echo $row_metaDatos['descripcion']; ?>"/>
<meta name="keywords" content="<?php echo $row_metaDatos['keywords']; ?>"/>
<meta name="generator" content="Dreamweaver"/>
<meta name="language" content="Spanish"/>
<meta name="revisit" content="1 day"/>
<meta name="distribution" content="Global"/>
<meta name="robots" content="All"/>
<body>

<?php if (!(strcmp($row_metaDatos["mantencion"],"1"))) { ?>
<!-- HOME -->
  <script type="text/javascript">
  window.location="https://www.prodalum.cl/mantencion/";
  </script>
<!-- //HOME -->
<?php } ?>
<?php if (!(strcmp($row_metaDatos["mantencion"],"0"))) { ?>
<!-- HOME -->
  <script type="text/javascript">
  window.location="https://www.prodalum.cl/home/";
  </script>
<!-- //HOME -->
<?php } ?>
</body>
</html>