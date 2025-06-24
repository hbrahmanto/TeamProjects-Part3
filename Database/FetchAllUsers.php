<?php
//fetches every user on the server.

//Returned json will be of the form:
//UserID, Name, Email, StaffType (string), StaffTypeID (int)
// stafftypes and thier id's are as follows (Employee - 1, TeamLead - 2, Manager - 3)

// sql query that will be run on the server
$sql = "SELECT Users.UserID, Users.Name, Users.Email, StaffType.StaffTypeName as StaffType, StaffType.StaffTypeID
        FROM Users
        JOIN StaffType ON Users.StaffTypeID = StaffType.StaffTypeID";	

// Connect to Database
$conn = mysqli_connect("localhost","debian-sys-maint","IZqESYqnzEnILCP4","team001");
// save the response using the conection and the sql query
$result = mysqli_query($conn, $sql);

//encode to json array
$dataArray = [];
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $dataArray[] = $row;
    }
}

mysqli_close($conn);
echo json_encode($dataArray);
?>
