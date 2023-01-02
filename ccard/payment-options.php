<?php 
ob_start();
require_once("../includes/dbsmain.inc.php");
$page_name=basename($_SERVER['PHP_SELF'],'.php');
$site_url=db_scalar("select admin_website_url from tbl_admin where 1 and admin_user_type='Admin'");

$curr_date=date("Y-m-d");

$pay_online_invoice_id=$_REQUEST['pay_online_invoice_id'];




$inv_sql_pay=db_query("select * from tbl_invoice where invoice_id='$pay_online_invoice_id'");
$inv_data_pay=mysqli_fetch_array($inv_sql_pay);
@extract($inv_data_pay);

$inv_details_sql_pay=db_query("select invoice_detail_package_name from tbl_invoice_detail where invoice_detail_invoice_id='$inv_data_pay[invoice_id]'");
while($inv_details_data_pay=mysqli_fetch_array($inv_details_sql_pay))
{
$product_service_names_array[]=$inv_details_data_pay['invoice_detail_package_name'];    
}


$product_service_names=implode(', ', $product_service_names_array); 


$billing_comp_sql_pay=db_query("select * from tbl_billing_company where billing_company_id='$inv_data_pay[invoice_billing_company_id]'");
$billing_comp_res_pay=mysqli_fetch_array($billing_comp_sql_pay);


$client_sql_pay=db_query("select * from tbl_clients where client_id='$inv_data_pay[invoice_client_id]'");
$client_res_pay=mysqli_fetch_array($client_sql_pay);

?>

<?php

$MERCHANT_KEY = $billing_comp_res_pay['billing_company_payumoney_key'];
$SALT = $billing_comp_res_pay['billing_company_payumoney_salt'];
// Merchant Key and Salt as provided by Payu.

//$PAYU_BASE_URL = "https://sandboxsecure.payu.in";		// For Sandbox Mode
$PAYU_BASE_URL = "https://secure.payu.in";			// For Production Mode

$action = '';

$posted = array();
if(!empty($_POST)) {
    //print_r($_POST);
  foreach($_POST as $key => $value) {    
    $posted[$key] = $value; 
	
  }
}

$formError = 0;

if(empty($posted['txnid'])) {
  // Generate random transaction id
  $txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
} else {
  $txnid = $posted['txnid'];
}
$hash = '';
// Hash Sequence
$hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";
if(empty($posted['hash']) && sizeof($posted) > 0) {
  if(
          empty($posted['key'])
          || empty($posted['txnid'])
          || empty($posted['amount'])
          || empty($posted['firstname'])
          || empty($posted['email'])
          || empty($posted['phone'])
          || empty($posted['productinfo'])
          || empty($posted['surl'])
          || empty($posted['furl'])
		  || empty($posted['service_provider'])
  ) {
    $formError = 1;
  } else {
    //$posted['productinfo'] = json_encode(json_decode('[{"name":"tutionfee","description":"","value":"500","isRequired":"false"},{"name":"developmentfee","description":"monthly tution fee","value":"1500","isRequired":"false"}]'));
	$hashVarsSeq = explode('|', $hashSequence);
    $hash_string = '';	
	foreach($hashVarsSeq as $hash_var) {
      $hash_string .= isset($posted[$hash_var]) ? $posted[$hash_var] : '';
      $hash_string .= '|';
    }

    $hash_string .= $SALT;


    $hash = strtolower(hash('sha512', $hash_string));
    $action = $PAYU_BASE_URL . '/_payment';
  }
} elseif(!empty($posted['hash'])) {
  $hash = $posted['hash'];
  $action = $PAYU_BASE_URL . '/_payment';
}
?>
<!DOCTYPE html>
<html class="gr__tradekeyindia_com"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<meta name="viewport" content="width=device-width, initial-scalw=1.0">
<title>Online Payment Options - <?=$billing_comp_res_pay['billing_company_name']?></title>
<link href="assets/bootsrtap.css" rel="stylesheet" type="text/css">
<!--<link href="https://www.webkeyindia.com/favicon.png" rel="shortcut icon" type="image/x-icon">-->
<meta name="description" content="Online payment options - <?=$billing_comp_res_pay['billing_company_name']?>">
<meta name="keywords" content="Online payment options - <?=$billing_comp_res_pay['billing_company_name']?>">
<!--------------->
<style>
	.bg1 {
   margin-left: 1px; border: #ddd solid 1px !important; background-color:#f9f9f9; padding:10px; color:#000 !important;
}
	.text-info {
   color:#000 !important;
}
	.bdr-bootom {
    border: #033d48 dotted 0px;
}
	.mttop {
    margin-top: 5px !important;
}
	.bdrclr {
   border: #044855 dotted 0px;
		border-left: #044855 dotted 0px;
		border-right: #044855 dotted 0px;
}
	
	.bg-black {
    background: #c52d2f;
		
}
	.btn-primary{background: #2B2B2B;}
	.btn-primary:hover { background: #c52d2f; border:solid 1px #c52d2f;}
	.bg-green {
    background: #c52d2f;
		background:url("assets/bg1.png") no-repeat; background-size:cover;  width:100%; height:100%;
}
	.mlleft{font-weight:bold;}
</style>	
<style>
table {
  width:100%;
}
table, th, td {
  border: 1px solid #ccc;
  border-collapse: collapse;
}
th, td {
  padding: 5px;
  text-align: left;
}
table#t01 tr:nth-child(even) {
  background-color: #eee;
}
table#t01 tr:nth-child(odd) {
 background-color: #fff;
}
table#t01 th {
  background-color: #c52d2f;
  color: white;
}
	#t01{text-align: center !important;}
