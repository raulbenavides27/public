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

$query_ultimaFamilia = sprintf("SELECT * FROM menuSubCategoriasFamilias ORDER BY menuSubCategoriasFamilias.id DESC");
$ultimaFamilia = mysqli_query($DKKadmin, $query_ultimaFamilia) or die(mysqli_error($DKKadmin));
$row_ultimaFamilia = mysqli_fetch_assoc($ultimaFamilia);
$totalRows_ultimaFamilia = mysqli_num_rows($ultimaFamilia);

$subCategoriaSEO = $row_ultimaFamilia["subCategoriaSEO"];

$query_subCategoriaSelect = sprintf("SELECT * FROM menuSubCategorias WHERE menuSubCategorias.subCategoriaSEO = '$subCategoriaSEO'");
$subCategoriaSelect = mysqli_query($DKKadmin, $query_subCategoriaSelect) or die(mysqli_error($DKKadmin));
$row_subCategoriaSelect = mysqli_fetch_assoc($subCategoriaSelect);
$totalRows_subCategoriaSelect = mysqli_num_rows($subCategoriaSelect);

$idCategoria = $row_subCategoriaSelect["idCategoria"];

$query_categoriaSelect = sprintf("SELECT * FROM menuCategorias WHERE menuCategorias.id = '$idCategoria'");
$categoriaSelect = mysqli_query($DKKadmin, $query_categoriaSelect) or die(mysqli_error($DKKadmin));
$row_categoriaSelect = mysqli_fetch_assoc($categoriaSelect);
$totalRows_categoriaSelect = mysqli_num_rows($categoriaSelect);

$categoriaSEO = $row_categoriaSelect["categoriaSEO"];

?>
<?php
//Actualizar Categoria
  $updateSQL = sprintf("UPDATE menuSubCategoriasFamilias SET menuSubCategoriasFamilias.categoriaSEO = '$categoriaSEO' ORDER BY menuSubCategoriasFamilias.id DESC");
  mysqli_select_db($DKKadmin, $database_DKKadmin);
  $Result1 = mysqli_query($DKKadmin, $updateSQL) or die(mysqli_error($DKKadmin));
  $updateGoTo = "familias.php";
  header(sprintf("Location: %s", $updateGoTo));
//Actualizar Categoria
?>
<?php
mysqli_free_result($ultimaFamilia);

mysqli_free_result($subCategoriaSelect);

mysqli_free_result($categoriaSelect);
?>
