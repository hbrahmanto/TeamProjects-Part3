<?php
//Fetches all messages from a chat in chronological order, expects to be called with a ChatID appended as get.

//Returned json will be of the form:
//MessageID - int, MessageContents - string, SendingTime - datetime, UserID - int, Name - string, IsEdited - bool, IsDeleted - bool 

//function to to some simple sanitisation of inputted data
function cleanInput($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

// Initalise variables
$ChatID = "";
if ($_SERVER["REQUEST_METHOD"] == "GET") {
	// PHP File should recieve project_id
	$ChatID = cleanInput($_GET["ChatID"]);
}

// sql query that will be run on the server
$sql = "SELECT ChatMessage.MessageID, ChatMessage.MessageContents, ChatMessage.SendingTime, Users.UserID, Users.Name, ChatMessage.IsEdited, ChatMessage.IsDeleted
        FROM Chats 
        JOIN ChatMessage ON ChatMessage.ChatID = Chats.ChatID 
        LEFT JOIN Users ON Users.UserID = ChatMessage.UserID
        WHERE Chats.ChatID = $ChatID
        ORDER BY SendingTime ASC";	

// Connect to Database
$conn = mysqli_connect("localhost","debian-sys-maint","IZqESYqnzEnILCP4","team001");
// save the response using the conection and the sql query
$result = mysqli_query($conn, $sql);

//encode to json array
$dataArray = [];
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $dataArray[] = $row;
    }
}

mysqli_close($conn);
echo json_encode($dataArray);
?>
