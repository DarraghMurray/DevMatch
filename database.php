<?php
    $servername='localhost';            //Found on control panel
    $UserName='id16365905_dmdbadmin';   //Found on control panel
    $PassWord='32RAQY35_194433prnm';    //000webhost account password
    $dbName='id16365905_devmatchdb';    //Found on control panel

    $connection= mysqli_connect($servername,$UserName,$PassWord,$dbName);

    if ( mysqli_connect_errno() ) {
      exit('Failed to connect to MySQL: ' . mysqli_connect_error());
    }
?>