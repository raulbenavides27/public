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

$query_ultimoConvenio = "SELECT * FROM convenios ORDER BY convenios.id DESC LIMIT 1";
$ultimoConvenio = mysqli_query($DKKadmin, $query_ultimoConvenio) or die(mysqli_error($DKKadmin));
$row_ultimoConvenio = mysqli_fetch_assoc($ultimoConvenio);
$totalRows_ultimoConvenio = mysqli_num_rows($ultimoConvenio);

	// *** Include the class
	include("resize-class.php");

	$imagen = $row_ultimoConvenio["thumb"];
	// *** 1) Initialise / load image
	$resizeObj = new resize("../images/convenios/thumbs/".$imagen);

	// *** 2) Resize image (options: exact, portrait, landscape, auto, crop)
	$resizeObj -> resizeImage(450, 450, 'crop');

	// *** 3) Save image
	$resizeObj -> saveImage("../images/convenios/thumbs/".$imagen, 100);


mysqli_free_result($ultimoConvenio);
?>
<META HTTP-EQUIV='Refresh' CONTENT='0; URL=convenios.php'>