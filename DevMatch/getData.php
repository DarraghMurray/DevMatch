<?php

// configuration
include 'database.php';

$row = $_POST['row']-1;
$userToMessage = $_POST['userToMessage'];
$rowperpage = 10-1;
$User1ID = $_POST['User1ID'];
$User2ID = $_POST['User2ID'];

// selecting posts
$params = array($User1ID,$User2ID,$row,$rowperpage);
$query = $db->executeStatement('SELECT * FROM messages WHERE User1ID=? AND User2ID=? ORDER BY MessageNum DESC limit ?,?','iiii',$params);
$result = $query->get_result();

$html = '';

while($message_row = mysqli_fetch_assoc($result)){
    echo ('
                                    <li class="clearfix Message">
                                        <div class="message-data');
                                            if($message_row['SenderID'] == $userToMessage) {
                                                echo'text-right';
                                            }
                                            echo('">
                                                <span class="message-data-time">'.$message_row['SentTime'].'</span>
                                         </div>
                                        <div class="message');
                                        if($message_row['SenderID'] == $userToMessage){echo'other-message float-right';} 
                                         else{ echo'my-message';}
                                        echo('">'.$message_row['Content'].'</div>
                                    </li> 
							' );

    $html = '<li class="clearfix Message">
                <div class="message-data';
    if($message_row['SenderID'] = $userToMessage) {
        $html .='text-right';
    }
    $html .='">
            <span class="message-data-time">'.$message_row['SentTime'].'</spam>
        </div
    <div class="message';
    if($message_row['SenderID'] == $userToMessage){ $html .='other-message float-right';} 
                                         else{ $html.='my-message';}
    $html .= '">'.$message_row['Content'].'</div>
    <li>';

    // Creating HTML structure
    /*$html .= '<div id="post_'.$time.'" class="post">';
    $html .= '<h1>'.$time.'</h1>';
    $html .= '<p>'.$content.'</p>';
    $html .= '</div>';*/

}

echo $html;