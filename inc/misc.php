<?php
/*
Misc Functions
*/

function recurlywp_isSecure(){

    if (
        ( ! empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
        || ( ! empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')
        || ( ! empty($_SERVER['HTTP_X_FORWARDED_SSL']) && $_SERVER['HTTP_X_FORWARDED_SSL'] == 'on')
        || (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443)
        || (isset($_SERVER['HTTP_X_FORWARDED_PORT']) && $_SERVER['HTTP_X_FORWARDED_PORT'] == 443)
        || (isset($_SERVER['REQUEST_SCHEME']) && $_SERVER['REQUEST_SCHEME'] == 'https')
    ) {
        return true;
    } else {
        return false;
    }

}

/** Setting up recurly API **/
function recurlywp_api_setup(){
	$options = get_option('recurlywp');
	if(!empty($options['api_key'])){
		$api_key = $options['api_key'];
		$client = new \Recurly\Client($api_key);
		if(recurlywp_isSecure()){
			return $client;
		}
		else{
			add_action( 'admin_notices', function() {
			    $class = 'notice notice-error';
			    $message = __( 'Recurly Error: Yikes! Seems like SSL is not activated on the website. In order to use this plugin you need to have SSL installed on the website, this is the requirment from Recurly.', 'recurlywp' );
			 
			    printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) ); 
			});
		}
	}
	return 0;
}

/** Get Countries **/

