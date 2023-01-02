<?php require_once("header.php");?>
<?php require_once("left-nav.php");?>
<style>
h5.source-title {
    background: #009688;
    color: #fff;
    padding: 6px;
    width: 200px;
    font-weight: 600;
}

.v-middle {
vertical-align:middle !important;
}
</style>
<?php
if(is_post_back()) {
	$arr_ids = $_REQUEST['arr_ids'];
	if(is_array($arr_ids)) {
		$str_ids = implode(',', $arr_ids); 
		
		if(isset($_REQUEST['Delete'])){
              
			db_query("DELETE FROM tbl_enquiry WHERE enquiry_id in ($str_ids)");
						$_SESSION["msg"]="selected enquiries are deleted. ";
			  
			  	 }

		
	}

	header("Location: ".$_SERVER['HTTP_REFERER']);
	exit;
}


$start = intval($start);
$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;

$order_by == '' ? $order_by = 'enquiry_id' : true;
$order_by2 == '' ? $order_by2 = 'desc' : true;
 
$sql = "select * from  tbl_enquiry   where 1 ";

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
                  <i class="fa fa-envelope" aria-hidden="true"></i>

               </div>
               <div class="header-title">
                  <h1>Enquiry</h1>
                  <small>Enquiry List</small>
                  
                  
                  
 
                 
                 


<span class="count-num">Total : <?=db_scalar("SELECT COUNT(enquiry_id) FROM  tbl_enquiry ")?></span>
                  
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
                                 <h4>Enquiry List</h4>
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
                                       <th class="text-center">Name</th>                                       
                                       <th class="text-center">Email/Source</th>
                                       <th class="text-center">Mobile</th>
                                       <th class="text-center">Date</th>
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
                            
                           
<td class=" v-middle">
<p><a href="view-enquiry.php?enquiry_id=<?=$line_raw["enquiry_id"]?>" target="_blank"><i class="fa fa-search-plus fa-lg pull-left" style="color:#000"></i>&nbsp; <?=$line_raw["enquiry_name"]?> </a></p>
</td>





<td class="text-center v-middle">
<a href="mailto:<?=$line_raw["enquiry_email"]?>"><?=$line_raw["enquiry_email"]?></a>

<?php if($line_raw['enquiry_source']!="" ){?>
<div  class="col-lg-12 bold source" align="center">
<h5 class="source-title">Enquiry From <?=$line_raw['enquiry_source']?> </h5></div>
<?php }?>

</td>





<td class="text-center v-middle">
<a href="tel:<?=$line_raw["enquiry_mobile"]?>"><?=$line_raw["enquiry_mobile"]?></a>
</td>

<td class="text-center v-middle">
<?=date("d-M-Y",strtotime($line_raw["enquiry_add_date"]))?>
</td>


<td class="text-center v-middle"><input name="arr_ids[]" type="checkbox" id="arr_ids[]" value="<?=$enquiry_id?>" /></td>                                           
                                       
                                    </tr>
<?php
}
?>
                                    
<tr> <td colspan="8">


 <?php //if($_SESSION['sess_admin_type']=='Admin'){ ?>

<button  style="background-color:#CA0000;border:solid #CA0000" type="submit" name="Delete" onClick="return select_chk()"  class="btn btn-primary pull-right ml5 " >Delete</button>


                          
                          <? //} ?>




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