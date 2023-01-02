<?php require_once("header.php");?>
<?php require_once("left-nav.php");?>
<?php require_once ('includes/photoshop.php');?>


<?php


if(isset($_POST['submit_user'])){
@extract($_POST);
 if(isset($_GET['edit_id'])){ 
if(is_array($access)){ $acc_type=implode(",",$access); }
    $sql="update tbl_admin set 
           admin_password = '$admin_password',
       admin_userid='$admin_userid',
       admin_access='$acc_type',
       admin_add_date=now(),
       admin_user_type='$admin_user_type' 
       where admin_id= '$_GET[edit_id]'";
             db_query($sql);
       $_SESSION["msg"]="User updated successfully !";
             header("Location:manage-user.php");
             exit;
}else{
@extract($_POST);
$cntUser=db_scalar("select count(*) from tbl_admin where 1 and admin_userid='$_POST[admin_userid]'");
 if($cntUser > 0){
  
    $_SESSION["msg"]="Sorry ! user already exist.";
 }else{
 if(is_array($access)){ $acc_type=implode(",",$access); }
    $sql="insert into tbl_admin set 
           admin_password ='$admin_password',
       admin_access='$acc_type',
       admin_userid='$admin_userid',
       admin_add_date=now(),
       admin_user_type='$admin_user_type'";
       db_query($sql);
      $_SESSION["msg"]="User created successfully !";
       header("Location:manage-user.php");
       exit;
    }
  }
}     
if(isset($_GET['edit_id'])){
$sql="select * from tbl_admin where admin_id='$_GET[edit_id]'";
$result2=db_query($sql);
$data_new=mysqli_fetch_array($result2);
}

?>



         <!-- Content Wrapper. Contains page content -->
         <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
               <div class="header-icon">
                  <i class="fa fa-user" aria-hidden="true"></i>

               </div>
               <div class="header-title">
                  <h1>Manage Sub Admin <span style="color:green"><?=db_scalar("select vehicle_brand_name from tbl_vehicle_filter where filter_id='$brand_id' ");?></span></h1>
                  <small>Sub Admin
       
                  </small>
                  
                  
<a href="vehicle_brand_model.php"><button id="btn-go-back" type="button" class="btn btn-labeled btn-inverse m-b-5 pull-right">
<span class="btn-label" ><i class="fa fa-chevron-circle-left"></i></span>Go Back
</button></a>

                  
               </div>
               
               
            </section>
            <!-- Main content -->
<script src="ckeditor/ckeditor.js"></script>            
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
                                 <h4>Sub Admin Information</h4>
                              </a>
                           </div>
                        </div>
                        <div class="panel-body">
<form name="form1" method="post" onsubmit="return formValidation()" enctype="multipart/form-data" class="col-sm-12" >





<div class="clearfix"></div>
<div class="form-group col-lg-4">
<label>Username</label>
<input type="text" class="form-control" placeholder="Enter Name" name="admin_userid" id="admin_userid"  value="<?=$data_new['admin_userid']?>">
</div>

<div class="form-group col-lg-4">
<label>Password</label>
<input type="text" class="form-control" placeholder="Enter Name" name="admin_password" id="admin_password"  value="<?=$data_new['admin_password']?>">
</div>
                    
<div class="form-group col-lg-4">
 <label>Status</label>
 
<select name="admin_user_type" class="form-control" >
                      <option value="Sub Admin" <?php if($admin_user_type=="Sub Admin"){?>selected <?}?> >Sub Admin</option>
                     
                    </select>


</div>   

<div class="col-lg-12 reset-button">
               
<table width="100%" border="0" cellspacing="0" cellpadding="2">
                <tr>
                  <td width="3%" scope="col"><input type="checkbox" name="access[]" <?php if(check_access("$data_new[admin_access]","1")=='true') { ?> checked="checked"<? } ?> value="1" /></td>
                  <td width="23%">Manage Billing Master</td>

                  <td width="3%" scope="col"><input type="checkbox" name="access[]" value="2" <?php if(check_access("$data_new[admin_access]","2")=='true') { ?> checked="checked"<? } ?>/></td>
                  <td width="71%">Manage Products/Services</td>
                </tr>
                <tr>
                  <th scope="row"><input type="checkbox" name="access[]" value="3" <?php if(check_access("$data_new[admin_access]","3")=='true') { ?> checked="checked"<? } ?>/></th>
                  <td>Manage Client Master</td>

                  <td><input type="checkbox" name="access[]" value="4" <?php if(check_access("$data_new[admin_access]","4")=='true') { ?> checked="checked"<? } ?>/></td>
                  <td>Manage Order Master</td>
                </tr>
                <tr>
                  <th scope="row"><input type="checkbox" name="access[]" value="5" <?php if(check_access("$data_new[admin_access]","5")=='true') { ?> checked="checked"<? } ?>/></th>
                  <td>Manage Invoices</td>

                  <td><input type="checkbox" name="access[]" value="6" <?php if(check_access("$data_new[admin_access]","6")=='true') { ?> checked="checked"<? } ?>/></td>
                  <td>General Setting</td>
                </tr>
                <tr>
                  <th scope="row"><input type="checkbox" name="access[]" value="7" <?php if(check_access("$data_new[admin_access]","7")=='true') { ?> checked="checked"<? } ?>/></th>
                  <td>Manage Sub Admin</td>
                  
                    <th scope="row"><input type="checkbox" name="access[]" value="8" <?php if(check_access("$data_new[admin_access]","8")=='true') { ?> checked="checked"<? } ?>/></th>
                  <td>Manual Transaction Record</td>
                  </tr>
                  
                    <tr>
                  <th scope="row"><input name="check_all" type="checkbox" id="check_all" value="check_all" onclick="checkall(this.form)" /></th>
                  <td><b>Select All</b></td>
                </tr>
               
              </table>

