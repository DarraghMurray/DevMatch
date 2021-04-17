<?php
        session_start();
        include("database.php");
      
        $user= $_SESSION['userID'];
                $searchTerm = $user;
                $teamSearch = $connection->prepare('SELECT * FROM members WHERE UserID = ? ');
                $teamSearch->bind_param('s',$searchTerm);

                $teamSearch->execute();

                $result = $teamSearch->get_result(); 
                if (mysqli_num_rows($result)==0) 
                echo "No memberships associated with your account";
                else
				displaySearchResultTeam($result,$user);
          
        
		
	
	function displaySearchResultTeam($mysqlResult, $user){	 
		echo ('
		<div class="container">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h2 class="panel-title">My teams</h2>
				</div>
			<table class="table table-bordered table-condensed table-hover">
			<thead class="thead-dark">
				<tr>');
				echo('
					<th>Name</th>
					<th>Membership</th>
					');
			echo ('
				</tr>
			</thead>');
			while($row = mysqli_fetch_assoc($mysqlResult)) {
                include("database.php");

                $searchTerm =  $row['TeamID'] ;
                $teamSearch = $connection->prepare('SELECT Name FROM teams WHERE TeamID = ? ');
                $teamSearch->bind_param('s',$searchTerm);

                $teamSearch->execute();

                $result = $teamSearch->get_result(); 

                $team_row = mysqli_fetch_assoc($result);

                $searchTerm =  $row['MTypeID'] ;
                $teamSearch = $connection->prepare('SELECT Name FROM membertype WHERE MTypeID = ? ');
                $teamSearch->bind_param('s',$searchTerm);

                $teamSearch->execute();

                $result = $teamSearch->get_result(); 

                $membership_row = mysqli_fetch_assoc($result);
            

				echo('<tr class="clickableRow" data-href="#">
					<td>
						'. $team_row['Name'] .'
					</td>
					<td>
						'. $membership_row['Name'].'
					</td> 
                    </tr>' );
					
		}
		echo ('
		</table>
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

