<?php
//fetches all chats a given user is a part of. expects to be called with a UserID appended as get.

//Returned json will be of the form:
//ChatID, ChatType, OtherUsersInChat, LastMessage
//Where OtherUsersInChat is a json of the form: UserID, Name
//Last Message is a json in the form: MessageContents, SenderName
//WARNING this will be null if there is no messages in the chat

//function to to some simple sanitisation of inputted data
function cleanInput($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

// Initalise variables
$UserID = "";
if ($_SERVER["REQUEST_METHOD"] == "GET") {
	// PHP File should recieve project_id
	$UserID = cleanInput($_GET["userID"]);
}

// sql query that will be run on the server
$sql = "SELECT Chats.ChatID, Chats.ChatType, (SELECT JSON_ARRAYAGG(JSON_OBJECT('UserID', Users.UserID,'Name', Users.Name))
            FROM ChatUser
            JOIN Users on ChatUser.UserID = Users.UserID
            WHERE ChatUser.ChatID = Chats.ChatID AND ChatUser.UserID != $UserID
            GROUP BY ChatUser.ChatID
            ) as OtherUsersInChat,
            (SELECT JSON_OBJECT(
                'MessageContents' , ChatMessage.MessageContents,
                'SenderName', Users.Name)
            FROM ChatMessage
            JOIN Users ON ChatMessage.UserID = Users.UserID
            WHERE ChatMessage.ChatID = Chats.ChatID
            ORDER BY ChatMessage.SendingTime DESC
            LIMIT 1) AS LastMessage

        FROM Chats 
        JOIN ChatUser ON ChatUser.ChatID = Chats.ChatID
        JOIN Users ON ChatUser.UserID = Users.UserID 
        WHERE ChatUser.UserID = $UserID
        GROUP BY Chats.ChatID, Chats.ChatType";	

// Connect to Database
$conn = mysqli_connect("localhost","debian-sys-maint","IZqESYqnzEnILCP4","team001");
// save the response using the conection and the sql query
$result = mysqli_query($conn, $sql);

//encode to json array
$dataArray = [];
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        //reencode the jsons to fix an error, may not be neccesary
        $otherUsersInChat = json_decode($row['OtherUsersInChat'], true);
        $row['OtherUsersInChat'] = $otherUsersInChat;
        $latestMessage = json_decode($row['LastMessage']);
        $row['LastMessage'] = $latestMessage;
        $dataArray[] = $row;
    }
}

mysqli_close($conn);
echo json_encode($dataArray);
?>
