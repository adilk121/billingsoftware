<?php require_once("header.php");?>
<?php require_once("left-nav.php");?>
<link href="assets/plugins/icheck/skins/all.css" rel="stylesheet" type="text/css"/>
<link href="assets/plugins/bootstrap-toggle/bootstrap-toggle.min.css" rel="stylesheet" type="text/css"/>
<?php
$site_pages_id = $_GET['site_pages_id'];

if($_REQUEST['delImage']!=""){
$isDel=db_query("UPDATE  tbl_site_pages SET  site_pages_image_name='' WHERE 1 and site_pages_id = '$site_pages_id'"); 
@unlink("../static_files/$_REQUEST[delImage]");
header("location:static_page_f.php?site_pages_id=$site_pages_id");
}

if(is_post_back()) {
 if($site_pages_name=='Home'){
  $pg_url='index';
 }else{
$pg_url=ami_crete_url($site_pages_name);
}
$ordBY=db_scalar("select MAX(site_pages_order_by) from tbl_site_pages where 1");
$ordBY=$ordBY+1;
  if($site_pages_id!='') {
    ////////////****************** IMAGE RESIZING START HERE *****************************//
//********** Code Created By Amitabh Kumar Sinha : Web Developer : Webkey Network Pvt. Ltd. *****************//
//**********  DATE : 31:07:2014 *****************//
//------------FUNCTION TO GET IMAGE EXTENSION START---------------//
 function getExtension($str) {
         $i = strrpos($str,".");
         if (!$i) { return ""; }
         $l = strlen($str) - $i;
         $ext = substr($str,$i+1,$l);
         return $ext;
 }
 //------------FUNCTION TO GET IMAGE EXTENSION END---------------//
  $image =$_FILES["file"]["name"];
  $uploadedfile = $_FILES['file']['tmp_name']; 
  if ($image) {   
      $DelImage=db_scalar("select site_pages_image_name from tbl_site_pages where 1 and site_pages_id = '$site_pages_id'");
      @unlink("../static_files/$DelImage");
    $filename = stripslashes($_FILES['file']['name']);  
      $extension = getExtension($filename);
    $extension = strtolower($extension);    
    $imgNAME = $pg_url.".".$extension;

move_uploaded_file($_FILES['file']['tmp_name'],"../static_files/$imgNAME");
}else{
$imgNAME=db_scalar("select site_pages_image_name from tbl_site_pages where 1 and site_pages_id = '$site_pages_id'");
}

////////////****************** IMAGE RESIZING END HERE *****************************//
   echo  $sqlupdate = "update tbl_site_pages set 
                     site_pages_name='$site_pages_name', 
             site_pages_title='$site_pages_title',
             site_pages_url='$pg_url',
             site_pages_image_name='$imgNAME',
             site_pages_meta_title = '$site_pages_meta_title',
             site_pages_link='$site_pages_link',
             site_pages_meta_description='$site_pages_meta_description',
             site_pages_meta_keyword='$site_pages_meta_keyword',
             site_pages_description='$site_pages_description',
             site_pages_show_in_header='$show_in_header',
             site_pages_show_in_footer='$show_in_footer',
             site_pages_add_date='$curr_date',
             site_pages_status='$site_pages_status'  
             where site_pages_id = '$site_pages_id' ";
      
  
                     db_query($sqlupdate);
             set_session_msg("Page Updated Successfully !");
    }else{
      //*************** INSERT NEW CATEGORY START ************************//
////////////****************** IMAGE RESIZING START HERE *****************************//
//********** Code Created By Amitabh Kumar Sinha : Web Developer : Webkey Network Pvt. Ltd. *****************//
//**********  DATE : 31:07:2014 *****************//
//------------FUNCTION TO GET IMAGE EXTENSION START---------------//
 function getExtension($str) {
         $i = strrpos($str,".");
         if (!$i) { return ""; }
         $l = strlen($str) - $i;
         $ext = substr($str,$i+1,$l);
         return $ext;
 }
 //------------FUNCTION TO GET IMAGE EXTENSION END---------------//
  $image =$_FILES["file"]["name"];
  $uploadedfile = $_FILES['file']['tmp_name']; 
  if ($image) {   
    $filename = stripslashes($_FILES['file']['name']);  
      $extension = getExtension($filename);
    $extension = strtolower($extension);
    $imgNAME = $pg_url.".".$extension;    


move_uploaded_file($_FILES['file']['tmp_name'],"../static_files/$imgNAME");
}

////////////****************** IMAGE RESIZING END HERE *****************************//
    $dupliDataCount=db_scalar("select count(*) from tbl_site_pages where 1 and site_pages_name='$site_pages_name'");
 if($dupliDataCount =='0'){
     $sqlinsert = "insert into tbl_site_pages set 
                      site_pages_name='$site_pages_name',
              site_pages_title='$site_pages_title',             
              site_pages_image_name='$imgNAME',
              site_pages_url='$pg_url',
              site_pages_link='$site_pages_link',
            site_pages_show_in_header='$show_in_header',
             site_pages_show_in_footer='$show_in_footer',
              site_pages_meta_title = '$site_pages_meta_title',
              site_pages_meta_description='$site_pages_meta_description',
              site_pages_meta_keyword='$site_pages_meta_keyword',
              site_pages_description='$site_pages_description',
              site_pages_order_by='$ordBY',
              site_pages_add_date='$curr_date',
              site_pages_status='$site_pages_status' ";
                      db_query($sqlinsert);
              set_session_msg("Page Added Successfully !");
                }else{   
                        set_session_msg("Sorry! page name is already exist !"); 
  }
  }
  header("Location: static_page_list.php");
  exit;
  
}
if($site_pages_id!=''){
  $sql="select * from tbl_site_pages where site_pages_id = '$site_pages_id'"; 
  $result = db_query($sql);
  if ($line_raw = mysqli_fetch_array($result)) {
    $line = ms_form_value($line_raw);
    @extract($line);
  }
}
?>


         <!-- Content Wrapper. Contains page content -->
         <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
               <div class="header-icon">
                  <i class="fa fa-file-text"></i>
               </div>
               <div class="header-title">
                  <h1>Edit Page</h1>
                  <small>Edit Page Content</small>
                  
                  