</style>
<!------------->
	<style>
		.pymg p{font-size: 18px;}
		.pymg img{width:40px; height:40px; border-radius:100%;}
		.mp02{margin:0px; text-align: center; padding:15px 10px;  margin-top:0px; }
		.mpres{}
		.brd-sty{border-right:solid 1px #ccc;}
		.pay-con img{width:40px; height:40px; border-radius:100%;}
		@media (min-width:320px) and (max-width:767px) 
		{.pymg{margin-bottom:10px;}
			.brd-sty{border-right:solid 0px #ccc;}
			.brd-res{border-top:solid 1px #ccc; margin: 0px; padding:20px 0px;}
		}
	</style>
<!---------------->

  <script>
    var hash = '<?php echo $hash ?>';
    function submitPayuForm() {
      if(hash == '') {
        return;
      }
      var payuForm = document.forms.payuForm;
      payuForm.submit();
    }
  </script>
</head>
<body class="bg-green" data-gr-c-s-loaded="true" onload="submitPayuForm()">
<header>
<div class="container">
<!--<div class="row"> <img src="assets/headere.jpg" class="img-responsive"> </div>-->
</div></header>


<div class="container bg-white">
<div class="row">
<div class="col-sm-12">
    <img src="../company_logo/<?=$billing_comp_res_pay['billing_company_logo']?>" style="width:180px; height:100px;" class="img-responsive">
<!--<h3><?=$billing_comp_res_pay['billing_company_name']?></h3>-->
<p class="bdr-bootom no-margin"></p>
<p class="text-right"><small><i class="text-danger">Online Payment</i> » <!--Order Now » Your Invoice--></small></p>
</div>
</div>
</div>


<div class="container bg-white">
<div class="row">
<form method="post">
<div class="container">
<table class="table-condensed table table-bordered table-striped">
<tbody><tr>
<td colspan="2" class="bg-black"><strong class="clrwhite">Your Invoice Details (Invoice No :- <?=$inv_data_pay['invoice_no']?> )</strong></td>
</tr>
<tr>
<td width="33%"><p class="mlleft no-margin">Payment For <i class="text-danger">*</i></p></td>
<td width="67%"><p class="no-margin"><?=$product_service_names?></p></td>
</tr>
<tr>
<td><p class="mlleft no-margin">Price (INR) <i class="text-danger">*</i></p></td>
<td><p class="no-margin"><?=$inv_data_pay['invoice_grand_total']?></p></td>
</tr>
<tr>
<td colspan="2" class="bg-black"><strong class="clrwhite">Your Information</strong></td>
</tr>
<tr>
<td><p class="mlleft no-margin">Company Name <i class="text-danger">*</i></p></td>
<td><p class="no-margin"><?=$client_res_pay['client_company_name']?></p></td>
</tr>
<tr>
<td><p class="mlleft no-margin">Mobile Number <i class="text-danger">*</i></p></td>
<td><p class="no-margin"><?=$client_res_pay['client_mobile']?></p></td>
</tr>
<tr>
<td><p class="mlleft no-margin">E-mail ID <i class="text-danger">*</i></p></td>
<td><p class="no-margin"><?=$client_res_pay['client_email']?></p></td>
</tr>

<tr>
<td><p class="mlleft no-margin">Registered Office Address <i class="text-danger">*</i></p></td>
<td><p class="no-margin"><?=$client_res_pay['client_billing_address']?></p></td>
</tr>


</tbody></table>
</div>
</form>
 
<div class="container clearfix">
<div class="row">
<div class="col-sm-12 col-xs-12">
<h4 class="text-danger" style="position:relative; top:10px; color:#c52d2f;"><strong>Please Select Your Mode of Payment</strong></h4>
</div>
<p class="clearfix"></p>
<div class="container clearfix">
<!------------->
<!--	<form enctype="multipart/form-data" name="SStdFrm" method="post" action="http://www.tradekeyindia.com/ccard/PayUMoney_form.php">-->
<div class="bdrclr clearfix">
<p class="mlleft bg1"><strong class="text-info">Wallet/QR Code/UPI (Google Pay/Phone Pay/Paytm/Bhim UPI) etc.</strong>
<!---<input name="name_radio1" value="value_radio4" id="id_radio4" type="radio" checked="checked">------>
</p>
<p class="bdr-bootom"></p>
<div>
	
<!------------------>
	<div class="clearfix"></div>
	
	<div class="col-md-12 mp02" style="border:solid 1px #ccc; top:-10px">
	<div class="col-md-6 mpres brd-sty">
		<!---<h4><strong>For Paytm</strong></h4>---->
		
		
		<div class="col-md-12">
			<div class="col-md-8 col-md-offset-2">
				<p style="font-weight: bold; color:#c52d2f; Font-size:20px;"><?=$billing_comp_res_pay['billing_company_name']?></p>
			<img src="../company_qr_code/<?=$billing_comp_res_pay['billing_company_payment_qr_code']?>" style="width:100%">
			</div>
		<!--	<p style="padding:10px 0px 5px 0px !important; font-weight: bold; position:relative; top:10px;">Q69272448ybl</p>
			<p class="pay-con">
			<img src="assets/g-pay.png">
			<img src="assets/phone-pay.png">
			<img src="assets/pytm1.png">
			<img src="assets/bhm.png"></p>-->
		</div></div>

	<div class="col-md-6 mpres brd-res">
		<!----<h4><strong>For Other Apps</strong></h4>----->
		
		<div class="col-md-12" style="text-align:left !important;">
		    <div class="col-md-12  pymg">
		 
			<p class="pay-con">
			<img src="assets/g-pay.png">
			<img src="assets/phone-pay.png">
			<img src="assets/pytm1.png">
			<img src="assets/bhm.png"></p>
		        </div>
			<?php if($billing_comp_res_pay['billing_company_wallet_no']!=""){ ?>
			<div class="col-md-12  pymg">
				<p>Wallet No.<!--<img src="assets/g-pay.png">--> : <span style="color:#c52d2f;"><?=$billing_comp_res_pay['billing_company_wallet_no']?></span>
				</p>
			</div>
			<?}?>
				<?php if($billing_comp_res_pay['billing_company_upi_id']!=""){ ?>
			<div class="col-md-12  pymg">
				<p>UPI Id<!--<img src="assets/phone-pay.png">--> : <span style="color:#c52d2f;"><?=$billing_comp_res_pay['billing_company_upi_id']?>
				</p>
			</div>
			<?}?>
			<!--<div class="col-md-12 text-center pymg">
				<p><img src="assets/pytm1.png"> :  9999414160

				</p>
			</div>
			<div class="col-md-12 text-center pymg">
				<p><img src="assets/bhm.png"> :  webkey@icici

				</p>
			</div>-->
			
		</div>
		<?php
if(isset($_REQUEST['submit_ref']))
{

$ref_no=$_POST['ref_no'];
$inv_ID=$_POST['invoice_id'];
$inv_BILLING_COMP_ID=$_POST['invoice_billing_comp_id'];
$inv_CLIENT_ID=$_POST['invoice_client_id'];
$payment_method=$_POST['pay_method'];
$scrn_sht="";

if($_FILES['screen_shot']['name']!=""){
    $rand=rand(100,10000);
   $screen_shot=$rand.$_FILES['screen_shot']['name'];
  move_uploaded_file($_FILES['screen_shot']['tmp_name'],"payment_screenshot/$screen_shot");        
$scrn_sht=$screen_shot;

    
}
 
$sql_in=db_query("insert into tbl_online_payment_record set
record_invoice_id='$inv_ID', 
record_billing_company_id='$inv_BILLING_COMP_ID',
record_client_id='$inv_CLIENT_ID',
record_ref_no='$ref_no',
record_screen_shot='$scrn_sht',
record_payment_method='$payment_method',
record_ref_no_match='No',
record_add_date='$curr_date' ");
if($sql_in)
{
    header("location:thanks.html?id=$inv_data_pay[invoice_id]&type=manual");
}else
{
  header("location:fail.html?id=$inv_data_pay[invoice_id]");
}
 
}	
		?>
		
		<div class="col-md-12 text-left"  style="border-top:solid 1px #ebebeb; padding: 20px 0px; font-size: 12px; margin-top:30px;">
			
			<form action="" method="post" enctype="multipart/form-data">
			<p>Transaction Ref. No. : <input type="text" name="ref_no" id="ref_no" required></p>
			<p style="float:left">Attach Screenshot : </p><p> <input type="file" name="screen_shot" id="screen_shot" required></p>
			<p><input type="hidden" name="invoice_id" id="invoice_id" value="<?=$inv_data_pay['invoice_id']?>"></p>
			<p><input type="hidden" name="invoice_billing_comp_id" id="invoice_billing_comp_id" value="<?=$inv_data_pay['invoice_billing_company_id']?>"></p>
			<p><input type="hidden" name="invoice_client_id" id="invoice_client_id" value="<?=$inv_data_pay['invoice_client_id']?>"></p>
			<p><input type="hidden" name="pay_method" id="pay_method" value="QR_CODE_WALLET_UPI"></p>
			<p style="color:blue;"><i>Note: Your payment will not be acceptable without submit transaction ref. no.</i></p>
			
				<p>   <input type="submit" class="btn btn-primary btn-md" name="submit_ref" id="submit_ref"></p>
			</form>
<!--				<p><span style="color:#c52d2f">Note : </span>
				We request you to kindly email us the payment details at <a href="mailto:support@webkeyindia.com" style="text-decoration:underline;">support@webkeyindia.com</a>, so that we can keep a track of it, and activate your order on receipt of the payment with fruitful effects.</p>
			--></div>
	</div></div>
	<!--------------->
<div class="col-md-2 col-sm-6 col-xs-6">
    
 <!--   
<input type="hidden" name="key" value="RQai3yst">

<input type="hidden" name="txnid" value="1752">

<input type="hidden" name="amount" value="testing">

<input type="hidden" name="firstname" id="firstname" value="testing">

<input type="hidden" name="email" id="email" value="testing@gmail.com">
	
<input type="hidden" name="phone" value="9955265212">

<input type="hidden" name="productinfo" value="testing">

<input type="hidden" name="surl" value="http://www.tradekeyindia.com/ccard/success.php" size="64">
  
<input type="hidden" name="furl" value="http://www.tradekeyindia.com/ccard/failure.php" size="64">
  
<input type="hidden" name="service_provider" value="payu_paisa" size="64">

-->

</div></div>
<p class="clearfix"></p>
</div>
<!--</form>-->


<!--<form enctype="multipart/form-data" name="joinForm1" method="post" action="http://www.tradekeyindia.com/ccard/pay.php" onsubmit="return ValidateRadio()">-->	
<?php
if($billing_comp_res_pay['billing_company_account_no']!=""){
?>
<div class="bdrclr mttop clearfix">
<p class="mlleft bg1"><strong class="text-info">By Bank (Deposit Cash, Cheque or Bank Transfer)</strong>
	
<input name="name_radio1" value="value_radio1" id="id_radio1" type="radio" style="position:relative; top:2px;">
</p>


    



	<div class="col-md-12" style="border:solid 1px #ccc; top:-10px">

<div style="display:none;" id="div1">


    
	<div class="col-md-12 col-sm-12 col-xs-12">

    </div>


<!----------->
	<div class="col-md-12 text-center" style="overflow:auto;" id="show_bank">

		<table id="t01" style="margin:20px 0px">
  <tr>
    <th colspan="2" style="text-align: center;">You can make the payment through NEFT / RTGS / Cash / Cheq or DD. Our account information is.</th>
  </tr>
  
   <tr>
    <td width="300">
Bank Name</td>
    <td><?=$billing_comp_res_pay['billing_company_bank_name']?></td>
  </tr>
   <tr>
    <td>A/C Name</td>
    <td><?=$billing_comp_res_pay['billing_company_account_name']?></td>
  </tr>
  <tr>
    <td width="300">
A/C No</td>
    <td><?=$billing_comp_res_pay['billing_company_account_no']?></td>
  </tr>
 
  <tr>
    <td>A/C Type</td>
    <td><?=$billing_comp_res_pay['billing_company_account_type']?></td>
  </tr>
  
  
	<tr>
    <td>IFSC</td>
    <td><?=$billing_comp_res_pay['billing_company_ifsc_code']?></td>
  </tr>
  
  <?php if($billing_comp_res_pay['billing_company_branch']!=""){ ?>
	<tr>
    <td>Branch</td>
    <td><?=$billing_comp_res_pay['billing_company_branch']?></td>
  </tr>
  <?}?>
</table>

	</div>



			<?php
if(isset($_REQUEST['submit_ref_bank']))
{

$ref_no=$_POST['ref_no'];
$inv_ID=$_POST['invoice_id'];
$inv_BILLING_COMP_ID=$_POST['invoice_billing_comp_id'];
$inv_CLIENT_ID=$_POST['invoice_client_id'];
$payment_method=$_POST['pay_method'];
$scrn_sht="";

if($_FILES['screen_shot']['name']!=""){
    $rand=rand(100,10000);
   $screen_shot=$rand.$_FILES['screen_shot']['name'];
  move_uploaded_file($_FILES['screen_shot']['tmp_name'],"payment_screenshot/$screen_shot");        
$scrn_sht=$screen_shot;

    
}
 
$sql_in=db_query("insert into tbl_online_payment_record set
record_invoice_id='$inv_ID', 
record_billing_company_id='$inv_BILLING_COMP_ID',
record_client_id='$inv_CLIENT_ID',
record_ref_no='$ref_no',
record_screen_shot='$scrn_sht',
record_payment_method='$payment_method',
record_ref_no_match='No',
record_add_date='$curr_date' ");
if($sql_in)
{
    header("location:thanks.html?id=$inv_data_pay[invoice_id]&type=manual");
}else
{
  header("location:fail.html?id=$inv_data_pay[invoice_id]");
}
 
}	
		?>
		<form action="" method="post" enctype="multipart/form-data">
					<p>Transaction Ref. No. : <input type="text" name="ref_no" id="ref_no" required></p>
			<p style="float:left">Attach Screenshot : </p><p> <input type="file" name="screen_shot" id="screen_shot" required></p>
			<p><input type="hidden" name="invoice_id" id="invoice_id" value="<?=$inv_data_pay['invoice_id']?>"></p>
			<p><input type="hidden" name="invoice_billing_comp_id" id="invoice_billing_comp_id" value="<?=$inv_data_pay['invoice_billing_company_id']?>"></p>
			<p><input type="hidden" name="invoice_client_id" id="invoice_client_id" value="<?=$inv_data_pay['invoice_client_id']?>"></p>
			<p><input type="hidden" name="pay_method" id="pay_method" value="BANK"></p>
				<p style="color:blue;"><i>Note: Your payment will not be acceptable without submit transaction ref. no. of bank.</i></p>
			
				<p>   <input type="submit" class="btn btn-primary btn-md" name="submit_ref_bank" id="submit_ref_bank"></p>
			</form>
	</div>
	<!----------->	
	
	
</div>


	
<p class="clearfix"></p>
</div>
<?}?>
<!--</form>-->

<!---------------->
<?php
if($billing_comp_res_pay['billing_company_payumoney_key']!="" && $billing_comp_res_pay['billing_company_payumoney_salt']!=""){
?>

 <?php if($formError) { ?>
	
      <span style="color:red">Please fill all mandatory fields.</span>
      <br/>
      <br/>
    <?php } ?> 
   <form action="<?php echo $action; ?>" method="post" name="payuForm">
      <input type="hidden" name="key" value="<?php echo $MERCHANT_KEY ?>" />
      <input type="hidden" name="hash" value="<?php echo $hash ?>"/>
      <input type="hidden" name="txnid" value="<?php echo $txnid ?>" />
      
      <div class="bdrclr mttop clearfix">
<p class="mlleft bg1"><strong class="text-info">Online Payment Options (Credit Card/Debit Card/Net Banking/Wallet/UPI) </strong>
<input name="name_radio1" value="value_radio3" id="id_radio3" type="radio" style="position:relative; top:2px;">
</p>

<input name="amount" value="<?=$inv_data_pay['invoice_grand_total']?>" type="hidden"/>
<input name="firstname" id="firstname" value="<?=$client_res_pay['client_company_name']?>" type="hidden"/>
<input name="email" id="email" value="<?=$client_res_pay['client_email']?>" type="hidden"/>

<input name="phone" value="<?=$client_res_pay['client_mobile']?>" type="hidden"/>

<input type="hidden" name="productinfo" value="<?=$product_service_names?>">
<input type="hidden" name="address1" value="<?=$client_res_pay['client_billing_address']?>">


<input name="surl" value="<?=$site_url?>/ccard/thanks.html?id=<?=$inv_data_pay['invoice_id']?>" size="64" type="hidden"/>

<input name="furl" value="<?=$site_url?>/ccard/fail.html?id=<?=$inv_data_pay['invoice_id']?>" size="64" type="hidden"/>

<input type="hidden" name="service_provider" value="payu_paisa" size="64" />




<div id="div3" style="display:none;">
<div class="col-md-12 col-sm-3 col-xs-12" style="border:solid 1px #ccc; top:-10px">
<p class="mttop mlleft">
<input type="submit" value="Proceed Now" class="btn btn-success" style="position:relative; top:2px;"/></p>
</div>
	
</div>




<p class="clearfix"></p>
</div></form>

<?}?>


<!--*******************-->



</div>
</div>

<footer class="bg-black clearfix">
<div class="col-sm-12 text-center"><small class="clrwhite"><a href="<?=$billing_comp_res_pay['billing_company_website']?>" style="color:#FFF;">&copy; <?=date("Y")?> <?=$billing_comp_res_pay['billing_company_name']?>. All Rights Reserved.</a></small>  </div>
</footer>
</div>
</div>
<script language="JavaScript">
function ValidateRadio(){
if ( ( document.joinForm1.pymt_mode[0].checked == false ) && ( document.joinForm1.pymt_mode[1].checked == false ) && ( document.joinForm1.pymt_mode[2].checked == false ) ) 
{
alert ( "Please select bank to proceed !" ); 
document.joinForm1.pymt_mode[0].focus();
return false; 
 }
}
</script>
<script language="JavaScript">
function SelectRadio(){
if ( ( document.joinForm2.pymt_mode1.checked == false ) ) 
{
alert ( "Please select Cheque/Demand Draft By Post to proceed !" ); 
document.joinForm2.pymt_mode1.focus();
return false; 
 }
}
</script>
<script src="assets/jquery-latest.js.download"></script>
<script type="text/javascript">
 $(document).ready(function () {
	$('#id_radio1').click(function () {
	   $('#div2').hide('slow');
	   $('#div3').hide('slow');
	   $('#div4').hide('slow');
	   $('#id_radio2').attr('checked', false);
	   $('#id_radio3').attr('checked', false);
	   $('#id_radio4').attr('checked', false);
	   $('#div1').show('slow');
});
$('#id_radio2').click(function () {
	  $('#div1').hide('slow');
	  $('#div3').hide('slow');
	  $('#div4').hide('slow');
	  $('#id_radio1').attr('checked', false);
	  $('#id_radio3').attr('checked', false);
	  $('#id_radio4').attr('checked', false);
	  $('#div2').show('slow');
 });
 $('#id_radio3').click(function () {
	  $('#div1').hide('slow');
	  $('#div2').hide('slow');
	  $('#div4').hide('slow');
	  $('#id_radio1').attr('checked', false);
	  $('#id_radio2').attr('checked', false);
	  $('#id_radio4').attr('checked', false);
	  $('#div3').show('slow');
 });
 $('#id_radio4').click(function () {
	  $('#div1').hide('slow');
	  $('#div2').hide('slow');
	  $('#div3').hide('slow');
	  $('#id_radio1').attr('checked', false);
	  $('#id_radio2').attr('checked', false);
	  $('#id_radio3').attr('checked', false);
	  $('#div4').show('slow');
 });
});
</script>
<script language="javascript" type="text/javascript">
function PopupWindowCenter(URL, title,w,h)
{var left = (screen.width/2)-(w/2);
var top = '20px';
var newWin = window.open (URL, title, 'toolbar=no, location=no,directories=no, status=no, menubar=no, scrollbars=no, resizable=no,copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
}
</script>
<script type="text/javascript">
    /* Modified to support Opera */

    function bookmarksite(title, url) {
      if (window.sidebar) // firefox
      window.sidebar.addPanel(title, url, "");
      else if (window.opera && window.print) { // opera
        var elem = document.createElement('a');
        elem.setAttribute('href', url);
        elem.setAttribute('title', title);
        elem.setAttribute('rel', 'sidebar');
        elem.click();
      } else if (document.all) // ie
      window.external.AddFavorite(url, title);
    }
    </script>


</div></body></html>