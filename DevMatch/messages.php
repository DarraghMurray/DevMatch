<?php
	require("navBar.php");
?>

<?php
		require('database.php');
		$user = $_SESSION['userID'];

		$params = array($user,$user);
		$connections = $db->executeStatement('SELECT User1ID,User2ID FROM connections WHERE (User1ID = ? OR User2ID = ?) AND Validated = 1','ii',$params);
		$connectionsRes = $connections->get_result();

		function displayConnectionsResult($connections, $user) {	
			if (!mysqli_num_rows($connections) ) {
				
			} else {
					while($row = mysqli_fetch_assoc($connections)) {
						require("database.php");
		
						if(intval($row['User1ID']) == $user) {
							$searchTerm = intval($row['User2ID']);
						} else if(intval($row['User2ID']) == $user) {
							$searchTerm = intval($row['User1ID']);
						}
						$params = array($searchTerm);
						$searchUser = $db->executeStatement('SELECT profiles.* FROM profiles INNER JOIN users ON profiles.UserID = users.UserID WHERE profiles.UserID = ? AND Banned=0','s',$params);
						$resultUser = $searchUser->get_result();
		
						while(	$user_row = mysqli_fetch_assoc($resultUser)){
							$today = new DateTime();
							$birthdate = new DateTime($user_row['DateOfBirth']);
							$interval = $today->diff($birthdate);
							$age = $interval->format('%y years');
							echo ('
							<tr class="candidates-list">
								<td class="title">
								<div class="candidate-list-details">
									<div class="candidate-list-info">
									<div class="candidate-list-title">
										<h5 class="mb-0"><a>'.$user_row['FirstName'].' '.$user_row['LastName'].'</a></h5>
									</div>
									<div class="candidate-list-option">
										<ul class="list-unstyled">
										<li><i class="fas fa-filter pr-1"></i>'.$user_row['Employment'].'</li>
										<li><i class="fas fa-map-marker-alt pr-1"></i>'.$user_row['Country'].'</li>
										</ul>
									</div>
									</div>
								</div>
								</td>
								<td>
									<div class="candidate-list-details text-center">
										<div class="candidate-list-info">
											<div class="candidate-list-option">
											<ul class="list-unstyled">
											<li><i class="fas pr-1"></i>'.$age.'</li>
											<li><i class="fas pr-1"></i></li>
											</ul>
											</div>
										</div>
									</div>
								</td>
								<td>
									<form action="connectionMessage.php" method="post">
										<input type="hidden" Name="User1ID" value="'.$row['User1ID'].'">
										<input type="hidden" Name="User2ID" value="'.$row['User2ID'].'">
										<input type="hidden" Name="userToMessage" value="'.$user_row['UserID'].'">
										<input type="submit" Name="message" value="Message">
									</form>
								</td>
							</tr>' );
						}
					}
			}
		}
	?>
<!DOCTYPE html>
<html>
    <head>
 		<link rel = "stylesheet"
			href = "https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css"
			integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl"
			crossorigin="anonymous">
		<link href="https://fonts.googleapis.com/css2?family=Khula:wght@700&display=swap" rel="stylesheet">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css" integrity="sha256-2XFplPlrFClt0bIdPgpz8H7ojnk10H69xRqd9+uTShA=" crossorigin="anonymous" />
		<link rel="stylesheet" href="CSS/messages.css">
		<!--<link rel="stylesheet" href="CSS/animation.css">-->
	</head>
	<body>

	<div class="container mt-3 mb-4" id="connectionChooser">
		<div class="col-lg-9 mt-4 mt-lg-0">
			<div class="row">
			<div class="col-md-12">
				<div class="user-dashboard-info-box table-responsive mb-0 bg-white p-4 shadow-sm">
				<table class="table manage-candidates-top mb-0">
					<thead>
					<tr>
						<th>Connection</th>
						<th class="action text-right">Action</th>
					</tr>
					</thead>
					<tbody>
						<?php 
						displayConnectionsResult($connectionsRes, $user); ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

		
		<!--<div class="loader">
			<div class="loader-item loader-item_1"></div>
			<div class="loader-item loader-item_2"></div>
			<div class="loader-item loader-item_3"></div>
			<div class="loader-item loader-item_4"></div>
		</div>
		<div class='console-container'><span id='text'></span><div class='console-underscore' id='console'>&#95;</div></div>

		<script type="text/javascript" src="animation.js">
		</script>-->
    </body>
</html>