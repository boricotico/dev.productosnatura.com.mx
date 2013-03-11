<?php
session_start();
ini_set('display_errors', '0');
require('functions.php');



#########################################################
#### INIT System Data
#########################################################
$in  = array();
$va  = array();
$trs = array();
$usr = array();
$sys = array();
$cfg = array();
$tpl = array();
$cses= array();
$error= array();

define('DATE_FORMAT_LONG', '%A %d %B, %Y');


load_sys_data(); //Load $sys

// System Data
$tpl['pagetitle'] = $cfg['app_title'];
$ck_name  =  $cfg['ckname'];
$sid='';
$cfg['cd'] = 1;  //Debug Mode

######################################################
##### Load Paths and URLs ############################
######################################################

// Connect Persistent to DB
mysql_pconnect ($cfg['dbi_host'], $cfg['dbi_user'], $cfg['dbi_pw']) or die('Error 0000000001 ');
mysql_select_db ($cfg['dbi_db']) or die('Error 0000000002 ');


// Load Data
foreach ($_GET as $key=>$value ) {
	if (array_key_exists(strtolower($key), $in)){
		$in[strtolower($key)] .= "|$value";
	}else{
		$in[strtolower($key)] = $value;
	}
}

foreach ($_POST as $key=>$value ) {
	if (array_key_exists(strtolower($key), $in)){
		$in[strtolower($key)] .= '|' . $value;
	}else{
		$in[strtolower($key)] = $value;
	}
}

$in['fullquery'] = getenv('QUERY_STRING');

## Templates por defecto
$tpl['nsMaxHits']  = 20;
$tpl['page_title'] = $cfg['app_title'];

if (array_key_exists("cmd", $in)){
	
	if ($in['cmd'] == 'page'){
		
		require('cmd_page.php');
		$fn = 'page_' . $in['fname'];
		if(function_exists($fn)){
			$fn();
		}
		## Si no existe funcion, se carga el template con el nombre de $in['fname']
		require($cfg['path_templates'] . $in['fname'] . '.html');
	
	}
	exit;
}

require($cfg['path_templates'] . 'home.html');


	
?>