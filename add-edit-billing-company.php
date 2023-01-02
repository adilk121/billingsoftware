<?php require_once("header.php");?>
<?php require_once("left-nav.php");?>
<?php require_once ('includes/photoshop.php');?>
<?php
$billing_company_id=trim($_REQUEST['id']);


$categoryID = trim($_GET['billing_company_id']);
if($_REQUEST['delLogo']!=""){
$delLogo=$_REQUEST['delLogo'];  
$isDel=db_query("UPDATE  tbl_billing_company SET  billing_company_logo='' WHERE 1 and billing_company_id = '$categoryID'"); 
@unlink("company_logo/$delLogo");
header("location:add-edit-billing-company.php?id=$categoryID");
}



if($_REQUEST['delSignature']!=""){
$delSignature=$_REQUEST['delSignature'];  
$isDel=db_query("UPDATE  tbl_billing_company SET  billing_company_digital_signature='' WHERE 1 and billing_company_id = '$categoryID'"); 
@unlink("company_signature/$delSignature");
header("location:add-edit-billing-company.php?id=$categoryID");
}


if($_REQUEST['delQRCode']!=""){
$delQRCode=$_REQUEST['delQRCode'];  
$isDel=db_query("UPDATE  tbl_billing_company SET  billing_company_payment_qr_code='' WHERE 1 and billing_company_id = '$categoryID'"); 
@unlink("company_qr_code/$delQRCode");
header("location:add-edit-billing-company.php?id=$categoryID");
}


