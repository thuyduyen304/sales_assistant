<?php
/*
Plugin Name: Test Plugin
Plugin URI: /order-page
Description: a plugin to create awesomeness and spread joy
Version: 1.2
Author: dtruong
Author URI: http://mrtotallyawesome.com
License: GPL2
*/

define( 'TEST__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

require_once( TEST__PLUGIN_DIR . 'class.pagetemplater.php' );
require_once( TEST__PLUGIN_DIR . 'admin-order-page.php' );
//require_once( TEST__PLUGIN_DIR . 'order-page.php' );


if( is_admin() ) {
   // $my_settings_page = new MySettingsPage();
   // add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'add_action_links',10,1 );

}
add_action( 'plugins_loaded', 'create_new_template');

//create page if any
$order_page_title = 'Order Page';
$order_page_check = get_page_by_title($order_page_title);
$template_file_name = 'page-order-page.php';
$order_page = array(
    'post_type' => 'page',
    'post_title' => $order_page_title,
    'post_status' => 'publish',
    'post_author' => 1,
    'post_slug' => 'order-page',
    'comment_status' => 'closed'
);
if(!isset($order_page_check->ID) && !the_slug_exists('order-page')){
    $order_page_id = wp_insert_post($order_page);
} else $order_page_id=$order_page_check->ID;

//attach the template to page
//update_post_meta($order_page_id, '_wp_page_template', $template_file_name);

/*
function order_admin_actions() {
    add_options_page("OSCommerce Product Display", "OSCommerce Product Display", 1, "OSCommerce Product Display", "order_admin");
}

add_action('admin_menu', 'order_admin_actions');

/**
 * setup a function to check if these pages exist
 * @param $post_name
 * @return bool
 */
function the_slug_exists($post_name) {
    global $wpdb;
    if($wpdb->get_row("SELECT post_name FROM wp_posts WHERE post_name = '" . $post_name . "'", 'ARRAY_A')) {
        return true;
    } else {
        return false;
    }
}

/**
 * Create new template for order page
 */
function create_new_template() {
    $template_file_name = 'page-order-page.php';
    PageTemplater::get_instance(array(
        $template_file_name => 'Order Page Template',
    ));
}

