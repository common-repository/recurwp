<?php
/**
 * Enquee Styles/Scripts
 */
// Adding CSS
function recurlywp_add_scripts() {

    // Recurly Card JS
    wp_enqueue_style( 'card-js-style', RECURLYWP_SCRIPT_URI . '/assets/css/card-js.min.css', false, false, false );
    
    // Recurly Checkout Form
    wp_enqueue_style( 'checkout-form-style', RECURLYWP_SCRIPT_URI . '/assets/css/checkout-form.css', array(), RECURLYWP_VERSION );

    // jQuery Easing
    wp_enqueue_script( 'jquery-easing', RECURLYWP_SCRIPT_URI . '/assets/js/jquery.easing.min.js', array('jquery'), false, true );

    // jQuery Validate
    wp_enqueue_script( 'jquery-validate', RECURLYWP_SCRIPT_URI . '/assets/js/jquery.validate.js', array('jquery'), false, true );

    // jQuery CardJS
    wp_enqueue_script( 'card-js', RECURLYWP_SCRIPT_URI . '/assets/js/card-js.min.js', array('jquery'), false, true );
    
    // Checkout Form Steps
    wp_enqueue_script( 'checkout-form-steps', RECURLYWP_SCRIPT_URI . '/assets/js/checkout-form-steps.js', array('jquery'), RECURLYWP_VERSION );

    //Recurly Main Styles
    wp_enqueue_style( 'recurlywp-styles', RECURLYWP_SCRIPT_URI . 'assets/css/recurlywp-style.css', array(), RECURLYWP_VERSION );    

    // Enqueue javascript on the frontend.
    wp_enqueue_script(
        'recurly-ajax',
        RECURLYWP_SCRIPT_URI . '/assets/js/recurly-ajax.js',
        array('jquery'),
        rand()
    );

    // The wp_localize_script allows us to output the ajax_url path for our script to use.
    wp_localize_script(
        'recurly-ajax',
        'recurly_ajax_obj',
        array(
            'ajaxurl' => admin_url( 'admin-ajax.php' ),
            'nonce' => wp_create_nonce('ajax-nonce')
        )
    );
    
}
add_action( 'wp_enqueue_scripts', 'recurlywp_add_scripts' );


function recurlywp_admin_scripts($hook) {
    // Admin Styles For Redux
    if($hook != 'toplevel_page_Recurly'){
        return ;
    }
    wp_enqueue_style( 'recurlywp-styles', RECURLYWP_SCRIPT_URI . 'assets/css/admin-style.css', array(), RECURLYWP_VERSION );

    wp_enqueue_script( 'recurlywp-admin-script', RECURLYWP_SCRIPT_URI . 'assets/js/admin-script.js', array('jquery'), RECURLYWP_VERSION );

    // The wp_localize_script allows us to output the ajax_url path for our script to use.
    wp_localize_script(
        'recurlywp-admin-script',
        'recurly_admin_obj',
        array(
            'ajaxurl' => admin_url( 'admin-ajax.php' ),
            'nonce' => wp_create_nonce('recadmin-nonce')
        )
    );

}
add_action( 'admin_enqueue_scripts', 'recurlywp_admin_scripts' );