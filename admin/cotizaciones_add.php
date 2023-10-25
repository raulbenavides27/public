<?php require_once('../Connections/DKKadmin.php'); ?>
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

//variables
$fecha = date('Y-m-d H:i:s');
$fechaID = strtotime($fecha);
$ip = $_SERVER["REMOTE_ADDR"];

$query_ultimaCotizacion = "SELECT * FROM cotizaciones WHERE cotizaciones.ip = '$ip' ORDER BY cotizaciones.id DESC";
$ultimaCotizacion = mysqli_query($DKKadmin, $query_ultimaCotizacion) or die(mysqli_error($DKKadmin));
$row_ultimaCotizacion = mysqli_fetch_assoc($ultimaCotizacion);
$totalRows_ultimaCotizacion = mysqli_num_rows($ultimaCotizacion);

$seo = $row_ultimaCotizacion["productoSEO"];
$id = $row_ultimaCotizacion["id"];

$query_infoProducto = "SELECT * FROM productos WHERE productos.nombreSEO = '$seo'";
$infoProducto = mysqli_query($DKKadmin, $query_infoProducto) or die(mysqli_error($DKKadmin));
$row_infoProducto = mysqli_fetch_assoc($infoProducto);
$totalRows_infoProducto = mysqli_num_rows($infoProducto);

$nombreProducto = $row_infoProducto["nombre"];
$categoriaProducto = $row_infoProducto["categoriaSEO"];
$subCategoriaProducto = $row_infoProducto["subCategoriaSEO"];
$familiaProducto = $row_infoProducto["subCategoriaFamiliaSEO"];

//actualizar info cotizacion
  $updateSQL = sprintf("UPDATE cotizaciones SET cotizaciones.producto = '$nombreProducto' WHERE cotizaciones.id = '$id'");
  $Result1 = mysqli_query($DKKadmin, $updateSQL) or die(mysqli_error($DKKadmin));
  $updateSQL = sprintf("UPDATE cotizaciones SET cotizaciones.productoCategoria = '$categoriaProducto' WHERE cotizaciones.id = '$id'");
  $Result1 = mysqli_query($DKKadmin, $updateSQL) or die(mysqli_error($DKKadmin));
  $updateSQL = sprintf("UPDATE cotizaciones SET cotizaciones.productoSubCategoria = '$subCategoriaProducto' WHERE cotizaciones.id = '$id'");
  $Result1 = mysqli_query($DKKadmin, $updateSQL) or die(mysqli_error($DKKadmin));
  $updateSQL = sprintf("UPDATE cotizaciones SET cotizaciones.productoFamilia = '$familiaProducto' WHERE cotizaciones.id = '$id'");
  $Result1 = mysqli_query($DKKadmin, $updateSQL) or die(mysqli_error($DKKadmin));
?>
<meta http-equiv="refresh" content="0; url=cotizaciones_view.php?id=<?php echo $id; ?>" />
<?php
mysqli_free_result($ultimaCotizacion);

mysqli_free_result($infoProducto);
?>
