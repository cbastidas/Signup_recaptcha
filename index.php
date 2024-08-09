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
	<base href="http://localhost/netrefer-api/">
	<title>Sign Up - NeatAffiliates</title>
	<link href="https://fonts.googleapis.com/css?family=Barlow:500,700&display=swap" rel="stylesheet">     

	<link rel="stylesheet" href="assets/css/style.css">
	<script src="assets/js/modernizr-3.6.0.min.js"></script>

	<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
	<script>window.jQuery || document.write('<script src="assets/js/jquery-3.3.1.min.js"><\/script>')</script>
	<script src="assets/js/plugins.js"></script>
	<script src="assets/js/bootstrap.min.js"></script>
	<script src="assets/js/scripts.js"></script>
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
					<form id="signup--register-form" novalidate>
						<input type="hidden" name="api_link" value="<?= $api_link; ?>" />
						<div class="row">
							<div class="col-md-6 mb-5 signup--partner-field-container">
								<label class="signup--partner-label mr-3" for="email"><b><span class="reqStar">*</span> Login Username</b></label>
								<div class="signup--partner-input-container">
									<input class="form-control" type="text" id="signup_username" name="PARAM_username" required />
									<div class="invalid-feedback"></div>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-6 mb-5 signup--partner-field-container">
								<label class="signup--partner-label mr-3" for="email"><b><span class="reqStar">*</span> Email address</b></label>
								<div class="signup--partner-input-container">
									<input class="form-control" type="email" id="email" name="PARAM_email" required />
									<div class="invalid-feedback"></div>
								</div>
							</div>

							<div class="col-md-6 mb-5 signup--partner-field-container">
								<label class="signup--partner-label mr-3" for="password"><b><span class="reqStar">*</span> Login password</b></label>
								<div class="signup--partner-input-container">
									<input class="form-control" id="sign-up-password" type="password" name="PARAM_password" autocomplete="new-password" required />
									<div class="invalid-feedback">
										The password must match.
									</div>
								</div>
							</div>

							<div class="col-md-6 mb-5 signup--partner-field-container">
								<label class="signup--partner-label mr-3" for="passwordconf"><b><span class="reqStar">*</span> Confirm password</b></label>
								<div class="signup--partner-input-container">
									<input class="form-control" id="passwordconf" type="password" name="passwordconf" autocomplete="new-password" required />
								</div>
							</div>

							<div class="col-md-6 mb-5 signup--partner-field-container">
								<label class="signup--partner-label mr-3" for="country"><b><span class="reqStar">*</span> Country</b></label>
								<div class="signup--partner-input-container">
									<select class="form-select" id="country" name="PARAM_country" required>
										<option value="">Select one</option>
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
									<div class="invalid-feedback"></div>
								</div>
							</div>

							<div class="col-md-8 mb-5 signup--partner-field-container">
								<label class="signup--partner-label mr-3">
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
									<div class="invalid-feedback"></div>
								</div>
							</div>

							<div class="col-md-6 mb-5 signup--partner-field-container">
								<label class="signup--partner-label mr-3" for="last_name"><b><span class="reqStar">*</span> Last Name</b></label>
								<div class="signup--partner-input-container">
									<input class="form-control" type="text" id="last_name" name="PARAM_last_name" required />
									<div class="invalid-feedback"></div>
								</div>
							</div>

							<div class="col-md-6 mb-5 signup--partner-field-container">
								<label class="signup--partner-label mr-3" for="date_of_birth"><b>Date of birth</b></label>
								<div class="signup--partner-input-container">
									<input class="form-control" type="text" id="date_of_birth" placeholder="YYYY-MM-DD" name="PARAM_date_of_birth" />
									<div class="invalid-feedback"></div>
								</div>
							</div>

							<div class="col-md-6 mb-5 signup--partner-field-container">
								<label class="signup--partner-label mr-3" for="skype_aim"><b><span class="reqStar">*</span> Skype</b></label>
								<div class="signup--partner-input-container">
									<input class="form-control" type="text" id="skype_aim" name="PARAM_skype_aim" required />
									<div class="invalid-feedback"></div>
								</div>
							</div>

							<div class="col-md-6 mb-5 signup--partner-field-container">
								<label class="signup--partner-label mr-3" for="address"><b>Address</b></label>
								<div class="signup--partner-input-container">
									<input class="form-control" type="text" id="address" name="PARAM_address" />
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
									<input class="form-control" type="text" id="company" name="PARAM_company" />
									<div class="invalid-feedback"></div>
								</div>
							</div>

							<div class="col-md-6 mb-5 signup--partner-field-container">
								<label class="signup--partner-label mr-3" for="mobile"><b><span class="reqStar">*</span> Mobile Number </b></label>
								<div class="signup--partner-input-container">
									<input class="form-control" type="text" id="mobile" name="PARAM_mobile" required />
									<div class="invalid-feedback"></div>
								</div>
							</div>

							<div class="col-md-6 mb-5 signup--partner-field-container">
								<label class="signup--partner-label mr-3" for="website"><b>Site URL</b></label>
								<div class="signup--partner-input-container">
									<input class="form-control" type="text" id="website" name="PARAM_website" />
									<div class="invalid-feedback"></div>
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
									</label>
								</div>
							</div>

							<div class="col-12 col-sm-6">
								<button class="btn-signup">Sign up</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</section>

	<script>
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
							//Only Change this URL
							let url = '/netrefer-api/proxy/post.php';

							$.ajax({
								type: 'POST',
								dataType: 'JSON',
								data: formData,
								url: url,
								contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
								success: function (response) {
									console.log(response)
									if (response.success) {
										// Clear form inputs
							            $('#signup--register-form').find(':input').val('');
//
							            // Remove validation classes
							            $('#signup--register-form').removeClass('was-validated');
							            $('#signup--register-form').find('.is-invalid').removeClass('is-invalid');
//
							            // Display success message (replace with your desired message)
							            $('#signup--register-form').prepend('<div class="alert alert-success text-center">Thank you! Your Subscription Was Successful!</div>');
									} else {
										let inputs = response.data;
//
										$('#signup--register-form').removeClass('was-validated');
//
										for (const key in inputs) {
											$(`[name="${key}"]`).addClass('is-invalid');
											$(`[name="${key}"]`).next('.invalid-feedback').text(inputs[key]);
										}
									}
								},
								error: function () {}
							});
						}
					} else {
						// Add 'was-validated' class to the form
						$(this).addClass('was-validated');

						// Highlight incorrect inputs with 'is-invalid' class
						$(this).find(':invalid').addClass('is-invalid');
					}
				});

				/**
				 * Validate that the passwords match
				 */
				function passwordsMatch() {
					var password = $('#sign-up-password').val();
					var confirmPassword = $('#passwordconf').val();

					return password === confirmPassword;
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
							pattern: /((([A-Za-z]{3,9}:(?:\/\/)?)(?:[\-;:&=\+\$,\w]+@)?[A-Za-z0-9\.\-]+|(?:www\.|[\-;:&=\+\$,\w]+@)[A-Za-z0-9\.\-]+)((?:\/[\+~%\/\.\w\-_]*)?\??(?:[\-\+=&;%@\.\w_]*)#?(?:[\.\!\/\\\w]*))?)/,
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

				/**
				 * Add the required attribute dynamically to each text area on the payments section
				 * */
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