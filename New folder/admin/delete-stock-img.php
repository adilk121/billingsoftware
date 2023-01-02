<?php 
ob_start();
require_once("../includes/dbsmain.inc.php");
$page_name=basename($_SERVER['PHP_SELF'],'.php');
include("../site-main-query.php");
$sess_id=session_id();
$site_url=$compDATA['admin_website_url'];
?>
<?php
$img=$_REQUEST['img'];
$catID=$_REQUEST['catID'];

$category_image_ids="";

if($img!=""){
$category_image_ids=db_scalar("SELECT category_image_ids FROM tbl_category WHERE category_id='$catID'");
$category_image_ids=@explode(",",$category_image_ids);

for($i=0;$i<count($category_image_ids);$i++){

if($category_image_ids[$i]==$img){
unset($category_image_ids[$i]);
}

}

}

$category_image_ids=@implode(",",$category_image_ids);
$sql="UPDATE tbl_category SET category_image_ids='$category_image_ids' WHERE category_id='$catID'";
$res=db_query($sql);
?>
