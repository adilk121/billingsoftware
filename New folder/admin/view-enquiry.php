<?php
require_once("../includes/dbsmain.inc.php");
include("../site-main-query.php");
if($enquiry_id!='') {
	$result = db_query("select * from tbl_enquiry where enquiry_id = '$enquiry_id'");
	if ($line_raw = mysqli_fetch_array($result)) {
	 @extract($line_raw);
	}
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
    <td  id="pageHead" colspan="2"><div class="col-lg-12 text-center bg-primary bold" style="padding:6px;font-size:16px"><i class="fa fa-envelope font-black fa-lg"></i>&nbsp;Enquiry Detail</div></td>
  </tr>



<form action="" method="post" enctype="multipart/form-data">
<tr>
<td width="100%" style="padding:10px">
<table width="100%" cellpadding="2" cellspacing="2" border="0" style="margin-left:0; margin-top:10px; border:1px solid #B7DBFF">

<?php if($line_raw['enquiry_source']=="Enquiry"){?>
<tr>
<td colspan="2" align="left" style="padding:5px;text-align:justify">
<span style="font-size:12px; font-weight:bold; color:#900;">Subject : <span style="color:#000;text-shadow:1px 1px 1px white;font-weight:500"><?=$enquiry_subject?></span></span></td>
</tr>  
<?php }?>


  
<tr>
<td colspan="2" align="left" style="padding:5px;text-align:justify">
<span style="font-size:12px; font-weight:bold; color:#900;">Detail : <span style="color:#000;text-shadow:1px 1px 1px white;font-weight:500"><?=$enquiry_detail?></span></span></td>
</tr>  





</form>
 
  
 
  <tr>
    <td></td>
    <td></td>
    </td>
  </tr>

</table>



<a href="javascript:self.close()" onClick="close_window()" class="pull-right"><strong style="font-size:16px;"><u>Close</u></strong></a>
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