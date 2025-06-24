<?php
//Updates the status of a given task
//given task must exist, and status must be one of "pending", "inprogress", "halted", "complete"
//Returns - Status ("Success" if successful), otherwise an error
//uses post
//required variables in post are: TaskID - int, Status - string ("pending", "inprogress", "halted", "complete")


// Initalise Variables
$TaskID = "";
$Status = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$array = json_decode(file_get_contents("php://input"), true);
	
	$TaskID = $array["TaskID"]; 	// expecting integer
	$Status = $array["Status"]; 	// expecting String
}

// Validate data
function validateData($TaskID,$Status) {
	// check task exists
    $isTaskValid = "default";
    $isStatusValid = "default";

	$conn = mysqli_connect("localhost","debian-sys-maint","IZqESYqnzEnILCP4","team001");
    $sql = "SELECT TaskID 
        FROM Task
        WHERE TaskID = ?;";
    $stmt = $conn->prepare($sql);

	if ($stmt){
		//bind variables
		$stmt->bind_param("i", $TaskID);
		//execute statement
		if ($stmt->execute()){
			//successful
            $isTaskValid = "valid";
		}else{
			//failed
			$isTaskValid = "validation statement execution failed";
		}
	}else{
		//preparing statement failed
		$isTaskValid = "validation statement preparing failed";
	}
    if ($Status != "pending" and $Status != "inprogress" and $Status != "halted" and $Status != "complete"){
        $isStatusValid = "invalid status given: $Status. Expexing 'pending', 'inprogress', 'halted', or 'complete'";
    }else{
        $isStatusValid = "valid";
    }

	mysqli_close($conn);
    return [$isTaskValid, $isStatusValid];
}

// Connect to Database
$dataArray = array();
$validArray = validateData($TaskID);
$isTaskValid = $validArray[0];
$isStatusValid = $validArray[1];
if ($isTaskValid == "valid" and $isStatusValid == "valid") {	
	$conn = mysqli_connect("localhost","debian-sys-maint","IZqESYqnzEnILCP4","team001");
	$sql = "UPDATE Task SET TaskStatus = ? WHERE TaskID = ?";
	$stmt = $conn->prepare($sql);

	if ($stmt){
		//bind variables
		$stmt->bind_param("si", $Status, $TaskID);
		//execute statement
		if ($stmt->execute()){
			//successful;
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
    $dataArray["Status"] = "Data validation failed, task: $isTaskValid, Status: $isStatusValid";
    echo json_encode($dataArray);
}

?>

