<?php 
            require('database.php');

            session_start();
            $errors = array();

            if (isset($_REQUEST['email'], $_REQUEST['pass'])) {
            
                $email = $_REQUEST['email'];
                $password = $_REQUEST['pass'];
            
                if($emailCheck = $connection->prepare('SELECT UserID,Password,UtypeID FROM users WHERE Email = ?')) {
                    $emailCheck->bind_param('s', $email);
                    $emailCheck->execute();

                    $emailCheck->store_result();
                    if ($emailCheck->num_rows() > 0) {
                        $emailCheck->bind_result($userID, $Password, $userType);
                        $emailCheck->fetch();
                        if (password_verify($password, $Password)) {

                            session_regenerate_id();
                            $_SESSION['loggedin'] = TRUE;
                            $_SESSION['userID'] = $userID;
                            $_SESSION['userType'] = $userType;
            
                            header("location: Home.php");
                        } else {
                            array_push($errors, "Incorrect password or email");
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
                header('location: index.php?register=fail&errors=' . $errors[0]);
            }
?>