<?php require_once("header.php");?>
<?php require_once("left-nav.php");?>
<style>
.v-middle {
vertical-align:middle !important;
}
</style>
<?php


function get_domain($url){
  $charge = explode('/', $url);
  $charge = $charge[2]; 
  return $charge;
}

if($st!=""){
$st=$_REQUEST['st'];
$catID=$_REQUEST['pid'];

if($st==1){
$sql="UPDATE tbl_billing_company SET billing_company_status='Inactive' WHERE billing_company_id='$catID' ";	
$res=db_query($sql);	
if($res>0){
$_SESSION["msg"]="Selected company is deactivated successfully.";	
}	
}else{
$sql="UPDATE tbl_billing_company SET billing_company_status='Active' WHERE billing_company_id='$catID' ";	
$res=db_query($sql);	
if($res>0){
$_SESSION["msg"]="Selected company is activated successfully.";	
}	
	
}

header("location:manage-billing-company.php");
exit;
}



if(is_post_back()) {
   $count="";
	$arr_ids = $_REQUEST['arr_ids'];

   
	if(is_array($arr_ids)) {
		$str_ids = implode(',', $arr_ids); 
		if(isset($_REQUEST['Activate']) || isset($_REQUEST['Activate_x']) ) {
			db_query("update tbl_billing_company set billing_company_status='Active' where billing_company_id in ($str_ids)");
			$_SESSION["msg"]="selected companies are activated. ";
		} else if(isset($_REQUEST['Deactivate']) || isset($_REQUEST['Deactivate_x']) ) {
			db_query("update tbl_billing_company set billing_company_status='Inactive' where billing_company_id in ($str_ids)");
						$_SESSION["msg"]="selected companies are deactivated. ";
		}/*else  if(isset($_REQUEST['Delete'])){
         db_query("update tbl_billing_company set billing_company_deleted='Yes' where billing_company_id in ($str_ids)");
            $_SESSION["msg"]="selected companies are deleted. ";
          }else  if(isset($_REQUEST['Restore'])){
         db_query("update tbl_billing_company set billing_company_deleted='No' where billing_company_id in ($str_ids)");
            $_SESSION["msg"]="selected companies are restored. ";
          }*/

		
	}
/*	if(isset($_REQUEST['Update'])){
		foreach($test_order_by as $key=>$value){
		db_query("update tbl_testimonial set test_order_by='$value' where test_id='$key'");
		}
	}
	$_SESSION["msg"]="Selected testimonial(s) order updated";	*/
	header("Location: ".$_SERVER['HTTP_REFERER']);
	exit;
}

$search_con="";
if(isset($_REQUEST['search_submit']))
{
if($_REQUEST['search_value']!="")
{
	$value=$_REQUEST['search_value'];
	$search_con="and (billing_company_name like '%$value%' OR billing_company_phone_no like '%$value%' OR billing_company_email like '%$value%')";
}

}


$filter_con="";
if($_REQUEST['list_filter']=="Active")
{
  $filter_con="and billing_company_status='Active'";
}

if($_REQUEST['list_filter']=="Inactive")
{
  $filter_con="and billing_company_status='Inactive'";
}


$start = intval($start);
$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;

$order_by == '' ? $order_by = 'billing_company_id' : true;
$order_by2 == '' ? $order_by2 = 'desc' : true;
 
$sql = "select * from  tbl_billing_company   where 1 $search_con $filter_con";
$sql = apply_filter($sql, $billing_company_name, 'like','billing_company_name');
$sql .= " order by $order_by $order_by2 ";
$sql .= " limit $start, $pagesize ";
//echo $sql;
$pager = new midas_pager_sql($sql, $pagesize, $start);
if($pager->total_records) {
	$result = db_query($sql);
}
?>

<script language="JavaScript" type="text/javascript" src="includes/general.js"></script>

         <!-- =============================================== -->
         <!-- Content Wrapper. Contains page content -->
         <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
               <div class="header-icon">
                  <i class="fa fa-building-o" aria-hidden="true"></i>

               </div>
               <div class="header-title">
                  <h1>Billing Company</h1>
                  <small>Billing Company List</small>
                  
                  
                  
 
                 
                 
                 <a href="add-edit-billing-company.php?id=0"><button id="btn-go-back" type="button" class="btn btn-labeled btn-inverse m-b-5 pull-right">
<span class="btn-label"><i class="fa fa-plus" aria-hidden="true"></i>
</span>Add New Company
</button></a>

 <span class="count-num">Total : <?=db_scalar("SELECT COUNT(billing_company_id) FROM  tbl_billing_company")?></span> 
