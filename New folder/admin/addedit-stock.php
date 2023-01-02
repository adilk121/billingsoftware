<?php require_once("header.php");?>
<?php require_once("left-nav.php");?>
<?php require_once ('../includes/photoshop.php');?>
<style>
select.bysize {
    border: solid thin #8e32a2;
    font-size: 16px;
    margin: -14px 0 0 0;
}

.form-group.custom-width {
    width: 13%;
	padding: 0 5px;
}

div#stock-entry{
	padding:15px 10px 2px 10px;
	margin:15px 0 15px 0;
	
}

.reset-button {
    margin-top: 0;
    padding: 0px 10px;
}
</style>
<?php
$subcatid=trim($_REQUEST['subcatid']);
$category_id=trim($_REQUEST['id']);
$categoryID = trim($_GET['catid']);

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
		}else if(isset($_REQUEST['set_as_main']) || isset($_REQUEST['set_as_main_x']) ) {
			$cid=$_REQUEST['cat_id'];
		db_query("update tbl_category set category_as_main='Yes' where category_id IN ($str_ids) AND category_parent_id='$cid' ");
		db_query("update tbl_category set category_as_main='No' where category_id NOT IN ($str_ids) AND category_parent_id='$cid' ");


		$_SESSION["msg"]="selected item is set as main. ";
			
		}  
		
		
		
	}

		
	header("Location: ".$_SERVER['HTTP_REFERER']);
	exit;
}

?>



         <!-- Content Wrapper. Contains page content -->
         <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
               <div class="header-icon">
                  <i class="fa fa-pencil-square-o" aria-hidden="true"></i>

               </div>
               <div class="header-title">
                  <h1>Add/Edit Product Stock</h1>
                  <small>Add/Edit product Stock content</small>
                  
                  
                  
                  
<a href="product_list.php?subcatid=<?=$subcatid?>&catid=<?=$catid?>"><button id="btn-go-back" type="button" class="btn btn-labeled btn-inverse m-b-5 pull-right">
<span class="btn-label" ><i class="fa fa-chevron-circle-left"></i></span>Go Back
</button></a>

<?php
$cid=$_REQUEST['cat_id'];
$sql="SELECT category_size FROM tbl_category WHERE 1 AND category_id='$cid' ";
$resultSize=db_scalar($sql);
$resultSize=@explode(",",$resultSize);



$sql="SELECT category_color FROM tbl_category WHERE 1 AND category_id='$cid' ";
$resultColor=db_scalar($sql);
$resultColor=@explode(",",$resultColor);
?> 


<select class="pull-right mr15 bysize" onChange="filterbycolor(this.value)" >
<option value="0">Color</option>
<?php foreach($resultColor as $rc) {?>
<option value="<?=$rc?>"><?=$rc?></option>
<?php }?>
<option value="All">All</option>
</select>




<select class="pull-right mr15 bysize" onChange="filterbysize(this.value)" >
<option value="0">Size</option>
<?php foreach($resultSize as $rs) {?>
<option value="<?=$rs?>"><?=$rs?></option>
<?php }?>
<option value="All">All</option>
</select>


                  
               </div>
               
               
            </section>
            <!-- Main content -->

            <section class="content">
            
            <?php if($_SESSION["msg"]!=""){?>               
<div class="alert alert-success alert-dismissable fade in text-center" style="background-color:#dff0d8;border:none; color:#000;margin:10px 0 10px 0">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Success!&nbsp;&nbsp;&nbsp;</strong> <?=$_SESSION["msg"]?>
  </div>
<?php 
unset($_SESSION["msg"]);
}?>     

               <div class="row">
                  <!-- Form controls -->
                  <div class="col-sm-12">
                     <div class="panel panel-bd lobidrag" data-edit-title='false' data-close='false' data-reload='false'>
                        <div class="panel-heading">
                           <div class="btn-group" id="buttonexport">
                              <a href="#">
                                 <h4>General Information
                                 
                                 <i class="fa fa-angle-double-right" ></i>
                                 
