<?php require_once("header.php");?>
<?php require_once("left-nav.php");?>
<style>
.v-middle {
vertical-align:middle !important;
}
</style>
<?php
$del_id=$_GET['del_id'];
if($del_id!=""){

$sql="UPDATE tbl_order SET ord_is_deleted='Yes' WHERE ord_id='$del_id'";
$res=db_query($sql);


if($res>0){
$_SESSION["msg"]="Selected order is deleted successfully."; 

}

header("location:manage-order.php");
exit;
}
?>




<?php
if(is_post_back()) {

$arr_ids = $_REQUEST['arr_ids'];
   
   if(is_array($arr_ids)) {
      $str_ids = implode(',', $arr_ids); 
      if(isset($_REQUEST['Delete']) || isset($_REQUEST['Delete_x']) ) {
         
      
         
         $res=db_query("UPDATE tbl_order SET ord_is_deleted='Yes' WHERE  ord_id in ($str_ids)");
             
          if($res>0){
          $_SESSION["msg"]="Selected orders are deleted successfully.";                 
          }
         
         
     
      }else if($_REQUEST['changeStatus']!="0"){
         
         $status=$_REQUEST['changeStatus'];
         $res=db_query("update tbl_order set ord_status = '$status' WHERE ord_id in ($str_ids) ");

   
      }else if($_REQUEST['changePayStatus']!="0"){
         
         $status=$_REQUEST['changePayStatus'];
         $res=db_query("update tbl_order set order_payment_status = '$status' WHERE ord_id in ($str_ids) ");

   
      }
   }

   //header("Location: ".$_SERVER['HTTP_REFERER']);
   //exit;
}

//////////////////// FILTER BY USER ///////////////////////
$uid=$_REQUEST['uid'];
$cond="";

if($uid!=""){
$cond=" AND ord_reg_id='$uid'";  
}


//////////////////////////////////////////////////////////

//////////////////// FILTER BY RESELLER ///////////////////////
$rID=$_REQUEST['rID'];
$cond2="";

if($rID!=""){
$cond2=" AND ord_refer_id='$rID'";  
}


//////////////////////////////////////////////////////////




$start = intval($start);
$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;

$order_by == '' ? $order_by = 'ord_id' : true;
$order_by2 == '' ? $order_by2 = 'desc' : true;
 
$sql = "select * from   tbl_order  where 1 AND ord_is_deleted='No' ";
$sql = apply_filter($sql, $reg_name, 'like','ord_id');
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
                  <i class="fa fa-cart-plus" aria-hidden="true"></i>

               </div>
               <div class="header-title">
                  <h1>Order
                  

                  
                  </h1>
                  <small>Order List</small>
                  
                  
                  
           <?/*       
<select class="form-control " id="buyer-ord" onChange="filterbyuser(this.value)" >
<option value="0">Filter By Buyer</option>
<?php
$sql="SELECT * FROM tbl_registration WHERE reg_status='Active'";
$data=db_query($sql);
$count=mysqli_num_rows($data);
if($count){
while($rec=mysqli_fetch_array($data)){ 
?>                  
<option value="<?=$rec['reg_id']?>"><?=$rec['reg_email']?> (<?=$rec['reg_name']?>)</option>
<?php
}
}
?>

</select>



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

</select>
*/?>
                  
                  
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
                                 <h4>Order List</h4>
                              </a>
                           </div>
                        </div>
                        
                        



                        
                        <div class="panel-body">
                        <!-- Plugin content:powerpoint,txt,pdf,png,word,xl -->
                           <!-- Plugin content:powerpoint,txt,pdf,png,word,xl -->