function recurlywp_get_countries(){

	// Countries list starts here.

	$countries_list = array(
		"AF" => "Afghanistan",
		"AL" => "Albania",
		"DZ" => "Algeria",
		"AS" => "American Samoa",
		"AD" => "Andorra",
		"AO" => "Angola",
		"AI" => "Anguilla",
		"AQ" => "Antarctica",
		"AG" => "Antigua and Barbuda",
		"AR" => "Argentina",
		"AM" => "Armenia",
		"AW" => "Aruba",
		"AU" => "Australia",
		"AT" => "Austria",
		"AZ" => "Azerbaijan",
		"BS" => "Bahamas",
		"BH" => "Bahrain",
		"BD" => "Bangladesh",
		"BB" => "Barbados",
		"BY" => "Belarus",
		"BE" => "Belgium",
		"BZ" => "Belize",
		"BJ" => "Benin",
		"BM" => "Bermuda",
		"BT" => "Bhutan",
		"BO" => "Bolivia",
		"BA" => "Bosnia and Herzegovina",
		"BW" => "Botswana",
		"BV" => "Bouvet Island",
		"BR" => "Brazil",
		"BQ" => "British Antarctic Territory",
		"IO" => "British Indian Ocean Territory",
		"VG" => "British Virgin Islands",
		"BN" => "Brunei",
		"BG" => "Bulgaria",
		"BF" => "Burkina Faso",
		"BI" => "Burundi",
		"KH" => "Cambodia",
		"CM" => "Cameroon",
		"CA" => "Canada",
		"CT" => "Canton and Enderbury Islands",
		"CV" => "Cape Verde",
		"KY" => "Cayman Islands",
		"CF" => "Central African Republic",
		"TD" => "Chad",
		"CL" => "Chile",
		"CN" => "China",
		"CX" => "Christmas Island",
		"CC" => "Cocos [Keeling] Islands",
		"CO" => "Colombia",
		"KM" => "Comoros",
		"CG" => "Congo - Brazzaville",
		"CD" => "Congo - Kinshasa",
		"CK" => "Cook Islands",
		"CR" => "Costa Rica",
		"HR" => "Croatia",
		"CU" => "Cuba",
		"CY" => "Cyprus",
		"CZ" => "Czech Republic",
		"CI" => "Côte d’Ivoire",
		"DK" => "Denmark",
		"DJ" => "Djibouti",
		"DM" => "Dominica",
		"DO" => "Dominican Republic",
		"NQ" => "Dronning Maud Land",
		"DD" => "East Germany",
		"EC" => "Ecuador",
		"EG" => "Egypt",
		"SV" => "El Salvador",
		"GQ" => "Equatorial Guinea",
		"ER" => "Eritrea",
		"EE" => "Estonia",
		"ET" => "Ethiopia",
		"FK" => "Falkland Islands",
		"FO" => "Faroe Islands",
		"FJ" => "Fiji",
		"FI" => "Finland",
		"FR" => "France",
		"GF" => "French Guiana",
		"PF" => "French Polynesia",
		"TF" => "French Southern Territories",
		"FQ" => "French Southern and Antarctic Territories",
		"GA" => "Gabon",
		"GM" => "Gambia",
		"GE" => "Georgia",
		"DE" => "Germany",
		"GH" => "Ghana",
		"GI" => "Gibraltar",
		"GR" => "Greece",
		"GL" => "Greenland",
		"GD" => "Grenada",
		"GP" => "Guadeloupe",
		"GU" => "Guam",
		"GT" => "Guatemala",
		"GG" => "Guernsey",
		"GN" => "Guinea",
		"GW" => "Guinea-Bissau",
		"GY" => "Guyana",
		"HT" => "Haiti",
		"HM" => "Heard Island and McDonald Islands",
		"HN" => "Honduras",
		"HK" => "Hong Kong SAR China",
		"HU" => "Hungary",
		"IS" => "Iceland",
		"IN" => "India",
		"ID" => "Indonesia",
		"IR" => "Iran",
		"IQ" => "Iraq",
		"IE" => "Ireland",
		"IM" => "Isle of Man",
		"IL" => "Israel",
		"IT" => "Italy",
		"JM" => "Jamaica",
		"JP" => "Japan",
		"JE" => "Jersey",
		"JT" => "Johnston Island",
		"JO" => "Jordan",
		"KZ" => "Kazakhstan",
		"KE" => "Kenya",
		"KI" => "Kiribati",
		"KW" => "Kuwait",
		"KG" => "Kyrgyzstan",
		"LA" => "Laos",
		"LV" => "Latvia",
		"LB" => "Lebanon",
		"LS" => "Lesotho",
		"LR" => "Liberia",
		"LY" => "Libya",
		"LI" => "Liechtenstein",
		"LT" => "Lithuania",
		"LU" => "Luxembourg",
		"MO" => "Macau SAR China",
		"MK" => "Macedonia",
		"MG" => "Madagascar",
		"MW" => "Malawi",
		"MY" => "Malaysia",
		"MV" => "Maldives",
		"ML" => "Mali",
		"MT" => "Malta",
		"MH" => "Marshall Islands",
		"MQ" => "Martinique",
		"MR" => "Mauritania",
		"MU" => "Mauritius",
		"YT" => "Mayotte",
		"FX" => "Metropolitan France",
		"MX" => "Mexico",
		"FM" => "Micronesia",
		"MI" => "Midway Islands",
		"MD" => "Moldova",
		"MC" => "Monaco",
		"MN" => "Mongolia",
		"ME" => "Montenegro",
		"MS" => "Montserrat",
		"MA" => "Morocco",
		"MZ" => "Mozambique",
		"MM" => "Myanmar [Burma]",
		"NA" => "Namibia",
		"NR" => "Nauru",
		"NP" => "Nepal",
		"NL" => "Netherlands",
		"AN" => "Netherlands Antilles",
		"NT" => "Neutral Zone",
		"NC" => "New Caledonia",
		"NZ" => "New Zealand",
		"NI" => "Nicaragua",
		"NE" => "Niger",
		"NG" => "Nigeria",
		"NU" => "Niue",
		"NF" => "Norfolk Island",
		"KP" => "North Korea",
		"VD" => "North Vietnam",
		"MP" => "Northern Mariana Islands",
		"NO" => "Norway",
		"OM" => "Oman",
		"PC" => "Pacific Islands Trust Territory",
		"PK" => "Pakistan",
		"PW" => "Palau",
		"PS" => "Palestinian Territories",
		"PA" => "Panama",
		"PZ" => "Panama Canal Zone",
		"PG" => "Papua New Guinea",
		"PY" => "Paraguay",
		"YD" => "People's Democratic Republic of Yemen",
		"PE" => "Peru",
		"PH" => "Philippines",
		"PN" => "Pitcairn Islands",
		"PL" => "Poland",
		"PT" => "Portugal",
		"PR" => "Puerto Rico",
		"QA" => "Qatar",
		"RO" => "Romania",
		"RU" => "Russia",
		"RW" => "Rwanda",
		"RE" => "Réunion",
		"BL" => "Saint Barthélemy",
		"SH" => "Saint Helena",
		"KN" => "Saint Kitts and Nevis",
		"LC" => "Saint Lucia",
		"MF" => "Saint Martin",
		"PM" => "Saint Pierre and Miquelon",
		"VC" => "Saint Vincent and the Grenadines",
		"WS" => "Samoa",
		"SM" => "San Marino",
		"SA" => "Saudi Arabia",
		"SN" => "Senegal",
		"RS" => "Serbia",
		"CS" => "Serbia and Montenegro",
		"SC" => "Seychelles",
		"SL" => "Sierra Leone",
		"SG" => "Singapore",
		"SK" => "Slovakia",
		"SI" => "Slovenia",
		"SB" => "Solomon Islands",
		"SO" => "Somalia",
		"ZA" => "South Africa",
		"GS" => "South Georgia and the South Sandwich Islands",
		"KR" => "South Korea",
		"ES" => "Spain",
		"LK" => "Sri Lanka",
		"SD" => "Sudan",
		"SR" => "Suriname",
		"SJ" => "Svalbard and Jan Mayen",
		"SZ" => "Swaziland",
		"SE" => "Sweden",
		"CH" => "Switzerland",
		"SY" => "Syria",
		"ST" => "São Tomé and Príncipe",
		"TW" => "Taiwan",
		"TJ" => "Tajikistan",
		"TZ" => "Tanzania",
		"TH" => "Thailand",
		"TL" => "Timor-Leste",
		"TG" => "Togo",
		"TK" => "Tokelau",
		"TO" => "Tonga",
		"TT" => "Trinidad and Tobago",
		"TN" => "Tunisia",
		"TR" => "Turkey",
		"TM" => "Turkmenistan",
		"TC" => "Turks and Caicos Islands",
		"TV" => "Tuvalu",
		"UM" => "U.S. Minor Outlying Islands",
		"PU" => "U.S. Miscellaneous Pacific Islands",
		"VI" => "U.S. Virgin Islands",
		"UG" => "Uganda",
		"UA" => "Ukraine",
		"SU" => "Union of Soviet Socialist Republics",
		"AE" => "United Arab Emirates",
		"GB" => "United Kingdom",
		"US" => "United States",
		"ZZ" => "Unknown or Invalid Region",
		"UY" => "Uruguay",
		"UZ" => "Uzbekistan",
		"VU" => "Vanuatu",
		"VA" => "Vatican City",
		"VE" => "Venezuela",
		"VN" => "Vietnam",
		"WK" => "Wake Island",
		"WF" => "Wallis and Futuna",
		"EH" => "Western Sahara",
		"YE" => "Yemen",
		"ZM" => "Zambia",
		"ZW" => "Zimbabwe",
		"AX" => "Åland Islands",
	);
	
	return apply_filters('recurlywp_list_countries',$countries_list);
}

