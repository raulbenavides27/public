<?php require_once('Connections/DKKfront.php'); ?>
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

$query_ultimaBusqueda = "SELECT * FROM buscador ORDER BY buscador.id DESC LIMIT 1";
$ultimaBusqueda = mysqli_query($DKKfront, $query_ultimaBusqueda) or die(mysqli_error());
$row_ultimaBusqueda = mysqli_fetch_assoc($ultimaBusqueda);
$totalRows_ultimaBusqueda = mysqli_num_rows($ultimaBusqueda);

?>
<meta http-equiv="refresh" content="0; url=resultados/index.php?q=<?php echo str_replace(" ","&",$row_ultimaBusqueda["search"]); ?>" />
<?php
mysqli_free_result($ultimaBusqueda);
?>
