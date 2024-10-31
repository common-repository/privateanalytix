<?php
/*
Plugin Name: PrivateAnalytix
Description: Embeds <strong>PrivateAnalytix</strong> code snippet in your website.
Version:     1.2.0
Author:      PrivateAnalytix
Author URI:  https://privateanalytix.com
Text Domain: privateanalytix
*/

defined( 'ABSPATH' ) or die;

define( 'PRIVATEANALYTIX_VER', '1.2.0' );

if ( ! class_exists( 'PrivateAnalytix' ) ) {
	class PrivateAnalytix {
		public static function getInstance() {
			if ( self::$instance == null ) {
				self::$instance = new self();
			}
			return self::$instance;
		}

		private static $instance = null;

		private function __clone() { }

		private function __wakeup() { }

		private function __construct() {
			// Properties
			$this->dashboard_url = 'https://privateanalytix.com/login';
			$this->logo_url      = plugins_url( 'images/logo.png', __FILE__ );
			$this->code          = null;

			// Admin actions
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_assets' ) );
			add_action( 'admin_init', array( $this, 'register_settings' ) );
			add_action( 'admin_menu', array( $this, 'add_admin_menu' ) );

			// Front actions
			add_action( 'wp_head', array( $this, 'embed_code' ), 100 );
		}

		public function enqueue_admin_assets( $screen_name ) {
			if ( $screen_name != 'toplevel_page_privateanalytix' ) return;
			wp_enqueue_style( 'privateanalytix-admin', plugins_url( 'css/admin.css', __FILE__ ), array(), PRIVATEANALYTIX_VER, 'all' );
		}

		public function register_settings() {
			register_setting( 'privateanalytix_optsgroup', 'privateanalytix_code' );
		}

		public function add_admin_menu() {
			add_menu_page(
				__( 'PrivateAnalytix', 'privateanalytix' ),
				__( 'PrivateAnalytix', 'privateanalytix' ),
				'manage_options',
				'privateanalytix',
				array( $this, 'render_options_page' ),
				'dashicons-chart-line'
			);
		}

		public function render_options_page() {
			$code     = $this->get_code();
			$is_valid = $this->is_valid_code( $code );
			require( dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'options.php' );
		}

		public function embed_code() {
			$code     = $this->get_code();
			$is_valid = $this->is_valid_code( $code );
			if ( $code != '' && $is_valid ) {
				echo $code;
			}
		}

		private function get_code() {
			if ( is_null( $this->code ) ) $this->code = get_option( 'privateanalytix_code' );
			return $this->code;
		}

		private function is_valid_code( $code ) {
			if ( strpos( $code, '<!-- Pixel Code' ) === false ) return false;
			if ( strpos( $code, '<!-- END Pixel Code -->' ) === false ) return false;
			return true;
		}
	}
}
PrivateAnalytix::getInstance();