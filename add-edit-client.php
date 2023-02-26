<?php require_once("header.php");?>
<?php require_once("left-nav.php");?>
<?php require_once ('includes/photoshop.php');?>
<?php
$client_id=trim($_REQUEST['id']);

// client id

if(is_post_back()){
//*************** UPDATE EXISTING CATEGORY START ************************//

if($_REQUEST['id']!='0') {


$sql = "update tbl_clients set        
				client_cid='$client_cid',
				client_name='$client_name',
				client_company_name='$client_company_name',
				client_gst_no='$client_gst_no', 
				client_email='$client_email',
				client_alt_email='$client_alt_email',
				client_mobile='$client_mobile',
				client_alt_mobile='$client_alt_mobile', 
				client_whatsapp_no='$client_whatsapp_no', 
        client_pan_no='$client_pan_no', 
        client_state_name='$client_state_name', 
        client_state_code='$client_state_code', 
				client_billing_address='$client_billing_address', 
				client_add_date='$curr_date',
				client_status='$client_status'
				where client_id = '$client_id' ";

db_query($sql);


$_SESSION["msg"]="Client updated successfully !";
header("Location:add-edit-client.php?id=$_REQUEST[id]");
exit;
//*************** UPDATE EXISTING CATEGORY END ************************//
}else{

$sql = "insert into tbl_clients set        
				client_cid='$client_cid',
				client_name='$client_name',
				client_company_name='$client_company_name',
				client_gst_no='$client_gst_no', 
				client_email='$client_email',
				client_alt_email='$client_alt_email',
				client_mobile='$client_mobile',
				client_alt_mobile='$client_alt_mobile', 
				client_whatsapp_no='$client_whatsapp_no', 
        client_pan_no='$client_pan_no', 
        client_state_name='$client_state_name', 
        client_state_code='$client_state_code', 
				client_billing_address='$client_billing_address', 
				client_add_date='$curr_date',
				client_status='$client_status'";
db_query($sql);
$_SESSION["msg"]="Client added successfully !";
header("Location:add-edit-client.php?id=$_REQUEST[id]");
exit;
//*************** INSERT NEW CATEGORY END ************************//
 }
}

