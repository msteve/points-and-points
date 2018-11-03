
<?php

class Points_Settings_Tab {
    public static function init() {
        add_filter( 'woocommerce_settings_tabs_array', __CLASS__ . '::add_settings_tab', 50 );
        add_action( 'woocommerce_settings_tabs_settings_tab_points', __CLASS__ . '::settings_tab' );
        add_action( 'woocommerce_update_options_settings_tab_points', __CLASS__ . '::update_settings' );

        add_filter( 'woocommerce_account_menu_items', __CLASS__ .'::points_account_menu_items', 10, 1 );
        add_action( 'init',  __CLASS__ .'::points_add_my_account_endpoint' );
        add_action( 'woocommerce_account_points_and_credits_endpoint', __CLASS__ .'::points_information_endpoint_content' );


       // points_payment_complete(3288);
    }


    public static function points_calculateUserLevel( $user_id="0") {
       

        //points_payment_complete(3288);

       // $order_id=3288;
       // $order = wc_get_order( $order_id );
        //print_r($order);
      //  $billing_address = $order->get_billing_address();
       /// print_r($billing_address);
       // $user = $order->get_user();
       // print_r($user->ID);
       //$order_data = $order->get_data();
      // print_r(get_user_meta( $user->ID, 'shipping_first_name', true ));
       //print_r(get_user_meta( $user->ID, 'billing_referrer', true ).'>>> ');
       //print_r($order->price);//$order->get_total();
      // print_r($order->get_total());
      // print_r($order->get_total());




       if($user_id=="0"){
            $user_id=get_current_user_id();
        }
        //get User Points
        $user_points = get_user_meta( $user_id, ApConstants::$USER_POINTS, true); 

        //get the level setting
        //echo 'Points >> '.$user_points;
        $levelPoints=[];
        $level="0";

        if( $user_points >0){
          // echo 'Points >> '.$user_points;
            for($i=10;$i>0;$i--){    //the
                $point=get_option( 'points_settings_tab_level'.$i.'_points', true );
                $levelPoints[]=$point;
                if($user_points>$point && $i==10){
                    $level=$i;
                   // echo 'Points >> '.$user_points.' Points for '.$i.' = '.$point;
                    break;
                }
                else if($user_points<=$point){
                    $level=$i;
                }
            }
        }

        return $level;

    }


/*  Account menu items
 *
 * @param arr $items
 * @return arr
 */
public static function points_account_menu_items( $items ) {
    $items2=[];
    $i=0;
    foreach($items as $key=>$value){
        if($i==1){
            $items2['points_and_credits'] = __( 'Points And Credits', 'points' );
        }else{
            $items2[$key]=$value;
            //print_r($key);
        }
        $i++;     
    }
    return $items2;
}
/** 
* Add endpoint
 */
public static function points_add_my_account_endpoint() {
    add_rewrite_endpoint( 'points_and_credits', EP_PAGES );
}
/**
 * Information content
 */
function points_information_endpoint_content() {
   // echo 'Your new content';
    //Show Full Points And Credits and Level

    //get User points Credits and Determine the Level
    $user_id=get_current_user_id();
    $user_points = get_user_meta( $user_id, ApConstants::$USER_POINTS, true); 
    $user_credits = get_user_meta( $user_id,  ApConstants::$USER_CREDIT, true); 
    //print_r("## USER CURRENT ".$user_id." ###");
    $level=Points_Settings_Tab::points_calculateUserLevel();

    $username=get_userdata( $user_id )->user_login;
   
    ?>
    <style>
                .top_tiles {
                    margin-bottom: 0;
                }
                .row {
                    margin-right: -10px;
                    margin-left: -10px;
                }
                .tile-stats {
                    position: relative;
                    display: block;
                    margin-bottom: 12px;
                    border: 1px solid #E4E4E4;
                    -webkit-border-radius: 5px;
                    overflow: hidden;
                    padding-bottom: 5px;
                    -webkit-background-clip: padding-box;
                    -moz-border-radius: 5px;
                    -moz-background-clip: padding;
                    border-radius: 5px;
                    background-clip: padding-box;
                    background: #FFF;
                    transition: all 300ms ease-in-out;
                }
                .tile-stats .icon {
                    width: 20px;
                    height: 20px;
                    color: #BAB8B8;
                    position: absolute;
                    right: 53px;
                    top: 22px;
                    z-index: 1;
                }
                .tile-stats .count, .tile-stats h3, .tile-stats p {
                    position: relative;
                    margin: 0;
                    margin-left: 10px;
                    z-index: 5;
                    padding: 0;
                }
                .tile-stats .count {
                    font-size: 38px;
                    font-weight: bold;
                    line-height: 1.65857;
                }
                .tile-stats h3 {
                    color: #BAB8B8;
                }
                .tile-stats .count, .tile-stats h3, .tile-stats p {
                    position: relative;
                    margin: 0;
                    margin-left: 10px;
                    z-index: 5;
                    padding: 0;
                }
                .tile-stats p {
                    margin-top: 5px;
                    font-size: 12px;
                }
                .tile-stats .count, .tile-stats h3, .tile-stats p {
                    position: relative;
                    margin: 0;
                    margin-left: 10px;
                    z-index: 5;
                    padding: 0;
                }
                .tile-stats .icon i {
                    margin: 0;
                    font-size: 60px;
                    line-height: 0;
                    vertical-align: bottom;
                    padding: 0;
                }

                .fa {
                    display: inline-block;
                    font: normal normal normal 14px/1 FontAwesome;
                    font-size: inherit;
                    text-rendering: auto;
                    -webkit-font-smoothing: antialiased;
                    -moz-osx-font-smoothing: grayscale;
                }
                    
    </style>
  
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css" integrity="sha384-/rXc/GQVaYpyDdyxK+ecHPVYJSN9bmVFBvjA/9eOB+pb3F2w2N6fc5qB9Ew5yIns" crossorigin="anonymous">

    <div class="row top_tiles">
              <div class="animated flipInY col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="tile-stats">
                  <div class="icon"><i class="fa fa-dollar-sign"></i></div>
                  <div class="count"><?=$user_credits?$user_credits:0?></div>
                  <h3>Credit</h3>
                 
                </div>
              </div>
              <div class="animated flipInY col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="tile-stats">
                  <div class="icon"><i class="fa fa-arrow-alt-circle-up"></i></div>
                  <div class="count"><?=$user_points?$user_points:0?></div>
                  <h3>Points</h3>
                 
                </div>
              </div>
              <div class="animated flipInY col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="tile-stats">
                  <div class="icon"><i class="fa fa-sort-amount-asc"></i></div>
                  <div class="count"><?=$level?></div>
                  <h3>Level</h3>
                 
                </div>
              </div>
              
            </div>
            <div class="row">
            <br/> <br/> <br/>
            <h6>Referrer name <strong><?=$username?></<strong> </h6>
    </div>
    <?php

}
        /**
     * Add a new settings tab to the WooCommerce settings tabs array.
     *
     * @param array $settings_tabs Array of WooCommerce setting tabs & their labels, excluding the Subscription tab.
     * @return array $settings_tabs Array of WooCommerce setting tabs & their labels, including the Subscription tab.
     */
    public static function add_settings_tab( $settings_tabs ) {
        $settings_tabs['settings_tab_points'] = __( 'Points And Credits', 'points' );
       // $settings_tabs['customer_level'] = __( 'Customer Level', 'points' );
        return $settings_tabs;
    }


