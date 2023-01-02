<?php
ob_start();
require_once("../includes/dbsmain.inc.php");
include("../site-main-query.php");
date_default_timezone_set('Asia/Kolkata');

$comp_id=$_POST['company_id'];
$type="";

$invoice_last_no=db_scalar("select invoice_order_invoice_no from tbl_invoice_order where invoice_order_company_id='$comp_id' order by invoice_order_id desc limit 1");
$invoice_gst_no=db_scalar("select billing_company_gst_no from tbl_billing_company where billing_company_id='$comp_id'");
$invoice_gst_rate=db_scalar("select billing_company_gst_rate from tbl_billing_company where billing_company_id='$comp_id'");

if($invoice_last_no=="" || empty($invoice_last_no))
{
	$invoice_last_no=db_scalar("select billing_company_invoice_start_no from tbl_billing_company where billing_company_id='$comp_id'");
}else{
	$type="From Order";
}

$invoice_data = array($invoice_last_no, $type,$invoice_gst_no,$invoice_gst_rate);
echo json_encode($invoice_data);




?>