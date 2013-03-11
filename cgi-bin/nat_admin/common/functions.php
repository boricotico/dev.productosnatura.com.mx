<?php

$local = php_uname ('n');

######################################################
##### Configuration File
######################################################
$cfg_folder  = '/home/barca/productosnatura.com.mx/cgi-bin/nat_admin/common/';

if($local != 'puppis'){
      $cfg_folder = '/home/www/domains_hypermedia/dev.productosnatura.com.mx/cgi-bin/nat_admin/common/';
	  ini_set('display_errors', '1');
}

############################################################################
##### Functions                                                        #####
############################################################################


// -------------------------------------------------------------------------
function build_checkbox_from_enum($column,$tbl_name) {
# --------------------------------------------------------
	$data='';
	$output='';

	$fields = load_enum_toarray($tbl_name,$column);
	if (count($fields) == 0) {
		$db_select_fields{$column} = &trans_txt('none');
		return $output;
	}

	foreach($fields as $field) {
		$output .= "<span style='white-space:nowrap'><input type='checkbox' name='$column' value='$field' class='checkbox'> $field </span>\n";
	}

	return $output;
}

// -------------------------------------------------------------------------
function build_page($tname) {
//Last modified on 31 Mar 2010 11:48:04
//Last modified by: MCC C. Gabriel Varela S. :Se modifica para que lea tambien de cfg
	global $cfg, $in, $usr, $va, $cses, $error;
	$page = load_page($cfg['path_templates'] . $tname) ;
	while (preg_match("/\[([^]]+)\]/", $page, $matches) and $num<99){
		$field    = $matches[1];
		$cmdname  = strtolower(substr($field,3));
		$cmdtype  = substr($field,0,3);
		if ($cmdtype == 'cf_'){
			$rep_str = $cfg[$cmdname];
		}elseif ($cmdtype == 'ck_'){
			$rep_str = $_COOKIE[$cmdname];
		}elseif($cmdtype == 'in_'){
			$rep_str = $in[$cmdname];
		}elseif($cmdtype == 'va_'){
			$rep_str = $va[$cmdname];
		}elseif($cmdtype == 'er_'){
			$rep_str = $error[$cmdname];
		}elseif($cmdtype == 'ur_'){
			$rep_str = $usr[$cmdname];
		}elseif($cmdtype == 'cs_'){
			$rep_str = $cses[$cmdname];
		}elseif($cmdtype == 'ip_'){
			$rep_str = build_page($cmdname.'.html');
		}elseif($cmdtype == 'fc_'){
			if (function_exists($cmdname)){
				$rep_str = $cmdname();
			}else{
				$rep_str = '';
			}
		}else{
			$rep_str ='';
		}
		$page = preg_replace("#\[$field\]#i",$rep_str,$page);
		++$num;
	}
	return $page;
}


// -------------------------------------------------------------------------
function build_radio ($tbl,$field){
        global $db;
        $result = $db->query("DESCRIBE $tbl $field;");
        $output = '';
        if (!DB::isError($result)) {
	        $rec = $result->fetchRow(DB_FETCHMODE_ASSOC);
	        $list = preg_split("/','/", substr($rec[1],6,-2));
	        for ($i = 0; $i < sizeof($list); $i++) {
		        $output .= "<input type='radio' name='$field' value='$list[$i]' class='checkbox'>$list[$i]\n";
	        }
        }
        return $output;
}


// -------------------------------------------------------------------------
function  build_radio_from_enum($column,$tbl_name) {
# --------------------------------------------------------
	$data='';
	$output='';

	$fields = load_enum_toarray($tbl_name,$column);
	if (count($fields) == 0) {
		$db_select_fields{$column} = &trans_txt('none');
		return $output;
	}

	foreach($fields as $field) {
		$output .= "<span style='white-space:nowrap'><input type='radio' name='$column' value='$fields' class='radio'> $field </span>\n";
	}

	return $output;
}


// -------------------------------------------------------------------------
function build_select_from_enum($column,$tbl_name){
# --------------------------------------------------------

	$data='';
	$output='';

	$fields = load_enum_toarray($tbl_name,$column);
	if (count($fields) == 0) {
		$db_select_fields{$column} = &trans_txt('none');
		return $output;
	}
	
	foreach($fields as $field) {
		$output .= "<option value='$field'>$field</option>\n";
	}
	return $output;
}



