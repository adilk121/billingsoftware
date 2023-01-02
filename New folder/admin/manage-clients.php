<?php require_once("header.php");?>
<?php require_once("left-nav.php");?>
<style>
.v-middle {
vertical-align:middle !important;
}
</style>
<?php
$show_deleted_client=$_REQUEST['Deleted_Client'];
if($show_deleted_client=="")
{
  $show_deleted_client="No";
}


if($st!=""){
$st=$_REQUEST['st'];
$catID=$_REQUEST['pid'];

if($st==1){
$sql="UPDATE tbl_clients SET client_status='Inactive' WHERE client_id='$catID' ";	
$res=db_query($sql);	
if($res>0){
$_SESSION["msg"]="Selected client is deactivated successfully.";	
}	
}else{
$sql="UPDATE tbl_clients SET client_status='Active' WHERE client_id='$catID' ";	
$res=db_query($sql);	
if($res>0){
$_SESSION["msg"]="Selected client is activated successfully.";	
}	
	
}

header("location:manage-clients.php?Deleted_Client=$show_deleted_client");
exit;
}



if(is_post_back()) {
   $count="";
	$arr_ids = $_REQUEST['arr_ids'];

   
	if(is_array($arr_ids)) {
		$str_ids = implode(',', $arr_ids); 
		if(isset($_REQUEST['Activate']) || isset($_REQUEST['Activate_x']) ) {
			db_query("update tbl_clients set client_status='Active' where client_id in ($str_ids)");
			$_SESSION["msg"]="selected clients are activated. ";
		} else if(isset($_REQUEST['Deactivate']) || isset($_REQUEST['Deactivate_x']) ) {
			db_query("update tbl_clients set client_status='Inactive' where client_id in ($str_ids)");
						$_SESSION["msg"]="selected clients are deactivated. ";
		}else  if(isset($_REQUEST['Delete'])){
         db_query("update tbl_clients set client_deleted='Yes' where client_id in ($str_ids)");
            $_SESSION["msg"]="selected clients are deleted. ";
          }else  if(isset($_REQUEST['Restore'])){
         db_query("update tbl_clients set client_deleted='No' where client_id in ($str_ids)");
            $_SESSION["msg"]="selected clients are restored. ";
          }

		
	}
/*	if(isset($_REQUEST['Update'])){
		foreach($test_order_by as $key=>$value){
		db_query("update tbl_testimonial set test_order_by='$value' where test_id='$key'");
		}
	}
	$_SESSION["msg"]="Selected testimonial(s) order updated";	*/
	header("Location: ".$_SERVER['HTTP_REFERER']);
	exit;
}

$search_con="";
if(isset($_REQUEST['search_submit']))
{
if($_REQUEST['search_value']!="")
{
	$value=$_REQUEST['search_value'];
	$search_con="and (client_cid='$value' OR client_company_name like '%$value%' OR client_email like '%$value%' OR client_mobile like '%$value%') ";
}

}


$start = intval($start);
$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;

$order_by == '' ? $order_by = 'client_id' : true;
$order_by2 == '' ? $order_by2 = 'desc' : true;
 
$sql = "select * from  tbl_clients where 1 and client_deleted='$show_deleted_client' $search_con";
$sql = apply_filter($sql, $client_name, 'like','client_name');
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
                  <i class="fa fa-users" aria-hidden="true"></i>

               </div>
               <div class="header-title">
                  <h1>Clients</h1>
                  <small>Clients List</small>
                  
                  
                  
 
                 
                 
                 <a href="add-edit-client.php?id=0"><button id="btn-go-back" type="button" class="btn btn-labeled btn-inverse m-b-5 pull-right">
<span class="btn-label"><i class="fa fa-plus" aria-hidden="true"></i>
</span>Add New Client
</button></a>

 <span class="count-num">Total : <?=db_scalar("SELECT COUNT(client_id) FROM  tbl_clients where client_deleted='$show_deleted_client' ")?></span> 
             
<?php if($show_deleted_client=="No"){?>
<a href="manage-clients.php?Deleted_Client=Yes">
<span class="count-num" style="background-color: black;"><i class="fa fa-trash"></i> Show Deleted Client</span> 
</a>
<?}else{?>
<a href="manage-clients.php?Deleted_Client=No">
<span class="count-num" style="background-color: black;"><i class="fa fa-users"></i> Show Undeleted Client</span> 
</a>
<?}?>     
               </div>


           
               
            </section>
            <!-- Main content -->
            <section class="content">
               <div class="row">

               	<div class="col-lg-6 col-lg-offset-4">
                     <p>
                     	<form action="" method="get">
                   <input type="text" placeholder="CID/Company Name/Email/Mobile" value="<?=$_REQUEST['search_value']?>" name="search_value" class="form-control text-center" style="width:300px; float: left;" required />
                     
                   <input type="submit" value="Search" class="btn btn-primary" name="search_submit" />

                    <input type="hidden" name="Deleted_Client" value="<?=$show_deleted_client?>">

                   <?php  if($_REQUEST['search_value']!=""){?>
                   <a href="manage-clients.php?Deleted_Client=<?=$show_deleted_client?>">Clear</a>
                   <?}?>
               </form>
