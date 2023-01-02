<?php
ob_start();
require_once("../includes/dbsmain.inc.php");
?>
<?php
$catID=$_GET['catID'];
$qnty=$_GET['qnty'];

if(!empty($catID)){
$sql="UPDATE tbl_category  SET category_qnty='$qnty' WHERE category_id='$catID'";
$res=db_query($sql);	
if($res){
echo 1;	
}else{
echo 0;		
}

}
?>


