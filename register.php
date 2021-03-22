<!DOCTYPE html>
<html>
  <head>
    <title>Registration</title>
    <link rel="stylesheet" href="CSS/intro-styles.css"/>
  </head>
  
  <body>

    <?php
        require('database.php');

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

            
            if(empty($surName) || strlen($surName) > 50) { array_push($errors, "surname is required"); }


            $userAlreadyExists = $connection->prepare('SELECT * FROM users WHERE Email=?');
            $userAlreadyExists->bind_param('s', $email);
            $userAlreadyExists->execute();

            $result = $userAlreadyExists->get_result();
            $user = mysqli_fetch_assoc($result);

            if ($user['Email'] == $email) {
              array_push($errors, "email already exists");
            }

            if(count($errors) == 0) {

              $hashPassword = password_hash($password, PASSWORD_DEFAULT);

              $userTableInsert = $connection->prepare('INSERT INTO users(Email,Password,UTypeID) 
                                                      VALUES(:email,:password,:utypeid)');
              $userTableInsert->bind_param(':email',$email);
              $userTableInsert->bind_param(':password',$hashPassword);
              $userTableInsert->bind_param(':utypeid',1);
              $userTableInsert->execute();

              $userID = mysqli_insert_id($connection);

              $profileTableInsert = $connection->prepare('INSERT INTO profiles(UserID,FirstName,LastName,Gender,DateOfBirth,Country) 
                                                      VALUES(:userid,:firstname,:lastname,:gender,:dateofbirth,:country)');
              $profileTableInsert->bind_param(':userid',$userID);
              $profileTableInsert->bind_param(':firstname',$firstName);
              $profileTableInsert->bind_param(':lastname',$surName);
              $profileTableInsert->bind_param(':gender',$gender);
              $profileTableInsert->bind_param(':dateofbirth',$dateOfBirth);
              $profileTableInsert->bind_param(':country',$country);
              $profileTableInsert->execute();

              $_SESSION['Registered'] = "You are now registered";
              header('location: index.html');
            } else {
              echo $errors[0];
              header('location: index.html');
            }
    } else {
      header('location: index.html');
    }

      function checkDateValid($dateOfBirth) {

        if(empty($dateOfBirth)) { 
          array_push($errors, "date of birth is required");
          return false; 
        }
        if(!preg_match("/^[0-9]{2}[/][0-9]{2}[/][0-9]{4}$/", $dateOfBirth)) {
          array_push($errors, "date of birth does not match pattern");
          return false;
        }
           

        $splitDOB = implode("/", $dateOfBirth);
        $D = $splitDOB[0];
        $M = $splitDOB[1];
        $Y = $splitDOB[2];

        $listOfDays = [31,28,31,30,31,30,31,31,30,31,30,31];

        $currYear = date("Y");

        if($D>0 && $M>0 && $Y>1900 && $D<32 && $M<13 && $Y<=currYear) {
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

  </body>
</html>