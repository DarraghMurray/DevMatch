<?php

    function checkMember($user,$team,&$teamManager,&$teamOwner) {
        
        include('database.php');

        $params = array($team,$user);
        $memberTypeQuery = $db->executeStatement('SELECT MTypeID FROM members WHERE TeamID=? AND UserID=?','ii',$params);
        $memberTypeResult = $memberTypeQuery->get_result();

        if(!mysqli_num_rows($memberTypeResult)) {

        }  else {
            $row = mysqli_fetch_assoc($memberTypeResult);
                switch(intval($row['MTypeID'])) {
                    case 2:
                        $teamOwner = true;
                        break;
                    case 3:
                        $teamManager = true;
                        break;
                }

        }
    }
    
?>