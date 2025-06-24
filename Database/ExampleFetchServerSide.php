<?php
//test file for fetching data from the server, expects to be called with a UserID appended as get.

//Returned json will be of the form:
//ChatID, ChatType, OtherUsersInChat
//Where OtherUsersInChat is a json of the form UserID, Name

//function to do some simple sanitisation of inputted data
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
//This example fetches every chat that a give user is a part of, along with the other users in those chats
$sql = "SELECT Chats.ChatID, Chats.ChatType, (SELECT JSON_ARRAYAGG(JSON_OBJECT('UserID', Users.UserID,'Name', Users.Name))
            FROM ChatUser
            JOIN Users on ChatUser.UserID = Users.UserID
            WHERE ChatUser.ChatID = Chats.ChatID AND ChatUser.UserID != $UserID
            GROUP BY ChatUser.ChatID
            ) as OtherUsersInChat
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
        $otherUsersInChat = json_decode($row['OtherUsersInChat'], true);
        $row['OtherUsersInChat'] = $otherUsersInChat;
        $dataArray[] = $row;
    }
}

mysqli_close($conn);
echo json_encode($dataArray);
?>
