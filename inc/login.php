<?php
/*
Recurly Login Form
*/

// function to login Shortcode
function recurlywp_login_shortcode( $atts ) {
    global $wpdb; 
    $login_fail_msg = "";
    if(!is_admin()){
	    if(!empty($_GET['login'])){
			if(sanitize_text_field( $_GET['login'] ) != ''){
			 $login_fail_msg=sanitize_text_field( $_GET['login'] );
			}
		}
		if(is_user_logged_in()){
			_e('You are already logged in.','recurlywp');
		}
		else{
		?>
			<div class="recurlywp-login-form">
			<?php if($login_fail_msg=='failed'){?>
			<div class="recurly-error"  align="center"><?php _e('Username or password is incorrect','recurlywp');?></div>
			<?php }?>
				<div class="alar-login-heading">
				</div>
				<form method="post" action="<?php echo get_option('home');?>/wp-login.php" id="loginform" name="loginform" >
					<div class="recurlywp-input-container">
					<label><?php _e('Username/Email :','recurlywp');?> </label>
					 <input type="text" tabindex="10" size="20" value="" class="recurly-input" id="user_login" required name="log" />
					</div>
					<div class="recurlywp-input-container">
					<label><?php _e('Password :','recurlywp');?> </label>
					  <input type="password" tabindex="20" size="20" value="" class="recurly-input" id="user_pass" required name="pwd" />
					</div>
					<div class="recurlywp-input-container">
					<input type="submit" tabindex="100" value="Log In" class="button" id="wp-submit" name="wp-submit" />
					<input type="hidden" value="<?php echo get_option('home');?>" name="redirect_to">
					</div>
				</form>
			</div>
		<?php
		}
	}
}

//add login shortcoode
add_shortcode( 'recurlywp_login_form', 'recurlywp_login_shortcode' );


//redirect to front end ,when login is failed
add_action( 'wp_login_failed', 'recurlywp_front_end_login_fail' );  // hook failed login

function recurlywp_front_end_login_fail( $username ) {
   $referrer = $_SERVER['HTTP_REFERER']; 
   // if there's a valid referrer, and it's not the default log-in screen
   if ( !empty($referrer) && !strstr($referrer,'wp-login') && !strstr($referrer,'wp-admin') ) {
      wp_redirect( $referrer . '/?login=failed' );  
      exit;
   }
}