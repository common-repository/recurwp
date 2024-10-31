<?php

/**
 * ReduxFramework Sample Config File
 * For full documentation, please visit: http://docs.reduxframework.com/
 */
if ( !class_exists( 'Redux' ) ) {
    return;
}
// This is your option name where all the Redux data is stored.
$opt_name = "recurlywp";
// This line is only for altering the demo. Can be easily removed.
$opt_name = apply_filters( 'redux_demo/opt_name', $opt_name );
$upgrade_vert = array();
/*
 *
 * --> Used within different fields. Simply examples. Search for ACTUAL DECLARATION for field examples
 *
 */
$sampleHTML = '';

if ( file_exists( dirname( __FILE__ ) . '/info-html.html' ) ) {
    Redux_Functions::initWpFilesystem();
    global  $wp_filesystem ;
    $sampleHTML = $wp_filesystem->get_contents( dirname( __FILE__ ) . '/info-html.html' );
}

// Background Patterns Reader
$sample_patterns_path = ReduxFramework::$_dir . '../sample/patterns/';
$sample_patterns_url = ReduxFramework::$_url . '../sample/patterns/';
$sample_patterns = array();
if ( is_dir( $sample_patterns_path ) ) {
    
    if ( $sample_patterns_dir = opendir( $sample_patterns_path ) ) {
        $sample_patterns = array();
        while ( ($sample_patterns_file = readdir( $sample_patterns_dir )) !== false ) {
            
            if ( stristr( $sample_patterns_file, '.png' ) !== false || stristr( $sample_patterns_file, '.jpg' ) !== false ) {
                $name = explode( '.', $sample_patterns_file );
                $name = str_replace( '.' . end( $name ), '', $sample_patterns_file );
                $sample_patterns[] = array(
                    'alt' => $name,
                    'img' => $sample_patterns_url . $sample_patterns_file,
                );
            }
        
        }
    }

}
/**
 * ---> SET ARGUMENTS
 * All the possible arguments for Redux.
 * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
 * */
$theme = wp_get_theme();
// For use with some settings. Not necessary.
$args = array(
    'opt_name'             => $opt_name,
    'display_name'         => "Recurly",
    'display_version'      => "1.0",
    'menu_type'            => 'menu',
    'allow_sub_menu'       => true,
    'menu_title'           => __( 'Recurly', 'recurlywp' ),
    'page_title'           => __( 'Recurly', 'recurlywp' ),
    'google_api_key'       => '',
    'google_update_weekly' => false,
    'show_options_object'  => false,
    'async_typography'     => false,
    'admin_bar'            => false,
    'admin_bar_icon'       => 'dashicons-portfolio',
    'global_variable'      => '',
    'dev_mode'             => false,
    'update_notice'        => false,
    'customizer'           => false,
    'page_priority'        => 50,
    'page_parent'          => 'themes.php',
    'page_permissions'     => 'manage_options',
    'menu_icon'            => RECURLYWP_SCRIPT_URI . '/assets/logo/logo.png',
    'last_tab'             => '',
    'page_icon'            => 'icon-themes',
    'page_slug'            => '',
    'save_defaults'        => true,
    'default_show'         => false,
    'default_mark'         => '',
    'show_import_export'   => false,
    'transient_time'       => 60 * MINUTE_IN_SECONDS,
    'output'               => true,
    'output_tag'           => true,
    'database'             => '',
    'use_cdn'              => true,
    'hints'                => array(
    'icon'          => 'el el-question-sign',
    'icon_position' => 'right',
    'icon_color'    => 'lightgray',
    'icon_size'     => 'normal',
    'tip_style'     => array(
    'color'   => 'red',
    'shadow'  => true,
    'rounded' => false,
    'style'   => '',
),
    'tip_position'  => array(
    'my' => 'top left',
    'at' => 'bottom right',
),
    'tip_effect'    => array(
    'show' => array(
    'effect'   => 'slide',
    'duration' => '500',
    'event'    => 'mouseover',
),
    'hide' => array(
    'effect'   => 'slide',
    'duration' => '500',
    'event'    => 'click mouseleave',
),
),
),
);
// ADMIN BAR LINKS -> Setup custom links in the admin bar menu as external items.
$args['admin_bar_links'][] = array(
    'id'    => 'redux-docs',
    'href'  => 'http://docs.reduxframework.com/',
    'title' => __( 'Documentation', 'recurlywp' ),
);
$args['admin_bar_links'][] = array(
    'href'  => 'https://github.com/ReduxFramework/redux-framework/issues',
    'title' => __( 'Support', 'recurlywp' ),
);
$args['admin_bar_links'][] = array(
    'id'    => 'redux-extensions',
    'href'  => 'reduxframework.com/extensions',
    'title' => __( 'Extensions', 'recurlywp' ),
);
// SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.
$args['share_icons'][] = array(
    'url'   => 'https://github.com/ReduxFramework/ReduxFramework',
    'title' => 'Visit us on GitHub',
    'icon'  => 'el el-github',
);
$args['share_icons'][] = array(
    'url'   => 'https://www.facebook.com/pages/Redux-Framework/243141545850368',
    'title' => 'Like us on Facebook',
    'icon'  => 'el el-facebook',
);
$args['share_icons'][] = array(
    'url'   => 'http://twitter.com/reduxframework',
    'title' => 'Follow us on Twitter',
    'icon'  => 'el el-twitter',
);
$args['share_icons'][] = array(
    'url'   => 'http://www.linkedin.com/company/redux-framework',
    'title' => 'Find us on LinkedIn',
    'icon'  => 'el el-linkedin',
);
// Panel Intro text -> before the form

