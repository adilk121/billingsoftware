<?
require_once("../includes/dbsmain.inc.php");
unset($_SESSION['sess_admin_login_id'],$_SESSION['user_id'],$_SESSION['user_name'],$_SESSION['ADMIN_ACCESS'],$_SESSION['sess_admin_type']);
header("Location:login.php");
?>