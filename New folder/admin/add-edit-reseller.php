<?php require_once("header.php");?>
<?php require_once("left-nav.php");?>
<link href="assets/plugins/icheck/skins/all.css" rel="stylesheet" type="text/css"/>
<link href="assets/plugins/bootstrap-toggle/bootstrap-toggle.min.css" rel="stylesheet" type="text/css"/>
<?php
if(isset($_POST['Register'])){
$count=db_scalar("select count(*) from tbl_resellers where 1 and reseller_email='$reseller_email'");
	if($count>=1){
		 $_SESSION['msg'] = "E-mail Id already Exist.!";
	 }else{
 $sql="insert into tbl_resellers set 
           reseller_name='$reseller_name',
		   reseller_adrs='$reseller_adrs',
		   reseller_email='$reseller_email',
		   reseller_pass='$reseller_pass',
		   reseller_mobile='$reseller_mobile',
		   reseller_status='Active',
		   reseller_add_date='$currDate',
	       reseller_zip_code='$reseller_zip_code',
	       reseller_city='$reseller_city',		   
	       reseller_country='$reseller_country'		   		   		   
		   ";
		   db_query($sql);
		   $regg_id=mysqli_insert_id($GLOBALS['dbcon']);
		   
$mail_body = '<center>
<div style="background-color:#e93c04;width:600px;padding:2px 2px 2px 2px;font-family:Arial, Helvetica, sans-serif;text-align:left;font-size:14px;border-radius:5px;border:1px solid #e93c04;" >
<div style="border:1px solid #dadada;background-color:#fff;padding:3px 4px 5px 5px;">
<div style="text-align:left;border-bottom:1px solid #e8410d;padding:2px;"><img src="'.SITE_WS_PATH.'/images/logo.png"  border="0" alt="tharichoice"></div>
<div style="margin-top:20px;"><span style="font-weight:bold;">Dear</span><span style="color:#e8410d;font-weight:bolder;"> '.ucfirst($reseller_name).'</span>,</div><br>
<div style="margin:0px;padding:0px;line-height:20px;">Welcome to ThariChoice.Com - Indias largest reseller\'s network .<br><br></div>
<div style="background-color:#faf9f8; border-radius:10px; padding:10px;">				
<div>Your tharichoice.com login details are:</div><br>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tbody style="background:#FFFFFF; border-radius:10px;">
<tr >
<td width="18%" valign="top"><img src="'.SITE_WS_PATH.'/images/img.png" border="0" height="63" width="90" alt="ThariChoice.Com  Login Details"></td>
<td width="82%" style="line-height:25px;">User Name: <strong>'.$reseller_email.'</strong><br>Password: <strong>'.$reseller_pass.'</strong><!--<div style="margin-top:7px;"><a  href="" style="font-size:11px;color:#00f;text-decoration:underline;">change your password</a></div>--></td>
</tr></tbody></table>
</div> 
<br>				
<div style="padding-top:5px;" >				
<p style="margin-top:15px;"><a href="'.SITE_WS_PATH.'/activation.php?id='.base64_encode($reseller_email).'">Click here To Activate Your Account.</a></p>
  <p style="margin-top:15px;font-weight:bold; color:#FF0000;font-size:10px;"><strong>(*PLEASE VERIFY YOUR ACCOUNT WITHIN SEVEN DAYS OTHERWISE YOUR ACCOUNT DETAILS WILL BE DELETED FROM OUR PORTAL.) </strong></p>				
<p style="margin-top:10px;">Know about our Paid Promotion Services. <a  href="'.SITE_WS_PATH.'/manage-membership.php"  style="color:#000;"><strong style="color:#0000ff;text-decoration:underline;">Click Here</strong></a></p>				
<p style="border-top:1px solid #ebebeb;padding-top:10px;"><strong>Customer Care Team</strong><br>Tharichoice.Com<br><a href="'.SITE_WS_PATH.'" target="_blank" style="color:#00f;">www.tharichoice.com</a><br>Email: <a href="mailto:info@tharichoice.com"  style="color:#00f;">info@tharichoice.com</a></p>				
<div style="font-family:Arial, Helvetica, sans-serif;font-size:13px;background-color:#fcfcfc;color:#666;">Note: This is a system-generated mail, dont reply to this.<br>You are receiving this mailer as a registered member of <strong>tharichoice.com</strong>. Please add this info@tharichoice.com to your address book to ensure delivery into your inbox</div>
</div>
</div>
</div>
</center>';


$_SESSION['msg'] = "Reseller is registered successfully.";		   

}
}		   
?>  


