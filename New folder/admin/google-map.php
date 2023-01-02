<?php
require_once("../includes/dbsmain.inc.php");
include("../site-main-query.php");
if(isset($_REQUEST['save_map'])){
$sql="UPDATE tbl_admin SET admin_contactus_map_link='$admin_contactus_map_link' WHERE 1 AND admin_id='".$admin."'";	 
db_query($sql);
$_SESSION['msg']="Google map is updated successfully.";
}


$reg_sql=db_query("select * from tbl_admin where 1 and admin_id='".$admin."'");
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
      <title><?=$compDATA['admin_company_name']?> : Admin Panel</title>
      <!-- Favicon and touch icons -->
      <link rel="shortcut icon" href="../fevicon.png" type="image/x-icon">
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

<div class="container"> 

<form action="" method="post" enctype="multipart/form-data">
 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center bg-primary bold" style="padding:6px;font-size:16px;background-color:#06F;color:#FFF" align="center"><i class="fa fa-map-marker font-black fa-lg"></i>&nbsp;Google Map Code</div>
    
<?php if($_REQUEST['view']!='yes'){?>

<?php if($_SESSION['msg']!=""){?>    
<div class="col-lg-12 text-center bold " style="color:#090;padding:15px 5px 5px 5px"><?=$_SESSION['msg']?></div>
<?php
unset($_SESSION['msg']);
}
?>    
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center mt5 " align="center">
<textarea name="admin_contactus_map_link" id="admin_contactus_map_link" class="" style="width:100%;height:200px" ><?=$admin_contactus_map_link?></textarea>
</div>    
    
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" align="center">
<button type="submit" name="save_map" class="btn btn-primary mt10 bold"><i class="fa fa-save fa-lg "></i> Save Map</button>
</div>
</form>
<?php }?>

<?php if($_REQUEST['view']=='yes'){?>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padd" align="center">
<?=$admin_contactus_map_link?>
</div>
<?php }?>

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><a href="javascript:self.close()" class="btn btn-link pull-right"><strong style="font-size:16px;"><u>Close</u></strong></a></div>

</div>



</body>
</html>
