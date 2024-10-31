<?php
/*
Plugin Name: RecurWP
Plugin URI: https://recurlywp.photontechs.com
Description: A complete recruly WordPress plugin.
Author: wpcohort
Author URI:https://profiles.wordpress.org/wocohort/
Version: 1.0.3
License: GPLv2
*/
/* DEFINING CONSTANTS */
define( 'RECURLYWP_VERSION', rand() );
define( 'RECURLYWP_SCRIPT_URI', plugin_dir_url( __FILE__ ) );
define( 'RECURLYWP_DIR', plugin_dir_path( __FILE__ ) );
// Fremius Integration

if ( !function_exists( 'recurlywp_fs' ) ) {
    // Create a helper function for easy SDK access.
    function recurlywp_fs()
    {
        global  $recurlywp_fs ;
        
        if ( !isset( $recurlywp_fs ) ) {
            // Include Freemius SDK.
            require_once dirname( __FILE__ ) . '/freemius/start.php';
            $recurlywp_fs = fs_dynamic_init( array(
                'id'             => '9145',
                'slug'           => 'recurwp',
                'type'           => 'plugin',
                'public_key'     => 'pk_faf4913ba186b18ee55e2e10e9316',
                'is_premium'     => false,
                'premium_suffix' => 'RecurWP Pro',
                'has_addons'     => false,
                'has_paid_plans' => true,
                'menu'           => array(
                'slug' => 'Recurly',
            ),
                'is_live'        => true,
            ) );
        }
        
        return $recurlywp_fs;
    }
    
    // Init Freemius.
    recurlywp_fs();
    // Signal that SDK was initiated.
    do_action( 'recurlywp_fs_loaded' );
}

try {
    /*
    Recurly Client Load
    */
    require_once RECURLYWP_DIR . '/lib/vendor/autoload.php';
    /*
    Misc Functions
    */
    require_once RECURLYWP_DIR . '/inc/misc.php';
    /*
    Redux Framework
    */
    if ( !class_exists( 'ReduxFramework' ) && file_exists( RECURLYWP_DIR . '/options/framework/ReduxCore/framework.php' ) ) {
        require_once RECURLYWP_DIR . '/options/framework/ReduxCore/framework.php';
    }
    if ( !isset( $redux_demo ) && file_exists( RECURLYWP_DIR . '/options/framework/settings/recurlywp-config.php' ) ) {
        require_once RECURLYWP_DIR . '/options/framework/settings/recurlywp-config.php';
    }
    /*
    Login Form
    */
    require_once RECURLYWP_DIR . '/inc/login.php';
    /*
    Enquee Styles/Scripts
    */
    require_once RECURLYWP_DIR . '/inc/scripts.php';
    /*
    Checkout Form
    */
    require_once RECURLYWP_DIR . '/inc/checkout.php';
    /*
    Dashboard
    */
    require_once RECURLYWP_DIR . '/inc/dashboard.php';
    /*
    CPT & Admin Page
    */
    require_once RECURLYWP_DIR . '/inc/cpt.php';
    /*
    AJAX Process
    */
    require_once RECURLYWP_DIR . '/inc/ajax.php';
} catch ( Exception $ex ) {
}