<?php
global $wpdb, $wpcvp;

foreach ($_POST as $key=>$value){
	${$key} = $value;
}
	
if($_POST["id"]){
	$id = $_POST["id"];
}elseif($_SESSION['id']){
	$id = $_SESSION['id'];
}

$sqlV = "SELECT a.*
		   
		   	FROM ".BD_CURRICULO." a
		   
		   		where a.id = '".$_POST["id_cadastro"]."'";
		
		
$queryV = $wpdb->get_results( $sqlV );
foreach($queryV as $kV => $vV){
	$dadosV = $vV;
}

if($_POST["area"]){
	
	$area 		= $_POST["area"];

	// A Hora a que o usuário acessou
	$current_time = current_time( 'mysql' );
	
	// Checamos se não existe nenhum registo procedemos
	$var = array(
	  'area' 		=> $area,
	);
	
	$wpdb->insert(BD_AREA_SERVICOS, $var );
	
	$id_area = $wpdb->insert_id;
}

$senha = md5($senha);

#echo "senha banco: ".$dadosV->senha;
#echo "<br/>";
#echo "senha novo: ".$senha;

if($senha == "" || $senha == "d41d8cd98f00b204e9800998ecf8427e"){
  	$senha = $dadosV->senha;
}else{
  	$senha = md5($_POST['senha']);
}

#echo "<br/>";
#echo "senha atualizado: ".$senha;


// A Hora a que o usuário acessou
$current_time = current_time( 'mysql' );

$nome2 			= str_replace(" ", "", $nome);
$uploaddir 		= dirname(__FILE__)."/../../../../../wp-content/uploads/curriculos/";

if($_FILES['curriculo']['name']){
			  
	$tipoArquivo 	= explode(".", $_FILES['curriculo']['name']);
	
	if(@$_SESSION['tipoF']=="site"){
		
		@unlink("wp-content/uploads/curriculos/".@$_SESSION['curriculo']);
		$_SESSION['curriculo'] = $nome2.".".$tipoArquivo[1];
		
	}elseif(@$_POST['tipoF']=="admin"){
		
		@unlink("wp-content/uploads/curriculos/".@$dado['curriculo']);
		$dado['curriculo'] = $nome2.".".$tipoArquivo[1];
		
	}
	
	$curriculo = $nome2.".".$tipoArquivo[1];
	
	#echo $uploaddir. $curriculo;
	#exit;
	move_uploaded_file($_FILES['curriculo']['tmp_name'], $uploaddir. $curriculo);

}elseif($_FILES['curriculo']['name'] == "" && $curriculoCar != ""){
	
	$tipoArquivo = explode(".", @$curriculoCar);
	$nomeNovo = $nome2.".".@$tipoArquivo[1];
	
	rename(@$uploaddir.@$curriculoCar, @$uploaddir.@$nomeNovo);
	//exit;
	$curriculo = $nomeNovo;

}else{
	$curriculo = "";
}

$var = array(
	'id_area' 		=> $id_area,
	'nome' 			=> $nome,
	'telefone'		=> $telefone,
	'celular'		=> $celular,
	'email' 		=> $email,
	'site_blog'		=> $site_blog,
	'skype' 		=> $skype,
	'estado_civil'	=> $estado_civil,
	'idade' 		=> $idade,
	'sexo' 			=> $sexo,
	'remuneracao' 	=> $remuneracao,

	'login' 		=> $login,
	'senha' 		=> $senha,

	'cpf' 			=> $cpf,
	'cep' 			=> $cep,
	'rua' 			=> $rua,
	'numero' 		=> $numero,
	'bairro' 		=> $bairro,
	'cidade' 		=> $cidade,
	'estado' 		=> $estado,
	'descricao' 	=> $descricao,
	'curriculo' 	=> $curriculo,
);


$proto = strtolower(preg_replace('/[^a-zA-Z]/','',$_SERVER['SERVER_PROTOCOL'])); //pegando só o que for letra 

if($_GET){

	$location = $proto.'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."&";

}else{

	$location = $proto.'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."?";

}
########################################################################################

$path = $wpcvp->removeMsg($location);

$delReg = 0;

if(@$_POST['mod']=="new"){

	$qry = $wpdb->insert(BD_CURRICULO, $var );
	$id_cadastro = $wpdb->insert_id;

	include(dirname(__FILE__)."/../../emails/cadastro.php");
	include(dirname(__FILE__)."/../../emails/cadastro_admin.php");

}

if(@$_POST['mod']=="edit"){

	if(@$_POST['excluirConta']==1){
  
  	$qry = $wpdb->query( $wpdb->prepare( "DELETE FROM ".BD_CURRICULO." WHERE id = %d" , array('id' => $_SESSION['id_cadastro']) ) );			
	
	for($iT==0;$iT<count($wpcvp->subTables);$iT++){
	    echo $iT."-".$wpcvp->subTables[$iT]."<br/>";
	    $wpdb->query( $wpdb->prepare( "DELETE FROM ".$wpcvp->subTables[$iT]." WHERE id_cadastro = %d" , array('id_cadastro' => $_SESSION['id_cadastro']) ) );
	}
  
  	$delReg = 1;
  
	}

	if(isset($_POST['id_cadastro'])){
  
  	$qry = $wpdb->update(BD_CURRICULO, $var, array('id' => $_POST['id_cadastro']), $format = null, $where_format = null );		
  	$id_cadastro = $_POST['id_cadastro'];
  
	}
}


if($delReg != 1){

	include( plugin_dir_path( __FILE__ ) . 'enviarFormacao.php' );
	include( plugin_dir_path( __FILE__ ) . 'enviarExperiencia.php' );
	include( plugin_dir_path( __FILE__ ) . 'enviarCursos.php' );
	include( plugin_dir_path( __FILE__ ) . 'enviarIdiomas.php' );
	include( plugin_dir_path( __FILE__ ) . 'enviarConhecimento.php' );

}

if(@$_POST['mod']=="edit"){
	#####################################################################################################
	#Apagar tabelas que está com o campo edit em zero
	$wpcvp->deletarZero($wpcvp->subTables, $id_cadastro);
	#######################################################################################################
}

if($qry == false && $qry != 0) { 
	$wpdb->show_errors(); 
	$wpdb->print_error();

	exit;

}else{

	if(@$_POST['tipoF']=="admin"){

		$msg = @$_POST['mod']=="new"?"&msg=1":"&msg=2";
  	echo "<script>location.href='?page=formulario-premium-admin&id_cadastro=".$id_cadastro."".$msg."'</script>";  
  
	}elseif(@$_POST['tipoF']=="site"){
  
	  	if(@$_POST['excluirConta']==1){
		  
			$msg = "&msg=3";
		  	echo "<script>location.href='".$path."&logout=1".$msg."'</script>";
		  
	  	}else{

	  	  	$msg = @$_POST['mod']=="new"?"&msg=1":"&msg=2";
		  	echo "<script>location.href='".$path."".$msg."'</script>";
	  	}
  
	}
}
	
?>

