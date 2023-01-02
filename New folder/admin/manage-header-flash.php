<?php require_once("header.php");?>
<?php require_once("left-nav.php");?>
<style>
.v-middle {
vertical-align:middle !important;
}
</style>
<?php
$DelID=$_GET["DelID"];
if($DelID!=""){
$imgDel=db_scalar("SELECT header_flash_image_name FROM tbl_header_flash WHERE header_flash_id='$DelID'");	
$sql="delete from tbl_header_flash where header_flash_id='$DelID'";
db_query($sql);
@unlink("../flash_images/$imgDel");
header("location:manage-header-flash.php");
exit;
}

if($_REQUEST['st']!=""){
$st=$_REQUEST['st'];
$pageID=$_REQUEST['pid'];

if($st==1){
$sql="UPDATE tbl_header_flash SET header_flash_status='Inactive' WHERE header_flash_id='$pageID' ";	
$res=db_query($sql);	
if($res>0){
$_SESSION["msg"]="Selected slider is deactivated successfully.";	
}	
}else{
$sql="UPDATE tbl_header_flash SET header_flash_status='Active' WHERE header_flash_id='$pageID' ";	
$res=db_query($sql);	
if($res>0){
$_SESSION["msg"]="Selected slider is activated successfully.";	
}	
	
}

header("location:manage-header-flash.php");
exit;
}

if(is_post_back()) {
	$arr_ids = $_REQUEST['arr_ids'];
  $Arr_size=sizeof($arr_ids);
	if(is_array($arr_ids)) {
		$str_ids = implode(',', $arr_ids); 
		/*if(isset($_REQUEST['Delete']) || isset($_REQUEST['Delete_x']) ) {
			db_query("delete from  tbl_header_flash where header_flash_id in ($str_ids)");
		}*/ 

       if(isset($_REQUEST['Delete']) || isset($_REQUEST['Delete_x']) ) {
 
    
      for($i=0; $i<$Arr_size; $i++)
    {
        $qc_del = db_scalar("select header_flash_image_name from tbl_header_flash where header_flash_id='$arr_ids[$i]'");
     @unlink("../flash_images/$qc_del");
      db_query("delete from tbl_header_flash where header_flash_id='$arr_ids[$i]' ");
    }
    

    }else if(isset($_REQUEST['Activate']) || isset($_REQUEST['Activate_x']) ) {
			$res=db_query("update  tbl_header_flash set header_flash_status = 'Active' where header_flash_id in ($str_ids)");
			  
			  if($res>0){
			  $_SESSION["msg"]="Selected slider is actived successfully.";	
			  }
			  
		} else if(isset($_REQUEST['Deactivate']) || isset($_REQUEST['Deactivate_x']) ) {
			$res=db_query("update  tbl_header_flash set header_flash_status = 'Inactive' where header_flash_id in ($str_ids)");
			
			 if($res>0){
			  $_SESSION["msg"]="Selected slider is deactivated successfully.";	
			  }
			  
		}else if(isset($_REQUEST['show_in_header']) || isset($_REQUEST['show_in_header_x']) ) {
			db_query("update  tbl_header_flash set site_pages_show_in_header='Yes' where header_flash_id in ($str_ids)");
		}else if(isset($_REQUEST['show_in_header_r']) || isset($_REQUEST['show_in_header_r_x']) ) {
			db_query("update  tbl_header_flash set site_pages_show_in_header='No' where header_flash_id in ($str_ids)");
		}else if(isset($_REQUEST['show_in_footer']) || isset($_REQUEST['show_in_footer_x']) ) {
			db_query("update  tbl_header_flash set site_pages_show_in_footer='Yes' where header_flash_id in ($str_ids)");
		}else if(isset($_REQUEST['show_in_footer_r']) || isset($_REQUEST['show_in_footer_r_x']) ) {
			db_query("update  tbl_header_flash set site_pages_show_in_footer='No' where header_flash_id in ($str_ids)");
		}
	}
	if(isset($_REQUEST['Update'])){
		foreach($site_pages_order_by as $key=>$value){
		db_query("update tbl_header_flash set site_pages_order_by='$value' where header_flash_id='$key'");
		}
	}
	header("Location: ".$_SERVER['HTTP_REFERER']);
	exit;
}

