<?php
/* Prevent direct access */
defined('ABSPATH') or die("You can't access this file directly.");

/**
 * Class aspInit
 *
 * AJAX SEARCH PRO initializator Class
 */
class WD_ASP_Init {

	/**
	 * Core singleton class
	 * @var WD_ASP_Init self
	 */
	private static $_instance, $new_install = false;

	private function __construct() {
		wd_asp()->db = WD_ASP_DBMan::getInstance();
		// @TODO 4.10.5
		/*
		wd_asp()->instant = new WD_ASP_Instant(array(
			'table_name' => 'asp_instant'
		));
		*/

		// Before the ASP_Helpers::previousVersion is ever executed, _asp_version option does not exist
		if ( get_option('_asp_version', false) === false ) {
			self::$new_install = true;
		}

		load_plugin_textdomain( 'ajax-search-pro', false, ASP_DIR . '/languages' );
	}

	/**
	 * Runs on activation OR if this->safety_check() detects a silent change
	 */
	public function activate() {

		// Includes the index table creation as well
		WD_ASP_DBMan::getInstance()->create();

		$this->activation_only_backwards_compatibility_fixes();

		// @TODO 4.10.5

		$this->create_chmod(true);

		// Was the plugin previously installed, and updated?
		if ( ASP_Helpers::previousVersion(ASP_CURR_VER_STRING, '<') ) {
			update_option("asp_recently_updated", 1);
		}

		set_transient('asp_just_activated', 1);

		// Add functions to asp_scheduled_activation_events to schedule background process events to the activation hook
		wp_schedule_single_event( time() + 15, 'asp_scheduled_activation_events' );
	}

	/**
	 *  Checks if the user correctly updated the plugin and fixes if not
	 */
	public function safety_check() {

		// Run the re-activation actions if this is actually a newer version
		if ( ASP_Helpers::previousVersion(ASP_CURR_VER_STRING, '<', true) ) {
			$this->activate();
			// Run a backwards compatibility check
			$this->backwards_compatibility_fixes();
			asp_generate_the_css();
			// Take a note on the recent update
			update_option("asp_recently_updated", 1);
		} else {
			// Was the plugin just activated, without version change?
			if ( get_transient('asp_just_activated') !== false ) {
				// Check the folders, they might have been deleted by accident
				$this->create_chmod();
				// Run a backwards compatibility check
				$this->backwards_compatibility_fixes();
				asp_generate_the_css();
				delete_transient('asp_just_activated');
			}
		}
	}

	/**
	 * Fix known backwards incompatibilities, only running at plugin activation
	 */
	public function activation_only_backwards_compatibility_fixes() {
		// Turn off the jquery script versions
		$comp = wd_asp()->o['asp_compatibility'];
		if ( !self::$new_install ) {
			if ( $comp['js_source'] == 'min' || $comp['js_source'] == 'min-scoped' ) {
				wd_asp()->o['asp_compatibility']['js_source'] = 'jqueryless-min';
			} else if ( $comp['js_source'] == 'nomin' || $comp['js_source'] == 'nomin-scoped' ) {
				wd_asp()->o['asp_compatibility']['js_source'] = 'jqueryless-nomin';
			}
			asp_save_option('asp_compatibility');
		}
		// Old way of reatining the browser back button to new one
		if ( isset($comp['js_retain_popstate']) && $comp['js_retain_popstate'] == 1 ) {
			foreach (wd_asp()->instances->get() as $si) {
				$id = $si['id'];
				$sd = $si['data'];
				$sd['trigger_update_href'] = 1;
				wd_asp()->instances->update($id, $sd);
			}
			unset($comp['js_retain_popstate']);
			wd_asp()->o['asp_compatibility'] = $comp;
			asp_save_option('asp_compatibility');
		}
	}