<a href="static_page_list.php"><button id="btn-go-back" type="button" class="btn btn-labeled btn-inverse m-b-5 pull-right">
<span class="btn-label" ><i class="fa fa-chevron-circle-left"></i></span>Go Back
</button></a>

                  
               </div>
               
               
            </section>
            <script type="text/javascript">
function formValidation(){
if(document.getElementById('site_pages_link').value==0){
  alert("Select page link !");
  document.getElementById('site_pages_link').focus();
  return false;
 }

}
</script>
            <!-- Main content -->
<script src="ckeditor/ckeditor.js"></script>            
            <section class="content">
               <div class="row">
                  <!-- Form controls -->
                  <div class="col-sm-12">
                     <div class="panel panel-bd lobidrag" data-edit-title='false' data-close='false' data-reload='false'>
                        <div class="panel-heading">
                           <div class="btn-group" id="buttonexport">
                              <a href="#">
                                 <h4>General Information</h4>
                              </a>
                           </div>
                        </div>
                        <div class="panel-body">
<form name="form1" method="post" onsubmit="return formValidation()" enctype="multipart/form-data" class="col-sm-12" >
                              <div class="form-group col-lg-6">
                                 <label>Page Name</label>
<input type="text" class="form-control" placeholder="Enter Name" name="site_pages_name" id="site_pages_name"  value="<?=$site_pages_name?>">
                              </div>
