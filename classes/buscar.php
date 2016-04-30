<?php
/**
 * Adds Foo_Widget widget.
 */
class formBuscar_wp_premium extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct(
	 		'wp-curriculo_vitae_busca_wp_premium', // Base ID
			'WP-Currículo Vitae Premium - Busca', // Name
			array( 'description' => __( 'Pesquise mais r&aacute;pido os curr&iacute;culos com esse widget.', 'text_domain' ), ) // Args
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
	?>
    	
     <div class="wp-curriculo-widgetBuscar">
     	<h4 style="display:block;"><?php echo $instance['titulo']?></h4>
        
		<form method="post" class="formWidgetBusca" action="<?php echo $instance['endereco']?>">
          <input type="text" name="buscar" class="btBuscar" placeholder="Pesquisar currículo..." style="margin-top: -10px;"> 
        </form>
     </div>
    <?php 
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
		$instance['endereco'] = strip_tags( $new_instance['endereco'] );
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
	public function form( $instance ) {
		if ( isset( $instance[ 'endereco' ] ) ) {
			$endereco = $instance[ 'endereco' ];
		}
		else {
			$endereco = __( 'Endere&ccedil;o da listagem', 'text_domain' );
		}
		
		if ( isset( $instance[ 'titulo' ] ) ) {
			$titulo = $instance[ 'titulo' ];
		}
		else {
			$titulo = __( 'T&iacute;tulo da widget', 'text_domain' );
		}
		?>
		<p>
        <label for="<?php echo $this->get_field_id( 'titulo' ); ?>">
			<?php _e( 'T&iacute;tulo da widget' ); ?>
        </label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'titulo' ); ?>" name="<?php echo $this->get_field_name( 'titulo' ); ?>" type="text" value="<?php echo esc_attr( $titulo ); ?>" />
        </p>
        <p>
		<label for="<?php echo $this->get_field_id( 'endereco' ); ?>">
			<?php _e( 'Coloque o endere&ccedil;o da p&aacute;gina que tem a listagem dos curr&iacute;culos: <br/> Nota: Coleque o endere&ccedil;o completo.' ); ?>
        </label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'endereco' ); ?>" name="<?php echo $this->get_field_name( 'endereco' ); ?>" type="text" value="<?php echo esc_attr( $endereco ); ?>" />
		</p>
		<?php 
	}

} // class Foo_Widget

?>