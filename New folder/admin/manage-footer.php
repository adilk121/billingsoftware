<?php require_once("header.php");?>
<?php require_once("left-nav.php");?>
<?php
if(is_post_back()){
 if(isset($_REQUEST['Update'])){	
     $update="update tbl_admin set 
	             admin_copyright='$admin_copyright',
				 admin_member_of='$admin_member_of',
				 admin_keyword='$admin_keyword',
				 admin_keyword_link='$admin_keyword_link',
				 admin_all_right_reserved='$admin_all_right_reserved' 
				 where 1 and admin_user_type='Admin'";
	db_query($update);
    $_SESSION["msg"] = "Record Updated";	
 }	
}
?>

         <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
               <div class="header-icon">
                  <i class="fa fa-gears"></i>
               </div>
               <div class="header-title">
                  <h1>Footer</h1>
                  <small>Manage Footer</small>
               </div>
               
               
               


            </section>
            <!-- Main content -->

                                  <?php
$sql = "select * from tbl_admin where 1 and admin_user_type='Admin'";
$sqlupdt=db_query($sql);		  
while ($line_raw = mysqli_fetch_array($sqlupdt)) {
	@extract($line_raw);
	$css = ($css=='trOdd')?'trEven':'trOdd';
?>
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
                                 <h4>Footer Content</h4>
                              </a>
                           </div>
                        </div>
                        <div class="panel-body">
                           <form class="col-sm-8 col-lg-offset-2" action="" method="post" name="form1" id="form1" onsubmit="return passValidation();">
                              
                              <div class="form-group col-lg-12">
                                 <label>Copyright</label>
<input type="text" class="form-control" name="admin_copyright" id="admin_copyright" value="<?=$admin_copyright?>">
                              </div>
                              
                              
                              <div class="form-group col-lg-12">
                                 <label>All Rights Reserved By</label>
<input type="text" class="form-control" name="admin_all_right_reserved" id="admin_all_right_reserved" value="<?=$admin_all_right_reserved?>">
                              </div>
                              
                              
                              <div class="form-group col-lg-12">
                                 <label>Designed by</label>
<input type="text" class="form-control" name="admin_member_of" id="admin_member_of" value="<?=$admin_member_of?>">
                              </div>

                                <div class="form-group col-lg-12">
                                 <label>Keyword</label>
<input type="text" class="form-control" name="admin_keyword" id="admin_keyword" value="<?=$admin_keyword?>">
                              </div>
                              
                               <div class="form-group col-lg-12">
                                 <label>Keyword Link</label>
<input type="text" class="form-control" name="admin_keyword_link" id="admin_keyword_link" value="<?=$admin_keyword_link?>">
                              </div>
                              
                            
                              
                              
                              <div class="col-lg-12 reset-button text-center" >
                              <button type="submit" name="Update"  class="btn btn-add">Update</button>
                              </div>
                           </form>
                        </div>
                     </div>
                  </div>
               </div>
            </section>
            <?}?>
            <!-- /.content -->
         </div>
<?php require_once("footer.php"); ?>
<script type="text/javascript">
function passValidation(){
function trim(str){				
 return str.replace(/^\s*|\s*$/g,'');
}
if(trim(document.getElementById('password').value)==0){		
  alert("Please enter old password !");
  document.getElementById('password').focus();
  return false;
 }
if(trim(document.getElementById('changepass').value)==0){		
  alert("Please enter new password !");
  document.getElementById('changepass').focus();
  return false;
 }
 if(trim(document.getElementById('confirmpass').value)==0){		
  alert("Please confirm new password !");
  document.getElementById('confirmpass').focus();
  return false;
 }
}
</script>