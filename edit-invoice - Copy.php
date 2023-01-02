<?php require_once("header.php");?>
<?php require_once("left-nav.php");?>
<?php require_once ('includes/photoshop.php');?>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<?php
$inv_id=trim($_REQUEST['id']);


if(is_post_back()){


if($_REQUEST['id']!='0') {
//*************** UPDATE EXISTING CATEGORY START ************************//
if($gst_extra=="Yes")
{
  $net_amount=$invoice_order_after_discount_amount;
}else{
   $gst_extra='No';
   $net_amount=$invoice_order_after_discount_amount-$gst_extra_amount;
}

//// FETCH BILLING COMPANY DETAILS START //
$billing_comp_sql=db_query("select billing_company_address,billing_company_terms_and_conditions from tbl_billing_company where billing_company_id='$invoice_order_company_id'");
$billing_comp_res=mysqli_fetch_array($billing_comp_sql);
//// FETCH BILLING COMPANY DETAILS END //

db_query("update tbl_invoice set
invoice_billing_company_id='$invoice_order_company_id',
invoice_status='$invoice_order_status',
invoice_no='$invoice_order_invoice_no',
invoice_date='$invoice_order_invoice_date',
invoice_due_date='$invoice_order_due_date',
invoice_total_amount='$invoice_order_total_amount',
invoice_discount_amount='$invoice_order_discount_amount',
invoice_after_discount_amount='$invoice_order_after_discount_amount',
invoice_billing_company_gst_rate='$invoice_order_gst_rate',
invoice_gst_extra='$gst_extra',
invoice_tax_amount='$gst_extra_amount',
invoice_net_amount='$net_amount',
invoice_grand_total='$invoice_order_grand_total',
invoice_recipient_note='$invoice_order_recipient_note',
invoice_billing_company_address='$billing_comp_res[billing_company_address]',
invoice_billing_company_terms_and_conditions='$billing_comp_res[billing_company_terms_and_conditions]'
where invoice_id='$inv_id'");

db_query("delete from tbl_invoice_detail where invoice_detail_invoice_id='$inv_id'");
$product_rows_count=sizeof($service_product_name);
for($i=0; $i<$product_rows_count; $i++)
{
/*   echo "<br>".$service_product_name[$i];
   echo "<br>".$service_product_price[$i];
   echo "<br>".$service_product_description[$i];*/
  db_query("insert into tbl_invoice_detail set 
            invoice_detail_invoice_id='$inv_id',
            invoice_detail_package_name='$service_product_name[$i]',
            invoice_detail_package_price='$service_product_price[$i]',
            invoice_detail_package_description='$service_product_description[$i]',
            invoice_detail_add_date='$curr_date',
            invoice_detail_update_date='$curr_date'    ");

}



$_SESSION["msg"]="Invoice updated successfully !";
header("Location:edit-invoice.php?id=$_REQUEST[id]");
exit;
//*************** UPDATE EXISTING CATEGORY END ************************//
}else{

///////////////INSERT NEW ORDER START ////////////////////////////







if($gst_extra=="Yes")
{
  $net_amount=$invoice_order_after_discount_amount;
}else{
   $gst_extra='No';
   $net_amount=$invoice_order_after_discount_amount-$gst_extra_amount;
}



db_query("insert into tbl_invoice_order set
invoice_order_company_id='$invoice_order_company_id',
invoice_order_client_id='$invoice_order_client_id',
invoice_order_invoice_frequency='$invoice_order_invoice_frequency',
invoice_order_invoice_total_amount='$invoice_order_total_amount',
invoice_order_invoice_discount_amount='$invoice_order_discount_amount',
invoice_order_invoice_after_discount_amount='$invoice_order_after_discount_amount',
invoice_order_gst_number='$invoice_order_gst_number',
invoice_order_gst_rate='$invoice_order_gst_rate',
invoice_order_is_invoice_gst_extra='$gst_extra',
invoice_order_invoice_tax_amount='$gst_extra_amount',
invoice_order_invoice_net_amount='$net_amount',
invoice_order_invoice_grand_total='$invoice_order_grand_total',
invoice_order_invoice_recipient_note='$invoice_order_recipient_note',
invoice_order_status='$order_status',
invoice_order_add_date='$curr_date'");

$order_id=db_scalar("select max(invoice_order_id) from tbl_invoice_order");
$product_rows_count=sizeof($service_product_name);
for($i=0; $i<$product_rows_count; $i++)
{
/*   echo "<br>".$service_product_name[$i];
   echo "<br>".$service_product_price[$i];
   echo "<br>".$service_product_description[$i];*/

   db_query("insert into tbl_invoice_order_detail set 
            invoice_order_detail_order_id='$order_id',
            invoice_order_detail_package_name='$service_product_name[$i]',
            invoice_order_detail_package_price='$service_product_price[$i]',
            invoice_order_detail_package_description='$service_product_description[$i]',
            invoice_order_detail_add_date='$curr_date'    ");

}

$client_data="";

if($invoice_order_status=="Paid")
{
//// FETCH CLIENT DETAILS START //
$client_sql=db_query("select * from tbl_clients where client_id='$invoice_order_client_id'");
$client_res=mysqli_fetch_array($client_sql);
//// FETCH CLIENT DETAILS END //
$client_data=",invoice_client_name='$client_res[client_name]',
invoice_client_company_name='$client_res[client_company_name]',
invoice_client_mobile='$client_res[client_mobile]',
invoice_client_email='$client_res[client_email]',
invoice_client_gst_no='$client_res[client_gst_no]',
invoice_client_state_name='$client_res[client_state_name]',
invoice_client_state_code='$client_res[client_state_code]',
invoice_client_address='$client_res[client_billing_address]'";

}

//// FETCH BILLING COMPANY DETAILS START //
$billing_comp_sql=db_query("select * from tbl_billing_company where billing_company_id='$invoice_order_company_id'");
$billing_comp_res=mysqli_fetch_array($billing_comp_sql);
//// FETCH BILLING COMPANY DETAILS END //

db_query("insert into tbl_invoice set
order_id='$order_id',
invoice_no='$invoice_order_invoice_no',
invoice_date='$invoice_order_invoice_date',
invoice_due_date='$invoice_order_due_date',
invoice_status='$invoice_order_status',
invoice_total_amount='$invoice_order_total_amount',
invoice_discount_amount='$invoice_order_discount_amount',
invoice_after_discount_amount='$invoice_order_after_discount_amount',
invoice_gst_extra='$gst_extra',
invoice_tax_amount='$gst_extra_amount',
invoice_net_amount='$net_amount',
invoice_grand_total='$invoice_order_grand_total',
invoice_recipient_note='$invoice_order_recipient_note',
invoice_billing_company_id='$invoice_order_company_id',
invoice_billing_company_gst_rate='$invoice_order_gst_rate',
invoice_billing_company_address='$billing_comp_res[billing_company_address]',
invoice_billing_company_terms_and_conditions='$billing_comp_res[billing_company_terms_and_conditions]',
invoice_client_id='$invoice_order_client_id'
$client_data ");
$invoice_id=db_scalar("select max(invoice_id) from tbl_invoice");

$product_rows_count_for_invoice=sizeof($service_product_name);
for($j=0; $j<$product_rows_count_for_invoice; $j++)
{
/*   echo "<br>".$service_product_name[$i];
   echo "<br>".$service_product_price[$i];
   echo "<br>".$service_product_description[$i];*/

   db_query("insert into tbl_invoice_detail set 
            invoice_detail_invoice_id='$invoice_id',
            invoice_detail_package_name='$service_product_name[$j]',
            invoice_detail_package_price='$service_product_price[$j]',
            invoice_detail_package_description='$service_product_description[$j]',
            invoice_detail_add_date='$curr_date'    ");

}

$_SESSION["msg"]="Order added successfully !";
header("Location:add-edit-order-invoice.php?id=$_REQUEST[id]&client_ID=$_REQUEST[client_ID]");
exit;

/////////////// INSERT NEW ORDER END ////////////////////////////
 }
}

if($inv_id!='') {
$result = db_query("select * from tbl_invoice where invoice_id = '$inv_id'");
if ($line_raw = mysqli_fetch_array($result)) {
@extract($line_raw);
}


$order_sql=db_query("select * from tbl_invoice_order where invoice_order_id='$line_raw[order_id]'");
if ($order_res = mysqli_fetch_array($order_sql)) {
@extract($order_res);
}

}
?>



         <!-- Content Wrapper. Contains page content -->
         <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
               <div class="header-icon">
                  <i class="fa fa-cart-plus" aria-hidden="true"></i>

               </div>
               <div class="header-title">
                  <h1>Edit Invoice</h1>
                  <small>Edit Invoice Content</small>
                  

<a href="manage-invoice.php"><button id="btn-go-back" type="button" class="btn btn-labeled btn-inverse m-b-5 pull-right">
<span class="btn-label" ><i class="fa fa-chevron-circle-left"></i></span>Go Back
</button></a>

                  
               </div>
               
               
            </section>
            <!-- Main content -->
<script src="ckeditor/ckeditor.js"></script>            
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
                                 <h4>Invoice Information</h4>
                              </a>
                           </div>
                        </div>
                        <div class="panel-body">
<form name="form1" id="form1" method="post" onsubmit="return formValidation()" enctype="multipart/form-data" class="col-sm-12" >
                              


<div class="clearfix"></div>



<div class="form-group col-lg-6">
<label>Billing Company *</label>
<select name="invoice_order_company_id" id="invoice_order_company_id" class="form-control" onchange="getInvoiceNoByCompany(this.value)" required>
  <option value="">--- Choose Billing Company ---</option>
<?php
$comp_sql=db_query("select billing_company_id,billing_company_name from tbl_billing_company where billing_company_status='Active' and billing_company_deleted='No' order by billing_company_name asc");
while($comp_res=mysqli_fetch_array($comp_sql))
{?>
  <option value="<?=$comp_res['billing_company_id']?>" <?php  if($comp_res['billing_company_id']==$invoice_billing_company_id){echo "selected";} ?> ><?=$comp_res['billing_company_name']?></option>
 <?}?>
  </select>
</div>




<div class="form-group col-lg-6">
<label>Bill To *</label>


<select <?php if($inv_id!=0){ echo "disabled"; } ?> name="invoice_order_client_id" id="invoice_order_client_id" class="form-control" required>
  <option value="">--- Choose Client ---</option>
<?php
$client_sql=db_query("select client_id,client_name,client_company_name from tbl_clients where client_status='Active' and client_deleted='No' order by client_company_name asc");
while($client_res=mysqli_fetch_array($client_sql))
{?>
  <option value="<?=$client_res['client_id']?>" <?php  if($client_res['client_id']==$invoice_client_id){echo "selected";} ?> ><?=$client_res['client_name']?> (<?=$client_res['client_company_name']?>)</option>
 <?}?>
  </select>


</div>


<div class="form-group col-lg-3">
<label>Invoice No. *</label>

<input type="text" class="form-control" placeholder="Enter Invoice No." name="invoice_order_invoice_no" id="invoice_order_invoice_no" readonly value="<?=$invoice_no?>"   >
</div>



<div class="form-group col-lg-3">
<label>Invoice Creating Frequency *</label>
<select name="invoice_order_invoice_frequency" id="invoice_order_invoice_frequency" class="form-control" required="" <?php if($inv_id!=0){ echo "disabled"; } ?>>
  <option value="">--- Choose Frequency ---</option>
  <option value="Once Only" <?php  if($order_res['invoice_order_invoice_frequency']=="Once Only"){echo "selected";} ?> >Once Only</option>
  <option value="Monthly" <?php  if($order_res['invoice_order_invoice_frequency']=="Monthly"){echo "selected";} ?>>Monthly</option>
  <option value="Quarterly" <?php  if($order_res['invoice_order_invoice_frequency']=="Quarterly"){echo "selected";} ?>>Quarterly (3 Months)</option>
  <option value="Half Yearly" <?php  if($order_res['invoice_order_invoice_frequency']=="Half Yearly"){echo "selected";} ?>>Half Yearly</option>
  <option value="Yearly" <?php  if($order_res['invoice_order_invoice_frequency']=="Yearly"){echo "selected";} ?>>Yearly</option>
  <option value="Two Yearly" <?php  if($order_res['invoice_order_invoice_frequency']=="Two Yearly"){echo "selected";} ?>>Two Yearly</option>
  <option value="Three Yearly" <?php  if($order_res['invoice_order_invoice_frequency']=="Three Yearly"){echo "selected";} ?>>Three Yearly</option>
  <option value="Four Yearly" <?php  if($order_res['invoice_order_invoice_frequency']=="Four Yearly"){echo "selected";} ?>>Four Yearly</option>
  <option value="Five Yearly" <?php  if($order_res['invoice_order_invoice_frequency']=="Five Yearly"){echo "selected";} ?>>Five Yearly</option>
 </select>
</div>

<div class="form-group col-lg-6">
<label>Invoice Status *</label>
<select name="invoice_order_status" id="invoice_order_status" class="form-control" required="" >
  <option value="">--- Choose Status ---</option>
  <option value="Paid" <?php  if($invoice_status=="Paid"){echo "selected";} ?> >Paid</option>
  <option value="Unpaid" <?php  if($invoice_status=="Unpaid"){echo "selected";} ?>>Unpaid</option>
 </select>
</div>





<div class="form-group col-lg-6">
<label>Invoice Date *</label>
<input type="date" class="form-control" placeholder="Enter Invoice No." name="invoice_order_invoice_date" id="invoice_order_invoice_date"  value="<?=$invoice_date?>" required="" onchange="setDueDate(this.value)">
</div>
<div class="form-group col-lg-6">
<label>Due Date *</label>
<input type="date" class="form-control" placeholder="Enter Invoice No." name="invoice_order_due_date" id="invoice_order_due_date"  value="<?=$invoice_due_date?>" required="">
</div>

<div class="form-group col-lg-12 ">
<?php

$pro_res=mysqli_fetch_array(db_query("select * from tbl_invoice_detail where invoice_detail_invoice_id='$invoice_id' limit 0,1 "));
?>

<table class="table borderless" id="dynamic_field">
<tr>
  <td width="25%">
    <input type="text" name="service_product_name[]"  id="service_product_name[1]" onchange="getPackageDetailsByName(this)" placeholder="Enter Product/Service Name *" class="form-control auto_sugg" onkeyup="auto_sugg_fun()" required="" value="<?=$pro_res['invoice_detail_package_name']?>">
  </td>

   <td width="15%">
    <input type="number" name="service_product_price[]" id="service_product_price[1]" placeholder="Enter Price *" class="form-control" onkeyup="cal_total_amount()" required="" value="<?=$pro_res['invoice_detail_package_price']?>">
  </td>

   <td width="55%">
    <input type="text" name="service_product_description[]" id="service_product_description[1]" placeholder="Enter Description *" class="form-control" required="" value="<?=$pro_res['invoice_detail_package_description']?>">
  </td>
  <td width="5">
    <button type="button" name="add" id="add" class="btn btn-success"><i class="fa fa-plus"></i></button>
  </td>
</tr>  

</table>
 

</div>


<div class="row">
<div class="form-group col-lg-3">
<label>Total Amount</label>
<input type="text" class="form-control" readonly  name="invoice_order_total_amount" id="invoice_order_total_amount" value="<?=$invoice_total_amount?>">
</div>
</div>

<div class="row">
<div class="form-group col-lg-3">
<label>Discount Amount</label>
<input type="number" class="form-control" placeholder="Enter Discount Amount" name="invoice_order_discount_amount" id="invoice_order_discount_amount"  value="<?=$invoice_discount_amount?>" onkeyup="minus_discount_amount()">
<span style="font-style: italic; font-weight: bold;" class="after_discount_amount">After discount <i class='fa fa-inr'></i> <?=$invoice_order_invoice_after_discount_amount?></span>
<input type="hidden" name="invoice_order_after_discount_amount" id="invoice_order_after_discount_amount" value="<?=$invoice_after_discount_amount?>">
</div>
</div>



<div class="row show_gst_section" style="display:none;">
<div class="form-group col-lg-3">
<label>Add GST Extra <span id="show_gst_rate"></span> </label>
<input type="hidden" name="invoice_order_gst_rate" id="invoice_order_gst_rate" value="<?=$invoice_billing_company_gst_rate?>">
<input type="hidden" name="invoice_order_gst_number" id="invoice_order_gst_number" value="<?=$order_res['invoice_order_gst_number']?>">

<input type="checkbox" id="gst_extra" name="gst_extra" value="Yes" onclick="set_gst_amount();" <?php if($invoice_gst_extra=="Yes"){?>checked <?}?> > 
<i class="fa fa-question-circle" style="cursor: pointer; color:red;" data-toggle="tooltip" title="By default GST amount included in grand total, if you click on checkbox then GST amount will be added separately."></i>

<input type="number" placeholder="GST Amount" class="form-control" name="gst_extra_amount" id="gst_extra_amount" value="<?=$invoice_tax_amount?>"  readonly="">


</div>
</div>

<div class="row">
<div class="form-group col-lg-3">
<label>Grand Total</label>
<input type="text" class="form-control" name="invoice_order_grand_total" id="invoice_order_grand_total" value="<?=$invoice_grand_total?>" readonly="">
</div>
</div>
 




<div class="row">
<div class="form-group col-lg-12">
<label>Note to recipient for mail</label>
<input type="text" class="form-control" placeholder="Enter Note" name="invoice_order_recipient_note" id="invoice_order_recipient_note"  value="<?=$invoice_recipient_note?>">
</div>
</div>



<!-- <div class="row">

  <div class="form-group col-lg-6">
     <select name="order_status" id="order_status" class="form-control">
       <option value="Active" <?php  if($invoice_order_status=="Active"){echo "selected";} ?> >Active</option>
       <option value="Inactive" <?php  if($invoice_order_status=="Inactive"){echo "selected";} ?> >Inactive</option>

     </select>
     
      </div>

      <div class="form-group col-lg-6">
        <p>
<input type="checkbox"  value="Yes" name="want_to_sent_mail_now" id="want_to_sent_mail_now"> Want to send mail now? 
      </p>
      </div>  

            
      </div>   -->                 
                             
                            
                           
                              <div class="col-lg-10 reset-button">
                                                                 
                                 <button type="submit" class="btn btn-add">Submit</button>
                                
                              </div>


                             <div class="col-lg-2 reset-button">
                                     <?php if($inv_id==0){?>                        
                                 <button type="button" class="btn btn-primary" onclick="openPreview();">Preview</button>
                                <?} ?>     
                              </div> 
                             
                           </form>
                        </div>
                     </div>
                  </div>
               </div>
            </section>
            <!-- /.content -->
         </div>


<script>

 $(document).ready(function(){
<?php ////////////// Edit condition start ///////////////
if($inv_id!=0)
{?>
getInvoiceNoByCompany(<?=$invoice_billing_company_id?>);
minus_discount_amount();
<?}
////////////// Edit condition end ///////////////
?>
});

function setDueDate(invoice_date)
{

  
 var status=$("#invoice_order_status").val();
 if(status=="Paid")
 {
   $("#invoice_order_due_date").val(invoice_date);
 }else{
  $("#invoice_order_due_date").val("");
 }
 
}

<?/*
function setDueDateDisabled(invoice_status)
{
if(invoice_status=="Paid")
{
$("#invoice_order_due_date").val("");
$("#invoice_order_due_date").attr("disabled", true);
}else{
  $("#invoice_order_due_date").attr("disabled", false);
}

}

<?php ////////////// Edit condition start ///////////////
if($inv_id!=0)
{?>
getInvoiceNoByCompany(<?=$invoice_order_company_id?>);
setDueDateDisabled("<?=$invoice_status?>");

<?}
////////////// Edit condition end ///////////////
*/?>
  function getInvoiceNoByCompany(company_id)
  {


 
    if(company_id!="")
    {
$.ajax({

url:"get-company-invoice-start.php",
type:"POST",
data:{company_id:company_id},
success:function(data)
{
var fetch_invoice_data=JSON.parse(data);
if(fetch_invoice_data!="")
{

if(fetch_invoice_data[1]=="From Order"){
  split_string = fetch_invoice_data[0].split(/(\d+)/);
  split_string[1]=parseInt(split_string[1])+1;

////////////// Edit condition start ///////////////
var invo_id="<?=$inv_id?>";
var invo_old_company_id="<?=$invoice_billing_company_id?>";

if(invo_id!=0 && company_id==invo_old_company_id)
{
  split_string[1]=parseInt(split_string[1])-1;
}

<?php/* 
if($inv_id!=0)
{?>
split_string[1]=parseInt(split_string[1])-1;
<?}*/?>
////////////// Edit condition end ///////////////

  document.getElementById("invoice_order_invoice_no").value=split_string[0]+split_string[1];
}else{
  document.getElementById("invoice_order_invoice_no").value=fetch_invoice_data[0];

}


if(fetch_invoice_data[2]=="")
{
document.getElementById("gst_extra_amount").value="0";
document.getElementById("invoice_order_gst_rate").value="";
document.getElementById("invoice_order_gst_number").value="";
document.getElementById("gst_extra").value="No";

var minus_amount=$("#invoice_order_discount_amount").val(); 
var total_amount=$("#invoice_order_total_amount").val(); 
$("#invoice_order_grand_total").val(total_amount-minus_amount);
var am=total_amount-minus_amount;
if(minus_amount!="")
{
  $(".after_discount_amount").html("After discount <i class='fa fa-inr'></i> "+am+"");
  $("#invoice_order_after_discount_amount").val(am);

}else{
  $(".after_discount_amount").html("");
   $("#invoice_order_after_discount_amount").val(total_amount);
}
$(".show_gst_section").hide();
}else{
$(".show_gst_section").show();
document.getElementById("show_gst_rate").innerHTML="("+fetch_invoice_data[3]+"%)";
document.getElementById("invoice_order_gst_rate").value=fetch_invoice_data[3];
document.getElementById("invoice_order_gst_number").value=fetch_invoice_data[2];
minus_discount_amount();
}





}

}
});
 }else{
   document.getElementById("invoice_order_invoice_no").value="";
 }

  }

</script>



<script>
var price_row_count=1;

  $(document).ready(function(){
var i=1;

<?php 

if($inv_id!=0){ 
$pro_sql_dynmic=db_query("select * from tbl_invoice_detail where invoice_detail_invoice_id='$inv_id' limit 1,18446744073709551615  ");
if(mysqli_num_rows($pro_sql_dynmic)>0)
{
  $j=2;
while($pro_res_dynmic=mysqli_fetch_array($pro_sql_dynmic))
{
?>

  $('#dynamic_field').append('<tr id="row<?=$j?>">  <td width="25%">    <input type="text" name="service_product_name[]"  id="service_product_name[<?=$j?>]" onchange="getPackageDetailsByName(this)" placeholder="Enter Product/Service Name *" class="form-control auto_sugg" onkeyup="auto_sugg_fun()" required="" value="<?=$pro_res_dynmic['invoice_detail_package_name']?>">  </td>   <td width="15%">    <input type="number" name="service_product_price[]" id="service_product_price[<?=$j?>]" placeholder="Enter Price *" class="form-control" onkeyup="cal_total_amount()" required="" value="<?=$pro_res_dynmic['invoice_detail_package_price']?>">  </td>   <td width="55%">    <input type="text" name="service_product_description[]" id="service_product_description[<?=$j?>]" placeholder="Enter Description *" class="form-control" required="" value="<?=$pro_res_dynmic['invoice_detail_package_description']?>">  </td>  <td width="5%">    <button type="button" name="remove" id="<?=$j?>" class="btn btn-danger btn_remove"><i class="fa fa-minus"></i></button>  </td></tr>  ');
<?php  
$j++;
}?>
i=<?=$j--?>;
price_row_count=i;
<? }} ?>


$('#add').click(function(){
i++;
$('#dynamic_field').append('<tr id="row'+i+'">  <td width="25%">    <input type="text" name="service_product_name[]"  id="service_product_name['+i+']" onchange="getPackageDetailsByName(this)" placeholder="Enter Product/Service Name *" class="form-control auto_sugg" onkeyup="auto_sugg_fun()" required="">  </td>   <td width="15%">    <input type="number" name="service_product_price[]" id="service_product_price['+i+']" placeholder="Enter Price *" class="form-control" onkeyup="cal_total_amount()" required="">  </td>   <td width="55%">    <input type="text" name="service_product_description[]" id="service_product_description['+i+']" placeholder="Enter Description *" class="form-control" required="">  </td>  <td width="5%">    <button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove"><i class="fa fa-minus"></i></button>  </td></tr>  ');



price_row_count=i;

});

$(document).on('click','.btn_remove', function(){
var button_id=$(this).attr("id");
$("#row"+button_id+"").remove();

cal_total_amount();
set_gst_amount();
minus_discount_amount();

});


});


   function cal_total_amount()
    {
var total_price=0;
var idarray_price = $("#dynamic_field")
             .find("input") //Find the spans
             .map(function() { return this.id; }) //Project Ids
             .get(); //ToArray


idarray_price.forEach(myFunction_price);
function myFunction_price(item, index) {
for(var j=0; j<=price_row_count; j++)
{
  if(item=="service_product_price["+j+"]")
  {
    if(document.getElementById("service_product_price["+j+"]").value!="")
    {
       total_price=total_price+parseInt(document.getElementById("service_product_price["+j+"]").value);
    }
  }
  document.getElementById("invoice_order_total_amount").value=total_price;
}


}
setGrandTotal();
set_gst_amount();
minus_discount_amount();

}
  </script>





      <script>
function auto_sugg_fun() {
 $(".auto_sugg").autocomplete({
        source: "get-invoice-product-name-autocomplete.php",
    });
}
</script>


<script type="text/javascript">
  function getPackageDetailsByName(name_id) {
var nameID = $(name_id).attr("id");
var nameID_number =nameID.replace(/[^0-9]/g,'')

var name_value=document.getElementById(nameID).value;

$.ajax({
type: "POST",
url: "get-product-service-details-ajax.php",
data: {name_value:name_value},
cache: false,
success: function(result){
var fetch_data=JSON.parse(result);
document.getElementById("service_product_price["+nameID_number+"]").value=fetch_data.invoice_product_price;
document.getElementById("service_product_description["+nameID_number+"]").value=fetch_data.invoice_product_description;
cal_total_amount();
setGrandTotal();
set_gst_amount();
minus_discount_amount();
}
});

}
</script>

<script>
  function setGrandTotal()
  {
var total_amount=$("#invoice_order_total_amount").val();    
$("#invoice_order_grand_total").val(total_amount);
  }

function minus_discount_amount()
{

var minus_amount=$("#invoice_order_discount_amount").val(); 
var total_amount=$("#invoice_order_total_amount").val(); 
$("#invoice_order_grand_total").val(total_amount-minus_amount);
var am=total_amount-minus_amount;
if(minus_amount!="")
{
  $(".after_discount_amount").html("After discount <i class='fa fa-inr'></i> "+am+"");
  $("#invoice_order_after_discount_amount").val(am);

}else{
  $(".after_discount_amount").html("");
   $("#invoice_order_after_discount_amount").val(total_amount);
}
set_gst_amount();
}


function set_gst_amount()
{
var show=document.getElementById('gst_extra');
var total_amnt=document.getElementById("invoice_order_total_amount").value;
var discount_amnt=document.getElementById("invoice_order_discount_amount").value;
var gst_rate=document.getElementById("invoice_order_gst_rate").value;
var amount=total_amnt-discount_amnt;

var gst_amount=(amount * gst_rate / 100) ;


    if(show.checked)
    {
var grand_total=gst_amount+amount;

/*alert(total_amnt);
alert(discount_amnt);
alert(amount);
alert(gst_amount);
alert(grand_total);*/
$("#gst_extra_amount").val(gst_amount.toFixed(2));
$("#invoice_order_grand_total").val(grand_total.toFixed(2));

    }
    else
    {

var amountt=amount;
var gst_rate=parseInt(document.getElementById("invoice_order_gst_rate").value);

var gst_am=(amountt * (100 / (100 + gst_rate ) ) );
gst_am=amountt-gst_am;
var net=amountt-gst_am;


$("#gst_extra_amount").val(gst_am.toFixed(2));
$("#invoice_order_grand_total").val(amountt.toFixed(2));
         
    }
}
</script>

<script>

function openPreview(){


  var f=document.getElementById('form1');
  if(f.checkValidity())
  {

 $('form').attr('action', 'order-invoice-preview.php'); 
 $("form").attr('target', '_blank');
 document.getElementById('form1').submit();

 $("form").removeAttr("target");
 $('form').attr('action', ''); 
  }else{
    alert("Please fill all required(*) fields!");
  }





}  

</script>


<?php require_once("footer.php"); ?>
 