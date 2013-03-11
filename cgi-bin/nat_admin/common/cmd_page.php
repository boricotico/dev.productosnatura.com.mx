<?php

	function page_lineas(){
		global $in,$cfg,$va;
	    //print_r($in);
		$lineas = !empty($in['sl']) ? $in['sl'] : 'lineas';
		//$id_linea = load_name('Lineas','Nombre',$linea,'ID_lineas');
		//if(!empty($id_linea)){
			$query = "SELECT ASIN,Url,Productos.Nombre,Lineas.Url_nombre,Sublineas.Url_nombre
					   FROM Productos 
					   INNER JOIN Sublineas USING (ID_sublineas)
					   INNER JOIN Lineas USING (ID_lineas)
					   WHERE Lineas.Url_nombre = '$lineas'
					   ORDER BY RAND() LIMIT 5 "; 
			//print"$query";
			$res = mysql_query($query);
			$filas = mysql_num_rows($res); 
					
			$va['linea'] = '<table width="100%" border="1" bordercolor="#C3C3C3"><tr>';
			
			for($i=0; $i<$filas; $i++){ 
				$datos = mysql_fetch_array($res);
				if($i%5 == 0 && $i>0)  $va['linea'] .=  '</tr><tr>'; 
						
				$va['linea'] .= '<td width="200">
							 <table width="100%">
							  <tr>
								<td align="center" valign="top">
									<a href="/comprar-productos-natura-mexico/'.$datos[0].'/'.$datos[3].'/'.$datos[4].'/'.$datos[1].'">
										<img src="'.$cfg['url_images'].'catalogo/'.$datos[3].'/'.$datos[4].'/'.$datos[0].'.jpg" name="'.$datos[1].'" width="60" height="85" />
									</a>
								</td>
							  </tr>
							  <tr>
								<td align="center" valign="top" class="texto">'.$datos[2].'</td>
							  </tr>
							 </table>
						 </td>';
			}
			$va['linea'] .= '</table>
							 <div style="text-align:right; vertical-align:baseline; height:35px;"><br />
							 	<a href="/comprar-productos-natura-mexico/'.$lineas.'/" class="texto" style=" font-weight:bold; color:#FE4617;"> Ver linea completa >> </a>
							 </div>';
		//}
		
		if(is_file($cfg['path_templates'] . $lineas . '.html')){
			$in['fname'] = $lineas;
		}
	}


	function page_consultora(){
		global $in,$cfg,$va;

		if(!empty($in['action'])){

			if($in['s3capcha'] == $_SESSION['s3capcha'] && !empty($in['s3capcha'])) {

				## ToDo: Crear carpeta correos para template de envio
				$from = $in['correo'];
				$asunto = 'Quiero ser consultora';
				$cuerpo_sendmail = build_page('correos/' . $in['fname'] . '.html');
				#$this_message = send_gmail($from , '', $asunto, $cuerpo_sendmail);
				$this_message = mail("roberto.barcenas@gmail.com" ,$asunto, $cuerpo_sendmail);

				$va['message'] = $this_message == 'ok' ? 'Gracias, hemos recibido tu correo' : $this_message;

				unset($_SESSION['s3capcha']);
				unset($in['nombre']);
				unset($in['correo']);
				unset($in['telefono']);
				unset($in['estado']);

			}else{
				$va['message'] = 'El correo no pudo ser enviado, por favor marca la imagen correcta';
			}

		}else{
			$va['message'] = 'Por favor, llena nuestro formulario de contacto.';
		}

		require($cfg['path_templates'] . $in['fname'] . '.html');
		exit;
	}
	
	function page_catalogo(){
		global $in,$cfg,$va;
		########################################TOP 5#################################################
		$query = "SELECT ID_productos,ASIN,Url,Productos.Nombre AS producto, Sublineas.Url_nombre AS sublinea, 
		 		   Lineas.Url_nombre AS linea 
		 		   FROM Productos 
		 		   INNER JOIN Sublineas USING (ID_sublineas)
				   INNER JOIN Lineas USING (ID_lineas)
				   ORDER BY RAND() LIMIT 5 "; 
		$res = mysql_query($query);
		$filas = mysql_num_rows($res); 
			    
		$va['catalog'] = '<table width="100%" border="1" bordercolor="#C3C3C3"><tr>';
		
		for($i=0; $i<$filas; $i++){ 
			$datos = mysql_fetch_array($res);
			if($i%5 == 0 && $i>0)  $va['catalog'] .=  '</tr><tr>'; 
					
			$va['catalog'] .= '<td width="200">
						 <table width="100%" border="0">
						  <tr>
							<td align="center" valign="top">
								<a href="/comprar-productos-natura-mexico/'.$datos[1].'/'.$datos[5].'/'.$datos[4].'/'.$datos[2].'">
									<img src="'.$cfg['url_images'].'catalogo/'.$datos[5].'/'.$datos[4].'/'.$datos[1].'.jpg" name="'.$datos[3].'" width="100" height="125" />
								</a>
							</td>
						  </tr>
						  <tr>
							<td align="center" valign="top">'.$datos[3].'</td>
						  </tr>
						 </table>
					 </td>';
		}
		$va['catalog'] .= '</table>';
		########################################SUGERENCIAS#################################################
		$queryS = "SELECT ID_productos,ASIN,Url,Productos.Nombre AS producto, Sublineas.Url_nombre AS sublinea, 
		 		   Lineas.Url_nombre AS linea 
		 		   FROM Productos 
		 		   INNER JOIN Sublineas USING (ID_sublineas)
				   INNER JOIN Lineas USING (ID_lineas)
				   ORDER BY RAND() LIMIT 5 "; 
		$resS = mysql_query($queryS);
		$filasS = mysql_num_rows($resS); 
			    
		$va['sugerencia'] = '<table width="100%" border="1" bordercolor="#C3C3C3"><tr>';
		
		for($j=0; $j<$filasS; $j++){ 
			$datosS = mysql_fetch_array($resS);
			if($j%5 == 0 && $j>0)  $va['sugerencia'] .=  '</tr><tr>'; 
					
			$va['sugerencia'] .= '<td width="200">
						 <table width="100%" border="0">
						  <tr>
							<td align="center" valign="top">
								<a href="/comprar-productos-natura-mexico/'.$datosS[1].'/'.$datosS[5].'/'.$datosS[4].'/'.$datosS[2].'">
									<img src="'.$cfg['url_images'].'catalogo/'.$datosS[5].'/'.$datosS[4].'/'.$datosS[1].'.jpg" name="'.$datosS[3].'" width="100" height="125" />
								</a>
							</td>
						  </tr>
						  <tr>
							<td align="center" valign="top">'.$datosS[3].'</td>
						  </tr>
						 </table>
					 </td>';
		}
		$va['sugerencia'] .= '</table>';
		
				
		require($cfg['path_templates'] . $in['fname'] . '.html');
		exit;
	}
	
	function page_producto(){
		global $in,$cfg,$va;
		//print_r($in);
	 	 $query = "SELECT Productos.Nombre,Productos.Descripcion,ASIN,ASIN_Refill,Size,Medida, Sublineas.Nombre AS sublinea, 
		 		   Lineas.Nombre AS linea,Lineas.Url_nombre,Sublineas.Url_nombre
		 		   FROM Productos 
		 		   INNER JOIN Sublineas USING (ID_sublineas)
				   INNER JOIN Lineas USING (ID_lineas) 
				   WHERE ASIN = $in[asin]";
		//print"$query"; 
				   $res = mysql_query($query);
				   $datos = mysql_fetch_array($res);
				   
		$va['product'] = '<table width="100%" border="1">
				 <tr class="subtitulo">
					<td align="left" valign="top">&nbsp;&nbsp;&nbsp;
						<a href="/comprar-productos-natura-mexico/'.$datos[8].'/"><b>'.$datos[7].'</a> >> 
						<a href="/comprar-productos-natura-mexico/'.$datos[8].'/'.$datos[9].'">'.htmlentities($datos[6]).'</b></a>
					</td>
					<td align="center" valign="top">&nbsp;</td>
					<td align="center" valign="top">&nbsp;</td>
				  </tr>
				  <tr class="texto">
					<td width="25%" rowspan="3" align="center" valign="top">
					    <img src="'.$cfg['url_images'].'catalogo/'.$datos[8].'/'.$datos[9].'/'.$datos[2].'.jpg" name="'.$datos[0].'" />
					</td>
					<td width="48%" height="46" align="left" valign="middle"><b>'.$datos[0].'</b></td>
				    <td width="27%" rowspan="3" align="center" valign="top">zona paypal</td>
				  </tr>
				  <tr class="texto">
				    <td align="left" valign="top">'.$datos[1].'</td>
			      </tr>
				  <tr class="texto">
				    <td align="left" valign="top">'.$datos[4].'&nbsp;'.$datos[5].'<br>'.$datos[2].'</td>
			      </tr>
				  <tr class="texto">
					<td align="center" valign="top">&nbsp;</td>
					<td align="center" valign="top">&nbsp;</td>
					<td align="center" valign="top">&nbsp;</td>
				  </tr>
				  </table>';
				  
	require($cfg['path_templates'] . $in['fname'] . '.html');
	exit;
	
	}
	
	function page_linea_completa(){
		global $in,$cfg,$va;
		//print_r($in);
		if($in['sln'] != ''){ 
			$sub = " AND Sublineas.Url_nombre = '$in[sln]'";
		}else{
			$sub = "";
		}
		/*******************************************************************************************/		
		$qry = "SELECT Lineas.ID_lineas,Sublineas.ID_sublineas,Sublineas.Nombre AS sublinea, 
			   LOWER(Lineas.Nombre) AS linea, Sublineas.Url_nombre
			   FROM Lineas 
			   INNER JOIN Sublineas USING (ID_lineas) 
			   WHERE Lineas.Url_nombre = '$in[ln]'"; 
		//print"$qry";
		$result = mysql_query($qry);
		$lista = mysql_num_rows($result); 
		/**********************************Sublinea***********************************************/
		$va['sublineas'] = '<table width="100%" border="0"><tr>';
		for($i=0; $i<$lista; $i++){ 
			$datos = mysql_fetch_array($result);
			//print"$in[ln] == ekos";
			
			if($in['ln'] == 'ekos' || $in['ln'] == 'homem'){ $color = 'color:#FCE4C6;'; }else{ $color = 'color:#171717;'; }
			
			if($i%$lista == 0 && $i>0)  $va['sublineas'] .=  '</tr><tr>'; 
					
			$va['sublineas'] .= '<td width="80">
						 <table width="100%" border="1" height="45" bordercolor="#C3C3C3" style="background-image:url('.$cfg['url_images'].'/colores/'.$in['ln'].'.jpg);">
						  <tr>
							<td align="center" valign="middle">
								<a href="/comprar-productos-natura-mexico/'.$in['ln'].'/'.$datos[4].'" style="'.$color.' font-size:15px;"><b>'.htmlentities($datos[2]).'</b></a>
							</td>
						  </tr>
						 </table>
					 </td>';
		}
		/****************************************Nombre y Desc Sublinea*****************************/
		$qrySub = "SELECT Sublineas.Url_nombre,Sublineas.Nombre,Sublineas.Descripcion
				   FROM Lineas 
				   INNER JOIN Sublineas USING (ID_lineas) 
				   WHERE Lineas.Url_nombre = '$in[ln]' $sub"; 
		//print"$qrySub";
		$resSub = mysql_query($qrySub);
		$datoSub = mysql_fetch_array($resSub);

		$va['sublineas'] .= '<tr><td align="justify">&nbsp;</td></tr>
							 <tr><td align="justify" colspan="'.$lista.'" class="texto"><b>'.htmlentities($datoSub[1]).'</b><br>
							 <br>'.htmlentities($datoSub[2]).'</td></tr>
							 </table>';
		/*******************************Productos**************************************************/ 
		if($in['sln'] == ''){ $ids = $datoSub[0]; }else{ $ids = $in['sln']; }

		$query = "SELECT ID_productos,ASIN,Url,Productos.Nombre AS producto, Sublineas.Url_nombre AS sublinea, 
		 		   Lineas.Url_nombre AS linea
		 		   FROM Productos 
		 		   INNER JOIN Sublineas USING (ID_sublineas)
				   INNER JOIN Lineas USING (ID_lineas)
				   WHERE Sublineas.Url_nombre = '$ids'"; 
		//print"<br>$query";
		$res = mysql_query($query);
		$filas = mysql_num_rows($res); 
		
		$va['productos'] = '<table width="100%" border="1" bordercolor="#C3C3C3"><tr>';
		for($j=0; $j<$filas; $j++){ 
			$datos = mysql_fetch_array($res);
			if($j%5 == 0 && $j>0)  $va['productos'] .=  '</tr><tr>'; 
					
			$va['productos'] .= '<td width="200">
						 <table width="100%" border="0">
						  <tr>
							<td align="center" valign="top">
								<a href="/comprar-productos-natura-mexico/'.$datos[1].'/'.$datos[5].'/'.$datos[4].'/'.$datos[2].'">
									<img src="'.$cfg['url_images'].'catalogo/'.$datos[5].'/'.$datos[4].'/'.$datos[1].'.jpg" name="'.$datos[3].'" width="100" height="125" />
								</a>
							</td>
						  </tr>
						  <tr>
							<td align="center" valign="top" class="texto">'.$datos[3].'</td>
						  </tr>
						 </table>
					 </td>';
		}
		$va['productos'] .= '</table>';
				
		require($cfg['path_templates'] . $in['fname'] . '.html');
		exit;
	}

	

?>
