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
/*$sql="UPDATE tbl_invoice SET invoice_status='Unpaid' WHERE invoice_id='$catID' ";   
$res=db_query($sql); 
if($res>0){
}  
$_SESSION["msg"]="Selected invoice is unpaid successfully.";   */
}else{
$sql="UPDATE tbl_online_payment_record SET record_ref_no_match='Yes' WHERE record_id='$catID' ";  
$res=db_query($sql); 
if($res>0){

$cli_id=db_scalar("select record_client_id from tbl_online_payment_record where record_id='$catID' ");
$INV_id=db_scalar("select record_invoice_id from tbl_online_payment_record where record_id='$catID' ");

$cli_res=mysqli_fetch_array(db_query("select * from tbl_clients where client_id='$cli_id'"));
  
  db_query("update tbl_invoice set 
  invoice_client_name='$cli_res[client_name]',
  invoice_client_company_name='$cli_res[client_company_name]',
  invoice_client_mobile='$cli_res[client_mobile]',
  invoice_client_email='$cli_res[client_email]',
  invoice_client_gst_no='$cli_res[client_gst_no]',
  invoice_client_state_name='$cli_res[client_state_name]',
  invoice_client_state_code='$cli_res[client_state_code]',
  invoice_client_address='$cli_res[client_billing_address]',
  invoice_status='Paid'
  where invoice_id='$INV_id'   ");


$_SESSION["msg"]="Selected transaction is paid successfully.";  
}  
   
}

header("location:manual-transaction-record.php");
exit;
}