if ( !isset( $args['global_variable'] ) || $args['global_variable'] !== false ) {
    
    if ( !empty($args['global_variable']) ) {
        $v = $args['global_variable'];
    } else {
        $v = str_replace( '-', '_', $args['opt_name'] );
    }
    
    $args['intro_text'] = sprintf( __( '<p>Did you know that Redux sets a global variable for you? To access any of your saved options from within your code you can use your global variable: <strong>$%1$s</strong></p>', 'recurlywp' ), $v );
} else {
    $args['intro_text'] = __( '<p>This text is displayed above the options panel. It isn\'t required, but more info is always better! The intro_text field accepts all HTML.</p>', 'recurlywp' );
}

Redux::setArgs( $opt_name, $args );
/*

        As of Redux 3.5+, there is an extensive API. This API can be used in a mix/match mode allowing for
*/
// -> START Basic Fields
Redux::setSection( $opt_name, array(
    'title'            => __( 'Setup', 'recurlywp' ),
    'id'               => 'basic',
    'desc'             => __( 'These are really basic fields!', 'recurlywp' ),
    'customizer_width' => '400px',
    'icon'             => 'el el-home',
) );
Redux::setSection( $opt_name, array(
    'title'            => __( 'Basic Settings', 'recurlywp' ),
    'id'               => 'basic-checkbox',
    'subsection'       => true,
    'customizer_width' => '450px',
    'fields'           => array(
    array(
    'id'    => 'api_key',
    'type'  => 'password',
    'title' => __( 'API Settings', 'recurlywp' ),
    'desc'  => __( 'You can locate and manage your API keys from the <a href="https://app.recurly.com/go/developer/api_keys" target="_blank">API Credentials</a> page.', 'recurlywp' ),
),
    array(
    'id'      => 'countries',
    'type'    => 'select',
    'title'   => __( 'Default Country', 'recurlywp' ),
    'options' => recurlywp_get_countries(),
    'default' => 'US',
),
    array(
    'id'      => 'currency',
    'type'    => 'select',
    'title'   => __( 'Default Currency', 'recurlywp' ),
    'options' => recurlywp_get_currencies(),
    'default' => 'United States Dollar',
),
    array(
    'id'          => 'accent_color',
    'type'        => 'raw',
    'content' => '<a href="' . recurlywp_fs()->get_upgrade_url() . '"><img src="' . RECURLYWP_SCRIPT_URI . 'options/framework/settings/presets/accentcolors.png" /></a><div class="upgrade_now_cn"><a href="' . recurlywp_fs()->get_upgrade_url() . '"><strong>Upgrade now!</strong> to unlock this feature.</a></div>',

),
  
),
) );


