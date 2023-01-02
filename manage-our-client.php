<?php require_once("header.php");?>
<?php require_once("left-nav.php");?>
<?php require_once ('../includes/photoshop.php');?>
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
<?php
 function getExtension($str) {
         $i = strrpos($str,".");
         if (!$i) { return ""; }
         $l = strlen($str) - $i;
         $ext = substr($str,$i+1,$l);
         return $ext;
 }
 
$catID=$_REQUEST['cat_id'];
$delImageID=$_REQUEST['DelID'];
if(!empty($delImageID)){ 
   $imageToDel=db_scalar("select image_name from  tbl_clients where 1 and image_id='$delImageID'"); 
   @unlink('../our_client/'.$imageToDel);
   $sqldel="delete from tbl_clients where 1 and image_id='$delImageID'";
   db_query($sqldel);
   set_session_msg("Image Deleted Successfully !");
   header("Location: manage-our-client.php");
   exit;
 }
if(is_post_back()) {
if (isset($_POST['submit'])) {
    for ($i = 0; $i < count($_FILES['file']['name']); $i++) {
	     $imgName=$_FILES['file']['name'][$i];
		 $gTitle=$_POST['title'][$i];
		 
		 //**** Change Duplicate Image name Start Here****//
	$uploadedfile = $_FILES['file']['tmp_name'][$i]; 
    $filename = stripslashes($_FILES['file']['name'][$i]); 	
	$extension = getExtension($filename);
	$extension = strtolower($extension);		
	$imgNAME = substr(md5($imgName.time().rand(1,10)),0,14).".".$extension;		
	
		 
		// $ext = substr($imgName, strrpos($imgName, "."));		 
//		 $imageDupli = db_scalar("select count(*) from tbl_category_image where 1 and category_image_name='$imgName'"); 
//		 if($imageDupli > 0){
//		  $imgName = basename($imgName, $ext);
//		  $imgName = basename($imgName, $ext) . rand(1,1000) . $ext;
//		 }else{
//		  $imgName = $imgName;
//		 }
		 //**** Change Duplicate Image name End Here****//
		 
if (move_uploaded_file($_FILES['file']['tmp_name'][$i],"../our_client/$imgNAME")) {


//////////////////////////////// FOR SMALL  PRODUCT THUMB //////////////////////////////
$image = new Zebra_Image(); 
$image->source_path = '../our_client/'.$imgNAME; 
$ext = substr($image->source_path, strrpos($image->source_path, '.') + 1);
// indicate a target image
//$image->target_path = '../our_client/thumb/'.$imgNAME;
// resize
// and if there is an error, show the error message
if (!$image->resize(100, 100, ZEBRA_IMAGE_BOXED, -1)) show_error($image->error, $image->source_path, $image->target_path);
////////////////////////////////////////////////////////////////////////////////////////


			 
			 
			
			    $sql = "insert into tbl_clients set 
				       image_cat_id='$catID',
		           image_status='Active',
						   image_name='$imgNAME',
						   image_title='$gTitle',	
						   image_add_date=now()";
						   db_query($sql);				
            } 
			       
        }
		set_session_msg("Image uploaded successfully !");
		header("Location: manage-our-client.php");
		exit;
    }
 }
?>
<script language="JavaScript" type="text/javascript" src="../includes/general.js"></script>

         <!-- =============================================== -->
         <!-- Content Wrapper. Contains page content -->
         <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
               <div class="header-icon">
                  <i class="fa fa-file-image-o" aria-hidden="true"></i>

               </div>
               <div class="header-title">
                  <h1>Our Client</h1>
                  <small>Our Client List</small>
                  
                  
 
                 
                 
                 

<span class="count-num">Total : <?=db_scalar("SELECT COUNT(image_id) FROM tbl_clients WHERE 1")?></span>
                  
               </div>


           
               
            </section>
            <!-- Main content -->
            <section class="content">
               <div class="row">

<?php if($_SESSION["msg"]!=""){?>               
<div class="alert alert-success alert-dismissable fade in text-center" style="background-color:#dff0d8;border:none; color:#000;margin:10px 0 0 0">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Success!&nbsp;&nbsp;&nbsp;</strong> <?=$_SESSION["msg"]?>
  </div>
<?php 
unset($_SESSION["msg"]);
}?>     




                  <div class="col-sm-12">
                     <div class="panel panel-bd lobidrag" data-edit-title='false' data-close='false' data-reload='false'>
                        
                        
                           
                        
                        
                        <div class="panel-heading">
                           <div class="btn-group" id="buttonexport">
                              <a href="#">
                                 <h4>Our Client Image List</h4>
                              </a>
                           </div>
                        </div>
                        
                        



                        
                        <div class="panel-body">
                       

                       
                           <div class="table-responsive">
<?php			
			  $sql_fetch = db_query("select * from tbl_clients where 1 ");
			  $cntDATA=mysqli_num_rows($sql_fetch);
			   if($cntDATA > 0){	
			   while($DATA = mysqli_fetch_array($sql_fetch)) {
		          @extract($DATA);		 
             ?>
			 <div class="col-lg-2 text-center" style="margin-bottom:10px">
             <img src="../our_client/<?=$DATA['image_name']?>" class="img-thumbnail" style="width:120px; height:120px;" />
            <span style="font-weight:bold;"><?=$DATA['image_title']?></span>
	
    <div class="col-lg-12 text-center" style="margin-top:10px" ><a href="manage-our-client.php?DelID=<?=$DATA['image_id']?>"><i class="fa fa-trash fa-2x" style="color:#F00"></i></a></div>
          </div>		  
			 <? }} ?>
			 <div class="cb"></div>
			 </div>
            <table width="55%"  border="0" align="center" cellpadding="0" cellspacing="0" class="tableForm" style="border:1px solid  #8e32a23b; margin-top:20px; margin-bottom:10px;">
              <tr>
                <td class="tdLabel" style="padding:8px;">
				<div id="maindiv">
                    <div id="formdiv">
                      <form enctype="multipart/form-data" action="" method="post">
                        <div id="filediv">
                          <input name="file[]" type="file" id="file"/>
                        </div>
                        <br/>
                        <input type="button" id="add_more" class="upload" value="Add More Files"/>
                        <input type="submit" value="Upload File" name="submit" id="upload" class="upload"/>
                      </form>
                      <br/>
                    </div>
                  </div></td>
              </tr>
            </table>
                              </table>
                              

                                             
                              
                           </div>

                                  
                           
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
<script src="scriptari.js"></script>