<html>
	<head>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
		<link rel = "stylesheet"
			href = "CSS/intro-styles.css">
		<link rel="preconnect" href="https://fonts.gstatic.com">
		<link href="https://fonts.googleapis.com/css2?family=Raleway:wght@200&display=swap" rel="stylesheet">
	</head>

	<body>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
		<?php
			include("registerResult.php");
		?>
		<div class="background-wrap">
			<video id="video-bg-elem" preload="auto" autoplay="true" loop="loop" muted="muted"> 
				<source src="Assets/index.mp4" type="video/mp4">
			</video> 

			</div id="intro">
				<div id="logInPopUp" class="modal">	
					<!-- Modal Content -->
					<form id = "logInPopUp" class="modal-content overflow-auto" action="logIn.php" method="post">
						<span onclick="document.getElementById('logInPopUp').style.display='none'"
							class="close" title="Close Modal">&times;</span>
						<div class="rounded" class="form-group" >
							<img class="img-fluid" src="Assets/login.png">
						</div> 
						<div class="form-group">
							<h2>Log-In</h2>
							<hr></hr>
						</div> 
						<div class="form-group">
						<input type="text" required class="form-control" name="email" placeholder="Email" maxlength="320">
						</div>
						<div class="form-group">
							<input type="password" required class="form-control" name="pass" placeholder="Password">
						</div>
						<div class="form-group text-center" >
							<input type="submit" class="btn btn-dark" value="Log-In" name="logIn">
						</div>
					</form>
				</div>

				<div id="registerPopUp" class="modal">
					<!-- Modal Content -->

					<form id = "registerPopUpForm" class="modal-content overflow-auto" onsubmit="return validateForm()" action="register.php" method="POST">
						<span onclick="document.getElementById('registerPopUp').style.display='none'"
							class="close" title="Close Modal">&times;</span>
						<div class="rounded" class="form-group">
							<img class="img-fluid" src="Assets/register.png">
						</div>
						<div class="form-group">
							<h2>Register</h2>
							<hr></hr>
						</div>
						<div class="form-group">
							<input type="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" required class="form-control" name="regEmail" placeholder="Email" maxlength="320">
						</div>
						<div class="form-group">
							<input type="password" minlength="6" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" required 
							class="form-control" id="regPass" name="regPass" placeholder="Password" maxlength="32">
							<small id="passwordHelp" class="form-text text-muted">passwords require an uppercase letter, a lowercase letter, a number and at least 6 characters</small>
							<input type="password" minlength="6" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" required
							class="form-control" id="regPassConfirm" name="regPassConfirm" placeholder="confirm password" maxlength="32">
						</div>
						<div class="form-group" style ="display: flex;">
							<input type="text" required pattern="[^\d]+"class="form-control" name="firstName"  placeholder="First Name"
							maxlength="50">
							<input type="text" required pattern="[^\d]+"class="form-control" name="surName" placeholder="Surname"
							maxlength="50">
						</div>

						<div class="form-group">
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="gender" id="Male" value="Male" required>
								<label class="form-check-label" for="Male">Male:</label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-chech-input" type="radio" name="gender" id="Female" value="Female" required>
								<label class="form-check-label" for="Female">Female:</label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input"type="radio" name="gender" id="Other" value="Other" required>
								<label class="form-check-label" for="vehicle3">Other:</label>
							</div>
						</div>

						<div class = "form-group" style="display: flex;">
							<select id="country" name="country" >
								<option selected value="">select country</option>
								<option value="Afghanistan">Afghanistan</option>
								<option value="Aland Islands">Aland Islands</option>
								<option value="Albania">Albania</option>
								<option value="Algeria">Algeria</option>
								<option value="American Samoa">American Samoa</option>
								<option value="Andorra">Andorra</option>
								<option value="Angola">Angola</option>
								<option value="Anguilla">Anguilla</option>
								<option value="Antarctica">Antarctica</option>
								<option value="Antigua and Barbuda">Antigua and Barbuda</option>
								<option value="Argentina">Argentina</option>
								<option value="Armenia">Armenia</option>
								<option value="Aruba">Aruba</option>
								<option value="Australia">Australia</option>
								<option value="Austria">Austria</option>
								<option value="Azerbaijan">Azerbaijan</option>
								<option value="Bahamas">Bahamas</option>
								<option value="Bahrain">Bahrain</option>
								<option value="Bangladesh">Bangladesh</option>
								<option value="Barbados">Barbados</option>
								<option value="Belarus">Belarus</option>
								<option value="Belgium">Belgium</option>
								<option value="Belize">Belize</option>
								<option value="Benin">Benin</option>
								<option value="Bermuda">Bermuda</option>
								<option value="Bhutan">Bhutan</option>
								<option value="Bolivia">Bolivia</option>
								<option value="Bonaire, Sint Eustatius and Saba">Bonaire, Sint Eustatius and Saba</option>
								<option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
								<option value="Botswana">Botswana</option>
								<option value="Bouvet Island">Bouvet Island</option>
								<option value="Brazil">Brazil</option>
								<option value="British Indian Ocean Territory">British Indian Ocean Territory</option>
								<option value="Brunei Darussalam">Brunei Darussalam</option>
								<option value="Bulgaria">Bulgaria</option>
								<option value="Burkina Faso">Burkina Faso</option>
								<option value="Burundi">Burundi</option>
								<option value="Cambodia">Cambodia</option>
								<option value="Cameroon">Cameroon</option>
								<option value="Canada">Canada</option>
								<option value="Cape Verde">Cape Verde</option>
								<option value="Cayman Islands">Cayman Islands</option>
								<option value="Central African Republic">Central African Republic</option>
								<option value="Chad">Chad</option>
								<option value="Chile">Chile</option>
								<option value="China">China</option>
								<option value="Christmas Island">Christmas Island</option>
								<option value="Cocos (Keeling) Islands">Cocos (Keeling) Islands</option>
								<option value="Colombia">Colombia</option>
								<option value="Comoros">Comoros</option>
								<option value="Congo">Congo</option>
								<option value="Congo, the Democratic Republic of the">Congo, the Democratic Republic of the</option>
								<option value="Cook Islands">Cook Islands</option>
								<option value="Costa Rica">Costa Rica</option>
								<option value="Cote D'Ivoire">Cote D'Ivoire</option>
								<option value="Croatia">Croatia</option>
								<option value="Cuba">Cuba</option>
								<option value="Curacao">Curacao</option>
								<option value="Cyprus">Cyprus</option>
								<option value="Czech Republic">Czech Republic</option>
								<option value="Denmark">Denmark</option>
								<option value="Djibouti">Djibouti</option>
								<option value="Dominica">Dominica</option>
								<option value="Dominican Republic">Dominican Republic</option>
								<option value="Ecuador">Ecuador</option>
								<option value="Egypt">Egypt</option>
								<option value="El Salvador">El Salvador</option>
								<option value="Equatorial Guinea">Equatorial Guinea</option>
								<option value="Eritrea">Eritrea</option>
								<option value="Estonia">Estonia</option>
								<option value="Ethiopia">Ethiopia</option>
								<option value="Falkland Islands (Malvinas)">Falkland Islands (Malvinas)</option>
								<option value="Faroe Islands">Faroe Islands</option>
								<option value="Fiji">Fiji</option>
								<option value="Finland">Finland</option>
								<option value="France">France</option>
								<option value="French Guiana">French Guiana</option>
								<option value="French Polynesia">French Polynesia</option>
								<option value="French Southern Territories">French Southern Territories</option>
								<option value="Gabon">Gabon</option>
								<option value="Gambia">Gambia</option>
								<option value="Georgia">Georgia</option>
								<option value="Germany">Germany</option>
								<option value="Ghana">Ghana</option>
								<option value="Gibraltar">Gibraltar</option>
								<option value="Greece">Greece</option>
								<option value="Greenland">Greenland</option>
								<option value="Grenada">Grenada</option>
								<option value="Guadeloupe">Guadeloupe</option>
								<option value="Guam">Guam</option>
								<option value="Guatemala">Guatemala</option>
								<option value="Guernsey">Guernsey</option>
								<option value="Guinea">Guinea</option>
								<option value="Guinea-Bissau">Guinea-Bissau</option>
								<option value="Guyana">Guyana</option>
								<option value="Haiti">Haiti</option>
								<option value="Heard Island and Mcdonald Islands">Heard Island and Mcdonald Islands</option>
								<option value="Holy See (Vatican City State)">Holy See (Vatican City State)</option>
								<option value="Honduras">Honduras</option>
								<option value="Hong Kong">Hong Kong</option>
								<option value="Hungary">Hungary</option>
								<option value="Iceland">Iceland</option>
								<option value="India">India</option>
								<option value="Indonesia">Indonesia</option>
								<option value="Iran, Islamic Republic of">Iran, Islamic Republic of</option>
								<option value="Iraq">Iraq</option>
								<option value="Ireland">Ireland</option>
								<option value="Isle of Man">Isle of Man</option>
								<option value="Israel">Israel</option>
								<option value="Italy">Italy</option>
								<option value="Jamaica">Jamaica</option>
								<option value="Japan">Japan</option>
								<option value="Jersey">Jersey</option>
								<option value="Jordan">Jordan</option>
								<option value="Kazakhstan">Kazakhstan</option>
								<option value="Kenya">Kenya</option>
								<option value="Kiribati">Kiribati</option>
								<option value="Korea, Democratic People"s Republic of">Korea, Democratic People"s Republic of</option>
								<option value="Korea, Republic of">Korea, Republic of</option>
								<option value="Kosovo">Kosovo</option>
								<option value="Kuwait">Kuwait</option>
								<option value="Kyrgyzstan">Kyrgyzstan</option>
								<option value="Lao People's Democratic Republic">Lao People's Democratic Republic</option>
								<option value="Latvia">Latvia</option>
								<option value="Lebanon">Lebanon</option>
								<option value="Lesotho">Lesotho</option>
								<option value="Liberia">Liberia</option>
								<option value="Libyan Arab Jamahiriya">Libyan Arab Jamahiriya</option>
								<option value="Liechtenstein">Liechtenstein</option>
								<option value="Lithuania">Lithuania</option>
								<option value="Luxembourg">Luxembourg</option>
								<option value="Macao">Macao</option>
								<option value="Macedonia, the Former Yugoslav Republic of">Macedonia, the Former Yugoslav Republic of</option>
								<option value="Madagascar">Madagascar</option>
								<option value="Malawi">Malawi</option>
								<option value="Malaysia">Malaysia</option>
								<option value="Maldives">Maldives</option>
								<option value="Mali">Mali</option>
								<option value="Malta">Malta</option>
								<option value="Marshall Islands">Marshall Islands</option>
								<option value="Martinique">Martinique</option>
								<option value="Mauritania">Mauritania</option>
								<option value="Mauritius">Mauritius</option>
								<option value="Mayotte">Mayotte</option>
								<option value="Mexico">Mexico</option>
								<option value="Micronesia, Federated States of">Micronesia, Federated States of</option>
								<option value="Moldova, Republic of">Moldova, Republic of</option>
								<option value="Monaco">Monaco</option>
								<option value="Mongolia">Mongolia</option>
								<option value="Montenegro">Montenegro</option>
								<option value="Montserrat">Montserrat</option>
								<option value="Morocco">Morocco</option>
								<option value="Mozambique">Mozambique</option>
								<option value="Myanmar">Myanmar</option>
								<option value="Namibia">Namibia</option>
								<option value="Nauru">Nauru</option>
								<option value="Nepal">Nepal</option>
								<option value="Netherlands">Netherlands</option>
								<option value="Netherlands Antilles">Netherlands Antilles</option>
								<option value="New Caledonia">New Caledonia</option>
								<option value="New Zealand">New Zealand</option>
								<option value="Nicaragua">Nicaragua</option>
								<option value="Niger">Niger</option>
								<option value="Nigeria">Nigeria</option>
								<option value="Niue">Niue</option>
								<option value="Norfolk Island">Norfolk Island</option>
								<option value="Northern Mariana Islands">Northern Mariana Islands</option>
								<option value="Norway">Norway</option>
								<option value="Oman">Oman</option>
								<option value="Pakistan">Pakistan</option>
								<option value="Palau">Palau</option>
								<option value="Palestinian Territory, Occupied">Palestinian Territory, Occupied</option>
								<option value="Panama">Panama</option>
								<option value="Papua New Guinea">Papua New Guinea</option>
								<option value="Paraguay">Paraguay</option>
								<option value="Peru">Peru</option>
								<option value="Philippines">Philippines</option>
								<option value="Pitcairn">Pitcairn</option>
								<option value="Poland">Poland</option>
								<option value="Portugal">Portugal</option>
								<option value="Puerto Rico">Puerto Rico</option>
								<option value="Qatar">Qatar</option>
								<option value="Reunion">Reunion</option>
								<option value="Romania">Romania</option>
								<option value="Russian Federation">Russian Federation</option>
								<option value="Rwanda">Rwanda</option>
								<option value="Saint Barthelemy">Saint Barthelemy</option>
								<option value="Saint Helena">Saint Helena</option>
								<option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
								<option value="Saint Lucia">Saint Lucia</option>
								<option value="Saint Martin">Saint Martin</option>
								<option value="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option>
								<option value="Saint Vincent and the Grenadines">Saint Vincent and the Grenadines</option>
								<option value="Samoa">Samoa</option>
								<option value="San Marino">San Marino</option>
								<option value="Sao Tome and Principe">Sao Tome and Principe</option>
								<option value="Saudi Arabia">Saudi Arabia</option>
								<option value="Senegal">Senegal</option>
								<option value="Serbia">Serbia</option>
								<option value="Serbia and Montenegro">Serbia and Montenegro</option>
								<option value="Seychelles">Seychelles</option>
								<option value="Sierra Leone">Sierra Leone</option>
								<option value="Singapore">Singapore</option>
								<option value="Sint Maarten">Sint Maarten</option>
								<option value="Slovakia">Slovakia</option>
								<option value="Slovenia">Slovenia</option>
								<option value="Solomon Islands">Solomon Islands</option>
								<option value="Somalia">Somalia</option>
								<option value="South Africa">South Africa</option>
								<option value="South Georgia and the South Sandwich Islands">South Georgia and the South Sandwich Islands</option>
								<option value="South Sudan">South Sudan</option>
								<option value="Spain">Spain</option>
								<option value="Sri Lanka">Sri Lanka</option>
								<option value="Sudan">Sudan</option>
								<option value="Suriname">Suriname</option>
								<option value="Svalbard and Jan Mayen">Svalbard and Jan Mayen</option>
								<option value="Swaziland">Swaziland</option>
								<option value="Sweden">Sweden</option>
								<option value="Switzerland">Switzerland</option>
								<option value="Syrian Arab Republic">Syrian Arab Republic</option>
								<option value="Taiwan, Province of China">Taiwan, Province of China</option>
								<option value="Tajikistan">Tajikistan</option>
								<option value="Tanzania, United Republic of">Tanzania, United Republic of</option>
								<option value="Thailand">Thailand</option>
								<option value="Timor-Leste">Timor-Leste</option>
								<option value="Togo">Togo</option>
								<option value="Tokelau">Tokelau</option>
								<option value="Tonga">Tonga</option>
								<option value="Trinidad and Tobago">Trinidad and Tobago</option>
								<option value="Tunisia">Tunisia</option>
								<option value="Turkey">Turkey</option>
								<option value="Turkmenistan">Turkmenistan</option>
								<option value="Turks and Caicos Islands">Turks and Caicos Islands</option>
								<option value="Tuvalu">Tuvalu</option>
								<option value="Uganda">Uganda</option>
								<option value="Ukraine">Ukraine</option>
								<option value="United Arab Emirates">United Arab Emirates</option>
								<option value="United Kingdom">United Kingdom</option>
								<option value="United States">United States</option>
								<option value="United States Minor Outlying Islands">United States Minor Outlying Islands</option>
								<option value="Uruguay">Uruguay</option>
								<option value="Uzbekistan">Uzbekistan</option>
								<option value="Vanuatu">Vanuatu</option>
								<option value="Venezuela">Venezuela</option>
								<option value="Viet Nam">Viet Nam</option>
								<option value="Virgin Islands, British">Virgin Islands, British</option>
								<option value="Virgin Islands, U.s.">Virgin Islands, U.s.</option>
								<option value="Wallis and Futuna">Wallis and Futuna</option>
								<option value="Western Sahara">Western Sahara</option>
								<option value="Yemen">Yemen</option>
								<option value="Zambia">Zambia</option>
								<option value="Zimbabwe">Zimbabwe</option>
							</select>	
							<input type="text" required id="dateOfBirth" pattern="^[0-9]{2}[/][0-9]{2}[/][0-9]{4}$" name="dateOfBirth" placeholder="dd/mm/yyyy">			
						</div>
						<div class = "form-group text-center" >
							<input type="submit" class="btn btn-dark" value="Register" name="register" onclick="validateForm()">
						</div>
					</form>
				</div>

				<div class="text-center">
					<div class="container">
						<img src="Assets/logo.png" id="logoImage" alt=" logo image"><br>
						<button type="button" class="btn btn-outline-dark btn-lg" onclick="document.getElementById('logInPopUp').style.display='block'">Log-in</button>
						<button type="button" class="btn btn-outline-dark btn-lg" onclick="document.getElementById('registerPopUp').style.display='block'">Register</button>
					</div>
				</div>
			</div>
		</div>

		<div id="about">
			<div class="resp-container">
			
			<iframe class="resp-iframe"  src="https://www.youtube.com/embed/pLFMs96Y-e4" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
			
				<div class="resp-about">
					<p>
					<img id="about-logo" src="Assets/logo.png"><br>
					Nowadays, especially because of the challenging times we are living, people forgot to connect, and the video games market helped a lot by keeping society entertained. 
						<br><br>Lately, a lot of progress was made in AI for video-games and streaming, just to give people a break from the pressure of not being able to physically connect.</p>
				</div>
			</div>	
		</div>
			
		<script language="javascript">

			function validateForm() {
				return confirmPassword() && validateDate() && isCountrySelected();
			}

			function validateDate() {
				
				let dateOfBirth = document.getElementById("dateOfBirth").value;
				let dateOfBirthSplit = dateOfBirth.split('/');

				let dd = parseInt(dateOfBirthSplit[0]);
				let mm = parseInt(dateOfBirthSplit[1]);
				let yy = parseInt(dateOfBirthSplit[2]);

				let ListofDays = [31,28,31,30,31,30,31,31,30,31,30,31];

				let date = new Date();
				let currYear = date.getFullYear();

				if(dd>0 && mm>0 && yy>1900 && dd < 32 && mm < 13 && yy <= currYear) {
					if(mm == 2) {
						let leapYear = false;
						if ( (!(yy % 4) && yy % 100) || !(yy % 400)) 
						{	
							leapYear = true; 
						}
						if ((leapYear==false) && (dd>=29))
						{	alert("exceeded no of days in month");
							return false; 
						}
						if ((leapYear==true) && (dd>29))	
						{  	alert("exceeded no of days in month");
							 return false; 
						}
						return true;
					}
					else {
						if(dd > ListofDays[mm-1]) {
							alert("exceeded no of days in month");
							return false;
						}
						return true;
					}
				} else {
					alert("invalid birth date");
					return false;
				}
			}

			function isCountrySelected() {
				let countryIndex = document.getElementById("country").selectedIndex;

				if(countryIndex >= 1) {
					return true;
				}
				alert("no country selected")
				return false;
			}

			function confirmPassword() {
				let password = document.getElementById("regPass");
				let passwordConfirm = document.getElementById("regPassConfirm");

				if (password.value === passwordConfirm.value) {
					return true;
				}
				alert("passwords don't match");
				return false;
			}
		</script>
	</body>
</html>