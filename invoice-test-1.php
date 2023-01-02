<?php
ob_start();
require_once("includes/dbsmain.inc.php");
include("site-main-query.php");

$curr_date=date("Y-m-d");


function remove_http($url) {
   $disallowed = array('http://', 'https://');
   foreach($disallowed as $d) {
      if(strpos($url, $d) === 0) {
         return str_replace($d, '', $url);
      }
   }
   return $url;
}

function convert_number($number) 
{ 
    if (($number < 0) || ($number > 999999999)) 
    { 
    throw new Exception("Number is out of range");
    } 

    $Gn = floor($number / 1000000);  /* Millions (giga) */ 
    $number -= $Gn * 1000000; 
    $kn = floor($number / 1000);     /* Thousands (kilo) */ 
    $number -= $kn * 1000; 
    $Hn = floor($number / 100);      /* Hundreds (hecto) */ 
    $number -= $Hn * 100; 
    $Dn = floor($number / 10);       /* Tens (deca) */ 
    $n = $number % 10;               /* Ones */ 

    $res = ""; 

    if ($Gn) 
    { 
        $res .= convert_number($Gn) . " Million"; 
    } 

    if ($kn) 
    { 
        $res .= (empty($res) ? "" : " ") . 
            convert_number($kn) . " Thousand"; 
    } 

    if ($Hn) 
    { 
        $res .= (empty($res) ? "" : " ") . 
            convert_number($Hn) . " Hundred"; 
    } 

    $ones = array("", "One", "Two", "Three", "Four", "Five", "Six", 
        "Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen", 
        "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eightteen", 
        "Nineteen"); 
    $tens = array("", "", "Twenty", "Thirty", "Fourty", "Fifty", "Sixty", 
        "Seventy", "Eigthy", "Ninety"); 

    if ($Dn || $n) 
    { 
        if (!empty($res)) 
        { 
            $res .= " and "; 
        } 

        if ($Dn < 2) 
        { 
            $res .= $ones[$Dn * 10 + $n]; 
        } 
        else 
        { 
            $res .= $tens[$Dn]; 

            if ($n) 
            { 
                $res .= "-" . $ones[$n]; 
            } 
        } 
    } 

    if (empty($res)) 
    { 
        $res = "zero"; 
    } 

    return $res; 
} 
?>


<?php

$sql=db_query("select * from tbl_invoice where invoice_id='$_REQUEST[invoice_id]' ");
$res=mysqli_fetch_array($sql);
   @extract($res);

?>

<!DOCTYPE html>
<html lang="en">
<head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
           <link rel="icon" type="image/png" href="<?=$compDATA['admin_favicon']?>">
      <title>PROFORMA INVOICE</title>
      <!-- Favicon and touch icons -->
      <!--<link rel="shortcut icon" href="fevicon.png" type="image/x-icon">-->
      <!-- Start Global Mandatory Style
         =====================================================================-->
      <!-- jquery-ui css -->
      <link href="assets/plugins/jquery-ui-1.12.1/jquery-ui.min.css" rel="stylesheet" type="text/css"/>
      <!-- Bootstrap -->
      <link href="assets/bootstrap/css/bootstrapa.min.css" rel="stylesheet" type="text/css"/>
      <!-- Bootstrap rtl -->
      <!--<link href="assets/bootstrap-rtl/bootstrap-rtl.min.css" rel="stylesheet" type="text/css"/>-->
      <!-- Lobipanel css -->
      <link href="assets/plugins/lobipanel/lobipanel.min.css" rel="stylesheet" type="text/css"/>
      <!-- Pace css -->
      <link href="assets/plugins/pace/flash.css" rel="stylesheet" type="text/css"/>
      <!-- Font Awesome -->
      <link href="assets/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
      <!-- Pe-icon -->
      <link href="assets/pe-icon-7-stroke/css/pe-icon-7-stroke.css" rel="stylesheet" type="text/css"/>
      <!-- Themify icons -->
      <link href="assets/themify-icons/themify-icons.css" rel="stylesheet" type="text/css"/>
      <!-- End Global Mandatory Style
         =====================================================================-->
      <!-- Start page Label Plugins 
         =====================================================================-->
      <!-- Emojionearea -->
      <link href="assets/plugins/emojionearea/emojionearea.min.css" rel="stylesheet" type="text/css"/>
      <!-- Monthly css -->
      <link href="assets/plugins/monthly/monthly.css" rel="stylesheet" type="text/css"/>
      <!-- End page Label Plugins 
         =====================================================================-->
      <!-- Start Theme Layout Style
         =====================================================================-->
      <!-- Theme style -->
      <link href="assets/dist/css/stylecrm.css" rel="stylesheet" type="text/css"/>

      <link href="assets/dist/css/custom.css" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" type="text/css" href="css/css-for-order-invoice-preview.css">