if(is_post_back()){

//////////////// UPDATE EXISTING CATEGORY START ///////////////////////

if($_REQUEST['id']!='0') {

if($_FILES['logo']['name']!="")
{
$DelImg=db_scalar("select billing_company_logo from tbl_billing_company where 1 and billing_company_id='$billing_company_id'");
@unlink("company_logo/$DelImg");
$rand=rand(100,10000);
$logo_image=$rand.$_FILES['logo']['name'];
move_uploaded_file($_FILES['logo']['tmp_name'],"company_logo/$logo_image");        
$sql_im = "update tbl_billing_company set billing_company_logo='$logo_image'  where billing_company_id='$billing_company_id'  ";
db_query($sql_im);
}


if($_FILES['signature']['name']!="")
{
$DelImg=db_scalar("select billing_company_digital_signature from tbl_billing_company where 1 and billing_company_id='$billing_company_id'");
@unlink("company_signature/$DelImg");
$rand=rand(100,10000);
$signature_image=$rand.$_FILES['signature']['name'];
move_uploaded_file($_FILES['signature']['tmp_name'],"company_signature/$signature_image");        
$sql_im = "update tbl_billing_company set billing_company_digital_signature='$signature_image'  where billing_company_id='$billing_company_id'  ";
db_query($sql_im);
}


if($_FILES['qr_code']['name']!="")
{
$DelImg=db_scalar("select billing_company_payment_qr_code from tbl_billing_company where 1 and billing_company_id='$billing_company_id'");
@unlink("company_qr_code/$DelImg");
$rand=rand(100,10000);
$qr_code_image=$rand.$_FILES['qr_code']['name'];
move_uploaded_file($_FILES['qr_code']['tmp_name'],"company_qr_code/$qr_code_image");        
$sql_im = "update tbl_billing_company set billing_company_payment_qr_code='$qr_code_image'  where billing_company_id='$billing_company_id'  ";
db_query($sql_im);
}


$sql = "update tbl_billing_company set        
        billing_company_phone_no='$billing_company_phone_no',
        billing_company_email='$billing_company_email',
        billing_company_gst_rate='$billing_company_gst_rate',          
        billing_company_website='$billing_company_website', 
        billing_company_address='$billing_company_address', 
        billing_company_terms_and_conditions='$billing_company_terms_and_conditions', 
        billing_company_bank_name='$billing_company_bank_name', 
        billing_company_account_name='$billing_company_account_name', 
        billing_company_account_no='$billing_company_account_no', 
        billing_company_account_type='$billing_company_account_type', 
        billing_company_ifsc_code='$billing_company_ifsc_code', 
        billing_company_branch='$billing_company_branch', 
        billing_company_upi_id='$billing_company_upi_id', 
        billing_company_wallet_no='$billing_company_wallet_no', 
        billing_company_payumoney_key='$billing_company_payumoney_key', 
        billing_company_payumoney_salt='$billing_company_payumoney_salt',   
        billing_company_update_date='$curr_date',
        billing_company_status='$billing_company_status'
				where billing_company_id = '$billing_company_id' ";

db_query($sql);


$_SESSION["msg"]="Company updated successfully !";
header("Location:add-edit-billing-company.php?id=$_REQUEST[id]");
exit;
/////////////////// UPDATE EXISTING CATEGORY END //////////////////
}else{


if(!empty($_FILES["logo"]["name"]))
{
 $rand=rand(100,10000);
  $logo=$rand.$_FILES['logo']['name'];
  move_uploaded_file($_FILES['logo']['tmp_name'],"company_logo/$logo");     
}


if(!empty($_FILES["signature"]["name"]))
{
 $rand=rand(100,10000);
  $signature=$rand.$_FILES['signature']['name'];
  move_uploaded_file($_FILES['signature']['tmp_name'],"company_signature/$signature");     
}

if(!empty($_FILES["qr_code"]["name"]))
{
 $rand=rand(100,10000);
  $qr_code=$rand.$_FILES['qr_code']['name'];
  move_uploaded_file($_FILES['qr_code']['tmp_name'],"company_qr_code/$qr_code");     
}


$sql = "insert into tbl_billing_company set        
				billing_company_name='$billing_company_name',
        billing_company_logo='$logo',
        billing_company_digital_signature='$signature',
        billing_company_payment_qr_code='$qr_code',
				billing_company_phone_no='$billing_company_phone_no',
				billing_company_email='$billing_company_email',
				billing_company_gst_no='$billing_company_gst_no', 
				billing_company_gst_rate='$billing_company_gst_rate',
				billing_company_cin_no='$billing_company_cin_no',
				billing_company_pan_no='$billing_company_pan_no',
				billing_company_invoice_start_no='$billing_company_invoice_start_no',
				billing_company_website='$billing_company_website', 
        billing_company_state_name='$billing_company_state_name', 
        billing_company_state_code='$billing_company_state_code', 
				billing_company_address='$billing_company_address', 
        billing_company_terms_and_conditions='$billing_company_terms_and_conditions', 
        billing_company_bank_name='$billing_company_bank_name', 
        billing_company_account_name='$billing_company_account_name', 
				billing_company_account_no='$billing_company_account_no', 
        billing_company_account_type='$billing_company_account_type', 
        billing_company_ifsc_code='$billing_company_ifsc_code', 
        billing_company_branch='$billing_company_branch', 
        billing_company_upi_id='$billing_company_upi_id', 
        billing_company_wallet_no='$billing_company_wallet_no', 
        billing_company_payumoney_key='$billing_company_payumoney_key', 
        billing_company_payumoney_salt='$billing_company_payumoney_salt', 
				billing_company_add_date='$curr_date',
				billing_company_status='$billing_company_status'";
db_query($sql);
$_SESSION["msg"]="Company added successfully !";
header("Location:add-edit-billing-company.php?id=$_REQUEST[id]");
exit;
//*************** INSERT NEW CATEGORY END ************************//
 }
}

