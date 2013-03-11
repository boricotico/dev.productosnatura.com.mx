<?php

include("s3Config.php");
$rand       = mt_rand(0,(sizeof($values)-1));
shuffle($values);
$s3Capcha = '<p>Por favor marca la imagen:  <strong>'.$values[$rand]."</strong></p>\n";
$s3Capcha .= '<div style="text-align:center; margin-left:150px;">';
for($i=0;$i<sizeof($values);$i++) {
    $value2[$i] = mt_rand();
    $s3Capcha .= '<div><span>'.$values[$i].' <input type="radio" name="s3capcha" value="'.$value2[$i].'"></span><div style="background: url('.$imagePath.$values[$i].'.'.$imageExt.') bottom left no-repeat; width:'.$imageW.'px; height:'.$imageH.'px;cursor:pointer;display:none;" class="img" /></div></div>'."\n";
}
 $s3Capcha .= '</div>'."\n";
$_SESSION['s3capcha'] = $value2[$rand];
echo $s3Capcha;
?>