  <!-- Footer -->
      <section class="section-padding footer">
         <div class="container">
            <div class="row">
               <div class="col-lg-3 col-md-3">
                  <h4 class="mb-5 mt-0"><a class="logo" href="index.html"><img src="img/logo.png" alt="Absolute Reality"></a></h4>
 <?php if($compDATA['admin_address']!=""){?>
              <p><i class="fa fa-map-marker" aria-hidden="true"></i>
              <?=$compDATA['admin_address']?>, <?=$compDATA['admin_city']?>, <?=$compDATA['admin_state']?>, <?=$compDATA['admin_country']?> - <?=$compDATA['admin_zip_code']?>
              </p>
              <?}?>
<?php if($compDATA['admin_mobile']!="" || $compDATA['admin_phone']!=""){?>
<p class="mb-0"><i class="fa fa-mobile" aria-hidden="true"></i> 
<a class="text-warning" href="tel:<?=$compDATA['admin_mobile']?>"><?=$compDATA['admin_mobile']?></a>
<?php if($compDATA['admin_phone']!=""){?>
/ <a class="text-warning" href="tel:<?=$compDATA['admin_phone']?>"><?=$compDATA['admin_phone']?></a>
<?}?>
</p>
<?}?>

<?php if($compDATA['admin_email']!="" || $compDATA['admin_alt_email']!=""){?>
<p class="mb-0">
<i class="fa fa-envelope-o" aria-hidden="true"></i>  
<a class="text-success" href="mailto:<?=$compDATA['admin_email']?>"><?=$compDATA['admin_email']?></a>
<?php if($compDATA['admin_alt_email']!=""){?>
/ <a class="text-success" href="mailto:<?=$compDATA['admin_alt_email']?>"><?=$compDATA['admin_alt_email']?></a>
<?}?>
</p>
<?}?>           


                  <div class="footer-social" style="padding-top:7px;">
                       <?php if($compDATA['admin_facebook_link']!=""){?>
                     <a class="btn-facebook" href="<?=$compDATA['admin_facebook_link']?>" target="_blank"><i class="mdi mdi-facebook"></i></a>
                     <?}?>
                     <?php if($compDATA['admin_twitter_link']!=""){?>
                     <a class="btn-twitter" href="<?=$compDATA['admin_twitter_link']?>" target="_blank"><i class="mdi mdi-twitter"></i></a>
                     <?}?>
                     <?php if($compDATA['admin_linkedin_link']!=""){?>
                     <a class="btn-messenger" href="<?=$compDATA['admin_linkedin_link']?>" target="_blank"><i class="mdi mdi-linkedin"></i></a>
                     <?}?>
                     <?php if($compDATA['admin_instagram_link']!=""){?>
                     <a class="btn-instagram" href="<?=$compDATA['admin_instagram_link']?>" target="_blank"><i class="mdi mdi-instagram"></i></a>
                     <?}?>
                      <?php if($compDATA['admin_pinterest_link']!=""){?>
                     <a class="btn-pinterest" href="<?=$compDATA['admin_pinterest_link']?>" target="_blank"><i class="mdi mdi-pinterest"></i></a>
                     <?}?>
                     <?php if($compDATA['admin_youtube_link']!=""){?>
                     <a class="btn-youtube" href="<?=$compDATA['admin_youtube_link']?>" target="_blank" style="color:red;"><i class="fa fa-youtube"></i></a>
                     <?}?>
                  </div>
                  

               </div>
               
               
            <!--   <div class="col-lg-2 col-md-2">
                  <h6 class="mb-4">OUR PROPERTIES</h6>
                  <ul>
                  <li><a href="#"><i class="mdi mdi-arrow-right"></i> Single Story</a></li>
                  <li><a href="#"><i class="mdi mdi-arrow-right"></i> Dubble Story</a></li>
                  <li><a href="#"><i class="mdi mdi-arrow-right"></i> Tripple Story</a></li>
                  <li><a href="#"><i class="mdi mdi-arrow-right"></i> Resort</a></li>
                  <li><a href="#"><i class="mdi mdi-arrow-right"></i> Home in Merrick Way</a></li>
                  </ul>
               </div>-->
                                                                     <?php
