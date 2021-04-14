<?php
/**
 *  For single text banner
 *
 * @package singlebanner.php
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
<?php
if ( 'fixed' === $general_settings['banner_position'] ) {
	$body_height = $general_settings['banner_size'] + 32;
	?>
	<style>
		body{
			margin-top:<?php echo esc_html( $general_settings['banner_size'] ); ?>; 
		}
		body.logged-in.admin-bar{
			margin-top: <?php echo esc_html($body_height) .'px !important'; ?>;
		}
	</style>
			
	<div id="carousel" class="top-banner top-banner-css" style="height:<?php echo esc_html( $general_settings['banner_size'] ); ?> ;" background-color: <?php echo esc_html( $general_settings['background-color'] ); ?>;" >
		<?php $banner_text = $banner_settings['banner_text']; ?>
		<?php $button_font_size = $general_settings['font_size'] / 2 + 4; ?>
		<div class="quoteContainer">
			<p class="quote-phrase margin-zero"  style="font-size: <?php echo esc_html( $general_settings['font_size'] ); ?>" > 
			<?php if ( 'call-to-action' === $banner_settings['url_action'] ) { ?>
				<a  style=" color:<?php echo esc_html( $general_settings['font-color'] ); ?>;"><span class="quote-marks"><?php echo wp_kses_post( $banner_text[0] ); ?></span></a>
				<a href="<?php echo esc_url( $banner_settings['bannerurl'] ); ?> ">
				<input type="submit" class="slider-cta-btn" style="font-size: <?php echo esc_attr( $button_font_size . 'px' ); ?>;"  id="submit" value="<?php echo esc_attr( $banner_settings['button_text'] ); ?>" ></a>
				<?php
			} else {
					if($banner_settings['bannerurl'] === ""){
						?>
						<a class="pointer-event-css" href="<?php echo esc_url( $banner_settings['bannerurl'] ); ?> "  style=" color:<?php echo esc_html( $general_settings['font-color'] ); ?>;"><span class="quote-marks"><?php echo wp_kses_post( $banner_text[0] ); ?></span></a>
						<?php
					}else{
						?>
						<a href="<?php echo esc_url( $banner_settings['bannerurl'] ); ?> "  style=" color:<?php echo esc_html( $general_settings['font-color'] ); ?>;"><span class="quote-marks"><?php echo wp_kses_post( $banner_text[0] ); ?></span></a>
						<?php
					}
				?>
					
					<?php
			}
			?>
		</div>
	</div>
	<?php

} else {
	?>
	<div id="carousel"  class="single-banner single-banner-css"  style="height:<?php echo esc_html( $general_settings['banner_size'] ); ?> ; background-color: <?php echo esc_html( $general_settings['background-color'] ); ?>;" >
		<?php $button_font_size = intval($general_settings['font_size']) / 2 + 4; ?>
		<?php $banner_text = $banner_settings['banner_text']; ?>
		<div class="quoteContainer">
			<p class="quote-phrase margin-zero"  style="font-size: <?php echo esc_html( $general_settings['font_size'] ); ?>" > 
		<?php if ( 'call-to-action' === $banner_settings['url_action'] ) { ?>
			<a  style=" color:<?php echo esc_html( $general_settings['font-color'] ); ?>;"><span class="quote-marks" style="font-size: <?php echo esc_html( $general_settings['font_size'] ); ?>"><?php echo wp_kses_post( $banner_text[0] ); ?></span></a>
			<a href="<?php echo esc_url( $banner_settings['bannerurl'] ); ?> ">
			<input type="submit" id="submit"  style="font-size: <?php echo esc_attr( $button_font_size . 'px' ); ?>;" value="<?php echo esc_attr( $banner_settings['button_text'] ); ?>" ></a>
			<?php
		} else {if($banner_settings['bannerurl'] === ""){
			?>
			<a class="pointer-event-css" href="<?php echo esc_url( $banner_settings['bannerurl'] ); ?> "  style=" color:<?php echo esc_html( $general_settings['font-color'] ); ?>;"><span class="quote-marks"><?php echo  wp_kses_post( $banner_text[0] ); ?></span></a>
			<?php
		}else{
			?>
			<a href="<?php echo esc_url( $banner_settings['bannerurl'] ); ?> "  style=" color:<?php echo esc_html( $general_settings['font-color'] ); ?>;"><span class="quote-marks"><?php echo  wp_kses_post( $banner_text[0] ) ; ?></span></a>
			<?php
		}
		}
		?>
		</div>
	</div> <?php
} ?>
