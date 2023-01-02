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
$catID=$_REQUEST['pid'];

if($st==1){
$sql="UPDATE tbl_invoice_order SET invoice_order_status='Inactive' WHERE invoice_order_id='$catID' ";   
$res=db_query($sql); 
if($res>0){
$_SESSION["msg"]="Selected order is deactivated successfully.";   
}  
}else{
$sql="UPDATE tbl_invoice_order SET invoice_order_status='Active' WHERE invoice_order_id='$catID' ";  
$res=db_query($sql); 
if($res>0){
$_SESSION["msg"]="Selected order is activated successfully.";  
}  
   
}

header("location:manage-orders-invoices.php");
exit;
}



if(is_post_back()) {
   $count="";
   $arr_ids = $_REQUEST['arr_ids'];

   
   if(is_array($arr_ids)) {
      $str_ids = implode(',', $arr_ids); 
      if(isset($_REQUEST['Activate']) || isset($_REQUEST['Activate_x']) ) {
         db_query("update tbl_invoice_order set invoice_order_status='Active' where invoice_order_id in ($str_ids)");
         $_SESSION["msg"]="selected orders are activated. ";
      } else if(isset($_REQUEST['Deactivate']) || isset($_REQUEST['Deactivate_x']) ) {
         db_query("update tbl_invoice_order set invoice_order_status='Inactive' where invoice_order_id in ($str_ids)");
                  $_SESSION["msg"]="selected orders are deactivated. ";
      }/*else  if(isset($_REQUEST['Delete'])){
         db_query("update tbl_clients set client_deleted='Yes' where client_id in ($str_ids)");
            $_SESSION["msg"]="selected clients are deleted. ";
          }else  if(isset($_REQUEST['Restore'])){
         db_query("update tbl_clients set client_deleted='No' where client_id in ($str_ids)");
            $_SESSION["msg"]="selected clients are restored. ";
          }*/

      
   }
/* if(isset($_REQUEST['Update'])){
      foreach($test_order_by as $key=>$value){
      db_query("update tbl_testimonial set test_order_by='$value' where test_id='$key'");
      }
   }
   $_SESSION["msg"]="Selected testimonial(s) order updated";   */
   header("Location: ".$_SERVER['HTTP_REFERER']);
   exit;
}


$search_con="";
if(isset($_REQUEST['search_submit']))
{


if($_REQUEST['search_value']!="")
{
   $value=$_REQUEST['search_value'];

$clien_sea_sql=db_query("select client_id from tbl_clients where 1 and client_name like '%$value%' OR client_mobile like '%$value%' OR client_email like '%$value%'");

while($clien_sea_res=mysqli_fetch_array($clien_sea_sql))
{
  $arr_cl_ids[]=$clien_sea_res['client_id'];
}
if($arr_cl_ids!="")
{
$str_cl_ids = implode(',', $arr_cl_ids);

  $client_name_search_con=" OR invoice_order_client_id in ($str_cl_ids)";
}

  $search_con="and (invoice_order_id='$value' $client_name_search_con ) ";
}

}


$client_con="";

if($_REQUEST['order_client_id']!="")
{
$client_con="and invoice_order_client_id='$_REQUEST[order_client_id]' ";
}


$filter_con="";
if($_REQUEST['list_filter']=="Active")
{
  $filter_con="and invoice_order_status='Active'";
}

if($_REQUEST['list_filter']=="Inactive")
{
  $filter_con="and invoice_order_status='Inactive'";
}

$start = intval($start);
$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;

$order_by == '' ? $order_by = 'invoice_order_id' : true;
$order_by2 == '' ? $order_by2 = 'desc' : true;
 
$sql = "select * from   tbl_invoice_order  where 1 $client_con $filter_con $search_con";
$sql = apply_filter($sql, $reg_name, 'like','invoice_order_id');
$sql .= " order by $order_by $order_by2 ";
$sql .= " limit $start, $pagesize ";
//echo $sql;
$pager = new midas_pager_sql($sql, $pagesize, $start);
if($pager->total_records) {
   $result = db_query($sql);
}
?>

<script language="JavaScript" type="text/javascript" src="includes/general.js"></script>

         <!-- =============================================== -->
         <!-- Content Wrapper. Contains page content -->
         <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
               <div class="header-icon">
                  <i class="fa fa-cart-plus" aria-hidden="true"></i>

               </div>
               <div class="header-title">
                  <h1>Orders</h1>
                  <small>Orders List</small>
                  





            
 
                 
                 
<a href="add-edit-order-invoice.php?id=0">
<button id="btn-go-back" type="button" class="btn btn-labeled btn-inverse m-b-5 pull-right">
<span class="btn-label"><i class="fa fa-plus" aria-hidden="true"></i>
</span>Add New Order/Invoice
</button></a>

