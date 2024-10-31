<?php
/*
RecurlyWP AJAX
*/

function recurly_account_update_ajax_process() {
 
    $nonce = $_POST['nonce'];

    if ( ! wp_verify_nonce( $nonce, 'ajax-nonce' ) ) {
        die( 'Nonce value cannot be verified.' );
    }
    $response_data = array();
    $user_id = "";
    $current_user = wp_get_current_user();
    $user_id = get_current_user_id();

    // The $_REQUEST contains all the data sent via ajax
    if ( isset($_REQUEST) ) {
        $client = recurlywp_api_setup();
        $recurlydata = array();
        $recurly = $_REQUEST['recurly'];
        parse_str($recurly,$recurlydata);
        if(is_user_logged_in()){

            try {
                $account_update = [
                    "first_name" => $recurlydata['firstname'],
                    "last_name" => $recurlydata['lastname'],
                    "address" => [
                        "street1" => $recurlydata['address'],
                        "country" => $recurlydata['country'],
                        "city" => $recurlydata['city'],
                        "region" => $recurlydata['state'],
                        "postal_code" => $recurlydata['zipcode']
                    ]
                ];

                $account = $client->updateAccount("code-".$current_user->user_email, $account_update);

                $response_data['type'] = "success";
                $response_data['message'] = apply_filters("recurlywp_sucess_message","Account updated sucessfully!");

                update_user_meta($user_id,'recurly_address',$recurlydata['address']);
                update_user_meta($user_id,'recurly_city',$recurlydata['city']);
                update_user_meta($user_id,'recurly_zipcode',$recurlydata['zipcode']);
                update_user_meta($user_id,'recurly_country',$recurlydata['country']);
                update_user_meta($user_id,'recurly_state',$recurlydata['state']);

                wp_update_user([
                    'ID' => $user_id, // this is the ID of the user you want to update.
                    'first_name' => $recurlydata['firstname'],
                    'last_name' => $recurlydata['lastname'],
                ]);

            } catch (\Recurly\Errors\Validation $e) {
                $response_data['type'] = "error";
                $response_data['message'] = $e->getMessage();
            } catch (\Recurly\RecurlyError $e) {
                $response_data['type'] = "error";
                $response_data['message'] = $e->getMessage();
            }


        }

    }
    print_r(json_encode($response_data));
    // Always die in functions echoing ajax content
   die();
}
 
add_action( 'wp_ajax_recurly_account_update_ajax_process', 'recurly_account_update_ajax_process' );
 
// If you wanted to also use the function for non-logged in users (in a theme for example)
add_action( 'wp_ajax_nopriv_recurly_account_update_ajax_process', 'recurly_account_update_ajax_process' );

function recurly_card_update_ajax_process() {
 
    $nonce = $_POST['nonce'];

    if ( ! wp_verify_nonce( $nonce, 'ajax-nonce' ) ) {
        die( 'Nonce value cannot be verified.' );
    }
    $response_data = array();
    $current_user = wp_get_current_user();
 
    // The $_REQUEST contains all the data sent via ajax
    if ( isset($_REQUEST) ) {
        $client = recurlywp_api_setup();
        $recurlydata = array();
        $recurly = $_REQUEST['recurly'];
        parse_str($recurly,$recurlydata);
        $user_id = "";
        if(is_user_logged_in()){

            $cardholdername = recurlywp_split_name($recurlydata['card-holders-name']);

            try {
                $binfo_update = [
                    "first_name" => $cardholdername['first_name'],
                    "last_name" => $cardholdername['last_name'],
                    "number" => $recurlydata['card-number'],
                    "month" => $recurlydata['expiry-month'],
                    "year" => $recurlydata['expiry-year'],
                    "cvv" => $recurlydata['cvc']                    
                ];
                $binfo = $client->updateBillingInfo("code-".$current_user->user_email, $binfo_update);

                $response_data['type'] = "success";
                $response_data['message'] = apply_filters("recurlywp_sucess_message","Card updated sucessfully!");

            } catch (\Recurly\Errors\Validation $e) {
                $response_data['type'] = "error";
                $response_data['message'] = $e->getMessage();
            } catch (\Recurly\RecurlyError $e) {
                $response_data['type'] = "error";
                $response_data['message'] = $e->getMessage();
            }

        }

    }
    print_r(json_encode($response_data));
    // Always die in functions echoing ajax content
   die();
}
 
