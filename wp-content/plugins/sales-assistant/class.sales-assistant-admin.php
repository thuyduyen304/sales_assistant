<?php
class Sales_Assistant_Admin
{
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;
    const SALES_ASSISTANT__SETTING_SLUG = 'order-setting-admin';

    /**
     * Start up
     */
    public function __construct()
    {
        add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
        add_action( 'admin_init', array( $this, 'page_init' ) );
        add_filter( 'plugin_action_links_'.plugin_basename( plugin_dir_path( __FILE__ ) . 'sales-assistant.php'), array('Sales_Assistant_Admin','add_action_links'));
    }

    /**
     * Add options page
     */
    public function add_plugin_page()
    {
        // This page will be under "Settings"
        add_options_page(
            'Sales Assistant Admin',
            'Sales Assistant Settings',
            'manage_options',
            self::SALES_ASSISTANT__SETTING_SLUG,
            array( $this, 'create_admin_page' )
        );
    }

    /**
     * Options page callback
     */
    public function create_admin_page()
    {
        // Set class property
        $this->options = get_option( 'sales_assistant_option' );
        ?>
        <div class="wrap">
            <h1>Sells Assistant Settings</h1>
            <form method="post" action="options.php">
                <?php
                // This prints out all hidden setting fields
                settings_fields( 'sales_assistant_option_group' );
                do_settings_sections( self::SALES_ASSISTANT__SETTING_SLUG );
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
            'sales_assistant_option_group', // Option group
            'sales_assistant_option', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );

        add_settings_section(
            'setting_section_id', // ID
            'Facebook App Settings', // Title
            array( $this, 'print_section_info' ), // Callback
            self::SALES_ASSISTANT__SETTING_SLUG // Page
        );

        add_settings_field(
            'app_id', // ID
            'App ID', // Title
            array( $this, 'app_id_callback' ), // Callback
            self::SALES_ASSISTANT__SETTING_SLUG , // Page
            'setting_section_id' // Section
        );

        add_settings_field(
            'app_secret',
            'App Secret',
            array( $this, 'app_secret_callback' ),
            self::SALES_ASSISTANT__SETTING_SLUG,
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
            '<input type="text" id="app_id" name="sales_assistant_option[app_id]" value="%s" />',
            isset( $this->options['app_id'] ) ? esc_attr( $this->options['app_id']) : ''
        );
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function app_secret_callback()
    {
        printf(
            '<input type="text" id="app_secret" name="sales_assistant_option[app_secret]" value="%s" />',
            isset( $this->options['app_secret'] ) ? esc_attr( $this->options['app_secret']) : ''
        );
    }

    /**
     * @param $links
     * @param $file
     * @return array
     */
    public static function add_action_links( $links ) {
        $links[] = '<a href="'. esc_url( get_admin_url(null, 'options-general.php?page=' . self::SALES_ASSISTANT__SETTING_SLUG) ) .'">Settings</a>';

        return $links;
    }
}