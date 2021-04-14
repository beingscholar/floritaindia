<?php
/**
 *  For multi-text banner (top(relative)-bottom)
 *
 * @package multibanner.php
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<style>
	.quote-phrase, .quote-phrase *{
		color: <?php echo esc_html( $general_settings['font-color'] ); ?>;
	}
</style>
<div id="carousel" class="multi-banner multi-banner-css" style="height:<?php echo esc_html( $general_settings['banner_size'] ); ?>; background-color: <?php echo esc_html( $general_settings['background-color'] ); ?>;">
	<div class="btn-bar">
	 <div id="buttons"><a id="prev" href="#"></a><a id="next" href="#"></a> </div>
	</div>
	<div id="slides" >
		<ul class="ulmenu">
			<?php $banner_text = $banner_settings['banner_text']; ?>
			<?php $button_font_size = intval($general_settings['font_size']) / 2 + 4; ?>
			<?php foreach ( $banner_text as $bannners_text ) { ?>
				<li class="slide">
					<div class="quoteContainer">
						<p class="quote-phrase margin-zero"  style="font-size: <?php echo esc_html( $general_settings['font_size'] ); ?>;" > 
							<?php if ( 'call-to-action' === $banner_settings['url_action'] ) { ?>
									<a  style=" color:<?php echo esc_html( $general_settings['font-color'] ); ?>;"><span class="quote-marks"><?php echo wp_kses_post( $bannners_text ); ?></span></a>
									<a href="<?php echo esc_url( $banner_settings['bannerurl'] ); ?> ">
									<input type="submit" style="font-size: <?php echo esc_attr( $button_font_size . 'px' ); ?>;"   style="font-size: <?php echo esc_html( $general_settings['font_size'] ); ?>;" id="submit" value="<?php echo esc_attr( $banner_settings['button_text'] ); ?>" >
									</a>
									<?php
							} else {
								if($banner_settings['bannerurl'] === ""){
									?>
									<a class="pointer-event-css" href="<?php echo esc_url( $banner_settings['bannerurl'] ); ?> "  style="color:<?php echo esc_html( $general_settings['font-color'] ); ?>;"><span class="quote-marks"><?php echo wp_kses_post( $bannners_text ); ?></span></a>
									<?php
								}else{
									?>
									<a href="<?php echo esc_url( $banner_settings['bannerurl'] ); ?> "  style=" color:<?php echo esc_html( $general_settings['font-color'] ); ?>;"><span class="quote-marks"><?php echo wp_kses_post( $bannners_text ); ?></span></a>
									<?php
								}
							}
							?>
								
						</p>
					</div>
				</li>
				<?php
			}
			?>
		</ul>
	</div>
</div>
