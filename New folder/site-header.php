<?php 
ob_start();
require_once("includes/dbsmain.inc.php");
$page_name=basename($_SERVER['PHP_SELF'],'.php');
include("site-main-query.php");
$sess_id=session_id();

$site_url=$compDATA['admin_website_url'];
$author = str_replace("http://","","$site_url");
?>
<!DOCTYPE html>
<html lang="en">
   
<head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php
$catgoryID=$_REQUEST['id'];
if(!empty($catgoryID)){?>
<title><?=db_scalar("select category_meta_title from  tbl_category where category_status='Active' and category_id='$catgoryID'")?></title>
<META NAME="description" content="<?=db_scalar("select category_meta_description from  tbl_category where category_status='Active' and category_id='$catgoryID'")?>" />
<META NAME="keywords" content="<?=db_scalar("select category_meta_keywords from  tbl_category where category_status='Active' and category_id='$catgoryID'")?>" />
<? }else{
$titl=db_scalar("select site_pages_meta_title from  tbl_site_pages where site_pages_status='Active' and site_pages_link='$page_name'");
$desc=db_scalar("select site_pages_meta_description from  tbl_site_pages where site_pages_status='Active' and site_pages_link='$page_name'");
$keyw=db_scalar("select site_pages_meta_keyword from  tbl_site_pages where site_pages_status='Active' and site_pages_link='$page_name'");
$PAGE_name=db_scalar("select site_pages_name from  tbl_site_pages where site_pages_status='Active' and site_pages_link='$page_name'");
if($titl=="")
{
    $titl=$compDATA['admin_company_name']." ".$PAGE_name;
}

if($desc=="")
{
    $desc=$compDATA['admin_company_name']." ".$PAGE_name;
}

if($keyw=="")
{
    $keyw=$compDATA['admin_company_name']." ".$PAGE_name;
}
?>
<title>
    <?=$titl?>
</title>
<meta name="description" content="<?=$desc?>">
<META NAME="keywords" content="<?=$keyw?>" />
<?}?>
      <meta name="author" content="<?=$compDATA['admin_company_name']?>">
      <!-- Favicon Icon -->
      <link rel="icon" type="image/png" href="<?=$site_url?>/<?=$compDATA['admin_favicon']?>">

<?php if($compDATA['admin_index_follow']=='Yes'){ ?>
<meta name="robots" content="index, follow" />
<? }else{ ?>
<meta name="robots" content="noindex, nofollow" />
<? } ?>
<?php if($compDATA['admin_meta_fb_id']!=''){ ?>
<meta property="fb:page_id" content="<?=$compDATA['admin_meta_fb_id']?>" />
<? } ?>
<?php if($compDATA['admin_meta_alexa_id']!=''){ ?>
<meta name="alexaVerifyID" content="<?=$compDATA['admin_meta_alexa_id']?>"/>
<? } ?>
<?php if($compDATA['admin_meta_msvalidate_id']!=''){ ?>
<meta name="msvalidate.01" content="<?=$compDATA['admin_meta_msvalidate_id']?>" />
<? } ?>
<?php if($compDATA['admin_site_verification_code']!=''){ ?>
<meta name="google-site-verification" content="<?=$compDATA['admin_site_verification_code']?>" />
<? } ?>
<?php if($compDATA['admin_google_analytic_code']!=''){
 echo $compDATA['admin_google_analytic_code'];
}?>


      <!-- Bootstrap core CSS -->
      <link href="<?=$site_url?>/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
      <!-- Material Design Icons -->
      <link href="<?=$site_url?>/vendor/icons/css/materialdesignicons.min.css" media="all" rel="stylesheet" type="text/css" />
      <!-- Select2 CSS -->
      <link href="<?=$site_url?>/vendor/select2/css/select2-bootstrap.css" rel="stylesheet" />
      <link href="<?=$site_url?>/vendor/select2/css/select2.min.css" rel="stylesheet" />
      <!-- Custom styles for this template -->
      <link href="<?=$site_url?>/css/samar.css" rel="stylesheet">
	  <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
     <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
   </head>
   <body>
       <style>
       .topnav {
  overflow: hidden;
  background-color: #003366;
}

.topnav a {
  float: left;
  display: block;
  color: #f2f2f2;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
  font-size: 17px;
}

.topnav a:hover {
  background-color: #ddd;
  color: black;
}

.topnav a.active {
  background-color: #ff6633;
  color: white;
}

.topnav .icon {
  display: none;
}

@media screen and (max-width: 600px) {
  .topnav a:not(:first-child) {display: none;}
  .topnav a.icon {
    float: right;
    display: block;
  }
}

@media screen and (max-width: 600px) {
  .topnav.responsive {position: relative;}
  .topnav.responsive .icon {
    position: absolute;
    right: 0;
    top: 0;
  }
  .topnav.responsive a {
    float: none;
    display: block;
    text-align: left;
  }
}
</style>
       <?php
