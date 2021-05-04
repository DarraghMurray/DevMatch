<html>
    <head>
      <link rel = "stylesheet"
			href = "https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css"
			integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl"
			crossorigin="anonymous">
    </head>

    <body>
      <?php
        include("database.php");

			$connectionSearch = $db->executeStatement('SELECT profiles.* FROM profiles INNER JOIN users ON profiles.UserID=users.UserID WHERE Banned=0');
			$result = $connectionSearch->get_result();
	
			displaySearchResultProfile($result);
    

		
	// Display search result for the different search
	// Not ideal, relevant field are hard coded and each search has a different display function.
	function displaySearchResultProfile($mysqlResult){	 
		echo ('
		<div class="container">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h2 class="panel-title">All Connections</h2>
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

