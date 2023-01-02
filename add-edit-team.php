<?php require_once("header.php");?>
<?php require_once("left-nav.php");?>
<?php require_once ('../includes/photoshop.php');?>
<?php
$team_id=trim($_REQUEST['id']);
$categoryID = trim($_GET['team_id']);

if($_REQUEST['delImage']!=""){
$delImage=$_REQUEST['delImage'];	

@unlink("../our_team/$delImage");
@unlink("../our_team/thumb/$delImage");

$isDel=db_query("UPDATE  tbl_our_team SET  team_member_image='' WHERE 1 and team_id = '$categoryID'");	

header("location:add-edit-team.php?id=$categoryID");
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
$imgToDel=db_scalar("SELECT team_member_image FROM tbl_our_team WHERE  team_id='$team_id'");	

if($image){

@unlink("../our_team/$imgToDel");
@unlink("../our_team/thumb/$imgToDel");

	
	$uploadedfile = $_FILES['file']['tmp_name']; 
    $filename = stripslashes($_FILES['file']['name']); 	
	$extension = getExtension($filename);
	$extension = strtolower($extension);		
	$imgNAME = substr(md5($category_url.time().rand(1,10)),0,14).".".$extension;	
	move_uploaded_file($_FILES['file']['tmp_name'],"../our_team/$imgNAME");

///////////////////////////// FOR SMALL  THUMB AND LARGE IMAGE /////////////////////////
$image = new Zebra_Image(); 
$image->source_path = '../our_team/'.$imgNAME; 
$ext = substr($image->source_path, strrpos($image->source_path, '.') + 1);
// indicate a target image
$image->target_path = '../our_team/thumb/'.$imgNAME;
// resize
// and if there is an error, show the error message
if (!$image->resize(75, 75, ZEBRA_IMAGE_BOXED, -1)) show_error($image->error, $image->source_path, $image->target_path);

}else{
$imgNAME=$imgToDel;
}

}

////////////****************** IMAGE RESIZING END HERE *****************************//

$sql = "update tbl_our_team set        
				team_member_name='$team_member_name',
				team_member_desig='$team_member_desig',
				team_member_image='$imgNAME',
				team_add_date='$curr_date',
				team_status='$team_status'
				where team_id = '$team_id' ";

db_query($sql);


$_SESSION["msg"]="Team Member updated successfully !";
header("Location:add-edit-team.php?id=$_REQUEST[id]");
exit;
//*************** UPDATE EXISTING CATEGORY END ************************//
}else{
$category_url=ami_crete_url($test_given_by);
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

@unlink("../our_team/$imgToDel");
@unlink("../our_team/thumb/$imgToDel");

	
	$uploadedfile = $_FILES['file']['tmp_name']; 
    $filename = stripslashes($_FILES['file']['name']); 	
	$extension = getExtension($filename);
	$extension = strtolower($extension);		
	$imgNAME = substr(md5($category_url.time().rand(1,10)),0,14).".".$extension;	
	move_uploaded_file($_FILES['file']['tmp_name'],"../our_team/$imgNAME");

///////////////////////////// FOR SMALL  THUMB AND LARGE IMAGE /////////////////////////
$image = new Zebra_Image(); 
$image->source_path = '../our_team/'.$imgNAME; 
$ext = substr($image->source_path, strrpos($image->source_path, '.') + 1);
// indicate a target image
$image->target_path = '../our_team/thumb/'.$imgNAME;
// resize
// and if there is an error, show the error message
if (!$image->resize(75, 75, ZEBRA_IMAGE_BOXED, -1)) show_error($image->error, $image->source_path, $image->target_path);

}else{
$imgNAME=$imgToDel;
}


}

////////////****************** IMAGE RESIZING END HERE *****************************//
$sql = "insert into tbl_our_team set 
        team_member_name='$team_member_name',
        team_member_desig='$team_member_desig',
        team_member_image='$imgNAME',
        team_add_date='$curr_date',
        team_status='$team_status'";
db_query($sql);
$_SESSION["msg"]="Team Member added successfully !";
header("Location:add-edit-team.php?id=$_REQUEST[id]");
exit;
//*************** INSERT NEW CATEGORY END ************************//
 }
}

if($team_id!='') {
	$result = db_query("select * from tbl_our_team where team_id = '$team_id'");
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
                  <i class="fa fa-comments" aria-hidden="true"></i>

               </div>
               <div class="header-title">
                  <h1>Add/Edit Our Team</h1>
                  <small>Add/Edit Our Team content</small>
                  
                  
<a href="manage-our-team.php"><button id="btn-go-back" type="button" class="btn btn-labeled btn-inverse m-b-5 pull-right">
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
<label>Testimonial Image</label>
<?php if($team_member_image!=""){ ?>
<img src="../our_team/<?=$team_member_image?>" class="form-control" style="width:150px;height:150px" />
<?php }else{?>
<img src="assets/dist/img/no-image.jpg" class="form-control" style="width:120px;height:150px" />
<?php }?>

<?php if($team_member_image!=""){ ?>
<div class="col-lg-12 " ><a href="add-edit-team.php?delImage=<?=$team_member_image?>&team_id=<?=$team_id?>" style="font-weight:600;margin-left:15px;text-decoration:underline" >Remove Image</a>                  
</div>
<?php }?>

</div>

<div class="form-group col-lg-9" style="padding-top:100px">
<input type="file" name="file" id="file" />
</div>

<div class="clearfix"></div>

<div class="form-group col-lg-6">
<label>Member Name</label>
<input type="text" class="form-control" placeholder="Enter Member Name" name="team_member_name" id="team_member_name"  value="<?=$team_member_name?>">
</div>
                                          
                                         
<div class="form-group col-lg-6">
<label>Member Designation</label>
<input type="text" class="form-control" placeholder="Enter Member Designation" name="team_member_desig" id="team_member_desig"  value="<?=$team_member_desig?>">
</div>
                                                                                                   
                         
<div class="form-group col-lg-3">
<label>Status</label>

<select name="team_status" class="form-control" >
  <option value="Active" <?php if($team_status=='Active'){ ?> selected="selected" <? } ?>>Active</option>
  <option value="Inactive" <?php if($team_status=='Inactive'){ ?> selected="selected" <? } ?>>Inactive</option>
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
 