$link_sql=db_query("select * from tbl_site_pages where 1 and site_pages_status='Active' and site_pages_show_in_header='Yes' order by site_pages_order_by asc");
if(mysqli_num_rows($link_sql)>0){
?>
<div class="fluid-container" style="background-color:#003366;">
<div class="container" style="background-color:#003366;">
    
   <div class="topnav" id="myTopnav">
       <?php
while($link_data=mysqli_fetch_array($link_sql)){
$pgName=$link_data['site_pages_link'];
?> <!--class="active"-->
  <a href="<?=$site_url?>/<?=$link_data['site_pages_link']?>.html"><?=$link_data['site_pages_name']?></a>
  <?}?>

  <a href="javascript:void(0);" class="icon" onclick="NavFunction()">
    <i class="fa fa-bars"></i>
  </a>
</div>
</div>
</div>
<?}?>


<script>
function NavFunction() {
  var x = document.getElementById("myTopnav");
  if (x.className === "topnav") {
    x.className += " responsive";
  } else {
    x.className = "topnav";
  }
}
</script>
       
      
     
      
     
      <header>
      	<div class="container position-relative">

      	    
         <nav class="navbar navbar-expand-lg navbar-light bg-danger pr-3 pl-3">
<?php
$sql_logo_welcome=db_query("select * from tbl_header where 1 and header_status='Active' limit 1");
if(mysqli_num_rows($sql_logo_welcome)>0){
$DATALOGO=mysqli_fetch_array($sql_logo_welcome);
@extract($DATALOGO);
}
?>
               <a class="navbar-brand text-success logo" href="<?=$site_url?>">
               <img src="<?=$site_url?>/header_files/<?=$DATALOGO['header_logo']?>" alt="<?=$compDATA['admin_company_name']?>" title="<?=$compDATA['admin_company_name']?>" width="250" style="margin-top:-13px;">
               </a>

               <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
               <span class="navbar-toggler-icon"></span>
               </button>
               <div class="collapse navbar-collapse" id="navbarResponsive">
                  <ul class="navbar-nav mr-auto mt-2 mt-lg-0 margin-auto">
<?php
$pro_sql_header=db_query("select * from tbl_category where 1 and category_status='Active' and category_parent_id='0' order by category_order_by asc limit 6");
while($pro_res_header=mysqli_fetch_array($pro_sql_header))
{//
?>       
<li class="nav-item">
<a href="<?=$site_url?>/property.html?id=<?=$pro_res_header['category_id']?>" class="nav-link">
<?=$pro_res_header['category_name']?>
</a>           
</li>
<?}?>

<?php/*
$link_sql=db_query("select * from tbl_site_pages where 1 and site_pages_status='Active' and site_pages_show_in_header='Yes' order by site_pages_order_by asc limit 5");
if(mysqli_num_rows($link_sql)>0){
while($link_data=mysqli_fetch_array($link_sql)){
$pgName=$link_data['site_pages_link'];
if($pgName=="services")
{?>
<li class="nav-item dropdown">
<a class="nav-link dropdown-toggle" href="javascript:void(0)" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
Services
</a>
 <?php
               $pro_sql_header=db_query("select * from tbl_category where 1 and category_status='Active' and category_parent_id='0' ");
               if(mysqli_num_rows($pro_sql_header)>0)
               {
               ?>
<div class="dropdown-menu">
    <?php
while($pro_res_header=mysqli_fetch_array($pro_sql_header))
{
?>
<a class="dropdown-item" href="<?=$site_url?>/property.html?id=<?=$pro_res_header['category_id']?>"><?=$pro_res_header['category_name']?></a>
<?}?>
</div>
<?}?>
</li>
<?}else{
?>
<li class="nav-item">
<a href="<?=$site_url?>/<?=$link_data['site_pages_link']?>.html" class="nav-link">
<?=$link_data['site_pages_name']?>
</a>           
</li>
<?}?>
<?}}
*/
?>





                   <!--  <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Co-Working
                        </a>
                        <div class="dropdown-menu">
                           <a class="dropdown-item" href="#">Properties Grid</a>
                           <a class="dropdown-item" href="#">Properties List</a>
                           <a class="dropdown-item" href="#">Property Single Slider</a>
                           <a class="dropdown-item" href="#">Property Single Gallery</a>
                        </div>
                     </li>-->
					<!--
                     <li class="nav-item ">
                        <a class="nav-link" href="#">
                        Commercial
                        </a>
						
                     </li>
					 
                     <li class="nav-item">
                        <a class="nav-link" href="#">
                      Warehouse
                        </a>
						
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" href="#">
                        Furnished Office
                        </a>
                     
                     </li> -->


                  </ul>
                  <div class="my-2 my-lg-0">
                     <ul class="list-inline main-nav-right">
					
                        <li class="list-inline-item">
                           <a class="btn btn-primary btn-sm" href="tel:<?=$compDATA['admin_mobile']?>"><i class="fa fa-phone"></i> <?=$compDATA['admin_mobile']?></a>
                        </li>
                     </ul>
                  </div>
               </div>
         	</nav>
         </div>
      </header>
      <!-- End Navbar -->