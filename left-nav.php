<!--<link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css" />-->

<?php
$website_url=db_scalar("select admin_website_url from tbl_admin where admin_status='Active' and admin_user_type='Admin'");
?>
<aside class="main-sidebar">
            <!-- sidebar -->
            <div class="sidebar">
               <!-- sidebar menu -->
               <ul class="sidebar-menu">
                  
            

<?php
if(check_access("$_SESSION[ADMIN_ACCESS]","1")=='true' || $_SESSION['sess_admin_type']=='Admin'){
?>
<li class="">
<a href="manage-billing-company.php"> 
<i class="fa fa-building-o" aria-hidden="true"></i>
<span>Manage Billing Master</span>
<span class="pull-right-container">
<i class="fa fa-angle-left pull-right"></i>
</span>
</a>                     
</li>  
<?}?>


<?php
if(check_access("$_SESSION[ADMIN_ACCESS]","2")=='true' || $_SESSION['sess_admin_type']=='Admin'){
?>
<li class="">
<a href="manage-invoice-product.php"> 
<i class="fa fa-tag" aria-hidden="true"></i>
<span>Manage Products/Services</span>
<span class="pull-right-container">
<i class="fa fa-angle-left pull-right"></i>
</span>
</a>                     
</li>  
<?}?>


<?php
if(check_access("$_SESSION[ADMIN_ACCESS]","3")=='true' || $_SESSION['sess_admin_type']=='Admin'){
?>
<li class="">
<a href="manage-clients.php"> 
<i class="fa fa-users" aria-hidden="true"></i>
<span>Manage Client Master</span>
<span class="pull-right-container">
<i class="fa fa-angle-left pull-right"></i>
</span>
</a>                     
</li>  
<?}?> 

<?php
if(check_access("$_SESSION[ADMIN_ACCESS]","4")=='true' || $_SESSION['sess_admin_type']=='Admin'){
?>
<li class="">
<a href="manage-orders-invoices.php"> 
<i class="fa fa-cart-plus" aria-hidden="true"></i>
<span>Manage Order Master</span>
<span class="pull-right-container">
<i class="fa fa-angle-left pull-right"></i>
</span>
</a>                     
</li>  
<?}?>


<?php
if(check_access("$_SESSION[ADMIN_ACCESS]","5")=='true' || $_SESSION['sess_admin_type']=='Admin'){
?>
<li class="">
<a href="manage-invoice.php"> 
<i class="fa fa-files-o" aria-hidden="true"></i>
<span>Manage Invoices</span>
<span class="pull-right-container">
<i class="fa fa-angle-left pull-right"></i>
</span>
</a>                     
</li>  
<?}?>





<?php
if(check_access("$_SESSION[ADMIN_ACCESS]","6")=='true' || $_SESSION['sess_admin_type']=='Admin'){
?>
<li class="">
<a href="contact_update.php">
<i class="fa fa-gears" aria-hidden="true"></i> <span>General Setting</span>
<span class="pull-right-container">
<i class="fa fa-angle-left pull-right"></i>
</span>
</a>                     
</li>  
<?}?>

<?php
if(check_access("$_SESSION[ADMIN_ACCESS]","7")=='true' || $_SESSION['sess_admin_type']=='Admin'){
?>
<li class="">
<a href="manage-user.php">
<i class="fa fa-user" aria-hidden="true"></i> <span>Manage Sub Admin</span>
<span class="pull-right-container">
<i class="fa fa-angle-left pull-right"></i>
</span>
</a>                     
</li>  
<?}?>

<?php
if(check_access("$_SESSION[ADMIN_ACCESS]","8")=='true' || $_SESSION['sess_admin_type']=='Admin'){
?>
<li class="">
<a href="manual-transaction-record.php">
<i class="fa fa-exchange" aria-hidden="true"></i> <span>Manual Transaction Record</span>
<span class="pull-right-container">
<i class="fa fa-angle-left pull-right"></i>
</span>
</a>                     
</li>  
<?}?>


 <li class="">
                     <a href="change-password.php">
                     <i class="fa fa-key" aria-hidden="true"></i> <span>Change Password</span>
                     <span class="pull-right-container">
                     <i class="fa fa-angle-left pull-right"></i>
                     </span>
                     </a>                     
                  </li>    

