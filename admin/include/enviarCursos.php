<?php

$wpcvp->zerarEdit(BD_CURSOS_PALEST, $id_cadastro);
					
for ($i=0; $i<count($id_curso_palestra); $i++) { 
	
	$var4 = array(
	  'id_cadastro' 	=> $id_cadastro,
	  'curso_palestra' 	=> $curso_palestra[$i],
	  'escola' 			=> $escola[$i],
	  'ano' 			=> $ano[$i],
	  'horas'			=> $horas[$i],
	  'tipo'			=> $tipo[$i],
	  'edit'			=> 1,
	  
	);
	
	if($id_curso_palestra[$i])
	{
		$qryCursos = $wpdb->update(BD_CURSOS_PALEST, $var4, array('id' => $id_curso_palestra[$i]), $format = null, $where_format = null );

	}else{
		$qryCursos = $wpdb->insert(BD_CURSOS_PALEST, $var4 );
	}
	
	if($qryCursos == false && $qryCursos != 0) { 
		
		$wpdb->show_errors(); 
		
		$wpdb->print_error();
		
		exit;
		
	}
}
?>

