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
$ip = $_SERVER["REMOTE_ADDR"];
$idAdmin = $_SESSION["MM_idAdmin"];
$fecha = date('Y-m-d H:i:s');
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

$query_datosAdmin = "SELECT * FROM `admin` WHERE `admin`.id = '$idAdmin'";
$datosAdmin = mysqli_query($DKKadmin, $query_datosAdmin);
$row_datosAdmin = mysqli_fetch_assoc($datosAdmin);
$totalRows_datosAdmin = mysqli_num_rows($datosAdmin);

$cotizacionID = $_GET["id"];
$query_cotizacionView = sprintf("SELECT * FROM qts_cotizaciones WHERE qts_cotizaciones.id = '$cotizacionID'");
$cotizacionView = mysqli_query($DKKadmin, $query_cotizacionView);
$row_cotizacionView = mysqli_fetch_assoc($cotizacionView);
$totalRows_cotizacionView = mysqli_num_rows($cotizacionView);

$idDespacho = $row_cotizacionView["lugarEntregaID"];
$idCotizacion = $row_cotizacionView["id"];
$idCliente = $row_cotizacionView["clienteID"];
$idCreador = $row_cotizacionView["creadorID"];

$query_datosCliente = "SELECT * FROM qts_clientes WHERE qts_clientes.id = '$idCliente'";
$datosCliente = mysqli_query($DKKadmin, $query_datosCliente);
$row_datosCliente = mysqli_fetch_assoc($datosCliente);
$totalRows_datosCliente = mysqli_num_rows($datosCliente);

$query_metaDatos = "SELECT * FROM metaDatos ORDER BY metaDatos.id DESC";
$metaDatos = mysqli_query($DKKadmin, $query_metaDatos);
$row_metaDatos = mysqli_fetch_assoc($metaDatos);
$totalRows_metaDatos = mysqli_num_rows($metaDatos);

$query_direccionDespacho = "SELECT * FROM qts_clientesDirecciones WHERE qts_clientesDirecciones.id = '$idDespacho'";
$direccionDespacho = mysqli_query($DKKadmin, $query_direccionDespacho);
$row_direccionDespacho = mysqli_fetch_assoc($direccionDespacho);
$totalRows_direccionDespacho = mysqli_num_rows($direccionDespacho);

$query_direccionCliente = "SELECT * FROM qts_clientesDirecciones WHERE qts_clientesDirecciones.clienteID = '$idCliente' AND qts_clientesDirecciones.principal = '1'";
$direccionCliente = mysqli_query($DKKadmin, $query_direccionCliente);
$row_direccionCliente = mysqli_fetch_assoc($direccionCliente);
$totalRows_direccionCliente = mysqli_num_rows($direccionCliente);

$query_productosCotizados = "SELECT * FROM qts_cotizacionesProductos WHERE qts_cotizacionesProductos.idCliente = '$idCliente' AND qts_cotizacionesProductos.idCotizacion = '$idCotizacion' AND qts_cotizacionesProductos.estado = '1' ORDER BY qts_cotizacionesProductos.id DESC";
$productosCotizados = mysqli_query($DKKadmin, $query_productosCotizados);
$row_productosCotizados = mysqli_fetch_assoc($productosCotizados);
$totalRows_productosCotizados = mysqli_num_rows($productosCotizados);

$query_productosActivos = "SELECT * FROM productos WHERE productos.estado = '1' ORDER BY productos.nombre ASC";
$productosActivos = mysqli_query($DKKadmin, $query_productosActivos);
$row_productosActivos = mysqli_fetch_assoc($productosActivos);
$totalRows_productosActivos = mysqli_num_rows($productosActivos);

$query_subTotal = "SELECT SUM(qts_cotizacionesProductos.total) FROM qts_cotizacionesProductos WHERE qts_cotizacionesProductos.idCotizacion = '$idCotizacion' AND qts_cotizacionesProductos.estado = '1'";
$subTotal = mysqli_query($DKKadmin, $query_subTotal);
$row_subTotal = mysqli_fetch_assoc($subTotal);
$totalRows_subTotal = mysqli_num_rows($subTotal);

$query_observaciones = "SELECT * FROM qts_cotizacionesObservaciones WHERE qts_cotizacionesObservaciones.idCotizacion = '$idCotizacion' AND qts_cotizacionesObservaciones.estado = '1'";
$observaciones = mysqli_query($DKKadmin, $query_observaciones);
$row_observaciones = mysqli_fetch_assoc($observaciones);
$totalRows_observaciones = mysqli_num_rows($observaciones);

