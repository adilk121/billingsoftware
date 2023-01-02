<?php require_once("header.php");?>
<?php require_once("left-nav.php");?>
<?php
$resprd_id=$_REQUEST['resprd_id'];
?>
<style>
span#marginPercentage {
    margin: -26px 0 0 0;
    float: right;
}
</style>
<?php
if(isset($_REQUEST['update'])){

$resprd_prd_name=db_scalar("SELECT category_name FROM tbl_category WHERE category_id='$resprd_prd_id' ");
$resprd_prd_margin=($resprd_prd_margin_amount/$resprd_prd_real_price)*100;

$sql = "update tbl_reseller_products set 
                resprd_reseller_id='$resprd_reseller_id',
				resprd_maincat_id='$resprd_maincat_id',
				resprd_cat_id='$resprd_cat_id',
				resprd_prd_id='$resprd_prd_id',		
				resprd_prd_name='$resprd_prd_name',						
				resprd_prd_real_price='$resprd_prd_real_price',	
				resprd_prd_margin='$resprd_prd_margin',								
				resprd_prd_margin_amount='$resprd_prd_margin_amount',				
				resprd_prd_display_price='$resprd_prd_display_price',	
				resprd_prd_add_date='".date("Y-m-d")."',
				resprd_prd_status='$resprd_prd_status'
				where resprd_id='$resprd_id'
				";
				
db_query($sql);
$_SESSION["msg"]="Product updated successfully !";
header("Location:edit-reseller-product.php?resprd_id=$resprd_id");
exit;
//*************** INSERT NEW CATEGORY END ************************//

}

if($resprd_id!='') {
	$result = db_query("select * from tbl_reseller_products where resprd_id = '$resprd_id'");
	$prdRes = mysqli_fetch_array($result);
}
?>



         <!-- Content Wrapper. Contains page content -->
         <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
               <div class="header-icon">
                  <i class="fa fa-pencil-square-o" aria-hidden="true"></i>

               </div>
               <div class="header-title">
                  <h1>Edit Reseller Product</h1>
                  <small>Edit reseller product content</small>
                  
                  
<a href="reseller_product_list.php"><button id="btn-go-back" type="button" class="btn btn-labeled btn-inverse m-b-5 pull-right">
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
                                 <h4>General Information
                                 
<i class="fa fa-angle-double-right" ></i>
<span style="margin-left:5px; font-size:16px;color:#8e32a2c7">
<?php
$sql="SELECT resprd_prd_name FROM tbl_reseller_products WHERE 1 AND resprd_id='$resprd_id'";
echo db_scalar($sql);
?>
</span>


                                 
                                 
                                 </h4>
                              </a>
                           </div>
                        </div>
                        <div class="panel-body">
<form name="form1" method="post" onsubmit="return formValidation()" enctype="multipart/form-data" class="col-sm-10 col-lg-offset-1" >
                              

<div class="form-group col-lg-12">
<label>Reseller</label>

<?php  
$sql="SELECT * FROM tbl_resellers ORDER BY reseller_name";
$dataRes=db_query($sql);
$countRes=mysqli_num_rows($dataRes);
?>
<select class="form-control" name="resprd_reseller_id" id="resprd_reseller_id" >
<option>Choose Reseller</option>
<?php if($countRes>0){?>
<?php while($recRes=mysqli_fetch_array($dataRes)){?>
<option  value="<?=$recRes['reseller_id']?>" <?php if($prdRes['resprd_reseller_id']==$recRes['reseller_id']){?> selected <?php }?>><?=$recRes['reseller_name']?></option>
<?php }?>

<?php }else{?>
<option  value="0">No Reseller Found</option>
<?php }?>

</select>


</div>
                                       
           
                            


<div class="form-group col-lg-12">
<label>Main Category Name</label>

<?php  
$sql="SELECT * FROM tbl_category WHERE 1 AND category_parent_id='0' ORDER BY category_name";
$dataMain=db_query($sql);
$countMain=mysqli_num_rows($dataMain);
?>
<select class="form-control" name="resprd_maincat_id" id="resprd_maincat_id" onChange="load_sub_cat(this.value)" >
<option>Choose Main Category</option>
<?php if($countMain>0){?>
<?php while($recMain=mysqli_fetch_array($dataMain)){?>
<option  value="<?=$recMain['category_id']?>" <?php if($prdRes['resprd_maincat_id']==$recMain['category_id']){?> selected <?php }?>><?=$recMain['category_name']?></option>
<?php }?>

<?php }else{?>
<option  value="0">No Category Found</option>
<?php }?>

</select>


</div>
                                       
                                       
                                       
<div class="form-group col-lg-12">
<label>Sub Category Name</label>

