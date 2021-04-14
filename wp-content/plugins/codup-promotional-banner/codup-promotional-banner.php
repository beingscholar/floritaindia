<?php
/**
 * Plugin Name: Codup Promotional Banner
 * Plugin URI:  https://codup.io
 * Description: Simple Plugin to add customized banner on selected pages.
 * Version:     1.1.2.3
 * Author:      Codup
 * Author URI:  https://codup.io/
 * License:     GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: codup-promotional-banner
 * WC requires atleast: 3.8.0
 * WC tested upto: 4.5.2
 *
 * @package CodupPromotionalBanner.php
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'CPB_PLUGIN_DIR', __DIR__ );
define( 'CPB_PLUGIN_DIR_URL', plugin_dir_url( __FILE__ ) );
define( 'CPB_TEMP_DIR', CPB_PLUGIN_DIR . '/templates' );
define( 'CPB_ASSETS_DIR_URL', CPB_PLUGIN_DIR_URL . 'assets' );

/*
 * Include local dependencies.
 */

require CPB_PLUGIN_DIR . '/includes/class-promotionalbanner.php';
require CPB_PLUGIN_DIR . '/includes/helpers.php'; 
new CodupPromotionalBanner();

