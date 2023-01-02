<?php
ob_start();
require_once("../includes/dbsmain.inc.php");
?>
<?php
$catID=$_GET['catID'];
if(!empty($catID)){
$sql="SELECT category_qnty FROM tbl_category WHERE category_id='$catID'";
$res=db_scalar($sql);	
//echo "<span style=\"color:green;font-weight:600\">$res</span>";
//}
?>
<div class="col-lg-12" id="qnty_area_<?=$catID?>" style="display:block">
<?php
if($res>0){
?>
<span style="color:#090;font-weight:600"><?=$res?></span>
<?php
}else{
?>	
<span style="color:red;font-weight:600">Out Of Stock</span>	
<?php
}
?>
</div>

<div class="col-lg-12" id="edit_qnty_<?=$catID?>" style="display:none">
<input type="text" name="edit_qnty"  class="txt_qnty" id="txt_qnty_<?=$catID?>" value="<?=$res?>" style="width:50%;text-align:center; "  autocomplete="off" /><button type="button" id="save_qnty_<?=$catID?>" onClick="save_prd_qnty(<?=$catID?>)"><i class="fa fa-save fa-lg"></i></button></div>
<?php }
?>
