<?php
/*
Plugin Name:       Aloha Friday Words
Description:       Easily share a weekly Hawaiian word and its definition.
Plugin URI:        https://geoffreyshilling.com/aloha-friday-words/
Contributors:      geoffreyshilling
Author:            Geoffrey Shilling
Author URI:        https://geoffreyshilling.com/aloha-friday-words/
Donate link:       https://paypal.me/geoffreyshilling
Version:           0.1.0
Stable tag:        0.1.0
Requires at least: 4.5
Tested up to:      4.9.9
Text Domain:       aloha-friday-words
Domain Path:       /languages
License:           GPL v2 or later
License URI:       https://www.gnu.org/licenses/gpl-2.0.txt

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 
2 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
with this program. If not, visit: https://www.gnu.org/licenses/
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Plugin Constants
// Plugin version.
if ( ! defined( 'AFW808_VERSION' ) ) {
	define( 'AFW808_VERSION', '0.1.0' );
}

// Plugin directory.
if ( ! defined( 'AFW808_PLUGIN_DIR' ) ) {
    define( 'AFW808_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
}

if ( is_admin() ) {
	require_once AFW808_PLUGIN_DIR . 'includes/aloha-friday-activation.php';
}
// Include dependencies
require_once AFW808_PLUGIN_DIR . 'includes/post-types.php';
require_once AFW808_PLUGIN_DIR . 'admin/aloha-friday-cpt-defaults.php';
require_once AFW808_PLUGIN_DIR . 'public/aloha-friday-cpt-display.php';
require_once ABSPATH . '/wp-admin/includes/post.php';


/**
 * Proper way to enqueue scripts and styles
 */

function afw808_add_styles_and_scripts() {
wp_enqueue_style('whatever', plugins_url('admin/css/styles.css', __FILE__) );
	}
	add_action( 'admin_enqueue_scripts', 'afw808_add_styles_and_scripts' ); 

/**
 * @internal never define functions inside callbacks.
 * these functions could be run multiple times; this would result in a fatal error.
 */
 
/**
 * custom option and settings
 */
function wporg_settings_init() {
 // register a new setting for "wporg" page
 register_setting( 'wporg', 'wporg_options' );
 
 // register a new section in the "wporg" page
 add_settings_section(
 'wporg_section_developers',
 __( 'The Matrix has you.', 'wporg' ),
 'wporg_section_developers_cb',
 'wporg'
 );
 
 // register a new field in the "wporg_section_developers" section, inside the "wporg" page
 add_settings_field(
	'wporg_field_pill', // as of WP 4.6 this value is used only internally
	// use $args' label_for to populate the id inside the callback
	__( 'Pill', 'wporg' ),
	'wporg_field_pill_cb',
	'wporg',
	'wporg_section_developers',
	[
	'label_for' => 'wporg_field_pill',
	'class' => 'wporg_row',
	'wporg_custom_data' => 'custom',
	]
);


add_settings_field(
	'wporg_field_pill_test', // as of WP 4.6 this value is used only internally
	// use $args' label_for to populate the id inside the callback
	__( 'Default Picture', 'wporg' ),
	'wporg_field_pill_test_cb',
	'wporg',
	'wporg_section_developers',
	[
	'label_for1' => 'wporg_field_pill_test',
	'class' => 'wporg_row1',
	'wporg_custom_data' => 'custom1',
	]
);
}
 
/**
 * register our wporg_settings_init to the admin_init action hook
 */
add_action( 'admin_init', 'wporg_settings_init' );
 
/**
 * custom option and settings:
 * callback functions
 */
 
// developers section cb
 
// section callbacks can accept an $args parameter, which is an array.
// $args have the following keys defined: title, id, callback.
// the values are defined at the add_settings_section() function.
function wporg_section_developers_cb( $args ) {
 ?>
 <p id="<?php echo esc_attr( $args['id'] ); ?>"><?php esc_html_e( 'Follow the white rabbit.', 'wporg' ); ?></p>
 <?php
}
 
// pill field cb
 
// field callbacks can accept an $args parameter, which is an array.
// $args is defined at the add_settings_field() function.
// wordpress has magic interaction with the following keys: label_for, class.
// the "label_for" key value is used for the "for" attribute of the <label>.
// the "class" key value is used for the "class" attribute of the <tr> containing the field.
// you can add custom key value pairs to be used inside your callbacks.
function wporg_field_pill_cb( $args ) {
 // get the value of the setting we've registered with register_setting()
 $options = get_option( 'wporg_options' );
 // output the field
 ?>
 <select id="<?php echo esc_attr( $args['label_for'] ); ?>"
 data-custom="<?php echo esc_attr( $args['wporg_custom_data'] ); ?>"
 name="wporg_options[<?php echo esc_attr( $args['label_for'] ); ?>]"
 >
 <option value="red" <?php echo isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ $args['label_for'] ], 'red', false ) ) : ( '' ); ?>>
 <?php esc_html_e( 'red pill', 'wporg' ); ?>
 </option>
 <option value="blue" <?php echo isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ $args['label_for'] ], 'blue', false ) ) : ( '' ); ?>>
 <?php esc_html_e( 'blue pill', 'wporg' ); ?>
 </option>
 </select>
 <p class="description">
 <?php esc_html_e( 'You take the blue pill and the story ends. You wake in your bed and you believe whatever you want to believe.', 'wporg' ); ?>
 </p>
 <p class="description">
 <?php esc_html_e( 'You take the red pill and you stay in Wonderland and I show you how deep the rabbit-hole goes.', 'wporg' ); ?>
 </p>

 <?php
}