<div id="sub-cat-load">
<?php  
$sql="SELECT * FROM tbl_category WHERE 1 AND category_parent_id='$prdRes[resprd_maincat_id]' ORDER BY category_name";
$dataMain=db_query($sql);
$countMain=mysqli_num_rows($dataMain);
?>
<select class="form-control" name="resprd_cat_id" id="resprd_cat_id"  onChange="load_prd(this.value)" >
<option>Choose Main Category</option>
<?php if($countMain>0){?>
<?php while($recMain=mysqli_fetch_array($dataMain)){?>
<option  value="<?=$recMain['category_id']?>" <?php if($prdRes['resprd_cat_id']==$recMain['category_id']){?> selected <?php }?>><?=$recMain['category_name']?></option>
<?php }?>

<?php }else{?>
<option  value="0">No Category Found</option>
<?php }?>

</select>

</div>

</div>


<div class="form-group col-lg-12">
<label>Product Name</label>


<div id="prd-load">
<?php  
$sql="SELECT * FROM tbl_category WHERE 1 AND category_parent_id='$prdRes[resprd_cat_id]' ORDER BY category_name";
$dataMain=db_query($sql);
$countMain=mysqli_num_rows($dataMain);
?>
<select class="form-control" name="resprd_prd_id" id="resprd_prd_id"  onChange="load_img(this.value)" >
<option>Choose Product</option>
<?php if($countMain>0){?>
<?php while($recMain=mysqli_fetch_array($dataMain)){?>
<option  value="<?=$recMain['category_id']?>" <?php if($prdRes['resprd_prd_id']==$recMain['category_id']){?> selected <?php }?>><?=$recMain['category_name']?></option>
<?php }?>

<?php }else{?>
<option  value="0">No Product Found</option>
<?php }?>

</select>

</div>

</div>
         
         

<div class="form-group col-lg-12">
<label>Image</label>

<?php  
$sql="SELECT category_image_name FROM tbl_category WHERE 1 AND category_id='$prdRes[resprd_prd_id]' ";
$img=db_scalar($sql);
?>

<div id="img-load">
<?php if($img!=""){?>
<img src="../uploaded_files/home_cat_thumb/<?=$img?>" style="width:175px;height:175px;border:solid thin #ccc;" >
<?php }else{?>
<img src="assets/dist/img/no-image.jpg" style="width:175px;height:175px" >
<?php }?>
</div>

</div>
                                                
                                                                                
                                         
                                         
<div class="form-group col-lg-3">
<label> Real Price (INR) </label>
<div id="load-price">
<input type="text" class="form-control" placeholder="Enter product price" name="resprd_prd_real_price" id="resprd_prd_real_price"    value="<?=$prdRes['resprd_prd_real_price']?>">
</div>

</div>
                              
                              
                              
                              
<div class="form-group col-lg-3">
<label> Display Price (INR)</label>


<input type="text" class="form-control" placeholder="Enter display price" name="resprd_prd_display_price" id="resprd_prd_display_price" onBlur="fill_margin()"  value="<?=$prdRes['resprd_prd_display_price']?>">


</div>                              


<div class="form-group col-lg-4">
<label> Margin Amount (INR)</label>
<input type="text" class="form-control" placeholder="Enter margin amount" name="resprd_prd_margin_amount" id="resprd_prd_margin_amount"   value="<?=$prdRes['resprd_prd_margin_amount']?>" style="width:85%"> <span id="marginPercentage" class="bold pull-right" style="color:#06F;"><?=$prdRes['resprd_prd_margin']?>%</span>
</div>                              
                              
                              
                              
                              

                                                                                                   
                            
                             
                         
                           
                           
<div class="form-group col-lg-3">
 <label>Status</label>
 
<select name="resprd_prd_status" class="form-control" >
                      <option value="Active" <?php if($prdRes['resprd_prd_status']=='Active'){ ?> selected="selected" <? } ?>>Active</option>
                      <option value="Inactive" <?php if($prdRes['resprd_prd_status']=='Inactive'){ ?> selected="selected" <? } ?>>Inactive</option>
                    </select>


</div> 

                         
<input type="hidden" name="resprd_id" value="<?=$_REQUEST['resprd_id']?>" />
                          
                              
                             
                              <div class="col-lg-12 reset-button">
                                                                 
                                 <button type="submit" name="update" class="btn btn-add">Update</button>
                                
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
<script>
function load_sub_cat(mainCatID){
$('#sub-cat-load').fadeOut('slow').load('load-subcat.php?mainCatID='+mainCatID).fadeIn("slow");			  	
}

function load_prd(Prd){
$('#prd-load').fadeOut('slow').load('load-prd.php?Prd='+Prd).fadeIn("slow");			  	
}

function load_img(imgID){
$('#img-load').fadeOut('slow').load('load-prd-img.php?imgID='+imgID).fadeIn("slow");			  	
$('#load-price').fadeOut('slow').load('load-prd-price.php?Prd='+imgID).fadeIn("slow");			  	
}

function fill_margin(){
dp=$('#resprd_prd_display_price').val();	
rp=$('#resprd_prd_real_price').val();	

amnt=dp-rp;

$("#resprd_prd_margin_amount").val(amnt);

$("#marginPercentage").show("fast");

var per=(amnt/rp)*100;

per=Math.round(per);

$("#marginPercentage").text(per+"%");



}


</script>