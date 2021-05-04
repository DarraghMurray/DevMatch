<?php

// configuration
include 'database.php';

$row = $_POST['row']-1;
$userToMessage = $_POST['userToMessage'];
$rowperpage = 10;
$User1ID = $_POST['User1ID'];
$User2ID = $_POST['User2ID'];

// selecting posts
$params = array($User1ID,$User2ID,$row,$rowperpage);
$query = $db->executeStatement('SELECT * FROM messages WHERE User1ID=? AND User2ID=? ORDER BY MessageNum DESC limit ?,?','iiii',$params);
$result = $query->get_result();

while($message_row = mysqli_fetch_assoc($result)){
    echo ('
                                    <li class="clearfix userMessage">
                                        <div class="message-data');
                                            if($message_row['SenderID'] == $userToMessage) {
                                                echo'text-right';
                                            }
                                            echo('">
                                                <span class="message-data-time">'.$message_row['SentTime'].'</span>
                                         </div>
                                        <div class="message Message');
                                        if($message_row['SenderID'] == $userToMessage){echo'other-message float-right';} 
                                         else{ echo'my-message';}
                                        echo('">'.$message_row['Content'].'</div>
                                    </li> 
							' );
}