<?php
if(isset($_POST['Update'])){

 $sql="update  tbl_resellers set 
           reseller_name='$reseller_name',
		   reseller_adrs='$reseller_adrs',
		   reseller_pass='$reseller_pass',
		   reseller_mobile='$reseller_mobile',
		   reseller_add_date='$currDate',
	       reseller_zip_code='$reseller_zip_code',
	       reseller_city='$reseller_city',		   
	       reseller_country='$reseller_country'		   		   		   		   
		   WHERE reseller_id='$reseller_id'		   
		   ";
		   db_query($sql);
		   
$_SESSION['msg'] = "Reseller is updated successfully.";		   
}		   
?>  



<?php
$reseller_id=$_GET['reseller_id'];

if($reseller_id!=""){
$sql="SELECT * FROM tbl_resellers WHERE 1 AND reseller_id='$reseller_id'";
$dataRegd=db_query($sql);
$recRegd=mysqli_fetch_array($dataRegd);
}
?>


         <!-- Content Wrapper. Contains page content -->
         <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
               <div class="header-icon">
                  <i class="fa fa-balance-scale"></i>
               </div>
               <div class="header-title">
                  <h1>Add/Edit Reseller</h1>
                  <small>Add/Edit reseller information</small>
                  
                  
<a href="manage-resellers.php"><button id="btn-go-back" type="button" class="btn btn-labeled btn-inverse m-b-5 pull-right">
<span class="btn-label" ><i class="fa fa-chevron-circle-left"></i></span>Go Back
</button></a>

                  
               </div>
               
               
            </section>
            <!-- Main content -->
<script src="../ckeditor/ckeditor.js"></script>            
            <section class="content">
               <div class="row">
                  <!-- Form controls -->
                  <div class="col-sm-12">
                     <div class="panel panel-bd lobidrag" data-edit-title='false' data-close='false' data-reload='false'>
                        <div class="panel-heading">
                           <div class="btn-group" id="buttonexport">
                              <a href="#">
                                 <h4><i class="fa fa-info-circle fa-lg" aria-hidden="true"></i>
&nbsp;Reseller Information</h4>
                              </a>
                           </div>
                        </div>
                        <div class="panel-body">
                        
<?php if($_SESSION['msg']!=""){?>
          <div class="col-lg-12 text-center" id="error-msg"><?=$_SESSION['msg']?></div>
          <?php 
		  unset($_SESSION['msg']);
		  }
		  ?>
          
          
                                  
<div class="col-lg-9 update-profile-holder col-lg-offset-2  mt20">

<form class="register-form outer-top-xs" method="post" role="form" onsubmit="return EnqValidation2()">

<?php if($reseller_id!=""){?> 
<div class="form-group col-lg-12">
<div class="col-lg-2 "><label class="info-title" for="exampleInputEmail2">Email&nbsp;Address&nbsp;<span>*</span></label></div>
<div class="col-lg-10 "><input type="text" name="reseller_email" id="reseller_email2" disabled   value="<?=$recRegd['reseller_email']?>" placeholder="Your email/user id" class="form-control unicase-form-control text-input"  >



</div>
</div>


<?php }else{?>
<div class="form-group col-lg-12">
<div class="col-lg-2 "><label class="info-title" for="exampleInputEmail2">Email&nbsp;Address&nbsp;<span>*</span></label></div>
<div class="col-lg-10 "><input type="text" name="reseller_email" id="reseller_email"   value="" placeholder="Your email/user id" class="form-control unicase-form-control text-input" onkeyup="check_email()" >

<span class="err" id="error_reseller_email"></span>   

<span class="err" id="error_msg"></span>   



</div>
</div>

<?php }?>


