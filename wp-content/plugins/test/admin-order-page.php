<?php
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
            'Order Settings Admin',
            'Order Page Settings',
            'manage_options',
            'order-setting-admin',
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
            <h1>My Settings</h1>
            <form method="post" action="options.php">
                <?php
                // This prints out all hidden setting fields
                settings_fields( 'order_option_group' );
                do_settings_sections( 'order-setting-admin' );
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
            'order_option_group', // Option group
            'my_option_name', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );

        add_settings_section(
            'setting_section_id', // ID
            'Facebook App Settings', // Title
            array( $this, 'print_section_info' ), // Callback
            'order-setting-admin' // Page
        );

        add_settings_field(
            'app_id', // ID
            'App ID', // Title
            array( $this, 'app_id_callback' ), // Callback
            'order-setting-admin', // Page
            'setting_section_id' // Section
        );

        add_settings_field(
            'app_secret',
            'App Secret',
            array( $this, 'app_secret_callback' ),
            'order-setting-admin',
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
        if( isset( $input['app_id'] ) )
            $new_input['app_id'] = sanitize_text_field( $input['app_id'] );

        if( isset( $input['app_secret'] ) )
            $new_input['app_secret'] = sanitize_text_field( $input['app_secret'] );

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
    public function app_id_callback()
    {
        printf(
            '<input type="text" id="app_id" name="my_option_name[app_id]" value="%s" />',
            isset( $this->options['app_id'] ) ? esc_attr( $this->options['app_id']) : ''
        );
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function app_secret_callback()
    {
        printf(
            '<input type="text" id="app_secret" name="my_option_name[app_secret]" value="%s" />',
            isset( $this->options['app_secret'] ) ? esc_attr( $this->options['app_secret']) : ''
        );
    }
}