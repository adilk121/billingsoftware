<?php require_once("header.php");?>
<?php require_once("left-nav.php");?>
<style>
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
$sql="UPDATE tbl_reseller_products SET resprd_prd_status='Inactive' WHERE resprd_id='$subcatID' ";	
$res=db_query($sql);	
if($res>0){
$_SESSION["msg"]="Selected product is deactivated successfully.";	
}	
}else{
$sql="UPDATE tbl_reseller_products SET resprd_prd_status='Active' WHERE resprd_id='$subcatID' ";	
$res=db_query($sql);	
if($res>0){
$_SESSION["msg"]="Selected product is activated successfully.";	
}	
	
}

header("location:reseller_product_list.php");
exit;
}


if(is_post_back()) {
	$arr_ids = $_REQUEST['arr_ids'];
	if(is_array($arr_ids)) {
		$str_ids = implode(',', $arr_ids); 
		if(isset($_REQUEST['Activate']) || isset($_REQUEST['Activate_x']) ) {
			db_query("update tbl_reseller_products set resprd_prd_status='Active' where resprd_id in ($str_ids)");
			$_SESSION["msg"]="selected products are activated. ";
		} else if(isset($_REQUEST['Deactivate']) || isset($_REQUEST['Deactivate_x']) ) {
			db_query("update tbl_reseller_products set resprd_prd_status='Inactive' where resprd_id in ($str_ids)");
						$_SESSION["msg"]="selected products are deactivated. ";
		}else if(isset($_REQUEST['Delete']) || isset($_REQUEST['Delete_x']) ) {
			db_query("DELETE FROM tbl_reseller_products WHERE resprd_id in ($str_ids)");
						$_SESSION["msg"]="selected products are deleted. ";
		}
		
	}

		
	header("Location: ".$_SERVER['HTTP_REFERER']);
	exit;
}

$cond="";
if($resellerID!=""){
$cond="WHERE resprd_reseller_id='$resellerID'";	
}

$start = intval($start);
$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;

$order_by == '' ? $order_by = 'resprd_prd_status' : true;
$order_by2 == '' ? $order_by2 = 'Desc' : true;
 
$sql = "select * from  tbl_reseller_products AS rp INNER JOIN tbl_category ct ON rp.resprd_prd_id=ct.category_id $cond";
$sql = apply_filter($sql, $category_name, 'like','resprd_prd_name');
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
                  <i class="fa fa-list" aria-hidden="true"></i>

               </div>
               <div class="header-title">
                  <h1>Reseller Product</h1>
                  <small>Product List</small>
                  
                  
                  
                  <a href="add-reseller-product.php"><button id="btn-go-back" type="button" class="btn btn-labeled btn-inverse m-b-5 pull-right">
<span class="btn-label"><i class="fa fa-plus" aria-hidden="true"></i>
</span>Add Product
</button></a>
          
          
          <span class="count-num">Total : <?=db_scalar("select COUNT(*) from  tbl_reseller_products AS rp INNER JOIN tbl_category ct ON rp.resprd_prd_id=ct.category_id")?></span>    
          
          
<select class="form-control " id="resller-ord" onChange="filterbyreseller(this.value)" >
<option value="0">Filter By Reseller</option>
<?php
$sql="SELECT * FROM tbl_resellers WHERE reseller_status='Active'";
$data=db_query($sql);
$count=mysqli_num_rows($data);
if($count){
while($rec=mysqli_fetch_array($data)){	
?>                  
<option value="<?=$rec['reseller_id']?>"><?=$rec['reseller_email']?> (<?=$rec['reseller_name']?>)</option>
<?php
}
}
?>
<option value="all">All</option>
</select>          
          
          
          
<?php if($_REQUEST['resellerID']!=""){?>          
<a href="manage-resellers.php" class="btn btn-link" style="float: right;
    font-size: 14px;
    margin: -16px 18px 0 0;
    border: solid thin #337ab785;"><i class="fa fa-chevron-circle-left" aria-hidden="true"></i>
Go To Reseller</a>
<?php }?>          
              
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
                                 <h4>Reseller Product List 

<?php if($_REQUEST['resellerID']!=""){?>                                 
<i class="fa fa-angle-double-right" ></i>                                 
<span style="margin-left:5px; font-size:16px;color:#8e32a2c7">
<?=db_scalar("SELECT category_name FROM tbl_category WHERE 1 AND category_id='$catID'")?></span> &nbsp;&nbsp;
<?php }?>

                                 
                                 
                                 </h4>
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
                                       <th class="text-center" style="width:5%">S.No.</th>            
                                       <th class="text-center" style="width:10%">Image</th>            
                                       <th class="text-center" style="width:30%">Name</th>                                       <th class="text-center" style="width:30%">Price</th>
                                       <th class="text-center" style="width:10%">Status</th>
                                       <th class="text-center" style="width:10%">Action</th>
                                       <th class="text-center" style="width:5%"><input name="check_all" type="checkbox" id="check_all" value="1" onclick="checkall(this.form)" /></th>
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
                            
                            
                            <td class="text-center v-middle"><?=++$cnt?></td>
                            
                             <td align="center" ><img src="<?=SITE_WS_PATH?>/uploaded_files/home_cat_thumb/<?=$category_image_name?>"  class="thumbnail" style="width:65px;height:65px; margin-top:0;margin-bottom:0" />