</div>

 <div class="col-lg-12 reset-button">
                                                                 
                                 <button type="submit" name="submit_user" onclick="return select_one()" id="submit_user" class="btn btn-add">Submit</button>
                                
                              </div>
                           </form>
                        </div>
                     </div>
                  </div>
               </div>
            </section>
            
            
            <?php
            
            if($st!=""){
$st=$_REQUEST['st'];
$catID=$_REQUEST['pid'];

if($st==1){
$sql="UPDATE tbl_admin SET admin_status='Inactive' WHERE admin_id='$catID' ";	
$res=db_query($sql);	
if($res>0){
$_SESSION["msg"]="Selected user is deactivated successfully.";	
}	
}else{
$sql="UPDATE tbl_admin SET admin_status='Active' WHERE admin_id='$catID' ";	
$res=db_query($sql);	
if($res>0){
$_SESSION["msg"]="Selected user is activated successfully.";	
}	
	
}

header("Location:manage-user.php");
exit;
}



if(is_post_back()) {
   $Arr_size=sizeof($arr_ids);
	$arr_ids = $_REQUEST['arr_ids'];
	if(is_array($arr_ids)) {
		$str_ids = implode(',', $arr_ids); 
		if(isset($_REQUEST['Activate']) || isset($_REQUEST['Activate_x']) ) {
			db_query("update tbl_admin set admin_status='Active' where admin_id in ($str_ids)");
			$_SESSION["msg"]="selected users are activated. ";
		}else if(isset($_REQUEST['Deactivate']) || isset($_REQUEST['Deactivate_x']) ) {
			db_query("update tbl_admin set admin_status='Inactive' where admin_id in ($str_ids)");
						$_SESSION["msg"]="selected users are deactivated. ";
		}else  if(isset($_REQUEST['Delete']) || isset($_REQUEST['Delete_x']) ) {
  
      db_query("delete from tbl_admin where admin_id in ($str_ids) ");
      $_SESSION["msg"]="selected users are deleted. ";
    
      }
header("Location:manage-user.php");
exit;

		
	}

}


$start = intval($start);
$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;

$order_by == '' ? $order_by = 'admin_id' : true;
$order_by2 == '' ? $order_by2 = 'desc' : true;
 
$sql = "select * from tbl_admin where admin_user_type!='Admin' ";
$sql = apply_filter($sql, $admin_name, 'like','admin_name');
$sql .= " order by $order_by $order_by2 ";
$sql .= " limit $start, $pagesize ";
//echo $sql;
$pager = new midas_pager_sql($sql, $pagesize, $start);
if($pager->total_records) {
	$result = db_query($sql);
}
            ?>
            <section class="content">
               <div class="row">

<?php if($_SESSION["msg"]!=""){?>               
<div class="alert alert-success alert-dismissable fade in text-center" style="background-color:#dff0d8;border:none; color:#000;margin:10px 0 0 0">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Success!&nbsp;&nbsp;&nbsp;</strong> <?=$_SESSION["msg"]?>
  </div>
<?php 
unset($_SESSION["msg"]);
}?>     

<div class="col-lg-12">

<? if($pager->total_records!=0) {?>
<div class="col-lg-6 text-left" >
<? $pager->show_displaying()?>
</div>
<div class="col-lg-6 text-right" >Records Per Page:
<?=pagesize_dropdown('pagesize', $pagesize);?>
</div>
<?php
}
?>

</div>


                  <div class="col-sm-12">
                     <div class="panel panel-bd lobidrag" data-edit-title='false' data-close='false' data-reload='false'>
                        
                        
                           
                        
                        
                        <div class="panel-heading">
                           <div class="btn-group" id="buttonexport">
                              <a href="#">
                                 <h4>Sub Admin List</h4>
                              </a>
                           </div>
                        </div>
                        
                        



                        
                        <div class="panel-body">
                       
