<div>
    <?php
        if(!empty($bt_shipment_tracking) && $bt_shipment_tracking instanceof Bt_Sync_Shipment_Tracking_Shipment_Model){
            try{
                echo $bt_shipment_tracking->current_status . "<br>" .
                "ETD: " . $bt_shipment_tracking->etd . "<br>" .
                "Courier: " . $bt_shipment_tracking->courier_name . "<br>" .
                "<a target='_blank' href='" . $bt_shipment_tracking->get_tracking_link() . "'>Track</a>" ;
            }catch(Exception $e){
                echo '<small>NA</small>';
            }
        }					
        else
            echo '<small>NA</small>';
    ?>
</div>