$query_ejecutivos = "SELECT * FROM admin WHERE admin.id = '$idCreador' ORDER BY admin.id ASC";
$ejecutivos = mysqli_query($DKKadmin, $query_ejecutivos);
$row_ejecutivos = mysqli_fetch_assoc($ejecutivos);
$totalRows_ejecutivos = mysqli_num_rows($ejecutivos);

$ivaCotizacion = ($row_subTotal['SUM(qts_cotizacionesProductos.total)'] * '0.19');
$totalCotizacion = ($row_subTotal['SUM(qts_cotizacionesProductos.total)'] + $ivaCotizacion);
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="iso-8859-1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <meta name="robots" content="none" />
    <link rel="SHORTCUT ICON" href="http://importadorarc.cl/ico/favicon.ico"/>
    <title>QTE.<?php if ($row_cotizacionView["id"] < 10) {echo "0000";} if ($row_cotizacionView["id"] < 100 && $row_cotizacionView["id"] > 10) {echo "000";} if ($row_cotizacionView["id"] < 1000 && $row_cotizacionView["id"] > 100) {echo "00";} if ($row_cotizacionView["id"] < 10000 && $row_cotizacionView["id"] > 1000) {echo "0";} if ($row_cotizacionView["id"] < 100000 && $row_cotizacionView["id"] > 10000) {echo "";} echo $row_cotizacionView["id"]; ?></title> 
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,600,700&amp;subset=latin-ext" rel="stylesheet">
    <style>
	body {
		width:95%;
		height:auto;
		margin-left:auto;
		margin-right:auto;
		}
	p {
		margin:0;
		padding:0;
		}
	#contenido {
		margin-top:20px;
		margin-left:20px;
		margin-right:20px;
		font-family: 'Open Sans', sans-serif;
		}
	.qte_info {
		width:100%;
		float:left;
		height:auto;
		}
	.qte_irc {
		float:left;
		height:auto;
		width:322px;
		}
	.qte_id {
		float:right;
		height:auto;
		width:250;
		}	
	.qte_logo {
		width:100px;
		height:60px;
		float:left;
		}	
	.qte_datos {
		width:222px;
		height:auto;
		float:right;
		font-size:12px;
		}
	.qte_numero {
		width:200px;
		height:60px;
		float:right;
		border: #F00 solid medium;
		text-align:center;
		text-transform:uppercase;
		padding-top:10px;
		font-size:10px;
		color:#F00;
		}
	.qte_cliente {
		margin-top:20px;
		margin-bottom:20px;
		width:100%;
		height:auto;
		float:left;
		font-size:12px;
		}
	.qte_condiciones {
		margin-top:40px;
		margin-bottom:20px;
		width:100%;
		height:auto;
		float:left;
		font-size:9px;
		}
	.qte_productos {
		margin-top:10px;
		width:100%;
		height:auto;
		float:right;
		font-size:12px;
		}
	.qte_productos_head {
		background-color:#333;
		color:#FFF;
		text-align:center;
		}
	.qte_productos_total {
		text-align:right;
		}
	.qte_tabla tr td {
		border: 1px #000 solid;
		}	
	.qte_tabla {
		border-collapse: collapse;
		}	
	.qte_tabla_precio tr td {
		border-bottom: 1px #000 solid;
		border-left: 1px #000 solid;
		border-right: 1px #000 solid;
		border-top: none;
		}	
	.qte_tabla_precio {
		border-collapse: collapse;
		}	
	.qte_observaciones {
		text-transform:none;
		}
	.qte_header_print {
		width:100%;
		float:left;
		height:70px;
		background-color:#efefef;
		margin-top:0px;
		margin-bottom:20px;
		}	
	.qte_button {
		background-color: #555555;
		border: none;
		color: white;
		padding: 15px 32px;
		text-align: center;
		text-decoration: none;
		display: inline-block;
		font-size: 16px;
		margin-top:12px;
		margin-right:12px;
		float:right;
	}
	@media all {
	   div.saltopagina{
		  display: none;
	   }
	}
	   
	@media print{
	   div.saltopagina{ 
		  display:block; 
		  page-break-before:always;
	   }
	}
	</style>
    <script language="javascript" type="text/javascript">
        function printDiv(divID) {
            //Get the HTML of div
            var divElements = document.getElementById(divID).innerHTML;
            //Get the HTML of whole page
            var oldPage = document.body.innerHTML;
            //Reset the page's HTML with div's HTML only
            document.body.innerHTML = 
              "<html><head><title></title></head><body>" + 
              divElements + "</body>";
            //Print Page
            window.print();
            //Restore orignal HTML
            document.body.innerHTML = oldPage;
        }
    </script>
  </head>
