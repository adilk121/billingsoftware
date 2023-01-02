<?php
if(!defined('LOCAL_MODE')) {
	die('<span style="font-family: tahoma, arial; font-size: 11px">config file cannot be included directly');
}

if (LOCAL_MODE) {
    // Settings for local midas server do not edit here
	
	// database settings 
    $ARR_CFGS["db_host"] = 'localhost';
	$ARR_CFGS["db_name"] = 'new_cms';
    $ARR_CFGS["db_user"] = 'root';
    $ARR_CFGS["db_pass"] = '';
	define('SITE_SUB_PATH', '/rehan/new-cms');
} else {
    // Server database settings
	$ARR_CFGS["db_host"] = 'localhost';
	$ARR_CFGS["db_name"] = 'webkeyco_billing_software';
    $ARR_CFGS["db_user"] = 'webkeyco_billing';
    $ARR_CFGS["db_pass"] = 'billing_software@123';
	define('SITE_SUB_PATH', '/2.0-demo/billing-software');
}



define('SITE_WS_PATH', 'http://'.$_SERVER['HTTP_HOST'].SITE_SUB_PATH);
define('SITE_FS_PATH', 'http://'.$_SERVER['HTTP_HOST'].SITE_SUB_PATH);
define('THUMB_CACHE_DIR', 'thumb_cache');
define('PLUGINS_DIR', 'includes/plugins');

define('UP_FILES_FS_PATH', SITE_FS_PATH.'/uploaded_files');
define('UP_FILES_WS_PATH', SITE_WS_PATH.'/uploaded_files');

define('DEFAULT_START_YEAR', 2012);
define('DEFAULT_END_YEAR', date('Y')+10);

define('SITE_NAME', 'Astech Media Pvt. Ltd.');
define('TEST_MODE', false);

define('DEF_PAGE_SIZE', 250);
define('ADMIN_DIR', 'admin');
define('ADIM_EMAIL','info@saleshub.com');

define('SITE_MAIN_PATH','http://'.$_SERVER['HTTP_HOST'].'/');
?>