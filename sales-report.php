<?php require_once("header.php");?>
<?php require_once("left-nav.php");?>
<style>
g.raphael-group-85-creditgroup {
    display: none !important;
}

select#prd_filter {
    width: 200px;
    float: right;
    margin: 0 300px 0 0;
}


	span.count-num {
    float: right;
    margin: 0px 13px 0 0;
    font-size: 18px;
    background: red;
    padding: 1px 6px 1px 6px;
    color: #fff;
    border-radius: 15px;
}


.v-middle {
vertical-align:middle !important;
}
span.new-lbl {
    background: #FFEB3B;
    padding: 1px 5px 1px 5px;
    font-size: 11px;
    font-weight: 600;
    color: red;
    border: solid thin #f0df4d;
    position: relative;
    top: -12px;
}
</style>
<?php
$catID=$_REQUEST['catid'];
$subcatid=$_REQUEST['subcatid'];
?>
<?php
if($st!=""){
$st=$_REQUEST['st'];
$subcatID=$_REQUEST['pid'];

if($st==1){
$sql="UPDATE tbl_category SET category_status='Inactive' WHERE category_id='$subcatID' ";	
$res=db_query($sql);	
if($res>0){
$_SESSION["msg"]="Selected product is deactivated successfully.";	
}	
}else{
$sql="UPDATE tbl_category SET category_status='Active' WHERE category_id='$subcatID' ";	
$res=db_query($sql);	
if($res>0){
$_SESSION["msg"]="Selected product is activated successfully.";	
}	
	
}

header("location:product_list.php?subcatid=$subcatid&catid=$catid");
exit;
}




if(is_post_back()) {
	$arr_ids = $_REQUEST['arr_ids'];
	if(is_array($arr_ids)) {
		$str_ids = implode(',', $arr_ids); 
		if(isset($_REQUEST['Activate']) || isset($_REQUEST['Activate_x']) ) {
			db_query("update tbl_category set category_status='Active' where category_id in ($str_ids)");
			$_SESSION["msg"]="selected categories are activated. ";
		} else if(isset($_REQUEST['Deactivate']) || isset($_REQUEST['Deactivate_x']) ) {
			db_query("update tbl_category set category_status='Inactive' where category_id in ($str_ids)");
						$_SESSION["msg"]="selected categories are deactivated. ";
		} else if(isset($_REQUEST['make_new']) || isset($_REQUEST['make_new_x']) ) {
			db_query("update tbl_category set category_is_new='Yes' where category_id in ($str_ids)");
						$_SESSION["msg"]="selected categories are set for new. ";
		} else if(isset($_REQUEST['remove_new']) || isset($_REQUEST['remove_new_x']) ) {
			db_query("update tbl_category set category_is_new='No' where category_id in ($str_ids)");
						$_SESSION["msg"]="selected categories are removed from new. ";
		}
		
	}
	if(isset($_REQUEST['Update'])){
		foreach($category_order_by as $key=>$value){
		db_query("update tbl_category set category_order_by='$value' where category_id='$key'");
		}
		$_SESSION["msg"]="Selected category order is set.";
	}
		
	header("Location: ".$_SERVER['HTTP_REFERER']);
	exit;
}





$start = intval($start);
$pagesize = intval($pagesize)==0?$pagesize=5:$pagesize;

$order_by == '' ? $order_by = 'category_name' : true;
$order_by2 == '' ? $order_by2 = 'asc' : true;
 
$sql = "select * from  tbl_category   where 1 AND category_parent_id!='0' AND category_is_product='Yes'";
$sql = apply_filter($sql, $category_name, 'like','category_name');
$sql .= " order by $order_by $order_by2 ";
$sql .= " limit $start, $pagesize ";
//echo $sql;
$pager = new midas_pager_sql($sql, $pagesize, $start);
if($pager->total_records) {
	$result = db_query($sql);
}
?>

<script language="JavaScript" type="text/javascript" src="../includes/general.js"></script>

         <!-- =============================================== -->
         <!-- Content Wrapper. Contains page content -->
         <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
               <div class="header-icon">
                  <i class="fa fa-archive" aria-hidden="true"></i>

               </div>
               <div class="header-title">
                  <h1>Sale & Inventory

                  
           
           <span class="count-num" style="margin-top:10px">Total : <?=db_scalar("select COUNT(category_id) from  tbl_category   where 1 AND category_parent_id!='0' AND category_is_product='Yes'")?></span>    

                  
            <a class="btn btn-link pull-right"  href="sales-and-inventory.php" ><i class="fa fa-arrow-left"></i> Go Back</a>                  

             


                  
                  </h1>
                  <small>Sale & Inventory</small>
                  
                  
                  
          
          
          
</div>


           
               
            </section>
            <!-- Main content -->
            <section class="content">

