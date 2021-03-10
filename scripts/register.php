<?php
    session_start();
    
    $email    = "";

    $db = mysqli_connect();

    if(isset($_POST['regEmail']) && isset($_POST['regPassword'])) {
        $email = mysqli_real_escape_string($db, $_POST['regEmail']);
        $password = mysqli_real_escape_string($db, $_POST['regPassword']);

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
          $query = "INSERT INTO users (email, password) 
                VALUES('$email', '$hashPassword')";
          mysqli_query($db, $query);

          $_SESSION['email'] = $email;
          $_SESSION['success'] = "You are now logged in";
          header('location: Home.html');
        }
}
?>