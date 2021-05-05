<?php
	require("navBar.php");
?>

<?php
		require('database.php');
		$user = $_SESSION['userID'];
        if(isset($_REQUEST["message"]) || isset($_REQUEST['sendMessage'])) {
            $userToMessage = $_REQUEST['userToMessage'];
            $user1ID = $_REQUEST['User1ID'];
            $user2ID = $_REQUEST['User2ID'];
        }

        if(isset($_REQUEST["sendMessage"])) {
            $content = $_REQUEST["messageSent"];
            $messageNumber = $_REQUEST["messageNumber"];

            $params = array($messageNumber,$user1ID,$user2ID,$user,$content);
            $messageSendQuery = $db->executeStatement('INSERT INTO messages(MessageNum,User1ID,User2ID,SenderID,Content) VALUES(?,?,?,?,?)','iiiis',$params);
        }

        $rowperpage = 10;
        $params = array($user1ID,$user2ID);
        $allcount_query = $db->executeStatement('SELECT count(*) as allcount FROM messages WHERE User1ID=? AND User2ID=?','ii',$params);
        $allcount_result = $allcount_query->get_result();
        $allcount_fetch = mysqli_fetch_array($allcount_result);
        $allcount = $allcount_fetch['allcount'];
        $messageNum = $allcount + 1;

		$params = array($user1ID,$user2ID, $allcount-$rowperpage ,$rowperpage);
		$messages= $db->executeStatement('SELECT * FROM messages WHERE User1ID=? AND User2ID=? ORDER BY MessageNum ASC LIMIT ?,?','iiii',$params);
		$messagesRes = $messages->get_result();

		function displayMessages($messages, $userToMessage, &$messageNum) {
            include('database.php');
			if (!mysqli_num_rows($messages) ) {
			} else {
                $params = array($userToMessage);
                $userToMessageQuery = $db->executeStatement('SELECT * FROM profiles WHERE UserID=?','i',$params);
                $userToMessageQueryResult = $userToMessageQuery->get_result();
                $userInfo = mysqli_fetch_assoc($userToMessageQueryResult);

                echo'
                <div class="chat-header clearfix">
                    <div class="row">
                        <div class="col-lg-6">
                            <a href="javascript:void(0);" data-toggle="modal" data-target="#view_info">
                                <img src="https://bootdey.com/img/Content/avatar/avatar2.png" alt="avatar">
                            </a>
                            <div class="chat-about">
                                <h6 class="m-b-0">'.$userInfo['FirstName'].' '.$userInfo['LastName'].'</h6>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="chat-history overflow-auto">
                                    <ul class="m-b-0">';
					while($message_row = mysqli_fetch_assoc($messages)) {
							echo ('
                                    <li class="clearfix userMessage">
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
					}
                    echo'
                    </ul>
                                </div>';
			}
		}
	?>
<!DOCTYPE html>
<html>
    <head>
 		<link rel = "stylesheet"
			href = "https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css"
			integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl"
			crossorigin="anonymous">
		<link href="https://fonts.googleapis.com/css2?family=Khula:wght@700&display=swap" rel="stylesheet">
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="CSS/connectionMessages.css">
	</head>
	<body>


<div class="container">
<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
                <button class="btn-primary" onClick="window.location.reload();">Reload</button>
                <h1 class="load-more">Load More</h1>
                <input type="hidden" id="row" value="0">
                <input type="hidden" id="all" value="<?php echo $allcount; ?>">
                <div class="chat">
                    <?php displayMessages($messagesRes,$userToMessage, $messageNum);?>
                    <div class="chat-message clearfix">
                        <div class="input-group mb-0">
                            <form action="connectionMessage.php" method="POST">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-send"></i></span>
                                </div>
                                <input type="hidden" name="User1ID" value="<?php echo $user1ID; ?>">
                                <input type="hidden" name="User2ID" value="<?php echo $user2ID; ?>">
                                <input type="hidden" name="userToMessage" value="<?php echo $userToMessage; ?>">
                                <input type="hidden" name="messageNumber" value="<?php echo $messageNum; ?>">
                                <input type="text" class="form-control" name="messageSent" placeholder="Enter text here...">  
                                <div class="input-group-append">
                                    <input type="submit" name="sendMessage" value="Send"> 
                                </div>   
                            </form>                              
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>
</div>

        <script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
            <script>
                $(document).ready(function(){
// Load more data
$('.load-more').click(function(){
    var allcount = Number($('#all').val());
    var row = allcount - Number($('.userMessage').length);
    var rowperpage = 10;
    var userToMessage = "<?php echo $userToMessage ?>";
    var User1ID = "<?php echo $user1ID?>";
    var User2ID = "<?php echo $user2ID?>";
    console.log(row);
    if(row > 0){
        $.ajax({
            url: 'getData.php',
            type: 'post',
            data: {row:row,
                    userToMessage:userToMessage,
                    User1ID:User1ID,
                    User2ID:User2ID},
            beforeSend:function(){
                $(".load-more").text("Loading...");
            },
            success: function(response){

                // Setting little delay while displaying new content
                setTimeout(function() {
                    // appending messages after last message with class="Message"
                    $(".userMessage:first").before(response).show().fadeIn("slow");

                    row = row - rowperpage;
                    console.log(row);
                    // checking row value is greater than allcount or not
                    if(row <= 0){
                        // Change the text and background
                        $('.load-more').text("Hide");
                        $('.load-more').css("background","darkorchid");
                    }else{
                        $(".load-more").text("Load more");
                    }
                }, 2000);

            }
        });
    }else{
        $('.load-more').text("Loading...");

        // Setting little delay while removing contents
        setTimeout(function() {

            // When row is greater than allcount then remove all class='Message' element after 10 elements
            $('.userMessage:nth-last-child(10)').prevAll('.userMessage').remove();

            // Change the text and background
            $('.load-more').text("Load more");
            $('.load-more').css("background","#15a9ce");
            
        }, 1000);
    }
});
});
            </script>
    </body>
</html>