$link_sql_footer=db_query("select * from tbl_site_pages where 1 and site_pages_status='Active' and site_pages_show_in_footer='Yes' order by site_pages_order_by asc ");
if(mysqli_num_rows($link_sql_footer)>0){
    ?>
               <div class="col-lg-3 col-md-3">
                  <h6 class="mb-4">QUICK LINKS</h6>
                  <ul>
<?php
while($link_data_footer=mysqli_fetch_array($link_sql_footer)){
?>
<li><a href="<?=$site_url?>/<?=$link_data_footer['site_pages_link']?>.html"><i class="mdi mdi-arrow-right"></i> <?=$link_data_footer['site_pages_name']?></a></li>
<?}?>
 
                  </ul>
<?php
if($compDATA['admin_visitor_counter_option']=='Yes'){ ?>
<div style="margin-left:7px; margin-bottom:15px;"><img src="https://counter9.01counter.com/private/freecounterstat.php?c=c22f8d1bcf70483344afcf49f2b176d1" border="0" title="web page counter" alt="web page counter"></div>
<?}?>

                                               <?php
if($compDATA['admin_language_option']=='Yes'){ ?>
            <div style="margin-left:15px; margin-bottom:15px;margin-top:15px;" id="google_translate_element"></div>
            <script type="text/javascript">
function googleTranslateElementInit() {
  new google.translate.TranslateElement({pageLanguage: 'en', layout: google.translate.TranslateElement.InlineLayout.SIMPLE}, 'google_translate_element');
}
</script><script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script> 
<? } ?>
               </div>
               <?}?>
               
               <?php
                $ser_count=mysqli_num_rows(db_query("select * from tbl_category where 1 and category_status='Active' and category_is_product='Yes' "));
               $pro_sql_footer=db_query("select * from tbl_category where 1 and category_status='Active' and category_is_product='Yes' order by category_id desc limit 5");
 
               if(mysqli_num_rows($pro_sql_footer)>0)
               {
               ?>
               <div class="col-lg-3 col-md-3">
                  <h6 class="mb-4">Properties</h6>
                  <ul>
<?php
while($pro_res_footer=mysqli_fetch_array($pro_sql_footer))
{
?>
                  <li><a href="<?=$site_url?>/property-details.html?id=<?=$pro_res_footer['category_id']?>"><i class="mdi mdi-arrow-right"></i> <?=$pro_res_footer['category_name']?></a></li>
                  <?}?>
                  
<?php
if($ser_count>5)
{?>
 <li><a href="<?=$site_url?>/property.html" style="color:yellow;"><i class="mdi mdi-arrow-right"></i> View More</a></li>
<?}?>
                  </ul>
               </div>
               <?}?>
               
               
                      <?php
               $city_count=mysqli_num_rows(db_query("select * from tbl_city where 1 and city_status='Active'"));
               $city_sql_footer=db_query("select * from tbl_city where 1 and city_status='Active' order by city_order_by asc limit 5");
 
               if(mysqli_num_rows($city_sql_footer)>0)
               {
               ?>
               <div class="col-lg-3 col-md-3">
                  <h6 class="mb-4">Properties By Location</h6>
                  <ul>
<?php
while($city_res_footer=mysqli_fetch_array($city_sql_footer))
{
?>
                  <li><a href="<?=$site_url?>/office-by-location.html?location=<?=$city_res_footer['city_name']?>"><i class="mdi mdi-arrow-right"></i> <?=$city_res_footer['city_name']?></a></li>
                  <?}?>
                  
<?php
if($city_count>5)
{?>
 <li><a href="<?=$site_url?>/office-by-location.html?location=Delhi" style="color:yellow;"><i class="mdi mdi-arrow-right"></i> View More</a></li>
<?}?>
                  </ul>
               </div>
               <?}?>
               
               
             <!--  <div class="col-lg-3 col-md-3">
