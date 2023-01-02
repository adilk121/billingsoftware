<?php require_once("header.php");?>
<?php require_once("left-nav.php");?>
<?php require_once ('../includes/photoshop.php');?>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script>
/*$(function() {
    $("#category_company_name").autocomplete({
        source: "company_name_autocomplete.php",
        
    });
});

$(function() {
    $("#category_model_number").autocomplete({
        source: "model_number_autocomplete.php",
        
    });
});

$(function() {
    $("#category_variant").autocomplete({
        source: "variant_autocomplete.php",
        
    });
});*/

</script>



<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/css/bootstrap-multiselect.css">
<?php
$subcatid=trim($_REQUEST['subcatid']);
$category_id=trim($_REQUEST['id']);
$categoryID = trim($_GET['catid']);

if($_REQUEST['delImage']!=""){
$delImage=$_REQUEST['delImage'];
$isDel=db_query("UPDATE  tbl_category SET  category_image_name='' WHERE 1 and category_id = '$category_id'");	
@unlink("../uploaded_files/$delImage");
//@unlink("../uploaded_files/home_cat_thumb/$delImage");
//@unlink("../uploaded_files/prd_thumb/$delImage");

header("location:addedit-product.php?id=$category_id&subcatid=$subcatid&catid=$catid");
}

