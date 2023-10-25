<?php require_once('../Connections/DKKadmin.php');?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

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

$query_ultimoProducto = "SELECT * FROM productos ORDER BY productos.id DESC";
$ultimoProducto = mysql_query($DKKadmin, $query_ultimoProducto);
$row_ultimoProducto = mysql_fetch_assoc($ultimoProducto);
$totalRows_ultimoProducto = mysql_num_rows($ultimoProducto);

$seoSubCategoria = $row_ultimoProducto["subCategoriaSEO"];

$query_subCategoriaSELECT = "SELECT * FROM menuSubCategorias WHERE menuSubCategorias.subCategoriaSEO = '$seoSubCategoria'";
$subCategoriaSELECT = mysql_query($DKKadmin, $query_subCategoriaSELECT);
$row_subCategoriaSELECT = mysql_fetch_assoc($subCategoriaSELECT);
$totalRows_subCategoriaSELECT = mysql_num_rows($subCategoriaSELECT);

$idCategoria = $row_subCategoriaSELECT["idCategoria"];

$query_categoriaSELECT = "SELECT * FROM menuCategorias WHERE menuCategorias.id = '$idCategoria '";
$categoriaSELECT = mysql_query($DKKadmin, $query_categoriaSELECT);
$row_categoriaSELECT = mysql_fetch_assoc($categoriaSELECT);
$totalRows_categoriaSELECT = mysql_num_rows($categoriaSELECT);

$seoCategoria = $row_categoriaSELECT["categoriaSEO"];
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
$codInterno = "0".$row_categoriaSELECT["id"]."0".$row_subCategoriaSELECT["id"]."0".$row_ultimoProducto["id"];
//Fijar CodInterno
  $updateSQL = sprintf($DKKadmin, "UPDATE productos SET productos.codInterno = '$codInterno' ORDER BY productos.id DESC LIMIT 1");
  mysql_select_db($DKKadmin, $database_DKKadmin);
  $Result1 = mysql_query($DKKadmin, $updateSQL);
//Fijar CodInterno
//Actualizar Estado
  $updateSQL = sprintf($DKKadmin, "UPDATE productos SET productos.categoriaSEO = '$seoCategoria' ORDER BY productos.id DESC LIMIT 1");
  mysql_select_db($DKKadmin, $database_DKKadmin);
  $Result1 = mysql_query($DKKadmin, $updateSQL);
  $updateGoTo = "productos-resize.php?id=".$row_ultimoProducto["id"];
  header(sprintf("Location: %s", $updateGoTo));
//Actualizar Estado
?>
<?php

mysql_free_result($ultimoProducto);

mysql_free_result($subCategoriaSELECT);

mysql_free_result($categoriaSELECT);
?>
