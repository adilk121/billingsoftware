<?php require_once("header.php");?>
<?php require_once("left-nav.php");?>
<?php require_once ('../includes/photoshop.php');?>
<?php
$partner_id=trim($_REQUEST['id']);
$categoryID = trim($_GET['partner_id']);

if($_REQUEST['delImage']!=""){
$delImage=$_REQUEST['delImage'];	

@unlink("../partners_images/$delImage");


$isDel=db_query("UPDATE  tbl_partners SET  partner_image_name='' WHERE 1 and partner_id = '$categoryID'");	

header("location:add-edit-partners.php?id=$categoryID");
}

if(is_post_back()){
//*************** UPDATE EXISTING CATEGORY START ************************//
$imgNAME ="";
if($_REQUEST['id']!='0') {
$category_url=ami_crete_url($test_given_by);
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
$imgToDel=db_scalar("SELECT partner_image_name FROM tbl_partners WHERE 1 and partner_id='$partner_id'");	

if($image){

@unlink("../partners_images/$imgToDel");


	
	$uploadedfile = $_FILES['file']['tmp_name']; 
    $filename = stripslashes($_FILES['file']['name']); 	
	$extension = getExtension($filename);
	$extension = strtolower($extension);		
	$imgNAME = substr(md5($category_url.time().rand(1,10)),0,14).".".$extension;	
	move_uploaded_file($_FILES['file']['tmp_name'],"../partners_images/$imgNAME");

///////////////////////////// FOR SMALL  THUMB AND LARGE IMAGE /////////////////////////
$image = new Zebra_Image(); 
$image->source_path = '../partners_images/'.$imgNAME; 
$ext = substr($image->source_path, strrpos($image->source_path, '.') + 1);
// indicate a target image
//                 $image->target_path = '../test_images/thumb/'.$imgNAME;
// resize
// and if there is an error, show the error message
if (!$image->resize(75, 75, ZEBRA_IMAGE_BOXED, -1)) show_error($image->error, $image->source_path, $image->target_path);

}else{
$imgNAME=$imgToDel;
}

}

////////////****************** IMAGE RESIZING END HERE *****************************//

$sql = "update tbl_partners set        
				partner_name='$partner_name',
				partner_image_name='$imgNAME',
				partner_address='$partner_address',
				partner_status='$partner_status'
				where partner_id = '$partner_id' ";

db_query($sql);


$_SESSION["msg"]="Project updated successfully !";
header("Location:add-edit-partners.php?id=$_REQUEST[id]");
exit;
//*************** UPDATE EXISTING CATEGORY END ************************//
}else{
$category_url=ami_crete_url($partner_name);
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

@unlink("../partners_images/$imgToDel");

	
	$uploadedfile = $_FILES['file']['tmp_name']; 
    $filename = stripslashes($_FILES['file']['name']); 	
	$extension = getExtension($filename);
	$extension = strtolower($extension);		
	$imgNAME = substr(md5($category_url.time().rand(1,10)),0,14).".".$extension;	
	move_uploaded_file($_FILES['file']['tmp_name'],"../partners_images/$imgNAME");

///////////////////////////// FOR SMALL  THUMB AND LARGE IMAGE /////////////////////////
$image = new Zebra_Image(); 
$image->source_path = '../partners_images/'.$imgNAME; 
$ext = substr($image->source_path, strrpos($image->source_path, '.') + 1);
// indicate a target image
                  //$image->target_path = '../test_images/thumb/'.$imgNAME;
// resize
// and if there is an error, show the error message
if (!$image->resize(75, 75, ZEBRA_IMAGE_BOXED, -1)) show_error($image->error, $image->source_path, $image->target_path);

}else{
$imgNAME=$imgToDel;
}


}

////////////****************** IMAGE RESIZING END HERE *****************************//
$sql = "insert into tbl_partners set 
                partner_name='$partner_name',
				partner_image_name='$imgNAME',
				partner_address='$partner_address', 	
				partner_add_date='$curr_date',
				partner_status='$partner_status'";
db_query($sql);
$_SESSION["msg"]="Project added successfully !";
header("Location:add-edit-partners.php?id=$_REQUEST[id]");
exit;
//*************** INSERT NEW CATEGORY END ************************//
 }
}

if($partner_id!='') {
	$result = db_query("select * from tbl_partners where partner_id = '$partner_id'");
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
                  <i class="fa fa-handshake-o" aria-hidden="true"></i>

               </div>
               <div class="header-title">
                  <h1>Add/Edit Project</h1>
                  <small>Add/Edit Project content</small>
                  
                  
<a href="manage-partners.php"><button id="btn-go-back" type="button" class="btn btn-labeled btn-inverse m-b-5 pull-right">
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
<label>Image</label>
<?php if($partner_image_name!=""){ ?>
<img src="../partners_images/<?=$partner_image_name?>" class="form-control" style="width:150px;height:150px" />
<?php }else{?>
<img src="assets/dist/img/no-image.jpg" class="form-control" style="width:120px;height:150px" />
<?php }?>

<?php if($partner_image_name!=""){ ?>
<div class="col-lg-12 " ><a href="add-edit-partners.php?delImage=<?=$partner_image_name?>&partner_id=<?=$partner_id?>" style="font-weight:600;margin-left:15px;text-decoration:underline" >Remove Image</a>                  
</div>
<?php }?>

</div>

<div class="form-group col-lg-9" style="padding-top:100px">
<input type="file" name="file" id="file" />
<p style="color:red; font-size:10px; font-weight: bold;">Image Size: 975px*550px</p>
</div>

<div class="clearfix"></div>
<div class="form-group col-lg-12">
                                 <label>Name</label>
<input type="text" class="form-control" placeholder="Enter Name" name="partner_name" id="partner_name"  value="<?=$partner_name?>">
                              </div>
                                         
                                         
                                         
<div class="form-group col-lg-12">
                                 <label>Address</label>
                                 <textarea class="form-control" placeholder="Enter Address" name="partner_address" id="partner_address" style="height:90px; resize: none;"><?=$partner_address?></textarea>

                              </div> 
                                                                                                   
                            
                            
                            
                             
                          <!--    <div class="form-group col-lg-12 " >
                                 <label>Testimonial Description</label>
 <textarea class="form-control" name="test_description" rows="3" placeholder="Enter testimonial description" id="" style="width:98%"><?=$test_description?></textarea>
                              </div> -->
                             

                           
                           
<div class="form-group col-lg-3">
 <label>Status</label>
 
<select name="partner_status" class="form-control" >
                      <option value="Active" <?php if($partner_status=='Active'){ ?> selected="selected" <? } ?>>Active</option>
                      <option value="Inactive" <?php if($partner_status=='Inactive'){ ?> selected="selected" <? } ?>>Inactive</option>
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
 
