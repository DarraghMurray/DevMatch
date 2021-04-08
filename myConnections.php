<?php
        session_start();
        include("database.php");
        $user = $_SESSION['userID'];

		//retrieves connection requests to user
        $connectionRequests = $connection->prepare('SELECT User1ID,User2ID FROM connections WHERE User1ID = ? AND Validated = "0"');
        $connectionRequests->bind_param('s', $user);
        $connectionRequests->execute();

		$connectionRequestsRes = $connectionRequests->get_result();

		//retrieves connection requests from user
        $connectionInvitations = $connection->prepare('SELECT User1ID,User2ID FROM connections WHERE User2ID = ? AND Validated = "0"');
        $connectionInvitations->bind_param('s', $user);
        $connectionInvitations->execute();

		$connectionInvitationsRes = $connectionInvitations->get_result();

		//retrieves connections already validated
        $connections = $connection->prepare('SELECT User1ID,User2ID FROM connections WHERE (User1ID = ? OR User2ID = ?) AND Validated = "1"');
        $connections->bind_param('ss', $user, $user);
        $connections->execute();

		$connectionsRes = $connections->get_result();

		if (mysqli_num_rows($connectionRequestsRes)==0 ) 
			$connectionRequestsRes = "";
		else if (mysqli_num_rows($connectionInvitationsRes)==0 )
			$connectionInvitationsRes ="";
		else if (mysqli_num_rows($connectionsRes)==0 ) 
			$connectionsRes = "";
	
		displaySearchResultProfile($connectionRequestsRes,$connectionInvitationsRes, $connectionsRes, $user);
		

		
	// Display search result for the different search
	// Not ideal, relevant field are hard coded and each search has a different display function.
	function displaySearchResultProfile($requests, $Invitations, $validatedConnections, $user) {	 


		echo ('
		<div class="container">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h2 class="panel-title">My Connections</h2>
				</div>
			<table class="table table-bordered table-condensed table-hover">
			<thead class="thead-dark">
				<tr><h3>Connection requests</h3></tr>
				<tr>');

					echo('
					<th>Name</th>
					<th>Gender</th>
					<th>Country</th>
					<th>Employment</th>');
			echo ('
				</tr>
			</thead>');
	
		if($requests !== "") {
			while(	$row = mysqli_fetch_assoc($requests)) {

				include("database.php");

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
			}
		}

		if($Invitations !== "") {
			echo('<div class="panel-heading">
					<h3 class="panel-title">Connection Invitations</h3>
				</div>');
			while($row = mysqli_fetch_assoc($Invitations)) {
				include("database.php");

				$searchTerm = $row['User1ID'];

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
			}
		}

		if($validatedConnections !== "") {

			while($row = mysqli_fetch_assoc($validatedConnections)) {
				include("database.php");

				if($row['User1ID'] != $user) {
					$searchTerm = $row['User1ID'];
				} else {
					$searchTerm = $row['User2ID'];
				}

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

