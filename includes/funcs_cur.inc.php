<?
function set_session_msg($msg)
{
 $_SESSION['sess_msg']=$msg;
}

function display_sess_msg()
{
 if($_SESSION['sess_msg']!='')  {
  echo '<span class="redcolor">';
  echo $_SESSION['sess_msg'];
  unset($_SESSION['sess_msg']) ; 
  echo "</span>";
   }

}


function ami_crete_url($val)
{
$output = preg_replace('!\s+!', ' ', $val);
 $vall=strtolower($output);
 $a=str_replace(",","",rtrim(ltrim($vall)));
 $b=str_replace("&"," ",$a);
 $c=str_replace("&amp;"," ",$b);
 $d=str_replace(" & "," ",$c);
 $e=str_replace(" &amp; "," ",$d);
 $f=str_replace("amp;"," ",$e);
 $g=str_replace(".","",$f);
 $h=str_replace("%"," ",$g);
 $i=str_replace("_"," ",$h);
 $j=str_replace("("," ",$i);
 $k=str_replace("."," ",$j);
 $l=str_replace(")"," ",$k);
 $m=str_replace("|"," ",$l);
 $n=str_replace("quot;","",$m);
 $o=str_replace('"',"",$n);
 $p=str_replace("/"," ",$o);
 $q=str_replace("\\","",$p);
 $r=str_replace("'","",$q);
 $s=str_replace("`"," ",$r); 
 $t=str_replace("["," ",$s);
 $u=str_replace("]"," ",$t);
 $v=str_replace("{"," ",$u);
 $w=str_replace("}"," ",$v);
 $x=str_replace("="," ",$w);
 $y=str_replace(" ","-",$x);
 $z = strtolower(preg_replace('/-{2,}/','-',$y));
 $curr_val = trim($z, "-");
 return $curr_val;
}



function check_access($acc,$check)
{
$value=explode(",",$acc);
$j=count($value);
for($i=0;$i<$j;$i++)
{
if($value[$i]==$check)
{
return "true";
break;
}
}
}

function getFromdatabasevalue($searchID,$field_name, $tablename, $pry_key){

	$showval=db_scalar("select $field_name from $tablename where $pry_key='$searchID'");

	return $showval;

}

function validate_form()

{

	return ' onsubmit="return validateForm(this,0,0,0,1,8);" ';

}



function protect_admin_page() {

	$cur_page = basename($_SERVER['PHP_SELF']);

	$arr=array('login.php','proposal.php','proposal1.php','proposal2.php','proposal3.php','dialer_req.php','dialer_resp.php','sla.php','invoice_format.php');

	if(in_array("$cur_page",$arr)){

		//no action	

	}

	else{

		if ($_SESSION['sess_admin_login_id']=='') {

			header('Location: login.php');

			exit;

		}

	}

}

function protect_member_page() {

	$cur_page = basename($_SERVER['PHP_SELF']);

	//echo "<br>cur_page: $cur_page";

	if($cur_page != 'login.php') {

		if ($_SESSION['sess_user_id']=='') {

			header('Location: login.php');

			exit;

		}

	}

}

function get_country_from_ip(){

	require_once SITE_FS_PATH."/Net/GeoIP.php";

	$geoip = Net_GeoIP::getInstance(SITE_FS_PATH."/Net/GeoIP.dat");

	try{

		$user_ip = $_SERVER['REMOTE_ADDR'];

		//$user_ip_country = $geoip->lookupCountryName($user_ip);

		$user_ip_country = $geoip->lookupRegion($user_ip);

	}

	catch (Exception $e){

		$user_ip = "Not Found";

		$email_body ="Dear Admin, <br><br>Location for IP Address ".$_SERVER['REMOTE_ADDR']." Not Found";

		send_email(ADMIN_EMAIL, $email_body, ADMIN_EMAIL, 'text/html', 'IP Location Not Found');

		// Handle exception

	}

	return $user_ip_country;

}

function get_city_from_ip(){

	include_once(SITE_FS_PATH."/Net/geoipcity.inc");

	include_once(SITE_FS_PATH."/Net/geoipregionvars.php");

	$gi = geoip_open(SITE_FS_PATH."/Net/GeoIPCity.dat",GEOIP_STANDARD);

	try{

		$user_ip = $_SERVER['REMOTE_ADDR'];

		$record = geoip_record_by_addr($gi, $user_ip);

		$cont =geoip_country_name_by_addr($gi, $user_ip);

		$loc_arr=array($record->city, $record->region, $record->latitude, $record->longitude, $cont);

		geoip_close($gi);

	}

	catch (Exception $e){

		$user_ip = "Not Found";

		$email_body ="Dear Admin, <br><br>Location for IP Address ".$_SERVER['REMOTE_ADDR']." Not Found";

		send_email(ADMIN_EMAIL, $email_body, ADMIN_EMAIL, 'text/html', 'IP Location Not Found');

	}

	return $loc_arr;

}

