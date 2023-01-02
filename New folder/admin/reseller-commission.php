<?php require_once("header.php");?>
<?php require_once("left-nav.php");?>
<style>
.v-middle {
vertical-align:middle !important;
}
</style>
<?php
if($st!=""){
$st=$_REQUEST['st'];
$pageID=$_REQUEST['pid'];

if($st==1){
$sql="UPDATE tbl_resellers SET reseller_status='Inactive' WHERE reseller_id='$pageID' ";	
$res=db_query($sql);	
if($res>0){
$_SESSION["msg"]="Selected reseller is deactivated successfully.";	
}	
}else{
$sql="UPDATE tbl_resellers SET reseller_status='Active' WHERE reseller_id='$pageID' ";	
$res=db_query($sql);	
if($res>0){
$_SESSION["msg"]="Selected reseller is activated successfully.";	
}	
	
}

header("location:manage-resellers.php");
exit;
}
?>

<?php
$del_id=$_GET['del_id'];
if($del_id!=""){

$sql="DELETE FROM tbl_resellers  WHERE reseller_id='$del_id' ";	
$res=db_query($sql);	
if($res>0){
$_SESSION["msg"]="Selected reseller is deleted successfully.";	

}

header("location:manage-resellers.php");
exit;
}
?>




<?php
if(is_post_back()) {
	$arr_ids = $_REQUEST['arr_ids'];
	if(is_array($arr_ids)) {
		$str_ids = implode(',', $arr_ids); 
		if(isset($_REQUEST['Delete']) || isset($_REQUEST['Delete_x']) ) {
			db_query("delete from  tbl_resellers where reseller_id in ($str_ids)");
		} else if(isset($_REQUEST['Activate']) || isset($_REQUEST['Activate_x']) ) {
			$res=db_query("update  tbl_resellers set reseller_status = 'Active' where reseller_id in ($str_ids)");
			  
			  if($res>0){
			  $_SESSION["msg"]="Selected resellers is actived successfully.";	
			  }
			  
		} else if(isset($_REQUEST['Deactivate']) || isset($_REQUEST['Deactivate_x']) ) {
			$res=db_query("update  tbl_resellers set reseller_status = 'Inactive' where reseller_id in ($str_ids)");
			
			 if($res>0){
			  $_SESSION["msg"]="Selected resellers is deactivated successfully.";	
			  }
			  
		}
	}

	header("Location: ".$_SERVER['HTTP_REFERER']);
	exit;
}

$start = intval($start);
$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;

$order_by == '' ? $order_by = 'reseller_status' : true;
$order_by2 == '' ? $order_by2 = 'asc' : true;
 
$sql = "select * from  tbl_resellers   where 1";
$sql = apply_filter($sql, $reseller_name, 'like','reseller_name');
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
                  <i class="fa fa-money" aria-hidden="true"></i>

               </div>
               <div class="header-title">
                  <h1>Commission
                  

                  
                  </h1>
                  <small>Commission List</small>
                  
                  
                  
               </div>


           
               
            </section>
            <!-- Main content -->
            <section class="content">
               <div class="row">

<?php if($_SESSION["msg"]!=""){?>               
<div class="alert alert-success alert-dismissable fade in text-center" style="background-color:#dff0d8;border:none; color:#000;margin:10px 0 0 0">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Success!&nbsp;&nbsp;&nbsp;</strong> <?=$_SESSION["msg"]?>.
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
                                 <h4>Commission</h4>
                              </a>
                           </div>
                        </div>
                        
                        



                        
                        <div class="panel-body">
                        <!-- Plugin content:powerpoint,txt,pdf,png,word,xl -->
                           <!-- Plugin content:powerpoint,txt,pdf,png,word,xl -->
<? if($pager->total_records>0) {?>                           
                           
                           <div class="table-responsive">
<form action="" method="post" enctype="multipart/form-data">                           
                              <table id="dataTableExample1" class="table table-bordered table-striped table-hover">
                                 <thead>
                                    <tr class="info">                                      
                                       <th class="text-center">S.No.</th>            
                                       <th class="text-center">User Info.</th>                                       
                                       <th class="text-center">Sale Count</th>                                       
                                       <th class="text-center">Commission</th>                                                                              
                                       <th class="text-center">Status</th>
                                       <th class="text-center">Action</th>
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
                                     
                                       <td class="text-left v-middle">
									   
									   <p class="bold"><a href="javascript:void(0);" onClick ="PopupWindowCenter('reseller_detail.php?user_id=<?=$reseller_id?>&user_type=<?=$reseller_user_type?>', 'PopupWindowCenter',450,450)"><?=$line_raw["reseller_name"]?></a></p>
                                       
                                       
                                       <p><?="<strong>UID : </strong>".$line_raw["reseller_email"]?></p>                                       
                                       
                                       
                                       
                                       </td>
                                     
<td class="text-center v-middle" >


<div class="text-center mt15" align="center" >
<a href="javascript:void(0);" onClick ="PopupWindowCenter('view-commission-detail.php?resID=<?=$line_raw['reseller_id']?>', 'PopupWindowCenter',1200,500)"><span class=" bold"  style="width:200px ;padding:4px 50px"> <?=db_scalar("SELECT COUNT(od_id) FROM   tbl_order_detail WHERE order_refer_id='$line_raw[reseller_id]' AND order_pay_status='Paid'")?></span></a>
</div>
</td>


<td class="text-center v-middle" >
<div class="text-center mt15" align="center" >
<a href="javascript:void(0);" onClick ="PopupWindowCenter('view-commission-detail.php?resID=<?=$line_raw['reseller_id']?>', 'PopupWindowCenter',1200,500)"><span class=" bold"  style="width:200px ;padding:4px 50px"><i class="fa fa-inr font-black"></i> 
<?php
$sql="SELECT SUM(order_refer_commission) FROM tbl_order_detail WHERE order_refer_id='$line_raw[reseller_id]' AND order_pay_status='Paid' ";
$commission=db_scalar($sql);
echo $commission;
?>



<? //db_scalar("SELECT SUM(ord_net_amount) FROM   tbl_order WHERE ord_refer_id='$line_raw[reseller_id]' AND order_payment_status='Paid'")?> </span></a>
</div>
</td>

<td class="text-center v-middle">
<?php if($line_raw["reseller_status"]=="Active"){?>
<span class="label-custom label label-default">Active</span>
<?php }else{?>
<span class="label-danger label label-default">Inactive</span>
<?php }?>

</td>
                                       <td class="text-center v-middle">






<p><a href="javascript:void(0);" onClick ="PopupWindowCenter('view-commission-detail.php?resID=<?=$line_raw['reseller_id']?>', 'PopupWindowCenter',1200,500)"><strong style="font-size:12px;"><button type="button" class="btn btn-view btn-sm" ><i class="fa fa-search"></i></button></strong></a>                                         
</p>



                                     
                                       </td>
<td class="text-center v-middle"><input name="arr_ids[]" type="checkbox" id="arr_ids[]" value="<?=$reseller_id?>" /></td>                                           
                                       
                                    </tr>
<?php
}
?>
                                    
<!--<tr> <td colspan="6">

<button class="btn btn-danger pull-left" type="submit" name="Delete"><i class="fa fa-trash-o"></i>&nbsp;Delete</button>

<button type="submit" name="Deactivate"  class="btn btn-warning pull-right " >Make Inactive</button>

<button type="submit" name="Activate" class="btn btn-success pull-right mr5" >Make Active</button>
</td></tr>   -->                                 
                                    
                                    
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