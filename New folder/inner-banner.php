      <!-- Inner Header -->
      <section class="section-padding bg-dark inner-header">
         <div class="container">
            <div class="row">
               <div class="col-md-12 text-center">
                  <h1 class="mt-0 mb-3">
                      <?php
                       if($_REQUEST['id']!="")
                       {
                        echo db_scalar("select category_name from tbl_category where category_id='$_REQUEST[id]'");
                       }else if($_REQUEST['location']!=""){
                        echo db_scalar("select city_name from tbl_city where city_name='$_REQUEST[location]'");
                       }else{
                       echo db_scalar("select site_pages_name from tbl_site_pages where site_pages_link='$page_name'");
                       }
                       ?>
                      </h1>
                  <div class="breadcrumbs">
                     <p class="mb-0">
                         <a href="<?=$site_url?>">
                             <i class="mdi mdi-home-outline"></i>
                             Home</a> / 
                            <?php
                       if($_REQUEST['id']!="")
                       {
                        echo db_scalar("select category_name from tbl_category where category_id='$_REQUEST[id]'");
                       }else if($_REQUEST['location']!=""){
                        echo db_scalar("select city_name from tbl_city where city_name='$_REQUEST[location]'");
                       }else{
                       echo db_scalar("select site_pages_name from tbl_site_pages where site_pages_link='$page_name'");
                       }
                       ?>
                             </p>
                  </div>
               </div>
            </div>
         </div>
      </section>
      <!-- End Inner Header -->