<?php
require_once("../includes/dbsmain.inc.php");
include("../site-main-query.php");
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
      <title><?=$compDATA['admin_company_name']?>: Admin Panel</title>
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
    <td  id="pageHead" colspan="2"><div class="col-lg-12 text-center bg-primary bold" style="padding:6px;font-size:16px"><i class="fa fa-cart-plus fa-lg" aria-hidden="true"></i>
&nbsp;Order Detail</div></td>
  </tr>
  
  <tr align="center">
      <td>
          <table cellpadding="2" cellspacing="2" border="0" >
         <tr>
          <td align="center" class="tdLabel" style="font-size:15px; font-weight:bold; color:#0000D7; background-color:#E4E4C9;" colspan="2">Personal Details</td>
        </tr>
        <tr>
          <td nowrap="nowrap" style="padding:5px; font-weight:bold;">Name :</td>
          <td width="77%" style="padding:5px;"><?=$reg_name?></td>
        </tr>
        <tr>
          <td nowrap="nowrap" style="padding:5px; font-weight:bold;">Email :</td>
          <td style="padding:5px;"><?=$reg_email?></td>
        </tr>
        <tr>
          <td  nowrap="nowrap" style="padding:5px; font-weight:bold;">Mobile  No :</td>
          <td  nowrap="nowrap" style="padding:5px;"><?=$reg_mobile_no?></td>
        </tr>
      </table>
    
      </td>
  </tr>
  



<form name="form1" action="" method="post" enctype="multipart/form-data" onsubmit="return checkcomment();">
<?php
 $discnt_sum = db_scalar("select SUM(product_discount_aftr_coupan) from tbl_order_detail where 1 and order_id='".$_REQUEST['ord_id']."'");
  $sql=db_query("select * from tbl_order_detail INNER JOIN tbl_order on order_id=ord_id where 1 and order_id='".$_REQUEST['ord_id']."' order by od_id desc");
   if(mysqli_num_rows($sql)>0){
?>	
  <table width="90%"  border="0" align="center" cellpadding="5" cellspacing="5" class="table-striped" style="margin-top:20px;">
    <tr style="height:30px; background-color:#E4E4C9;">
      <td width="25%" align="center" class="tdLabel" style="font-size:12px; color:#0000D7;"><strong>Product Name</strong></td>
      <td width="10%" align="center" class="tdLabel" style="font-size:12px; color:#0000D7;"><strong>Image</strong></td>
      <td width="10%" align="center" class="tdLabel" style="font-size:12px; color:#0000D7;"><strong>Unit Price (Rs)</strong></td>
      <td width="10%" align="center" class="tdData" style="font-size:12px; color:#0000D7;"><strong>Quantity</strong></td>
	  	  <td width="11%" align="center" class="tdData" style="font-size:12px; color:#0000D7;"><strong>Total Amnt</strong></td>
	  <?php if($discnt_sum > 0){ ?>
	  <td width="12%" align="center" class="tdData" style="font-size:12px; color:#0000D7;"><strong>Coupan</strong></td>	  
	  <? } ?>
      
    </tr>
    <tr>
      <td colspan="8">&nbsp;</td>
    </tr>
    <?php
  $i=0;
   $net_amount=0;
   $ship_charges=0;
   $amnt=0;
   while($recd=mysqli_fetch_array($sql)){
   $i++;
   @extract($recd);
   $net_amount=$net_amount+$product_price;	
   $ship_charges=$ord_prd_shipping_charges+$ship_charges;


   $subcat = db_scalar("select category_parent_id from tbl_category where 1 and category_id='$recd[product_id]' ");
   $catID = db_scalar("select category_parent_id from tbl_category where 1 and category_id='$subcat' ");
?>
    <tr>
      <td class="tdLabel" align="center" style="font-size:11px;">
	  <b><?=db_scalar("select category_name from tbl_category where 1 and category_id='$recd[product_id]'")?></b>
    <?php if($product_size!=""){ ?>
<p><b>Size : </b><?=$product_size?></p>
<?}?>
 <?php if($product_color!=""){ ?>
<p><b>Colour : </b><?=$product_color?></p>
<?}?>
<!--	<p><b>Size : </b><?=$product_color?></p>
	<p><b>Artist : </b><?=$ord_prd_artist_name?></p>
	<p><b>Medium : </b><?=$ord_prd_medium?></p>
	<p><b>Material : </b><?=$ord_prd_material?></p>
	<p><b>Type : </b><?=$ord_prd_type?></p>-->


	
	  </td>
     <td class="tdLabel" align="center" style="font-size:11px;padding:5px 0 5px 0">
	 <img src="../uploaded_files/<?=db_scalar("select category_image_name from tbl_category where 1 and category_id='$recd[product_id]'")?>" width="60" height="70" />	
	  </td>
	  

        
      <td width="10%" align="center" class="tdData" style="font-size:11px;"><strong>
        <?=$product_unit_price?>
        </strong></td>
      <td width="10%" align="center" class="tdData" style="font-size:11px;"><strong>
        <?=$product_qty?>
        </strong></td>
		<td width="10%" align="center" class="tdData" style="font-size:11px;"><strong>
        <?=$product_qty * $product_unit_price;?>
        </strong></td>
		<?php if($discnt_sum > 0){ ?>
		<td width="10%" align="center" class="tdData" style="font-size:11px;">

		<p><strong style="color:#009933;">( <?=$product_coupan_code?> )</strong></p>
		<p><strong><?=$discnt_sum?></strong></p>
		</td>
		<? } ?>
    </tr>
    <? } ?>
    
    <tr >
      <td <?php if($discnt_sum > 0){ ?>colspan="5"<? }else{ ?>colspan="4"<? } ?> align="right"><strong>Tax Amount : </strong></td>
      <td   align="center"><span class="style1">
       <?php  $net_amount+=$ship_charges;
       
       
      
       
       	   
        
        $tax=db_scalar("select ord_tax from tbl_order where ord_id='$order_id'");
  ?>
        <?=number_format($tax,2,'.',',')?>
        </span></td>
    </tr>
    
        <tr >
      <td <?php if($discnt_sum > 0){ ?>colspan="5"<? }else{ ?>colspan="4"<? } ?> align="right"><strong>Total Amount : </strong></td>
      <td   align="center"><span class="style1">
       <?php  $net_amount+=$ship_charges;
       
       
      
       
       	   
      
         $net_amount=db_scalar("select ord_net_amount from tbl_order where ord_id='$order_id'");
  ?>
        <?=number_format($net_amount,2,'.',',')?>
        </span></td>
    </tr>
    
    
  </table>
  <? } ?>
