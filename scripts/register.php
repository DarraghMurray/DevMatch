<?php
    session_start();

    echo "hello";
    
    $email    = "";

    $db = mysqli_connect('localhost','root','','cs4116webdb');
    
    echo $_POST["regPass"];

    if(isset($_POST['regEmail']) && isset($_POST['regPass'])) {
        $email = mysqli_real_escape_string($db, $_POST['regEmail']);
        $password = mysqli_real_escape_string($db, $_POST['regPass']);

        echo $email;

        if (empty($email)) { array_push($errors, "Email is required"); }
        if (empty($password_1)) { array_push($errors, "Password is required"); }

        $userAlreadyExists= "SELECT * FROM users WHERE email='$email' LIMIT 1";
        $result = mysqli_query($db, $userAlreadyExists);
        $user = mysqli_fetch_assoc($result);

        if ($user['email'] === $email) {
          array_push($errors, "email already exists");
        }

        if(count($errors) == 0) {

          $hashPassword = password_hash($password, PASSWORD_DEFAULT);
          $query = "INSERT INTO users (Email, Password) 
                VALUES('$email', '$hashPassword')";
          mysqli_query($db, $query);

          $_SESSION['email'] = $email;
          $_SESSION['success'] = "You are now logged in";
          header('location: Home.html');
        } else {
          header('location: Intro.html');
        }
}
?>