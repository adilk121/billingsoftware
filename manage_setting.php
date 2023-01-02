<?php require_once("header.php");?>
<?php require_once("left-nav.php");?>


<?php

/*Extra Feature*/

if(isset($_POST['ExtraSubmit'])){
@extract($_POST);
if($admin_etrust_option!='Yes'){
    $admin_etrust_link='';
  }
  $sql="update tbl_admin set 
			admin_search_option='$admin_search_option',
			admin_language_option='$admin_language_option',
			admin_video_option='$admin_video_option',
			admin_etrust_option='$admin_etrust_option',
			admin_visitor_counter_option='$admin_visitor_counter_option',
			admin_product_option='$admin_product_option',
			admin_etrust_link='$admin_etrust_link',
				admin_whatsapp_option='$admin_whatsapp_option',
			admin_call_now_option='$admin_call_now_option',
			admin_skype_option='$admin_skype_option',
			
			admin_callback_option='$admin_callback_option',
			admin_flipbook_option='$admin_flipbook_option',
			admin_live_chat_code='$admin_live_chat_code'
			where admin_user_type='Admin'";
            db_query($sql);
    $_SESSION['msg'] = "Features Added Successfully !";
}



if(isset($_POST['FeatureSubmit'])){
@extract($_POST);

if(is_uploaded_file($_FILES['site_map_xml']['tmp_name'])){
 if($_FILES['site_map_xml']['name']=="sitemap.xml" && $_FILES['site_map_xml']['type']=="text/xml"){
       
       $site_map_xml=$_FILES['site_map_xml']['name'];
        $temp=$_FILES['site_map_xml']['tmp_name'];
        $cur=$site_map_xml;
        move_uploaded_file($temp,$cur);
        
   }else{?>
      <script>alert("Please upload correct sitemap.xml file");</script> 
<?php }
}

if(is_uploaded_file($_FILES['robots_txt']['tmp_name'])){
 if($_FILES['robots_txt']['name']=="robots.txt" && $_FILES['robots_txt']['type']=="text/plain"){ 
    
$robots_txt=$_FILES['robots_txt']['name'];
$temp2=$_FILES['robots_txt']['tmp_name'];
$cur2=$robots_txt;
move_uploaded_file($temp2,$cur2);
}else{?>
 <script>alert("Please upload correct robots.txt file");</script> 
<?php    
}
}

if(is_uploaded_file($_FILES['favicon']['tmp_name'])){
 
   if(preg_match("/\.(gif|png|jpg|jpeg)$/",$_FILES['favicon']['name']) && $_FILES['favicon']['name']=="favicon.gif" || $_FILES['favicon']['name']=="favicon.png" || $_FILES['favicon']['name']=="favicon.jpg" || $_FILES['favicon']['name']=="favicon.jpeg"){
    $old_file=db_scalar("select admin_favicon from tbl_admin where admin_user_type='Admin'");
   @unlink($old_file);
   $favicon=$_FILES['favicon']['name'];
   $temp3=$_FILES['favicon']['tmp_name'];
   $cur3=$favicon;
   move_uploaded_file($temp3,$cur3);
     db_query("update tbl_admin set admin_favicon='$favicon' where admin_user_type='Admin'");
   }else{?>
<script>alert("Please upload correct image");</script>
<?php    
}

 
}


/*if(is_uploaded_file($_FILES['favicon']['tmp_name'])){
    $old_file=db_scalar("select admin_favicon from tbl_admin where admin_user_type= 'Admin'");
    @unlink("../$old_file");
    
    $favicon=$_FILES['favicon']['name'];
    $temp3=$_FILES['favicon']['tmp_name'];
    $cur3="../".$favicon;
    move_uploaded_file($temp3,$cur3); 
    
    db_query("update tbl_admin set admin_favicon='$favicon' where admin_user_type= 'Admin'");
}*/



if($admin_is_meta_fb_id!='Yes'){
    $admin_meta_fb_id='';
  }
if($admin_is_meta_alexa_id!='Yes'){
    $admin_meta_alexa_id='';
  }
  if($admin_is_meta_msvalidate_id!='Yes'){
    $admin_meta_msvalidate_id='';
  }
  
  $sql_upd="update tbl_admin set 
			admin_index_follow='$admin_index_follow',
			admin_is_meta_fb_id='$admin_is_meta_fb_id',
			admin_meta_fb_id='$admin_meta_fb_id',
			admin_is_meta_alexa_id='$admin_is_meta_alexa_id',
			admin_meta_alexa_id='$admin_meta_alexa_id',
			admin_google_analytic_code='$admin_google_analytic_code',
			admin_site_verification_code='$admin_site_verification_code',
			admin_is_meta_msvalidate_id='$admin_is_meta_msvalidate_id',
			admin_meta_msvalidate_id='$admin_meta_msvalidate_id'
			where admin_user_type='Admin'";
            db_query($sql_upd);
            $_SESSION['msg']="Features Updated Successfully";
            /*header("location:manage_seo.php");
			exit;*/
}

 $sql="select * from tbl_admin where admin_user_type='Admin'";
 $result2=db_query($sql);
 $data_new=mysqli_fetch_array($result2);
