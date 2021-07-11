<?php
/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the #main and #page div elements.
 *
 * @package WordPress
 * @subpackage TemplateMela
 * @since TemplateMela 1.0
 */
?>
<?php tmpmela_content_after(); ?>
</div>
<!-- .main-content-inner -->
</div>
<!-- .main_inner -->
</div>
<!-- #main -->


<?php tmpmela_footer_before(); ?>
<footer id="colophon" class="site-footer" >

  <div class="top-footer">
    <div class="theme-container">
  <ul>
    <li>
      <i class="fa fa-phone"></i>
      <p>
<span>CALL 7 DAYS: 8 AM TO 9 PM

</span>
      1800 3010 2273, 1800 103 3300 (Toll free)
</p>
    </li>

    <li>
      <i class="fa fa-envelope"></i>
      <p>
<span>EMAIL</span>
      info@floritaindia.com
</p>
    </li>


</ul>
<p>
<span>
Looking For Bulk Purchase?
</span>
      <a href="javascript:void(0)">
Tell us your requirement
</a>
</p>
</div>
</div>


		 <?php tmpmela_footer_inside(); ?>
		<?php get_sidebar('footer'); ?>
		 <div class="footer-bottom">
		 	 <div class="theme-container">
					<?php if ( has_nav_menu('footer-menu') ) { ?>
					<div class="footer-menu-links">
					<?php
								$tmpmela_footer_menu=array(
								'menu' => esc_html__('TM Footer Navigation','bsflorita'),
								'depth'=> 1,
								'echo' => false,
								'menu_class'      => 'footer-menu',
								'container'       => '',
								'container_class' => '',
								'theme_location' => 'footer-menu'
								);
								echo wp_nav_menu($tmpmela_footer_menu);
								?>
					</div><!-- #footer-menu-links -->
					<?php } ?>
				   	<div class="site-info">  <?php echo esc_html__( 'Copyright', 'bsflorita' ); ?> &copy; <?php echo esc_attr(date('Y')); ?> <?php echo esc_attr(stripslashes(get_option('tmpmela_footer_slog')));?>
							<?php do_action( 'tmpmela_credits' ); ?>
					</div>

				<?php if ( is_active_sidebar( 'footer-bottom-widget-area' ) ) : ?>
					<?php dynamic_sidebar( 'footer-bottom-widget-area' ); ?>
				<?php endif; ?>
			</div>
	 </div>
</footer>
<!-- #colophon -->
<?php tmpmela_footer_after(); ?>
</div>
<!-- #page -->
<?php tmpmela_go_top(); ?>
<?php tmpmela_get_widget('before-end-body-widget'); ?>
<?php wp_footer(); ?>
</body>
</html>