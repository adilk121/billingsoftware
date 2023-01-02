       <?php
       $i=0;
$city_query1=db_query("select * from tbl_city where 1 and city_status='Active' and city_is_best='Yes' limit 4");
if(mysqli_num_rows($city_query1)>0)
{
?>
      <!-- Properties by City -->
      <section class="section-padding bg-grey">
         <div class="section-title text-center mb-5">
            <h2>Best Commercial Offices In Delhi NCR</h2>
            <div class="line mb-2"></div>
            <p>We are Now Having Approx 99.9% Properties of all Sectors.</p>
         </div>
         <div class="container">
            <div class="row">
                <?php
               // $city_query1=db_query("select * from tbl_city where 1 and city_status='Active' and city_is_best='Yes' limit 0,1");
while($city_res1=mysqli_fetch_array($city_query1))
{       $i++;          ?>
<div  <?php if($i==1 || $i==4){?>class="col-lg-8 col-md-8"<?}else{?>class="col-lg-4 col-md-4"<?}?>  >
<div class="card bg-dark text-white card-overlay">
<a href="<?=$site_url?>/office-by-location.html?location=<?=$city_res1['city_name']?>">
<img class="card-img" src="<?=$site_url?>/city_images/<?=$city_res1['city_image_name']?>" alt="<?=$city_res1['city_name']?>" title="<?=$city_res1['city_name']?>">
<div class="card-img-overlay">
<h3 class="card-title text-white">Offices In <?=$city_res1['city_name']?></h3>
<p class="card-text text-white"><?=db_scalar("select count(category_id) from tbl_category where category_status='Active' and category_city='$city_res1[city_name]' ");?> Properties</p>
</div>
</a>
</div>
</div>
<?}?>
               
                
            </div>
       
         </div>
      </section>
      <!-- End Properties by City -->
      <?}?>
      