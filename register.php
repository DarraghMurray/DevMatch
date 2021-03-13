<?php
    session_start();
    
    $email    = "";

    $errors;

    $servername='localhost';
    $username='root';
    $password='';
    $dbName='cs4116webdb';

    $connection= mysqli_connect($servername,$username,$password,$dbName);

    if ($connection->connect_error) {
      die("Connection Failed:" .$connection->connect_error);
    }

    echo "Connected Successfully";

    if(isset($_POST['regEmail']) && isset($_POST['regPass'])) {
        $email = mysqli_real_escape_string($connection, $_POST['regEmail']);
        $password = mysqli_real_escape_string($connection, $_POST['regPass']);

        if (empty($email)) { array_push($errors, "Email is required"); }
        if (empty($password_1)) { array_push($errors, "Password is required"); }

        $userAlreadyExists= "SELECT * FROM users WHERE email='$email' LIMIT 1";
        $result = mysqli_query($connection, $userAlreadyExists);
        $user = mysqli_fetch_assoc($result);

        if ($user['email'] === $email) {
          array_push($errors, "email already exists");
        }

        if(count($errors) == 0) {

          $hashPassword = password_hash($password, PASSWORD_DEFAULT);
          $query = "INSERT INTO users (Email, Password, UTypeID) 
                VALUES('$email', '$hashPassword', 1)";
          mysqli_query($connection, $query);

          $_SESSION['email'] = $email;
          $_SESSION['success'] = "You are now logged in";
          header('location: Home.php');
        } else {
          //header('location: Intro.html');
        }
}
?>