<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access pages directly.
/**
 *
 * Field: Color Picker
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if( ! class_exists( 'Codevz_Field_color_picker' ) ) {
  class Codevz_Field_color_picker extends Codevz_Fields {

    public function __construct( $field, $value = '', $unique = '', $where = '' ) {
      parent::__construct( $field, $value, $unique, $where );
    }

    public function output() {

      echo $this->element_before();
      echo '<input type="text" name="'. $this->element_name() .'" value="'. esc_html( $this->element_value() ) .'"'. $this->element_class('codevz-wp-color-picker') . $this->element_attributes( $this->extra_attributes() ) .'/>';
      echo $this->element_after();

    }

    public function extra_attributes() {

      $atts = array();

      if( isset( $this->field['id'] ) ) {
        $atts['data-depend-id'] = $this->field['id'];
      }

      if ( isset( $this->field['rgba'] ) &&  $this->field['rgba'] === false ) {
        $atts['data-rgba'] = 'false';
      }

      if( isset( $this->field['default'] ) ) {
        $atts['data-default-color'] = $this->field['default'];
      }

      return $atts;

    }

  }
}
