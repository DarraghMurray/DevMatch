<?php
		require("session.php");
        require("database.php");
        $user = $_SESSION['userID'];

        if(isset($_REQUEST['accepted'])) {
			echo($_REQUEST['accepted']);
			echo($user);
            $params = array($_REQUEST['accepted'],$user);
			$connectionsQuery = $db->executeStatement('UPDATE connections SET Validated=1 WHERE User1ID=? AND User2ID=?','ii',$params);
        }

		//retrieves connection requests to user
        $params = array($user);
		$connectionRequests = $db->executeStatement('SELECT User1ID,User2ID FROM connections WHERE User1ID = ? AND Validated = 0','s',$params);

		$connectionRequestsRes = $connectionRequests->get_result();

		//retrieves connection requests from user
        $connectionInvitations = $db->executeStatement('SELECT User1ID,User2ID FROM connections WHERE User2ID = ? AND Validated = 0','s',$params);

		$connectionInvitationsRes = $connectionInvitations->get_result();

		if (mysqli_num_rows($connectionRequestsRes)==0 ) 
			$connectionRequestsRes = "";
		else if (mysqli_num_rows($connectionInvitationsRes)==0 )
			$connectionInvitationsRes ="";
	
		displaySearchResultProfile($connectionRequestsRes,$connectionInvitationsRes, $user);
		

		
	// Display search result for the different search
	// Not ideal, relevant field are hard coded and each search has a different display function.
	function displaySearchResultProfile($requests, $Invitations, $user) {	 

        if($Invitations !== "") {
            echo ('
            <div class="container">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2 class="panel-title">Invitations</h2>
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
			while($row = mysqli_fetch_assoc($Invitations)) {
				include("database.php");

				$searchTerm = $row['User1ID'];

				$params = array($searchTerm);
				$searchUser = $db->executeStatement('SELECT * FROM profiles WHERE UserID = ?','s',$params);

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
                            <form action="" method="post">
                                <input type="hidden" name="accepted" value=' .$user_row['UserID']. '>
                                <input type="submit" name="Accept" value="Accept" />
                            </form>
                        </td>
                        <td>
                            <form action="profile.php"target="_parent" method="post">
                                <input type="hidden" name="profileSelected" value=' .$user_row['UserID'].'>
                                <input type="submit" name="View" value="View" />
                            </form>
                        </td>
					</tr>' );
				}
			}
            
            echo (' </table>
            </div>
            </div>');
		}

		if($requests !== "") {

            echo ('
		<div class="container">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h2 class="panel-title">Requests</h2>
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

            include("database.php");
			while(	$row = mysqli_fetch_assoc($requests)) {

				$searchTerm = $row['User2ID'];

				$params = array($searchTerm);
				$searchUser = $db->executeStatement('SELECT * FROM profiles WHERE UserID = ?','s',$params);

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
					</tr>' );
				}
			}
            echo (' </table>
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

