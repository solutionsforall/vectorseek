<?php if ( ! defined( 'ABSPATH' ) ) {exit;} // Exit if accessed directly.

/**
 * Theme dashboard
 * 
 * @link https://xtratheme.com/
 */

if ( ! class_exists( 'Xtra_Dashboard' ) ) {

	class Xtra_Dashboard {

		private static $instance 	= null;
		private static $slug 		= 'xtra-dashboard';
		private static $activation 	= 'codevz_theme_activation';

		public function __construct() {

			// Ignore check.
			if ( function_exists( 'codevz_ignore_activation' ) ) {
				return;
			}

			// Check features.
			$disable = array_flip( (array) Codevz_Theme::option( 'disable' ) );

			// Check white label for menu.
			if ( ! isset( $disable['menu'] ) ) {

				add_action( 'admin_init', [ $this, 'admin_init' ] );
				add_action( 'admin_menu', [ $this, 'admin_menu' ] );

			}

		}

		public static function instance() {
			if ( self::$instance === null ) {
				self::$instance = new self();
			}
			
			return self::$instance;
		}
		
		// Activation check
		public function admin_init() {
			
			$a = get_option( self::$activation );
			
			// Delete old activations.
			if ( ( isset( $a['type'] ) && $a['type'] === 'free' ) || isset( $a['item_id'] ) ) {
				
				delete_option( self::$activation );

			}

			// Current page.
			global $pagenow;
			
			// Redirect after theme activation.
			if ( "themes.php" == $pagenow && isset( $_GET['activated'] ) ) {

				wp_redirect( esc_url_raw( admin_url( 'admin.php?page=' . self::$slug ) ) );

			}
		}
		
		/**
		 * Get Logo & Tabs HTML
		 * @return string
		 */
		public static function tabs( $page ) {

				$xtra = wp_get_theme();
				$is_plugin_active = is_plugin_active( 'codevz-plus/codevz-plus.php' );

			?>
				<h1 class="cz_hide"></h1>
				<div class="cz_top_info">
					<div class="cz_logo"><img src="<?php echo esc_html( Codevz_Theme::option( 'white_label_welcome_page_logo', 'data:image/png;base64,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' ) ); ?>" alt="XTRA Theme"/></div>
					<div class="cz_theme_name">
						<h2> Welcome to <?php esc_html_e( Codevz_Theme::option( 'white_label_theme_name', 'XTRA' ) ); ?> WordPress Theme </h2>
						<h3 style="opacity:.5"> Current version: <?php esc_html_e( $xtra->get( 'Version' ) ); ?></h3>
					</div>
				</div>

				<h2 class="nav-tab-wrapper">
					<a href="<?php echo esc_url( admin_url( 'admin.php?page=' . self::$slug ) ); ?>" class="nav-tab <?php echo ($page =='welcome' ? 'nav-tab-active' : '') ; ?>">
						<?php esc_html_e('Welcome', 'codevz'); ?>
					</a>

					<?php if ( ! TGM_Plugin_Activation::get_instance()->is_tgmpa_complete() ) { ?>
						<a href="<?php echo esc_url( admin_url( 'themes.php?page=tgmpa-install-plugins' ) ); ?>" class="nav-tab">
							<?php esc_html_e('Install Plugins', 'codevz'); ?>
						</a>
					<?php } ?>

					<?php if ( ! is_array( get_option( self::$activation ) ) || ! $is_plugin_active ) { ?>
						<a href="#" class="nav-tab cz_not_act">
							<img src="data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTkuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgdmlld0JveD0iMCAwIDUxMiA1MTIiIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDUxMiA1MTI7IiB4bWw6c3BhY2U9InByZXNlcnZlIiB3aWR0aD0iMTZweCIgaGVpZ2h0PSIxNnB4Ij4KPGc+Cgk8Zz4KCQk8cGF0aCBkPSJNNDM3LjMzMywxOTJoLTMydi00Mi42NjdDNDA1LjMzMyw2Ni45OSwzMzguMzQ0LDAsMjU2LDBTMTA2LjY2Nyw2Ni45OSwxMDYuNjY3LDE0OS4zMzNWMTkyaC0zMiAgICBDNjguNzcxLDE5Miw2NCwxOTYuNzcxLDY0LDIwMi42Njd2MjY2LjY2N0M2NCw0OTIuODY1LDgzLjEzNSw1MTIsMTA2LjY2Nyw1MTJoMjk4LjY2N0M0MjguODY1LDUxMiw0NDgsNDkyLjg2NSw0NDgsNDY5LjMzMyAgICBWMjAyLjY2N0M0NDgsMTk2Ljc3MSw0NDMuMjI5LDE5Miw0MzcuMzMzLDE5MnogTTI4Ny45MzgsNDE0LjgyM2MwLjMzMywzLjAxLTAuNjM1LDYuMDMxLTIuNjU2LDguMjkyICAgIGMtMi4wMjEsMi4yNi00LjkxNywzLjU1Mi03Ljk0OCwzLjU1MmgtNDIuNjY3Yy0zLjAzMSwwLTUuOTI3LTEuMjkyLTcuOTQ4LTMuNTUyYy0yLjAyMS0yLjI2LTIuOTktNS4yODEtMi42NTYtOC4yOTJsNi43MjktNjAuNTEgICAgYy0xMC45MjctNy45NDgtMTcuNDU4LTIwLjUyMS0xNy40NTgtMzQuMzEzYzAtMjMuNTMxLDE5LjEzNS00Mi42NjcsNDIuNjY3LTQyLjY2N3M0Mi42NjcsMTkuMTM1LDQyLjY2Nyw0Mi42NjcgICAgYzAsMTMuNzkyLTYuNTMxLDI2LjM2NS0xNy40NTgsMzQuMzEzTDI4Ny45MzgsNDE0LjgyM3ogTTM0MS4zMzMsMTkySDE3MC42Njd2LTQyLjY2N0MxNzAuNjY3LDEwMi4yODEsMjA4Ljk0OCw2NCwyNTYsNjQgICAgczg1LjMzMywzOC4yODEsODUuMzMzLDg1LjMzM1YxOTJ6IiBmaWxsPSIjMDAwMDAwIi8+Cgk8L2c+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPC9zdmc+Cg==" />
							<?php esc_html_e('Demo Importer', 'codevz'); ?>
						</a>
						<a href="#" class="nav-tab cz_not_act">
							<img src="data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTkuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgdmlld0JveD0iMCAwIDUxMiA1MTIiIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDUxMiA1MTI7IiB4bWw6c3BhY2U9InByZXNlcnZlIiB3aWR0aD0iMTZweCIgaGVpZ2h0PSIxNnB4Ij4KPGc+Cgk8Zz4KCQk8cGF0aCBkPSJNNDM3LjMzMywxOTJoLTMydi00Mi42NjdDNDA1LjMzMyw2Ni45OSwzMzguMzQ0LDAsMjU2LDBTMTA2LjY2Nyw2Ni45OSwxMDYuNjY3LDE0OS4zMzNWMTkyaC0zMiAgICBDNjguNzcxLDE5Miw2NCwxOTYuNzcxLDY0LDIwMi42Njd2MjY2LjY2N0M2NCw0OTIuODY1LDgzLjEzNSw1MTIsMTA2LjY2Nyw1MTJoMjk4LjY2N0M0MjguODY1LDUxMiw0NDgsNDkyLjg2NSw0NDgsNDY5LjMzMyAgICBWMjAyLjY2N0M0NDgsMTk2Ljc3MSw0NDMuMjI5LDE5Miw0MzcuMzMzLDE5MnogTTI4Ny45MzgsNDE0LjgyM2MwLjMzMywzLjAxLTAuNjM1LDYuMDMxLTIuNjU2LDguMjkyICAgIGMtMi4wMjEsMi4yNi00LjkxNywzLjU1Mi03Ljk0OCwzLjU1MmgtNDIuNjY3Yy0zLjAzMSwwLTUuOTI3LTEuMjkyLTcuOTQ4LTMuNTUyYy0yLjAyMS0yLjI2LTIuOTktNS4yODEtMi42NTYtOC4yOTJsNi43MjktNjAuNTEgICAgYy0xMC45MjctNy45NDgtMTcuNDU4LTIwLjUyMS0xNy40NTgtMzQuMzEzYzAtMjMuNTMxLDE5LjEzNS00Mi42NjcsNDIuNjY3LTQyLjY2N3M0Mi42NjcsMTkuMTM1LDQyLjY2Nyw0Mi42NjcgICAgYzAsMTMuNzkyLTYuNTMxLDI2LjM2NS0xNy40NTgsMzQuMzEzTDI4Ny45MzgsNDE0LjgyM3ogTTM0MS4zMzMsMTkySDE3MC42Njd2LTQyLjY2N0MxNzAuNjY3LDEwMi4yODEsMjA4Ljk0OCw2NCwyNTYsNjQgICAgczg1LjMzMywzOC4yODEsODUuMzMzLDg1LjMzM1YxOTJ6IiBmaWxsPSIjMDAwMDAwIi8+Cgk8L2c+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPC9zdmc+Cg==" />
							<?php esc_html_e('Theme Options', 'codevz'); ?>
						</a>
					<?php } else { ?>
						<a href="<?php echo esc_url( admin_url( 'customize.php?&autofocus[section]=codevz_theme_options-demos' ) ); ?>" class="nav-tab">
							<?php esc_html_e('Demo Importer', 'codevz'); ?>
						</a>
						<a href="<?php echo esc_url( admin_url( 'customize.php' ) ); ?>" class="nav-tab">
							<?php esc_html_e('Theme Options', 'codevz'); ?>
						</a>
					<?php } ?>

					<a href="<?php echo esc_url( admin_url( 'admin.php?page=codevz-doc' ) ); ?>" class="nav-tab <?php echo ($page =='doc' ? 'nav-tab-active' : '') ; ?>">
						<?php esc_html_e('Documentation & Support', 'codevz'); ?>
					</a>
				</h2>
			<?php
		}

		/**
		 * Get theme styles
		 * @return string
		 */
		public static function styles() {
			?>
			<style>
		@import url('https://fonts.googleapis.com/css?family=Nunito:400,700');
		.wrap *{outline:none;}
		.wrap a{text-decoration: none}
		#message{display: none;}

		.wrap {
			font-family: "Nunito";
			margin: 20px 20px 0 2px;
			background: #f8f8f8;
			float: left;
			width: 98%;
			box-sizing: border-box;
			padding: 0 30px 30px;
			box-shadow: 0 1px 15px rgba(0,0,0,.04),0 1px 6px rgba(0,0,0,.04);
			border-radius: 2px;
		}
		.wrap h2{font-weight: 600}
		.wrap h3 {
		font-size: 16px;
		margin-bottom: 25px;
		}
		.wrap h4 {
		font-size: 14px;
		font-weight: 400;
		}
		.nav-tab-wrapper, .wrap h2.nav-tab-wrapper{
			background: #d8d8d8;
			margin: 0 -30px;
			padding: 15px 20px 0 20px;	
			border: none;
			box-shadow: inset 0 0 14px rgba(0,0,0,.1);
		}
		.nav-tab {
			line-height: 1;
			padding: 16px 16px 20px;
			font-size: 14px;
			color: #282828;
			background: none;
			border-radius: 2px 2px 0 0;
			border: none;
			margin-bottom: -4px
		}
		.nav-tab-active,.nav-tab:hover{
			background: #f8f8f8;
			color:#282828;
		}

		.cz_box{
			float: left;
			background: #fff;
			box-shadow: 0 1px 15px rgba(0,0,0,.04),0 1px 6px rgba(0,0,0,.04);
			width: 100%;
			box-sizing: border-box;
			border-radius: 2px;
			padding: 50px;
			margin-top: 30px;
			min-height: 350px;
		}

		.cz_box2{width:49%;margin-right: 2%;}
		.cz_box4{width:23.5%;margin-right: 2%;min-height: 445px;}

		.cz_box_end{margin-right:0}
		
		.cz_box h2{
			font-size: 24px;
			margin:10px 0 30px;
			border-bottom: solid 1px #ddd;
			padding-bottom: 20px;
			position: relative;
		}
		.cz_box h2::after {
			content: "";
			width: 50px;
			height: 3px;
			background: #ffae00;
			position: absolute;
			left: 0;
			bottom: -2px;
		}

		.cz_box{font-size:18px;}

		#setting-error-tgmpa{
			display: none;
			margin: 25px 0 0;
			box-shadow: 0 1px 15px rgba(0,0,0,.04),0 1px 6px rgba(0,0,0,.04);
			border-radius: 3px;
			padding: 15px 45px;
		}

		.cz_button {
			line-height: 30px;
			padding: 4px 20px;
			border: none;
			background: #ffae00;
			color: #282828;
			border-radius: 3px;
			font-size: 14px;
			cursor: pointer;
			text-decoration: none;
			text-shadow: 0 0 1px rgba(0,0,0,.4);
			float: left;
			position: relative;
			transition: all .2s ease-in-out
		}
		.cz_button.cz_button2 {
			background: rgba(167, 167, 167, 0.5)
		}
		.cz_button:hover,.cz_button.cz_button2:hover {
			background: #282828;
			color: #ffae00
		}
		.cz_button_activation {
			position: absolute;
			right: 10px;
			top: 9px;
			height: 32px;
			line-height: 30px;
			padding: 0 20px;
		}
		.cz_button_a {padding: 9px 18px}
		.cz_button_a i {margin-right: 10px}
		.rtl .cz_button_a i {margin-right:0;margin-left: 10px}
		.cz_button_a img {width: 22px;position: absolute;left: 15px;top: 14px;}
		.cz_button_a:hover {color:#fff;}
		input.cz_code {
			height: 50px;
			line-height: 50px;
			padding: 20px;
			width: 100%;
			border-radius: 3px;
			box-shadow: none;
		}
		input.cz_code::placeholder{color:#aaa;}
		.cz_top_info{
			margin: 0 -30px;
			padding: 25px 30px;
		}
		.cz_logo {
			float: left;
			margin-right: 30px;
			padding: 19px 19px 14px;
			width: 88px;
			height: 88px;
			box-sizing: border-box;
			background: #fff;
			box-shadow: 0 1px 15px rgba(0,0,0,.04), 0 1px 6px rgba(0,0,0,.04);
			margin-left: -3px;
			border-radius: 2px;
		}
		.cz_logo img {
			width:50px
		}
		.cz_theme_name h2{font-size: 24px;font-weight: 700;margin-bottom: 10px}
		.cz_theme_name h3{font-size: 14px;font-weight: 500;}
		.cz_hide{display: none;}

		.cz_grn{color:#00ca98;font-size: 20px !important;}

		.cz_good, .cz_error{
			color: #fff;
			background: #00ca98;
			padding: 2px 6px 2px;
			font-size: 12px;
			border-radius: 3px;
			margin: 0 10px;
		}
		.cz_error {
			background: rgba(215, 3, 3, 0.7);
		}
		.cz_rd{
		    color: rgba(215, 3, 3, 0.7);
		    background: rgba(215, 3, 3, 0.04);
		    border: 1px solid rgba(215, 3, 3, 0.13);
		    padding: 30px;
		}
		.cz_ul {
			font-size: 16px;
			list-style: circle;
			margin: 20px
		}
		.cz_ul li {
			margin-bottom: 16px
		}

		.cz_faq{
			border: solid 1px #e5e5e5;
			border-radius: 2px;
			margin-bottom: 20px;
			padding: 17px 25px;
			box-shadow: 0 0 10px rgba(0,0,0,.07);
		}

		.cz_q b{cursor: pointer;font-size: 16px;color:#0073aa;opacity: .7}
		.cz_q b:hover{opacity:1}
		.cz_a {color: #777;display: none}
		.cz_a p{margin-bottom: 0}

		.cz_ula{font-size: 14px;margin-bottom: 30px;}
		.cz_ula li{margin-bottom: 10px;}
		.cz_ula li a{color: #0073aa;text-decoration: none}
		.cz_ula li a:hover{opacity:1}

		a:focus{box-shadow: none}
		a.cz_button:focus{color:#fff}
		@media only screen and (max-width: 767px) {
			.cz_box,.cz_box2,.cz_box4{width:100%;margin-right: 0;padding: 30px}
			 h2 .nav-tab{width:100%;border-bottom: none;border-radius: 2px;box-sizing: border-box;}
		}
		.cz_85{width: 85%;position: relative;}
		.cz_fl{float: left;}
		.cz_fr{float: right;}

		.cz_not_act{cursor: not-allowed;opacity: .4}
		.cz_not_act img{width: 14px;opacity: .6;}

		.cz_ul_details {
		    font-size: 18px;
		    margin-bottom: 50px;
		}
		.cz_ul_details span {
		    font-size: 16px;
		    opacity: .6;
		    margin: 18px 0 10px;
		    display: inline-block;
		}
	span.xtra-renew {
		margin-top: 0;
		margin-bottom: 0;
	}
	.xtra-renew a {
		display: inline-block;
		margin-left: 20px;
		font-size: 13px;
		font-weight: 600;
		background: #fff;
		color: #282828;
		padding: 8px 16px;
		border-radius: 2px;
		border: solid 2px #ffae00;
	}
		</style>
		<?php
		}

		/**
		 * Add admin menus
		 * @return array
		 */
		public function admin_menu() {

			// Icon.
			$icon = 'data:image/svg+xml;bas'.'e6'.'4,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIyMTEiIGhlaWdodD0iMjEzIiB2aWV3Qm94PSIwIDAgMjExIDIxMyI+IDxkZWZzPiA8c3R5bGU+IC5jbHMtMSB7IGZpbGw6ICNmZmY7IGZpbGwtcnVsZTogZXZlbm9kZDsgfSA8L3N0eWxlPiA8L2RlZnM+IDxwYXRoIGlkPSJDb2xvcl9GaWxsXzEiIGRhdGEtbmFtZT0iQ29sb3IgRmlsbCAxIiBjbGFzcz0iY2xzLTEiIGQ9Ik01Mi41MzMsMTYuMDI4Qzg2LjUyLDE1LjIxMSwxMTMuMDQ2LDQyLjYyLDk3LjgsNzcuMTM4Yy01LjcxNSwxMi45NDQtMTkuMDU0LDIwLjQ1LTMxLjk1NiwyMy45MTMtOS40NTIsMi41MzctMTkuMjY2LTEuNzQzLTIzLjk2Ny00LjQyOC0zLjM5NC0xLjkzOS02Ljk1LTIuMDI2LTkuNzY0LTQuNDI4LTguODQ0LTcuNTUtMjAuODIxLTI2Ljk1Ni0xNC4yLTQ2LjA1NGE0OC41NjEsNDguNTYxLDAsMCwxLDIzLjA4LTI2LjU3QzQ0Ljc1NywxNy42NTMsNDkuMTkzLDE4LjIxNyw1Mi41MzMsMTYuMDI4Wm05NC4wOTQsMGMxMS45MjItLjIxLDIyLjAyMS43MywyOS4yOTMsNS4zMTQsMTQuODkxLDkuMzg2LDI4LjYwNSwzNy45NDQsMTUuMDkxLDU5LjMzOS01Ljk2LDkuNDM2LTE3LjAxMiwxNy4yNjMtMjkuMjkzLDIwLjM3SDE0MS4zYy02LjYwOSwxLjYzOC0xNS40OTUsNC45NDktMjAuNDE3LDguODU3LTEwLjI0Niw4LjEzNi0xNi4wMjgsMjAuNS0xOS41MjgsMzUuNDI2djE5LjQ4NWMtNS4wMzYsMTguMDY4LTIzLjkxNywzOC45MTEtNDkuNzEsMzIuNzY5LTQuNzI0LTEuMTI0LTExLjA1Mi0yLjc3OC0xNS4wOS01LjMxMy01LjcxNC0zLjU4OC05LjU2LTkuMzgyLTEzLjMxNS0xNS4wNTdhNDUuMTUzLDQ1LjE1MywwLDAsMS02LjIxNC0xNC4xN2MtMS45LTcuODkzLjQ5NC0xNS4zNjgsMi42NjMtMjEuMjU2LDMuOTM5LTEwLjY5Myw5LjgyMi0yMC4yOTEsMTkuNTI5LTI0LjgsOC4zNTctMy44ODEsMTguMTcyLTIuNDgxLDI4LjQwNi01LjMxNCwxMi40NjYtMy40NTEsMjUuOTctMTAuMjYzLDMyLjg0NC0xOS40ODRBNjkuMTM5LDY5LjEzOSwwLDAsMCwxMTEuMTIsNjkuMTY3VjU0LjExMWMxLjQ2My02LjM1NywyLjk4NC0xMy42NzcsNi4yMTQtMTguNkMxMjIuMSwyOC4yNTYsMTMxLjEsMjEuMzE5LDEzOS41MjYsMTcuOCwxNDEuOTIsMTYuOCwxNDQuNzQ1LDE3LjI3MiwxNDYuNjI3LDE2LjAyOFptNTEuNDg1LDU0LjAyNWMwLjcxNCwwLjkuMzE1LDAuMjQzLDAuODg4LDEuNzcxaC0wLjg4OFY3MC4wNTNabS00Ni4xNTksNDIuNTEyYzI5LjMzMSwxLjM3OCw1Mi4xNjEsMjQuNjIsNDEuNzIxLDU1LjgtMS4zNTksNC4wNTgtMS4xMjIsOC40MzMtMy41NTEsMTEuNTEzLTYuNDI1LDguMTUyLTE4LjYsMTUuODM4LTMwLjE4MSwxOC42LTcuNzQ3LDEuODQ4LTE1LjE3LTEuNzM5LTE5LjUyOS0zLjU0My0zLjIzNi0xLjMzOS02LC4wNzktOC44NzYtMS43NzEtMTMuNC04LjYyNy0yNi4xMjktMzEuMTQ3LTE3Ljc1NC01My4xNCw0LjA4My0xMC43MjEsMTMuNzItMjAuMjY0LDIzLjk2Ny0yNC44QzE0MS43NDQsMTEzLjQ1NSwxNDguMiwxMTQuNzk0LDE1MS45NTMsMTEyLjU2NVoiLz4gPC9zdmc+';
			$icon = Codevz_Theme::option( 'white_label_menu_icon', $icon );

			// Add welcome theme menu
			$theme = Codevz_Theme::option( 'white_label_theme_name', 'XTRA' );
			add_menu_page( $theme, $theme, 'manage_options', self::$slug, [ $this, 'welcome' ], $icon, 2 );

			// Sub menus
			add_submenu_page( self::$slug, 'Welcome', 'Welcome', 'manage_options', self::$slug, [ $this, 'welcome' ] );
			
			if ( ! TGM_Plugin_Activation::get_instance()->is_tgmpa_complete() ) {
				add_submenu_page( self::$slug, 'Install Plugins', 'Install Plugins', 'edit_theme_options', 'themes.php?page=tgmpa-install-plugins' );
			}

			add_submenu_page( self::$slug, 'Demo Importer', 'Demo Importer', 'edit_theme_options', 'customize.php?&autofocus[panel]=codevz_theme_options-demos' );
			add_submenu_page( self::$slug, 'Documentation & Support', 'Documentation & Support', 'manage_options', 'codevz-doc',[ $this, 'doc' ] );
			add_submenu_page( self::$slug, 'Theme Options', 'Theme Options', 'manage_options', 'customize.php' );
		}
		
		/**
		 * Documentation & Support page content
		 * @return string
		 */
		public function doc() {

			self::styles();

			?>

			<div class="wrap">
				
				<?php self::tabs('doc');?>

				<script type="text/javascript">
					jQuery(document).ready(function($) {
						$('.cz_q').each(function() {
							$( this ).on('click' , function() {
								$(this).next('.cz_a').slideToggle();
							});
						});	

					});
				</script>

				<div class="cz_box cz_box2">
					<h2>FAQ</h2>

					<div class="cz_faq">
						<div class="cz_q">
							<b>How to update theme or plugins?</b>
						</div>
						<div class="cz_a">
							<p>Please read this: <a href="http://theme.support/doc/xtra#update" target="_blank">http://theme.support/doc/xtra#update</a></p>
						</div>
					</div>

					
					<div class="cz_faq">
						<div class="cz_q">
							<b>How to change site logo?</b>
						</div>
						<div class="cz_a">
							<p>Go to Theme Options > Header > Logo</p>
						</div>
					</div>

					<div class="cz_faq">
						<div class="cz_q">
							<b>How to change logo size?</b>
						</div>
						<div class="cz_a">
							<p>Go to Theme Options > Header > Header and find logo size fields</p>
						</div>
					</div>

					<div class="cz_faq">
						<div class="cz_q">
							<b>How to change copyright text? </b>
						</div>
						<div class="cz_a">
							<p>Go to Theme Options > Footer > Footer bottom bar and find Icon and Text element</p>
						</div>
					</div>

					<div class="cz_faq">
						<div class="cz_q">
							<b>How to disable quick contact form icon? </b>
						</div>
						<div class="cz_a">
							<p>Go to Theme Options > Footer > More and find quick contact form options</p>
						</div>
					</div>

					<div class="cz_faq">
						<div class="cz_q">
							<b>How to disable Back to top icon? </b>
						</div>
						<div class="cz_a">
							<p>Go to Theme Options > Footer > More and remove back top icon</p>
						</div>
					</div>

					<div class="cz_faq">
						<div class="cz_q">
							<b>How to re-import / replace new demo? </b>
						</div>
						<div class="cz_a">
							<p>First go to pages and delete all the pages also from trash, then you can import new demo</p>
						</div>
					</div>

					<div class="cz_faq">
						<div class="cz_q">
							<b>Do I need to activate WPBakery or Slider Plugins with license key?</b>
						</div>
						<div class="cz_a">
							<p>No, we have an extended license for this plugins and we can only use it in our theme(s), we will update our Plugins repository when this plugins updated, you can update them via our theme for lifetime.</p>
						</div>
					</div>

					<div class="cz_faq">
						<div class="cz_q">
							<b>Fix error: Destination folder already exists for installing plugins</b>
						</div>
						<div class="cz_a">
							<p>Please read this: <a href="https://codevz.ticksy.com/article/13873/" target="_blank">https://codevz.ticksy.com/article/13873/</a></p>
						</div>
					</div>

				</div>


				<div class="cz_box cz_box2 cz_box_end" style="min-height: auto;" >
					
					<h2 class="cz_fl" style="margin-bottom:0">Support Center</h2>

					<a class="cz_button cz_button_a cz_fr" target="_blank" href="https://codevz.ticksy.com"><i class="fa fa-comments"></i>Technical Support</a>

				</div>


				<div class="cz_box cz_box4">
					<h2>Video Tutorial</h2>

					<ul class="cz_ula">
						<li><a href="https://www.youtube.com/watch?v=cpmkKF03Ucc" target="_blank">How to installing?</a></li>
						<li><a href="https://www.youtube.com/watch?v=L04htAGAdNc" target="_blank">Header Builder</a></li>
						<li><a href="https://www.youtube.com/watch?v=JujqGDhf5d4" target="_blank">Page Builder</a></li>
						<li><a href="https://www.youtube.com/watch?v=C5u02RGUVVs" target="_blank">Footer Builder</a></li>
						<li><a href="https://www.youtube.com/watch?v=98XwGq9SSxM" target="_blank">Mobile Header</a></li>
					</ul>

					<a class="cz_button cz_button_a" target="_blank" href="https://www.youtube.com/channel/UCrS1L4oeTRfU1hvIo1gJGjg/videos?view_as=subscriber"><i class="fa fa-video-camera"></i>View All Videos</a>

				</div>

				<div class="cz_box cz_box4 cz_box_end">
					<h2>Documentation</h2>

					<ul class="cz_ula">
						<li><a href="http://theme.support/doc/xtra#install" target="_blank">Installation</a></li>
						<li><a href="http://theme.support/doc/xtra#import" target="_blank">Demo Importer</a></li>
						<li><a href="http://theme.support/doc/xtra#troubleshooting" target="_blank">Installation Troubleshooting</a></li>
						<li><a href="http://theme.support/doc/xtra#update" target="_blank">Update Guide</a></li>
						<li><a href="http://theme.support/doc/xtra#edit" target="_blank">Demos Edit Guide</a></li>
						<li><a href="http://theme.support/doc/xtra#colors" target="_blank">Theme Color</a></li>
						<li><a href="http://theme.support/doc/xtra#faq" target="_blank">FAQ</a></li>
					</ul>

					<a class="cz_button cz_button_a" target="_blank" href="http://theme.support/doc/xtra"><i class="fa fa-file-text-o"></i>Documentation</a>

				</div>

				
	   							
			</div>
			<?php

		}

		/**
		 * Welcome page content
		 * @return string
		 */
		public function welcome() {
			$active = null;

			// Deregister activation
			if ( isset( $_POST['deregister'] ) ) {
				$active = self::activation_process( 'deregister' );
			} else if ( isset( $_POST['code'] ) ) {
				$active = self::activation_process( 'register', $_POST['code'] );
			}

			self::styles();

			?>

				<div class="wrap">
				
				<?php self::tabs('welcome'); ?>

				<div class="cz_box cz_box2">
					<h2>Activation</h2>

					<?php

						// Activation
						if ( is_array( get_option( self::$activation ) ) ) {
							echo '<h3 class="cz_grn">Congratulations your theme activated successfully.</h3>';
							if ( $active && $active !== 'register' ) {
								echo '<h3 class="cz_rd">' . esc_html( $active ) . '</h3>';
							}

							$details = (array) get_option( self::$activation );

							if ( isset( $details['purchase_code'] ) ) {

								$pdate = date( 'd F Y', strtotime( $details['purchase_date'] ) );							
								$edate = date( 'd F Y', strtotime( "6 months", strtotime( $details['purchase_date'] ) ) );

								$renew = '';
								if ( current_time( 'timestamp' ) > strtotime( $edate ) ) {
									$renew = '<span class="xtra-renew"><a href="https://xtratheme.com/pricing" target="_blank">Buy Extended Support</a></span>';
								}

								echo '<ul class="cz_ul_details">';
								echo '<li><span>Purchase code:</span> <br />' . $details['purchase_code'] . '</li>';
								echo '<li><span>Purchase date:</span> <br />' . date( 'd F Y', strtotime( $details['purchase_date'] ) ) . '</li>';
								echo '<li><span>Support until:</span> <br /><span style="' . ( $renew ? 'color: red;margin-top: 0;margin-bottom: 0;' : '' ) . '">' . date( 'd F Y', strtotime( $details['support_until'] ) ) . ( $renew ? ' expired' : '' ) . '</span>' . $renew . '</li>';
								echo '<li><span>Theme and Plugins updates:</span> <br />Lifetime</li>';
								echo '</ul>';

							}

							?>
								<form method="post">
									<input type="hidden" name="deregister" value="1">
									<input type="submit" class="cz_button cz_button2" value="Deregister license">
								</form>
							<?php

						} else if ( $active ) {

							if ( $active === 'register' ) {
								echo '<h3 class="cz_grn">Congratulations your theme activated successfully.</h3>';
								?>
									<form method="post">
										<input type="hidden" name="deregister" value="1">
										<input type="submit" class="cz_button cz_button2" value="Deregister license">
									</form>
								<?php 
							} else {
								echo '
					<p style="font-size: 18px">Please activate your theme via purchase code to access<br />theme features, updates and demo importer</p>
					<h3 class="cz_rd">' . esc_html( $active ) . '</h3>';
								?>
									<form class="cz_85" method="post">
										<input class="cz_code" type="text" name="code" placeholder="Please insert purchase code ...">
										<input type="submit" class="cz_button cz_button_activation" value="Activate">
									</form>
									<p class="cz_85">
										<a href="https://xtratheme.com/my-account" target="_blank">How to find purchase code?</a>
										<a href="https://xtratheme.com/" target="_blank" class="cz_fr">Buy new license</a>
									</p>

								<?php 
							}

						} else {
							?>
								<p style="font-size: 18px">Please activate your theme via purchase code to access<br />theme features, updates and demo importer</p>
								<form class="cz_85" method="post">
									<input class="cz_code" type="text" name="code" placeholder="Please insert purchase code ...">
									<input type="submit" class="cz_button cz_button_activation" value="Activate">
								</form>
								<p class="cz_85">
									<a href="https://xtratheme.com/my-account" target="_blank">How to find purchase code?</a>
									<a href="https://xtratheme.com/" target="_blank" class="cz_fr">Buy new license</a>
								</p>
							<?php 
						}
					?>

				</div>

				<div class="cz_box cz_box2 cz_box_end">

					<h2> System Status </h2>
					<ul class="cz_ul">
						<li>PHP version: <?php echo PHP_VERSION . ( ( version_compare( PHP_VERSION, '7.0.0') <= 0 ) ? '<span class="cz_error">' . esc_html__( 'PHP 7.2 recommended', 'codevz' ) . '</span>' : '<span class="cz_good">' . esc_html__( 'Good', 'codevz' ) . '</span>' ); ?></li>
						<li>Memory limit: <?php echo ini_get( 'memory_limit' ) . ( ( ini_get( 'memory_limit' ) < 128 ) ? '<span class="cz_error">' . esc_html__( '128M recommended', 'codevz' ) . '</span>' : '<span class="cz_good">' . esc_html__( 'Good', 'codevz' ) . '</span>' ); ?></li>
						<li>Max execution time: <?php echo ini_get( 'max_execution_time' ) . ( ( ini_get( 'memory_limit' ) < 60 ) ? '<span class="cz_error">' . esc_html__( '60 recommended', 'codevz' ) . '</span>' : '<span class="cz_good">' . esc_html__( 'Good', 'codevz' ) . '</span>' ); ?></li>
					</ul>
				</div>

			</div>
			<?php
		}

		/**
		 * Activation process
		 * @return string
		 */
		public static function activation_process( $type = 'register', $code = '' ) {

			if ( $type === 'deregister') {
				$code = (array) get_option( self::$activation );
				if ( isset( $code['purchase_code'] ) ) {

					$code = $code['purchase_code'];

					delete_option( self::$activation );

				} else {
					return 'Failed, Please try again ...';
				}
			}

			if ( ! $code ) {
				return 'Please insert valid purchase code.';
			}

			// Verify purchase
			$verify = wp_remote_get( 'https://xtratheme.com?type=' . $type . '&domain=' . $_SERVER['SERVER_NAME'] . '&code=' . $code );
			if ( is_wp_error( $verify ) ) {
				return $verify->get_error_message() ;
			} else if ( ! isset( $verify['body'] ) ) {
				return 'Something went wrong, Please try again in the next 10 seconds';
			} else {
				$verify = json_decode( $verify['body'], true );

				if ( isset( $verify['type'] ) && $verify['type'] === 'deregister' ) {
					
					if ( ! isset( $verify['limit'] ) ) {
						delete_option( self::$activation );
					}

					return $verify['message'];
				}

				if ( isset( $verify['type'] ) && $verify['type'] === 'error' ) {
					return $verify['message'];
				}

				if ( ! isset( $verify['purchase_code'] ) ) {
					return 'Purchase code not found in our database, Please try again ...';
				}
			}

			// Update option
			if ( $type === 'register' ) {
				update_option( self::$activation, $verify );
				return 'register';
			}
		}

	}

	// Run
	Xtra_Dashboard::instance();

}