<?php /*if($show_deleted_company=="No"){?>
<a href="manage-billing-company.php?Deleted_C=Yes">
  <span class="count-num" style="background-color: black;"><i class="fa fa-trash"></i> Show Deleted Company</span> 
</a>
<?}else{?>
<a href="manage-billing-company.php?Deleted_C=No">
  <span class="count-num" style="background-color: black;"><i class="fa fa-building-o"></i> Show Undeleted Company</span> 
</a>
  <?}*/?>

                  
               </div>


           
               
            </section>
            <!-- Main content -->
            <section class="content">
               <div class="row">

               	<div class="col-lg-6 col-lg-offset-4">
                     <p>
                     	<form action="" method="get">
                   <input type="text" placeholder="Company Name/Phone/Email" value="<?=$_REQUEST['search_value']?>" name="search_value" class="form-control text-center" style="width:300px; float: left;" required/>

                   
                 <!--   <input type="hidden" name="Deleted_C" value="<?=$show_deleted_company?>"> -->
                     
                   <input type="submit" value="Search" class="btn btn-primary" name="search_submit" />
                   <?php  if($_REQUEST['search_value']!=""){?>
                   <a href="manage-billing-company.php">Clear</a>
                   <?}?>
               </form>
</p>

               </div>

<?php if($_SESSION["msg"]!=""){?>            
<br>   
<br>
<div class="alert alert-success alert-dismissable fade in text-center" style="background-color:#dff0d8;border:none; color:#000;margin:10px 0 0 0">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Success!&nbsp;&nbsp;&nbsp;</strong>  <?=$_SESSION["msg"]?>
  </div>
<?php 
unset($_SESSION["msg"]);
}?>     

<div class="col-lg-12">
<select onchange="filter_fun(this.value)">
<option value="All" <?php if($_REQUEST['list_filter']=="All"){?> selected <?}?>>Show All</option>
<option value="Active" <?php if($_REQUEST['list_filter']=="Active"){?> selected <?}?>>Show Active</option>
<option value="Inactive" <?php if($_REQUEST['list_filter']=="Inactive"){?> selected <?}?>>Show Inactive</option>
</select>


<script type="text/javascript">
 function filter_fun(filter_value)
 {
  window.location.href="manage-billing-company.php?list_filter="+filter_value;
 }



</script>
</div>


<!-- <div class="col-lg-12">

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

</div> -->


<div class="col-sm-12">
   <div class="panel panel-bd lobidrag" data-edit-title='false' data-close='false' data-reload='false'>
     
      
      <div class="panel-heading">
         <div class="btn-group" id="buttonexport">
            <a href="#">
               <h4>Company List</h4>
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
                                       <th class="text-center">Company</th>            
                                       <th class="text-center">Company Details</th>                                       
                                       <th class="text-center">Status</th>

                                       <th class="text-center">Edit</th>
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
                            
                             <td align="center" >
<?php if($billing_company_logo!=""){?>                             
<?//=SITE_WS_PATH?>
<img src="company_logo/<?=$billing_company_logo?>"  class="thumbnail" style="width:65px;height:65px; margin-top:0;margin-bottom:0" />
<?php }else{?>
<img src="assets/dist/img/Noimage.png"  class="thumbnail" style="width:65px;height:65px; margin-top:0;margin-bottom:0" />
<?php }?> 
<br>
<?=$billing_company_name?>
<br>

<a href="<?=$billing_company_website?>" target="_blank">
<?php
echo get_domain($billing_company_website);
?>

</a>
</td>
                                     
<td class="v-middle" align="left">
<strong>Phone No.: </strong><?=$billing_company_phone_no?><br>
<strong>Email: </strong><?=$billing_company_email?><br>
<strong>Address: </strong><?=$billing_company_address?>
 </td>





<td class="text-center v-middle">
<?php if($line_raw["billing_company_status"]=="Active"){?>
<a href="manage-billing-company.php?st=1&pid=<?=$line_raw["billing_company_id"]?>"><span class="label-custom label label-default">Active</span></a>
<?php }else{?>
<a href="manage-billing-company.php?st=0&pid=<?=$line_raw["billing_company_id"]?>"><span class="label-danger label label-default">Inactive</span></a>
<?php }?>

</td>






<td class="text-center v-middle">
<a href="add-edit-billing-company.php?id=<?=$line_raw["billing_company_id"]?>"><button type="button" class="btn btn-add btn-sm" ><i class="fa fa-pencil"></i></button>
</a>                                          
</td>


<td class="text-center v-middle"><input name="arr_ids[]" type="checkbox" id="arr_ids[]" value="<?=$billing_company_id?>" /></td>                                           
                                       
                                    </tr>
<?php
}
?>
                                    
<tr> <td colspan="8">






                          
                        

<button type="submit" name="Deactivate"  class="btn btn-primary pull-right mr5"  onClick="return select_chk()">Make Inactive</button>

<button type="submit" name="Activate" class="btn btn-success pull-right mr5"  onClick="return select_chk()">Make Active</button>


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
            </section>
            <!-- /.content -->
         </div>
<?php require_once("footer.php"); ?>