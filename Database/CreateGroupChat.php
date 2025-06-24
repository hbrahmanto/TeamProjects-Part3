
<?php
//creates a new group chat with the give user in it
//Returns - Status ("Success" if successful), ChatID, otherwise error
//uses post
//required variables in post are: UserID


// Initalise Variables
$UserID = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$array = json_decode(file_get_contents("php://input"), true);
	$UserID = $array["UserID"]; 	// expecting integer
}

// Validate user
function validateData($userID) {
    $isValid = "default";

	// check if chat exists already
	$conn = mysqli_connect("localhost","debian-sys-maint","IZqESYqnzEnILCP4","team001");

    $sql = "SELECT UserID
        FROM Users
        WHERE UserID = ?";

    $stmt = $conn->prepare($sql);
    
    if ($stmt){
        $stmt->bind_param("i", $userID);
        if($stmt->execute()){
            $stmt->store_result();
            $stmt->fetch();
            if ($stmt->num_rows > 0){ //user exists   
                $isValid = "valid";
            }else{
                $isValid =  "invalid user given: $userID";
            }
        }else{
            $isValid = "error excecuting validation statement";
        }
        
    }else{
        $isValid =  "error preparing validation statement";
    }

    $conn->close();
    return $isValid;
}

// Connect to Database
$dataArray = array();
$isValid = validateData($UserID);
if ($isValid == "valid") {	
	$conn = mysqli_connect("localhost","debian-sys-maint","IZqESYqnzEnILCP4","team001");
	$sql = "INSERT INTO Chats (ChatType) VALUES ('group')";
    //create the chat
    if($conn->query($sql) === TRUE){
        $newChatID = $conn->insert_id;

        //insert user
        $sqlInsertUser = "INSERT INTO ChatUser (ChatID, UserID) VALUES (?,?)";
        $stmtInsertUser = $conn->prepare($sqlInsertUser);
        $stmtInsertUser->bind_param("ii", $newChatID, $UserID);
        if ($stmtInsertUser->execute()){
            $dataArray["Status"] = "Success";
            $dataArray["ChatID"] = $newChatID;
        }else{
            $dataArray["Status"] = "error inserting user";
        }

    }else{
        $dataArray["Status"] = "Couldnt create new group chat in chats table";
    }
	$conn->close();
    echo json_encode($dataArray);
}else {
    $dataArray["Status"] = "Data validation failed: $isValid";
    echo json_encode($dataArray);
}

?>