<?php if($category_is_new=='Yes'){?>
<span class="new-lbl">New</span>                             
<?php }?>
                             
                             </td>
                                     
<td class="text-left v-middle " style="padding-left:20px">

<div class="bold pb5 pt5 " style="width:auto">
<a href="Javascript:void(0)" onClick ="PopupWindowCenter('reseller_detail.php?user_id=<?=$line_raw['resprd_reseller_id']?>', 'PopupWindowCenter',400,400)"><?=db_scalar("SELECT reseller_name FROM tbl_resellers WHERE reseller_id='$line_raw[resprd_reseller_id]'")?>&nbsp;<i class="fa fa-chevron-circle-right"></i>
</a></div>

<?=$line_raw["category_name"]?> </td>
                                     

<td class="text-center v-middle" >

<table  style="width:100%">

<tr>
<td style="width:45%;text-align:right;font-weight:600">Our Price</td><td style="width:5%;text-align:right;font-weight:600">:</td>
<td style="width:50%;text-align:left;padding-left:15px"><i class="fa fa-inr">&nbsp;</i><?=$line_raw["category_discount_price"]?></td>
</tr>

<tr>
<td style="width:45%;text-align:right;font-weight:600;padding-top:10px">Reseller Price</td><td style="width:5%;text-align:right;font-weight:600">:</td>
<td style="width:50%;text-align:left;padding-left:15px;padding-top:10px"><i class="fa fa-inr">&nbsp;</i><?=$line_raw["resprd_prd_display_price"]?></td>
</tr>


<tr>
<td style="width:45%;text-align:right;font-weight:600;padding:10px 0 0 0;color:#C30">Reseller Margin</td><td style="width:5%;text-align:right;font-weight:600">:</td>
<td style="width:50%;text-align:left;padding:10px 0 0 15px;"><i class="fa fa-inr">&nbsp;</i><?=$line_raw["resprd_prd_margin_amount"]?>
<span class="bold" style="color:#06F">&nbsp;(<?php
$storePrice=$line_raw["category_discount_price"];
$marginAmount=$line_raw["resprd_prd_margin_amount"];

if($marginAmount>0 && $storePrice >0){
$per=($marginAmount/$storePrice)*100;
echo round($per,1);
}else{ echo "0";}
?>%)
</span>
</td>
</tr>





</table>



</td>


<td class="v-middle" align="center">

<?php if($line_raw["resprd_prd_status"]=="Active"){?>
<a href="reseller_product_list.php?st=1&pid=<?=$line_raw["resprd_id"]?>"><span class="label-custom label label-default">Active</span></a>
<?php }else{?>
<a href="reseller_product_list.php?st=0&pid=<?=$line_raw["resprd_id"]?>"><span class="label-danger label label-default">Inactive</span></a>
<?php }?>


</td>



<td class="text-center v-middle">
<a href="edit-reseller-product.php?resprd_id=<?=$line_raw["resprd_id"]?>"><button type="button" class="btn btn-add btn-sm" ><i class="fa fa-pencil"></i></button>
</a>                                          
</td>


<td class="text-center v-middle"><input name="arr_ids[]" type="checkbox" id="arr_ids[]" value="<?=$resprd_id?>" /></td>                                           
                                       
                                    </tr>
<?php
}
?>
                                    
<tr> <td colspan="8">




<button  style="background-color:#CA0000;border:solid #CA0000" type="submit" name="Delete" onClick="return select_chk()"  class="btn btn-primary pull-left ml5 " >Delete</button>



<button type="submit" name="Deactivate"  class="btn btn-danger pull-right mr5" >Make Inactive</button>

<button type="submit" name="Activate" class="btn btn-success pull-right mr5" >Make Active</button>


</td></tr>                                    
                                    
                                    
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
               
               <!-- /.modal -->
               <!-- Modal -->    
               <!-- Customer Modal2 -->
               
               <!-- /.modal -->
            </section>
            <!-- /.content -->
         </div>
<?php require_once("footer.php"); ?>
<script>
function filterbyreseller(uid){

if(uid=="all"){	
window.location="reseller_product_list.php";		
}else{
window.location="reseller_product_list.php?resellerID="+uid;	
}

}
</script>