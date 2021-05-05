<?php
  require("session.php");
?>

<html>
    <head>
      <link rel = "stylesheet"
			href = "https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css"
			integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl"
			crossorigin="anonymous">
      <link rel="stylesheet" href="CSS/nav.css">
      
    </head>

    <body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="Home.php">
    <img src="Assets/logo.png" style="position:relative;width:80px;height:80px">      
  </a>
    <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">

          <li class="nav-item ">
              <a class="nav-link" href="Home.php">Home</a>
            </li>
            </li>
            <li class="nav-item ">
              <a class="nav-link" href="profile.php">Profile</a>
            </li>
        
            <li class="nav-item">
              <a class="nav-link" href="connectionsBoard.php">MyConnections</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="messages.php">Messages</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="logOut.php">Log-Out</a>
            </li>
      </ul>
      <form class="d-flex" action="Search.php">
        <input class="form-control me-2" type="search" name="searchTerm" placeholder="Search" aria-label="Search">
        <input type="hidden" name="nonSet"  value="">        
        <button class="btn btn-outline-success" type="submit" name="search">Search</button>
        <select class="form-control" style="margin-left:2px; width:fit-content;" name="searchType" id="searchType">
                            <option value="0">Connections</option>
                            <option value="1">Teams</option>
                            <option value="2">Vacancies</option>
                        </select>

      </form>
    </div>
  </div>
</nav>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js" integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>
 
  </body>
</html>