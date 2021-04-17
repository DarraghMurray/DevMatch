<?php
        session_start();
        include("database.php");
        $user= $_SESSION['userID'];
	
		$searchTerm =  $user ;
        $connectionSearch = $connection->prepare('SELECT User1ID,User2ID FROM connections WHERE User1ID = ? or User2ID= ?');
        $connectionSearch->bind_param('ss',$searchTerm, $user);
        $connectionSearch->execute();


        $result = $connectionSearch->get_result();
		if (mysqli_num_rows($result)==0) 
		echo "No connections associated";
		else
		displaySearchResultProfile($result, $user);
		

		
	// Display search result for the different search
	// Not ideal, relevant field are hard coded and each search has a different display function.
	function displaySearchResultProfile($mysqlResult, $user){	 


		echo ('
		<div class="container">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h2 class="panel-title">My Connections</h2>
				</div>
			<table class="table table-bordered table-condensed table-hover">
			<thead class="thead-dark">
				<tr>');

					echo('
					<th>Name</th>
					<th>Gender</th>
					<th>Country</th>
					<th>Employment</th>');
			echo ('
				</tr>
			</thead>');
	
		while(	$row = mysqli_fetch_assoc($mysqlResult)) {
			//after getting the connection's id, I want to get its data - idk who was the first in connection - either user1id or 2, so I have to check for both
			//query for id

			include("database.php");

			if ($user !=$row['User1ID'])
			$searchTerm = $row['User1ID'];
			else
			$searchTerm = $row['User2ID'];

			$searchUser = $connection->prepare('SELECT * FROM profiles WHERE UserID = ?');
			$searchUser->bind_param('s',$searchTerm);
			$searchUser->execute();

			$resultUser = $searchUser->get_result();

			while(	$user_row = mysqli_fetch_assoc($resultUser)){
				echo ('<tr class="clickableRow" data-href="#">
				<td>
					'.$user_row['FirstName'].' '.$user_row['LastName'].'
				</td>
				<td>
					'.$user_row['Gender'].'
				</td>
				<td>
					'.$user_row['Country'].'
				</td>
				<td>
					'.$user_row['Employment'].'
				</td>
			</tr>' );
		}
			echo ('
			</table>
			</div>
			</div>');
			

		}
	}


	

	
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

