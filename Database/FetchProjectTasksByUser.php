<?php
//Fetches all the tasks on a given project per user on the project
//Returned json will be of the form:
//UserID - int, Name - String
//TaskCount is an integer denoting how many tasks a user is assigned in a given project
// Complete, InProgress, Halted, Pending are integers counting how many tasks a user is assigned of each status
//uses post
//required variables in post are: ProjectID - int

function cleanInput($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

// Initalise Variables
$ProjectID = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$array = json_decode(file_get_contents("php://input"), true);
	$ProjectID = cleanInput($array["ProjectID"]); 	// expecting integer
}

// Connect to Database
$dataArray = [];

$conn = mysqli_connect("localhost","debian-sys-maint","IZqESYqnzEnILCP4","team001");

$sql = "SELECT Users.UserID, Users.Name,
    COUNT(*) as TaskCount,
    COUNT(CASE WHEN Task.TaskStatus = 'complete' THEN 1 END) as 'Complete',
    COUNT(CASE WHEN Task.TaskStatus = 'inprogress' THEN 1 END) as 'InProgress',
    COUNT(CASE WHEN Task.TaskStatus = 'halted' THEN 1 END) as 'Halted',
    COUNT(CASE WHEN Task.TaskStatus = 'pending' THEN 1 END) as 'Pending'
    FROM Task
    JOIN UserTask ON Task.TaskID = UserTask.TaskID
    JOIN Users on Users.UserID = UserTask.UserID
    WHERE Task.ProjectID = ?
    GROUP BY Users.UserID";
$stmt = $conn->prepare($sql);

if ($stmt){
    //bind variables
    $stmt->bind_param("i", $ProjectID);
    //execute statement
    if ($stmt->execute()){
        //successful;
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()){
            $dataArray[] = $row;
        }
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
?>

