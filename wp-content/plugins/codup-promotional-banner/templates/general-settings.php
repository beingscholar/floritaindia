<?php
/**
 *  For general settings of banner
 *
 * @package general-settings.php
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

<?php
	$banner_settings   = get_option( 'cpb_settings' );
	$targeturl         = $banner_settings['bannerurl'];
	$expirydate        = $banner_settings['banner_expiry'];
	$banner_text       = $banner_settings['banner_text'];
	$banner_url_action = $banner_settings['url_action'];
	$button_text       = $banner_settings['button_text'];
?>
<body>
	<h2><?php echo esc_html( __("General Settings",'codup-promotional-banner') ) ?></h2>
	<form method="post" action="" name="sb_settings">
		<?php wp_nonce_field( 'banner_general_settings', 'banner_general_settings' ); ?>
		<table class="form-table">
			<tbody>
				<tr>
					<th>
						<label  ><?php echo esc_html( __("Enable / Disable",'codup-promotional-banner') ) ?></label>
					</th>
					<td>
						<?php if ( 'yes' === $banner_settings['enable_disable'] ) : ?>
						<input type="checkbox" class="enable-disable-banner" id="enable-disable-banner" name="enable-disable-banner" checked >
						
						<?php else : ?>
						<input type="checkbox" class="enable-disable-banner" id="enable-disable-banner" name="enable-disable-banner">
						<?php endif ?>
					</td>
				</tr>
						
				<tr>
					<th>
						<label  ><?php echo esc_html( __("Banner Text",'codup-promotional-banner') ) ?></label>
					</th>
					<td>
						<div class="field_wrapper">
							<?php if ( empty( $banner_text ) ) { ?>
								<textarea name="field_name[]" id="field_name[]" cols="30" rows="4"></textarea>
								<a href="javascript:void(0);" class="add_button" title="Add field"><?php echo esc_html( __("Add",'codup-promotional-banner') ) ?></a>
							<?php } ?>
							<?php if ( !empty( $banner_text ) ) { ?>
								<?php
									$i = 0; 
									foreach ( $banner_text as $banners_texts ) {
										if ( 0 === $i ) { ?>

										<textarea name="field_name[]" id="" cols="30" rows="4"><?php echo esc_html( $banners_texts ); ?></textarea> 
										<a href="javascript:void(0);" class="add_button" title="Add field"><?php echo esc_html( __("Add",'codup-promotional-banner') ) ?></a>
										<?php } ?>
										<?php if ( 0 !== $i ) { ?>
										<div>
											<textarea name="field_name[]" id="field_name[]" cols="30" rows="4"><?php echo esc_html( $banners_texts ); ?></textarea>
											<a href="javascript:void(0);" class="remove_button"><?php echo esc_html( __("Remove",'codup-promotional-banner') ) ?></a>
										</div>
										<?php
										}
									$i++;
									}
							} ?>
						</div>
					</td>
				</tr>
				<tr >
					<th>
						<label  ><?php echo esc_html( __("Target url",'codup-promotional-banner') ) ?></label>
					</th>
					<td>
						<input type="url" id="banner-url" name="banner-url" value="<?php echo esc_attr( $targeturl ); ?>" />
					</td>
				</tr>

				<tr>
					<th>
						<label  ><?php echo esc_html( __("Target url option",'codup-promotional-banner') ) ?></label>
					</th>
					<td>
						<input type="radio" id="url-action-complete-content" class="url-action" name="url-action" value="complete-content" <?php echo ('complete-content' === $banner_url_action) ? 'checked' : ''; ?> ><?php echo esc_html( __("Complete content",'codup-promotional-banner') ) ?><br>
						<input type="radio" id="url-action-call-to-action" class="url-action" name="url-action" value="call-to-action" <?php echo ('call-to-action' === $banner_url_action) ? 'checked' : ''; ?> ><?php echo esc_html( __("Call to action",'codup-promotional-banner') ) ?><br><br>
					</td>
				</tr>

				<tr id="buttonname" <?php echo ('complete-content' === $banner_url_action) ? "hidden" : ( (null === $banner_url_action) ? "hidden" : "" ) ?> >
					<th>
						<label  ><?php echo esc_html( __("Button Name",'codup-promotional-banner') ) ?></label>
					</th>
					<td>
						<input type="text" id="button_text" name="button_text" placeholder="button text" value="<?php echo esc_attr( $button_text ); ?>"/> 
					</td>
				</tr>

				<tr >
					<th>
						<label  ><?php echo esc_html( __("Expiry date",'codup-promotional-banner') ) ?></label>
					</th>
					<td>
						<input type="date" id="banner-expiry" name="banner-expiry" value="<?php echo esc_attr( $expirydate ); ?>" />
					</td>
				</tr>

			</tbody>
		</table>
		<p class="submit">
			<input id="general_settings_submit" class="button button-primary" type="button" value= <?php echo esc_html( __("Save Changes",'codup-promotional-banner') ) ?>>
			<img style="position: relative;top: 13px;left: 30px;display:none;" src="<?php echo esc_url( CPB_ASSETS_DIR_URL . '/img/loader.gif' ); ?>" id="loader" />
			<div style="display:none" id="message"></div>
		</p>
	</form>
</body>
