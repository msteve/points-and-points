
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
    public static function get_settings() {
        $settings = array(
            'section_title' => array(
                'name'     => __( 'Points and Credits To be Earned', 'points' ),
                'type'     => 'title',
                'desc'     => 'Assign Points and credits Earned for every user at each level',
                'id'       => 'points_settings_tab_title'
            ),
            'title' => array(
                'name' => __( 'Title', 'points' ),
                'type' => 'text',
                'desc' => __( 'This is some helper text', 'points' ),
                'id'   => 'points_settings_tab_section_title'
            ),
            'description' => array(
                'name' => __( 'Description', 'points' ),
                'type' => 'textarea',
                'desc' => __( 'This is a paragraph describing ta yadda. Lorem ipsum yadda yadda yadda. Lorem ipsum yadda yadda yadda. Lorem ipsum yadda yadda yadda.', 'points' ),
                'id'   => 'points_settings_tab_description'
            ),
            'credits' => array(
                'name' => __( 'Credits', 'points' ),
                'type' => 'text',
                'desc' => __( 'This is a paragraph yadda yadda. Lorem ipsum yadda yadda yadda.', 'points' ),
                'id'   => 'points_settings_tab_credits'
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