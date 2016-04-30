<?php

global $wpdb, $wpcvp;

if(isset($_POST['salvar'])){
	require_once("include/enviarOptions.php");
}

$sqlOp = "SELECT * FROM ".BD_CONFIGURACOES." where 1=1 and id=1";
		
$queryOp = $wpdb->get_results( $sqlOp, ARRAY_A );

foreach($queryOp as $kOp => $vOp){
	$dadosOp = $vOp;
}

wp_enqueue_style('wpcvpa_style', plugins_url('css/style.css', __FILE__));             
#wp_enqueue_style('wpcva_bootstrap', plugins_url('../css/bootstrap.min.css', __FILE__));

wp_enqueue_script('jquery');	
wp_enqueue_script('wpcvpa_bootstrapJS', plugins_url('../js/bootstrap.min.js', __FILE__));
wp_enqueue_script('wpcvpa_script', plugins_url('js/script.js', __FILE__));

?>
<div class="container-fluid">
    <h2><?php echo NAME_CONFIG ?></h2>
    <p>Para usar as informações do cadastrado no e-mail usar os comandos abaixo:</p>
    <div class="row">
    	<div class="col-md-1">
        	<strong>@senha</strong><br />
          <strong>@nome</strong><br />
          <strong>@email</strong><br />
          <strong>@cpf</strong><br />
          <strong>@cep</strong><br />
          <strong>@rua</strong><br />
          <strong>@bairro</strong><br />
		  </div>
      <div class="col-md-1">
        	<strong>@cidade</strong><br />
          <strong>@estado</strong><br />
          <strong>@numero</strong><br />
          <strong>@telefone</strong><br />
          <strong>@celular</strong><br />
          <strong>@site_blog</strong><br />
          <strong>@skype</strong><br />

      </div>
    </div>
    

<?php 
if($_POST['salvar']){ 
	include(plugin_dir_path( __FILE__ ) . 'include/enviarOptions.php');  
}
?>
	
<?php if(@$_GET['msg']==1){ ?>

  <div class="alert alert-success" style="text-align:center;">Salvo com sucesso!</div>	
  
<?php } ?>

	<form method="post">
		<h3>Configura&ccedil;&otilde;es de e-mail cadastro</h3>
    
        <div class="form-group">
          <label class="control-label cep">Assunto:</label>
          <div class="controls">
            <input type="text" name="assunto_cadastro" id="assunto_cadastro" value="<?php echo $dadosOp['assunto_cadastro'];?>" class="form-control" /> 
          </div>
        </div>
        
        <div class="form-group">
          <label class="control-label cep">Mensagem:</label>
          <div class="controls">
            
            <?php /*<textarea name="mensagem_cadastro" class="form-control" id="wpcvp_mensagem_cadastro"><?php echo $dadosOp['mensagem_cadastro'];?></textarea> */ ?>
            
            <?php wp_editor( $dadosOp['mensagem_cadastro'], 'wpcvp_mensagem_cadastro', $settings = array('textarea_name' => mensagem_cadastro) ); ?>
            
          </div>
        </div>
        
        <h3>Configura&ccedil;&otilde;es de e-mail cadastro para o admin</h3>
    
        <div class="form-group">
          <label class="control-label cep">Assunto:</label>
          <div class="controls">
            <input type="text" name="assunto_cadastro_admin" id="assunto_cadastro_admin" value="<?php echo $dadosOp['assunto_cadastro_admin'];?>" class="form-control" /> 
          </div>
        </div>
        
        <div class="form-group">
          <label class="control-label cep">Mensagem:</label>
          <div class="controls">
            <?php /*<textarea name="mensagem_cadastro_admin" class="form-control" id="wpcvp_mensagem_cadastro_admin"><?php echo $dadosOp['mensagem_cadastro_admin'];?></textarea> */?>
            
            <?php wp_editor( $dadosOp['mensagem_cadastro_admin'], 'wpcvp_mensagem_cadastro_admin', $settings = array('textarea_name' => mensagem_cadastro_admin) ); ?>
            
          </div>
        </div>
    
    	<h3>Configura&ccedil;&otilde;es de e-mail esqueceu a senha</h3>
        
        <div class="form-group">
          <label class="control-label">Assunto:</label>
          <div class="controls">
            <input type="text" name="assunto_esqueceu" id="assunto_esqueceu" value="<?php echo $dadosOp['assunto_esqueceu'];?>" class="form-control" /> 
          </div>
        </div>
        
        <div class="form-group">
          <label class="control-label">Mensagem:</label>
          <div class="controls">
            <?php /*<textarea name="mensagem_esqueceu" class="form-control" id="wpcvp_mensagem_esqueceu"><?php echo $dadosOp['mensagem_esqueceu'];?></textarea> */?>
            
            <?php wp_editor( $dadosOp['mensagem_esqueceu'], 'wpcvp_mensagem_esqueceu', $settings = array('textarea_name' => mensagem_esqueceu) ); ?>
          </div>
        </div>
        
        <h3>Configura&ccedil;&otilde;es de e-mail de aprova&ccedil;&atilde;o</h3>
        
        <div class="form-group cep">
          <label class="control-label">Assunto:</label>
          <div class="controls">
            <input type="text" name="assunto_aprovacao" id="assunto_aprovacao" value="<?php echo $dadosOp['assunto_aprovacao'];?>" class="form-control" /> 
          </div>
        </div>
        
        <div class="form-group cep">
          <label class="control-label cep">Mensagem:</label>
          <div class="controls">
            <?php /*<textarea name="mensagem_aprovacao" class="form-control" id="wpcvp_mensagem_aprovacao"><?php echo $dadosOp['mensagem_aprovacao'];?></textarea>*/?>
            <?php wp_editor( $dadosOp['mensagem_aprovacao'], 'wpcvp_mensagem_aprovacao', $settings = array('textarea_name' => mensagem_aprovacao) ); ?>
          </div>
        </div>
		
        <h3>Personalizar configura&ccedil;&otilde;es de remetente</h3>
        
        <div class="row">
        	
            <div class="col-md-5">
            	<div class="form-group">
                  <label class="control-label">Nome:</label>
                  <div class="controls">
                    <input type="text" name="nome" id="email_envio" value="<?php echo $dadosOp['nome'];?>" class="form-control" /> 
                  </div>
                </div>
            </div>
            
            <div class="col-md-5">
            	<div class="form-group">
                  <label class="control-label">E-mail:</label>
                  <div class="controls">
                    <input type="text" name="email" id="email_envio" value="<?php echo $dadosOp['email'];?>" class="form-control" /> 
                  </div>
                </div>
            </div>
            
        </div>
        
        <button type="submit" name="salvar" id="cadastrar" class="btn btn-primary">Salvar</button>
        
    </form>

    
</div>