<span style="margin-left:5px; font-size:16px;color:#8e32a2c7"><?=db_scalar("SELECT category_name FROM tbl_category WHERE 1 AND category_id='$catid'")?>&nbsp;&nbsp;<i class="fa fa-angle-double-right" ></i><span style="margin-left:5px; font-size:16px;color:#8e32a2c7"><?=db_scalar("SELECT category_name FROM tbl_category WHERE 1 AND category_id='$subcatid'")?></span>

&nbsp;&nbsp;<i class="fa fa-angle-double-right" ></i><span style="margin-left:5px; font-size:16px;color:#8e32a2c7"><?=db_scalar("SELECT category_name FROM tbl_category WHERE 1 AND category_id='$cat_id'")?></span>
                                 
                                 
                                 </h4>
                              </a>
                           </div>
                        </div>
                        <div class="panel-body">
                        
                        
<div id="table-load-area">

<div class="table-responsive" >

<form action="" name="stockFormAdd" id="stockFormAdd" method="post" enctype="multipart/form-data" >                           
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
                                       <th class="text-center"><input name="check_all" type="checkbox" id="check_all" value="1" onclick="checkall(this.form)" /></th>
                                    </tr>
                                 </thead>
                                 
<tbody>
                                   
<?php
$cid=$_REQUEST['cat_id'];

$size=$_REQUEST['size'];
$color=$_REQUEST['color'];

$condSize="";

if($size!=""){
$condSize=" AND category_size='$size'";
}

$condColor="";

if($color!=""){
$condColor=" AND category_color='$color'";
}