$start = intval($start);
$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;

$order_by == '' ? $order_by = 'header_flash_status' : true;
$order_by2 == '' ? $order_by2 = 'asc' : true;
 
$sql = "select * from  tbl_header_flash   where 1 AND header_flash_type='Main'";
$sql = apply_filter($sql, $header_flash_title, 'like','header_flash_title');
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
                  <i class="fa fa-picture-o" aria-hidden="true"></i>

               </div>
               <div class="header-title">
                  <h1>Header Flash</h1>
                  <small>Header Flash List</small>
                  
                  
                  <a href="addedit-header-flash.php"><button id="btn-go-back" type="button" class="btn btn-labeled btn-inverse m-b-5 pull-right">
<span class="btn-label" ><i class="fa fa-plus" aria-hidden="true"></i>
</span>Add New
</button></a>
                  
                  
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

<? if($pager->total_records>0) {?>
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
                                 <h4>Header Flash List</h4>
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
                                       <th class="text-center">Image</th>    
                                       <th class="text-center">Title</th>
                                       <th class="text-center">Description</th> 
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
                            
<td class="text-center v-middle"><a href="<?=SITE_WS_PATH?>" target="_blank"><img src="../flash_images/<?=$header_flash_image_name?>" height="100" width="200"  style="border:solid thin #ccc;padding:5px;"></a></td>                            
                                     
 <td class="text-center v-middle"><?=$line_raw["header_flash_title"]?></td>

<td class="text-center v-middle"><?=$line_raw["header_flash_description"]?></td>
                                     

<td class="text-center v-middle">
<?php if($line_raw["header_flash_status"]=="Active"){?>
<a href="manage-header-flash.php?st=1&pid=<?=$line_raw["header_flash_id"]?>"><span class="label-custom label label-default">Active</span></a>
<?php }else{?>
<a href="manage-header-flash.php?st=0&pid=<?=$line_raw["header_flash_id"]?>"><span class="label-danger label label-default">Inactive</span></a>

<?php }?>

</td>
                                       <td class="text-center v-middle">
<a href="addedit-header-flash.php?header_flash_id=<?=$line_raw["header_flash_id"]?>"><button type="button" class="btn btn-add btn-sm" ><i class="fa fa-pencil"></i></button>
</a>                                          


<a href="manage-header-flash.php?DelID=<?=$line_raw["header_flash_id"]?>"><button type="button" class="btn 
btn-danger btn-sm" ><i class="fa fa-trash"></i></button>
</a>                                          


                                       </td>
<td class="text-center v-middle"><input name="arr_ids[]" type="checkbox" id="arr_ids[]" value="<?=$header_flash_id?>" /></td>                                           
                                       
                                    </tr>
<?php
}
?>
                                    
<tr> <td colspan="7">



<button type="submit" name="Deactivate"  class="btn btn-warning pull-right " onClick="return select_chk()">Make Inactive</button>

<button type="submit" name="Activate" class="btn btn-success pull-right mr5" onClick="return select_chk()">Make Active</button>
<button type="submit" name="Delete" class="btn btn-success pull-right mr5 label-danger" onClick="return select_chk()">Delete</button>

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



   <script language="javascript">
function select_chk(){
var chks = document.getElementsByName('arr_ids[]');
var hasChecked = false;
for (var i = 0; i < chks.length; i++){
if (chks[i].checked){
  hasChecked = true;
  break;
  }
}
if (hasChecked == false){
alert("Please Select At Least One.");
return false;
}
}
</script> 
<?php require_once("footer.php"); ?>