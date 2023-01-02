<?php require_once("header.php");?>
<?php require_once("left-nav.php");?>
<?php require_once ('../includes/photoshop.php');?>
<?php
$invoice_product_id=trim($_REQUEST['id']);



if(is_post_back()){
//*************** UPDATE EXISTING CATEGORY START ************************//

if($_REQUEST['id']!='0') {


$sql = "update tbl_invoice_product set        
        invoice_product_name='$invoice_product_name',
        invoice_product_description='$invoice_product_description',
        invoice_product_price='$invoice_product_price',
				invoice_product_update_date='$curr_date',
				invoice_product_status='$invoice_product_status'
				where invoice_product_id = '$invoice_product_id' ";

db_query($sql);


$_SESSION["msg"]="Product/Service updated successfully !";
header("Location:add-edit-invoice-product.php?id=$_REQUEST[id]");
exit;
//*************** UPDATE EXISTING CATEGORY END ************************//
}else{

$sql = "insert into tbl_invoice_product set        
				invoice_product_name='$invoice_product_name',
				invoice_product_description='$invoice_product_description',
				invoice_product_price='$invoice_product_price',
				invoice_product_add_date='$curr_date',
				invoice_product_status='$invoice_product_status'";
db_query($sql);
$_SESSION["msg"]="Product/Service added successfully !";
header("Location:add-edit-invoice-product.php?id=$_REQUEST[id]");
exit;
//*************** INSERT NEW CATEGORY END ************************//
 }
}

if($invoice_product_id!='') {
	$result = db_query("select * from tbl_invoice_product where invoice_product_id = '$invoice_product_id'");
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
                  <i class="fa fa-tag" aria-hidden="true"></i>

               </div>
               <div class="header-title">
                  <h1>Add/Edit Product/Service</h1>
                  <small>Add/Edit Product/Service Content</small>
                  
                  
<a href="manage-invoice-product.php"><button id="btn-go-back" type="button" class="btn btn-labeled btn-inverse m-b-5 pull-right">
<span class="btn-label" ><i class="fa fa-chevron-circle-left"></i></span>Go Back
</button></a>

                  
               </div>
               
               
            </section>
            <!-- Main content -->
<script src="../ckeditor/ckeditor.js"></script>            
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
                                 <h4>Product/Service Information</h4>
                              </a>
                           </div>
                        </div>
                        <div class="panel-body">
<form name="form1" method="post" onsubmit="return formValidation()" enctype="multipart/form-data" class="col-sm-12" >
                              


                            
<!-- <div class="form-group col-lg-3">
<label>Testimonial Image</label>
<?php if($test_image_name!=""){ ?>
<img src="../test_images/<?=$test_image_name?>" class="form-control" style="width:150px;height:150px" />
<?php }else{?>
<img src="assets/dist/img/no-image.jpg" class="form-control" style="width:120px;height:150px" />
<?php }?>

<?php if($test_image_name!=""){ ?>
<div class="col-lg-12 " ><a href="add-edit-testimonial.php?delImage=<?=$test_image_name?>&test_id=<?=$test_id?>" style="font-weight:600;margin-left:15px;text-decoration:underline" >Remove Image</a>                  
</div>
<?php }?>

</div>

<div class="form-group col-lg-9" style="padding-top:100px">
<input type="file" name="file" id="file" />
<p style="color:red; font-weight: bold; font-size: 11px;">Image Size: 225*225</p>
</div> -->

<div class="clearfix"></div>



<div class="form-group col-lg-6">
<label>Product/Service Name</label>
<input type="text" class="form-control" placeholder="Enter Name" name="invoice_product_name" id="invoice_product_name"  value="<?=$invoice_product_name?>">
</div>


<div class="form-group col-lg-6">
<label>Price</label>
<input type="text" class="form-control" placeholder="Enter Price" name="invoice_product_price" id="invoice_product_price"  value="<?=$invoice_product_price?>">
</div>

<div class="form-group col-lg-12 " >
<label>Description</label>
<textarea class="form-control" name="invoice_product_description" rows="3" placeholder="Enter Description" id="" style="width:98%; resize:none;"><?=$invoice_product_description?></textarea>
</div>
             
                           
<div class="form-group col-lg-3">
 <label>Status</label>
 
<select name="invoice_product_status" class="form-control" >
                      <option value="Active" <?php if($invoice_product_status=='Active'){ ?> selected="selected" <? } ?>>Active</option>
                      <option value="Inactive" <?php if($invoice_product_status=='Inactive'){ ?> selected="selected" <? } ?>>Inactive</option>
                    </select>


</div>                             
       


                             
                             
                            
                              
                              
                             
                              <div class="col-lg-12 reset-button">
                                                                 
                                 <button type="submit" class="btn btn-add">Submit</button>
                                
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
 