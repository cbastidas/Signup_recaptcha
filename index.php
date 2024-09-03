<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" lang="en-US">
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" lang="en-US">
<![endif]-->
<!--[if !(IE 7) & !(IE 8)]><!-->
<html lang="en-US">
<!--<![endif]-->
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no, minimal-ui">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<base href="https://signup.neataffiliates.com/"> 
	<title>Sign Up - NeatAffiliates</title>
	<link href="https://fonts.googleapis.com/css?family=Barlow:500,700&display=swap" rel="stylesheet">     

	<link rel="stylesheet" href="assets/css/style.css">
	<script src="assets/js/modernizr-3.6.0.min.js"></script>

	<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
	<script>window.jQuery || document.write('<script src="assets/js/jquery-3.3.1.min.js"><\/script>')</script>
	<script src="assets/js/plugins.js"></script>
	<script src="assets/js/bootstrap.min.js"></script>
	<script src="assets/js/scripts.js"></script>
	<script src="https://www.google.com/recaptcha/api.js?render=6LfxizQqAAAAAHkef_jZCxUzGL-guIH2DUI0HX_p"></script>

</head>
<?php

	$brand_group = (isset($_GET['brand_group']) && $_GET['brand_group'] != "")?$_GET['brand_group']:2;
	$brand_id = (isset($_GET['brand_id']) && $_GET['brand_id'] != "")?$_GET['brand_id']:"";

	$url = "https://www.neataffiliates.com/wp-json/commission-plugin/v1/get-brands/?brand_group=".$brand_group."&brand_id=".$brand_id;
	$ch = curl_init($url);

	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HEADER, false);

	// Execute the GET request
	$response = curl_exec($ch);

	// Check for errors
	if (curl_errno($ch)) {
		echo "Error: " . curl_error($ch);
	} else {
		// Process the response (assuming it's JSON)
		$brands = json_decode($response, true);
		$api_link = $brands[0]['api_link'];

		if (!is_array($brands)) {
			echo "There was an error, please try again or get in tounch with the administrator";
		}
	}

	// Close the cURL handle
	curl_close($ch);
