<?php

/*
  Plugin Name: Points And Ponits
  Description: Give points to Woo commerce Users and Level
  Version: 1.0
  Author: Steve M Prince
  Author URI: https://www.facebook.com/steven.mbaalu
  Plugin URI: https://www.facebook.com/steven.mbaalu
 */

include_once( 'includes/settings.php' );
include_once( 'includes/ApConstants.php' );
//3288


add_action( 'woocommerce_payment_complete', 'points_payment_complete' );
function points_payment_complete( $order_id ){
   // echo "Giving Poinst >>> ";
    $order = wc_get_order( $order_id );
    // $order = wc_get_order( $order_id );
   // error_log( "Order complete for order $order_id", 0 );
   /// error_log( $order, 0 );
    //give him points and referrer and credits As well
    $user = $order->get_user();
    $point_got=get_option( 'points_settings_tab_downline_points', true );
    $price=$order->get_total();
    $credit_got=(get_option( 'points_settings_tab_downline_credits', true )/100)*$price;
  
    
    if( $user ){
        $user_id=$user->ID;
        // do something with the user

       // $order_id=3288;
       // $order = wc_get_order( $order_id );
        //print_r($order);
      //  $billing_address = $order->get_billing_address();
       /// print_r($billing_address);
       // $user = $order->get_user();
       // print_r($user->ID);
       //$order_data = $order->get_data();
      // print_r(get_user_meta( $user->ID, 'shipping_first_name', true ));
      // print_r(get_user_meta( $user->ID, 'billing_referrer', true ));

      // Set Points and Credits   
      //Set update_user_meta( $user_id, $meta_key, $meta_value, $prev_value );
      //Cost print_r($order->get_total());

      //Get Old User Points 
      $user_points = get_user_meta( $user_id, ApConstants::$USER_POINTS, true); 
     // echo "DOWNL USer had ".$user_points." Points ###";
      if($user_points){
            $tol=$user_points+$point_got;
            update_user_meta( $user_id, ApConstants::$USER_POINTS,$tol);
           // echo "DOWN Update Adding Poooins ".$user_points." Points ###";
        }else{
            update_user_meta( $user_id,ApConstants::$USER_POINTS, $point_got);
          //  echo "DOWN Adding Adding Poooins ".$user_points." Points ###";
        }

      $user_credits = get_user_meta( $user_id,  ApConstants::$USER_CREDIT, true); 
      if($user_credits){
            $tol=$user_credits+$credit_got;
            update_user_meta( $user_id, ApConstants::$USER_CREDIT,$tol);
        }else{
             update_user_meta( $user_id,ApConstants::$USER_CREDIT, $credit_got);
        }
        //Now for the franchise
        $refferer=get_user_meta( $user->ID, 'billing_referrer', true );

        //echo "FRN  ID ".$refferer." ,, ###";
        if($refferer){
            $user_franch = get_user_by('login',$refferer);

            if($user_franch)
            {
               $user_id_franch=$user_franch->ID;
             //  echo "FRN  ID ".$user_id_franch." ,, ###";
               $point_got=get_option( 'points_settings_tab_downline_points', true );
               $credit_got=(get_option( 'points_settings_tab_franchisees_credits', true )/100)*$price;

               $user_points = get_user_meta( $user_id_franch, ApConstants::$USER_POINTS, true); 
                if($user_points){
                        $tol=$user_points+$point_got;
                        update_user_meta( $user_id_franch, ApConstants::$USER_POINTS,$tol);
                    }else{
                        update_user_meta( $user_id_franch,ApConstants::$USER_POINTS, $point_got);
                    }

                    $user_credits = get_user_meta( $user_id_franch,  ApConstants::$USER_CREDIT, true); 
                    if($user_credits){
                            $tol=$user_credits+$credit_got;
                            update_user_meta( $user_id_franch, ApConstants::$USER_CREDIT,$tol);
                        }else{
                            update_user_meta( $user_id_franch,ApConstants::$USER_CREDIT, $credit_got);
                        }


            }
        }

    }
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
