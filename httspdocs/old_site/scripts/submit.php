<?php

/* config start */

$emailAddress = 'carmen.adame@productosnatura.com.mx';

/* config end */

if(is_file("../phpmailer/class.phpmailer.php")){
	require_once("../phpmailer/class.phpmailer.php");
}else{
	echo "No encontre ../phpmailer/class.phpmailer.php";
	exit;
}


session_name("fancyform");
session_start();


foreach($_POST as $k=>$v)
{
	if(ini_get('magic_quotes_gpc'))
	$_POST[$k]=stripslashes($_POST[$k]);
	
	$_POST[$k]=htmlspecialchars(strip_tags($_POST[$k]));
}


$err = array();

if(!checkLen('name'))
	$err[]='El campo nombre es muy corto!';

if(!checkLen('email'))
	$err[]='El correo esta vacio!';
else if(!checkEmail($_POST['email']))
	$err[]='Correo invalido!';

/*
if(!checkLen('subject'))
	$err[]='You have not selected a subject!';
*/
if(!checkLen('message'))
	$err[]='El mensaje es muy corto o vacio!';

if((int)$_POST['captcha'] != $_SESSION['expect'])
	$err[]='Suma incorrecta!';


if(count($err))
{
	if($_POST['ajax'])
	{
		echo '-1';
	}

	else if($_SERVER['HTTP_REFERER'])
	{
		$_SESSION['errStr'] = implode('<br />',$err);
		$_SESSION['post']=$_POST;
		
		header('Location: '.$_SERVER['HTTP_REFERER']);
	}

	exit;
}


$msg=
'Nombre:	'.$_POST['name'].'<br />
Telefono:	'.$_POST['phone'].'<br />
Email:	'.$_POST['email'].'<br />
IP:	'.$_SERVER['REMOTE_ADDR'].'<br /><br />

Mensaje:<br /><br />

'.nl2br($_POST['message']).'

';


$mail = new PHPMailer();
$mail->IsMail();

$mail->AddReplyTo($_POST['email'], $_POST['name']);
$mail->AddAddress($emailAddress,'Carmen Adame');
$mail->AddAddress('carmenatura@hotmail.com','Carmen Adame');
$mail->SetFrom($_POST['email'], $_POST['name']);
$mail->Subject = "Mensaje enviado por  ".$_POST['name']." | Forma de Contacto";

$mail->MsgHTML($msg);

$mail->Send();


unset($_SESSION['post']);

if($_POST['ajax'])
{
	echo '1';
}
else
{
	$_SESSION['sent']=1;
	
	if($_SERVER['HTTP_REFERER'])
		header('Location: '.$_SERVER['HTTP_REFERER']);
	
	exit;
}

function checkLen($str,$len=2)
{
	return isset($_POST[$str]) && mb_strlen(strip_tags($_POST[$str]),"utf-8") > $len;
}

function checkEmail($str)
{
	return preg_match("/^[\.A-z0-9_\-\+]+[@][A-z0-9_\-]+([.][A-z0-9_\-]+)+[A-z]{1,4}$/", $str);
}

?>
