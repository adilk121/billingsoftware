<?php require_once("header.php");?>
<?php require_once("left-nav.php");?>
<link href="assets/plugins/icheck/skins/all.css" rel="stylesheet" type="text/css"/>
<link href="assets/plugins/bootstrap-toggle/bootstrap-toggle.min.css" rel="stylesheet" type="text/css"/>

<?php
$headerID=$_REQUEST['edit_header_id'];
$logo_title=$_REQUEST['logo_title'];
$logo_status=$_REQUEST['logo_status'];

if($_REQUEST['delImage']!=""){
$isDel=db_query("UPDATE  tbl_header SET  header_logo='' WHERE 1 and header_id = '$header_id'"); 
@unlink("../gallery_image/$_REQUEST[delImage]");
header("location:addedit-logo.php?edit_header_id=$header_id");
}

if(is_post_back()) {

 if(!empty($headerID)){

  if($_FILES['header_logo']['name']!="")
  {
     $DelImg=db_scalar("select header_logo from tbl_header where 1 and header_id='$headerID'");
   @unlink("../gallery_image/$DelImg");
    $sqldel="delete from tbl_header where 1 and header_id='$headerID'";
   db_query($sqldel);
$rand=rand(100,10000);

   $file_name6=$rand.$_FILES['header_logo']['name'];
  move_uploaded_file($_FILES['header_logo']['tmp_name'],"../gallery_image/$file_name6");        
  $sql_edit6=",header_logo='$file_name6'";
 
  $sql = "insert into tbl_header set 
      header_status='$logo_status'
      $sql_edit6,
      header_image_title='$logo_title',
      header_add_date=now()";
   $_SESSION["msg"]="Selected logo is updated successfully.";  

  }else {

 $sql = "update tbl_header set 
      header_status='$logo_status',
      header_image_title='$logo_title',
      header_add_date=now()
      where header_id='$headerID'  ";
      $_SESSION["msg"]="Selected logo is updated successfully.";  
}
  }else{

$rand=rand(100,10000);
  $file_name=$rand.$_FILES['header_logo']['name'];
  move_uploaded_file($_FILES['header_logo']['tmp_name'],"../gallery_image/$file_name");     

  $sql = "insert into tbl_image_gallery set 
  image_name='$file_name',
  image_title='$logo_title',
  image_category='',
  image_status='$logo_status',
  image_add_date=now()";
  $_SESSION["msg"]="Logo added successfully.";  
     /* set_session_msg("Header Logo Added Successfully !");
      header("Location: manage-header.php");
      exit;*/
    }
          db_query($sql);
  header("Location: manage-test-gallery.php");
 
}



if($headerID!='') {
  $result = db_query("select * from tbl_header where header_id = '$headerID'");
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
                  <i class="fa fa-picture-o"></i>
               </div>
               <div class="header-title">
                  <h1>Edit Image</h1>
                  <small>Edit Image Content</small>
                  
                  
<a href="manage-test-gallery.php"><button id="btn-go-back" type="button" class="btn btn-labeled btn-inverse m-b-5 pull-right">
<span class="btn-label" ><i class="fa fa-chevron-circle-left"></i></span>Go Back
</button></a>

                  
               </div>
               
               
            </section>
            <!-- Main content -->
<script src="../ckeditor/ckeditor.js"></script>            
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
                             
                             

                        
<div class="form-group col-lg-4">
<label>Gallery Image</label>
<?php if($header_logo!=""){ ?>
<img src="../header_files/<?=$header_logo?>" class="form-control" style="width:252px;height:380px"  />
<?php }else{?>
<img src="assets/dist/img/no-image.jpg" class="form-control" style="width:252px;height:380px" />
<?php }?>

<?php/* if($header_logo!=""){ ?>
<div class="col-lg-12 " ><a href="addedit-logo.php?delImage=<?=$header_logo?>&header_id=<?=$header_id?>" style="font-weight:600;margin-left:15px;text-decoration:underline;margin-top:20px" >Remove Image</a>                  
</div>
<?php }*/?>

</div>

<div class="form-group col-lg-8" style="padding-top:30px">

<div class="form-group col-lg-12">
<label>Gallery Image</label>
<input class="form-control" type="file" name="header_logo" id="header_logo" />
</div>

<div class="form-group col-lg-12">
<label>Image Title</label>
<input type="text" class="form-control" placeholder="Enter Title" name="logo_title" id="logo_title" value="<?=$header_image_title?>" >
</div>

<div class="form-group col-lg-12">
<label>Category</label>
<select class="form-control">
  <option>Select Category</option>
  <?php
  $sql_cat=db_query("select * from tbl_category where 1 and category_status='Active' and category_parent_id='0' ");
while($res_cat=mysqli_fetch_array($sql_cat))
{?>
  <option><?=$res_cat['category_name']?></option>
 <?}?>
  </select>
</div>
                             

                             
<div class="form-group col-lg-3">
<label>Status</label>
<select name="logo_status" class="form-control" >
<option value="Active" <?php if($header_status=='Active'){ ?> selected="selected" <? } ?>>Active</option>
<option value="Inactive" <?php if($header_status=='Inactive'){ ?> selected="selected" <? } ?>>Inactive</option>
</select>


</div>                             
           
           
<div class="form-group col-lg-3 pt25">

<button type="submit"  class="btn btn-add">Update</button>
</div>                             
                          
                             
                             
                             
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
 