<script>
$(document).ready(function(){

$('.page-header').animate({ scrollTop: $('.page-header').scrollTop() + $('#faq-result').offset().top - $('.page-header').offset().top }, { duration: 'slow', easing: 'swing'});
$('html,body').animate({ scrollTop: $('.page-header').offset().top - ($(window).height()/15) }, { duration: 1000, easing: 'swing'});

});
</script>
</head><style type="text/css">
@media print {
.printbtn {
  display : none;
}
.widthami{width:260px !important;}
}
</style>
<style type="text/css" media="print">
@page {
  size: auto;   /* auto is the initial value */
  margin: 0mm;  /* this affects the margin in the printer settings */
}
html {
  background-color: #FFFFFF;
  margin: 0px;  /* this affects the margin on the html before sending to printer */
}
body {
  margin: 1mm 1mm 1mm 1mm; /* margin you want for the content */
}
</style>
<body>
  
      

<div class="container">
  <div style="margin-top:10px; margin-bottom:35px;">
    <div class="row">
      <div class="col-md-12">
        <div class="text-center">
  

<h4>PROFORMA INVOICE</h4>

			   
			<button class="btn btn-success printbtn" onClick="window.print();"><i class="fa fa-print"></i> Print Invoice</button>
				<button class="btn btn-danger printbtn"><i class="fa fa-envelope-o"></i> Pay Online</button>
			
		
				
        </div>
        <div class="col-md-10 col-md-offset-1 clearfix" style="border:1px solid #eee; padding:10px;">
          <div class="col-md-12">
            <div class="col-md-6">
              <div class="amifLeft"> 
                <div class="widthami">
<?php

$client_company_name="";
$client_name="";
$client_address="";
$client_email="";
$client_email="";
$client_gst_no="";
$client_state_name="";
$client_state_code="";


if($invoice_status=="Paid")
{
$client_company_name=$invoice_client_company_name;
$client_name=$invoice_client_name;
$client_address=$invoice_client_address;
$client_email=$invoice_client_email;
$client_mobile=$invoice_client_mobile;
$client_gst_no=$invoice_client_gst_no;
$client_state_name=$invoice_client_state_name;
$client_state_code=$invoice_client_state_code;
}else{
$client_data_sql=db_query("select * from tbl_clients where client_id='$invoice_client_id'");
$client_data_res=mysqli_fetch_array($client_data_sql);

$client_company_name=$client_data_res['client_company_name'];
$client_name=$client_data_res['client_name'];
$client_address=$client_data_res['client_billing_address'];
$client_email=$client_data_res['client_email'];
$client_mobile=$client_data_res['client_mobile'];
$client_gst_no=$client_data_res['client_gst_no'];
$client_state_name=$client_data_res['client_state_name'];
$client_state_code=$client_data_res['client_state_code'];

}

/*$client_data_sql=db_query("select * from tbl_clients where client_id='$_REQUEST[invoice_order_client_id]'");
$client_data_res=mysqli_fetch_array($client_data_sql);*/
?>

                  <p style='margin-bottom:5px;'><b>Bill To:</b></p>
              <p style='margin-bottom:5px;'>
<b><?=$client_name?></b>
<?php if($client_company_name!=""){?>
(<?=$client_company_name?>)
<?}?>
                                <br><?=$client_address?>
                      <?php if($client_email!=""){?>
                 <br><?=$client_email?>
                  <?}?>
                <?php if($client_mobile!=""){?>
                 / <?=$client_mobile?>
                  <?}?>
                    
                  <?php if($client_gst_no!=""){?>
                     <br> <b>GST No</b>: <?=$client_gst_no?>
                      <?}?>


                     

                      
                <br><br><strong>Invoice Number: </strong> <?=$invoice_no?>
                <br>
                <b><strong>Invoice Date:</strong> </b> <?=date("d-M-Y", strtotime($invoice_date))?>
                <?php if($invoice_due_date!="0000-00-00"){?>
                  <br>
<b><strong>Due Date:</strong> </b> <?=date("d-M-Y", strtotime($invoice_due_date))?>
                   <?}?>
              </p>


                    </div>

          
              </div>
            </div>

            <div class="col-md-6">
              <div class="amifRight">
              