function recurlywp_get_currencies(){
	
	 $currencies_list = [
	    'AFN' => 'Afghan Afghani',
	    'ALL' => 'Albanian Lek',
	    'DZD' => 'Algerian Dinar',
	    'AOA' => 'Angolan Kwanza',
	    'ARS' => 'Argentine Peso',
	    'AMD' => 'Armenian Dram',
	    'AWG' => 'Aruban Florin',
	    'AUD' => 'Australian Dollar',
	    'AZN' => 'Azerbaijani Manat',
	    'BSD' => 'Bahamian Dollar',
	    'BDT' => 'Bangladeshi Taka',
	    'BBD' => 'Barbadian Dollar',
	    'BZD' => 'Belize Dollar',
	    'BMD' => 'Bermudian Dollar',
	    'BOB' => 'Bolivian Boliviano',
	    'BAM' => 'Bosnia & Herzegovina Convertible Mark',
	    'BWP' => 'Botswana Pula',
	    'BRL' => 'Brazilian Real',
	    'GBP' => 'British Pound',
	    'BND' => 'Brunei Dollar',
	    'BGN' => 'Bulgarian Lev',
	    'BIF' => 'Burundian Franc',
	    'KHR' => 'Cambodian Riel',
	    'CAD' => 'Canadian Dollar',
	    'CVE' => 'Cape Verdean Escudo',
	    'KYD' => 'Cayman Islands Dollar',
	    'XAF' => 'Central African Cfa Franc',
	    'XPF' => 'Cfp Franc',
	    'CLP' => 'Chilean Peso',
	    'CNY' => 'Chinese Renminbi Yuan',
	    'COP' => 'Colombian Peso',
	    'KMF' => 'Comorian Franc',
	    'CDF' => 'Congolese Franc',
	    'CRC' => 'Costa Rican Colón',
	    'HRK' => 'Croatian Kuna',
	    'CZK' => 'Czech Koruna',
	    'DKK' => 'Danish Krone',
	    'DJF' => 'Djiboutian Franc',
	    'DOP' => 'Dominican Peso',
	    'XCD' => 'East Caribbean Dollar',
	    'EGP' => 'Egyptian Pound',
	    'ETB' => 'Ethiopian Birr',
	    'EUR' => 'Euro',
	    'FKP' => 'Falkland Islands Pound',
	    'FJD' => 'Fijian Dollar',
	    'GMD' => 'Gambian Dalasi',
	    'GEL' => 'Georgian Lari',
	    'GIP' => 'Gibraltar Pound',
	    'GTQ' => 'Guatemalan Quetzal',
	    'GNF' => 'Guinean Franc',
	    'GYD' => 'Guyanese Dollar',
	    'HTG' => 'Haitian Gourde',
	    'HNL' => 'Honduran Lempira',
	    'HKD' => 'Hong Kong Dollar',
	    'HUF' => 'Hungarian Forint',
	    'ISK' => 'Icelandic Króna',
	    'INR' => 'Indian Rupee',
	    'IDR' => 'Indonesian Rupiah',
	    'ILS' => 'Israeli New Sheqel',
	    'JMD' => 'Jamaican Dollar',
	    'JPY' => 'Japanese Yen',
	    'KZT' => 'Kazakhstani Tenge',
	    'KES' => 'Kenyan Shilling',
	    'KGS' => 'Kyrgyzstani Som',
	    'LAK' => 'Lao Kip',
	    'LBP' => 'Lebanese Pound',
	    'LSL' => 'Lesotho Loti',
	    'LRD' => 'Liberian Dollar',
	    'MOP' => 'Macanese Pataca',
	    'MKD' => 'Macedonian Denar',
	    'MGA' => 'Malagasy Ariary',
	    'MWK' => 'Malawian Kwacha',
	    'MYR' => 'Malaysian Ringgit',
	    'MVR' => 'Maldivian Rufiyaa',
	    'MRO' => 'Mauritanian Ouguiya',
	    'MUR' => 'Mauritian Rupee',
	    'MXN' => 'Mexican Peso',
	    'MDL' => 'Moldovan Leu',
	    'MNT' => 'Mongolian Tögrög',
	    'MAD' => 'Moroccan Dirham',
	    'MZN' => 'Mozambican Metical',
	    'MMK' => 'Myanmar Kyat',
	    'NAD' => 'Namibian Dollar',
	    'NPR' => 'Nepalese Rupee',
	    'ANG' => 'Netherlands Antillean Gulden',
	    'TWD' => 'New Taiwan Dollar',
	    'NZD' => 'New Zealand Dollar',
	    'NIO' => 'Nicaraguan Córdoba',
	    'NGN' => 'Nigerian Naira',
	    'NOK' => 'Norwegian Krone',
	    'PKR' => 'Pakistani Rupee',
	    'PAB' => 'Panamanian Balboa',
	    'PGK' => 'Papua New Guinean Kina',
	    'PYG' => 'Paraguayan Guaraní',
	    'PEN' => 'Peruvian Nuevo Sol',
	    'PHP' => 'Philippine Peso',
	    'PLN' => 'Polish Złoty',
	    'QAR' => 'Qatari Riyal',
	    'RON' => 'Romanian Leu',
	    'RUB' => 'Russian Ruble',
	    'RWF' => 'Rwandan Franc',
	    'STD' => 'São Tomé and Príncipe Dobra',
	    'SHP' => 'Saint Helenian Pound',
	    'SVC' => 'Salvadoran Colón',
	    'WST' => 'Samoan Tala',
	    'SAR' => 'Saudi Riyal',
	    'RSD' => 'Serbian Dinar',
	    'SCR' => 'Seychellois Rupee',
	    'SLL' => 'Sierra Leonean Leone',
	    'SGD' => 'Singapore Dollar',
	    'SBD' => 'Solomon Islands Dollar',
	    'SOS' => 'Somali Shilling',
	    'ZAR' => 'South African Rand',
	    'KRW' => 'South Korean Won',
	    'LKR' => 'Sri Lankan Rupee',
	    'SRD' => 'Surinamese Dollar',
	    'SZL' => 'Swazi Lilangeni',
	    'SEK' => 'Swedish Krona',
	    'CHF' => 'Swiss Franc',
	    'TJS' => 'Tajikistani Somoni',
	    'TZS' => 'Tanzanian Shilling',
	    'THB' => 'Thai Baht',
	    'TOP' => 'Tongan Paʻanga',
	    'TTD' => 'Trinidad and Tobago Dollar',
	    'TRY' => 'Turkish Lira',
	    'UGX' => 'Ugandan Shilling',
	    'UAH' => 'Ukrainian Hryvnia',
	    'AED' => 'United Arab Emirates Dirham',
	    'USD' => 'United States Dollar',
	    'UYU' => 'Uruguayan Peso',
	    'UZS' => 'Uzbekistani Som',
	    'VUV' => 'Vanuatu Vatu',
	    'VND' => 'Vietnamese Đồng',
	    'XOF' => 'West African Cfa Franc',
	    'YER' => 'Yemeni Rial',
	    'ZMW' => 'Zambian Kwacha'
	];
	return apply_filters('recurlywp_list_currencies',$currencies_list);
}

