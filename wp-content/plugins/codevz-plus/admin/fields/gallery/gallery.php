<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access pages directly.
/**
 *
 * Field: Gallery
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if( ! class_exists( 'Codevz_Field_Gallery' ) ) {
  class Codevz_Field_Gallery extends Codevz_Fields {

    public function __construct( $field, $value = '', $unique = '', $where = '' ) {
      parent::__construct( $field, $value, $unique, $where );
    }

    public function output(){

      echo $this->element_before();

      $value  = $this->element_value();
      $add    = ( ! empty( $this->field['add_title'] ) ) ? $this->field['add_title'] : esc_html__( 'Add Gallery', 'codevz' );
      $edit   = ( ! empty( $this->field['edit_title'] ) ) ? $this->field['edit_title'] : esc_html__( 'Edit Gallery', 'codevz' );
      $clear  = ( ! empty( $this->field['clear_title'] ) ) ? $this->field['clear_title'] : esc_html__( 'Clear', 'codevz' );
      $hidden = ( empty( $value ) ) ? ' hidden' : '';

      echo '<ul>';

      if( ! empty( $value ) ) {

        $values = explode( ',', $value );

        foreach ( $values as $id ) {
          $attachment = wp_get_attachment_image_src( $id, 'thumbnail' );
          echo '<li><img src="'. $attachment[0] .'" alt="Gallery" /></li>';
        }

      }

      echo '</ul>';
      echo '<a href="#" class="button button-primary codevz-button">'. $add .'</a>';
      echo '<a href="#" class="button codevz-edit-gallery'. $hidden .'">'. $edit .'</a>';
      echo '<a href="#" class="button codevz-warning-primary codevz-clear-gallery'. $hidden .'">'. $clear .'</a>';
      echo '<input type="text" name="'. $this->element_name() .'" value="'. $value .'"'. $this->element_class() . $this->element_attributes() .'/>';

      echo $this->element_after();

    }

  }
}
