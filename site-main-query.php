<?php
///////////////////////////// ADMIN/OWNER INFORMATION /////////////////////////////
$sql_comp_detail=db_query("select * from tbl_admin where 1");
 if(mysqli_num_rows($sql_comp_detail)>0){
  $compDATA=mysqli_fetch_array($sql_comp_detail);
}
?>
<?php
/////////////////////////////// USER INFORMATION /////////////////////////////
if(!empty($_SESSION['reg_id'])){

$sql_user_detail=db_query("select * from  tbl_registration where reg_id='$_SESSION[reg_id]'");
 if(mysqli_num_rows($sql_user_detail)>0){
  $userDATA=mysqli_fetch_array($sql_user_detail);
}

}
?>
<?php
//////////////////////////// RESELLER INFORMATION /////////////////////////////
if(!empty($_SESSION['resID'])){

$sql_reseller_detail=db_query("select * from  tbl_resellers where reseller_id='$_SESSION[resID]'");
 if(mysqli_num_rows($sql_reseller_detail)>0){
  $resellerDATA=mysqli_fetch_array($sql_reseller_detail);
}

}
?>