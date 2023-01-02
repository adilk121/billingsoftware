<?php
require_once("../includes/dbsmain.inc.php");
ob_start();

//------------FUNCTION TO GET IMAGE EXTENSION START---------------//
 function getExtension($str) {
         $i = strrpos($str,".");
         if (!$i) { return ""; }
         $l = strlen($str) - $i;
         $ext = substr($str,$i+1,$l);
         return $ext;
 }
 //------------FUNCTION TO GET IMAGE EXTENSION END---------------//
if($_SERVER["REQUEST_METHOD"] == "POST"){
 	$image =$_FILES["file"]["name"];
	$uploadedfile = $_FILES['file']['tmp_name']; 
 	if ($image) { 	
 		$filename = stripslashes($_FILES['file']['name']); 	
  		$extension = getExtension($filename);
 		$extension = strtolower($extension);
		$imgNAME = substr(md5($reg_email.mktime().rand(1,9)),0,14).".".$extension;		

 $size=filesize($_FILES['file']['tmp_name']);
if($extension=="jpg" || $extension=="jpeg" ){
  $uploadedfile = $_FILES['file']['tmp_name'];
  $src = imagecreatefromjpeg($uploadedfile);
}else if($extension=="png"){
  $uploadedfile = $_FILES['file']['tmp_name'];
  $src = imagecreatefrompng($uploadedfile);
}else{
$src = imagecreatefromgif($uploadedfile);
}
list($width,$height)=getimagesize($uploadedfile);
if($width >= 400){
$newwidth=400;
$newheight=($height/$width)*$newwidth;
$tmp=imagecreatetruecolor($newwidth,$newheight);
imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);
$filename = "../teacher/". $imgNAME;
imagejpeg($tmp,$filename,100);
imagedestroy($src);
imagedestroy($tmp);
imagedestroy($tmp1);
}else{
move_uploaded_file($_FILES['file']['tmp_name'],"../teacher/$imgNAME");
}
}


$checkTeacher=db_scalar("SELECT reg_id FROM tbl_registration WHERE 1 AND reg_email='$reg_email'");
if($checkTeacher>0){
set_session_msg("This User ID is already exist !");
header("Location:add-teacher.php");
exit;
}else{


$reg_class_name=db_scalar("SELECT category_name FROM tbl_category WHERE 1 AND category_id='$reg_class'");
$reg_subject_name=db_scalar("SELECT category_name FROM tbl_category WHERE 1 AND category_id='$subject_id'");

$sql = "insert into tbl_registration set 
                reg_name='$reg_name',
				reg_email='$reg_email',
				reg_mobile_no='$reg_mobile_no',
   		        reg_stream='$reg_stream',				
                reg_class='$reg_class_name',
		        reg_class_id='$reg_class',		   
                reg_subject='$reg_subject_name',										
                reg_subject_id='$subject_id',	
				reg_pass='$reg_pass',
				reg_status='$reg_status',
				reg_user_type='Teacher',
				reg_add_date='".date("Y-m-d")."'";

db_query($sql);
set_session_msg("Teacher/Team is added successfully !");
header("Location:add-teacher.php");
exit;

}

}
?>
<script src="ckeditor/ckeditor.js"></script>
<style>
p.fck {
    width: 90%;
	float:left;
    margin: 0 auto;
 }
</style>
<link href="styles.css" rel="stylesheet" type="text/css">
<script>
function getXMLHTTP() {
var xmlhttp=false;	
try{
xmlhttp=new XMLHttpRequest();
}
catch(e){
try{	
xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
}
catch(e){
try{
xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
}
catch(e1){
xmlhttp=false;
}
}
}
return xmlhttp;
}


