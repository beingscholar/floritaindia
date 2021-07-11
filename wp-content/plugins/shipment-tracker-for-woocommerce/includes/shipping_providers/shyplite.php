<?php

/**
 * The shiprocket-specific functionality of the plugin.
 *
 * @package    Bt_Sync_Shipment_Tracking
 * @subpackage Bt_Sync_Shipment_Tracking/shiprocket
 * @author     Amit Mittal <amitmittal@bitsstech.com>
 */
class Bt_Sync_Shipment_Tracking_Shyplite {
    
    private const TRACKING_EVENT_STATUS_CODES = array(
                                                    "SB"=>"Shipment Booked",
                                                    "PU"=>"Picked Up",
                                                    "IT"=>"In Transit",
                                                    "EX"=>"Exception",
                                                    "OD"=>"Out for Delivery",
                                                    "OP"=>"Out for Pickup",
                                                    "RT"=>"Return",
                                                    "DL"=>"Delivered",
                                                );
    private const API_BASE_URL = "https://api.shyplite.com";
    private const API_BULK_TRACK_BY_ORDER_ID = "/track?oid=1";
    
    private $auth_token;
    private $seller_id;
    private $app_id;
    private $public_key;
    private $secret_key;
   
	public function __construct() {
    }
    
    function init_params() {
        $seller_id=carbon_get_theme_option( 'bt_sst_shyplite_sellerid' );
		$app_id=carbon_get_theme_option( 'bt_sst_shyplite_appid' );
		$public_key=carbon_get_theme_option( 'bt_sst_shyplite_publickey' );
        $secret_key=carbon_get_theme_option( 'bt_sst_shyplite_secretkey' );
        
        $this->seller_id=trim($seller_id);
        $this->app_id=trim($app_id);
        $this->public_key=trim($public_key);
        $this->secret_key=trim($secret_key);
    }
  

    function generate_token(){
        $timestamp    = time();
        $appID        = $this->app_id;
        $key          = $this->public_key;
        $secret       = $this->secret_key;

        $sign = "key:".$key."id:".$appID.":timestamp:".$timestamp;
        $authtoken = rawurlencode(base64_encode(hash_hmac('sha256', $sign, $secret, true)));  
        return array(
            "authtoken"=>$authtoken,
            "timestamp"=>$timestamp,
            "appID"=>$appID,
            "key"=>$key,
            "secret"=>$secret,
        );
        //echo $timestamp;                
    }

    public function get_orders_tracking($order_ids){    

        if(!empty($order_ids)){
            $this->init_params();
            $authtoken = $this->generate_token();           

            $headers = array(
                "x-appid"=> $this->app_id,
                "x-timestamp"=> $authtoken["timestamp"],
                "x-sellerid"=> $this->seller_id,
                "x-version"=> 3, // for auth version 3.0 only
                "Authorization"=>$authtoken["authtoken"],
                "content-type"=>"application/json",
            );
            $body = array(
                "orders"=>$order_ids
            );  

            $postData = json_encode($body);

            $args = array(
                'body' => $postData,
                'headers' => $headers
            );                    
           
            $url = self::API_BASE_URL . self::API_BULK_TRACK_BY_ORDER_ID;

            $response = wp_remote_post( $url, $args );

            $body = wp_remote_retrieve_body( $response );
          
            $resp = json_decode($body,true);
            return !isset($resp["error"])?$resp:null;
            //return $resp;
        }
       

        // ob_start();
        // var_dump($request);
        // $result = ob_get_clean();

        // error_log($result);

        return null;
    }  
    
    public function get_order_tracking($order_id){
        return $this->get_orders_tracking(array($order_id));        
    }

    public function init_model($data){
        $obj = new Bt_Sync_Shipment_Tracking_Shipment_Model();
        $obj->shipping_provider = 'shyplite';
        $obj->awb = sanitize_text_field($data["awbNo"]);        
        $obj->courier_name = sanitize_text_field($data["carrierName"]);
        $obj->etd = sanitize_text_field($data["allData"]["expectedDeliveryDate"]);
        $obj->scans = $data["events"];
        $last_status_code = end($data["events"])["status"];
        if(!empty($last_status_code) && isset(self::TRACKING_EVENT_STATUS_CODES[strtoupper($last_status_code)])){
            $obj->current_status = self::TRACKING_EVENT_STATUS_CODES[strtoupper($last_status_code)];
        }else{
            $obj->current_status = $last_status_code;
        }
        

        return $obj;
    }  

    public function update_order_shipment_status($order_id){
        $resp= $this->get_order_tracking($order_id);
		if(isset($resp[$order_id])){
			$shipment_obj = $this->init_model($resp[$order_id]);
            $bt_shipment_tracking_old = get_post_meta( $order_id, '_bt_shipment_tracking', true );
            update_post_meta($order_id, '_bt_shipment_tracking', $shipment_obj);
            do_action( 'bt_shipment_status_changed',$order_id,$shipment_obj,$bt_shipment_tracking_old);
			return $shipment_obj;
        }
        return null;
    }

    public function bulk_update_order_shipment_status($orderids){
        $objs=array();
        if($orderids && sizeof($orderids)>0){
            $orderids = array_map('strval',$orderids);
            $array_chunks = array_chunk($orderids, 50);
    
            $tracking=array();
            
            foreach ($array_chunks as $ck) {
                $tk=$this->get_orders_tracking($ck);
                if($tk!=null){
                    $tracking = $tracking + $tk; 
                }            
            }            
            
            foreach ($tracking as $order_id => $track) {
                if(!isset($track['awbNo'])) continue;
                $shipment_obj = $this->init_model($track);
                update_post_meta($order_id, '_bt_shipment_tracking', $shipment_obj);
                $bt_shipment_tracking_old = get_post_meta( $order_id, '_bt_shipment_tracking', true );
                do_action( 'bt_shipment_status_changed',$order_id,$shipment_obj,$bt_shipment_tracking_old);
                $objs[]=$shipment_obj;
            }
        }   

        return $objs;
    }

    
}
