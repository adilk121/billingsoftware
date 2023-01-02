<?php
require_once("../includes/dbsmain.inc.php");

$cat_id=$_REQUEST['cat_id'];

if(isset($_REQUEST['add_colors'])){
	
$sql="UPDATE tbl_category SET category_color='$colors' WHERE  category_id='$cat_id'";		
$res=db_query($sql);
if($res>0){
$_SESSION['msg']="Colors are added successfully.";	
}

}


$sql=db_query("select * from tbl_category where 1 and category_id='$cat_id'");
if(mysqli_num_rows($sql)>0){
	   $data=mysqli_fetch_array($sql);
	    @extract($data);
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
    <td  id="pageHead" colspan="2"><div class="col-lg-12 text-center bg-primary bold" style="padding:6px;font-size:16px"><i class="fa fa-bars font-black fa-lg"></i>&nbsp;Manage Product Colors</div></td>
  </tr>

<form action="" method="post" enctype="multipart/form-data">
<tr>
<td width="100%" style="padding:10px">
<?php if($_SESSION['msg']!=""){?>
<p class="text-success bold text-center" style="padding:5px;text-align:center"><?=$_SESSION['msg']?></p>
<?php 
unset($_SESSION['msg']);
}
?>

<label>Enter Colors</label>
<textarea class="form-control" style="height:130px" name="colors" id="colors" required="required"><?=$category_color?></textarea>
<p style="color:blue;font-size:12px">Please enter separated by comma (,) </p>

<button class="btn btn-primary" style="padding:5px 20px;margin-top:10px" name="add_colors">Add</button>

</td>
</tr>

</form>
<tr valign="top">
    <td class="tdLabel" align="center" colspan="2"><A href="javascript:self.close()"><strong style="font-size:16px;"><u>Close</u></strong></a></td>
  </tr>
</table>





</body>
</html>