function status_dropdown($name, $sel_value, $extra='', $choose_one=''){

	$arr = array( "Active" => 'Active', 'Inactive' => 'Inactive');

	return array_dropdown($arr, $sel_value, $name, $extra='', $choose_one='');

}

function yes_no_dropdown($name, $sel_value, $extra='', $choose_one=''){

	$arr = array( "Yes" => 'Yes', 'No' => 'No');

	return array_dropdown($arr, $sel_value, $name, $extra='', $choose_one='');

}

function get_banner($position, $no_of_ad, $width="", $height=""){

	$date_today=date('Y-m-d');

	$sql = "SELECT * FROM pof_banner where bnr_position='$position' and bnr_expiry >'$date_today' order by rand() limit 0, $no_of_ad";

	$res = db_query($sql);

	$result = mysql_fetch_array($res);

	if($result['bnr_type']=='Code'){

		$add_query=$result['bnr_google_code'];

	}

	else{

		if($height) $height_text='height="'.$height.'"';

		if($width) $width_text='width="'.$width.'"';

		if($bnr_href!=''){

			$url_value=str_replace("http://","",$result['bnr_href']);

			$new_url="http://".$url_value;

			$add_query='<a href="'.$new_url.'"><img src="'.show_thumb(UP_FILES_WS_PATH.'/banner/'.$result[bnr_image], $width, $height,"crop").'" '. $width_text.' '. $height_text.' /></a>';

		}

		else{

			$add_query='<img src="'.show_thumb(UP_FILES_WS_PATH.'/banner/'.$result[bnr_image], $width, $height, "crop").'" '. $height_text.' '. $width_text.'/>';

		}

	}

	return $add_query;

}

function FindStateID($stateName){

	$stateName1=trim($stateName);

	$sres=mysql_fetch_array(db_query("select state_id from pof_states where state_name='$stateName1'"));

	return $sres[state_id];

}

function FindStateIDByCode($statecode){

	$statecode1=trim($statecode);

	$sres=mysql_fetch_array(db_query("select state_id from pof_states where state_code='$statecode1'"));

	return $sres[0];

}

function FindStateName($stateID){

	$sres=mysql_fetch_array(db_query("select state_name from pof_states where state_id='$stateID'"));

	return $sres[0];

}

function FindStateCode($stateID){

	$sres=mysql_fetch_array(db_query("select state_code from pof_states where state_id='$stateID'"));

	return $sres[0];

}

function FindCountryName($contID){

	$sres=mysql_fetch_array(db_query("select countries_name from ques_countries where countries_id='$contID'"));

	return $sres[countries_name];

}

function user_online($user_id){

    $last=db_scalar("select st_lastvisit_datetime from mb_user_settings where st_user_id='$user_id' and st_login_status='Yes'");

	$diff_date=db_scalar("select DATE_SUB(now(), INTERVAL 24 MINUTE)");

	 if($diff_date>$last){

		return false;

	 }else{

		return true;

	 }

 }



