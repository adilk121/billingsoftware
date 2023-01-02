<?php
ob_start();
require_once("../includes/dbsmain.inc.php");
if(empty($_SESSION['sess_admin_login_id'])){
header("location:login.php");
exit; 
}
$curr_date=date("Y-m-d");
?>

<?php 

 
// Get search term 
$searchTerm = $_GET['term']; 
 
// Fetch matched data from the database 
$query = db_query("SELECT distinct(category_company_name) FROM tbl_category WHERE category_company_name LIKE '%".$searchTerm."%' AND category_status = 'Active' order by CASE when category_company_name LIKE '$searchTerm%'
THEN 1 when category_company_name LIKE '%$searchTerm%' THEN 2 when category_company_name LIKE '%$searchTerm' THEN  3 END"); 
 
// Generate array with skills data 
$skillData = array(); 
if($query->num_rows > 0){ 
    while($row = $query->fetch_assoc()){ 
       // $data['id'] = $row['category_id']; 
        $data['value'] = $row['category_company_name']; 
        array_push($skillData, $data); 
    } 
} 
 
// Return results as json encoded array 
echo json_encode($skillData); 
?>