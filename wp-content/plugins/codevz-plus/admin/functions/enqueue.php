<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access pages directly.
/**
 *
 * Framework admin enqueue style and scripts
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if( ! function_exists( 'codevz_framework_admin_enqueue_scripts' ) ) {

  function codevz_framework_front_enqueue() {
    wp_enqueue_style( 'vc_font_awesome_5_shims', CODEVZ_FRAMEWORK_URL .'/assets/css/font-awesome/css/v4-shims.min.css', array(), '5.11.2', 'all' );
    wp_enqueue_style( 'vc_font_awesome_5', CODEVZ_FRAMEWORK_URL .'/assets/css/font-awesome/css/all.min.css', array(), '5.11.2', 'all' );
  }
  add_action( 'wp_enqueue_scripts', 'codevz_framework_front_enqueue' );

  function codevz_framework_admin_enqueue_scripts() {

    // admin utilities
    wp_enqueue_media();

    // wp core styles
    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_style( 'jquery-ui-datepicker' );

    // framework core styles
    wp_enqueue_style( 'vc_font_awesome_5_shims', CODEVZ_FRAMEWORK_URL .'/assets/css/font-awesome/css/v4-shims.min.css', array(), '5.11.2', 'all' );
    wp_enqueue_style( 'vc_font_awesome_5', CODEVZ_FRAMEWORK_URL .'/assets/css/font-awesome/css/all.min.css', array(), '5.11.2', 'all' );
    wp_enqueue_style( 'codevz-framework', CODEVZ_FRAMEWORK_URL .'/assets/css/codevz.min.css', array(), '1.0.0', 'all' );

    if ( is_rtl() ) {
      wp_enqueue_style( 'codevz-framework-rtl', CODEVZ_FRAMEWORK_URL .'/assets/css/codevz-rtl.min.css', array(), '1.0.0', 'all' );
    }

    // wp core scripts
    wp_enqueue_script( 'wp-color-picker' );
    wp_enqueue_script( 'jquery-ui-sortable' );
    wp_enqueue_script( 'jquery-ui-accordion' );
    wp_enqueue_script( 'jquery-ui-datepicker' );
    wp_enqueue_script( 'jquery-ui-slider' );

    // framework core scripts
    wp_enqueue_script( 'codevz-framework-plugins', CODEVZ_FRAMEWORK_URL .'/assets/js/codevz-plugins.min.js', array(), '1.0.0', true );
    wp_enqueue_script( 'codevz-framework',  CODEVZ_FRAMEWORK_URL .'/assets/js/codevz.min.js', array(), '1.0.0', true );

  }

  add_action( 'admin_enqueue_scripts', 'codevz_framework_admin_enqueue_scripts' );
  add_action( 'elementor/editor/before_enqueue_scripts', 'codevz_framework_admin_enqueue_scripts' );

}
