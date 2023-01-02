<?php require_once("header.php");?>
<?php require_once("left-nav.php");?>
<style>
span#marginPercentage {
    margin: -26px 0 0 0;
    float: right;
}
</style>
<?php
if(isset($_REQUEST['submit'])){

$resprd_prd_name=db_scalar("SELECT category_name FROM tbl_category WHERE category_id='$resprd_prd_id' ");
$resprd_prd_margin=($resprd_prd_margin_amount/$resprd_prd_real_price)*100;

$sql = "insert into tbl_reseller_products set 
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
				";
				
db_query($sql);
$_SESSION["msg"]="Product added successfully !";
header("Location:addedit-reseller-product.php");
exit;
//*************** INSERT NEW CATEGORY END ************************//

}

if($res_id!='') {
	$result = db_query("select * from tbl_reseller_products where resprd_id = '$resprd_id'");
	if ($line_raw = mysqli_fetch_array($result)) {extract($line_raw);
	}
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
                  <h1>Add Reseller Product</h1>
                  <small>Add reseller product content</small>
                  
                  
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
                                 <h4>General Information</h4>
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
<option  value="<?=$recRes['reseller_id']?>"><?=$recRes['reseller_name']?></option>
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
<option  value="<?=$recMain['category_id']?>"><?=$recMain['category_name']?></option>
<?php }?>

<?php }else{?>
<option  value="0">No Category Found</option>
<?php }?>

</select>


</div>
                                       
                                       
                                       
<div class="form-group col-lg-12">
<label>Sub Category Name</label>


<div id="sub-cat-load">
<select class="form-control" name="resprd_cat_id" id="resprd_cat_id"  onChange="load_prd(this.value)">
<option>Choose Sub Category</option>
</select>
</div>

</div>


<div class="form-group col-lg-12">
<label>Product Name</label>


<div id="prd-load">
<select class="form-control" name="resprd_prd_id" id="resprd_prd_id"  >
<option>Choose Product</option>
</select>
</div>

</div>
         
         

<div class="form-group col-lg-12">
<label>Image</label>


<div id="img-load">
<img src="assets/dist/img/no-image.jpg" style="width:175px;height:175px" >
</div>

</div>
                                                
                                                                                
                                         
                                         
<div class="form-group col-lg-3">
<label> Real Price (INR) </label>
<div id="load-price">
<input type="text" class="form-control" placeholder="Enter product price" name="resprd_prd_real_price" id="resprd_prd_real_price" readonly   value="<?=$resprd_prd_real_price?>">
</div>

</div>
                              
                              
                              
                              
<div class="form-group col-lg-3">
<label> Display Price (INR)</label>


<input type="text" class="form-control" placeholder="Enter display price" name="resprd_prd_display_price" id="resprd_prd_display_price" onBlur="fill_margin()"  value="">


</div>                              


<div class="form-group col-lg-4">
<label> Margin (INR)</label>
<input type="text" class="form-control" placeholder="Enter margin amount" name="resprd_prd_margin_amount" id="resprd_prd_margin_amount"  readonly value="" style="width:85%"> <span id="marginPercentage" class="bold pull-right" style="color:#06F;display:none"></span>
</div>                              
                              
                              
                              
                              

                                                                                                   
                            
                             
                         
                           
                           
<div class="form-group col-lg-3">
 <label>Status</label>
 
<select name="resprd_prd_status" class="form-control" >
                      <option value="Active" <?php if($resprd_prd_status=='Active'){ ?> selected="selected" <? } ?>>Active</option>
                      <option value="Inactive" <?php if($resprd_prd_status=='Inactive'){ ?> selected="selected" <? } ?>>Inactive</option>
                    </select>


</div> 

                         
       


                             
                             
                          
                              
                             
                              <div class="col-lg-12 reset-button">
                                                                 
                                 <button type="submit" name="submit" class="btn btn-add">Submit</button>
                                
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