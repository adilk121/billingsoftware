<?
$ARR_VALID_IMG_EXTS = array('jpg', 'jpeg', 'jpe', 'gif', 'png', 'bmp');

$ARR_WEEK_DAYS = array(
'mon' => 'Monday',
'tue' => 'Tuesday',
'wed' => 'Wednesday',
'thu' => 'Thursday',
'fri' => 'Friday',
'sat' => 'Saturday',
'sun' => 'Sunday'
);

$ARR_MONTHS = Array('01'=>'Jan' , '02'=>'Feb' , '03'=>'Mar' , '04'=>'Apr' , '05'=>'May' , '06'=>'Jun' , '07'=>'Jul' , '08'=>'Aug' , '09'=>'Sep' , '10'=>'Oct' , '11'=>'Nov' , '12'=>'Dec');
$ARR_MONTH = Array('1'=>'Jan' , '2'=>'Feb' , '3'=>'Mar' , '4'=>'Apr' , '5'=>'May' , '6'=>'Jun' , '7'=>'Jul' , '8'=>'Aug' , '9'=>'Sep' , '10'=>'Oct' , '11'=>'Nov' , '12'=>'Dec');
$ARR_SOURCES = Array('Just Dial','Sulekha','Website Enquiry','Link Exchange','Reference','Advertisment','Ask Laila','Online Portals','Campain','SMS Campain','Email Campain');
$gender_Arr=array("Male","Female");
$sms_Arr=array("Yes","No");
$viewed_Arr=array("Yes","No");
$Acti_Arr=array("Active","Inactive");
$creadit_Arr=array("Cash","Credit-Card","Cheque");
$mail_Arr =array("info","director","clients","himanshu");
$interested_Arr=array("Interested","Most Interested","Least Interested","Not Interested","Research Required","Wrong Lead","Sale","Given To Others");
$Service_catg_Arr=array("Website Designing","Website Development","Domain Name Registration","Web Hosting/ Web Space","Search Engin Optimization (SEO)","Others");
$option_Arr=array('1'=>'A','2'=>'B','3'=>'C','4'=>'D','5'=>'E');
$marital_status_Arr=array("Single","Married");
if ($handle = opendir(dirname(__FILE__).'/db_arrays')) { 
	while (false !== ($file = readdir($handle))) { 
		if (is_file(dirname(__FILE__).'/db_arrays/'.$file)) { 
			include(dirname(__FILE__).'/db_arrays/'.$file);
		} 
	} 
   closedir($handle); 
}
?>