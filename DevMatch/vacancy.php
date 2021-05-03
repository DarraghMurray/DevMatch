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
        require("checkMemberType.php");

        $user = $_SESSION['userID'];
        $admin = $_SESSION['admin'];
        $teamOwner = false;
        $teamManager = false;

        if(isset($_REQUEST['applied'])) {
          $vacancy = $_REQUEST['appliedVacID'];
          $appliedUser = $_REQUEST['appliedUser'];

          $params = array($appliedUser,$vacancy);
          $applicantQuery = $db->executeStatement('INSERT INTO applications(UserID,VacID) VALUES(?,?)','ii',$params);
        }
        else if(isset($_REQUEST['update'])) {
          $vacancy = $_REQUEST['updateVacancy'];
          $updateRole = $_REQUEST['updateRole'];
          $updateDescription = $_REQUEST['updateDescription'];

          $params = array($updateRole,$updateDescription,$vacancy);
          $updateQuery = $db->executeStatement('UPDATE vacancies SET Role=?, Description=? WHERE VacID=?','ssi',$params);
        }
        else if(isset($_REQUEST['teamVacancySelected'])) {
          $vacancy = $_REQUEST['teamVacancySelected'];
        } 
        else if(isset($_REQUEST['vacToRemove'])) {
            $vacancy = $_REQUEST['vacToRemove'];
            $params = array($vacancy);
            $removeQuery = $db->executeStatement('UPDATE vacancies SET Disabled=1 WHERE VacID=?','i',$params);
        }
  
        $searchTerm =  $vacancy;

        $params = array($searchTerm);
        $vacancySearch = $db->executeStatement('SELECT vacancies.TeamID,vacancies.Role,vacancies.Description, profiles.FirstName, profiles.LastName, teams.Name FROM vacancies INNER JOIN profiles ON vacancies.ManagerID=profiles.UserID 
        INNER JOIN teams ON vacancies.TeamID=teams.TeamID WHERE VacID=?','i',$params);
        $vacancyResult = $vacancySearch->get_result();
        $row = mysqli_fetch_assoc($vacancyResult);
        
        $role = $row['Role'];
        $description = $row['Description'];
        $managerName = $row['FirstName'] . " " . $row['LastName'];
        $teamName = $row['Name'];
        $teamID = $row['TeamID'];

        checkMember($user,$teamID,$teamManager,$teamOwner);

echo '
<div class="container">
<div class="row gutters">
<div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
<div class="card h-100">
	<div class="card-body">
		<div class="account-settings">
			<div class="user-profile">
				<div class="user-avatar">
					<img src=" ' . '" alt="Maxwell Admin">
				</div>
				<h5 class="manager-name">' . $managerName .'</h5>
				<h6 class="team-name">' . $teamName . '</h6>
			</div>';
      if($admin || $teamManager || $teamOwner) {
      echo'
      <form action="" method="POST">
        <input type="hidden" name="vacToRemove" value="'. $vacancy .'">
        <input type="submit" name="removeVac" value="Remove">
      </form>';
      } 
		echo'</div>
	</div>
</div>
</div>
<div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
<div class="card h-100">
  <form action="" method="POST">
    <div class="card-body">';
    if($admin) {
      echo'
      <form action="" method="POST">';
    }
        echo '<div class="row gutters">
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <h6 class="mb-2 text-primary">Vacancy Details</h6>
          </div>
            <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-12">
              <div class="form-group">
                <label for="fullName">Role</label>
                <input type="text" class="form-control" name="updateRole" id="updateRole" value="' . $role . '">
              </div>
            </div>
            <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-12">
              <div class="form-group">
                <label for="eMail">Description</label>
                <input type="text" class="form-control" name="updateDescription" id="updateDescription" value="' . $description . '">
              </div>
            </div>
        </div>
        <div class="row gutters">
          <div class ="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
              <div "text-left">
                <form action="" method="post">
                  <input type="hidden" name="appliedUser" value="'.$user.'">
                  <input type="hidden" name="appliedVacID" value="'.$vacancy.'">
                  <input type="submit" name="applied" class="btn-primary" value="Apply">
                </form>
              </div>
          </div>';
        if($admin || $teamOwner || $teamManager) {
          echo'
          <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="text-right">
              <input type="hidden" name="updateVacancy" value="'.$vacancy.'">
              <input type="submit" id="updateBtn" name="update" class="btn btn-primary" value="Update" />
      </form>
              <form action="" method="post">
                <input type="hidden" name="teamVacancySelected" value="'.$vacancy.'">
                <input type="submit" id="cancelBtn" name="cancel" class="btn btn-secondary" value="Cancel"/>
              </form>
              <form action="applicants.php" method="post">
                <input type="hidden" name="vacTeamID" value="'.$teamID.'">
                <input type="hidden" name="applicantsVacID" value="'.$vacancy.'">
                <input type="submit" name="viewApplicants" class="btn-primary" value="View Applicants">
              </form>
            </div>
          </div>';
        }
        echo'
        </div>
        <div class="row gutters">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">';
              displayVacancySkills($vacancy);
    echo '
            </div>
        </div>
    </div>
  </form>
</div>
</div>
</div>
</div>
';
function displayVacancySkills($vacancy) {
  include('database.php');

  $params = array($vacancy);
  $vacancySkillQuery = $db->executeStatement('SELECT
                              skills.Name AS skillName,
                              level.Name AS skillLevel,
                              Level.Strength AS skillStrength,
                              skilltype.Name AS skillType
                            FROM
                              skillrequirement
                              INNER JOIN skills ON skillrequirement.SkillID = skills.SkillID
                              INNER JOIN level ON skillrequirement.LevelID = level.LevelID
                              INNER JOIN skilltype ON skills.STypeID = skillType.STypeID
                            WHERE
                              skillrequirement.VacID = ?','i',$params);
  $result = $vacancySkillQuery->get_result();

  if (!mysqli_num_rows($result)){
    echo ('
      <div class="container">
        No Skill Requirements.
      </div>');
  } else {
    echo '
  <div class="container">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h2 class="panel-title">Skills</h2>
      </div>
    <table class="table table-bordered table-condensed table-hover">
    <thead class="thead-dark">
      <tr>
        <th>Skill</th>
        <th>Level</th>
        <th>Strength</th>
        <th>Type</th>
      </tr>
    </thead>';
      while($row = mysqli_fetch_assoc($result)) {

        echo('<tr class="clickableRow" data-href="#">
          <td>
            '.$row['skillName'].'
          </td>
          <td>
            '.$row['skillLevel'].'
          </td>
          <td>
            '.$row['skillStrength'].'
          </td>
          <td>
            '.$row['skillType'].'
          </td>
        </tr>');
      }
      echo '</table>
            </div>
            </div>';
  }
}
?>
<script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
<script src="http://netdna.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script type="text/javascript">
	
</script>


</body>
</html>