function recurlywp_get_currency_symbol($currencyCode, $locale = 'en_US'){
    $formatter = new \NumberFormatter($locale . '@currency=' . $currencyCode, \NumberFormatter::CURRENCY);
    return $formatter->getSymbol(\NumberFormatter::CURRENCY_SYMBOL);
}


function recurly_get_all_plans(){

	$client = recurlywp_api_setup();
	$listplans = array();
	if($client){
		$options = [
		  'params' => [
		    'limit' => 200
		  ]
		];
		$plans = $client->listPlans($options);

		foreach($plans as $plan) {
		  $listplans[$plan->getCode()] = $plan->getName();
		}
	}

	return $listplans;
}

function recurlywp_take_to_checkout($atts){
	ob_start();
	$options = get_option('recurlywp');
	$style_data = "";
	if(!empty($atts['spacing'])){
		$spacing = explode("|", $atts['spacing']);
		$style_data .= "padding-top:".$spacing[0]."px;padding-bottom:".$spacing[1]."px;padding-left:".$spacing[2]."px;padding-right:".$spacing[3]."px;";
	}
	if(!empty($atts['background'])){
		$style_data .= "background:".$atts['background'].";";	
	}
	if(!empty($atts['color'])){
		$style_data .= "color:".$atts['color'].";";	
	}
	?>
	<a href="<?php echo get_permalink($options['checkout_page']); ?>?plan=<?php echo $atts['plan']; ?>" class="recurly_checkout_btn" style="<?php echo $style_data; ?>"><?php echo $atts['title']; ?></a>
	<?php
	return ob_get_clean();
}
add_shortcode('recurlywp_btn','recurlywp_take_to_checkout');