<li class="">
<a href="logout.php">
<i class="fa fa-sign-out" aria-hidden="true"></i> <span>Logout</span>
<span class="pull-right-container">
<i class="fa fa-angle-left pull-right"></i>
</span>
</a>                     
</li>  




                  
<?/*

 <li class="">
<a href="<?=$website_url?>" target="_blank"><i class="fa fa-globe"></i><span>Visit Website

</span>
<span class="pull-right-container">
</span>
</a>
</li>                 
      
      
      
    <?php if($_SESSION['sess_admin_type']=="Admin"){ ?>
       <li class="">
                    <!--  <a href="category_list.php"> -->
               <!-- <a href="product_list.php"> -->
                         
                       <a href="manage_setting.php"> 
                     <i class="fa fa-list" aria-hidden="true"></i>
<span>SEO & Site Features</span>
                     <span class="pull-right-container">
                     <i class="fa fa-angle-left pull-right"></i>
                     </span>
                     </a>                     
                  </li>  
                  <?}?>
                  
                                   
 <li class="">
                    <!--  <a href="category_list.php"> -->
               <!-- <a href="product_list.php"> -->
                         
                       <a href="subcat_list.php"> 
                     <i class="fa fa-list" aria-hidden="true"></i>
<span>Manage Property Category</span>
                     <span class="pull-right-container">
                     <i class="fa fa-angle-left pull-right"></i>
                     </span>
                     </a>                     
                  </li>  
                  
                  
             <li class="">
 <a href="city_list.php"> 
                     <i class="fa fa-building-o" aria-hidden="true"></i>
<span>Manage City</span>
                     <span class="pull-right-container">
                     <i class="fa fa-angle-left pull-right"></i>
                     </span>
                     </a>                     
                  </li>    
                  
                  
<li class="">
<a href="manage-services.php"> 
<i class="fa fa-list" aria-hidden="true"></i>
<span>Manage Services</span>
<span class="pull-right-container">
<i class="fa fa-angle-left pull-right"></i>
</span>
</a>                     
</li>     
                   
                  
                  
                             
                  
                  
   <!--                
<li class="">
<a href="manage-registration.php">
<i class="fa fa-user-circle-o" aria-hidden="true"></i>
<span>Manage Users</span>
<span class="pull-right-container">
<i class="fa fa-angle-left pull-right"></i>
</span>
</a>                     
</li>      


<li class="treeview">
                     <a href="#">
                     <i class="fa fa-cart-plus"></i><span>Manage Orders</span>
                     <span class="pull-right-container">
                     <i class="fa fa-angle-left pull-right"></i>
                     </span>
                     </a>
                     <ul class="treeview-menu">
                        <li><a href="manage-order.php">View Orders</a></li>
                        <li><a href="order-history.php?paySt=Paid">Orders History</a></li>

                     </ul>
                  </li> -->
                  
                  
                                              
                 
                 
                  <li class="">
                     <a href="static_page_list.php">
                     <i class="fa fa-file-text-o" aria-hidden="true"></i>
<span>Manage Page Contents</span>
                     <span class="pull-right-container">
                     <i class="fa fa-angle-left pull-right"></i>
                     </span>
                     </a>                     
                  </li>
                  
                  

                  <li class="">
                     <a href="enquiry-list.php">
                     <i class="fa fa-envelope" aria-hidden="true"></i>
<span>Manage Enquiry</span>
                     <span class="pull-right-container">
                     <i class="fa fa-angle-left pull-right"></i>
                     </span>
                     </a>                     
                  </li>
<!--                          <li class="">
                     <a href="manage-rating.php">
                     <i class="fa fa-star" aria-hidden="true"></i>
<span>Manage Rating</span>
                     <span class="pull-right-container">
                     <i class="fa fa-angle-left pull-right"></i>
                     </span>
                     </a>                     
                  </li> -->
                                    
                 <li class="">
                     <a href="manage-logo.php">
                     <i class="fa fa-picture-o" aria-hidden="true"></i> <span>Manage Logo</span>
                     <span class="pull-right-container">
                     <i class="fa fa-angle-left pull-right"></i>
                     </span>
                     </a>                     
                  </li>     

               <!--      <li class="">
                     <a href="manage-test-gallery.php">
                     <i class="fa fa-picture-o" aria-hidden="true"></i> <span>Manage GALLERY</span>
                     <span class="pull-right-container">
                     <i class="fa fa-angle-left pull-right"></i>
                     </span>
                     </a>                     
                  </li>  -->
                  
                  
                  
                  <li class="">
                     <a href="manage-header-flash.php">
                     <i class="fa fa-picture-o" aria-hidden="true"></i> <span>Manage Header Flash</span>
                     <span class="pull-right-container">
                     <i class="fa fa-angle-left pull-right"></i>
                     </span>
                     </a>                     
                  </li>  

                        <li class="">
                     <a href="manage-our-client.php">
                     <i class="fa fa-picture-o" aria-hidden="true"></i> <span>Manage Clients</span>
                     <span class="pull-right-container">
                     <i class="fa fa-angle-left pull-right"></i>
                     </span>
                     </a>                     
                  </li>  


           <!--         <li class="">
                     <a href="manage-left-banner.php">
                     <i class="fa fa-picture-o" aria-hidden="true"></i> <span>Manage Left Banner</span>
                     <span class="pull-right-container">
                     <i class="fa fa-angle-left pull-right"></i>
                     </span>
                     </a>                     
                  </li>  --> 
                  
                  
<!--  <li class="">
                     <a href="manage-slider.php">
                     <i class="fa fa-picture-o" aria-hidden="true"></i> <span>Manage Left Slider</span>
                     <span class="pull-right-container">
                     <i class="fa fa-angle-left pull-right"></i>
                     </span>
                     </a>                     
                  </li>    -->                 
                  
                  
                  
                  
               
                  
                  <li class="">
                     <a href="testimonial-list.php">
                     <i class="fa fa-comments" aria-hidden="true"></i> <span>Manage Testimonials</span>
                     <span class="pull-right-container">
                     <i class="fa fa-angle-left pull-right"></i>
                     </span>
                     </a>                     
                  </li>   
                  
                  


                  


<li class="">
<a href="manage-partners.php">
<i class="fa fa-handshake-o" aria-hidden="true"></i> <span>Manage Our Projects</span>
<span class="pull-right-container">
<i class="fa fa-angle-left pull-right"></i>
</span>
</a>                     
</li>    
    <li class="">
                     <a href="manage_social_links.php">
                     <i class="fa fa-share-alt" aria-hidden="true"></i> <span>Manage Social Links</span>
                     <span class="pull-right-container">
                     <i class="fa fa-angle-left pull-right"></i>
                     </span>
                     </a>                     
                  </li>                  
                  
 
   <!-- 

                  
                  


 <li class="">
                     <a href="image-list.php">
                     <i class="fa fa-file-image-o" aria-hidden="true"></i> <span>Manage Gallery</span>
                     <span class="pull-right-container">
                     <i class="fa fa-angle-left pull-right"></i>
                     </span>
                     </a>                     
                  </li>    
                  
-->

 <!-- 
                 <li class="">
                     <a href="faq-list.php">
                     <i class="fa fa-question-circle"></i> <span>Manage FAQ</span>
                     <span class="pull-right-container">
                     <i class="fa fa-angle-left pull-right"></i>
                     </span>
                     </a>                     
                  </li>   -->                
                                    
                  <li class="">
                     <a href="contact_update.php">
                     <i class="fa fa-gears" aria-hidden="true"></i> <span>General Setting</span>
                     <span class="pull-right-container">
                     <i class="fa fa-angle-left pull-right"></i>
                     </span>
                     </a>                     
                  </li>  
                  
 <?php if($_SESSION['sess_admin_type']=="Admin"){ ?>
                 <li class="">
                     <a href="manage-footer.php">
                     <i class="fa fa-gears" aria-hidden="true"></i> <span>Manage Footer</span>
                     <span class="pull-right-container">
                     <i class="fa fa-angle-left pull-right"></i>
                     </span>
                     </a>                     
                  </li> 
                  <?}?>

              
                  
                                
                                    
              
                  
                  
                  
                  
<li class="">
                     <a href="logout.php">
                     <i class="fa fa-sign-out" aria-hidden="true"></i>

<span>Logout</span>
                     <span class="pull-right-container">
                     <i class="fa fa-angle-left pull-right"></i>
                     </span>
                     </a>                     
                  </li>                  
                  */?>
                  
                <!--  
                  <li class="treeview">
                     <a href="#">
                     <i class="fa fa-shopping-basket"></i><span>Transaction</span>
                     <span class="pull-right-container">
                     <i class="fa fa-angle-left pull-right"></i>
                     </span>
                     </a>
                     <ul class="treeview-menu">
                        <li><a href="deposit.html">New Deposit</a></li>
                        <li><a href="expense.html">New Expense</a></li>
                        <li><a href="transfer.html">Transfer</a></li>
                        <li><a href="view-tsaction.html">View transaction</a></li>
                        <li><a href="balance.html">Balance Sheet</a></li>
                        <li><a href="treport.html">Transfer Report</a></li>
                     </ul>
                  </li>
                  <li class="treeview">
                     <a href="#">
                     <i class="fa fa-shopping-cart"></i><span>Sales</span>
                     <span class="pull-right-container">
                     <i class="fa fa-angle-left pull-right"></i>
                     </span>
                     </a>
                     <ul class="treeview-menu">
                        <li><a href="invoice.html">Invoices</a></li>
                        <li><a href="ninvoices.html">New Invoices</a></li>
                        <li><a href="recurring.html">Recurring invoices</a></li>
                        <li><a href="nrecurring.html">New Recurring invoices</a></li>
                        <li><a href="quote.html">quotes</a></li>
                        <li><a href="nquote.html">New quote</a></li>
                        <li><a href="payment.html">Payments</a></li>
                        <li><a href="taxeport.html">Tax Rates</a></li>
                     </ul>
                  </li>
                  <li class="treeview">
                     <a href="#">
                     <i class="fa fa-book"></i><span>Task</span>
                     <span class="pull-right-container">
                     <i class="fa fa-angle-left pull-right"></i>
                     </span>
                     </a>
                     <ul class="treeview-menu">
                        <li><a href="rtask.html">Running Task</a></li>
                        <li><a href="atask.html">Archive Task</a></li>
                     </ul>
                  </li>
                  <li class="treeview">
                     <a href="#">
                     <i class="fa fa-shopping-bag"></i><span>Accounting</span>
                     <span class="pull-right-container">
                     <i class="fa fa-angle-left pull-right"></i>
                     </span>
                     </a>
                     <ul class="treeview-menu">
                        <li><a href="cpayment.html">Client payment</a></li>
                        <li><a href="emanage.html">Expense management</a></li>
                        <li><a href="ecategory.html">Expense Category</a></li>
                     </ul>
                  </li>
                  <li class="treeview">
                     <a href="#">
                     <i class="fa fa-file-text"></i><span>Report</span>
                     <span class="pull-right-container">
                     <i class="fa fa-angle-left pull-right"></i>
                     </span>
                     </a>
                     <ul class="treeview-menu">
                        <li><a href="preport.html">Project Report</a></li>
                        <li><a href="creport.html">Client Report</a></li>
                        <li><a href="ereport.html">Expense Report</a></li>
                        <li><a href="incomexp.html">Income expense comparesion</a></li>
                     </ul>
                  </li>
                  <li class="treeview">
                     <a href="#">
                     <i class="fa fa-bell"></i><span>Attendance</span>
                     <span class="pull-right-container">
                     <i class="fa fa-angle-left pull-right"></i>
                     </span>
                     </a>
                     <ul class="treeview-menu">
                        <li><a href="thistory.html">Time History</a></li>
                        <li><a href="timechange.html">Time Change Request</a></li>
                        <li><a href="atreport.html">Attendance Report</a></li>
                     </ul>
                  </li>
                  <li class="treeview">
                     <a href="#">
                     <i class="fa fa-edit"></i><span>Recruitment</span>
                     <span class="pull-right-container">
                     <i class="fa fa-angle-left pull-right"></i>
                     </span>
                     </a>
                     <ul class="treeview-menu">
                        <li><a href="jpost.html">Jobs Posted</a></li>
                        <li><a href="japp.html">Jobs Application</a></li>
                     </ul>
                  </li>
                  <li class="treeview">
                     <a href="#">
                     <i class="fa fa-shopping-basket"></i><span>payroll</span>
                     <span class="pull-right-container">
                     <i class="fa fa-angle-left pull-right"></i>
                     </span>
                     </a>
                     <ul class="treeview-menu">
                        <li><a href="salary.html">Salary Template</a></li>
                        <li><a href="hourly.html">Hourly</a></li>
                        <li><a href="managesal.html">Manage salary</a></li>
                        <li><a href="empsallist.html">Employee salary list</a></li>
                        <li><a href="mpayment.html">Make payment</a></li>
                        <li><a href="generatepay.html">Generate payslip</a></li>
                        <li><a href="paysum.html">Payroll summary</a></li>
                     </ul>
                  </li>
                  <li class="treeview">
                     <a href="#">
                     <i class="fa fa-bitbucket-square"></i><span>Stock</span>
                     <span class="pull-right-container">
                     <i class="fa fa-angle-left pull-right"></i>
                     </span>
                     </a>
                     <ul class="treeview-menu">
                        <li><a href="stockcat.html">Stock category</a></li>
                        <li><a href="manstock.html">Manage Stock</a></li>
                        <li><a href="astock.html">Assign stock</a></li>
                     </ul>
                  </li>
                  <li class="treeview">
                     <a href="#">
                     <i class="fa fa-ticket"></i><span>Tickets</span>
                     <span class="pull-right-container">
                     <i class="fa fa-angle-left pull-right"></i>
                     </span>
                     </a>
                     <ul class="treeview-menu">
                        <li><a href="ticanswer.html">Answered</a></li>
                        <li><a href="ticopen.html">Open</a></li>
                        <li><a href="iprocess.html">Inprocess</a></li>
                        <li><a href="close.html">CLosed</a></li>
                        <li><a href="allticket.html">All Tickets</a></li>
                     </ul>
                  </li>
                  <li class="treeview">
                     <a href="#">
                     <i class="fa fa-list"></i>
                     <span>Utilities</span>
                     <span class="pull-right-container">
                     <i class="fa fa-angle-left pull-right"></i>
                     </span>
                     </a>
                     <ul class="treeview-menu">
                        <li><a href="ativitylog.html">Activity Log</a></li>
                        <li><a href="emailmes.html">Email message log</a></li>
                        <li><a href="systemsts.html">System status</a></li>
                     </ul>
                  </li>
                  <li class="treeview">
                     <a href="#">
                     <i class="fa fa-bar-chart"></i><span>Charts</span>
                     <span class="pull-right-container">
                     <i class="fa fa-angle-left pull-right"></i>
                     </span>
                     </a>
                     <ul class="treeview-menu">
                        <li class=""><a href="charts_flot.html">Flot Chart</a></li>
                        <li><a href="charts_Js.html">Chart js</a></li>
                        <li><a href="charts_morris.html">Morris Charts</a></li>
                        <li><a href="charts_sparkline.html">Sparkline Charts</a></li>
                     </ul>
                  </li>
                  <li class="treeview">
                     <a href="#">
                     <i class="fa fa-briefcase"></i>
                     <span>Icons</span>
                     <span class="pull-right-container">
                     <i class="fa fa-angle-left pull-right"></i>
                     </span>
                     </a>
                     <ul class="treeview-menu">
                        <li><a href="icons_bootstrap.html">Bootstrap Icons</a></li>
                        <li><a href="icons_fontawesome.html">Fontawesome Icon</a></li>
                        <li><a href="icons_flag.html">Flag Icons</a></li>
                        <li><a href="icons_material.html">Material Icons</a></li>
                        <li><a href="icons_weather.html">Weather Icons </a></li>
                        <li><a href="icons_line.html">Line Icons</a></li>
                        <li><a href="icons_pe.html">Pe Icons</a></li>
                        <li><a href="icon_socicon.html">Socicon Icons</a></li>
                     </ul>
                  </li>
                  <li class="treeview">
                     <a href="#">
                     <i class="fa fa-list"></i> <span>Other page</span>
                     <span class="pull-right-container">
                     <i class="fa fa-angle-left pull-right"></i>
                     </span>
                     </a>
                     <ul class="treeview-menu">
                        <li><a href="login.html">Login</a></li>
                        <li><a href="register.html">Register</a></li>
                        <li><a href="profile.html">Profile</a></li>
                        <li><a href="forget_password.html">Forget password</a></li>
                        <li><a href="lockscreen.html">Lockscreen</a></li>
                        <li><a href="404.html">404 Error</a></li>
                        <li><a href="505.html">505 Error</a></li>
                        <li><a href="blank.html">Blank Page</a></li>
                     </ul>
                  </li>
                  <li class="treeview">
                     <a href="#">
                     <i class="fa fa-bitbucket"></i><span>UI Elements</span>
                     <span class="pull-right-container">
                     <i class="fa fa-angle-left pull-right"></i>
                     </span>
                     </a>
                     <ul class="treeview-menu">
                        <li><a href="buttons.html">Buttons</a></li>
                        <li><a href="tabs.html">Tabs</a></li>
                        <li><a href="notification.html">Notification</a></li>
                        <li><a href="tree-view.html">Tree View</a></li>
                        <li><a href="progressbars.html">Progressber</a></li>
                        <li><a href="list.html">List View</a></li>
                        <li><a href="typography.html">Typography</a></li>
                        <li><a href="panels.html">Panels</a></li>
                        <li><a href="modals.html">Modals</a></li>
                        <li><a href="icheck_toggle_pagination.html">iCheck, Toggle, Pagination</a></li>
                        <li><a href="labels-badges-alerts.html">Labels, Badges, Alerts</a></li>
                     </ul>
                  </li>
                  <li class="treeview">
                     <a href="#">
                     <i class="fa fa-gear"></i>
                     <span>settings</span>
                     <span class="pull-right-container">
                     <i class="fa fa-angle-left pull-right"></i>
                     </span>
                     </a>
                     <ul class="treeview-menu">
                        <li><a href="gsetting.html">Genaral settings</a></li>
                        <li><a href="stfsetting.html">Staff settings</a></li>
                        <li><a href="emailsetting.html">Email settings</a></li>
                        <li><a href="paysetting.html">Payment</a></li>
                     </ul>
                  </li>
                  <li>
                     <a href="company.html">
                     <i class="fa fa-home"></i> <span>Companies</span>
                     <span class="pull-right-container">
                     </span>
                     </a>
                  </li>
                  <li>
                     <a href="holiday.html">
                     <i class="fa fa-stop-circle"></i> <span>Public Holiday</span>
                     <span class="pull-right-container">
                     </span>
                     </a>
                  </li>
                  <li>
                     <a href="user.html">
                     <i class="fa fa-user-circle"></i><span>User</span>
                     <span class="pull-right-container">
                     </span>
                     </a>
                  </li>
                  <li>
                     <a href="items.html">
                     <i class="fa fa-file-o"></i><span>Items</span>
                     <span class="pull-right-container">
                     </span>
                     </a>
                  </li>
                  <li>
                     <a href="department.html">
                     <i class="fa fa-tree"></i><span>Departments</span>
                     <span class="pull-right-container">
                     </span>
                     </a>
                  </li>
                  <li>
                     <a href="document.html">
                     <i class="fa fa-file-text"></i> <span>Documents</span>
                     <span class="pull-right-container">
                     </span>
                     </a>
                  </li>
                  <li>
                     <a href="train.html">
                     <i class="fa fa-clock-o"></i><span>Training</span>
                     <span class="pull-right-container">
                     </span>
                     </a>
                  </li>
                  <li>
                     <a href="calender.html">
                     <i class="fa fa-calendar"></i> <span>Calender</span>
                     <span class="pull-right-container">
                     </span>
                     </a>
                  </li>
                  <li>
                     <a href="notice.html">
                     <i class="fa fa-file-text"></i> <span>Notice Board</span>
                     <span class="pull-right-container">
                     </span>
                     </a>
                  </li>
                  <li>
                     <a href="message.html">
                     <i class="fa fa-envelope-o"></i> <span>Message</span>
                     <span class="pull-right-container">
                     </span>
                     </a>
                  </li>
                  <li>
                     <a href="note.html">
                     <i class="fa fa-comment"></i> <span>Notes</span>
                     <span class="pull-right-container">
                     </span>
                     </a>
                  </li>-->
               </ul>
            </div>
            <!-- /.sidebar -->
         </aside>