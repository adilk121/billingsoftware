<?php 
ob_start();
require_once("../includes/dbsmain.inc.php");
$Prd=$_GET['Prd'];
?>
<?php  
$sql="SELECT category_discount_price FROM tbl_category WHERE 1 AND category_id='$Prd' ";
$price=db_scalar($sql);
?>
<input type="text" class="form-control" placeholder="Enter product price" name="resprd_prd_real_price" id="resprd_prd_real_price" readonly   value="<?=$price?>">
