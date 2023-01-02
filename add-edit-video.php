<?php require_once("header.php");?>
<?php require_once("left-nav.php");?>
<?php require_once ('../includes/photoshop.php');?>
<?php
$video_id=trim($_REQUEST['id']);
$videoID = trim($_GET['video_id']);


if(is_post_back()){
//*************** UPDATE EXISTING CATEGORY START ************************//
$imgNAME ="";
if($_REQUEST['id']!='0') {

$sql = "update  tbl_video set        
				video_title='$video_title',
				video_url='$video_url',
				video_add_date='$curr_date',
				video_status='$video_status'
				where video_id = '$video_id' ";

db_query($sql);


$_SESSION["msg"]="Video updated successfully !";
header("Location:add-edit-video.php?id=$_REQUEST[id]");
exit;
//*************** UPDATE EXISTING CATEGORY END ************************//
}else{

$sql = "insert into  tbl_video set                
				video_title='$video_title',				
				video_url='$video_url',
				video_add_date='$curr_date',
				video_status='$video_status'";
db_query($sql);
$_SESSION["msg"]="Video added successfully !";
header("Location:add-edit-video.php?id=$_REQUEST[id]");
exit;
//*************** INSERT NEW CATEGORY END ************************//
 }
}

if($video_id!='') {
	$result = db_query("select * from  tbl_video where video_id = '$video_id'");
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
                  <i class="fa fa-video-camera" aria-hidden="true"></i>

               </div>
               <div class="header-title">
                  <h1>Add/Edit Video</h1>
                  <small>Add/Edit video</small>
                  
                  
<a href="video-list.php"><button id="btn-go-back" type="button" class="btn btn-labeled btn-inverse m-b-5 pull-right">
<span class="btn-label" ><i class="fa fa-chevron-circle-left"></i></span>Go Back
</button></a>

                  
               </div>
               
               
            </section>
            <!-- Main content -->

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
                              


                            


<div class="form-group col-lg-12">
                                 <label>Title</label>
<input type="text" class="form-control" placeholder="Enter Title" name="video_title" id="video_title"  value="<?=$video_title?>">
                              </div>
                                         


<div class="form-group col-lg-6">
                                 <label>Url</label>
<input type="text" class="form-control" placeholder="Enter Name" name="video_url" id="video_url"  value="<?=$video_url?>">
<span style="color:#03C;font-size:12px">*Enter last part of YouTube url. i.e. : <span style="color:#F00">Zr2_Q7fR_ag</span></span>

                              </div>
                                         
                                         
                                         

                           
<div class="form-group col-lg-3">
 <label>Status</label>
 
<select name="video_status" class="form-control" >
                      <option value="Active" <?php if($video_status=='Active'){ ?> selected="selected" <? } ?>>Active</option>
                      <option value="Inactive" <?php if($video_status=='Inactive'){ ?> selected="selected" <? } ?>>Inactive</option>
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
 