<?php
/**
 * TemplateMela
 * @copyright  Copyright (c) TemplateMela. (http://www.templatemela.com)
 * @license    http://www.templatemela.com/license/
 * @author         TemplateMela
 * @version        Release: 1.0
 */
/**  Set Default options : Theme Settings  */
function tmpmela_set_default_options_child()
{
	/*  General Settings  */
	add_option("tmpmela_show_site_loader","yes"); // Show Loader
	add_option("tmpmela_loader_background_color","C70A0A"); //Loader Background color
	add_option("tmpmela_logo_image",get_stylesheet_directory_uri()."/images/megnor/logo.png"); // set logo image	
	add_option("tmpmela_logo_image_alt",'firezy_layout7'); // set logo image alt
	add_option("tmpmela_mob_logo_image", get_stylesheet_directory_uri()."/images/megnor/mob-logo.png"); // set logo image	
	add_option("tmpmela_mob_logo_image_alt",'firezy_layout7'); // set logo image alt
	add_option("tmpmela_bkg_color","FFFFFF"); // background color
	add_option("tmpmela_bodyfont_color","838383"); // body font color
	
	add_option("tmpmela_button_color","c70a0a"); // button color
	add_option("tmpmela_button_text_color","FFFFFF"); // button Text color
	add_option("tmpmela_button_hover_color","ffd200"); // button hover color
	add_option("tmpmela_button_hover_text_color","000000"); // button hover Text color

	/*  Header Settings  */
	add_option("tmpmela_header_top_bkg_color","c70a0a"); // header top background color		
	add_option("tmpmela_header_bottom_bkg_color","b30909"); // header background color		
	add_option("tmpmela_show_header_services","yes");//Show Header CMS Service Setting?
	add_option("tmpmela_header_topservice_text1_color","FFFFFF"); // Header cms service Text1 color
	add_option("tmpmela_header_topservice_text2_color","FFFFFF"); // Header cms service Text2 color
	add_option("tmpmela_header_right_service_text_color","000000"); // Header Right Service Text Color
	add_option("tmpmela_header_right_service_background_color","FFFFFF");//Header Right Background color
	
    /*  Navigation Menu Setting  */
	add_option("tmpmela_top_menu_text_color","FFFFFF"); // Top menu text color
	add_option("tmpmela_top_menu_texthover_color","ffd200"); // Top menu text hover color
	add_option("tmpmela_sub_menu_bkg_color","FFFFFF"); // Sub menu background color
	add_option("tmpmela_sub_menu_text_color","000000"); // Sub menu text color
	add_option("tmpmela_sub_menu_texthover_color","c70a0a"); // Sub menu text hover color
	
	add_option("tmpmela_categoty_title1_text_color","FFFFFF");//Category Title1 text Color
	add_option("tmpmela_categoty_title2_text_color","ffd200"); //Category Title2 Text color
	add_option("tmpmela_sidebar_category_bg_color","c70a0a"); //Categoty Block Background Color
	add_option("tmpmela_sidebar_category_link_color","FFFFFF");//Category Link Color
	add_option("tmpmela_sidebar_category_link_hover_color","ffd200"); //Categoty Block Link hover Color
	add_option("tmpmela_sidebar_category_child_link_color","c70a0a"); //Categoty Block Child Link Color
	add_option("tmpmela_sidebar_category_child_link_hover_color","ffd200"); //Categoty Block Child Link hover Color
	add_option("tmpmela_sidebar_category_sub_child_link_color","000000");//Categoty Block Sub Child Link Color
	add_option("tmpmela_sidebar_category_sub_child_link_hover_color","c70a0a"); //Categoty Block Sub Child Link hover Color
	
	/*  Content Settings  */
	add_option("tmpmela_h1font",'Poppins'); // h1 family google font
	add_option("tmpmela_h1font_other",'Arial'); // h1 family specified font
	add_option("tmpmela_h1color",'000000'); // h1 family font color	 
	add_option("tmpmela_h2font",'Poppins'); // h2 family google font
	add_option("tmpmela_h2font_other",'Arial'); // h2 family specified font
	add_option("tmpmela_h2color",'000000'); // h2 family font color	
	add_option("tmpmela_h3font",'Poppins'); // h3 family google font
	add_option("tmpmela_h3font_other",'Arial'); // h3 family specified font
	add_option("tmpmela_h3color",'000000'); // h3 family font color	
	add_option("tmpmela_h4font",'Poppins'); // h4 family google font
	add_option("tmpmela_h4font_other",'Arial'); // h4 family specified font
	add_option("tmpmela_h4color",'000000'); // h4 family font color	
	add_option("tmpmela_h5font",'Poppins'); // h5 family google font
	add_option("tmpmela_h5font_other",'Arial'); // h5 family specified font 
	add_option("tmpmela_h5color",'000000'); // h5 family font color	
	add_option("tmpmela_h6font",'Poppins'); // h6 family google font
	add_option("tmpmela_h6font_other",'Arial'); // h6 family specified font 
	add_option("tmpmela_h6color",'000000'); // h6 family font color	
	add_option("tmpmela_link_color","000000"); // link color
	add_option("tmpmela_hoverlink_color","c70a0a"); // link hover color
	
	/*  Footer Settings  */	
	add_option("tmpmela_footer_bkg_color","B30909"); // footer background color	
	add_option("tmpmela_footer_title_color","ffd200"); // footer link text color
	add_option("tmpmela_footerlink_color","EBEBEB"); // footer link text color
	add_option("tmpmela_footerhoverlink_color","ffd200"); // footer link hover text color

}
add_action('init', 'tmpmela_set_default_options_child');
function tmpmela_child_scripts() {
    wp_enqueue_style( 'tmpmela-child-style', get_template_directory_uri(). '/style.css' );	
}
add_action( 'wp_enqueue_scripts', 'tmpmela_child_scripts' );
register_sidebar( array(
        'name' => esc_html__( 'Home Sidebar', 'firezy' ),
        'id' => 'home-sidebar',
        'description' => esc_html__( 'The Home Sidebar', 'firezy' ),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => "</aside>",
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ) );
/********************************************************
**************** One Click Import Data ******************
********************************************************/

