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

    if(isset($_POST['register'])) {
        $email = mysqli_real_escape_string($connection, $_POST['regEmail']);
        $password = mysqli_real_escape_string($connection, $_POST['regPass']);
        $firstName = mysqli_real_escape_string($connection, $_POST['firstName']);
        $surName = mysqli_real_escape_string($connection, $_POST['surName']);
        $gender = mysqli_real_escape_string($connection, $_POST['gender']);

        $oldDate = $_POST['dateOfBirth'];
        $newDate = strtotime($oldDate);
        $dateOfBirth = date("Y-m-d", $newDate);

        $country = mysqli_real_escape_string($connection, $_POST['country']);

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
                VALUES('$email', '$hashPassword', 1);";
          mysqli_query($connection, $query);

          $userID = mysqli_insert_id($connection);
          
          $profileInfoInsert = "INSERT INTO profiles (UserID, FirstName, LastName, Gender, DateOfBirth, Country)
                                  VALUES('$userID','$firstName','$surName','$gender','$dateOfBirth','$country');";
          if(mysqli_query($connection, $profileInfoInsert)){
            echo "Records inserted successfully.";
        } else{
            echo "ERROR: Could not able to execute $profileInfoInsert. " . mysqli_error($connection);
        }

          $_SESSION['Registered'] = "You are now registered";
          header('location: Intro.html');
        } else {
          echo $errors[0];
          header('location: Intro.html');
        }
}
?>