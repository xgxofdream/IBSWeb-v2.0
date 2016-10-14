<?php
/**
 * 锟截讹拷锟斤拷
 *
 * @param string $text	原锟斤拷息
 * @param int $time		转锟斤拷时锟斤拷锟斤拷
 * @param string $url	转锟斤拷锟街�
 * @return string
 */
function redirect($url, $text = "", $time = 4) {
	global $_SITE_NAME;
	include_once 'views/redirect.htm'; 
	exit ();
}


function msg($msg, $page = -1) // 锟斤拷示锟斤拷息
{
	echo "<SCRIPT language=javascript>alert(\"" . $msg . "\");</SCRIPT>";
	echo "<SCRIPT>history.go(" . $page . ");</SCRIPT>";
	exit ();
}


function getip() {
	if ($_SERVER ['HTTP_X_FORWARDED_FOR']) {
		$onlineip = $_SERVER ['HTTP_X_FORWARDED_FOR'];
	} elseif ($_SERVER ['HTTP_CLIENT_IP']) {
		$onlineip = $_SERVER ['HTTP_CLIENT_IP'];
	} else {
		$onlineip = $_SERVER ['REMOTE_ADDR'];
	}
	return $onlineip;
}
function validate_email($address) 
{
	if (ereg ( '^[-!#$%&\'*+\\./0-9=?A-Z^_`a-z{|}~]+' . '@' . '[-!#$%&\'*+\\/0-9=?A-Z^_`a-z{|}~]+\.' . '[-!#$%&\'*+\\./0-9=?A-Z^_`a-z{|}~]+$', $address, $email )) {
		return true;
	} else {
		return false;
	}
}
function encrypt($str) //
{
	$str = md5 ( md5 ( md5 ( $str ) ) );
	return $str;
}
function safe($str) {
	$str = addslashes ( $str );
	
	// $str = str_replace("<","&lt;",$str);
	// $str = str_replace(">","&gt;",$str);
	$str = str_replace ( "\n", "<br>", $str );
	$str = str_replace ( " ", "&nbsp;", $str );
	
	return $str;
}

// 
function unsafe($str) {
	$str = str_replace ( "<br>", "\n", $str );
	$str = str_replace ( "&nbsp;", " ", $str );
	
	return $str;
}

// --------------------------IBSWeb-----------------------
function pageGuard() {
	$user_tel = '';
	$user_type = '';
	if (isset ( $_SESSION ['user_tel'] ) && $_SESSION ['user_type'] >= 0) {
		$user_tel = $_SESSION ['user_tel'];
		$user_type = $_SESSION ['user_type'];
		return $user_tel;
	} else {
		destroySession();
	}
	
}

function destroySession() {
	
		$_SESSION = array ();
		if (isset ( $_COOKIE [session_name ()] )) {
			setcookie ( session_name (), '', time () - 42000, '/' );
		}
		session_destroy ();
		redirect ( "index.php", "You are illegally logining!" );
		exit ();
}

function jsonEncode($var) {
	if (! function_exists ( 'json_encode' )) {
		return json_encode ( $var, JSON_FORCE_OBJECT );
	} else {
		switch (gettype ( $var )) {
			case 'boolean' :
				return $var ? 'true' : 'false'; // Lowercase necessary!
			case 'integer' :
			case 'double' :
				return $var;
			case 'resource' :
			case 'string' :
				return '"' . str_replace ( array (
						"\r",
						"\n",
						"<",
						">",
						"&" 
				), array (
						'\r',
						'\n',
						'\x3c',
						'\x3e',
						'\x26' 
				), addslashes ( $var ) ) . '"';
			case 'array' :
				// Arrays in JSON can't be associative. If the array is empty or if it
				// has sequential whole number keys starting with 0, it's not associative
				// so we can go ahead and convert it as an array.
				if (empty ( $var ) || array_keys ( $var ) === range ( 0, sizeof ( $var ) - 1 )) {
					$output = array ();
					foreach ( $var as $v ) {
						$output [] = jsonEncode ( $v );
					}
					return '[ ' . implode ( ', ', $output ) . ' ]';
				}
			// Otherwise, fall through to convert the array as an object.
			case 'object' :
				$output = array ();
				foreach ( $var as $k => $v ) {
					$output [] = jsonEncode ( strval ( $k ) ) . ': ' . jsonEncode ( $v );
				}
				return '{ ' . implode ( ', ', $output ) . ' }';
			default :
				return 'null';
		}
	}
}

