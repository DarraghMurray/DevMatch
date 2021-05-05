
<html>
    <head>
      <link rel = "stylesheet"
			href = "https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css"
			integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl"
			crossorigin="anonymous">
    </head>

    <body>
      <?php
        require("database.php");
      
		$teamSearch = $db->executeStatement('SELECT * FROM teams');
		$result = $teamSearch->get_result(); 
	 
		displaySearchResultTeam($result);
  
	function displaySearchResultTeam($mysqlResult){	 
		echo ('
		<div class="container">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h2 class="panel-title">All Teams</h2>
				</div>
			<table class="table table-bordered table-condensed table-hover">
			<thead class="thead-dark">
				<tr>');
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
					<td>
						<form action="teamProfile.php" target="_parent" method="post">
							<input type="hidden" name="teamProfileSelected" value=' .$row['TeamID'].'>
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
	

	
    ?>
    </body>
</html>