if ( ! function_exists( 'sampledata_import_files' ) ) :
function sampledata_import_files() {
    return array(
		 array(
        'import_file_name'             => 'firezy_layout7',
        'local_import_file'            => trailingslashit( get_stylesheet_directory() ) . 'demo-content/demo7/firezy_layout7.wordpress.xml',
        'local_import_customizer_file' => trailingslashit( get_stylesheet_directory() ) . 'demo-content/demo7/firezy_layout7_customizer_export.dat',
		'local_import_widget_file'     => trailingslashit( get_stylesheet_directory() ) . 'demo-content/demo7/firezy_layout7_widgets_settings.wie',
        'import_notice'                => esc_html__( 'Please waiting for a few minutes, do not close the window or refresh the page until the data is imported.', 'firezy' ),
        ),
		);
}
add_filter( 'pt-ocdi/import_files', 'sampledata_import_files' );
endif;

if ( ! function_exists( 'sampledata_after_import' ) ) :
function sampledata_after_import($selected_import) {
         //Set Menu
        $header_menu = get_term_by('name', 'MainMenu', 'nav_menu');
        $top_menu = get_term_by('name', 'Header Top Links', 'nav_menu');
		$footer_menu = get_term_by('name', 'MainMenu', 'nav_menu');
        set_theme_mod( 'nav_menu_locations' , array( 
		 'primary'   => $header_menu->term_id,
		 'header-menu'   => $top_menu->term_id ,
		 'footer-menu'   => $footer_menu->term_id 
         ) 
        );
		
		//Set Front page and blog page
       $page = get_page_by_title( 'Home');
       if ( isset( $page->ID ) ) {
        update_option( 'page_on_front', $page->ID );
        update_option( 'show_on_front', 'page' );
       }
	   $post = get_page_by_title( 'Blog');
       if ( isset( $page->ID ) ) {
        update_option( 'page_for_posts', $post->ID );
        update_option( 'show_on_posts', 'post' );
       }
	   
	   //Import Revolution Slider
       if ( class_exists( 'RevSlider' ) ) {
           $slider_array = array(
              get_stylesheet_directory()."/demo-content/demo7/tmpmela_homeslider_firezy_layout7.zip",
              );
 
           $slider = new RevSlider();
        
           foreach($slider_array as $filepath){
             $slider->importSliderFromPost(true,true,$filepath);  
           }
           echo esc_html__( 'Slider processed', 'firezy' );
      }
}
add_action( 'pt-ocdi/after_import', 'sampledata_after_import' );
endif;
?>