?>


<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
<div class="header-icon">
<i class="fa fa-share-alt"></i>
</div>
<div class="header-title">
<h1>SEO & Site Features</h1>
<small>SEO & Site Features Settings</small>
</div>
  

</section>
<!-- Main content -->
<section class="content">
<div class="row">
<!-- Form controls -->

<!-- Enable/Disable SEO Feature Section START -->
<div class="col-sm-8">

<?php if($_SESSION["msg"]!=""){?>     
                      
<div class="alert alert-success alert-dismissable fade in text-center" style="background-color:#dff0d8;border:none; color:#000;margin:10px 0 10px 0">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Success!&nbsp;&nbsp;&nbsp;</strong> <?=$_SESSION["msg"]?>.
  </div>
<?php 
unset($_SESSION["msg"]);
}?> 

<div class="panel panel-bd lobidrag" data-edit-title='false' data-close='false' data-reload='false'>
<div class="panel-heading">
<div class="btn-group" id="buttonexport">
  <a href="#">
     <h4 style="color:grey !important;"></h4>Enable/Disable SEO & Site Features</h4>
  </a>
</div>
</div>
<div class="panel-body">
<form class="col-sm-12" enctype="multipart/form-data" method="post">
  
<div class="form-group col-lg-10">
<div class="row">
<div class="col-lg-5">
<label><i class="fa fa-angle-double-right " style="color:#3c5997; font-size:20px"></i>
Enable Index,Follow &nbsp;&nbsp;&nbsp;:</label>
</div>
<div class="col-lg-7">
<input style="width:20px;height:20px;" type="checkbox" value="Yes" name="admin_index_follow" id="admin_facebook_link" <?php if($data_new['admin_index_follow']=='Yes') {?> checked="checked" <?php }?> />
</div>
</div>
</div>

<div class="form-group col-lg-10">
<div class="row">
<div class="col-lg-5">
<label><i class="fa fa-angle-double-right " style="color:#3c5997; font-size:20px"></i>
Upload Sitemap XML &nbsp;&nbsp;&nbsp;:</label>
</div>
<div class="col-lg-7">
<input type="file" class="form-control" name="site_map_xml" id="site_map_xml" />
</div>
</div>
</div>

<div class="form-group col-lg-10">
<div class="row">
<div class="col-lg-5">
<label><i class="fa fa-angle-double-right " style="color:#3c5997; font-size:20px"></i>
Upload Robots TXT &nbsp;&nbsp;&nbsp;:</label>
</div>
<div class="col-lg-7">
<input type="file" class="form-control" name="robots_txt" id="robots_txt" />
</div>
</div>
</div>

<div class="form-group col-lg-10">
<div class="row">
<div class="col-lg-5">
<label><i class="fa fa-angle-double-right " style="color:#3c5997; font-size:20px"></i>
Upload Favicon &nbsp;&nbsp;&nbsp;:</label>
</div>
<div class="col-lg-7">
<input type="file" class="form-control" name="favicon" id="favicon" />
</div>
</div>
</div>

<!--<div class="form-group col-lg-10">
<div class="row">
<div class="col-lg-5">
<label><i class="fa fa-angle-double-right " style="color:#3c5997; font-size:20px"></i>
FB Page ID &nbsp;&nbsp;&nbsp;:</label>
</div>
<div class="col-lg-7">
<input style="width:20px;height:20px;" type="checkbox" value="Yes" name="admin_is_meta_fb_id" id="admin_is_meta_fb_id" <?php if($data_new['admin_is_meta_fb_id']=='Yes') {?> checked="checked" <?php }?> />
</div>
</div>
</div>-->

<div class="form-group col-lg-10">
<div class="row">
<div class="col-lg-5">
    &nbsp;&nbsp;
