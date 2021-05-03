<?php
        require('database.php');
		date_default_timezone_set('Europe/Dublin');

        session_start();
        $errors = array();

        if(isset($_REQUEST['register'])) {

            $email = $_REQUEST['regEmail'];
            checkEmail($email);

            $password = $_REQUEST['regPass'];
            checkPassword($password);

            $firstName = $_REQUEST['firstName'];
            checkName($firstName);
            
            $surName = $_REQUEST['surName'];
            checkName($surName);

            $gender = $_REQUEST['gender'];
            if(empty($gender)) { array_push($errors, "gender is required"); }
            
            $dateOfBirth = $_REQUEST['dateOfBirth'];
            if(checkDateValid($dateOfBirth)) {
              $dateOfBirth = strtotime($dateOfBirth);
              $dateOfBirth = date("Y-m-d", $dateOfBirth);
            };
            
            $country = $_REQUEST['country'];
            if(empty($country)) { array_push($errors, "must select a country"); }

            if(count($errors) == 0) {

              $params = array($email);
              $userAlreadyExists = $db->executeStatement('SELECT * FROM users WHERE Email=?','s',$params);
              if($userAlreadyExists) {

                $userAlreadyExists->store_result();
                    if ($userAlreadyExists->num_rows() > 0) {
                      array_push($errors, "email already exists");
                    } 
              } else {
                  array_push($errors, "Registration failed");
              }
            } else {
                header('location: index.php?register=fail&errors=' . $errors[0]);
            }

            if(count($errors) == 0) {
              $uTypeID = 1;
              $hashPassword = password_hash($password, PASSWORD_DEFAULT);

              $db->beginTransaction();
              $params = array($email,$hashPassword,$uTypeID);
              $userTableInsert = $db->executeStatement('INSERT INTO users(Email,Password,UTypeID) 
              VALUES(?,?,?)','ssi',$params);
              if($userTableInsert){

                $userID = $db->getLastInsertID();

                $params = array($userID,$firstName,$surName,$gender,$dateOfBirth,$country);
                $profileTableInsert = $db->executeStatement('INSERT INTO profiles(UserID,FirstName,LastName,Gender,DateOfBirth,Country) 
                VALUES(?,?,?,?,?,?)',"isssss",$params);
                if($profileTableInsert) {
                  $db->commitTransaction();
                } else {
                  $db->rollbackTransaction();
                  array_push($errors, "Registration failed");
                }
              } else {
                $db->rollbackTransaction();
                array_push($errors, "Registration failed");
              }

              if(count($errors) == 0){
                header('location: index.php?register=succeed');
               } else {
                  header('location: index.php?register=fail&errors=' . $errors[0]);
               }
            } else {
                header('location: index.php?register=fail&errors=' . $errors[0]);
            }
    } else {
      header('location: index.php?register=fail');
    }

      function checkDateValid($dateOfBirth) {

        if(empty($dateOfBirth)) { 
          array_push($errors, "date of birth is required");
          return false; 
        }
        if(!preg_match("/^[0-9]{2}[\/][0-9]{2}[\/][0-9]{4}$/", $dateOfBirth)) {
          array_push($errors, "date of birth does not match pattern");
          return false;
        }
           

        $splitDOB = explode("/", $dateOfBirth);
        $D = $splitDOB[0];
        $M = $splitDOB[1];
        $Y = $splitDOB[2];

        $listOfDays = [31,28,31,30,31,30,31,31,30,31,30,31];

        $currYear = date("Y");

        if($D>0 && $M>0 && $Y>1900 && $D<32 && $M<13 && $Y<=$currYear) {
					if($M === 2) {
						$leapYear = false;
						if ( (!(yy % 4) && yy % 100) || !(yy % 400)) 
						{	$leapYear = true; }
						if (($leapYear===false) && (dd>28))	{	
              array_push($errors, "day outside range for given month");
              return false ;
            }
						if (($leapYear===true) && (dd>29)) {   
              array_push($errors, "day outside range for given month");
              return false;
            }
						return true;
					}
					else {
						if($D > $listOfDays[$M-1]) {
              array_push($errors, "day outside range for given month");
							return false;
						}
						return true;
					}
				} else {
          array_push($errors, "date of birth outside accepted limits");
          return false;
        }
      }

      function checkEmail($email) {
        if(empty($email)) { 
          array_push($errors, "Email is required");
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { 
          array_push($errors, "invalid email");
        }
      }

      function checkPassword($password) {
        if(empty($password)) { 
          array_push($errors, "Password is required"); 
        }

        if(!preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}$/", $password)) {
          array_push($errors, "password does not match pattern");
        }

        if(strlen($password) > 32) {
          array_push($errors, "password exceeds max length 32");
        }

      }

      function checkName($name) {
        if(empty($name)) { 
          array_push($errors, "full name is required");
       }
       if(strlen($name) > 50) {
        array_push($errors, "first or last name exceeds character limit 50");
       }
       if(preg_match('/[0-9]+/', $name) > 0) {
        array_push($errors, "first or last name contains a number");
       }
      }
    ?>