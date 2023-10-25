<?php
// *** Logout the current user.
$logoutGoTo = "../admin";
if (!isset($_SESSION)) {
  session_start($DKKadmin);
}
$_SESSION['MM_Username'] = NULL;
$_SESSION['MM_UserGroup'] = NULL;
$_SESSION['MM_idAdmin'] = NULL;
unset($_SESSION['MM_Username']);
unset($_SESSION['MM_UserGroup']);
unset($_SESSION['MM_idAdmin']);
if ($logoutGoTo != "") {header("Location: $logoutGoTo");
exit;
}
?>