<div class="row">
<div class="col-lg-12">
<?php
/* Include the fusioncharts.php file that contains functions to embed the charts. */
include("../includes/fusioncharts.php");
/* The following 4 code lines contain the database connection information. Alternatively, you can move these code lines to a separate file and include the file here. You can also modify this code based on your database connection. */
$hostdb = $ARR_CFGS["db_host"];  // MySQl host
 $userdb = $ARR_CFGS["db_user"];  // MySQL username
 $passdb = $ARR_CFGS["db_pass"];  // MySQL password
 $namedb = $ARR_CFGS["db_name"];  // MySQL database name
// Establish a connection to the database
$dbhandle = new mysqli($hostdb, $userdb, $passdb, $namedb);
/*Render an error message, to avoid abrupt failure, if the database connection parameters are incorrect */
if ($dbhandle->connect_error) {
exit("There was an error with your connection: ".$dbhandle->connect_error);
}
?>


<!-- You need to include the following JS file to render the chart.
When you make your own charts, make sure that the path to this JS file is correct.
Else, you will get JavaScript errors. -->

<script type="text/javascript" src="js/fusioncharts.js"></script>

<script type="text/javascript" src="js/themes/fusioncharts.theme.fint.js"></script>

<!--<script type="text/javascript" src="http://static.fusioncharts.com/code/latest/fusioncharts.js"></script>-->

<?php
    // Form the SQL query that returns the top 10 most populous countries
    $strQuery = "SELECT category_id,category_name FROM tbl_category WHERE category_is_product='Yes' ORDER BY category_name limit $start, $pagesize";
    // Execute the query, or else return the error message.
    $resultGraph = $dbhandle->query($strQuery) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
    // If the query returns a valid response, prepare the JSON string
    if ($resultGraph) {
        // The `$arrData` array holds the chart attributes and data
        $arrData = array(
            "chart" => array(
              "caption" => "Products Sale Report",
              "paletteColors" => "#0075c2",
              "bgColor" => "#ffffff",
              "borderAlpha"=> "20",
              "canvasBorderAlpha"=> "0",
              "usePlotGradientColor"=> "0",
              "plotBorderAlpha"=> "10",
              "showXAxisLine"=> "1",
              "xAxisLineColor" => "#999999",
              "showValues" => "0",
              "divlineColor" => "#999999",
              "divLineIsDashed" => "1",
              "showAlternateHGridColor" => "0"
            )
        );
        $arrData["data"] = array();
// Push the data into the array
        while($row = mysqli_fetch_array($resultGraph)) {
			$qntySold=db_scalar("SELECT SUM(item_qnty) FROM tbl_sale_inventory WHERE prd_id='$row[category_id]'");
			$saleAmount=db_scalar("SELECT SUM(total_amount) FROM tbl_sale_inventory WHERE prd_id='$row[category_id]'");
			
        array_push($arrData["data"], array(
            "label" => $row["category_name"]." ($qntySold)"."<br>Rs. $saleAmount",
            "value" => $qntySold
            )
        );
        }
        /*JSON Encode the data to retrieve the string containing the JSON representation of the data in the array. */
        $jsonEncodedData = json_encode($arrData);
/*Create an object for the column chart using the FusionCharts PHP class constructor. Syntax for the constructor is ` FusionCharts("type of chart", "unique chart id", width of the chart, height of the chart, "div id to render the chart", "data format", "data source")`. Because we are using JSON data to render the chart, the data format will be `json`. The variable `$jsonEncodeData` holds all the JSON data for the chart, and will be passed as the value for the data source parameter of the constructor.*/
        $columnChart = new FusionCharts("column2D", "Product Sale Report" , "100%", 500, "chart-1", "json", $jsonEncodedData);
        // Render the chart
        $columnChart->render();
        // Close the database connection
        $dbhandle->close();
    }
?>

<div class="col-lg-12" id="chart-1"><!-- Fusion Charts will render here--></div>

</div>

<? $pager->show_pager();?>
</div>

               <div class="row mt30">



<?php if($_SESSION["msg"]!=""){?>               
<div class="alert alert-success alert-dismissable fade in text-center" style="background-color:#dff0d8;border:none; color:#000;margin:10px 0 0 0">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Success!&nbsp;&nbsp;&nbsp;</strong> <?=$_SESSION["msg"]?>
  </div>
<?php 
unset($_SESSION["msg"]);
}?>     

<div class="col-lg-12">

<? if($pager->total_records!=0) {?>
<div class="col-lg-6 text-left" >
<? $pager->show_displaying()?>
</div>
<div class="col-lg-6 text-right" >Records Per Page:
<?=pagesize_dropdown('pagesize', $pagesize);?>
</div>
<?php
}
?>

</div>


                  <div class="col-sm-12">
                     <div class="panel panel-bd lobidrag" data-edit-title='false' data-close='false' data-reload='false'>
                        
                        
                           
                        
                        
                        <div class="panel-heading">
                           <div class="btn-group" id="buttonexport">
                              <a href="#">
<h4>Sale & Inventory </h4>
                              </a>
                           </div>
                        </div>
                        
                        



                        
                        <div class="panel-body">
                       
