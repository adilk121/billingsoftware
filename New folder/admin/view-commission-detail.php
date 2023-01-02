<?php
require_once("../includes/dbsmain.inc.php");
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
    <td  id="pageHead" colspan="2" align="center"><div class="col-lg-12 text-center bg-primary bold" style="padding:6px;font-size:16px"><i class="fa fa-money fa-lg" aria-hidden="true"></i>
&nbsp;Commission Detail</div></td>
  </tr>



<form name="form1" action="" method="post" enctype="multipart/form-data" onsubmit="return checkcomment();">
<?php
$sql=db_query("select * from tbl_order_detail INNER JOIN tbl_order on order_id=ord_id where 1 and order_refer_id='".$_REQUEST['resID']."' order by od_id desc");
   if(mysqli_num_rows($sql)>0){
?>	
  <table width="90%"  border="0" align="center" cellpadding="5" cellspacing="5" class="table-striped" style="margin-top:20px;">
    <tr style="height:30px; background-color:#E4E4C9;">
      <td width="18%" align="center" class="tdLabel" style="font-size:12px; color:#0000D7;"><strong>Product Name</strong></td>
      <td width="11%" align="center" class="tdLabel" style="font-size:12px; color:#0000D7;"><strong>Price</strong></td>
      <td width="10%" align="center" class="tdLabel" style="font-size:12px; color:#0000D7;"><strong>Sale Price</strong></td>

      <td width="13%" align="center" class="tdData" style="font-size:12px; color:#0000D7;"><strong>Quantity</strong></td>
      
      <td width="25%" align="center" class="tdLabel" style="font-size:12px; color:#0000D7;"><strong>Sub Total/Commission</strong></td>      

	  	  <td width="11%" align="center" class="tdData" style="font-size:12px; color:#0000D7;"><strong>Date</strong></td>
	 
      
    </tr>
    <tr>
      <td colspan="8">&nbsp;</td>
    </tr>
    <?php
  $i=0;
   $net_amount=0;
   while($recd=mysqli_fetch_array($sql)){
   $i++;
   @extract($recd);
   $net_amount=$net_amount+$product_price;	
   $subcat = db_scalar("select category_parent_id from tbl_category where 1 and category_id='$recd[product_id]' ");
   $catID = db_scalar("select category_parent_id from tbl_category where 1 and category_id='$subcat' ");
?>
    <tr>
      <td class="tdLabel" align="center" style="font-size:11px;">
	  <b><?=db_scalar("select category_name from tbl_category where 1 and category_id='$recd[product_id]'")?></b>
	<p>(<?=db_scalar("select category_name from tbl_category where 1 and category_id='$catID'");?>)</p>
    <img src="../uploaded_files/<?=db_scalar("select category_image_name from tbl_category where 1 and category_id='$recd[product_id]'")?>" width="60" height="70" />		  	  
	  </td>
     <td  align="center" style="font-size:11px;padding:5px 0 5px 0; font-weight:700;color:#063;">
	         <?="Rs. ".$order_refer_real_price?>
     	
	  </td>
      <td width="13%" align="left" class="tdData" style="font-size:11px;color:#F00;padding-left:20px">
      
      <strong>
	
<p>		<?="Rs. ".$product_unit_price?>		</p>
        
               
        
        </strong></td>
        
        
        
      <td width="13%" align="center" class="tdData" style="font-size:11px;"><strong>
        <?=$product_qty?>
        </strong></td>
        
        <td width="25%" align="left" class="tdData" style="font-size:11px;color:#00F;padding-left:50px"><strong>
      
      
     
      <p><?="Rs. ".$product_qty * $product_unit_price?></p>
       
        <p class="font-black"><?="Rs. ".$order_refer_commission?></p>
        
        		
        </strong></td>
        
		<td width="11%" align="center" class="tdData" style="font-size:11px;"><strong>
        <?=date("d M Y",strtotime($order_date));?>
        </strong></td>
		
    </tr>
    <? } ?>
    <tr >
      <td colspan="3" align="right"><strong>Total Amount : </strong></td>
      <td   align="center"><span class="style1">
        <?="Rs.  ".number_format($net_amount,2,'.',',')?>
        </span></td>
        
              <td colspan="" align="right"><strong>Commission : </strong></td>
      <td   align="center"><span class="style1">
<?php
$commAmount=db_scalar("SELECT SUM(order_refer_commission) FROM tbl_order_detail WHERE  order_refer_id='$_REQUEST[resID]'");
echo "Rs.  ".$commAmount;
?>       
</span></td>

        
    </tr>
    
  </table>
  <? } ?>
</form>




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