function user_total_online_count(){

		 $cnt=db_scalar("select count(*) as `cnt` from mb_users inner join mb_user_settings on mb_users.user_id=mb_user_settings.st_user_id where 1 

	and mb_user_settings.st_login_status='Yes' and (DATE_SUB(now(), INTERVAL 24 MINUTE) < mb_user_settings.st_lastvisit_datetime) and user_delete_status!='delete' and user_status='Active'");

  	 return $cnt;

 }

 function calculate_datediff($date2,$date1){

 	$date2=strtotime($date2);

	$date1=strtotime($date1);

	$dateDiff = $date2 - $date1;

	$dateDiff = abs($dateDiff);

	$fullDays = floor($dateDiff/(60*60*24));

	$fullHours = floor(($dateDiff-($fullDays*60*60*24))/(60*60));

	$fullMinutes = floor(($dateDiff-($fullDays*60*60*24)-($fullHours*60*60))/60);

	$ret = " ago";

	

	if($fullMinutes!=""){

		$ret = $fullMinutes." mins".$ret;

	}

	if($fullHours!=""){

		$ret = $fullHours." hours, ".$ret;

	}

	if($fullDays!=""){

		$ret =  $fullDays." days, ".$ret;

	}

	if($ret!=" ago"){

		return $ret;

	}

}

function date_datediff($date2,$date1){

 	$date2=strtotime($date2);

	$date1=strtotime($date1);

	$dateDiff = $date2 - $date1;

	$dateDiff = abs($dateDiff);

	$fullDays = floor($dateDiff/(60*60*24));

	$fullHours = floor(($dateDiff-($fullDays*60*60*24))/(60*60));

	$fullMinutes = floor(($dateDiff-($fullDays*60*60*24)-($fullHours*60*60))/60);

	$ret = " ago";

	if($fullMinutes!=""){

		$arr['minute'] = $fullMinutes;

	}

	if($fullHours!=""){

		$arr['hour']= $fullHours;

	}

	if($fullDays!=""){

		$arr['day'] =  $fullDays;

	}

	return $arr['hour'].".".$arr['minute'];

}

function send_email($user_email, $email_body, $from_string, $mail_type, $subject,$attachements=''){

	if($user_email == ''){

		echo "Invalid Email Address";

	}

	  	$email_body = str_replace("{sitepath}",SITE_WS_PATH,$email_body);  

	

		if(strpos($mail_type,'plain')){

			$html = false;

		}else{

			$html = true;

		}

		$mailer = new PHPMailer();

		if($from_string == ''){

			$from_string = ADMIN_EMAIL;

		}

		$mailer->From=$from_string;

		$mailer->FromName = SITE_NAME;

		$mailer->AddAddress($user_email);

		if(LOCAL_MODE){

			$mailer->Mailer='mail';

		}else{

			$mailer->Mailer='mail';

		}

		$mailer->IsHTML($html);

		$mailer->Subject=$subject;

		$mailer->Body=$email_body;

		if(is_array($attachements)){

			foreach($attachements as $file_name){

				$mailer->AddAttachment($file_name, "Attachement.".file_ext($file_name)); 

			} 

		}elseif($attachements!=''){

			//echo "hellow";

			$mailer->AddAttachment($attachements, "Attachement.".file_ext($attachements)); 

		}

		

		if(!$mailer->Send()){

			  echo "Problem while sending SMTP mail. <p>";

			  echo "<br>Mailer Error: " . $mailer->ErrorInfo;

		}else{

			@unlink($attachements);

			

		}

		return;

}



function GetAge($Birthdate)

{

        // Explode the date into meaningful variables

        list($BirthYear,$BirthMonth,$BirthDay) = explode("-", $Birthdate);

        // Find the differences

        $YearDiff = date("Y") - $BirthYear;

        $MonthDiff = date("m") - $BirthMonth;

        $DayDiff = date("d") - $BirthDay;

        // If the birthday has not occured this year

        if ($DayDiff < 0 || $MonthDiff < 0)

          $YearDiff--;

        return $YearDiff;

}



function eligible_to_send_msg($searched_person_id,$searching_person_id){

/*searched person detail*/

	$searched_person_result=db_query("SELECT * FROM pof_mail_settings WHERE set_user_id='$searched_person_id'");

	$searched_person_detail = mysql_fetch_array($searched_person_result);

	

	$block_query=db_scalar("select group_concat(block_block_id) from ques_user_block where block_user_id='$searched_person_id'");

	if($block_query!=''){

		$blocked_user=explode(',',$block_query);

	}

/*searching person detail*/

	$searching_person_result=db_query("SELECT * FROM ques_user WHERE user_id='$_SESSION[sess_user_id]'");

	$searching_person_detail = mysql_fetch_array($searching_person_result);

	$searching_person_result2=db_query("SELECT * FROM pof_relation_type WHERE rel_user_id='$_SESSION[sess_user_id]'");

	$searching_person_detail2 = mysql_fetch_array($searching_person_result2);

	

	if(($block_query!='') and (in_array($searching_person_id,$blocked_user))){

		return false;

	}

	if($searched_person_detail['set_mail_gender']!='Other'){

		if($searched_person_detail['set_mail_gender']!=$searching_person_detail['user_gender']){

			return false;

		}

	}elseif($searched_person_detail['set_min_age']!='' || $searched_person_detail['set_max_age']!=''){

		if($searched_person_detail['set_min_age']>GetAge($searching_person_detail['user_DOB']) || $searched_person_detail['set_max_age']<GetAge($searching_person_result['user_DOB'])){

			return false;

		}

	}elseif($searched_person_detail['set_country_id']!=''){

		if($searched_person_detail['set_country_id']!=$searching_person_detail['user_country_id']){

			return false;

		}

	}elseif($searched_person_detail['set_chat']=='Yes'){

		if($searched_person_detail['set_chat']==$searching_person_detail2['rel_chat']){

			return false;

		}

	}elseif($searched_person_detail['set_dating']=='Yes'){

		if($searched_person_detail['set_dating']==$searching_person_detail2['rel_dating']){

			return false;

		}

	}elseif($searched_person_detail['set_friends']=='Yes'){

		if($searched_person_detail['set_friends']==$searching_person_detail2['rel_friends']){

			return false;

		}

	}elseif($searched_person_detail['set_activity_partner']=='Yes'){

		if($searched_person_detail['set_activity_partner']==$searching_person_detail2['rel_activity_partner']){

			return false;

		}

	}elseif($searched_person_detail['set_short_term']=='Yes'){

		if($searched_person_detail['set_short_term']==$searching_person_detail2['rel_short_term']){

			return false;

		}

	}elseif($searched_person_detail['set_intimate_encounter']=='Yes'){

		if($searched_person_detail['set_intimate_encounter']==$searching_person_detail2['rel_intimate_encounter']){

			return false;

		}

	}elseif($searched_person_detail['set_married']=='Yes'){

		$marital_status=($searched_person_detail['set_married']=='Yes'?'Single':'Married');

		if($marital_status!=$searching_person_detail['user_marital_status']){

			return false;

		}

	}elseif($searched_person_detail['set_drugs']=='Yes'){

		if($searching_person_detail['user_do_drugs']!='No'){

			return false;

		}

	}elseif($searched_person_detail['set_smoke']=='Yes'){

		if($searching_person_detail['user_smoke']!='No'){

			return false;

		}

	}elseif($searched_person_detail['set_first_noimage']=='No'){

		if($searching_person_detail['user_photo']==''){

			return false;

		}

	}

	return true;

}

function  chk_date_fromat($show_date){

	if($date=='0000-00-00'){

	  $show_date="";	

	}else{

	  $show_date=date('F dS,Y',strtotime($show_date));	

	}

return 	$show_date;

}



function show_error($error_array)

{

	if(is_array($error_array) && count($error_array)){

    	foreach($error_array as $error){

	            echo "<b>$error</b>";	

				unset($error);

		}

   }

}

function remove_array_empty_values($array, $remove_null_number = true){

  $new_array = array();

 

    $null_exceptions = array();

 

   foreach ($array as $key => $value)

    {

        $value = trim($value);

 

        if($remove_null_number)

        {

            $null_exceptions[] = '0';

        }

 

        if(!in_array($value, $null_exceptions) && $value != "")

        {

            $new_array[] = $value;

        }

    }

    return $new_array;

}
function show_staticdata($id)
{
$sql_page="select * from tbl_static_pages where pg_id='$id' and pg_status='Active'";
$res_page=db_query($sql_page);
return mysql_fetch_array($res_page);
}

//Tree Parent Search with link..
function parent_search($slno, $table_name, $name_field, $primery_field, $search_field,$link,$html){ //for searching parent.
	$db=mysql_fetch_array(db_query("select * from $table_name where $primery_field='$slno'"));
	echo mysql_error();
	if($db[$search_field]!=0){
		$arr[]=$db[$name_field]."~".$db[$search_field];
		$slno=$db[$search_field];
		parent_search($slno, $table_name, $name_field, $primery_field, $search_field,$link, $html);
	}
	else{
		$slno=$db[$search_field];
		$arr[]=$db[$name_field]."~".$db[$primery_field];
	}
	$arr1=array_reverse($arr);
	for($i=0;$i<count($arr1);$i++){
		$varr=explode("~", $arr1[$i]);
		if("$varr[0]" !=""){
			if($html=="html"){
				$name=strtolower($db[$name_field]);
				$file_name=str_replace(" ","-",$name).".php";
				echo "&nbsp;<a href=\"$file_name\">$varr[0]</a> >>&nbsp;";
			}
			else{
				if(strlen($link)){
					$href="$link?id=$varr[1]";
					echo "&nbsp;<a href=\"$href\"><strong>$varr[0]</strong></a> >>&nbsp;";
				}
				else{
					echo "&nbsp;<strong>$varr[0]</strong>&nbsp;>>&nbsp;";
				}
			}
		}
		else{
			echo "&nbsp;";
		}
	}
}

?>