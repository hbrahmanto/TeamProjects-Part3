<?php
//fetches general information about each project on the server.

//Returned json will be of the form:
//ProjectID, Leaders, ProjectName, TaskCount, Complete, InProgress, Halted, Pending
// TaskCount is an integer denoting how many tasks a project has
// Complete, InProgress, Halted, Pending are integers counting how many tasks in a project have each status
//Leaders is a json of the form: UserID, Name. it is a list of all team leaders assigned to a project

// sql query that will be run on the server
$sql = "SELECT Project.ProjectID, 
            Project.ProjectName, 
            Project.ProjectDeadline,
            JSON_ARRAYAGG(JSON_OBJECT('UserID', Users.UserID, 'Name', Users.Name)) as 'Leaders',
            COUNT(*) as TaskCount,
            COUNT(CASE WHEN Task.TaskStatus = 'complete' THEN 1 END) as 'Complete',
            COUNT(CASE WHEN Task.TaskStatus = 'inprogress' THEN 1 END) as 'InProgress',
            COUNT(CASE WHEN Task.TaskStatus = 'halted' THEN 1 END) as 'Halted',
            COUNT(CASE WHEN Task.TaskStatus = 'pending' THEN 1 END) as 'Pending'
        FROM Project
        LEFT JOIN TeamLeader on Project.ProjectID = TeamLeader.ProjectID
        LEFT JOIN Users on TeamLeader.UserID = Users.UserID
        LEFT JOIN Task on Project.ProjectID = Task.ProjectID
        GROUP BY Project.ProjectID, Project.ProjectName";	

// Connect to Database
$conn = mysqli_connect("localhost","debian-sys-maint","IZqESYqnzEnILCP4","team001");
// save the response using the conection and the sql query
$result = mysqli_query($conn, $sql);

//encode to json array
$dataArray = [];
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        //reencoded json to fix some errors when running this file
        $leaders = json_decode($row['Leaders'], true);
        $row['Leaders'] = $leaders;
        $dataArray[] = $row;
    }
}

mysqli_close($conn);
echo json_encode($dataArray);
?>
