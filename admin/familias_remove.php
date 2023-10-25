<?php require_once('../Connections/DKKadmin.php');?>
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
$idCategoria = $_GET["id"];

$query_ConsultaChange = sprintf("SELECT * FROM menuSubCategoriasFamilias WHERE menuSubCategoriasFamilias.id = '$idCategoria'");
$ConsultaChange = mysqli_query($DKKadmin, $query_ConsultaChange) or die(mysqli_error($DKKadmin));
$row_ConsultaChanget = mysqli_fetch_assoc($ConsultaChange);
$totalRows_ConsultaChange = mysqli_num_rows($ConsultaChange);
?>
<?php
//Actualizar Estado
  $updateSQL = sprintf("UPDATE menuSubCategoriasFamilias SET menuSubCategoriasFamilias.estado = '0' WHERE menuSubCategoriasFamilias.id = '$idCategoria'");
  mysqli_select_db($DKKadmin, $database_DKKadmin);
  $Result1 = mysqli_query($DKKadmin, $updateSQL) or die(mysqli_error($DKKadmin));
  $updateGoTo = "familias.php";
  header(sprintf("Location: %s", $updateGoTo));
//Actualizar Estado
?>
<?php
mysqli_free_result($ConsultaChange);
?>