<label><i class="fa fa-angle-right " style="color:#3c5997; font-size:20px"></i>
FB Page Id &nbsp;&nbsp;&nbsp;:</label>
</div>
<div class="col-lg-7">
<input type="text" class="form-control" name="admin_meta_fb_id" id="admin_meta_fb_id" value="<?=$data_new['admin_meta_fb_id']?>" /> 
</div>
</div>
</div>

<!--<div class="form-group col-lg-10">
<div class="row">
<div class="col-lg-5">
<label><i class="fa fa-angle-double-right " style="color:#3c5997; font-size:20px"></i>
Alexa Verify Id &nbsp;&nbsp;&nbsp;:</label>
</div>
<div class="col-lg-7">
<input style="width:20px;height:20px;" type="checkbox" value="Yes" name="admin_is_meta_alexa_id" id="admin_is_meta_alexa_id" <?php if($data_new['admin_is_meta_alexa_id']=='Yes') {?> checked="checked" <?php }?> />
</div>
</div>
</div>-->
                              
<div class="form-group col-lg-10">
<div class="row">
<div class="col-lg-5">
    &nbsp;&nbsp;
<label><i class="fa fa-angle-right " style="color:#3c5997; font-size:20px"></i>
Alexa Verify Id &nbsp;&nbsp;&nbsp;:</label>
</div>
<div class="col-lg-7">
<input type="text" class="form-control" name="admin_meta_alexa_id" id="admin_meta_alexa_id" value="<?=$data_new['admin_meta_alexa_id']?>" /> 
</div>
</div>
</div>                              


<!--<div class="form-group col-lg-10">
<div class="row">
<div class="col-lg-5">
<label><i class="fa fa-angle-double-right " style="color:#3c5997; font-size:20px"></i>
MS Validate &nbsp;&nbsp;&nbsp;:</label>
</div>
<div class="col-lg-7">
<input style="width:20px;height:20px;" type="checkbox" value="Yes" name="admin_is_meta_msvalidate_id" id="admin_is_meta_msvalidate_id" <?php if($data_new['admin_is_meta_msvalidate_id']=='Yes') {?> checked="checked" <?php }?> />
</div>
</div>
</div>-->

<div class="form-group col-lg-10">
<div class="row">
<div class="col-lg-5">
    &nbsp;&nbsp;
<label><i class="fa fa-angle-right " style="color:#3c5997; font-size:20px"></i>
MS Validate Id &nbsp;&nbsp;&nbsp;:</label>
</div>
<div class="col-lg-7">
<input type="text" class="form-control" name="admin_meta_msvalidate_id" id="admin_meta_msvalidate_id" value="<?=$data_new['admin_meta_msvalidate_id']?>" /> 
</div>
</div>
</div>

<div class="form-group col-lg-10">
<div class="row">
<div class="col-lg-5">
   
<label><i class="fa fa-angle-double-right " style="color:#3c5997; font-size:20px"></i>
Site Verification Code &nbsp;&nbsp;&nbsp;:</label>
</div>
<div class="col-lg-7">
<input type="text" class="form-control" name="admin_site_verification_code" id="admin_site_verification_code" value="<?=$data_new['admin_site_verification_code']?>" /> 
 <span style="font-size:11px; color:#f40b0b; ">( e.g. MIi7IWVh6w09Va41EiiYgMHxbPaG-1lOiyj8rc8t-2g )</span>
</div>
</div>
</div>

<div class="form-group col-lg-10">
<div class="row">
<div class="col-lg-5">
   
<label><i class="fa fa-angle-double-right " style="color:#3c5997; font-size:20px"></i>
Google Analytic Code &nbsp;&nbsp;&nbsp;:</label>
</div>
<div class="col-lg-7">
<textarea style="resize:none;" name="admin_google_analytic_code" class="form-control" rows="6" col="2"><?=$data_new['admin_google_analytic_code']?></textarea> 

</div>
</div>
</div>

  
  <div class="col-lg-12 reset-button text-center" >
  <button type="submit" name="FeatureSubmit"  class="btn btn-add">Save</button>
  </div>
</form>
</div>
</div>

</div>
<!-- Enable/Disable SEO Feature Section END -->


<div class="col-sm-4">

<?php if($_SESSION["msg"]!=""){?>     
                      
<div class="alert alert-success alert-dismissable fade in text-center" style="background-color:#dff0d8;border:none; color:#000;margin:10px 0 10px 0">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Success!&nbsp;&nbsp;&nbsp;</strong> <?=$_SESSION["msg"]?>.
  </div>
<?php 
unset($_SESSION["msg"]);
}?> 

