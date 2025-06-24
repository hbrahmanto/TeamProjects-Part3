<?php
//adds a given user to a group chat
//given user must be in the given chat, otherwise status will return an error
//Returns - Status ("Success" if successful).
//uses post
//required variables in post are: UserID - int, ChatID - int

// Initalise Variables
$UserID = "";
$ChatID = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$array = json_decode(file_get_contents("php://input"), true);

	$UserID = $array["UserID"]; 	// expecting integer
	$ChatID = $array["ChatID"]; 	// expecting integer
}

// Validate chatid
function validateChat($ChatID) {
	// check if chat exists,it is a group
	$conn = mysqli_connect("localhost","debian-sys-maint","IZqESYqnzEnILCP4","team001");
    $sql = "SELECT ChatID, ChatType
    FROM Chats
    WHERE ChatID = ?;";

    $stmt = $conn->prepare($sql);
    
    if ($stmt){
        $stmt->bind_param("i", $ChatID);
        if($stmt->execute()){
            $stmt->store_result();
            if ($stmt->num_rows > 0){ //chat was found
                $stmt->bind_result($chatID, $chatType);
                if ($chatType == "group"){
                    $conn->close();
                    return "valid"; 
                }
                $conn->close();
                return "valid";
            }else{
                $conn->close();
                return "invalid ChatID";
            }
            
        }else{
           $conn->close();
            return "error excecuting validation statement"; 
        }
        
    }else{
        $conn->close();
        return "error preparing validation statement";
    }
}

// Validate userid
function validateUser($userID) {
	// check if chat exists,it is a group
	$conn = mysqli_connect("localhost","debian-sys-maint","IZqESYqnzEnILCP4","team001");
    $sql = "SELECT UserID
    FROM Users
    WHERE UserID = ?;";

    $stmt = $conn->prepare($sql);
    
    if ($stmt){
        $stmt->bind_param("i", $userID);
        if($stmt->execute()){
            $stmt->store_result();
            if ($stmt->num_rows > 0){ //chat was found                
				$conn->close();
				return "valid"; 
            }
            $conn->close();
            return "invalid UserID: $userID";
        }
        $conn->close();
        return "error excecuting validation statement";
    }else{
        $conn->close();
        return "error preparing validation statement";
    }
}

// Connect to Database
$dataArray = array();
$isChatValid = validateChat($ChatID);
$isUserValid = validateUser($UserID);
if ($isChatValid == "valid" and $isUserValid = "valid") {	
	$conn = mysqli_connect("localhost","debian-sys-maint","IZqESYqnzEnILCP4","team001");
	$sql = "INSERT INTO ChatUser (ChatID, UserID) VALUES (?, ?)";
	$stmt = $conn->prepare($sql);

	if ($stmt){
		//bind variables
		$stmt->bind_param("ii", $ChatID, $UserID);
		//execute statement
		if ($stmt->execute()){
			//successful
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
    $dataArray["Status"] = "Data validation failed, Chat: $isChatValid, User: $isUserValid";
    echo json_encode($dataArray);
}

?>

