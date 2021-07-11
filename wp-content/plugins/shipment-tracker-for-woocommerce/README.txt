=== Shipment Tracker for Woocommerce ===
Contributors: amitmital
Tags: shiprocket, shyplite, order tracking, shipment tracking
Requires at least: 4.6
Tested up to: 5.7
Requires PHP: 5.6
Stable tag: trunk
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Automatically synchronize woocommerce orders' shipment tracking information from Shiprocket and Shyplite.

== Description ==
This plugin integrates with Shiprocket and Shyplite web apis to synchronize tracking information of your Woocommerce orders. Easy setup, many configurable options for sync frequency, default provider etc.

Disclaimer: Woocommerce, Shiprocket &amp; Shyplite are registered trademarks and belong to their respective owners. This plugin is not affiliated with them in any way.
== Installation ==
1. In your WordPress admin panel, go to Plugins > New Plugin, search for \'Shipment Tracker\' and click “Install now“
2. Alternatively, download the plugin and upload the contents of shipment-tracker.zip to your plugins directory, which usually is /wp-content/plugins/.
3. Activate the plugin
4. Enable the desired shipment aggregator (Shiprocket or Shyplite), then click Save.
4. Set your API keys of enabled shipping providers in their respective Tab.

== Screenshots ==
1. Enable the shipping providers and set other basic configurations in "General Settings".
2. Shiprocket specific settings (only appears if Shiprocket is enabled in General Settings).
3. Shyplite specific settings (only appears if Shyplite is enabled in General Settings).
4. Tracking information in Woocommerce->Orders page in admin.
5. Tracking information in Order details page.

== Changelog ==
= 1.2.0 - 2021.06.11 =
1) Added tracking info in my-account->orders
2) Feature to add tracking updates as order notes.
3) Support for fallback webhook url for shiprocket.
= 1.1.0 - 2021.03.05 =
* Wordpress 5.7 support. 
* Fixes in Shyplite syncing.
= 1.0.0 - 2021.02.03 =
* Initial release!