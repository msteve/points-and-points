
<?php

class Points_Settings_Tab {
    public static function init() {
        add_filter( 'woocommerce_settings_tabs_array', __CLASS__ . '::add_settings_tab', 50 );
        add_action( 'woocommerce_settings_tabs_settings_tab_points', __CLASS__ . '::settings_tab' );
        add_action( 'woocommerce_update_options_settings_tab_points', __CLASS__ . '::update_settings' );

    }

        /**
     * Add a new settings tab to the WooCommerce settings tabs array.
     *
     * @param array $settings_tabs Array of WooCommerce setting tabs & their labels, excluding the Subscription tab.
     * @return array $settings_tabs Array of WooCommerce setting tabs & their labels, including the Subscription tab.
     */
    public static function add_settings_tab( $settings_tabs ) {
        $settings_tabs['settings_tab_points'] = __( 'Points And Credits', 'points' );
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

            'downlineCredit' => array(
                'name' => '',//,__( 'Franchisees Credit Earned', 'points' ),
                'type' => 'number',
                 'placeholder'=>'e.g 10%',
                'desc' => __( '(%)The Credits Percentage Earned by a Down line after Joining', 'points' ),
                'id'   => 'points_settings_tab_downline_credits'
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