<?php require_once("header.php");?>
<?php require_once("left-nav.php");?>
<style>
.v-middle {
vertical-align:middle !important;
}
span.new-lbl {
    background: #FFEB3B;
    padding: 1px 5px 1px 5px;
    font-size: 11px;
    font-weight: 600;
    color: red;
    border: solid thin #f0df4d;
    position: relative;
    top: -12px;
}
</style>
<?php
$catID=$_REQUEST['catid'];
$subcatid=$_REQUEST['subcatid'];
?>
<?php
if($st!=""){
$st=$_REQUEST['st'];
$subcatID=$_REQUEST['pid'];

if($st==1){
$sql="UPDATE tbl_category SET category_status='Inactive' WHERE category_id='$subcatID' ";	
$res=db_query($sql);	
if($res>0){
$_SESSION["msg"]="Selected property is deactivated successfully.";	
}	
}else{
$sql="UPDATE tbl_category SET category_status='Active' WHERE category_id='$subcatID' ";	
$res=db_query($sql);	
if($res>0){
$_SESSION["msg"]="Selected property is activated successfully.";	
}	
	
}

header("location:product_list.php?subcatid=$subcatid&catid=$catid");
exit;
}

 if(isset($_REQUEST['Delete'])){
if(is_array($_REQUEST['arr_ids'])){

$check=$_REQUEST['arr_ids'];
$SUB=count($check);

function del_sub($CAT){
$select=db_query("select * from tbl_category where category_parent_id='$CAT'");

while($SQL=mysqli_fetch_array($select)){
del_sub($SQL['category_id']);
$delete=db_query("delete from tbl_category where category_parent_id='$SQL[category_id]'");
//DELETE SUB CATEGORY AND PRODUCTS MORE IMAGES START
$del_image=db_query("delete from tbl_category_image where category_image_cat_id='$SQL[category_id]'");
//DELETE SUB CATEGORY AND PRODUCTS MORE IMAGES END
}
//DELETE ALL CATEGORY MORE IMAGES FROM FOLDER START
$img_selct=db_query("select category_image_id,category_image_name from  tbl_category_image where 1 and category_image_cat_id='$CAT'");
while($sqlsel=mysqli_fetch_array($img_selct)){
$imgName = $sqlsel['category_image_name'];
@unlink("../category_more_images/$imgName");
}
//DELETE ALL CATEGORY MORE IMAGES FROM FOLDER END
//DELETE ALL CATEGORY IMAGES FROM FOLDER START
$ct_img = mysqli_fetch_array(db_query("select category_image_name from tbl_category where category_id='$CAT'"));
@unlink("../uploaded_files/$ct_img[category_image_name]");
//@unlink("../uploaded_files/home_cat_thumb/$ct_img[category_image_name]");
//DELETE ALL CATEGORY IMAGES FROM FOLDER END
$del=db_query("delete from tbl_category where category_id='$CAT'");
$del_img=db_query("delete from tbl_category_image where category_image_cat_id='$CAT'");

}
for($x=0;$x<$SUB;$x++){
del_sub($check[$x]);
}
}

$_SESSION["msg"]="Selected property is deleted successfully.";	
header("Location: ".$_SERVER['HTTP_REFERER']);
exit;
}


