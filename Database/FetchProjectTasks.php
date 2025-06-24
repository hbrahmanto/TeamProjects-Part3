<?php
//Fetches all the tasks on a given project and information about them
//Returned json will be of the form:
//TaskID - int, TaskName - String, MaxAssignedEmployees - int, PersonHoursEstimate - int,TaskStatus - String, Deadline - date, CompletedDate - date (null if task not complete)
//AssignedEmployees denotes all employees assigned to a task, it is a JSON of the form
// UserID - int, Name - string
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

$sql = "SELECT Task.TaskID, Task.TaskName, Task.MaxAssignedEmployees, Task.PersonHoursEstimation, Task.TaskStatus, Task.Deadline, Task.CompletedDate, Task.StartDate,
    JSON_ARRAYAGG(JSON_OBJECT('UserID', Users.UserID, 'Name', Users.Name, 'Email', Users.Email, 'Location', Users.Location)) as 'AssignedEmployees'
    FROM Task
    JOIN UserTask ON Task.TaskID = UserTask.TaskID
    JOIN Users ON Users.UserID = UserTask.UserID
    WHERE Task.ProjectID = ?
    GROUP BY Task.TaskID";
$stmt = $conn->prepare($sql);

if ($stmt){
    //bind variables
    $stmt->bind_param("i", $ProjectID);
    //execute statement
    if ($stmt->execute()){
        //successful;
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()){
            $assigned = json_decode($row['AssignedEmployees'], true);
            $row['AssignedEmployees'] = $assigned;
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

