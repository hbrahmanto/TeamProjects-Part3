
<?php

//creates a new private chat between two given users
//if chat already exists, the chatid of that chat will be returned
//Returns - Status ("Success" if successful), ChatID, otherwise error and existing chatid
//uses post
//required variables in post are: User1ID - int, User2ID - int


// Initalise Variables
$UserID = "";
$ChatID = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$array = json_decode(file_get_contents("php://input"), true);

	$User1ID = $array["User1ID"]; 	// expecting integer
	$User2ID = $array["User2ID"]; 	// expecting integer
}

// Validate chatid
function validateData($User1ID, $User2ID ) {
    ini_set("display_errors", 1);
    ini_set("track_errors", 1);
    ini_set("html_errors", 1);
    error_reporting(E_ALL);
    $isChatValid = "default";
    $chatID = -1;
    $isUserValid = "valid";
	// check if chat exists already
	$conn = mysqli_connect("localhost","debian-sys-maint","IZqESYqnzEnILCP4","team001");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    $sql = "SELECT Chats.ChatID
        FROM Chats
        JOIN ChatUser AS cu1 ON Chats.ChatID = cu1.ChatID
        JOIN ChatUser AS cu2 ON Chats.ChatID = cu2.ChatID
        WHERE Chats.ChatType = 'private'
        AND cu1.UserID = ?
        AND cu2.UserID = ?";

    $stmt = $conn->prepare($sql);
    
    if ($stmt){
        $stmt->bind_param("ii", $User1ID, $User2ID);
        if($stmt->execute()){
            $stmt->store_result();
            $stmt->bind_result($chatID);
            $stmt->fetch();

            if ($stmt->num_rows > 0){ //chat already exists     
                $isChatValid =  "chat already exists"; 
            }else{
                $isChatValid = "valid";
            }
            
            
        }else{
            $isChatValid = "error executing validation statement: " . mysqli_stmt_error($stmt);
        }
        
    }else{
        $isChatValid =  "error preparing validation statement";
    }

    if ($User1ID == $User2ID){
        $isUserValid = "User1 and User2 cannot be identical. User1: $User1ID User2: $User2ID";
    }

    $conn->close();
    return [$isChatValid, $chatID, $isUserValid];
}

// Connect to Database
$dataArray = array();
$validateResult = validateData($User1ID,$User2ID);
$isChatValid= $validateResult[0];
$isUserValid= $validateResult[2];
$chatID = $validateResult[1];
if ($isChatValid == "valid" and $isUserValid == "valid") {	
	$conn = mysqli_connect("localhost","debian-sys-maint","IZqESYqnzEnILCP4","team001");
	$sql = "INSERT INTO Chats (ChatType) VALUES ('private')";
    //create the chat
    if($conn->query($sql) === TRUE){
        $newChatID = $conn->insert_id;

        //insert user1
        $sqlInsertUser = "INSERT INTO ChatUser (ChatID, UserID) VALUES (?,?)";
        $stmtInsertUser1 = $conn->prepare($sqlInsertUser);
        $stmtInsertUser1->bind_param("ii", $newChatID, $User1ID);
        if ($stmtInsertUser1->execute()){
            //insert user 2
            $stmtInsertUser2 = $conn->prepare($sqlInsertUser);
            $stmtInsertUser2->bind_param("ii", $newChatID, $User2ID);
            if($stmtInsertUser2->execute()){
                $dataArray["Status"] = "Success";
                $dataArray["ChatID"] = $newChatID;
            }else{
                $dataArray["Status"] = "error inserting user 2";
            }
        }else{
            $dataArray["Status"] = "error inserting user 1";
        }

    }else{
        $dataArray["Status"] = "Couldnt create new private chat in chats table";
    }
	$conn->close();
    echo json_encode($dataArray);
}else {
    $dataArray["Status"] = "Data validation failed, Chat: $isChatValid";
    $dataArray["ChatID"] = $chatID;
    echo json_encode($dataArray);
}

?>