<?php
$billing_comp_gst_rate="";
$billing_comp_address="";
$billing_comp_terms_and_conditions="";


$billing_comp_name="";
$billing_comp_phone_no="";
$billing_comp_email="";
$billing_comp_website="";
$billing_comp_gst_no="";
$billing_comp_cin_no="";
$billing_comp_state_code="";
$billing_comp_digital_signature="";


$company_data_sql=db_query("select * from tbl_billing_company where billing_company_id='$invoice_billing_company_id'");
$company_data_res=mysqli_fetch_array($company_data_sql);

if($invoice_status=="Paid")
{
$billing_comp_gst_rate=$invoice_billing_company_gst_rate;
$billing_comp_address=$invoice_billing_company_address;
$billing_comp_terms_and_conditions=$invoice_billing_company_terms_and_conditions;

$billing_comp_name=$company_data_res['billing_company_name'];
$billing_comp_phone_no=$company_data_res['billing_company_phone_no'];
$billing_comp_email=$company_data_res['billing_company_email'];
$billing_comp_website=$company_data_res['billing_company_website'];
$billing_comp_gst_no=$company_data_res['billing_company_gst_no'];
$billing_comp_cin_no=$company_data_res['billing_company_cin_no'];
$billing_comp_state_code=$company_data_res['billing_company_state_code'];
$billing_comp_digital_signature=$company_data_res['billing_company_digital_signature'];
}else{
$billing_comp_gst_rate=$company_data_res['billing_company_gst_rate'];
$billing_comp_address=$company_data_res['billing_company_address'];
$billing_comp_terms_and_conditions=$company_data_res['billing_company_terms_and_conditions'];


$billing_comp_name=$company_data_res['billing_company_name'];
$billing_comp_phone_no=$company_data_res['billing_company_phone_no'];
$billing_comp_email=$company_data_res['billing_company_email'];
$billing_comp_website=$company_data_res['billing_company_website'];
$billing_comp_gst_no=$company_data_res['billing_company_gst_no'];
$billing_comp_cin_no=$company_data_res['billing_company_cin_no'];
$billing_comp_state_code=$company_data_res['billing_company_state_code'];
$billing_comp_digital_signature=$company_data_res['billing_company_digital_signature'];
}


?>  
        <div class="col-md-12" style="width:255px; text-align:right;margin-right:-15px;">

    <h5 style="font-size:20px; margin:0px; padding:0px; "><?=$billing_comp_name?></h5>
    <strong>Add: </strong><?=$billing_comp_address?>
   <br><strong>Call Us:</strong><?=$billing_comp_phone_no?>
   <br><strong>Email:</strong><?=$billing_comp_email?>
   <br><strong>Website:</strong><a href="<?=$billing_comp_website?>" target="_blank" style="color:#374767;"><?=remove_http($billing_comp_website)?></a>
   <?php if($billing_comp_gst_no!=""){?><br><strong>GST No. </strong>:<?=$billing_comp_gst_no?><?}?>
   <?php if($billing_comp_cin_no!=""){?><br><strong>CIN No. </strong>:<?=$billing_comp_cin_no?><?}?>

                  </div>


        </div>
  </div>
                <!--<div style="margin-top:25px;"> <strong>Invoice Number : </strong> WKN/AM/19-20/6174 </div>
    <div style="margin-top:25px;"> <strong>Invoice Date :</strong> </b> 27-10-2020 </div>-->
              </div>
            </div>
            <div class="col-md-12 ">
              <table class="table table-bordered table-striped text-center">
                <thead>
                  <tr class="masthead text-primary">
                    <th width="20%" class="text-center">SL</th>
                    <th width="60%" class="text-left">PARTICULARS</th>
                    <!--<th width="10%" class="text-center">QTY</th>-->
                    <th colspan="2" width="45%" class="text-center">RATE</th>
                    <!--<th width="50%" class="text-right">AMOUNT</th>-->
                  </tr>
                </thead>
                <tbody>

                  <?php

$j=1;

