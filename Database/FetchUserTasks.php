<?php
//Fetches all the tasks assigned to a given user
//Returned json will be of the form:
//TaskID - int, TaskName - String, MaxAssignedEmployees - int, PersonHoursEstimate - int,TaskStatus - String, Deadline - date, CompletedDate - date (null if task not complete), ProjectID - int, ProjectName - String
//uses post
//required variables in post are: UserID - int

function cleanInput($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

// Initalise Variables
$UserID = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$array = json_decode(file_get_contents("php://input"), true);
	$UserID = cleanInput($array["UserID"]); 	// expecting integer
}

// Connect to Database
$dataArray = [];

$conn = mysqli_connect("localhost","debian-sys-maint","IZqESYqnzEnILCP4","team001");

$sql = "SELECT Task.TaskID, Task.TaskName, Project.ProjectID, Project.ProjectName, Task.MaxAssignedEmployees , Task.PersonHoursEstimation, Task.TaskStatus, Task.Deadline, Task.CompletedDate, Task.StartDate
    FROM Task
    LEFT JOIN Project on Project.ProjectID = Task.ProjectID
    JOIN UserTask on UserTask.TaskID = Task.TaskID
    WHERE UserTask.UserID = ?
    GROUP BY Task.TaskID";
$stmt = $conn->prepare($sql);

if ($stmt){
    //bind variables
    $stmt->bind_param("i", $UserID);
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