// translate colunm name to its chinses name
function translateDatabaseColumnName($chinese_name_array, $mysql_content_array) {
	// $j = 0;
	$name = array ();
	$content = array ();
	$newArray = array ();
	
	$name = $chinese_name_array;
	$content = $mysql_content_array;
	
	foreach ( $content as $key1 => $value1 ) {
		
		foreach ( $name as $key2 => $value2 ) {
			
			if ($key1 == $key2) {
				
				$newArray [$value2] = $value1;
			}
		}
	}
	
	return $newArray;
}

// Associate Table name with Column name
function associateTableAndColumnName($arr, $db_table_column_arr, $POST_arr) {
	$newArray = array ();
	
	$name = $db_table_column_arr;
	$content = $arr;
	
	$newArray = array_intersect ( $db_table_column_arr, $arr );
	$newArray = array_intersect_key ( $newArray, $POST_arr );
	
	return $newArray;
}

// transfrom the $_POST array into a string for storing into database
function linkAllinOne($value1, $value2) {
	return $value1 . "<li>" . $value2 . "</li>";
}

// Transform the $_POST Keys into php codes(assign valiables)
function makePOSTkeyToPhpExpr($arr) {
	$str = '';
	if (is_array ( $arr )) {
		
		reset ( $arr );
		$arr = array_keys ( $arr );
		
		foreach ( $arr as $value ) {
			$str .= "\$" . $value . " = checkArrayValue(\$_POST['" . $value . "'], 'No data yet');";
		}
	} else {
		$str = $arr;
	}
	
	return $str;
}

