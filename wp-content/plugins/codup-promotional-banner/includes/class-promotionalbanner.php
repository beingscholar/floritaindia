<?php
/**
 *  Main file of banner
 *
 * @package class-promotionalbanner.php
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'CodupPromotionalBanner' ) ) {
	/**
	 *  Main class of banner containing all settings and enqueue methods
	 */
	class CodupPromotionalBanner {

		/**
		 * Constructor
		 */
		public function __construct() {

			$cpb_general_settings = get_option( 'cpb_settings_banner' );

			add_action( 'admin_menu', array( $this, 'cpb_add_banner_option' ) );
			add_action( 'wp_ajax_cpb_save_general_settings', array( $this, 'cpb_save_general_settings' ) );
			add_action( 'wp_ajax_cpb_save_banner_settings', array( $this, 'cpb_save_banner_settings' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'cpb_slider_asset' ) );
			add_action( 'admin_init', array( $this, 'cpb_assets' ) );

			if ( 'fixed' === $cpb_general_settings['banner_position'] || 'top' === $cpb_general_settings['banner_position'] ) {

				add_action( 'wp_head', array( $this, 'cpb_banner_enqueue' ) );
			} else {
				add_action( 'wp_footer', array( $this, 'cpb_banner_enqueue' ) );
			}

		}

		/**
		 * Banner date_expiry
		 *
		 * @return Boolean
		 */
		public function cpb_is_date_valid() {

			$cpb_banner_settings = get_option( 'cpb_settings' );
			$cpb_to_date = $cpb_banner_settings['banner_expiry'];
			$cpb_current_date = date( 'Y-m-d' );

			if ( empty( $cpb_to_date ) ) {
				return true;
			}
			
			if (! empty( $cpb_to_date ) && $cpb_current_date <= $cpb_to_date ) {
				return true;
			}

			return false;

		}

		/**
		 * Function to enqueue banner on all or selected pages
		 *
		 * @return void
		 */
		public function cpb_banner_enqueue() {
			
			$template = '';
			$post = $GLOBALS['wp_the_query']->get_queried_object();

			if( isset( $post->post_name ) ) {
				$page_name = $post->post_name;
			}
			else {
				$page_name = null;
			}

			if ( null === $page_name ) {
				if ( null !== get_option( 'woocommerce_shop_page_id' ) ) {
					$id = strval( get_option( 'woocommerce_shop_page_id' ) );
				}
			}
			else {
				$id = strval(get_queried_object_id());
			}

			$banner_settings  = get_option( 'cpb_settings' );
			$general_settings = get_option( 'cpb_settings_banner' );
			
			if ( 'yes' === $banner_settings['enable_disable'] && $this->cpb_is_date_valid() ) {

				if ( "true" === $general_settings['allpages'] ) {

					if ( 'complete-content' === $banner_settings['url_action'] ) {
						
						$banner_text = $banner_settings['banner_text'];
						
						if ( 'top' === strval($general_settings['banner_position']) || 'bottom' === strval($general_settings['banner_position']) ) {
							if ( sizeof( $banner_text ) === 1 ) {
								$template = 'singlebanner';
							}
							else {
								$template = 'multibanner';

							}
						}
						else {
							if ( sizeof( $banner_text ) === 1 ) {
								$template = 'singlebanner';
							}
							else {
								$template = 'to-fixed';
							}
						}
					}

					if ( 'call-to-action' === $banner_settings['url_action'] ) {

						$banner_text = $banner_settings['banner_text'];
						if ( 'top' === $general_settings['banner_position'] || 'bottom' === $general_settings['banner_position'] ) {
							
							if ( sizeof( $banner_text ) === 1 ) {
								$template = 'singlebanner';
							}
							else {
								$template = 'multibanner';
							}
						}
						else {

							if ( sizeof( $banner_text ) === 1 ) {

								$template = 'singlebanner';
							} else {

								$template = 'to-fixed';
							}
						}
					}
				}
				else {
					
					if ( is_array( $general_settings['pages_list'] ) && in_array( $id, $general_settings['pages_list'], true ) ) {
						if ( 'complete-content' === $banner_settings['url_action'] ) {
							$banner_text = $banner_settings['banner_text'];
							if ( 'top' === $general_settings['banner_position'] || 'bottom' === $general_settings['banner_position'] ) {
								if ( count( $banner_text ) === 1 ) {

									$template = 'singlebanner';
								}
								else {

									$template = 'multibanner';

								}
							}
							else {
								if ( count( $banner_text ) === 1 ) {

									$template = 'singlebanner';
								} else {

									$template = 'to-fixed';
								}
							}
						}

						if ( 'call-to-action' === $banner_settings['url_action'] ) {

							$banner_text = $banner_settings['banner_text'];
							
							if ( 'top' === $general_settings['banner_position'] || 'bottom' === $general_settings['banner_position'] ) {
								if ( count( $banner_text ) === 1 ) {
									$template = 'singlebanner';
								}
								else {
									$template = 'multibanner';
								}
							}
							else {
								if ( count( $banner_text ) === 1 ) {

									$template = 'singlebanner';
								}
								else {

									$template = 'to-fixed';
								}
							}
						}
					}
				}
			
				if( $template ){
					include CPB_PLUGIN_DIR . '/templates' . '/' . $template . '.php';
				}
				

			}
		}

		/**
		 * Function enqueues JS files and other css files.
		 *
		 * @return void
		 */
		public function cpb_assets() {
			if(isset($_GET['page']) && 'cpb_bs_settings' == $_GET['page']){
				wp_enqueue_style( 'cpb-select2-stylings', CPB_ASSETS_DIR_URL . '/css/style.css', null, 1 );
			}
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_style( 'cpb-select2-styling', CPB_ASSETS_DIR_URL . '/css/select2.min.css', null, 1 );

			wp_enqueue_script( 'my-script-handle', plugins_url('my-script.js', __FILE__ ), array( 'wp-color-picker' ), false, true );

			wp_enqueue_script( 'cpb-select2-script', CPB_ASSETS_DIR_URL . '/js/select2.min.js', array( 'jquery' ), true );

			wp_enqueue_script( 'cpb-main-script', CPB_ASSETS_DIR_URL . '/js/main.js', array( 'jquery', 'cpb-select2-script' ), true );
			wp_localize_script(
				'cpb-main-script',
				'cpb_ajax_vars',
				array(
					'url' => admin_url( 'admin-ajax.php' ),
				)
			);
		}

		/**
		 * Function enqueues JS files for slider and other css files.
		 *
		 * @return void
		 */
		public function cpb_slider_asset() {

			wp_enqueue_style( 'stylings', CPB_ASSETS_DIR_URL . '/css/style2.css', null, 1 );
			wp_enqueue_script( 'cpb-sb1-script', CPB_ASSETS_DIR_URL . '/js/slider.js', array( 'jquery', 'jquery-ui-slider' ), true );
			
			wp_localize_script(
				'cpb-sb1-script',
				'cpb_sb1_ajax_vars',
				array(
					'url'       => admin_url( 'admin-ajax.php' ),
					'timer_val' => get_option( 'cpb_settings_banner' ),
				)
			);

		}

		/**
		 * Function generates Banner Settings option on WP Admin Menu
		 *
		 * @return void
		 */
		public function cpb_add_banner_option() {
			
			add_menu_page(
				esc_html( 'Promo Banner', 'codup-promotional-banner' ),
				'Promo Banner',
				'manage_options',
				'cpb-main-settings',
				array( $this, ' cpb_menu_callback' ),
				null,
				2
			);

			add_submenu_page( 'cpb-main-settings', esc_html( 'General Settings', 'codup-promotional-banner' ), 'General Settings', 'manage_options', 'cpb_gs_settings', array( $this, 'cpb_general_settings_callback' ) );
			add_submenu_page( 'cpb-main-settings', esc_html( 'Banner Settings', 'codup-promotional-banner' ), 'Banner Settings', 'manage_options', 'cpb_bs_settings', array( $this, 'cpb_banners_settings_callback' ) );
			remove_submenu_page( 'cpb-main-settings', 'cpb-main-settings' );

		}

		/**
		 * Callback template for Banner Settings page in WP Admin Menu
		 *
		 * @return void
		 */
		public function cpb_menu_callback() {
			include CPB_PLUGIN_DIR . '/templates' . '/banner-settings.php';
		}

		/**
		 * Callback template for General Settings page in WP Admin Menu
		 *
		 * @return void
		 */
		public function cpb_general_settings_callback() {
			include CPB_PLUGIN_DIR. '/templates' . '/general-settings.php';
		}

		/**
		 * Callback template for Banner Settings page in WP Admin Menu
		 *
		 * @return void
		 */
		public function cpb_banners_settings_callback() {
			include CPB_PLUGIN_DIR. '/templates' . '/banner-settings.php';
		}

		/**
		 * AJAX Function hooked with JS to save banner_settings and respond accordingly.
		 *
		 * @return void
		 */
		public function cpb_save_banner_settings() {
			if ( ! empty( $_POST ) || isset( $_POST['banner_settings'] ) ) {

				if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['banner_settings'] ) ), 'banner_settings' ) ) {

					echo '<div class="notice notice-error is-dismissible">
                                <p>Nonce verification failed. Refresh the page.</p>
                                </div>';
				}
				else {
					$bag_col     = filter_input( INPUT_POST, 'background-color', FILTER_SANITIZE_STRING );
					$fontcolor   = filter_input( INPUT_POST, 'font-color', FILTER_SANITIZE_STRING );
					$pages_all   = filter_input( INPUT_POST, 'pages_list', FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY );
					$fontsize    = filter_input( INPUT_POST, 'font-size', FILTER_SANITIZE_STRING );
					$delaytime   = filter_input( INPUT_POST, 'font-delay', FILTER_SANITIZE_STRING );
					$pos         = filter_input( INPUT_POST, 'banner-position', FILTER_SANITIZE_STRING );
					$bannerssize = filter_input( INPUT_POST, 'banner_size', FILTER_SANITIZE_STRING );
					$p_selection = filter_input( INPUT_POST, 'pages_shown', FILTER_SANITIZE_STRING );
					$allpages   = filter_input( INPUT_POST, 'allpages', FILTER_SANITIZE_STRING );

					$settings_serialized = ( [
						'background-color' => $bag_col,
						'font-color'       => $fontcolor,
						'pages_list'       => $pages_all,
						'font_size'        => $fontsize,
						'delay'            => $delaytime,
						'banner_position'  => $pos,
						'banner_size'      => $bannerssize,
						'pages_selection'  => $p_selection,
						'allpages'         => $allpages,
					] );
					
					if (  "false" === $allpages && empty($pages_all) && "show_to_specific_pages" === $p_selection) {

						echo '<div class="notice notice-error is-dismissible">
                                <p>Please Select Specific Pages.</p>
                                </div>';
					}
					else if ( update_option( 'cpb_settings_banner', $settings_serialized ) ) {
						echo  '<div class="notice notice-success is-dismissible">
                                <p>'. esc_html( __( "Settings updated", 'codup-promotional-banner') ).'</p>
                                </div>';
					}
					else {
						echo '<div class="notice notice-warning is-dismissible">
                                <p>'. esc_html( __( "No changes made", 'codup-promotional-banner') ).'</p>
                                </div>';
					}
				}
			}
			die;
		}

		/**
		 * AJAX Function hooked with JS to save general_settings and respond accordingly
		 *
		 * @return void
		 */
		public function cpb_save_general_settings() {
			if ( ! empty( $_POST ) || isset( $_POST['banner_general_settings'] ) ) {
				if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['banner_general_settings'] ) ), 'banner_general_settings' ) ) {
					echo '<div class="notice notice-error is-dismissible">
                                <p>Nonce verification failed. Refresh the page.</p>
                                </div>';
				}
				else {

					$banner_text           = filter_input( INPUT_POST, 'banner-text', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY );
					$banner_url            = filter_input( INPUT_POST, 'banner-url', FILTER_SANITIZE_URL );
					$bannerexpiry          = filter_input( INPUT_POST, 'banner-expiry', FILTER_SANITIZE_STRING );
					$banner_enable_disable = filter_input( INPUT_POST, 'enable-disable-banner', FILTER_SANITIZE_STRING );
					$url_action            = filter_input( INPUT_POST, 'url_action', FILTER_SANITIZE_STRING );
					$text_button           = filter_input( INPUT_POST, 'button_text_url', FILTER_SANITIZE_STRING );

					$settings_serialized = ( [
						'banner_text'    => $banner_text,
						'bannerurl'      => $banner_url,
						'banner_expiry'  => $bannerexpiry,
						'enable_disable' => $banner_enable_disable,
						'url_action'     => $url_action,
						'button_text'    => $text_button,
					] );
					if ( update_option( 'cpb_settings', $settings_serialized ) ) {
						echo '<div class="notice notice-success is-dismissible">
                                <p>'. esc_html( __( "Settings updated", 'codup-promotional-banner') ).'</p>
                                </div>';
					} else {
						echo '<div class="notice notice-warning is-dismissible">
                                <p>'. esc_html( __( "No changes made", 'codup-promotional-banner') ).'</p>
                                </div>';
					}
				}
			}
			die;
		}

	}

}
