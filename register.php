<?php
    session_start();
    
    $email    = "";

    $errors = array();

    $servername='localhost';
    $UserName='root';
    $PassWord='';
    $dbName='cs4116webdb';

    $connection= mysqli_connect($servername,$UserName,$PassWord,$dbName);

    if ($connection->connect_error) {
      die("Connection Failed:" .$connection->connect_error);
    }

    echo "Connected Successfully";

    if(isset($_POST['regEmail']) && isset($_POST['regPass'])) {
        $email = mysqli_real_escape_string($connection, $_POST['regEmail']);
        $password = mysqli_real_escape_string($connection, $_POST['regPass']);

        if (empty($email)) { array_push($errors, "Email is required"); }
        if (empty($password)) { array_push($errors, "Password is required"); }

        $userAlreadyExists= "SELECT * FROM users WHERE Email='$email'";
        $result = mysqli_query($connection, $userAlreadyExists);
        $user = mysqli_fetch_assoc($result);

        if ($user['Email'] == $email) {
          array_push($errors, "email already exists");
        }

        if(count($errors) == 0) {

          $hashPassword = password_hash($password, PASSWORD_DEFAULT);
          $query = "INSERT INTO users (Email, Password, UTypeID) 
                VALUES('$email', '$hashPassword', 1)";
          mysqli_query($connection, $query);

          $_SESSION['Registered'] = "You are now registered";
          header('location: Intro.html');
        } else {
          echo $errors[0];
          header('location: Intro.html');
        }
}
?>