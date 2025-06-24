<?php
//creates a message on the database from a given user in a given chat using the current time
//given user must be in the given chat, otherwise status will return an error
//Returns - Status ("Success" if successful), MessageID the id of the inserted message.
//uses post
//required variables in post are: UserID - int, ChatID - int, MessageContents - String

function cleanInput($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

// Initalise Variables
$UserID = "";
$MessageContents = "";
$ChatID = "";
$CurrentTime = date("Y-m-d H:i:s");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$array = json_decode(file_get_contents("php://input"), true);
	
	$UserID = cleanInput($array["UserID"]); 	// expecting integer
	$ChatID = cleanInput($array["ChatID"]); 	// expecting string
	$MessageContents = cleanInput($array["MessageContents"]);	 // expecting string
}

// Validate data
function validateData($UserID, $ChatID, $MessageContents) {
	// check if chat exists and user is a part of it
	$conn = mysqli_connect("localhost","debian-sys-maint","IZqESYqnzEnILCP4","team001");
    $sql = "SELECT UserID, ChatID FROM ChatUser WHERE UserID = '{$UserID}' AND ChatID = {$ChatID};";
    $result = mysqli_query($conn, $sql);
	
	if (mysqli_num_rows($result) == 0) {
        mysqli_close($conn);
		return false;
	}
	
	// check string length is valid
	if (strlen($MessageContents) <= 0) {
		return false;
	}
	mysqli_close($conn);
	return true;
}

// Connect to Database
$dataArray = array();
if (validateData($UserID, $ChatID, $MessageContents) == true) {	
	$conn = mysqli_connect("localhost","debian-sys-maint","IZqESYqnzEnILCP4","team001");
	$sql = "INSERT INTO ChatMessage (ChatID, UserID, SendingTime, MessageContents) VALUES (?, ?, ?, ?)";
	$stmt = $conn->prepare($sql);

	if ($stmt){
		//bind variables
		$stmt->bind_param("iiss", $ChatID, $UserID, $CurrentTime, $MessageContents);
		//execute statement
		if ($stmt->execute()){
			//successful
			$last_id = $conn->insert_id;
			$dataArray["MessageID"] = $last_id;
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
	
	;

    echo json_encode($dataArray);
}else {
    $dataArray["Status"] = "Data validation failed";
    echo json_encode($dataArray);
}

?>

