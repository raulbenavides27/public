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

//variables
$fecha = date('Y-m-d H:i:s');
$fechaID = strtotime($fecha);
$ip = $_SERVER["REMOTE_ADDR"];
$telefono = $_GET["phone"];
$texto = $_GET["text"];
$pagina = 'whatsapp';

$query_metaDatos = "SELECT * FROM metaDatos ORDER BY metaDatos.id DESC";
$metaDatos = mysqli_query($DKKfront, $query_metaDatos) or die(mysqli_error());
$row_metaDatos = mysqli_fetch_assoc($metaDatos);
$totalRows_metaDatos = mysqli_num_rows($metaDatos);

//registrar visita
$updateSQL = sprintf("INSERT INTO visitas (pagina, ip, fechaID) VALUE ('$pagina', '$ip', '$fechaID')");
$Result1 = mysqli_query($DKKfront, $updateSQL) or die(mysqli_error($DKKfront));
?>
<meta http-equiv="refresh" content="0; url=https://api.whatsapp.com/send?phone=<?php echo $telefono; ?>&text=<?php echo $texto; ?>" />
<?php
mysqli_free_result($metaDatos);
?>
