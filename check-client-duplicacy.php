<?php
ob_start();
require_once("includes/dbsmain.inc.php");  // ADDING CONNECTION FILES
date_default_timezone_set('Asia/Kolkata');


$type=$_POST['type'];
$value=$_POST['value'];

if($type=="CID")
{
$client_id=db_scalar("select client_id from tbl_clients where client_cid='$value'");
if($client_id!="")
{
	echo "CID already exist, please use a different one !";
}
}

if($type=="GST")
{
$client_id=db_scalar("select client_id from tbl_clients where client_gst_no='$value'");
if($client_id!="")
{
	echo "GST no. already exist, please use a different one !";
}
}


if($type=="Email")
{
$client_id=db_scalar("select client_id from tbl_clients where client_email='$value'");
if($client_id!="")
{
	echo "Email address already exist, please use a different one !";
}
}

if($type=="Mobile")
{
$client_id=db_scalar("select client_id from tbl_clients where client_mobile='$value'");
if($client_id!="")
{
	echo "Mobile no. already exist, please use a different one !";
}
}

if($type=="PAN")
{
$client_id=db_scalar("select client_id from tbl_clients where client_pan_no='$value'");
if($client_id!="")
{
	echo "PAN no. already exist, please use a different one !";
}
}



?>