function check_email_address($email,$dns) {
        // First, we check that there's one @ symbol, and that the lengths are right
        if(!$email){
	        return false;
        }
        if (!ereg("[^@]{1,64}@[^@]{1,255}", $email)) {
	        // Email invalid because wrong number of characters in one section, or wrong number of @ symbols.
	        return false;
        }
        // Split it into sections to make life easier
        $email_array = explode("@", $email);
        $local_array = explode(".", $email_array[0]);
        for ($i = 0; $i < sizeof($local_array); $i++) {
	        if (!ereg("^(([A-Za-z0-9!#$%&'*+/=?^_`{|}~-][A-Za-z0-9!#$%&'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$", $local_array[$i])) {
		        return false;
	        }
        }
        if (!ereg("^\[?[0-9\.]+\]?$", $email_array[1])) { // Check if domain is IP. If not, it should be valid domain name
	        $domain_array = explode(".", $email_array[1]);
	        if (sizeof($domain_array) < 2) {
		        return false; // Not enough parts to domain
	        }
	        for ($i = 0; $i < sizeof($domain_array); $i++) {
		        if (!ereg("^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$", $domain_array[$i])) {
			        return false;
		        }
	        }
        }
        if ($dns){
	        $dom = explode('@', $email);
	        if(checkdnsrr($dom[1].'.', 'MX') ) return true;
	        if(checkdnsrr($dom[1].'.', 'A') ) return true;
	        if(checkdnsrr($dom[1].'.', 'CNAME') ) return true;
	        return false;
        }
        return true;
}


// -------------------------------------------------------------------------
function checkip ($ipfilter){
// -------------------------------------------------------------------------
	$ip = get_ip();
	#echo "$ipfilter <br>.. $ip<br><br>";
	$ip1 = preg_split("/\./",$ip,4);
	$ips = preg_split("/,|\n/",$ipfilter);
	
	#echo "<br>size".sizeof($ips);
	for ($x = 0; $x<sizeof($ips); $x++) {
		$ips[$x] = preg_replace("/\r/", "", $ips[$x]);
		$ip2 = preg_split("/\./",$ips[$x],4);
		$ok = 1;
		#echo "<br>cheking: $ips[$x]=?$ip : $x<br>";
		for ($i = 0; $i <= 3; $i++) {
			#echo "&nbsp;&nbsp;&nbsp;&nbsp; $ip1[$i] != $ip2[$i]";
			if ($ip1[$i] != $ip2[$i] and $ip2[$i] != 'x'){
				$ok = 0;
				#echo " : ERR";
			}
			#echo "<br>";
			
		}
		if ($ok){
			#echo "IP OKM<br>"; 
			$sth = mysql_query("SELECT COUNT(*) FROM admin_IPlist WHERE Type='Black' AND IP='$ip'");
			$ary = mysql_fetch_array($sth);
			if ($ary[0]>0){
				return 0;
			}else{
				return 1;	
			}
		}
	}
	return 0;
}


// -------------------------------------------------------------------------
function filter_values($input){
	//$output = preg_replace("/\'/", "\\'/", $input);
	$output = mysql_real_escape_string($input);
	return $output;
}

// -------------------------------------------------------------------------
function format_price($num) {
	return ("$ " . number_format($num,2)) ;
}

//

// -------------------------------------------------------------------------
function get_ip (){
	if (getenv('REMOTE_ADDR')){
		return getenv('REMOTE_ADDR');
	}elseif (getenv('REMOTE_HOST')){
		return getenv('REMOTE_HOST');
	}elseif (getenv('HTTP_CLIENT_IP')){
		return getenv('HTTP_CLIENT_IP');
	}else{
		return "Unknown";
	}
}


// -------------------------------------------------------------------------
function load_callsession() {
//Last modified on 29 Nov 2010 09:14:26
//Last modified by: MCC C. Gabriel Varela S. :Se pone prefijo toko_ en lugar de cart_
	global $in,$cfg,$cses;
	$pattern	= "/([^=]+)=(.*)/";
	if ($AUTH	= fopen($cfg['auth_dir'] . '/toko_'.session_id(),"r")){
		while(!feof($AUTH)){
			$line = fgets($AUTH);
			if(preg_match($pattern,$line,$data)){
				$key	=	$data[1];
				$value	=	$data[2];
				$cses[$key]	=	$value;
			}
		}
		fclose($AUTH);
	}
	else	
		die('Eror:00003');
	return;
}


