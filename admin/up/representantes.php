<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Subir Fotograf&iacute;a</title>
        <!-- favicon -->
        <link rel="shortcut icon" href="../img/favicons/favicon.png">

        <link rel="icon" type="image/png" href="../img/favicons/favicon-16x16.png" sizes="16x16">
        <link rel="icon" type="image/png" href="../img/favicons/favicon-32x32.png" sizes="32x32">
        <link rel="icon" type="image/png" href="../img/favicons/favicon-96x96.png" sizes="96x96">
        <link rel="icon" type="image/png" href="../img/favicons/favicon-160x160.png" sizes="160x160">
        <link rel="icon" type="image/png" href="../img/favicons/favicon-192x192.png" sizes="192x192">

        <link rel="apple-touch-icon" sizes="57x57" href="../img/favicons/apple-touch-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="../img/favicons/apple-touch-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="../img/favicons/apple-touch-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="../img/favicons/apple-touch-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="../img/favicons/apple-touch-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="../img/favicons/apple-touch-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="../img/favicons/apple-touch-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="../img/favicons/apple-touch-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="../img/favicons/apple-touch-icon-180x180.png">
        <!-- END favicon -->

        <!-- Estilos -->
        <!-- Google Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400italic,600,700%7COpen+Sans:300,400,400italic,600,700">

        <!-- CSS -->
        <link rel="stylesheet" href="../css/bootstrap.min.css">
        <link rel="stylesheet" id="css-main" href="../css/oneui.css">
        <link rel="stylesheet" href="../js/plugins/select2/select2.min.css">
        <link rel="stylesheet" href="../js/plugins/select2/select2-bootstrap.min.css">
        <link rel="stylesheet" href="../js/plugins/dropzonejs/dropzone.min.css">
        <link rel="stylesheet" href="../js/plugins/jquery-tags-input/jquery.tagsinput.min.css">
        <!-- END Estilos -->
</head>

<body>

<?php if ((isset($_POST["enviado"])) && ($_POST["enviado"] == "representantesForm")) {
	$nombre_archivo = $_FILES['userfile']['name']; 
	move_uploaded_file($_FILES['userfile']['tmp_name'], "../../images/representantes/".$nombre_archivo);
	
	?>
    <script>
		opener.document.representantesForm.imagen.value="<?php echo $nombre_archivo; ?>";
		self.close();
	</script>
    <?php
}
else
{?>
	<div id="page-container">
		<main id="main-container">
        	<div class="content content-boxed">
                <div class="block">
                	<div class="block-content block-content-full">
                            <div class="row">
                                <div class="col-sm-12">
                            	<form action="representantes.php" method="post" enctype="multipart/form-data" id="representantesForm">
                                	<div class="form-group">
                                        <label class="col-xs-12" for="userfile">Selecciona la imagen</label>
                                        <div class="col-xs-12">
                                            <input type="file" id="userfile" name="userfile">
                                        </div>
                                    </div>
                                	<div class="form-group">
                                        <div class="col-xs-12" style="margin-top:20px;">                                            
                                        	<button class="btn btn-block btn-primary push-10" type="submit"><i class="fa fa-upload"></i> Cargar</button>
                                            <input type="hidden" name="enviado" value="representantesForm" />
                                        </div>
                                    </div>
                                </form>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
<?php }?>
        <script src="../js/core/jquery.min.js"></script>
        <script src="../js/core/bootstrap.min.js"></script>
        <script src="../js/core/jquery.slimscroll.min.js"></script>
        <script src="../js/core/jquery.scrollLock.min.js"></script>
        <script src="../js/core/jquery.appear.min.js"></script>
        <script src="../js/core/jquery.countTo.min.js"></script>
        <script src="../js/core/jquery.placeholder.min.js"></script>
        <script src="../js/core/js.cookie.min.js"></script>
        <script src="../js/app.js"></script>
        <script src="../js/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js"></script>
        <script src="../js/plugins/select2/select2.full.min.js"></script>
        <script src="../js/plugins/dropzonejs/dropzone.min.js"></script>
        <script src="../js/plugins/jquery-tags-input/jquery.tagsinput.min.js"></script>
        <script src="../js/plugins/ckeditor/ckeditor.js"></script>
        <script>
            jQuery(function () {
                App.initHelpers(['maxlength', 'select2', 'tags-inputs', 'ckeditor', 'appear', 'appear-countTo']);
            });
        </script>
</body>
</html>