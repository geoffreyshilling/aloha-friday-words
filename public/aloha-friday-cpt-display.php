<?php
/**
 * Aloha Friday Custom Post Type Display Functions
 *
 * @copyright   Copyright (c) 2018, Geoffrey Shilling
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Create a function called "afw808_add_aloha_friday_post_types_to_query" if it doesn't already exist
if ( ! function_exists( 'afw808_add_aloha_friday_post_types_to_query' ) ) {
	// Show posts of 'post' and 'mug monday' post types on home page
	function afw808_add_aloha_friday_post_types_to_query( $query ) {
        if ( $query->is_main_query() ) {
            $query->set( 'post_type', array( 'post', 'afw808_aloha_friday' ) );
            return $query;
		}
	}
}
add_action( 'pre_get_posts','afw808_add_aloha_friday_post_types_to_query', 10, 1 );

