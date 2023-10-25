<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_DKKfront = "localhost";
$database_DKKfront = "prodalum_w3";
$username_DKKfront = "prodalum_admin";
$password_DKKfront = "m3nd1gO5Ol4nO";
$DKKfront = mysqli_connect($hostname_DKKfront, $username_DKKfront, $password_DKKfront, $database_DKKfront) or trigger_error(mysqli_error(),E_USER_ERROR); 
mysqli_set_charset($DKKfront, 'iso-8859-1');
?>