<!-- <select class="form-control " id="buyer-ord" onChange="filterbyuser(this.value)">
<option value="0">Filter</option>                 
<option value="All">All</option>
<option value="Active">Active</option>
<option value="Scheduled">Scheduled</option>
<option value="Unpaid">Unpaid</option>
<option value="Paid">Paid</option>
<option value="Cancelled">Cancelled</option>
<option value="Deleted">Deleted</option>
</select> -->

<span class="count-num">Total : <?=db_scalar("SELECT COUNT(invoice_order_id) FROM  tbl_invoice_order ")?></span>
                  


               </div>


           
               
            </section>
            <!-- Main content -->
            <section class="content">
               <div class="row">
      <div class="col-lg-6 col-lg-offset-4">
                     <p>
                      <form action="" method="get">
                   <input type="text" placeholder="Order No./Name/Mobile/Email" value="<?=$_REQUEST['search_value']?>" name="search_value" class="form-control text-center" style="width:300px; float: left;" required/>

                   
                   <input type="hidden" name="order_client_id" value="<?=$_REQUEST['order_client_id']?>">
                
                   <input type="submit" value="Search" class="btn btn-primary" name="search_submit" />
                   <?php  if($_REQUEST['search_value']!=""){
                      $cl_ID="";
                      if($_REQUEST['order_client_id']!="")
                      {
                        $cl_ID="?order_client_id=$_REQUEST[order_client_id]";
                      }
                    ?>
                   <a href="manage-orders-invoices.php<?=$cl_ID?>">Clear</a>
                   <?}?>
               </form>
</p>

               </div>

<?php if($_SESSION["msg"]!=""){?>          
<br><br>     
<div class="alert alert-success alert-dismissable fade in text-center" style="background-color:#dff0d8;border:none; color:#000;margin:10px 0 0 0">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Success!&nbsp;&nbsp;&nbsp;</strong> <?=$_SESSION["msg"]?>.
  </div>
<?php 
unset($_SESSION["msg"]);
}?>     

<div class="col-lg-12">
<select onchange="filter_fun(this.value)">
<option value="All" <?php if($_REQUEST['list_filter']=="All"){?> selected <?}?>>Show All</option>
<option value="Active" <?php if($_REQUEST['list_filter']=="Active"){?> selected <?}?>>Show Active</option>
<option value="Inactive" <?php if($_REQUEST['list_filter']=="Inactive"){?> selected <?}?>>Show Inactive</option>
</select>

<!-- <select onchange="del_showing(this.value)">
<option value="No" <?php if($_REQUEST['Deleted_C']=="No"){?> selected <?}?> >Show Undeleted</option>
<option value="Yes" <?php if($_REQUEST['Deleted_C']=="Yes"){?> selected <?}?>>Show Deleted</option>
</select> -->

<script type="text/javascript">
 function filter_fun(filter_value)
 {
  window.location.href="manage-orders-invoices.php?list_filter="+filter_value;
 }

/*  function del_showing(del_value)
  {
window.location.href="manage-orders-invoices.php?Deleted_C="+del_value+"&list_filter=<?=$_REQUEST['list_filter']?>";
  }*/

</script>
</div>

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
                                       <th class="text-center">Order No./Client Info.</th>                                       
                                       <th class="text-center">Order Item/Amount<br>Date</th>                                       
                                       <th class="text-center">Order Status</th>
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
   
$sql="SELECT * FROM tbl_clients WHERE client_id='$line_raw[invoice_order_client_id]'";
$dataReg=db_query($sql);
$recReg=mysqli_fetch_array($dataReg);
?>                                   
<tr>
<td class="text-center v-middle"><?=++$cnt?></td>

<td class="text-left v-middle">

<!-- <a href="Javascript:void(0)" onClick ="PopupWindowCenter('view-order-detail.php?user_id=<?=$recReg['reg_id']?>&ord_id=<?=$line_raw["ord_id"]?>', 'PopupWindowCenter',1000,400)"> -->

  <a href="javascript:void(0);" onclick='window.open("view-order.php?order_id=<?=$line_raw["invoice_order_id"]?>", "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=50,left=25,width=1300,height=600");'> 

   <p class="text-danger bold">#<?=$line_raw["invoice_order_id"]?></p></a>
<p><?=$recReg["client_name"]?> <?php if($recReg["client_company_name"]!=""){?>(<span style='color:#8e09a2; font-weight: bold;'><?=$recReg["client_company_name"]?></span>)<?}?></p>
<p><?="<strong>Mobile : </strong>".$recReg["client_mobile"]?></p>
<p><?="<strong>Email : </strong>".$recReg["client_email"]?></p>                                       
</td>
                                     
