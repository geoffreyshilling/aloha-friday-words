<?php
/**
 * Post Type Functions
 *
 * @copyright   Copyright (c) 2018, Geoffrey Shilling
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function afw808_register_aloha_friday_post_type() {
    $args = array(
        'public' => true,
        'title_placeholder' => 'Aloha Friday - Week of ',
        'label'  => 'Aloha Friday Words',
        'show_in_rest' => true,
        'supports'  => array( 'title', 'thumbnail', 'editor',  'post-formats'),
        'taxonomies'  => array( 'category' ),
        'has_archive' => true,
        'menu_icon' => 'dashicons-palmtree',
        'rewrite'     => array( 'slug' => 'aloha-friday' ), // my custom slug
        'template' => array(
            array( 'core/heading', array(
                'level' => '3',
                'content' => 'Hawaiian Word',
            ) ),
            array( 'core/paragraph', array(
                'placeholder' => 'Add Hawaiian Word...',
            ) ),
            array( 'core/heading', array(
                'level' => '3',
                'content' => 'English Translation',
            ) ),
            array( 'core/paragraph', array(
                'placeholder' => 'Add English Translation...',
            ) ),
            array( 'core/heading', array(
                'level' => '3',
                'content' => 'Example Sentance',
            ) ),
            array( 'core/paragraph', array(
                'placeholder' => 'Add Example Sentence...',
            ) ),
            array( 'core-embed/youtube', array(
                'url' => 'https://www.youtube.com/watch?v=aLxObV22gf8',
            ) ),
        ),
    );
    register_post_type( 'aloha_friday_words', $args );
}
add_action( 'init', 'afw808_register_aloha_friday_post_type' );