<?php
/*
Checkout Page
*/

// Checkout shortcode
function recurlywp_checkout(){
	ob_start();
	if ( $overridden_template = locate_template( 'checkout.php' ) ) {
	    /*
	     * locate_template() returns path to file.
	     * if either the child theme or the parent theme have overridden the template.
	     */
	    load_template( $overridden_template );
	} else {
	    /*
	     * If neither the child nor parent theme have overridden the template,
	     * we load the template from the 'templates' sub-directory of the directory this file is in.
	     */
	    include(RECURLYWP_DIR. '/templates/checkout.php' );
	}
	return ob_get_clean();
}
add_shortcode('recurlywp_checkout','recurlywp_checkout');