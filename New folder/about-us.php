<?php include("site-header.php"); ?>
<?php include("inner-banner.php"); ?>
      <!-- About -->
      <section class="section-padding bg-white">
         <div class="container">
            <div class="row">
               <div class="pl-4 col-lg-5 col-md-5 pr-4">
                  <img class="rounded img-fluid" src="<?=$site_url?>/static_files/<?=db_scalar("select site_pages_image_name from tbl_site_pages where site_pages_link='about-us'");?>" alt="<?=db_scalar("select site_pages_name from tbl_site_pages where site_pages_link='$page_name'");?>" title="<?=db_scalar("select site_pages_name from tbl_site_pages where site_pages_link='$page_name'");?>">
               </div>
               <div class="col-lg-6 col-md-6 pl-5 pr-5">
                  <?=db_scalar("select site_pages_description from tbl_site_pages where site_pages_link='about-us'");?>

                  
               </div>
            </div>
         </div>
      </section>
      <!-- End About -->
   <?php include("site-footer.php"); ?>