<?php


	switch($in['sl']){
		
		case 'ekos':
								$va['chosen'] = 'Ekos';
								break;	
		
		case 'perfumes':
								$va['chosen'] = 'Perfumes';
								break;
								
		case 'tododia':
								$va['chosen'] = 'Todo Dia';
								break;
								
		case 'andiroba':
								$va['chosen'] = 'Andiroba';
								break;						
														
	}
	
	echo 'Bienvenido a: ' . $va['chosen'];
	exit;

?>