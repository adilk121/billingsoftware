<?php 
ob_start();
require_once("../includes/dbsmain.inc.php");
$page_name=basename($_SERVER['PHP_SELF'],'.php');
include("../site-main-query.php");
$sess_id=session_id();
$site_url=$compDATA['admin_website_url'];
?>
<?php
$dicountAmount=$category_real_price-$category_discount_price;
$category_discount_percentage=($dicountAmount/$category_real_price)*100;

$sql = "insert into tbl_category set 
				category_real_price='$category_real_price',
				category_discount_price='$category_discount_price',
				category_discount_percentage='$category_discount_percentage',
				category_color='$category_color',
				category_size='$category_size',		
				category_qnty='$category_qnty',							
				category_parent_id='$prd_id',
				category_image_ids='$category_image_ids',
				category_is_product='Yes',
				category_for_stock='Yes',
				category_add_date='$curr_date',
				category_status='$category_status'";
db_query($sql);
?>