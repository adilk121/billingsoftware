<?php 
ob_start();
require_once("../includes/dbsmain.inc.php");
$imgID=$_GET['imgID'];
?>
<?php  
$sql="SELECT category_image_name FROM tbl_category WHERE 1 AND category_id='$imgID' ";
$img=db_scalar($sql);
?>
<?php if($img!=""){?>
<img src="../uploaded_files/home_cat_thumb/<?=$img?>" style="width:175px;height:175px;border:solid thin #ccc;" >
<?php }else{?>
<img src="assets/dist/img/no-image.jpg" style="width:175px;height:175px" >
<?php }?>