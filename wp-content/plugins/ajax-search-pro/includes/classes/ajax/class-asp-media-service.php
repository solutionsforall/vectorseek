<?php
if (!defined('ABSPATH')) die('-1');

if (!class_exists("WD_ASP_MediaService_Handler")) {
	/**
	 * Class WD_ASP_MediaService_Handler
	 *
	 * Handles the media service license activation process
	 *
	 * @class         WD_ASP_MediaService_Handler
	 * @version       1.0
	 * @package       AjaxSearchPro/Classes/Ajax
	 * @category      Class
	 * @author        Ernest Marcinko
	 */
	class WD_ASP_MediaService_Handler extends WD_ASP_Handler_Abstract {
		/**
		 * Static instance storage
		 *
		 * @var self
		 */
		protected static $_instance;

		/**
		 * Keyword Delete handler
		 */
		function handle() {
			include_once(ASP_CLASSES_PATH . 'media/media.inc.php');

			if ( isset($_POST['ms_deactivate']) ) {
				ASP_Media_Service_License::getInstance()->delete();
				ASP_Helpers::prepareAjaxHeaders();
				print 0;
			} else {
				$success = 0;
				if ( isset($_POST['ms_license_key']) ) {
					$r = ASP_Media_Service_License::getInstance()->activate($_POST['ms_license_key']);
					$success = $r['success'];
					$text = $r['text'];
				} else {
					$text = "License key is missing or invalid.";
				}
				ASP_Helpers::prepareAjaxHeaders();
				print_r(json_encode(array(
					'success' => $success,
					'text' => $text
				)));
			}
			exit;
		}

		function deactivate() {
			include_once(ASP_CLASSES_PATH . 'media/media.inc.php');

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