<? if($pager->total_records>0) {?>                       
                       
                           <div class="table-responsive">
<form action="" method="post" enctype="multipart/form-data">                           
                              <table id="dataTableExample1" class="table table-bordered table-striped table-hover">
                                 <thead>
                                    <tr class="info">                                      
                                       <th class="text-center">S.No.</th>            
                                       <th class="text-center">User Info</th>   
                                        
                                       
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Action</th>
                                       <th class="text-center"><input name="check_all" type="checkbox" id="check_all" value="1" onclick="checkall(this.form)" /></th>
                                    </tr>
                                 </thead>
                                 
<tbody>
                                   
<?
$cnt=0;
while ($line_raw = mysqli_fetch_array($result)) {
	$line = ms_display_value($line_raw);
	@extract($line);
	$css = ($css=='trOdd')?'trEven':'trOdd';
?>                                   
                                    <tr>
                            
                            
                            <td class="text-center v-middle"><?=++$cnt?></td>
                            

                                     
<td class="v-middle">
<p><b>Username</b>: <?=$line_raw["admin_userid"]?></p>
<p><b>Password</b>: <?=$line_raw["admin_password"]?></p>
<p><b>Access</b>: 
  <?php
                $msg="";  
                if(check_access("$line_raw[admin_access]","1")=='true')
                {  $msg.= "Manage Billing Master,&nbsp;"; }
                if(check_access("$line_raw[admin_access]","2")=='true')
                {  $msg.= "Manage Products/Services,&nbsp;"; }
                if(check_access("$line_raw[admin_access]","3")=='true')
                {  $msg.= "Manage Client Master,&nbsp;"; }
                if(check_access("$line_raw[admin_access]","4")=='true')
                {  $msg.= "Manage Order Master,&nbsp;"; }
                if(check_access("$line_raw[admin_access]","5")=='true')
                {  $msg.= "Manage Invoices,&nbsp;"; }
                if(check_access("$line_raw[admin_access]","6")=='true')
                {  $msg.= "General Setting,&nbsp;"; }
                if(check_access("$line_raw[admin_access]","7")=='true')
                {  $msg.= "Manage Sub Admin,&nbsp;"; }
                 if(check_access("$line_raw[admin_access]","8")=='true')
                {  $msg.= "Manual Transaction Record,&nbsp;"; }
               
                 print "$msg";
                ?>
</p>
</td>





<td class="text-center v-middle">
<?php if($line_raw["admin_status"]=="Active"){?>
<a href="manage-user.php?st=1&pid=<?=$line_raw["admin_id"]?>"><span class="label-custom label label-default">Active</span></a>
<?php }else{?>
<a href="manage-user.php?st=0&pid=<?=$line_raw["admin_id"]?>"><span class="label-danger label label-default">Inactive</span></a>
<?php }?>

</td>
 



<td class="text-center v-middle">
<a href="manage-user.php?edit_id=<?=$line_raw["admin_id"]?>"><button type="button" class="btn btn-add btn-sm" ><i class="fa fa-pencil"></i></button>
</a>                                          
</td>


<td class="text-center v-middle"><input name="arr_ids[]" type="checkbox" id="arr_ids[]" value="<?=$admin_id?>" /></td>                                           
                                       
                                    </tr>
<?php
}
?>
                                    
<tr> <td colspan="9">


 <?php if($_SESSION['sess_admin_type']=='Admin'){ ?>

<button  style="background-color:#CA0000;border:solid #CA0000" type="submit" name="Delete" onClick="return select_chk()"  class="btn btn-primary pull-left ml5 " >Delete</button>


                          
                          <? } ?>


 


<button type="submit" name="Deactivate"  class="btn btn-danger pull-right mr5" >Make Inactive</button>

<button type="submit" name="Activate" class="btn btn-success pull-right mr5" >Make Active</button>

</td></tr>             

                                    
                                    
                                 </tbody>
</form>
                              </table>
                              
<? $pager->show_pager();?>
                                             
                              
                           </div>
<?php }else{?>
<div class="col-lg-12 msg text-center">Sorry, no records found.</div>
<?php }?>
                                  
                           
                        </div>
                     </div>
                  </div>
               </div>
             
               <!-- /.modal -->
               <!-- Modal -->    
               <!-- Customer Modal2 -->
               
               <!-- /.modal -->
            </section>
            
            
            
            
            <!-- /.content -->
         </div>


         <script language="javascript" type="text/javascript">
function select_one(){

if(document.getElementById('admin_userid').value==0){   
alert("Enter Username !");
document.getElementById('admin_userid').focus();
return false;
}
if(document.getElementById('admin_password').value==0){   
alert("Enter Password !");
document.getElementById('admin_password').focus();
return false;
}

var chks = document.getElementsByName('access[]');
var hasChecked = false;
for (var i = 0; i < chks.length; i++){
if (chks[i].checked){
hasChecked = true;
break;
}else{
hasChecked = false;
}
}
if (hasChecked == false){
alert("Please select at least one access !");
return false;
}else{
return true;
}
}
</script>

<?php require_once("footer.php"); ?>
 