<body>
<div id="contenido">
	<div id="donotprintdiv" class="qte_header_print">
        <input type="button" value="Imprimir" onclick="javascript:printDiv('printablediv')" class="qte_button" />
    </div>
    <div id="printablediv">
        <div class="qte_info">
            <div class="qte_irc">
                <div class="qte_logo">
                    <img src="images/logo.png" width="100" height="59">
                </div>
                <div class="qte_datos">
                <p>
                <b>Prodalum</b><br>
                <?php echo str_replace("3559, ","3559<br>",$row_metaDatos['direccion']); ?><br>
                <?php echo $row_metaDatos['telefono']; ?> / <?php echo $row_metaDatos['correo']; ?><br>
                www.prodalum.cl</p>
                </div>
            </div>
            <div class="qte_id">
                <div class="qte_numero">
                    <p><b>
                    RUT: <?php echo $row_metaDatos['RUT']; ?><br>
                    cotizaci&Oacute;n<br>
                    n&ordm; <?php if ($row_cotizacionView["id"] < 10) {echo "0000";} if ($row_cotizacionView["id"] < 100 && $row_cotizacionView["id"] > 10) {echo "000";} if ($row_cotizacionView["id"] < 1000 && $row_cotizacionView["id"] > 100) {echo "00";} if ($row_cotizacionView["id"] < 10000 && $row_cotizacionView["id"] > 1000) {echo "0";} if ($row_cotizacionView["id"] < 100000 && $row_cotizacionView["id"] > 10000) {echo "";} echo $row_cotizacionView["id"]; ?>
                    </b></p>
                </div>
            </div>
        </div>
        
        <div class="qte_cliente">
            <table width="100%" class="qte_tabla">
                <tr>
                    <td width="86">Raz&oacute;n Social</td>
                    <td width="250"><?php if (isset($row_datosCliente["razonSocial"]))   echo $row_datosCliente["razonSocial"]; else echo $row_datosCliente["nombre"]  ?></td>
                    <td width="86">RUT</td>
                    <td width="150"><?php echo $row_datosCliente["rut"]; ?></td>
                </tr>
                <tr>
                    <td width="86">Correo</td>
                    <td width="250"><?php echo $row_datosCliente["correo"]; ?></td>
                    <td width="86">Fono</td>
                    <td width="150"><?php echo $row_datosCliente["telefono"]; ?></td>
                </tr>
                <tr>
                    <td width="86">Comuna</td>
                    <td width="250"><?php echo $row_datosCliente["comuna"]; ?></td>
                    <td width="86">Fecha</td>
                    <td width="150"><?php echo date("d/m/Y",$row_cotizacionView["fechaID"]); ?></td>
                </tr>
                <tr>
                    <td width="86">Forma de Pago</td>
                    <td width="250"><?php if ($row_cotizacionView["formaPago"] == '1') {echo"100%";} if ($row_cotizacionView["formaPago"] == '2') {echo"30% Reserva / 70% Contra Entrega <small>Contado</small>";} if ($row_cotizacionView["formaPago"] == '3') {echo"30% Reserva / 70% Contra Entrega <small>Tarjeta de Crédito</small>";} ?></td>
                    <td width="86">M&eacute;todo Pago</td>
                    <td width="150"><?php if ($row_cotizacionView["metodoPago"] == '1') {echo"Efectivo, Debito, Credito o Transferencia Bancaria";} if ($row_cotizacionView["metodoPago"] == '2') {echo"Otro";} if ($row_cotizacionView["metodoPago"] == '3') {echo "Tarjeta de Crédito <small>".$row_cotizacionView["metodoPagoAdicional"]."</small>";} ?></td>
                </tr>
                <tr>
                    <td width="86">Lugar de Entrega</td>
                    <td width="250"><?php if ($row_cotizacionView["lugarEntrega"] == '1') {echo"Retiro en Prodalum";} if ($row_cotizacionView["lugarEntrega"] == '2') {echo"Por Coordinar";} if ($row_cotizacionView["lugarEntrega"] == '3') {echo"Despacho";} ?></td>
                    <td width="86">Plazo Entrega</td>
                    <td width="150"><?php if ($row_cotizacionView["tiempoEntrega"] == '1') {echo"Inmediato";} if ($row_cotizacionView["tiempoEntrega"] == '2') {echo"25 a 30 dias";} if ($row_cotizacionView["tiempoEntrega"] == '3') {echo $row_cotizacionView["tiempoEntregaAdicional"];} ?></td>
                </tr>
                <tr>
                    <td width="86">Ejecutivo</td>
                    <td width="250"><?php echo $row_ejecutivos["nombre"]." ".$row_ejecutivos["apellido"]; ?> </td>
                    <td width="86">Validez</td>
                    <td width="150">5 d&iacute;as</td>
                </tr>
            </table>
        </div>
        <div class="qte_productos">
            <table width="100%" class="qte_tabla">
                <tr class="qte_productos_head">
                    <td width="66"></td>
                    <td width="260">Producto</td>
                    <td width="33">QTY</td>
                    <td width="90">Precio Unit.</td>
                    <td width="33">Dcto.</td>
                    <td width="90">Total</td>
                </tr>
                <?php do { ?>
                <?php 
                $idProductosCotizados = $row_productosCotizados["idProducto"];
                $seleccionaProductosCotizados = mysqli_query($DKKadmin,"SELECT * FROM productos WHERE productos.id = '$idProductosCotizados' ORDER BY productos.id ASC"); if(mysqli_num_rows($seleccionaProductosCotizados) == 0) { echo "No hay productos"; } else { ?>
                <?php $counter = 1; while($pCotizados = mysqli_fetch_array($seleccionaProductosCotizados)) { ?>
                <tr class="qte_productos_body">
                    <td width="66" align="center"><img src="../images/productos/<?php echo $pCotizados["imagen1"]; ?>" alt="<?php echo $pCotizados["nombre"]; ?>" width="60" height="auto"/></td>
                    <td width="250"><?php echo $pCotizados["nombre"]; ?></td>
                    <?php if ($row_productosCotizados["qty"] >= $pCotizados["qtyMinima"]) { ?>
                    <td width="33" align="center"><?php echo $row_productosCotizados["qty"]; ?></td>
                    <?php } ?>
                    <?php if ($row_productosCotizados["qty"] < $pCotizados["qtyMinima"]) { ?>
                    <td width="33" align="center"><?php echo $pCotizados["qtyMinima"]; ?></td>
                    <?php } ?>
                    <td width="90" align="center"><?php echo "$".number_format($row_productosCotizados["precio"],0,",","."); ?></td>
                    <td width="43" align="center"><?php if ($row_productosCotizados["statusDscto"] == '1') { echo "$".number_format($row_productosCotizados["dscto"],0,",","."); } else { echo "0"; } ?></td>
                    <td width="90" align="center"><?php echo "$".number_format($row_productosCotizados["total"],0,",","."); ?></td>
                </tr>
                <?php } ?>
                <?php } ?>
                <?php } while ($row_productosCotizados = mysqli_fetch_assoc($productosCotizados)); ?>
    
            </table>
            <table width="100%" class="qte_tabla_precio">
                <tr class="qte_productos_total">
                    <td width="502">SUBTOTAL</td>
                    <td width="90" align="center"><?php echo "$ ".number_format($row_subTotal['SUM(qts_cotizacionesProductos.total)'],0,",","."); ?></td>
                </tr>
                <tr class="qte_productos_total">
                    <td width="482">IVA</td>
                    <td width="90" align="center"><?php echo "$ ".number_format($ivaCotizacion,0,",","."); ?></td>
                </tr>
                <tr class="qte_productos_total">
                    <td width="482">TOTAL</td>
                    <td width="90" align="center"><?php echo "$ ".number_format($totalCotizacion,0,",","."); ?></td>
                </tr>
            </table>
        </div>
        <div class="qte_cliente">
            <table width="100%" class="qte_tabla">
                <tr>
                    <td width="86">Observaciones</td>
                    <td width="486"><b>Confirmar Stock al Momento de la Compra.</b>
                    <p><b>Forma de Compra:</b> Con Orden de Compra, Por esta Via, o Personalmente .<br>
                    <b>Formas de Pago:</b> Contra entrega con Tarjetas de Debito o de Credito.<br>
                    <b>Contra entrega con Deposito Bancario  o  Transferencia.</b><br>
                    <b>DATOS TRANSFERENCIA:</b><br>
                    BANCO SANTANDER<br>
                    CTA. CTE. 283920012-0<br>
                    RUT: 84.260.700-0<br>
                    A: PRODALUM S.A
                    </td>
                </tr>
            </table>
        </div>
        <div class="saltopagina"></div>
        <div class="qte_condiciones">

        </div>
    </div>
</div>
</body>
</html>
<?php
mysqli_free_result($datosAdmin);

mysqli_free_result($cotizacionView);

mysqli_free_result($datosCliente);

mysqli_free_result($metaDatos);

mysqli_free_result($direccionDespacho);

mysqli_free_result($direccionCliente);

mysqli_free_result($productosCotizados);

mysqli_free_result($productosActivos);

mysqli_free_result($subTotal);

mysqli_free_result($observaciones);

mysqli_free_result($ejecutivos);
?>
