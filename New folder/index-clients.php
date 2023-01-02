 <?php
$client_query=db_query("select * from  tbl_clients where image_status='Active' order by image_add_date desc ");
$count=mysqli_num_rows($client_query);
$count_no=ceil($count/4);
if($count>0)
{
 ?>



  <section class="section-padding">

         <div class="section-title text-center mb-5">
            <h2>Our Awesome Clients </h2>
            <div class="line mb-2"></div>
            <p>16+ Years of Transparent Business Management.
</p>
         </div>
         <div class="container">
            <div class="row">
              <!--Carousel Wrapper-->
<div id="multi-item-example2" class="carousel slide carousel-multi-item" data-ride="carousel">

  <!--Controls-->
  <div class="controls-top">
     <?php if($count>4){?>
    <a class="btn-floating" href="#multi-item-example2" data-slide="prev"><i class="fa fa-chevron-left"></i></a>
    <a class="btn-floating" href="#multi-item-example2" data-slide="next"><i class="fa fa-chevron-right"></i></a>
    <?}?>
  </div>
  <!--/.Controls-->

  <!--Indicators-->
  <ol class="carousel-indicators">
    <?php 
    for($j=0; $j<$count_no; $j++)
{ ?>
    <li data-target="#multi-item-example2" data-slide-to="<?=$j?>" <?php if($j==0){?>class="active"<?}?> ></li>
    <?}?>
  
    
  </ol>
  <!--/.Indicators-->

  <!--Slides-->
  <div class="carousel-inner" role="listbox">

    <!--First slide-->
<?php 
$q_inc=0;
for($i=1; $i<=$count_no; $i++)
{

 ?>

    <div class="carousel-item <?php if($i==1){?>active<?}?>">

<?php
$client_query1=db_query("select * from  tbl_clients where image_status='Active' order by image_add_date desc limit $q_inc,4");
while($client_res=mysqli_fetch_array($client_query1))
{
?>
      <div class="col-md-3" style="float:left">
       <div class="card mb-2">
          <img class="card-img-top" src="<?=$site_url?>/our_client/<?=$client_res['image_name']?>" alt="" style="width:260px; height:260px;">
     
        </div>
      </div>
<?}?>


    </div>
<?php 
$q_inc=$q_inc+4;
}?>
    <!--/.First slide-->

   

   

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