<div class="form-group col-lg-12">
<div class="col-lg-2 "><label class="info-title" for="exampleInputEmail2">Password <span>*</span></label></div>
<div class="col-lg-10 "><input type="text" name="reseller_pass" id="reseller_pass" value="<?=$recRegd['reseller_pass']?>" placeholder="Your name" class="form-control unicase-form-control text-input"></div>
</div>


<div class="form-group col-lg-12">
<div class="col-lg-2 "><label class="info-title" for="exampleInputEmail2">Name <span>*</span></label></div>
<div class="col-lg-10 "><input type="text" name="reseller_name" id="reseller_name" value="<?=$recRegd['reseller_name']?>" placeholder="Your name" class="form-control unicase-form-control text-input"></div>
</div>



<div class="form-group col-lg-12">
<div class="col-lg-2 "><label class="info-title" for="exampleInputEmail2">Contact No <span>*</span></label></div>
<div class="col-lg-10 "><input type="text" class="form-control unicase-form-control text-input" name="reseller_mobile" id="reseller_mobile" value="<?=$recRegd['reseller_mobile']?>" placeholder="Your mobile"></div>
</div>

<div class="form-group col-lg-12">
<div class="col-lg-2 "><label class="info-title" for="exampleInputEmail2">Address <span>*</span></label></div>
<div class="col-lg-10 "><textarea name="reseller_adrs" id="reseller_adrs" rows="2" class="form-control theme-bdr" placeholder="Your Address"><?=$recRegd['reseller_adrs']?></textarea>		</div>
</div>

<div class="form-group col-lg-12">
<div class="col-lg-2 "><label class="info-title" for="exampleInputEmail2">Zip Code <span>*</span></label></div>
<div class="col-lg-10 "><input type="text" placeholder="Enter zip/pin code" class="form-control unicase-form-control text-input" name="reseller_zip_code" id="reseller_zip_code" value="<?=$recRegd['reseller_zip_code']?>"></div>
</div>


<div class="form-group col-lg-12">
<div class="col-lg-2 "><label class="info-title" for="exampleInputEmail2">City <span>*</span></label></div>
<div class="col-lg-10 "><input type="text" placeholder="Enter city " name="reseller_city" id="reseller_city" value="<?=$recRegd['reseller_city']?>" class="form-control unicase-form-control text-input"></div>
</div>