if(is_post_back()) {
	$arr_ids = $_REQUEST['arr_ids'];
	if(is_array($arr_ids)) {
		$str_ids = implode(',', $arr_ids); 
		if(isset($_REQUEST['Activate']) || isset($_REQUEST['Activate_x']) ) {
			db_query("update tbl_category set category_status='Active' where category_id in ($str_ids)");
			$_SESSION["msg"]="selected properties are activated. ";
		} else if(isset($_REQUEST['Deactivate']) || isset($_REQUEST['Deactivate_x']) ) {
			db_query("update tbl_category set category_status='Inactive' where category_id in ($str_ids)");
						$_SESSION["msg"]="selected properties are deactivated. ";
		}/* else if(isset($_REQUEST['make_special']) || isset($_REQUEST['make_special_x']) ) {
			db_query("update tbl_category set category_is_special='Yes' where category_id in ($str_ids)");
						$_SESSION["msg"]="selected categories are set for special. ";
		} else if(isset($_REQUEST['remove_special']) || isset($_REQUEST['remove_special_x']) ) {
			db_query("update tbl_category set category_is_special='No' where category_id in ($str_ids)");
						$_SESSION["msg"]="selected categories are removed from special. ";
		}*/ else if(isset($_REQUEST['make_residential_properties']) || isset($_REQUEST['make_residential_properties_x']) ) {
			db_query("update tbl_category set category_is_residential_properties='Yes' where category_id in ($str_ids)");
						$_SESSION["msg"]="selected properties are set for residential properties. ";
		} else if(isset($_REQUEST['remove_residential_properties']) || isset($_REQUEST['remove_residential_properties_x']) ) {
			db_query("update tbl_category set category_is_residential_properties='No' where category_id in ($str_ids)");
						$_SESSION["msg"]="selected properties are removed from residential properties. ";
		} else if(isset($_REQUEST['make_featured']) || isset($_REQUEST['make_featured_x']) ) {
			db_query("update tbl_category set category_is_featured='Yes' where category_id in ($str_ids)");
						$_SESSION["msg"]="selected properties are set for featured. ";
		} else if(isset($_REQUEST['remove_featured']) || isset($_REQUEST['remove_featured_x']) ) {
			db_query("update tbl_category set category_is_featured='No' where category_id in ($str_ids)");
						$_SESSION["msg"]="selected properties are removed from featured. ";
		}		else if(isset($_REQUEST['set_on_slider']) || isset($_REQUEST['set_on_slider_x']) ) {
			db_query("update tbl_category set category_set_slider='Yes' where category_id in ($str_ids)");
						$_SESSION["msg"]="selected properties are set on slider. ";
		} else if(isset($_REQUEST['remove_from_slider']) || isset($_REQUEST['remove_from_slider_x']) ) {
			db_query("update tbl_category set category_set_slider='No' where category_id in ($str_ids)");
						$_SESSION["msg"]="selected properties are removed from slider. ";
		}
		/* else if(isset($_REQUEST['set_for_home']) || isset($_REQUEST['set_for_home_x']) ) {
      db_query("update tbl_category set category_for_home='Yes' where category_id in ($str_ids)");
            $_SESSION["msg"]="selected categories are set for home. ";
    } else if(isset($_REQUEST['remove_home']) || isset($_REQUEST['remove_home_x']) ) {
      db_query("update tbl_category set category_for_home='No' where category_id in ($str_ids)");
            $_SESSION["msg"]="selected categories are remove from home. ";
    }*/

		
	}
/*	if(isset($_REQUEST['Update'])){
		foreach($category_order_by as $key=>$value){
		db_query("update tbl_category set category_order_by='$value' where category_id='$key'");
		}
		$_SESSION["msg"]="Selected category order is set.";
	}*/
		
	header("Location: ".$_SERVER['HTTP_REFERER']);
	exit;
}


$start = intval($start);
$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;

$order_by == '' ? $order_by = 'category_status' : true;
$order_by2 == '' ? $order_by2 = 'asc' : true;
 
$sql = "select * from  tbl_category   where 1 AND category_parent_id='$subcatid'";
$sql = apply_filter($sql, $category_name, 'like','category_name');
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
                  <i class="fa fa-list" aria-hidden="true"></i>

               </div>
               <div class="header-title">
                  <h1>Property</h1>
                  <small>Property List</small>

                      
<?php /*?> <a href="import/index.php?cat=<?=$_REQUEST['subcatid']?>" target="_blank"><button id="btn-go-back" type="button" class="btn btn-warning m-b-5 pull-right ml10">
Import CSV
</button></a>  <?php */?>                
                 
                 
                 
                  <a href="addedit-product.php?id=0&subcatid=<?=$subcatid?>&catid=<?=$catID?>"><button id="btn-go-back" type="button" class="btn btn-labeled btn-inverse m-b-5 pull-right">
<span class="btn-label"><i class="fa fa-plus" aria-hidden="true"></i>
</span>Add Property
</button></a>
          
          
          <span class="count-num">Total : <?=db_scalar("SELECT COUNT(category_id) FROM tbl_category WHERE 1 AND category_parent_id='$subcatid'")?></span>    
          
          
<a href="subcat_list.php?catID=<?=$catID?>" class="btn btn-link" style="float: right;
    font-size: 14px;
    margin: -20px 18px 0 0;
    border: solid thin #337ab785;"><i class="fa fa-chevron-circle-left" aria-hidden="true"></i>
