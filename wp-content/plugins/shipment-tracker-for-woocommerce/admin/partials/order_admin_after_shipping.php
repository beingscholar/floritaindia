<br class="clear" />
<div class="address">
    <b>Shipping Provider:</b> <?php echo $bt_shipping_provider; ?>
</div>
<div class="edit_address">
	<?php
        woocommerce_wp_select([
            'id'       => '_bt_shipping_provider',
            'label'    => __( 'Shipping Provider: ', 'woocommerce' ),
            'selected' => true,
            'value'    => $bt_shipping_provider,
            'options' => [
                '' => 'None',
                'shiprocket' => 'Shiprocket',
                'shyplite' => 'Shyplite',
            ]
        ]);  
        
        woocommerce_wp_checkbox( array( // Checkbox.
            'id'            => '_bt_shipping_sync_now',
            'label'         => 'Sync Tracking Now',
            'style' => 'width:unset;'
        ) );
	?>
</div>
<br class="clear" />
		