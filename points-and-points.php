<?php

/*
  Plugin Name: Points And Ponits
  Description: Give points to Woo commerce Users and Level
  Version: 1.0
  Author: Stephen Mbaalu
  Author URI: http://authorsite.com/
  Plugin URI: http://authorsite.com/points-and-points
 */

include_once( 'includes/settings.php' );

add_action( 'woocommerce_payment_complete', 'points_payment_complete' );
function points_payment_complete( $order_id ){
    $order = wc_get_order( $order_id );
    error_log( "Order complete for order $order_id", 0 );
    error_log( $order, 0 );
    //give him points and referrer and credits As well
    $user = $order->get_user();
    error_log( $user, 0 );
    if( $user ){
        // do something with the user
    }


    /*
       $billingEmail = $order->billing_email;
  $products = $order->get_items();

foreach($products as $prod){
  $items[$prod['product_id']] = $prod['name'];
}

$url = 'http://requestb.in/15gbo981';
// post to the request somehow
wp_remote_post( $url, array(
 'method' => 'POST',
 'timeout' => 45,
 'redirection' => 5,
 'httpversion' => '1.0',
 'blocking' => true,
 'headers' => array(),
 'body' => array( 'billingemail' => $billingEmail, 'items' => $items ),
 'cookies' => array()
 )
);
     */

}





//Add custom fields to billing fields 

/*add_filter( 'woocommerce_billing_fields' , 'points_custom_checkout_fields',5 );

// Our hooked in function - $fields is passed via the filter!
function points_custom_checkout_fields( $fields ) {

    if (!is_user_logged_in()){
    $fields['billing_options']= array(
        'label' => __('Referrer', 'points'), // Add custom field label
        'placeholder' => _x('Referer code', 'placeholder', 'points'), // Add custom field placeholder
        'required' => true, // if field is required or not
        'clear' => false, // add clear or not
        'type' => 'text' // add field type
        //'class' => array('my-css')    // add class name
    );
}
    return $fields;
}*/


// Hook in
add_filter( 'woocommerce_checkout_fields' , 'points_custom_override_checkout_fields' );

// Our hooked in function - $fields is passed via the filter!
function points_custom_override_checkout_fields( $fields ) {

if (!is_user_logged_in()){
     $fields['billing']['billing_referrer'] = array(
        'label'     => __('Referrer', 'points'),
    'placeholder'   => _x('Referrer code', 'placeholder', 'points'),
    'required'  => true,
    'class'     => array('form-row-wide'),
    'clear'     => false
     );

     return $fields;
    }
}

/**
 * Display field value on the order edit page
 */

 
add_action( 'woocommerce_admin_order_data_after_shipping_address', 'points_my_custom_checkout_field_display_admin_order_meta', 10, 1 );

function points_my_custom_checkout_field_display_admin_order_meta($order){
    echo '<p><strong>'.__('Referrer','points').':</strong> ' . get_post_meta( $order->get_id(), '_billing_referrer', true ) . '</p>';
}

/**
 * Register core post types.
 */

/*function register_msarcade_shops() {
    if (post_type_exists('msshop')) {
        return;
    }

    $labels = array(
        'name' => __('Shops', 'msarcades'),
        'singular_name' => __('Shop', 'msarcades'),
        'menu_name' => _x('Shops', 'Admin menu name', 'msarcades'),
        'add_new' => __('Add Shop', 'msarcades'),
        'add_new_item' => __('Add New Shop', 'msarcades'),
        'edit' => __('Edit', 'msarcades'),
        'edit_item' => __('Edit Product', 'msarcades'),
        'new_item' => __('New Shop', 'msarcades'),
        'view' => __('View Shop', 'msarcades'),
        'view_item' => __('View Shop', 'msarcades'),
        'search_items' => __('Search Shops', 'msarcades'),
        'not_found' => __('No Shops found', 'msarcades'),
        'not_found_in_trash' => __('No Shops found in trash', 'msarcades'),
        'parent' => __('Parent Shop', 'msarcades'),
        'featured_image' => __('Shop Image', 'msarcades'),
        'set_featured_image' => __('Set Shop image', 'msarcades'),
        'remove_featured_image' => __('Remove Shop image', 'msarcades'),
        'use_featured_image' => __('Use as Shop image', 'msarcades'),
        'insert_into_item' => __('Insert into Shop', 'msarcades'),
        'uploaded_to_this_item' => __('Uploaded to this Shop', 'msarcades'),
        'filter_items_list' => __('Filter Shops', 'msarcades'),
        'items_list_navigation' => __('Shops navigation', 'msarcades'),
        'items_list' => __('Shops list', 'msarcades'),
    );

    $args = array(
        'labels' => $labels,
        'hierarchical' => true,
        'description' => 'Shops in a business',
        'supports' => array('title', 'editor', 'author', 'thumbnail', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'page-attributes'),
        'taxonomies' => array('genres'),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        //'menu_icon' => 'dashicons-format-audio',
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'post'
    );

    register_post_type('business_shop', $args);
}

add_action('init', 'register_msarcade_shops');

function arcades_taxonomy() {

    register_taxonomy(
            'arcades', 'business_shop', array(
        'hierarchical' => true,
        'label' => 'Arcades',
        'query_var' => true,
        'rewrite' => array(
            'slug' => 'arcade',
            'with_front' => false
        )
            )
    );
}

add_action('init', 'arcades_taxonomy');

include_once( 'includes/ShopWidget.php' );*/
