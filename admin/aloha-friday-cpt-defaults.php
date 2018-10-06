<?php
/**
 * Aloha Friday Custom Post Type Defaults
 *
 * @copyright   Copyright (c) 2018, Geoffrey Shilling
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// Change placeholder text for  post titles
function my_title_placeholders( $placeholder ){
    $screen = get_current_screen();
	switch ( $screen->post_type ) {
        case 'ord808_aloha_friday':
        $mondayOfThisWeek = strtotime('last monday');
			$weekOfMonday = date( 'F j', $mondayOfThisWeek ) ;

			$my_title = 'Aloha Friday - Week of ' . $weekOfMonday;

			$post_id = post_exists( $my_title );
			while ( $post_id ) {
				$mondayOfThisWeek = strtotime("+7 day", $mondayOfThisWeek);
				$weekOfMonday = date( 'F j', $mondayOfThisWeek ) ;
				$my_title = 'Aloha Friday - Week of ' . $weekOfMonday;

				$post_id = post_exists( $my_title );
			}

			$placeholder = __( 'Aloha Friday - Week of ', 'aloha-friday-words' ) . $weekOfMonday;
			//return __( 'Aloha Friday - Week of ', 'aloha-friday-words' ) . $weekOfMonday;
			//$placeholder = __( 'Enter building name and number' );
			break;
		default: break;
		
	}
    return $placeholder;
}
add_filter( 'enter_title_here', 'my_title_placeholders' );

// Create a function called "ord808af_add_default_taxonomy" if it doesn't already exist
if ( ! function_exists( 'ord808af_add_default_taxonomy' ) ) {
	function ord808af_add_default_taxonomy( $post_id ) {
		// Only add Mug Monday taxonomy to Mug Monday post types

		// Check if 'Mug Monday' category already exists
		$term = term_exists( 'Aloha Friday', 'category' );
		// Mug Monday category does not exist. Create it
		if ( $term === 0 || $term === null ) {
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

add_action( 'save_post_ord808_aloha_friday', 'ord808af_add_default_taxonomy' );


function default_category_featured_image() {
    global $post;
    $featured_image_exists = has_post_thumbnail($post->ID);
                  
    if (!$featured_image_exists)  {
    $attached_image = get_children( "post_parent=$post->ID&post_type=attachment&post_mime_type=image&numberposts=1" );
    
    if ($attached_image) {
                              
    foreach ($attached_image as $attachment_id => $attachment) {
    set_post_thumbnail($post->ID, $attachment);
    }}
    else if ( in_category('175') ) {
    set_post_thumbnail($post->ID, '3105');
    }
    wp_reset_postdata();
                                   }
                                   
                               }
                            
          
    add_action('the_post', 'default_category_featured_image');

// Create a function called "ord808af_add_default_title" if it doesn't already exist
if ( ! function_exists( 'ord808af_add_default_title' ) ) {
	/**
	 * Set the default title field text
	 *
	 * @return string
	*/
	function ord808af_add_default_title( $data ) {
	    if( 'ord808_aloha_friday' === $data['post_type'] ) {
	        if( empty( $data['post_title'] ) ) {
				

			 /** Return the default title field text based on number of
			  * posts and post drafts in the database.
			  * Example format:  'Mug Monday #1 - Week of '
			  */
			  $mondayOfThisWeek1 = strtotime('last monday');
			  $weekOfMonday1 = date( 'F j', $mondayOfThisWeek1 ) ;
  
			  $my_title1 = 'Aloha Friday - Week of ' . $weekOfMonday1;
			  $post_id1 = post_exists( $my_title1 );

			  while ( $post_id1 ) {
				$mondayOfThisWeek1 = strtotime("+7 day", $mondayOfThisWeek1);
				$weekOfMonday1 = date( 'F j', $mondayOfThisWeek1 ) ;
				$my_title1 = 'Aloha Friday - Week of ' . $weekOfMonday1;

				$post_id1 = post_exists( $my_title1 );
			}
			
			  if (get_page_by_title($my_title1, OBJECT, 'ord808_aloha_friday') != null ) {
				$my_title1 = 'Aloha Friday - Week of ' . $weekOfMonday1 . " already exists";
				
			} else {
				$my_title1 = 'Aloha Friday - Week of ' . $weekOfMonday1;
			}
 			  // 
			//	if (get_page_by_title('Aloha Friday - Week of October 8', OBJECT, 'ord808_aloha_friday') != null ) {
			//		$my_title1 = "Aloha Friday - Week of October 8 Already Exists" . get_page_by_title('Aloha Friday - Week of October 8');
			//		
			//	} else {
			//		$my_title1 = "Doesnt exists. return value is: " . get_page_by_title('Aloha Friday - Week of October 8');
			//	}
			  
			 
			  //$placeholder = __( 'Aloha Friday - Week of ', 'aloha-friday-words' ) . $weekOfMonday;

			  //$data['post_title'] = __( 'Aloha Friday - Week of ', 'aloha-friday-words' ) . $weekOfMonday1;
			  $data['post_title'] = $my_title1;
	        }


	    }
	    return $data;
	}
}
add_filter( 'wp_insert_post_data', 'ord808af_add_default_title', 10, 1 );