    /**
     * Uses the WooCommerce admin fields API to output settings via the @see woocommerce_admin_fields() function.
     *
     * @uses woocommerce_admin_fields()
     * @uses self::get_settings()
     */
    public static function settings_tab() {
        woocommerce_admin_fields( self::get_settings() );
    }
    /**
     * Uses the WooCommerce options API to save settings via the @see woocommerce_update_options() function.
     *
     * @uses woocommerce_update_options()
     * @uses self::get_settings()
     */
    public static function update_settings() {
        woocommerce_update_options( self::get_settings() );
    }
    /**
     * Get all the settings for this plugin for @see woocommerce_admin_fields() function.
     *
     * @return array Array of settings for @see woocommerce_admin_fields() function.
     */

    /*public static function get_settings() {
        $settings = array(
                            array(
                            'name' => __( 'Pricing Options', 'woocommerce' ),
                            'type' => 'title',
                            'desc' => __('The following options affect how prices are displayed on the frontend.', 'woocommerce'),
                            'id'   => 'pricing_options'
                            ),
              
                            array(
                            'name'    => __( 'Currency Position', 'woocommerce' ),
                            'desc'    => __( 'This controls the position of the currency symbol.', 'woocommerce' ),
                            'id'      => 'woocommerce_currency_pos',
                            'css'     => 'min-width:150px;',
                            'std'     => 'left', // WooCommerce < 2.0
                            'default' => 'left', // WooCommerce >= 2.0
                            'type'    => 'select',
                            'options' => array(
                                'left'        => __( 'Left', 'woocommerce' ),
                                'right'       => __( 'Right', 'woocommerce' ),
                                'left_space'  => __( 'Left (with space)', 'woocommerce' ),
                                'right_space' => __( 'Right (with space)', 'woocommerce' )
                            ),
                            'desc_tip' =>  true,
                            ),
              
                            array(
                            'name'     => __( 'Thousand separator', 'woocommerce' ),
                            'desc'     => __( 'This sets the thousand separator of displayed prices.', 'woocommerce' ),
                            'id'       => 'woocommerce_price_thousand_sep',
                            'css'      => 'width:30px;',
                            'std'      => ',', // WooCommerce < 2.0
                            'default'  => ',', // WooCommerce >= 2.0
                            'type'     => 'text',
                            'desc_tip' =>  true,
                            ),
                
                                array(
                                'name'    => __( 'Trailing zeros', 'woocommerce' ),
                                'desc'    => __( 'Remove zeros after the decimal point. e.g. $10.00 becomes $10', 'woocommerce' ),
                                'id'      => 'woocommerce_price_trim_zeros',
                                'std'     => 'yes', // WooCommerce < 2.0
                                'default' => 'yes', // WooCommerce >= 2.0
                                'type'    => 'checkbox'
                                ),
              
                             array( 'type' => 'sectionend', 'id' => 'pricing_options' ),
                );
                
               
    
            return apply_filters( 'points_settings_tab_settings', $settings );
                
    }*/