</form>

<table width="90%" border="1" align="center" cellpadding="0" cellspacing="0"  style="border:1px solid #DFDFDF; margin-top:10px;">
 <?php if($reg_billing_address_same=="Yes"){?>
  <tr>
      <th colspan="2" align="left">
        <p style="padding:10px; color:blue;"> NOTE:- Your shipping address is also billing address.</p>
      </th>
  </tr>
<?}?>
  <tr valign="middle" style="height:30px;">
    <?php if($reg_billing_address_same!="Yes"){?>
    <td width="50%" style="background-color:#EAEAEA; font-size:13px;"><b> &nbsp;Billing Address</b></td>
  <?}?>
    <td width="50%" style="background-color:#EAEAEA; font-size:13px;"><b>&nbsp;Shipping Address </b></td>
  </tr>
  <tr valign="top">
    <?php if($reg_billing_address_same!="Yes"){?>
    <td><table width="100%" cellpadding="2" cellspacing="2" border="0">
        
        <tr>
          <td nowrap="nowrap" style="padding:5px; font-weight:bold;">Name :</td>
          <td width="77%" style="padding:5px;"><?=$reg_billing_name?></td>
        </tr>
        <tr>
          <td nowrap="nowrap" style="padding:5px; font-weight:bold;">Email :</td>
          <td style="padding:5px;"><?=$reg_billing_email?></td>
        </tr>
        <tr>
          <td nowrap="nowrap" style="padding:5px; font-weight:bold;">Address :</td>
          <td style="padding:5px;"><?=$reg_billing_address?></td>
        </tr>
           <?php if($reg_billing_landmark!=""){?>
          
          <tr>
          <td nowrap="nowrap" style="padding:5px; font-weight:bold;">Landmark :</td>
          <td nowrap="nowrap" style="padding:5px;"><?=$reg_billing_landmark?></td>
        </tr>
        <?}?>
        
        <tr>
          <td nowrap="nowrap" style="padding:5px; font-weight:bold;">City :</td>
          <td nowrap="nowrap" style="padding:5px;"><?=$reg_billing_city?></td>
        </tr>
        <tr>
          <td nowrap="nowrap" style="padding:5px; font-weight:bold;">State :</td>
          <td nowrap="nowrap" style="padding:5px;"><?=$reg_billing_state?></td>
        </tr>
        <tr>
          <td nowrap="nowrap" style="padding:5px; font-weight:bold;">Country :</td>
          <td nowrap="nowrap" style="padding:5px;"><?=$reg_billing_country?></td>
        </tr>
        <tr>
          <td nowrap="nowrap" style="padding:5px; font-weight:bold;">Zip Code :</td>
          <td nowrap="nowrap" style="padding:5px;"><?=$reg_billing_zip_code?></td>
        </tr>
        <tr>
          <td  nowrap="nowrap" style="padding:5px; font-weight:bold;">Mobile  No :</td>
          <td  nowrap="nowrap" style="padding:5px;"><?=$reg_billing_mobile_no?></td>
        </tr>
      </table></td>
      <?}?>
    <td class="al pl20px bg p5px"><table width="100%" cellpadding="2" cellspacing="2" border="0">

