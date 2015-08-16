<?php

global $wpdb;

require_once (dirname( __FILE__ ).'/../../../../wp-includes/class-phpmailer.php');
require_once (dirname( __FILE__ ).'/../../../../wp-includes/class-smtp.php');

$cpf = $_POST['cpf'];

$wls_curriculo_options 			= $wpdb->prefix . 'wls_curriculo_options';
$wls_curriculo 					= $wpdb->prefix . 'wls_curriculo';
$wls_areas 						= $wpdb->prefix . 'wls_areas';

$sql = "SELECT a.*,
			   b.area
		
		FROM ".$wls_curriculo." a
		
			left join ".$wls_areas." b
				on a.id_area = b.id
		
		where 1=1 and a.cpf = '".$cpf."'";
		
$query = $wpdb->get_results( $sql, ARRAY_A  );
foreach($query as $k => $v){
	$dados = $v;
}

$caracteres = 8;
$senha = substr(uniqid(rand(), true),0,$caracteres);
$senha2 = $senha;

$var = array(
		'senha' 		=> $senha2,
	  );

$qry = $wpdb->update($wls_curriculo, $var, array('id' => $dados['id']), $format = null, $where_format = null );									

$sqlOp = "SELECT * FROM ".$wls_curriculo_options." where id=1";
		
$queryOp = $wpdb->get_results( $sqlOp, ARRAY_A );

foreach($queryOp as $kOp => $vOp){
	$dadosOp = $vOp;
}

$headers = "";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=utf-8\r\n";
$headers .= "From: ".$dadosOp['nome']." <".$dadosOp['email'].">\r\n";

$sqlCurriculo = "SELECT * FROM ".$wls_curriculo." where cpf='".$cpf."'";
		
$queryCurriculo = $wpdb->get_results( $sqlCurriculo, ARRAY_A );

foreach($queryCurriculo as $kCurriculo => $vCurriculo){
	$dadosCurriculo = $vCurriculo;
}

$subject = $dadosOp['assunto_esqueceu']!=""?$dadosOp['assunto_esqueceu']:"Nova senha foi enviada";

$msge = $dadosOp['mensagem_esqueceu'];

$msge = str_replace('@senha'		, $senha						, $msge);
$msge = str_replace('@nome'			, $dadosCurriculo['nome']		, $msge);
$msge = str_replace('@email'		, $dadosCurriculo['email']		, $msge);
$msge = str_replace('@cpf'			, $dadosCurriculo['cpf']		, $msge);
$msge = str_replace('@cep'			, $dadosCurriculo['cep']		, $msge);
$msge = str_replace('@rua'			, $dadosCurriculo['rua']		, $msge);
$msge = str_replace('@bairro'		, $dadosCurriculo['bairro']		, $msge);
$msge = str_replace('@cidade'		, $dadosCurriculo['cidade']		, $msge);
$msge = str_replace('@estado'		, $dadosCurriculo['estado']		, $msge);
$msge = str_replace('@numero'		, $dadosCurriculo['numero']		, $msge);
$msge = str_replace('@telefone'		, $dadosCurriculo['telefone']	, $msge);
$msge = str_replace('@celular'		, $dadosCurriculo['celular']	, $msge);
$msge = str_replace('@site_blog'	, $dadosCurriculo['site_blog']	, $msge);
$msge = str_replace('@skype'		, $dadosCurriculo['skype']		, $msge);

// Call the wp_mail function, display message based on the result.
if(wp_mail($dadosCurriculo['email'], $subject, $msge,  $headers) ) {
	
	// the message was sent...
    echo '<div class="container-fluid">';
    echo 'Nova senha foi enviado com sucesso para o e-mail <strong>'.$dadosCurriculo['email'].'</strong>.';
	echo '</div>';
	
} else {
    
	// the message was not sent...
	echo '<div class="container-fluid">';
    echo 'Erro ao enviar a mensagem. Tente novamente mais tarde.';
	echo '</div>';
	
}

?>
