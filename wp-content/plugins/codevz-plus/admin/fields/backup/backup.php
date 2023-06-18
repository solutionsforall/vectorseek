<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access pages directly.
/**
 *
 * Field: Backup
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if( ! class_exists( 'Codevz_Field_backup' ) ) {
  class Codevz_Field_backup extends Codevz_Fields {

    public function __construct( $field, $value = '', $unique = '', $where = '' ) {
      parent::__construct( $field, $value, $unique, $where );
    }

    public function output() {

      $nonce   = wp_create_nonce( 'csf_backup' );
      $options = get_option( $this->unique );
      $export  = esc_url( add_query_arg( array(
        'action'  => 'codevz-framework-export-options',
        'export'  => $this->unique,
        'wpnonce' => $nonce
      ), admin_url( 'admin-ajax.php' ) ) );

      if( ! empty( $options['_transient'] ) ) {
        unset( $options['_transient'] );
      }

      echo $this->element_before();

      echo '<textarea name="_nonce" class="codevz-import-data"></textarea>';
      echo '<a href="#" class="button button-primary codevz-confirm codevz-import-js">'. esc_html__( 'Import a Backup', 'codevz' ) .'</a>';
      echo '<small>( '. esc_html__( 'copy-paste your backup string here', 'codevz' ).' )</small>';

      echo '<hr />';
      
      echo '<textarea name="_nonce" class="codevz-export-data" disabled="disabled">'. codevz_encode_string( $options ) .'</textarea>';
      echo '<a href="'. $export .'" class="button button-primary" target="_blank">'. esc_html__( 'Export and Download Backup', 'codevz' ) .'</a>';

      echo '<hr />';
      echo '<a href="#" class="button button-primary codevz-warning-primary codevz-confirm codevz-reset-js">'. esc_html__( 'Reset All Options', 'codevz' ) .'</a>';
      echo '<small class="codevz-text-warning">'. esc_html__( 'Please be sure for reset all of framework options, You will lose current theme options and custom sidebars.', 'codevz' ) .'</small>';

      echo '<div class="codevz-data" data-unique="'. $this->unique .'" data-wpnonce="'. $nonce .'"></div>';

      echo $this->element_after();

    }

  }
}