	/**
	 * Fix known backwards incompatibilities
	 */
	public function backwards_compatibility_fixes() {

		// Index table option fixes
		$ito = wd_asp()->o['asp_it_options'];
		if ( isset($ito['it_post_types']) && !is_array($ito['it_post_types']) ) {
			$ito['it_post_types'] = explode('|', $ito['it_post_types']);
			foreach ($ito['it_post_types'] as $ck => $ct) {
				if ( $ct == '' )
					unset($ito['it_post_types'][$ck]);
			}
			wd_asp()->o['asp_it_options']['it_post_types'] = $ito['it_post_types'];
			asp_save_option('asp_it_options');
		}

		$ana = wd_asp()->o['asp_analytics'];
		// Analytics Options fixes 4.18
		if ( isset($ana['analytics']) && $ana['analytics'] == 1 ) {
			wd_asp()->o['asp_analytics']['analytics'] = 'pageview';
			asp_save_option('asp_analytics');
		}

		// 4.18.6 Pool sizes no longer slow down page load on index table options
		delete_option('_asp_it_pool_sizes');


		/*
		 * Search instance option fixes
		 *
		 * - Get instances
		 * - Check options
		 * - Transition to new options based on old ones
		 * - Save instances
		 */
		foreach (wd_asp()->instances->get() as $si) {
			$id = $si['id'];
			$sd = $si['data'];

			// -------------------------- 4.10 ------------------------------
			// Primary and secondary fields
			$values = array('-1', '0', '1', '2', 'c__f');
			$adv_fields = array(
				'primary_titlefield',
				'secondary_titlefield',
				'primary_descriptionfield',
				'secondary_descriptionfield'
			);
			foreach($adv_fields as $field) {
				// Force string conversion for proper comparision
				if ( !in_array($sd[$field].'', $values) ) {
					// Custom field value is selected
					$sd[$field.'_cf'] = $sd[$field];
					$sd[$field] = 'c__f';
				}
			}
			// -------------------------- 4.10 ------------------------------

			// ------------------------- 4.10.4 -----------------------------
			// Autocomplete aggreagated to one option only.
			if ( isset($sd['autocomplete_mobile']) ) {
				if ( $sd['autocomplete_mobile'] == 1 && $sd['autocomplete'] == 1 ) {
					$sd['autocomplete'] = 1;
				} else if ( $sd['autocomplete_mobile'] == 1 ) {
					$sd['autocomplete'] = 3;
				} else if ( $sd['autocomplete'] == 1 ) {
					$sd['autocomplete'] = 2;
				} else {
					$sd['autocomplete'] = 0;
				}
				unset($sd['autocomplete_mobile']);
			}
			// ------------------------- 4.10.4 -----------------------------

			// ------------------------- 4.11 -------------------------------
			// Autocomplete aggreagated to one option only.
			if ( !isset($sd['frontend_fields']['unselected']) )
				$sd['frontend_fields']['unselected'] = array();
			if ( isset($sd['showexactmatches'], $sd['exactmatchestext']) ) {
				$sd['frontend_fields']['labels']['exact'] = $sd['exactmatchestext'];
				if ($sd['showexactmatches'] == 0) {
					$sd['frontend_fields']['unselected'][] = 'exact';
					$sd['frontend_fields']['selected'] =
						array_diff( $sd['frontend_fields']['selected'], array('exact') );
				}
			}
			if ( isset($sd['showsearchintitle'], $sd['searchintitletext']) ) {
				$sd['frontend_fields']['labels']['title'] = $sd['searchintitletext'];
				if ($sd['showsearchintitle'] == 0) {
					$sd['frontend_fields']['unselected'][] = 'title';
					$sd['frontend_fields']['selected'] =
						array_diff( $sd['frontend_fields']['selected'], array('title') );
				}
			}
			if ( isset($sd['showsearchincontent'], $sd['searchincontenttext']) ) {
				$sd['frontend_fields']['labels']['content'] = $sd['searchincontenttext'];
				if ($sd['showsearchincontent'] == 0) {
					$sd['frontend_fields']['unselected'][] = 'content';
					$sd['frontend_fields']['selected'] =
						array_diff( $sd['frontend_fields']['selected'], array('content') );
				}
			}
			if ( isset($sd['showsearchinexcerpt'], $sd['searchinexcerpttext']) ) {
				$sd['frontend_fields']['labels']['excerpt'] = $sd['searchinexcerpttext'];
				if ($sd['showsearchinexcerpt'] == 0) {
					$sd['frontend_fields']['unselected'][] = 'excerpt';
					$sd['frontend_fields']['selected'] =
						array_diff( $sd['frontend_fields']['selected'], array('excerpt') );
				}
			}
			// ------------------------- 4.11 -------------------------------

			// ------------------------- 4.11.6 -----------------------------
			// User meta fields to array
			if ( isset($sd['user_search_meta_fields']) && !is_array($sd['user_search_meta_fields']) ) {
				$sd['user_search_meta_fields'] = explode(',', $sd['user_search_meta_fields']);
				foreach ( $sd['user_search_meta_fields'] as $umk=>$umv ) {
					$sd['user_search_meta_fields'][$umk] = trim($umv);
					if( $sd['user_search_meta_fields'][$umk] == '' )
						unset($sd['user_search_meta_fields'][$umk]);
				}
			}
			// ------------------------- 4.11.6 -----------------------------

			// ------------------------- 4.11.10 ----------------------------
			// Before, this was a string
			if ( isset($sd['customtypes']) && !is_array($sd['customtypes']) ) {
				$sd['customtypes'] = explode('|', $sd['customtypes']);
				foreach ($sd['customtypes'] as $ck => $ct) {
					if ( $ct == '' )
						unset($sd['customtypes'][$ck]);
				}
			}
			// No longer exists
			if ( isset($sd['selected-customtypes']) )
				unset($sd['selected-customtypes']);
			// No longer exists
			if ( isset($sd['searchinpages']) ) {
				if ( $sd['searchinpages'] == 1 && !in_array('page', $sd['customtypes']) ) {
					array_unshift($sd['customtypes'] , 'page');
				}
				unset($sd['searchinpages']);
			}
			// No longer exists
			if ( isset($sd['searchinposts']) ) {
				if ( $sd['searchinposts'] == 1 && !in_array('post', $sd['customtypes']) ) {
					array_unshift($sd['customtypes'] , 'post');
				}
				unset($sd['searchinposts']);
			}
			// ------------------------- 4.11.10 ----------------------------

			// ------------------------- 4.12 -------------------------------
			if ( is_numeric($sd['i_item_width']) ) {
				$sd['i_item_width'] = $sd['i_item_width'].'px';
			}
			// ------------------------- 4.12 -------------------------------

			// ------------------------- 4.13.1 -----------------------------
			$font_sources = array("inputfont", "descfont", "titlefont",
				"authorfont", "datefont", "showmorefont", "groupfont",
				"exsearchincategoriestextfont", "groupbytextfont", "settingsdropfont",
				"prestitlefont", "presdescfont", "pressubtitlefont", "search_text_font");
			if ( isset($sd['inputfont']) && strpos($sd['inputfont'], '--g--') !== false ) {
				/**
				 * Remove the unneccessary --g-- tags and quotes
				 */
				foreach($font_sources as $fk) {
					if ( isset($sd[$fk]) ) {
						$sd[$fk] = str_replace(array('--g--', '"', "'"), '', $sd[$fk]);
					}
				}
			}
			if ( isset($sd['results_order']) && strpos($sd['results_order'], 'peepso') === false ) {
				$sd['results_order'] .= '|peepso_groups|peepso_activities';
			}
			if ( isset($sd['groupby_content_type']) && !isset($sd['groupby_content_type']['peepso_groups']) ) {
				$sd['groupby_content_type']['peepso_groups'] = 'Peepso Groups';
				$sd['groupby_content_type']['peepso_activities'] = 'Peepso Activities';
			}
			// ------------------------- 4.13.1 -----------------------------

			// ------------------------- 4.14.4 -----------------------------
			if ( isset($sd['frontend_fields']['labels']['comments']) ) {
				unset($sd['frontend_fields']['labels']['comments']);
			}
			$sd['frontend_fields']['selected'] = array_diff( $sd['frontend_fields']['selected'], array('comments') );
			$sd['frontend_fields']['unselected'] = array_diff( $sd['frontend_fields']['unselected'], array('comments') );
			$sd['frontend_fields']['checked'] = array_diff( $sd['frontend_fields']['checked'], array('comments') );
			// ------------------------- 4.14.4 -----------------------------

			// ------------------------- 4.14.5 -----------------------------
			// For non-existence checks use the raw_data array
			if ( !isset($si['raw_data']['i_item_width_tablet']) ) {
				$sd['i_item_width_tablet'] = $sd['i_item_width'];
				$sd['i_item_width_phone'] = $sd['i_item_width'];
			}
			// For non-existence checks use the raw_data array
			if ( !isset($si['raw_data']['i_item_height_tablet']) ) {
				$sd['i_item_height_tablet'] = $sd['i_item_height'];
				$sd['i_item_height_phone'] = $sd['i_item_height'];
			}
			// For non-existence checks use the raw_data array
			if ( !isset($si['raw_data']['box_width_tablet']) ) {
				$sd['box_width_tablet'] = $sd['box_width'];
				$sd['box_width_phone'] = $sd['box_width'];
			}
			// ------------------------- 4.14.5 -----------------------------

			// ------------------------- 4.15 -------------------------------
			if ( is_numeric($sd['i_item_height']) ) {
				$sd['i_item_height'] = $sd['i_item_height'].'px';
			}
			if ( is_numeric($sd['i_item_height_tablet']) ) {
				$sd['i_item_height_tablet'] = $sd['i_item_height_tablet'].'px';
			}
			if ( is_numeric($sd['i_item_height_phone']) ) {
				$sd['i_item_height_phone'] = $sd['i_item_height_phone'].'px';
			}
			// ------------------------- 4.15 -------------------------------

			// ------------------------- 4.17 -------------------------------
			if ( !empty($sd['image_default'])
				&& !isset($si['raw_data']['tax_image_default'], $si['raw_data']['tax_image_default']) )
			{
				$sd['tax_image_default'] = $sd['image_default'];
				$sd['user_image_default'] = $sd['image_default'];
			}
			// ------------------------- 4.17 -------------------------------

			// ------------------------- 4.18.2 -----------------------------
			if ( isset($sd['jquery_chosen_nores']) ) {
				$sd['jquery_select2_nores'] = $sd['jquery_chosen_nores'];
			}
			// ------------------------- 4.18.2 -----------------------------

			// ------------------------- 4.18.8 -----------------------------
			if ( !isset($si['raw_data']['tax_res_showdescription']) ) {
				$sd['tax_res_showdescription'] = $sd['showdescription'];
				$sd['user_res_showdescription'] = $sd['showdescription'];
				$sd['tax_res_descriptionlength'] = $sd['descriptionlength'];
				$sd['user_res_descriptionlength'] = $sd['descriptionlength'];
			}
			// ------------------------- 4.18.8 -----------------------------

			// ------------------------- 4.20.5 -----------------------------
			// The mobile settings state can be forced without forcing the hover
			if ( ASP_Helpers::previousVersion('4.20.4') ) {
				if ( $sd['mob_force_sett_hover'] == 0 ) {
					$sd['mob_force_sett_state'] = 'none';
				}
			}
			// ------------------------- 4.20.5 -----------------------------

			// ----------------- Unset some unused search data --------------
			// Leave this here, so it is executed as last
			$values = array(
				// from 4.10
				'magnifierimage_selects', 'settingsimage_selects', 'loadingimage_selects',
				'i_res_magnifierimage_selects', 'i_pagination_arrow_selects', 'keyword_logic_def',
				'user_search_title_field_def', 'frontend_search_settings_position_def', 'term_logic_def',
				'cf_logic_def', 'resultstype_def', 'resultsposition_def', 'box_compact_float_def',
				'box_compact_position_def', 'keyword_suggestion_source_def', 'bpgroupstitle_def', 'bpgroupstitle',
				'settingsimagepos_def', 'blogtitleorderby_def', 'i_ifnoimage_def', 'i_pagination_position_def',
				'weight_def', 'user_search_description_field_def', 'triggeronclick', 'triggeronreturn', 'redirectonclick',
				'redirect_click_to', 'redirect_on_enter', 'redirect_enter_to', 'mob_trigger_on_click',
				// from 4.11
				'showexactmatches', 'exactmatchestext', 'showsearchintitle', 'searchintitletext', 'showsearchincontent',
				'searchincontenttext', 'showsearchincomments', 'searchincommentstext', 'showsearchinexcerpt', 'searchinexcerpttext',
				// from 4.18.2
				'jquery_chosen_nores'
			);
			foreach ($values as $v) {
				if ( isset($sd[$v]) )
					unset($sd[$v]);
			}

			// At the end, update
			wd_asp()->instances->update($id, $sd);
		}
	}

