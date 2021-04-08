<?php
        session_start();
        include_once("navBar.php");
        include("database.php");
		
        if(isset($_REQUEST['profileSelected'])) {
          $user = $_REQUEST['profileSelected'];
        } else {
           $user= $_SESSION['userID'];
        }
	
        $searchTerm =  $user ;
        $connectionSearch = $connection->prepare('SELECT * FROM profiles WHERE UserID = ?');
        $connectionSearch->bind_param('s',$searchTerm);
        $connectionSearch->execute();

        $result = $connectionSearch->get_result();
        $row = mysqli_fetch_assoc($result);
        echo $row['FirstName'].' '.$row['LastName'];

?>


<html>
    <head>
      <link rel = "stylesheet"
			href = "https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css"
			integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl"
			crossorigin="anonymous">

    </head>


    <body>
    </body>
</html>