<?php
/**
 * Aloha Friday Words Custom Post Type Default Settings
 *
 * @copyright   Copyright (c) 2018, Geoffrey Shilling
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Change placeholder text for  post titles
function afw808_add_default_title_placeholder( $placeholder ){
    $screen = get_current_screen();
	switch ( $screen->post_type ) {
        case 'afw808_aloha_friday':
        	$mondayOfThisWeek = strtotime( 'last monday' );
			$weekOfMonday = date( 'F j', $mondayOfThisWeek ) ;

			$my_title = 'Aloha Friday - Week of ' . $weekOfMonday;

			$post_id = post_exists( $my_title );
			while ( $post_id ) {
				$mondayOfThisWeek = strtotime( '+7 day', $mondayOfThisWeek );
				$weekOfMonday = date( 'F j', $mondayOfThisWeek ) ;
				$my_title = 'Aloha Friday - Week of ' . $weekOfMonday;
				$post_id = post_exists( $my_title );
			}
			$placeholder = __( 'Aloha Friday - Week of ', 'aloha-friday-words' ) . $weekOfMonday;
			break;
		default: break;	
	}
	//$options = get_option('my_option_name');
	

	//$placeholder = $options['default_title'];
    return $placeholder;
}
add_filter( 'enter_title_here', 'afw808_add_default_title_placeholder' );

// Create a function called "afw808_add_default_taxonomy" if it doesn't already exist
if ( ! function_exists( 'afw808_add_default_taxonomy' ) ) {
	function afw808_add_default_taxonomy( $post_id ) {
		// Only add Mug Monday taxonomy to Mug Monday post types

		// Check if 'Mug Monday' category already exists
		$term = term_exists( 'Aloha Friday', 'category' );
		// Mug Monday category does not exist. Create it
		if ( 0 === $term || null === $term ) {
			wp_insert_term(
				'Aloha Friday', // the term
				'category', // the taxonomy
				array(
					'description' => 'A new Hawaiian word and definition every Friday.',
					'slug' => 'aloha-friday',
				)
	 		);
		}

		// An array of IDs of categories we to add to this post.
		$cat_ids = array( get_cat_ID( 'Aloha Friday' ) );
		$term_taxonomy_ids = wp_set_object_terms( $post_id, $cat_ids, 'category', true );

		if ( is_wp_error( $term_taxonomy_ids ) ) {
			// There was an error somewhere and the terms couldn't be set.
		} else {
		    // Success! These categories were added to the post.
		}
	}
}
add_action( 'save_post_afw808_aloha_friday', 'afw808_add_default_taxonomy' );


function afw808_default_category_featured_image() {
    global $post;
    $featured_image_exists = has_post_thumbnail( $post->ID );
                  
    if ( ! $featured_image_exists )  {
    	$attached_image = get_children( "post_parent=$post->ID&post_type=attachment&post_mime_type=image&numberposts=1" );
		if ( $attached_image ) {				
			foreach ( $attached_image as $attachment_id => $attachment ) {
				set_post_thumbnail( $post->ID, $attachment );
			}
		}
    	elseif ( in_category( '175' ) ) {
			set_post_thumbnail( $post->ID, '3105' );
			
    	}
    	wp_reset_postdata();
	}            
}
add_action( 'the_post', 'default_category_featured_image' );

// Create a function called "afw808_add_default_title" if it doesn't already exist
if ( ! function_exists( 'afw808_add_default_title' ) ) {
	/**
	 * Set the default title field text
	 *
	 * @return string
	*/
	function afw808_add_default_title( $data ) {
	    if ( 'afw808_aloha_friday' === $data['post_type'] ) {
	        if ( empty( $data['post_title'] ) ) {
				

			 /** Return the default title field text based on number of
			  * posts and post drafts in the database.
			  * Example format:  'Mug Monday #1 - Week of '
			  */
			  $mondayOfThisWeek1 = strtotime( 'last monday' );
			  $weekOfMonday1 = date( 'F j', $mondayOfThisWeek1 ) ;
			  $dayOfPost = date( 'j', strtotime( '+4 day', $mondayOfThisWeek1 ) );
			  $monthOfPost = date( 'm', strtotime( '+4 day', $mondayOfThisWeek1 ) );
			  $yearOfPost = date( 'Y', strtotime( '+4 day', $mondayOfThisWeek1 ) );
  
			  $afw808_default_title = 'Aloha Friday - Week of ' . $weekOfMonday1;
			  $afw808_post_id = post_exists( $afw808_default_title );

			  while ( $afw808_post_id ) {
				$mondayOfThisWeek1 = strtotime( '+7 day', $mondayOfThisWeek1 );
				$weekOfMonday1 = date( 'F j', $mondayOfThisWeek1 ) ;
				$afw808_default_title = 'Aloha Friday - Week of ' . $weekOfMonday1;

				$dayOfPost = date( 'j', strtotime( '+4 day', $mondayOfThisWeek1 ) );
				$monthOfPost = date( 'm', strtotime( '+4 day', $mondayOfThisWeek1 ) );
				$yearOfPost = date( 'Y', strtotime( '+4 day', $mondayOfThisWeek1 ) );
				$afw808_post_id = post_exists( $afw808_default_title );
			}
			
			  if ( get_page_by_title( $afw808_default_title, OBJECT, 'afw808_aloha_friday' ) != null ) {
				$afw808_default_title = 'Aloha Friday - Week of ' . $weekOfMonday1 . ' already exists';
				
			} else {
				$afw808_default_title = 'Aloha Friday - Week of ' . $weekOfMonday1;
			}

				$timeStamp = date( 'Y-m-d H:i:s', strtotime( "$yearOfPost-$monthOfPost-$dayOfPost 08:08:00" ) ); 
				// $timeStamp = date('Y-m-d H:i:s', strtotime('2019-01-02 08:08:00')); // format needed for WordPress

				$data['post_status'] = 'future'; 
				$data['post_date'] = $timeStamp ;
				$data['post_date_gmt'] = get_gmt_from_date ( $timeStamp ) ;
				$data['post_title'] = $afw808_default_title;
			}	
	    }
	    return $data;
	}
}
add_filter( 'wp_insert_post_data', 'afw808_add_default_title', 10, 1 );