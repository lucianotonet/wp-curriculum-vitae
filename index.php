<?php
/*
Plugin Name: WP-Currículo Vitae - Premium
Plugin URI: https://github.com/tonetlds/wp-curriculo-vitae
Description: O WP-Curriculo Premium Vitae é um plugin que permite que usuarios a cadastrem seu curriculo no site para divulgacao online ou para uso do site. Originalmente desenvolvido por William Luis da Silva (http://www.williamluis.com.br/)
Version: 5.0.8
Author: Luciano Tonet
Author URI: http://www.lucianotonet.com/
License: GPLv2
GitHub Plugin URI: https://github.com/tonetlds/wp-curriculo-vitae
*/

include_once(plugin_dir_path( __FILE__ ) . 'include/config.php') ;

#Registamos a função para correr na ativação do plugin
register_activation_hook( __FILE__, 	'wpcvp_install' );

#Cria o banco de dados e a pasta onde vai ser salvo os arquivos
add_action('init', 						'wpcvp_create_table' );

#Inicia a sessão
add_action('init', 						'wpcvp_iniciarSessao', 1);

add_action( 'admin_head', 				'wpcvp_icone' );

add_action('wp_head',					'wpcvp_ajaxurl');

#shortcode que chama formulario de cadastro
add_shortcode( 'formCadastro_cvp', 		'wpcvp_formulario');
	
#shortcode para listar os currículos
add_shortcode( 'listCurriculos_cvp',	'wpcvp_lista_curriculos' );

#Cria um painel do plugin no administrativo do wordpress
add_action('admin_menu', 				'wpcvp_configuracoes');

#Criando um widget de busca de curriculo
add_action( 'widgets_init', create_function( '', 'register_widget( "formBuscar_wp_premium" );' ) );
include( plugin_dir_path( __FILE__ ) . 'classes/buscar.php' );	

#Onde é chamado os CSSs do plugin - Visual externo do plugin
add_action('wp_print_styles', 'wpcvp_estilos');

#Fecha a sessão
add_action('wp_login', 	'wpcvp_fecharSessao');

register_deactivation_hook( __FILE__, 'wpcvp_unistall' );

function wpcvp_install() {
	define('DISALLOW_FILE_EDIT', true );

  // Vamos testar a versão do PHP e do WordPress
  // caso as versões sejam antigas, desativamos
  // o nosso plugin.

  if ( version_compare( PHP_VERSION, '5.2.1', '<' )
    or version_compare( get_bloginfo( 'version' ), '3.3', '<' ) ) {
      deactivate_plugins( basename( __FILE__ ) );
  }
}

#Função que faz instalação do banco e cria a pasta
function wpcvp_create_table() {
  include_once( plugin_dir_path( __FILE__ ) . 'install.php' );
}

function wpcvp_iniciarSessao() {
	$proto = strtolower(preg_replace('/[^a-zA-Z]/','',$_SERVER['SERVER_PROTOCOL'])); //pegando só o que for letra 
  
	if($_GET){
	
		$location = $proto.'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."&";
		
	}else{
		
		$location = $proto.'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."?";
		
	}
	
	$path = $location;

	#register Cadastro Currículo - Login widget
	add_action( 'widgets_init', create_function( '', 'register_widget( "formLogin_wp_premium" );' ) );
	include( plugin_dir_path( __FILE__ ) . 'classes/formLogin.php' );	
	
	if(!session_id()) {
        
		session_start();
		
    }
    	
	$logout = @$_GET['logout'];
	
	
	if($logout == 1){
		session_destroy ();
	}
}

function wpcvp_icone(){
	wp_enqueue_style( 'wpcvp_Style', plugins_url('css/wp_curriculo_style.css', __FILE__) );
}


function wpcvp_ajaxurl() {
	wp_enqueue_script('jquery');
?>

<script type="text/javascript">
var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';

/*Função Pai de Mascaras*/
function Mascara(o,f){
		v_obj=o
		v_fun=f
		setTimeout("execmascara()",1)
}

/*Função que Executa os objetos*/
function execmascara(){
		v_obj.value=v_fun(v_obj.value)
}

/*Função que Determina as expressões regulares dos objetos*/
function leech(v){
		v=v.replace(/o/gi,"0")
		v=v.replace(/i/gi,"1")
		v=v.replace(/z/gi,"2")
		v=v.replace(/e/gi,"3")
		v=v.replace(/a/gi,"4")
		v=v.replace(/s/gi,"5")
		v=v.replace(/t/gi,"7")
		return v
}

/*Função que permite apenas numeros*/
function Integer(v){
		return v.replace(/\D/g,"")
}

/*Função que padroniza CPF*/
function Cpf(v){
		v=v.replace(/\D/g,"")                                   
		v=v.replace(/(\d{3})(\d)/,"$1.$2")         
		v=v.replace(/(\d{3})(\d)/,"$1.$2")         
																						 
		v=v.replace(/(\d{3})(\d{1,2})$/,"$1-$2")

		return v
}
</script>
<?php
}

#funcão que faz o cadastro
function wpcvp_formulario() {
	ob_start();
	  
	include_once( plugin_dir_path( __FILE__ ) . 'formulario.php' );
	  
	$formCadastro = ob_get_contents();
	ob_end_clean();
	
	return $formCadastro;
}

