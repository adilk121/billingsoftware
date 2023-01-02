<?php 
ob_start();
require_once("../includes/dbsmain.inc.php");
$page_name=basename($_SERVER['PHP_SELF'],'.php');
include("../site-main-query.php");
$sess_id=session_id();
$site_url=$compDATA['admin_website_url'];
?>
<style>
.v-middle {
vertical-align:middle !important;

}

div#formdiv {
    background: #8e32a23b;
    padding: 15px;
}

div#formdiv input {
    background: #3f3c3c;
    border: solid thin #3f3c3c;
    color: #fff;
    padding: 5px 8px 5px 8px;
    border-radius: 5px;
    font-weight: 600;
}

div#formdiv input[type="button"] {
    background: #FF5722;
    border: solid thin #FF5722;
    color: #fff;
    padding: 5px 8px 5px 8px;
    border-radius: 5px;
    font-weight: 600;
}

div#formdiv input[type="submit"] {
    background: #FF5722;
    border: solid thin #FF5722;
    color: #fff;
    padding: 5px 8px 5px 8px;
    border-radius: 5px;
    font-weight: 600;
}




</style>
<div class="col-sm-12">
<div class="panel panel-bd lobidrag" data-edit-title='false' data-close='false' data-reload='false'>


<div class="panel-body">



<div class="table-responsive">
<?php			
$sql="select * from tbl_category_image ORDER BY category_image_id";
$sql_fetch = db_query($sql);
$cntDATA=mysqli_num_rows($sql_fetch);
if($cntDATA > 0){	
$chk=1;
while($DATA = mysqli_fetch_array($sql_fetch)) {
@extract($DATA);	

if(file_exists("../category_more_images/$DATA[category_image_name]")){	 
?>
<div class="col-lg-2 text-center" style="margin-bottom:10px">
<img src="../category_more_images/<?=$DATA['category_image_name']?>" class="img-thumbnail" width="140" height="140" />
<span style="font-weight:bold;"><?=$DATA['category_image_title']?></span>

<div class="col-lg-12 text-center" style="margin-top:10px" >
<input type="checkbox" name="choose-image" style="width:20px;height:20px;margin: 0 0 0 5px;vertical-align: middle;" onclick="add_item_images('<?=$DATA['category_image_id']?>','<?=$chk?>','../category_more_images/<?=$DATA['category_image_name']?>')" id="<?=$chk?>"  value="<?=$DATA['category_image_id']?>" />

<strong>IMAGE ID :</strong> <?=$DATA['category_image_id']?>

</div>
</div>		  
<?php 
}

$chk++;
}
} 
?>
<div class="cb"></div>
</div>

</table>

</div>

</div>
</div>

<script>
function add_item_images(imgID,chk,img_url){



$(document).ready(function(e) {

$("#image-added-area").show("fast");

if($("#"+chk).prop('checked') == true){
var ids=$("#imgIDs_all").val();

if(ids!=""){
$("#imgIDs_all").val(ids+","+imgID);
}else{
$("#imgIDs_all").val(imgID);	
}


}

if($("#"+chk).prop('checked') == false){
	
	
var ids=$("#imgIDs_all").val();

if((ids.search(","+imgID))!=-1){

var ids=ids.replace(","+imgID,"");
$("#imgIDs_all").val(ids);

$("#item_image_"+imgID).remove()

}else{

if((ids.search(imgID+","))!=-1){

var ids=ids.replace(imgID+",","");
$("#imgIDs_all").val(ids);	
$("#item_image_"+imgID).remove()
}else{

var ids=ids.replace(imgID,"");
$("#imgIDs_all").val(ids);	
$("#item_image_"+imgID).remove()
}

}


}



});

	
}
</script>
<script src="assets/plugins/jQuery/jquery-1.12.4.min.js" type="text/javascript"></script>