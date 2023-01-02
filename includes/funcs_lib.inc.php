<?php 
function connect_db(){
	global $ARR_CFGS;
	if (!isset($GLOBALS['dbcon'])){
		$GLOBALS['dbcon'] =	mysqli_connect($ARR_CFGS["db_host"], $ARR_CFGS["db_user"], $ARR_CFGS["db_pass"]);
		mysqli_select_db($GLOBALS['dbcon'],$ARR_CFGS["db_name"]) or die("Could not connect to database. Please check configuration and ensure MySQL is running.");
	}
}
function db_query($sql, $dbcon2 = null){
	if($dbcon2==''){
		if(!isset($GLOBALS['dbcon'])) {
			connect_db();
		}
		$dbcon2	= $GLOBALS['dbcon'];
	}
	$time_before_sql = checkpoint();
	$result	= mysqli_query($dbcon2,$sql) or	die(db_error($sql));
	return $result;
}
function db_scalar($sql, $dbcon2 = null){
	if($dbcon2==''){
		if(!isset($GLOBALS['dbcon'])) {
			connect_db();
		}
		$dbcon2	= $GLOBALS['dbcon'];
	}
	$result	= db_query($sql, $dbcon2);
	if ($line =	mysqli_fetch_array($result))	{
		$response =	$line[0];
	}
	return $response;
}
function db_error($sql){
	if(LOCAL_MODE){
		echo "<div style='font-family: tahoma; font-size: 11px; color: #333333'><br>".mysqli_error($GLOBALS['dbcon'])."<br>";
		//print_error();
		echo "<br>sql: $sql";
		echo "</div>";
	}
	else{
		echo "<div style='font-family: tahoma; font-size: 11px; color: #333333'><br>".mysqli_error($GLOBALS['dbcon'])."<br>";
		//print_error();
		echo "<br>sql: $sql";
		echo "</div>";
		/*$file = SITE_FS_PATH.'/sql_opt/errors.txt';
		$handle = fopen($file, 'a');
		fwrite($handle, "\r\n".$_SERVER['PHP_SELF']."\t".preg_replace("/\s/m", " ", $sql)."\t".date("Y-m-d G:i:s",time()) ."\t".session_id() );
		fclose($handle);*/
		//die("Internal Server Error");
	}
}
/*function print_error(){
	$debug_backtrace = debug_backtrace();
	for($i = count($debug_backtrace)-1;$i > 0; $i--){
		$error = $debug_backtrace[$i];
		echo '<div style="background-color:#ffc;padding:2px;">';
		echo '<span ><b>File:</b> '.str_replace(SITE_FS_PATH, '', str_replace('\\','/', $error['file'])).'</span>';
		echo ", <b>Line:</b> ".$error['line']."";
		echo ", <b>Function:</b> ".$error['function']."";
		echo "</div>";
	}
}*/
function mysqli_time($hour, $minute,	$ampm){
	if ($ampm == 'PM' && $hour != '12')	{
		$hour += 12;
	}
	if ($ampm == 'AM' && $hour == '12')	{
		$hour =	'00';
	}
	$mysqli_time	= $hour	. ':' .	$minute	. ':00';
	return $mysqli_time;
}
function price_format($price){
	if ($price != '' &&	$price != '0') {
		$price = number_format($price, 2);
		return '$'.$price;
	}
}
function midas_date_format($date){
	if(strlen($date) >= 10){
		if ($date == '0000-00-00 00:00:00' || $date	== '0000-00-00') {
			return '';
		}
		$mktime	= mktime(0,	0, 0, substr($date,	5, 2), substr($date, 8,	2),	substr($date, 0, 4));
		return date("M j, Y", $mktime);
	}
	else{
		return $s;
	}
}
function datetime_format($date){
	global $arr_month_short;
	if(strlen($date) >= 10){
		if ($date == '0000-00-00 00:00:00' || $date	== '0000-00-00') {
			return '';
		}
		$mktime	= mktime(substr($date, 11, 2), substr($date, 14, 2), substr($date, 17, 2),substr($date,	5, 2), substr($date, 8,	2),	substr($date, 0, 4));
		return date("M j, Y h:i A ", $mktime);
	}
	else{
		return $s;
	}
}
function time_format($time){
	if(strlen($time) >= 5){
		$hour =	substr($time, 0, 2);
		$hour =	str_pad($hour, 2, "0", STR_PAD_LEFT);
		return $hour . ':' . substr($time, 3, 2) . ' ' . $ampm;
	}
	else{
		return $s;
	}
}
function ms_print_r($var){
	echo "<textarea rows='10' cols='148' style='font-size: 11px; font-family: tahoma'>";
	print_r($var);
	echo "</textarea>";
}
function ms_form_value($var){
	return is_array($var) ? array_map('ms_form_value', $var) : midas_html_chars(trim($var));
}
function ms_escape_string($var){
	return is_array($var) ? array_map('ms_escape_string', $var) : mysqli_escape_string(trim($var));
}
function ms_display_value($var){
	return is_array($var) ? array_map('ms_display_value', $var) : nl2br(midas_html_chars(trim($var)));
}
function ms_stripslashes($var){
	return is_array($var) ? array_map('ms_stripslashes', $var) : stripslashes(trim($var));
}
function ms_addslashes($var){
	return is_array($var) ? array_map('ms_addslashes', $var) : addslashes(trim($var));
}
function ms_trim($var){
	return is_array($var) ? array_map('ms_trim', $var) : trim($var);
}
function is_image_valid($file_name){
	global $ARR_VALID_IMG_EXTS;
	$ext = file_ext($file_name);
	if(in_array($ext, $ARR_VALID_IMG_EXTS)){
		return true;
	}
	else{
		return false;
	}
}
function getmicrotime(){
	list($usec,	$sec) =	explode(" ", microtime());
	return ((float)$usec + (float)$sec);
}
function file_ext($file_name){
	$path_parts = pathinfo($file_name);
	$ext = strtolower($path_parts["extension"]);
	return $ext;
}
function blank_filter($var){
	$var = trim($var);
	return ($var != '' && $var != '&nbsp;');
}
function apply_filter($sql,	$field,	$field_filter, $column){
	if($field!=''){
		if($field_filter == "=" || $field_filter == ""){
			$sql = $sql	. "	and	$column	= '$field' ";
		}
		else if($field_filter =="like"){
			$sql = $sql	. "	and	$column	like '%$field%'	";
		}
		else if($field_filter =="starts_with"){
			$sql = $sql	. "	and	$column	like '$field%' ";
		}
		else if($field_filter =="ends_with"){
			$sql = $sql	. "	and	$column	like '%$field' ";
		}
		else if ($field_filter =="not_contains"){
			$sql = $sql	. "	and	$column	not	like '%$field%'	";
		}
		else if ($field_filter == ">"){
			$sql = $sql . " and $column > '$field' ";
		}
		else if ($field_filter == "<"){
			$sql = $sql . " and $column < '$field' ";
		}
		else if ($field_filter ==	"!="){
			$sql = $sql	. "	and	$column	!= '$field'	";
		}
	}
	return $sql;
}
function filter_dropdown($name	= 'filter',	$sel_value){
	$arr = array( "like" => 'Contains', '=' => 'Is', "starts_with" => 'Starts with', "ends_with"	=> 'Ends with', "!=" => 'Is not' , "not_contains" => 'Not contains');
	return array_dropdown($arr, $sel_value, $name);
}
function make_url($url){
	$parsed_url	= parse_url($url);
	if ($parsed_url['scheme'] == '') {
		return 'http://' . $url;
	}
	else {
		return $url;
	}
}
function ms_mail($to, $subject, $message, $arr_headers= array()){
	$add_query_headers = '';
	foreach($arr_headers as $name=>$value){
		$add_query_headers .= "$name: $value\n";
	}
	@mail($to, $subject, $message, $add_query_headers);
	return true;
}
function date_to_mysql($date){
	list($month, $day, $year) = explode('/', $date);
	return "$year-$month-$day";
}
function export_delimited_file($sql, $arr_columns, $file_name='', $arr_substitutes='', $arr_tpls=''){
	if($file_name=='') {
		$file_name = time().'.txt';
	}
	header("Content-type: application/txt");
	header("Content-Disposition: attachment; filename=$file_name");
	$arr_db_cols= array_keys($arr_columns);
	$arr_headers= array_values($arr_columns);
	$add_query_columns = implode(',', $arr_db_cols);
	$sql= "select ".$add_query_columns." $sql" ;
	
	$result= db_query($sql);
	$num_cols = count($arr_columns);
	foreach($arr_headers as $header){
		echo $header."\t";
	}
	while($line=mysqli_fetch_array($result, mysqli_ASSOC)){
		echo "\r\n";
		foreach($line as $key => $value){
			$value=str_replace("\n","",$value);
			$value=str_replace("\r","",$value);
			$value=str_replace("\t","",$value);
			if(is_array($arr_substitutes[$key])){
				$value = $arr_substitutes[$key][$value];
			}
			if(isset($arr_tpls[$key])){
				$code = str_replace('{1}', $value, $arr_tpls[$key]);
				eval ("\$value = $code;");
			}
			echo $value."\t";
		}
	}
}
function checkpoint($from_start = false){
	global $PREV_CHECKPOINT;
	if($PREV_CHECKPOINT==''){
		$PREV_CHECKPOINT = SCRIPT_START_TIME;
	}
	$cur_microtime = getmicrotime();	
	if($from_start){
		return $cur_microtime - SCRIPT_START_TIME;
	}
	else{
		$time_taken = $cur_microtime - $PREV_CHECKPOINT;
		$PREV_CHECKPOINT = $cur_microtime;
		return $time_taken;
	}
}
function readable_col_name($add_query){
	return ucwords( str_replace('_', ' ', strtolower($add_query) ) );
}
function ms_echo($add_query){
	if(LOCAL_MODE){
		echo($add_query);
	}
}


