<?php
/**
 * Adds Foo_Widget widget.
 */
class formLogin_wp_premium extends WP_Widget {
	
		
	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct(
	 		'wp-curriculo_vitae_login_wp_premium', // Base ID
			'WP-Currículo Vitae Premium - Login', // Name
			array( 'description' => __( 'Entre com seu login e senha para ter acesso ao seu cadastro, para poder editalo.', 'text_domain' ), ) // Args
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {

		global $wpdb;
		include( plugin_dir_path( __FILE__ ) . '../admin/include/funcoes2.php' );
		if(isset($_POST['novaSenha'])){
			include( plugin_dir_path( __FILE__ ) . '../emails/esqueceu_senha.php' );
		}
		
		$proto = strtolower(preg_replace('/[^a-zA-Z]/','',$_SERVER['SERVER_PROTOCOL'])); //pegando só o que for letra 
  
		if($_GET){
		
			$location = $proto.'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."&";
			
		}else{
			
			$location = $proto.'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."?";
			
		}
		
		$path = $location;
		
		if(isset($_POST['logar'])){	
			
			$login = $_POST['login'];
			$senha = $_POST['senha'];
			$senha2 = md5($senha);
			
			$sqlL = "SELECT a.*,
				  b.area,
				  c.id as id_formacao,
				  c.subtitulo,
				  c.iniciou,
				  c.finalizou,
				  c.escola_faculdade,
				  c.cidade_escola_faculdade,
				  c.estado_escola_faculdade,
				  c.status as fStatus,
				  c.formacao,
			   	  d.id as id_experiencia,
				  d.empresa,
				  d.ano_inicio,
				  d.ano_final,
				  d.cargo,
				  d.site_empresa,
				  d.mais_cargo,
				  d.status_ep,
			   	  e.id as id_curso_palestra,
				  e.curso_palestra,
				  e.escola,
				  e.ano,
				  e.horas,
				  e.tipo,
				  f.iInicio,
				  f.iFinal,
				  f.iEscola,
				  f.iCurso,
				  f.iNivel,
				  f.iDescricao,
				  f.iCursando,
				  g.ctCurso,
				  g.ctNivel

		   
		   FROM ".BD_CURRICULO." a
		   
		   		left join ".BD_AREA_SERVICOS." b
				on a.id_area = b.id
				
				left join ".BD_FORMA_ACADE." c
					on c.id_cadastro = a.id
					
				left join ".BD_EXPERI_PROFIS." d
					on d.id_cadastro = a.id
					
				left join ".BD_CURSOS_PALEST." e
					on e.id_cadastro = a.id

		      	left join ".BD_IDIOMAS." f
		        	on f.id_cadastro = a.id

		      	left join ".BD_CONHECI_TECNI." g
		        	on g.id_cadastro = a.id
		   
		   		where a.login = '".$login."' and a.senha = '".$senha2."'";
			
			
			$queryL = $wpdb->get_results( $sqlL );
			foreach($queryL as $kL => $vL){
				$dadosL = $vL;
			}
			
			$nome 			= $dadosL->nome;
			$status 		= $dadosL->status;
			$id_cadastro 	= $dadosL->id;
			
			if($dadosL->nome != ""){
				$_SESSION['logado'] = 1;
			}else{
				$_SESSION['logado'] = 0;
			}
			
			
			
			$_SESSION['nome'] 			= $nome;
			$_SESSION['status'] 		= $status;
			$_SESSION['id_cadastro'] 	= $id_cadastro;
			
			#print_r($_SESSION);
			#exit;
			
			echo "<script>location.href='".removeMsg2($path)."&naoLogado=2'</script>";

		}else{
			
			if($_GET['naoLogado']){
				
			}else{
				$naoLogado = 1;
			}
			
		}
		
		
		if($_SESSION['logado']==0 && $naoLogado != 1){ ?>
			
            <div class="alert alert-danger" style="color:red;">
                <b>Aviso!</b> Login ou senha incorreta.
            </div>
            
		<?php session_start();}
		
		if($_SESSION['logado']==1 && $_SESSION['status']==0){ ?>
			
            <div class="alert alert-danger" style="color:red;">
                <b>Aviso!</b> Aguardando aprovação de seu cadastro.
            </div>
			
		<?php session_start();}
		
		if($_SESSION['logado']==1 && $_SESSION['status']==1){ ?>
			
            <div class="alert alert-danger" style="color:red;">
                <b>Aviso!</b> Seu cadastro foi recusado.
            </div>
			
		<?php session_start();}
		
		if($_SESSION['logado']==1 && $_SESSION['status']==2){
			
			$sqlO = "SELECT * FROM ".BD_CURRICULO." where id = '".$_SESSION['id_cadastro']."'";
			
			$queryO = $wpdb->get_results( $sqlO );
			foreach($queryO as $kO => $vO){
				$dadosO = $vO;
			}
			
		?>
            <div class="well" style="overflow: hidden;">
                <h4><?php echo $instance['titulo']?></h4>
                Ol&aacute; <strong><?php echo $_SESSION['nome']?$_SESSION['nome']:$dadosO->nome; ?></strong>,<br />
            Para alterar seu cadastro, acesse a página de cadastro. 
                <a href="<?php echo $path ?>&logout=1">Sair</a>
            </div>
        <?php
			
		}else{
			
		?>
            <div class="container-fluid" style="overflow: hidden;">
            <div id="wpcvp_formLoginSenha">
                <h4><?php echo $instance['titulo']?></h4>
            
                <form method="post" id="formLoginSenha">
                  
                  <div class="form-group">
                    <div class="controls">
                      <input type="text" name="login" class="form-control" placeholder="Login" > 
                    </div>
                  </div>
                  
                  <div class="form-group">
                    <div class="controls">
                      <input type="password" name="senha" class="form-control" placeholder="Senha" > 
                    </div>
                  </div>   
    
                  <button type="submit" name="logar" class="btn btn-primary">Logar</button>
                  
                  <span class="help-block" id="wpcvp_linkEsqueceu" style="cursor:pointer;">Esqueceu sua senha? Clique aqui.</span>
                </form>
            </div>
            
            <div id="wpcvp_formEsqueceuSenha" style="display:none;">
                <h4>Esqueceu sua senha</h4>
                
                <form method="post" >
                  <div class="form-group">
                    <div class="controls">
                      <input type="text" name="cpf" id="cpf" maxlength="14" onkeydown="Mascara(this,Cpf);" onkeypress="Mascara(this,Cpf);" onkeyup="Mascara(this,Cpf);" class="form-control" placeholder="CPF" > 
                    </div>
                  </div>   
                  <button type="submit" name="novaSenha" class="btn btn-primary">Lembrar</button>
                  <br>
                  <span class="help-block" id="wpcvp_linkLogin" style="cursor:pointer;">Voltar para o login.</span>
                </form>
            </div>
           </div>
		<?php
		}
		
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['titulo'] = strip_tags( $new_instance['titulo'] );
		
		return $instance;
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form($instance) {
		if ( isset( $instance[ 'titulo' ] ) ) {
			$titulo = $instance[ 'titulo' ];
		}
		else {
			$titulo = __( 'T&iacute;tulo da widget', 'text_domain' );
		}
	?>
    <p>
    	Esse widget ira colocar um formul&aacute;rio de login, para o us&uacute;ario ter acesso ao seu cadastro e poder modificalo, com forme sua vontade.
    </p>
    <p>
    <label for="<?php echo $this->get_field_id( 'titulo' ); ?>">
        <?php _e( 'T&iacute;tulo da widget' ); ?>
    </label> 
    <input class="widefat" id="<?php echo $this->get_field_id( 'titulo' ); ?>" name="<?php echo $this->get_field_name( 'titulo' ); ?>" type="text" value="<?php echo esc_attr( $titulo ); ?>" />
    </p>

	<?php 
	}

} // class Foo_Widget

?>