function recurlywp_update_popup(){
?>
  <div class="recurlywp-modal">
    <div class="recurlywp-modal-overlay recurlywp-modal-toggle"></div>
    <div class="recurlywp-modal-wrapper recurlywp-modal-transition">
      <div class="recurlywp-modal-header">
        <button class="recurlywp-modal-close recurlywp-modal-toggle">&times;</button>
        <h2 class="recurlywp-modal-heading">Update Subscription</h2>
      </div>
      
      <div class="recurlywp-modal-body">
        <div class="recurlywp-modal-content">
          <div class="update_subscription_iner">
          	<div class="update_subscription_block">
	       		<div id="response_recurly">
	       			
	       		</div>
          		<form class="update_subscription_form" id="update_recurly_form" action="" method="POST">
          			<input type="hidden" name="uuid" id="recurlywp-uuid" value="" />
          			<div class="recurlywp-form-group">
          				<label class="recurlywp-label">Change Quantity</label>
          				<input type="number" name="quantity" id="recurlywp-quantity" class="recurlywp-form-field" value="1">
          			</div>
          			<div class="recurlywp-form-group">
          				<input type="button" value="Update" id="update_recurly_sub" class="recurly-form-submit" />
          			</div>
          		</form>
          	</div>
          </div>
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
  </div>
<?php
}