function array_dropdown( $arr, $sel_value='', $name='', $extra='', $choose_one='', $arr_skip= array()){
	$combo="<select name='$name' id='$name' $extra >";
	if($choose_one!=''){
		$combo.="<option value=\"\">$choose_one</option>";
	}
	foreach($arr as $key => $value){
		if(is_array($arr_skip) && in_array($key, $arr_skip)){
			continue;
		}
		$combo.='<option value="'.midas_html_chars($key).'"';
		if(is_array($sel_value)){
			if(in_array($key, $sel_value) || in_array(midas_html_chars($key), $sel_value)){
				$combo.=" selected ";
			}
		}
		else{
			if($sel_value==$key || $sel_value==midas_html_chars($key)){
				$combo.=" selected ";
			}
		}
		$combo.=" >$value</option>";
	}
	$combo.=" </select>";
	return $combo;
}
function make_checkboxes($arr_tmp, $checkname, $checksel = '', $cols,	$missit, $style	= '', $tableattr = ''){
	if($style != ""){
		$style = "class='" . $style	. "'";
	}
	$colwidth =	100	/ $cols;
	$colwidth =	round($colwidth, 2);
	$j = 0;
	if(is_array($arr_tmp) && count($arr_tmp)) {
		foreach($arr_tmp as	$key =>	$value)	{
			$tochecked = "";
			if (is_array($checksel)	&& in_array($key, $checksel)) {
				$tochecked = "checked";
			}
			if ($key !=	$missit) {
				if ($value != "") {
					if ($j == 0) {
						$checkstr .= "<table $tableattr><tr>\n";
					} else if (($j % $cols)	== 0) {
						$checkstr .= "</tr><tr>\n";
					}
					$checkstr .= "<td valign=top><INPUT TYPE='checkbox' $javascript	 NAME='$checkname" . '[]' .	"' value='$key'	$tochecked ></td><td $style nowrap> $value	</td>\n";
					$j++;
				}
			}
		}
		$j--;
		for($x = $j	% $cols;$x < 4;$x++) {
			if ($x != 3) {
				$checkstr .= "<td>&nbsp;</td>\n";
			} else {
				$checkstr .= "<td>&nbsp;</td></tr>\n";
			}
		}
		$checkstr .= "</table>";
	}
	return $checkstr;
}
function make_radios($arr_tmp, $checkname, $checksel = '', $cols,	$missit, $style	= '', $tableattr = ''){
	if ($style != "") {
		$style = "class='" . $style	. "'";
	}
	$colwidth =	100	/ $cols;
	$colwidth =	round($colwidth, 2);
	$j = 1;
	foreach($arr_tmp as	$key =>	$value)	{
		$tochecked = "";
		if ($checksel == $key) {
			$tochecked = "checked";
		}
		if ($key !=	$missit) {
			if ($value != "") {
				if ($j == 1) {
					$checkstr .= "<table $tableattr><tr>\n";
				} else if (($j % $cols)	== 1) {
					$checkstr .= "</tr><tr>\n";
				}
				$checkstr .= "<td width='" . $colwidth . "%' $style	valign=top><INPUT TYPE='radio' $javascript	 NAME='$checkname' value='$key'	$tochecked	   > $value	</td>\n";
				$j++;
			}
		}
	}
	$j--;
	for($x = $j	% $cols;$x < 4;$x++) {
		if ($x != 3) {
			$checkstr .= "<td>&nbsp;</td>\n";
		} else {
			$checkstr .= "<td>&nbsp;</td></tr>\n";
		}
	}
	$checkstr .= "</table>";
	return $checkstr;
}
function date_dropdown($pre, $selected_date = '', $start_year='', $end_year = '', $sort = 'asc'){
	$cur_date =	date("Y-m-d");
	$cur_date_day =	substr($cur_date, 8, 2);
	$cur_date_month	= substr($cur_date,	5, 2);
	$cur_date_year = substr($cur_date, 0, 4);

	if ($selected_date != '') {
		$selected_date_day = substr($selected_date,	8, 2);
		$selected_date_month = substr($selected_date, 5, 2);
		$selected_date_year	= substr($selected_date, 0,	4);
	}
	$date_dropdown	.= month_dropdown($pre	. "month", $selected_date_month);
	$date_dropdown	.= day_dropdown($pre .	"day", $selected_date_day);
	$date_dropdown	.= year_dropdown($pre . "year", $selected_date_year, $start_year,	$end_year,	$sort);
	return $date_dropdown;
}
function month_dropdown($name,	$selected_date_month = '', $extra=''){
	global $ARR_MONTHS;
	$date_dropdown	= "	<select	name='$name' $extra> <option value='0'>Month</option>";
	$i = 0;
	foreach ($ARR_MONTHS as $key => $value){
		$date_dropdown	.= " <option ";
		if($key == $selected_date_month){
			$date_dropdown	.= " selected ";
		}
		$date_dropdown	.= " value='" .str_pad($key, 2, "0",	STR_PAD_LEFT) .	"'>$value</option>";
	}
	$date_dropdown	.= "</select>";
	return $date_dropdown;
}
function day_dropdown($name, $selected_date_day = '', $extra=''){
	$date_dropdown	.= "<select	name='$name' $extra>";
	$date_dropdown	.= "<option	value='0'>Date</option>";
	for($i = 1;$i <= 31;$i++) {
		$date_dropdown	.= " <option ";
		if ($i == $selected_date_day) {
			$date_dropdown	.= " selected ";
		}
		$date_dropdown	.= " value='" .	str_pad($i,	2, "0",	STR_PAD_LEFT) .	"'>" . $i .	$s . "</option>";
	}
	$date_dropdown	.= "</select>";
	return $date_dropdown;
}
function year_dropdown($name, $selected_date_year = '', $start_year =	'',	$end_year = '', $extra=''){
	if($start_year	== ''){
		$start_year	= DEFAULT_START_YEAR;
	}
	if($end_year == ''){
		$end_year =	DEFAULT_END_YEAR;
	}
	$date_dropdown	.= "<select	name='$name' $extra>";
	$date_dropdown	.= "<option	value='0'>Year</option>";
	for($i = $start_year; $i <= $end_year; $i++) {
		$date_dropdown	.= " <option ";
		if ($i == $selected_date_year) {
			$date_dropdown	.= " selected ";
		}
		$date_dropdown	.= " value='" .	str_pad($i,	2, "0",	STR_PAD_LEFT) .	"'>" . str_pad($i, 2, "0", STR_PAD_LEFT) .	"</option>";
	}
	$date_dropdown	.= "</select>";
	return $date_dropdown;
}
function time_dropdown($pre, $selected_time = ''){
	if($selected_time != '' &&	$selected_time != ':'){
		$selected_hour = substr($selected_time,	0, 2);
		$selected_minute = substr($selected_time, 3, 2);
	}
	$add_query .= hour_dropdown($pre, $selected_hour);
	$add_query .= '<b>:</b>';
	$add_query .= minute_dropdown($pre, $selected_minute);
	return $add_query;
}
function hour_dropdown($pre, $selected_hour){
	$add_query .= "<select	name='"	. $pre . "hour'>";
	$add_query .= "<option	value=''>Hour</option>";
	for($i = 0;	$i <= 23; $i++){
		$add_query .= " <option ";
		if ($i == $selected_hour &&	$selected_hour != '') {
			$add_query .= " selected ";
		}
		$add_query .= " value='".str_pad($i,	2, "0",	STR_PAD_LEFT) .	"'>" . str_pad($i, 2, "0", STR_PAD_LEFT)."</option>";
	}
	$add_query .= "</select>";
	return $add_query;
}
function minute_dropdown($pre, $selected_minute){
	$add_query .= "<select name='".$pre."minute'>";
	$add_query .= "<option value=''>Minute</option>";
	for($i = 0;	$i <= 59; $i = $i +	15)	{
		$add_query .= " <option ";
		if (str_pad($i,	2, "0",	STR_PAD_LEFT) === strval($selected_minute))	{
			$add_query .= "selected ";
		}
		$add_query.=" value='" .str_pad($i,2,"0",STR_PAD_LEFT)."'>".str_pad($i,2,"0", STR_PAD_LEFT)."</option>";
	}
	$add_query .= "</select>";
	return $add_query;
}
function ampm_dropdown($pre, $selected_ampm){
	$add_query .= "<select name='" . $pre . "ampm'>";
	$add_query .= " <option ";
	if($selected_ampm=='AM'){
		$add_query .= " selected ";
	}
	$add_query .= " value='AM'>AM</option>";
	$add_query .= " <option ";
	if($selected_ampm=='PM'){
		$add_query .= " selected ";
	}
	$add_query .= " value='PM'>PM</option>";
	$add_query .= "</select>";
	return $add_query;
}
function get_qry_str($over_write_key = array(),	$over_write_value =	array()){
	global $_GET;
	$m = $_GET;
	if(is_array($over_write_key)){
		$i = 0;
		foreach($over_write_key	as $key){
			$m[$key] = $over_write_value[$i];
			$i++;
		}
	}
	else{
		$m[$over_write_key]	= $over_write_value;
	}
	$qry_str = qry_str($m);
	return $qry_str;
}
function qry_str($arr, $skip = ''){
	$s = "?";
	$i = 0;
	foreach($arr as	$key =>	$value){
		if(is_array($skip)){
			if(!in_array($key, $skip)){
				if(is_array($value)){
					foreach($value as $value2){
						$i==0?$i=1:$s.='&';
						if($value2!=''){
							$s .= $key.'[]='.$value2;
						}
					}
				}
				else{
					$i==0?$i=1:$s.='&';
					if($value!=''){
						$s .= "$key=$value";
					}
				}
			}
		}
		else{
			if($key !=	$skip){
				if(is_array($value)){
					foreach($value as $value2){
						$i==0?$i=1:$s.='&';
						if($value2!=''){
							$s .= $key . '[]=' . $value2;
						}
					}
				}
				else{
					$i==0?$i=1:$s.='&';
					if($value!=''){
						$s .= "$key=$value";
					}
				}
			}
		}
	}
	return $s;
}
function check_radio($s, $s2){
	if(is_array($s2)){
		if (in_array($s, $s2)) {
			return " checked ";
		}
	}
	else if ($s == $s2){
		return " checked ";
	}
}
function sort_arrows($column){
	return '<A HREF="' . $_SERVER['PHP_SELF'] .	get_qry_str(array('order_by', 'order_by2'),	array($column, 'asc')) . '"><img src="images/icons/up_arrow.gif" border="0"></a>	<a href="'	. $_SERVER['PHP_SELF'] . get_qry_str(array('order_by', 'order_by2'), array($column,	'desc')) . '"><img src="images/icons/down_arrow.gif" border="0"></a>';
}
function select_option($s, $s1){
	if($s == $s1){
		echo " selected	";
	}
}
function is_post_back(){
	if(count($_POST)>0) {
		return true;
	} else {
		return false;
	}
}
function request_to_hidden($arr_skip=''){
	foreach($_REQUEST as $name => $value){
		$s .= '<input type="hidden" name="'.$name.'" value="'.midas_html_chars(stripslashes($value)).'">'."\n";
	}
	return $s;
}
function sql_to_array_file($arr_name, $sql, $file, $full_table=false){
	$add_query = "<?\n";
	$add_query .= '$'.$arr_name. " = array();\n";
	$result = db_query($sql);
	while ($line = mysqli_fetch_array($result)) {
		$line = ms_addslashes($line);
		if($full_table) {
			$key = $line[0];
			foreach($line as $name=>$value){
				if(!is_numeric($name)){
					$add_query .= '$'.$arr_name."['".$key."']['".$name."'] = '".str_replace("'", "\'", stripslashes($value))."';\n";
				}
			}
			$add_query .= "\n";
		}
		else{
			$add_query .= '$'.$arr_name."['".$line[0]."'] = '".str_replace("'", "\'", stripslashes($line[1]))."';\n";
		}
	}
	$add_query .= "?>";
	$fh = fopen($file, 'w');
	fwrite($fh, $add_query);
	fclose($fh);
	return true;
}
function array_radios($arr, $sel_value = '', $name = '', $cols = 3, $extra = ''){
	if($style != ""){
		$style = "class='" . $style . "'";
	}
	$colwidth = 100 / $cols;
	$colwidth = round($colwidth, 2);
	$j = 1;
	foreach($arr as $key => $value) {
		$tochecked = "";
		if (is_array($sel_value) && in_array($key, $sel_value)) {
			$tochecked = "checked";
		} 
		if ($key != $missit) {
			if ($value != "") {
				if ($j == 1) {
					$checkstr .= "<table $tableattr><tr>\n";
				} else if (($j % $cols) == 1 || $cols==1) {
					$checkstr .= "</tr><tr>\n";
				} 

				$checkstr .= "<td width='" . $colwidth . "%' $style valign=top><INPUT TYPE='radio' $javascript  NAME='$name' value='$key' $tochecked     > $value </td>\n";
				$j++;
			} 
		} 
	} 
	$j--; 
	for($x = $j % $cols;$x < 4;$x++) {
		if ($x != 3) {
			$checkstr .= "<td>&nbsp;</td>\n";
		} else {
			$checkstr .= "<td>&nbsp;</td></tr>\n";
		} 
	} 
	$checkstr .= "</table>";
	return $checkstr;
} 
function show_thumb($file_org, $width, $height, $ratio_type = 'width_height'){
	if(LOCAL_MODE) {
		$method = 'gd';
	}
	else{
		$method = 'im';
	}
	return midas_thumb::show_thumb($file_org, $width, $height, $ratio_type, $method, 'php');
}
function ms_parse_keywords($keywords){
	$arr_keywords = array();
	$dq_end =true;
	$sp_end = true;
	for($i=0;$i< strlen($keywords);$i++){
		$cur_token = $keywords[$i];
		if($cur_token=='"'){
			if($dq_start){
				$dq_end = true;
				$dq_start = false;
				$arr_keywords[] = $cur_keyword;
				$cur_keyword = '';
			}
			else if($dq_end){
				$dq_end = false;
				$dq_start = true;
				$sp_start = false;
			}
			else{
				$dq_end = false;
				$dq_start = true;
			}
		}
		else if($cur_token==' '){
			if($sp_start || $dq_end){
				$sp_end = true;
				$sp_start = false;
				$arr_keywords[] = $cur_keyword;
				$cur_keyword = '';
			}
			else if($sp_end && !$dq_start){
				$sp_end = false;
				$sp_start = true;
			}
			else if($dq_start){
				$cur_keyword .= $cur_token;
			}
		}
		else{
			$cur_keyword .= $cur_token;
		}
	}
	$arr_keywords[] =$cur_keyword;
	return $arr_keywords;
}
function pagesize_dropdown($name, $value){
	$arr = array('10'=>'10','25'=>'25','50'=>'50','100'=>'100','250'=>'250');
	$m = $_GET;
	unset($m['pagesize']);
	return array_dropdown($arr, $value , $name, '  onchange="location.href=\''.$_SERVER['PHP_SELF'].qry_str($m).'&pagesize=\'+this.value" ');
}
function sql_to_assoc_array($sql){
	$arr = array();
	$result = db_query($sql);
	while ($line = mysqli_fetch_array($result)) {
		$line = ms_form_value($line);
		$arr[$line[0]] = $line[1];
	}
	return $arr;
}
function sql_to_index_array($sql){
	$arr = array();
	$result = db_query($sql);
	while ($line = mysqli_fetch_array($result)) {
		$line = ms_form_value($line);
		$arr[] = $line[0];
	}
	return $arr;
}
function sql_to_array($sql){
	$arr = array();
	$result = db_query($sql);
	while ($line = mysqli_fetch_array($result)) {
		$line = ms_form_value($line);
		array_push($arr, $line);
	}
	return $arr;
}
function get_unique_file_name($file_name){
	return str_shuffle(md5(uniqid(rand(), true))) . '.' . file_ext($file_name);
}
function qry_str_to_hidden($add_query){
	$fields='';
	if(substr($add_query,0,1)=='?') {
		$add_query = substr($add_query,1);
	}
	$arr = explode('&', $add_query);
	foreach($arr as $pair){
		list($name, $value) = explode('=',$pair);
		if($name!=''){
			$fields.='<input type="hidden" name="'.$name.'" id="'.$name.'" value="'.$value.'" />';
		}
	}
	return $fields;
}
function enum_to_array($table, $column){
	$result = db_query("show fields from $table"); 
	while($line = mysqli_fetch_assoc($result)){
		if($line['Field']==$column){
			$Type = $line['Type'];
			$Type = substr($Type,6,-2);
			$arr_tmp = explode("','", $Type);
			foreach($arr_tmp as $val) {
				$arr[$val]=$val;
			}
			return $arr;
		}
	}
}
function absolute_to_fs($path){
	$path = str_replace(SITE_SUB_PATH , '' , str_replace('\\', '/', $path));
	return SITE_FS_PATH.'/'.$path;
}
function fs_to_absolute($path){
	return str_replace(SITE_FS_PATH , SITE_SUB_PATH, str_replace('\\', '/', $path));
}
function get_absolute_dir($file){
	return fs_to_absolute(dirname($file));
}
function enum_dropdown($table, $column, $name, $sel_value='', $extra='', $choose_one='', $arr_skip= array()){
	$arr = enum_to_array($table, $column);
	return array_dropdown( $arr, $sel_value, $name, $extra, $choose_one, $arr_skip);
}
function make_field($field_info){
	$type= $field_info['type'];
	$name= $field_info['name'];
	$sel_value= $field_info['sel_value'];
	$values= $field_info['values'];
	$extra= $field_info['extra'];
	if($type=='select' || $type=='radio' || $type=='checkbox') {
		$arr_tmp = split("\n", $values);
		$arr_values = array();
		foreach($arr_tmp as $row) {
			list($key, $value) = explode("|", $row);
			$arr_values[$key] = $value;
		}
	} 
	$add_query = '';
	switch($type) {
		case 'textfield':
			$add_query = '<input name="'.$name.'" type="text" id="'.$name.'" value="'.$sel_value.'" '.$extra.' class="textfield">';
		break;
		case 'password':
			$add_query = '<input name="'.$name.'" type="password" id="'.$name.'" value="'.$sel_value.'" '.$extra.' class="textfield">';
		break;
		case 'textarea':
			$add_query = '<textarea name="'.$name.'" id="'.$name.'" rows="5" cols="50" '.$extra.' class="textfield">'.$sel_value.'</textarea>';
		break;
		case 'select':
			if(is_array($arr_values)) {
				$add_query = '<select name="'.$name.'" '.$extra.'>';
				foreach($arr_values as $key => $value){
					$add_query .= '<option value="'.$key.'" ';
					if($sel_value==$key){
						$add_query .= 'selected';
					}
					$add_query .= ' >'.$value."</option>"; 
					$add_query .= "\r\n";
				}
				$add_query .= '</select>';
			}
		break;
		case 'list':
			if(is_array($arr_values)){
				$add_query = '<select name="'.$name.'" size ="4" multiple  '.$extra.'>';
				foreach($arr_values as $key => $value){
					$add_query .= '<option value="'.$key.'" ';
					if(in_array($key, $sel_value)){
						$add_query .= 'selected';
					}
					$add_query .=$value."</option>"; 
					$add_query .="\r\n";
				}
				$add_query .= '</select>';
			}
		break;
		case 'radio':
			if(is_array($arr_values)) {
				foreach($arr_values as $key => $value) {
					$add_query .= '<input type="radio" name="'.$name.'" value="'.$key.'" ';
					if($sel_value== $key){
						$add_query .= 'checked';
					}
					$add_query .= $extra.'> '.$value; 
				}
			}
		break;
		case 'checkbox':
			if(is_array($arr_values)) {
				foreach($arr_values as $key => $value){
					$add_query .= '<input type="checkbox" name="arr_'.$name.'[]" value="'.$key.'"';
					if(in_array($key, $sel_value)){
						$add_query .= 'checked';
					}
					$add_query .= $extra.'> '.$value; 
				}
			}
		break;
		case 'hidden':
			$add_query = '<input name="'.$name.'" type="hidden" id="'.$name.'" value="'.$sel_value.'" '.$extra.'>';
		break;
		case 'function':
			$function = str_replace('{1}', $name, $values);
			$function = str_replace('{v}', $extra, $function);
			$add_query = eval('echo '.$function);
		break;
	}
	return $add_query;
}
function file_size_format($file_size){
	if($file_size>1024*1024*1024) {
		return round($file_size/(1024*1024*1024), 2).' GB';
	}
	else if($file_size>1024*1024){
		return round($file_size/(1024*1024), 2).' MB';
	}
	else if($file_size>1024){
		return round($file_size/1024, 2).' KB';
	}
	else{
		return round($file_size, 2).' bytes';
	}
}
function recursive_dropdown( $id_column, $name_column, $parent_id_column, $order_column, $table, $where,  $name , $sel_value, $skip, $extra='', $choose_one='', $parent_id=0, $level=0){
	$level++;
	$sql = "select $id_column, $name_column from $table where $parent_id_column='$parent_id' and $id_column!='$skip'";
	if($where!=''){
		$sql .= " and $where ";
	}
	$sql .= " order by $order_column ";
	$result = db_query($sql);
	if(mysqli_num_rows($result)) {
		if($level==1) { 
			$add_query_dropdown.="<select name='$name' id='$name' $extra >";
			if($choose_one!=''){
				$add_query_dropdown.="<option value=\"\">$choose_one</option>";
			}
		}
		while ($line_raw = mysqli_fetch_array($result)){
			$line = ms_display_value($line_raw);
			@extract($line);
			$add_query_dropdown .= '<option value="'.$line[0].'"';
			if ($sel_value == $line[0]){
				$add_query_dropdown .= "	selected ";
			}
			$add_query_dropdown .= ">";
			for($i=2;$i<=$level;$i++) {
				if($i==$level){
					$add_query_dropdown .= " &nbsp;&nbsp;&raquo; ";
				}
				else{
					$add_query_dropdown .= " &nbsp;&nbsp;&nbsp; ";
				}
			}
			$add_query_dropdown .= "$line[1]</option>";
			$add_query_dropdown .= recursive_dropdown($id_column, $name_column, $parent_id_column, $order_column, $table, $where, $name, $sel_value, $skip, $extra, $choose_one, $$id_column, $level);
		}
		$add_query_dropdown .= $level== 1 ? '</select>' : '';
	}
	return $add_query_dropdown;
}
function midas_html_chars($add_querying){
	$array_trans = array('<' => "&lt;", '>' => "&gt;", '"' => "&quot;", "'" => "&#039;");
	return strtr($add_querying, $array_trans);
}
function file_absolute_path($file){
	return fs_to_absolute(dirname($file));
}
function load_plugin($name, $type=''){
	global $ARR_LOADED_PLUGINS, $ARR_PLUGINS_INFO;
	if($type=='up'){
		$dir = SITE_FS_PATH.'/under_process/'.$name;
	}
	else{
		$dir = SITE_FS_PATH.'/'.PLUGINS_DIR.'/'.$name;
	}
	if(file_exists($dir.'/midas_plugin.php')){
		require_once($dir.'/midas_plugin.php');
		$ARR_LOADED_PLUGINS[] = $name;
		$ARR_PLUGINS_INFO[$name] = array('version'=>$plugin_version, 'type'=>$type);
	}
	else{
		//trigger_error("<div style='color:red;'>Cannot load plugin: $name</div>", E_USER_ERROR);
	}
}
function plugin_loaded($name){
	global $ARR_LOADED_PLUGINS;
	if(in_array($name, $ARR_LOADED_PLUGINS)){
		return true;
	}
	return false;
}
function plugin_path($type, $name=''){
	global $CURRENT_PLUGIN, $ARR_PLUGINS_INFO;
	if($name==''){
		$name=$CURRENT_PLUGIN;
	}
	if($ARR_PLUGINS_INFO[$name]['type']=='up'){
		$dir = 'under_process';
	}
	else{
		$dir = PLUGINS_DIR;
	}
	$type = strtoupper($type);
	if($type=='WS'){
		return SITE_WS_PATH.'/'.$dir.'/'.$name;
	}
	else if($type=='FS'){ 
		return SITE_FS_PATH.'/'.$dir.'/'.$name;
	}
	else if($type=='SUB'){ 
		return SITE_SUB_PATH.'/'.$dir.'/'.$name;
	}
	else if($type=='AWS'){ 
		return SITE_WS_PATH.'/'.$dir.'/'.$name.'/'.ADMIN_DIR;
	}
	else if($type=='AFS'){ 
		return SITE_FS_PATH.'/'.$dir.'/'.$name.'/'.ADMIN_DIR;
	}
	else if($type=='ASUB'){ 
		return SITE_SUB_PATH.'/'.$dir.'/'.$name.'/'.ADMIN_DIR;
	}
	return false;
}
function plugin_fs_path($name=''){
	return plugin_path('FS', $name);
}
function plugin_ws_path($name=''){
	return plugin_path('WS', $name);
}
function plugin_sub_path($name=''){
	return plugin_path('SUB', $name);
}
function plugin_admin_sub_path($name=''){
	return plugin_path('ASUB', $name);
}
function plugin_admin_fs_path($name=''){
	return plugin_path('AFS', $name);
}



function null_to_blank($var){
	if(is_null($var)){
		return '';
	}
	return $var;
}


function calculate_tax($amount,$tax_rate){

$tax=((float)$amount/100)*$tax_rate;

return $tax;
}