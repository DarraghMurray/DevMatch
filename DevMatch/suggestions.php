<html>
    <head>
      <link rel = "stylesheet"
			href = "https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css"
			integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl"
			crossorigin="anonymous">
    </head>

    <body>
      <?php
	    require("session.php");
        include("database.php");
		//Get current user ID
		$user= $_SESSION['userID'];
		
		//Get user skills
		$params=array($user);
		$userSkillSearchQ=$db->executeStatement('SELECT * FROM userskill, level WHERE userID=? AND userskill.LevelID=level.LevelID','i',$params);
		$resultUserS=$userSkillSearchQ->get_result();
		
		//Get all active vacancies
		$vacancySearchQ = $db->executeStatement('SELECT vacID, vacancies.Role, teams.Name, vacancies.Description FROM vacancies, teams WHERE teams.TeamID=vacancies.TeamID AND Disabled=0');
		$resultAllVac = $vacancySearchQ->get_result();

		$suggestedVacRows=array();
		//For each vacancy, get requirement, compare to user skill, add to resultSuggVac if equal or better
		while($vacRow=mysqli_fetch_assoc($resultAllVac)){
			
			$params=array($vacRow['vacID']);
			// Get vacancy requirements
			$requirementQ = $db->executeStatement('SELECT skills.skillID as skillID, skills.Name AS skillName, level.Name AS skillLevel, level.Strength AS skillStrength, skilltype.Name AS skillType FROM skillrequirement, skills, level, skilltype WHERE skillrequirement.SkillID = skills.SkillID AND skillrequirement.LevelID = level.LevelID AND skills.STypeID = skillType.STypeID AND skillrequirement.VacID = ?','i',$params);
			$resultReq=$requirementQ->get_result();	
			
			// Every vacancy starts suggestable (validVac=true), without requirement, a vacancy is automaticaly suggested
			$validVac=true;
			// For each requirement, compare to every user skills, validVac ends as false if a requirement is not met
			while(($requirementRow=mysqli_fetch_assoc($resultReq)) && ($validVac==true)){
				$validVac=false; 	//ends at the end of the loop if one requirement is not met
				// For each user skill, compare to current requirement, ends as soon as a correspondance is found
				while(($uSkillRow=mysqli_fetch_assoc($resultUserS)) && ($validVac==false)){
					if (($requirementRow['skillID']==$uSkillRow['SkillID'])	&&	(! ($requirementRow['skillStrength']>$uSkillRow['Strength']))){
						$validVac=true;
					}
				}
				// Rewinds resultUserS for next requirement
				$resultUserS->data_seek(0);
			}
			if ($validVac){
				array_push($suggestedVacRows, $vacRow);
			}
		}
		displaySuggestionResults($suggestedVacRows);
	 
	
		function displaySuggestionResults($resultArray){
			if (empty($resultArray)){
				echo ('
				<div class="container">
					No result found.
				</div>	
				');
			} else {	 
				echo ('
				<div class="container">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h2 class="panel-title">Jobs for you !</h2>
						</div>
					<table class="table table-bordered table-condensed table-hover">
					<thead class="thead-dark">
						<tr>');
						echo('
							<th>Role</th>
							<th>Team</th>
							<th>Description</th>');
					echo ('
						</tr>
					</thead>');
					foreach($resultArray as $row) {
						echo('<tr class="clickableRow" data-href="#">
							<td>
								'.$row['Role'].'
							</td>
							<td>
								'.$row['Name'].'
							</td>
							<td>
								'.$row['Description'].'
							</td>
							<td>
								<form action="vacancy.php" target="_parent" method="post">
									<input type="hidden" name="teamVacancySelected" value=' .$row['vacID'].'>
									<input type="submit" name="View" value="View" />
								</form>
							</td>
						</tr>');
					}
				echo ('
				</table>
				</div>
				</div>');
			}
		}
    ?>
    </body>
</html>

