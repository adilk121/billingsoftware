<?php include("site-header.php"); ?>
 <?php include("inner-banner.php"); ?>


 <?php
 if(isset($_POST['EnqSubmitContact']))
 {
  @extract($_REQUEST);

  
  $sql="insert into tbl_enquiry set
      enquiry_name='$contact_name',
      enquiry_mobile='$contact_phone',
      enquiry_email='$contact_email',
      enquiry_subject='$contact_subject',
      enquiry_detail='$contact_message',
      enquiry_source='Enquiry',
      enquiry_add_date=now()";
      db_query($sql);
      
      
      
       ///////////////****** Mailer to client start here **********************//////////////
  $hostName = $_SERVER['HTTP_HOST'];          
$msgmail="<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' />
<title>$compDATA[admin_company_name]</title>
 </head>
<body>      
   <table align='center' cellSpacing='0' cellPadding='0' width='87%' border='1' style='border:1px solid #e61938'>
  <tbody>
    <tr>
      <td vAlign='top' style='background-color:#e61938; padding:10px;font-family:Verdana, Arial, Helvetica, sans-serif; font-size:16px; color:#ffffff; text-align:center; font-weight:bold;' colspan='3' >Enquiry From $hostName</td>
    </tr>
     <tr>
      <td width='30%' vAlign='top' style='font-family:Verdana, Arial, Helvetica, sans-serif; font-size:14px; color:#003366; background-color:#F9E2DD;padding:10px;' ><strong>Name </strong> </td>
      <td vAlign='top' width='70%' style='font-family:Verdana, Arial, Helvetica, sans-serif;padding:10px;'>$contact_name</td>
    </tr>    
    <tr>
      <td vAlign='top'  style='font-family:Verdana, Arial, Helvetica, sans-serif; font-size:14px; color:#003366; background-color:#F9E2DD;padding:10px;' ><strong>Mobile </strong> </td>
      <td vAlign='top' style='font-family:Verdana, Arial, Helvetica, sans-serif;padding:10px;'>$contact_phone</td>
    </tr>
    <tr>
      <td vAlign='top'  style='font-family:Verdana, Arial, Helvetica, sans-serif; font-size:14px; color:#003366; background-color:#F9E2DD;padding:10px;' ><strong>Email-Id </strong> </td>
      <td vAlign='top' style='font-family:Verdana, Arial, Helvetica, sans-serif;padding:10px;'>$contact_email</td>
    </tr>    
   
      <tr>
      <td vAlign='top'  style='font-family:Verdana, Arial, Helvetica, sans-serif; font-size:14px; color:#003366; background-color:#F9E2DD;padding:10px;' ><strong>Subject </strong> </td>
      <td vAlign='top' style='font-family:Verdana, Arial, Helvetica, sans-serif;padding:10px;'>$contact_subject</td>
    </tr>  
    <tr>
      <td vAlign='top'  style='font-family:Verdana, Arial, Helvetica, sans-serif; font-size:14px; color:#003366; background-color:#F9E2DD;padding:10px;' ><strong>Detail </strong> </td>
      <td vAlign='top' style='font-family:Verdana, Arial, Helvetica, sans-serif;padding:10px;'>$contact_message</td>
    </tr>    
  </tbody>
</table>
</body>
</html>";

$toEmail = $compDATA['admin_email'];
//$toEmail="rehantki@gmail.com";
$subject = "Enquiry from $hostName";
            $from="$contact_email";
        $Headers1 = "From: $contact_name<$from>\n";
        $Headers1 .= "X-Mailer: PHP/". phpversion();
        $Headers1 .= "X-Priority: 3 \n";
        $Headers1 .= "MIME-version: 1.0\n";
        $Headers1 .= "Content-Type: text/html; charset=iso-8859-1\n"; 
        @mail("$toEmail", "$subject", "$msgmail","$Headers1","-fenquiry@tradekeyindia.com");
        //@mail("amitabh.tradekeyindia@gmail.com", "Subject", "Msg1","$Headers1","-fenquiry@tradekeyindia.com");
         $toEmail."<br>";
         
///////////////****** Mailer to User **********************//////////////
$toEmail2 = $contact_email;
$subject2 = "Enquiry of $hostName";
            $from2="$compDATA[admin_email]";
        $Headers12 = "From: $compDATA[admin_company_name]<$from2>\n";
        $Headers12 .= "X-Mailer: PHP/". phpversion();
        $Headers12 .= "X-Priority: 3 \n";
        $Headers12 .= "MIME-version: 1.0\n";
        $Headers12 .= "Content-Type: text/html; charset=iso-8859-1\n"; 
        @mail("$toEmail2", "$subject2", "$msgmail","$Headers12","-fenquiry@tradekeyindia.com");
        //@mail("amitabh.tradekeyindia@gmail.com", "Subject", "Msg1","$Headers1","-fenquiry@tradekeyindia.com");
         $toEmail2."<br>";
         
///////////////****** Mailer to client end here **********************//////////////
///////////////// Mail To Admin //////////////////////////////////

$mail_to_admin="client_enquiry@tradekeyindia.com";
//$mail_to_admin="arif.tradekeyindia@gmail.com";
$sub_admin="Business Enquiry From $hostName";
$mail_admin_body = "$msgmail";  
$sender_admin =$contact_email;   
$headers_admin  = "MIME-Version: 1.0" . "\r\n";
$headers_admin .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";
$headers_admin .= "from: ".$sender_admin."\n";
if($contact_email){
@mail($mail_to_admin,$sub_admin,$mail_admin_body,$headers_admin);
?>
<script>//alert("Enquiry form submitted successfully. We will contact you soon.");

  swal("Successfull", "Enquiry form submitted successfully, We will contact you soon", "success");</script>
<?
}
}

 
?>

          <style>
