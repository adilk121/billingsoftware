        <?php
$hot_sql=db_query("select * from tbl_category where 1 and category_status='Active' and category_is_product='Yes' and category_is_residential_properties='Yes' limit 6");
if(mysqli_num_rows($hot_sql)>0)
{
?>
     
      <section class="section-padding">
         <div class="section-title text-center mb-5">
            <h2>Residential Properties</h2>
            <div class="line mb-2"></div>
            <p>More Than 15,000 Updated Properties Available in Noida, Greater Noida & Yamuna ExpresswayWe are Now Having Approx 99.9% Properties of all Sectors.
</p>
         </div>
         <div class="container">
            <div class="row">
                             <?php
while($hot_res=mysqli_fetch_array($hot_sql))
{
             ?>
             
               <div class="col-lg-4 col-md-4">
                  <div class="card card-list">
                     <a href="<?=$site_url?>/property-details.html?id=<?=$hot_res['category_id']?>">
                        <div class="card-img">
                          <!-- <div class="badge images-badge"><i class="mdi mdi-image-filter"></i> 12</div>
                           <span class="badge badge-primary">For Rent</span>-->
                           <img class="card-img-top" style="width:800px; height:220px;" src="<?=$site_url?>/uploaded_files/<?=$hot_res['category_image_name']?>" alt="<?=$hot_res['category_name']?>" title="<?=$hot_res['category_name']?>">
                        </div>
                        <div class="card-body">
                           <h2 class="text-primary mb-2 mt-0">
                              <i class="fa fa-inr"></i> <?=$hot_res['category_amount']?> <small>/ <?=$hot_res['category_amount_type']?></small>
                           </h2>
                           <h5 class="card-title mb-2"><?=$hot_res['category_name']?></h5>
                           <h6 class="card-subtitle mt-1 mb-0 text-muted"><i class="mdi mdi-home-map-marker"></i>  <?php
                                 $area=substr($hot_res['category_areas_name'],0,27);
                                 echo $area;
                                 if(strlen($hot_res['category_areas_name'])>27)
                                 {echo "...";}
                               ?></h6>
                        </div>
						<!--
                        <div class="card-footer">
                           <span><i class="mdi mdi-sofa"></i> Beds : <strong>3</strong></span>
                           <span><i class="mdi mdi-scale-bathroom"></i> Baths : <strong>2</strong></span>
                           <span><i class="mdi mdi-move-resize-variant"></i> Area : <strong>587 sq ft</strong></span>
                        </div>-->
                     </a>
                  </div>
               </div>
               <?}?>
            
               
            </div>
          <?/*
            <div class="row">
               <div class="col-lg-4 col-md-4">
                  <div class="card card-list">
                     <a href="#">
                        <div class="card-img">
                           <div class="badge images-badge"><i class="mdi mdi-image-filter"></i> 18</div>
                           <span class="badge badge-danger">Commercial Office</span>
                           <img class="card-img-top" src="img/list-new/7.png" alt="Card image cap">
                        </div>
                        <div class="card-body">
                           <h2 class="text-primary mb-2 mt-0">
                              <i class="fa fa-inr"></i> 25,000 <small>/month</small>
                           </h2>
                           <h5 class="card-title mb-2">BUSINESS PARK</h5>
                           <h6 class="card-subtitle mt-1 mb-0 text-muted"><i class="mdi mdi-home-map-marker"></i>Sector-125,126,127,132,140,140A,
142,136,150</h6>
                        </div>
						<!--
                        <div class="card-footer">
                           <span><i class="mdi mdi-sofa"></i> Beds : <strong>6</strong></span>
                           <span><i class="mdi mdi-scale-bathroom"></i> Baths : <strong>4</strong></span>
                           <span><i class="mdi mdi-move-resize-variant"></i> Area : <strong>987 sq ft</strong></span>
                        </div>-->
                     </a>
                  </div>
               </div>
               <div class="col-lg-4 col-md-4">
                  <div class="card card-list">
                     <a href="#">
                        <div class="card-img">
                           <div class="badge images-badge"><i class="mdi mdi-image-filter"></i> 04</div>
                           <span class="badge badge-warning">Luxury Office</span>
                           <img class="card-img-top" src="img/list-new/8.png" alt="Card image cap">
                        </div>
                        <div class="card-body">
                           <h2 class="text-primary mb-2 mt-0">
                              <i class="fa fa-inr"></i> 12,000 <small>/month</small>
                           </h2>
                           <h5 class="card-title mb-2">PHASE-1, NOIDA
</h5>
                           <h6 class="card-subtitle mt-1 mb-0 text-muted"><i class="mdi mdi-home-map-marker"></i> Sector-1, 2, 3, 4, 5, 6,
7, 8, 9, 10, 11 & 16 Noida</h6>
                        </div>
						<!--
                        <div class="card-footer">
                           <span><i class="mdi mdi-sofa"></i> Beds : <strong>8</strong></span>
                           <span><i class="mdi mdi-scale-bathroom"></i> Baths : <strong>4</strong></span>
                           <span><i class="mdi mdi-move-resize-variant"></i> Area : <strong>120 sq ft</strong></span>
                        </div>-->
                     </a>
                  </div>
               </div>
               <div class="col-lg-4 col-md-4">
                  <div class="card card-list">
                     <a href="#">
                        <div class="card-img">
                           <div class="badge images-badge"><i class="mdi mdi-image-filter"></i> 45</div>
                           <span class="badge badge-info">Private Cabin</span>
                           <img class="card-img-top" src="img/list-new/7.png" alt="Card image cap">
                        </div>
                        <div class="card-body">
                           <h2 class="text-primary mb-2 mt-0">
                              <i class="fa fa-inr"></i> 356, 000 <small>/month</small>
                           </h2>
                           <h5 class="card-title mb-2">PHASE-2, NOIDA</h5>
                           <h6 class="card-subtitle mt-1 mb-0 text-muted"><i class="mdi mdi-home-map-marker"></i>Sector-80, 81, Phase-2, NEPZ Noida</h6>
                        </div>
						<!--
                        <div class="card-footer">
                           <span><i class="mdi mdi-sofa"></i> Beds : <strong>1</strong></span>
                           <span><i class="mdi mdi-scale-bathroom"></i> Baths : <strong>3</strong></span>
                           <span><i class="mdi mdi-move-resize-variant"></i> Area : <strong>187 sq ft</strong></span>
                        </div>-->
                     </a>
                  </div>
               </div>
            </div>
            */?>
            <div class="row mt-4">
               <div class="col-md-12 text-center">
                  <a class="btn btn-secondary font-weight-bold btn-lg" href="<?=$site_url?>/property.html">VIEW ALL</a>
               </div>
            </div>
         </div>
      </section>
      
      
      <?}?>
      <!-- End Properties List -->