Redux::setSection( $opt_name, array(
    'title'            => __( 'Checkout', 'recurlywp' ),
    'id'               => 'checkout',
    'desc'             => __( 'All checkout settings.', 'recurlywp' ),
    'customizer_width' => '400px',
    'icon'             => 'el el-credit-card',
) );
Redux::setSection( $opt_name, array(
    'title'            => __( 'Checkout Settings', 'recurlywp' ),
    'id'               => 'checkout-settings',
    'subsection'       => true,
    'customizer_width' => '450px',
    'fields'           => array(
   
    array(
    'id'    => 'checkout_page',
    'type'  => 'select',
    'title' => __( 'Select Checkout Page', 'recurlywp' ),
    'desc' => __('Please include [recurlywp_checkout] shortcode in the page content.','recurlywp'),
    'data'  => 'pages',
),
array(
    'id'    => 'default_plan',
    'type'  => 'text',
    'title' => __( 'Recurly Plan code (You can upgrade to add unlimited plans <a href="' . recurlywp_fs()->get_upgrade_url() . '">Upgrade Now</a>!)', 'recurlywp' ),
    'desc'  => __( 'Default plan is recommended to add.', 'recurlywp' ),
),
array(
    'id'    => 'restrict_access',
    'type'  => 'raw',
    'content' => '<a href="' . recurlywp_fs()->get_upgrade_url() . '"><img src="' . RECURLYWP_SCRIPT_URI . 'options/framework/settings/presets/requirelogin.png" /></a>',

   ),
    array(
    'id'    => 'dashboard_page',
    'type'  => 'raw',
    'content' => '<a href="' . recurlywp_fs()->get_upgrade_url() . '"><img src="' . RECURLYWP_SCRIPT_URI . 'options/framework/settings/presets/checkout.png" /></a><div class="upgrade_now_cn"><a href="' . recurlywp_fs()->get_upgrade_url() . '"><strong>Upgrade now!</strong> to unlock this feature.</a></div>',

    
    
),

),
) );
Redux::setSection( $opt_name, array(
    'title'            => __( 'Confirmation', 'recurlywp' ),
    'id'               => 'confirmation',
    'desc'             => __( 'All confirmation settings.', 'recurlywp' ),
    'customizer_width' => '400px',
    'icon'             => 'el el-check',
) );
Redux::setSection( $opt_name, array(
    'title'            => __( 'Confirmation Settings', 'recurlywp' ),
    'id'               => 'confirmation-settings',
    'subsection'       => true,
    'customizer_width' => '450px',
    'fields'           => array( array(
    'id'    => 'confirmation_icon',
    'type'  => 'media',
    'title' => __( 'Confirmation Icon', 'recurlywp' ),
), array(
    'id'      => 'confirmation_title',
    'type'    => 'text',
    'title'   => __( 'Confirmation Title', 'recurlywp' ),
    'default' => __( "IT'S ON THE WAY!", 'recurlywp' ),
), array(
    'id'      => 'confirmation_content',
    'type'    => 'editor',
    'title'   => __( 'Confirmation Content', 'recurlywp' ),
    'default' => __( "Thanks for the pruchase, Have a nice day!", 'recurlywp' ),
) ),
) );

Redux::setSection( $opt_name, array(
    'title'            => __( 'Shortcode', 'recurlywp' ),
    'id'               => 'shortcode',
    'desc'             => __( 'All shortcode settings.', 'recurlywp' ),
    'customizer_width' => '400px',
    'icon'             => 'el el-cogs',
) );
Redux::setSection( $opt_name, array(
    'title'            => __( 'Shortcode Generate', 'recurlywp' ),
    'id'               => 'shortcode-settings',
    'subsection'       => true,
    'customizer_width' => '450px',
    'fields'           => array( array(
    'id'      => 'selectplan',
    'type'    => 'raw',
    'content' => '<a href="' . recurlywp_fs()->get_upgrade_url() . '"><img src="' . RECURLYWP_SCRIPT_URI . 'options/framework/settings/presets/shortcodegen.png" /></a><div class="upgrade_now_cn"><a href="' . recurlywp_fs()->get_upgrade_url() . '"><strong>Upgrade now!</strong> to unlock this feature.</a></div>',
    ) ),
) );

Redux::setSection( $opt_name, array(
    'title'            => __( 'Tools', 'recurlywp' ),
    'id'               => 'tools',
    'desc'             => __( 'Tools settings.', 'recurlywp' ),
    'customizer_width' => '400px',
    'icon'             => 'el el-braille'
) );

Redux::setSection( $opt_name, array(
    'id'               => 'manage-settings',
    'subsection'       => true,
    'customizer_width' => '450px',
    'fields'           => array(
        array(
            'id'       => 'generate_pages',
            'type'     => 'raw',
            'content' => '<a href="' . recurlywp_fs()->get_upgrade_url() . '"><img src="' . RECURLYWP_SCRIPT_URI . 'options/framework/settings/presets/tools.png" /></a><div class="upgrade_now_cn"><a href="' . recurlywp_fs()->get_upgrade_url() . '"><strong>Upgrade now!</strong> to unlock this feature.</a></div>',
        ),
    )
) );

