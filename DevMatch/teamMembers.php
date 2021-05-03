<?php
		require("navBar.php");
        require("database.php");
		require('checkMemberType.php');

		$user = $_SESSION['userID'];
		$admin = $_SESSION['admin'];
        $teamOwner=false;
        $teamManager=false;
		if(isset($_REQUEST['viewMembers'])) {
			$teamID = $_REQUEST['teamID'];
		}

		if(isset($_REQUEST['memberToRemove'])) {
			$params = array($_REQUEST['membersToRemove'],$teamID);
			$deleteQuery = $db->executeStatement('DELETE FROM members WHERE UserID=? AND TeamID=?','ii',$params);
		}

		checkMember($user,$teamID,$teamManager,$teamOwner);


		//retrieves connections already validated
		$params = array($teamID);
		$members = $db->executeStatement('SELECT UserID FROM members WHERE TeamID = ?','s',$params);
		$membersRes = $members->get_result();

		displaySearchResultProfile($membersRes,$teamID, $teamOwner, $teamManager);
		

		
	// Display search result for the different search
	// Not ideal, relevant field are hard coded and each search has a different display function.
	function displaySearchResultProfile($members, $teamID, $teamOwner, $teamManager) {	 
		if(!mysqli_num_rows($members)) {
			echo'<div class="container">
					No result found.
				</div>';
		} else {
			echo ('
			<div class="container">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h2 class="panel-title">Team Members</h2>
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

				while($row = mysqli_fetch_assoc($members)) {
					include("database.php");

					$searchTerm = $row['UserID'];

					$params = array($searchTerm);
					$searchUser = $db->executeStatement('SELECT profiles.* FROM profiles INNER JOIN users ON profiles.UserID = users.UserID WHERE profiles.UserID = ? AND Banned=0','s',$params);
					$resultUser = $searchUser->get_result();

					while(	$user_row = mysqli_fetch_assoc($resultUser)){
						echo '<tr class="clickableRow" data-href="#">
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
								<form action="profile.php"target="_parent" method="post">
									<input type="hidden" name="profileSelected" value=' .$user_row['UserID'].'>
									<input type="submit" name="View" value="View" />
								</form>
							</td>';
							if($teamOwner || $teamManager) {
							echo '<td>
								<form action="" method="POST">
									<input type="hidden" name="teamID" value='. $teamID .'>
									<input type="hidden" name="memberToRemove" value='.$user_row['UserID'].'>
									<input type="submit" name="Remove" value="Remove"/>
								</form>
							</td>';
							}
						echo'</tr>';
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