<?php
//load the database configuration file
include 'dbConfig.php';

$cat=$_REQUEST['cat'];

if(!empty($_GET['status'])){
    switch($_GET['status']){
        case 'succ':
            $statusMsgClass = 'alert-success';
            $statusMsg = 'Stock data has been inserted successfully.';
            break;
        case 'err':
            $statusMsgClass = 'alert-danger';
            $statusMsg = 'Some problem occurred, please try again.';
            break;
        case 'invalid_file':
            $statusMsgClass = 'alert-danger';
            $statusMsg = 'Please upload a valid CSV file.';
            break;
        default:
            $statusMsgClass = '';
            $statusMsg = '';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Import CSV File : ThariChoice</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <style type="text/css">
    .panel-heading a{float: right;}
    #importFrm{margin-bottom: 20px;display: none;}
    #importFrm input[type=file] {display: inline;}
  </style>
</head>
<body>

<div class="container">
    <h2>Import CSV File : ThariChoice</h2>
    <?php if(!empty($statusMsg)){
        echo '<div class="alert '.$statusMsgClass.'">'.$statusMsg.'</div>';
    } ?>
    
<?php
$query = $db->query("SELECT * FROM  tbl_category WHERE category_is_product='Yes' AND category_for_stock='Yes' ORDER BY category_id DESC");
?>    
    <div class="panel panel-default">
        <div class="panel-heading">
            Stock list
            
            

            <a href="javascript:void(0);" class="btn btn-success" style="margin:-6px 0 0 0;font-weight:600" onclick="$('#importFrm').slideToggle();">Import Stock</a>
            
                        
                        
        </div>
        <div class="panel-body">
            <form action="importData.php" method="post" enctype="multipart/form-data" id="importFrm">
                <input type="file" name="file" />
                <input type="hidden" name="cat" value="<?=$cat?>" />
                <input type="submit" class="btn btn-primary" name="importSubmit" value="IMPORT">
            </form>
            <table class="table table-bordered">
                <thead>
                    <tr>
                      <th  style="text-align:center">SN.</th>
                      <th>Item Name</th>
                      <th>MRP</th>
                      <th>Sell Price</th>
                      <th>Color</th>
                      <th>Size</th>
                      <th>Status</th>
                      <th>Quantity</th>            
                      <th>Image IDs</th>                      
                    </tr>
                </thead>
                <tbody>
<?php                    
if($query->num_rows > 0){ 
$sn=0;
while($row = $query->fetch_assoc()){


$catID=$row['category_parent_id'];
$query2 = $db->query("SELECT category_name FROM  tbl_category WHERE category_id='$catID'");
$row2 = $query2->fetch_row();
$catName=$row2[0];



$query3 = $db->query("SELECT category_parent_id FROM  tbl_category WHERE category_id='$catID'");
$row3 = $query3->fetch_row();
$catIdMain=$row3[0];


if($catIdMain==$cat){	
$sn++;
?>

<tr>
<td align="center"><?=$sn?></td>
<td><?=$catName?></td>
<td><?php echo $row['category_real_price']; ?></td>
<td><?php echo $row['category_discount_price']; ?></td>
<td><?php echo $row['category_color']; ?></td>
<td><?php echo $row['category_size']; ?></td>					  
<td><?php echo $row['category_status']; ?></td>
<td><?php echo $row['category_qnty']; ?></td>                      
<td><?php echo $row['category_image_ids']; ?></td>
</tr>
<?php 

}
} 
?>
<tr><td colspan="9" style="text-align:center;font-size:16px; font-weight:600;padding:10px;background-color:#efecec"><span style="margin-right:20px"><strong>Total :</strong> <?=$sn?></span></td></tr>
<?php
}else{ ?>
<tr><td colspan="5">No stock found.....</td></tr>
<?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>