// check the values of the $_POST array
function checkArrayValue($array, $placement) {
	if (is_array ( $array )) {
		foreach ( $array as $key => &$value ) {
			if ($value == '') {
				$value = $placement;
			}
		}
		$array = array_reduce ( $array, "linkAllinOne" );
	} else {
	}
	
	return $array;
}
function receiveAndAddDataToMysql($arr, $db_table01_arr, $db_table02_arr, $user_ID = 3) {
	/*
	 * ////////////////////////////////////////////////////////////////////////////////////////////
	 * 1. This function 1)receives Html Post Data and 2)put them into two mysql tables in 'Update' way
	 * 2. $arr is an array for $_POST
	 * 3. $db_table01_name for the database table name targeted
	 * 4. $db_table02_arr is an array storing the info of the other database table targeted (table'sname and column's name), this array is customized.
	 * 5. $user_ID is for the targeted row in tables.
	 */
	// /////////////////////////////////////////////////////////////////////////////////////////
	$str01 = '';
	$str02 = '';
	$str03 = '';
	$str04 = '';
	$temp = '';
	$new_arr = array ();
	
	// calculate how many parts are finished
	/*
	 * $i = 0;
	 * $j = 0;
	 * $percent = 0;
	 *
	 * foreach ( $_POST as $key => &$value )
	 * {
	 * $i++;
	 *
	 * if ($value !='') {
	 * $j++;
	 * } else {
	 * $value = "No data yet";
	 * //echo $key."=".$value."<br>";
	 * }
	 * }
	 *
	 * $percent = Round ($j/$i, 2);
	 * $percent = $percent*100;
	 */
	$pageform_completion = formCompletion ();
	
	// Transform the $_POST Keys into php codes(assign valiables)
	$phpcode_str = makePOSTkeyToPhpExpr ( $arr );
	// run the generated php codes
	eval ( $phpcode_str );
	
	// Transform the $_POST Keys into php codes(Updata mysql)
	reset ( $arr );
	reset ( $db_table01_arr );
	reset ( $db_table02_arr );
	
	$str00 = "\$mysqlcode = \"UPDATE ";
	
	$i = 3;
	$temp .= "`" . current ( $db_table01_arr ) . "` LEFT JOIN `" . next ( $db_table01_arr ) . "` ON (" . prev ( $db_table01_arr ) . ".user_ID=" . next ( $db_table01_arr ) . ".user_ID) ";
	while ( $i <= count ( $db_table01_arr ) ) {
		
		next ( $db_table01_arr );
		$str01 .= " LEFT JOIN `" . current ( $db_table01_arr ) . "` ON (" . prev ( $db_table01_arr ) . ".user_ID=" . next ( $db_table01_arr ) . ".user_ID)";
		$i ++;
	}
	
	$str01 = $temp . $str01;
	
	$str01 .= " SET ";
	
	$new_arr = associateTableAndColumnName ( $db_table01_arr, $GLOBALS ['db_table_column_arr'], $arr );
	
	foreach ( $new_arr as $key => $value ) {
		$str02 .= $value . "." . $key . " = '$" . $key . "', ";
	}
	
	$str02 .= key ( $db_table02_arr ) . "." . current ( $db_table02_arr ) . " = '\$pageform_completion' ";
	$str03 = "WHERE " . $value . ".user_ID ='" . $user_ID . "'\";";
	$str04 = $str00 . $str01 . $str02 . $str03;
	
	// run the generated php codes
	eval ( $str04 );
	/*
	 * $myfile = fopen("liujie.txt", "w") or die("Unable to open file!");
	 * $txt = $mysqlcode."\n";
	 * fwrite($myfile, $txt);
	 *
	 * fclose($myfile);
	 *
	 * echo $str00."<br>------<br>";
	 * echo $str01."<br>------<br>";
	 * echo $str02."<br>------<br>";
	 * echo $str03."<br>------<br>";
	 * echo $str04."<br>------<br>";
	 * echo $mysqlcode;
	 */
	// Update mysql
	try {
		$db = connectMysql ();
		$db->query ( $mysqlcode );
	} catch ( PDOException $e ) {
		echo $e->getMessage ();
	}
}
function searchSql01($pageBodyType) {
	$sql = '';
	$sql01 = '';
	switch ($pageBodyType) {
		case 'search_managmentInfo' :
			$sql01 = "SELECT * FROM `user_basic_info` LEFT JOIN `user_profile_for_research` ON (user_basic_info.user_ID=user_profile_for_research.user_ID) LEFT JOIN `user_key_info` ON (user_profile_for_research.user_ID=user_key_info.user_ID) WHERE user_key_info.user_type = 0 ";
			break;
		
		default :
			destroySession();
			break;
	}
	
	if ($_POST ['firstAdd'] == 1) {
		$sql02 = "AND user_profile_for_research.sample_code = '" . $_POST ['sample_code'] . "' ";
	} else {
		$sql02 = "";
	}
	
	if ($_POST ['secondAdd'] == 1) {
		$sql03 = "AND user_profile_for_research.user_blood_status = '" . $_POST ['user_blood_status'] . "' AND user_profile_for_research.user_urine_status = '" . $_POST ['user_urine_status'] . "' AND user_profile_for_research.user_feces_status = '" . $_POST ['user_feces_status'] . "' ";
	} else {
		$sql03 = "";
	}
	
	if ($_POST ['thirdAdd'] == 1) {
		if ($_POST ['user_physician_estimation_status'] [0] == '')
			$_POST ['user_physician_estimation_status'] [0] = 0;
		if ($_POST ['user_self_estimation_status'] [0] == '')
			$_POST ['user_self_estimation_status'] [0] = 0;
		if ($_POST ['user_basic_info_status'] [0] == '')
			$_POST ['user_basic_info_status'] [0] = 0;
		if ($_POST ['user_health_info_status'] [0] == '')
			$_POST ['user_health_info_status'] [0] = 0;
		if ($_POST ['user_diet_info_status'] [0] == '')
			$_POST ['user_diet_info_status'] [0] = 0;
		if ($_POST ['user_lifestyle_info_status'] [0] == '')
			$_POST ['user_lifestyle_info_status'] [0] = 0;
		
		if ($_POST ['user_physician_estimation_status'] [1] == '')
			$_POST ['user_physician_estimation_status'] [1] = 100;
		if ($_POST ['user_self_estimation_status'] [1] == '')
			$_POST ['user_self_estimation_status'] [1] = 100;
		if ($_POST ['user_basic_info_status'] [1] == '')
			$_POST ['user_basic_info_status'] [1] = 100;
		if ($_POST ['user_health_info_status'] [1] == '')
			$_POST ['user_health_info_status'] [1] = 100;
		if ($_POST ['user_diet_info_status'] [1] == '')
			$_POST ['user_diet_info_status'] [1] = 100;
		if ($_POST ['user_lifestyle_info_status'] [1] == '')
			$_POST ['user_lifestyle_info_status'] [1] = 100;
		
		$sql04 = "
AND user_profile_for_research.user_physician_estimation_status BETWEEN '" . $_POST ['user_physician_estimation_status'] [0] . "' AND '" . $_POST ['user_physician_estimation_status'] [1] . "'
AND user_profile_for_research.user_self_estimation_status BETWEEN '" . $_POST ['user_self_estimation_status'] [0] . "' AND '" . $_POST ['user_self_estimation_status'] [1] . "'
AND user_profile_for_research.user_basic_info_status BETWEEN '" . $_POST ['user_basic_info_status'] [0] . "' AND '" . $_POST ['user_basic_info_status'] [1] . "'
AND user_profile_for_research.user_health_info_status BETWEEN '" . $_POST ['user_health_info_status'] [0] . "' AND '" . $_POST ['user_health_info_status'] [1] . "'
AND user_profile_for_research.user_diet_info_status BETWEEN '" . $_POST ['user_diet_info_status'] [0] . "' AND '" . $_POST ['user_diet_info_status'] [1] . "'
AND user_profile_for_research.user_lifestyle_info_status BETWEEN '" . $_POST ['user_lifestyle_info_status'] [0] . "' AND '" . $_POST ['user_lifestyle_info_status'] [1] . "' ";
	} else {
		$sql04 = "";
	}
	
	$sql = $sql01 . $sql02 . $sql03 . $sql04 . "ORDER BY user_key_info.user_ID DESC";
	
	return $sql;
}
function searchSql02($pageBodyType) {
	$sql = '';
	$sql01 = '';
	switch ($pageBodyType) {
		
		case 'search_sampleProfile' :
			$sql01 = "SELECT * FROM `user_basic_info` LEFT JOIN `user_health_info` ON (user_basic_info.user_ID=user_health_info.user_ID) LEFT JOIN `user_physician_estimation` ON (user_health_info.user_ID=user_physician_estimation.user_ID) LEFT JOIN `user_profile_for_research` ON (user_physician_estimation.user_ID=user_profile_for_research.user_ID) LEFT JOIN `user_key_info` ON (user_profile_for_research.user_ID=user_key_info.user_ID) WHERE user_key_info.user_type = 0 ";
			break;
		
		default :
			destroySession();
			break;
	}
	
	if ($_POST ['firstAdd'] == 1) {
		$sql02 = "AND user_profile_for_research.sample_code = '" . $_POST ['sample_code'] . "' ";
	} else {
		$sql02 = "";
	}
	
	if ($_POST ['secondAdd'] == 1) {
		if ($_POST ['basic_age'] [0] == '')
			$_POST ['basic_age'] [0] = 0;
		if ($_POST ['basic_age'] [1] == '')
			$_POST ['basic_age'] [1] = 100;
		
		$sql03 = " AND user_basic_info.basic_age BETWEEN " . $_POST ['basic_age'] [0] . " AND " . $_POST ['basic_age'] [1] . " AND user_basic_info.basic_gender = '" . $_POST ['basic_gender'] . "' ";
	} else {
		$sql03 = "";
	}
	
	if ($_POST ['thirdAdd'] == 1) {
		$sql04 = "AND user_physician_estimation.user_symptom_stage = '" . $_POST ['user_symptom_stage'] . "' AND user_physician_estimation.user_IBStype_byROME = '" . $_POST ['user_IBStype_byROME'] . "' ";
	} else {
		$sql04 = "";
	}
	
	$sql = $sql01 . $sql02 . $sql03 . $sql04 . "ORDER BY user_key_info.user_ID DESC";
	
	return $sql;
}
function formCompletion() {
	$i = 0;
	$j = 0;
	$percent = 0;
	
	foreach ( $_POST as $key => &$value ) {
		$i ++;
		
		if ($value != '') {
			$j ++;
		} else {
			$value = "No data yet";
			// echo $key."=".$value."<br>";
		}
	}
	
	$percent = Round ( $j / $i, 2 );
	$percent = $percent * 100;
	return $percent;
}

?>