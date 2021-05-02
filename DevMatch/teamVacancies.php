<?php
		require("navBar.php");
		require("database.php");
		
?>

<html>
    <head>
      <link rel = "stylesheet"
			href = "https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css"
			integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl"
			crossorigin="anonymous">
		<link rel="stylesheet" href="CSS/teamProfile.css">
    </head>

    <body>

	<div class="text-right">
		<?php

			if(isset($_REQUEST['viewVacancies'])) {
				$teamID = $_REQUEST['teamID'];
				$memberType = intval($_REQUEST['memberType']);
			}

			if($memberType === 2 || $memberType === 3) {
				echo('<form action="createVacancy.php" method="post">
					<input type="hidden" name="vacTeamID" value='. $teamID.'>
					<input type="submit" value="Add Vacancy">
				</form>');
			}
			
		?>
	</div>
		
    </body>
</html>

<?php

	// Get all enabled vacancies of the team
	$vacancies = $connection->prepare('SELECT VacID,ManagerID,Role,Description FROM vacancies WHERE TeamID = ? AND Disabled = 0');
	$vacancies->bind_param('s', $teamID);
	$vacancies->execute();

	$vacanciesRes = $vacancies->get_result();

	if (mysqli_num_rows($vacanciesRes)==0 ) {
		$vacanciesRes = "";
	}
	displaySearchResultVacancy($vacanciesRes);
		

		
	// Display search result
	// Not ideal, relevant field are hard coded and each search has a different display function.
	function displaySearchResultVacancy($vacancies) {	 

		echo ('
		
		<div class="container">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h2 class="panel-title">Team Vacancies</h2>
				</div>
			<table class="table table-bordered table-condensed table-hover">
			<thead class="thead-dark">
				<tr>');

					echo('
					<th>Role</th>
					<th>Description</th>
					<th>Manager</th>');
			echo ('
				</tr>
			</thead>');

		if($vacancies !== "") {
			while($row = mysqli_fetch_assoc($vacancies)) {
				include("database.php");

				// Get Name corresponding to ManagerID
				$searchTerm = $row['ManagerID'];

				$searchUser = $connection->prepare('SELECT * FROM profiles WHERE UserID = ?');
				$searchUser->bind_param('s',$searchTerm);
				$searchUser->execute();

				$resultUser = $searchUser->get_result();

				// Table display + Links to vacancy page
				while(	$user_row = mysqli_fetch_assoc($resultUser)){
					echo ('<tr class="clickableRow" data-href="#">
                        <td>'
                            .$row['Role'].
                        '</td>
                        <td>'
                            .$row['Description'].
                        '</td>
						<td>
							'.$user_row['FirstName'].' '.$user_row['LastName'].'
						</td>
						<td>		
							<form action="vacancy.php" method="POST">
								<input type="hidden" name="teamVacancySelected" value='.$row['VacID']. '>
								<input type="submit" name="View" value="View">
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
    
   