<div class="panel panel-bd lobidrag" data-edit-title='false' data-close='false' data-reload='false'>
<div class="panel-heading">
<div class="btn-group" id="buttonexport">
  <a href="#">
     <h4 style="color:grey !important;"></h4>Enable/Disable SEO & Site Features</h4>
  </a>
</div>
</div>
<div class="panel-body">
<form class="col-sm-12" enctype="multipart/form-data" method="post">
  
<!--<div class="form-group col-lg-12">
<div class="row">
<div class="col-lg-8" style="padding-left:0px;">
<label style="font-size:14px"><i class="fa fa-angle-double-right " style="color:#3c5997; font-size:18px"></i>
Search option :</label>
</div>
<div class="col-lg-4">
<input style="width:18px;height:18px;" type="checkbox" value="Yes" name="admin_search_option" id="admin_search_option" <?php if($data_new['admin_search_option']=='Yes') {?> checked="checked" <?php }?> />
</div>
</div>
</div>-->

<!--<div class="form-group col-lg-12">
<div class="row">
<div class="col-lg-8" style="padding-left:0px;">
<label style="font-size:14px"><i class="fa fa-angle-double-right " style="color:#3c5997; font-size:18px"></i>
E-Trust :</label>
</div>
<div class="col-lg-4">
<input style="width:18px;height:18px;" type="checkbox" value="Yes" name="admin_etrust_option" id="admin_etrust_option" <?php if($data_new['admin_etrust_option']=='Yes') {?> checked="checked" <?php }?> />
</div>
</div>
</div>-->

<!--<div class="form-group col-lg-12">
<div class="row">
<div class="col-lg-12" style="padding-left:0px;">
<label style="font-size:14px"><i class="fa fa-angle-double-right " style="color:#3c5997; font-size:18px"></i>
Enter E-Trust Link :</label>
</div>
</div>
</div>

<div class="form-group col-lg-12">
<div class="row">
<div class="col-lg-12" style="padding-left:0px;">
<input type="text" value="<?=$data_new['admin_etrust_link']?>" name="admin_etrust_link" id="admin_etrust_link" class="form-control" />
</div>
</div>
</div>-->

<div class="form-group col-lg-12">
<div class="row">
<div class="col-lg-8" style="padding-left:0px;">
<label style="font-size:14px"><i class="fa fa-angle-double-right " style="color:#3c5997; font-size:18px"></i>
Visitor Counter :</label>
</div>
<div class="col-lg-4">
<input style="width:18px;height:18px;" type="checkbox" value="Yes" name="admin_visitor_counter_option" id="admin_visitor_counter_option" <?php if($data_new['admin_visitor_counter_option']=='Yes') {?> checked="checked" <?php }?> />
</div>
</div>
</div>

<!--<div class="form-group col-lg-12">
<div class="row">
<div class="col-lg-8" style="padding-left:0px;">
<label style="font-size:14px"><i class="fa fa-angle-double-right " style="color:#3c5997; font-size:18px"></i>
Products :</label>
</div>
<div class="col-lg-4">
<input style="width:18px;height:18px;" type="radio" value="Yes" name="admin_product_option" id="admin_product_option" <?php if($data_new['admin_product_option']=='Yes') {?> checked="checked" <?php }?> />
</div>
</div>
</div>-->

<!--<div class="form-group col-lg-12">
<div class="row">
<div class="col-lg-8" style="padding-left:0px;">
<label style="font-size:14px"><i class="fa fa-angle-double-right " style="color:#3c5997; font-size:18px"></i>
Services :</label>
</div>
<div class="col-lg-4">
<input style="width:18px;height:18px;" type="radio" value="No" name="admin_product_option" id="admin_product_option" <?php if($data_new['admin_product_option']=='No') {?> checked="checked" <?php }?> />
</div>
</div>
</div>-->

<div class="form-group col-lg-12">
<div class="row">
<div class="col-lg-8" style="padding-left:0px;">
<label style="font-size:14px"><i class="fa fa-angle-double-right " style="color:#3c5997; font-size:18px"></i>
Language Converter :</label>
</div>
<div class="col-lg-4">
<input style="width:18px;height:18px;" type="checkbox" value="Yes" name="admin_language_option" id="admin_language_option" <?php if($data_new['admin_language_option']=='Yes') {?> checked="checked" <?php }?> />
</div>
</div>
</div>
                              
