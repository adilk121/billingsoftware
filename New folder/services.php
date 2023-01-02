<?php include("site-header.php"); ?>
      <!-- Inner Header -->
<?php include("inner-banner.php"); ?>
      <!-- End Inner Header -->
<?php
$ser_query=db_query("select * from tbl_service where service_status='Active' order by service_order_by asc");
if(mysqli_num_rows($ser_query)>0)
{
?>
      <section class="section-padding">
         <div class="container">
            <div class="row">
               <div class="col-lg-12 col-md-12">
                  <div class="row">
                      
<?php
while($ser_res=mysqli_fetch_array($ser_query))
{?>         
                      
<div class="col-lg-4 col-md-4">
<div class="card blog-card">
<a href="<?=$site_url?>/service-details.html?ser_id=<?=$ser_res['service_id']?>">
<img class="card-img-top" style="width:600px; height:235px;" src="<?=$site_url?>/service_images/<?=$ser_res['service_image_name']?>" alt="<?=$ser_res['service_name']?>" title="<?=$ser_res['service_name']?>">
<div class="card-body">
<h6 class="badge-success" style="color:black; font-weight:bold;"><?=$ser_res['service_name']?></h6>
<p class="mb-0">

   <?=substr(strip_tags($ser_res['service_description']),0,110)?>...

  
    </p>
</div>
<!--<div class="card-footer">
<p class="mb-0"><img class="rounded-circle" src="img/user/3.jpg" alt="Card image cap"> <strong>Rahul Yadav</strong> On October 03, 2018</p>
</div>-->
</a>
</div>
</div>
<?}?>
                     
                     
               
                
                  </div>
          
                 
               </div>
            </div>
         </div>
      </section>
      
      <?}else{?>
       <div class="col-md-12">
   <h2  style="color:red; text-align: center; padding-bottom:50px;">
    Service Not Available!

  </h2>
  </div>
      <?}?>
      <!-- End Blog List -->
     
      <!-- Footer -->
     <?php include("site-footer.php"); ?>