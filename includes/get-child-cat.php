<?php
$id_array=array();

function has_child($catid){
$sql="SELECT COUNT(category_id) FROM  tbl_category WHERE 1 AND category_parent_id='$catid' AND category_status='Active'  AND category_for_stock='No' ";	
$count=db_scalar($sql);

if($count>0){
return true;	
}else{
return false;		
}
	
}


function getIds($catid){

$sql="SELECT category_id FROM tbl_category WHERE 1 AND category_parent_id='$catid' AND category_status='Active' AND category_for_stock='No' ";	
$data_ids=db_query($sql);
while($rec_ids=mysqli_fetch_array($data_ids)){

if(has_child($rec_ids['category_id'])){
$id_array[]=getIds($rec_ids['category_id']);
}else{
$id_array[]=$rec_ids['category_id'];
}

}

return @implode(",",$id_array);

}
?>  