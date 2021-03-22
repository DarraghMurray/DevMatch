<?php
    $servername='localhost';
    $UserName='root';
    $PassWord='';
    $dbName='cs4116webdb';

    $connection= mysqli_connect($servername,$UserName,$PassWord,$dbName);

    if ($connection->connect_error) {
      die("Connection Failed:" .$connection->connect_error);
    }
?>