#error_style_contact{
    color:white; 
    font-size:13px;
    font-family:arial;
    background-color:#c32323;
    border-radius:7px; 
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
    box-sizing: border-box;
    padding:7px;
    margin-top: 10px;
}

.error_name_contact{
       display:none;
}
.error_email_contact{
       display:none;
}


.error_phone_contact{
       display:none;
}
.error_subject_contact{
       display:none;
}

.error_message_contact{
       display:none;
}


   </style>
      <!-- Contact Me -->
      <section class="section-padding  bg-white">
         <div class="container">
            <div class="row">





               <form class="col-lg-8 col-md-8" action="" method="post" enctype="multipart/form-data" onsubmit="return checkValidationContact();">
                  <div class="section-title">
                     <h2 class="mt-1 mb-5">Enquiry</h2>
                        <?=db_scalar("select site_pages_description from tbl_site_pages where site_pages_link='enquiry'");?>
                  </div>
                  <div class="control-group form-group">
                     <div class="controls">
                        <label>Full Name <span class="text-danger">*</span></label>
                        <input type="text" placeholder="Full Name" class="form-control" name="contact_name" id="contact_name" onkeyup="errNameContact();">
                                           <p id="error_style_contact" class="error_name_contact" style="width:255px;"></p>
                     </div>
                  </div>
                  <div class="row">
                     <div class="control-group form-group col-md-6">
                        <label>Email Address<span class="text-danger">*</span></label>
                        <div class="controls">
                           <input type="text" placeholder="Email Address" class="form-control" name="contact_email" id="contact_email" onkeyup="errEmailContact();">
                            <p id="error_style_contact" class="error_email_contact" style="width:250px;"></p>
                        </div>
                     </div>
                     <div class="control-group form-group col-md-6">
                        <div class="controls">
                           <label> Phone Number <span class="text-danger">*</span></label>
                           <input type="text" placeholder="Phone Number"  class="form-control" maxlength="10" name="contact_phone" id="contact_phone" onkeyup="errPhoneContact();">
                             <p id="error_style_contact" class="error_phone_contact" style="width:250px;"></p>
                        </div>
                     </div>
                  </div>

                  <div class="control-group form-group">
                     <div class="controls">
                        <label>Subject <span class="text-danger">*</span></label>
                        <input type="text" placeholder="Subject" class="form-control" name="contact_subject" id="contact_subject" onkeyup="errSubjectContact();">
                             <p id="error_style_contact" class="error_subject_contact" style="width:250px;"></p>
                     </div>
                  </div>
                  <div class="control-group form-group">
                     <div class="controls">
                        <label>Message <span class="text-danger">*</span></label>
                        <textarea rows="4" cols="100" placeholder="Message"  class="form-control" name="contact_message" id="contact_message" onkeyup="errMessageContact();"></textarea>
                         <p id="error_style_contact" class="error_message_contact" style="width:250px;"></p>
                     </div>
                  </div>
                  <div id="success"></div>
                  <!-- For success/fail messages -->
                  <button type="submit" class="btn btn-secondary btn-lg" name="EnqSubmitContact">Send Message</button>
               </form>

               
               <div class="col-lg-4 col-md-4 contact-us">
                <img src="img/enquiry-img.jpg" width="320">
               </div>
            </div>
         </div>


   
      </section>
      <!-- End Contact Me -->



