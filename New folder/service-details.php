<?php include("site-header.php"); ?>

<?php 
$ser_qu=db_query("select * from tbl_service where service_status='Active' and service_id='$_REQUEST[ser_id]'");
$ser_result=mysqli_fetch_array($ser_qu);
?>
      <!-- End Navbar -->
      <!-- Inner Header -->
      <section class="section-padding bg-dark inner-header">
         <div class="container">
            <div class="row">
               <div class="col-md-12 text-center">
                  <h1 class="mt-0 mb-3"><?=$ser_result['service_name']?></h1>
                  <div class="breadcrumbs">
                     <p class="mb-0"><a href="<?=$site_url?>"><i class="mdi mdi-home-outline"></i> Home</a> / <?=$ser_result['service_name']?></p>
                  </div>
               </div>
            </div>
         </div>
      </section>
      <!-- End Inner Header -->
      <!-- Properties List -->
      <section class="section-padding">
         <div class="container">
            <div class="row">
                
                
            
           
             
             
               <div class="col-lg-9 col-md-9">
                  <div class="card blog-card padding-card blog-single-page">
                     <img class="img-thumbnail" src="<?=$site_url?>/service_images/<?=$ser_result['service_image_name']?>" alt="<?=$ser_result['service_name']?>" title="<?=$ser_result['service_name']?>">
                     <div class="card-body blog-single-page">
                        <!--<span class="badge badge-success">House/Villa</span>-->
                        <h2><?=$ser_result['service_name']?></h2>
                    
                       <?=$ser_result['service_description']?>
                </div>
                  </div>
                    </div>
              
              
               <div class="col-lg-3 col-md-3">
                  <?php
                            $our_ser_query=db_query("select * from tbl_service where  service_status='Active' order by service_order_by asc");
                          if(mysqli_num_rows($our_ser_query)>0)
                          {
                            ?>
                  <div class="card inner-side-bar">
                     <div class="card-body">
                        <h5 class="card-title mb-3">Our Services</h5>
                        <ul class="sidebar-card-list">
                          <?php
                          while($our_ser_res=mysqli_fetch_array($our_ser_query))
                          {
                          ?>
                           <li><a href="<?=$site_url?>/service-details.html?ser_id=<?=$our_ser_res[service_id]?>">
                               <i class="mdi mdi-chevron-right"></i> <?=$our_ser_res['service_name']?> </a></li>
                           <?}?>
                          
                        </ul>
                     </div>
                  </div>
                  <?}?>
             
               </div>
         
            </div>
         </div>
      </section>
      <!-- End Properties List -->
     
      <!-- Footer -->
     <?php include("site-footer.php"); ?>