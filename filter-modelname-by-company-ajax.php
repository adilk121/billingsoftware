<?php 
ob_start();
require_once("../includes/dbsmain.inc.php");
?>
<?php
$company_name=$_REQUEST['company_name'];
$company_id=db_scalar("select filter_id from tbl_vehicle_filter where vehicle_brand_name='$company_name'");
?>



 <label>Model Number</label>
 <select class="form-control" name="category_model_number" id="category_model_number">
     <option>Select Model</option>
     <?php
$model_sql=db_query("select * from tbl_vehicle_filter where vehicle_status='Active' and parent_id='$company_id' ");
while($model_res=mysqli_fetch_array($model_sql))
{?>
  <option value="<?=$model_res['vehicle_model_number']?>" <?php if($model_res['vehicle_model_number']==$category_model_number){?>selected<?}?> ><?=$model_res['vehicle_model_number']?></option>     
<?}
?>
</select>
