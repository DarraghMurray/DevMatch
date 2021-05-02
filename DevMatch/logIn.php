<?php 
            require('database.php');

            session_start();
            $errors = array();

            if (isset($_REQUEST['email'], $_REQUEST['pass'])) {
            
                $email = $_REQUEST['email'];
                $password = $_REQUEST['pass'];
            
                $params = array($email);
                $emailCheck = $db->executeStatement('SELECT UserID,Password,UtypeID,Banned FROM users WHERE Email = ?', 's',$params);
    
                if($emailCheck) {
                    $emailCheck->store_result();
                    if ($emailCheck->num_rows() > 0) {
                        $emailCheck->bind_result($userID, $Password, $userType, $Banned);
                        $emailCheck->fetch();
                        if(!$Banned) {
                            if (password_verify($password, $Password)) {

                                session_regenerate_id();
                                $_SESSION['loggedin'] = TRUE;
                                $_SESSION['userID'] = $userID;
                                $_SESSION['userType'] = $userType;
                
                                header("location: Home.php");
                            } else {
                                array_push($errors, "Incorrect password or email");
                            }
                        } else {
                            array_push($errors, "Account has been suspended");
                        }
                    $emailCheck->close();
                    } else {
                        array_push($errors, "Incorrect password or email");
                    }
                } else {
                    array_push($errors, "log-in failed");
                }       
            } else {
                array_push($errors, "all fields must be filled");
            }

            if(count($errors) != 0) {
                header('location: index.php?logIn=fail&error=' . $errors[0]);
            }
?>