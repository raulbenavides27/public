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

$query_resizeID = "SELECT * FROM noticias ORDER BY noticias.id DESC LIMIT 1";
$resizeID = mysqli_query($DKKadmin, $query_resizeID) or die(mysqli_error($DKKadmin));
$row_resizeID = mysqli_fetch_assoc($resizeID);
$totalRows_resizeID = mysqli_num_rows($resizeID);

	// *** Include the class
	include("resize-class.php");

	$imagen = $row_resizeID["imagen"];
	// *** 1) Initialise / load image
	$resizeObj = new resize("../images/noticias/".$imagen);

	// *** 2) Resize image (options: exact, portrait, landscape, auto, crop)
	$resizeObj -> resizeImage(847, 470, 'crop');

	// *** 3) Save image
	$resizeObj -> saveImage("../images/noticias/".$imagen, 100);


mysqli_free_result($resizeID);
?>
<META HTTP-EQUIV='Refresh' CONTENT='0; URL=noticias.php'>