</p>

               </div>

<?php if($_SESSION["msg"]!=""){?>            
<br>   <br>   
<div class="alert alert-success alert-dismissable fade in text-center" style="background-color:#dff0d8;border:none; color:#000;margin:10px 0 0 0">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Success!&nbsp;&nbsp;&nbsp;</strong>  <?=$_SESSION["msg"]?>
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
               <h4>Clients List</h4>
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
                                       <th class="text-center">CID/Email/Mobile</th>            
                                       <th class="text-center">Customer Details</th>                                       
                                       <th class="text-center">Orders</th>
                                       <th class="text-center">Status</th>

                                       <th class="text-center">Edit</th>
                                       <th class="text-center"><input name="check_all" type="checkbox" id="check_all" value="1" onclick="checkall(this.form)" /></th>
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
                            
                             <td align="left" width="20%">
<!-- <?php if($test_image_name!=""){?>                             
<?//=SITE_WS_PATH?>
<img src="../test_images/<?=$test_image_name?>"  class="thumbnail" style="width:65px;height:65px; margin-top:0;margin-bottom:0" />
<?php }else{?>
<img src="assets/dist/img/Noimage.png"  class="thumbnail" style="width:65px;height:65px; margin-top:0;margin-bottom:0" />
<?php }?> -->

<strong>CID: </strong><?=$client_cid?><br>
<strong><i class="fa fa-envelope"></i> </strong><?=$client_email?><br>
<strong><i class="fa fa-phone"></i> </strong><?=$client_mobile?>


</td>
                                     
<td class="v-middle" align="left" >
<strong>Name: </strong><?=$client_name?><br>
<strong>Company: </strong><?=$client_company_name?><br>
<strong>Address: </strong><?=$client_billing_address?>
 </td>



 <td class="v-middle" align="center">
<?=db_scalar("select count(invoice_order_id) from tbl_invoice_order where invoice_order_client_id='$line_raw[client_id]'")?>
<?php if($show_deleted_client=="No"){?>
<br>
<a href="add-edit-order-invoice.php?id=0&client_ID=<?=$line_raw['client_id']?>" ><span style="color:black !important;" class="label-warning label label-default"><i class="fa fa-plus"></i> Add Order/Invoide</span></a>
<?}?>

 </td>



<td class="text-center v-middle">
<?php if($line_raw["client_status"]=="Active"){?>
<a href="manage-clients.php?st=1&pid=<?=$line_raw["client_id"]?>&Deleted_Client=<?=$show_deleted_client?>"><span class="label-custom label label-default">Active</span></a>
<?php }else{?>
<a href="manage-clients.php?st=0&pid=<?=$line_raw["client_id"]?>&Deleted_Client=<?=$show_deleted_client?>"><span class="label-danger label label-default">Inactive</span></a>
<?php }?>

</td>






<td class="text-center v-middle">
<a href="add-edit-client.php?id=<?=$line_raw["client_id"]?>&Deleted_Client=<?=$show_deleted_client?>"><button type="button" class="btn btn-add btn-sm" ><i class="fa fa-pencil"></i></button>
</a>                                          
</td>


<td class="text-center v-middle"><input name="arr_ids[]" type="checkbox" id="arr_ids[]" value="<?=$client_id?>" /></td>                                           
                                       
                                    </tr>
<?php
}
?>
                                    
<tr> <td colspan="8">



<?php if($show_deleted_client=="No"){?>
 <button  style="background-color:#CA0000;border:solid #CA0000" type="submit" name="Delete" onClick="return select_chk()"  class="btn btn-primary pull-left ml5 " >Delete</button> 
 <?}else{?>
 <button  style="background-color:green;border:solid green" type="submit" name="Restore" onClick="return select_chk()"  class="btn btn-primary pull-left ml5 " >Restore</button> 
 <?}?> 


                          
                        


<button type="submit" name="Deactivate"  class="btn btn-primary pull-right mr5"  onClick="return select_chk()">Make Inactive</button>

<button type="submit" name="Activate" class="btn btn-success pull-right mr5"  onClick="return select_chk()">Make Active</button>
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