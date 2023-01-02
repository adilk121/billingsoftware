<?php require_once("header.php");?>
<?php require_once("left-nav.php");?>
<style>
/* enable absolute positioning */
.inner-addon { 
    position: relative; 
}

/* style icon */
.inner-addon .fa {
  position: absolute;
  padding: 8px 10px 10px 10px;
  pointer-events: none;
}

/* align icon */
.left-addon .fa  { left:  0px;}
.right-addon .fa{ right: 0px;}

/* add padding  */
.left-addon input  { padding-left:  60px;vertical-align:middle;height:40px }
.right-addon input { padding-right: 60px; }
</style>

<?php
if(isset($_POST['ContactUpdate'])){
    @extract($_POST);
	$sql="update tbl_admin set 
	             admin_facebook_link='$admin_facebook_link',
	             admin_twitter_link='$admin_twitter_link',
	             admin_linkedin_link='$admin_linkedin_link',
      				 admin_instagram_link='$admin_instagram_link',
               admin_pinterest_link='$admin_pinterest_link',
               admin_youtube_link='$admin_youtube_link',
      				 admin_whatsapp_link='$admin_whatsapp_link'
				 where admin_user_type='Admin'";
				 
	db_query($sql);
	             $_SESSION['msg']="Social links are updated successfully !";
				 header("location:manage_social_links.php");
				 exit;
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
                  <h1>Social Links</h1>
                  <small>Social Links Settings</small>
               </div>
               
               
               


            </section>
            <!-- Main content -->
            <section class="content">
               <div class="row">
                  <!-- Form controls -->
                  <div class="col-sm-12">
                  
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
               <h4>General Settings</h4>
            </a>
         </div>
      </div>
      <div class="panel-body">
         <form class="col-sm-12" enctype="multipart/form-data" method="post">
            
            <div class="form-group col-lg-6">
              
              <div class="inner-addon left-addon">
<i class="fa fa-facebook-square" style="color:#3c5997; font-size:28px"></i>
<input type="text" class="form-control" placeholder="Enter facebook link here" value="<?=$data_new['admin_facebook_link']?>" name="admin_facebook_link" id="admin_facebook_link" />
</div>
              
                              </div>
                              
                              
<div class="form-group col-lg-6">
  
  <div class="inner-addon left-addon">
<i class="fa fa-twitter-square" style="color:#06C; font-size:28px"></i>
<input type="text" class="form-control" placeholder="Enter twitter link here" value="<?=$data_new['admin_twitter_link']?>" name="admin_twitter_link" id="admin_twitter_link" />
</div>
  
</div>

                                                            
<div class="form-group col-lg-6">

<div class="inner-addon left-addon">
<i class="fa fa-linkedin-square" style="color:#0077b5; font-size:28px"></i>
<input type="text" class="form-control" placeholder="Enter linkedin link here" value="<?=$data_new['admin_linkedin_link']?>" name="admin_linkedin_link" id="admin_linkedin_link" />
</div>

</div>
         
                              
<div class="form-group col-lg-6">

<div class="inner-addon left-addon">
<i class="fa fa-instagram" style="color:#FF66FF; font-size:28px"></i>
<input type="text" class="form-control" placeholder="Enter Instagram link here" value="<?=$data_new['admin_instagram_link']?>" name="admin_instagram_link" id="admin_instagram_link" />
</div>

</div>

<div class="form-group col-lg-6">

<div class="inner-addon left-addon">
<i class="fa fa-pinterest" style="color:#d00729; font-size:28px"></i>
<input type="text" class="form-control" placeholder="Enter Pinterest link here" value="<?=$data_new['admin_pinterest_link']?>" name="admin_pinterest_link" id="admin_pinterest_link" />
</div>

</div>

<div class="form-group col-lg-6">

<div class="inner-addon left-addon">
<i class="fa fa-youtube" style="color:#d00729; font-size:28px"></i>
<input type="text" class="form-control" placeholder="Enter Youtube link here" value="<?=$data_new['admin_youtube_link']?>" name="admin_youtube_link" id="admin_youtube_link" />
</div>

</div>

                              
<!--  <div class="form-group col-lg-6">
                                
                                <div class="inner-addon left-addon">
    <i class="fa fa-whatsapp" style="color:#00CC33; font-size:28px"></i>
    <input type="text" class="form-control" placeholder="Enter Whatsapp link here" value="<?=$data_new['admin_whatsapp_link']?>" name="admin_whatsapp_link" id="admin_whatsapp_link" />
</div>
                                
                              </div>     -->                                                        
                              
                              
                             
                              
                              
                              <div class="col-lg-12 reset-button text-center" >
                              <button type="submit" name="ContactUpdate"  class="btn btn-add">Save</button>
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