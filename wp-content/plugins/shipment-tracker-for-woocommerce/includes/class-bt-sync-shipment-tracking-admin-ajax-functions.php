<?php


class Bt_Sync_Shipment_Tracking_Admin_Ajax_Functions{  

    public function __construct( $crons,$shiprocket,$shyplite ) {
        $this->crons = $crons;
        $this->shiprocket = $shiprocket;
        $this->shyplite = $shyplite;
    }

    public function bt_sync_now_shyplite(){
        $obj = $this->crons->sync_shyplite_shipments();
        
        $resp = array(
            "status"=>true,
            "orders_count"=>sizeof($obj)
        );
        echo json_encode($resp);
        die();
    }


  
}