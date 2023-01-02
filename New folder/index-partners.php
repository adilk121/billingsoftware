      <?php
$partner_query=db_query("select * from  tbl_partners where partner_status='Active' order by partner_add_date desc ");
$count1=mysqli_num_rows($partner_query);
$count_no1=ceil($count1/4);
if($count1>0)
{
 ?>

      <section class="section-padding">
         <div class="section-title text-center mb-5">
            <h2>Our Projects</h2>
            <div class="line mb-2"></div>
            <p>16+ Years of Transparent Business Management.
</p>
         </div>
         <div class="container">
            <div class="row">
              <!--Carousel Wrapper-->
<div id="multi-item-example" class="carousel slide carousel-multi-item" data-ride="carousel">

  <!--Controls-->
  <div class="controls-top">
    <?php if($count1>4){?>
    <a class="btn-floating" href="#multi-item-example" data-slide="prev"><i class="fa fa-chevron-left"></i></a>
    <a class="btn-floating" href="#multi-item-example" data-slide="next"><i
        class="fa fa-chevron-right"></i></a>
        <?}?>
  </div>
  <!--/.Controls-->

  <!--Indicators-->
  <ol class="carousel-indicators">
        <?php 
    for($j1=0; $j1<$count_no1; $j1++)
{ ?>
    <li data-target="#multi-item-example" data-slide-to="<?=$j1?>" <?php if($j1==0){?>class="active"<?}?> ></li>
    <?}?>
  
    
  </ol>
  <!--/.Indicators-->

  <!--Slides-->
  <div class="carousel-inner" role="listbox">

    <!--First slide-->
    <?php 
$q_inc1=0;
for($i=1; $i<=$count_no1; $i++)
{

 ?>
    <div class="carousel-item <?php if($i==1){?>active<?}?>">
<?php
$partner_query1=db_query("select * from  tbl_partners where partner_status='Active' order by partner_add_date desc limit $q_inc1,4");
while($partner_res=mysqli_fetch_array($partner_query1))
{
?>
      <div class="col-md-3" style="float:left">
       <div class="card mb-2">
          <img class="card-img-top"
            src="<?=$site_url?>/partners_images/<?=$partner_res['partner_image_name']?>" alt="<?=$partner_res['partner_name']?>" title="<?=$partner_res['partner_name']?>">
          <div class="card-body">
            <h4 class="card-title"><?=$partner_res['partner_name']?></h4>
            <p class="card-text"><?=$partner_res['partner_address']?></p>
           <!-- <a class="btn btn-primary">Read More</a>-->
          </div>
        </div>
      </div>
<?}?>


      


    </div>
    <!--/.First slide-->

    <?php 
$q_inc1=$q_inc1+4;
}?>

   

   

  </div>
  <!--/.Slides-->

</div>
<!--/.Carousel Wrapper-->

            </div>
            
           <!-- <div class="row mt-4">
               <div class="col-md-12 text-center">
                  <button class="btn btn-secondary font-weight-bold btn-lg" type="submit">VIEW ALL</button>
               </div>
            </div>-->
         </div>
      </section>
      <?}?>