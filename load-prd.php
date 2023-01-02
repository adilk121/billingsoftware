<?php 
ob_start();
require_once("../includes/dbsmain.inc.php");
$Prd=$_GET['Prd'];
?>
<?php  
$sql="SELECT * FROM tbl_category WHERE 1 AND category_parent_id='$Prd' AND category_is_product='Yes' ORDER BY category_name";
$dataMain=db_query($sql);
$countMain=mysqli_num_rows($dataMain);
?>
<select class="form-control" name="resprd_prd_id" id="resprd_prd_id" onChange="load_img(this.value)"  >
<option>Choose Product</option>
<?php if($countMain>0){?>
<?php while($recMain=mysqli_fetch_array($dataMain)){?>
<option  value="<?=$recMain['category_id']?>"><?=$recMain['category_name']?></option>
<?php }?>

<?php }else{?>
<option  value="0">No Product Found</option>
<?php }?>

</select> 