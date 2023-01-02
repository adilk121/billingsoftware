<?php
require_once("../includes/dbsmain.inc.php");
$reg_sql=db_query("select * from tbl_registration where 1 and reg_id='".$_REQUEST['user_id']."'");
if(mysqli_num_rows($reg_sql)>0){
     $regdata=mysqli_fetch_array($reg_sql);
      @extract($regdata);
     }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Sales Hub : Admin Panel</title>
      <!-- Favicon and touch icons -->
      <link rel="shortcut icon" href="../fevicon.png" type="image/x-icon">
      <!-- Start Global Mandatory Style
         =====================================================================-->
      <!-- jquery-ui css -->
      <link href="assets/plugins/jquery-ui-1.12.1/jquery-ui.min.css" rel="stylesheet" type="text/css"/>
      <!-- Bootstrap -->
      <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
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
      
      <style>
  span.count-num {
    float: right;
    margin: -16px 13px 0 0;
    font-size: 18px;
    background: red;
    padding: 1px 6px 1px 6px;
    color: #fff;
    border-radius: 15px;
}
    </style>
      <!-- Theme style rtl -->
      <!--<link href="assets/dist/css/stylecrm-rtl.css" rel="stylesheet" type="text/css"/>-->
      <!-- End Theme Layout Style
         =====================================================================-->
   </head>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td  id="pageHead" colspan="2"><div class="col-lg-12 text-center bg-primary bold" style="padding:6px;font-size:16px"><i class="fa fa-user-circle-o font-black fa-lg"></i>&nbsp;Registration Detail</div></td>
  </tr>
<tr>
    <td colspan="2" align="center">

         <table width="50%" cellpadding="2" cellspacing="2" border="0" style="margin-left:0; margin-top:10px; border:1px solid #B7DBFF">

<tr style="background-color:#B7DBFF;">
    <td colspan="2" align="center" style="padding:5px"><span style="font-size:12px; font-weight:bold; color:#000;">Personal Details</span></td>
    
  </tr>
 
  <tr>
    <td nowrap="nowrap" style="padding:5px; font-weight:bold;">Name :</td>
    <td style="padding:5px;"><?=$reg_name?>
    </td>
  </tr>
  <tr>
    <td nowrap="nowrap" style="padding:5px; font-weight:bold;">Email :</td>
    <td style="padding:5px;"><?=$reg_email?>
    </td>
  </tr>
  <tr>
    <td nowrap="nowrap" style="padding:5px; font-weight:bold;">Password :</td>
    <td style="padding:5px;"><?=$reg_pass?>
    </td>
  </tr>
  <tr>
    <td  nowrap="nowrap" style="padding:5px; font-weight:bold;">Mobile  No :</td>
    <td  nowrap="nowrap" style="padding:5px;"><?=$reg_mobile_no?>
    </td>
  </tr>
 
  <tr>
    <td></td>
    <td></td>
    </td>
  </tr>

</table>
    </td>
</tr>
<?php if($reg_billing_address_same=="Yes"){?>
<tr style="background-color:#B7DBFF;">
    <td colspan="2" align="left" style="padding:5px">
        <p style="font-size:15px; font-weight:bold; color:blue; padding:10px;">NOTE:- Your shipping address is also billing address.</p></td>
    
  </tr>
  <?}?>
