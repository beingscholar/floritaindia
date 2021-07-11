<?php

/**
 * The shiprocket-specific functionality of the plugin.
 *
 * @package    Bt_Sync_Shipment_Tracking
 * @subpackage Bt_Sync_Shipment_Tracking/shiprocket
 * @author     Amit Mittal <amitmittal@bitsstech.com>
 */
class Bt_Sync_Shipment_Tracking_Shiprocket {

    private const COURIERS_JSON = '{"1":"Blue Dart","2":"FedEx","7":"FEDEX PACKAGING#","8":"DHL Packet International#","10":"Delhivery","12":"FedEx Surface 10 Kg","14":"Ecom Express","16":"Dotzot","33":"Xpressbees","35":"Aramex International#","37":"DHL PACKET PLUS INTERNATIONAL#","38":"DHL PARCEL INTERNATIONAL DIRECT#","39":"Delhivery Surface 5 Kgs","40":"Gati Surface 5 Kg","41":"FedEx Flat Rate","42":"FedEx Surface 5 Kg","43":"Delhivery Surface","44":"Delhivery Surface 2 Kgs","45":"Ecom Express Reverse##","46":"Shadowfax Reverse##","48":"Ekart Logistics","50":"Wow Express","51":"Xpressbees Surface","52":"RAPID DELIVERY","53":"Gati Surface 1 Kg","54":"Ekart Logistics Surface","55":"Blue Dart Surface","56":"DHL Express International","57":"Professional","58":"Shadowfax Surface","60":"Ecom Express ROS","62":"FedEx Surface 1 Kg","63":"Delhivery Flash","68":"Delhivery Essential Surface","80":"Delhivery Reverse QC","95":"Shadowfax Local","96":"Shadowfax Essential Surface","97":"Dunzo Local","99":"Ecom Express ROS Reverse","100":"Delhivery Surface 10 Kgs","101":"Delhivery Surface 20 Kgs","102":"Delhivery Essential Surface 5Kg","103":"Xpressbees Essential Surface","104":"Delhivery Essential Surface 2Kg","106":"Wefast Local","107":"Wefast Local 5 Kg","108":"Ecom Express Essential","109":"Ecom Express ROS Essential","110":"Delhivery Essential","111":"Delhivery Non Essential"}';

    private const API_BASE_URL = "https://apiv2.shiprocket.in";
    private const API_GET_LOCALITY = "/v1/external/open/postcode/details?postcode=";
    private const API_TRACK_BY_ORDER_ID = "/v1/external/courier/track?order_id=";

    private $auth_token;

    private $username;
    private $password;
    private $channel_id;

	public function __construct() {
    }

    function init_params() {
        $username=carbon_get_theme_option( 'bt_sst_shiprocket_apiusername' );
		$password=carbon_get_theme_option( 'bt_sst_shiprocket_apipassword' );
		$channel_id=carbon_get_theme_option( 'bt_sst_shiprocket_channelid' );
        
        $this->username=trim($username);
        $this->password=trim($password);
        $this->channel_id=trim($channel_id);
    }
    
    public function get_locality($postcode){
        $this->init_params();
        $auth_token = $this->get_token();

        if(!empty($auth_token)){

            $args = array(
                'headers'     => array(
                    'Authorization' => 'Bearer ' . $auth_token,
                ),
            );  

            $response = wp_remote_get( self::API_BASE_URL . self::API_GET_LOCALITY . $postcode, $args );

            $body     = wp_remote_retrieve_body( $response );

            $resp = json_decode($body,true);

            if($resp["success"]){
                return array(
                    "postcode"=>$resp["postcode_details"]["postcode"],
                    "city"=>$resp["postcode_details"]["city"],
                    "state"=>$resp["postcode_details"]["state"],
                    "state_code"=>$resp["postcode_details"]["state_code"],
                    "country"=>$resp["postcode_details"]["country"],
                );
            }

        }else{
            return null;
        }


    }

    function generate_token(){

        $body = array(
            'email'    => $this->username,
            'password'   => $this->password,
        );

        $args = array(
            'body'        => $body,
            'headers'     => array(
                "Content-Type: application/json"
              ),
        );

        $response = wp_remote_post( "https://apiv2.shiprocket.in/v1/external/auth/login", $args );

        $body = wp_remote_retrieve_body( $response );

        return json_decode($body,true)["token"];
        
    }

    function get_token(){
        if(empty($this->auth_token)){
            $this->auth_token = $this->generate_token();
        }

        return $this->auth_token;
    }

