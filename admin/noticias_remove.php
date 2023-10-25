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

$varID_ConsultaChange = "0";
if (isset($_GET["id"])) {
  $varID_ConsultaChange = $_GET["id"];
}
;
$query_ConsultaChange = sprintf("SELECT * FROM noticias WHERE noticias.id = %s", GetSQLValueString($varID_ConsultaChange, "int"));
$ConsultaChange = mysqli_query($DKKadmin, $query_ConsultaChange) or die(mysqli_error($DKKadmin));
$row_ConsultaChange = mysqli_fetch_assoc($ConsultaChange);
$totalRows_ConsultaChange = mysqli_num_rows($ConsultaChange);
?>
<?php 
$idAdmin = $_SESSION["MM_idAdmin"];
$fecha = date('Y-m-d');
$fechaHoy = strtotime($fecha);
$fechaAyer = strtotime( '-1 day' ,strtotime($fecha));
$fecha2dias = strtotime( '-2 day' ,strtotime($fecha));
$fecha3dias = strtotime( '-3 day' ,strtotime($fecha));
$fecha4dias = strtotime( '-4 day' ,strtotime($fecha));
$fecha5dias = strtotime( '-5 day' ,strtotime($fecha));
$fecha6dias = strtotime( '-6 day' ,strtotime($fecha));
$fecha1semana = strtotime( '-1 week' ,strtotime($fecha));
$fecha10dias = strtotime( '-10 day' ,strtotime($fecha));
$fecha15dias = strtotime( '-15 day' ,strtotime($fecha));
$fecha1mes = strtotime( '-1 month' ,strtotime($fecha));
$fecha2meses = strtotime( '-2 month' ,strtotime($fecha));
$fecha3meses = strtotime( '-3 month' ,strtotime($fecha));
$fecha6meses = strtotime( '-6 month' ,strtotime($fecha));
$fechayear = strtotime( '-1 year' ,strtotime($fecha));
?>
<?php
//Actualizar Estado
  $updateSQL = sprintf("UPDATE noticias SET noticias.estado = '0' WHERE noticias.id = %s",GetSQLValueString($varID_ConsultaChange, "int"));
  $Result1 = mysqli_query($DKKadmin, $updateSQL) or die(mysqli_error($DKKadmin));
  $updateGoTo = "noticias.php";
  header(sprintf("Location: %s", $updateGoTo));
//Actualizar Estado
?>
<?php
mysqli_free_result($ConsultaChange);
?>
