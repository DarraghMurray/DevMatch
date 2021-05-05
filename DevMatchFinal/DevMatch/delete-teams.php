<?php
        require("navBar.php");
/*         require("database.php");
		
        $user= $_SESSION['userID'];
	
        $searchTerm =  $user ;
        $connectionSearch = $connection->prepare('SELECT * FROM connections WHERE UserID = ?');
        $connectionSearch->bind_param('s',$searchTerm);
        $connectionSearch->execute();

        $result = $connectionSearch->get_result();
        $row = mysqli_fetch_assoc($result);
        echo $row['FirstName'].' '.$row['LastName']; */

?>

<!DOCTYPE html>
<html>
    <head>
 		<link rel = "stylesheet"
			href = "https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css"
			integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl"
			crossorigin="anonymous">
		<link href="https://fonts.googleapis.com/css2?family=Khula:wght@700&display=swap" rel="stylesheet">

		<link rel="stylesheet" href="CSS/animation.css">
	</head>
	<body>
		<div class="loader">
			<div class="loader-item loader-item_1"></div>
			<div class="loader-item loader-item_2"></div>
			<div class="loader-item loader-item_3"></div>
			<div class="loader-item loader-item_4"></div>
		</div>
		<div class='console-container'><span id='text'></span><div class='console-underscore' id='console'>&#95;</div></div>

		<script type="text/javascript" src="animation.js">
		</script>
    </body>
</html>