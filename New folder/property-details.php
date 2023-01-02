<?php include("site-header.php"); ?>

<?php
$parent_id=db_scalar("select category_parent_id from tbl_category where category_id='$_REQUEST[id]'");
$ser_query=db_query("select * from tbl_category where category_status='Active' and category_id='$_REQUEST[id]' ");
$ser_res=mysqli_fetch_array($ser_query);

?>


    <style>
    
.slider-1{
background-image: url('<?=$site_url?>/uploaded_files/<?=$ser_res['category_image_name']?>') !important;
}


<?php
$cat_image=db_query("select * from tbl_category_image where 1 and category_image_cat_id='$ser_res[category_id]' ");
$more_img_count=mysqli_num_rows($cat_image);
if($more_img_count>0)
{$i=1;
while($image_res=mysqli_fetch_array($cat_image))
{
    $i++;
?>
        .slider-<?=$i?>{
        background-image: url('<?=$site_url?>/category_more_images/<?=$image_res[category_image_name]?>') !important;
        }
<?}?>
<?}?>

    </style>
      <!-- End Navbar -->
      <!-- Property Single Slider header -->
      <section class="samar-slider">
         <div id="samarslider" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
               <li data-target="#samarslider" data-slide-to="0" class="active"></li>
               <?php
               if($more_img_count>0){
               $cat_image1=db_query("select * from tbl_category_image where 1 and category_image_cat_id='$ser_res[category_id]' ");
                $j=1;
                while($image_res1=mysqli_fetch_array($cat_image1))
                {$j++;?>
               <li data-target="#samarslider" data-slide-to="<?=$j?>"></li>
               <?}?>
               <?}?>
            </ol>
            <div class="carousel-inner" role="listbox">
               <div class="carousel-item active slider-1">
                  <div class="overlay"></div>
               </div>
               
                 <?php
               if($more_img_count>0){
                      $cat_image2=db_query("select * from tbl_category_image where 1 and category_image_cat_id='$ser_res[category_id]' ");
                $k=1;
                while($image_res2=mysqli_fetch_array($cat_image2))
                {
                    $k++;
                ?>
             
               <div class="carousel-item slider-<?=$k?>">
                  <div class="overlay"></div>
               </div>
               <?}?>
               <?}?>
               
            </div>
            <?php
               if($more_img_count>0){
               ?>
            <a class="carousel-control-prev" href="#samarslider" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#samarslider" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
            </a>
            <?}?>
         </div>
         <div class="property-single-title">
            <div class="container">
               <div class="row">
                  <div class="col-lg-8 col-md-8">
                     <h1 class="text-white"><?=$ser_res['category_name']?></h1>
                     <h6 class="text-white"><i class="mdi mdi-home-map-marker"></i> <?=$ser_res['category_areas_name']?></h6>
                  </div>
                  <div class="col-lg-4 col-md-4 text-right">
                     <!--<h6 class="mt-2 text-white">For Rent</h6>-->
                     <h2 class="text-warning"><i class="fa fa-inr"></i> <?=$ser_res['category_amount']?> <small>/ <?=$ser_res['category_amount_type']?></small></h2>
                  </div>
               </div>
               <hr>
           <!--    <div class="row">
                  <div class="col-lg-8 col-md-8">
                     <p class="mt-1 mb-0 text-white"><strong>Property ID</strong> : 533566 &nbsp;&nbsp; <strong>Add to favorites</strong> <i class="mdi mdi-heart text-danger"></i></p>
                  </div>
                  <div class="col-lg-4 col-md-4 text-right">
                     <div class="footer-social">
                        <span class="text-info">Share :</span> &nbsp;
                        <a class="btn-facebook" href="#"><i class="mdi mdi-facebook"></i></a>
                        <a class="btn-twitter" href="#"><i class="mdi mdi-twitter"></i></a>
                        <a class="btn-instagram" href="#"><i class="mdi mdi-instagram"></i></a>
                        <a class="btn-whatsapp" href="#"><i class="mdi mdi-whatsapp"></i></a>
                        <a class="btn-messenger" href="#"><i class="mdi mdi-facebook-messenger"></i></a>
                        <a class="btn-google" href="#"><i class="mdi mdi-google"></i></a>
                     </div>
                  </div>
               </div>-->
            </div>
         </div>
      </section>
      <!-- End Property Single Slider header -->
      <!-- Property Single Slider -->
      <section class="section-padding">
         <div class="container">
            <div class="row">
               <div class="col-lg-8 col-md-8">
                  <div class="card padding-card property-single-slider">
               
                     <div class="col-lg-8 col-md-8">
                        <div class="card-body">
                          <img src="<?=$site_url?>/uploaded_files/<?=$ser_res['category_image_name']?>" >
                         </div>
                         
                          </div>
                       
                          
                     <div class="card-body">
                    
                        <h5 class="card-title mb-3">Description</h5>
                        
                       <!-- <div class="row">
                           <div class="col-lg-4 col-md-4">
                              <div class="list-icon">
                                 <i class="mdi mdi-move-resize-variant"></i>
                                 <strong>Area:</strong>
                                 <p class="mb-0">1270 aq ft</p>
                              </div>
                           </div>
                           <div class="col-lg-4 col-md-4">
                              <div class="list-icon">
                                 <i class="mdi mdi-sofa"></i>
                                 <strong>Beds:</strong>
                                 <p class="mb-0">4 Bedrooms</p>
                              </div>
                           </div>
                           <div class="col-lg-4 col-md-4">
                              <div class="list-icon">
                                 <i class="mdi mdi-hot-tub"></i>
                                 <strong>Baths:</strong>
                                 <p class="mb-0">2 Bathrooms</p>
                              </div>
                           </div>
                        </div>
                        <div class="row">
                           <div class="col-lg-4 col-md-4">
                              <div class="list-icon">
                                 <i class="mdi mdi-garage"></i>
                                 <strong>Rooms:</strong>
                                 <p class="mb-0">6 Rooms</p>
                              </div>
                           </div>
                           <div class="col-lg-4 col-md-4">
                              <div class="list-icon">
                                 <i class="mdi mdi-floor-plan"></i>
                                 <strong>Floors:</strong>
                                 <p class="mb-0">4 Floors</p>
                              </div>
                           </div>
                           <div class="col-lg-4 col-md-4">
                              <div class="list-icon">
                                 <i class="mdi mdi-car-convertible"></i>
                                 <strong>Garage:</strong>
                                 <p class="mb-0">2 Garages</p>
                              </div>
                           </div>
                        </div>-->
                       <?=$ser_res['category_description']?>
                       <table width="100%" border="1" cellpadding="15">
                           
                           <tr>
                               <th>Areas</th><td><?=$ser_res['category_areas_name']?></td>
                           </tr>
                           
                            <tr>
                               <th>City</th><td><?=$ser_res['category_city']?></td>
                           </tr>
                           
                            <tr>
                               <th>Price</th><td><i class="fa fa-inr"></i> <?=$ser_res['category_amount']?> <small>/ <?=$ser_res['category_amount_type']?></small></td>
                           </tr>
                           
                       </table>
                       
                        
                     </div>
                  </div>
              <!--    <div class="card padding-card property-single-slider">
                     <div class="card-body">
                        <h5 class="card-title mb-3">Features</h5>
                        <div class="row">
                           <div class="col-lg-4 col-md-4">
                              <ul class="sidebar-card-list">
                                 <li><a href="#"><i class="mdi mdi-checkbox-marked-outline text-success"></i> In-room tea and coffee</a></li>
                                 <li><a href="#"><i class="mdi mdi-checkbox-marked-outline text-success"></i> Writing desk</a></li>
                                 <li><a href="#"><i class="mdi mdi-checkbox-marked-outline text-success"></i> Personal safe</a></li>
                                 <li><a href="#"><i class="mdi mdi-checkbox-marked-outline text-success"></i> Minibar</a></li>
                                 <li><a href="#"><i class="mdi mdi-checkbox-marked-outline text-success"></i> Refrigerator</a></li>
                                 <li><a href="#"><i class="mdi mdi-checkbox-marked-outline text-success"></i> Electronic key card access</a></li>
                              </ul>
                           </div>
                           <div class="col-lg-4 col-md-4">
                              <ul class="sidebar-card-list">
                                 <li><a href="#"><i class="mdi mdi-checkbox-marked-outline text-success"></i> Refrigerator</a></li>
                                 <li><a href="#"><i class="mdi mdi-checkbox-marked-outline text-success"></i> Electronic key card access</a></li>
                                 <li><a href="#"><i class="mdi mdi-checkbox-marked-outline text-success"></i> In-room tea and coffee</a></li>
                                 <li><a href="#"><i class="mdi mdi-close-box-outline text-danger"></i> Writing desk</a></li>
                                 <li><a href="#"><i class="mdi mdi-close-box-outline text-danger"></i> Personal safe</a></li>
                                 <li><a href="#"><i class="mdi mdi-close-box-outline text-danger"></i> Minibar</a></li>
                              </ul>
                           </div>
                           <div class="col-lg-4 col-md-4">
                              <ul class="sidebar-card-list">
                                 <li><a href="#"><i class="mdi mdi-checkbox-marked-outline text-success"></i> Personal safe</a></li>
                                 <li><a href="#"><i class="mdi mdi-checkbox-marked-outline text-success"></i> Minibar</a></li>
                                 <li><a href="#"><i class="mdi mdi-checkbox-marked-outline text-success"></i> Refrigerator</a></li>
                                 <li><a href="#"><i class="mdi mdi-checkbox-marked-outline text-success"></i> In-room tea and coffee</a></li>
                                 <li><a href="#"><i class="mdi mdi-checkbox-marked-outline text-success"></i> Writing desk</a></li>
                                 <li><a href="#"><i class="mdi mdi-checkbox-marked-outline text-success"></i> Electronic key card access</a></li>
                              </ul>
                           </div>
                        </div>
                     </div>
                  </div>
                 <div class="card padding-card property-single-slider">
                     <div class="card-body">
                        <h5 class="card-title mb-3">Location</h5>
                        <div class="row mb-3">
                           <div class="col-lg-6 col-md-6">
                              <p><strong class="text-dark">Address :</strong> 1200 Petersham Town</p>
                              <p><strong class="text-dark">State :</strong> Newcastle</p>
                           </div>
                           <div class="col-lg-6 col-md-6">
                              <p><strong class="text-dark">City :</strong> Sydney</p>
                              <p><strong class="text-dark">Zip/Postal Code  :</strong> 54330</p>
                           </div>
                        </div>
                        <div id="map"></div>
                     </div>
                  </div>
                  <div class="card padding-card property-single-slider">
                     <div class="card-body">
                        <h5 class="card-title mb-4">Video</h5>
                        <a href="#"><img class="rounded img-fluid" src="img/video.jpg" alt="Card image cap"></a>
                     </div>
                  </div>
                  <div class="card padding-card reviews-card property-single-slider">
                     <div class="card-body">
                        <h5 class="card-title mb-4">3 Reviews</h5>
                        <div class="media mb-4">
                           <img class="d-flex mr-3 rounded-circle" src="img/user/1.jpg" alt="">
                           <div class="media-body">
                              <h5 class="mt-0">Stave Martin <small>Feb 12, 2018</small> 
                                 <span class="star-rating float-right">
                                 <i class="mdi mdi-star text-warning"></i>
                                 <i class="mdi mdi-star text-warning"></i>
                                 <i class="mdi mdi-star text-warning"></i>
                                 <i class="mdi mdi-star-half text-warning"></i>
                                 <i class="mdi mdi-star-half text-warning"></i><small class="text-success">5/2</small>
                                 </span>
                              </h5>
                              <p>Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.</p>
                           </div>
                        </div>
                        <div class="media">
                           <img class="d-flex mr-3 rounded-circle" src="img/user/2.jpg" alt="">
                           <div class="media-body">
                              <h5 class="mt-0">Mark Smith <small>Feb 09, 2018</small> <span class="star-rating float-right">
                                 <i class="mdi mdi-star text-warning"></i>
                                 <i class="mdi mdi-star-half text-warning"></i>
                                 <i class="mdi mdi-star-half text-warning"></i>
                                 <i class="mdi mdi-star-half text-warning"></i>
                                 <i class="mdi mdi-star-half text-warning"></i><small class="text-success">5/1</small>
                                 </span>
                              </h5>
                              <p>Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.</p>
                              <div class="media mt-4">
                                 <img class="d-flex mr-3 rounded-circle" src="img/user/3.jpg" alt="">
                                 <div class="media-body">
                                    <h5 class="mt-0">Ryan Printz <small>Nov 13, 2018</small> <span class="star-rating float-right">
                                       <i class="mdi mdi-star text-warning"></i>
                                       <i class="mdi mdi-star text-warning"></i>
                                       <i class="mdi mdi-star-half text-warning"></i>
                                       <i class="mdi mdi-star-half text-warning"></i>
                                       <i class="mdi mdi-star-half text-warning"></i><small class="text-success">5/5</small>
                                       </span>
                                    </h5>
                                    <p>Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.</p>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="media mt-4">
                           <img class="d-flex mr-3 rounded-circle" src="img/user/4.jpg" alt="">
                           <div class="media-body">
                              <h5 class="mt-0">Stave Mark <small>Feb 12, 2018</small> 
                                 <span class="star-rating float-right">
                                 <i class="mdi mdi-star text-warning"></i>
                                 <i class="mdi mdi-star text-warning"></i>
                                 <i class="mdi mdi-star text-warning"></i>
                                 <i class="mdi mdi-star-half text-warning"></i>
                                 <i class="mdi mdi-star-half text-warning"></i><small class="text-success">5/2</small>
                                 </span>
                              </h5>
                              <p class="mb-0">Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.</p>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="card padding-card property-single-slider">
                     <div class="card-body">
                        <h5 class="card-title mb-4">Leave a Review</h5>
                        <form name="sentMessage">
                           <div class="row">
                              <div class="control-group form-group col-lg-4 col-md-4">
                                 <div class="controls">
                                    <label>Your Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" required>
                                 </div>
                              </div>
                              <div class="control-group form-group col-lg-4 col-md-4">
                                 <div class="controls">
                                    <label>Your Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" required>
                                 </div>
                              </div>
                              <div class="control-group form-group col-lg-4 col-md-4">
                                 <div class="controls">
                                    <label>Rating <span class="text-danger">*</span></label>
                                    <select class="form-control custom-select">
                                       <option>1 Star</option>
                                       <option>2 Star</option>
                                       <option>3 Star</option>
                                       <option>4 Star</option>
                                       <option>5 Star</option>
                                    </select>
                                 </div>
                              </div>
                           </div>
                           <div class="control-group form-group">
                              <div class="controls">
                                 <label>Review <span class="text-danger">*</span></label>
                                 <textarea rows="10" cols="100" class="form-control"></textarea>
                              </div>
                           </div>
                           <button type="submit" class="btn btn-primary btn-lg">Send Message</button>
                        </form>
                     </div>
                  </div>-->
                  
                  
                  
               </div>
               

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
/*.error_subject_contact{
       display:none;
}*/

