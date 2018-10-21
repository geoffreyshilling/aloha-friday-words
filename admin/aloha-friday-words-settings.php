<?php
class Aloha_Friday_Words_Settings_Page
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
            'Aloha Friday Words Settings', 
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
        // Set class property
        $this->options = get_option( 'my_option_name' );
        ?>
        <div class="wrap">
            <h1>Aloha Friday Words Settings</h1>
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
            '', // Title
            array( $this, 'print_section_info' ), // Callback
            'my-setting-admin' // Page
        );  

        /*
        add_settings_field(
            'default_title', // ID
            'Default Title', // Title 
            array( $this, 'default_title_callback' ), // Callback
            'my-setting-admin', // Page
            'setting_section_id' // Section           
        );
        */  

        add_settings_field(
            'default_featured_image', 
            'Default Featured Image', 
            array( $this, 'default_featured_image_callback' ), 
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
        /*
        if( isset( $input['default_title'] ) )
            $new_input['default_title'] = sanitize_text_field( $input['default_title'] );
        */
            if( isset( $input['default_featured_image'] ) )
                $new_input['default_featured_image'] = sanitize_text_field( $input['default_featured_image'] );

        return $new_input;
    }

    /** 
     * Print the Section text
     */
    public function print_section_info()
    {
        print 'Set default settings for Aloha Friday Words posts:';
    }

    /** 
     * Get the settings option array and print one of its values
     */
    /*
    public function default_title_callback()
    {
        printf(
            '<input type="text" id="default_title" name="my_option_name[default_title]" value="%s" />',
            isset( $this->options['default_title'] ) ? esc_attr( $this->options['default_title']) : ''
        );

        if( isset( $this->options['default_title'] ) ) {
            printf( "<br>Current Setting: " .  $this->options['default_title'] );
        }
    }
    */

    /** 
     * Get the settings option array and print one of its values
     */
    public function default_featured_image_callback()
    {
        
        if( isset( $this->options['default_featured_image'] ) ) {
            
        printf( '<div id="image-preview"><img src="' .  $this->options['default_featured_image'] . '" width="400px">' . '</div>');
        //printf( plugin_dir_url( __FILE__ ) . 'admin/js/media-uploader.js' );
        global $wpdb;
        $image_url = $this->options['default_featured_image'];
        $attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $image_url ));

    }
        
    printf(
        '<input size="43" type="text" id="default_featured_image" name="my_option_name[default_featured_image]" value="%s" />',
        isset( $this->options['default_featured_image'] ) ? esc_attr( $this->options['default_featured_image']) : ''
    );

    printf(
        '<br><input id="upload_image_button" type="button" class="button-primary" value="Set Default Image" />'
    );


        
    }

}

if( is_admin() )
    $my_settings_page = new Aloha_Friday_Words_Settings_Page();