	/**
	 * Extra styles if needed..
	 */
	public function styles() {}

	/**
	 * Prints the scripts
	 */
	public function scripts() {
		wd_asp()->scripts = WD_ASP_Scripts::getInstance();

		if ( !wd_asp()->instances->exists() ) {
			return false;
		}

		$exit1 = apply_filters('asp_load_css_js', false);
		$exit2 = apply_filters('asp_load_js', false);
		if ( $exit1 || $exit2 )
			return false;

		$analytics = wd_asp()->o['asp_analytics'];
		$comp_settings = wd_asp()->o['asp_compatibility'];
		$load_in_footer = $comp_settings['load_in_footer'] == 1;
		$media_query = ASP_DEBUG == 1 ? asp_gen_rnd_str() : get_option("asp_media_query", "defn");
		if ( wd_asp()->manager->getContext() == "backend" ) {
			$css_async_load = false;
			$legacy = false;
			$js_minified = false;
			$js_optimized = true;
			$js_async_load = false;
		} else {
			$css_async_load = $comp_settings['css_async_load'] == 1;
			$legacy = $comp_settings['js_source'] != 'jqueryless-min' && $comp_settings['js_source'] != 'jqueryless-nomin';
			$js_minified = $comp_settings['js_source'] == 'jqueryless-min';
			$js_optimized = $comp_settings['script_loading_method'] != 'classic';
			$js_async_load = $comp_settings['script_loading_method'] == 'optimized_async';
		}

		$single_highlight = false;
		$single_highlight_arr = array();
		$search = wd_asp()->instances->get();
		if (is_array($search) && count($search)>0) {
			foreach ($search as $s) {
				// $style and $id needed in the include
				if ( $s['data']['single_highlight'] == 1 ) {
					$single_highlight = true;
					$single_highlight_arr[] = array(
						'id' => $s['id'],
						'selector' => $s['data']['single_highlight_selector'],
						'scroll' => $s['data']['single_highlight_scroll'] == 1,
						'scroll_offset' => intval($s['data']['single_highlight_offset']),
						'whole' => $s['data']['single_highlightwholewords'] == 1,
					);
				}
			}
		}


		if ( asp_is_asset_required('datepicker') ) {
			wp_enqueue_script('jquery-ui-datepicker');
		}

		$ajax_url = admin_url('admin-ajax.php');
		if ( !is_admin() ) {
			if (  $comp_settings['usecustomajaxhandler'] == 1) {
				$ajax_url = ASP_URL . 'ajax_search.php';
			}
			if ( wd_asp()->o['asp_caching']['caching'] == 1 && wd_asp()->o['asp_caching']['caching_method'] == 'sc_file' ) {
				$ajax_url = ASP_URL . 'sc-ajax.php';
			}
		}

		if (ASP_DEBUG < 1 && strpos($comp_settings['js_source'], "scoped") !== false) {
			$scope = "aspjQuery";
		} else {
			$scope = "jQuery";
		}


		if ( $legacy ) {
			wd_asp()->scripts_legacy = WD_ASP_Scripts_Legacy::getInstance();
			wd_asp()->scripts_legacy->enqueue();
			$handle = 'wd-asp-ajaxsearchpro';
			$additional_scripts = array();
		} else {
			if ( $css_async_load ) {
				$handle = 'wd-asp-async-loader';
				wd_asp()->scripts->enqueue(
					wd_asp()->scripts->get($handle, $js_minified, $js_optimized),
					array(
						'media_query' => $media_query,
						'in_footer' => $load_in_footer
					)
				);
			} else {
				$handle = 'wd-asp-ajaxsearchpro';
			}

			if ( !$js_async_load ) {
				wd_asp()->scripts->enqueue(
					wd_asp()->scripts->get(array(), $js_minified, $js_optimized, array(
						'wd-asp-async-loader', 'wd-asp-prereq-and-wrapper'
					)),
					array(
						'media_query' => $media_query,
						'in_footer' => $load_in_footer
					)
				);
				$additional_scripts = wd_asp()->scripts->get(array(), $js_minified, $js_optimized,
					array('wd-asp-async-loader', 'wd-asp-prereq-and-wrapper', 'wd-asp-ajaxsearchpro-wrapper')
				);
			} else {
				$handle = 'wd-asp-prereq-and-wrapper';
				wd_asp()->scripts->enqueue(
					wd_asp()->scripts->get($handle, $js_minified, $js_optimized),
					array(
						'media_query' => $media_query,
						'in_footer' => $load_in_footer
					)
				);
				$additional_scripts = wd_asp()->scripts->get(array(), $js_minified, $js_optimized,
					array('wd-asp-async-loader',
						'wd-asp-prereq-and-wrapper',
						'wd-asp-ajaxsearchpro-wrapper',
						'wd-asp-ajaxsearchpro-prereq'
					)
				);
			}
		}

		// The new variable is ASP
		ASP_Helpers::objectToInlineScript($handle, 'ASP', array(
			'wp_rocket_exception' => 'DOMContentLoaded',	// WP Rocket hack to prevent the wrapping of the inline script: https://docs.wp-rocket.me/article/1265-load-javascript-deferred
			'ajaxurl' => $ajax_url,
			'backend_ajaxurl' => admin_url('admin-ajax.php'),
			'js_scope' => $scope,
			'asp_url' => ASP_URL,
			'upload_url' => wd_asp()->upload_url,
			'css_basic_url' => asp_get_css_url('basic'),
			'detect_ajax' => w_isset_def($comp_settings['detect_ajax'], 0),
			'media_query' => get_option("asp_media_query", "defn"),
			'version' => ASP_CURR_VER,
			'pageHTML' => '',
			'additional_scripts' => $additional_scripts,
			'script_async_load' => $js_async_load,
			'font_url' =>  asp_is_asset_required('asppsicons2') ? str_replace('http:', "", plugins_url()). '/ajax-search-pro/css/fonts/icons/icons2.woff2' : false,
			'init_only_in_viewport' => $comp_settings['init_instances_inviewport_only'] == 1,
			'scrollbar' => $comp_settings['load_mcustom_js'] == "yes" && asp_is_asset_required('simplebar'),
			'css_async' => $css_async_load,
			'highlight' => array(
				'enabled' => $single_highlight,
				'data' => $single_highlight_arr
			),
			'debug' => ASP_DEBUG == 1 || defined('WP_ASP_TEST_ENV'),
			'instances' => new stdClass(),
			'analytics' => array(
				'method' => $analytics['analytics'],
				'tracking_id' => $analytics['analytics_tracking_id'],
				'string' => $analytics['analytics_string'],
				'event' => array(
					'focus' => array(
						'active' => $analytics['gtag_focus'],
						'action' => $analytics['gtag_focus_action'],
						"category" => $analytics['gtag_focus_ec'],
						"label" =>  $analytics['gtag_focus_el'],
						"value" => $analytics['gtag_focus_value']
					),
					'search_start' => array(
						'active' => $analytics['gtag_search_start'],
						'action' => $analytics['gtag_search_start_action'],
						"category" => $analytics['gtag_search_start_ec'],
						"label" =>  $analytics['gtag_search_start_el'],
						"value" => $analytics['gtag_search_start_value']
					),
					'search_end' => array(
						'active' => $analytics['gtag_search_end'],
						'action' => $analytics['gtag_search_end_action'],
						"category" => $analytics['gtag_search_end_ec'],
						"label" =>  $analytics['gtag_search_end_el'],
						"value" => $analytics['gtag_search_end_value']
					),
					'magnifier' => array(
						'active' => $analytics['gtag_magnifier'],
						'action' => $analytics['gtag_magnifier_action'],
						"category" => $analytics['gtag_magnifier_ec'],
						"label" =>  $analytics['gtag_magnifier_el'],
						"value" => $analytics['gtag_magnifier_value']
					),
					'return' => array(
						'active' => $analytics['gtag_return'],
						'action' => $analytics['gtag_return_action'],
						"category" => $analytics['gtag_return_ec'],
						"label" =>  $analytics['gtag_return_el'],
						"value" => $analytics['gtag_return_value']
					),
					'try_this' => array(
						'active' => $analytics['gtag_try_this'],
						'action' => $analytics['gtag_try_this_action'],
						"category" => $analytics['gtag_try_this_ec'],
						"label" =>  $analytics['gtag_try_this_el'],
						"value" => $analytics['gtag_try_this_value']
					),
					'facet_change' => array(
						'active' => $analytics['gtag_facet_change'],
						'action' => $analytics['gtag_facet_change_action'],
						"category" => $analytics['gtag_facet_change_ec'],
						"label" =>  $analytics['gtag_facet_change_el'],
						"value" => $analytics['gtag_facet_change_value']
					),
					'result_click' => array(
						'active' => $analytics['gtag_result_click'],
						'action' => $analytics['gtag_result_click_action'],
						"category" => $analytics['gtag_result_click_ec'],
						"label" =>  $analytics['gtag_result_click_el'],
						"value" => $analytics['gtag_result_click_value']
					)
				)
			)
		), 'before',true);

		add_action('wp_print_footer_scripts', function() use($handle){
			$script_data = wd_asp()->instances->get_script_data();
			if ( count($script_data) > 0 ) {
				$script = "window.ASP_INSTANCES = [];";
				foreach ( $script_data as $id => $data ) {
					$script .= "window.ASP_INSTANCES[$id] = $data;";
				}
				wp_add_inline_script($handle, $script, 'before');
			}
		}, 0);
	}

