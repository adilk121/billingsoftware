<?php require_once("header.php");?>
         <!-- =============================================== -->
         <!-- Left side column. contains the sidebar -->
<?php require_once("left-nav.php");?>
         <!-- =============================================== -->
         <!-- Content Wrapper. Contains page content -->
         <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
               <div class="header-icon">
                  <i class="fa fa-dashboard"></i>
               </div>
               <div class="header-title">
                  <h1>Admin Dashboard</h1>
                  <small>Very detailed & featured admin.</small>
               </div>
            </section>
            <!-- Main content -->
            <section class="content">
               <div class="row">
               
               <div class="col-lg-12 text-center" id="login-title" style="margin:0 0 20px 0"><h2>Welcome to <span style="font-weight:600;text-shadow:1px 1px 2px red"><?=$compDATA['admin_company_name']?></span> Administrator Panel</h2></div>
               
               
               
              <!--     <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
                     <a href="manage-registration.php"><div id="cardbox1">
                        <div class="statistic-box">
                           <i class="fa fa-user-plus fa-3x"></i>
                           <div class="counter-number pull-right">
                              <span class="count-number"><?=db_scalar("SELECT COUNT(reg_id) FROM tbl_registration WHERE reg_status='Active'")?></span> 
                              <span class="slight"><i class="fa fa-play fa-rotate-270"> </i>
                              </span>
                           </div>
                           <h3> Active Client</h3>
                        </div>
                     </div></a>
                  </div>
                  <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
                     <a href="manage-order.php">
                     <div id="cardbox2">
                        <div class="statistic-box">
                           <i class="fa fa-money fa-3x"></i>
                           <div class="counter-number pull-right">
                              <span class="count-number"><?=db_scalar("SELECT COUNT(ord_id) FROM  tbl_order where ord_is_deleted='No' ")?></span> 
                              <span class="slight"><i class="fa fa-play fa-rotate-270"> </i>
                              </span>
                           </div>
                           <h3>  Active Order</h3>
                        </div>
                     </div>
                     </a>
                  </div>
                  <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
                  <a href="product_list.php">
                     <div id="cardbox3">
                        <div class="statistic-box">
                           <i class="fa fa-shopping-basket fa-3x"></i>
                           <div class="counter-number pull-right">
                              <span class="count-number"><?=db_scalar("SELECT COUNT(category_id) FROM  tbl_category where category_is_product='Yes' ")?></span> 
                              <span class="slight"><i class="fa fa-play fa-rotate-270"> </i>
                              </span>
                           </div>
                           <h3>  Total Products</h3>
                        </div>
                     </div>
                     </a>
                  </div> -->
                  
               </div>
               
               
               
               <!-- /.row -->
<!--              <div class="row">
               
               
                  
                  
                  <div class="col-xs-12 col-sm-12">
                     <div class="panel panel-bd lobidrag" data-edit-title='false' data-close='false' data-reload='false'>
                        <div class="panel-heading">
                           <div class="panel-title">
                              <h4>Google Map</h4>
                           </div>
                        </div>
                        <div class="panel-body" >
                           <div class="google-maps">
                               <?=$compDATA['admin_contactus_map_link']?>
                           </div>
                        </div>
                     </div>
                  </div>
                  
               </div>  -->
            </section>
            <!-- /.content -->
         </div>
<?php require_once("footer.php"); ?>