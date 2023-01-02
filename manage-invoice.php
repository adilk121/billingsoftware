<?php require_once("header.php");?>
<?php require_once("left-nav.php");?>
<style>
.v-middle {
vertical-align:middle !important;
}
</style>
<?php

/////////////////////////// SENDING MAIL START //////////////////////////////////////


if($_REQUEST['send_mail_invoice_id']!="")
{
    
$inv_id_for_mail=$_REQUEST['send_mail_invoice_id'];

$inv_sql_mail=db_query("select invoice_billing_company_id,invoice_client_id,invoice_grand_total,invoice_recipient_note,invoice_due_date,invoice_status,invoice_no,invoice_id from tbl_invoice where invoice_id='$inv_id_for_mail'");
$inv_data_mail=mysqli_fetch_array($inv_sql_mail);
@extract($inv_data_mail);
    
   
 //////////// Billing company section start ////////////////   
 
 
$title_invoice="";
$a="";
if($invoice_status=="Paid")
{
$title_invoice="Invoice";
$a="an";    
}
else{
$title_invoice="Proforma Invoice";
$a="a";  
}

$inv_title_lower=strtolower($title_invoice);

$billing_comp_sql_mail=db_query("select billing_company_email,billing_company_name,billing_company_website,billing_company_phone_no from tbl_billing_company where billing_company_id='$invoice_billing_company_id'");
$billing_comp_res_mail=mysqli_fetch_array($billing_comp_sql_mail);


$client_sql_mail=db_query("select client_company_name,client_name,client_email from tbl_clients where client_id='$invoice_client_id'");
$client_res_mail=mysqli_fetch_array($client_sql_mail);
$client_comp_name="";
if($client_res_mail['client_company_name']!="")
{$client_comp_name=" (".$client_res_mail['client_company_name'].")";}


$mailtextComp='
<html>
<head>
<title>'.$title_invoice.'</title>
</head>

<body>
<div style="font-family:arial;">
<center>

<div style=" width:70%; height: auto; background-color: #00509a; background-image: linear-gradient(to right, #00509a, #017eb8, #00509a); padding:30px;">

    <div style="background-color:white; border-radius:16px; height:auto; padding:20px; width:80%;">  
<h3>'.$title_invoice.' Sent</h3>

<p style="font-size:16px; color:#777777;">We have sent your '.$inv_title_lower.' to '.$client_res_mail["client_name"].''.$client_comp_name.' of Rs.'.$invoice_grand_total.'.</p>
<br>
<p><a href="'.$compDATA["admin_website_url"].'/view-mail-invoice.php?invoice_id='.$inv_id_for_mail.'" style="text-decoration:none; padding:15px; background-color:#0070ba; color:white; border-radius:30px;">View customer invoice</a></p>
<br>
<hr>';



if($invoice_recipient_note!="")
{
$mailtextComp.='
<p style="font-size:17px; color:#009cde;">Note to</p>
<p style="font-size:17px;">'.$invoice_recipient_note.'</p>';
}

$mailtextComp.='
</div>
</div>


</center>
</div>
</body>
</html>';

////////////////// Billing company section end ////////////////////


 //////////// Mail to Client section start ////////////////   
 
 function get_domain($url){
  $charge = explode('/', $url);
  $charge = $charge[2]; 
  return $charge;
}

 $billing_comp_website=get_domain($billing_comp_res_mail["billing_company_website"]);
 
$mailtextClient='
<html>
<head>
<title>'.$title_invoice.'</title>
</head>

<body>
<div style="font-family:arial;">
<center>
<div style="width:75%;">
<p style="color:#777777; padding:40px; background-color:#f5f5f5; font-size:13px;">
Dear '.$client_res_mail["client_name"].''.$client_comp_name.',
</p>
</div>

<div style=" width:70%; height: auto; background-color: #00509a; background-image: linear-gradient(to right, #00509a, #017eb8, #00509a); padding:30px;">

    <div style="background-color:white; border-radius:16px; height:auto; padding:20px; width:80%;">  
<h3>You have received '.$a.' '.$inv_title_lower.'.</h3>

<br>
<p style="font-size:16px; color:#777777;">'.$billing_comp_res_mail["billing_company_name"].' sent you '.$a.' '.$inv_title_lower.' Rs.'.$invoice_grand_total.'.</p>
<br>
<p><a href="'.$compDATA["admin_website_url"].'/view-mail-invoice.php?invoice_id='.$inv_id_for_mail.'" style="text-decoration:none; padding:15px; background-color:#0070ba; color:white; border-radius:30px;">View and pay invoice</a></p>
';

if($invoice_status=="Unpaid")
{
$du_date=date("d M Y",strtotime($invoice_due_date));
$mailtextClient.='<p style="padding:20px; font-size:16px;"><a style="text-decoration:none; color:#15c;">Due date: '.$du_date.'</a></p>';
}else{
$mailtextClient.='<br>';

}

$mailtextClient.='<hr>';

if($invoice_recipient_note!="")
{
$mailtextClient.='
<p style="font-size:17px; color:#009cde;">Note to</p>
<p style="font-size:17px;">'.$invoice_recipient_note.'</p>';
}

$mailtextClient.='

</div>

</div>




<div style="width:75%; text-align:left; padding:10px;">
<p>
It is recommended that you have to pay your invoice amount before the due date, so that your services can run smoothly without any disturbance. 
</p>
<p>In case you have any queries, please visit us at '.$billing_comp_website.' or call us  on '.$billing_comp_res_mail["billing_company_phone_no"].'.</p>

<p>
Best Regards,
<br>
Billing Team
<br>
'.$billing_comp_res_mail["billing_company_name"].'
<br>
</p>
</div>

</center>


</div>
</body>
</html>';

////////////////// Mail to Client section end ////////////////////




//Send to billing company

//$toEmail = "rehantki@gmail.com";
$toEmail="$billing_comp_res_mail[billing_company_email]";
$subject = "We've sent your $inv_title_lower ($invoice_no) for Rs.$invoice_grand_total";
		        $from="$client_res_mail[client_email]";
				$Headers1 = "From: <$from>\n";
				$Headers1 .= "X-Mailer: PHP/". phpversion();
				$Headers1 .= "X-Priority: 3 \n";
				$Headers1 .= "MIME-version: 1.0\n";
				$Headers1 .= "Content-Type: text/html; charset=iso-8859-1\n"; 
				@mail("$toEmail", "$subject", "$mailtextComp","$Headers1","-fenquiry@tradekeyindia.com");
				//@mail("amitabh.tradekeyindia@gmail.com", "Subject", "Msg1","$Headers1","-fenquiry@tradekeyindia.com");
				 $toEmail."<br>";
				 




//Send to client

//$toEmail = "rehantki@gmail.com";
$toEmail="$client_res_mail[client_email]";
$subject = "$title_invoice From $billing_comp_res_mail[billing_company_name] ($invoice_no)";
		        $from="$billing_comp_res_mail[billing_company_email]";
				$Headers1 = "From: <$from>\n";
				$Headers1 .= "X-Mailer: PHP/". phpversion();
				$Headers1 .= "X-Priority: 3 \n";
				$Headers1 .= "MIME-version: 1.0\n";
				$Headers1 .= "Content-Type: text/html; charset=iso-8859-1\n"; 
				@mail("$toEmail", "$subject", "$mailtextClient","$Headers1","-fenquiry@tradekeyindia.com");
				//@mail("amitabh.tradekeyindia@gmail.com", "Subject", "Msg1","$Headers1","-fenquiry@tradekeyindia.com");
				 $toEmail."<br>";
				 
   $_SESSION["msg"]="Invoice Sent Successfully.";   
   header("Location: ".$_SERVER['HTTP_REFERER']);
   exit;		 
				 
}