<td class="text-center v-middle">
<!-- <a href="Javascript:void(0)" onClick ="PopupWindowCenter('view-order-detail.php?user_id=<?=$recReg['reg_id']?>&ord_id=<?=$line_raw["ord_id"]?>', 'PopupWindowCenter',1000,400)"> -->

    <a href="javascript:void(0);" onclick='window.open("view-order.php?order_id=<?=$line_raw["invoice_order_id"]?>", "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=50,left=25,width=1300,height=600");'> 
<p class="bg-primary bold"><?="Items : ".db_scalar("SELECT COUNT(invoice_order_detail_id) FROM tbl_invoice_order_detail WHERE 1 AND invoice_order_detail_order_id='$line_raw[invoice_order_id]' ")?></p></a>

<p class="bg-success bold"><i class="fa fa-inr"></i> <?=$line_raw["invoice_order_invoice_grand_total"]?></p>
<p class="bg-yellow bold"><?=date("d M y",strtotime($line_raw["invoice_order_add_date"]))?></p>


</td>

<td class="text-center v-middle">

<p>
<?php if($line_raw["invoice_order_status"]=="Active"){?>
<a href="manage-orders-invoices.php?st=1&pid=<?=$line_raw["invoice_order_id"]?>"><span class="label-custom label label-default">Active</span></a>
<?php }else{?>
<a href="manage-orders-invoices.php?st=0&pid=<?=$line_raw["invoice_order_id"]?>"><span class="label-danger label label-default">Inactive</span></a>
<?php }?>
</p>


</td>

<td class="text-center v-middle">

<p>

   <a href="javascript:void(0);" onclick='window.open("view-order.php?order_id=<?=$line_raw["invoice_order_id"]?>", "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=50,left=25,width=1300,height=600");'> 

  <!--  <a href="view-order-detail.php?order_id=<?=$line_raw["invoice_order_id"]?>" target="_blank"> -->
   <strong style="font-size:12px;"><button type="button" class="btn btn-view btn-sm" ><i class="fa fa-search"></i></button></strong></a>        

   <a href="add-edit-order-invoice.php?id=<?=$line_raw["invoice_order_id"]?>"><button type="button" class="btn btn-add btn-sm" ><i class="fa fa-pencil"></i></button>
</a>                                    
</p>


<?php /*?><p><a href="print-invoice.php?ordID=<?=$line_raw["ord_id"]?>" title="Generate invoice" target="_blank" ><strong style="font-size:12px;"><button type="button" class="btn  btn-sm btn-default" ><i class="fa fa-print fa-lg"></i></button></strong></a>                                         
</p><?php */?>





<?php /*?><p><a href="add-user.php?reg_id=<?=$line_raw["reg_id"]?>"><button type="button" class="btn btn-add btn-sm" ><i class="fa fa-pencil"></i></button>
</a> </p><?php */?>
<!--
<p><a href="manage-order.php?del_id=<?=$line_raw[invoice_order_id]?>">
    <button type="button" class="btn btn-danger btn-sm" ><i class="fa fa-trash"></i></button> 
</a> </p>                  
-->                       
                                       </td>
<td class="text-center v-middle">
 <input name="arr_ids[]" type="checkbox" id="arr_ids[]" value="<?=$invoice_order_id?>" />
</td>                                           
                                       
                                    </tr>
<?php
}
?>
                                    
<tr> <td colspan="6">

<button type="submit" name="Deactivate"  class="btn btn-danger pull-right mr5"  onClick="return select_chk()">Make Inactive</button>

<button type="submit" name="Activate" class="btn btn-success pull-right mr5"  onClick="return select_chk()">Make Active</button>






<!-- <select  class="form-control" name="changePayStatus" id="changePayStatus" onChange="change_pay_status(this.value)" style="width:180px;float:right;background-color:#063;color:#FFF;border:solid thin #06C;margin-right:5px"  >

<option value="0">Choose Pay Status</option>
<option value="Paid">Paid</option>
<option value="Unpaid">Unpaid</option>
</select> -->


<!--<button class="btn btn-default pull-right mr10" type="submit" name="Invoice"><i class="fa fa-print"></i>&nbsp;Generate Invoice</button>
-->


<!-- <button class="btn btn-danger pull-left" type="submit" name="Delete"><i class="fa fa-trash-o"></i>&nbsp;Delete</button>


 -->



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
function filterbyuser(uid){
window.location="manage-orders-invoices.php?uid="+uid; 
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


</script>