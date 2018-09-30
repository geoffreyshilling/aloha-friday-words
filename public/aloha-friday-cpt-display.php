<?php
/**
 * Aloha Friday Custom Post Type Display Functions
 *
 * @copyright   Copyright (c) 2018, Geoffrey Shilling
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// Create a function called "ord808af_add_aloha_friday_post_types_to_query" if it doesn't already exist
if ( ! function_exists( 'ord808af_add_aloha_friday_post_types_to_query' ) ) {
	// Show posts of 'post' and 'mug monday' post types on home page
	function ord808af_add_aloha_friday_post_types_to_query( $query ) {
	  if ( true ) {
	    if ( $query->is_search ) {
	      $query->set( 'post_type', array( 'post', 'ord808_aloha_friday' ) );
	    }
	  }
	}
}

add_action( 'pre_get_posts','ord808af_add_aloha_friday_post_types_to_query', 10, 1 );

