<?php require_once("header.php");?>
<?php require_once("left-nav.php");?>
<style>
.v-middle {
vertical-align:middle !important;
}
</style>

<?php                  
$web_site=db_scalar("select admin_website_url from tbl_admin where 1 and admin_user_type='Admin' ");
$phone=db_scalar("select admin_phone from tbl_admin where 1 and admin_user_type='Admin' ");
$mobile=db_scalar("select admin_mobile from tbl_admin where 1 and admin_user_type='Admin' ");
$email=db_scalar("select admin_email from tbl_admin where 1 and admin_user_type='Admin' ");
$comp_name=db_scalar("select admin_company_name from tbl_admin where 1 and admin_user_type='Admin' ");

?>
<?php
if($st!=""){
$st=$_REQUEST['st'];
$pageID=$_REQUEST['pid'];

if($st==1){
$sql="UPDATE tbl_registration SET reg_status='Inactive' WHERE reg_id='$pageID' ";   
$res=db_query($sql); 
if($res>0){
$_SESSION["msg"]="Selected user is deactivated successfully."; 


$mail_inactive=mysqli_fetch_array(db_query("select * from tbl_registration where 1 and reg_id='$pageID' "));

         ///////////////****** Mailer to client start here **********************//////////////
   $hostName = $_SERVER['HTTP_HOST'];          
   
$msgmail="<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' />
<title>TradeKeyIndia.com-Largest B2B Portal In India</title>
 </head>
<body>
<h2 style='font-family:Constantia; background-color:red; color:white; text-align:center; text-transform:uppercase;'>warning</h2>

<h2 style='font-family:Constantia;'>Dear $mail_inactive[reg_name],</h2>

<p style='font-family:Courier New; font-size:16px;'>Your account has been deactivated by admin due to our terms and conditions.</p>

<p style='font-family:Courier New; font-size:16px;'>Login Details as Below:-</p>

<p style='font-family:Courier New; font-size:16px;'>

<table border='0'>
<tr><td style='font-family:Courier New; font-size:16px;'>Website</td><td style='font-family:Courier New; font-size:16px;'>:  $web_site</td></tr>
<tr><td style='font-family:Courier New; font-size:16px;'>Login ID</td><td style='font-family:Courier New; font-size:16px;'>:  $mail_inactive[reg_email]</td></tr>
<tr><td style='font-family:Courier New; font-size:16px;'>Password</td><td style='font-family:Courier New; font-size:16px;'>:  $mail_inactive[reg_pass]</td></tr>
</table>
</p>
<p style='font-family:Courier New; font-size:16px;'>We are always here to assist you.</p>
<p style='font-family:Courier New; font-size:16px;'>Customer Support :</p>
<p style='font-family:Courier New; font-size:16px;'>Email Address : $email</p>
<p style='font-family:Courier New; font-size:16px;'>Contact Number : $mobile </p>

</body>
</html>";
//$toEmail = $email;
$toEmail = $mail_inactive['reg_email'];
$subject = "Account deactivated from $web_site";
              $from="$email";
            $Headers1 = "From: $comp_name<$from>\n";
            $Headers1 .= "X-Mailer: PHP/". phpversion();
            $Headers1 .= "X-Priority: 3 \n";
            $Headers1 .= "MIME-version: 1.0\n";
            $Headers1 .= "Content-Type: text/html; charset=iso-8859-1\n"; 
            @mail("$toEmail", "$subject", "$msgmail","$Headers1","-fenquiry@tradekeyindia.com");
            //@mail("amitabh.tradekeyindia@gmail.com", "Subject", "Msg1","$Headers1","-fenquiry@tradekeyindia.com");
             $toEmail."<br>";
///////////////****** Mailer to client end here **********************//////////////
///////////////// Mail To Admin //////////////////////////////////


if($email){
@mail($mail_to_admin,$sub_admin,$mail_admin_body,$headers_admin);
 }

}  
}else{
$sql="UPDATE tbl_registration SET reg_status='Active' WHERE reg_id='$pageID' ";  
$res=db_query($sql); 
if($res>0){
$_SESSION["msg"]="Selected user is activated successfully.";   


$mail_active=mysqli_fetch_array(db_query("select * from tbl_registration where 1 and reg_id='$pageID' "));

         ///////////////****** Mailer to client start here **********************//////////////
   $hostName = $_SERVER['HTTP_HOST'];          
   
$msgmail="<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' />
<title>TradeKeyIndia.com-Largest B2B Portal In India</title>
 </head>
<body>

<h2 style='font-family:Constantia;'>Dear $mail_active[reg_name],</h2>

<p style='font-family:Courier New; font-size:16px;'>Your account has been activated, now you can login with following details.</p>

<p style='font-family:Courier New; font-size:16px;'>Login Details as Below:-</p>

<p style='font-family:Courier New; font-size:16px;'>

<table border='0'>
<tr><td style='font-family:Courier New; font-size:16px;'>Website</td><td style='font-family:Courier New; font-size:16px;'>:  $web_site</td></tr>
<tr><td style='font-family:Courier New; font-size:16px;'>Login ID</td><td style='font-family:Courier New; font-size:16px;'>:  $mail_active[reg_email]</td></tr>
<tr><td style='font-family:Courier New; font-size:16px;'>Password</td><td style='font-family:Courier New; font-size:16px;'>:  $mail_active[reg_pass]</td></tr>
</table>
</p>
<p style='font-family:Courier New; font-size:16px;'>We are always here to assist you.</p>
<p style='font-family:Courier New; font-size:16px;'>Customer Support :</p>
<p style='font-family:Courier New; font-size:16px;'>Email Address : $email</p>
<p style='font-family:Courier New; font-size:16px;'>Contact Number : $mobile </p>
</body>
</html>";
//$toEmail = $email;
$toEmail = "$mail_active[reg_email]";
$subject = "Account activated from $web_site";
              $from="$email";
            $Headers1 = "From: $comp_name<$from>\n";
            $Headers1 .= "X-Mailer: PHP/". phpversion();
            $Headers1 .= "X-Priority: 3 \n";
            $Headers1 .= "MIME-version: 1.0\n";
            $Headers1 .= "Content-Type: text/html; charset=iso-8859-1\n"; 
            @mail("$toEmail", "$subject", "$msgmail","$Headers1","-fenquiry@tradekeyindia.com");
            //@mail("amitabh.tradekeyindia@gmail.com", "Subject", "Msg1","$Headers1","-fenquiry@tradekeyindia.com");
             $toEmail."<br>";
///////////////****** Mailer to client end here **********************//////////////
///////////////// Mail To Admin //////////////////////////////////


if($email){
@mail($mail_to_admin,$sub_admin,$mail_admin_body,$headers_admin);
 }
}  
   
}

header("location:manage-registration.php");
exit;
}
?>

