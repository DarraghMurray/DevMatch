<html>
    <head>
      <link rel = "stylesheet"
			href = "https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css"
			integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl"
			crossorigin="anonymous">

      <link rel = "stylesheet"
			href = "CSS/home.css"
			crossorigin="anonymous">
    </head>

    <body>
      <?php
        include_once("navBar.php");

?>

<div class="lateral">
  <a href="myConnections.php" target="page">Connections</a>
  <a href="myTeams.php"  target="page">Teams</a>
</div>
<iframe class="page" name="page" src="myConnections.php"></iframe>

    </body>
</html>