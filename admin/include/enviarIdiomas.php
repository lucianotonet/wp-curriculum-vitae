<?php

$wpcvp->zerarEdit(BD_IDIOMAS, $id_cadastro);	
					
for ($i=0; $i<count($id_idiomas); $i++) { 
	
	$var4 = array(
	  'id_cadastro' 	=> $id_cadastro,
	  'iInicio' 		=> $iInicio[$i],
	  'iFinal' 			=> $iFinal[$i],
	  'iEscola' 		=> $iEscola[$i],
	  'iCurso'			=> $iCurso[$i],
	  'iCursando'		=> $iCursando[$i],
	  'iNivel'			=> $iNivel[$i],
	  'iDescricao'		=> $iDescricao[$i],
	  'edit'			=> 1,
	  
	);
	
	if($id_idiomas[$i])
	{
		$qryIdiomas = $wpdb->update(BD_IDIOMAS, $var4, array('id' => $id_idiomas[$i]), $format = null, $where_format = null );

	}else{
		$qryIdiomas = $wpdb->insert(BD_IDIOMAS, $var4 );
	}
	
	if($qryIdiomas == false && $qryCursos != 0) { 
		
		$wpdb->show_errors(); 
		
		$wpdb->print_error();
		
		exit;
		
	}
}
?>