<script>

  function trimfield(str) 
        { 
            return str.replace(/^\s+|\s+$/g,''); 
        }
    function checkValidationContact(){
      
        var name=document.getElementById("contact_name");
         var email=document.getElementById("contact_email");
        var phone=document.getElementById("contact_phone");
        var subject=document.getElementById("contact_subject");
       var message=document.getElementById("contact_message");
         
        if(name.value==""){
            $('#contact_name').css({"border-color":"red"});
            name.focus();
            $('.error_name_contact').fadeIn('slow');
             $(".error_name_contact").html("Please enter your name !");
            return false;
        }

        if(name.value.length<=3){
             $('#contact_name').css({"border-color":"red"});
            name.focus();
            $(".error_name_contact").html("Name should be greater than 3 alphabet !");
            $('.error_name_contact').fadeIn('slow');
            return false;
        }

        if (/[0-9]/g.test(name.value)) {
            $('#contact_name').css({"border-color":"red"});
                name.focus();
         $(".error_name_contact").html("Use alphabet only !");
            $('.error_name_contact').fadeIn('slow');
                return false;
        }

       if(email.value==""){
             $('#contact_email').css({"border-color":"red"});
            email.focus();
             $(".error_email_contact").html("Please enter your email !");
            $('.error_email_contact').fadeIn('slow');
            return false;            
        }
        if(!/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email.value)){
             $('#contact_email').css({"border-color":"red"});
            email.focus();
             $(".error_email_contact").html("Please enter valid email address !");
            $('.error_email_contact').fadeIn('slow');
            return false;
        }

  
    
     
           if(phone.value==""){
             $('#contact_phone').css({"border-color":"red"});
            phone.focus();
            $(".error_phone_contact").html("Please enter phone number !");
            $('.error_phone_contact').fadeIn('slow');
            return false;
        }

        if(isNaN(phone.value)){
             $('#contact_phone').css({"border-color":"red"});
            phone.focus();
             $(".error_phone_contact").html("Please enter numeric value !");
            $('.error_phone_contact').fadeIn('slow');
            return false;
        }

        if(phone.value.length<10 || phone.value.length>10){
             $('#contact_phone').css({"border-color":"red"});
            phone.focus();
            $(".error_phone_contact").html("Phone number should be 10 digit long !");
            $('.error_phone_contact').fadeIn('slow');
            return false;
        }

        if(subject.value==""){
            $('#contact_subject').css({"border-color":"red"});
            subject.focus();
            $('.error_subject_contact').fadeIn('slow');
             $(".error_subject_contact").html("Please enter your subject !");
            return false;
        }
        
        if(trimfield(message.value)==""){
             $('#contact_message').css({"border-color":"red"});
            message.focus();
             $(".error_message_contact").html("Please leave your message !");
            $('.error_message_contact').fadeIn('slow');
            return false;
        }

    }
    
    function errNameContact(){
        $('#contact_name').css({"border-color":"#49aecc"});
          $('.error_name_contact').css({"display":"none"});
    }

      function errEmailContact(){
        $('#contact_email').css({"border-color":"#49aecc"});
        $('.error_email_contact').css({"display":"none"});
    }
    
       function errPhoneContact(){
        $('#contact_phone').css({"border-color":"#49aecc"});
        $('.error_phone_contact').css({"display":"none"});
    }
    
   function errSubjectContact(){
        $('#contact_subject').css({"border-color":"#49aecc"});
        $('.error_subject_contact').css({"display":"none"});
    }
    
   
    
      function errMessageContact(){
        $('#contact_message').css({"border-color":"#49aecc"});
        $('.error_message_contact').css({"display":"none"});
    }
</script>
    <?php include("site-footer.php"); ?>