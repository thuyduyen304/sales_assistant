<?php
/*
Plugin Name: Sales Assistant
Description: a plugin to support sales on WooCommerce
Version: 1.0
Author: dtruong
*/

define( 'SALES_ASSISTANT__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );


require_once( SALES_ASSISTANT__PLUGIN_DIR . 'class.sales-assistant-admin.php' );
require_once( SALES_ASSISTANT__PLUGIN_DIR . 'sales-assistant-page.php' );


if( is_admin() ) {
    $settings_page = new Sales_Assistant_Admin();
}
