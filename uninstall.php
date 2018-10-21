<?php
/**
 * Uninstall Aloha Friday Words
 *
 * Deletes all the plugin data i.e.
 * 		1. Custom Post types.
 * 		2. Terms & Taxonomies.
 * 		3. Plugin options.
 *
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) exit;
global $wpdb;
require_once ABSPATH . '/wp-admin/includes/post.php';
// Load EDD file.
include_once( 'aloha-friday-words.php' );



$aloha_friday_words_cat_id = array( get_cat_ID( 'Aloha Friday Words' ) );
wp_delete_term( $aloha_friday_words_cat_id[0], 'category' );

	/** Delete All the Custom Post Types */
	$afw_taxonomies = array( 'aloha-friday', 'aloha-friday-words' );
	$afw_post_types = array( 'aloha_friday_words', 'ord808_aloha_friday' );
	foreach ( $afw_post_types as $post_type ) {

		$afw_taxonomies = array_merge( $afw_taxonomies, get_object_taxonomies( $post_type ) );
		$items = get_posts( array( 'post_type' => $post_type, 'post_status' => 'any', 'numberposts' => -1, 'fields' => 'ids' ) );

		if ( $items ) {
			foreach ( $items as $item ) {
				wp_delete_post( $item, true);
			}
		}
	}

	/** Delete All the Terms & Taxonomies */
	foreach ( array_unique( array_filter( $afw_taxonomies ) ) as $taxonomy ) {

		$terms = $wpdb->get_results( $wpdb->prepare( "SELECT t.*, tt.* FROM $wpdb->terms AS t INNER JOIN $wpdb->term_taxonomy AS tt ON t.term_id = tt.term_id WHERE tt.taxonomy IN ('%s') ORDER BY t.name ASC", $taxonomy ) );

		// Delete Terms.
		if ( $terms ) {
			foreach ( $terms as $term ) {
				$wpdb->delete( $wpdb->term_relationships, array( 'term_taxonomy_id' => $term->term_taxonomy_id ) );
				$wpdb->delete( $wpdb->term_taxonomy, array( 'term_taxonomy_id' => $term->term_taxonomy_id ) );
				$wpdb->delete( $wpdb->terms, array( 'term_id' => $term->term_id ) );
			}
		}

		// Delete Taxonomies.
		$wpdb->delete( $wpdb->term_taxonomy, array( 'taxonomy' => $taxonomy ), array( '%s' ) );
	}

	

	/** Delete all the Plugin Options */
	delete_option( 'my_option_name' );


    global $wp_post_types;
    if ( isset( $wp_post_types[ 'afw808_aloha_friday' ] ) ) {
        unset( $wp_post_types[ 'afw808_aloha_friday' ] );
    }