if(is_post_back()) {
   $count="";
   $arr_ids = $_REQUEST['arr_ids'];
$size_arr=sizeof($arr_ids);

   if(is_array($arr_ids)) {
      $str_ids = implode(',', $arr_ids); 
      if(isset($_REQUEST['Paid']) || isset($_REQUEST['Paid_x']) ) {
       
for($i=0; $i<$size_arr; $i++)
{
    
$CLI_ID=db_scalar("select record_client_id from tbl_online_payment_record where record_id='$arr_ids[$i]' ");
$INV_ID=db_scalar("select record_invoice_id from tbl_online_payment_record where record_id='$arr_ids[$i]' ");

$cli_res=mysqli_fetch_array(db_query("select * from tbl_clients where client_id='$CLI_ID'"));
  
  db_query("update tbl_invoice set 
  invoice_client_name='$cli_res[client_name]',
  invoice_client_company_name='$cli_res[client_company_name]',
  invoice_client_mobile='$cli_res[client_mobile]',
  invoice_client_email='$cli_res[client_email]',
  invoice_client_gst_no='$cli_res[client_gst_no]',
  invoice_client_state_name='$cli_res[client_state_name]',
  invoice_client_state_code='$cli_res[client_state_code]',
  invoice_client_address='$cli_res[client_billing_address]',
  invoice_status='Paid'
  where invoice_id='$INV_ID'
  ");
  
  
  
  
}
  db_query("update tbl_online_payment_record set record_ref_no_match='Yes' where record_id in ($str_ids)");
  
  


         $_SESSION["msg"]="selected transactions are paid. ";
      } /*else if(isset($_REQUEST['Unpaid']) || isset($_REQUEST['Unpaid_x']) ) {
         db_query("update tbl_invoice set invoice_status='Unpaid' where invoice_id in ($str_ids)");
                  $_SESSION["msg"]="selected invoices are deactivated. ";
      }else  if(isset($_REQUEST['Delete'])){
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

  $client_name_search_con=" and record_client_id in ($str_cl_ids)";
}


 // $search_con="and (invoice_no='$value' $client_name_search_con) ";
  
    $search_con=$client_name_search_con;
}

}

$filter_con="";
if($_REQUEST['list_filter']!="")
{
  $filter_con="and record_ref_no_match='$_REQUEST[list_filter]'";
}





$start = intval($start);
$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;

$order_by == '' ? $order_by = 'record_id' : true;
$order_by2 == '' ? $order_by2 = 'desc' : true;
 
$sql = "select * from   tbl_online_payment_record  where 1 $filter_con $search_con";
$sql = apply_filter($sql, $reg_name, 'like','record_id');
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
                  <i class="fa fa-exchange" aria-hidden="true"></i>

               </div>
               <div class="header-title">
                  <h1>Transaction</h1>
                  <small>Transaction List</small>
                  





            
 
                 
                 
<!--<a href="add-edit-order-invoice.php?id=0">
<button id="btn-go-back" type="button" class="btn btn-labeled btn-inverse m-b-5 pull-right">
<span class="btn-label"><i class="fa fa-plus" aria-hidden="true"></i>
</span>Add New Order/Invoice
</button></a>-->

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

<span class="count-num">Total : <?=db_scalar("SELECT COUNT(record_id) FROM  tbl_online_payment_record ")?></span>
                  


               </div>


           
               
            </section>
            <!-- Main content -->
            <section class="content">
               <div class="row">

                 <div class="col-lg-6 col-lg-offset-4">
                     <p>
                      <form action="" method="get">
                   <input type="text" placeholder="Name/Mobile/Email" value="<?=$_REQUEST['search_value']?>" name="search_value" class="form-control text-center" style="width:300px; float: left;" required/>
                  <input type="submit" value="Search" class="btn btn-primary" name="search_submit" />
                   <?php  if($_REQUEST['search_value']!=""){?>
                   <a href="manual-transaction-record.php">Clear</a>
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
<option value="" <?php if($_REQUEST['list_filter']==""){?> selected <?}?>>Show All</option>
<option value="Yes" <?php if($_REQUEST['list_filter']=="Yes"){?> selected <?}?>>Show Paid</option>
<option value="No" <?php if($_REQUEST['list_filter']=="No"){?> selected <?}?>>Show Unpaid</option>
</select>



<script type="text/javascript">
 function filter_fun(filter_value)
 {
  window.location.href="manual-transaction-record.php?list_filter="+filter_value;
 }


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
                                 <h4>Transaction List</h4>
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
                                       <th class="text-center">Screenshot/Trans. Ref. No.</th>        
                                       <th class="text-center">Invoice No./Client Info.</th>                                       
                                       <th class="text-center">Item/Amount/<br>Submit Date</th>                                       
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
   
$client_name="";
$client_company_name="";
$client_mobile="";
$client_email="";

$inv_sql=db_query("select * from tbl_invoice where invoice_id='$line_raw[record_invoice_id]' ");
$inv_res=mysqli_fetch_array($inv_sql);

if($inv_res['invoice_status']=="Paid")
{
$client_name="$inv_res[invoice_client_name]";
$client_company_name="$inv_res[invoice_client_company_name]";
$client_mobile="$inv_res[invoice_client_mobile]";
$client_email="$inv_res[invoice_client_email]";
}else{
$sql="SELECT * FROM tbl_clients WHERE client_id='$inv_res[invoice_client_id]'";
$dataReg=db_query($sql);
$recReg=mysqli_fetch_array($dataReg);

$client_name=$recReg['client_name'];
$client_company_name=$recReg['client_company_name'];
$client_mobile=$recReg['client_mobile'];
$client_email=$recReg['client_email'];

}


?>                                   
<tr>
<td class="text-center v-middle"><?=++$cnt?></td>
<td class="text-center v-middle">
    <a href="ccard/payment_screenshot/<?=$line_raw['record_screen_shot']?>" target="_blank">
    <img src="ccard/payment_screenshot/<?=$line_raw['record_screen_shot']?>" style="width:100px; height:100px;">
    </a>

    <p><b><?=$line_raw['record_ref_no']?>
   
    </b>
     <br>
   <?php if($line_raw['record_payment_method']=="BANK"){ ?>
    (By Bank)
    <?}else{?>
    (By QR Code/UPI/Wallet)
    
    <?}?>
    
    </p>
    </td>

<td class="text-left v-middle">
<a href="javascript:void(0);" onclick='window.open("view-invoice.php?invoice_id=<?=$line_raw["record_invoice_id"]?>", "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=50,left=25,width=1300,height=600");'> 

   <p class="text-danger bold">#<?=$inv_res["invoice_no"]?></p></a>
<p><?=$client_name?> <?php if($client_company_name!=""){?>(<span style='color:#8e09a2; font-weight: bold;'><?=$client_company_name?></span>)<?}?></p>
<p><?="<strong>Mobile : </strong>".$client_mobile?></p>
<p><?="<strong>Email : </strong>".$client_email?> 
<?php/* if($line_raw["invoice_status"]=="Unpaid"){?>
<a href="manage-invoice.php?send_mail_invoice_id=<?=$line_raw['invoice_id']?>" title="Send Reminder"><i class="fa fa-send"></i></a>
<?}*/?>
</p>

</td>
                                     
<td class="text-center v-middle">
<!-- <a href="Javascript:void(0)" onClick ="PopupWindowCenter('view-order-detail.php?user_id=<?=$recReg['reg_id']?>&ord_id=<?=$line_raw["ord_id"]?>', 'PopupWindowCenter',1000,400)"> -->

    <a href="javascript:void(0);" onclick='window.open("view-invoice.php?invoice_id=<?=$line_raw["record_invoice_id"]?>", "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=50,left=25,width=1300,height=600");'> 
<p class="bg-primary bold"><?="Items : ".db_scalar("SELECT COUNT(invoice_detail_id) FROM tbl_invoice_detail WHERE 1 AND invoice_detail_invoice_id='$inv_res[invoice_id]' ")?></p></a>

<p class="bg-success bold"><i class="fa fa-inr"></i> <?=$inv_res["invoice_grand_total"]?></p>
<p class="bg-yellow bold"><?=date("d M y",strtotime($line_raw["record_add_date"]))?></p>


</td>

<td class="text-center v-middle">

<p>

<?php if($inv_res['invoice_status']=="Paid"){?>

  <!-- manage-invoice.php?st=1&pid=<?=$line_raw["invoice_id"]?> -->
<a href="javascript:void(0)"><span class="label-custom label label-default">Paid</span></a>
<?php }else{?>
<a href="manual-transaction-record.php?st=0&pid=<?=$line_raw["record_id"]?>"><span class="label-danger label label-default">Unpaid</span></a>
<?php }?>
</p>


</td>

<td class="text-center v-middle">

<p>

   <a href="javascript:void(0);" onclick='window.open("view-invoice.php?invoice_id=<?=$line_raw["record_invoice_id"]?>", "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=50,left=25,width=1300,height=600");'> 

   <strong style="font-size:12px;"><button type="button" class="btn btn-view btn-sm" ><i class="fa fa-search"></i></button></strong></a>        
<?php/* if($line_raw["invoice_status"]=="Unpaid"){?>
   <a href="edit-invoice.php?id=<?=$line_raw["invoice_id"]?>"><button type="button" class="btn btn-add btn-sm" ><i class="fa fa-pencil"></i></button>
</a>  
<?}*/?>

<!-- <a href="javascript:void(0);" onclick='window.open("view-invoice.php?invoice_id=<?=$line_raw["record_invoice_id"]?>&print=Yes", "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=50,left=25,width=1300,height=600");'> 
   <strong style="font-size:12px;"><button type="button" class="btn btn-view btn-sm" ><i class="fa fa-print" style="color:black; font-size: 15px;"></i></button></strong></a>  
-->

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
 <input name="arr_ids[]" type="checkbox" id="arr_ids[]" value="<?=$record_id?>" />
</td>                                           
                                       
                                    </tr>
<?php
}
?>
                                    
<tr> <td colspan="7">

<!-- <button type="submit" name="Unpaid"  class="btn btn-danger pull-right mr5"  onClick="return select_chk()">Make Unpaid</button>
 -->
<button type="submit" name="Paid" class="btn btn-success pull-right mr5"  onClick="return select_chk()">Make Paid</button>






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