function wporg_field_pill_test_cb( $args ) {

   
	// get the value of the setting we've registered with register_setting()
	$options = get_option( 'wporg_options' );

	echo 'Current settings are:<br>';
	foreach ( $options as $option ) {
		echo $option;
	}
	echo '<br><br>';
	// output the field
	?>
	
	
	<input id="<?php echo esc_attr( $args['label_for1'] ); ?>" type="text" name="background_image1" value="<?php echo isset( $options[ $args['label_for1'] ] ) ? ( selected( $options[ $args['label_for1'] ], 'test', false ) ) : ( '' ); ?>" />
   <input id="upload_image_button" type="button" class="button-primary" value="Insert Image" />
   
	<?php
   }
 
/**
 * top level menu
 */
function wporg_options_page() {
 // add top level menu page
 add_menu_page(
 'WPOrg',
 'WPOrg Options',
 'manage_options',
 'wporg',
 'wporg_options_page_html'
 );
}
 
/**
 * register our wporg_options_page to the admin_menu action hook
 */
add_action( 'admin_menu', 'wporg_options_page' );
 
/**
 * top level menu:
 * callback functions
 */
function wporg_options_page_html() {
 // check user capabilities
 if ( ! current_user_can( 'manage_options' ) ) {
 return;
 }
 
 // add error/update messages
 
 // check if the user have submitted the settings
 // wordpress will add the "settings-updated" $_GET parameter to the url
 if ( isset( $_GET['settings-updated'] ) ) {
 // add settings saved message with the class of "updated"
 add_settings_error( 'wporg_messages', 'wporg_message', __( 'Settings Saved', 'wporg' ), 'updated' );
 }
 
 // show error/update messages
 settings_errors( 'wporg_messages' );
 ?>
 <div class="wrap">
 <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
 <form action="options.php" method="post">
 <?php
 // output security fields for the registered setting "wporg"
 settings_fields( 'wporg' );
 // output setting sections and their fields
 // (sections are registered for "wporg", each field is registered to a specific section)
 do_settings_sections( 'wporg' );
 // output save settings button
 submit_button( 'Save Settings' );
 ?>
 </form>
 </div>
 <?php
}






function media_uploader_enqueue() {
	wp_enqueue_media();
	wp_register_script('media-uploader', plugins_url('media-uploader.js' , __FILE__ ), array('jquery'));
	wp_enqueue_script('media-uploader');
}
add_action('admin_enqueue_scripts', 'media_uploader_enqueue');

























class MySettingsPage
{
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;

    /**
     * Start up
     */
    public function __construct()
    {
        add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
        add_action( 'admin_init', array( $this, 'page_init' ) );
    }

    /**
     * Add options page
     */
    public function add_plugin_page()
    {
        // This page will be under "Settings"
        add_options_page(
            'Settings Admin', 
            'My Settings', 
            'manage_options', 
            'my-setting-admin', 
            array( $this, 'create_admin_page' )
        );
    }

    /**
     * Options page callback
     */
    public function create_admin_page()
    {
		$defaults = array( 
			'id_number' => 'Aloha Friday - Week of '
		);
        // Set class property
        //$this->options = get_option( 'my_option_name' );
        $this->options = wp_parse_args(get_option( 'my_option_name' ), $defaults);
        ?>
        <div class="wrap">
            <h1>My Settings</h1>
            <form method="post" action="options.php">
            <?php
                // This prints out all hidden setting fields
                settings_fields( 'my_option_group' );
                do_settings_sections( 'my-setting-admin' );
                submit_button();
            ?>
            </form>
        </div>
        <?php
    }

    /**
     * Register and add settings
     */
    public function page_init()
    {        
        register_setting(
            'my_option_group', // Option group
            'my_option_name', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );

        add_settings_section(
            'setting_section_id', // ID
            'My Custom Settings', // Title
            array( $this, 'print_section_info' ), // Callback
            'my-setting-admin' // Page
        );  

        add_settings_field(
            'id_number', // ID
            'ID Number', // Title 
            array( $this, 'id_number_callback' ), // Callback
            'my-setting-admin', // Page
            'setting_section_id' // Section           
        );      

        add_settings_field(
            'title', 
            'Title', 
            array( $this, 'title_callback' ), 
            'my-setting-admin', 
            'setting_section_id'
        );      
    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize( $input )
    {
        $new_input = array();
        if( isset( $input['id_number'] ) )
            $new_input['id_number'] = sanitize_text_field( $input['id_number'] );

        if( isset( $input['title'] ) )
            $new_input['title'] = sanitize_text_field( $input['title'] );

        return $new_input;
    }

    /** 
     * Print the Section text
     */
    public function print_section_info()
    {
        print 'Enter your settings below:';
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function id_number_callback()
    {
		$testoption = $this->options['id_number'];
		$testoption = str_replace('[todays_date]', 'todays date replaced', $testoption);
        printf(
            '<input size=55 type="text" id="id_number" name="my_option_name[id_number]" value="%s">',
			isset( $this->options['id_number'] ) ? esc_attr( $this->options['id_number']) : '808'
		);
		printf(
			'<br>Valid substitutions will be
			<br>[todays_date]
			<br>[current_day]
			<br>[current_month]
			<br>[current_year]'
		);
		printf(
            $testoption
		);
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function title_callback()
    {
        printf(
            '<input type="text" id="title" name="my_option_name[title]" value="%s" />',
            isset( $this->options['title'] ) ? esc_attr( $this->options['title']) : ''
		);
		?> 
		 <input id="upload_image_button" type="button" class="button-primary" value="Set Image" />
		 <br><img id="default-image" src="<?php printf(esc_attr( $this->options['title']));?>" class="aloha-friday-default-image-preview">
		 <br>
		 <?php 

	$values = get_option( 'my_option_name' ); 
	foreach ( $values as $value ) {

		echo $value;
	}
    }
}

if( is_admin() )
	$my_settings_page = new MySettingsPage();
	

