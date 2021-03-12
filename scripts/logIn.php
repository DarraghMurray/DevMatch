<?php 

    session_start();

    $email    = "";

    $db = mysqli_connect("localhost","root","Drombanna1","cs4116Webdb");

    if (isset($_POST['email']) && isset($_POST['passWord'])) {
        $email = mysqli_real_escape_string($db, $_POST['email']);
        $password = mysqli_real_escape_string($db, $_POST['Password']);
    
        if (empty($email)) {
            array_push($errors, "Email is required");
        }
        if (empty($password)) {
            array_push($errors, "Password is required");
        }
    
        if (count($errors) == 0) {
            $hashPassword = password_hash()
            $query = "SELECT * FROM users WHERE email='$email' AND password='$hashPassword'";
            $results = mysqli_query($db, $query);
            if (mysqli_num_rows($results) == 1) {
                $_SESSION['email'] = $email;
                $_SESSION['success'] = "You are now logged in";
                header('location: Home.html');
            }else {
                array_push($errors, "Wrong username/password combination");
            }
        }
    }
    
    


?>