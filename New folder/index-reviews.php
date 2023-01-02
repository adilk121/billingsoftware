 <?php
$test_query=db_query("select * from  tbl_testimonial where test_status='Active' order by test_order_by asc ");
if(mysqli_num_rows($test_query)>0)
{ ?>

 <!-- Trusted Agents -->
      <section class="section-padding">
         <div class="section-title text-center mb-5">
            <h2>Customers Reviews About Absolute Reality</h2>
            <div class="line mb-2"></div>
            <p>100% Customer Satisfaction.</p>
         </div>
         <div class="container">
            <div class="row">

<?php
while($test_res=mysqli_fetch_array($test_query))
{
?>

               <div class="col-lg-4 col-md-4">
                  <div class="agents-card text-center">
                     <img class="img-fluid mb-4" src="<?=$site_url?>/test_images/<?=$test_res['test_image_name']?>" alt="<?=$test_res['test_given_by']?>" title="<?=$test_res['test_given_by']?>">
                     <p class="mb-4"><?=$test_res['test_description']?></p>
                     <h6 class="mb-0 text-primary">- <?=$test_res['test_given_by']?> -
                      <span class="star-rating">
                        <i class="mdi mdi-star text-warning"></i>
                        <i class="mdi mdi-star text-warning"></i>
                        <i class="mdi mdi-star text-warning"></i>
                        <i class="mdi mdi-star text-warning"></i>
                        <i class="mdi mdi-star-half text-warning"></i>
                        </span>
                     </h6>
                     <!--<small>Buying Agent</small>-->
                  </div>
               </div>


             <?}?>
               
               
               
             


            </div>
         </div>
      </section>
      <!-- End Trusted Agents -->
      <?}?>