<div class="form-group col-lg-6">
<label>Page Link</label>
<!-- <input type="text" class="form-control" placeholder="Enter Title" name="site_pages_title" id="site_pages_title" value="<?=$site_pages_title?>" > -->  
    <select name="site_pages_link" id="site_pages_link" class="form-control" >
          <option value="">Select Page Link</option>
          <option value="index" <?php if($site_pages_link=='index'){ ?> selected="selected" <? } ?>>index.php</option>
          <option value="about-us" <?php if($site_pages_link=='about-us'){ ?> selected="selected" <? } ?>>about-us.php</option>
          <option value="contact-us" <?php if($site_pages_link=='contact-us'){ ?> selected="selected" <? } ?>>contact-us.php</option>
          <option value="enquiry" <?php if($site_pages_link=='enquiry'){ ?> selected="selected" <? } ?>>enquiry.php</option>
           <option value="services" <?php if($site_pages_link=='services'){ ?> selected="selected" <? } ?>>services.php</option>    
           <option value="property" <?php if($site_pages_link=='property'){ ?> selected="selected" <? } ?>>property.php</option>    



         <!--  <option value="dashboard" <?php if($site_pages_link=='dashboard'){ ?> selected="selected" <? } ?>>dashboard.php</option>
          <option value="privacy-policy" <?php if($site_pages_link=='privacy-policy'){ ?> selected="selected" <? } ?>>privacy-policy.php</option>

          <option value="register" <?php if($site_pages_link=='register'){ ?> selected="selected" <? } ?>>register.php</option>
          <option value="login" <?php if($site_pages_link=='login'){ ?> selected="selected" <? } ?>>login.php</option>
          
          <option value="cart" <?php if($site_pages_link=='cart'){ ?> selected="selected" <? } ?>>cart.php</option>
          <option value="checkout" <?php if($site_pages_link=='checkout'){ ?> selected="selected" <? } ?>>checkout.php</option>
          <option value="wishlist" <?php if($site_pages_link=='wishlist'){ ?> selected="selected" <? } ?>>wishlist.php</option>
          <option value="category" <?php if($site_pages_link=='category'){ ?> selected="selected" <? } ?>>category.php</option>
             <option value="products" <?php if($site_pages_link=='products'){ ?> selected="selected" <? } ?>>products.php</option>
          <option value="faq" <?php if($site_pages_link=='faq'){ ?> selected="selected" <? } ?>>faq.php</option> -->
          



    <!--       <option value="gallery" <?php if($site_pages_link=='gallery'){ ?> selected="selected" <? } ?>>gallery.php</option>


          <option value="video" <?php if($site_pages_link=='video'){ ?> selected="selected" <? } ?>>video.php</option>
   
          <option value="blog" <?php if($site_pages_link=='blog'){ ?> selected="selected" <? } ?>>blog.php</option>
 -->


        <!--   <option value="enquiry" <?php if($site_pages_link=='enquiry'){ ?> selected="selected" <? } ?>>enquiry.php</option>
       
               
          <option value="current-jobs" <?php if($site_pages_link=='current-jobs'){ ?> selected="selected" <? } ?>>current-jobs.php</option>
          <option value="testimonial" <?php if($site_pages_link=='testimonial'){ ?> selected="selected" <? } ?>>testimonial.php</option>
          <option value="press-release" <?php if($site_pages_link=='press-release'){ ?> selected="selected" <? } ?>>press-release.php</option>
          <option value="site-map" <?php if($site_pages_link=='site-map'){ ?> selected="selected" <? } ?>>site-map.php</option>
          <option value="certificates" <?php if($site_pages_link=='certificates'){ ?> selected="selected" <? } ?>>certificates.php</option>
          <option value="client-logos" <?php if($site_pages_link=='client-logos'){ ?> selected="selected" <? } ?>>client-logos.php</option>
          <option value="quality-assurance" <?php if($site_pages_link=='quality-assurance'){ ?> selected="selected" <? } ?>>quality-assurance.php</option>
          <option value="download-catalog" <?php if($site_pages_link=='download-catalog'){ ?> selected="selected" <? } ?>>download-catalog.php</option> -->
          </select>

        
                             </div>
                             
 <?php if($site_pages_link=='about-us'){ ?>
                            
<div class="form-group col-lg-3">
<label>Page Image</label>
<?php if($site_pages_image_name!=""){ ?>
<img src="../static_files/<?=$site_pages_image_name?>" class="form-control" style="width:170px;height:200px" />
<?php }else{?>
<img src="assets/dist/img/no-image.jpg" class="form-control" style="width:170px;height:200px" />
<?php }?>

<?php if($site_pages_image_name!=""){ ?>
<div class="col-lg-12 " ><a href="static_page_f.php?delImage=<?=$site_pages_image_name?>&site_pages_id=<?=$site_pages_id?>" style="font-weight:600;margin-left:15px;text-decoration:underline" >Remove Image</a>                  
</div>
<?php }?>

</div>

<div class="form-group col-lg-9" style="padding-top:100px">
<input type="file" name="file" id="file" />
</div>
<?php }?>


                                                          
                            
                             
                             <div class="form-group col-lg-12">
                                 <label>Page Content</label>
 <textarea class="form-control" name="site_pages_description" rows="3" id="editor1"><?=$site_pages_description?></textarea>
                              </div>
                             
