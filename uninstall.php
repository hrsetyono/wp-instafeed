<?php
/*
  Fired when the plugin is uninstalled
  https://github.com/DevinVinson/WordPress-Plugin-Boilerplate/blob/master/plugin-name/uninstall.php
*/

// If uninstall not called from WordPress, then exit.
if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}