add_action( 'wp_ajax_recurly_card_update_ajax_process', 'recurly_card_update_ajax_process' );
 
// If you wanted to also use the function for non-logged in users (in a theme for example)
add_action( 'wp_ajax_nopriv_recurly_card_update_ajax_process', 'recurly_card_update_ajax_process' );

function recurly_submit_ajax_process() {
 
    $nonce = $_POST['nonce'];

    if ( ! wp_verify_nonce( $nonce, 'ajax-nonce' ) ) {
        die( 'Nonce value cannot be verified.' );
    }
    $response_data = array();
    $options = get_option('recurlywp');

    // The $_REQUEST contains all the data sent via ajax
    if ( isset($_REQUEST) ) {
        $client = recurlywp_api_setup();
        $recurlydata = array();
        $recurly = $_REQUEST['recurly'];
        parse_str($recurly,$recurlydata);
        $user_id = "";
        $cardholdername = recurlywp_split_name($recurlydata['card-holders-name']);
        if(!is_user_logged_in()){
            
            $user_id = username_exists( $recurlydata['email'] );
            if ( ! $user_id && false == email_exists( $user_email ) ) {
                $random_password = wp_generate_password( 12, false );
                $user_id = wp_create_user( $recurlydata['email'], $random_password, $recurlydata['email'] );
            } else {
                $response_data['type'] = "success";
                $response_data['message'] = __( 'User already exists.', 'recurlywp' );
                print_r(json_encode($response_data));
                die();
            }

        }
        else{
            $user_id = get_current_user_id();
        }

        try {
            $sub_create = [
                "plan_code" => $recurlydata['plancode'],
                "currency" => $options['currency'],
                "total_billing_cycles" => $recurlydata['billing_cycles'],
                "account" => [
                    "code" => $recurlydata['email'],
                    "first_name" => $recurlydata['firstname'],
                    "email" => $recurlydata['email'],
                    "last_name" => $recurlydata['lastname'],
                    "address" =>  [
                        //"first_name" => $recurlydata['firstname'],
                        //"last_name" => $recurlydata['lastname'],
                        "street1" => $recurlydata['address'],
                        "city" => $recurlydata['city'],
                        "postal_code" => $recurlydata['zipcode'],
                        "country" => $recurlydata['country']
                    ],
                    "billing_info" => [
                        "first_name" => $cardholdername['first_name'],
                        "last_name" => $cardholdername['last_name'],
                        "address" =>  [
                            //"first_name" => $recurlydata['firstname'],
                            //"last_name" => $recurlydata['lastname'],
                            "street1" => $recurlydata['address'],
                            "city" => $recurlydata['city'],
                            "postal_code" => $recurlydata['zipcode'],
                            "country" => $recurlydata['country'],
                            "region" => $recurlydata['state']
                        ],
                        "number" => $recurlydata['card-number'],
                        "month" => $recurlydata['expiry-month'],
                        "year" => $recurlydata['expiry-year'],
                        "cvv" => $recurlydata['cvc'],
                    ],
                ],
                "quantity" => $recurlydata['quantity']
            ];
            $subscription = $client->createSubscription($sub_create);

            $response_data['type'] = "success";

            //* Perform Action On Creating Subscription*//
            $args = array(
                'plan_code' => $recurlydata['plancode'],
                'user_id' => get_current_user_id(),
                'first_name' => $recurlydata['firstname'],
                'last_name' => $recurlydata['lastname'],
                'uuid' => $subscription->getUuid()
            );
            do_action('recurlywp_sucess_subscription',$args);

            $response_data['message'] = apply_filters("recurlywp_sucess_message","You are subscribed sucessfully!");
            update_user_meta($user_id,'recurly_address',$recurlydata['address']);
            update_user_meta($user_id,'recurly_city',$recurlydata['city']);
            update_user_meta($user_id,'recurly_zipcode',$recurlydata['zipcode']);
            update_user_meta($user_id,'recurly_country',$recurlydata['country']);
            update_user_meta($user_id,'recurly_state',$recurlydata['state']);

        } catch (\Recurly\Errors\Validation $e) {
            $response_data['type'] = "error";
            $response_data['message'] = $e->getMessage();
            // If the request was not valid, you may want to tell your user
            // why. You can find the invalid params and reasons in err.params
        } catch (\Recurly\RecurlyError $e) {
            // If we don't know what to do with the err, we should
            // probably re-raise and let our web framework and logger handle it
            $response_data['type'] = "error";
            $response_data['message'] = $e->getMessage();      
        }

        print_r(json_encode($response_data));
    }
     
    // Always die in functions echoing ajax content
   die();
}
 
