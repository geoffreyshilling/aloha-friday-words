<?php
/**
 * Activation Functions
 *
 * @copyright   Copyright (c) 2018, Geoffrey Shilling
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Create a function called "mug_monday_rewrite_flush" if it doesn't already exist
if ( ! function_exists( 'afw808_rewrite_flush' ) ) {
	/**
	 * Flush the rewrite rules once Mug Monday CPT is created.
	 *
	 * @return void
	*/
	function afw808_rewrite_flush() {
		// call the CPT registration function
	    afw808_register_aloha_friday_post_type();
		/* Flush rewrite rules for custom post types. */
	    flush_rewrite_rules();
	}
}
register_activation_hook( __FILE__, 'afw808_rewrite_flush' );
