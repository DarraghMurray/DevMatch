<?php
    require('navBar.php');
?><html>
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

    $userType = intval($_SESSION['userType']);

    if(isset($_REQUEST['acceptApplicant'])) {
      $user = $_REQUEST['applicantAccepted'];
      $vacancy = $_REQUEST['vacAccepted'];
      $teamID = $_REQUEST['teamAccepted'];

      $params = array($vacancy);
      $deleteVacancy = $db->executeStatement('DELETE FROM vacancies WHERE VacID=?','i',$params);

      $params = array($teamID,$user);
      $addTeamMember = $db->executeStatement('INSERT INTO members VALUES(?,?,1)','ii',$params);
    }
    else if(isset($_REQUEST['viewApplicants'])) {
      $vacancy = $_REQUEST['applicantsVacID'];
      $teamID = $_REQUEST['vacTeamID'];
    }

    $params = array($vacancy);
    $applicantsQuery = $db->executeStatement('SELECT profiles.UserID,profiles.FirstName,profiles.LastName,profiles.Gender,profiles.Country,profiles.DateOfBirth 
                                              FROM applications INNER JOIN profiles ON applications.UserID=profiles.UserID 
                                              WHERE VacID=?','i',$params);
    $result = $applicantsQuery->get_result();



    echo' <div class="container">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h2 class="panel-title">Applicants</h2>
      </div>
    <table class="table table-bordered table-condensed table-hover">
    <thead class="thead-dark">
      <tr>
        <th>Name</th>
        <th>Gender</th>
        <th>Age</th>
        <th>Country</th>
      </tr>
    </thead>';

    while($row = mysqli_fetch_assoc($result)) {

      $age = $row['DateOfBirth'];

      echo('<tr class="clickableRow" data-href="#">
      <td>
        '.$row['FirstName'].' '.$row['LastName'].'
      </td>
      <td>
        '.$row['Gender'].'
      </td>
      <td>
        '.$age.'
      </td>
      <td>
        '.$row['Country'].'
      </td>
      <td>
        <form action="" method="POST">
          <input type="hidden" name="teamAccepted" value="'.$teamID.'">
          <input type="hidden" name="vacAccepted" value="'.$vacancy.'">
          <input type="hidden" name="applicantAccepted" value="'.$row['UserID'].'">
          <input type="submit" name="acceptApplicant" value="Accept">
        </form>
        <form action="profile.php" method="POST">
          <input type="hidden" name="profileSelected" value="'.$row['UserID'].'">
          <input type="submit" name="View" value="View">
        </form>
      </td>
    </tr>');
    }

    echo '</table>
          </div>
          </div>';

?>
<script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
<script src="http://netdna.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script type="text/javascript">

</script>


</body>
</html>