function wpcvp_lista_curriculos() {
	
	ob_start();
	
	include_once( plugin_dir_path( __FILE__ ) . 'lista_curriculos.php' );
	
	$listCurriculos = ob_get_contents();
	
	ob_end_clean();
	
	return $listCurriculos;
}

function wpcvp_configuracoes() {
	
	#Cria um menu dentro do menu options
	add_menu_page( 'WP-Currículo Vitae Premium', 'Currículo Vitae', 'manage_options', URL_INF, 'curriculo_vitae_premium', '' );
	
	#Submenu de informações
	add_submenu_page(URL_INF, NAME_INF, NAME_INF, 'manage_options', URL_INF, 'curriculo_vitae_premium', '');
	
	#Submenu para configurações
	add_submenu_page(URL_INF, NAME_CONFIG, NAME_CONFIG, 'manage_options', URL_CONFIG,'wpcvp_configuracao_emails', '');
	
	#Submenu para fazer um novo cadastro
	add_submenu_page(URL_INF, NAME_FOR_REG, NAME_FOR_REG, 'manage_options', URL_FOR_REG, 'wpcvp_formulario_admin' );
	
	#Submenu que exibe a lista de currículos cadastrados
	add_submenu_page(URL_INF, NAME_LIST_CURR, NAME_LIST_CURR, 'manage_options', URL_LIST_CURR, 'wpcvp_lista_curriculos_admin' );
	
	#Submenu que exibe as áreas de serviços cadastrada e possibilita cadastrar novas áreas  
	add_submenu_page(URL_INF, NAME_AREA_SERV, NAME_AREA_SERV, 'manage_options', URL_AREA_SERV, 'wpcvp_areas' );

}

// Interior da página de Opções.
// Esta função imprime o conteúdo da página no ecrã.
// O HTML necessário encontra-se já escrito.
function curriculo_vitae_premium() {
	include_once( plugin_dir_path( __FILE__ ) . 'admin/informativo.php' );
}

function wpcvp_configuracao_emails() {
	include_once( plugin_dir_path( __FILE__ ) . 'admin/configuracao_emails.php' );
}


function wpcvp_formulario_admin() {
	include_once( plugin_dir_path( __FILE__ ) . 'admin/formulario.php' );
}

function wpcvp_lista_curriculos_admin() {
	include_once( plugin_dir_path( __FILE__ ) . 'admin/lista_curriculos.php' );
}

function wpcvp_areas() {
	include_once( plugin_dir_path( __FILE__ ) . 'admin/lista_area_servicos.php' );
}


include_once(plugin_dir_path( __FILE__ ) . 'include/functionAjax.php') ;

function wpcvp_estilos() {
	include_once( plugin_dir_path( __FILE__ ) . 'style.php' );
}


function wpcvp_fecharSessao() {
    session_destroy ();
}

function wpcvp_unistall(){
	include_once( plugin_dir_path( __FILE__ ) . 'uninstall.php' );
}

// AJAX HANDLER
add_action( 'wp_ajax_set_readed', 'set_readed' );
function set_readed() {
	global $wpdb; // this is how you get access to the database

	$change = $wpdb->get_row( "UPDATE `".$wpdb->prefix."wls_curriculo` SET `new` = '0' WHERE `".$wpdb->prefix."wls_curriculo`.`id` = ".$_POST['id'] );

	$check = $wpdb->get_var( "SELECT * FROM `".$wpdb->prefix."wls_curriculo` WHERE `id` = ".$_POST['id'] );

	echo $check;

	wp_die(); // this is required to terminate immediately and return a proper response
}


// ADD TOP MENU
add_action( 'admin_bar_menu', 'toolbar_curriculos', 999 );

function toolbar_curriculos( $wp_admin_bar ) {

	global $wpdb; // this is how you get access to the database
	
	$count = $wpdb->get_var( "SELECT COUNT(*) FROM `".$wpdb->prefix."wls_curriculo` WHERE `new` = 1" );	

	$args = array(
		'id'    => 'lista-de-curriculos-premium-admin',
		'title' => 'Currículos',
		'href'  => admin_url().'admin.php?page=lista-de-curriculos-premium-admin',
		'meta'  => array( 'class' => '' )
	);
	$wp_admin_bar->add_node( $args );
}


// WOrDPRESS NOTICE
function sample_admin_notice__success() {

	global $wpdb; // this is how you get access to the database
	
	$count = $wpdb->get_var( "SELECT COUNT(*) FROM `".$wpdb->prefix."wls_curriculo` WHERE `new` = 1" );	

	if( $count == 1 ){
		$count = ' um';
		$label = ' novo currículo';
	}else
	if( $count > 1 ){
		$count = ' '.$count;
		$label = ' novos currículos';
	}else{
		$count = '';
		$label = '';
	}


	if ($count) {
		?>
	    <div class="notice notice-success is-dismissible">
	        <p><span class="dashicons dashicons-id-alt"></span> Você possui <a href="<?php echo admin_url().'admin.php?page=lista-de-curriculos-premium-admin'; ?>"><?php echo $count.$label ?></a>!</p>
	    </div>
	    <?php
	}
}
add_action( 'admin_notices', 'sample_admin_notice__success' );