<?php
$del_id=$_GET['del_id'];
if($del_id!=""){

$sql="DELETE FROM tbl_registration  WHERE reg_id='$del_id' ";  
$res=db_query($sql); 
if($res>0){
$_SESSION["msg"]="Selected user is deleted successfully.";  

}

header("location:manage-registration.php");
exit;
}
?>




<?php
if(is_post_back()) {
     $Arr_size=sizeof($arr_ids);
     
   $arr_ids = $_REQUEST['arr_ids'];
   if(is_array($arr_ids)) {
      $str_ids = implode(',', $arr_ids); 
      if(isset($_REQUEST['Delete']) || isset($_REQUEST['Delete_x']) ) {
         db_query("delete from  tbl_registration where reg_id in ($str_ids)");
      } else if(isset($_REQUEST['Activate']) || isset($_REQUEST['Activate_x']) ) {
         $res=db_query("update  tbl_registration set reg_status = 'Active' where reg_id in ($str_ids)");
           
           if($res>0){
      //   $_SESSION["msg"]="Selected user is actived successfully.";
              for($i=0; $i<$Arr_size; $i++)
    {
 
$mail_active=mysqli_fetch_array(db_query("select * from tbl_registration where 1 and reg_id='$arr_ids[$i]' "));

         ///////////////****** Mailer to client start here **********************//////////////
   $hostName = $_SERVER['HTTP_HOST'];          
   
$msgmail="<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' />
<title>TradeKeyIndia.com-Largest B2B Portal In India</title>
 </head>
<body>

<h2 style='font-family:Constantia;'>Dear $mail_active[reg_name],</h2>

<p style='font-family:Courier New; font-size:16px;'>Your account has been activated, now you can login with following details.</p>

<p style='font-family:Courier New; font-size:16px;'>Login Details as Below:-</p>

<p style='font-family:Courier New; font-size:16px;'>

<table border='0'>
<tr><td style='font-family:Courier New; font-size:16px;'>Website</td><td style='font-family:Courier New; font-size:16px;'>:  $web_site</td></tr>
<tr><td style='font-family:Courier New; font-size:16px;'>Login ID</td><td style='font-family:Courier New; font-size:16px;'>:  $mail_active[reg_email]</td></tr>
<tr><td style='font-family:Courier New; font-size:16px;'>Password</td><td style='font-family:Courier New; font-size:16px;'>:  $mail_active[reg_pass]</td></tr>
</table>
</p>
<p style='font-family:Courier New; font-size:16px;'>We are always here to assist you.</p>
<p style='font-family:Courier New; font-size:16px;'>Customer Support :</p>
<p style='font-family:Courier New; font-size:16px;'>Email Address : $email</p>
<p style='font-family:Courier New; font-size:16px;'>Contact Number : $mobile / $phone</p>
</body>
</html>";
//$toEmail = $email;
$toEmail = "$mail_active[reg_email]";
$subject = "Account activated from $web_site";
              $from="$email";
            $Headers1 = "From: $comp_name<$from>\n";
            $Headers1 .= "X-Mailer: PHP/". phpversion();
            $Headers1 .= "X-Priority: 3 \n";
            $Headers1 .= "MIME-version: 1.0\n";
            $Headers1 .= "Content-Type: text/html; charset=iso-8859-1\n"; 
            @mail("$toEmail", "$subject", "$msgmail","$Headers1","-fenquiry@tradekeyindia.com");
            //@mail("amitabh.tradekeyindia@gmail.com", "Subject", "Msg1","$Headers1","-fenquiry@tradekeyindia.com");
             $toEmail."<br>";
///////////////****** Mailer to client end here **********************//////////////
///////////////// Mail To Admin //////////////////////////////////


if($email){
@mail($mail_to_admin,$sub_admin,$mail_admin_body,$headers_admin);
 } }
           $_SESSION["msg"]="Selected user is actived successfully.";     
           }
           
      } else if(isset($_REQUEST['Deactivate']) || isset($_REQUEST['Deactivate_x']) ) {
         $res=db_query("update  tbl_registration set reg_status = 'Inactive' where reg_id in ($str_ids)");
         
          if($res>0){
         //  $_SESSION["msg"]="Selected user is deactivated successfully.";   
           
                       for($j=0; $j<$Arr_size; $j++)
    {

$mail_inactive=mysqli_fetch_array(db_query("select * from tbl_registration where 1 and reg_id='$arr_ids[$j]' "));

         ///////////////****** Mailer to client start here **********************//////////////
   $hostName = $_SERVER['HTTP_HOST'];          
   
$msgmail="<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' />
<title>TradeKeyIndia.com-Largest B2B Portal In India</title>
 </head>
<body>
<h2 style='font-family:Constantia; background-color:red; color:white; text-align:center; text-transform:uppercase;'>warning</h2>

<h2 style='font-family:Constantia;'>Dear $mail_inactive[reg_name],</h2>

<p style='font-family:Courier New; font-size:16px;'>Your account has been deactivated by admin due to our terms and conditions.</p>

<p style='font-family:Courier New; font-size:16px;'>Login Details as Below:-</p>

<p style='font-family:Courier New; font-size:16px;'>

<table border='0'>
<tr><td style='font-family:Courier New; font-size:16px;'>Website</td><td style='font-family:Courier New; font-size:16px;'>:  $web_site</td></tr>
<tr><td style='font-family:Courier New; font-size:16px;'>Login ID</td><td style='font-family:Courier New; font-size:16px;'>:  $mail_inactive[reg_email]</td></tr>
<tr><td style='font-family:Courier New; font-size:16px;'>Password</td><td style='font-family:Courier New; font-size:16px;'>:  $mail_inactive[reg_pass]</td></tr>
</table>
</p>
<p style='font-family:Courier New; font-size:16px;'>We are always here to assist you.</p>
<p style='font-family:Courier New; font-size:16px;'>Customer Support :</p>
<p style='font-family:Courier New; font-size:16px;'>Email Address : $email</p>
<p style='font-family:Courier New; font-size:16px;'>Contact Number : $mobile / $phone</p>

</body>
</html>";
//$toEmail = $email;
$toEmail = $mail_inactive['reg_email'];
$subject = "Account deactivated from $web_site";
              $from="$email";
            $Headers1 = "From: $comp_name<$from>\n";
            $Headers1 .= "X-Mailer: PHP/". phpversion();
            $Headers1 .= "X-Priority: 3 \n";
            $Headers1 .= "MIME-version: 1.0\n";
            $Headers1 .= "Content-Type: text/html; charset=iso-8859-1\n"; 
            @mail("$toEmail", "$subject", "$msgmail","$Headers1","-fenquiry@tradekeyindia.com");
            //@mail("amitabh.tradekeyindia@gmail.com", "Subject", "Msg1","$Headers1","-fenquiry@tradekeyindia.com");
             $toEmail."<br>";
///////////////****** Mailer to client end here **********************//////////////
///////////////// Mail To Admin //////////////////////////////////


if($email){
@mail($mail_to_admin,$sub_admin,$mail_admin_body,$headers_admin);
 } }
   $_SESSION["msg"]="Selected user is deactivated successfully."; 
           }
           
      }
   }

   header("Location: ".$_SERVER['HTTP_REFERER']);
   exit;
}