<div class="form-group col-lg-12">
<div class="col-lg-2 "><label class="info-title" for="exampleInputEmail2">Country <span>*</span></label></div>
<div class="col-lg-10 ">
<select class="form-control for-select-box" name="reseller_country" id="reseller_country">

                  <option value="Afghanistan">Afghanistan</option>
                  <option value="Albania">Albania</option>
                  <option value="Algeria">Algeria</option>
                  <option value="American Samoa">American Samoa</option>
                  <option value="Andorra">Andorra</option>
                  <option value="Angola">Angola</option>
                  <option value="Anguilla">Anguilla</option>
                  <option value="Antarctica">Antarctica</option>
                  <option value="Antigua and Barbuda">Antigua and Barbuda</option>
                  <option value="Argentina">Argentina</option>
                  <option value="Armenia">Armenia</option>
                  <option value="Aruba">Aruba</option>
                  <option value="Australia">Australia</option>
                  <option value="Austria">Austria</option>
                  <option value="Azerbaijan">Azerbaijan</option>
                  <option value="Bahamas">Bahamas</option>
                  <option value="Bahrain">Bahrain</option>
                  <option value="Bangladesh">Bangladesh</option>
                  <option value="Barbados">Barbados</option>
                  <option value="Belarus">Belarus</option>
                  <option value="Belgium">Belgium</option>
                  <option value="Belize">Belize</option>
                  <option value="Benin">Benin</option>
                  <option value="Bermuda">Bermuda</option>
                  <option value="Bhutan">Bhutan</option>
                  <option value="Bolivia">Bolivia</option>
                  <option value="Bosnia and Herzegowina">Bosnia and Herzegowina</option>
                  <option value="Botswana">Botswana</option>
                  <option value="Bouvet Island">Bouvet Island</option>
                  <option value="Brazil">Brazil</option>
                  <option value="British Indian Ocean Territory">British Indian Ocean Territory</option>
                  <option value="Brunei Darussalam">Brunei Darussalam</option>
                  <option value="Bulgaria">Bulgaria</option>
                  <option value="Burkina Faso">Burkina Faso</option>
                  <option value="Burundi">Burundi</option>
                  <option value="Cambodia">Cambodia</option>
                  <option value="Cameroon">Cameroon</option>
                  <option value="Canada">Canada</option>
                  <option value="Cape Verde">Cape Verde</option>
                  <option value="Cayman Islands">Cayman Islands</option>
                  <option value="Central African Republic">Central African Republic</option>
                  <option value="Chad">Chad</option>
                  <option value="Chile">Chile</option>
                  <option value="China">China</option>
                  <option value="Christmas Island">Christmas Island</option>
                  <option value="Cocos (Keeling) Islands">Cocos (Keeling) Islands</option>
                  <option value="Colombia">Colombia</option>
                  <option value="Comoros">Comoros</option>
                  <option value="Congo">Congo</option>
                  <option value="Cook Islands">Cook Islands</option>
                  <option value="Costa Rica">Costa Rica</option>
                  <option value="Croatia (local name: Hrvatska)">Croatia (local name: Hrvatska)</option>
                  <option value="Cuba">Cuba</option>
                  <option value="Cyprus">Cyprus</option>
                  <option value="Czech Republic">Czech Republic</option>
                  <option value="Denmark">Denmark</option>
                  <option value="Djibouti">Djibouti</option>
                  <option value="Dominica">Dominica</option>
                  <option value="Dominican Republic">Dominican Republic</option>
                  <option value="East Timor">East Timor</option>
                  <option value="Ecuador">Ecuador</option>
                  <option value="Egypt">Egypt</option>
                  <option value="El Salvador">El Salvador</option>
                  <option value="Equatorial Guinea">Equatorial Guinea</option>
                  <option value="Eritrea">Eritrea</option>
                  <option value="Estonia">Estonia</option>
                  <option value="Ethiopia">Ethiopia</option>
                  <option value="Falkland Islands (Malvinas)">Falkland Islands (Malvinas)</option>
                  <option value="Faroe Islands">Faroe Islands</option>
                  <option value="Fiji">Fiji</option>
                  <option value="Finland">Finland</option>
                  <option value="France">France</option>
                  <option value="France Metropolitan">France Metropolitan</option>
                  <option value="French Guiana">French Guiana</option>
                  <option value="French Polynesia">French Polynesia</option>
                  <option value="French Southern Territories">French Southern Territories</option>
                  <option value="Gabon">Gabon</option>
                  <option value="Gambia">Gambia</option>
                  <option value="Georgia">Georgia</option>
                  <option value="Germany">Germany</option>
                  <option value="Ghana">Ghana</option>
                  <option value="Gibraltar">Gibraltar</option>
                  <option value="Greece">Greece</option>
                  <option value="Greenland">Greenland</option>
                  <option value="Grenada">Grenada</option>
                  <option value="Guadeloupe">Guadeloupe</option>
                  <option value="Guam">Guam</option>
                  <option value="Guatemala">Guatemala</option>
                  <option value="Guinea">Guinea</option>
                  <option value="Guinea-Bissau">Guinea-Bissau</option>
                  <option value="Guyana">Guyana</option>
                  <option value="Haiti">Haiti</option>
                  <option value="Heard and Mc Donald Islands">Heard and Mc Donald Islands</option>
                  <option value="Honduras">Honduras</option>
                  <option value="Hong Kong">Hong Kong</option>
                  <option value="Hungary">Hungary</option>
                  <option value="Iceland">Iceland</option>
                  <option value="India" selected="selected">India</option>
                  <option value="Indonesia">Indonesia</option>
                  <option value="Iran (Islamic Republic of)">Iran (Islamic Republic of)</option>
                  <option value="Iraq">Iraq</option>
                  <option value="Ireland">Ireland</option>
                  <option value="Israel">Israel</option>
                  <option value="Italy">Italy</option>
                  <option value="Jamaica">Jamaica</option>
                  <option value="Japan">Japan</option>
                  <option value="Jordan">Jordan</option>
                  <option value="Kazakhstan">Kazakhstan</option>
                  <option value="Kenya">Kenya</option>
                  <option value="Kiribati">Kiribati</option>
                  <option value="Kuwait">Kuwait</option>
                  <option value="Kyrgyzstan">Kyrgyzstan</option>
                  <option value="Latvia">Latvia</option>
                  <option value="Lebanon">Lebanon</option>
                  <option value="Lesotho">Lesotho</option>
                  <option value="Liberia">Liberia</option>
                  <option value="Libyan Arab Jamahiriya">Libyan Arab Jamahiriya</option>
                  <option value="Liechtenstein">Liechtenstein</option>
                  <option value="Lithuania">Lithuania</option>
                  <option value="Luxembourg">Luxembourg</option>
                  <option value="Macao">Macao</option>
                  <option value="Macedonia">Macedonia</option>

                  <option value="Madagascar">Madagascar</option>
                  <option value="Malawi">Malawi</option>
                  <option value="Malaysia">Malaysia</option>
                  <option value="Maldives">Maldives</option>
                  <option value="Mali">Mali</option>
                  <option value="Malta">Malta</option>
                  <option value="Marshall Islands">Marshall Islands</option>
                  <option value="Martinique">Martinique</option>
                  <option value="Mauritania">Mauritania</option>
                  <option value="Mauritius">Mauritius</option>
                  <option value="Mayotte">Mayotte</option>
                  <option value="Mexico">Mexico</option>
                  <option value="Micronesia">Micronesia</option>
                  <option value="Moldova">Moldova</option>
                  <option value="Monaco">Monaco</option>
                  <option value="Mongolia">Mongolia</option>
                  <option value="Montserrat">Montserrat</option>
                  <option value="Morocco">Morocco</option>
                  <option value="Mozambique">Mozambique</option>
                  <option value="Myanmar">Myanmar</option>
                  <option value="Namibia">Namibia</option>
                  <option value="Nauru">Nauru</option>
                  <option value="Nepal">Nepal</option>
                  <option value="Netherlands">Netherlands</option>
                  <option value="Netherlands Antilles">Netherlands Antilles</option>
                  <option value="New Caledonia">New Caledonia</option>
                  <option value="New Zealand">New Zealand</option>
                  <option value="Nicaragua">Nicaragua</option>
                  <option value="Niger">Niger</option>
                  <option value="Nigeria">Nigeria</option>
                  <option value="Niue">Niue</option>
                  <option value="Norfolk Island">Norfolk Island</option>
                  <option value="North Korea">North Korea</option>
                  <option value="Northern Mariana Islands">Northern Mariana Islands</option>
                  <option value="Norway">Norway</option>
                  <option value="Oman">Oman</option>
                  <option value="Pakistan">Pakistan</option>
                  <option value="Palau">Palau</option>
                  <option value="Panama">Panama</option>
                  <option value="Papua New Guinea">Papua New Guinea</option>
                  <option value="Paraguay">Paraguay</option>
                  <option value="Peru">Peru</option>
                  <option value="Philippines">Philippines</option>
                  <option value="Pitcairn">Pitcairn</option>
                  <option value="Poland">Poland</option>
                  <option value="Portugal">Portugal</option>
                  <option value="Puerto Rico">Puerto Rico</option>
                  <option value="Qatar">Qatar</option>
                  <option value="Reunion">Reunion</option>
                  <option value="Romania">Romania</option>
                  <option value="Russian Federation">Russian Federation</option>
                  <option value="Rwanda">Rwanda</option>
                  <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
                  <option value="Saint Lucia">Saint Lucia</option>
                  <option value="Saint Vincent and the Grenadines">Saint Vincent and the Grenadines</option>
                  <option value="Samoa">Samoa</option>
                  <option value="San Marino">San Marino</option>
                  <option value="Sao Tome and Principe">Sao Tome and Principe</option>
                  <option value="Saudi Arabia">Saudi Arabia</option>
                  <option value="Senegal">Senegal</option>
                  <option value="Seychelles">Seychelles</option>
                  <option value="Sierra Leone">Sierra Leone</option>
                  <option value="Singapore">Singapore</option>
                  <option value="Slovakia (Slovak Republic)">Slovakia (Slovak Republic)</option>
                  <option value="Slovenia">Slovenia</option>
                  <option value="Solomon Islands">Solomon Islands</option>
                  <option value="Somalia">Somalia</option>
                  <option value="South Africa">South Africa</option>
                  <option value="South Korea">South Korea</option>
                  <option value="Spain">Spain</option>
                  <option value="Sri Lanka">Sri Lanka</option>
                  <option value="St. Helena">St. Helena</option>
                  <option value="St. Pierre and Miquelon">St. Pierre and Miquelon</option>
                  <option value="Sudan">Sudan</option>
                  <option value="Suriname">Suriname</option>
                  <option value="Svalbard and Jan Mayen Islands">Svalbard and Jan Mayen Islands</option>
                  <option value="Swaziland">Swaziland</option>
                  <option value="Sweden">Sweden</option>
                  <option value="Switzerland">Switzerland</option>
                  <option value="Syrian Arab Republic">Syrian Arab Republic</option>
                  <option value="Taiwan">Taiwan</option>
                  <option value="Tajikistan">Tajikistan</option>
                  <option value="Tanzania">Tanzania</option>
                  <option value="Thailand">Thailand</option>
                  <option value="Togo">Togo</option>
                  <option value="Tokelau">Tokelau</option>
                  <option value="Tonga">Tonga</option>
                  <option value="Trinidad and Tobago">Trinidad and Tobago</option>
                  <option value="Tunisia">Tunisia</option>
                  <option value="Turkey">Turkey</option>
                  <option value="Turkmenistan">Turkmenistan</option>
                  <option value="Turks and Caicos Islands">Turks and Caicos Islands</option>
                  <option value="Tuvalu">Tuvalu</option>
                  <option value="Uganda">Uganda</option>
                  <option value="Ukraine">Ukraine</option>
                  <option value="United Arab Emirates">United Arab Emirates</option>
                  <option value="United Kingdom">United Kingdom</option>
                  <option value="United States">United States</option>
                  <option value="United States Minor Outlying 

                    

                    Islands">United States Minor Outlying 
                  
                  
                  
                  Islands</option>
                  <option value="Uruguay">Uruguay</option>
                  <option value="Uzbekistan">Uzbekistan</option>
                  <option value="Vanuatu">Vanuatu</option>
                  <option value="Vatican City State (Holy See)">Vatican City State (Holy See)</option>
                  <option value="Venezuela">Venezuela</option>
                  <option value="Vietnam">Vietnam</option>
                  <option value="Virgin Islands (British)">Virgin Islands (British)</option>
                  <option value="Virgin Islands (U.S.)">Virgin Islands (U.S.)</option>
                  <option value="Wallis And Futuna Islands">Wallis And Futuna Islands</option>
                  <option value="Western Sahara">Western Sahara</option>
                  <option value="Yemen">Yemen</option>
                  <option value="Yugoslavia">Yugoslavia</option>
                  <option value="Congo, The Democratic Republic Of 

                    

                    The">Congo, The Democratic Republic Of 
                  
                  
                  
                  The</option>
                  <option value="Zambia">Zambia</option>
                  <option value="Zimbabwe">Zimbabwe</option>
                  <option value="Other Country">Other Country</option>
                  
                  
