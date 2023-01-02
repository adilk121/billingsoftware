<?php 
ob_start();
require_once("../includes/dbsmain.inc.php");
$mainCatID=$_GET['mainCatID'];
?>
<?php  
$sql="SELECT * FROM tbl_category WHERE 1 AND category_parent_id='$mainCatID' ORDER BY category_name";
$dataMain=db_query($sql);
$countMain=mysqli_num_rows($dataMain);
?>
<select class="form-control" name="resprd_cat_id" id="resprd_cat_id" onChange="load_prd(this.value)" >
<option>Choose Sub Category</option>
<?php if($countMain>0){?>
<?php while($recMain=mysqli_fetch_array($dataMain)){?>
<option  value="<?=$recMain['category_id']?>"><?=$recMain['category_name']?></option>
<?php }?>

<?php }else{?>
<option  value="0">No Category Found</option>
<?php }?>

</select> 