.error_message_contact{
       display:none;
}


   </style>
               <div class="col-lg-4 col-md-4">
               <!--   <div class="card sidebar-card property-single-slider">
                     <div class="card-body">
                        <h5 class="card-title mb-4">About Agent</h5>
                        <div class="about-agent">
                           <div class="carousel-inner">
                              <div class="carousel-item active">
                                 <div class="card card-list">
                                    <a href="#">
                                       <img class="card-img-top" src="img/agent.jpg" alt="Card image cap">
                                       <div class="card-body pb-0 about-agent-info">
                                          <h5 class="card-title mb-4">Samar Hunjan</h5>
                                          <h6 class="card-subtitle mb-3 text-muted"><i class="mdi mdi-phone"></i> (950) 491-570-180</h6>
                                          <h6 class="card-subtitle mb-3 text-muted"><i class="mdi mdi-email"></i> support@example.com</h6>
                                          <h6 class="card-subtitle text-muted"><i class="mdi mdi-link"></i> www.example.com</h6>
                                       </div>
                                    </a>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>-->
                  <div class="card sidebar-card property-single-slider">
                     <div class="card-body">
                        <h5 class="card-title mb-4">Request a Showing</h5>
                        <form action="" method="post" enctype="multipart/form-data" onsubmit="return checkValidationContact();">
                           <div class="control-group form-group">
                              <div class="controls">
                                 <label>Your Full Name <span class="text-danger">*</span></label>
                                 <input type="text" placeholder="Enter Your Full Name" class="form-control" name="contact_name" id="contact_name" onkeyup="errNameContact();">
                                    <p id="error_style_contact" class="error_name_contact" style="width:255px;"></p>
                              </div>
                           </div>
                           <div class="control-group form-group">
                              <div class="controls">
                                 <label>Your Email Address <span class="text-danger">*</span></label>
                                 <input type="text" placeholder="Enter Your Email Address"  class="form-control" name="contact_email" id="contact_email" onkeyup="errEmailContact();">
                             <p id="error_style_contact" class="error_email_contact" style="width:250px;"></p>
                              </div>
                           </div>
                           <div class="control-group form-group">
                              <div class="controls">
                                 <label>Phone Number <span class="text-danger">*</span></label>
                                 <input type="text" placeholder="Enter Phone Number"  class="form-control" maxlength="10" name="contact_phone" id="contact_phone" onkeyup="errPhoneContact();">
                            <p id="error_style_contact" class="error_phone_contact" style="width:250px;"></p>
                              </div>
                           </div>
                           
                             <input type="hidden"  class="form-control" name="contact_subject" id="contact_subject" value="Enquiry For <?=$ser_res['category_name']?>">
                             
                           <div class="control-group form-group">
                              <div class="controls">
                                 <label>Message <span class="text-danger">*</span></label>
                                 <textarea rows="5" cols="50" class="form-control" name="contact_message" id="contact_message" onkeyup="errMessageContact();"></textarea>
                           <p id="error_style_contact" class="error_message_contact" style="width:250px;"></p>
                              </div>
                           </div>
                           <button type="submit" class="btn btn-secondary btn-lg btn-block" name="EnqSubmitContact">SEND REQUEST</button>
                        </form>
                     </div>
                  </div>
               <!--   <div class="card sidebar-card property-single-slider">
                     <div class="card-body">
                        <h5 class="card-title mb-4">Featured Properties</h5>
                        <div id="featured-properties" class="carousel slide" data-ride="carousel">
                           <ol class="carousel-indicators">
                              <li data-target="#featured-properties" data-slide-to="0" class="active"></li>
                              <li data-target="#featured-properties" data-slide-to="1"></li>
                           </ol>
                           <div class="carousel-inner">
                              <div class="carousel-item active">
                                 <div class="card card-list">
                                    <a href="#">
                                       <div class="card-img">
                                          <div class="badge images-badge"><i class="mdi mdi-image-filter"></i> 03</div>
                                          <span class="badge badge-success">For Sale</span>
                                          <img class="card-img-top" src="img/list/3.png" alt="Card image cap">
                                       </div>
                                       <div class="card-body">
                                          <h2 class="text-primary mb-2 mt-0">
                                             $55,000 <small>/month</small>
                                          </h2>
                                          <h5 class="card-title mb-2">Loft Above The City</h5>
                                          <h6 class="card-subtitle mt-1 mb-0 text-muted"><i class="mdi mdi-home-map-marker"></i> Hope Street (Stop P), London SW11, UK</h6>
                                       </div>
                                       <div class="card-footer">
                                          <span><i class="mdi mdi-sofa"></i> Beds : <strong>2</strong></span>
                                          <span><i class="mdi mdi-scale-bathroom"></i> Baths : <strong>1</strong></span>
                                          <span><i class="mdi mdi-move-resize-variant"></i> Area : <strong>100 sq ft</strong></span>
                                       </div>
                                    </a>
                                 </div>
                              </div>
                              <div class="carousel-item">
                                 <div class="card card-list">
                                    <a href="#">
                                       <div class="card-img">
                                          <div class="badge images-badge"><i class="mdi mdi-image-filter"></i> 03</div>
                                          <span class="badge badge-success">For Sale</span>
                                          <img class="card-img-top" src="img/list/3.png" alt="Card image cap">
                                       </div>
                                       <div class="card-body">
                                          <h2 class="text-primary mb-2 mt-0">
                                             $55,000 <small>/month</small>
                                          </h2>
                                          <h5 class="card-title mb-2">Loft Above The City</h5>
                                          <h6 class="card-subtitle mt-1 mb-0 text-muted"><i class="mdi mdi-home-map-marker"></i> Hope Street (Stop P), London SW11, UK</h6>
                                       </div>
                                       <div class="card-footer">
                                          <span><i class="mdi mdi-sofa"></i> Beds : <strong>2</strong></span>
                                          <span><i class="mdi mdi-scale-bathroom"></i> Baths : <strong>1</strong></span>
                                          <span><i class="mdi mdi-move-resize-variant"></i> Area : <strong>100 sq ft</strong></span>
                                       </div>
                                    </a>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="card sidebar-card property-single-slider">
                     <div class="card-body">
                        <h5 class="card-title mb-4">Mortage Calculator</h5>
                        <form name="sentMessage">
                           <div class="control-group form-group">
                              <div class="controls">
                                 <label>Sale Price <span class="text-danger">*</span></label>
                                 <input type="text" placeholder="$" class="form-control" required>
                              </div>
                           </div>
                           <div class="control-group form-group">
                              <div class="controls">
                                 <label>Down payment <span class="text-danger">*</span></label>
                                 <input type="text" placeholder="$"  class="form-control" required>
                              </div>
                           </div>
                           <div class="control-group form-group">
                              <div class="controls">
                                 <label>Term <span class="text-danger">*</span></label>
                                 <input type="text" placeholder="Years"  class="form-control" required>
                              </div>
                           </div>
                           <div class="control-group form-group">
                              <div class="controls">
                                 <label>Interest Rate <span class="text-danger">*</span></label>
                                 <input type="text" placeholder="%" class="form-control" required>
                              </div>
                           </div>
                           <button type="submit" class="btn btn-secondary btn-lg btn-block">CALCULATE</button>
                        </form>
                     </div>
                  </div>-->
               </div>
            </div>
         </div>
      </section>
      <!-- End Property Single Slider -->	 
      <!-- Similar Properties -->
