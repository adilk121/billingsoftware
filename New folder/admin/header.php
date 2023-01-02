<?php
ob_start();
require_once("../includes/dbsmain.inc.php");
include("../site-main-query.php");
if(empty($_SESSION['sess_admin_login_id'])){
header("location:login.php");
exit; 
}
$curr_date=date("Y-m-d");
?>
<!DOCTYPE html>
<html lang="en">
<head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
           <link rel="icon" type="image/png" href="../<?=$compDATA['admin_favicon']?>">
      <title><?=$compDATA['admin_company_name']?> : Admin Panel</title>
      <!-- Favicon and touch icons -->
      <!--<link rel="shortcut icon" href="../fevicon.png" type="image/x-icon">-->
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

<style>
#bubble-of-the-week{
width: 800px;
margin: 0 40px 0 0;
padding: 12px 0 10px 0;
font-size: 20px;
color: #fff;
text-shadow: 1px 1px 2px black;
}

#bubble-of-the-week marquee{
margin:5px 0 0 0; 
padding:0  0 5px 0;
}

select#buyer-ord {
    width: 200px;
    float: right;
    margin: -16px 0 0 0;
}

select#resller-ord {
    width: 200px;
    float: right;
    margin: -16px 10px 0 0;
}




@media only screen and (max-width : 769px) and (orientation:portrait){

#bubble-of-the-week {
    width: 200px;
    margin: 0 35px 0 0;
    padding: 0 0 10px 0;
    font-size: 20px;
    color: #fff;
    text-shadow: 1px 1px 2px black;
}

}

@media only screen and (max-width : 769px) and (orientation:landscape){

#bubble-of-the-week {
    width: 452px;
    margin: 0 35px 0 0;
    padding: 0 0 10px 0;
    font-size: 20px;
    color: #fff;
    text-shadow: 1px 1px 2px black;
}

}
</style>

      <!-- Theme style rtl -->
      <!--<link href="assets/dist/css/stylecrm-rtl.css" rel="stylesheet" type="text/css"/>-->
      <!-- End Theme Layout Style
         =====================================================================-->
   </head>
   <body class="hold-transition sidebar-mini">
      <!--preloader-->
     <!-- <div id="preloader">
         <div id="status"></div>
      </div>-->
      <!-- Site wrapper -->
      <div class="wrapper">
         <header class="main-header">
            <a href="index.php" class="logo">
               <!-- Logo -->
               <span class="logo-mini">
               AP
               </span>
               <span class="logo-lg">
              <i class="fa fa-tachometer"></i>&nbsp; Admin Dashboard
               </span>
            </a>
            <!-- Header Navbar -->
            <nav class="navbar navbar-static-top">
                <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
               
                  <span class="sr-only">Toggle navigation</span>
                  <span class="pe-7s-angle-left-circle"></span>
               </a> 
               <!-- searchbar-->
              <!-- <a href="#search"><span class="pe-7s-search"></span></a>
               <div id="search">
                 <button type="button" class="close">×</button>
                 <form>
                   <input type="search" value="" placeholder="Search.." />
                   <button type="submit" class="btn btn-add">Search...</button>
                </form>
                
                                
             </div>-->

                 



             <div class="navbar-custom-menu">
                 
                  
                  
                  <ul class="nav navbar-nav">
                    
                    
<?php /*?><?php
$sql="select admin_business_bubble from tbl_admin where   admin_id='$_SESSION[sess_admin_login_id]' and admin_status = 'Active'";
$bubble = db_scalar($sql);
?>
<?php if($bubble!=""){?>                    
<li id="bubble-of-the-week" >
<a href="Javascript:void(0)" onClick="PopupWindowCenter('update-bubble.php', 'PopupWindowCenter',400,320)" style="color:#fff" ><marquee  direction="left" onmouseover="this.stop();" onmouseout="this.start();"  ><i class="fa fa-pencil-square-o">&nbsp;</i><?=$bubble?></marquee></a>
</li>
<?php
}
?><?php */?>
                    
                     <!-- Help -->
                 <!--     <li class="dropdown dropdown-help hidden-xs">
                        <a href="contact_update.php" >
                        <i class="pe-7s-settings"></i></a>
                        
                     </li> -->
                     <!-- user -->
                     <li class="dropdown dropdown-user">
                        <a href="logout.php"><i class="fa fa-sign-out"></i> </a>
                        
                     </li>
                  </ul>
               </div>
            </nav>
         </header>
        