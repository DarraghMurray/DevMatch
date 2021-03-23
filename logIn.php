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
            $email = "";
            $errors = array();

            if (isset($_POST['logIn'])) {
                $email = mysqli_real_escape_string($connection, $_POST['email']);
                $password = mysqli_real_escape_string($connection, $_POST['pass']);
            
                if (empty($email)) { array_push($errors, "Email is required"); }
                if (empty($password)) { array_push($errors, "Password is required");  }
            
                $emailCheck = $connection->prepare('SELECT * FROM users WHERE Email = ?');
                $emailCheck->bind_param('s', $email);
                $emailCheck->execute();

                $result = $emailCheck->get_result();
                $user = mysqli_fetch_assoc($result);
    
                if( mysqli_num_rows($result) == 1) {
                    if(!password_verify($password, $user['Password'])) {  array_push($errors, "Password is incorrect"); }
                } else {
                    array_push($errors, "No account with given email");
                }

                if (count($errors) == 0) {
                        $_SESSION['userID'] = $user['UserID'];
                        $_SESSION['success'] = "You are now logged in";
                        echo "success";
                        header("location: Home.php");
                } else {
                    echo $errors[0];
                    header("location: index.html");
                }
            }
            
        ?>

  </form>
    </body>
</html>