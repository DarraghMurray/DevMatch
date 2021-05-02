<?php
    require_once('databaseManager.php');
    $config = parse_ini_file('../config.ini');
    $db = new databaseManager('localhost',$config['dbname'],$config['username'],$config['password']);
?>