<? if($pager->total_records>0) {?>                       
                       
                           <div class="table-responsive">
<form action="" method="post" enctype="multipart/form-data">                           
                              <table id="dataTableExample1" class="table table-bordered table-striped table-hover">
                                 <thead>
                                    <tr class="info">                                      
                                       <th class="text-center">S.No.</th>                                                  
                                       <th class="text-center">Item</th>                                       
                                       <th class="text-center">Total Qnty</th>
                                       <th class="text-center">Qnty Sold</th>
                                       <th class="text-center">Total Sale</th>
                                       <th class="text-center">Edit</th>
                                    </tr>
                                 </thead>
                                 
<tbody>
                                   
<?
$cnt=0;
while ($line_raw = mysqli_fetch_array($result)) {
	$line = ms_display_value($line_raw);
	@extract($line);
	$css = ($css=='trOdd')?'trEven':'trOdd';
?>                                   
                                    <tr>
                            
                            
                            <td class="text-center v-middle"><?=++$start?></td>
                            
                            
                                     
<td class="text-left v-middle " style="padding-left:20px">

<a href="Javascript:void(0)" onClick ="PopupWindowCenter('sale_detail.php?prdID=<?=$line_raw["category_id"]?>', 'PopupWindowCenter',1000,400)" ><?=$line_raw["category_name"]?></a> </td>
                                     

<td class="text-center v-middle"  >
<div class="col-lg-12 text-center" align="center" id="all_area_<?=$line_raw["category_id"]?>">
<div class="col-lg-12" id="qnty_area_<?=$line_raw["category_id"]?>" style="display:block">
<?php
if($line_raw["category_qnty"]>0){
?>
<span style="color:#090;font-weight:600"><?=$line_raw["category_qnty"]?></span>
<?php
}else{
?>	
<span style="color:red;font-weight:600">Out Of Stock</span>	
<?php
}
?>
</div>

<div class="col-lg-12" id="edit_qnty_<?=$line_raw["category_id"]?>" style="display:none">
<input type="text" name="edit_qnty"  class="txt_qnty" id="txt_qnty_<?=$line_raw["category_id"]?>" value="<?=$line_raw["category_qnty"]?>" style="width:50%;text-align:center; "  autocomplete="off" /><button type="button" id="save_qnty_<?=$line_raw["category_id"]?>" onClick="save_prd_qnty(<?=$line_raw["category_id"]?>)"><i class="fa fa-save fa-lg"></i></button></div>
</div>

<div class=" clearfix"></div>
</td>


<td class="v-middle" align="center">
<?php
$qntySold=db_scalar("SELECT SUM(item_qnty) FROM tbl_sale_inventory WHERE prd_id='$line_raw[category_id]'");
if($qntySold!=""){
echo $qntySold;	
}else{
echo "0";	
}
?>
</td>



<td class="text-center v-middle">
<i class="fa fa-inr" aria-hidden="true"></i>
<?php
$qntySold=db_scalar("SELECT SUM(total_amount) FROM tbl_sale_inventory WHERE prd_id='$line_raw[category_id]'");
if($qntySold!=""){
echo $qntySold;	
}else{
echo "0";	
}
?>                                       
</td>


<td class="text-center v-middle">
<button type="button" class="" onClick="edit_quantity(<?=$line_raw['category_id']?>);" id="edit_<?=$line_raw['category_id']?>" ><i class="fa fa-pencil"></i></button>


</td>                                           
                                       
                                    </tr>
<?php
}
?>
                                    
                                    
                                    
                                    
                                 </tbody>
</form>
                              </table>
                              
<? $pager->show_pager();?>
                                             
                              
                           </div>
<?php }else{?>
<div class="col-lg-12 msg text-center">Sorry, no records found.</div>
<?php }?>
                                  
                           
                        </div>
                     </div>
                  </div>
               </div>
               <!-- customer Modal1 -->
               
               <!-- /.modal -->
               <!-- Modal -->    
               <!-- Customer Modal2 -->
               
               <!-- /.modal -->
            </section>

            <!-- /.content -->
         </div>
<?php require_once("footer.php"); ?>
<script>

    
function edit_quantity(catID){

$(document).ready(function(e) {
	
//alert(catID);
var toHide="qnty_area_"+catID;	
var toShow="edit_qnty_"+catID;	

$("#"+toShow).show("fast");
$("#"+toHide).hide("fast");



});
	
}


function save_prd_qnty(catID){

$(document).ready(function(e) {
	
var toHide="#edit_qnty_"+catID;	
var toShow="#qnty_area_"+catID;

var allArea="#all_area_"+catID;


//alert(catID);

var qnty=$("#txt_qnty_"+catID).val();

$.ajax({
type:"GET",
url:'update-prd-qnty.php?catID='+catID+"&qnty="+qnty,
processData:true,
success: function(data){

if(data==1){	

$(toShow).show("fast");
$(toHide).hide("fast");

$(allArea).fadeOut('slow').load('reload-prd-qnty.php?catID='+catID).fadeIn("slow");	

}else{
alert("Unable to update this record.");	
}

}
	
});    

});
	
}


</script>
<!--<script type="text/javascript" src="../js/fusioncharts.js"></script>-->

<!--<script type="text/javascript" src="../js/fusioncharts.theme.ocean.js"></script>-->