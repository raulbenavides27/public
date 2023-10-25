<?php require_once('../Connections/DKKadmin.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  global $DKKadmin;
$theValue = function_exists("mysqli_real_escape_string") ? mysqli_real_escape_string($DKKadmin, $theValue) : mysqli_escape_string($DKKadmin,$theValue);

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

//Variables
$fecha = date('Y-m-d H:i:s');
$fechaID = strtotime($fecha);
$categoriaID = $GET["id"];

$query_editID = "SELECT * FROM productosCategorias WHERE productosCategorias.id = '$categoriaID'";
$editID = mysqli_query($DKKadmin, $query_editID) or die(mysqli_error($DKKadmin));
$row_editID = mysqli_fetch_assoc($editID);
$totalRows_editID = mysqli_num_rows($editID);

	// *** Include the class
	include("resize-class.php");

	$imagen = $row_editID["imagen"];
	// *** 1) Initialise / load image
	$resizeObj = new resize("../images/productos/categorias/".$imagen);

	// *** 2) Resize image (options: exact, portrait, landscape, auto, crop)
	$resizeObj -> resizeImage(848, 197, 'crop');

	// *** 3) Save image
	$resizeObj -> saveImage("../images/productos/categorias/".$imagen, 100);


mysqli_free_result($editID);
?>
<META HTTP-EQUIV='Refresh' CONTENT='0; URL=categorias.php'>