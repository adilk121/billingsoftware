<?php require_once("header.php");?>
<?php require_once("left-nav.php");?>
<?php require_once ('../includes/photoshop.php');?>
<?php
$EditID=$_REQUEST['edit_id'];
$ms=0;

//if(is_post_back()) {
  if(isset($_REQUEST['submit_brand']))  
  {
    $vehicle_brand_name=$_REQUEST['vehicle_brand_name'];
    $vehicle_status=$_REQUEST['vehicle_status'];


 if(!empty($EditID)){


 $sql = "update tbl_vehicle_filter set 
   vehicle_brand_name='$vehicle_brand_name',
  vehicle_status='$vehicle_status'
      where filter_id='$EditID'  ";
     // $ms="Brand is updated successfully.";  
      $ms=2;

  }else{

  $sql = "insert into tbl_vehicle_filter set 
  vehicle_brand_name='$vehicle_brand_name',
  vehicle_status='$vehicle_status'";
 // $ms="Brand added successfully.";  
  $ms=1;
   
    }

          db_query($sql);
header("Location: vehicle_brand_model.php");
 
}



if($EditID!='') {
	$result = db_query("select * from tbl_vehicle_filter where filter_id='$EditID' ");
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
                  <i class="fa fa-comments" aria-hidden="true"></i>

               </div>
               <div class="header-title">
                  <h1>Add/Edit Brand</h1>
                  <small>Add/Edit brand content
       
                  </small>
                  
                  
<!--<a href="manage-artists.php"><button id="btn-go-back" type="button" class="btn btn-labeled btn-inverse m-b-5 pull-right">
<span class="btn-label" ><i class="fa fa-chevron-circle-left"></i></span>Go Back
</button></a>-->

                  
               </div>
               
               
            </section>
            <!-- Main content -->
<script src="ckeditor/ckeditor.js"></script>            
            <section class="content">
            
            <?php /*if($ms!=0){?>               
<div class="alert alert-success alert-dismissable fade in text-center" style="background-color:#dff0d8;border:none; color:#000;margin:10px 0 10px 0">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Success!&nbsp;&nbsp;&nbsp;</strong>
    <?php if($ms==1){
        echo "Brand added successfully.";
        ?>
        <script>
    function cler(){
            document.getElementById("vehicle_brand_name").value="";
    }
    cler();
        </script>
        <?
    }else{
    echo "Brand is updated successfully.";
    
    }?>  
  </div>
<?php 

}*/?>     

               <div class="row">
                  <!-- Form controls -->
                  <div class="col-sm-12">
                     <div class="panel panel-bd lobidrag" data-edit-title='false' data-close='false' data-reload='false'>
                        <div class="panel-heading">
                           <div class="btn-group" id="buttonexport">
                              <a href="#">
                                 <h4>Brand Information</h4>
                              </a>
                           </div>
                        </div>
                        <div class="panel-body">
<form name="form1" method="post" onsubmit="return formValidation()" enctype="multipart/form-data" class="col-sm-12" >





<div class="clearfix"></div>
<div class="form-group col-lg-6">
                                 <label>Vehicle Brand Name</label>
<input type="text" class="form-control" placeholder="Enter Name" name="vehicle_brand_name" id="vehicle_brand_name"  value="<?=$vehicle_brand_name?>">
                              </div>
                    
<div class="form-group col-lg-3">
 <label>Status</label>
 
<select name="vehicle_status" class="form-control" >
                      <option value="Active" <?php if($vehicle_status=="Active"){?>selected <?}?> >Active</option>
                      <option value="Inactive" <?php if($vehicle_status=="Inactive"){?>selected <?}?> >Inactive</option>
                    </select>


</div>                             
 <div class="col-lg-12 reset-button">
                                                                 
                                 <button type="submit" name="submit_brand" id="submit_brand" class="btn btn-add">Submit</button>
                                
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
$sql="UPDATE tbl_vehicle_filter SET vehicle_status='Inactive' WHERE filter_id='$catID' ";	
$res=db_query($sql);	
if($res>0){
$_SESSION["msg"]="Selected brand is deactivated successfully.";	
}	
}else{
$sql="UPDATE tbl_vehicle_filter SET vehicle_status='Active' WHERE filter_id='$catID' ";	
$res=db_query($sql);	
if($res>0){
$_SESSION["msg"]="Selected brand is activated successfully.";	
}	
	
}

header("location:vehicle_brand_model.php");
exit;
}



if(is_post_back()) {
   $Arr_size=sizeof($arr_ids);
	$arr_ids = $_REQUEST['arr_ids'];
	if(is_array($arr_ids)) {
		$str_ids = implode(',', $arr_ids); 
		if(isset($_REQUEST['Activate']) || isset($_REQUEST['Activate_x']) ) {
			db_query("update tbl_vehicle_filter set vehicle_status='Active' where filter_id in ($str_ids)");
			$_SESSION["msg"]="selected brands are activated. ";
		}else if(isset($_REQUEST['Deactivate']) || isset($_REQUEST['Deactivate_x']) ) {
			db_query("update tbl_vehicle_filter set vehicle_status='Inactive' where filter_id in ($str_ids)");
						$_SESSION["msg"]="selected brands are deactivated. ";
		}else  if(isset($_REQUEST['Delete']) || isset($_REQUEST['Delete_x']) ) {
   for($i=0; $i<$Arr_size; $i++)
    {
db_query("delete from tbl_vehicle_filter where parent_id in ($str_ids)");
      db_query("delete from tbl_vehicle_filter where filter_id='$arr_ids[$i]' ");
      
      $_SESSION["msg"]="selected brands are deleted. ";
      
    }


         //db_query("delete from  tbl_header where header_id in ($str_ids)");
      }

		
	}

}


$start = intval($start);
$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;

$order_by == '' ? $order_by = 'filter_id' : true;
$order_by2 == '' ? $order_by2 = 'desc' : true;
 
$sql = "select * from  tbl_vehicle_filter  where 1 and parent_id='0' ";
$sql = apply_filter($sql, $testimonial_name, 'like','vehicle_brand_name');
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
                                 <h4>Brand List</h4>
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
                                       <th class="text-center">Brand Name</th>   
                                       <th class="text-center">Model</th>   
                                       
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
                            

                                     
<td class="text-center v-middle">
<p><?=$line_raw["vehicle_brand_name"]?></p>
</td>

<td class="text-center v-middle">

<a href="vehicle_model.php?brand_id=<?=$line_raw["filter_id"]?>">
    <button type="button" class="btn btn-info btn-outline btn-rounded w-md m-b-5"><i class="fa fa-plus">&nbsp;&nbsp;</i></span>Add/Edit Model</button></a>
</td>



<td class="text-center v-middle">
<?php if($line_raw["vehicle_status"]=="Active"){?>
<a href="vehicle_brand_model.php?st=1&pid=<?=$line_raw["filter_id"]?>"><span class="label-custom label label-default">Active</span></a>
<?php }else{?>
<a href="vehicle_brand_model.php?st=0&pid=<?=$line_raw["filter_id"]?>"><span class="label-danger label label-default">Inactive</span></a>
<?php }?>

</td>
 



<td class="text-center v-middle">
<a href="vehicle_brand_model.php?edit_id=<?=$line_raw["filter_id"]?>"><button type="button" class="btn btn-add btn-sm" ><i class="fa fa-pencil"></i></button>
</a>                                          
</td>


<td class="text-center v-middle"><input name="arr_ids[]" type="checkbox" id="arr_ids[]" value="<?=$filter_id?>" /></td>                                           
                                       
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
<?php require_once("footer.php"); ?>
 