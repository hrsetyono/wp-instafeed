<?php
/*
Plugin Name: Edje Instagram Feed
Description: Display Instagram photos from any user in WordPress theme. Works without access token! SHORTCODE: <code>[instafeed your.username]</code>
Plugin URI: https://github.com/hrsetyono/wp-instagram-feed
Author: Pixel Studio ID
Author URI: https://pixelstudio.id
Version: 0.2.0
*/

// If this file is called directly, abort.
if( !defined( 'WPINC' ) ) { die; }
define( 'H_INSTAFEED_VERSION', '0.1.0' );
define( 'H_INSTAFEED_URL', plugins_url( '', __FILE__ ) );
define( 'H_INSTAFEED_PATH', untrailingslashit( plugin_dir_path( __FILE__ ) ) );



new H_Instafeed();
class H_Instafeed {
	function __construct() {
		register_activation_hook( __FILE__, array($this, 'activation_hook') );
		register_deactivation_hook( __FILE__, array($this, 'deactivation_hook') );

		$this->load();
		is_admin() ? $this->admin_load() : $this->public_load();
	}

	/*
		Load the required dependencies for BOTH Admin and Public pages.
	*/
	function load() {
	}

	/*
		Load the required dependencies for Admin pages.
	*/
	function admin_load() {
		require_once H_INSTAFEED_PATH . '/admin/admin-hooks.php';

		new H_Instafeed_Admin_Hooks();
	}

	/*
		Load the required dependencies for Public pages.
	*/
	function public_load() {
		require_once H_INSTAFEED_PATH . '/public/public-hooks.php';

		new H_Instafeed_Public_Hooks();
	}

	/*
	  The code that runs during plugin activation.
	*/
	function activation_hook() {

	}

	/*
	  The code that runs during plugin deactivation.
	*/
	function deactivation_hook() {

	}

	///

	/*
    Alias for get_photos()
  */
	static function get( $username, $endcursor = '' ) {
		return H_Instafeed_Public_Hooks::get_data( $username, $endcursor );
	}
}
