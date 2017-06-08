<?php

/**
 * top level menu
 */
function main_sales_assistant() {
    // add top level menu page
    add_menu_page(
        'Sales Assistant',
        'Sales Assistant',
        'manage_options',
        'sales_assistant_page',
        'render_sales_assistant_page'
    );
}

/**
 * register our wporg_options_page to the admin_menu action hook
 */
add_action( 'admin_menu', 'main_sales_assistant' );

/**
 * top level menu:
 * callback functions
 */
function render_sales_assistant_page() {
    // check user capabilities
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }
    //get the app id here
    $app_info = get_option('sales_assistant_option');
    if($app_info['app_id'] == '') return;
    //include the script
    wp_register_script('firebase-script','https://www.gstatic.com/firebasejs/4.1.1/firebase.js');
    wp_enqueue_script( 'firebase-script');
    wp_register_script( 'sales-assistant-script', plugins_url( '/js/custom-script.js', __FILE__ ) );
    wp_enqueue_script( 'sales-assistant-script', array('firebase-script') );
    wp_localize_script( 'sales-assistant-script', 'app_info', $app_info );
    ?>
    <div class="wrap">
        <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>

        <fb:login-button
            scope="email,manage_pages,public_profile,publish_actions,read_page_mailboxes,read_mailbox"
            >
        </fb:login-button>

    </div>
<?php //onlogin="checkLoginState();"
}

