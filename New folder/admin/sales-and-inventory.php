<?php require_once("header.php");?>
<?php require_once("left-nav.php");?>
<style>
span#lbl-total-sale {
    background: #40ff48;
    padding: 2px 10px 2px 10px;
    border: solid thin #000;
    float: right;
    font-size: 22px;
    margin: 5px 0 0 0;
}

select#prd_filter {
    width: 200px;
    float: right;
    margin: 0 300px 0 0;
}


	span.count-num {
    float: right;
    margin: 0px 13px 0 0;
    font-size: 18px;
    background: red;
    padding: 1px 6px 1px 6px;
    color: #fff;
    border-radius: 15px;
}


.v-middle {
vertical-align:middle !important;
}
span.new-lbl {
    background: #FFEB3B;
    padding: 1px 5px 1px 5px;
    font-size: 11px;
    font-weight: 600;
    color: red;
    border: solid thin #f0df4d;
    position: relative;
    top: -12px;
}
</style>
<?php
$catID=$_REQUEST['catid'];
$subcatid=$_REQUEST['subcatid'];
?>
<?php
if($st!=""){
$st=$_REQUEST['st'];
$subcatID=$_REQUEST['pid'];

if($st==1){
$sql="UPDATE tbl_category SET category_status='Inactive' WHERE category_id='$subcatID' ";	
$res=db_query($sql);	
if($res>0){
$_SESSION["msg"]="Selected product is deactivated successfully.";	
}	
}else{
$sql="UPDATE tbl_category SET category_status='Active' WHERE category_id='$subcatID' ";	
$res=db_query($sql);	
if($res>0){
$_SESSION["msg"]="Selected product is activated successfully.";	
}	
	
}

header("location:product_list.php?subcatid=$subcatid&catid=$catid");
exit;
}




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
		} else if(isset($_REQUEST['make_new']) || isset($_REQUEST['make_new_x']) ) {
			db_query("update tbl_category set category_is_new='Yes' where category_id in ($str_ids)");
						$_SESSION["msg"]="selected categories are set for new. ";
		} else if(isset($_REQUEST['remove_new']) || isset($_REQUEST['remove_new_x']) ) {
			db_query("update tbl_category set category_is_new='No' where category_id in ($str_ids)");
						$_SESSION["msg"]="selected categories are removed from new. ";
		}
		
	}
	if(isset($_REQUEST['Update'])){
		foreach($category_order_by as $key=>$value){
		db_query("update tbl_category set category_order_by='$value' where category_id='$key'");
		}
		$_SESSION["msg"]="Selected category order is set.";
	}
		
	header("Location: ".$_SERVER['HTTP_REFERER']);
	exit;
}



$start = intval($start);
$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;

$order_by == '' ? $order_by = 'category_status' : true;
$order_by2 == '' ? $order_by2 = 'asc' : true;
 
$sql = "select * from  tbl_category   where 1 AND category_parent_id!='0' AND category_is_product='Yes'";
$sql = apply_filter($sql, $category_name, 'like','category_name');
$sql .= " order by $order_by $order_by2 ";
$sql .= " limit $start, $pagesize ";
//echo $sql;
$pager = new midas_pager_sql($sql, $pagesize, $start);
if($pager->total_records) {
	$result = db_query($sql);
}
?>

<script language="JavaScript" type="text/javascript" src="../includes/general.js"></script>

         <!-- =============================================== -->
         <!-- Content Wrapper. Contains page content -->
         <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
               <div class="header-icon">
                  <i class="fa fa-archive" aria-hidden="true"></i>

               </div>
               <div class="header-title">
                  <h1>Sale & Inventory

                 <!-- <a class="btn btn-warning pull-right"  href="sales-report.php" ><i class="fa fa-file"></i> Sales Report</a>           -->
           
          


<span id="lbl-total-sale">
<?php
$qntySold=db_scalar("SELECT SUM(total_amount) FROM tbl_sale_inventory WHERE 1");
?>
<span style="color:#666">Total Sale :</span> <i class="fa fa-inr"></i> <?=$qntySold?>
</span>


</h1>
                  <small>Sale & Inventory</small>
                  
                  
                  
          
          
          
