<?php

session_name("fancyform");
session_start();


$_SESSION['n1'] = rand(1,20);
$_SESSION['n2'] = rand(1,20);
$_SESSION['expect'] = $_SESSION['n1']+$_SESSION['n2'];


$str='';
if($_SESSION['errStr'])
{
	$str='<div class="error">'.$_SESSION['errStr'].'</div>';
	unset($_SESSION['errStr']);
}

$success='';
if($_SESSION['sent'])
{
	$success='<h1>Thank you!</h1>';
	
	$css='<style type="text/css">#contact-form{display:none;}</style>';
	
	unset($_SESSION['sent']);
}
?>
<div id="main-container" style="width:900px;text-align:center;">				
	<div id="form-container">
	<h1>Forma de Contacto</h1>
	<h2>
		<span style="color:red;font-weight:bolder;">Consultora:</span> <span style="color:#2f2f2f;font-weight:bold;"> Mar&iacute;a Carmen Adame Cer&oacute;n </span> <br>
		<span style="color:red;font-weight:bolder;">Tel&eacute;fono:</span><span style="color:#2f2f2f;font-weight:bold;"> 0155 - 5794 - 9690 </span><br>
		<span style="color:red;font-weight:bolder;">E-mail:</span><span style="color:#2f2f2f;font-weight:bold;"> carmen.adame@productosnatura.com.mx </span>
	</h2>
	
	<form id="contact-form" name="contact-form" method="post" action="/scripts/submit.php">
	  <table width="60%" border="0" cellspacing="0" cellpadding="5" align="center">
		<tr>
		  <td width="15%"><label for="name">Tu Nombre</label></td>
		  <td width="50%"><input type="text" class="validate[required,custom[onlyLetter]]" name="name" id="name" value="<?=$_SESSION['post']['name']?>" /></td>
		  <td width="15%" id="errOffset">&nbsp;</td>
		</tr>
		<tr>
		  <td><label for="phone">Tu tel&eacute;fono</label></td>
		  <td><input type="text" class="validate[required,custom[telephone]]" name="phone" id="phone" value="<?=$_SESSION['post']['phone']?>" /></td>
		  <td>&nbsp;</td>
		</tr>
		<tr>
		  <td><label for="email"><label for="email">Tu Correo</label></td>
		  <td><input type="text" class="validate[required,custom[email]]" name="email" id="email" value="<?=$_SESSION['post']['email']?>" /></td>
		  <td>&nbsp;</td>
		</tr>
		<!--<tr>
		  <td><label for="subject">Subject</label></td>
		  <td><select name="subject" id="subject">
			<option value="" selected="selected"> - Choose -</option>
			<option value="Question">Question</option>
			<option value="Business proposal">Business proposal</option>
			<option value="Advertisement">Advertising</option>
			<option value="Complaint">Complaint</option>
		  </select>          </td>
		  <td>&nbsp;</td>
		</tr>-->
		<tr>
		  <td valign="top"><label for="message">Tu Mensaje</label></td>
		  <td><textarea name="message" id="message" class="validate[required]" cols="35" rows="5"><?=$_SESSION['post']['message']?></textarea></td>
		  <td valign="top">&nbsp;</td>
		</tr>
		<tr>
		  <td><label for="captcha"><?=$_SESSION['n1']?> + <?=$_SESSION['n2']?> =</label></td>
		  <td><input type="text" class="validate[required,custom[onlyNumber]]" name="captcha" id="captcha" /></td>
		  <td valign="top">&nbsp;</td>
		</tr>
		<tr>
		  <td valign="top">&nbsp;</td>
		  <td colspan="2"><input type="submit" name="button" id="button" value="Enviar" />
		  <input type="reset" name="button2" id="button2" value="Limpiar" />
		  
		  <?=$str?>          <img id="loading" src="img/ajax-load.gif" width="16" height="16" alt="Enviando" /></td>
		</tr>
	  </table>
	  </form>
	  <?=$success?>
	</div>
	
</div>
			