add_action( 'wp_ajax_recurly_submit_ajax_process', 'recurly_submit_ajax_process' );
 
// If you wanted to also use the function for non-logged in users (in a theme for example)
add_action( 'wp_ajax_nopriv_recurly_submit_ajax_process', 'recurly_submit_ajax_process' );

//** Adding Pages **/
function recurly_create_default_pages() {
   if( current_user_can('editor') || current_user_can('administrator') ){

        $options = get_option('recurlywp');

        $checkoutpage = recurlywp_create_page("Checkout","[recurlywp_checkout]" );
        $loginpage = recurlywp_create_page("Login","[recurlywp_login_form]" );
        $dashboardpage = recurlywp_create_page("Dashboard","[recurlywp_dashboard]" );
        $options['checkout_page'] = $checkoutpage;
        $options['login_page'] = $loginpage;
        $options['dashboard_page'] = $dashboardpage;
        update_option('recurlywp',$options);

   }
}
add_action( 'wp_ajax_recurly_create_default_pages', 'recurly_create_default_pages' );

function recurly_cancel_ajax_subscription() {
 
    $nonce = $_POST['nonce'];

    if ( ! wp_verify_nonce( $nonce, 'ajax-nonce' ) ) {
        die( 'Nonce value cannot be verified.' );
    }
    $response_data = array();
    // The $_REQUEST contains all the data sent via ajax
    if ( isset($_REQUEST) ) {
        if(is_user_logged_in()){
            $client = recurlywp_api_setup();
            $recurlydata = array();
            $uuid = sanitize_text_field($_REQUEST['uuid']);
          
            try {
                $subscription = $client->cancelSubscription("uuid-".$uuid);

                $response_data['type'] = "success";
                $response_data['message'] = apply_filters("recurlywp_sucess_message","Subscription canceled!");

            } catch (\Recurly\Errors\Validation $e) {
                $response_data['type'] = "error";
                $response_data['message'] = $e->getMessage();
            } catch (\Recurly\RecurlyError $e) {
                $response_data['type'] = "error";
                $response_data['message'] = $e->getMessage();
            }
        }
    }
    print_r(json_encode($response_data));
    // Always die in functions echoing ajax content
   die();
}
 
add_action( 'wp_ajax_recurly_cancel_ajax_subscription', 'recurly_cancel_ajax_subscription' );
 
// If you wanted to also use the function for non-logged in users (in a theme for example)
add_action( 'wp_ajax_nopriv_recurly_cancel_ajax_subscription', 'recurly_cancel_ajax_subscription' );


/** Update Recurly Subscription **/
function recurly_update_ajax_subscription() {
 
    $nonce = $_POST['nonce'];
    if ( ! wp_verify_nonce( $nonce, 'ajax-nonce' ) ) {
        die( 'Nonce value cannot be verified.' );
    }
    $response_data = array();
    // The $_REQUEST contains all the data sent via ajax
    if ( isset($_REQUEST) ) {
        if(is_user_logged_in()){
            $client = recurlywp_api_setup();
            $recurlydata = array();
            $recurly = $_REQUEST['recurlyupdate'];
            parse_str($recurly,$recurlydata);
          
            try {
                $change_create = [
                    "quantity" => $recurlydata['quantity']
                ];
                $change = $client->createSubscriptionChange("uuid-".$recurlydata['uuid'], $change_create);

                $response_data['type'] = "success";
                $response_data['message'] = apply_filters("recurlywp_sucess_message","Subscription updated!");

            } catch (\Recurly\Errors\Validation $e) {

                $response_data['type'] = "error";
                $response_data['message'] = $e->getMessage();

            } catch (\Recurly\RecurlyError $e) {

                $response_data['type'] = "error";
                $response_data['message'] = $e->getMessage();

            }
        }
    }
    print_r(json_encode($response_data));
    // Always die in functions echoing ajax content
   die();
}
 
add_action( 'wp_ajax_recurly_update_ajax_subscription', 'recurly_update_ajax_subscription' );
 
// If you wanted to also use the function for non-logged in users (in a theme for example)
add_action( 'wp_ajax_nopriv_recurly_update_ajax_subscription', 'recurly_update_ajax_subscription' );