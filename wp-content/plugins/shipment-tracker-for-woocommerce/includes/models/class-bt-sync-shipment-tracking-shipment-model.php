<?php


class Bt_Sync_Shipment_Tracking_Shipment_Model{  

    public $shipping_provider;
    public $awb;
    public $current_status;
    public $courier_name;
    public $etd;
    public $scans;   

    public function __construct() {
    } 


    public function get_tracking_link(){
        if($this->shipping_provider=="shyplite"){
            return "https://tracklite.in/track/" . $this->awb;
        }else if($this->shipping_provider=="shiprocket"){
            return "https://shiprocket.co/tracking/" . $this->awb;
        }else{
            return "#";
        }
    }
}