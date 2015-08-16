<?php

#wp_enqueue_style('wpcvp_bootstrap', plugins_url('css/bootstrap.min.css', __FILE__));
wp_enqueue_style('wpcvp_style', plugins_url('css/wp_curriculo_style.css', __FILE__));

wp_enqueue_script('jquery');	
#wp_enqueue_script('wpcvp_bootstrap', plugins_url('js/bootstrap.min.js', __FILE__));
wp_enqueue_script('wpcvp_scriptMask', plugins_url('js/jquery.maskedinput-1.1.4.pack.js', __FILE__));
#wp_enqueue_script('wpcvlightboxjsP', plugins_url('js/wpcv_lightbox.js', __FILE__));
wp_enqueue_script('wpcvp_scriptArea', plugins_url('js/scriptArea.js', __FILE__));
wp_enqueue_script('wpcvp_script', plugins_url('js/script.js', __FILE__));


?>