$invoice_detail_sql=db_query("select * from tbl_invoice_detail where invoice_detail_invoice_id='$invoice_id' ");
while($invoice_detail_res=mysqli_fetch_array($invoice_detail_sql))
  {  ?>
                    <tr>
                    <td class="text-primary"><?=$j?>.</td>
                    <td class="text-left"><b><?=$invoice_detail_res['invoice_detail_package_name']?></b> (<?=$invoice_detail_res['invoice_detail_package_description']?>)</td>
                    <!--<td>0</td>-->
                    <td colspan="2" class="text-center"><?=number_format((float)$invoice_detail_res['invoice_detail_package_price'], 2, '.', '')?></td>
                    <!--<td class="text-right">0</td>-->
                    </tr>
<?php $j++;  }?>

                                    <tr>
                    <td colspan="5">&nbsp;</td>
                  </tr>
<tr>
<td colspan="3"><strong class="pull-right">Total Amount</strong></td>
<td class="text-right"><?=number_format((float)$invoice_total_amount, 2, '.', '')?></td>
</tr>


<?php if($invoice_discount_amount>0){ ?>
<tr>
<td colspan="3"><strong class="pull-right">Discount</strong></td>
<td class="text-right"><?=number_format((float)$invoice_discount_amount, 2, '.', '')?></td>
</tr>


<?php
if($billing_comp_gst_no!="")
{
?>
<tr>
<td colspan="3"><strong class="pull-right">Amount</strong></td>
<td class="text-right"><?=number_format((float)$invoice_after_discount_amount, 2, '.', '')?></td>
</tr>
<?}?>
<?}?>

<?php
if($billing_comp_gst_no!="")
{
?>

<?php if($billing_comp_state_code==$client_state_code){
$csgst_rate=$billing_comp_gst_rate/2;
$csgst_amount=$invoice_tax_amount/2;
  ?>
<tr>
<td colspan="3"><strong class="pull-right">CGST@<?=$csgst_rate?>%</strong></td>
<td class="text-right"><?=number_format((float)$csgst_amount, 2, '.', '')?></td>
</tr>

<tr>
<td colspan="3"><strong class="pull-right">SGST@<?=$csgst_rate?>%</strong></td>
<td class="text-right"><?=number_format((float)$csgst_amount, 2, '.', '')?></td>
</tr>
<?}else{?>
<tr>
<td colspan="3"><strong class="pull-right">IGST@<?=$billing_comp_gst_rate?>%</strong></td>
<td class="text-right"><?=number_format((float)$invoice_tax_amount, 2, '.', '')?></td>
</tr>
<?}?>   
<?}?>     

<?php
$bill_amount="";
$net_amount="";

if($invoice_gst_extra=="Yes")
{
$bill_amount=$invoice_after_discount_amount+$invoice_tax_amount;
}else{
$net_amount=$invoice_after_discount_amount-$invoice_tax_amount;
$bill_amount=$invoice_grand_total;
}

 ?>
<?php
if($invoice_gst_extra!="Yes")
{
?>
<?php
if($billing_comp_gst_no!="")
{
?>
 <tr>
<td colspan="3"><strong class="pull-right">Net Amount Before Tax</strong></td>
<td class="text-right"><?=number_format((float)$net_amount, 2, '.', '')?></td>
</tr> 
<?}?>
<?}?>
<tr>
<td colspan="3"><strong class="pull-right">BILL TOTAL (Rs.)</strong></td>
<td class="text-right"><?=number_format((float)$bill_amount, 2, '.', '')?></td>
</tr>  


                  <tr>
                    <td colspan="5"><strong class="pull-left">Rupees <?php print convert_number($bill_amount); ?> Only</strong></td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top:5px;">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <h5><strong>Terms And Conditions*</strong></h5>
             <?=$billing_comp_terms_and_conditions?>

                 </div>
                 
                 <div class="col-md-12 col-sm-12 col-xs-12">
                <h5><strong>Note</strong></h5>
             <?=$billing_comp_terms_and_conditions?>

                 </div>
             

            </div>
            	<div class="col-xs-12 text-center">
			   
				<button class="btn btn-success printbtn" onClick="window.print();"><i class="fa fa-print"></i> Print Invoice</button>
				<button class="btn btn-danger printbtn"><i class="fa fa-envelope-o"></i> Pay Online</button>
			
			</div>
			
      <!-- <div class="col-md-12" style="margin-top:5px;">
              <div class="pull-right"><a href="javascript:void(0);" onClick="window.print();" class="amiBtn2 printbtn">Print Page</a></div>
            </div>-->
          </div>
        </div>
      </div>
    </div>

<script>
$(document).bind('keydown keypress', 'ctrl+s', function () {
        $('#save').click();
        return false;
    });
  
 $(this).bind("contextmenu", function(e) {
        e.preventDefault();
    }); 
</script>
</body>
</html>