<tr>
<?php if($reg_billing_address_same!="Yes"){?>
<td width="50%" style="padding:10px">
    
    <table width="100%" cellpadding="2" cellspacing="2" border="0" style="margin-left:0; margin-top:10px; border:1px solid #B7DBFF">

<tr style="background-color:#B7DBFF;">
    <td colspan="2" align="center" style="padding:5px"><span style="font-size:12px; font-weight:bold; color:#000;">Billing Address</span></td>
    
  </tr>


 
  <tr>
    <td nowrap="nowrap" style="padding:5px; font-weight:bold;">Name :</td>
    <td style="padding:5px;"><?=$reg_billing_name?>
    </td>
  </tr>
  <tr>
    <td nowrap="nowrap" style="padding:5px; font-weight:bold;">Email :</td>
    <td style="padding:5px;"><?=$reg_billing_email?>
    </td>
  </tr>
  <tr>
    <td  nowrap="nowrap" style="padding:5px; font-weight:bold;">Mobile  No :</td>
    <td  nowrap="nowrap" style="padding:5px;"><?=$reg_billing_mobile_no?>
    </td>
  </tr>
  
  <tr>
    <td nowrap="nowrap" style="padding:5px; font-weight:bold;">Address :</td>
    <td style="padding:5px;"><?=$reg_billing_address?>
    </td>
  </tr>
  <?php if($reg_billing_landmark!=""){?>
    <tr>
    <td nowrap="nowrap" style="padding:5px; font-weight:bold;">Landmark :</td>
    <td style="padding:5px;"><?=$reg_billing_landmark?>
    </td>
  </tr>
  <?}?>
  <tr>
    <td nowrap="nowrap" style="padding:5px; font-weight:bold;">Zip Code :</td>
    <td nowrap="nowrap" style="padding:5px;"><?=$reg_billing_zip_code?>
    </td>
  </tr>
  <tr>
    <td nowrap="nowrap" style="padding:5px; font-weight:bold;">City :</td>
    <td nowrap="nowrap" style="padding:5px;"><?=$reg_billing_city?>
    </td>
  </tr>
  <tr>
    <td nowrap="nowrap" style="padding:5px; font-weight:bold;">State :</td>
    <td nowrap="nowrap" style="padding:5px;"><?=$reg_billing_state?>
    </td>
  </tr>
  <tr>
    <td nowrap="nowrap" style="padding:5px; font-weight:bold;">Country :</td>
    <td nowrap="nowrap" style="padding:5px;"><?=$reg_billing_country?>
    </td>
  </tr>
  <tr>
    <td></td>
    <td></td>
  
  </tr>

</table></td>
<?}?>



<td width="50%" style="padding:10px"><table width="100%" cellpadding="2" cellspacing="2" border="0" style="margin-left:0; margin-top:10px; border:1px solid #B7DBFF">
  
  
  <tr style="background-color:#B7DBFF;">
    <td colspan="2" align="center" style="padding:5px"><span style="font-size:12px; font-weight:bold; color:#000;">Shipping Address</span></td>
    
  </tr>
  <tr>
    <td></td>
    <td></td>
    </td>
  </tr>
  <tr>
    <td style="padding:5px; font-weight:bold;">Name :</td>
    <td style="padding:5px;"><?=$reg_shipping_name?>
    </td>
  </tr>
  <tr>
    <td nowrap="nowrap" style="padding:5px; font-weight:bold;">Email :</td>
    <td nowrap="nowrap" style="padding:5px;"><?=$reg_shipping_email?>
    </td>
  </tr>
  <tr>
    <td nowrap="nowrap" style="padding:5px; font-weight:bold;">Mobile  No :</td>
    <td nowrap="nowrap" style="padding:5px;"><?=$reg_shipping_mobile_no?>
    </td>
  </tr>
  <tr>
    <td nowrap="nowrap" style="padding:5px; font-weight:bold;">Address :</td>
    <td style="padding:5px;"><?=$reg_shipping_address?>
    </td>
  </tr>
  
    <?php if($reg_shipping_landmark!=""){?>
    <tr>
    <td nowrap="nowrap" style="padding:5px; font-weight:bold;">Landmark :</td>
    <td style="padding:5px;"><?=$reg_shipping_landmark?>
    </td>
  </tr>
  <?}?>
  
   <tr>
    <td nowrap="nowrap" style="padding:5px; font-weight:bold;">Zip Code :</td>
    <td nowrap="nowrap" style="padding:5px;"><?=$reg_shipping_zip_code?>
    </td>
  </tr>
  <tr>
    <td nowrap="nowrap" style="padding:5px; font-weight:bold;">City :</td>
    <td nowrap="nowrap" style="padding:5px;"><?=$reg_shipping_city?>
    </td>
  </tr>
  <tr>
    <td nowrap="nowrap" style="padding:5px; font-weight:bold;">State :</td>
    <td nowrap="nowrap" style="padding:5px;"><?=$reg_shipping_state?>
    </td>
  </tr>
  <tr>
    <td nowrap="nowrap" style="padding:5px; font-weight:bold;">Country :</td>
    <td nowrap="nowrap" style="padding:5px;"><?=$reg_shipping_country?>
    </td>
  </tr>
  
  <tr>
    <td nowrap="nowrap" style="padding:5px; font-weight:bold;">&nbsp;</td>
    <td nowrap="nowrap" style="padding:5px;">&nbsp;
    </td>
  </tr>
 
  
  
</table></td>
</tr>

<tr valign="top">
    <td class="tdLabel" align="center" colspan="2"><A href="javascript:self.close()"><strong style="font-size:16px;"><u>Close</u></strong></a></td>
  </tr>
</table>





</body>
</html>