<!--<div class="form-group col-lg-12">
<div class="row">
<div class="col-lg-8" style="padding-left:0px;">
<label style="font-size:14px"><i class="fa fa-angle-double-right " style="color:#3c5997; font-size:18px"></i>
Video :</label>
</div>
<div class="col-lg-4">
<input style="width:18px;height:18px;" type="checkbox" value="Yes" name="admin_video_option" id="admin_video_option" <?php if($data_new['admin_video_option']=='Yes') {?> checked="checked" <?php }?> />
</div>
</div>
</div>

<div class="form-group col-lg-12">
<div class="row">
<div class="col-lg-8" style="padding-left:0px;">
<label style="font-size:14px"><i class="fa fa-angle-double-right " style="color:#3c5997; font-size:18px"></i>
Flip Book :</label>
</div>
<div class="col-lg-4">
<input style="width:18px;height:18px;" type="checkbox" value="Yes" name="admin_flipbook_option" id="admin_flipbook_option" <?php if($data_new['admin_flipbook_option']=='Yes') {?> checked="checked" <?php }?> />
</div>
</div>
</div>-->

<div class="form-group col-lg-12">
<div class="row">
<div class="col-lg-8" style="padding-left:0px;">
<label style="font-size:14px"><i class="fa fa-angle-double-right " style="color:#3c5997; font-size:18px"></i>
Visible WhatsApp Icon :</label>
</div>
<div class="col-lg-4">
<input style="width:18px;height:18px;" type="checkbox" value="Yes" name="admin_whatsapp_option" id="admin_whatsapp_option" <?php if($data_new['admin_whatsapp_option']=='Yes') {?> checked="checked" <?php }?> />
</div>
</div>
</div>

<div class="form-group col-lg-12">
<div class="row">
<div class="col-lg-8" style="padding-left:0px;">
<label style="font-size:14px"><i class="fa fa-angle-double-right " style="color:#3c5997; font-size:18px"></i>
Call Now :</label>
</div>
<div class="col-lg-4">
<input style="width:18px;height:18px;" type="checkbox" value="Yes" name="admin_call_now_option" id="admin_call_now_option" <?php if($data_new['admin_call_now_option']=='Yes') {?> checked="checked" <?php }?> />
</div>
</div>
</div>

<div class="form-group col-lg-12">
<div class="row">
<div class="col-lg-8" style="padding-left:0px;">
<label style="font-size:14px"><i class="fa fa-angle-double-right " style="color:#3c5997; font-size:18px"></i>
Show Call Back :</label>
</div>
<div class="col-lg-4">
<input style="width:18px;height:18px;" type="checkbox" value="Yes" name="admin_callback_option" id="admin_callback_option" <?php if($data_new['admin_callback_option']=='Yes') {?> checked="checked" <?php }?> />
</div>
</div>
</div>

<div class="form-group col-lg-12">
<div class="row">
<div class="col-lg-8" style="padding-left:0px;">
<label style="font-size:14px"><i class="fa fa-angle-double-right " style="color:#3c5997; font-size:18px"></i>
Skype Feature :</label>
</div>
<div class="col-lg-4">
<input style="width:18px;height:18px;" type="checkbox" value="Yes" name="admin_skype_option" id="admin_skype_option" <?php if($data_new['admin_skype_option']=='Yes') {?> checked="checked" <?php }?> />
</div>
</div>
</div>

<div class="form-group col-lg-12">
<div class="row">
<div class="col-lg-12" style="padding-left:0px;">
<label style="font-size:14px"><i class="fa fa-angle-double-right " style="color:#3c5997; font-size:18px"></i>
Live Chat Link :</label>
</div>
</div>
</div>

<div class="form-group col-lg-12">
<div class="row">
<div class="col-lg-12" style="padding-left:0px;">
<input type="text" value="<?=$data_new['admin_live_chat_code']?>" name="admin_live_chat_code" id="admin_live_chat_code" class="form-control" />
</div>
</div>
</div>

  
  <div class="col-lg-12 reset-button text-center" >
  <button type="submit" name="ExtraSubmit"  class="btn btn-add">Save</button>
  </div>
</form>
</div>
</div>

</div>


</div>
</section>
<!-- /.content -->
</div>
<?php require_once("footer.php"); ?>
<script type="text/javascript">
function nospaces(t){
if(t.value.match(/\s/g)){
alert('Sorry, you are not allowed to enter any spaces');
t.value=t.value.replace(/\s/g,'');
}
}
</script>