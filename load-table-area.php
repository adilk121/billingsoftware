<?php 
ob_start();
require_once("../includes/dbsmain.inc.php");
$page_name=basename($_SERVER['PHP_SELF'],'.php');
include("../site-main-query.php");
$sess_id=session_id();
$site_url=$compDATA['admin_website_url'];
?>
<?php
if(is_post_back()) {
	$arr_ids = $_REQUEST['arr_ids'];
	if(is_array($arr_ids)) {
		$str_ids = implode(',', $arr_ids); 
		if(isset($_REQUEST['Activate']) || isset($_REQUEST['Activate_x']) ) {
			db_query("update tbl_category set category_status='Active' where category_id in ($str_ids)");
			$_SESSION["msg"]="selected categories are activated. ";
		} else if(isset($_REQUEST['Deactivate']) || isset($_REQUEST['Deactivate_x']) ) {
			db_query("update tbl_category set category_status='Inactive' where category_id in ($str_ids)");
						$_SESSION["msg"]="selected categories are deactivated. ";
		} else if(isset($_REQUEST['Delete']) || isset($_REQUEST['Delete_x']) ) {
			db_query("Delete from tbl_category where category_id in ($str_ids)");
						$_SESSION["msg"]="selected categories are deleted. ";
		} 
		
	}

		
	header("Location: ".$_SERVER['HTTP_REFERER']);
	exit;
}
?>
<div class="table-responsive" id="formArea">

<form action="" name="stockFormAdd" id="stockFormAdd" method="post" enctype="multipart/form-data">                           
                              <table id="dataTableExample1" class="table table-bordered table-striped table-hover">
                                 <thead>
                                    <tr class="info">                                      
                                       <th class="text-center">S.No.</th>            
                                                
                                       <th class="text-center">Item</th>                                       
                                       <th class="text-center">MRP</th>
                                       <th class="text-center">Sell Price</th>
                                       <th class="text-center">Color</th>                                       
                                       <th class="text-center">Size</th>
                                       <th class="text-center">Quantity</th>                                       
                                       <th class="text-center">Action</th>
                                       <th class="text-center">Status</th>
                                       <th class="text-center"><input name="check_all" type="checkbox" id="check_all" value="1" onClick="checkall(this.form)" /></th>
                                    </tr>
                                 </thead>
                                 
<tbody>
                                   
<?php
$cid=$_REQUEST['cat_id'];
$sql="SELECT * FROM tbl_category WHERE 1 AND category_parent_id='$cid' ORDER BY category_id DESC";
$result=db_query($sql);
$countTotal=mysqli_num_rows($result);
$cnt=0;
if($countTotal>0){
	
while ($rec_stock= mysqli_fetch_array($result)) {
$line = ms_display_value($rec_stock);
@extract($line);
$css = ($css=='trOdd')?'trEven':'trOdd';
?>                                   
<tr>
<td class="text-center v-middle"><?=++$cnt?></td>
<td class="text-center v-middle " >
<?=db_scalar("SELECT category_name FROM tbl_category WHERE 1 AND category_id='$cat_id'")?>
</td>
                                     

<td class="text-center v-middle">
<?=$rec_stock['category_real_price']?>
</td>


<td class="v-middle" align="center">
<?=$rec_stock['category_discount_price']?>
</td>


<td class="text-center v-middle">
<?=$rec_stock['category_color']?>                           
</td>

<td class="text-center v-middle">
<?=$rec_stock['category_size']?>                           
</td>

<td class="text-center v-middle">
<?=$rec_stock['category_qnty']?>                           
</td>

<td class="text-center v-middle">
<a href="Javascript:void(0)" class="bold" onClick="edit_stock('<?=$rec_stock['category_id']?>')" >Edit / View
</a>                                          
</td>

<td class="text-center v-middle">
<?php if($rec_stock['category_status']=="Active"){?>
<span class="text-success bold" >Active</span>
<?php }else{?>
<span class="text-danger bold" >Inactive</span>
<?php }?>
            
</td>

<td class="text-center v-middle"><input name="arr_ids[]" type="checkbox" id="arr_ids[]" value="<?=$rec_stock['category_id']?>" /></td>
</tr>

<?php
}
}else{
?>
<tr>
<td colspan="10" class="text-danger text-center p-20"> No record(s) found</td>
</tr>
<?php }?>
                                    
                                    
                                    
                                    
                                 </tbody>

                              </table>
                              

                                             
                              
                           </div>                        
                        
                        

