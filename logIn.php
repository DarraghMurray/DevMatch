<!DOCTYPE html>
<html>
  <head>
    <title>Log-In</title>
    <link rel="stylesheet" href="CSS/intro-style.css"/>
  </head>
  <body>
        <?php 
            require('database.php');

            session_start();
            $errors = array();

            if (isset($_REQUEST['email'], $_REQUEST['pass'])) {
            
                $email = $_POST['email'];
                $password = $_POST['pass'];
            
                if($emailCheck = $connection->prepare('SELECT UserID,Password FROM users WHERE Email = ?')) {
                    $emailCheck->bind_param('s', $email);
                    $emailCheck->execute();

                    $emailCheck->store_result();
                    if ($emailCheck->num_rows() > 0) {
                        $emailCheck->bind_result($userID, $Password);
                        $emailCheck->fetch();
                        if (password_verify($password, $Password)) {

                            session_regenerate_id();
                            $_SESSION['loggedin'] = TRUE;
                            $_SESSION['name'] = $_POST['username'];
                            $_SESSION['userID'] = $id;

                            header("location: Home.php");
                        } else {
                            // Incorrect password
                            echo 'Incorrect email and/or password!';
                        }
                    } else {
                        // Incorrect email
                        echo 'Incorrect email and/or password!';
                    }
                } else {
                    echo 'login failed';
                }
                    $emailCheck->close();
                    
            } else {
                exit('Please fill both the username and password fields!');
            }
            
        ?>

  </form>
    </body>
</html>