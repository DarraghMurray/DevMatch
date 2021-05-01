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
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	
    </head>

    <body>
	<?php
	$selected=$_GET['searchType'];
	?>	<div class="container p-5">
			<div class="panel panel-default m-2 p-5">
				<h1>Search :</h1>
				
				<form class="form-inline" id="searchForm" action="Search.php" name="searchForm" method="GET">
					<div class="form-group">
						<label class="control-label p-1" for="searchType">Type:</label>
						<select class="form-control" name="searchType" id="searchType">
							<option value=0 <?php if($selected == '0'){echo("selected");}?>>User</option>		<!-- selected keeps the selected comboBox option on submission --> 
							<option value=1 <?php if($selected == '1'){echo("selected");}?>>Team</option>
							<option value=2 <?php if($selected == '2'){echo("selected");}?>>Vacancy</option>
						</select>
					</div>
					<div class="form-group p-1">
						<label class="control-label p-1" for="searchType">Search:</label>
						<input class "form-control input-default" type="text" name="searchTerm" id="searchTerm" placeholder="Quick search ...">
						<div class="input-group-btn">
							<button class="btn btn-outline-success my-2 my-sm-0" type="submit" name="search">
								<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
									<path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
								</svg>
							</button>
						</div>
					</div>
				</form>
				<!--<button class="btn btn-light" type="button" data-toggle="collapse" data-target=".collapseForm" aria-expanded="false" aria-controls="collapseForm">
				<div class="collapse" id="collapseForm">-->
					<div class="card card-body">
						<h4> Search User </h4>
						<form class="form-inline" id="searchForm" action="Search.php" name="searchForm" method="GET">
							<input type="hidden" id="searchType" name="searchType" value="0">
							<div class="form-group p-1">
								<label class="control-label p-1" for="searchTerm">Name:</label>
								<input class "form-control input-default" type="text" name="searchTerm" id="searchTerm" placeholder="Name ...">
							</div>
							<div class="form-group p-1">
								<label class="control-label p-1" for="searchUserCountry">Country:</label>
								<input class "form-control input-default" type="text" name="searchUserCountry" id="searchUserCountry" placeholder="Country ...">
							</div>
							<div class="input-group-btn">
									<button class="btn btn-outline-success my-2 my-sm-0" type="submit" name="search">
										<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
											<path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
										</svg>
									</button>
								</div>
						</form>
					</div>
					<div class="card card-body">
						<h4> Search Team </h4>
						<form class="form-inline" id="searchForm" action="Search.php" name="searchForm" method="GET">
							<input type="hidden" id="searchType" name="searchType" value="1">
							<div class="form-group p-1">
								<label class="control-label p-1" for="searchTerm">Name:</label>
								<input class "form-control input-default" type="text" name="searchTerm" id="searchTerm" placeholder="Team name ...">
							</div>
							<div class="form-group p-1">
								<label class="control-label p-1"> Creation date:</label>
								<input class="form-control" type="date" id="searchCreationDate" name="searchCreationDate">
								<label class="control-label p-1" for="searchCompareDate"> or </label>
								<select class="form-control" name="searchCompareDate" id="searchCompareDate">
									<option value=0 >earlier</option>
									<option value=1 >later</option>
								</select>
							</div>
							<div class="input-group-btn">
								<button class="btn btn-outline-success my-2 my-sm-0" type="submit" name="search">
									<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
										<path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
									</svg>
								</button>
							</div>
						</form>
					</div>
				<!--</div>-->
			</div>
		</div>
      <?php
        if(isset($_REQUEST['search'])) {

			$searchType = intval($_REQUEST['searchType']);
            $searchTerm = $_REQUEST['searchTerm'];
			if (isset($_REQUEST['searchUserCountry'])){
				$searchCountry=$_REQUEST['searchUserCountry'];
			} else {$searchCountry='';}
			if (isset($_REQUEST['searchCompareDate'])){	
				$searchCompareDate=intval($_REQUEST['searchCompareDate']);
			} else {$searchCompareDate=1;}	
			if (isset($_REQUEST['searchCreationDate'])){
				$searchCreationDate=$_REQUEST['searchCreationDate'];
			} else {$searchCreationDate=0; $searchCompareDate=1;}

            if($searchType === 0) {
				$searchTerm = '%' . $searchTerm . '%';
				$searchCountry='%'.$searchCountry.'%';
                $connectionSearch = $connection->prepare('SELECT profiles.UserID,profiles.FirstName, profiles.LastName, 
														profiles.Gender, profiles.Country, profiles.Employment FROM profiles 
														INNER JOIN users ON profiles.UserID=users.UserID WHERE users.Banned=0 
														AND CONCAT(profiles.FirstName, " ", profiles.LastName) LIKE ? 
														AND Country LIKE ?');
				//'SELECT * FROM profiles WHERE CONCAT(FirstName, " ", LastName) LIKE ? AND Country LIKE ?'
                $connectionSearch->bind_param('ss',$searchTerm,$searchCountry);
                $connectionSearch->execute();

                $result = $connectionSearch->get_result();
                /*while($row = mysqli_fetch_assoc($result)) {
					print_r($row);
                }*/
				displaySearchResultProfile($result);
            } else if($searchType === 1) {
				$searchTerm = '%' . $searchTerm . '%';
				if ($searchCompareDate==0){
					$teamSearch = $connection->prepare('SELECT * FROM teams WHERE Name LIKE ? AND CreationDate <= ?');	//Translation from date in php to datetime in mysql is automatic, they can be compared directly
				} else {
					$teamSearch = $connection->prepare('SELECT * FROM teams WHERE Name LIKE ? AND CreationDate >= ?');
				}
                $teamSearch->bind_param('ss', $searchTerm, $searchCreationDate);
                $teamSearch->execute();

                $result = $teamSearch->get_result(); 
                /* while($row = mysqli_fetch_assoc($result)) {
                    print_r($row);
                } */
				displaySearchResultTeam($result);
            } else if($searchType === 2) {
                $searchTerm = '%' . $searchTerm . '%';
                $vacancySearch = $connection->prepare('SELECT * FROM vacancies, teams WHERE teams.TeamID=vacancies.TeamID AND Role LIKE ?');
                $vacancySearch->bind_param('s', $searchTerm);
                $vacancySearch->execute();

                $result = $vacancySearch->get_result();
                /* while($row = mysqli_fetch_assoc($result)) {
                    print_r($row);
                } */
				displaySearchResultVacancies($result);
            }
        }
		
	// Display search result for the different search
	// Not ideal, relevant field are hard coded and each search has a different display function.
	function displaySearchResultProfile($mysqlResult){
		if (!mysqli_num_rows($mysqlResult)){
			echo ('
			<div class="container">
				No result found.
			</div>	
			');
		} else {	 
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
	}
	
	function displaySearchResultTeam($mysqlResult){	 
		if (!mysqli_num_rows($mysqlResult)){
			echo ('
			<div class="container">
				No result found.
			</div>	
			');
		} else {
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
	}
	
		function displaySearchResultVacancies($mysqlResult){
			if (!mysqli_num_rows($mysqlResult)){
				echo ('
				<div class="container">
					No result found.
				</div>	
				');
			} else {	 
				echo ('
				<div class="container">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h2 class="panel-title">Results</h2>
						</div>
					<table class="table table-bordered table-condensed table-hover">
					<thead class="thead-dark">
						<tr>');
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
								'.$row['Name'].'
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
		}
    ?>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    </body>
</html>

