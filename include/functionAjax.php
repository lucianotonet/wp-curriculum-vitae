<?php

#######################################################################################################
#Adicionando funções para executar scripts em AJAX
add_action('wp_ajax_wpcvp_curriculoStatus', 		'wpcvp_curriculoStatus');
add_action('wp_ajax_nopriv_wpcvp_curriculoStatus', 	'wpcvp_curriculoStatus');

add_action('wp_ajax_wpcvp_checkCpf', 				'wpcvp_checkCpf');
add_action('wp_ajax_nopriv_wpcvp_checkCpf', 		'wpcvp_checkCpf');

add_action('wp_ajax_wpcvp_carregar_cidade', 		'wpcvp_carregar_cidade');
add_action('wp_ajax_nopriv_wpcvp_carregar_cidade', 	'wpcvp_carregar_cidade');

add_action('wp_ajax_wpcvp_carregar_bairro', 		'wpcvp_carregar_bairro');
add_action('wp_ajax_nopriv_wpcvp_carregar_bairro', 	'wpcvp_carregar_bairro');

add_action('wp_ajax_wpcvp_verificarArquivo', 		'wpcvp_verificarArquivo');
add_action('wp_ajax_nopriv_wpcvp_verificarArquivo', 'wpcvp_verificarArquivo');

add_action('wp_ajax_wpcvp_editArea', 				'wpcvp_editArea');
add_action('wp_ajax_nopriv_wpcvp_editArea', 		'wpcvp_editArea');

#######################################################################################################
#Funções dos scripts AJAX

function wpcvp_curriculoStatus(){
	
	/*
		Função que salva o status do cadastrado alternando entre "Aprovado" e "Reprovado".
		Quando é criado um novo registro, o status do mesmo já é salvo como aguardando.
		Representação das opções dos status com seu número indicativo:
		Aguardando 	=> 0
		Reprovado	=> 1
		Aprovado 	=> 2
	*/

	global $wpdb;
	global $_POST;
		
	$id_cadastro = $_POST['id_registro'];
	$status 	 = $_POST['status'];
			
	$var = array('status' => $status);

	$qry = $wpdb->update( BD_CURRICULO, $var, array('id' => $id_cadastro), $format = null, $where_format = null );
	
	if($qry == false && $qry != 0) { 
		
		$wpdb->show_errors(); 
		
		$wpdb->print_error();
		
		exit;
		
	}elseif($status == 2){	
		include(plugin_dir_path( __FILE__ ) . 'emails/aprovado.php');
	}
		
}


function wpcvp_checkCpf(){
	
	/*
		Função verifica se o número do CPF existe, se sim retorna um valor, se não volta zero.
	*/

	global $wpdb;
	global $_POST;
		
	$cpf = $_POST['cpf'];

	$sqlCheckCpf = "SELECT cpf FROM ".BD_CURRICULO." where cpf = '".$cpf."'";
    $queryCheckCpf = $wpdb->get_results( $sqlCheckCpf );
	
	$check = array();
	
	echo sizeof($queryCheckCpf);
	
}


function wpcvp_carregar_cidade(){

	/*
		Função que retorna uma listagem de cidades em cima do estado que está recebendo.
	*/
	
	global $wpdb;
	global $_POST;
		
	$estado = $_POST['estado'];
	
	$optionCidade = "";
	$optionCidade .= "<option value=\"\">Selecione a cidade</option>";
	
	$sqlCidade = "SELECT cidade FROM ".BD_CURRICULO." where 1=1 and estado = '".$estado."' group by cidade";
	$queryCidade = $wpdb->get_results( $sqlCidade );
	foreach($queryCidade as $kC => $vC){
         $optionCidade .= "<option value=\"".$vC->cidade."\">".$vC->cidade."</option>";
	}
	
	echo $optionCidade;
	
}


function wpcvp_carregar_bairro(){

	/*
		Função que retorna uma listagem de bairro em cima da cidade que está recebendo.
	*/
	
	global $wpdb;
	global $_POST;
		
	$estado = $_POST['estado'];
	$cidade = $_POST['cidade'];
	
	$optionBairro = "";
	$optionBairro .= "<option value=\"\">Selecione o bairro</option>";
	
	$sqlBairro = "SELECT bairro FROM ".BD_CURRICULO." where 1=1 and estado = '".$estado."' and cidade = '".$cidade."' group by bairro";
	$queryBairro = $wpdb->get_results( $sqlBairro );
	foreach($queryBairro as $kB => $vB){
         $optionBairro .= "<option value=\"".$vB->bairro."\">".$vB->bairro."</option>";
	}
	
	echo $optionBairro;
	
}


function wpcvp_verificarArquivo(){

	/*
		Função que verifica se arquivo do registro existe.
	*/

	global $wpdb;
	global $_POST;
		
	$arquivo = $_POST['arquivo'];
	
	$array 	= explode("\\", $arquivo);
	$ext 	= explode(".", $array[count($array)-1]);
	
	#print_r($array);
	echo $ext[count($ext)-1];
	
}


function wpcvp_editArea(){

	/*
		Função que faz a edição do nome do registro.
		Quando clicado no nome do registro irá aparecer o nome dentro de um input,
		com a possibilidade de redigitar o nome, e quando clicado na imagem de ok,
		será atualizado em banco.
	*/

	global $wpdb;
	global $_POST;
		
	$id 	= $_POST['rel'];
	$texto 	= $_POST['texto'];
			
	$var = array('area' => $texto);

	// Guardar os valores na tabela
	$qry = $wpdb->update( BD_AREA_SERVICOS, $var, array('id' => $id), $format = null, $where_format = null );
	
	if($qry == false && $qry != 0) { 
		
		$wpdb->show_errors(); 
		
		$wpdb->print_error();
		
		exit;
		
	}else{	
		echo 1;
		echo $id;
		echo $texto;
	}
		
}

?>