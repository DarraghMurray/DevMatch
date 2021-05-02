<?php
  require("navBar.php");
?>
<html>
    <head>
      <link rel = "stylesheet"
			href = "https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css"
			integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl"
			crossorigin="anonymous">
      <link href="http://netdna.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
      <link rel="stylesheet" href="CSS/profile.css">

    </head>
    <body>

  

    <?php
        require("database.php");
    
        $userType = intval($_SESSION['userType']);

        if(isset($_REQUEST['profileSelected'])) {
          $user = $_REQUEST['profileSelected'];
          $ownProfile = false;
        } else if(isset($_REQUEST['userToBan'])) {
          $user = $_REQUEST['userToBan'];

          $params = array($user);
          $banQuery = $db->executeStatement('UPDATE users SET Banned=1 WHERE UserID=?','i',$params);
          $ownProfile = false;
        } else {
           $user= $_SESSION['userID'];
           $ownProfile = true;
        }
  
        $searchTerm =  $user ;

		$params = array($searchTerm);
        $profileQuery = $db->executeStatement('SELECT users.Email, profiles.* FROM users INNER JOIN profiles ON users.UserID=profiles.UserID WHERE users.UserID = ?'
                                              , 's', $params);

        $result = $profileQuery->get_result();
        $row = mysqli_fetch_assoc($result);

        $mail =   $row["Email"];
        $firstN = $row["FirstName"] ;
        $lastN = $row["LastName"] ;
        $gender = $row["Gender"];
        $description = $row["Description"];
        $pass= null;
        $country = $row["Country"];
        $birthday= $row["DateOfBirth"];

        if ($gender == "Female"){
          $imageURL = "Assets/female.png";
        }
        else
          if ($gender == "Male"){
          $imageURL = "Assets/male.png";
        }
        else
         $imageURL = "Assets/other.png";
		