    public static function get_settings() {

        //array for the levels 

        $settings = array(
            'section_title' => array(
                'name'     => __( 'Points and Credits To be Earned', 'points' ),
                'type'     => 'title',
                'desc'     => 'Assign Points and credits Earned for every user at each level',
                'id'       => 'points_settings_tab_title'
            ),
            'Franchisee' => array(
                'name' => __( 'Franchisee Points Earned', 'points' ),
                'type' => 'number',
                'placeholder'=>'e.g 5',
                'desc' => __( 'The number of points the Franchisee earns after when his/her down line Joins', 'points' ),
                'id'   => 'points_settings_tab_franchisee_points'
            ),
            'FranchiseesCredit' => array(
                'name' => '',//,__( 'Franchisees Credit Earned', 'points' ),
                'type' => 'number',
                 'placeholder'=>'e.g 10%',
                'desc' => __( '(%)The Credits Percentage Earned by a Franchisee after when his/her down line Joins', 'points' ),
                'id'   => 'points_settings_tab_franchisees_credits'
            ),

            'downline' => array(
                'name' => __( 'Downline Points Earned', 'points' ),
                'type' => 'number',
                'placeholder'=>'e.g 5',
                'desc' => __( 'The number of points the Downline earns after  Joining', 'points' ),
                'id'   => 'points_settings_tab_downline_points'
            ),
            'downlineCredit' => array(
                'name' => '',//,__( 'Franchisees Credit Earned', 'points' ),
                'type' => 'number',
                 'placeholder'=>'e.g 10%',
                'desc' => __( '(%)The Credits Percentage Earned by a Down line after Joining', 'points' ),
                'id'   => 'points_settings_tab_downline_credits'
            ),

            'level1Points' => array(
                'name' => __( 'Points for Level 1', 'points' ),//,__( 'Franchisees Credit Earned', 'points' ),
                'type' => 'number',
                 'placeholder'=>'e.g 10',
                'desc' => __( 'Points Required for level 1', 'points' ),
                'id'   => 'points_settings_tab_level1_points'
            ),
            'level2Points' => array(
                'name' => __( 'Points for Level 2', 'points' ),//,__( 'Franchisees Credit Earned', 'points' ),
                'type' => 'number',
                 'placeholder'=>'e.g 10',
                'desc' => __( 'Points Required for level 2', 'points' ),
                'id'   => 'points_settings_tab_level2_points'
            ),
            'level3Points' => array(
                'name' => __( 'Points for Level 3', 'points' ),//,__( 'Franchisees Credit Earned', 'points' ),
                'type' => 'number',
                 'placeholder'=>'e.g 10',
                'desc' => __( 'Points Required for level 3', 'points' ),
                'id'   => 'points_settings_tab_level3_points'
            ),
            'level4Points' => array(
                'name' => __( 'Points for Level 4', 'points' ),//,__( 'Franchisees Credit Earned', 'points' ),
                'type' => 'number',
                 'placeholder'=>'e.g 10',
                'desc' => __( 'Points Required for level 4', 'points' ),
                'id'   => 'points_settings_tab_level4_points'
            ),
            'level5Points' => array(
                'name' => __( 'Points for Level 5', 'points' ),//,__( 'Franchisees Credit Earned', 'points' ),
                'type' => 'number',
                 'placeholder'=>'e.g 10',
                'desc' => __( 'Points Required for level 5', 'points' ),
                'id'   => 'points_settings_tab_level5_points'
            ),
            'level6Points' => array(
                'name' => __( 'Points for Level 6', 'points' ),//,__( 'Franchisees Credit Earned', 'points' ),
                'type' => 'number',
                 'placeholder'=>'e.g 10',
                'desc' => __( 'Points Required for level 6', 'points' ),
                'id'   => 'points_settings_tab_level6_points'
            ),
            'level7Points' => array(
                'name' => __( 'Points for Level 7', 'points' ),//,__( 'Franchisees Credit Earned', 'points' ),
                'type' => 'number',
                 'placeholder'=>'e.g 10',
                'desc' => __( 'Points Required for level 7', 'points' ),
                'id'   => 'points_settings_tab_level7_points'
            ),
            'level8Points' => array(
                'name' => __( 'Points for Level 8', 'points' ),//,__( 'Franchisees Credit Earned', 'points' ),
                'type' => 'number',
                 'placeholder'=>'e.g 10',
                'desc' => __( 'Points Required for level 8', 'points' ),
                'id'   => 'points_settings_tab_level8_points'
            ),
            'level9Points' => array(
                'name' => __( 'Points for Level 9', 'points' ),//,__( 'Franchisees Credit Earned', 'points' ),
                'type' => 'number',
                 'placeholder'=>'e.g 10',
                'desc' => __( 'Points Required for level 9', 'points' ),
                'id'   => 'points_settings_tab_level9_points'
            ),
            'level10Points' => array(
                'name' => __( 'Points for Level 10', 'points' ),//,__( 'Franchisees Credit Earned', 'points' ),
                'type' => 'number',
                 'placeholder'=>'e.g 10',
                'desc' => __( 'Points Required for level 10', 'points' ),
                'id'   => 'points_settings_tab_level10_points'
            ),        
            'section_end' => array(
                 'type' => 'sectionend',
                 'id' => 'points_settings_tab_section_end'
            )
        );
        return apply_filters( 'points_settings_tab_settings', $settings );

        //wc_settings_tab_demo_settings
    }

}
Points_Settings_Tab::init();