function check_user(){

var req=new getXMLHTTP();

var myemail = document.getElementById('reg_email').value;

//alert(myemail)

var str="../check_user.php?emailID="+myemail;
req.onreadystatechange = function() {

if(req.readyState==4){
if(req.status==200){

document.getElementById('errorMsg').style.display="block";
document.getElementById('errorMsg').innerHTML=req.responseText;




} 
}
}

req.open("GET",str,true);
req.send(null);
}


function loadSubjectTeach(classID){
//alert(classID);
var req=new getXMLHTTP();
var str="load-subject-teacher.php?classID="+classID;
req.onreadystatechange = function() {
	
if(req.readyState==4){
if(req.status==200){//alert(req.responseText);

document.getElementById('subject-area').innerHTML=req.responseText;

}
}

}


req.open("GET",str,true);
req.send(null);

}

</script>
<?php include("top.inc.php");?>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td id="pageHead"><div id="txtPageHead">Add Product</div></td>
              </tr>
            </table>
            <div align="right"><a href="manage-teacher.php" style="font-size:12px; font-weight:bold; margin-right:15px;">Back to Teacher List</a>&nbsp;</div>
            <form name="form1" method="post" enctype="multipart/form-data">
              <table width="95%"  border="0" align="center" cellpadding="0" cellspacing="0" class="tableForm">
                <tr>
                  <td width="20%" class="tdLabel">&nbsp;</td>
                  <td width="80%" class="tdData" style="padding-left:7px;"><strong><font color="red">
                    <?=display_sess_msg();?>
                    </font></strong></td>
                </tr>
                <tr>
                  <td width="20%" class="tdLabel" style="font-size:12px; padding:7px;">Teacher Name:</td>
                  <td width="80%" class="tdData" style="font-size:12px; padding:7px;"><input name="reg_name" style="width:350px; height:28px;" type="text" id="reg_name"  value="<?=$reg_name?>" class="textfield"  ></td>
                </tr>
                
               
               
                              <tr>
                  <td width="20%" class="tdLabel" style="font-size:12px; padding:7px;">UserID/Email ID:</td>
                  <td width="80%" class="tdData" style="font-size:12px; padding:7px;"><input name="reg_email" style="width:350px; height:28px;" type="text" id="reg_email"  value="<?=$reg_email?>" onBlur="check_user()" class="textfield"  >
<p class="mt5" style="display:none" id="errorMsg">You can use this email id</p>                 
                  
                  </td>
                </tr>
                
                
                 <tr>
                  <td width="20%" class="tdLabel" style="font-size:12px; padding:7px;">Password:</td>
                  <td width="80%" class="tdData" style="font-size:12px; padding:7px;"><input name="reg_pass" style="width:350px; height:28px;" type="text" id="reg_pass"  value="<?=$reg_pass?>" class="textfield"  ></td>
                </tr>

                
                
                
               <?php /*?> <?php if($reg_image){ ?>
                <tr>
                  <td width="177" class="tdLabel" style="font-size:12px; padding:5px;">Current Image  :</td>
                  <td width="721" class="tdData" style="font-size:12px; padding:5px;"><img src="../uploaded_files/<?=$reg_image?>" height="70" width="70"  border="0"> </td>
                </tr>
                <? } ?>
                <tr>
                  <td class="tdLabel" style="font-size:12px; padding:5px;">Teacher Image :</td>
                  <td class="tdData" style="font-size:12px; padding:5px;"><input type="file" name="file" id="file"></td>
                </tr>
               <?php */?>
             
             
              <tr>
                  <td width="20%" class="tdLabel" style="font-size:12px; padding:7px;">Class:</td>
                  <td width="80%" class="tdData" style="font-size:12px; padding:7px;">
<select style="width:350px;height:30px; font-size:13px" name="reg_class" onChange="loadSubjectTeach(this.value)" >
<option value="0"> -- Choose Class -- </option>
<?php
$sql="SELECT * FROM tbl_category WHERE 1 AND category_parent_id='0'";
$dataClass=db_query($sql);
while($recClass=mysqli_fetch_array($dataClass)){
?>
<option value="<?=$recClass['category_id']?>"><?=$recClass['category_name']?></option>
<?php
}
?>

