<?php
		require("navBar.php");
        require("database.php");
        $user = $_SESSION['userID'];

        if(isset($_REQUEST['vacTeamID'])) {
            $teamID = $_REQUEST['vacTeamID'];
        } 

        if(isset($_REQUEST['addVacancy'])) {
			echo("add");
            //Create vacancy
			$role = $_REQUEST['role'];
			//echo($role);
            $description = $_REQUEST['description'];
            //echo($description);
			$addManID = $_REQUEST['createVacManID'];
            //echo($addManID);
			$teamID = $_REQUEST['createVacTeamID'];
			//echo($teamID);
			
			$params=array($teamID, $addManID, $role, $description);
            $addQuery = $db->executeStatement('INSERT INTO vacancies(TeamID,ManagerID,Role,Description) VALUES(?,?,?,?)','iiss',$params);
			//Get autoincremented vacID from last insertion through addQuery
			$vacID=$addQuery->insert_id;
			
			//Create skill requirements
			if(!empty($_POST['skill'])){
				$addReqQuery = $db->executeStatement('INSERT INTO skillrequirement(VacID, SkillID, LevelID) VALUES(?,?,?)');
				$addReqQuery->bind_param('iii',$vacID,$skillID,$lvlID);
				// Loop to store and display values of individual checked checkbox.
				foreach($_POST['skill'] as $selected){ //checked items
					$skillID=$selected;
					if (isset($_POST["level".$selected])){
						$lvlID=$_POST["level".$selected];
					}
					$addReqQuery->execute();
				}
			}
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
                    <form method="post"> 
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
							
							
							<div class="row gutters">
								<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
									<h6 class="mt-3 mb-2 text-primary">Skills</h6>
								</div>
								<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
									<div class="form-group">
							<?php 
									//	Get all skills
									$searchSkills= $db->executeStatement('SELECT * FROM skills');
									$resultSkills = $searchSkills->get_result();
									
									// One line per skill (checkbox, skill name and level selection)
									while($skills_row = mysqli_fetch_assoc($resultSkills)){

										echo '
											<div class="d-flex justify-content-between" style="margin-top:10px;">
												<input type="checkbox" class="profileEdit" name="skill[]" value='.$skills_row['SkillID'].'>
												<label for='.$skills_row['SkillID'].'>'.$skills_row['Name'].'</label><br>';
										
										//Combobox level
										$search = $db->executeStatement('SELECT * FROM level');
										$resultLevel = $search->get_result();
									
										$lev_name= "level".$skills_row['SkillID'];
										echo '<select class="profileEdit" name="'.$lev_name.'">';
										while($level_row = mysqli_fetch_assoc($resultLevel)){
											echo '<option value='.$level_row["LevelID"].' >'.$level_row["Name"].' </option>';
										}
										echo ' </select> </div>';
									}

									
							?>
							
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <input type="submit" class="btn btn-primary" id="Add" value="Publish" name="addVacancy">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
		
    </body>
</html>