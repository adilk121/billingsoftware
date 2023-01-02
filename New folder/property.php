<?php include("site-header.php"); ?>
<?php include("inner-banner.php"); ?>
        <?php
$city_con="";
if(isset($_REQUEST['city_check']))
{
$cities = $_REQUEST['city_check'];
$Arr_size=sizeof($cities);
if($_REQUEST['id']!="")
{
for($i=0; $i<$Arr_size; $i++)
{if($i==0)
{
   $city_con.=" and (category_city='$cities[$i]'";   
}else{
    $city_con.=" or category_city='$cities[$i]'";  
}
  
}
}
if($Arr_size>0)
{$city_con.=")";}

}


        if($_REQUEST['id']!="")
        {
           $cat_id=$_REQUEST['id']; 
           $ord_by="";
          
        }else{
            $cat_id=0;
            $ord_by="order by category_order_by asc";
        }
$start = intval($start);
//$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;
$pagesize=12;
$sql = "select * from  tbl_category where 1 and category_status='Active' and category_parent_id='$cat_id' $city_con  $ord_by";
$sql .= " limit $start, $pagesize ";
//echo $sql;
$pager = new midas_pager_sql($sql, $pagesize, $start);
if($pager->total_records) {
  $result = db_query($sql);
}
?>


    
      <!-- Properties List -->
      <section class="section-padding">
         <div class="container">
            <div class="row">
<?php
$des="";
if($cat_id!=0)
{
    $des=db_scalar("select category_description from tbl_category where category_id='$cat_id'"); 
}else{
 $des=db_scalar("select site_pages_description from tbl_site_pages where site_pages_link='property'");
}
if($des!=""){ ?>
<div class="col-lg-12 col-md-12 pl-5 pr-5">
<?=$des?>
<hr></div>
<?}?>



<style>
    .checkbox-city{
        border-style:solid; 
        border-width:1px;
        padding:3px;
        font-weight:bold;
        border-radius:7px;
    }
</style>

<?php if($cat_id!=0){?>
<div class="col-lg-12 col-md-12">
    <form action="" method="post" >
<?php
$city_count=mysqli_num_rows(db_query("select * from tbl_city where 1 and city_status='Active' order by city_order_by asc"));
 
 $city_sql=db_query("select * from tbl_city where 1 and city_status='Active' order by city_order_by asc");
 while($city_res=mysqli_fetch_array($city_sql))
{//onclick="if(this.checked){this.form.submit()}"
?>
<span class="checkbox-city">
    <input type="checkbox" name="city_check[]" id="city_check[]" onclick="this.form.submit()" <?php if($_REQUEST['city_check']!=""){foreach($_REQUEST['city_check'] as $city) { if($city==$city_res['city_name']){?>checked <?} } }?> value="<?=$city_res['city_name']?>"/> 
    <?=$city_res['city_name']?>
    </span>&nbsp;&nbsp;
<?}?>
<!--<input type="submit" value="Find" class="btn btn-secondary" name="SUBMIT" id="SUBMIT" />-->
<?php
if($_REQUEST['city_check']!="")
{?>
<a href="<?=$site_url?>/property.html?id=<?=$cat_id?>" class="btn btn-secondary">Clear</a>
<?}?>
</form>
    </div>
 
<hr>
<?}?>

