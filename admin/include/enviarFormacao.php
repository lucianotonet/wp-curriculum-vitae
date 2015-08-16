<?php

$wpcvp->zerarEdit(BD_FORMA_ACADE, $id_cadastro);	

for ($i=0; $i<count($id_formacao); $i++) { 
	#echo $quantidade; 
	#echo "<br/>";
	#echo $i; 
	
	$var2 = array(
	
	  'id_cadastro' 			=> $id_cadastro,
	  'subtitulo' 				=> $subtitulo[$i],
	  'status' 					=> $status[$i],
	  'iniciou' 				=> $iniciou[$i],
	  'finalizou'				=> $finalizou[$i],
	  'escola_faculdade'		=> $escola_faculdade[$i],
	  'cidade_escola_faculdade' => $cidade_escola_faculdade[$i],
	  'estado_escola_faculdade'	=> $estado_escola_faculdade[$i],
	  'formacao'				=> $formacao[$i],
	  'edit' 					=> 1,
	);
	
	if($id_formacao[$i]){
		
		$qryFormacao = $wpdb->update(BD_FORMA_ACADE, $var2, array('id' => $id_formacao[$i]), $format = null, $where_format = null );
		
	}else{
		
		$qryFormacao = $wpdb->insert(BD_FORMA_ACADE, $var2 );
		
	}
	
	if($qryFormacao == false && $qryCursos != 0) { 
		
		$wpdb->show_errors(); 
		
		$wpdb->print_error();
		
		exit;
		
	}
}
#exit;

?>