<script>

// Replace the <textarea id="editor"> with an CKEditor
// instance, using default configurations.
CKEDITOR.replace( 'editor1');

</script>
                           
                           
<div class="form-group col-lg-3">
<select name="site_pages_status" class="form-control" >
                      <option value="Active" <?php if($site_pages_status=='Active'){ ?> selected="selected" <? } ?>>Active</option>
                      <option value="Inactive" <?php if($site_pages_status=='Inactive'){ ?> selected="selected" <? } ?>>Inactive</option>
                    </select>


</div>                             
       
       <div class="form-group col-lg-3">
<select name="show_in_header" class="form-control" >
  <option value="">Header</option>
<option value="Yes" <?php if($site_pages_show_in_header=='Yes'){ ?> selected="selected" <? } ?>>Show in header</option>
<option value="No" <?php if($site_pages_show_in_header=='No'){ ?> selected="selected" <? } ?>>Not show in header</option>
</select>


</div>  
<div class="form-group col-lg-3">
<select name="show_in_footer" class="form-control" >
  <option value="">Footer</option>
<option value="Yes" <?php if($site_pages_show_in_footer=='Yes'){ ?> selected="selected" <? } ?>>Show in footer</option>
<option value="No" <?php if($site_pages_show_in_footer=='No'){ ?> selected="selected" <? } ?>>Not show in footer</option>
</select>


</div>  


<?php if($_SESSION['sess_admin_type']=="Admin"){ ?>
<div class="col-lg-12" style="padding:0;background-color:#e8f1f3;margin:20px 0 50px 0">
                           <div class="btn-group" id="buttonexport">
                              <a href="#" >
                                 <h4 style="color:#000;font-weight:600;padding:5px">SEO Related Information</h4>
                              </a>
                           </div>
                        </div>                             
                             
                             
                              <div class="form-group col-lg-12">
                                 <label>Page Meta Title</label>
<textarea class="form-control" rows="3" name="site_pages_meta_title" id="site_pages_meta_title" placeholder="Enter page meta title here" ><?=$site_pages_meta_title?></textarea>
                              </div>
                              <div class="form-group col-lg-12">
                                 <label>Page Meta Description</label>
<textarea class="form-control" rows="3" placeholder="Enter page meta description here" name="site_pages_meta_description" id="site_pages_meta_description"><?=$site_pages_meta_description?></textarea>
                              </div>
                              <div class="form-group col-lg-12">
                                 <label>Page Meta Keyword</label>
<textarea class="form-control" rows="3" name="site_pages_meta_keyword" placeholder="Enter page meta keywords here" id="site_pages_meta_keyword"><?=$site_pages_meta_keyword?></textarea>
                              </div> 
                              <?}?>
                              
                              
                             
                              <div class="col-lg-12 reset-button">
                                                                 
                                 <button type="submit" class="btn btn-add">Save</button>
                                
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
 