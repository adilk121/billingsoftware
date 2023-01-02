<?php 
ob_start();
require_once("../includes/dbsmain.inc.php");
$page_name=basename($_SERVER['PHP_SELF'],'.php');
include("../site-main-query.php");
$sess_id=session_id();
$site_url=$compDATA['admin_website_url'];
?>
<style>
label.for-edit-lbl {
    font-size: 12px;
    margin: 0 5px;
}

.itemImages{
width:100px;
height:100px;
border:solid thin #ccc;
margin:10px 15px;
padding:3px;
}

.first-img-active {
    padding: 2px;
    box-shadow: 1px 1px 16px 4px #010a0f8a;
    border: solid thin #ccc;
}

</style>
<?php
$sql="SELECT * FROM tbl_category WHERE 1 AND category_id='$cid'";
$data=db_query($sql);
$rec=mysqli_fetch_array($data);
@extract($rec);
$cat_id=db_scalar("SELECT category_parent_id FROM tbl_category WHERE category_id='$cid'");
?>
<form name="form1" id="stockFormEdit" method="post" onsubmit="return formValidationnnn()" enctype="multipart/form-data" class="col-sm-12" >

<div class="form-group col-lg-2 custom-width">   
<label class="for-edit-lbl">MRP</label>                            
<input type="text" class="form-control" placeholder="Enter MRP" name="category_real_price" id="category_real_price"  value="<?=$category_real_price?>">
</div>

<div class="form-group col-lg-2 custom-width">
<label class="for-edit-lbl">Sell Price</label>
<input type="text" class="form-control" placeholder="Selling Price" name="category_discount_price" id="category_discount_price"  value="<?=$category_discount_price?>">
</div>

<div class="form-group col-lg-2 custom-width">    
<label class="for-edit-lbl">Color</label>
<select name="category_color" id="category_color" class="form-control" >
<option value="" >Colors</option>
<?php 
$avai_colors=db_scalar("SELECT category_color FROM tbl_category WHERE 1 AND category_id='$cat_id'");
$avai_colors=@explode(",",$avai_colors);
foreach($avai_colors as $ac){
?>
<option value="<?=$ac?>"  <?php if($category_color==$ac){?> selected="selected"<?php }?> ><?=$ac?></option>
<?php
}
?>
</select>
                            
</div>
                              
<div class="form-group col-lg-1 custom-width"> 
<label class="for-edit-lbl">Size</label>
<select name="category_size" id="category_size"  class="form-control" >
<option value="" >Size</option>
<?php 
$avai_sizes=db_scalar("SELECT category_size FROM tbl_category WHERE 1 AND category_id='$cat_id'");
$avai_sizes=@explode(",",$avai_sizes);
foreach($avai_sizes as $as){
?>
<option value="<?=$as?>" <?php if($category_size==$as){?> selected="selected"<?php }?> ><?=$as?></option>
<?php
}
?>
</select>

</div>    


                          


<div class="form-group col-lg-2 custom-width">
<label class="for-edit-lbl">Status</label>
<select name="category_status" class="form-control" >
<option value="Active" <?php if($category_status=='Active'){ ?> selected="selected" <? } ?>>Active</option>
<option value="Inactive" <?php if($category_status=='Inactive'){ ?> selected="selected" <? } ?>>Inactive</option>
</select>
</div> 


<div class="form-group col-lg-1 custom-width">
<label class="for-edit-lbl">Qnty</label>
<input type="text" class="form-control" placeholder="Enter Qnty" name="category_qnty" id="category_qnty"  value="<?=$category_qnty?>">
</div>


<div class="form-group col-lg-2 custom-width">
<label class="for-edit-lbl">&nbsp;</label>
<a class="btn btn-link bold " id="select-images"><span class="underline">Add Images</span> 
<i class="fa fa-arrow-up font-black"></i>
</a>
</div>                             

<input type="hidden" name="editID" id="editID" value="<?=$cid?>" />

<input type="hidden" name="category_image_ids" id="imgIDs" value="<?=$rec['category_image_ids']?>" />

<input type="hidden" name="prd_id"  value="<?=$category_parent_id?>" />
       
<div class="col-lg-1 reset-button text-center">
<label class="for-edit-lbl">&nbsp;</label>
<button type="submit" id="edit_stock" class="btn btn-add">Edit Item</button>
</div>
</form>



<div class="col-lg-12" id="image-added-area" >

<?php
//if($category_image_ids!=""){
//$sql="SELECT * FROM tbl_category_image WHERE category_image_id IN ($category_image_ids)  ";
//}else{
//$sql="SELECT * FROM tbl_category_image WHERE category_image_id IN (-1) ";	
//}

$imgIds="";
if($category_image_ids!=""){
$imgIds=@explode(",",$category_image_ids);
}else{
$sql="SELECT * FROM tbl_category_image WHERE category_image_id IN (-1) ";	
}

//$dataImg=db_query($sql);
//$countImg=mysqli_num_rows($dataImg);
$countImg=count($imgIds);
if($countImg>0){
$cnt=0;	
//while($recImg=mysqli_fetch_array($dataImg)){	
while($cnt<$countImg){	
$sql="SELECT * FROM tbl_category_image WHERE category_image_id='$imgIds[$cnt]'";
$dataImg=db_query($sql);
$recImg=mysqli_fetch_array($dataImg);
?>

<div class="col-lg-2 ">
<img id="item_image" src="../category_more_images/<?=$recImg['category_image_name']?>"  class="itemImages <?php if($cnt==0){?>first-img-active <?php }?>" />
<div class="col-lg-12 text-center mb10"><i class="fa fa-trash fa-lg text-danger delImage" onclick="delImage('<?=$recImg['category_image_id']?>','<?=$cid?>')" ></i></div>
</div>
<?php 
$cnt++;
}
}
?>

</div>


<script>
$(document).ready(function(e) {

////////////////// DISPLAYING IMAGE AREA ////////////////////////////
$("#select-images").click(function(e) {

//alert('Ok');

$('#image-select-area').slideUp('fast').load('load-item-images.php?cid=<?=$category_parent_id?>').slideDown("fast");			  	
    
});

	
});
</script>

<script>
<?php /*?>function delImage(imgID,catID){

$('#stock-entry').slideUp('fast').load('load-item-images-after-delete.php?img='+imgID+'&catID='+catID+'&cid='+<?=$cid?>).slideDown("fast");			
}<?php */?>
</script>

<script>
function delImage(imgID,catID){


$.ajax({
        	url: "delete-stock-img.php?img="+imgID+"&catID="+catID,
			type: "POST",
			contentType: false,
    	    processData:false,
			success: function(data){

$('#stock-entry').slideUp('fast').load('load-edit-area.php?cid='+<?=$cid?>).slideDown("fast");			
  	


			},
		  	error: function() 
	    	{
	    	} 	        
	   });
	   
	   
}
</script>



<script>
$(document).ready(function (e) {
	
$(document).on("submit", "#stockFormEdit", (function(e) {
//	$("#stockFormEdit").on('submit',(function(e) {	
//		e.preventDefault();
		$.ajax({
        	url: "edit-stock.php",
			type: "POST",
			data:  new FormData(this),
			contentType: false,
    	    processData:false,
			success: function(data){

$('#table-load-area').fadeOut('fast').load('load-table-area.php?cat_id=<?=$category_parent_id?>').fadeIn("fast");
  	


			},
		  	error: function() 
	    	{
	    	} 	        
	   });
	}));
});
</script>