// -------------------------------------------------------------------------
function load_cfg($tbl_name){
	global $db_cols, $db_valid_types, $db_not_null;
	$sth = mysql_query("show tables like '$tbl_name';");
	$ary = mysql_fetch_array($sth);
	if (!$ary[0]){
		return;
	}
	$db_cols = array();
	$sth = mysql_query("describe $tbl_name;");
	while ($ary = mysql_fetch_array($sth)) {
		#print_r($ary);
		$db_cols[] = $ary[0];
		if ($ary[5] == "auto_increment"){
			$db_valid_types[$ary[0]] = "auto_increment";
			$ary[2] = "YES";
		}elseif (preg_match("/varchar/i", $ary[1])){
			if ($ary[4] == "email"){
				$db_valid_types[$ary[0]] = "email";
			}else{
				$db_valid_types[$ary[0]] = "alpha";
			}
		}elseif ($ary[1] == "date"){
			$db_valid_types[$ary[0]] = "date";
		}elseif (preg_match("/^int/", $ary[1]) || $ary[1] == "decimal(5,3)"){
			$db_valid_types[$ary[0]] = "numeric";
		}elseif (preg_match("/^dec/", $ary[1])){
			$db_valid_types[$ary[0]] = "currency";
		}else{
			$db_valid_types[$ary[0]] = "alpha";
		}
		if (!$ary[2] or $ary[2] == 'NO'){
			$db_not_null[$ary[0]] = 1;
		}
	}
	return;
}


// -------------------------------------------------------------------------
function load_db_names($db,$id_name,$id_value,$str_out) {
# --------------------------------------------------------

	$sth = mysql_query("SELECT * FROM $db WHERE $id_name='$id_value';") or die('Eror:00004');
	$rec = mysql_fetch_assoc($sth);
	if ($rec[$id_name]>0){
		foreach ($rec as $key=>$value )
		{
			$str_out=preg_replace("/\[$key\]/",$rec[$key],$str_out);
		}
		return $str_out;
	}else{
		return '';
	}
}


// -------------------------------------------------------------------------
function load_enum_toarray($tbl_name,$col_name) {
# --------------------------------------------------------
	$ary='';
	$matches=array();
	$fields=array();
	$data='';
	
	###### Load Table Properties
	$sth = mysql_query("describe $tbl_name $col_name;");

	while ($ary = mysql_fetch_array($sth) ){
		$ary[0] = strtolower($ary[0]);
		$pattern= "/enum\((.*)/";
		#echo $ary[1];
		if (preg_match($pattern,$ary[1],$matches)){
			$data = $matches[1];
			$data = str_replace("'","",$data);
			$data = substr($data,0,-1);
		}
	}
	$fields = explode(",",$data);
	return $fields;
}


// -------------------------------------------------------------------------
function load_name($db,$id_name,$id_value,$field) {
// --------------------------------------------------------
    if($id_value!='NOW()' or $id_value!='CURDATE()')
		$id_value="'$id_value'";
	$sth = mysql_query("SELECT ".$field." FROM ".$db." WHERE ".$id_name."=".$id_value.";") or die('Eror:00005');
    if(mysql_num_rows($sth) > 0)
        return mysql_result($sth,0);
}

function count_tbl($tbl,$cond) {
// --------------------------------------------------------
	($cond) and ($cond = " WHERE $cond");
    $sth = mysql_query("SELECT COUNT(*) FROM $tbl $cond");
	$ary = mysql_fetch_array($sth);
	(!$ary[0]) and ($ary[0]=0);
	return $ary[0];
}

function sum_tbl($tbl,$id,$cond) {
// --------------------------------------------------------
	($cond) and ($cond = " WHERE $cond");
    $sth = mysql_query("SELECT SUM($id) FROM $tbl $cond");
	$ary = mysql_fetch_array($sth);
	(!$ary[0]) and ($ary[0]=0);
	return $ary[0];
}

// -------------------------------------------------------------------------
function load_object($obj){
	global $cfg, $in, $usr, $va, $error,$tpl,$cses,$me;
	#echo "\n\n\n\n\n\n\n\n\n\n<p>LOADING:::$cfg[path_templates].$obj</p>\n\n\n\n\n\n\n\n\n\n";
	if (file_exists($cfg['path_templates'].$obj) and is_readable($cfg['path_templates'].$obj) and is_file($cfg['path_templates'].$obj)) {
		require($cfg['path_templates'].$obj);
	}elseif ($cfg[cd]){
		echo "Unable to load : ". $cfg['path_templates'].$obj;
	}
	return;
}