<?php if($recRegd['reseller_country']!=""){?>
<option value="<?=$recRegd['reseller_country']?>" selected><?=$recRegd['reseller_country']?></option>
<?php }?>                                    
                                    
                </select>







</div>
</div>



<div class="form-group col-lg-12">
<div class="col-lg-2 ">&nbsp;</div>
<div class="col-lg-10 ">


<?php if($reseller_id!=""){?>
<button type="submit" name="Update" id="UpdateProfile" class="btn-upper btn btn-primary checkout-page-button btn-update-profile">Update</button>
<?php }else{?>
<button type="submit" name="Register" id="UpdateProfile" class="btn-upper btn btn-primary checkout-page-button btn-update-profile">Submit</button>
<?php }?>

</div>
</div>










</form>




</div>
                        </div>
                     </div>
                  </div>
               </div>
            </section>
            <!-- /.content -->
         </div>
<?php require_once("footer.php"); ?>
 <script>
$(document).ready(function(e) {
    
$("#reseller_email").on('blur',function(){


var email=$('#reseller_email').val();

//alert(email)

var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
if(email==''){
$('#error_reseller_email').html("Please enter only alphabets !")
$('#reseller_email').val('');
}else if(!email.match(mailformat)){
$('#error_reseller_email').html("You have entered an invalid email address!")
$('#reseller_email').val('');
}else{


$.ajax({
type:'POST',
url:"../check-email-reseller.php?email="+email,
success: function(result){
$("#error_msg").html(result);	

$('#error_reseller_email').html('')	
}

})	


}
	
})


$('#reseller_email').on('keypress',function(){
$('#error_reseller_email').html('')	
})

	
	
});



