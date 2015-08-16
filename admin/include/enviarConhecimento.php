<?php

$wpcvp->zerarEdit(BD_CONHECI_TECNI, $id_cadastro);
					
for ($i=0; $i<count($id_conhecimento_tecnico); $i++) { 
	
	$var4 = array(
	  'id_cadastro' 	=> $id_cadastro,
	  'ctCurso' 		=> $ctCurso[$i],
	  'ctNivel' 		=> $ctNivel[$i],
	  'edit'			=> 1,
	  
	);
	
	if($id_conhecimento_tecnico[$i])
	{
		$qryConhecimentoT = $wpdb->update(BD_CONHECI_TECNI, $var4, array('id' => $id_conhecimento_tecnico[$i]), $format = null, $where_format = null );

	}else{
		$qryConhecimentoT = $wpdb->insert(BD_CONHECI_TECNI, $var4 );
	}
	
	if($qryConhecimentoT == false && $qryCursos != 0) { 
		
		$wpdb->show_errors(); 
		
		$wpdb->print_error();
		
		exit;
		
	}
}
?>