function recurlywp_custom_checkout_redirect() {

	$options = get_option('recurlywp');

 	if(!is_user_logged_in()){
 		if(is_page($options['dashboard_page'])){
 			wp_redirect( get_permalink($options['login_page']) );
       		die;
       	}
 	}

 	if(!empty($options['restrict_access'])){

 		if(!is_user_logged_in()){

 			 if(is_page($options['checkout_page'])){
 				 wp_redirect( $options['redirect_url'] );
       		 	die;
       		}
 		}

 	}
 
}
add_action( 'template_redirect', 'recurlywp_custom_checkout_redirect' );

function recurlywp_get_plan_info($plan_id){
	$client = recurlywp_api_setup();
	if($client){
		try {
		    $plan = $client->getPlan("code-".$plan_id);
		    return $plan;
		} catch (\Recurly\Errors\NotFound $e) {
		    return 'Could not find resource.' . $e->getMessage();
		} catch (\Recurly\RecurlyError $e) {
		    return 'Some unexpected Recurly error happened. Try again later.' . PHP_EOL;
		}	
	}
}

function recurlywp_get_order_review($plan_info,$amount = 1){
	//* Order Review *//
	if(!empty($plan_info)){
	?>
	<div class="recurlywp-checkout-review-order order_review">
	   <h3 class="order_review_heading">Your order</h3>
	   <div class="checkout-review-order-table-wrapper">
	      <table class="recurlywp-checkout-review-order-table">
	         <thead>
	            <tr>
	               <th class="recurly-product-name">Product</th>
	               <th class="recurly-product-total">Subtotal</th>
	            </tr>
	         </thead>
	         <tbody>
	         	<?php
	         		$plan_prices = $plan_info->getCurrencies();
	            	foreach ($plan_prices as $singlecurrency) {
	           	?>
	            <tr class="cart_item">
	               <td class="recurly-product-name">
	                  <?php echo $plan_info->getName(); ?>	<strong class="product-quantity">×&nbsp;<?php echo $amount;  ?></strong>
	                  <span class="interval-length"><?php echo $plan_info->getIntervalLength(); ?> <?php echo $plan_info->getIntervalUnit(); ?></span>		
	               </td>
	               <td class="recurly-product-total">
	                  <span class="recurlywp-Price-amount amount"><bdi><span class="recurlywp-Price-currencySymbol"><?php echo recurlywp_get_currency_symbol($singlecurrency->getCurrency()); ?></span><?php echo apply_filters('recurlywp_price_format',number_format($singlecurrency->getUnitAmount(),2)); ?></bdi></span>
	               </td>
	            </tr>
	        	<?php } ?>
	         </tbody>
	         <tfoot>
	            <tr class="cart-subtotal">
	               <th>Subtotal</th>
	               <td><span class="recurlywp-Price-amount amount"><bdi><span class="recurlywp-Price-currencySymbol"><?php echo recurlywp_get_currency_symbol($singlecurrency->getCurrency()); ?></span><?php echo apply_filters('recurlywp_price_format',number_format($singlecurrency->getUnitAmount()*$amount,2)); ?></bdi></span></td>
	            </tr>
	            <tr class="order-total">
	               <th>Total</th>
	               <td><strong><span class="recurlywp-Price-amount amount"><bdi><span class="recurlywp-Price-currencySymbol"><?php echo recurlywp_get_currency_symbol($singlecurrency->getCurrency()); ?></span><?php echo apply_filters('recurlywp_price_format',number_format($singlecurrency->getUnitAmount()*$amount,2)); ?></bdi></span></strong> </td>
	            </tr>
	         </tfoot>
	      </table>
	   </div>
	</div>
	<?php
	}
}