if(is_post_back()){
//*************** UPDATE EXISTING CATEGORY START ************************//
$imgNAME ="";

if($_REQUEST['id']!='0') {
$category_url=ami_crete_url($category_name);
////////////****************** IMAGE RESIZING START HERE *****************************//
//********** Code Created By Amitabh Kumar Sinha : Web Developer : Webkey Network Pvt. Ltd. *****************//
//**********  DATE : 31:07:2014 *****************//
//------------FUNCTION TO GET IMAGE EXTENSION START---------------//
 function getExtension($str) {
         $i = strrpos($str,".");
         if (!$i) { return ""; }
         $l = strlen($str) - $i;
         $ext = substr($str,$i+1,$l);
         return $ext;
 }
 //------------FUNCTION TO GET IMAGE EXTENSION END---------------//
if($_SERVER["REQUEST_METHOD"] == "POST"){
  
$image =$_FILES["file"]["name"];
$imgToDel=db_scalar("SELECT category_image_name FROM tbl_category WHERE  category_id='$category_id'");	

if($image){

@unlink("../uploaded_files/$imgToDel");
//@unlink("../uploaded_files/home_cat_thumb/$imgToDel");
//@unlink("../uploaded_files/prd_thumb/$imgToDel");

	
	$uploadedfile = $_FILES['file']['tmp_name']; 
    $filename = stripslashes($_FILES['file']['name']); 	
	$extension = getExtension($filename);
	$extension = strtolower($extension);		
	$imgNAME = substr(md5($category_url.time().rand(1,10)),0,14).".".$extension;	
	move_uploaded_file($_FILES['file']['tmp_name'],"../uploaded_files/$imgNAME");

///////////////////////////// FOR SMALL  THUMB AND LARGE IMAGE /////////////////////////
$image = new Zebra_Image(); 
$image->source_path = '../uploaded_files/'.$imgNAME; 
$ext = substr($image->source_path, strrpos($image->source_path, '.') + 1);
// indicate a target image
//$image->target_path = '../uploaded_files/home_cat_thumb/'.$imgNAME;
// resize
// and if there is an error, show the error message
if (!$image->resize(358, 358, ZEBRA_IMAGE_NOT_BOXED, -1)) show_error($image->error, $image->source_path, $image->target_path);
////////////////////////////////////////////////////////////////////////////////////////

//////////////////////////////// FOR SMALL  PRODUCT THUMB //////////////////////////////
$image = new Zebra_Image(); 
$image->source_path = '../uploaded_files/'.$imgNAME; 
$ext = substr($image->source_path, strrpos($image->source_path, '.') + 1);
// indicate a target image
//$image->target_path = '../uploaded_files/prd_thumb/'.$imgNAME;
// resize
// and if there is an error, show the error message
if (!$image->resize(100, 100, ZEBRA_IMAGE_BOXED, -1)) show_error($image->error, $image->source_path, $image->target_path);
////////////////////////////////////////////////////////////////////////////////////////



}else{
$imgNAME=$imgToDel;
}

}

////////////****************** IMAGE RESIZING END HERE *****************************//


 $discountAmount=$category_real_price-$category_discount_price;
 $category_discount_percentage=($discountAmount/$category_real_price)*100;
 /*$color_count=COUNT($_POST["colors"]);
 $c=$color_count-1;
 $i=0;
 // Check if any option is selected 
        if(isset($_POST["colors"]))  
        { 
          // Retrieving each selected option 
            foreach ($_POST['colors'] as $colors){
                 if($c==$i){
                     $color_arr.=$colors;    
                 }else{
                     $color_arr.=$colors.",";
                 }
                 
                 $i++;
            }  
                   
        }else{
            echo "<script>alert('Please select any color...');</script>";
        }*/

$sql = "update tbl_category set        
		     	category_name='$category_name',
                 category_areas_name='$category_areas_name',
				category_parent_id='$subcatid',
				category_image_name='$imgNAME',
				category_description='$category_description', 
				category_amount='$category_amount',
				category_amount_type='$category_amount_type',
					category_city='$category_city',
                category_meta_title='$category_meta_title',
				category_meta_description='$category_meta_description',
				category_meta_keywords='$category_meta_keywords',
				category_is_product='Yes',
				category_url='$category_url',
				category_status='$category_status'
				where category_id = '$category_id' ";
				

db_query($sql);
$_SESSION["msg"]="Property Updated Successfully !";
header("Location:addedit-product.php?id=$category_id&subcatid=$subcatid&catid=$catid");
exit;
//*************** UPDATE EXISTING CATEGORY END ************************//
}else{
$category_url=ami_crete_url($category_name);
//*************** INSERT NEW CATEGORY START ************************//
////////////****************** IMAGE RESIZING START HERE *****************************//
//********** Code Created By Amitabh Kumar Sinha : Web Developer : Webkey Network Pvt. Ltd. *****************//
//**********  DATE : 31:07:2014 *****************//
//------------FUNCTION TO GET IMAGE EXTENSION START---------------//
 function getExtension($str) {
         $i = strrpos($str,".");
         if (!$i) { return ""; }
         $l = strlen($str) - $i;
         $ext = substr($str,$i+1,$l);
         return $ext;
 }
 //------------FUNCTION TO GET IMAGE EXTENSION END---------------//
 if($_SERVER["REQUEST_METHOD"] == "POST"){


	
 	$image =$_FILES["file"]["name"];
	

if($image){
	
	$uploadedfile = $_FILES['file']['tmp_name']; 
    $filename = stripslashes($_FILES['file']['name']); 	
	$extension = getExtension($filename);
	$extension = strtolower($extension);		
	$imgNAME = substr(md5($category_url.time().rand(1,10)),0,14).".".$extension;	
	move_uploaded_file($_FILES['file']['tmp_name'],"../uploaded_files/$imgNAME");

///////////////////////////// FOR SMALL  THUMB AND LARGE IMAGE /////////////////////////
$image = new Zebra_Image(); 
$image->source_path = '../uploaded_files/'.$imgNAME; 
$ext = substr($image->source_path, strrpos($image->source_path, '.') + 1);
// indicate a target image
//$image->target_path = '../uploaded_files/home_cat_thumb/'.$imgNAME;
// resize
// and if there is an error, show the error message
if (!$image->resize(358, 358, ZEBRA_IMAGE_BOXED, -1)) show_error($image->error, $image->source_path, $image->target_path);
///////////////////////////////////////////////////////////////////////////////////////

//////////////////////////////// FOR SMALL  PRODUCT THUMB //////////////////////////////
$image = new Zebra_Image(); 
$image->source_path = '../uploaded_files/'.$imgNAME; 
$ext = substr($image->source_path, strrpos($image->source_path, '.') + 1);
// indicate a target image
//$image->target_path = '../uploaded_files/prd_thumb/'.$imgNAME;
// resize
// and if there is an error, show the error message
if (!$image->resize(100, 100, ZEBRA_IMAGE_BOXED, -1)) show_error($image->error, $image->source_path, $image->target_path);
////////////////////////////////////////////////////////////////////////////////////////




}else{
$imgNAME=$imgToDel;
}


	 
	 
}

////////////****************** IMAGE RESIZING END HERE *****************************//

$dicountAmount=$category_real_price-$category_discount_price;
$category_discount_percentage=($dicountAmount/$category_real_price)*100;
/*$color_count=COUNT($_POST["colors"]);
 $c=$color_count-1;
 $i=0;
 // Check if any option is selected 
        if(isset($_POST["colors"]))  
        { 
          // Retrieving each selected option 
            foreach ($_POST['colors'] as $colors){
                 if($c==$i){
                     $color_arr.=$colors;    
                 }else{
                     $color_arr.=$colors.",";
                 }
                 
                 $i++;
            }  
                   
        }else{
            echo "<script>alert('Please select any color...');</script>";
        }*/
$sql = "insert into tbl_category set 
                 category_name='$category_name',
                 category_areas_name='$category_areas_name',
				category_parent_id='$subcatid',
				category_image_name='$imgNAME',
				category_description='$category_description', 
				category_amount='$category_amount',
				category_amount_type='$category_amount_type',
				category_city='$category_city',
                category_meta_title='$category_meta_title',
				category_meta_description='$category_meta_description',
				category_meta_keywords='$category_meta_keywords',
				category_is_product='Yes',
				category_url='$category_url',
				category_add_date='$curr_date',
				category_status='$category_status'";
db_query($sql);
$_SESSION["msg"]="Property added successfully !";
header("Location:addedit-product.php?id=$category_id&subcatid=$subcatid&catid=$catid");
exit;
//*************** INSERT NEW CATEGORY END ************************//
 }
}