<? if($pager->total_records>0) {?>                           
                           
                           <div class="table-responsive">
<form action="" id="frm_ord" name="frm_ord" method="post" enctype="multipart/form-data">                           
                              <table id="dataTableExample1" class="table table-bordered table-striped table-hover">
                                 <thead>
                                    <tr class="info">                                      
                                       <th class="text-center">S.No.</th>            
                                       <th class="text-center">Order No./User Info.</th>                                       
                                       <th class="text-center">Order Date</th>                                       
                                       <th class="text-center">Status Order/Pay</th>
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
   
$sql="SELECT * FROM tbl_registration WHERE reg_id='$line_raw[ord_reg_id]'";
$dataReg=db_query($sql);
$recReg=mysqli_fetch_array($dataReg);
?>                                   
<tr>
<td class="text-center v-middle"><?=++$cnt?></td>

<td class="text-left v-middle">

<!-- <a href="Javascript:void(0)" onClick ="PopupWindowCenter('view-order-detail.php?user_id=<?=$recReg['reg_id']?>&ord_id=<?=$line_raw["ord_id"]?>', 'PopupWindowCenter',1000,400)"> -->

<a href="view-order-detail.php?user_id=<?=$recReg['reg_id']?>&ord_id=<?=$line_raw["ord_id"]?>" target="_blank">

   <p class="text-danger bold">#TCORD<?=$line_raw["ord_id"]?></p></a>
<p><?=$recReg["reg_name"]?></p>
<p><?="<strong>Mb : </strong>".$recReg["reg_mobile_no"]?></p>
<p><?="<strong>UID : </strong>".$recReg["reg_email"]?></p>                                       
</td>
                                     
<td class="text-center v-middle">
<!-- <a href="Javascript:void(0)" onClick ="PopupWindowCenter('view-order-detail.php?user_id=<?=$recReg['reg_id']?>&ord_id=<?=$line_raw["ord_id"]?>', 'PopupWindowCenter',1000,400)"> -->

   <a href="view-order-detail.php?user_id=<?=$recReg['reg_id']?>&ord_id=<?=$line_raw["ord_id"]?>" target="_blank">
<p class="bg-primary bold"><?="Items : ".db_scalar("SELECT COUNT(od_id) FROM tbl_order_detail WHERE 1 AND order_reg_id='$recReg[reg_id]' AND order_id='$line_raw[ord_id]'")?></p></a>

<p class="bg-yellow bold"><?=date("d M y",strtotime($line_raw["ord_date"]))?></p>
</td>

<td class="text-center v-middle">

<p>
<?php if($line_raw["ord_status"]=="Active"){?>
<span class="label-custom label label-default" >Active</span>
<?php }else if($line_raw["ord_status"]=="Inactive"){?>
<span class="label-danger label label-default" >Inactive</span>
<?php }else if($line_raw["ord_status"]=="Deliver"){?>
<span class="label-primary label label-default" >Deliver</span>
<?php }else if($line_raw["ord_status"]=="Rejected"){?>
<span class="label-warning label label-default" >Rejected</span>
<?php }?>
</p>


<p>
<?php if($line_raw["order_payment_status"]=="Paid"){?>
<span class="label-custom label label-default" style="text-transform:uppercase;background-color:#06F !important;border:solid thin #06F !important" >Paid</span>
<?php }else if($line_raw["order_payment_status"]=="Unpaid"){?>
<span class="label-danger label label-default" style="text-transform:uppercase;background-color:#F00;border:solid thin #F00" >Unpaid</span>
<?php }?></p>

</td>

<td class="text-center v-middle">

<p>

<!--    <a href="javascript:void(0);" onClick ="PopupWindowCenter('view-order-detail.php?user_id=<?=$recReg['reg_id']?>&ord_id=<?=$line_raw["ord_id"]?>', 'PopupWindowCenter',1000,500)"> -->

   <a href="view-order-detail.php?user_id=<?=$recReg['reg_id']?>&ord_id=<?=$line_raw["ord_id"]?>" target="_blank">
   <strong style="font-size:12px;"><button type="button" class="btn btn-view btn-sm" ><i class="fa fa-search"></i></button></strong></a>                                         
</p>


<?php /*?><p><a href="../print-invoice.php?ordID=<?=$line_raw["ord_id"]?>" title="Generate invoice" target="_blank" ><strong style="font-size:12px;"><button type="button" class="btn  btn-sm btn-default" ><i class="fa fa-print fa-lg"></i></button></strong></a>                                         
</p><?php */?>





<?php /*?><p><a href="add-user.php?reg_id=<?=$line_raw["reg_id"]?>"><button type="button" class="btn btn-add btn-sm" ><i class="fa fa-pencil"></i></button>
</a> </p><?php */?>

<p><a href="manage-order.php?del_id=<?=$line_raw["ord_id"]?>"><button type="button" class="btn btn-danger btn-sm" ><i class="fa fa-trash"></i></button>
</a> </p>                                         
                                       </td>
<td class="text-center v-middle"><input name="arr_ids[]" type="checkbox" id="arr_ids[]" value="<?=$ord_id?>" /></td>                                           
                                       
                                    </tr>
<?php
}
?>
                                    
<tr> <td colspan="6">




<select  class="form-control" name="changeStatus" id="changeStatus" onChange="change_status(this.value)" style="width:160px;float:right;background-color:#06C;color:#FFF;border:solid thin #06C"  >

<option value="0">Choose Status</option>
<option value="Inactive">Inactive</option>
<option value="Active">Active</option>
<option value="Deliver">Deliver</option>
<option value="Rejected">Rejected</option>

</select>


<select  class="form-control" name="changePayStatus" id="changePayStatus" onChange="change_pay_status(this.value)" style="width:180px;float:right;background-color:#063;color:#FFF;border:solid thin #06C;margin-right:5px"  >

<option value="0">Choose Pay Status</option>
<option value="Paid">Paid</option>
<option value="Unpaid">Unpaid</option>
</select>


<!--<button class="btn btn-default pull-right mr10" type="submit" name="Invoice"><i class="fa fa-print"></i>&nbsp;Generate Invoice</button>
-->


<button class="btn btn-danger pull-left" type="submit" name="Delete"><i class="fa fa-trash-o"></i>&nbsp;Delete</button>






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
function change_status(st){

if(validateChecks()==true){

$(document).ready(function(e) {
$("#frm_ord").submit();    
});

}else{
alert('Please select at least one order.');
document.getElementById("changeStatus").selectedIndex = 0; //Option 10
return false;  
}

}
</script>

<script>
function change_pay_status(st){

//alert(st)
if(validateChecks()==true){

$(document).ready(function(e) {
$("#frm_ord").submit();    
});

}else{
alert('Please select at least one order.');
document.getElementById("changePayStatus").selectedIndex = 0; //Option 10
return false;  
}

}
</script>


<script>
function validateChecks() {
      var chks = document.getElementsByName('arr_ids[]');
      var checkCount = 0;
      for (var i = 0; i < chks.length; i++) {
         if (chks[i].checked) {
            checkCount++;
         }
      }
      if (checkCount < 1) {
         return false;
      }
      return true;
   }
</script>
<script>
function filterbyuser(uid){
window.location="manage-order.php?uid="+uid; 
}
</script>
<script>
function filterbyreseller(uid){
window.location="manage-order.php?rID="+uid; 
}
</script>