<?php require_once('../Connections/DKKadmin.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "../admin/login.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}

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

//Variables
$idAdmin = $_SESSION["MM_idAdmin"];
$ip = $_SERVER["REMOTE_ADDR"];
$fecha = date('Y-m-d H:i:s');
$fechaID = strtotime($fecha);
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

$varIDadmin_datosAdmin = "0";
if (isset($_SESSION["MM_idAdmin"])) {
  $varIDadmin_datosAdmin = $_SESSION["MM_idAdmin"];
}
$query_datosAdmin = sprintf("SELECT * FROM admin WHERE admin.id = %s AND admin.estado = '1'", GetSQLValueString($varIDadmin_datosAdmin, "int"));
$datosAdmin = mysqli_query($DKKadmin, $query_datosAdmin) or die(mysqli_error($DKKadmin));
$row_datosAdmin = mysqli_fetch_assoc($datosAdmin);
$totalRows_datosAdmin = mysqli_num_rows($datosAdmin);

$query_contactosPendientes = "SELECT * FROM contacto WHERE contacto.estado = '1' ORDER BY contacto.id DESC";
$contactosPendientes = mysqli_query($DKKadmin, $query_contactosPendientes) or die(mysqli_error($DKKadmin));
$row_contactosPendientes = mysqli_fetch_assoc($contactosPendientes);
$totalRows_contactosPendientes = mysqli_num_rows($contactosPendientes);

$varIDcotizacionEditar_qtsCotizacionEditar = "0";
if (isset($_GET["id"])) {
  $varIDcotizacionEditar_qtsCotizacionEditar = $_GET["id"];
}
$query_qtsCotizacionEditar = sprintf("SELECT * FROM qts_cotizaciones WHERE qts_cotizaciones.id = %s", GetSQLValueString($varIDcotizacionEditar_qtsCotizacionEditar, "int"));
$qtsCotizacionEditar = mysqli_query($DKKadmin, $query_qtsCotizacionEditar);
$row_qtsCotizacionEditar = mysqli_fetch_assoc($qtsCotizacionEditar);
$totalRows_qtsCotizacionEditar = mysqli_num_rows($qtsCotizacionEditar);

$idDespacho = $row_qtsCotizacionEditar["lugarEntregaID"];
$idCotizacion = $row_qtsCotizacionEditar["id"];
$idCliente = $row_qtsCotizacionEditar["clienteID"];

$query_qtsDatosCliente = "SELECT * FROM qts_clientes WHERE qts_clientes.id = '$idCliente'";
$qtsDatosCliente = mysqli_query($DKKadmin, $query_qtsDatosCliente);
$row_qtsDatosCliente = mysqli_fetch_assoc($qtsDatosCliente);
$totalRows_qtsDatosCliente = mysqli_num_rows($qtsDatosCliente);

$query_qtsMetaDatos = "SELECT * FROM metaDatos ORDER BY metaDatos.id DESC";
$qtsMetaDatos = mysqli_query($DKKadmin, $query_qtsMetaDatos);
$row_qtsMetaDatos = mysqli_fetch_assoc($qtsMetaDatos);
$totalRows_qtsMetaDatos = mysqli_num_rows($qtsMetaDatos);

$query_qtsDireccionDespacho = "SELECT * FROM qts_clientesDirecciones WHERE qts_clientesDirecciones.id = '$idDespacho'";
$qtsDireccionDespacho = mysqli_query($DKKadmin, $query_qtsDireccionDespacho);
$row_qtsDireccionDespacho = mysqli_fetch_assoc($qtsDireccionDespacho);
$totalRows_qtsDireccionDespacho = mysqli_num_rows($qtsDireccionDespacho);

$query_qtsDireccionCliente = "SELECT * FROM qts_clientesDirecciones WHERE qts_clientesDirecciones.clienteID = '$idCliente' AND qts_clientesDirecciones.principal = '1'";
$qtsDireccionCliente = mysqli_query($DKKadmin, $query_qtsDireccionCliente);
$row_qtsDireccionCliente = mysqli_fetch_assoc($qtsDireccionCliente);
$totalRows_qtsDireccionCliente = mysqli_num_rows($qtsDireccionCliente);

$query_qtsProductosCotizacion = "SELECT * FROM qts_cotizacionesProductos WHERE qts_cotizacionesProductos.idCliente = '$idCliente' AND qts_cotizacionesProductos.idCotizacion = '$idCotizacion' AND qts_cotizacionesProductos.estado = '1' ORDER BY qts_cotizacionesProductos.id DESC";
$qtsProductosCotizacion = mysqli_query($DKKadmin, $query_qtsProductosCotizacion);
$row_qtsProductosCotizacion = mysqli_fetch_assoc($qtsProductosCotizacion);
$totalRows_qtsProductosCotizacion = mysqli_num_rows($qtsProductosCotizacion);

$query_qtsProductosActivos = "SELECT * FROM productos WHERE productos.estado = '1' ORDER BY productos.nombre ASC";
$qtsProductosActivos = mysqli_query($DKKadmin, $query_qtsProductosActivos);
$row_qtsProductosActivos = mysqli_fetch_assoc($qtsProductosActivos);
$totalRows_qtsProductosActivos = mysqli_num_rows($qtsProductosActivos);

$query_subTotal = "SELECT SUM(qts_cotizacionesProductos.total) FROM qts_cotizacionesProductos WHERE qts_cotizacionesProductos.idCotizacion = '$idCotizacion' AND qts_cotizacionesProductos.estado = '1'";
$subTotal = mysqli_query($DKKadmin, $query_subTotal);
$row_subTotal = mysqli_fetch_assoc($subTotal);
$totalRows_subTotal = mysqli_num_rows($subTotal);

$query_qtsObservacionesCotizacion = "SELECT * FROM qts_cotizacionesObservaciones WHERE qts_cotizacionesObservaciones.idCotizacion = '$idCotizacion' AND qts_cotizacionesObservaciones.estado = '1'";
$qtsObservacionesCotizacion = mysqli_query($query_qtsObservacionesCotizacion);
$row_qtsObservacionesCotizacion = mysqli_fetch_assoc($qtsObservacionesCotizacion);
$totalRows_qtsObservacionesCotizacion = mysqli_num_rows($qtsObservacionesCotizacion);

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "observacionesForm")) {
  $insertSQL = sprintf("INSERT INTO qts_cotizacionesObservaciones (observacion, ip, fecha, fechaID, idCreador, idCliente, idCotizacion, estado) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['observacion'], "text"),
                       GetSQLValueString($_POST['ip'], "text"),
                       GetSQLValueString($_POST['fecha'], "text"),
                       GetSQLValueString($_POST['fechaID'], "text"),
                       GetSQLValueString($_POST['idCreador'], "text"),
                       GetSQLValueString($_POST['idCliente'], "text"),
                       GetSQLValueString($_POST['idCotizacion'], "text"),
                       GetSQLValueString($_POST['estado'], "text"));
  $Result1 = mysqli_query($DKKadmin, $insertSQL) or die(mysqli_error($DKKadmin));
  $insertGoTo = "qts_view.php?id=".$idCotizacion;
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "nuevoProductoForm")) {
  $insertSQL = sprintf("INSERT INTO qts_cotizacionesProductos (idProducto, idCliente, idCreador, idCotizacion, qty, precio, statusDscto, dscto, fecha, fechaID, ip, estado) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['idProducto'], "text"),
                       GetSQLValueString($_POST['idCliente'], "text"),
                       GetSQLValueString($_POST['idCreador'], "text"),
                       GetSQLValueString($_POST['idCotizacion'], "text"),
                       GetSQLValueString($_POST['qty'], "text"),
                       GetSQLValueString($_POST['precio'], "text"),
                       GetSQLValueString(isset($_POST['statusDscto']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString($_POST['dscto'], "text"),
                       GetSQLValueString($_POST['fecha'], "text"),
                       GetSQLValueString($_POST['fechaID'], "text"),
                       GetSQLValueString($_POST['ip'], "text"),
                       GetSQLValueString($_POST['estado'], "text"));
  $Result1 = mysqli_query($DKKadmin, $insertSQL) or die(mysqli_error($DKKadmin));
  $insertGoTo = "qts_productos_add.php?id=".$idCotizacion;
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

$ivaCotizacion = ($row_subTotal['SUM(qts_cotizacionesProductos.total)'] * '0.19');
$totalCotizacion = ($row_subTotal['SUM(qts_cotizacionesProductos.total)'] + $ivaCotizacion);
?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>QTE.<?php if ($row_qtsCotizacionEditar["id"] < 10) {echo "0000";} if ($row_qtsCotizacionEditar["id"] < 100 && $row_qtsCotizacionEditar["id"] > 10) {echo "000";} if ($row_qtsCotizacionEditar["id"] < 1000 && $row_qtsCotizacionEditar["id"] > 100) {echo "00";} if ($row_qtsCotizacionEditar["id"] < 10000 && $row_qtsCotizacionEditar["id"] > 1000) {echo "0";} if ($row_qtsCotizacionEditar["id"] < 100000 && $row_qtsCotizacionEditar["id"] > 10000) {echo "";} echo $row_qtsCotizacionEditar["id"]; ?></title>
        <!-- Google Fonts -->
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400italic,600,700%7COpen+Sans:300,400,400italic,600,700">

        <!-- CSS -->
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" id="css-main" href="css/oneui.css">
</head>

<body>
            <main id="main-container">
                <!-- contenido -->
                <div class="content content-boxed">
                    <!-- cotización -->
                    <div class="block">
                        <div class="block-header">
                            <ul class="block-options">
                                <li>
                                    <!-- impresión: App() -> uiHelperPrint() -->
                                    <button type="button" id="btnExportar" ><i class="fa fa-file-pdf-o"></i> Guardar como PDF</button>
                                </li>
                            </ul>
                            <h3 class="block-title">QTE.<?php if ($row_qtsCotizacionEditar["id"] < 10) {echo "0000";} if ($row_qtsCotizacionEditar["id"] < 100 && $row_qtsCotizacionEditar["id"] > 10) {echo "000";} if ($row_qtsCotizacionEditar["id"] < 1000 && $row_qtsCotizacionEditar["id"] > 100) {echo "00";} if ($row_qtsCotizacionEditar["id"] < 10000 && $row_qtsCotizacionEditar["id"] > 1000) {echo "0";} if ($row_qtsCotizacionEditar["id"] < 100000 && $row_qtsCotizacionEditar["id"] > 10000) {echo "";} echo $row_qtsCotizacionEditar["id"]; ?></h3>
                        </div>
                        <div class="block-content block-content-narrow">
                            <!-- info -->
                            <div class="h1 text-center push-30-t push-30 hidden-print">COTIZACIÓN</div>
                            <div class="row">
                            	<div class="col-xs-6 text-left">
                                    <p class="h5 font-w400 push-5"><?php if (isset($row_qtsDatosCliente["razonSocial"]))   echo $row_qtsDatosCliente["razonSocial"]; else echo $row_qtsDatosCliente["nombre"]  ?> </p>
                                    <?php if ($totalRows_qtsDireccionCliente > 0) { ?>
									<?php if ($row_qtsUltimaCotizacion["lugarEntrega"] == '3') { ?>
                                    <address class="font-s12">
                                        <?php if (empty($row_qtsDatosCliente["razonSocial"])) { ?><?php echo $row_qtsDatosCliente["nombre"]; ?><br><?php } ?>
                                        <?php echo $row_qtsDireccionDespacho["direccion1"]; ?><br>
                                        <?php if (isset($row_qtsDireccionDespacho["direccion2"])) echo $row_qtsDireccionDespacho["direccion2"]."<br>"; ?>
                                        <?php echo $row_qtsDireccionDespacho["comuna"].", ".$row_qtsDireccionDespacho["ciudad"].". ".$row_qtsDireccionDespacho["region"]; ?><br>
                                        <i class="si si-call-end"></i> <?php echo $row_qtsDatosCliente["telefono"]; ?><br>
                                        <i class="si si-envelope"></i> <?php echo $row_qtsDatosCliente["correo"]; ?>
                                    </address>
                                    <?php } ?>
                                    <?php if ($row_qtsUltimaCotizacion["lugarEntrega"] != '3') { ?>
                                    <address class="font-s12">
                                        <?php echo $row_qtsDatosCliente["nombre"]; ?><br>
										<?php echo $row_qtsDireccionCliente["direccion1"]; ?><br>
                                        <?php if (isset($row_qtsDireccionCliente["direccion2"])) echo $row_qtsDireccionCliente["direccion2"]."<br>"; ?>
                                        <?php echo $row_qtsDireccionCliente["comuna"].", ".$row_qtsDireccionCliente["ciudad"].". ".$row_qtsDireccionCliente["region"]; ?><br>
                                        <i class="si si-call-end"></i> <?php echo $row_qtsDatosCliente["telefono"]; ?><br>
                                        <i class="si si-envelope"></i> <?php echo $row_qtsDatosCliente["correo"]; ?>
                                    </address>
                                    <?php } ?>
                                    <?php } //Mostrar si tiene direcciones regitradas ?>
                                    <?php if ($totalRows_qtsDireccionCliente == 0) { ?>
                                    <address class="font-s12">
                                        <?php echo $row_qtsDatosCliente["nombre"]; ?><br>
                                        <strong>RUT:</strong> <?php echo $row_qtsDatosCliente["rut"]; ?><br>
                                        <i class="si si-call-end"></i> <?php echo $row_qtsDatosCliente["telefono"]; ?><br>
                                        <i class="si si-envelope"></i> <?php echo $row_qtsDatosCliente["correo"]; ?>
                                    </address>
                                    <?php } //Mostrar si NO tiene direcciones regitradas ?>
                                    <p class="h5 font-w400 push-5">Términos</p>
                                    <address class="font-s12">
                                        <strong>Lugar de Entrega:</strong> <?php if ($row_qtsCotizacionEditar["lugarEntrega"] == '1') {echo"Bodegas IRC";} if ($row_qtsCotizacionEditar["lugarEntrega"] == '2') {echo"Oficinas IRC";} if ($row_qtsCotizacionEditar["lugarEntrega"] == '3') {echo"Despacho";} ?><br>
                                        <strong>Tiempo de Entrega:</strong> <?php if ($row_qtsCotizacionEditar["tiempoEntrega"] == '1') {echo"Inmediato";} if ($row_qtsCotizacionEditar["tiempoEntrega"] == '2') {echo"60 días";} if ($row_qtsCotizacionEditar["tiempoEntrega"] == '3') {echo $row_qtsCotizacionEditar["tiempoEntregaAdicional"];} ?><br>
                                        <strong>Método de Pago:</strong> <?php if ($row_qtsCotizacionEditar["metodoPago"] == '1') {echo"Transferencia";} if ($row_qtsCotizacionEditar["metodoPago"] == '2') {echo"Depósito";} if ($row_qtsCotizacionEditar["metodoPago"] == '3') {echo "Tarjeta de Crédito <small>".$row_qtsCotizacionEditar["metodoPagoAdicional"]."</small>";} ?><br>
                                        <!-- <strong>Forma de Pago:</strong> <?php if ($row_qtsCotizacionEditar["formaPago"] == '1') {echo"100%";} if ($row_qtsCotizacionEditar["formaPago"] == '2') {echo"30% Reserva / 70% Contra Entrega <small>Contado</small>";} if ($row_qtsCotizacionEditar["formaPago"] == '3') {echo"30% Reserva / 70% Contra Entrega <small>Tarjeta de Crédito</small>";} ?> -->
                                    </address>
                                </div>
                            	<div class="col-xs-6 text-right">
                                	<img src="../images/logo.png" width="120" height="auto" alt="<?php echo $row_qtsMetaDatos["titulo"]; ?>">
                                    <address class="font-s12">
                                        <?php echo $row_qtsMetaDatos["direccion"]; ?><br>
                                        <i class="si si-call-end"></i> <?php echo $row_qtsMetaDatos["telefono"]; ?><br>
                                        <i class="si si-envelope"></i> <?php echo $row_qtsMetaDatos["correo"]; ?><br>
                                        <b>Fecha de Emisión:</b> <?php echo $fechaDMA; ?>
                                    </address>
                                    <span class="label label-<?php if ($row_qtsCotizacionEditar["estado"] == '1') { echo "warning"; } if ($row_qtsCotizacionEditar["estado"] == '2') { echo "success"; } if ($row_qtsCotizacionEditar["estado"] == '3') { echo "primary"; } if ($row_qtsCotizacionEditar["estado"] == '0') { echo "danger"; }; ?>"><?php if ($row_qtsCotizacionEditar["estado"] == '1') { echo "INGRESADA"; } if ($row_qtsCotizacionEditar["estado"] == '2') { echo "ENVIADA"; } if ($row_qtsCotizacionEditar["estado"] == '3') { echo "CANCELADA"; } if ($row_qtsCotizacionEditar["estado"] == '0') { echo "ELIMINADA"; }; ?></span>
                                </div>
                            </div>
                            <hr class="hidden-print">

                            <!-- productos -->
                            <div class="table-responsive">
                                <div class="block">
                                    <div class="block-options">
                                    </div>
                                    <div class="block-header">
                                        <h4 class="block-title">Detalle</h4>
                                    </div>
                                    <div class="block-content remove-padding-l remove-padding-r">
                                        <?php if ($totalRows_qtsProductosCotizacion == 0) { ?>
                                        <p>Aún no hay productos en esta cotización. <a href="" data-toggle="modal" data-target="#nuevoProducto">Añade el primero.</a>
                                        <?php } //Si hay productos ?>
                                        <?php if ($totalRows_qtsProductosCotizacion > 0) { ?>
                                        <table class="table table-bordered table-hover font-s12">
                                            <thead>
                                                <tr>
                                                    <th style="width: 70px; text-align:center;"></th>
                                                    <th>Producto</th>
                                                    <th class="text-right" style="width: 120px;">Precio</th>
                                                    <th class="text-center" style="width: 100px;">Dscto</th>
                                                    <th class="text-center" style="width: 100px;">Qty</th>
                                                    <th class="text-right" style="width: 140px;">SubTotal</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                
												<?php do { ?>
                                                <?php 
                                                $idProductosCotizados = $row_qtsProductosCotizacion["idProducto"];
                                                $seleccionaProductosCotizados = mysqli_query($DKKadmin,"SELECT * FROM productos WHERE productos.id = '$idProductosCotizados' ORDER BY productos.id ASC"); if(mysqli_num_rows($seleccionaProductosCotizados) == 0) { echo "No hay productos"; } else { ?>
                                                  <?php $counter = 1; while($pCotizados = mysqli_fetch_array($seleccionaProductosCotizados)) { ?>

                                                <tr>
                                                    <td class="image" style="width: 70px; text-align:center;"><img src="../images/productos/thumbs/<?php echo $pCotizados["imagen1"]; ?>" alt="<?php echo $pCotizados["nombre"]; ?>" width="40" height="40"/></td>
                                                    <td>
                                                        <p class="font-w600 push-10"><?php echo $pCotizados["nombre"]; ?></p>
                                                        <div class="text-muted"><?php echo strtoupper(str_replace("-"," ",$pCotizados["categoriaSEO"])); ?></div>
                                                    </td>
                                                    <td class="text-right"><?php if ($pCotizados["statusOferta"] == '0') echo "$".number_format($pCotizados["precio"],0,",","."); if ($pCotizados["statusOferta"] == '1') echo "$".number_format($pCotizados["precioOferta"],0,",","."); ?></td>
                                                    <td class="text-right"><?php if ($row_qtsProductosCotizacion["statusDscto"] == '1') { echo "$".number_format($row_qtsProductosCotizacion["dscto"],0,",","."); } else { echo "0"; } ?></td>
                                                    <?php if ($row_qtsProductosCotizacion["qty"] >= $pCotizados["qtyMinima"]) { ?>
                                                    <td class="text-center"><span class="badge badge-primary"><?php echo $row_qtsProductosCotizacion["qty"]; ?></span></td>
                                                    <?php } ?>
                                                    <?php if ($row_qtsProductosCotizacion["qty"] < $pCotizados["qtyMinima"]) { ?>
                                                    <td class="text-center"><span class="badge badge-primary"><?php echo $pCotizados["qtyMinima"]; ?></span></td>
                                                    <?php } ?>
                                                    <td class="text-right"><?php echo "$".number_format($row_qtsProductosCotizacion["total"],0,",","."); ?></td>
                                                </tr>
                                                
                                                  <?php } ?>
                                                <?php } ?>
                                                <?php } while ($row_qtsProductosCotizacion = mysqli_fetch_assoc($qtsProductosCotizacion)); ?>
        
                                                <tr>
                                                    <td colspan="5" class="font-w600 text-right">Subtotal</td>
                                                    <td class="text-right"><?php echo "$ ".number_format($row_subTotal['SUM(qts_cotizacionesProductos.total)'],0,",","."); ?></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="5" class="font-w600 text-right">IVA</td>
                                                    <td class="text-right"><?php echo "$ ".number_format($ivaCotizacion,0,",","."); ?></td>
                                                </tr>
                                                <tr class="active">
                                                    <td colspan="5" class="font-w700 text-uppercase text-right">Total</td>
                                                    <td class="font-w700 text-right"><?php echo "$ ".number_format($totalCotizacion,0,",","."); ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <?php } //Si hay productos ?>
                                    </div>
								</div>
                                
                                <?php if ($totalRows_qtsObservacionesCotizacion > 0) { ?>
                                <div class="block block-bordered">
                                    <div class="block-header">
                                        <h4 class="block-title">Observaciones</h4>
                                    </div>
                                    <div class="block-content">
                                        <p class="font-s12"><?php echo $row_qtsObservacionesCotizacion["observacion"]; ?></p>
                                    </div>
                                </div>
                                <?php } //Mostrar si hay observaciones ?>

                            </div>
                            <!-- END productos -->

                            <!-- footer -->
                            <hr class="hidden-print">
                            <p class="text-muted text-center"><small><?php echo "PRODALUM Ltda. | ".$row_qtsMetaDatos["direccion"]." | ".$row_qtsMetaDatos["telefono"]." | ".$row_qtsMetaDatos["correo"]; ?></small></p>
                            <!-- END footer -->
                        </div>
                    </div>
                    <!-- END Invoice -->
                </div>
                <!-- END Page Content -->
            </main>
		<script src="http://html2canvas.hertzen.com/build/html2canvas.js" type="text/javascript"></script>
		<script src="js/core/jquery.min.js"></script>
        <script src="js/core/bootstrap.min.js"></script>
        <script src="js/core/jquery.slimscroll.min.js"></script>
        <script src="js/core/jquery.scrollLock.min.js"></script>
        <script src="js/core/jquery.appear.min.js"></script>
        <script src="js/core/jquery.countTo.min.js"></script>
        <script src="js/core/jquery.placeholder.min.js"></script>
        <script src="js/core/js.cookie.min.js"></script>
        <script src="js/app.js"></script>
        <script>
		$(document).ready(function (){
			$("#btnExportar").on("click",function(){
				
				var doc = new jsPDF();
				var imgHeight=140 ;
				var imgWidth=140 ;
				var positionY=20;
				var positionX=20;
				
				doc.setFontSize(15);
				doc.text(15, 15, "Hola JSPDF y html2canvas");
					
				html2canvas($("#content"), {
					onrendered: function(canvas) {
						var img = canvas.toDataURL("image/jpeg");
						doc.addImage(img, 'JPEG', positionX ,  positionY, 140, imgWidth);
						doc.save('QTE_<?php if ($row_qtsCotizacionEditar["id"] < 10) {echo "0000";} if ($row_qtsCotizacionEditar["id"] < 100 && $row_qtsCotizacionEditar["id"] > 10) {echo "000";} if ($row_qtsCotizacionEditar["id"] < 1000 && $row_qtsCotizacionEditar["id"] > 100) {echo "00";} if ($row_qtsCotizacionEditar["id"] < 10000 && $row_qtsCotizacionEditar["id"] > 1000) {echo "0";} if ($row_qtsCotizacionEditar["id"] < 100000 && $row_qtsCotizacionEditar["id"] > 10000) {echo "";} echo $row_qtsCotizacionEditar["id"]; ?>.pdf');
						}	
				});
				
				});
				
			});
		</script>
</body>
</html>
<?php
mysqli_free_result($datosAdmin);

mysqli_free_result($contactosPendientes);

mysqli_free_result($qtsCotizacionEditar);

mysqli_free_result($qtsDatosCliente);

mysqli_free_result($qtsMetaDatos);

mysqli_free_result($qtsDireccionDespacho);

mysqli_free_result($qtsDireccionCliente);

mysqli_free_result($qtsProductosCotizacion);

mysqli_free_result($qtsProductosActivos);

mysqli_free_result($subTotal);

mysqli_free_result($qtsObservacionesCotizacion);
?>