if($client_id!='') {
	$result = db_query("select * from tbl_clients where client_id = '$client_id'");
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
                  <i class="fa fa-users" aria-hidden="true"></i>

               </div>
               <div class="header-title">
                  <h1>Add/Edit Client</h1>
                  <small>Add/Edit Client Content</small>
                  
                  
<a href="manage-clients.php"><button id="btn-go-back" type="button" class="btn btn-labeled btn-inverse m-b-5 pull-right">
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
                                 <h4>General Information</h4>
                              </a>
                           </div>
                        </div>
                        <div class="panel-body">
<form name="form1" method="post" onsubmit="return formValidation()" enctype="multipart/form-data" class="col-sm-12" >
                              


                            
<!-- <div class="form-group col-lg-3">
<label>Testimonial Image</label>
<?php if($test_image_name!=""){ ?>
<img src="test_images/<?=$test_image_name?>" class="form-control" style="width:150px;height:150px" />
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
<label>CID *</label>
<input type="text" class="form-control" placeholder="Enter CID" name="client_cid" id="client_cid"  value="<?=$client_cid?>" <?php if($client_cid!=""){?> readonly <?}?> required onchange="check_duplicacy(this.value,'CID')">
</div>


<div class="form-group col-lg-6">
<label>Customer Name *</label>
<input type="text" class="form-control" placeholder="Enter Customer Name" name="client_name" id="client_name"  value="<?=$client_name?>" onkeypress="return alphaOnly(this, event)" required>
</div>
 <script type="text/javascript">
        function alphaOnly(txt, e) {
            var arr = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz ";
            var code;
            if (window.event)
                code = e.keyCode;
            else
                code = e.which;
            var char = keychar = String.fromCharCode(code);
            if (arr.indexOf(char) == -1)
                return false;
            
        }
    </script>

<div class="form-group col-lg-6">
<label>Company Name *</label>
<input type="text" class="form-control" placeholder="Enter Company Name" name="client_company_name" id="client_company_name"  value="<?=$client_company_name?>" required>
</div>


<div class="form-group col-lg-6">
<label>GST No.</label>
<input type="text" class="form-control" placeholder="Enter GST No." name="client_gst_no" id="client_gst_no"  value="<?=$client_gst_no?>" onchange="check_duplicacy(this.value,'GST')">
</div>

<div class="form-group col-lg-6">
<label>Email Address *</label>
<input type="text" class="form-control" placeholder="Enter Email Address" name="client_email" id="client_email"  value="<?=$client_email?>" onblur="validateEmail(this);" required onchange="check_duplicacy(this.value,'Email')">
</div>

<div class="form-group col-lg-6">
<label>Alternate Email Address</label>
<input type="email" class="form-control" placeholder="Enter Alt Email Address" name="client_alt_email" id="client_alt_email"  value="<?=$client_alt_email?>">
</div>

<div class="form-group col-lg-4">
<label>Mobile No. *</label>
<input type="text" maxlength="10" class="form-control" placeholder="Enter Mobile No." name="client_mobile" id="client_mobile"  value="<?=$client_mobile?>" required oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" onchange="check_duplicacy(this.value,'Mobile')">
</div>

<div class="form-group col-lg-4">
<label>Alternate Mobile No.</label>
<input type="text" maxlength="10" class="form-control" placeholder="Enter Alt Mobile No." name="client_alt_mobile" id="client_alt_mobile"  value="<?=$client_alt_mobile?>" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
</div>

<div class="form-group col-lg-4">
<label>WhatsApp No.</label>
<input type="text" maxlength="10" class="form-control" placeholder="Enter WhatsApp No." name="client_whatsapp_no" id="client_whatsapp_no"  value="<?=$client_whatsapp_no?>" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
</div>
<div class="form-group col-lg-4">
<label>PAN No.</label>
<input type="text" class="form-control" placeholder="Enter PAN No." name="client_pan_no" id="client_pan_no"  value="<?=$client_pan_no?>" onchange="check_duplicacy(this.value,'PAN')">
</div>


<div class="form-group col-lg-4">
<label>State Name *</label>
<input type="text" class="form-control" placeholder="Enter State Name" name="client_state_name" id="client_state_name"  value="<?=$client_state_name?>" required>
</div>

<div class="form-group col-lg-4">
<label>State Code *</label>
<input type="text" class="form-control" placeholder="Enter State Code" name="client_state_code" id="client_state_code"  value="<?=$client_state_code?>" required>
</div>


                                         
<div class="form-group col-lg-12 " >
<label>Billing Address *</label>
<textarea class="form-control" name="client_billing_address" rows="3" placeholder="Enter Billing Address" id="" style="width:98%; resize:none;" required><?=$client_billing_address?></textarea>
</div>
                             

                           
                           
<div class="form-group col-lg-3">
 <label>Status</label>
 
<select name="client_status" class="form-control" >
                      <option value="Active" <?php if($client_status=='Active'){ ?> selected="selected" <? } ?>>Active</option>
                      <option value="Inactive" <?php if($client_status=='Inactive'){ ?> selected="selected" <? } ?>>Inactive</option>
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
           document.getElementById("client_email").focus();
              $("#submit_btn").attr("disabled", true);
            return false;
        }
  $("#submit_btn").attr("disabled", false);
        return true;

}


function check_duplicacy(value,type)
{
$.ajax({
url:"check-client-duplicacy.php",
type:"POST",
data:{value:value, type:type},
success:function(data)
{
    if(data!="")
    {
      alert(data);
      $("#submit_btn").attr("disabled", true);
    }else{
        $("#submit_btn").attr("disabled", false);
    }
}

});

}
</script>

<?php require_once("footer.php"); ?>
 
