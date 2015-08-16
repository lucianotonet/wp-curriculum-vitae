<?php

global $wpdb;

require_once (dirname( __FILE__ ).'/../../../../wp-includes/class-phpmailer.php');
require_once (dirname( __FILE__ ).'/../../../../wp-includes/class-smtp.php');

//require_once(dirname( __FILE__ )."/../classes/PHPMailer_5.2.4/class.phpmailer.php");
require_once (dirname( __FILE__ ).'/../../../../wp-includes/class-phpmailer.php');
require_once (dirname( __FILE__ ).'/../../../../wp-includes/class-smtp.php');

$wls_curriculo_options 			= $wpdb->prefix . 'wls_curriculo_options';
$wls_curriculo 					= $wpdb->prefix . 'wls_curriculo';

$sqlOp = "SELECT * FROM ".$wls_curriculo_options." where id=1";
		
$queryOp = $wpdb->get_results( $sqlOp, ARRAY_A );

foreach($queryOp as $kOp => $vOp){
	$dadosOp = $vOp;
}

$headers = "";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=utf-8\r\n";
$headers .= "From: ".$dadosOp['nome']." <".$dadosOp['email'].">\r\n";

$sqlCurriculo = "SELECT * FROM ".$wls_curriculo." where id='".$id_cadastro."'";
		
$queryCurriculo = $wpdb->get_results( $sqlCurriculo, ARRAY_A );

foreach($queryCurriculo as $kCurriculo => $vCurriculo){
	$dadosCurriculo = $vCurriculo;
}

$subject = $dadosOp['assunto_aprovacao']!=""?$dadosOp['assunto_aprovacao']:"Seu currículo foi aprovado com sucesso!";

$msge = $dadosOp['mensagem_aprovacao'];

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

wp_mail( $dadosCurriculo['email'], $subject, $msge,  $headers);
/*
// Call the wp_mail function, display message based on the result.
if( wp_mail( $dadosCurriculo['email'], $subject, $msge,  $headers) ) {
    // the message was sent...
    echo 'O cadastro <strong>'.$dadosCurriculo['nome'].'</strong> foi aprovado com sucesso.';
} else {
    // the message was not sent...
    echo 'Erro em provar o cadastro <strong>'.$dadosCurriculo['nome'].'</strong>. Tente novamente mais tarde.';
}*/
?>