// -------------------------------------------------------------------------
function load_sys_data() {
//Last modified on 29 Nov 2010 09:19:08
//Last modified by: MCC C. Gabriel Varela S. :Se cambia la forma de evaluar las líneas
        global $sys,$cfg,$cfg_folder,$local;
        
        if (file_exists($cfg_folder.'/general.'.$local.".cfg")) {
	        if ($handle = fopen($cfg_folder.'/general.'.$local.'.cfg','r')){
		        while (!feof($handle) and $handle != '') {
			        $line=fgets($handle);
			        if(preg_match("/\||=/",$line))
			        {
				        list($type,$name,$value) = preg_split("/\||=/", $line,3);
				        if ($type=='sys'){
					        $sys[$name]=trim($value);
				        }elseif ($type=='conf' or $type=='conf_local'){
					        $cfg[$name]=trim($value);
				        }
				      }
		        }
	        }
        }
}


// -------------------------------------------------------------------------
function load_page($fname) {
	global $usr,$cfg;
	(!$usr['pref_language']) and ($usr['pref_language']=$cfg['default_lang']);
	if (preg_match("/(.*)\/([a-z]*)_(.*)$/",$fname,$matches) and isset($cfg['path_ns_cgi_'.$matches[2]])){
		$fname = $matches[1]."/".$matches[2]."/".$matches[3];
	}
	$fname = preg_replace("/\[lang\]/", $usr['pref_language'], $fname);
	#echo "fname $fname<br>";
	if (file_exists("$fname")){
		if ($handle = fopen("$fname",'r')){
			$page='';
			while (!feof($handle)) {
				$page .= fgets($handle);
			}
			return $page;
		}else{
			return '';
		}
	}else{
		return '';
	}
}


// -------------------------------------------------------------------------
function php_error($sys_err) {
        global $in,$error,$va;
        require('phperror.php');
        exit;
}


// -------------------------------------------------------------------------
function randomize_array($array){
// --------------------------------------------------------
// Forms Involved: 
// Created on 05/11/2010 15:45:39
// Author: RB
// Description :   Regresa un arreglo con orden aleatorio
// Parameters  : 

    $rand_items = array_rand($array, count($array));
    $new_array = array();

    foreach($rand_items as $value){
        $new_array[$value] = $array[$value];
    }
    return $new_array;
}


function make_seed(){
// --------------------------------------------------------
// Forms Involved: 
// Created on: 
// Author: Carlos Haas
// Description :   
// Parameters : 
  list($usec, $sec) = explode(' ', microtime());
  return (float) $sec + ((float) $usec * 100000);
}

#########################################################
#    Function: send_gmail
#           Send email using gmail service
#
#    Created by:
#        _Carlos Haas_
#
#    Modified By:
#        - Oscar Sanchez:
#
#
#       Parameters:
#        - to: To mail
#        - subject: Subject Mai
#        - ext_message: Message Mail
#        - ext_headers: Headers Mail
#
#       Returns:
#        0: Message Failed
#        1: Message Sent
#
#       See Also:
#
#
function send_gmail($from , $to, $subject, $body_html){
##########################################################
    global $cfg,$local;

    if($local == 'puppis'){
        set_include_path("." . PATH_SEPARATOR . ($UserDir = dirname($_SERVER['DOCUMENT_ROOT'])) . "/pear/php" . PATH_SEPARATOR . get_include_path());
    }else{
        set_include_path($cfg['mail_pear_path']);
    }

    global $cfg;
    require_once($cfg['mail_pear_path'] . 'Mail.php');
    require_once($cfg['mail_pear_path'] . 'Mail/mime.php');

    $host = "ssl://smtp.gmail.com";
    $port = "465";

    $from = $from;
    $to_email =  !empty($to) ? $to : $cfg['tos_mail'];

    $username = $cfg['gmail_username'];
    $password = $cfg['gmail_passwd'];
    $crlf = "\n";

    $headers = array(
                    'From' => $from,
                    'Subject' => $subject
                    );

    $message =  new Mail_mime(array('eol' => $crlf)); //based on pear doc
    $message->setHTMLBody($body_html);
    $body = $message->getMessageBody(); //based on pear doc

    $headers = $message->headers($headers);


    $smtp = Mail::factory(
                            'smtp',
                            array (
                                    'host' => $host,
                                    'port' => $port,
                                    'auth' => true,
                                    'username' => $username,
                                    'password' => $password
                                )
                        );

    $mail = $smtp->send($to_email, $headers, $body);

    if (PEAR::isError($mail)) {
        #echo "\nEmail Error: " . $mail->getMessage() . "\n";
        return 'Email Error: ' . $mail->getMessage();
    } else {
        #echo "\n Email successfully sent! \n";
        return 'ok';
    }  // End if

}  // End function

?>