</script>



<script type="text/javascript">
function EnqValidation2(){	
   function trim(str){				
	 return str.replace(/^\s*|\s*$/g,'');
	}	
	
	
var email=trim(document.getElementById('reseller_email').value);
var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
if(email=='')
  {
	  alert('Please Enter Email Id');
	  document.getElementById('reseller_email').focus();
	  return false;
  }else if(!email.match(mailformat)){
alert("You have entered an invalid email address!");
document.getElementById('reseller_email').focus();
return false;
}	
	
	
if(trim(document.getElementById('reseller_name').value)==0){		
alert("Enter Your Name !");
document.getElementById('reseller_name').focus();
return false;
}	
if (!document.getElementById('reseller_name').value.match(/^[a-zA-Z-,]+(\s{0,1}[a-zA-Z-, ])*$/)){
alert("Please enter only alphabets !");
document.getElementById('reseller_name').value='';
document.getElementById('reseller_name').focus();
return false;
}



var mobno=trim(document.getElementById('reseller_mobile_no').value);
if(trim(document.getElementById('reseller_mobile_no').value)==0){
	alert("Enter your mobile no.!");
	document.getElementById('reseller_mobile_no').focus();
	return false;
}
if(isNaN(document.getElementById('reseller_mobile_no').value)){
	alert("Mobile no. should be no.!");
	document.getElementById('reseller_mobile_no').focus();
	return false;
}
if(mobno.length < 10){
    alert("Mobile no. should be 10 digit long !");
	document.getElementById('reseller_mobile_no').focus();
	return false;
}




if(trim(document.getElementById('reseller_address').value)==0){
	alert("Enter your address !");
	document.getElementById('reseller_address').focus();
	return false;
 }
 
 
 if(trim(document.getElementById('reseller_zip_code').value)==0){
	alert("Enter your pin/zip code !");
	document.getElementById('reseller_zip_code').focus();
	return false;
 }
 
  if(trim(document.getElementById('reseller_city').value)==0){
	alert("Enter your city name !");
	document.getElementById('reseller_city').focus();
	return false;
 }


  if(trim(document.getElementById('reseller_state').value)==0){
	alert("Enter your state name !");
	document.getElementById('reseller_state').focus();
	return false;
 }


  if(trim(document.getElementById('reseller_coutry').value)==0){
	alert("Enter your country name !");
	document.getElementById('reseller_coutry').focus();
	return false;
 }
 
 
	
}
</script>