/* <<<<<<< Updated upstream
		
	if(isset($_POST['update'])) {

		//update database validate and reload the page
		if(isset($_POST['descrip'])){
			$dd= $_POST['descrip'];
				$descriptionQ = $connection->prepare('UPDATE profiles SET Description = ? WHERE UserID= ?');
				$descriptionQ->bind_param('si', $dd, $user);
				$descriptionQ->execute();
		}

		if(isset($_POST['lastName'])){
			$dd= $_POST['lastName'];
			if(checkName($dd)){
				$descriptionQ = $connection->prepare('UPDATE profiles SET LastName = ? WHERE UserID= ?');
				$descriptionQ->bind_param('si', $dd, $user);
				$descriptionQ->execute();
			}
		}

		if(isset($_POST['firstName'])){
			$dd= $_POST['firstName'];
			if(checkName($dd)){
				$descriptionQ = $connection->prepare('UPDATE profiles SET FirstName = ? WHERE UserID= ?');
				$descriptionQ->bind_param('si', $dd, $user);
				$descriptionQ->execute();
			}
		}
	 
	  
	 
		if(isset($_POST['countryField'])){
			$dd= $_POST['countryField'];
			$descriptionQ = $connection->prepare('UPDATE profiles SET Country = ? WHERE UserID= ?');
			$descriptionQ->bind_param('si', $dd, $user);
			$descriptionQ->execute();
		}
	 
		if(isset($_POST['bDay'])){
			$dd= $_POST['bDay'];
			$descriptionQ = $connection->prepare('UPDATE profiles SET DateOfBirth = ? WHERE UserID= ?');
			$descriptionQ->bind_param('si', $dd, $user);
			$descriptionQ->execute();
		}

	  
	  
		if(isset($_POST['eMail'])){
			$dd= $_POST['eMail'];
			if(checkEmail($dd,$user)){
				$descriptionQ = $connection->prepare('UPDATE users SET Email = ? WHERE UserID= ?');
				$descriptionQ->bind_param('si', $dd, $user);
				$descriptionQ->execute();
			}
		}


		if(isset($_POST['passWord'])){
			$dd= $_POST['passWord'];
			if(checkPassword($dd)){
				$hashPassword = password_hash($dd, PASSWORD_DEFAULT);
				$descriptionQ = $connection->prepare('UPDATE users SET Password = ? WHERE UserID= ?');
				$descriptionQ->bind_param('si', $hashPassword, $user);
				$descriptionQ->execute();
				echo '<script> alert("Password updated!")</script>';
			}
		}




		if(!empty($_POST['skill'])){
			// Loop to store and display values of individual checked checkbox.

			$searchUserSkill = $connection->prepare('SELECT * FROM userskill WHERE UserID = ?');
			$searchUserSkill->bind_param('s',$user);
			$searchUserSkill->execute();

			$resultUserSkill = $searchUserSkill->get_result();
			$existingSkills = array();

			$newSkills = array();

			while(	$userSkills_row = mysqli_fetch_assoc($resultUserSkill)){
				array_push($existingSkills,$userSkills_row['SkillID']);
			}



			///I must compare with the new elements
			// 1. daca exista  in existing avem new - update level
			// 2. daca in existing nu am new - il adaug
			// 3. daca in new nu am existing - il sterg si resetez nivel


			foreach($_POST['skill'] as $selected){ //checked items
				array_push($newSkills,$selected);
				if(!in_array($selected,$existingSkills)){ //insert in db with level
					$lev= "level".$selected;
					if(isset($_POST[$lev])){

						$ins = $connection->prepare('INSERT INTO userskill VALUES ( ? , ? , ? , NULL)');
						$ins->bind_param('iii',$user,$selected,$_POST[$lev]);
						$ins->execute();
					}	
				}
			}

			foreach($existingSkills as $selected){
				if(in_array($selected,$newSkills)){
					//update level
					$lev= "level".$selected;
					if(isset($_POST[$lev])){

						$upd = $connection->prepare('UPDATE userskill SET LevelID = ? WHERE UserID= ? and SkillID= ?');
						$upd->bind_param('sss',$_POST[$lev], $user,$selected);
						$upd->execute();
					}
				}
				else{
					//selected from existing does not exist in new - delete
					$del = $connection->prepare('DELETE FROM userskill WHERE UserID= ? and SkillID= ?');
						$del->bind_param('ss',$user,$selected);
						$del->execute();
				}
			}
		}
	
		//refreshing the entire content to see live data
		echo "<meta http-equiv='refresh' content='0'>";
	}	
	
	if(isset($_POST['cancel'])) {
	   // it will refresh the page automatically
	   echo "<meta http-equiv='refresh' content='0'>";
	}

echo '
<form method=post>
<div class="container">
<div class="row gutters">
<div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
<div class="card h-100">
	<div class="card-body">
		<div class="account-settings">
			<div class="user-profile">
				<div class="user-avatar">
					<img src=" ' . $imageURL . '" alt="Maxwell Admin">
				</div>
				<h5 class="user-name">' . $firstN.' ' .   $lastN   .'</h5>
				<h6 class="user-email">' . $mail . '</h6>
			</div>
			<div class="about">
				<h5>About</h5>';

   if($description==null)
   echo'
        <textarea type="textarea" class="form-control profileEdit" id="description" placeholder="Description" rows="3"></textarea>';
    else
     echo ' <textarea type="textarea" class="form-control profileEdit" id="description" value=' . $description .' rows="3"></textarea>';
     echo '
          <button type="button" id="addTeam" name="addTeam" class="btn btn-primary addTeamBtn">Add a team</button>
           <button type="button" id="viewAdministratedTeams" name="viewAdministratedTeams" class="btn btn-primary viewAdministratedTeams" style="margin-top:10px">View Administrated Teams</button>
		  ';
          if($userType === 2) {
            echo('<form method="post">
                <input type="hidden" name="userToBan" value='.$user.'>
                <input type="submit" name="banUser" value="Ban">
              </form>');
          }
       echo '</div>
		</div>
	</div>
</div>
</div>
<div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
<div class="card h-100">
	<div class="card-body">
		<div class="row gutters">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
				<h6 class="mb-2 text-primary">Personal Details</h6>
			</div>
			<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
				<div class="form-group">
					<label for="fullName">Last Name</label>
					<input type="text" class="form-control profileEdit" id="lastName" value=' . $lastN .'>
				</div>
			</div>
			<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
				<div class="form-group">
					<label for="eMail">Email</label>
					<input type="email" class="form-control profileEdit" id="eMail" value='.$mail.'>
				</div>
			</div>
			<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
				<div class="form-group">
					<label for="phone">First name</label>
					<input type="text" class="form-control profileEdit" id="firstName" value=' . $firstN .'>
				</div>
			</div>
			<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
				<div class="form-group">
					<label for="website">Password</label>
					<input type="password" class="form-control profileEdit" id="password" placeholder="Change password">
				</div>
			</div>
		</div>
		<div class="row gutters">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
				<h6 class="mt-3 mb-2 text-primary">Details</h6>
			</div>
			<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
				<div class="form-group">
					<label for="Country">Country</label>
					<select class="form-control profileEdit" id="Country" name="countryField" selected='.$country.'>
                <option value='.$country.' selected>'.$country.'</option>
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
								<option value="Cote DIvoire">Cote DIvoire</option>
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
								<option value="Lao Peoples Democratic Republic">Lao Peoples Democratic Republic</option>
								<option value="Latvia">Latvia</option>
								<option value="Lebanon">Lebanon</option>
								<option value="Lesotho">Lesotho</option>
								<option value="Liberia">Liberia</option>
								<option value="Libyan Arab Jamahiriya">Libyan Arab Jamahiriya</option>
								<option value="Liechtenstein">Liechtenstein</option>
								<option value="Lithuania">Lithuania</option>
								<option value="Luxembourg">Luxembourg</option>
								<option value="Macao">Macao</option>
								<option value="Macedonia">Macedonia, the Former Yugoslav Republic of</option>
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
          </div>
			</div>
			<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
				<div class="form-group">
					<label for="birthday">Birthday</label>
					<input type="date" class="form-control profileEdit" id="birthDay" name="bDay" value='.$birthday.'>
				</div>
			</div>
		</div>
	<div class="row gutters">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
      <h6 class="mt-3 mb-2 text-primary">Skills</h6>
    </div>
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
    <div class="form-group">';
	
======= */
		if(isset($_POST['update'])) {



			//update database validate and reload the page
			if(isset($_POST['descrip'])){
			  $dd= $_POST['descrip'];
			  $params = array($dd,$user);
			  $descriptionQ = $db->executeStatement('UPDATE profiles SET Description = ? WHERE UserID= ?','si',$params);
			}
		  
			if(isset($_POST['lastName'])){
			  $dd= $_POST['lastName'];
			  if(checkName($dd)){
				  $params = array($dd,$user);
				  $descriptionQ = $db->executeStatement('UPDATE profiles SET LastName = ? WHERE UserID= ?');
			  }
			}
		  
			if(isset($_POST['firstName'])){
			  $dd= $_POST['firstName'];
			  if(checkName($dd)){
				  $params = array($dd,$user);
				  $descriptionQ = $db->executeStatement('UPDATE profiles SET FirstName = ? WHERE UserID= ?','si',$params);
			  }
			}
		   
			
		   
			if(isset($_POST['countryField'])){
			  $dd= $_POST['countryField'];
			  $params = array($dd,$user);
			  $descriptionQ = $db->executeStatement('UPDATE profiles SET Country = ? WHERE UserID= ?','si',$params);
			}
		   
			if(isset($_POST['bDay'])){
			  $dd= $_POST['bDay'];
			  $params = array($dd,$user);
			  $descriptionQ = $db->executeStatement('UPDATE profiles SET DateOfBirth = ? WHERE UserID= ?','si',$params);
			}
		  
			
			
			if(isset($_POST['eMail'])){
			  $dd= $_POST['eMail'];
			  if(checkEmail($dd,$user)){
				  $params = array($dd,$user);
				  $descriptionQ = $db->executeStatement('UPDATE users SET Email = ? WHERE UserID= ?','si',$params);
			  }
			}
		  
		  
			if(isset($_POST['passWord'])){
				$dd= $_POST['passWord'];
				if(checkPassword($dd)){
					$hashPassword = password_hash($dd, PASSWORD_DEFAULT);
				  $params = array($hashPassword,$user);
				  $descriptionQ = $db->executeStatement('UPDATE users SET Password = ? WHERE UserID= ?','si',$params);
					echo '<script> alert("Password updated!")</script>';
				}
			}
		  
		  
		  
		  
			if(!empty($_POST['skill'])){
			  // Loop to store and display values of individual checked checkbox.
		  
			  $params = array($user);
			  $searchUserSkill = $db->executeStatement('SELECT * FROM userskill WHERE UserID = ?','s',$params);
			  $resultUserSkill = $searchUserSkill->get_result();
			  $existingSkills = array();
		  
			  $newSkills = array();
		  
			  while(	$userSkills_row = mysqli_fetch_assoc($resultUserSkill)){
				  array_push($existingSkills,$userSkills_row['SkillID']);
			  }
		  
		  
		  
			  ///I must compare with the new elements
			  // 1. daca exista  in existing avem new - update level
			  // 2. daca in existing nu am new - il adaug
			  // 3. daca in new nu am existing - il sterg si resetez nivel
		  
		  
			  foreach($_POST['skill'] as $selected){ //checked items
				  array_push($newSkills,$selected);
				  if(!in_array($selected,$existingSkills)){ //insert in db with level
					  $lev= "level".$selected;
					  if(isset($_POST[$lev])){
						  $params = array($user,$selected,$_POST[$lev]);
						  $ins = $db->executeStatement('INSERT INTO userskill VALUES ( ? , ? , ? , NULL)','iii',$params);
					  }	
				  }
			  }
		  
			  foreach($existingSkills as $selected){
				  if(in_array($selected,$newSkills)){
					  //update level
					  $lev= "level".$selected;
					  if(isset($_POST[$lev])){
		  
						  $params = array($_POST[$lev],$user,$selected);
						  $upd = $db->executeStatement('UPDATE userskill SET LevelID = ? WHERE UserID= ? and SkillID= ?','sss',$params);
					  }
				  }
				  else{
					  //selected from existing does not exist in new - delete
					  $params = array($user,$selected);
					  $del = $db->executeStatement('DELETE FROM userskill WHERE UserID= ? and SkillID= ?','ss',$params);
				  }
			  }
		  
		  
		  }
		  
		  //refreshing the entire content to see live data
		   echo "<meta http-equiv='refresh' content='0'>";
		  }
		  
		  if(isset($_POST['cancel'])) {
			  // it will refresh the page automatically
			  echo "<meta http-equiv='refresh' content='0'>";
		   }

		   echo '
		   <form method=post>
		   <div class="container">
		   <div class="row gutters">
		   <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
		   <div class="card h-100">
			   <div class="card-body">
				   <div class="account-settings">
					   <div class="user-profile">
						   <div class="user-avatar">
							   <img src=" ' . $imageURL . '" alt="Maxwell Admin">
						   </div>
						   <h5 class="user-name">' . $firstN.' ' .   $lastN   .'</h5>
						   <h6 class="user-email">' . $mail . '</h6>
					   </div>
					   <div class="about">
						   <h5>About</h5>';
		   
			  if($description==null)
			  echo'
				   <textarea type="textarea" class="form-control profileEdit" id="description" placeholder="Description" rows="3"></textarea>';
			   else
				echo ' <textarea type="textarea" class="form-control profileEdit" id="description" value=' . $description .' rows="3"></textarea>';
				echo '
					 <button type="button" id="addTeam" name="addTeam" class="btn btn-primary addTeamBtn">Add a team</button>
					  <button type="button" id="viewAdministratedTeams" name="viewAdministratedTeams" class="btn btn-primary viewAdministratedTeams" style="margin-top:10px">View Administrated Teams</button>
					 ';
					 if($userType === 2) {
					   echo('<form method="post">
						   <input type="hidden" name="userToBan" value='.$user.'>
						   <input type="submit" name="banUser" value="Ban">
						 </form>');
					 }
				  echo '</div>
				   </div>
			   </div>
		   </div>
		   </div>
		   <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
		   <div class="card h-100">
			   <div class="card-body">
				   <div class="row gutters">
					   <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
						   <h6 class="mb-2 text-primary">Personal Details</h6>
					   </div>
					   <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
						   <div class="form-group">
							   <label for="fullName">Last Name</label>
							   <input type="text" class="form-control profileEdit" id="lastName" value=' . $lastN .'>
						   </div>
					   </div>
					   <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
						   <div class="form-group">
							   <label for="eMail">Email</label>
							   <input type="email" class="form-control profileEdit" id="eMail" value='.$mail.'>
						   </div>
					   </div>
					   <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
						   <div class="form-group">
							   <label for="phone">First name</label>
							   <input type="text" class="form-control profileEdit" id="firstName" value=' . $firstN .'>
						   </div>
					   </div>
					   <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
						   <div class="form-group">
							   <label for="website">Password</label>
							   <input type="password" class="form-control profileEdit" id="password" placeholder="Change password">
						   </div>
					   </div>
				   </div>
				   <div class="row gutters">
					   <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
						   <h6 class="mt-3 mb-2 text-primary">Details</h6>
					   </div>
					   <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
						   <div class="form-group">
							   <label for="Country">Country</label>
							   <select class="form-control profileEdit" id="Country" name="countryField" selected='.$country.'>
						   <option value='.$country.' selected>'.$country.'</option>
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
										   <option value="Cote DIvoire">Cote DIvoire</option>
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
										   <option value="Lao Peoples Democratic Republic">Lao Peoples Democratic Republic</option>
										   <option value="Latvia">Latvia</option>
										   <option value="Lebanon">Lebanon</option>
										   <option value="Lesotho">Lesotho</option>
										   <option value="Liberia">Liberia</option>
										   <option value="Libyan Arab Jamahiriya">Libyan Arab Jamahiriya</option>
										   <option value="Liechtenstein">Liechtenstein</option>
										   <option value="Lithuania">Lithuania</option>
										   <option value="Luxembourg">Luxembourg</option>
										   <option value="Macao">Macao</option>
										   <option value="Macedonia">Macedonia, the Former Yugoslav Republic of</option>
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
					 </div>
					   </div>
					   <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
						   <div class="form-group">
							   <label for="birthday">Birthday</label>
							   <input type="date" class="form-control profileEdit" id="birthDay" name="bDay" value='.$birthday.'>
						   </div>
					   </div>
				   </div>
			   <div class="row gutters">
			   <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
				 <h6 class="mt-3 mb-2 text-primary">Skills</h6>
			   </div>
			   <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
			   <div class="form-group">';
			   
/* >>>>>>> Stashed changes */
	//////////////////////////////// skills	  
		//existing skills
		$params = array($user);
		$searchUserSkill = $db->executeStatement('SELECT * FROM userskill WHERE UserID = ?','s',$params);
		$resultUserSkill = $searchUserSkill->get_result();
		$existingSkills = array();
	
		while(	$userSkills_row = mysqli_fetch_assoc($resultUserSkill)){
			array_push($existingSkills,$userSkills_row['SkillID']);
		}

	$searchSkills = $db->executeStatement('SELECT * FROM skills');
   	$resultSkills = $searchSkills->get_result();

   $count=0;

   while(	$skills_row = mysqli_fetch_assoc($resultSkills)){

	//Qualifications of a job
	$params = array($skills_row['STypeID']);
	$searchDescription = $db->executeStatement('SELECT * FROM skilltype WHERE STypeID = ?','s',$params);
	$resultDescription = $searchDescription->get_result();
	$rowDesc = mysqli_fetch_assoc($resultDescription);

	echo ' <div class="d-flex justify-content-between" style="margin-top:10px;">';

	if (in_array($skills_row['SkillID'], $existingSkills)) {

    echo '
	<input type="checkbox" class="profileEdit" name="skill[]" value='.$skills_row['SkillID'].' checked>
    <label for='.$skills_row['SkillID'].'>'.$skills_row['Name'].'</label><br>';
	}else{
	echo '	<input type="checkbox" class="profileEdit" name="skill[]" value='.$skills_row["SkillID"].'>
    <label for='.$skills_row['SkillID'].'>'.$skills_row['Name'].'</label><br>';
		
	}

	$getLevelVar = getLevel($skills_row['SkillID'],$user);


	$search = $db->executeStatement('SELECT * FROM level');
    $resultLevel = $search->get_result();
    
	$lev_name= "level".$skills_row['SkillID'];
	echo '<select class="profileEdit" name="'.$lev_name.'">';
	while($level_row = mysqli_fetch_assoc($resultLevel)){
		if ($getLevelVar == $level_row["LevelID"])
		echo '<option value='.$level_row["LevelID"].' selected>'.$level_row["Name"].' </option>';
	else
		echo '<option value='.$level_row["LevelID"].' >'.$level_row["Name"].' </option>';

    }

    echo '
    </select>

    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal'.$count.'">See qualifications</button>

    <!-- Modal -->
  <div class="modal fade" id="myModal'.$count.'" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">'.$rowDesc['Name'].'</h4>
        </div>
        <div class="modal-body">
          <p>'.$rowDesc['Description'].'</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
    
    </div>';
	$count++;
  }

    if($ownProfile || $userType === 2) {
      echo('
		</div>
		</div>
		</div>
      <div class="row gutters">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
          <div class="text-right">
          <form method="post">
            <input type="submit" id="cancelBtn" name="cancel" class="btn btn-secondary" value="Cancel"/>
            <input type="submit" id="updateBtn" name="update" class="btn btn-primary" value="Update" />
          </form>
          </div>
        </div>
      </div>');
    }
	echo '</div>
</div>
</div>
</div>
</div>
</form>
';

function checkName($name) {
  if(empty($name)) { 
    echo '<script> alert("full name is required");</script>';
    return false;
 }
 if(strlen($name) > 50) {
  echo '<script> alert("first or last name exceeds character limit 50");</script>';
  return false;

 }
 if(preg_match('/[0-9]+/', $name) > 0) {
  echo '<script> alert("first or last name contains a number");</script>';
  return false;

 }
 return true;
}

function checkEmail($email,$user) {
      require("database.php");
	  $params = array($email,$user);
	  $search = $db->executeStatement('SELECT * FROM users WHERE Email = ? AND UserID != ?','ss',$params);
      $search->store_result();
    
  if ($search->num_rows() > 0) {
    echo '<script> alert("Email already exists");</script>';
    return false;
  } 

  if(empty($email)) { 
    echo '<script> alert("Email is required");</script>';
    return false;
  }
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { 
   echo '<script> alert( "Invalid email");</script>';
   return false;
  }
  
  return true;
}

function checkPassword($password) {
  if($password==null)
    return false;
  else{
    if(!preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}$/", $password)) {
      echo '<script> alert( "password does not match pattern")</script>';
      return false;
    }
  }

  if(strlen($password) > 32) {
    echo '<script> alert("password exceeds max length 32")</script>';
    return false;
  }

return true;
}


function getLevel($skillId,$user){
	require("database.php");

	$params = array($user,$skillId);
	$searchUserSkill = $db->executeStatement('SELECT * FROM userskill WHERE UserID = ? AND SkillID= ?','ss',$params);
	$resultUserSkill = $searchUserSkill->get_result();
	
	$userSkillsLevel_row = mysqli_fetch_assoc($resultUserSkill);

	if($userSkillsLevel_row == null){
		return 1;}
	else{
		return $userSkillsLevel_row["LevelID"];
	}
}
  ?>
<script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
<script src="http://netdna.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script type="text/javascript"></script>
    <script language="javascript">
        var user_type = '<?php echo $userType ?>';
        var own_profile = '<?php echo $ownProfile ?>';
        
        if(user_type != 2 && own_profile != true) {
          $(".profileEdit").each(function() {
            $(this).prop('readonly',true);
			$(this).prop('disabled',true);
          });
        }
    </script>
</body>
</html>