/*
 * <--- END SECTIONS
 */
/*
 *
 * YOU MUST PREFIX THE FUNCTIONS BELOW AND ACTION FUNCTION CALLS OR ANY OTHER CONFIG MAY OVERRIDE YOUR CODE.
 *
 */
/*
 *
 * --> Action hook examples
 *
 */
// If Redux is running as a plugin, this will remove the demo notice and links
//add_action( 'redux/loaded', 'remove_demo' );
// Function to test the compiler hook and demo CSS output.
// Above 10 is a priority, but 2 in necessary to include the dynamically generated CSS to be sent to the function.
//add_filter('redux/options/' . $opt_name . '/compiler', 'compiler_action', 10, 3);
// Change the arguments after they've been declared, but before the panel is created
//add_filter('redux/options/' . $opt_name . '/args', 'change_arguments' );
// Change the default value of a field after it's been set, but before it's been useds
//add_filter('redux/options/' . $opt_name . '/defaults', 'change_defaults' );
// Dynamically add a section. Can be also used to modify sections/fields
//add_filter('redux/options/' . $opt_name . '/sections', 'dynamic_section');
/**
 * This is a test function that will let you see when the compiler hook occurs.
 * It only runs if a field    set with compiler=>true is changed.
 * */
if ( !function_exists( 'compiler_action' ) ) {
    function compiler_action( $options, $css, $changed_values )
    {
        echo  '<h1>The compiler hook has run!</h1>' ;
        echo  "<pre>" ;
        print_r( $changed_values );
        // Values that have changed since the last save
        echo  "</pre>" ;
        //print_r($options); //Option values
        //print_r($css); // Compiler selector CSS values  compiler => array( CSS SELECTORS )
    }

}
/**
 * Custom function for the callback validation referenced above
 * */
if ( !function_exists( 'redux_validate_callback_function' ) ) {
    function redux_validate_callback_function( $field, $value, $existing_value )
    {
        $error = false;
        $warning = false;
        //do your validation
        
        if ( $value == 1 ) {
            $error = true;
            $value = $existing_value;
        } elseif ( $value == 2 ) {
            $warning = true;
            $value = $existing_value;
        }
        
        $return['value'] = $value;
        
        if ( $error == true ) {
            $field['msg'] = 'your custom error message';
            $return['error'] = $field;
        }
        
        
        if ( $warning == true ) {
            $field['msg'] = 'your custom warning message';
            $return['warning'] = $field;
        }
        
        return $return;
    }

}
/**
 * Custom function for the callback referenced above
 */
if ( !function_exists( 'redux_my_custom_field' ) ) {
    function redux_my_custom_field( $field, $value )
    {
        print_r( $field );
        echo  '<br/>' ;
        print_r( $value );
    }

}
/**
 * Custom function for filtering the sections array. Good for child themes to override or add to the sections.
 * Simply include this function in the child themes functions.php file.
 * NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
 * so you must use get_template_directory_uri() if you want to use any of the built in icons
 * */
if ( !function_exists( 'dynamic_section' ) ) {
    function dynamic_section( $sections )
    {
        //$sections = array();
        $sections[] = array(
            'title'  => __( 'Section via hook', 'recurlywp' ),
            'desc'   => __( '<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'recurlywp' ),
            'icon'   => 'el el-paper-clip',
            'fields' => array(),
        );
        return $sections;
    }

}
/**
 * Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.
 * */
if ( !function_exists( 'change_arguments' ) ) {
    function change_arguments( $args )
    {
        //$args['dev_mode'] = true;
        return $args;
    }

}
/**
 * Filter hook for filtering the default value of any given field. Very useful in development mode.
 * */
if ( !function_exists( 'change_defaults' ) ) {
    function change_defaults( $defaults )
    {
        $defaults['str_replace'] = 'Testing filter hook!';
        return $defaults;
    }

}
/**
 * Removes the demo link and the notice of integrated demo from the redux-framework plugin
 */
if ( !function_exists( 'remove_demo' ) ) {
    function remove_demo()
    {
        // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
        
        if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
            remove_filter(
                'plugin_row_meta',
                array( ReduxFrameworkPlugin::instance(), 'plugin_metalinks' ),
                null,
                2
            );
            // Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
            remove_action( 'admin_notices', array( ReduxFrameworkPlugin::instance(), 'admin_notices' ) );
        }
    
    }

}