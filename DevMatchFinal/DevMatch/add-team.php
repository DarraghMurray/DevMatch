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

         //profile data
         $params = array($user);
         $connectionSearch = $db->executeStatement('SELECT * FROM profiles WHERE UserID = ?','s',$params);
 
         $result = $connectionSearch->get_result();
         $row = mysqli_fetch_assoc($result);
         $firstN = $row["FirstName"] ;
         $lastN = $row["LastName"] ;
   
echo '
<form method=post name="addTeam" id="addTeam">

<div class="container">
<div class="row gutters">
<div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
<div class="card h-100">
	<div class="card-body">
		<div class="account-settings">
			<div class="user-profile">
				<div class="user-avatar">
					<img src="Assets/team.png" alt="myTeam">
				</div>
				<h5 class="user-name">'. $firstN.' '. $lastN.'</h5>
				<h6 class="user-email">Teams</h6>
			</div>
			<div class="about">
				<h5>About</h5>
      
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="form-group">
          <label for="fullName">Team Name</label>
          <input type="text" class="form-control" name="teamName" id="teamName" placeholder="Name">
        </div>
      </div>
      <div class="col-xl-12 col-lg12 col-md-12 col-sm-12 col-12">
        <div class="form-group">
          <label for="eMail">Team Description</label>
          <textarea type="textarea" class="form-control"  name="teamDescription"  id="teamDescription" placeholder="Description" rows="3"></textarea>
        </div>
      </div>
</div>
		</div>
	</div>
</div>
</div>';

echo '

<div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
<div class="card h-100">
	<div class="card-body">';

      echo'<div class="row gutters">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
          <h5 class="mb-2 text-primary">Team Details</h5>
        </div>
      
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
				<div class="form-group" >
	      <h6> Add members</h6>
        ';
        //Only if you are the connection of some user you can add
 
        //retrieves connections already validated
        $params = array($user, $user);
        $connectionSearch = $db->executeStatement('SELECT User1ID,User2ID FROM connections WHERE (User1ID = ? OR User2ID = ?) AND Validated = "1"','ss',$params);
        $connectionsRes = $connectionSearch->get_result();

		if (mysqli_num_rows($connectionsRes)==0 ) 
			$connectionsRes = "";


      if($connectionsRes !== "") {

        while($row = mysqli_fetch_assoc($connectionsRes)) {
          include("database.php");
  
          if($row['User1ID'] != $user) {
            $searchTerm = $row['User1ID'];
          } else {
            $searchTerm = $row['User2ID'];
          }
      
          $params = array($searchTerm);
          $connectionSearch = $db->executeStatement('SELECT profiles.* FROM profiles INNER JOIN users ON profiles.UserID = users.UserID WHERE profiles.UserID = ? AND Banned=0','s',$params);
          $resultUser = $connectionSearch->get_result();
        
          $counter=1;
          while(	$user_row = mysqli_fetch_assoc($resultUser)){
                ///create array & checkboxes
                echo ' <div class="d-flex justify-content-between" style="margin-top:10px;">';

                echo ' <input type="checkbox"  name="member[]" value='.$user_row['UserID'].'>
                <label for='.$user_row['LastName'].'>'.$user_row['LastName']." ".$user_row['FirstName'].'</label><br>';
              
                $search = $db->executeStatement('SELECT * FROM membertype');
                $resultMemberType = $search->get_result();

                $mem_name= "memType".$user_row['UserID'];
                echo '<select class="teamAdd" name="'. $mem_name.'">';
                while($mem_row = mysqli_fetch_assoc($resultMemberType)){
                 
                    echo '<option value='.$mem_row["MTypeID"].' >'.$mem_row["Name"].' </option>';
            
                }
            
                echo '
                </select>';
              
              
               echo '
           </div>';
              }
              $counter++;

        }
      }

        echo ' 

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
     ';


      if(isset($_POST['update'])) {   

        if(isset($_POST['teamDescription']) && isset($_POST['teamName']) ){
        

        $name = $_POST['teamName'];
        $description = $_POST['teamDescription'];
        $params = array($name,$user,$description);
        $ins = $db->executeStatement('INSERT INTO teams(Name,CreatorID,Description,CreationDate) VALUES ( ? , ? , ? , now())','sss',$params);

        $params = array($name);
        $getTeamID = $db->executeStatement('SELECT * FROM teams WHERE Name= ?','s',$params);
       
        $result = $getTeamID->get_result();

        $row = mysqli_fetch_assoc($result);

        //check if members were checked and their type
        //$upd = $db->executeStatement('UPDATE userskill SET LevelID = ? WHERE UserID= ? and SkillID= ?','sss',$params);
        if(!empty($_POST['member'])){
            // Loop to store and display values of individual checked checkbox.
            foreach($_POST['member'] as $selected){ // insert the members
            //team_id,mtype_id,userID
                $teamID= $row['TeamID'];
                $mTypeID = $_POST["memType" . $selected];
               
                $params = array($teamID,$mTypeID,$selected);
                $ins = $db->executeStatement('INSERT INTO members(TeamID,MTypeID,UserID) VALUES ( ? , ? , ?)','sss',$params);

        }
    }
        echo '<script>alert("Successfully added");</script>';

    }else{
          if(!isset($_POST['teamDescription']))
            echo '<script>alert("Team description must be set");</script>';
          
        if(!isset($_POST['teamName']))
            echo '<script>alert("Team name must be set");</script>';
        
            echo "<meta http-equiv='refresh' content='0'>";

        }

    }

    
    

      if(isset($_POST['cancel'])) {
        // it will refresh the page automatically
        echo "<meta http-equiv='refresh' content='0'>";
     }
   
     echo " </form>";

?>
<script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
<script src="http://netdna.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script type="text/javascript"></script>


</body>
</html>