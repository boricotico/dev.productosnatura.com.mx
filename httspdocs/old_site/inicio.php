<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Productos Natura Mexico ::: bien estar bien :::</title>
<link type="text/css" rel="stylesheet" media="all" href="styles/styles.css" />
	<!-- galeria -->
	<link rel="stylesheet" href="/themes/default/default.css" type="text/css" media="screen" />
    <!-- <link rel="stylesheet" href="themes/pascal/pascal.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="themes/orman/orman.css" type="text/css" media="screen" />-->
    <link rel="stylesheet" href="/nivo-slider.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="/style.css" type="text/css" media="screen" />
	<!-- forma -->
	<link rel="stylesheet" type="text/css" href="/jqtransformplugin/jqtransform.css" />
	<link rel="stylesheet" type="text/css" href="/formValidator/validationEngine.jquery.css" />
	<?=$css?>
	<!-- -->
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
	<!-- menu -->
    <script src="/js/lavalamp.js" type="text/javascript"></script>
    <script type="text/javascript" src="/jquery.nivo.slider.pack.js"></script>
	<!-- comun -->
	<script src="/js/funciones.js" type="text/javascript"></script>	
	<!-- forma -->
	<script type="text/javascript" src="/jqtransformplugin/jquery.jqtransform.js"></script>
	<script type="text/javascript" src="/formValidator/jquery.validationEngine.js"></script>	
	<script type="text/javascript" src="/scripts/script.js"></script>
	
</head>

<body>
<table width="10%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center" valign="top">
		<table width="930" height="350" border="0" cellspacing="0" cellpadding="0" bgcolor="#2F2F2F">
		  <tr>
			<td align="center"><!--<img src="images/imagen.jpg" width="920" height="343" />-->
			<div id="wrapper">
				<div class="slider-wrapper theme-default">
					<div class="ribbon"></div>
					<div id="slider" class="nivoSlider">
						<img src="images/imagen1.1.jpg" alt="" data-transition="slideInLeft" />
						<img src="images/imagen2.1.jpg" alt="" title="#htmlcaption" />
					</div>
				</div>
			</div>
			</td>
		  </tr>
		</table>	
	</td>
  </tr>
  <tr style="line-height: 7px;">
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center">
	<div class="lavalamp yellow">
    <ul >
        <li class="active" id="registro"><a href="inicio.php" class="texto_menu">Registro Consultora</a></li>
        <li id="comprar"><a href="inicio2.php" class="texto_menu">¡Quiero Comprar!</a></li>
		<li id="contacto"><a href="inicio3.php" class="texto_menu">Contacto</a></li>
    </ul>
        <div class="floatr"></div>
    </div>	</td>
  </tr>
  <tr><td>&nbsp;</td></tr>
  <tr><td>&nbsp;</td></tr>
  <tr>
    <td align="center" valign="top"><table width="930" height="600" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
      <tr>
        <td align="left" valign="top" class="texto">
		<div id="veregistro">
		Registro
		</div>
		
		<div id="vecomprar" style="display:none">
		Comprar
		</div>
		
		<div id="vecontacto" style="display:none">
		<? require('contacto.php'); ?>
		</div>
		</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center" valign="top">&nbsp;</td>
  </tr>
</table>
</body>
</html>
