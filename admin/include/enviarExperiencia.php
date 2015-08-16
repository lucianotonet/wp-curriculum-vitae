<?php

$wpcvp->zerarEdit(BD_EXPERI_PROFIS, $id_cadastro);

for ($i=0; $i<count($id_experiencia); $i++) { 
	//echo "Telefone: ".$telefone[$i].""; 
	
	$var3 = array(
	  'id_cadastro' 	=> $id_cadastro,
	  'empresa' 		=> $empresa[$i],
	  'protocolo_site' 	=> $protocolo_site[$i],
	  'site_empresa' 	=> $site_empresa[$i],
	  'cargo' 			=> $cargo[$i],
	  'ano_inicio'		=> $ano_inicio[$i],
	  'ano_final'		=> $ano_final[$i],
	  'status_ep' 		=> $status_ep[$i],
	  'mais_cargo'		=> $mais_cargo[$i],
	  'edit'			=> 1,
	  
	);
	
	if($id_experiencia[$i])
	{
		$qryExperiencia = $wpdb->update(BD_EXPERI_PROFIS, $var3, array('id' => $id_experiencia[$i]), $format = null, $where_format = null );
	}else{
		$qryExperiencia = $wpdb->insert(BD_EXPERI_PROFIS, $var3 );
	}
	
	if($qryExperiencia == false && $qryCursos != 0) { 
		
		$wpdb->show_errors(); 
		
		$wpdb->print_error();
		
		exit;
		
	}
}
?>