</select>
                  
                 <!-- <input name="reg_class" style="width:350px; height:28px;" type="text" id="reg_class"  value="<?=$reg_class?>" class="textfield"  >-->
                 </td>
                </tr> 
                
                
 <tr>
                  <td width="20%" class="tdLabel" style="font-size:12px; padding:7px;">Subject:</td>
                  <td width="80%" class="tdData" style="font-size:12px; padding:7px;">
<div id="subject-area">
<select style="width:350px;height:30px; font-size:13px" name="subject_id" >
<option value="0"> -- Choose Subject -- </option>
</select>              
</div>    
                  
        <?php /*?> <input name="reg_stream" style="width:350px; height:28px;" type="text" id="reg_stream"  value="<?=$reg_stream?>" class="textfield"  ><?php */?>
         
         </td>
                </tr>                 
                
              
              <tr>
                  <td width="20%" class="tdLabel" style="font-size:12px; padding:7px;">Mobile:</td>
                  <td width="80%" class="tdData" style="font-size:12px; padding:7px;"><input name="reg_mobile_no" style="width:350px; height:28px;" type="text" id="reg_mobile_no"  value="<?=$reg_mobile_no?>" class="textfield"  ></td>
                </tr>
              
              <?php /*?> <tr>
                  <td width="20%" class="tdLabel" style="font-size:12px; padding:7px;">Location:</td>
                  <td width="80%" class="tdData" style="font-size:12px; padding:7px;"><input name="reg_location" style="width:350px; height:28px;" type="text" id="reg_location"  value="<?=$reg_location?>" class="textfield"  ></td>
                </tr>
                
                
                 <tr>
                  <td width="20%" class="tdLabel" style="font-size:12px; padding:7px;">Qualification:</td>
                  <td width="80%" class="tdData" style="font-size:12px; padding:7px;"><input name="reg_qualification" style="width:350px; height:28px;" type="text" id="reg_qualification"  value="<?=$reg_qualification?>" class="textfield"  ></td>
                </tr>
               
               
               
                <tr>
                  <td class="tdLabel" style="font-size:12px; padding:7px;">Profile Description:</td>
                  <td class="tdData" style="font-size:12px; padding:7px;"><p class="fck">
                      <textarea cols="80" id="editor1" name="reg_profile_description" rows="10"><?=$reg_profile_description?>
</textarea>
                      <script>

			// Replace the <textarea id="editor"> with an CKEditor
			// instance, using default configurations.
			CKEDITOR.replace( 'editor1', {
				uiColor: '#ACACAC',
				toolbar: [
					[ 'Bold', 'Italic', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink' ],
					[ 'FontSize', 'TextColor', 'BGColor' ]
				]
			});

		</script>
                    </p></td>
                </tr><?php */?>
                
                <tr>
                  <td class="tdLabel" style="font-size:12px; padding:7px;">Status:</td>
                  <td class="tdData" style="font-size:12px; padding:7px;"><select name="reg_status" style="width:200px; height:26px;">
                      <option value="Active" <?php if($reg_status=='Active'){ ?> selected="selected" <? } ?>>Active</option>
                      <option value="Inactive" <?php if($reg_status=='Inactive'){ ?> selected="selected" <? } ?>>Inactive</option>
                    </select></td>
                </tr>
                <tr>
                  <td class="tdLabel" style="font-size:12px; padding:7px;">&nbsp;</td>
                  <td class="tdData" style="font-size:12px; padding:7px;"><input type="hidden" name="reg_id" value="<?=$reg_id?>" />
                    <input type="image" name="imageField" src="images/buttons/submit.gif" style="width:100px; margin-bottom:25px;" /></td>
                </tr>
              </table>
            </form>
            <? include("bottom.inc.php");?>