<?php
  require("navBar.php");
?>

<html>
    <head>
      <link rel = "stylesheet"
			href = "https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css"
			integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl"
			crossorigin="anonymous">
      <link href="http://netdna.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
      <link rel="stylesheet" href="CSS/profile.css">

    </head>
    <body>


<?php
        require("database.php");
        $user = $_SESSION['userID'];


		echo ('
		<div class="container">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h2 class="panel-title">My teams delete</h2>
				</div>
			<table class="table table-bordered table-condensed table-hover">
			<thead class="thead-dark">
				<tr>');

					echo('
					<th>Name</th>
					<th>Description</th>
				');
			echo ('
				</tr>
			</thead>');


		$params=array($user);
		$getTeamID = $db->executeStatement('SELECT * FROM teams WHERE CreatorID= ?','s',$params);
       
        $result = $getTeamID->get_result();

        while($row = mysqli_fetch_assoc($result)){
			echo ('<tr class="clickableRow" data-href="#">
			<td>
				'.$row['Name'].'
			</td>
			<td>
				'.$row['Description'].'
			</td>
			<td>
			<form action="" method="post">
				<input type="hidden" name="del"'.$row['TeamID'].' value=' .$row['TeamID']. '>
				<input type="submit" name="Delete" value="Delete" />
');
			if(isset($_POST["Delete"])){
			$params = array($row['TeamID']);
			$del = $db->executeStatement('DELETE FROM teams WHERE TeamID= ?','i',$params);
			$del = $db->executeStatement('DELETE FROM members WHERE TeamID = ?','i',$params);
			}
			echo ('</form> </td>');
		}

		echo (' </table>
				</div>
				</div>');
	

	?>

  
      
    </body>
</html>