?>
<body class="light-bg" >
    <?php include_once('./inc/header.php'); ?>
	<style>
		.signup--partner-field-container{
			align-items: center;
			display: flex;
			flex-wrap: nowrap;
			justify-content: center;
		}

		.signup--partner-field-container .signup--partner-label {
			font-size: 14px;
			width: 50%;
		}

		.signup--partner-input-container {
			width: 100%;
		}

		.reqStar{
			color: red;
		}

		.btn-signup{
			list-style: none;
			margin: 0;
			display: inline-block;
			text-align: center;
			font-weight: 700;
			color: #fff;
			text-decoration: none;
			cursor: pointer;
			box-sizing: border-box;
			width: 90%;
			border-radius: 100px;
			border: none;
			padding: 15px 20px;
			font-size: 18px;
			background: #6D00DC;
		}

		.hiddenPaymentMethod {
			display: none;
		}

		input[type="text"], input[type="password"], select, textarea{
			display: block;
			width: 100% !important;
			height: calc(2.25rem + 2px) !important;
			padding: 0.375rem 0.75rem;
			font-size: 1rem;
			font-family: inherit !important;
			line-height: 1.5 !important;
			color: #495057;
			background-color: #fff;
			background-clip: padding-box;
			border: 1px solid #ced4da;
			border-radius: 0.25rem;
			transition: border-color 0.15s ease-in-out,box-shadow 0.15s ease-in-out;
		}

		.signup--throne-logos{
			height: 40px;
		}

		@media (max-width: 768px) {
			.signup--partner-field-container{
				display: inline-block;
			}

			.signup--partner-field-container .signup--partner-label {
				width: 100%;
			}
		}
	</style>

	<section class="sub-center-content">
		<div class="container-fluid">
			<div class="title">
				<h1>Sign Up</h1>
				<p>Welcome to our affiliate program. Please complete the form below to signup.<br /> Fields marked with * must be completed.</p>

				<div class="row col-sm-11 col-md-10 col-xl-7 m-auto p-0 justify-content-center">
				<?php
					$brand_group = '';

					if ($brands) :
						foreach ($brands as $brand):
							$brand_group .= ',' . $brand['ma_brand_id'];
				?>
							<img class="m-2 signup--throne-logos" src="https://www.neataffiliates.com/wp-content/uploads/brands/logos/primary/<?php echo strtolower(str_replace(' ', '', $brand['name']))?>.png" alt="" />
				<?php
						endforeach;

						$brand_group = trim($brand_group, ',');
					endif;
				?>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-11 col-md-10 col-lg-9 m-auto p-5 signup-box">
					<form id="signup--register-form" action="post.php" method="POST" novalidate>
						<!--https://admin.throneneataffiliates.com -->
						<input type="hidden" name="api_link" value="<?= "https://admin.throneneataffiliates.com/feeds.php?FEED_ID=26"; ?>" />
						<div class="row">
							<div class="col-md-6 mb-5 signup--partner-field-container">
								<label class="signup--partner-label mr-3" for="email"><b><span class="reqStar">*</span> Login Username</b><br></br>(Without Spaces)</label>
								<div class="signup--partner-input-container">
									<input class="form-control " type="text" id="signup_username" name="PARAM_username" required />
									<!--Validation (Aug2024) -->
									<div id="errorUsername" class="invalid-feedback">Insert a Login Username</div>
									<div id="errorSpaces" class="invalid-feedback">Name shouldn't contain spaces</div>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-6 mb-5 signup--partner-field-container">
								<label class="signup--partner-label mr-3" for="email"><b><span class="reqStar">*</span> Email address</b></label>
								<div class="signup--partner-input-container">
									<input class="form-control" type="email" id="email" name="PARAM_email" autocomplete="username" required />
									<!--Validation (Aug2024) -->
									<div id="errorEmail" class="invalid-feedback">Insert a valid email Address</div>
								</div>
							</div>

							<div class="col-md-6 mb-5 signup--partner-field-container">
								<label class="signup--partner-label mr-3" for="password"><b><span class="reqStar">*</span> Login password</b></label>
								<div class="signup--partner-input-container">
									<input class="form-control" id="sign-up-password" type="password" name="PARAM_password" autocomplete="new-password" required />
									<!--Validation (Aug2024) -->
									<div id="errorPassword" class="invalid-feedback">
										Insert your password
									</div>

									<div id="errorPasswordPattern" class="invalid-feedback">
										Password should contain at least 6 characters, mixing Upper, Lower Case and numbers 
									</div>
								</div>
							</div>

							<div class="col-md-6 mb-5 signup--partner-field-container">
								<label class="signup--partner-label mr-3" for="passwordconf"><b><span class="reqStar">*</span> Confirm password</b></label>
								<div class="signup--partner-input-container">
									<input class="form-control" id="passwordconf" type="password" name="passwordconf" autocomplete="new-password" required />
									<!--Validation (Aug2024) -->
									<div id="errorPasswordMatch" class="invalid-feedback">
										Password must match
									</div>
								</div>
							</div>

							<div class="col-md-6 mb-5 signup--partner-field-container">
								<label class="signup--partner-label mr-3" for="country"><b><span class="reqStar">*</span> Country</b></label>
								<div class="signup--partner-input-container">
									<select class="form-select is-invalid" id="country" name="PARAM_country" required >
										<option value="default">Select a country</option>
										<option value="AF"> Afghanistan </option>
										<option value="AL"> Albania </option>
										<option value="DZ"> Algeria </option>
										<option value="AS"> American Samoa </option>
										<option value="AD"> Andorra </option>
										<option value="AO"> Angola </option>
										<option value="AI"> Anguilla </option>
										<option value="AQ"> Antarctica </option>
										<option value="AG"> Antigua and Barbuda </option>
										<option value="AR"> Argentina </option>
										<option value="AM"> Armenia </option>
										<option value="AW"> Aruba </option>
										<option value="AU"> Australia </option>
										<option value="AT"> Austria </option>
										<option value="AZ"> Azerbaijan </option>
										<option value="BS"> Bahamas </option>
										<option value="BH"> Bahrain </option>
										<option value="BD"> Bangladesh </option>
										<option value="BB"> Barbados </option>
										<option value="BY"> Belarus </option>
										<option value="BE"> Belgium </option>
										<option value="BZ"> Belize </option>
										<option value="BJ"> Benin </option>
										<option value="BM"> Bermuda </option>
										<option value="BT"> Bhutan </option>
										<option value="BO"> Bolivia (Plurinational State of) </option>
										<option value="BQ"> Bonaire, Sint Eustatius and Saba </option>
										<option value="BA"> Bosnia and Herzegovina </option>
										<option value="BW"> Botswana </option>
										<option value="BV"> Bouvet Island </option>
										<option value="BR"> Brazil </option>
										<option value="IO"> British Indian Ocean Territory </option>
										<option value="BN"> Brunei Darussalam </option>
										<option value="BG"> Bulgaria </option>
										<option value="BF"> Burkina Faso </option>
										<option value="BI"> Burundi </option>
										<option value="CV"> Cabo Verde </option>
										<option value="KH"> Cambodia </option>
										<option value="CM"> Cameroon </option>
										<option value="CA"> Canada </option>
										<option value="KY"> Cayman Islands </option>
										<option value="CF"> Central African Republic </option>
										<option value="TD"> Chad </option>
										<option value="CL"> Chile </option>
										<option value="CN"> China </option>
										<option value="CX"> Christmas Island </option>
										<option value="CC"> Cocos (Keeling) Islands </option>
										<option value="CO"> Colombia </option>
										<option value="KM"> Comoros </option>
										<option value="CG"> Congo </option>
										<option value="CD"> Congo (Democratic Republic of the) </option>
										<option value="CK"> Cook Islands </option>
										<option value="CR"> Costa Rica </option>
										<option value="HR"> Croatia </option>
										<option value="CU"> Cuba </option>
										<option value="CW"> Curaçao </option>
										<option value="CY"> Cyprus </option>
										<option value="CZ"> Czechia </option>
										<option value="CI"> Côte d'Ivoire </option>
										<option value="DK"> Denmark </option>
										<option value="DJ"> Djibouti </option>
										<option value="DM"> Dominica </option>
										<option value="DO"> Dominican Republic </option>
										<option value="EC"> Ecuador </option>
										<option value="EG"> Egypt </option>
										<option value="SV"> El Salvador </option>
										<option value="GQ"> Equatorial Guinea </option>
										<option value="ER"> Eritrea </option>
										<option value="EE"> Estonia </option>
										<option value="SZ"> Eswatini </option>
										<option value="ET"> Ethiopia </option>
										<option value="FK"> Falkland Islands (Malvinas) </option>
										<option value="FO"> Faroe Islands </option>
										<option value="FJ"> Fiji </option>
										<option value="FI"> Finland </option>
										<option value="FR"> France </option>
										<option value="GF"> French Guiana </option>
										<option value="PF"> French Polynesia </option>
										<option value="TF"> French Southern Territories </option>
										<option value="GA"> Gabon </option>
										<option value="GM"> Gambia </option>
										<option value="GE"> Georgia </option>
										<option value="DE"> Germany </option>
										<option value="GH"> Ghana </option>
										<option value="GI"> Gibraltar </option>
										<option value="GR"> Greece </option>
										<option value="GL"> Greenland </option>
										<option value="GD"> Grenada </option>
										<option value="GP"> Guadeloupe </option>
										<option value="GU"> Guam </option>
										<option value="GT"> Guatemala </option>
										<option value="GG"> Guernsey </option>
										<option value="GN"> Guinea </option>
										<option value="GW"> Guinea-Bissau </option>
										<option value="GY"> Guyana </option>
										<option value="HT"> Haiti </option>
										<option value="HM"> Heard Island and McDonald Islands </option>
										<option value="VA"> Holy See </option>
										<option value="HN"> Honduras </option>
										<option value="HK"> Hong Kong </option>
										<option value="HU"> Hungary </option>
										<option value="IS"> Iceland </option>
										<option value="IN"> India </option>
										<option value="ID"> Indonesia </option>
										<option value="IR"> Iran (Islamic Republic of) </option>
										<option value="IQ"> Iraq </option>
										<option value="IE"> Ireland </option>
										<option value="IM"> Isle of Man </option>
										<option value="IL"> Israel </option>
										<option value="IT"> Italy </option>
										<option value="JM"> Jamaica </option>
										<option value="JP"> Japan </option>
										<option value="JE"> Jersey </option>
										<option value="JO"> Jordan </option>
										<option value="KZ"> Kazakhstan </option>
										<option value="KE"> Kenya </option>
										<option value="KI"> Kiribati </option>
										<option value="KP"> Korea (Democratic People's Republic of) </option>
										<option value="KR"> Korea (Republic of) </option>
										<option value="KW"> Kuwait </option>
										<option value="KG"> Kyrgyzstan </option>
										<option value="LA"> Lao People's Democratic Republic </option>
										<option value="LV"> Latvia </option>
										<option value="LB"> Lebanon </option>
										<option value="LS"> Lesotho </option>
										<option value="LR"> Liberia </option>
										<option value="LY"> Libya </option>
										<option value="LI"> Liechtenstein </option>
										<option value="LT"> Lithuania </option>
										<option value="LU"> Luxembourg </option>
										<option value="MO"> Macao </option>
										<option value="MG"> Madagascar </option>
										<option value="MW"> Malawi </option>
										<option value="MY"> Malaysia </option>
										<option value="MV"> Maldives </option>
										<option value="ML"> Mali </option>
										<option value="MT"> Malta </option>
										<option value="MH"> Marshall Islands </option>
										<option value="MQ"> Martinique </option>
										<option value="MR"> Mauritania </option>
										<option value="MU"> Mauritius </option>
										<option value="YT"> Mayotte </option>
										<option value="MX"> Mexico </option>
										<option value="FM"> Micronesia (Federated States of) </option>
										<option value="MD"> Moldova (Republic of) </option>
										<option value="MC"> Monaco </option>
										<option value="MN"> Mongolia </option>
										<option value="ME"> Montenegro </option>
										<option value="MS"> Montserrat </option>
										<option value="MA"> Morocco </option>
										<option value="MZ"> Mozambique </option>
										<option value="MM"> Myanmar </option>
										<option value="NA"> Namibia </option>
										<option value="NR"> Nauru </option>
										<option value="NP"> Nepal </option>
										<option value="NL"> Netherlands </option>
										<option value="AN"> Netherlands Antilles </option>
										<option value="NC"> New Caledonia </option>
										<option value="NZ"> New Zealand </option>
										<option value="NI"> Nicaragua </option>
										<option value="NE"> Niger </option>
										<option value="NG"> Nigeria </option>
										<option value="NU"> Niue </option>
										<option value="NF"> Norfolk Island </option>
										<option value="MK"> North Macedonia </option>
										<option value="MP"> Northern Mariana Islands </option>
										<option value="NO"> Norway </option>
										<option value="OM"> Oman </option>
										<option value="PK"> Pakistan </option>
										<option value="PW"> Palau </option>
										<option value="PS"> Palestine, State of </option>
										<option value="PA"> Panama </option>
										<option value="PG"> Papua New Guinea </option>
										<option value="PY"> Paraguay </option>
										<option value="PE"> Peru </option>
										<option value="PH"> Philippines </option>
										<option value="PN"> Pitcairn </option>
										<option value="PL"> Poland </option>
										<option value="PT"> Portugal </option>
										<option value="PR"> Puerto Rico </option>
										<option value="QA"> Qatar </option>
										<option value="RO"> Romania </option>
										<option value="RU"> Russian Federation </option>
										<option value="RW"> Rwanda </option>
										<option value="RE"> Réunion </option>
										<option value="BL"> Saint Barthélemy </option>
										<option value="SH"> Saint Helena, Ascension and Tristan da Cunha </option>
										<option value="KN"> Saint Kitts and Nevis </option>
										<option value="LC"> Saint Lucia </option>
										<option value="MF"> Saint Martin (French part) </option>
										<option value="PM"> Saint Pierre and Miquelon </option>
										<option value="VC"> Saint Vincent and the Grenadines </option>
										<option value="WS"> Samoa </option>
										<option value="SM"> San Marino </option>
										<option value="ST"> Sao Tome and Principe </option>
										<option value="SA"> Saudi Arabia </option>
										<option value="SN"> Senegal </option>
										<option value="RS"> Serbia </option>
										<option value="SC"> Seychelles </option>
										<option value="SL"> Sierra Leone </option>
										<option value="SG"> Singapore </option>
										<option value="SX"> Sint Maarten (Dutch part) </option>
										<option value="SK"> Slovakia </option>
										<option value="SI"> Slovenia </option>
										<option value="SB"> Solomon Islands </option>
										<option value="SO"> Somalia </option>
										<option value="ZA"> South Africa </option>
										<option value="GS"> South Georgia and the South Sandwich Islands </option>
										<option value="SS"> South Sudan </option>
										<option value="ES"> Spain </option>
										<option value="LK"> Sri Lanka </option>
										<option value="SD"> Sudan </option>
										<option value="SR"> Suriname </option>
										<option value="SJ"> Svalbard and Jan Mayen </option>
										<option value="SE"> Sweden </option>
										<option value="CH"> Switzerland </option>
										<option value="SY"> Syrian Arab Republic </option>
										<option value="TW"> Taiwan (Province of China) </option>
										<option value="TJ"> Tajikistan </option>
										<option value="TZ"> Tanzania, United Republic of </option>
										<option value="TH"> Thailand </option>
										<option value="TL"> Timor-Leste </option>
										<option value="TG"> Togo </option>
										<option value="TK"> Tokelau </option>
										<option value="TO"> Tonga </option>
										<option value="TT"> Trinidad and Tobago </option>
										<option value="TN"> Tunisia </option>
										<option value="TR"> Turkey </option>
										<option value="TM"> Turkmenistan </option>
										<option value="TC"> Turks and Caicos Islands </option>
										<option value="TV"> Tuvalu </option>
										<option value="UG"> Uganda </option>
										<option value="UA"> Ukraine </option>
										<option value="AE"> United Arab Emirates </option>
										<option value="GB"> United Kingdom of Great Britain and Northern Ireland </option>
										<option value="UM"> United States Minor Outlying Islands </option>
										<option value="US"> United States of America </option>
										<option value="UY"> Uruguay </option>
										<option value="UZ"> Uzbekistan </option>
										<option value="VU"> Vanuatu </option>
										<option value="VE"> Venezuela (Bolivarian Republic of) </option>
										<option value="VN"> Viet Nam </option>
										<option value="VG"> Virgin Islands (British) </option>
										<option value="VI"> Virgin Islands (U.S.) </option>
										<option value="WF"> Wallis and Futuna </option>
										<option value="EH"> Western Sahara </option>
										<option value="YE"> Yemen </option>
										<option value="ZM"> Zambia </option>
										<option value="ZW"> Zimbabwe </option>
										<option value="AX"> Åland Islands </option>
									</select>
									<div id="emptyCountry" class="invalid-feedback">You must select a Country</div>
									<br></br>
								</div>
							</div>

							

							<div class="col-md-8 mb-5 signup--partner-field-container">
								<label class="signup--partner-label mr-3 ">
									<b>Email mailout subscription</b><br />
									<small>Send me newsletters and promotional emails.</small>
								</label>
								<br>
								<input class="form-control" id="email_unsubscribed" type="checkbox" name="PARAM_email_unsubscribed[]" value="0">
								<label class="signup--partner-label mr-3" for="email_unsubscribed">Subscribed</label>
							</div>
						</div>

						<div class="row">
							<div class="col-12">
								<hr />
							</div>
						</div>

						<div class="row">
							<div class="col-md-6 mb-5 signup--partner-field-container">
								<label class="signup--partner-label mr-3" for="first_name"><b><span class="reqStar">*</span> First Name</b></label>
								<div class="signup--partner-input-container">
									<input class="form-control" type="text" id="first_name" name="PARAM_first_name" required />
									<!--Validation (Aug2024) -->
									<div id="errorFirstName" class="invalid-feedback">Insert your First Name</div>
								</div>
							</div>

							<div class="col-md-6 mb-5 signup--partner-field-container">
								<label class="signup--partner-label mr-3" for="last_name"><b><span class="reqStar">*</span> Last Name</b></label>
								<div class="signup--partner-input-container">
									<input class="form-control" type="text" id="last_name" name="PARAM_last_name" required />
									<!--Validation (Aug2024) -->
									<div id="errorLastName" class="invalid-feedback">Insert your Last Name</div>
								</div>
							</div>

							<div class="col-md-6 mb-5 signup--partner-field-container">
								<label class="signup--partner-label mr-3" for="date_of_birth"><b><span class="reqStar">*</span>Date of birth</b></label>
								<div class="signup--partner-input-container">
									<input class="form-control" type="text" id="date_of_birth" placeholder="YYYY-MM-DD" name="PARAM_date_of_birth" required/>
									<div id="errorDateofBirth" class="invalid-feedback">Insert Date of Birth</div>
								</div>
							</div>

							<div class="col-md-6 mb-5 signup--partner-field-container">
								<label class="signup--partner-label mr-3" for="skype_aim"><b><span class="reqStar">*</span> Skype</b></label>
								<div class="signup--partner-input-container">
									<input class="form-control" type="text" id="skype_aim" name="PARAM_skype_aim" required />
									<!--Validation (Aug2024) -->
									<div id="errorSkype" class="invalid-feedback">Insert a valid Skype Account</div>
								</div>
							</div>

							<div class="col-md-6 mb-5 signup--partner-field-container">
								<label class="signup--partner-label mr-3" for="address"><b>Address</b></label>
								<div class="signup--partner-input-container">
									<input class="form-control" type="text" id="address" name="PARAM_address"/>
									<div class="invalid-feedback"></div>
								</div>
							</div>

							<div class="col-md-6 mb-5 signup--partner-field-container">
								<label class="signup--partner-label mr-3" for="city"><b>City</b></label>
								<div class="signup--partner-input-container">
									<input class="form-control" type="text" id="city" name="PARAM_city" />
									<div class="invalid-feedback"></div>
								</div>
							</div>

							<div class="col-md-6 mb-5 signup--partner-field-container">
								<label class="signup--partner-label mr-3" for="postcode"><b>Zip Code</b></label>
								<div class="signup--partner-input-container">
									<input class="form-control" type="text" id="postcode" name="PARAM_postcode" />
									<div class="invalid-feedback"></div>
								</div>
							</div>

							<div class="col-md-6 mb-5 signup--partner-field-container">
								<label class="signup--partner-label mr-3" for="company"><b>Company Name</b></label>
								<div class="signup--partner-input-container">
									<input class="form-control" type="text" id="company" name="PARAM_company"/>
								</div>
							</div>

							<div class="col-md-6 mb-5 signup--partner-field-container">
								<label class="signup--partner-label mr-3" for="mobile"><b><span class="reqStar">*</span> Mobile Number </b></label>
								<div class="signup--partner-input-container">
									<input class="form-control" type="text" id="mobile" name="PARAM_mobile" required />
									<!--Validation (Aug2024) -->
									<div id="errorMobileNumber" class="invalid-feedback">Insert a valid Mobile number</div>
								</div>
							</div>

							<div class="col-md-6 mb-5 signup--partner-field-container">
								<label class="signup--partner-label mr-3" for="website">
									<span class="reqStar font-size: 20px" >*</span>
									<b>Site URL</b>
								</label>
								<div class="signup--partner-input-container">
									<input class="form-control" type="text" id="website" name="PARAM_website" placeholder="www.example.com" required />
									<!--Validation (Aug2024) -->
									<div id="errorUrl" class="invalid-feedback">Insert a valid URL</div>
								</div>
							</div>

							<input type="hidden" name="PARAM_plans" value="<?php echo htmlspecialchars($brand_group); ?>" />
						</div>

						<div class="row">
							<div class="col-12">
								<hr />
							</div>
						</div>

						<div class="row">
							<div class="col-12 col-sm-6">
								<p>
									<span class="reqStar">*</span> 
									<b>Terms &amp; Conditions</b>
									<br />
									<small>
										Please read the 
										<a href="https://www.neataffiliates.com/throne-terms-of-use/" target="_blank">Terms &amp; Conditions</a> before agreeing. 
									</small>
								</p>

								<div class="form-group">
									<label class="signup--partner-label mr-3" for="termsagreement">
										<input id="termsagreement" class="form-control" type="checkbox" name="PARAM_termsagreement" value="1" required /> I agree to the terms and conditions 
										<!--Validation (Aug2024) -->
										<div id="errorTerms" class="invalid-feedback">Must agree with Terms and Conditions</div>
									</label>
								</div>
							</div>
							
							<div class="col-12 col-sm-6">
							<input type="hidden" name="recaptcha_response" id="recaptchaResponse">
							</div>
							<div class="col-12 col-sm-6">
								<button type="submit" class="btn-signup">Sign up</button>
							</div>

						</div>

						
					</form>

				</div>
			</div>
		</div>
	</section>

	<script>
		grecaptcha.ready(function() {
    	grecaptcha.execute('6LfxizQqAAAAAHkef_jZCxUzGL-guIH2DUI0HX_p', {action: 'submit'}).then(function(token) {
        document.getElementById('recaptchaResponse').value = token;
    		});
		});

		(function ($) {
			$(document).ready(function () {
				let previousSelectedPayment = 0;

				$('.signup--payment-option').on('change', function () {
					if (previousSelectedPayment !== this.value) {
						$(`#paymentFields${previousSelectedPayment}`).addClass('hiddenPaymentMethod');
					}

					if (previousSelectedPayment === 0) {
						previousSelectedPayment = this.value;
					}

					$(`#paymentFields${this.value}`).removeClass('hiddenPaymentMethod');
					addRequiredAttribute(`#paymentFields${previousSelectedPayment}`, `#paymentFields${this.value}`);
					previousSelectedPayment = this.value;
				});

				$('#signup--register-form').submit(function (event) {
					event.preventDefault();
					event.stopPropagation();

					//VALIDATIONS OF THE FORM
					//.........................
					//Username Validation
					var loginSelect = document.getElementById('signup_username').value.trim();
					var errorLoginMessage = document.getElementById('errorUsername');
					var errorSpacesMessage = document.getElementById('errorSpaces');
					
					errorLoginMessage.style.display  = 'none';
					errorSpacesMessage.style.display  = 'none';

					if (loginSelect === ''){
						event.preventDefault();	
						window.scrollTo(0, 0);
						errorLoginMessage.style.display  = 'block';
						errorSpacesMessage.style.display  = 'none';
					}

					else {
						errorLoginMessage.style.display  = 'none';

						if (loginSelect.indexOf(' ') !== -1){
							event.preventDefault();	
							window.scrollTo(0, 0);
							errorSpacesMessage.style.display  = 'block';
						}
						else {
							errorSpacesMessage.style.display  = 'none';
						}
					}

					//here finish the Username Validation
					
					//..........................
					//email Validation
					var emailSelect = document.getElementById('email');
					var errorEmailMessage = document.getElementById('errorEmail');
					if(emailSelect.value.trim() === ''){
					   event.preventDefault();	
					   window.scrollTo(0, 0);
					   errorEmailMessage.style.display  = 'block';
					}

					else {
						errorEmailMessage.style.display  = 'none';
					}
					//Here finish the email Validation
					

					//..........................
					//password validation
					let passwordSelect = document.getElementById('sign-up-password');
					let errorPasswordMessage = document.getElementById('errorPassword');
					let passwordPatternError = document.getElementById('errorPasswordPattern');
					let passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{6,}$/;
					errorPasswordMessage.style.display = 'none';
					passwordPatternError.style.display = 'none';

					if(passwordSelect.value.trim() === ''){
						event.preventDefault();
						window.scrollTo(0, 0);
						errorPasswordMessage.style.display  = 'block';
						passwordPatternError.style.display = 'none';
					}

					else {
						errorPasswordMessage.style.display  = 'none';
						
						if (!passwordPattern.test(passwordSelect.value)) {
							event.preventDefault();
							passwordPatternError.style.display = 'block';
							errorPasswordMessage.style.display  = 'none';
							window.scrollTo(0, 0);
							return false;
						}
						else {
							passwordPatternError.style.display = 'none';
							errorPasswordMessage.style.display = 'none';
							//return true;
						}
					}

					//Here finish the password validation

					//..........................
					//passwordMatch validation
					var passwordMatchSelect = document.getElementById('passwordconf');
					var errorpasswordMatchMessage = document.getElementById('errorPasswordMatch');

					if(passwordMatchSelect.value.trim() === ''){
						event.preventDefault();
						window.scrollTo(0, 0);
						errorpasswordMatchMessage.style.display  = 'block';
					}
					
					else if (passwordSelect.value !== passwordMatchSelect.value){
						event.preventDefault();
						window.scrollTo(0, 0);
						errorpasswordMatchMessage.style.display = 'block';
					}
					else {
						errorpasswordMatchMessage.style.display  = 'none';
					}
					//Here finish the passwordMatch validation

					//PasswordMatching Confirmation Validation
					if (passwordSelect !== '' && passwordMatchSelect !== '' && !passwordsMatch()){
							event.preventDefault();
							window.scrollTo(0, 0);
							errorpasswordMatchMessage.style.display  = 'block';
						}
						else {
							errorpasswordMatchMessage.style.display  = 'none';
						}
					//Here finish the passwordMatching Confirmation Validation
					
					//..........................
					//Country Selection Validation
					var countrySelect = document.getElementById('country');
					var errorCountryMessage = document.getElementById('emptyCountry');

					if(countrySelect.value === 'default') {
						event.preventDefault();
						window.scrollTo(0, 0);
						errorCountryMessage.style.display = 'block';
					}
					else {
						errorCountryMessage.style.display = 'none';
					}
					//here finish the Country Selection Validation

					//..........................
					//First Name Validation
					var firstNameSelect = document.getElementById('first_name');
					var errorFirstNameMessage = document.getElementById('errorFirstName');
					if(firstNameSelect.value.trim() === ''){
						event.preventDefault();
						window.scrollTo(0, 0);
						errorFirstNameMessage.style.display  = 'block';
					}

					else {
						errorFirstNameMessage.style.display  = 'none';
					}
					//Here finish the First Name validation

					//..........................
					//Last Name Validation
					var lastNameSelect = document.getElementById('last_name');
					var errorLastNameMessage = document.getElementById('errorLastName');
					if(lastNameSelect.value.trim() === ''){
						event.preventDefault();
						window.scrollTo(0, 0);
						errorLastNameMessage.style.display  = 'block';
					}

					else {
						errorLastNameMessage.style.display  = 'none';
					}
					//Here finish the Last Name validation
					
					//Date of Birth Validation
					var dateofBirth = document.getElementById('date_of_birth');
					var errorDateofBirthMessage = document.getElementById('errorDateofBirth');
					if (dateofBirth.value.trim() === ''){
						event.preventDefault();
						window.scrollTo(0, 0);
						errorDateofBirthMessage.style.display = 'block';
					}
					else {
						errorDateofBirthMessage.style.display = 'none';
					}
					//Here finish the Date of Birth Validation

					//..........................
					//skype Validation
					var skypeSelect = document.getElementById('skype_aim');
					var errorSkypeMessage = document.getElementById('errorSkype');
					if(skypeSelect.value.trim() === ''){
						event.preventDefault();
						window.scrollTo(0, 0);
						errorSkypeMessage.style.display  = 'block';
					}

					else {
						errorSkypeMessage.style.display  = 'none';
					}
					//Here finish the skype validation

					//..........................
					//mobile number Validation
					var mobileNumberSelect = document.getElementById('mobile');
					var errorMobileNumberMessage = document.getElementById('errorMobileNumber');
					if(mobileNumberSelect.value.trim() === ''){
						event.preventDefault();
						window.scrollTo(0, 0);
						errorMobileNumberMessage.style.display  = 'block';
					}

					else {
						errorMobileNumberMessage.style.display  = 'none';
					}
					//Here finish the mobile number validation

					//..........................
					//site URL Validation
					var urlSelect = document.getElementById('website');
					var errorUrlMessage = document.getElementById('errorUrl');
					if(urlSelect.value.trim() === ''){
						event.preventDefault();
						window.scrollTo(0, 0);
						errorUrlMessage.style.display  = 'block';
					}

					else {
						errorUrlMessage.style.display  = 'none';
					}
					//Here finish the site URL validation

					//..........................
					//Terms and Conditions Validation
					var termsSelect = document.getElementById('termsagreement');
					var errorTermsMessage = document.getElementById('errorTerms');
					if(!termsSelect.checked){
						event.preventDefault();
						window.scrollTo(0, 0);
						errorTermsMessage.style.display  = 'block';
					}

					else {
						errorTermsMessage.style.display  = 'none';
					}
					//Here finish the Terms and Conditions Validation
				

					//Here to validate Password Matching and the Validity of the Data
					if (this.checkValidity() && passwordsMatch()) {
						let formData = {};

						// Loop through form elements and add to formData
						$(this).find(':input').each(function () {
							if (this.name && this.value) {
								formData[this.name] = this.value;
							}
						});

						let validated = validateFormat(formData);
						//let validated = true;

						
						if (validated) {
							//This takes the endpoint from the post.php and makes a POST request
							let url = '/proxy/post.php';
							//let url = 'feeds.php?FEED_ID=26';
							//let url = 'https://admin.throneneataffiliates.com/feeds.php?FEED_ID=26';
							//let url = '/netrefer-api/proxy/post.php';
							console.log(formData);
							$.ajax({
						    type: 'POST',
						    dataType: 'JSON',
						    data: formData,
						    url: url,
						    contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
						    success: function(response) {
						        console.log(response);
								$('#signup--register-form').find('.alert').remove(); // Delete the previous messages
    							$('#signup--register-form').find('.is-invalid').removeClass('is-invalid'); // Delete the validation classes
							
						        if (response.success) {
						            $('#message').text('Your signup was successful');
								
						            // Clear form inputs
						            $('#signup--register-form').find(':input').val('');
								
						            // Remove validation classes
						            $('#signup--register-form').removeClass('was-validated');
						            $('#signup--register-form').find('.is-invalid').removeClass('is-invalid');
								
						            // Display success message
						            $('#signup--register-form').prepend('<div class="alert alert-success text-center">Thank you! Your Signup Was Successful!</div>');
						            window.scrollTo(0, 0);
								
						            // Optionally redirect after success
						            // setTimeout(function() {
						            //     window.location.href = 'https://thrnaffpanel.thrnaffcdn.com/signin.php';
						            // }, 2000);
								
						        } else {
						            // Clear previous error messages
						           //$('#signup--register-form').find('.alert').remove();
									let parser = new DOMParser();
							        let xmlDoc = parser.parseFromString(response.message, "text/xml");

							        // Obtener los errores del XML
							        let errors = xmlDoc.getElementsByTagName("ERROR");

							        // Generar mensajes de error y asignarlos a los campos
							        for (let i = 0; i < errors.length; i++) {
							            let detail = errors[i].getAttribute("DETAIL");
							            let msg = errors[i].getElementsByTagName("MSG")[0].textContent;
										let field = $(`[name="${detail}"]`);
            							if (field.length > 0) {
            							    // Mostrar el mensaje de error al lado del campo correspondiente
            							    field.addClass('is-invalid');
            							    field.next('.invalid-feedback').text(msg);
            							} else {
            							    // Si el campo no existe, mostrar un mensaje general
            							    console.warn(`El campo con nombre "${detail}" no se encontró en el formulario.`);
            							    $('#signup--register-form').prepend(`<div class="alert alert-danger">${msg}</div>`);
            							}
							        }
							        // Desplazar hacia arriba para que el usuario vea los mensajes
							        window.scrollTo(0, 0);
							    }
							},

						            // Display general error message
						           //if (response.error_code == 400) {
						           //    $('#signup--register-form').prepend('<div class="alert alert-failed text-center">'+ response.message + '</div>');
						           //} else {
									//	window.scrollTo(0, 0);
									//	
									//

						           //    //for (const key in errorMessages) {
									//	//	let errorMessage = errorMessages[key];
						           //    //    errorList += '<li>${errorMessage}</li>';
									//	//
						           //    //    // Highlight the input field with error
						           //    //    $(`[name="${key}"]`).addClass('is-invalid');
									//	//
						           //    //    // Display error message next to the input field
						           //    //    $(`[name="${key}"]`).next('.invalid-feedback').text(errorMessage);
						           //    //}
									//	//errorList += '</ul>';
            						//	$('#signup--register-form').prepend(`<div class="alert alert-danger">${errorList}</div>`);
						           //}
									//$('#signup--register-form').prepend(`<div class="alert alert-failed alert-danger">${errorMessageHTML}</div>`);
						           //window.scrollTo(0, 0);
						    error: function() {
						        $('#signup--register-form').prepend('<div class="alert alert-failed alert-danger text-center">An unexpected error occurred. Please try again later.</div>');
								window.scrollTo(0, 0);
						    }
						});//ajax

						} //Validated
					} // checkvalidity
					else { //Else Validated
						// Add 'was-validated' class to the form
						$(this).addClass('was-validated');
						event.preventDefault();
						// Highlight incorrect inputs with 'is-invalid' class
						$(this).find(':invalid').addClass('is-invalid');
					}// else validated
				}); //signup register form

				/**
				 * Validate that the passwords match
				 */
				function passwordsMatch() {
					var passwordValidation = $('#sign-up-password').val();
					var confirmPassword = $('#passwordconf').val();
					return passwordValidation === confirmPassword;
				}
			
				/**
				 * Validate the input format based on API regex
				 * */
				function validateFormat(data) {
					// Regular expressions
					let regexPatterns = {
						PARAM_address: {
							pattern: /^.{3,255}$/m,
							message: 'A valid address is required'
						},
						PARAM_city: {
							pattern: /^[\sa-zA-Z0-9.-]{2,49}$/,
							message: 'A valid city is required'
						},
						PARAM_company: {
							pattern: /^[\sa-zA-Z0-9.-]{2,49}$/,
							message: 'A valid company is required'
						},
						PARAM_date_of_birth: {
							pattern: /^[a-zA-Z0-9\/ \-\.@,]{6,49}$/,
							message: 'A valid date of birth is required'
						},
						PARAM_first_name: {
							pattern: /^[a-zA-Z]{2,49}$/,
							message: 'A valid first name is required'
						},
						PARAM_last_name: {
							pattern: /^[a-zA-Z]{2,49}$/,
							message: 'A valid surname is required'
						},
						PARAM_mobile: {
							pattern: /^[0-9x# +()-]{2,50}$/,
							message: 'A valid mobile phone is required'
						},
						PARAM_skype_aim: {
							pattern: /^[a-zA-Z0-9 @,._-]{2,49}$/,
							message: 'A valid skype username is required'
						},
						PARAM_termsagreement: {
							pattern: /^1$/,
							message: 'Please accept terms and conditions'
						},
						PARAM_website: {
							pattern: /^[\sa-zA-Z0-9.-]{2,49}$/,
							message: 'Use a valid URL',
							required: false
						},
						PARAM_postcode: {
							pattern: /^[a-zA-Z0-9, \/\.-]{2,49}$/,
							message: 'A valid postal code is required'
						},
					};

					// Validate data against regex patterns
					let validationSuccess = true;

					for (const key in regexPatterns) {
						$(`[name="${key}"]`).removeClass('is-invalid');

						if (regexPatterns.hasOwnProperty(key)) {
							const regex = regexPatterns[key].pattern;
							let validationResult = regex.test(data[key]);

							if (!validationResult) {
								validationSuccess = false;
								$(`[name="${key}"]`).addClass('is-invalid');
								let errorMsg = regexPatterns[key].message;
								$(`[name="${key}"]`).next('.invalid-feedback').text(errorMsg);
							}
						}
					}

					return validationSuccess;
				}
				/*
				 Add the required attribute dynamically to each text area on the payments section
				 */
				function addRequiredAttribute(removeAttrID, addAttrID) {
					let textareaNotRequiredFields = document.querySelectorAll(`${removeAttrID} textarea`);
					textareaNotRequiredFields.forEach(function (textarea) {
						textarea.removeAttribute("required");
					});

					let textareaRequiredFields = document.querySelectorAll(`${addAttrID} textarea:not(.signup--payment-field-not-required)`);
					textareaRequiredFields.forEach(function (textarea) {
						textarea.setAttribute('required', "");
					});
				}
			});
		})(jQuery);
		
	
	</script>
	<?php include_once('./inc/footer.php'); ?>
</body>
</html>
