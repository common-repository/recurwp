<?php
/*
Recurly Checkout Template
*/
do_action('recurlywp_before_checkout');
$current_user = wp_get_current_user();
$current_user_id = get_current_user_id();
$options = get_option('recurlywp');
$plan_id = "";
$amount = 1;
if(!empty($options['default_plan'])){
	$plan_id = $options['default_plan'];
}
if(!empty($_GET['amount'])){
	$amount = sanitize_text_field($_GET['amount']);
}
$plan_info = recurlywp_get_plan_info($plan_id);
$recurly_address = "";
$recurly_address = get_user_meta($current_user_id,'recurly_address',true);
$recurly_city = "";
$recurly_city = get_user_meta($current_user_id,'recurly_city',true);
$recurly_zipcode = "";
$recurly_zipcode = get_user_meta($current_user_id,'recurly_zipcode',true);
$recurly_country = "";
$recurly_country = get_user_meta($current_user_id,'recurly_country',true);
$recurly_state = "";
$recurly_state = get_user_meta($current_user_id,'recurly_state',true);
$recurly_list_countries = recurlywp_get_countries();
?>
<div class="check-steps-outer" id="check-steps-block">

	<div class="container">
		<div class="row">
			<form class="steps" accept-charset="UTF-8" enctype="multipart/form-data" id="recurly_form" novalidate="">
				<input type="hidden" name="plancode" value="<?php echo $plan_id; ?>">
				<ul id="progressbar">
				  <li class="active"><?php echo __('User Information','recurlywp'); ?></li>
				  <li><?php echo __('Pay Now','recurlywp'); ?> </li>
				  <li><?php echo __('Confirmation','recurlywp'); ?> </li>
				</ul>
		  <!-- USER INFORMATION FIELD SET --> 
			<fieldset>
			    <h2 class="fs-title"> <?php echo __('Basic Information','recurlywp'); ?> </h2>
			    <h3 class="fs-subtitle">  <?php echo __('We just need some basic information to begin your scoring','recurlywp'); ?> </h3>
			    <!-- Begin What's Your First Name Field -->
			    <div class="row">
			    	<div class="col-sm-7">
			    		<div class="form-group row">
						    <label class="col-sm-3 col-form-label"> <?php echo __('First Name','recurlywp'); ?> </label>
						    <div class="col-sm-9">
						      <input class="form-control" name="firstname" value="<?php echo $current_user->user_firstname; ?>" required="required" type="text" placeholder="" data-rule-required="true" data-msg-required="Please include your first name." >
						      	<span class="error1" style="display: none;">
					              <i class="error-log fa fa-exclamation-triangle"></i>
					          	</span>
						    </div>
						</div>

			    		<div class="form-group row">
						    <label class="col-sm-3 col-form-label"> <?php echo __('Last Name','recurlywp'); ?> </label>
						    <div class="col-sm-9">
						      <input class="form-control" name="lastname" value="<?php echo $current_user->user_lastname; ?>" required="required" type="text"  placeholder="" data-rule-required="true" data-msg-required="Please include your last name." >
						      	<span class="error1" style="display: none;">
					              <i class="error-log fa fa-exclamation-triangle"></i>
					          	</span>
						    </div>
						</div>

			    		<div class="form-group row">
						    <label class="col-sm-3 col-form-label">  <?php echo __('Email','recurlywp'); ?> </label>
						    <div class="col-sm-9">
						      <input class="form-control" name="email" required="required" value="<?php echo $current_user->user_email; ?>" type="text" placeholder="" data-rule-required="true" data-msg-required="Please include your email." >
						      	<span class="error1" style="display: none;">
					              <i class="error-log fa fa-exclamation-triangle"></i>
					          	</span>
						    </div>
						</div>

						<?php if(!is_user_logged_in()){ ?>
			    		<!-- <div class="form-group row">
						    <label class="col-sm-3 col-form-label">Password</label>
						    <div class="col-sm-9">
						      <input class="form-control" id="password" name="password"  data-rule-password="true"   required="required" value="" type="password" value="" placeholder="" data-rule-required="true" data-msg-required="Please include your password." >
						      	<span class="error1" style="display: none;">
					              <i class="error-log fa fa-exclamation-triangle"></i>
					          	</span>
						    </div>
						</div>


			    		<div class="form-group row">
						    <label class="col-sm-3 col-form-label">Re-enter Password</label>
						    <div class="col-sm-9">
						      <input class="form-control" name="reenterpassword" data-rule-password="true" data-rule-equalTo="#password" required="required" value="" type="password" value="" placeholder="" data-rule-required="true" data-msg-required="Please include your password." >
						      	<span class="error1" style="display: none;">
					              <i class="error-log fa fa-exclamation-triangle"></i>
					          	</span>
						    </div>
						</div>
	--->
						<?php } ?>



			    		<div class="form-group row">
						    <label class="col-sm-3 col-form-label"> <?php echo __('Address','recurlywp'); ?> </label>
						    <div class="col-sm-9">
						      <input class="form-control" name="address" value="<?php echo $recurly_address; ?>" required="required" type="text"  placeholder="" data-rule-required="true" data-msg-required="Please include your shipping address." >
						      	<span class="error1" style="display: none;">
					              <i class="error-log fa fa-exclamation-triangle"></i>
					          	</span>
						    </div>
						</div>

			    		<div class="form-group row">
						    <label class="col-sm-3 col-form-label"> <?php echo __('Country','recurlywp'); ?> </label>
						    <div class="col-sm-9">
						         <select id="country" name="country" class="form-control" required="required" data-rule-required="true"  data-msg-required="Please select your country." >
									<?php foreach ($recurly_list_countries as $countrycode => $countryval) {

										?>
										<option value="<?php echo $countrycode; ?>" <?php if(!empty($recurly_country)) { if($countrycode == $recurly_country) { echo "selected"; } } else { if($countrycode == $options['countries']) { echo "selected"; } } ?>><?php echo $countryval; ?></option>
										<?php
									} ?>
					            </select>
						      	<span class="error1" style="display: none;">
					              <i class="error-log fa fa-exclamation-triangle"></i>
					          	</span>
						    </div>
						</div>



			    		<div class="form-group row">
						    <label class="col-sm-3 col-form-label"> <?php echo __('City','recurlywp'); ?> </label>
						    <div class="col-sm-9">
						      <input class="form-control" name="city" required="required" value="<?php echo $recurly_city; ?>" type="text" placeholder="" data-rule-required="true" data-msg-required="Please enter your city." >
						      	<span class="error1" style="display: none;">
					              <i class="error-log fa fa-exclamation-triangle"></i>
					          	</span>
						    </div>
						</div>



			    		<div class="form-group row">
						    <label class="col-sm-3 col-form-label"> <?php echo __('State','recurlywp'); ?> </label>
						    <div class="col-sm-9">
						      <input class="form-control" name="state" required="required" value="<?php echo $recurly_state; ?>" type="text" placeholder="" data-rule-required="true" data-msg-required="Please enter your state." >
						      	<span class="error1" style="display: none;">
					              <i class="error-log fa fa-exclamation-triangle"></i>
					          	</span>
						    </div>
						</div>


			    		<div class="form-group row">
						    <label class="col-sm-3 col-form-label"> <?php echo __('ZIP Code','recurlywp'); ?> </label>
						    <div class="col-sm-9">
						      <input class="form-control" name="zipcode" required="required" type="text" value="<?php echo $recurly_zipcode; ?>"  placeholder="" data-rule-required="true" data-msg-required="Please enter your zipcode." >
						      	<span class="error1" style="display: none;">
					              <i class="error-log fa fa-exclamation-triangle"></i>
					          	</span>
						    </div>
						</div>
						<!-- Quantity Field -->
						<input type="hidden" value="<?php echo $amount; ?>" name="quantity" />
						<!--  Ends here -->
			    	</div>
			    	<div class="col-sm-5 pr60">
						<?php recurlywp_get_order_review($plan_info,$amount); ?>			
					</div>
			    	</div>
					<input type="button" data-page="1" name="next" class="next action-button" value="<?php echo __('Next','recurlywp'); ?>">
			</fieldset>



		  <!-- ACQUISITION FIELD SET -->  
		  <fieldset>
		    <h2 class="fs-title"> <?php echo __('Please enter your account detail','recurlywp'); ?> </h2>
		    <h3 class="fs-subtitle"> <?php echo __('How have you been doing in acquiring donors?','recurlywp'); ?> </h3>
		      <!-- Begin Total Number of Donors in Year 1 Field -->
		       <div class="row plr-40 account-sub-block">
		       	<div class="col-sm-7">
		       		<div class="panel-body">
		       		<div id="response_recurly">
		       			
		       		</div>
					<div class="card-js">
					  <input class="card-number my-custom-class" name="card-number">
					  <input class="name" id="the-card-name-id" name="card-holders-name" placeholder="Name on card">
					  <input class="expiry-month" name="expiry-month">
					  <input class="expiry-year" name="expiry-year">
					  <input class="cvc" name="cvv">
					</div>
						<span class="mt-20 btn btn-block btn-primary" id="pay_n_recurly">Pay now</span>
					</div>
		       	</div>
		       	<div class="col-sm-5">
		       		<?php recurlywp_get_order_review($plan_info,$amount); ?>	
		       	</div>
		       </div>
		        <!-- End Calc of Total Number of Donors Fields -->
		   <input type="button" data-page="2" name="next" class="next action-button" id="success_order_message" value="<?php echo __('Place Order Now','recurlywp'); ?>" />
		   	<div class="text-align-center">
		    	<input type="button" data-page="2" name="previous" class="previous action-button" value="<?php echo __('Previous','recurlywp'); ?>" />
			</div>
		  </fieldset>



		  <!-- Cultivation FIELD SET -->  
		 	<fieldset>
			    <div class="conf-step">
			    	<img src="<?php echo $options['confirmation_icon']['url']; ?>">
			    	<h2 class="fs-title"><?php echo $options['confirmation_title']; ?></h2>
			   		<h3 class="fs-subtitle"><?php echo $options['confirmation_content']; ?></h3>
			    </div>
		  	</fieldset>

		  		<input type="hidden" name="recurly-token" data-recurly="token">
				
				</form>

		  </div>
	</div>
	<div class="recurly-ui-block">
		<div class="recurly-ui-inner">
			<div id="loading-icon">
				<div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>
			</div>
		</div>
	</div>
</div>