<?php
/*$adrs=db_scalar("SELECT ord_adrs_id FROM  tbl_order WHERE ord_id='$_REQUEST[ord_id]'");
$sql="SELECT * FROM tbl_address WHERE 1 AND id='$adrs'";
$data=db_query($sql);
$recAdrs=mysqli_fetch_array($data);	*/
?>        
        <tr>
          <td style="padding:5px; font-weight:bold;">Name :</td>
          <td width="77%" style="padding:5px;">
              <?=$reg_shipping_name?>
          </td>
        </tr>
        <tr>
          <td nowrap="nowrap" style="padding:5px; font-weight:bold;">Email :</td>
          <td nowrap="nowrap" style="padding:5px;"><?=$reg_shipping_email?></td>
        </tr>
        <tr>
          <td nowrap="nowrap" style="padding:5px; font-weight:bold;">Address :</td>
          <td style="padding:5px;"><?=$reg_shipping_address?></td>
        </tr>
        <?php if($reg_shipping_landmark!=""){?>
          
          <tr>
          <td nowrap="nowrap" style="padding:5px; font-weight:bold;">Landmark :</td>
          <td nowrap="nowrap" style="padding:5px;"><?=$reg_shipping_landmark?></td>
        </tr>
        <?}?>
        
        <tr>
          <td nowrap="nowrap" style="padding:5px; font-weight:bold;">City :</td>
          <td nowrap="nowrap" style="padding:5px;"><?=$reg_shipping_city?></td>
        </tr>
        <tr>
          <td nowrap="nowrap" style="padding:5px; font-weight:bold;">State :</td>
          <td nowrap="nowrap" style="padding:5px;"><?=$reg_shipping_state?></td>
        </tr>
        <tr>
          <td nowrap="nowrap" style="padding:5px; font-weight:bold;">Country :</td>
          <td nowrap="nowrap" style="padding:5px;"><?=$reg_shipping_country?></td>
        </tr>
        <tr>
          <td nowrap="nowrap" style="padding:5px; font-weight:bold;">Zip Code :</td>
          <td nowrap="nowrap" style="padding:5px;"><?=$reg_shipping_zip_code?></td>
        </tr>
        <tr>
          <td nowrap="nowrap" style="padding:5px; font-weight:bold;">Mobile  No :</td>
          <td nowrap="nowrap" style="padding:5px;"><?=$reg_shipping_mobile_no?></td>
        </tr>
      </table></td>
  </tr>
  <?php
  $cmnt=db_scalar("select ord_comment from tbl_order where 1 and ord_id='".$_REQUEST['ord_id']."'");
  if($cmnt!=""){
  ?>
  
  <tr>
    <td colspan="2"><p style="font-size:16px; color:red; padding:10px; font-weight:bold;"> COMMENT:- <?=$cmnt?></p>
</td>
</tr> 
<?}?>


  <tr>
    <td align="center" colspan="2"><a href="javascript:self.close()" onClick="close_window()" ><strong style="font-size:16px;"><u>Close</u></strong></a>
</td>

</tr>  

</table>


</table>



</td>




  </tr>
  
  
  
</table>



</body>
</html>
<script>
function close_window(){
window.close();
 window.opener.location.reload();
}
</script>