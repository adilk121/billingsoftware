<?php require_once("header.php");?>
<?php require_once("left-nav.php");?>
<?php require_once ('../includes/photoshop.php');?>
<?php
$news_id=trim($_REQUEST['id']);
$newsID = trim($_GET['news_id']);

if($_REQUEST['delImage']!=""){

$delImage=$_REQUEST['delImage'];	
$isDel=db_query("UPDATE  tbl_news SET  news_image_name='' WHERE 1 and news_id = '$newsID'");	
@unlink("../uploaded_files/$delImage");
@unlink("../uploaded_files/home_cat_thumb/$delImage");

header("location:add-edit-news.php?id=$newsID");
}

if(is_post_back()){
//*************** UPDATE EXISTING CATEGORY START ************************//
$imgNAME ="";
if($_REQUEST['id']!='0') {
$category_url=ami_crete_url($news_given_by);
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
if($_SERVER["REQUEST_METHOD"] == "POST") {
  
$image =$_FILES["file"]["name"];
$imgToDel=db_scalar("SELECT news_image_name FROM  tbl_news WHERE  news_id='$news_id'");	

if($image){

@unlink("../news_images/$imgToDel");
@unlink("../news_images/thumb/$imgToDel");

	
	$uploadedfile = $_FILES['file']['tmp_name']; 
    $filename = stripslashes($_FILES['file']['name']); 	
	$extension = getExtension($filename);
	$extension = strtolower($extension);		
	$imgNAME = substr(md5($category_url.time().rand(1,10)),0,14).".".$extension;	
	move_uploaded_file($_FILES['file']['tmp_name'],"../news_images/$imgNAME");

///////////////////////////// FOR SMALL  THUMB AND LARGE IMAGE /////////////////////////
$image = new Zebra_Image(); 
$image->source_path = '../news_images/'.$imgNAME; 
$ext = substr($image->source_path, strrpos($image->source_path, '.') + 1);
// indicate a target image
$image->target_path = '../news_images/thumb/'.$imgNAME;
// resize
// and if there is an error, show the error message
if (!$image->resize(75, 75, ZEBRA_IMAGE_BOXED, -1)) show_error($image->error, $image->source_path, $image->target_path);

}else{
$imgNAME=$imgToDel;
}

}

////////////****************** IMAGE RESIZING END HERE *****************************//

$sql = "update  tbl_news set        
				news_given_by='$news_given_by',
				news_title='$news_title',
				news_comp_name='$news_comp_name',
				news_image_name='$imgNAME',
				news_description='$news_description', 	
				news_add_date='$curr_date',
				news_status='$news_status'
				where news_id = '$news_id' ";

db_query($sql);


$_SESSION["msg"]="News updated successfully !";
header("Location:add-edit-news.php?id=$_REQUEST[id]");
exit;
//*************** UPDATE EXISTING CATEGORY END ************************//
}else{
$category_url=ami_crete_url($news_given_by);
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
if($_SERVER["REQUEST_METHOD"] == "POST"){
	
 	$image =$_FILES["file"]["name"];
	

if($image){

@unlink("../news_images/$imgToDel");
@unlink("../news_images/thumb/$imgToDel");

	
	$uploadedfile = $_FILES['file']['tmp_name']; 
    $filename = stripslashes($_FILES['file']['name']); 	
	$extension = getExtension($filename);
	$extension = strtolower($extension);		
	$imgNAME = substr(md5($category_url.time().rand(1,10)),0,14).".".$extension;	
	move_uploaded_file($_FILES['file']['tmp_name'],"../news_images/$imgNAME");

///////////////////////////// FOR SMALL  THUMB AND LARGE IMAGE /////////////////////////
$image = new Zebra_Image(); 
$image->source_path = '../news_images/'.$imgNAME; 
$ext = substr($image->source_path, strrpos($image->source_path, '.') + 1);
// indicate a target image
$image->target_path = '../news_images/thumb/'.$imgNAME;
// resize
// and if there is an error, show the error message
if (!$image->resize(75, 75, ZEBRA_IMAGE_BOXED, -1)) show_error($image->error, $image->source_path, $image->target_path);

}else{
$imgNAME=$imgToDel;
}


}

////////////****************** IMAGE RESIZING END HERE *****************************//
$sql = "insert into  tbl_news set 
                news_given_by='$news_given_by',
				news_title='$news_title',				
				news_comp_name='$news_comp_name',
				news_image_name='$imgNAME',
				news_description='$news_description', 	
				news_add_date='$curr_date',
				news_status='$news_status'";
db_query($sql);
$_SESSION["msg"]="News added successfully !";
header("Location:add-edit-news.php?id=$_REQUEST[id]");
exit;
//*************** INSERT NEW CATEGORY END ************************//
 }
}