<?php if($cat_id!=0){?>
            <div class="col-lg-3 col-md-3">
                  <?php
                            $our_ser_query=db_query("select * from tbl_category where category_parent_id='0' and category_status='Active' order by category_order_by asc");
                          if(mysqli_num_rows($our_ser_query)>0)
                          {
                            ?>
                  <div class="card inner-side-bar">
                     <div class="card-body">
                        <h5 class="card-title mb-3">Our Properties</h5>
                        <ul class="sidebar-card-list">
                          <?php
                          while($our_ser_res=mysqli_fetch_array($our_ser_query))
                          {
                          ?>
                           <li><a href="<?=$site_url?>/property.html?id=<?=$our_ser_res[category_id]?>">
                               <i class="mdi mdi-chevron-right"></i> <?=$our_ser_res['category_name']?> </a></li>
                           <?}?>
                          
                        </ul>
                     </div>
                  </div>
                  <?}?>
                <!--  <div class="card inner-side-bar">
                     <div class="card-body property-features-add">
                        <h5 class="card-title mb-3">Property Features</h5>
                        <div class="custom-control custom-checkbox">
                           <input type="checkbox" class="custom-control-input" id="samar-checkbox" checked>
                           <label class="custom-control-label" for="samar-checkbox">Center Cooling</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                           <input type="checkbox" class="custom-control-input" id="samar-checkbox1">
                           <label class="custom-control-label" for="samar-checkbox1">Fire Alarm</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                           <input type="checkbox" class="custom-control-input" id="samar-checkbox2" checked>
                           <label class="custom-control-label" for="samar-checkbox2">Heating</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                           <input type="checkbox" class="custom-control-input" id="samar-checkbox3">
                           <label class="custom-control-label" for="samar-checkbox3">Gym</label>
                        </div>
                     </div>
                  </div>
                  <div class="card inner-side-bar">
                     <div class="card-body">    
                        <h5 class="card-title mb-3">Property Status</h5>
                        <ul class="sidebar-card-list">
                           <li><a href="#"><i class="mdi mdi-chevron-right"></i> For Rent <span class="sidebar-badge">600</span></a></li>
                           <li><a href="#"><i class="mdi mdi-chevron-right"></i> For Sale <span class="sidebar-badge">1200</span></a></li>
                        </ul>
                     </div>
                  </div>
                  <div class="card inner-side-bar">
                     <div class="card-body">
                        <h5 class="card-title mb-3">Property By City</h5>
                        <ul class="sidebar-card-list">
                           <li><a href="#"><i class="mdi mdi-chevron-right"></i> New York <span class="sidebar-badge">220</span></a></li>
                           <li><a href="#"><i class="mdi mdi-chevron-right"></i> Los Angeles <span class="sidebar-badge">150</span></a></li>
                           <li><a href="#"><i class="mdi mdi-chevron-right"></i> Chicago <span class="sidebar-badge">100</span></a></li>
                           <li><a href="#"><i class="mdi mdi-chevron-right"></i> Houston <span class="sidebar-badge">50</span></a></li>
                           <li><a href="#"><i class="mdi mdi-chevron-right"></i> Philadelphia <span class="sidebar-badge">23</span></a></li>
                        </ul>
                     </div>
                  </div>-->
                
                <!--  <div class="card inner-side-bar">
                     <div class="card-body">
                        <h5 class="card-title mb-4">Featured Properties</h5>
                        <div id="featured-properties" class="carousel slide" data-ride="carousel">
                           <ol class="carousel-indicators">
                              <li data-target="#featured-properties" data-slide-to="0" class="active"></li>
                              <li data-target="#featured-properties" data-slide-to="1"></li>
                              <li data-target="#featured-properties" data-slide-to="2"></li>
                              
                           </ol>
                           <div class="carousel-inner">
                               
                              <div class="carousel-item active">
                                 <div class="card card-list">
                                    <a href="#">
                                       <img class="card-img-top" src="img/list/1.png" alt="Card image cap">
                                       <div class="card-body">
                                          <h5 class="card-title no-border">House in Kent Street</h5>
                                          <h6 class="card-subtitle mb-2 text-muted"><i class="mdi mdi-home-map-marker"></i> 127 Kent Sreet, Sydny</h6>
                                          <h4 class="text-primary mb-0 mt-3">
                                             $130,000 <small>/month</small>
                                          </h4>
                                       </div>
                                    </a>
                                 </div>
                              </div>
                              
                              <div class="carousel-item">
                                 <div class="card card-list">
                                    <a href="#">
                                       <img class="card-img-top" src="img/list/2.png" alt="Card image cap">
                                       <div class="card-body">
                                          <h5 class="card-title no-border">Family House in Hudson</h5>
                                          <h6 class="card-subtitle mb-2 text-muted"><i class="mdi mdi-home-map-marker"></i> Hoboken, NJ, USA</h6>
                                          <h4 class="text-primary mb-0 mt-3">
                                             $127,000 <small>/month</small>
                                          </h4>
                                       </div>
                                    </a>
                                 </div>
                              </div>
                              
                              
                              <div class="carousel-item">
                                 <div class="card card-list">
                                    <a href="#">
                                       <img class="card-img-top" src="img/list/2.png" alt="Card image cap">
                                       <div class="card-body">
                                          <h5 class="card-title no-border">Family House in Hudson</h5>
                                          <h6 class="card-subtitle mb-2 text-muted"><i class="mdi mdi-home-map-marker"></i> Hoboken, NJ, USA</h6>
                                          <h4 class="text-primary mb-0 mt-3">
                                             $127,000 <small>/month</small>
                                          </h4>
                                       </div>
                                    </a>
                                 </div>
                              </div>
                              
                           </div>
                        </div>
                     </div>
                  </div>-->
               </div>
             <?}?>
            
               <div class="<?php if($cat_id!=0){?>col-lg-9 col-md-9<?}else{?>col-lg-12 col-md-12<?}?>">



                  <div class="samar_top_filter row">
                     <div class="col-lg-6 col-md-6 tags-action">
