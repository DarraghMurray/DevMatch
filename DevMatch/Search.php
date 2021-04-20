<?php
	require("navBar.php");
	require("database.php");
	if(isset($_REQUEST['userToAdd'])) {
		$connectionsQuery = $connection->prepare('INSERT INTO connections(User1ID,User2ID,RequestDate) VALUES(?,?,now())');
		$connectionsQuery->bind_param('ii', $_SESSION['userID'], $_REQUEST['userToAdd']);
		$connectionsQuery->execute();
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
      <?php
        if(isset($_REQUEST['search'])) {

            $searchType = intval($_REQUEST['searchType']);
            $searchTerm = $_REQUEST['searchTerm'];

            if($searchType === 0) {
                $searchTerm = '%' . $searchTerm . '%';
                $connectionSearch = $connection->prepare('SELECT * FROM profiles WHERE CONCAT(FirstName, " ", LastName) LIKE ?');
                $connectionSearch->bind_param('s',$searchTerm);
                $connectionSearch->execute();

                $result = $connectionSearch->get_result();
                /*while($row = mysqli_fetch_assoc($result)) {
					print_r($row);
                }*/
				displaySearchResultProfile($result);
            } else if($searchType === 1) {
                $searchTerm = '%' . $searchTerm . '%';
                $teamSearch = $connection->prepare('SELECT * FROM teams WHERE Name LIKE ?');
                $teamSearch->bind_param('s', $searchTerm);
                $teamSearch->execute();

                $result = $teamSearch->get_result(); 
                /*while($row = mysqli_fetch_assoc($result)) {
                    print_r($row);
                }*/
				displaySearchResultTeam($result);
            } else if($searchType === 2) {
                $searchTerm = '%' . $searchTerm . '%';
                $vacancySearch = $connection->prepare('SELECT * FROM vacancies WHERE Role LIKE ?');
                $vacancySearch->bind_param('s', $searchTerm);
                $vacancySearch->execute();

                $result = $vacancySearch->get_result();
                /*while($row = mysqli_fetch_assoc($result)) {
                    print_r($row);
                }*/
				displaySearchResultVacancies($result);
            }
        }
		
	// Display search result for the different search
	// Not ideal, relevant field are hard coded and each search has a different display function.
	function displaySearchResultProfile($mysqlResult){	 
		echo ('
		<div class="container">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h2 class="panel-title">Results</h2>
				</div>
			<table class="table table-bordered table-condensed table-hover">
			<thead class="thead-dark">
				<tr>');
			/*while($finfo=$mysqlResult->fetch_field()){ //We don't want every field
				echo ('
					<th>'.$finfo->name.'</th>
				');
			}*/
				echo('
					<th>Name</th>
					<th>Gender</th>
					<th>Country</th>
					<th>Employment</th>');
			echo ('
				</tr>
			</thead>');
			while($row = mysqli_fetch_assoc($mysqlResult)) {
				echo('<tr class="clickableRow" data-href="#">
					<td>
						'.$row['FirstName'].' '.$row['LastName'].'
					</td>
					<td>
						'.$row['Gender'].'
					</td>
					<td>
						'.$row['Country'].'
					</td>
					<td>
						'.$row['Employment'].'
					</td>
					<td>
						<form action="" method="post">
							<input type="hidden" name="userToAdd" value=' .$row['UserID']. '>
							<input type="submit" name="Add" value="Add" />
						</form>
					</td>
					<td>
						<form action="profile.php" method="post">
							<input type="hidden" name="profileSelected" value=' .$row['UserID'].'>
							<input type="submit" name="View" value="View" />
						</form>
					</td>
				</tr>');
			}
		echo ('
		</table>
		</div>
		</div>');
	}
	
	function displaySearchResultTeam($mysqlResult){	 
		echo ('
		<div class="container">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h2 class="panel-title">Results</h2>
				</div>
			<table class="table table-bordered table-condensed table-hover">
			<thead class="thead-dark">
				<tr>');
			/*while($finfo=$mysqlResult->fetch_field()){ //We don't want every field
				echo ('
					<th>'.$finfo->name.'</th>
				');
			}*/
				echo('
					<th>Name</th>
					<th>Creation date</th>
					<th>Description</th>');
			echo ('
				</tr>
			</thead>');
			while($row = mysqli_fetch_assoc($mysqlResult)) {
				echo('<tr class="clickableRow" data-href="#">
					<td>
						'.$row['Name'].'
					</td>
					<td>
						'.$row['CreationDate'].'
					</td>
					<td>
						'.$row['Description'].'
					</td>
				</tr>');
			}
		echo ('
		</table>
		</div>
		</div>');
	}
	
		function displaySearchResultVacancies($mysqlResult){	 
		echo ('
		<div class="container">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h2 class="panel-title">Results</h2>
				</div>
			<table class="table table-bordered table-condensed table-hover">
			<thead class="thead-dark">
				<tr>');
			/*while($finfo=$mysqlResult->fetch_field()){ //We don't want every field
				echo ('
					<th>'.$finfo->name.'</th>
				');
			}*/
				echo('
					<th>Role</th>
					<th>Team</th>
					<th>Description</th>');
			echo ('
				</tr>
			</thead>');
			while($row = mysqli_fetch_assoc($mysqlResult)) {
				echo('<tr class="clickableRow" data-href="#">
					<td>
						'.$row['Role'].'
					</td>
					<td>
						Not implemented yet
					</td>
					<td>
						'.$row['Description'].'
					</td>
				</tr>');
			}
		echo ('
		</table>
		</div>
		</div>');
	}
    ?>
    </body>
</html>

