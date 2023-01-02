<?php require_once("header.php");?>
<?php require_once("left-nav.php");?>
<?php require_once ('../includes/photoshop.php');?>
<?php
$job_id=trim($_REQUEST['id']);



if(is_post_back()){
//*************** UPDATE EXISTING CATEGORY START ************************//

if($_REQUEST['id']!='0') {

$sql = "update  tbl_jobs set        				
				job_title='$job_title',
				job_description='$job_description', 	
				job_add_date='$curr_date',
				job_status='$job_status'
				where job_id = '$job_id' ";

db_query($sql);


$_SESSION["msg"]="Job updated successfully !";
header("Location:add-edit-job.php?id=$_REQUEST[id]");
exit;
//*************** UPDATE EXISTING CATEGORY END ************************//
}else{


////////////****************** IMAGE RESIZING END HERE *****************************//
$sql = "insert into  tbl_jobs set 
				job_title='$job_title',				
				job_description='$job_description', 	
				job_add_date='$curr_date',
				job_status='$job_status'";
db_query($sql);
$_SESSION["msg"]="Job added successfully !";
header("Location:add-edit-job.php?id=$_REQUEST[id]");
exit;
//*************** INSERT NEW CATEGORY END ************************//
 }
}

if($job_id!='') {
	$result = db_query("select * from  tbl_jobs where job_id = '$job_id'");
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
                  <i class="fa fa-bell" aria-hidden="true"></i>

               </div>
               <div class="header-title">
                  <h1>Add/Edit Jobs</h1>
                  <small>Add/Edit job content</small>
                  
                  
<a href="job-list.php"><button id="btn-go-back" type="button" class="btn btn-labeled btn-inverse m-b-5 pull-right">
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
                              


                            


<div class="form-group col-lg-12">
                                 <label>Title</label>
<input type="text" class="form-control" placeholder="Enter Title" name="job_title" id="job_title"  value="<?=$job_title?>">
                              </div>
                                         


                                         
                                         
                                         
                                                                                                   
                            
                            
                            
                             
                             <div class="form-group col-lg-12 " >
                                 <label>Job Description</label>
 <textarea class="form-control" name="job_description" rows="3" placeholder="Enter testimonial description" id="editor1" style="width:98%"><?=$job_description?></textarea>
                              </div>
                             

<script>

// Replace the <textarea id="editor"> with an CKEditor
// instance, using default configurations.
CKEDITOR.replace( 'editor1');

</script>                      
                           
<div class="form-group col-lg-3">
 <label>Status</label>
 
<select name="job_status" class="form-control" >
                      <option value="Active" <?php if($job_status=='Active'){ ?> selected="selected" <? } ?>>Active</option>
                      <option value="Inactive" <?php if($job_status=='Inactive'){ ?> selected="selected" <? } ?>>Inactive</option>
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
 