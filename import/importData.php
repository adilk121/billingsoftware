<?php
//load the database configuration file
include 'dbConfig.php';

if(isset($_POST['importSubmit'])){
    
    //validate whether uploaded file is a csv file
    $csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
    if(!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'],$csvMimes)){
        if(is_uploaded_file($_FILES['file']['tmp_name'])){
            
            //open uploaded csv file with read only mode
            $csvFile = fopen($_FILES['file']['tmp_name'], 'r');
            
            //skip first line
            fgetcsv($csvFile);
            
            //parse data from csv file line by line
$rCount=0;
while(($line = fgetcsv($csvFile)) !== FALSE){

$rCount++;

//if($rCount>1){

$prevQuery = "SELECT category_id FROM  tbl_category WHERE category_name = '".trim($line[0])."'";
$prevResult = $db->query($prevQuery);



$prdParID="";
foreach($prevResult as $pi){
$prdParID=$pi['category_id'];	
}

$category_real_price=$line[1];
$category_discount_price=$line[2];

$dicountAmount=$category_real_price-$category_discount_price;
$category_discount_percentage=($dicountAmount/$category_real_price)*100;


//insert member data into database
$sql="INSERT INTO tbl_category SET 
category_real_price = '".$line[1]."', 
category_discount_price = '".$line[2]."', 
category_color = '".$line[3]."', 
category_size = '".$line[4]."', 
category_status = '".$line[5]."',
category_qnty='".$line[6]."',
category_image_ids='".$line[7]."',
category_parent_id='$prdParID',
category_is_product='Yes',
category_for_stock='Yes',
category_discount_percentage='$category_discount_percentage'
";

$db->query($sql);

//}

}
            
            //close opened csv file
            fclose($csvFile);

            $qstring = '?status=succ&cat='.$_REQUEST['cat'];
        }else{
            $qstring = '?status=err&cat='.$_REQUEST['cat'];
        }
    }else{
        $qstring = '?status=invalid_file&cat='.$_REQUEST['cat'];
    }
}

//redirect to the listing page
header("Location: index.php".$qstring);
exit;
?>