<span>
<? if($pager->total_records!=0) {?>
<? $pager->show_displaying()?>
<?//=pagesize_dropdown('pagesize', $pagesize);?>
<?php
}
?>
</span>
                     </div>
                   <!--  <div class="col-lg-6 col-md-6 sort-by-btn float-right">
                        <div class="view-mode float-right">
                           <a class="active" href="properties-grid.html"><i class="mdi mdi-grid"></i></a><a href="properties-list.html"><i class="mdi mdi-format-list-bulleted"></i></a>
                        </div>
                        <div class="dropdown float-right">
                           <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                           <i class="mdi mdi-filter"></i> Sort by 
                           </button>
                           <div class="dropdown-menu float-right" aria-labelledby="dropdownMenuButton">
                              <a class="dropdown-item" href="#"><i class="mdi mdi-chevron-right"></i> Popularity </a>
                              <a class="dropdown-item" href="#"><i class="mdi mdi-chevron-right"></i> New </a>
                              <a class="dropdown-item" href="#"><i class="mdi mdi-chevron-right"></i> Discount </a>
                              <a class="dropdown-item" href="#"><i class="mdi mdi-chevron-right"></i> Price: Low to High </a>
                              <a class="dropdown-item" href="#"><i class="mdi mdi-chevron-right"></i> Price: High to Low </a>
                           </div>
                        </div>
                     </div>-->
                  </div>
                  
 <?php if($pager->total_records>0) {?>   
                  <div class="row">
                      

<?php
//$pro_sql=db_query("select * from tbl_category where 1 and category_status='Active' and category_is_product='Yes' ");
while($pro_res=mysqli_fetch_array($result))
{

?>
                      
                     <div class="col-lg-4 col-md-4">
                        <div class="card card-list">
                            
                               <?php
                              if($cat_id!=0)
                              {?>
                           <a href="<?=$site_url?>/property-details.html?id=<?=$pro_res['category_id']?>">
                               <?}else{?>
                                 <a href="<?=$site_url?>/property.html?id=<?=$pro_res['category_id']?>">
                               <?}?>
                              <div class="card-img">
                               <!--  <div class="badge images-badge"><i class="mdi mdi-image-filter"></i> 12</div>
                                 <span class="badge badge-primary">For Sale</span>-->
                                 <img class="card-img-top" style="width:800px; <?php if($cat_id!=0){?>height:200px;<?}else{?>height:240px;<?}?>" src="<?=$site_url?>/uploaded_files/<?=$pro_res['category_image_name']?>" alt="<?=$pro_res['category_name']?>" title="<?=$pro_res['category_name']?>">
                              </div>
                            
                              <div class="card-body">
                                 <h2 class="text-primary mb-2 mt-0">
                                   <?=$pro_res['category_name']?>
                                 </h2>
                                   <?php
                              if($cat_id!=0)
                              {?>
                                <h5 class="card-title mb-2"><i class="fa fa-inr"></i> <?=$pro_res['category_amount']?> / <?=$pro_res['category_amount_type']?></h5>
                                 <h6 class="card-subtitle mt-1 mb-0 text-muted"><i class="mdi mdi-home-map-marker"></i>
                                 <?php
                                 $area=substr($pro_res['category_areas_name'],0,27);
                                 echo $area;
                                 if(strlen($pro_res['category_areas_name'])>27)
                                 {echo "...";}
                               ?></h6>
                              <?}?>
                              </div>
                             
                              
                           <!--    <div class="card-footer">
                                 <span><i class="mdi mdi-sofa"></i> Beds : <strong>3</strong></span>
                                 <span><i class="mdi mdi-scale-bathroom"></i> Baths : <strong>2</strong></span>
                              </div>-->
                           </a>
                        </div>
                     </div>

<?}?>
         </div>         
                  
               
                  
     <!--             <nav class="mt-5">
                     <ul class="pagination justify-content-center">
                        <li class="page-item disabled">
                           <a class="page-link" href="#" tabindex="-1"><i class="mdi mdi-chevron-left"></i></a>
                        </li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#">...</a></li>
                        <li class="page-item"><a class="page-link" href="#">10</a></li>
                        <li class="page-item">
                           <a class="page-link" href="#"><i class="mdi mdi-chevron-right"></i></a>
                        </li>
                     </ul>
                  </nav>-->
                  
                  
               </div>
               
            <?php $pager->show_pager();?>
<?php }else{?>
  <div class="col-md-12">
   <h2  style="color:red; text-align: center; padding-bottom:50px;">
    Property Not Available!

  </h2>
  </div>
<?php }?>
            </div>

            
            
            
            
         </div>
      </section>
      <!-- End Properties List -->
      <!-- Footer -->
       <?php include("site-footer.php"); ?>