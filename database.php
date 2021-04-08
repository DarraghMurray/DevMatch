<?php
    $servername='localhost';            //Found on control panel
    $UserName='root';   //Found on control panel
    $PassWord='';    //000webhost account password
    $dbName='cs4116webdb';    //Found on control panel

    $connection = mysqli_connect($servername,$UserName,$PassWord,$dbName);

    if ( mysqli_connect_errno() ) {
      exit('Failed to connect to MySQL: ' . mysqli_connect_error());
    }
?>