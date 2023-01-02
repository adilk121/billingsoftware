<?php 
ob_start();
require_once("../includes/dbsmain.inc.php"); // ADDING CONNECTION FILES
date_default_timezone_set('Asia/Kolkata');

 $service_product_name=$_POST['name_value'];
 $id=db_scalar("SELECT invoice_product_id FROM tbl_invoice_product where invoice_product_status='Active' and invoice_product_name='$service_product_name'  ");

$service_product_detils=mysqli_fetch_array(db_query("SELECT * FROM tbl_invoice_product where invoice_product_status='Active' and invoice_product_id='$id'"));

  $price=$service_product_detils['invoice_product_price'];
  $description=$service_product_detils['invoice_product_description'];
$package_details = new \stdClass();
$package_details->invoice_product_price=$price;
$package_details->invoice_product_description=$description;
echo json_encode($package_details);
?>