<?php
$rel_query=db_query("select * from tbl_category where category_parent_id='$parent_id' and category_id!=$_REQUEST[id] and category_status='Active' order by category_id desc limit 6 ");
if(mysqli_num_rows($rel_query)>0)
{
?>
      <section class="section-padding  border-top">
         <div class="container">
            <div class="row">
               <div class="col-lg-12 col-md-12 section-title text-left mb-4">
                  <h2>Similar Properties</h2>
               </div>
               
<?php
while($rel_res=mysqli_fetch_array($rel_query))
{
?>
               <div class="col-lg-4 col-md-4">
                  <div class="card card-list">
                     <a href="<?=$site_url?>/property-details.html?id=<?=$rel_res['category_id']?>">
                        <div class="card-img">
                         <!-- <div class="badge images-badge"><i class="mdi mdi-image-filter"></i> 12</div>
                           <span class="badge badge-primary">For Sale</span>-->
                           <img class="card-img-top" style="width:800px; height:258px;" src="<?=$site_url?>/uploaded_files/<?=$rel_res['category_image_name']?>" alt="<?=$rel_res['category_name']?>" title="<?=$rel_res['category_name']?>">
                        </div>
                        <div class="card-body">
                           <h2 class="text-primary mb-2 mt-0">
                            <i class="fa fa-inr"></i> <?=$rel_res['category_amount']?> <small>/ <?=$rel_res['category_amount_type']?></small>
                           </h2>
                           <h5 class="card-title mb-2"><?=$rel_res['category_name']?></h5>
                           <h6 class="card-subtitle mt-1 mb-0 text-muted"><i class="mdi mdi-home-map-marker"></i> <?php
                                 $area=substr($rel_res['category_areas_name'],0,27);
                                 echo $area;
                                 if(strlen($rel_res['category_areas_name'])>27)
                                 {echo "...";}
                               ?></h6>
                        </div>
                       <!-- <div class="card-footer">
                           <span><i class="mdi mdi-sofa"></i> Beds : <strong>3</strong></span>
                           <span><i class="mdi mdi-scale-bathroom"></i> Baths : <strong>2</strong></span>
                           <span><i class="mdi mdi-move-resize-variant"></i> Area : <strong>587 sq ft</strong></span>
                        </div>-->
                     </a>
                  </div>
               </div>
               <?}?>
               
              
             
            </div>
         </div>
      </section>
      <?}?>
      <!-- End Similar Properties -->
      
      
      
<script>

  function trimfield(str) 
        { 
            return str.replace(/^\s+|\s+$/g,''); 
        }
    function checkValidationContact(){
      
        var name=document.getElementById("contact_name");
         var email=document.getElementById("contact_email");
        var phone=document.getElementById("contact_phone");
    //    var subject=document.getElementById("contact_subject");
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

/*        if(subject.value==""){
            $('#contact_subject').css({"border-color":"red"});
            subject.focus();
            $('.error_subject_contact').fadeIn('slow');
             $(".error_subject_contact").html("Please enter your subject !");
            return false;
        }*/
        
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
    
/*   function errSubjectContact(){
        $('#contact_subject').css({"border-color":"#49aecc"});
        $('.error_subject_contact').css({"display":"none"});
    }*/
    
   
    
      function errMessageContact(){
        $('#contact_message').css({"border-color":"#49aecc"});
        $('.error_message_contact').css({"display":"none"});
    }
</script>
   <?php include("site-footer.php"); ?>