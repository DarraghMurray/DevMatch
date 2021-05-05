<?php
		require("session.php");
        require("database.php");
        $user = $_SESSION['userID'];

		if(isset($_REQUEST['connectionDeleted'])) {
            $params = array($_REQUEST['connectionDeleted'],$user,$user,$_REQUEST['connectionDeleted']);
			$deleteQuery = $db->executeStatement('DELETE FROM connections WHERE (User1ID=? AND User2ID=?) OR (User1ID=? AND user2ID=?)','iiii',$params);
        }
		//retrieves connections already validated
        $params = array($user,$user);
		$connections = $db->executeStatement('SELECT User1ID,User2ID FROM connections WHERE (User1ID = ? OR User2ID = ?) AND Validated = 1','ii',$params);

		$connectionsRes = $connections->get_result();

		if (mysqli_num_rows($connectionsRes)==0 ) 
			$connectionsRes = "";
	
		displaySearchResultProfile($connectionsRes, $user);
		

		
	// Display search result for the different search
	// Not ideal, relevant field are hard coded and each search has a different display function.
	function displaySearchResultProfile($validatedConnections, $user) {	 


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

		if($validatedConnections !== "") {

			while($row = mysqli_fetch_assoc($validatedConnections)) {
				include("database.php");

				if(intval($row['User1ID']) == $user) {
					$searchTerm = $row['User2ID'];
				} else if(intval($row['User2ID']) == $user) {
					$searchTerm = $row['User1ID'];
				}

				$params = array($searchTerm);
				$searchUser = $db->executeStatement('SELECT profiles.* FROM profiles INNER JOIN users ON profiles.UserID = users.UserID WHERE profiles.UserID = ? AND Banned=0','s',$params);

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
						<td>
							<form action="profile.php" target="_parent" method="post">
								<input type="hidden" name="profileSelected" value=' .$user_row['UserID'].'>
								<input type="submit" name="View" value="View" />
							</form>
						</td>
						<td>
							<form action="" method="post">
								<input type="hidden" name="connectionDeleted" value=' .$user_row['UserID']. '>
								<input type="submit" name="Delete" value="Delete" />
							</form>
						</td>
					</tr>' );
				}
			}
		}
		
		echo (' </table>
				</div>
				</div>');
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

