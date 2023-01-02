<?php
ob_start();
require_once("../includes/dbsmain.inc.php");  // ADDING CONNECTION FILES
date_default_timezone_set('Asia/Kolkata');

 

 
// Get search term 
 $skillData = array(); 
 $search_sql=db_query("SELECT * FROM tbl_invoice_product where invoice_product_status='Active' ");
 while($row=mysqli_fetch_array($search_sql))
 {

     $data['id'] = $row['invoice_product_id']; 
        $data['value'] = $row['invoice_product_name']; 
        array_push($skillData, $data); 
 }


 
// Return results as json encoded array 
echo json_encode($skillData); 
?>