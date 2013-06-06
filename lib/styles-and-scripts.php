<?php
function add_scripts() {

		wp_register_style( 'normalize', get_template_directory_uri() . '/stylesheets/normalize.css', array(), '2013', 'all' );
		wp_register_style( 'foundation-css', get_template_directory_uri() . '/stylesheets/foundation.css', array('normalize'), '2013', 'all' );
		wp_enqueue_style('normalize');
		wp_enqueue_style('foundation-css');

		if ( !is_admin() ) {
		    wp_deregister_script('jquery');
		    wp_register_script('jquery', '//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js', false, null);
		    // wp_register_script('jquery', 'http://code.jquery.com/jquery-2.0.0-beta3.js', false, null);
		    // add_filter('script_loader_src', 'jquery_local_fallback', 10, 2);
		}

		// wp_register_script( 'modernizr-foundation', get_template_directory_uri() . '/javascripts/foundation/modernizr.foundation.js');
		wp_register_script( 'modernizr-foundation', get_template_directory_uri() . '/javascripts/modernizr.min.js');
		wp_enqueue_script( 'modernizr-foundation' );

		wp_register_script( 'app', get_template_directory_uri() . '/javascripts/foundation/app.js', array('jquery'), '2013', true);
		wp_register_script( 'foundation', get_template_directory_uri() . '/javascripts/foundation/jquery.foundation.js', array('jquery'), '2013', true);
		wp_register_script( 'alerts', get_template_directory_uri() . '/javascripts/foundation/jquery.foundation.alerts.js', array('jquery'), '2013', true);
		wp_register_script( 'clearing', get_template_directory_uri() . '/javascripts/foundation/jquery.foundation.clearing.js', array('jquery'), '2013', true);
		wp_register_script( 'cookie', get_template_directory_uri() . '/javascripts/foundation/jquery.foundation.cookie.js', array('jquery'), '2013', true);
		wp_register_script( 'dropdown', get_template_directory_uri() . '/javascripts/foundation/jquery.foundation.dropdown.js', array('jquery'), '2013', true);
		wp_register_script( 'forms', get_template_directory_uri() . '/javascripts/foundation/jquery.foundation.forms.js', array('jquery'), '2013', true);
		wp_register_script( 'joyride', get_template_directory_uri() . '/javascripts/foundation/jquery.foundation.joyride.js', array('jquery'), '2013', true);
		wp_register_script( 'magellan', get_template_directory_uri() . '/javascripts/foundation/jquery.foundation.magellan.js', array('jquery'), '2013', true);
		wp_register_script( 'orbit', get_template_directory_uri() . '/javascripts/foundation/jquery.foundation.orbit.js', array('jquery'), '2013', true);
		wp_register_script( 'placeholder', get_template_directory_uri() . '/javascripts/foundation/jquery.placeholder.js', array('jquery'), '2013', true);
		wp_register_script( 'reveal', get_template_directory_uri() . '/javascripts/foundation/jquery.foundation.reveal.js', array('jquery'), '2013', true);
		wp_register_script( 'section', get_template_directory_uri() . '/javascripts/foundation/jquery.foundation.section.js', array('jquery'), '2013', true);
		wp_register_script( 'tooltips', get_template_directory_uri() . '/javascripts/foundation/jquery.foundation.tooltips.js', array('jquery'), '2013', true);
		wp_register_script( 'topbar', get_template_directory_uri() . '/javascripts/foundation/jquery.foundation.topbar.js', array('jquery'), '2013', true);
		wp_register_script( 'offcanvas', get_template_directory_uri() . '/javascripts/foundation/jquery.offcanvas.js', array('jquery'), '2013', true);
		wp_register_script( 'tabs', get_template_directory_uri() . '/javascripts/foundation/jquery.foundation.tabs.js', array('jquery'), '2013', true);
		wp_register_script( 'mediaQueryToggle', get_template_directory_uri() . '/javascripts/foundation/jquery.foundation.mediaQueryToggle.js', array('jquery'), '2013', true);
		wp_register_script( 'custom', get_template_directory_uri() . '/javascripts/jquery.custom.js', array('jquery', 'foundation'), '2013', true );
		// wp_register_script( '', get_template_directory_uri() . '/javascripts/foundation/jquery..js', array('jquery'), '2013', true );

		// wp_enqueue_script( 'app' );
		wp_enqueue_script( 'foundation' );
		// wp_enqueue_script( 'alerts' );
		// wp_enqueue_script( 'clearing' );
		wp_enqueue_script( 'cookie' );
		// wp_enqueue_script( 'dropdown' );
		// wp_enqueue_script( 'forms' );
		// wp_enqueue_script( 'joyride' );
		// wp_enqueue_script( 'magellan' );
		// wp_enqueue_script( 'orbit' );
		// wp_enqueue_script( 'placeholder' );
		// wp_enqueue_script( 'reveal' );
		// wp_enqueue_script( 'section' );
		wp_enqueue_script( 'tooltips' );
		wp_enqueue_script( 'topbar' );
		// wp_enqueue_script( 'offcanvas' );
		// wp_enqueue_script( 'tabs' );
		// wp_enqueue_script( 'mediaQueryToggle' );
		// wp_enqueue_script( 'custom' );

		// wp_enqueue_script( '' );

}
add_action( 'wp_enqueue_scripts', 'add_scripts', 10 );


// http://wordpress.stackexchange.com/a/12450
function jquery_local_fallback($src, $handle) {
  static $add_jquery_fallback = false;

  if ($add_jquery_fallback) {
    echo '<script>window.jQuery || document.write(\'<script src="' . get_template_directory_uri() . '/javascripts/foundation/jquery.js"><\/script>\')</script>' . "\n";
    $add_jquery_fallback = false;
  }

  if ($handle === 'jquery') {
    $add_jquery_fallback = true;
  }

  return $src;
}