	/**
	 *  Create and chmod the upload directory
	 */
	public function create_chmod( $is_activation = false ) {
		if ( $is_activation ) {
			global $wp_filesystem;

			if ( wpd_fs_init(true, 'is_dir') && !$wp_filesystem->is_dir( wd_asp()->upload_path ) ) {
				if ( !$wp_filesystem->mkdir( wd_asp()->upload_path, 0755 ) ) {
					return false;
				} else {
					if ( !@chmod(wd_asp()->upload_path, 0755) ) {
						if ( !@chmod(wd_asp()->upload_path, 0664 ) ){
							@chmod(wd_asp()->upload_path, 0644 );
						}
					}
				}
			}
		} else {
			/**
			 * DO NOT initialize WP_Filesystem() nor $wp_filesystem here!
			 * It causes conflicts later on. Instead just use the native PHP functions.
			 */
			if ( !is_dir( wd_asp()->upload_path ) ) {
				if ( !mkdir( wd_asp()->upload_path, '0777', true ) ) {
					return false;
				} else {
					if ( !@chmod(wd_asp()->upload_path, 0755) ) {
						if ( !@chmod(wd_asp()->upload_path, 0664 ) ){
							@chmod(wd_asp()->upload_path, 0644 );
						}
					}
				}
			}
		}
		return true;
	}

