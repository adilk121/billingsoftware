<?php
ob_start();
require_once("../includes/dbsmain.inc.php");
if(empty($_SESSION['sess_admin_login_id'])){
header("location:login.php");
exit;	
}
$curr_date=date("Y-m-d");
?>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>ThariChoice : Admin Panel</title>
      <!-- Favicon and touch icons -->
      <link rel="shortcut icon" href="../fevicon.png" type="image/x-icon">
      <!-- Start Global Mandatory Style
         =====================================================================-->
      <!-- jquery-ui css -->
      <link href="assets/plugins/jquery-ui-1.12.1/jquery-ui.min.css" rel="stylesheet" type="text/css"/>
      <!-- Bootstrap -->
      <link href="assets/bootstrap/css/bootstrapa.min.css" rel="stylesheet" type="text/css"/>
      <!-- Bootstrap rtl -->
      <!--<link href="assets/bootstrap-rtl/bootstrap-rtl.min.css" rel="stylesheet" type="text/css"/>-->
      <!-- Lobipanel css -->
      <link href="assets/plugins/lobipanel/lobipanel.min.css" rel="stylesheet" type="text/css"/>
      <!-- Pace css -->
      <link href="assets/plugins/pace/flash.css" rel="stylesheet" type="text/css"/>
      <!-- Font Awesome -->
      <link href="assets/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
      <!-- Pe-icon -->
      <link href="assets/pe-icon-7-stroke/css/pe-icon-7-stroke.css" rel="stylesheet" type="text/css"/>
      <!-- Themify icons -->
      <link href="assets/themify-icons/themify-icons.css" rel="stylesheet" type="text/css"/>
      <!-- End Global Mandatory Style
         =====================================================================-->
      <!-- Start page Label Plugins 
         =====================================================================-->
      <!-- Emojionearea -->
      <link href="assets/plugins/emojionearea/emojionearea.min.css" rel="stylesheet" type="text/css"/>
      <!-- Monthly css -->
      <link href="assets/plugins/monthly/monthly.css" rel="stylesheet" type="text/css"/>
      <!-- End page Label Plugins 
         =====================================================================-->
      <!-- Start Theme Layout Style
         =====================================================================-->
      <!-- Theme style -->
      <link href="assets/dist/css/stylecrm.css" rel="stylesheet" type="text/css"/>

      <link href="assets/dist/css/custom.css" rel="stylesheet" type="text/css"/>
      
      <style>
	span.count-num {
    float: right;
    margin: -16px 13px 0 0;
    font-size: 18px;
    background: red;
    padding: 1px 6px 1px 6px;
    color: #fff;
    border-radius: 15px;
}
	  </style>

<style>
#bubble-of-the-week{
width: 800px;
margin: 0 40px 0 0;
padding: 12px 0 10px 0;
font-size: 20px;
color: #fff;
text-shadow: 1px 1px 2px black;
}

#bubble-of-the-week marquee{
margin:5px 0 0 0;	
padding:0  0 5px 0;
}

select#buyer-ord {
    width: 200px;
    float: right;
    margin: -16px 0 0 0;
}

select#resller-ord {
    width: 200px;
    float: right;
    margin: -16px 10px 0 0;
}


.content-wrapper, .right-side, .main-footer {
    -webkit-transition: -webkit-transform 0.3s ease-in-out, margin 0.3s ease-in-out;
    -webkit-transition: margin 0.3s ease-in-out, -webkit-transform 0.3s ease-in-out;
    transition: margin 0.3s ease-in-out, -webkit-transform 0.3s ease-in-out;
    transition: transform 0.3s ease-in-out, margin 0.3s ease-in-out;
    transition: transform 0.3s ease-in-out, margin 0.3s ease-in-out, -webkit-transform 0.3s ease-in-out;
    margin-left: 0;
    z-index: 820;
}