if($category_id!='') {
	$result = db_query("select * from tbl_category where category_id = '$category_id'");
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
                  <i class="fa fa-pencil-square-o" aria-hidden="true"></i>

               </div>
               <div class="header-title">
                  <h1>Add/Edit Property</h1>
                  <small>Add/Edit Property content</small>
                  
                  
<a href="product_list.php?subcatid=<?=$subcatid?>&catid=<?=$catid?>"><button id="btn-go-back" type="button" class="btn btn-labeled btn-inverse m-b-5 pull-right">
<span class="btn-label" ><i class="fa fa-chevron-circle-left"></i></span>Go Back
</button></a>

                  
               </div>
               
               
            </section>
            <!-- Main content -->
<script src="ckeditor/ckeditor.js"></script>            
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
                                 
<span style="margin-left:5px; font-size:16px;color:#8e32a2c7"><?=db_scalar("SELECT category_name FROM tbl_category WHERE 1 AND category_id='$catid'")?>&nbsp;&nbsp;<i class="fa fa-angle-double-right" ></i><span style="margin-left:5px; font-size:16px;color:#8e32a2c7"><?=db_scalar("SELECT category_name FROM tbl_category WHERE 1 AND category_id='$subcatid'")?></span>

&nbsp;&nbsp;<i class="fa fa-angle-double-right" ></i><span style="margin-left:5px; font-size:16px;color:#8e32a2c7"><?=db_scalar("SELECT category_name FROM tbl_category WHERE 1 AND category_id='$category_id'")?></span>
                                 
                                 
                                 </h4>
                              </a>
                           </div>
                        </div>
                        <div class="panel-body">
<form name="form1" method="post" onsubmit="return formValidation()" enctype="multipart/form-data" class="col-sm-12" >
                              


                            
<div class="form-group col-lg-3">
<label>Image</label>
<?php if($category_image_name!=""){ ?>
<img src="../uploaded_files/<?=$category_image_name?>" class="form-control" style="width:150px;height:150px" />
<?php }else{?>
<img src="assets/dist/img/no-image.jpg" class="form-control" style="width:120px;height:150px" />
<?php }?>

<?php if($category_image_name!=""){ ?>
<div class="col-lg-12 " ><a href="addedit-product.php?delImage=<?=$category_image_name?>&id=<?=$category_id?>&subcatid=<?=$subcatid?>&catid=<?=$catid?>" style="font-weight:600;margin-left:15px;text-decoration:underline" >Remove Image</a>                  
</div>
<?php }?>

</div>

<div class="form-group col-lg-9" style="padding-top:100px">
<input type="file" name="file" id="file" />
</div>


<div class="form-group col-lg-12">
                                 <label>Title</label>
<input type="text" class="form-control" placeholder="Enter Title" name="category_name" id="category_name"  value="<?=$category_name?>">
                              </div>
                              
                              
<div class="form-group col-lg-12">
<label>Areas/Sector Name</label>
<input type="text" class="form-control" placeholder="Enter Areas/Sector Name, eg:- Noida Sec-62, Noida Sec-142 etc." name="category_areas_name" id="category_areas_name"  value="<?=$category_areas_name?>">
</div>


<div class="form-group col-lg-12">
<label>City</label>
<select class="form-control" name="category_city" id="category_city">
    <option value="">Choose City</option>
    <?php
    $city_query=db_query("select * from tbl_city where city_status='Active'");
    while($city_res=mysqli_fetch_array($city_query))
    {  ?>
    <option value="<?=$city_res['city_name']?>"  <?php if($city_res['city_name']==$category_city){?>selected<?}?> ><?=$city_res['city_name']?></option>
    <?}?>
    
</select>
</div>
<?/*              
<div class="form-group col-lg-6">
                                 <label>Product Color</label>
<select required class="form-control" name="category_color">
<option value="">Select Color</option>
   <option value="Red"  <?php if($category_color=="Red"){?> selected <?}?>>Red</option>
      <option value="Blue" <?php if($category_color=="Blue"){?> selected <?}?>>Blue</option>
         <option value="Green" <?php if($category_color=="Green"){?> selected <?}?>>Green</option>

  </select>

<!--<input type="text" class="form-control" placeholder="Enter Product Name" name="category_name" id="category_name"  value="<?=$category_name?>">-->
                              </div>
                                       
<div class="form-group col-lg-6">
                                 <label>Product Size</label>
<select required class="form-control" name="category_size" >
  <option value="">Select Size</option>
   <option value="S" <?php if($category_size=="S"){?> selected <?}?>>S</option>
      <option value="M" <?php if($category_size=="M"){?> selected <?}?>>M</option>
         <option value="L" <?php if($category_size=="L"){?> selected <?}?>>L</option>

  </select>
<!--<input type="text" class="form-control" placeholder="Enter Product Name" name="category_size" id="category_size"  value="<?=$category_size?>">
-->
                              </div>
                              
*/?>

<!--                              <div class="form-group col-lg-12">
                                 <label>Product Name Keywords</label>
<input type="text" class="form-control" placeholder="Enter Product Keywords" name="category_name_keywords" id="category_name_keywords"  value="<?=$category_name_keywords?>">
<p style="font-weight: bold;">Format : <span style="color:red;">keyword1,keyword2,keyword3</span></p>


                              </div>-->
                                       
                                       
                                       
<!-- <div class="form-group col-lg-12">
                                 <label>Product Shared</label>
<input type="text" class="form-control" placeholder="Enter shared information" name="category_shared_count" id="category_shared_count"  value="<?=$category_shared_count?>">
                              </div> -->
                                      
                    <!--         <div class="form-group col-lg-12">
                                 <label>Product Short Description</label>
 <textarea rows="5" style="resize:none;" class="form-control" name="category_short_description" ><?=$category_short_description?></textarea>
                              </div>-->
                             
<script>

// Replace the <textarea id="editor"> with an CKEditor
// instance, using default configurations.
//CKEDITOR.replace( 'editor2');

</script>                                
                                      
  
                             <div class="form-group col-lg-12">
                                 <label>Description</label>
 <textarea class="form-control" name="category_description" rows="3" id="editor1"><?=$category_description?></textarea>
                              </div>
                             
<script>

// Replace the <textarea id="editor"> with an CKEditor
// instance, using default configurations.
CKEDITOR.replace( 'editor1');

</script>         


 
                                      

<?/*

    <div class="form-group col-lg-6">
 <label>Brand Name</label>
 <select class="form-control" name="category_company_name" id="category_company_name" onchange="selectCompanyName(this.value);">
     <option value="">Select Brand</option>
<?php
$brand_sql=db_query("select * from tbl_vehicle_filter where vehicle_status='Active' and parent_id='0' ");
while($brand_res=mysqli_fetch_array($brand_sql))
{?>
  <option value="<?=$brand_res['vehicle_brand_name']?>" <?php if($brand_res['vehicle_brand_name']==$category_company_name){?>selected<?}?> ><?=$brand_res['vehicle_brand_name']?></option>     
<?}
?>


 </select>
<!--<input type="text" class="form-control" placeholder="Enter Company Name" name="category_company_name" id="category_company_name"  value="<?=$category_company_name?>">
-->


</div> 

    <div class="form-group col-lg-3" id="show_model_name">
 <label>Model Number</label>
 <select class="form-control" name="category_model_number" id="category_model_number">
     <option value="">Select Model</option>
     <?php
$model_sql=db_query("select * from tbl_vehicle_filter where vehicle_status='Active' and parent_id!='0' ");
while($model_res=mysqli_fetch_array($model_sql))
{?>
  <option value="<?=$model_res['vehicle_model_number']?>" <?php if($model_res['vehicle_model_number']==$category_model_number){?>selected<?}?> ><?=$model_res['vehicle_model_number']?></option>     
<?}
?>



    <!-- <option value="A3">A3</option>
     <option value="A4">A4</option>
     <option value="A5">A5</option>
     <option value="A6">A6</option>
     <option value="A7">A7</option>
     <option value="A8">A8</option>
     <option value="Q3">Q3</option>
     <option value="Q5">Q5</option>
     <option value="Q7">Q7</option>
     <option value="X1">X1</option>
     <option value="X3">X3</option>
     <option value="X3">X3</option>
     <option value="X3">X3</option>
     <option value="1 SERIES">1 SERIES</option>
     <option value="2 SERIES">2 SERIES</option>
     <option value="3 SERIES">3 SERIES</option>
     <option value="4 SERIES">4 SERIES</option>
     <option value="5 SERIES">5 SERIES</option>
     <option value="6 SERIES">6 SERIES</option>
     <option value="7 SERIES">7 SERIES</option>
     <option value="AVEO">AVEO</option>
     <option value="AVEO U-VA">AVEO U-VA</option>
     <option value="BEAT">BEAT</option>
     <option value="CAPTIVA">CAPTIVA</option>
     <option value="CRUZE">CRUZE</option>
     <option value="ENJOY">ENJOY</option>
     <option value="OPTRA">OPTRA</option>
     <option value="SAIL">SAIL</option>
     <option value="SAIL U-VA">SAIL U-VA</option>
     <option value="SPARK">SPARK</option>
     <option value="TAVERA">TAVERA</option>
     <option value="TRAILBLAZER">TRAILBLAZER</option>
     <option value="GO">GO</option>
     <option value="GO PLUS">GO PLUS</option>
     <option value="REDI-GO">REDI-GO</option>
     <option value="LINEA">LINEA</option>
     <option value="PALIO">PALIO</option>
     <option value="PUNTO">PUNTO</option>
     <option value="ECOSPORT">ECOSPORT</option>
-->
     
 </select>
<!--<input type="text" class="form-control" placeholder="Enter Model Number" name="category_model_number" id="category_model_number"  value="<?=$category_model_number?>">
-->


</div> 


       <script>
function selectCompanyName(company_name)
{
$.ajax({
type: "POST",
url: "filter-modelname-by-company-ajax.php",
data: {company_name:company_name},
cache: false,
success: function(result){

document.getElementById('show_model_name').innerHTML=result;

}
});
}

</script>
   
  <div class="form-group col-lg-3">
 <label>Model Year</label>
 
<!--<input type="number" onkeydown="return event.keyCode !== 69" class="form-control" placeholder="Enter Model Year" name="category_model_year" id="category_model_year"  value="<?=$category_model_year?>">
--><select class="form-control" name="category_model_year" id="category_model_year">
<option value="2001" <?php if($category_model_year=="2001"){?>selected<?}?>  >2001</option>
<option value="2002" <?php if($category_model_year=="2002"){?>selected<?}?>  >2002</option>
<option value="2003" <?php if($category_model_year=="2003"){?>selected<?}?>  >2003</option>
<option value="2004" <?php if($category_model_year=="2004"){?>selected<?}?>  >2004</option>
<option value="2005" <?php if($category_model_year=="2005"){?>selected<?}?>  >2005</option>
<option value="2006" <?php if($category_model_year=="2006"){?>selected<?}?>  >2006</option>
<option value="2007" <?php if($category_model_year=="2007"){?>selected<?}?>  >2007</option>
<option value="2008" <?php if($category_model_year=="2008"){?>selected<?}?>  >2008</option>
<option value="2009" <?php if($category_model_year=="2009"){?>selected<?}?>  >2009</option>
<option value="2010" <?php if($category_model_year=="2010"){?>selected<?}?>  >2010</option>
<option value="2011" <?php if($category_model_year=="2011"){?>selected<?}?>  >2011</option>
<option value="2012" <?php if($category_model_year=="2012"){?>selected<?}?>  >2012</option>
<option value="2013" <?php if($category_model_year=="2013"){?>selected<?}?>  >2013</option>
<option value="2014" <?php if($category_model_year=="2014"){?>selected<?}?>  >2014</option>
<option value="2015" <?php if($category_model_year=="2015"){?>selected<?}?>  >2015</option>
<option value="2016" <?php if($category_model_year=="2016"){?>selected<?}?>  >2016</option>
<option value="2017" <?php if($category_model_year=="2017"){?>selected<?}?>  >2017</option>
<option value="2018" <?php if($category_model_year=="2018"){?>selected<?}?>  >2018</option>
<option value="2019" <?php if($category_model_year=="2019"){?>selected<?}?>  >2019</option>
<option value="2020" <?php if($category_model_year=="2020"){?>selected<?}?>  >2020</option>
<option value="2021" <?php if($category_model_year=="2021"){?>selected<?}?>  >2021</option>
</select>
</div> 

 <!--   <div class="form-group col-lg-3">
 <label>Variant</label>
 
<input type="text" class="form-control" placeholder="Enter Variant" name="category_variant" id="category_variant"  value="<?=$category_variant?>">
</div> -->
           
*/?>
                                         
      
      <div class="form-group col-lg-3">
                                 <label> Amount </label>
<input type="text" class="form-control" placeholder="Enter Amount" name="category_amount" id="category_amount"  value="<?=$category_amount?>">
                              </div>
                              
      
      <div class="form-group col-lg-3">

                                 <label> Type </label>
                         <select name="category_amount_type" id="category_amount_type" class="form-control">
                                 <option value="">Select Amount Type</option>
                                  <option value="Day" <?php if($category_amount_type=="Day"){?>selected<?}?>>Per Day</option>
                                  <option value="Week" <?php if($category_amount_type=="Week"){?>selected<?}?>>Per Week</option>
                                  <option value="Month" <?php if($category_amount_type=="Month"){?>selected<?}?>>Per Month</option>
                                  <option value="Year" <?php if($category_amount_type=="Year"){?>selected<?}?>>Per Year</option>
                                  
                                  
                              </select>
                              </div>
                              
                                                                 

                              
                              
            
       
                              
                              
                              
                              
                              
                              
<!--<div class="form-group col-lg-6">
                                 <label> Color </label>
<input type="text" class="form-control" placeholder="Enter product color" name="category_color" id="category_color"  value="<?=$category_color?>">
                              </div>-->
                              
                              
                              
                              
                      
                                                            
                              
                              
                                                                                                   
                            
                           
                           
                           
<div class="form-group col-lg-6">
 <label>Status</label>
 
<select name="category_status" class="form-control" >
                      <option value="Active" <?php if($category_status=='Active'){ ?> selected="selected" <? } ?>>Active</option>
                      <option value="Inactive" <?php if($category_status=='Inactive'){ ?> selected="selected" <? } ?>>Inactive</option>
                    </select>


</div> 
<!--
<div class="form-group col-lg-3">
 <label>In Stock</label>

<select name="category_in_stock" class="form-control" >
                      <option value="Yes" <?php if($category_in_stock=='Yes'){ ?> selected="selected" <? } ?>>Yes</option>
                      <option value="No" <?php if($category_in_stock=='No'){ ?> selected="selected" <? } ?>>No</option>
                    </select>
                     



</div>                             
       
       
       <div class="form-group col-lg-3">
 <label>Quantity</label>
 
<input type="text" class="form-control" placeholder="Enter product quantity" name="category_qnty" id="category_qnty"  value="<?=$category_qnty?>">



</div> -->


<!--    <div class="form-group col-lg-3">
 <label>Select Colors</label>
 
<select id="dates-field2" class="multiselect-ui form-control" multiple="multiple" name="colors[]">
            <option style="color:black; background-color:AliceBlue;" value="AliceBlue">AliceBlue</option>
            
            <option style="color:black; background-color:AntiqueWhite;" value="AntiqueWhite">AntiqueWhite</option>
            
            <option style="color:black; background-color:Aqua;" value="Aqua">Aqua</option>
            
            <option style="color:black; background-color:Aquamarine;" value="Aquamarine">Aquamarine</option>
            
            <option style="color:black; background-color:Beige;" value="Beige">Beige</option>
            
            <option style="color:black; background-color:Bisque;" value="Bisque">Bisque</option>
        </select>

</div>  -->
       

<?php if($_SESSION['sess_admin_type']=="Admin"){ ?>
<div class="col-lg-12" style="padding:0;background-color:#e8f1f3;margin:20px 0 50px 0">
                           <div class="btn-group" id="buttonexport">
                              <a href="#" >
                                 <h4 style="color:#000;font-weight:600;padding:5px">SEO Related Information</h4>
                              </a>
                           </div>
                        </div>                            
                             
                             
                            <div class="form-group col-lg-12">
                                 <label>Product Meta Title</label>
<textarea class="form-control" rows="3" name="category_meta_title" id="category_meta_title" placeholder="Enter category meta title here" ><?=$category_meta_title?></textarea>
                              </div>
                              <div class="form-group col-lg-12">
                                 <label>Product Meta Description</label>
<textarea class="form-control" rows="3" placeholder="Enter category meta description here" name="category_meta_description" id="category_meta_description"><?=$category_meta_description?></textarea>
                              </div>
                              <div class="form-group col-lg-12">
                                 <label>Product Meta Keyword</label>
<textarea class="form-control" rows="3" name="category_meta_keywords" placeholder="Enter category meta keywords here" id="category_meta_keywords"><?=$category_meta_keywords?></textarea>
                              </div>
                              <?}?>
                              
                              
                             
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
        <script type="text/javascript">
$(function() {
    $('.multiselect-ui').multiselect({
        includeSelectAllOption: true
    });
});
</script>
<?php require_once("footer.php"); ?>
 