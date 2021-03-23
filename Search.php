<html>
    <head>
      <link rel = "stylesheet"
			href = "https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css"
			integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl"
			crossorigin="anonymous">
    </head>

    <body>
      <?php
        include_once("navBar.php");
        include("database.php");

        if(isset($_REQUEST['search'])) {

            $searchType = intval($_REQUEST['searchType']);
            $searchTerm = $_REQUEST['searchTerm'];

            if($searchType === 0) {
                $searchTerm = '%' . $searchTerm . '%';
                $connectionSearch = $connection->prepare('SELECT * FROM profiles WHERE CONCAT(FirstName, " ", LastName) LIKE ?');
                $connectionSearch->bind_param('s',$searchTerm);
                $connectionSearch->execute();

                $result = $connectionSearch->get_result();
                while($row = mysqli_fetch_assoc($result)) {
                  print_r($row);
                }
            } else if($searchType === 1) {
                $searchTerm = '%' . $searchTerm . '%';
                $teamSearch = $connection->prepare('SELECT * FROM teams WHERE Name LIKE ?');
                $teamSearch->bind_param('s', $searchTerm);
                $teamSearch->execute();

                $result = $teamSearch->get_result(); 
                while($row = mysqli_fetch_assoc($result)) {
                    print_r($row);
                }
            } else if($searchType === 2) {
                $searchTerm = '%' . $searchTerm . '%';
                $vacancySearch = $connection->prepare('SELECT * FROM vacancies WHERE Role LIKE %{?}%');
                $vacancySearch->bind_param('s', $searchTerm);
                $vacancySearch->execute();

                $result = $vacancySearch->get_result();
                while($row = mysqli_fetch_assoc($result)) {
                    print_r($row);
                }
            }
        }
      ?>
    </body>
</html>