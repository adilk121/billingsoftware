<?php
session_start();
//load the database configuration file
include 'dbConfig.php';

if(isset($_POST['importSubmit'])){
    $sub_cat_id=$_POST['subcatid'];
$cat_id=$_POST['catid'];

    //validate whether uploaded file is a csv file
    $csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
    if(!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'],$csvMimes)){
        if(is_uploaded_file($_FILES['file']['tmp_name'])){
            
            //open uploaded csv file with read only mode
            $csvFile = fopen($_FILES['file']['tmp_name'], 'r');
            
            //skip first line
            fgetcsv($csvFile);
            
            //parse data from csv file line by line
            while(($line = fgetcsv($csvFile)) !== FALSE){
                //check whether member already exists in database with same email
                $prevQuery = "SELECT category_id FROM tbl_category WHERE category_name = '".$line[0]."'";
                $prevResult = $db->query($prevQuery);
                if($prevResult->num_rows > 0){
                    //update member data
					//$date = date("Y-m-d",strtotime($line[6]));
                   // $db->query("UPDATE tbl_records SET ranking_page_no = '".$line[1]."', ranking_position_no = '".$line[2]."', ranking_search_engine_name = '".$line[4]."', ranking_industry = '".$line[5]."', ranking_date = '".$date."' WHERE records_website_url = '".$line[0]."' AND ranking_website_url = '".$line[3]."'");
                }else{
                    //insert member data into database
					//$date = date("Y-m-d",strtotime($line[6]));
					

$date = date("Y-m-d");
$currStatus = "Active";
$value = $line[0];
$cat_url = preg_replace('/[ ,]+/', '-', trim($value));
$stock='Yes';
$category_is_pro='Yes';


                    $db->query("INSERT INTO tbl_category (category_name, category_name_keywords, category_company_name, category_model_number, category_model_year, category_real_price, category_discount_price, category_discount_percentage, category_description, category_qnty, category_parent_id, category_url, category_is_product, category_add_date, category_in_stock, category_status) VALUES ('".$line[0]."','".$line[1]."','".$line[2]."','".$line[3]."','".$line[4]."','".$line[5]."','".$line[6]."','".$line[7]."','".$line[8]."','".$line[9]."','".$sub_cat_id."','".$cat_url."','".$category_is_pro."','".$date."','".$stock."','".$currStatus."')");
                }
            }
         
         
         
            //close opened csv file
            fclose($csvFile);

         //   $qstring = '?status=succ';
            $_SESSION["msg_csv"]="succ";
        }else{
          //  $qstring = '?status=err';
               $_SESSION["msg_csv"]="err";
        }
    }else{
       // $qstring = '?status=invalid_file';
           $_SESSION["msg_csv"]="invalid_file";
    }
}

//redirect to the listing page
header("Location: product_list.php?subcatid=$sub_cat_id&catid=$cat_id");