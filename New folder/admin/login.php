<?php
ob_start();
require_once("../includes/dbsmain.inc.php");
include("../site-main-query.php");
if(!empty($_SESSION['sess_admin_login_id'])){
header("location:index.php");
exit;	
}

if(is_post_back()) {
 	$sql="select * from tbl_admin where admin_userid='$_POST[login_id]' and admin_status = 'Active'";
	$result = db_query($sql);
	if ($line_raw = mysqli_fetch_assoc($result)) {
		@extract($line_raw);
		if ($admin_password==$_POST['password']) {
			$_SESSION['sess_admin_login_id'] = $admin_id;
			$_SESSION['user_id']=$admin_id;
			$_SESSION['user_name']=$admin_name;
			$_SESSION['ADMIN_ACCESS'] = $admin_access;
			$_SESSION['sess_admin_type'] = $admin_user_type;
			if($return_page=='') {
				header("location: index.php");
				exit;
			} else {
				header("location: ".$return_page);
				exit;
			}
		} else {
			$_SESSION['msg'] = "Invalid Login ID or Password";
		}
	} else {
		$_SESSION['msg'] = "Invalid Login ID or Password";
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title><?=$compDATA['admin_company_name']?>: Admin Panel</title>

        <!-- Favicon and touch icons -->
        <!--<link rel="shortcut icon" href="../fevicon.png" type="image/x-icon">-->
        <!-- Bootstrap -->
        <link href="assets/bootstrap/css/bootstrapa.min.css" rel="stylesheet" type="text/css"/>
        <!-- Bootstrap rtl -->
        <!--<link href="assets/bootstrap-rtl/bootstrap-rtl.min.css" rel="stylesheet" type="text/css"/>-->
        <!-- Pe-icon-7-stroke -->
        <link href="assets/pe-icon-7-stroke/css/pe-icon-7-stroke.css" rel="stylesheet" type="text/css"/>
        <!-- style css -->
        <link href="assets/dist/css/stylecrm.css" rel="stylesheet" type="text/css"/>
        
        <style>
		div#login-title h2 {
    font-size: 28px;
    color: #000;
    font-weight: 600;
    text-shadow: 2px 2px 4px white;
    background: #ffff;
    padding: 13px;
}
		</style>
        <!-- Theme style rtl -->
        <!--<link href="assets/dist/css/stylecrm-rtl.css" rel="stylesheet" type="text/css"/>-->
    </head>
    <body>
        <!-- Content Wrapper -->
        <div class="login-wrapper">
            <div class="back-link">
                <div class="col-lg-12 text-center" id="login-title"><h2>Welcome to <?=$compDATA['admin_company_name']?> Administrator Panel</h2></div>
            </div>
            <div class="container-center">
            <div class="login-area">
                <div class="panel panel-bd panel-custom">
                    <div class="panel-heading">
                        <div class="view-header">
                            <div class="header-icon">
                                <i class="pe-7s-unlock"></i>
                            </div>
                            <div class="header-title">
                                <h3>Login</h3>
                                <small><strong>Please enter your credentials to login.</strong></small>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <form action="" id="loginForm" method="post" enctype="multipart/form-data" >
                            <div class="form-group">
                                <label class="control-label" for="username">Username</label>
                                <input type="text" placeholder="example@gmail.com" title="Please enter you username"  value="" name="login_id" id="login_id" class="form-control" autocomplete="off">
                                <span class="help-block small">Your unique username</span>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="password">Password</label>
                                <input type="password" title="Please enter your password" placeholder="******"  value="" name="password" id="password" class="form-control">
                                <span class="help-block small">Your login password</span>
                            </div>
                            <div>
                                <button type="submit" class="btn btn-add">Login</button>
                               
                            </div>
                        </form>
                        </div>
                        </div>
                </div>
            </div>
        </div>
        <!-- /.content-wrapper -->
        <!-- jQuery -->
        <script src="assets/plugins/jQuery/jquery-1.12.4.min.js" type="text/javascript"></script>
        <!-- bootstrap js -->
        <script src="assets/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    </body>

</html>