$sql="SELECT * FROM tbl_category WHERE 1 AND category_parent_id='$cid' $condSize $condColor ORDER BY category_id DESC";
$result=db_query($sql);
$countTotal=mysqli_num_rows($result);
$cnt=0;
if($countTotal>0){
	
while ($rec_stock= mysqli_fetch_array($result)) {
$line = ms_display_value($rec_stock);
@extract($line);
$css = ($css=='trOdd')?'trEven':'trOdd';
?>                                   
<tr <?php if($rec_stock['category_as_main']=='Yes'){?> style="background-color: #62d0f1b8;
    font-size: 15px;" <?php }?>>
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


<button type="submit" name="Activate"  class="btn btn-success" style="padding:1px 10px;font-weight:600;text-shadow:1px 1px 2px black">Activate</button>


<button type="submit" name="Deactivate"  class="btn btn-warning" style="padding:1px 10px;font-weight:600;text-shadow:1px 1px 2px black">Deactivate</button>

<button type="submit" name="set_as_main" onClick="return select_chk()"   class="btn btn-info" style="padding:1px 10px;font-weight:600;text-shadow:1px 1px 2px black">Set As Main</button>

</span>                        
</form>                        
                        
                        
<a href="addedit-stock.php?cat_id=<?=$_REQUEST['cat_id']?>&subcatid=<?=$_REQUEST['subcatid']?>&catid=<?=$_REQUEST['catid']?>" class="btn btn-link pull-left" style="margin:-10px 0 -10px 0"><i class="fa fa-refresh" aria-hidden="true"></i> Clear</a>                        
<div class="col-lg-12 border-all border-green " id="stock-entry">
<form name="form1" id="stockForm" method="post" onsubmit="return formValidationnnn()" enctype="multipart/form-data" class="col-sm-12" >

<div class="form-group col-lg-2 custom-width">                               
<input type="text" class="form-control" placeholder="Enter MRP" name="category_real_price" id="category_real_price"  value="">
</div>

<div class="form-group col-lg-2 custom-width">
<input type="text" class="form-control" placeholder="Selling Price" name="category_discount_price" id="category_discount_price"  value="">
</div>

<div class="form-group col-lg-2 custom-width">    
<select name="category_color" id="category_color" class="form-control" >
<option value="" >Colors</option>
<?php 
$avai_colors=db_scalar("SELECT category_color FROM tbl_category WHERE 1 AND category_id='$cat_id'");
$avai_colors=@explode(",",$avai_colors);
foreach($avai_colors as $ac){
?>
<option value="<?=$ac?>" ><?=$ac?></option>
<?php
}
?>
</select>
                            
</div>
                              
<div class="form-group col-lg-1 custom-width"> 
<select name="category_size" id="category_size"  class="form-control" >
<option value="" >Size</option>
<?php 
$avai_sizes=db_scalar("SELECT category_size FROM tbl_category WHERE 1 AND category_id='$cat_id'");
$avai_sizes=@explode(",",$avai_sizes);
foreach($avai_sizes as $as){
?>
<option value="<?=$as?>" ><?=$as?></option>
<?php
}
?>
</select>

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



<div class="col-lg-12" id="image-added-area" ></div>

</div>
<div class="col-lg-12 text-left text-danger">*Note: First will be main image of product</div>

<div class="col-lg-12" id="image-select-area"></div>

</div>

</div>
                     </div>
                  </div>
               </div>
            </section>
            <!-- /.content -->
         </div>
<?php require_once("footer.php"); ?>
<script>
$(document).ready(function(e) {

////////////////// DISPLAYING IMAGE AREA ////////////////////////////
$("#select-images").click(function(e) {

$('#image-select-area').slideUp('fast').load('load-item-images.php?cid=<?=$cat_id?>').slideDown("fast");			  	
    
});

	
});
</script>

<script>
$(document).ready(function (e) {
	
$(document).on("submit", "#stockForm", (function(e) {
//	$("#stockForm").on('submit',(function(e) {
  //      e.preventDefault();
		$.ajax({
        	url: "add-stock.php",
			type: "POST",
			data:  new FormData(this),
			contentType: false,
    	    processData:false,
			success: function(data){

$('#table-load-area').fadeOut('fast').load('load-table-area.php?cat_id=<?=$cat_id?>').fadeIn("fast");
location.reload();
  	


			},
		  	error: function() 
	    	{
	    	} 	        
	   });
	}));
});
</script>

<script>
function edit_stock(catid){

$(document).ready(function(e) {
$('#stock-entry').fadeOut('fast').load('load-edit-area.php?cid='+catid).fadeIn("fast");    
});


}
</script>

<script>
function filterbysize(val){

if(val=='All'){
window.location="addedit-stock.php?cat_id=<?=$_REQUEST['cat_id']?>&subcatid=<?=$_REQUEST['subcatid']?>&catid=<?=$_REQUEST['catid']?>";
}else{
window.location="addedit-stock.php?cat_id=<?=$_REQUEST['cat_id']?>&subcatid=<?=$_REQUEST['subcatid']?>&catid=<?=$_REQUEST['catid']?>&size="+val;
}

}
</script>

<script>
function filterbycolor(val){

if(val=='All'){
window.location="addedit-stock.php?cat_id=<?=$_REQUEST['cat_id']?>&subcatid=<?=$_REQUEST['subcatid']?>&catid=<?=$_REQUEST['catid']?>";
}else{
window.location="addedit-stock.php?cat_id=<?=$_REQUEST['cat_id']?>&subcatid=<?=$_REQUEST['subcatid']?>&catid=<?=$_REQUEST['catid']?>&color="+val;
}

}
</script>

<script>
function select_chk(){
			var chks = document.getElementsByName('arr_ids[]');
			var hasChecked = false;
			var checkCount=0;
			for (var i = 0; i < chks.length; i++){
			if (chks[i].checked){
				hasChecked = true;				
				break;
				}
				
			}


			for (var i = 0; i < chks.length; i++){

			if (chks[i].checked){
				checkCount=checkCount+1;
				}
				
			}


			if (hasChecked == false){
			alert("Please Select At Least One.");
			return false;
			}
			
			

			if(checkCount>1){				
			alert("You can selecy only one item as main.");
			return false;
			}
}
</script>