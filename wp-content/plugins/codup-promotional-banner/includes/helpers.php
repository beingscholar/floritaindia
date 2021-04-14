<?php
/**
 *  For getting all pages
 *
 * @package helpers.php
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

 /**
  *  Method for getting all site pages
  */
function cpb_get_all_pages() {
	$pages = get_pages( [ 'post_status' => 'publish' ] );

	foreach ( $pages as $page ) {
		$page_data[ $page->ID ] = $page->post_title;
	}
	return $page_data;
}
