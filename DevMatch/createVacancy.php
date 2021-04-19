<?php
		require("navBar.php");
        $user = $_SESSION['userID'];
        if(isset($_REQUEST['vacTeamID'])) {
            $teamID = $_REQUEST['vacTeamID'];
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
                        <div class="row gutters">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <h6 class="mb-2 text-primary">Vacancy Form</h6>
                            </div>
                            <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-12">
                                <div class="form-group">
                                    <label for="role">Role</label>
                                    <input type="text" class="form-control" id="role">
                                </div>
                            </div>
                            <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-12">
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <input type="text" class="form-control" id="description">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
		
    </body>
</html>