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
    
        if(isset($_REQUEST['profileSelected'])) {
          $user = $_REQUEST['profileSelected'];
        } else {
           $user= $_SESSION['userID'];
        }
  
        $searchTerm =  $user ;

        //mail and password
        $connectionSearch = $connection->prepare('SELECT * FROM users WHERE UserID = ?');
        $connectionSearch->bind_param('s',$searchTerm);
        $connectionSearch->execute();
        $result = $connectionSearch->get_result();
        $row = mysqli_fetch_assoc($result);
        
        $mail =   $row["Email"];

       //profile data
        $connectionSearch = $connection->prepare('SELECT * FROM profiles WHERE UserID = ?');
        $connectionSearch->bind_param('s',$searchTerm);
        $connectionSearch->execute();

        $result = $connectionSearch->get_result();
        $row = mysqli_fetch_assoc($result);
        $firstN = $row["FirstName"] ;
        $lastN = $row["LastName"] ;
        $gender = $row["Gender"];
        $description = $row["Description"];
        $pass= null;
        $country = $row["Country"];
        $birthday= $row["DateOfBirth"];


        if ($gender == "Female"){
          $imageURL = "Assets/female.png";
        }
        else
          if ($gender == "Male"){
          $imageURL = "Assets/male.png";
        }
        else
         $imageURL = "Assets/other.png";

            
      if(isset($_POST['update'])) {
        //update databese validate and reload the page
      }
      if(isset($_POST['cancel'])) {
         // it will refresh the page automatically
      }

echo '
<div class="container">
<div class="row gutters">
<div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
<div class="card h-100">
	<div class="card-body">
		<div class="account-settings">
			<div class="user-profile">
				<div class="user-avatar">
					<img src=" ' . $imageURL . '" alt="Maxwell Admin">
				</div>
				<h5 class="user-name">' . $firstN.' ' .   $lastN   .'</h5>
				<h6 class="user-email">' . $mail . '</h6>
			</div>
			<div class="about">
				<h5>About</h5>';

   if($description==null)
   echo'
        <textarea type="textarea" class="form-control" id="description" placeholder="Description" rows="3"></textarea>';
    else
     echo ' <textarea type="textarea" class="form-control" id="description" value=' . $description .' rows="3"></textarea>';
     echo '
          <form method="post">
          <button type="button" id="addTeam" name="addTeam" class="btn btn-primary addTeamBtn">Add a team</button>
          <form method="post">
        </div>
		</div>
	</div>
</div>
</div>
<div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
<div class="card h-100">
	<div class="card-body">
		<div class="row gutters">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
				<h6 class="mb-2 text-primary">Personal Details</h6>
			</div>
			<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
				<div class="form-group">
					<label for="fullName">Last Name</label>
					<input type="text" class="form-control" id="lastName" value=' . $lastN .'>
				</div>
			</div>
			<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
				<div class="form-group">
					<label for="eMail">Email</label>
					<input type="email" class="form-control" id="eMail" value='.$mail.'>
				</div>
			</div>
			<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
				<div class="form-group">
					<label for="phone">First name</label>
					<input type="text" class="form-control" id="firstName" value=' . $firstN .'>
				</div>
			</div>
			<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
				<div class="form-group">
					<label for="website">Password</label>
					<input type="password" class="form-control" id="password" placeholder="Change password">
				</div>
			</div>
		</div>
		<div class="row gutters">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
				<h6 class="mt-3 mb-2 text-primary">Details</h6>
			</div>
			<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
				<div class="form-group">
					<label for="Country">Country</label>
					<input type="text" class="form-control" id="Country" value='.$country.'>
				</div>
			</div>
			<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
				<div class="form-group">
					<label for="birthday">Birthday</label>
					<input type="date" class="form-control" id="birthDay" value='.$birthday.'>
				</div>
			</div>
		</div>

    <div class="row gutters">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
      <h6 class="mt-3 mb-2 text-primary">Skills</h6>
    </div>
    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
      <div class="form-group">
        <label for="SkillName">Skill</label>
        <input type="text" class="form-control" id="Skill" value="Skill">
      </div>
    </div>
    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
      <div class="form-group">
        <label for="level">Level</label>
        <input type="text" class="form-control" id="level" value="Level">
      </div>
    </div>

    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
    <div class="form-group">
      <label for="birthday">Qualifications</label>
      <input type="text" class="form-control" id="qualification" value="Quallification">
    </div>
  </div>
  </div>

		<div class="row gutters">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
				<div class="text-right">
        <form method="post">
					<input type="submit" id="cancelBtn" name="cancel" class="btn btn-secondary" value="Cancel"/>
					<input type="submit" id="updateBtn" name="update" class="btn btn-primary" value="Update" />
				</form>
          </div>
			</div>
		</div>
	</div>
</div>
</div>
</div>
</div>
';?>
<script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
<script src="http://netdna.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script type="text/javascript">
	
</script>


</body>
</html>