	public function pluginReset( $triggerActivate = true ) {
		$options = array(
			'asp_version',
			'_asp_version',
			'asp_glob_d',
			'asp_performance_def',
			'asp_performance',
			'asp_it_def',
			'asp_it',
			'asp_it_options',
			'asp_analytics_def',
			'asp_analytics',
			'asp_caching_def',
			'asp_caching',
			'asp_compatibility_def',
			'asp_compatibility',
			'asp_defaults',
			'asp_st_override',
			'asp_woo_override',
			'asp_stat',
			'asp_updates',
			'asp_updates_lc',
			'asp_media_query',
			'asp_performance_stats',
			'asp_recently_updated',
			'asp_fonts',
			'_asp_tables',
			'_asp_priority_groups',
			'_asp_it_pool_sizes'
		);
		foreach ($options as $o) {
			delete_option($o);
			delete_site_option($o);
		}

		wp_clear_scheduled_hook('asp_cron_it_extend');

		if ( $triggerActivate )
			$this->activate();
	}

	public function pluginWipe() {
		require_once(ASP_CLASSES_PATH . "cache/cache.inc.php");

		// Options
		$this->pluginReset( false );

		// Meta
		if ( is_multisite() ) {
			global $switched;
			$sites = get_sites(array('fields' => 'ids'));
			foreach ($sites as $site) {
				switch_to_blog($site);
				delete_metadata('post', 1, '_asp_additional_tags', '', true);
				delete_metadata('post', 1, '_asp_metadata', '', true);
				wpd_TextCache::clearDBCache(); // Delete options cache
				restore_current_blog();
			}
		} else {
			delete_metadata('post', 1, '_asp_additional_tags', '', true);
			delete_metadata('post', 1, '_asp_metadata', '', true);
			wpd_TextCache::clearDBCache(); // Delete options cache
		}

		// Database
		wd_asp()->db->delete();

		// Files with safety check for alterations
		if (
			str_replace('/', '', get_home_path()) != str_replace('/', '', wd_asp()->upload_path) &&
			strpos(wd_asp()->upload_path, 'wp-content') > 5 &&
			strpos(wd_asp()->upload_path, 'wp-includes') === false &&
			strpos(wd_asp()->upload_path, 'wp-admin') === false &&
			is_dir( wd_asp()->upload_path )
		) {
			wpd_rmdir( wd_asp()->upload_path  );
			if ( is_dir( wd_asp()->upload_path ) ) {
				wpd_rmdir( wd_asp()->upload_path, true);
				if ( is_dir( wd_asp()->upload_path ) ) {
					// Last attempt, with force
					wpd_rmdir( wd_asp()->upload_path, true, true);
				}
			}
		}
		// Deactivate
		deactivate_plugins(ASP_FILE);
	}


	/**
	 *  If anything we need in the footer
	 */
	public function footer() {

	}

	/**
	 * Get the instane of asp_indexTable
	 *
	 * @return self
	 */
	public static function getInstance() {
		if (!(self::$_instance instanceof self)) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}
}