if($news_id!='') {
	$result = db_query("select * from  tbl_news where news_id = '$news_id'");
	if ($line_raw = mysqli_fetch_array($result)) {
	 @extract($line_raw);
	}
}
?>



         <!-- Content Wrapper. Contains page content -->
         <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
               <div class="header-icon">
                  <i class="fa fa-newspaper-o" aria-hidden="true"></i>

               </div>
               <div class="header-title">
                  <h1>Add/Edit News</h1>
                  <small>Add/Edit news content</small>
                  
                  
<a href="news-list.php"><button id="btn-go-back" type="button" class="btn btn-labeled btn-inverse m-b-5 pull-right">
<span class="btn-label" ><i class="fa fa-chevron-circle-left"></i></span>Go Back
</button></a>

                  
               </div>
               
               
            </section>
            <!-- Main content -->
<script src="../ckeditor/ckeditor.js"></script>            
            <section class="content">
            
            <?php if($_SESSION["msg"]!=""){?>               
<div class="alert alert-success alert-dismissable fade in text-center" style="background-color:#dff0d8;border:none; color:#000;margin:10px 0 10px 0">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Success!&nbsp;&nbsp;&nbsp;</strong> <?=$_SESSION["msg"]?>
  </div>
<?php 
unset($_SESSION["msg"]);
}?>     

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
                              


                            
<div class="form-group col-lg-3">
<label>News Image</label>
<?php if($news_image_name!=""){ ?>
<img src="../news_images/<?=$news_image_name?>" class="form-control" style="width:150px;height:150px" />
<?php }else{?>
<img src="assets/dist/img/no-image.jpg" class="form-control" style="width:120px;height:150px" />
<?php }?>

<?php if($news_image_name!=""){ ?>
<div class="col-lg-12 " ><a href="add-edit-news.php?delImage=<?=$news_image_name?>&news_id=<?=$news_id?>" style="font-weight:600;margin-left:15px;text-decoration:underline" >Remove Image</a>                  
</div>
<?php }?>

</div>

<div class="form-group col-lg-9" style="padding-top:100px">
<input type="file" name="file" id="file" />
</div>

<div class="clearfix"></div>


<div class="form-group col-lg-12">
                                 <label>Titlw</label>
<input type="text" class="form-control" placeholder="Enter Title" name="news_title" id="news_title"  value="<?=$news_title?>">
                              </div>
                                         


<div class="form-group col-lg-6">
                                 <label>Posted By</label>
<input type="text" class="form-control" placeholder="Enter Name" name="news_given_by" id="news_given_by"  value="<?=$news_given_by?>">
                              </div>
                                         
                                         
                                         
<div class="form-group col-lg-6">
                                 <label>Company Name</label>
<input type="text" class="form-control" placeholder="Enter company name" name="news_comp_name" id="news_comp_name"  value="<?=$news_comp_name?>">
                              </div>
                                                                                                   
                            
                            
                            
                             
                             <div class="form-group col-lg-12 " >
                                 <label>News Description</label>
 <textarea class="form-control" name="news_description" rows="3" placeholder="Enter testimonial description" id="editor1" style="width:98%"><?=$news_description?></textarea>
                              </div>
                             

<script>

// Replace the <textarea id="editor"> with an CKEditor
// instance, using default configurations.
CKEDITOR.replace( 'editor1');

</script>                      
                           
<div class="form-group col-lg-3">
 <label>Status</label>
 
<select name="news_status" class="form-control" >
                      <option value="Active" <?php if($news_status=='Active'){ ?> selected="selected" <? } ?>>Active</option>
                      <option value="Inactive" <?php if($news_status=='Inactive'){ ?> selected="selected" <? } ?>>Inactive</option>
                    </select>


</div>                             
       


                             
                             
                            
                              
                              
                             
                              <div class="col-lg-12 reset-button">
                                                                 
                                 <button type="submit" class="btn btn-add">Submit</button>
                                
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
 