if($billing_company_id!='') {
	$result = db_query("select * from tbl_billing_company where billing_company_id = '$billing_company_id'");
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
                  <i class="fa fa-building-o" aria-hidden="true"></i>

               </div>
               <div class="header-title">
                  <h1>Add/Edit Company</h1>
                  <small>Add/Edit Company</small>
                  
                  
<a href="manage-billing-company.php"><button id="btn-go-back" type="button" class="btn btn-labeled btn-inverse m-b-5 pull-right">
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
                                 <h4>Company Information</h4>
                              </a>
                           </div>
                        </div>
                        <div class="panel-body">
<form name="form1" method="post" onsubmit="return formValidation()" enctype="multipart/form-data" class="col-sm-12" >
                              

<div class="form-group col-lg-12">
<label>Company Name *</label>
<input type="text" class="form-control" placeholder="Enter Company Name" name="billing_company_name" id="billing_company_name"  value="<?=$billing_company_name?>" required <?php if($billing_company_name!=""){?> readonly <?}?>>
</div>
                            
<div class="form-group col-lg-3">
<label>Company Logo *</label>
<?php if($billing_company_logo!=""){ ?>
<img src="company_logo/<?=$billing_company_logo?>" class="form-control" style="width:150px;height:150px" />
<?php }else{?>
<img src="assets/dist/img/no-image.jpg" class="form-control" style="width:150px;height:150px" />
<?php }?>

<?php if($billing_company_logo!=""){ ?>
<div class="col-lg-12 " ><a href="add-edit-billing-company.php?delLogo=<?=$billing_company_logo?>&billing_company_id=<?=$billing_company_id?>" style="font-weight:600;margin-left:15px;text-decoration:underline" >Remove Image</a>                  
</div>
<?php }?>

</div>

<div class="form-group col-lg-9" style="padding-top:100px">
<input type="file" name="logo" id="logo" <?php if($_REQUEST['id']==0 || $billing_company_logo==""){?> required <?}?> />
<p style="color:red; font-weight:bold; font-size:12px;">Width:180px, Height:100px</p>
</div> 

<div class="clearfix"></div>


<div class="form-group col-lg-3">
<label>Company Digital Signature *</label>
<?php if($billing_company_digital_signature!=""){ ?>
<img src="company_signature/<?=$billing_company_digital_signature?>" class="form-control" style="width:150px;height:150px" />
<?php }else{?>
<img src="assets/dist/img/no-image.jpg" class="form-control" style="width:150px;height:150px" />
<?php }?>

<?php if($billing_company_digital_signature!=""){ ?>
<div class="col-lg-12 " ><a href="add-edit-billing-company.php?delSignature=<?=$billing_company_digital_signature?>&billing_company_id=<?=$billing_company_id?>" style="font-weight:600;margin-left:15px;text-decoration:underline" >Remove Image</a>                  
</div>
<?php }?>

</div>

<div class="form-group col-lg-9" style="padding-top:100px">
<input type="file" name="signature" id="signature" <?php if($_REQUEST['id']==0 || $billing_company_digital_signature==""){?> required <?}?>/>
<p style="color:red; font-weight:bold; font-size:12px;">Width:300px, Height:115px</p>
</div> 

<div class="clearfix"></div>








<div class="form-group col-lg-6">
<label>Phone No. *</label>
<input type="text" maxlength="10" class="form-control" placeholder="Enter Phone No." name="billing_company_phone_no" id="billing_company_phone_no"  value="<?=$billing_company_phone_no?>" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" required>
</div>


<div class="form-group col-lg-6">
<label>Email Address *</label>
<input type="text" class="form-control" placeholder="Enter Email Address" name="billing_company_email" id="billing_company_email"  value="<?=$billing_company_email?>" onblur="validateEmail(this);" required >
</div>


<div class="form-group col-lg-3">
<label>GST No.</label>
<input type="text" class="form-control" placeholder="Enter GST No." name="billing_company_gst_no" id="billing_company_gst_no"  value="<?=$billing_company_gst_no?>" <?php if($billing_company_gst_no!=""){?> readonly <?}?> >
</div>

<div class="form-group col-lg-3">
<label>GST Rate %</label>
<input type="text" class="form-control" maxlength="2" placeholder="Enter GST Rate %" name="billing_company_gst_rate" id="billing_company_gst_rate"  value="<?=$billing_company_gst_rate?>" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" <?php /*if($billing_company_gst_rate!=""){?> readonly <?}*/?>>
</div>

<div class="form-group col-lg-6">
<label>CIN No.</label>
<input type="text" class="form-control" placeholder="Enter CIN No." name="billing_company_cin_no" id="billing_company_cin_no"  value="<?=$billing_company_cin_no?>" <?php if($billing_company_cin_no!=""){?> readonly <?}?> >
</div>

<div class="form-group col-lg-4">
<label>PAN No.</label>
<input type="text" class="form-control" placeholder="Enter PAN No." name="billing_company_pan_no" id="billing_company_pan_no"  value="<?=$billing_company_pan_no?>" <?php if($billing_company_pan_no!=""){?> readonly <?}?>>
</div>

<div class="form-group col-lg-4">
<label>Invoice Start No. *</label>
<input type="text" class="form-control" placeholder="Enter Invoice Start No." name="billing_company_invoice_start_no" id="billing_company_invoice_start_no"  value="<?=$billing_company_invoice_start_no?>" onchange="check_invoice_no_exist(this.value)" required <?php if($billing_company_invoice_start_no!=""){?> readonly <?}?>>
<p style="color:red; font-weight: bold; font-size: 11px;">YOURTEXT10001</p>
</div>


<div class="form-group col-lg-4">
<label>Website</label>
<input type="text" class="form-control" placeholder="Enter Website" name="billing_company_website" id="billing_company_website"  value="<?=$billing_company_website?>" >
<p style="color:red; font-weight: bold; font-size: 11px;">https://www.youwebsite.com</p>
</div>


<div class="form-group col-lg-6">
<label>State Name *</label>
<input type="text" class="form-control" placeholder="Enter State Name" name="billing_company_state_name" id="billing_company_state_name"  value="<?=$billing_company_state_name?>" <?php if($billing_company_state_name!=""){?> readonly <?}?> required>
</div>

<div class="form-group col-lg-6">
<label>State Code *</label>
<input type="text" class="form-control" placeholder="Enter State Code" name="billing_company_state_code" id="billing_company_state_code"  value="<?=$billing_company_state_code?>" <?php if($billing_company_state_code!=""){?> readonly <?}?> required>
</div>


<div class="form-group col-lg-12 " >
<label>Address *</label>
<textarea class="form-control" name="billing_company_address" rows="3" placeholder="Enter Address" id="" style="width:98%; resize:none;" required><?=$billing_company_address?></textarea>
</div>


<div class="form-group col-lg-12 " >
<label>Terms & Conditions</label>
<textarea class="form-control" name="billing_company_terms_and_conditions" id="editor1" rows="3" placeholder="Enter Terms & Conditions" id="" style="width:98%;"><?=$billing_company_terms_and_conditions?></textarea>
<script>
  CKEDITOR.replace( 'editor1');
</script>

</div>



<div class="col-lg-12" style="padding:0;background-color:#e8f1f3;margin:20px 0 50px 0">
                           <div class="btn-group" id="buttonexport">
                              <a href="#" >
                                 <h4 style="color:#000;font-weight:600;padding:5px">Payment Details</h4>
                              </a>
                           </div>
                        </div>                           
                <div class="form-group col-lg-3">
<label>Company Payment QR Code *</label>
<?php if($billing_company_payment_qr_code!=""){ ?>
<img src="company_qr_code/<?=$billing_company_payment_qr_code?>" class="form-control" style="width:150px;height:150px" />
<?php }else{?>
<img src="assets/dist/img/no-image.jpg" class="form-control" style="width:150px;height:150px" />
<?php }?>

<?php if($billing_company_payment_qr_code!=""){ ?>
<div class="col-lg-12 " ><a href="add-edit-billing-company.php?delQRCode=<?=$billing_company_payment_qr_code?>&billing_company_id=<?=$billing_company_id?>" style="font-weight:600;margin-left:15px;text-decoration:underline" >Remove Image</a>                  
</div>
<?php }?>

</div>

<div class="form-group col-lg-9" style="padding-top:100px">
<input type="file" name="qr_code" id="qr_code" <?php if($_REQUEST['id']==0 || $billing_company_payment_qr_code==""){?> required <?}?>/>
<p style="color:red; font-weight:bold; font-size:12px;">Width:300px, Height:240px</p>
</div> 

<div class="clearfix"></div>             
                             
<div class="form-group col-lg-6">
<label>Bank Name</label>
<input type="text" class="form-control" placeholder="Enter Bank Name" name="billing_company_bank_name" id="billing_company_bank_name"  value="<?=$billing_company_bank_name?>" >
</div>

<div class="form-group col-lg-6">
<label>Account Name</label>
<input type="text" class="form-control" placeholder="Enter Account Name" name="billing_company_account_name" id="billing_company_account_name"  value="<?=$billing_company_account_name?>" >
</div>

<div class="form-group col-lg-6">
<label>Account No.</label>
<input type="text" class="form-control" placeholder="Enter Account No." name="billing_company_account_no" id="billing_company_account_no"  value="<?=$billing_company_account_no?>" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
</div>

<div class="form-group col-lg-6">
<label>Account Type</label>

<select class="form-control" name="billing_company_account_type" id="billing_company_account_type">
	<option value="Current" <?php if($billing_company_account_type=="Current"){?>selected <?}?> >Current</option>
	<option value="Saving" <?php if($billing_company_account_type=="Saving"){?>selected <?}?>>Saving</option>

</select>

</div>

<div class="form-group col-lg-6">
<label>IFSC Code</label>
<input type="text" class="form-control" placeholder="Enter IFSC Code" name="billing_company_ifsc_code" id="billing_company_ifsc_code"  value="<?=$billing_company_ifsc_code?>" >
</div>

<div class="form-group col-lg-6">
<label>Branch</label>
<input type="text" class="form-control" placeholder="Enter Branch" name="billing_company_branch" id="billing_company_branch"  value="<?=$billing_company_branch?>" >
</div>

<div class="form-group col-lg-6">
<label>UPI ID</label>
<input type="text" class="form-control" placeholder="Enter UPI ID (PhonePe, GooglePay, Paytm)" name="billing_company_upi_id" id="billing_company_upi_id"  value="<?=$billing_company_upi_id?>" >
</div>

<div class="form-group col-lg-6">
<label>Wallet No.</label>
<input type="text" maxlength="10" class="form-control" placeholder="Enter Wallet No." name="billing_company_wallet_no" id="billing_company_wallet_no"  value="<?=$billing_company_wallet_no?>" >
</div>
               
 <div class="form-group col-lg-6">
  <label>Payment Gateway Details (<span style="color:#95b543;">PayUmoney</span>)</label>
 <div class="form-group col-lg-6">
<input type="text" class="form-control" placeholder="Enter Key" name="billing_company_payumoney_key" id="billing_company_payumoney_key"  value="<?=$billing_company_payumoney_key?>" >
</div>

 <div class="form-group col-lg-6">
<input type="text" class="form-control" placeholder="Enter Salt" name="billing_company_payumoney_salt" id="billing_company_payumoney_salt"  value="<?=$billing_company_payumoney_salt?>" >
</div>

<!-- <input type="text" class="form-control" placeholder="Enter Online Payment Link" name="billing_company_online_payment_link" id="billing_company_online_payment_link"  value="<?=$billing_company_online_payment_link?>" >
 -->
</div>              

                           
                           
<div class="form-group col-lg-6">
 <label>Status</label>
 
<select name="billing_company_status" class="form-control" >
                      <option value="Active" <?php if($billing_company_status=='Active'){ ?> selected="selected" <? } ?>>Active</option>
                      <option value="Inactive" <?php if($billing_company_status=='Inactive'){ ?> selected="selected" <? } ?>>Inactive</option>
                    </select>


</div>                             
       


                             
                             
                            
                              
 
                             
                              <div class="col-lg-12 reset-button">
                                                                 
                                 <button type="submit" class="btn btn-add" id="submit_btn">Submit</button>
                                
                              </div>
                           </form>
                        </div>
                     </div>
                  </div>
               </div>
            </section>
            <!-- /.content -->
         </div>

<script>


function validateEmail(emailField){
        var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;

        if (reg.test(emailField.value) == false) 
        {
            alert('Invalid Email Address');
            document.getElementById("billing_company_email").focus();
            return false;
        }

        return true;

}

	function check_invoice_no_exist(invoice_start_no)
	{
	
$.ajax({
type: "POST",
url: "check_invoice_no_exist.php",
data: {invoice_start_no:invoice_start_no},
cache: false,
success: function(result){
//document.getElementById('show_model_name').innerHTML=result;
if(result!="")
{
	alert("Invoice start no. is already exist! please enter a different no.");
	$("#submit_btn").attr("disabled", true);
}
else{
	$("#submit_btn").attr("disabled", false);
}
}

	});

	}
</script>

<?php require_once("footer.php"); ?>
 