<?php
		require("navBar.php");
        require("database.php");

        $teamID = $_REQUEST['teamID'];

		//retrieves connections already validated
        $vacancies = $connection->prepare('SELECT ManagerID,Role,Description FROM vacancies WHERE TeamID = ? AND Disabled = 0');
        $vacancies->bind_param('s', $teamID);
        $vacancies->execute();

		$vacanciesRes = $vacancies->get_result();

		if (mysqli_num_rows($vacanciesRes)==0 ) {
			$vacanciesRes = "";
		}
		displaySearchResultVacancy($vacanciesRes);
		

		
	// Display search result for the different search
	// Not ideal, relevant field are hard coded and each search has a different display function.
	function displaySearchResultVacancy($vacancies) {	 

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
					<th>Role</th>
					<th>Description</th>
					<th>Manager</th>');
			echo ('
				</tr>
			</thead>');

		if($vacancies !== "") {

			while($row = mysqli_fetch_assoc($vacancies)) {
				include("database.php");

				$searchTerm = $row['ManagerID'];

				$searchUser = $connection->prepare('SELECT * FROM profiles WHERE UserID = ?');
				$searchUser->bind_param('s',$searchTerm);
				$searchUser->execute();

				$resultUser = $searchUser->get_result();

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