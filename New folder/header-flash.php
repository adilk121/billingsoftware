  
  <?php
$flash_sql=db_query("select * from tbl_header_flash where 1 and header_flash_status='Active' order by header_flash_id");
if(mysqli_num_rows($flash_sql)>0)
{?>

    <style>
    <?php
    $i=0;
while($flash_res=mysqli_fetch_array($flash_sql))
{$i++;
?>
      .slider-<?=$i?>{
   background-image: url('<?=$site_url?>/flash_images/<?=$flash_res['header_flash_image_name']?>') !important;
}
<?}?>
    </style>
<!--  background-image: url('img/slider/4.jpg') !important; -->

      <!-- Main Slider With Form -->
      <section class="samar-slider slider-h-auto">
         <div id="samarslider" class="carousel slide" data-ride="carousel">
             <ol class="carousel-indicators">
                   <?php
$flash_sql1=db_query("select * from tbl_header_flash where 1 and header_flash_status='Active' order by header_flash_id");

    $j=0;
while(mysqli_fetch_array($flash_sql1))
{
?>
               <li data-target="#samarslider" data-slide-to="<?=$j?>" <?php if($j==0){?> class="active"<?}?> ></li>
<?php
$j++;
}?>
            
            </ol> 
            <div class="carousel-inner" role="listbox">
               
  <?php
$flash_sql2=db_query("select * from tbl_header_flash where 1 and header_flash_status='Active' order by header_flash_id");

    $k=0;
    $z=0;
while($flash_res2=mysqli_fetch_array($flash_sql2))
{$k++;
?>
               <div class="carousel-item <?php if($k==1){?> active<?}?> slider-<?=$k?>">
                  <div class="overlay"></div>
                  <div class="section-padding">
                     <div class="container banner-list pl-5 pr-5">
                        <div class="row">
                           <div class="col-lg-8 col-md-8">
                              <h1 class="mt-5 mb-4 text-white"><?=$flash_res2['header_flash_title']?></h1>
                              <h6 class="mb-5 text-white"><?=$flash_res2['header_flash_description']?></h6>
                              <a class="btn btn-secondary btn-lg" href="<?=$site_url?>/enquiry.html" style="color:white;">Contact Us/Enquiry</a>
                              <a class="btn btn-outline-warning btn-lg" href="<?=$site_url?>/about-us.html" style="color:white;">About Us</a>
                           </div>
                           
<?php
$cat_slider_query=db_query("select * from tbl_category where category_status='Active' and category_set_slider='Yes' limit $z,1");
if(mysqli_num_rows($cat_slider_query)>0)
{
    while($cat_slider_res=mysqli_fetch_array($cat_slider_query))
{?>
                           <div class="col-lg-4 col-md-4">
                              <div class="card card-list mb-0 box-shadow-none">
                                 <a href="<?=$site_url?>/property-details.html?id=<?=$cat_slider_res['category_id']?>">
                                   <!-- <span class="badge badge-success">For Lease</span>-->
                                    <img class="card-img-top" style="width:700px; height:200px;" src="<?=$site_url?>/uploaded_files/<?=$cat_slider_res['category_image_name']?>" alt="<?=$cat_slider_res['category_name']?>" title="<?=$cat_slider_res['category_name']?>">
                                    <div class="card-body">
                                       <h3 class="card-title"><?=$cat_slider_res['category_name']?></h3>
                                       <h4 class="card-subtitle mb-2 text-muted"><i class="mdi mdi-home-map-marker"></i> <?php
                                 $area=substr($cat_slider_res['category_areas_name'],0,27);
                                 echo $area;
                                 if(strlen($cat_slider_res['category_areas_name'])>27)
                                 {echo "...";}
                               ?></h4>
                                       <h5 class="text-primary mb-0 mt-3">
                                         <i class="fa fa-inr"></i> <?=$cat_slider_res['category_amount']?> <small>/ <?=$cat_slider_res['category_amount_type']?></small>
                                       </h5>
                                    </div>
                                 </a>
                              </div>
                           </div>
<?}?>
<?}?>
                           
                        </div>
                     </div>
                  </div>
               </div>

<?php

$z++;
}?>
               


            </div>
            <a class="carousel-control-prev" href="#samarslider" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#samarslider" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
            </a>
         </div>
      </section>
      <!-- End Main Slider With Form -->

      <?}?>