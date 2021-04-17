<?php
    $config = parse_ini_file('../config.ini');

    $connection = mysqli_connect('localhost',$config['username'],$config['password'],$config['dbname']);

    if ( mysqli_connect_errno() ) {
      exit('Failed to connect to MySQL: ' . mysqli_connect_error());
    }
?>