    public function shiprocket_webhook_receiver($request){        

        $enabled_shipping_providers = carbon_get_theme_option( 'bt_sst_enabled_shipping_providers' );
        if(is_array($enabled_shipping_providers) && in_array('shiprocket',$enabled_shipping_providers)){

            $order_id = $request["order_id"];       
            if(!empty($order_id)){    
                if(false !== $order = wc_get_order( $order_id )){   

                    $bt_sst_order_statuses_to_sync = carbon_get_theme_option( 'bt_sst_order_statuses_to_sync' );
                    $bt_sst_sync_orders_date = carbon_get_theme_option( 'bt_sst_sync_orders_date' );

                    $order_status = 'wc-' . $order->get_status();                    

                    if(in_array($order_status,$bt_sst_order_statuses_to_sync)){

                        $date_created_dt = $order->get_date_created(); // Get order date created WC_DateTime Object
                        $timezone        = $date_created_dt->getTimezone(); // Get the timezone
                        $date_created_ts = $date_created_dt->getTimestamp(); // Get the timestamp in seconds
    
                        $now_dt = new WC_DateTime(); // Get current WC_DateTime object instance
                        $now_dt->setTimezone( $timezone ); // Set the same time zone
                        $now_ts = $now_dt->getTimestamp(); // Get the current timestamp in seconds
    
                        $allowed_seconds = $bt_sst_sync_orders_date * 24 * 60 * 60; // bt_sst_sync_orders_date in seconds
    
                        $diff_in_seconds = $now_ts - $date_created_ts; // Get the difference (in seconds)

                        if ( $diff_in_seconds <= $allowed_seconds ) {
                            $shipment_obj = $this->init_model($request);
                            $bt_shipment_tracking_old = get_post_meta( $order_id, '_bt_shipment_tracking', true );
                            update_post_meta($order_id, '_bt_shipment_tracking', $shipment_obj);
                            update_post_meta($order_id, '_bt_shipping_provider', 'shiprocket' );
                            do_action( 'bt_shipment_status_changed',$order_id,$shipment_obj,$bt_shipment_tracking_old);
                            return "Thanks Shiprocket! Record updated.";
                        }else{
                            return "Thanks Shiprocket! Order too old.";
                        }
                    }else{
                        return "Thanks Shiprocket! Order status out of scope.";
                    }
                }
            }
        }      

        // ob_start();
        // var_dump($request);
        // $result = ob_get_clean();

        // error_log($result);

        return "Thanks Shiprocket!";
    }

    public function get_order_tracking($order_id){
        $this->init_params();
        $auth_token = $this->get_token();

        if(!empty($auth_token)){
            
            $args = array(
                'headers'     => array(
                    'Authorization' => 'Bearer ' . $auth_token,
                ),
            );        

            $response = wp_remote_get( self::API_BASE_URL . self::API_TRACK_BY_ORDER_ID . $order_id . '&channel_id=' . $this->channel_id,$args );

            $body     = wp_remote_retrieve_body( $response );

            $resp = json_decode($body,true);


            return $resp;

        }else{
            return null;
        }
    }

    public function get_courier_by_id($id){
        $couriers = json_decode(self::COURIERS_JSON,true);
        return isset($couriers[$id])?$couriers[$id]:"NA";
    }

    public function init_model($data){

        $obj = new Bt_Sync_Shipment_Tracking_Shipment_Model();

        if(isset($data["tracking_data"])){
            //from the api call
            $obj->shipping_provider = 'shiprocket';
            $obj->awb = sanitize_text_field($data["tracking_data"]["shipment_track"][0]["awb_code"]);        
            $obj->courier_name = $this->get_courier_by_id(sanitize_text_field($data["tracking_data"]["shipment_track"][0]["courier_company_id"]));
            $obj->etd = sanitize_text_field($data["tracking_data"]["shipment_track"][0]["delivered_date"]);
            $obj->scans = $data["tracking_data"]["shipment_track_activities"];
            $obj->current_status = sanitize_text_field($data["tracking_data"]["shipment_track"][0]["current_status"]);
        }else{
            //from webhook receiver
            $obj->shipping_provider = 'shiprocket';
            $obj->awb = sanitize_text_field($data["awb"]);        
            $obj->courier_name = sanitize_text_field($data["courier_name"]);
            $obj->etd = sanitize_text_field($data["etd"]);
            $obj->scans = $data["scans"];
            $obj->current_status = sanitize_text_field($data["current_status"]);
        }

        
        return $obj;
    } 

    public function update_order_shipment_status($order_id){
        $resp= $this->get_order_tracking($order_id);
		if(sizeof($resp)>0&&$resp[0]!=false){
			$shipment_obj = $this->init_model($resp[0]);
            $bt_shipment_tracking_old = get_post_meta( $order_id, '_bt_shipment_tracking', true );
            update_post_meta($order_id, '_bt_shipment_tracking', $shipment_obj);
            do_action( 'bt_shipment_status_changed',$order_id,$shipment_obj,$bt_shipment_tracking_old);
			return $shipment_obj;
        }
        return null;
    }
}
