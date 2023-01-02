<?php 
ob_start();
require_once("../includes/dbsmain.inc.php");
$page_name=basename($_SERVER['PHP_SELF'],'.php');
$site_url=db_scalar("select admin_website_url from tbl_admin where 1");


$pay_online_invoice_id=$_REQUEST['id'];

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
<!DOCTYPE html>
<html class="gr__tradekeyindia_com"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<meta name="viewport" content="width=device-width, initial-scalw=1.0">
<title>Online payment options - <?=$billing_comp_res_pay['billing_company_name']?></title>
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
</head>
<body class="bg-green" data-gr-c-s-loaded="true">
<header>
<div class="container">
<!--<div class="row"> <img src="assets/headere.jpg" class="img-responsive"> </div>-->
</div></header>


<div class="container bg-white">
<div class="row">
<div class="col-sm-12">
    <img src="../company_logo/<?=$billing_comp_res_pay['billing_company_logo']?>" style="width:180px; height:100px;" class="img-responsive">
<!--<h3>Failure</h3>-->
<p class="bdr-bootom no-margin"></p>
<p class="text-right"><small><i class="text-danger">Online Payment</i> » Failure</small></p>
</div>
</div>
<hr>
</div>


<div class="container bg-white">
<div class="row">
<h1 style="text-align:center; color:red; padding:50px;">Your transaction has been failed !</h1>
<div class="container clearfix">


<footer class="bg-black clearfix">
<div class="col-sm-12 text-center"><small class="clrwhite"><a href="<?=$billing_comp_res_pay['billing_company_website']?>" target="_blank" style="color:#FFF;">&copy; <?=date("Y")?> <?=$billing_comp_res_pay['billing_company_name']?>. All Rights Reserved.</a></small>  </div>
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