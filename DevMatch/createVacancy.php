<?php
		require("navBar.php");
        require("database.php");
        $user = $_SESSION['userID'];

        if(isset($_REQUEST['vacTeamID'])) {
            $teamID = $_REQUEST['vacTeamID'];
        } 
        
        if(isset($_REQUEST['addVacancy'])) {
            $role = $_REQUEST['role'];
            $description = $_REQUEST['description'];
            $addManID = $_REQUEST['createVacManID'];
            $teamID = $_REQUEST['createVacTeamID'];

            $addQuery = $connection->prepare('INSERT INTO vacancies(TeamID,ManagerID,Role,Description) VALUES(?,?,?,?)');
            $addQuery->bind_param('iiss',$teamID, $addManID, $role, $description);
            $addQuery->execute();
        }
?>

<html>
    <head>
      <link rel = "stylesheet"
			href = "https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css"
			integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl"
			crossorigin="anonymous">
		<link rel="stylesheet" href="CSS/teamProfile.css">
    </head>

    <body>

        <div class="lateral"></div>

        <div class="container page">
            <div class="card h-100">
                <div class="card-body">
                    <form action="" method="post"> 
                        <?php
                            echo('<input type="hidden" name="createVacManID" value='.$user.'>
                            <input type="hidden" name="createVacTeamID" value='.$teamID.'>');
                        ?>
                        <div class="row gutters">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <h6 class="mb-2 text-primary">Vacancy Form</h6>
                            </div>
                            <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-12">
                                <div class="form-group">
                                    <label for="role">Role</label>
                                    <input type="text" class="form-control" id="role" name="role" required maxlength="255">
                                </div>
                            </div>
                            <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-12">
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <input type="text" class="form-control" id="description" name="description" required maxlength="20000">
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <input type="submit" class="form-control" id="Add" value="Add" name="addVacancy">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
		
    </body>
</html>