</div>


           
               
            </section>
            <!-- Main content -->
            <section class="content">
               <div class="row">

<?php if($_SESSION["msg"]!=""){?>               
<div class="alert alert-success alert-dismissable fade in text-center" style="background-color:#dff0d8;border:none; color:#000;margin:10px 0 0 0">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Success!&nbsp;&nbsp;&nbsp;</strong> <?=$_SESSION["msg"]?>
  </div>
<?php 
unset($_SESSION["msg"]);
}?>     

<div class="col-lg-12">

<? if($pager->total_records!=0) {?>
<div class="col-lg-6 text-left" >
<? $pager->show_displaying()?>
</div>
<div class="col-lg-6 text-right" >Records Per Page:
<?=pagesize_dropdown('pagesize', $pagesize);?>
</div>
<?php
}
?>

</div>


                  <div class="col-sm-12">
                     <div class="panel panel-bd lobidrag" data-edit-title='false' data-close='false' data-reload='false'>
                        
                        
                           
                        
                        
                        <div class="panel-heading">
                           <div class="btn-group" id="buttonexport">
                              <a href="#">
<h4>Sale & Inventory </h4>
                              </a>
                           </div>
                        </div>
                        
                        



                        
                        <div class="panel-body">
                       
<? if($pager->total_records>0) {?>                       
                       
                           <div class="table-responsive">
<form action="" method="post" enctype="multipart/form-data">                           
                              <table id="dataTableExample1" class="table table-bordered table-striped table-hover">
                                 <thead>
                                    <tr class="info">                                      
                                       <th class="text-center">S.No.</th>                                                  
                                       <th class="text-center">Item</th>                                       
                                       <th class="text-center">Total Qnty</th>
                                       <th class="text-center">Qnty Sold</th>
                                       <th class="text-center">Total Sale</th>
                                       <th class="text-center">Edit</th>
                                    </tr>
                                 </thead>
                                 
<tbody>
                                   
<?
$cnt=0;
while ($line_raw = mysqli_fetch_array($result)) {
	$line = ms_display_value($line_raw);
	@extract($line);
	$css = ($css=='trOdd')?'trEven':'trOdd';
?>                                   
                                    <tr>
                            
                            
                            <td class="text-center v-middle"><?=++$start?></td>
                            
                            
                                     
<td class="text-left v-middle " style="padding-left:20px">

<a href="Javascript:void(0)" onClick ="PopupWindowCenter('sale_detail.php?prdID=<?=$line_raw["category_id"]?>', 'PopupWindowCenter',1000,400)" ><?=$line_raw["category_name"]?></a> </td>
                                     

<td class="text-center v-middle"  >
<div class="col-lg-12 text-center" align="center" id="all_area_<?=$line_raw["category_id"]?>">
<div class="col-lg-12" id="qnty_area_<?=$line_raw["category_id"]?>" style="display:block">
<?php
if($line_raw["category_qnty"]>0){
?>
<span style="color:#090;font-weight:600"><?=$line_raw["category_qnty"]?></span>
<?php
}else{
?>	
<span style="color:red;font-weight:600">Out Of Stock</span>	
<?php
}
?>
</div>

<div class="col-lg-12" id="edit_qnty_<?=$line_raw["category_id"]?>" style="display:none">
<input type="text" name="edit_qnty"  class="txt_qnty" id="txt_qnty_<?=$line_raw["category_id"]?>" value="<?=$line_raw["category_qnty"]?>" style="width:50%;text-align:center; "  autocomplete="off" /><button type="button" id="save_qnty_<?=$line_raw["category_id"]?>" onClick="save_prd_qnty(<?=$line_raw["category_id"]?>)"><i class="fa fa-save fa-lg"></i></button></div>
</div>

<div class=" clearfix"></div>
</td>


<td class="v-middle" align="center">
<?php
$qntySold=db_scalar("SELECT SUM(item_qnty) FROM tbl_sale_inventory WHERE prd_id='$line_raw[category_id]'");
if($qntySold!=""){
echo $qntySold;	
}else{
echo "0";	
}
?>
</td>



<td class="text-center v-middle">
<i class="fa fa-inr" aria-hidden="true"></i>
<?php
$qntySold=db_scalar("SELECT SUM(total_amount) FROM tbl_sale_inventory WHERE prd_id='$line_raw[category_id]'");
if($qntySold!=""){
echo $qntySold;	
}else{
echo "0";	
}
?>                                       
</td>


<td class="text-center v-middle">
<button type="button" class="" onClick="edit_quantity(<?=$line_raw['category_id']?>);" id="edit_<?=$line_raw['category_id']?>" ><i class="fa fa-pencil"></i></button>


</td>                                           
                                       
                                    </tr>
<?php
}
?>
                                    
                                    
                                    
                                    
                                 </tbody>
</form>
                              </table>
                              
<? $pager->show_pager();?>
                                             
                              
                           </div>
<?php }else{?>
<div class="col-lg-12 msg text-center">Sorry, no records found.</div>
<?php }?>
                                  
                           
                        </div>
                     </div>
                  </div>
               </div>
               <!-- customer Modal1 -->
               <div class="modal fade" id="customer1" tabindex="-1" role="dialog" aria-hidden="true">
                  <div class="modal-dialog">
                     <div class="modal-content">
                        <div class="modal-header modal-header-primary">
                           <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                           <h3><i class="fa fa-file-text-o m-r-5"></i> Update Page</h3>
                        </div>
                        <div class="modal-body">
                           <div class="row">
                              <div class="col-md-12">
                                 <form class="form-horizontal">
                                    <fieldset>
                                       <!-- Text input-->
                                       <div class="col-md-4 form-group">
                                          <label class="control-label">Customer Name:</label>
                                          <input type="text" placeholder="Customer Name" class="form-control">
                                       </div>
                                       <!-- Text input-->
                                       <div class="col-md-4 form-group">
                                          <label class="control-label">Email:</label>
                                          <input type="email" placeholder="Email" class="form-control">
                                       </div>
                                       <!-- Text input-->
                                       <div class="col-md-4 form-group">
                                          <label class="control-label">Mobile</label>
                                          <input type="number" placeholder="Mobile" class="form-control">
                                       </div>
                                       <div class="col-md-6 form-group">
                                          <label class="control-label">Address</label><br>
                                          <textarea name="address" rows="3"></textarea>
                                       </div>
                                       <div class="col-md-6 form-group">
                                          <label class="control-label">type</label>
                                          <input type="text" placeholder="type" class="form-control">
                                       </div>
                                       <div class="col-md-12 form-group user-form-group">
                                          <div class="pull-right">
                                             <button type="button" class="btn btn-danger btn-sm">Cancel</button>
                                             <button type="submit" class="btn btn-add btn-sm">Save</button>
                                          </div>
                                       </div>
                                    </fieldset>
                                 </form>
                              </div>
                           </div>
                        </div>
                        <div class="modal-footer">
                           <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>
                        </div>
                     </div>
                     <!-- /.modal-content -->
                  </div>
                  <!-- /.modal-dialog -->
               </div>
               <!-- /.modal -->
               <!-- Modal -->    
               <!-- Customer Modal2 -->
               
               <!-- /.modal -->
            </section>

            <!-- /.content -->
         </div>
<?php require_once("footer.php"); ?>
<script>

    
function edit_quantity(catID){

$(document).ready(function(e) {
	
//alert(catID);
var toHide="qnty_area_"+catID;	
var toShow="edit_qnty_"+catID;	

$("#"+toShow).show("fast");
$("#"+toHide).hide("fast");



});
	
}


function save_prd_qnty(catID){

$(document).ready(function(e) {
	
var toHide="#edit_qnty_"+catID;	
var toShow="#qnty_area_"+catID;

var allArea="#all_area_"+catID;


//alert(catID);

var qnty=$("#txt_qnty_"+catID).val();

$.ajax({
type:"GET",
url:'update-prd-qnty.php?catID='+catID+"&qnty="+qnty,
processData:true,
success: function(data){

if(data==1){	

$(toShow).show("fast");
$(toHide).hide("fast");

$(allArea).fadeOut('slow').load('reload-prd-qnty.php?catID='+catID).fadeIn("slow");	

}else{
alert("Unable to update this record.");	
}

}
	
});    

});
	
}


</script>