Go Back</a>       
              
                             
 
           
               </div>


         
               
            </section>
            
            <!-- Main content -->
            <section class="content">
               <div class="row">
                  
                  
        <!--        <div class="col-md-6 col-md-offset-4" >
                     <form enctype="multipart/form-data" action="importData1.php" method="post">
                      
                        <div>
                          <input type="file" name="file" id="file" style="float:left;"/>
                       <input type="hidden" name="subcatid" value="<?=$_REQUEST['subcatid']?>">
                       <input type="hidden" name="catid" value="<?=$_REQUEST['catid']?>">
                       
                       
                        <input type="submit" value="Upload File" name="importSubmit" id="upload" class="upload"/>
                         </div>
                        
                      </form>
                     </div>
                     <br>-->
                    
<?php if($_SESSION["msg_csv"]=="succ"){
?>
<div class="alert alert-success alert-dismissable fade in text-center" style="background-color:#dff0d8;border:none; color:#000;margin:10px 0 0 0">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Success !&nbsp;&nbsp;&nbsp;</strong>
    File Uploaded Successfully
  </div>
  <?
    unset($_SESSION["msg_csv"]);
    }else if($_SESSION["msg_csv"]=="err"){?>
  <div class="alert alert-alert alert-dismissable fade in text-center" style="background-color:red;border:none; color:white;margin:10px 0 0 0">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Error !&nbsp;&nbsp;&nbsp;</strong>
    File Could Not Uploaded !
  </div>
  <?   
  unset($_SESSION["msg_csv"]);
  }else if($_SESSION["msg_csv"]=="invalid_file"){?>
    <div class="alert alert-alert alert-dismissable fade in text-center" style="background-color:red;border:none; color:white;margin:10px 0 0 0">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Invalid !&nbsp;&nbsp;&nbsp;</strong>
    Invalid File !
  </div>
  <? 
    unset($_SESSION["msg_csv"]);
      
  }
 
  ?>
  


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
                                 <h4>Property List <i class="fa fa-angle-double-right" ></i>
                                 
<!--<span style="margin-left:5px; font-size:16px;color:#8e32a2c7"><?=db_scalar("SELECT category_name FROM tbl_category WHERE 1 AND category_id='$catID'")?></span> &nbsp;&nbsp;

<i class="fa fa-angle-double-right" ></i>-->
                                 
<span style="margin-left:5px; font-size:16px;color:#8e32a2c7"><?=db_scalar("SELECT category_name FROM tbl_category WHERE 1 AND category_id='$subcatid'")?></span>
                                 
                                 </h4>
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
                                       <th class="text-center">Image</th>            
                                       <th class="text-center">Name</th>  
                                       <th class="text-center">City</th>  
                                       
                                       <th class="text-center">Status</th>
                                   <!--      <th class="text-center">Order By</th>-->
                                       <th class="text-center">More Images</th>
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
                            
                             <td align="center" >
<?php if($category_image_name!=""){?>

 <?//=SITE_WS_PATH?>
<img src="../uploaded_files/<?=$category_image_name?>"  class="thumbnail" style="width:65px;height:65px; margin-top:0;margin-bottom:0" />
<?php }else{?>
<img src="assets/dist/img/Noimage.png"  class="thumbnail" style="width:65px;height:65px; margin-top:0;margin-bottom:0" />
<?php }?>

<?php if($category_for_home=='Yes'){?>
<span class="new-lbl">Home</span>                             
<?php }?>

<?php if($category_is_residential_properties=='Yes'){?>
<span class="new-lbl">Residential Properties</span>                             
<?php }?>




<?php if($category_is_featured=='Yes'){?>
<span class="new-lbl">Featured</span>                             
<?php } ?>

<?php if($category_set_slider=='Yes'){?>
<span class="new-lbl">Slider</span>                             
<?php } ?>



                             
                             </td>
                                     
<td class="text-left v-middle " style="padding-left:20px">

<?=$line_raw["category_name"]?> </td>

<td class="text-center v-middle " style="padding-left:20px">

<?=$line_raw["category_city"]?> </td>


                                     

<td class="text-center v-middle">
<?php if($line_raw["category_status"]=="Active"){?>
<a href="product_list.php?st=1&pid=<?=$line_raw["category_id"]?>&subcatid=<?=$subcatid?>&catid=<?=$catid?>"><span class="label-custom label label-default">Active</span></a>
<?php }else{?>
<a href="product_list.php?st=0&pid=<?=$line_raw["category_id"]?>&subcatid=<?=$subcatid?>&catid=<?=$catid?>"><span class="label-danger label label-default">Inactive</span></a>
<?php }?>

