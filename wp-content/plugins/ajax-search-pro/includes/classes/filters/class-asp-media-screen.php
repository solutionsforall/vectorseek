<?php
if (!defined('ABSPATH')) die('-1');

if (!class_exists("WD_ASP_MediaScreen_Filter")) {
	/**
	 * Class WD_ASP_MediaScreen_Filter
	 *
	 * Displays the media content field
	 *
	 * @class         WD_ASP_MediaScreen_Filter
	 * @version       1.0
	 * @package       AjaxSearchPro/Classes/Filters
	 * @category      Class
	 * @author        Ernest Marcinko
	 */
	class WD_ASP_MediaScreen_Filter extends WD_ASP_Filter_Abstract {
		/**
		 * Static instance storage
		 *
		 * @var self
		 */
		protected static $_instance;

		public function handle( $form_fields = array(), $post = null ) {
			$field_value = get_post_meta( $post->ID, '_asp_attachment_text', true );

			if ( $field_value !== '' ) {
				$form_fields['asp_attachment_text'] = array(
					'value' => $field_value,
					'label' => __( 'Content (not editable)' ),
					'helps' => __( 'Parsed content by Ajax Search Pro Media Parser service' ),
					'input'  => 'textarea'
				);
			}

			return $form_fields;
		}

		// ------------------------------------------------------------
		//   ---------------- SINGLETON SPECIFIC --------------------
		// ------------------------------------------------------------
		public static function getInstance() {
			if ( ! ( self::$_instance instanceof self ) ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}
	}
}