$start = intval($start);
$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;

$order_by == '' ? $order_by = 'reg_status' : true;
$order_by2 == '' ? $order_by2 = 'asc' : true;
 
$sql = "select * from  tbl_registration   where 1";
$sql = apply_filter($sql, $reg_name, 'like','reg_name');
$sql .= " order by $order_by $order_by2 ";
$sql .= " limit $start, $pagesize ";
//echo $sql;
$pager = new midas_pager_sql($sql, $pagesize, $start);
if($pager->total_records) {
   $result = db_query($sql);
}
?>

<script language="JavaScript" type="text/javascript" src="../includes/general.js"></script>

         <!-- =============================================== -->
         <!-- Content Wrapper. Contains page content -->
         <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
               <div class="header-icon">
                  <i class="fa fa-user-circle-o" aria-hidden="true"></i>

               </div>
               <div class="header-title">
                  <h1>Users
                  
<?php /*?><a href="add-user.php"><button class="btn btn-success pull-right bold " ><i class="fa fa-user-circle-o fa-lg font-black"></i> Add User</button></a><?php */?>

                  
                  </h1>
                  <small>Users List</small>

                  
                  
               </div>


           
               
            </section>
            <!-- Main content -->
            <section class="content">
               <div class="row">

<?php if($_SESSION["msg"]!=""){?>               
<div class="alert alert-success alert-dismissable fade in text-center" style="background-color:#dff0d8;border:none; color:#000;margin:10px 0 0 0">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Success!&nbsp;&nbsp;&nbsp;</strong> <?=$_SESSION["msg"]?>.
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
                                 <h4>Users List</h4>
                              </a>
                           </div>
                        </div>
                        
                        



                        
                        <div class="panel-body">
                        <!-- Plugin content:powerpoint,txt,pdf,png,word,xl -->
                           <!-- Plugin content:powerpoint,txt,pdf,png,word,xl -->
<? if($pager->total_records>0) {?>                           
                           
                           <div class="table-responsive">
<form action="" method="post" enctype="multipart/form-data">                           
                              <table id="dataTableExample1" class="table table-bordered table-striped table-hover">
                                 <thead>
                                    <tr class="info">                                      
                                       <th class="text-center">S.No.</th>            
                                       <th class="text-center">User Info.</th>                                       
                                       <th class="text-center">Add Date</th>                                       
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
                                     
                                       <td class="text-left v-middle">
                              
                              <p><?=$line_raw["reg_name"]?></p>
                                       
                                       <p><?="<strong>Mb : </strong>".$line_raw["reg_mobile_no"]?></p>
                                       <p><?="<strong>UID : </strong>".$line_raw["reg_email"]?></p>                                       
                                       <p>                                                                        
<span style="display:none;" id="pass_<?=$cnt?>" onMouseOut="this.style.display='none';document.getElementById('star_<?=$cnt?>').style.display='block'"><?="<strong>Pass : </strong>".$line_raw["reg_pass"]?></span>
                                       <span  style="cursor:pointer"  id="star_<?=$cnt?>" onMouseOver="this.style.display='none';document.getElementById('pass_<?=$cnt?>').style.display='block'"><strong>Pass : </strong><span style="font-size:10px"><i class="fa fa-star fa-spin"></i><i class="fa fa-star fa-spin"></i><i class="fa fa-star fa-spin"></i><i class="fa fa-star fa-spin"></i><i class="fa fa-star fa-spin"></i></span></span>
                                       </p>
                                       
                                       
                                       </td>
                                     
<td class="text-center v-middle">


<p class="bg-yellow bold"><?=date("d M y",strtotime($line_raw["reg_add_date"]))?></p>



</td>
<td class="text-center v-middle">
<?php if($line_raw["reg_status"]=="Active"){?>
<a href="manage-registration.php?st=1&pid=<?=$line_raw["reg_id"]?>"><span class="label-custom label label-default">Active</span></a>
<?php }else{?>
<a href="manage-registration.php?st=0&pid=<?=$line_raw["reg_id"]?>"><span class="label-danger label label-default">Inactive</span></a>
<?php }?>

</td>
                                       <td class="text-center v-middle">






<!-- <p><a href="javascript:void(0);" onClick ="PopupWindowCenter('registration_detail.php?user_id=<?=$reg_id?>&user_type=<?=$reg_user_type?>', 'PopupWindowCenter',1000,400)"><strong style="font-size:12px;"><button type="button" class="btn btn-view btn-sm" ><i class="fa fa-search"></i></button></strong></a>   -->
<p><a href="registration_detail.php?user_id=<?=$reg_id?>&user_type=<?=$reg_user_type?>" target="_blank" ><strong style="font-size:12px;"><button type="button" class="btn btn-view btn-sm" ><i class="fa fa-search"></i></button></strong></a>  

</p>

<?php /*?><p><a href="add-user.php?reg_id=<?=$line_raw["reg_id"]?>"><button type="button" class="btn btn-add btn-sm" ><i class="fa fa-pencil"></i></button>
</a> </p><?php */?>

<p><a href="manage-registration.php?del_id=<?=$line_raw["reg_id"]?>"><button type="button" class="btn btn-danger btn-sm" ><i class="fa fa-trash"></i></button>
</a> </p>                                         
                                       </td>
<td class="text-center v-middle"><input name="arr_ids[]" type="checkbox" id="arr_ids[]" value="<?=$reg_id?>" /></td>                                           
                                       
                                    </tr>
<?php
}
?>
                                    
<tr> <td colspan="6">

<button class="btn btn-danger pull-left" type="submit" name="Delete"><i class="fa fa-trash-o"></i>&nbsp;Delete</button>

<button type="submit" name="Deactivate"  class="btn btn-warning pull-right " >Make Inactive</button>

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
               <!-- customer Modal1 -->
               
               <!-- /.modal -->
               <!-- Modal -->    
               <!-- Customer Modal2 -->
               
               <!-- /.modal -->
            </section>
            <!-- /.content -->
         </div>
<?php require_once("footer.php"); ?>