@media only screen and (max-width : 769px) and (orientation:portrait){

#bubble-of-the-week {
    width: 200px;
    margin: 0 35px 0 0;
    padding: 0 0 10px 0;
    font-size: 20px;
    color: #fff;
    text-shadow: 1px 1px 2px black;
}

}

@media only screen and (max-width : 769px) and (orientation:landscape){

#bubble-of-the-week {
    width: 452px;
    margin: 0 35px 0 0;
    padding: 0 0 10px 0;
    font-size: 20px;
    color: #fff;
    text-shadow: 1px 1px 2px black;
}

}
</style>

      <!-- Theme style rtl -->
      <!--<link href="assets/dist/css/stylecrm-rtl.css" rel="stylesheet" type="text/css"/>-->
      <!-- End Theme Layout Style
         =====================================================================-->

<style>
select.bysize {
    border: solid thin #8e32a2;
    font-size: 16px;
    margin: -14px 0 0 0;
}

.form-group.custom-width {
    width: 13%;
	padding: 0 5px;
}

div#stock-entry{
	padding:15px 10px 2px 10px;
	margin:15px 0 15px 0;
	
}

.reset-button {
    margin-top: 0;
    padding: 0px 10px;
}
</style>



         <!-- Content Wrapper. Contains page content -->
         <div class="content-wrapper">
           
           
            <!-- Main content -->

            <section class="content">
            

               <div class="row">
                  <!-- Form controls -->
                  <div class="col-sm-12">
                     <div class="panel panel-bd lobidrag" data-edit-title='false' data-close='false' data-reload='false'>
                        <div class="panel-heading">
                           <div class="btn-group" id="buttonexport">
                              <a href="#">
                                 <h4>Images For Stock
                                 
                                 
                                 
                                 
                                 </h4>
                              </a>
                           </div>
                        </div>
                        <div class="panel-body">
                        
                        
<div id="table-load-area">

<div class="table-responsive" >

                        
                        
<div class="col-lg-3 text-left text-danger">*Note: First will be main image of product</div>

<div class="col-lg-5">
<div class="col-lg-4 text-right"><strong>Copy Image ID :</strong> </div>
<div class="col-lg-6 no-padd">
<input type="text" class="form-control" name="image_ids" id="imgIDs_all" value="" />
</div>
<div class="col-lg-2 text-left no-padd">
<button class="btn btn-primary" id="copy-image-ids"><i class="fa fa-clone"></i> Copy</button>
</div>
</div>


<div class="col-lg-4 text-right">
<a href="pick-images.php" class="btn btn-info pull-right" style="margin-left:10px" >
<i class="fa fa-refresh" aria-hidden="true"></i> Clear</a>  

</div>       
                      



<div class="col-lg-12 mt20 mb30" id="image-select-area"></div>

</div>

</div>
                     </div>
                  </div>
               </div>
            </section>
            <!-- /.content -->
         </div>
<?php require_once("footer.php"); ?>
<script>
$(document).ready(function(e) {

////////////////// DISPLAYING IMAGE AREA ////////////////////////////
//$("#select-images").click(function(e) {

$('#image-select-area').slideUp('fast').load('load-item-images-all.php').slideDown("fast");			  	
    
//});

	
});


</script>


<script src='https://cdn.jsdelivr.net/clipboard.js/1.5.10/clipboard.min.js'></script>

<script>
$(document).ready(function(e) {
var clipboard = new Clipboard('#copy-image-ids', {
    text: function() {
        return document.querySelector('#imgIDs_all').value;
    }
});
clipboard.on('success', function(e) {
  alert("Image Ids Are Copied!");
  e.clearSelection();
});
//$("#input-url").val(location.href);
//safari
if (navigator.vendor.indexOf("Apple")==0 && /\sSafari\//.test(navigator.userAgent)) {
   $('#copy-shop-url').on('click', function() {
var msg = window.prompt("Copy this link", location.href);

});
  }
    
});
</script>