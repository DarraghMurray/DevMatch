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

                $vacancySearch = $connection->prepare('SELECT * FROM vacancies');
                $vacancySearch->execute();

                $result = $vacancySearch->get_result();
              
				displaySearchResultVacancies($result);
         
	
		function displaySearchResultVacancies($mysqlResult){	 
		echo ('
		<div class="container">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h2 class="panel-title">Vacancies</h2>
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

