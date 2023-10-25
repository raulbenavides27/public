<?php require_once('../Connections/DKKadmin.php'); ?>
<?php
$idAdmin = $_SESSION["MM_idAdmin"];

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

$query_datosAdmin = "SELECT * FROM admin WHERE admin.id = '$idAdmin'";
$datosAdmin = mysqli_query($DKKadmin, $query_datosAdmin) or die(mysqli_error($DKKadmin));
$row_datosAdmin = mysqli_fetch_assoc($datosAdmin);
$totalRows_datosAdmin = mysqli_num_rows($datosAdmin);

$query_contactosPendientes = "SELECT * FROM contacto WHERE contacto.estado = '1' ORDER BY contacto.id DESC";
$contactosPendientes = mysqli_query($DKKadmin, $query_contactosPendientes) or die(mysqli_error($DKKadmin));
$row_contactosPendientes = mysqli_fetch_assoc($contactosPendientes);
$totalRows_contactosPendientes = mysqli_num_rows($contactosPendientes);
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start($DKKadmin);
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['correo'])) {
  $loginUsername=$_POST['correo'];
  $password=$_POST['password'];
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "../admin";
  $MM_redirectLoginFailed = "lock.php";
  $MM_redirecttoReferrer = false;
  
  $LoginRS__query=sprintf("SELECT id, correo, password FROM admin WHERE correo=%s AND password=%s",
    GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysqli_query($DKKadmin, $LoginRS__query) or die(mysqli_error($DKKadmin));
  $row_LoginRS = mysqli_fetch_assoc($LoginRS);
  $loginFoundUser = mysqli_num_rows($LoginRS);
  if ($loginFoundUser) {
     $loginStrGroup = "";
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id($DKKadmin);}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      
    $_SESSION['MM_idAdmin'] = $row_LoginRS["id"];	      

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>
<!DOCTYPE html>
<!--[if IE 9]>         <html class="ie9 no-focus" lang="es"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-focus" lang="es"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">

        <title>Origen | Pantalla Bloqueada</title>

        <meta name="description" content="Origen es la plataforma de administración diseñada con el fin de entregar una herramienta eficiente y eficaz al momento de mantener el control sobre áreas específicas o generales de cualquier organización, empresa o grupo de personas.">
        <meta name="author" content="DiegoKingKong">
        <meta name="robots" content="noindex, nofollow">
        <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1.0">

        <!-- favicon -->
        <link rel="shortcut icon" href="img/favicons/favicon.png">

        <link rel="icon" type="image/png" href="img/favicons/favicon-16x16.png" sizes="16x16">
        <link rel="icon" type="image/png" href="img/favicons/favicon-32x32.png" sizes="32x32">
        <link rel="icon" type="image/png" href="img/favicons/favicon-96x96.png" sizes="96x96">
        <link rel="icon" type="image/png" href="img/favicons/favicon-160x160.png" sizes="160x160">
        <link rel="icon" type="image/png" href="img/favicons/favicon-192x192.png" sizes="192x192">

        <link rel="apple-touch-icon" sizes="57x57" href="img/favicons/apple-touch-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="img/favicons/apple-touch-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="img/favicons/apple-touch-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="img/favicons/apple-touch-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="img/favicons/apple-touch-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="img/favicons/apple-touch-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="img/favicons/apple-touch-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="img/favicons/apple-touch-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="img/favicons/apple-touch-icon-180x180.png">
        <!-- END favicon -->

        <!-- Estilos -->
        <!-- Google Fonts -->
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400italic,600,700%7COpen+Sans:300,400,400italic,600,700">

        <!-- CSS -->
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" id="css-main" href="css/oneui.css">
        <!-- END Estilos -->
    </head>
    <body class="bg-image" style="background-image: url('img/bg/1.jpg');">
        <!-- contenido -->
        <div class="bg-white pulldown">
            <div class="content content-boxed overflow-hidden">
                <div class="row">
                    <div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
                        <div class="push-50-t push-50 animated fadeIn">
                            <!-- avatar -->
                            <div class="text-center">
                                <img class="img-avatar img-avatar96" src="img/avatars/<?php echo $row_datosAdmin["avatar"]; ?>" alt="Desbloquear Cuenta | <?php echo $row_datosAdmin["nombre"]; ?>">
                            </div>
                            <!-- END avatar -->

                            <form class="form-horizontal push-50-t" action="<?php echo $loginFormAction; ?>" method="POST" name="ingreso">
                                <div class="form-group"> 
                                    <div class="col-xs-12">
                                        <div class="form-material form-material-primary">
                                            <input class="form-control" type="password" id="password" name="password" placeholder="Ingresa tu Contraseña">
                                            <label for="password">Contraseña</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-xs-12 col-sm-6 col-sm-offset-3">
                                        <input type="hidden" name="correo" value="<?php echo $row_datosAdmin["correo"]; ?>">
                                        <button class="btn btn-sm btn-block btn-default" type="submit">Desbloquear Cuenta</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END Lock Screen Content -->

        <!-- Lock Screen Footer -->
        <div class="pulldown push-30-t text-center animated fadeInUp">
            <small class="text-white-op font-w600"><span class="js-year-copy"></span> &copy; OneUI 3.4</small>
        </div>
        <!-- END Lock Screen Footer -->

        <!-- OneUI Core JS: jQuery, Bootstrap, slimScroll, scrollLock, Appear, CountTo, Placeholder, Cookie and App.js -->
        <script src="js/core/jquery.min.js"></script>
        <script src="js/core/bootstrap.min.js"></script>
        <script src="js/core/jquery.slimscroll.min.js"></script>
        <script src="js/core/jquery.scrollLock.min.js"></script>
        <script src="js/core/jquery.appear.min.js"></script>
        <script src="js/core/jquery.countTo.min.js"></script>
        <script src="js/core/jquery.placeholder.min.js"></script>
        <script src="js/core/js.cookie.min.js"></script>
        <script src="js/app.js"></script>
    </body>
</html>
<?php
mysqli_free_result($datosAdmin);

mysqli_free_result($contactosPendientes);
?>