/////////////////////////// SENDING MAIL END //////////////////////////////////////

if($st!=""){
$st=$_REQUEST['st'];
$catID=$_REQUEST['pid'];

if($st==1){
$sql="UPDATE tbl_invoice SET invoice_status='Unpaid' WHERE invoice_id='$catID' ";   
$res=db_query($sql); 
if($res>0){
}  
$_SESSION["msg"]="Selected invoice is unpaid successfully.";   
}else{
$sql="UPDATE tbl_invoice SET invoice_status='Paid' WHERE invoice_id='$catID' ";  
$res=db_query($sql); 
if($res>0){

$cli_id=db_scalar("select invoice_client_id from tbl_invoice where invoice_id='$catID' ");

$cli_res=mysqli_fetch_array(db_query("select * from tbl_clients where client_id='$cli_id'"));
  
  db_query("update tbl_invoice set 
  invoice_client_name='$cli_res[client_name]',
  invoice_client_company_name='$cli_res[client_company_name]',
  invoice_client_mobile='$cli_res[client_mobile]',
  invoice_client_email='$cli_res[client_email]',
  invoice_client_gst_no='$cli_res[client_gst_no]',
  invoice_client_state_name='$cli_res[client_state_name]',
  invoice_client_state_code='$cli_res[client_state_code]',
  invoice_client_address='$cli_res[client_billing_address]'
  where invoice_id='$catID'
  ");


$_SESSION["msg"]="Selected invoice is paid successfully.";  
}  
   
}

header("location:manage-invoice.php");
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
  $cli_id=db_scalar("select invoice_client_id from tbl_invoice where invoice_id='$arr_ids[$i]' ");

$cli_res=mysqli_fetch_array(db_query("select * from tbl_clients where client_id='$cli_id'"));
  
  db_query("update tbl_invoice set 
  invoice_client_name='$cli_res[client_name]',
  invoice_client_company_name='$cli_res[client_company_name]',
  invoice_client_mobile='$cli_res[client_mobile]',
  invoice_client_email='$cli_res[client_email]',
  invoice_client_gst_no='$cli_res[client_gst_no]',
  invoice_client_state_name='$cli_res[client_state_name]',
  invoice_client_state_code='$cli_res[client_state_code]',
  invoice_client_address='$cli_res[client_billing_address]'
  where invoice_id='$arr_ids[$i]'
  ");
}
  db_query("update tbl_invoice set invoice_status='Paid' where invoice_id in ($str_ids)");


         $_SESSION["msg"]="selected invoices are paid. ";
      } else if(isset($_REQUEST['Unpaid']) || isset($_REQUEST['Unpaid_x']) ) {
         db_query("update tbl_invoice set invoice_status='Unpaid' where invoice_id in ($str_ids)");
                  $_SESSION["msg"]="selected invoices are unpaid. ";
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

  $client_name_search_con=" OR invoice_client_id in ($str_cl_ids)";
}

  $search_con="and (invoice_no='$value' $client_name_search_con) ";
}

}

