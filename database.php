<?php
    $servername='localhost';            //Found on control panel
    $UserName='root';   //Found on control panel id16365905_dmdbadmin
    $PassWord='root';    //000webhost account password 32RAQY35_194433prnm
    $dbName='cs4116webdb';    //Found on control panel id16365905_devmatchdb

	
	date_default_timezone_set('Europe/Dublin');
	
    $connection= mysqli_connect($servername,$UserName,$PassWord,$dbName);

    if ( mysqli_connect_errno() ) {
      exit('Failed to connect to MySQL: ' . mysqli_connect_error());
    }
?>