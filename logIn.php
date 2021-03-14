<?php 

    session_start();
        
    $email = "";

    $errors = array();

    $servername='localhost';
    $UserName = 'root';
    $PassWord='';
    $dbName='cs4116webdb';

    $connection= mysqli_connect($servername,$UserName,$PassWord,$dbName);

    if ($connection->connect_error) {
        die("Connection Failed:" .$connection->connect_error);
    }

    echo "Connected Successfully";

    if (isset($_POST['email']) && isset($_POST['pass'])) {
        $email = mysqli_real_escape_string($connection, $_POST['email']);
        $password = mysqli_real_escape_string($connection, $_POST['pass']);
    
        if (empty($email)) { array_push($errors, "Email is required"); }
        if (empty($password)) { array_push($errors, "Password is required");  }
    
        $query = "SELECT * FROM users WHERE Email='$email'";
        $result = mysqli_query($connection, $query);
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
        } else {
            echo $errors[0];
        }
    }
    
    


?>