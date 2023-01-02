<?php
ob_start();
require_once("../includes/dbsmain.inc.php");
include("../site-main-query.php");
if(empty($_SESSION['sess_admin_login_id'])){
header("location:login.php");
exit; 
}
$curr_date=date("Y-m-d");
$invoice_start_no=$_REQUEST['invoice_start_no'];

echo db_scalar("select billing_company_id from tbl_billing_company where billing_company_invoice_start_no='$invoice_start_no'");


?>