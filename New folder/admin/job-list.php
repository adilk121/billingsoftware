<?php require_once("header.php");?>
<?php require_once("left-nav.php");?>
<style>
.v-middle {
vertical-align:middle !important;
}
</style>
<?php
if($st!=""){
$st=$_REQUEST['st'];
$catID=$_REQUEST['pid'];

if($st==1){
$sql="UPDATE tbl_jobs SET job_status='Inactive' WHERE job_id='$catID' ";	
$res=db_query($sql);	
if($res>0){
$_SESSION["msg"]="Selected job is deactivated successfully.";	
}	
}else{
$sql="UPDATE tbl_jobs SET job_status='Active' WHERE job_id='$catID' ";	
$res=db_query($sql);	
if($res>0){
$_SESSION["msg"]="Selected job is activated successfully.";	
}	
	
}

header("location:job-list.php");
exit;
}



if(is_post_back()) {
	$arr_ids = $_REQUEST['arr_ids'];
	if(is_array($arr_ids)) {
		$str_ids = implode(',', $arr_ids); 
		if(isset($_REQUEST['Activate']) || isset($_REQUEST['Activate_x']) ) {
			db_query("update tbl_jobs set job_status='Active' where job_id in ($str_ids)");
			$_SESSION["msg"]="selected jobs are activated. ";
		} else if(isset($_REQUEST['Deactivate']) || isset($_REQUEST['Deactivate_x']) ) {
			db_query("update tbl_jobs set job_status='Inactive' where job_id in ($str_ids)");
						$_SESSION["msg"]="selected jobs are deactivated. ";
		}else  if(isset($_REQUEST['Delete'])){
              
			db_query("DELETE FROM tbl_jobs WHERE job_id in ($str_ids)");
						$_SESSION["msg"]="selected jobs are deleted. ";
			  
			  	 }

		
	}
	if(isset($_REQUEST['Update'])){
		foreach($job_order_by as $key=>$value){
		db_query("update tbl_jobs set job_order_by='$value' where job_id='$key'");
		}
	}
	$_SESSION["msg"]="Selected news order is set.";	
	header("Location: ".$_SERVER['HTTP_REFERER']);
	exit;
}


$start = intval($start);
$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;

$order_by == '' ? $order_by = 'job_status' : true;
$order_by2 == '' ? $order_by2 = 'asc' : true;
 
$sql = "select * from  tbl_jobs   where 1 ";
$sql = apply_filter($sql, $testimonial_name, 'like','job_title');
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
                  <i class="fa fa-bell" aria-hidden="true"></i>

               </div>
               <div class="header-title">
                  <h1>Career/Jobs</h1>
                  <small>Career/Jobs List</small>
                  
                  
                  
 
                 
                 
                 <a href="add-edit-job.php?id=0"><button id="btn-go-back" type="button" class="btn  btn-labeled btn-inverse m-b-5 pull-right " >
<span class="btn-label"><i class="fa fa-plus" aria-hidden="true"></i>
</span>Add Jobs
</button></a>

<span class="count-num">Total : <?=db_scalar("SELECT COUNT(job_id) FROM  tbl_jobs ")?></span>
                  
               </div>


           
               
            </section>
            <!-- Main content -->
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
                                 <h4>Jobs List</h4>
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
                                       <th class="text-center">Title</th>                                       

                                       <th class="text-center">Status</th>
<!--                                       <th class="text-center">Order By</th>-->
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
                            
                            
                                     
<td class="text-left v-middle pl5">
<p><a href="Javascript:void(0)" class="font-black bold"><?=$line_raw["job_title"]?></a></p>

                                       
                                       </td>



<td class="text-center v-middle">
<?php if($line_raw["job_status"]=="Active"){?>
<a href="job-list.php?st=1&pid=<?=$line_raw["job_id"]?>"><span class="label-custom label label-default">Active</span></a>
<?php }else{?>
<a href="job-list.php?st=0&pid=<?=$line_raw["job_id"]?>"><span class="label-danger label label-default">Inactive</span></a>
<?php }?>

</td>


<?php /*?><td class="v-middle" align="center">
<input type="text" name="job_order_by[<?=$job_id?>]" id="job_order_by[<?=$job_id?>]"  value="<?=$job_order_by?>" class="form-control" style="width:40px"  />
</td><?php */?>



<td class="text-center v-middle">

<a href="add-edit-job.php?id=<?=$line_raw["job_id"]?>"><button type="button" class="btn btn-add btn-sm" ><i class="fa fa-pencil"></i></button>
</a>


<?php /*?><a href="add-edit-news.php?id=<?=$line_raw["job_id"]?>"><button type="button" class="btn btn-default btn-sm" ><i class="fa fa-search"></i></button>
</a>
<?php */?>
                                          
</td>


<td class="text-center v-middle"><input name="arr_ids[]" type="checkbox" id="arr_ids[]" value="<?=$job_id?>" /></td>                                           
                                       
                                    </tr>
<?php
}
?>
                                    
<tr> <td colspan="8">


 <?php if($_SESSION['sess_admin_type']=='Admin'){ ?>

<button  style="background-color:#CA0000;border:solid #CA0000" type="submit" name="Delete" onClick="return select_chk()"  class="btn btn-primary pull-left ml5 " >Delete</button>


                          
                          <? } ?>

<!--<button type="submit" name="Update"  class="btn btn-primary pull-right ml5 " >Update Order</button>-->

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
               <!-- customer Modal1 -->
               
               <!-- /.modal -->
               <!-- Modal -->    
               <!-- Customer Modal2 -->
               
               <!-- /.modal -->
            </section>
            <!-- /.content -->
         </div>
<?php require_once("footer.php"); ?>