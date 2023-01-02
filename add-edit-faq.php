<?php require_once("header.php");?>
<?php require_once("left-nav.php");?>
<?php
$faq_id=$_REQUEST['faq_id'];

if(isset($_REQUEST['submit'])){
$sql = "insert into tbl_faq set 
                faq_ques='$faq_ques',
				faq_answer='$faq_answer',				
				faq_status='$faq_status',
				faq_add_date='".date("Y-m-d")."'
				";
db_query($sql);
$_SESSION["msg"]="FAQ is added successfully !";
header("Location:add-edit-faq.php");
exit;
}


if(isset($_REQUEST['update'])){
$sql = "update  tbl_faq set 
                faq_ques='$faq_ques',
				faq_answer='$faq_answer',				
				faq_status='$faq_status',
				faq_add_date='".date("Y-m-d")."'
				WHERE faq_id='$faq_id'
				";
db_query($sql);
$_SESSION["msg"]="FAQ is updated successfully !";
header("Location:add-edit-faq.php?faq_id=$faq_id");
exit;
}



if($faq_id!='') {
	$result = db_query("select * from tbl_faq where faq_id = '$faq_id'");
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
                  <i class="fa fa-question-circle" aria-hidden="true"></i>

               </div>
               <div class="header-title">
                  <h1>Add/Edit FAQ</h1>
                  <small>Add/Edit FAQ content</small>
                  
                  
<a href="faq-list.php"><button id="btn-go-back" type="button" class="btn btn-labeled btn-inverse m-b-5 pull-right">
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
<label>Question</label>
<input type="text" class="form-control" placeholder="Enter question" name="faq_ques" id="faq_ques"  value="<?=$faq_ques?>">
</div>


<div class="form-group col-lg-12 " >
<label>Answer</label>
<textarea class="form-control" name="faq_answer" rows="3" placeholder="Enter answer" id="faq_answer" style="width:98%"><?=$faq_answer?></textarea>
                              </div>
                             

                           
                           
<div class="form-group col-lg-3">
 <label>Status</label>
 
<select name="faq_status" class="form-control" >
                      <option value="Active" <?php if($faq_status=='Active'){ ?> selected="selected" <? } ?>>Active</option>
                      <option value="Inactive" <?php if($faq_status=='Inactive'){ ?> selected="selected" <? } ?>>Inactive</option>
                    </select>


</div>                             
                              <div class="col-lg-12 reset-button">
                                 <?php if($faq_id!=""){?>
                                 <button type="submit" name="update" class="btn btn-add">Update</button>                                 <?php }else{?>								                                 
                                 <button type="submit" name="submit" class="btn btn-add">Submit</button>
                                 <?php }?>								                                 
                                
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
 