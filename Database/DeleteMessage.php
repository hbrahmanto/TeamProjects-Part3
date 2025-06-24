<?php
//Deletes a message by flagging it and marking as deleted and updating the text to a placeholder, this is so it is still returned when messages are fetched
//given user must have written the given chat, otherwise status will return an error
//Returns - Status ("Success" if successful)
//uses post
//required variables in post are: MessageID - int, UserID - int, MessageContents - String

function cleanInput($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

// Initalise Variables
$UserID = "";
$MessageID = "";
$MessageContents = "Message Deleted";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$array = json_decode(file_get_contents("php://input"), true);
	
	$UserID = cleanInput($array["UserID"]); 	// expecting integer
	$MessageID = cleanInput($array["MessageID"]); 	// expecting string
}

// Validate data
function validateData($UserID, $ChatID, $MessageID) {
	// check if chat message exists from given user
	$conn = mysqli_connect("localhost","debian-sys-maint","IZqESYqnzEnILCP4","team001");
    $sql = "SELECT ChatUser.UserID, ChatMessage.MessageContents 
        FROM ChatUser 
        JOIN ChatMessage on ChatUser.UserID = ChatMessage.UserID 
        WHERE ChatUser.UserID = {$UserID} AND ChatUser.ChatID = {$ChatID} AND MessageID = {$MessageID};";
    $result = mysqli_query($conn, $sql);
	
	if (mysqli_num_rows($result) == 0) {
        mysqli_close($conn);
		return false;
	}
	mysqli_close($conn);
	return true;
}

// Connect to Database
$dataArray = array();
if (validateData($UserID, $ChatID, $MessageID) == true) {	
	$conn = mysqli_connect("localhost","debian-sys-maint","IZqESYqnzEnILCP4","team001");
	$sql = "UPDATE ChatMessage SET MessageContents = ?, IsDeleted = 1 WHERE MessageID = ?";
	$stmt = $conn->prepare($sql);

	if ($stmt){
		//bind variables
		$stmt->bind_param("si", $MessageContents, $MessageID);
		//execute statement
		if ($stmt->execute()){
			//successful;
			$dataArray["MessageID"] = $MessageID;
			$dataArray["Status"] = "Success";
		}else{
			//failed
			$dataArray["Status"] = "Statement execution failed";
		}
	}else{
		//preparing statement failed
		$dataArray["Status"] = "Statement preparing failed";
	}

	$stmt->close();
	$conn->close();
    echo json_encode($dataArray);
}else {
    $dataArray["Status"] = "Data validation failed";
    echo json_encode($dataArray);
}

?>

