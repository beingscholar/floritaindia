<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://amitmittal.tech
 * @since             1.0.0
 * @package           Bt_Sync_Shipment_Tracking
 *
 * @wordpress-plugin
 * Plugin Name:       Shipment Tracker for Woocommerce
 * Plugin URI:        https://wordpress.org/plugins/shipment-tracker-for-woocommerce/
 * Description:       Automatically synchronize woocommerce orders' shipment tracking information from Shiprocket and Shyplite.
 * Version:           1.2.0
 * Author:            Bitss Techniques
 * Author URI:        http://bitss.tech/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       bt-sync-shipment-tracking
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'BT_SYNC_SHIPMENT_TRACKING_VERSION', '1.2.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-bt-sync-shipment-tracking-activator.php
 */
function activate_bt_sync_shipment_tracking() {	
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-bt-sync-shipment-tracking-activator.php';
	Bt_Sync_Shipment_Tracking_Activator::activate();	
}
add_action( 'admin_notices', 'bt_sst_woocommerce_not_installed_notice' );
function bt_sst_woocommerce_not_installed_notice(){
	if( get_transient( 'bt-sst-woocommerce-not-installed-notice' ) ){
	   ?>
	   <div class="updated error is-dismissible">
		   <p>Shipment Tracker requires Woocommerce to be installed and activated. Just so you know!</p>
	   </div>
	   <?php
	   delete_transient( 'bt-sst-woocommerce-not-installed-notice' );
   }
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-bt-sync-shipment-tracking-deactivator.php
 */
function deactivate_bt_sync_shipment_tracking() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-bt-sync-shipment-tracking-deactivator.php';
	Bt_Sync_Shipment_Tracking_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_bt_sync_shipment_tracking' );
register_deactivation_hook( __FILE__, 'deactivate_bt_sync_shipment_tracking' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-bt-sync-shipment-tracking.php';

//add settings link in plugin lising
add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'bt_sst_add_action_links' );
 
function bt_sst_add_action_links ( $actions ) {
   if(is_woocommerce_activated()){
		$mylinks = array(
			'<a href="' . admin_url( 'options-general.php?page=crb_carbon_fields_container_shipment_tracking.php' ) . '">Settings</a>',
		);
		$actions = array_merge( $actions, $mylinks );
	}
   return $actions;
}

if ( ! function_exists( 'is_woocommerce_activated' ) ) {
	function is_woocommerce_activated() {
		//if ( class_exists( 'woocommerce' ) ) { return true; } else { return false; }
		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		return is_plugin_active( 'woocommerce/woocommerce.php' );
	}
}

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_bt_sync_shipment_tracking() {
	if(is_woocommerce_activated()){
		delete_transient( 'bt-sst-woocommerce-not-installed-notice' );
		$plugin = new Bt_Sync_Shipment_Tracking();
		$plugin->run();
	}else{
		set_transient( 'bt-sst-woocommerce-not-installed-notice', true, 0 );		
	}

}
run_bt_sync_shipment_tracking();