</td>
<!--<td class="v-middle" align="center">
<input type="text" name="category_order_by[<?=$category_id?>]" id="category_order_by[<?=$category_id?>]"  value="<?=$category_order_by?>" class="form-control" style="width:40px"  />
</td>-->



<td class="v-middle" align="center">
<?php /*?><a href="addedit-stock.php?cat_id=<?=$line_raw["category_id"]?>&subcatid=<?=$subcatid?>&catid=<?=$catid?>">
<button type="button" class="btn btn-default" style="height: 34px;width: 162px;margin: 0 0 7px 0;background: #009e38;
    color: #fff;font-weight: 600;" >
<i class="fa fa-plus pull-left " style="background: #0e5f22;padding: 7px 10px;margin: -3px 0 0 -9px;"></i> Add Stock
</button>
</a><br><?php */?>


<a href="category_image_list.php?cat_id=<?=$line_raw["category_id"]?>&subcatid=<?=$subcatid?>&catid=<?=$catid?>">
<button type="button" class="btn btn-labeled btn-pink m-b-5">
<span class="btn-label"><i class="fa fa-image"></i></span>Upload Images
</button>
</a>


</td>



<td class="text-center v-middle">
<!--<a href="manage_colors.php?cat_id=<?=$category_id?>" target="_blank"><button type="button" class="btn btn-info bold btn-sm" >COLORS</button>
</a>                                          


<a href="manage_sizes.php?cat_id=<?=$category_id?>" target="_blank"><button type="button" class="btn btn-warning bold btn-sm" >SIZE</button>
</a>   -->                                     


<a href="addedit-product.php?id=<?=$category_id?>&subcatid=<?=$subcatid?>&catid=<?=$catID?>"><button type="button" class="btn btn-add btn-sm" ><i class="fa fa-pencil"></i></button>
</a>                                          

</td>


<td class="text-center v-middle"><input name="arr_ids[]" type="checkbox" id="arr_ids[]" value="<?=$category_id?>" /></td>                                           
                                       
                                    </tr>
<?php
}
?>
                                    
<tr> <td colspan="8">


<?php //if($_SESSION['sess_admin_type']=='Admin'){ ?>

<button  style="background-color:#CA0000;border:solid #CA0000" type="submit" name="Delete" onClick="return select_chk()"  class="btn btn-primary pull-left ml5 " >Delete</button>

<? //} ?>

<!--<button type="submit" name="remove_home" style="background-color:#FF3;border:#FF3;color:#000" class="btn btn-success pull-right mr5 ml5 pull-left" >Remove From Home</button>

<button type="submit" name="set_for_home" style="background-color:#FF3;border:#FF3;color:#000" class="btn btn-success pull-right ml5 mr5 pull-left" >Set For Home</button>
-->

<!-- 


<button type="submit" name="remove_special" style="background-color:#FF3;border:#FF3;color:#000" class="btn btn-success pull-right mr5" >Remove Special</button>

<button type="submit" name="make_special" style="background-color:#FF3;border:#FF3;color:#000" class="btn btn-success pull-right mr5" >Make Special</button>
 -->
<button type="submit" name="remove_residential_properties" style="background-color:#FF3;border:#FF3;color:#000" onClick="return select_chk()" class="btn btn-success pull-right mr5 ml5 pull-left" >Remove Residential Properties</button>

<button type="submit" name="make_residential_properties" style="background-color:#FF3;border:#FF3;color:#000" onClick="return select_chk()" class="btn btn-success pull-right ml5 mr5 pull-left" >Make Residential Properties</button>


<button type="submit" name="remove_featured"  class="btn btn-warning pull-right mr5" onClick="return select_chk()" >Remove Featured</button>

<button type="submit" name="make_featured" class="btn btn-warning pull-right mr5" onClick="return select_chk()">Make Featured</button>



<!--<button type="submit" name="Update"  class="btn btn-primary pull-right ml5 " >Update Order</button>
-->

<button type="submit" name="Deactivate"  class="btn btn-danger pull-right mr5" onClick="return select_chk()">Make Inactive</button>

<button type="submit" name="Activate" class="btn btn-success pull-right mr5" onClick="return select_chk()">Make Active</button>


</td></tr>       


<tr> <td colspan="8">
    <button type="submit" name="remove_from_slider"  class="btn btn-warning pull-right mr5" onClick="return select_chk()" >Remove From Slider</button>

<button type="submit" name="set_on_slider" class="btn btn-warning pull-right mr5" onClick="return select_chk()">Set On Slider</button>

    
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