$filter_con="";
if($_REQUEST['list_filter']=="Paid")
{
  $filter_con="and invoice_status='Paid'";
}

if($_REQUEST['list_filter']=="Unpaid")
{
  $filter_con="and invoice_status='Unpaid'";
}




$start = intval($start);
$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;

$order_by == '' ? $order_by = 'invoice_id' : true;
$order_by2 == '' ? $order_by2 = 'desc' : true;
 
$sql = "select * from   tbl_invoice  where 1 $filter_con $search_con";
$sql = apply_filter($sql, $reg_name, 'like','invoice_id');
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
                  <i class="fa fa-files-o" aria-hidden="true"></i>

               </div>
               <div class="header-title">
                  <h1>Invoices</h1>
                  <small>Invoices List</small>
                  





            
 
                 
                 
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

<span class="count-num">Total : <?=db_scalar("SELECT COUNT(invoice_id) FROM  tbl_invoice ")?></span>
                  


               </div>


           
               
            </section>
            <!-- Main content -->
            <section class="content">
               <div class="row">

                 <div class="col-lg-6 col-lg-offset-4">
                     <p>
                      <form action="" method="get">
                   <input type="text" placeholder="Invoice No./Name/Mobile/Email" value="<?=$_REQUEST['search_value']?>" name="search_value" class="form-control text-center" style="width:300px; float: left;" required/>
                  <input type="submit" value="Search" class="btn btn-primary" name="search_submit" />
                   <?php  if($_REQUEST['search_value']!=""){?>
                   <a href="manage-invoice.php">Clear</a>
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
<option value="Paid" <?php if($_REQUEST['list_filter']=="Paid"){?> selected <?}?>>Show Paid</option>
<option value="Unpaid" <?php if($_REQUEST['list_filter']=="Unpaid"){?> selected <?}?>>Show Unpaid</option>
</select>



<script type="text/javascript">
 function filter_fun(filter_value)
 {
  window.location.href="manage-invoice.php?list_filter="+filter_value;
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
                                 <h4>Invoice List</h4>
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
                                       <th class="text-center">Invoice No./Client Info.</th>                                       
                                       <th class="text-center">Item/Amount<br>Date</th>                                       
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

if($line_raw['invoice_status']=="Paid")
{
$client_name="$line_raw[invoice_client_name]";
$client_company_name="$line_raw[invoice_client_company_name]";
$client_mobile="$line_raw[invoice_client_mobile]";
$client_email="$line_raw[invoice_client_email]";
}else{
$sql="SELECT * FROM tbl_clients WHERE client_id='$line_raw[invoice_client_id]'";
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

<td class="text-left v-middle">

<!-- <a href="Javascript:void(0)" onClick ="PopupWindowCenter('view-order-detail.php?user_id=<?=$recReg['reg_id']?>&ord_id=<?=$line_raw["ord_id"]?>', 'PopupWindowCenter',1000,400)"> -->

  <a href="javascript:void(0);" onclick='window.open("view-invoice.php?invoice_id=<?=$line_raw["invoice_id"]?>", "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=50,left=25,width=1300,height=600");'> 

   <p class="text-danger bold">#<?=$line_raw["invoice_no"]?></p></a>
<p><?=$client_name?> <?php if($client_company_name!=""){?>(<span style='color:#8e09a2; font-weight: bold;'><?=$client_company_name?></span>)<?}?></p>
<p><?="<strong>Mobile : </strong>".$client_mobile?></p>
<p><?="<strong>Email : </strong>".$client_email?> 
<?php if($line_raw["invoice_status"]=="Unpaid"){?>
<a href="manage-invoice.php?send_mail_invoice_id=<?=$line_raw['invoice_id']?>" title="Send Reminder"><i class="fa fa-send"></i></a>
<?}?>
</p>

</td>
                                     
<td class="text-center v-middle">
<!-- <a href="Javascript:void(0)" onClick ="PopupWindowCenter('view-order-detail.php?user_id=<?=$recReg['reg_id']?>&ord_id=<?=$line_raw["ord_id"]?>', 'PopupWindowCenter',1000,400)"> -->

    <a href="javascript:void(0);" onclick='window.open("view-invoice.php?invoice_id=<?=$line_raw["invoice_id"]?>", "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=50,left=25,width=1300,height=600");'> 
<p class="bg-primary bold"><?="Items : ".db_scalar("SELECT COUNT(invoice_detail_id) FROM tbl_invoice_detail WHERE 1 AND invoice_detail_invoice_id='$line_raw[invoice_id]' ")?></p></a>

<p class="bg-success bold"><i class="fa fa-inr"></i> <?=$line_raw["invoice_grand_total"]?></p>
<p class="bg-yellow bold"><?=date("d M y",strtotime($line_raw["invoice_date"]))?></p>


</td>

<td class="text-center v-middle">

<p>

<?php if($line_raw["invoice_status"]=="Paid"){?>

  <!-- manage-invoice.php?st=1&pid=<?=$line_raw["invoice_id"]?> -->
<a href="javascript:void(0)"><span class="label-custom label label-default">Paid</span></a>
<?php }else{?>
<a href="manage-invoice.php?st=0&pid=<?=$line_raw["invoice_id"]?>"><span class="label-danger label label-default">Unpaid</span></a>
<?php }?>
</p>


</td>

<td class="text-center v-middle">

<p>

   <a href="javascript:void(0);" onclick='window.open("view-invoice.php?invoice_id=<?=$line_raw["invoice_id"]?>", "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=50,left=25,width=1300,height=600");'> 

  <!--  <a href="view-order-detail.php?order_id=<?=$line_raw["invoice_order_id"]?>" target="_blank"> -->
   <strong style="font-size:12px;"><button type="button" class="btn btn-view btn-sm" ><i class="fa fa-search"></i></button></strong></a>        
<?php if($line_raw["invoice_status"]=="Unpaid"){?>
   <a href="edit-invoice.php?id=<?=$line_raw["invoice_id"]?>"><button type="button" class="btn btn-add btn-sm" ><i class="fa fa-pencil"></i></button>
</a>  
<?}?>

 <a href="javascript:void(0);" onclick='window.open("view-invoice.php?invoice_id=<?=$line_raw["invoice_id"]?>&print=Yes", "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=50,left=25,width=1300,height=600");'> 
   <strong style="font-size:12px;"><button type="button" class="btn btn-view btn-sm" ><i class="fa fa-print" style="color:black; font-size: 15px;"></i></button></strong></a>  


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
 <input name="arr_ids[]" type="checkbox" id="arr_ids[]" value="<?=$invoice_id?>" />
</td>                                           
                                       
                                    </tr>
<?php
}
?>
                                    
<tr> <td colspan="6">

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