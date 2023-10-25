<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_DKKadmin = "localhost";
$database_DKKadmin = "prodalum_w3";
$username_DKKadmin = "prodalum_admin";
$password_DKKadmin = "m3nd1gO5Ol4nO";
$DKKadmin = mysqli_connect($hostname_DKKadmin, $username_DKKadmin, $password_DKKadmin, $database_DKKadmin) or trigger_error(mysqli_error(),E_USER_ERROR); 
mysqli_set_charset($DKKadmin, 'iso-8859-1');
?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
?>