function recurlywp_split_name($name) {
    $name = trim($name);
    $last_name = (strpos($name, ' ') === false) ? '' : preg_replace('#.*\s([\w-]*)$#', '$1', $name);
    $first_name = trim( preg_replace('#'.preg_quote($last_name,'#').'#', '', $name ) );
    return array("first_name"=>$first_name, "last_name"=>$last_name);
}

function recurlywp_fetch_account_billing($account_id){
	/* Recurly Account Info */
	$client = recurlywp_api_setup();
	try {
	    $binfo = $client->getBillingInfo("code-".$account_id);
	    return $binfo;
	} catch (\Recurly\Errors\NotFound $e) {
	    return $e->getMessage();
	} catch (\Recurly\RecurlyError $e) {
		return $e->getMessage();
	}

}

function recurlywp_apply_style_from_color(){
	$options = get_option('recurlywp');
	?>
	<?php if(!empty($options['accent_color']) && !empty($options['sec_color']) ) { ?>
		<!-- Recurly Styles -->
		<style type="text/css">
			.steps fieldset {
			    border-top-color: <?php echo $options['accent_color']; ?>;
			}	
			#progressbar li.active:before, #progressbar li.active:after {
			    background: <?php echo $options['accent_color']; ?>;
			    border-color: <?php echo $options['sec_color']; ?>;
			}
			#progressbar li:before {
			    color: <?php echo $options['accent_color']; ?>;
			    border-color: <?php echo $options['sec_color']; ?>;
			}	
			.steps .action-button, .action-button {
			    background: <?php echo $options['accent_color']; ?>;
			}
			span#pay_n_recurly {
			    background: <?php echo $options['accent_color']; ?> !important;
			}	
			.steps .action-button, .action-button {
			    background: <?php echo $options['accent_color']; ?>;
			}
			.steps .action-button:hover, .steps .action-button:focus, .action-button:hover, .action-button:focus {
			    background: <?php echo $options['sec_color']; ?>;
			}
			.recurlywp-input-container input#wp-submit {
			    background: <?php echo $options['accent_color']; ?>;
			}
		</style>
	<?php } ?>
	<?php
}
add_action('wp_head','recurlywp_apply_style_from_color');

/**
 * This always shows the current post status in the labels.
 *
 * @param array   $states current states.
 * @param WP_Post $post current post object.
 * @return array
 */
function custom_display_post_states( $states, $post ) {
	$options = get_option('recurlywp');
    
    if(!empty($options['checkout_page'])){
    	if($options['checkout_page'] == $post->ID){
    		$states[ 'recurlywp' ] = __('RecurlyWP Checkout','recurlywp');
    	}
    }
    if(!empty($options['dashboard_page'])){
    	if($options['dashboard_page'] == $post->ID){
    		$states[ 'recurlywp' ] = __('RecurlyWP Dashboard','recurlywp');
    	}
    }
    if(!empty($options['login_page'])){
    	if($options['login_page'] == $post->ID){
    		$states[ 'recurlywp' ] = __('RecurlyWP Login','recurlywp');
    	}
    }
    return $states;
}
 
add_filter( 'display_post_states', 'custom_display_post_states', 10, 2 );

function recurlywp_create_page($title_of_the_page,$content,$parent_id = NULL ){
    $objPage = get_page_by_title($title_of_the_page, 'OBJECT', 'page');
    if( ! empty( $objPage ) ){
        return $objPage->ID;
    }
    
    $page_id = wp_insert_post(
            array(
            'comment_status' => 'close',
            'ping_status'    => 'close',
            'post_author'    => 1,
            'post_title'     => ucwords($title_of_the_page),
            'post_name'      => strtolower(str_replace(' ', '-', trim($title_of_the_page))),
            'post_status'    => 'publish',
            'post_content'   => $content,
            'post_type'      => 'page',
            'post_parent'    =>  $parent_id //'id_of_the_parent_page_if_it_available'
            )
        );
    return $page_id;
}

