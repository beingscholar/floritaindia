<?php
/**
 *  For front-end settings of banner
 *
 * @package banner-settings.php
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

<?php $all_site_pages = cpb_get_all_pages(); ?>
<?php

	$banner_settings = get_option( 'cpb_settings_banner' );

?>

<?php

	$bg_color        = $banner_settings['background-color'];
	$font_color      = $banner_settings['font-color'];
	$pages_list      = $banner_settings['pages_list'];
	$font_size       = $banner_settings['font_size'];
	$delay           = $banner_settings['delay'];
	$banner_position = $banner_settings['banner_position'];
	$banner_size     = $banner_settings['banner_size'];
	$pages_selection = $banner_settings['pages_selection'];
?>
<body>
	<h2><?php echo esc_html( __("Banner Settings",'codup-promotional-banner') )?></h2>
	<form method="post" action="" name="sb_settings">
		<?php wp_nonce_field( 'banner_settings', 'banner_settings' ); ?>
		<table class="form-table">
			<tbody>
				<tr>
					<th>
						<label ><?php echo esc_html( __("Background Color",'codup-promotional-banner') ) ?></label>
					</th>
					<td>
						<input type="text"  class="hex-color-field" id="background-color" name="background-color" value="<?php echo esc_attr( $bg_color ); ?>" />
					</td>
					<td rowspan="2"></td>
				</tr>
				<tr>
					<th>
						<label ><?php echo esc_html( __("Font Color",'codup-promotional-banner') )?></label>
					</th>
					<td>
						<input type="text"  class="hex-color-field" id="font-color" name="font-color" value="<?php echo esc_attr( $font_color ); ?>" />
					</td>
				</tr>

				<tr>
					<th>
						<label ><?php echo esc_html( __("Banner Height",'codup-promotional-banner') ) ?></label>
					</th>
					<td>
						<input type="text" id="banner-size" name="banner-size" value="<?php echo esc_attr( $banner_size ); ?>" /> <span> In pixel e.g:40px </span>
					</td>
				</tr>

				<tr>
					<th>
						<label  ><?php echo esc_html( __("Font Size",'codup-promotional-banner') ) ?></label>
					</th>
					<td>
						<input type="text" id="font-size" name="font-size" value="<?php echo esc_attr( $font_size ); ?>" /><span> In pixel e.g:20px </span>
					</td>
				</tr>

				<tr>
					<th>
						<label  ><?php echo esc_html( __("Banner Delay",'codup-promotional-banner') ) ?></label>
					</th>
					<td>
						<input type="number" id="font-delay" name="font-delay" value="<?php echo esc_attr( $delay ); ?>" /><span> 1sec=1000 e.g:1000</span>
					</td>
				</tr>

				<tr>
					<th>
						<label  ><?php echo esc_html( __("Banner Position",'codup-promotional-banner') ) ?></label>
					</th>
					<td>
						<input type="radio" id='banner-position' name="banner-position" value="top" <?php echo ('top' === $banner_position) ? 'checked=checked' : ''; ?> ><?php echo esc_html( __("Top",'codup-promotional-banner') ) ?><br>
						<input type="radio" id="banner-position" name="banner-position" value="fixed" <?php echo ('fixed' === $banner_position) ? 'checked=checked' : ''; ?> ><?php echo esc_html( __("Top fixed",'codup-promotional-banner') ) ?><br>
						<input type="radio" id="banner-position" name="banner-position" value="bottom" <?php echo ('bottom' === $banner_position) ? 'checked=checked' : ''; ?> ><?php echo esc_html( __("Bottom",'codup-promotional-banner') ) ?>  
					</td>
				</tr>
				
				<tr>
					<th>
						<label  ><?php echo esc_html( __("Pages to display",'codup-promotional-banner') ) ?></label>
					</th>
					<td>
						<b>Site Pages</b><hr>
						<input type="radio" id="select_all_pages_radio" name="pages_selection" value="show_to_all_pages" title="Select All" style="margin-right:5px;"  <?php echo ('show_to_all_pages' === $pages_selection) ? 'checked' : ''; ?> > <?php echo esc_html( __("Select all pages",'codup-promotional-banner') ) ?>
						<input type="radio" id="show_to_specific_pages_radio" name="pages_selection" value="show_to_specific_pages" title="Show Specific Pages"  <?php echo ('show_to_specific_pages' === $pages_selection) ? 'checked' : ''; ?> ><?php echo esc_html( __("Show specific pages",'codup-promotional-banner') ) ?>
						<br>
						<div id="shop_page_div" style="min-height:150px;" <?php echo ('show_to_all_pages' === $pages_selection) ? esc_attr("hidden"): ( (null === $pages_selection) ? esc_attr("hidden") : "" )?> >
							<div class="container">
								<div class="row">
									<select  id="pages_list" class="pages_list" name="pages_list[]" multiple="multiple">
										<?php foreach ( $all_site_pages as $page_id => $page_name ): ?>
											<?php $selected = is_array( $pages_list ) && in_array( strval($page_id), $pages_list, true ); ?>
											<option <?php echo $selected ? 'selected=selected' : ''; ?> value="<?php echo esc_attr( $page_id ); ?>"><?php echo esc_attr( $page_name ); ?>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
						</div>
					</td>
				</tr>
			</tbody>
		</table>
		<p class="submit">
			<input id="banner_settings_submit" class="button button-primary" type="button" value=<?php echo esc_html( __("Save Changes",'codup-promotional-banner') ) ?> >
			<img style="position: relative;top: 13px;left: 30px;display:none;" src="<?php echo esc_url( CPB_ASSETS_DIR_URL . '/img/loader.gif' ); ?>" id="loader" />
			<div style="display:none" id="message"></div>
		</p>
	</form>
</body>