<?php $description=strip_tags(db_scalar("select site_pages_description from tbl_site_pages where site_pages_link='about-us'"));
if($description!=""){
?>
                  <h6 class="mb-4">ABOUT US</h6> 
                  <p class="text-info newsletter-info"><?=substr($description,0,200);?>..<a href="<?=$site_url?>/about-us.html" style="color:yellow;">Read More</a></p>
<?}?>
                  <h6 class="mb-3 mt-4">GET IN TOUCH</h6>
                  <div class="footer-social">
                       <?php if($compDATA['admin_facebook_link']!=""){?>
                     <a class="btn-facebook" href="<?=$compDATA['admin_facebook_link']?>" target="_blank"><i class="mdi mdi-facebook"></i></a>
                     <?}?>
                     <?php if($compDATA['admin_twitter_link']!=""){?>
                     <a class="btn-twitter" href="<?=$compDATA['admin_twitter_link']?>" target="_blank"><i class="mdi mdi-twitter"></i></a>
                     <?}?>
                     <?php if($compDATA['admin_linkedin_link']!=""){?>
                     <a class="btn-messenger" href="<?=$compDATA['admin_linkedin_link']?>" target="_blank"><i class="mdi mdi-linkedin"></i></a>
                     <?}?>
                     <?php if($compDATA['admin_instagram_link']!=""){?>
                     <a class="btn-instagram" href="<?=$compDATA['admin_instagram_link']?>" target="_blank"><i class="mdi mdi-instagram"></i></a>
                     <?}?>
                      <?php if($compDATA['admin_pinterest_link']!=""){?>
                     <a class="btn-pinterest" href="<?=$compDATA['admin_pinterest_link']?>" target="_blank"><i class="mdi mdi-pinterest"></i></a>
                     <?}?>
                     <?php if($compDATA['admin_youtube_link']!=""){?>
                     <a class="btn-youtube" href="<?=$compDATA['admin_youtube_link']?>" target="_blank" style="color:red;"><i class="fa fa-youtube"></i></a>
                     <?}?>
                  </div>

                       



               </div>-->
            </div>
         </div>
      </section>
      <!-- End Footer -->
      <!-- Copyright -->
      <div class="pt-4 pb-4 text-center footer-bottom">
         <p class="mt-0 mb-0"><?php if(!empty($compDATA['admin_copyright'])){ ?>© Copyright <?=$compDATA['admin_copyright'];?><? } ?> <?php if(!empty($compDATA['admin_all_right_reserved'])){ ?><strong> <?=$compDATA['admin_all_right_reserved'];?></strong>. All Rights Reserved<? } ?></p>
         <small class="mt-0 mb-0">
         Made with <i class="mdi mdi-heart text-danger"></i> by <a class="text-warning" href="<?=$compDATA['admin_keyword_link']?>" target="_blank"><?=$compDATA['admin_member_of']?> - <?=$compDATA['admin_keyword']?></a>
         </small>
      </div>
      <!-- End Copyright -->
      <!-- Bootstrap core JavaScript -->
      <script src="<?=$site_url?>/vendor/jquery/jquery.min.js"></script>
      <script src="<?=$site_url?>/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
      <!-- Contact form JavaScript -->
      <!-- Do not edit these files! In order to set the email address and subject line for the contact form go to the bin/contact_me.php file. -->
      <script src="<?=$site_url?>/js/jqBootstrapValidation.js"></script>
      <script src="<?=$site_url?>/js/contact_me.js"></script>
      <!-- select2 Js -->
      <script src="<?=$site_url?>/vendor/select2/js/select2.min.js"></script>
      <!-- Custom -->
      <script src="<?=$site_url?>/js/custom.js"></script>
	  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-120909275-1"></script>
	  <script>
		  window.dataLayer = window.dataLayer || [];
		  function gtag(){dataLayer.push(arguments);}
		  gtag('js', new Date());

		  gtag('config', 'UA-120909275-1');
	  </script>
   </body>

</html>

