<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://amitmittal.tech
 * @since      1.0.0
 *
 * @package    Bt_Sync_Shipment_Tracking
 * @subpackage Bt_Sync_Shipment_Tracking/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Bt_Sync_Shipment_Tracking
 * @subpackage Bt_Sync_Shipment_Tracking/admin
 * @author     Amit Mittal <amitmittal@bitsstech.com>
 */
//ref: https://rudrastyh.com/woocommerce/customize-order-details.html
//ref: https://woocommerce.github.io/code-reference/hooks/hooks.html
class Bt_Sync_Shipment_Tracking_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;
	private $shiprocket;
    private $shyplite;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version,$shiprocket,$shyplite ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->shiprocket = $shiprocket;
        $this->shyplite = $shyplite;

	}



	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Bt_Sync_Shipment_Tracking_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Bt_Sync_Shipment_Tracking_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/bt-sync-shipment-tracking-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Bt_Sync_Shipment_Tracking_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Bt_Sync_Shipment_Tracking_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/bt-sync-shipment-tracking-admin.js', array( 'jquery' ), $this->version, false );

	}

	function plugin_admin_menu(){
		//add_menu_page( 'Sync Shipment Tracking Settings', 'Sync Shipment Tracking', 'manage_options', 'bt-sync-shipment-tracking-settings', array($this , 'render_admin_settings' ), );
	}

	function render_admin_settings(){
		$url=get_site_url(null, '/wp-json/bt-sync-shipment-tracking-shiprocket/v1.0.0/webhook_receiver');
		echo "Enter this url in Shiprocket webhook settings: " . $url;
	}

	public function custom_shop_order_column($columns){
		$reordered_columns = array();

		// Inserting columns to a specific location
		foreach( $columns as $key => $column){
			$reordered_columns[$key] = $column;
			if( $key ==  'order_status' ){
				// Inserting after "Status" column
				$reordered_columns['bt-shipping-status'] = 'Shipping Status';
			}
		}
		return $reordered_columns;
	}

	public function custom_orders_list_column_content( $column, $post_id ){
		switch ( $column )
		{
			case 'bt-shipping-status' :
				$bt_shipment_tracking = get_post_meta( $post_id, '_bt_shipment_tracking', true );
				$bt_shipping_provider = get_post_meta( $post_id, '_bt_shipping_provider', true );
				include plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/order_shipment_details.php';
				break;
		}
	}

	public function show_order_shipping_admin($order){
		$bt_shipment_tracking = get_post_meta( $order->get_id(), '_bt_shipment_tracking', true );
		$bt_shipping_provider = get_post_meta( $order->get_id(), '_bt_shipping_provider', true );

		include_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/order_admin_after_shipping.php';
		include_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/order_shipment_details.php';
	}

	public function woocommerce_process_shop_order_meta($order_id){
		$new_provider=wc_clean( $_POST[ '_bt_shipping_provider' ] ) ;
		update_post_meta( $order_id, '_bt_shipping_provider', $new_provider );
		if($new_provider=="shiprocket" && $_POST["_bt_shipping_sync_now"]){
			return $this->shiprocket->update_order_shipment_status($order_id);
		}else if($new_provider=="shyplite" && $_POST["_bt_shipping_sync_now"]){
			return $this->shyplite->update_order_shipment_status($order_id);
		}
	}

	public function woocommerce_order_status_processing($order_id){
		
		$enabled_shipping_providers = carbon_get_theme_option( 'bt_sst_enabled_shipping_providers' );
		$bt_sst_default_shipping_provider = carbon_get_theme_option( 'bt_sst_default_shipping_provider' );

		//check if default shipping provider is set and enabled.
		if(!empty($bt_sst_default_shipping_provider) && is_array($enabled_shipping_providers) && in_array($bt_sst_default_shipping_provider,$enabled_shipping_providers)){
			$bt_shipping_provider = get_post_meta( $order_id, '_bt_shipping_provider', true );
			//make sure a shipping provider is not already assigned.
			if(empty($bt_shipping_provider)){
				update_post_meta($order_id, '_bt_shipping_provider', $bt_sst_default_shipping_provider);
			}			
		}
	}

	public function bt_shipment_status_changed($order_id,$shipment_obj,$old_tracking_obj){
		//shipment status updated..		
		$bt_sst_complete_delivered_orders = carbon_get_theme_option( 'bt_sst_complete_delivered_orders' );
		if($bt_sst_complete_delivered_orders==1){
			//change status of delivered order to completed.
			if(strcasecmp($shipment_obj->current_status,"delivered")==0){				
				$order = wc_get_order( $order_id );
				$order->update_status( 'completed', "Shipment has been delivered." );
			}
		}

		//check if order note needs to be added
		$bt_sst_add_order_note = carbon_get_theme_option( 'bt_sst_add_order_note' );
		if($bt_sst_add_order_note==1){
			//making sure that status has changed
			if($old_tracking_obj == null || $shipment_obj->current_status != $old_tracking_obj->current_status){
				$bt_sst_order_note_type = carbon_get_theme_option( 'bt_sst_order_note_type' );
				$bt_sst_order_note_template = carbon_get_theme_option( 'bt_sst_order_note_template' );
				if(!empty($bt_sst_order_note_template)){
					$order = wc_get_order( $order_id ); 
					$note = str_replace("#old_status#",$old_tracking_obj == null?"":$old_tracking_obj->current_status,$bt_sst_order_note_template);				
					$note = str_replace("#new_status#",$shipment_obj->current_status,$note);
					$note = str_replace("#track_link#","<a target='_blank' href='" . $shipment_obj->get_tracking_link() . "'>Track</a>",$note);
					$order->add_order_note( $note, $bt_sst_order_note_type=='customer' );
				}
			}
		}
	}
}