<span class="pull-right">

<button type="submit" name="Delete"  class="btn btn-danger" style="padding:1px 10px;font-weight:600;text-shadow:1px 1px 2px black">Delete</button>


<button type="submit" name="Activate"   class="btn btn-success" style="padding:1px 10px;font-weight:600;text-shadow:1px 1px 2px black">Activate</button>


<button type="submit" name="Deactivate"  class="btn btn-warning" style="padding:1px 10px;font-weight:600;text-shadow:1px 1px 2px black">Deactivate</button>

</span>                        
</form>
                              </table>
                              

                                             
                              
                                             
                        
                        
                        
<div class="col-lg-12 border-all border-green " id="stock-entry">
<form name="form1" id="stockForm" method="post" onSubmit="return formValidationnnn()" enctype="multipart/form-data" class="col-sm-12" >

<div class="form-group col-lg-2 custom-width">                               
<input type="text" class="form-control" placeholder="Enter MRP" name="category_real_price" id="category_real_price"  value="">
</div>

<div class="form-group col-lg-2 custom-width">
<input type="text" class="form-control" placeholder="Selling Price" name="category_discount_price" id="category_discount_price"  value="">
</div>

<div class="form-group col-lg-2 custom-width">                                
<input type="text" class="form-control" placeholder="Enter color" name="category_color" id="category_color"  
value="">
</div>
                              
<div class="form-group col-lg-1 custom-width">                                
<input type="text" class="form-control" placeholder="size" name="category_size" id="category_size"  value="">
</div>                              


<div class="form-group col-lg-2 custom-width">
<select name="category_status" class="form-control" >
<option value="Active" >Active</option>
<option value="Inactive" >Inactive</option>
</select>
</div> 


<div class="form-group col-lg-1 custom-width">
<input type="text" class="form-control" placeholder="Enter Qnty" name="category_qnty" id="category_qnty"  value="">
</div>


<div class="form-group col-lg-2 custom-width">
<a class="btn btn-link bold " id="select-images"><span class="underline">Add Images</span> 
<i class="fa fa-arrow-up font-black"></i>
</a>
</div>                             
<input type="hidden" name="category_image_ids" id="imgIDs" value="" />

<input type="hidden" name="prd_id"  value="<?=$cat_id?>" />
       
<div class="col-lg-1 reset-button text-center">
<button type="submit" id="add_stock" class="btn btn-add">Add Item</button>
</div>
</form>



<div class="col-lg-12" id="image-added-area" style="display:none"></div>

</div>
<div class="col-lg-12 text-left text-danger">*Note: First will be main image of product</div>

<div class="col-lg-12" id="image-select-area"></div>

</div>
<script src="assets/plugins/jQuery/jquery-1.12.4.min.js" type="text/javascript"></script>
<script>
function edit_stock(catid){

$(document).ready(function(e) {
$('#stock-entry').fadeOut('fast').load('load-edit-area.php?cid='+catid).fadeIn("fast");    
});


}
</script>

<script>
function activate_item(){

$(document).ready(function(e) {
    
$("#stockFormAdd").on('submit',(function(e) {	
//		e.preventDefault();
		
		alert('yes')
		//$.ajax({
//        	url: "edit-stock.php",
//			type: "POST",
//			data:  new FormData(this),
//			contentType: false,
//    	    processData:false,
//			success: function(data){
//
<?php /*?>$('#table-load-area').fadeOut('fast').load('load-table-area.php?cat_id=<?=$category_parent_id?>').fadeIn("fast");<?php */?>
//  	
//
//
//			},
//		  	error: function() 
//	    	{
//	    	} 	        
//	   });
	   
	   
}));
	
	
});
	
}
</script>