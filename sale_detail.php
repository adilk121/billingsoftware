<?php
require_once("../includes/dbsmain.inc.php");
$prdID=$_REQUEST['prdID'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>ThariChoice : Admin Panel</title>
      <!-- Favicon and touch icons -->
  <link rel="shortcut icon" href="../fevicon.png" type="image/x-icon">
      <!-- Start Global Mandatory Style
         =====================================================================-->
      <!-- jquery-ui css -->
      <link href="assets/plugins/jquery-ui-1.12.1/jquery-ui.min.css" rel="stylesheet" type="text/css"/>
      <!-- Bootstrap -->
     <!-- <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>-->
     <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
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
    <td  id="pageHead" colspan="2"><div class="col-lg-12 text-center bg-primary bold " style="padding:6px;font-size:16px; color:#fff"><i class="fa fa-user-circle-o font-black fa-lg"></i>&nbsp;Sale Detail</div></td>
  </tr>
</table>


<div class="table-responsive">
<?php
$sql="SELECT * FROM tbl_order_detail WHERE product_id='$prdID'";
$data=db_query($sql);
$count=mysqli_num_rows($data);
if($count){
?>

<form action="" method="post" enctype="multipart/form-data">                           
                              <table id="dataTableExample1" class="table table-bordered table-striped table-hover">
                                 <thead>
                                    <tr class="info">                                      
                                       <th class="text-center">S.No.</th>                                                  
                                       <th class="text-center">Item</th>
                                       <th class="text-center">Unit Price</th>
                                       <th class="text-center">Qnty Sold</th>
                                       <th class="text-center">Total Sale</th>
 <th class="text-center">Date</th>                                       
                                      
                                    </tr>
                                 </thead>
                                 
<tbody>
                                   
<?
$cnt=0;
while ($line_raw = mysqli_fetch_array($data)) {

$check=db_scalar("SELECT ord_id FROM tbl_order WHERE ord_id='$line_raw[order_id]' AND order_payment_status='Paid'");	
	
if($check>0){	
	$line = ms_display_value($line_raw);
	@extract($line);
	$css = ($css=='trOdd')?'trEven':'trOdd';
?>                                   
                                    <tr>
                            
                            
                            <td class="text-center v-middle"><?=++$start?></td>
                            
                            
                                     
<td class="text-left v-middle " style="padding-left:20px">
<?=db_scalar("SELECT category_name FROM tbl_category WHERE category_id='$line_raw[product_id]'")?>
</td>
       
<td class="text-left v-middle " style="padding-left:20px">
<?=round($line_raw['product_unit_price'],2)?>
</td>
              
       
                                     


<td class="v-middle" align="center">
<?php
echo $line_raw['product_qty'];	
?>
</td>



<td class="text-center v-middle">
<i class="fa fa-inr" aria-hidden="true"></i> <?php
echo round($line_raw['product_price'],2);	
?>                                    
</td>


<td class="text-center v-middle">
<?php
echo date("d M Y",strtotime($line_raw['order_date']));	
?>                                    
</td>


                                         
                                       
                                    </tr>
<?php
}
}
?>


                                    
                                    
                                    
                                    
                                 </tbody>
</form>
                              </table>
                              
                              

<div class="col-lg-12 text-right border">
<?php
$total=db_scalar("SELECT SUM(product_price) FROM tbl_order_detail WHERE product_id='$prdID'");
?>
<h3>Total : <i class="fa fa-inr"></i> <?=round($total,2)?></h3>
</div>                              
                              
<?php 
}else{
?>
<div class="col-lg-12 text-center p-20">No record(s) found</div>
<?php 
}
?>
                              
                           </div>

<table width="100%">


<tr valign="top">
    <td class="tdLabel" align="center" colspan="2"><A href="javascript:self.close()"><strong style="font-size:16px;"><u>Close</u></strong></a></td>
  </tr>
</table>





</body>
</html>
      <script src="assets/plugins/jQuery/jquery-1.12.4.min.js" type="text/javascript"></script>
      <!-- jquery-ui --> 
      <script src="assets/plugins/jquery-ui-1.12.1/jquery-ui.min.js" type="text/javascript"></script>
      <!-- Bootstrap -->
      <script src="assets/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
      <!-- lobipanel -->
      <script src="assets/plugins/lobipanel/lobipanel.min.js" type="text/javascript"></script>
      <!-- Pace js -->
      <script src="assets/plugins/pace/pace.min.js" type="text/javascript"></script>
      <!-- SlimScroll -->
      <script src="assets/plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript">    </script>
      <!-- FastClick -->
      <script src="assets/plugins/fastclick/fastclick.min.js" type="text/javascript"></script>
      <!-- CRMadmin frame -->
      <script src="assets/dist/js/custom.js" type="text/javascript"></script>
      <!-- End Core Plugins
         =====================================================================-->
      <!-- Start Page Lavel Plugins
         =====================================================================-->
      <!-- ChartJs JavaScript -->
      <script src="assets/plugins/chartJs/Chart.min.js" type="text/javascript"></script>
      <!-- Counter js -->
      <script src="assets/plugins/counterup/waypoints.js" type="text/javascript"></script>
      <script src="assets/plugins/counterup/jquery.counterup.min.js" type="text/javascript"></script>
      <!-- Monthly js -->
      <script src="assets/plugins/monthly/monthly.js" type="text/javascript"></script>
      <!-- End Page Lavel Plugins
         =====================================================================-->
      <!-- Start Theme label Script
         =====================================================================-->
      <!-- Dashboard js -->
      <script src="assets/dist/js/dashboard.js" type="text/javascript"></script>

      <script src="../includes/general.js" type="text/javascript"></script>