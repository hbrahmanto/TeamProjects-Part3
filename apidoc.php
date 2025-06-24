<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>RESTful API</title>
        <style>
            .api-details{
                border:1px;
            }
        </style>

    </head>
    <body>
        <h1>API Scripts</h1>

        <h1>General</h1>

        <hr>

        <h2>Database/FetchAllUsers.php</h2>
        <div class="api-details">
            <p>fetches details of all users on the system</p><!--description-->
            <p>Method: <code>N/a</code></p>
            <p>Parameters: none</p>
            <h3>Returned JSON format:</h3>
            <pre>
                "UserID": int,
                "Name": string,
                "Email": string,
                "StaffType": string, // stafftypes and thier id's are as follows (employee - 1, teamlead - 2, manager - 3)
                "StaffTypeID": int
            </pre>
        </div>

        <hr>

        <h1>Chat Subsystem</h1>

        <hr>

        <h2>Database/FetchChatsFromUser.php</h2>
        <div class="api-details">
            <p>Returns details of all chats that a given user is in</p><!--description-->
            <p>Method: <code>GET</code></p>
            <p>Parameters:</p>
            <ul>
                <li><code>userID</code> int</li>
            </ul>
            <h3>Returned JSON format:</h3>
            <pre>
                "ChatID": int,
                "ChatType": string,
                "OtherUsersInChat":[
                    {
                        "UserID": int,
                        "Name": string
                    },
                    ...
                ],
                "LastMessage":[
                    {
                        "MessageContents": string,
                        "SenderName": string
                    }
                ]
            </pre>
        </div>

        <hr>

        <h2>Database/FetchMessagesFromChat.php</h2>
        <div class="api-details">
            <p>Returns all the messages from a given chat</p><!--description-->
            <p>Method: <code>GET</code></p>
            <p>Parameters:</p>
            <ul>
                <li><code>ChatID</code> int </li>
            </ul>
            <h3>Returned JSON format:</h3>
            <pre>
                "MesageID": int,
                "MessageContents": string,
                "SendingTime": datetime,
                "UserID": int,
                "Name": string,
                "IsEdited": bool,
                "isDeleted": bool
            </pre>
        </div>

        <hr>

        <h2>Database/CreateMessage.php</h2>
        <div class="api-details">
            <p>Adds a message from the given user in to a chat. User must be a part of the chat</p><!--description-->
            <p>Method: <code>POST</code></p>
            <p>Parameters:</p>
            <ul>
                <li><code>UserID</code> - int </li>
                <li><code>ChatID</code> - int </li>

            </ul>
            <h3>Returned JSON format:</h3>
            <pre>
                "MessageID": int, //if successful, id of the newly created message
                "Status": string  //'Successful' if request was successful, otherwise an error message
            </pre>
        </div>

        <hr>

        <h2>Database/UpdateMessage.php</h2>
        <div class="api-details">
            <p>Changes the text of a given message, and sets IsEddited to true. Given user must have posted the given message</p><!--description-->
            <p>Method: <code>POST</code></p>
            <p>Parameters:</p>
            <ul>
                <li><code>UserID</code> - int</li>
                <li><code>MessageID</code> - int</li>
                <li><code>MesssageContents</code> - string</li>
            </ul>
            <h3>Returned JSON format:</h3>
            <pre>
                "MessageID": int, //the message id of the edited message
                "Status": string //'Successful' if request was successful, otherwise an error message
            </pre>
        </div>

        <hr>

        <h2>Database/DeleteMessage.php</h2>
        <div class="api-details">
            <p>Wipes MessageContents of a message and sets IsDeleted to true. Given user must have posted the given message</p><!--description-->
            <p>Method: <code>POST</code></p>
            <p>Parameters:</p>
            <ul>
                <li><code>UserID</code> int </li>
                <li><code>MessageID</code> int </li>

            </ul>
            <h3>Returned JSON format:</h3>
            <pre>
                "MessageID": int, //the message id of the deleted message
                "Status": string //'Successful' if request was successful, otherwise an error message
            </pre>
        </div>

        <hr>

        <h2>Database/CreatePrivateChat.php</h2>
        <div class="api-details">
            <p>Creates a private chat between two given users, if the chat already exists the ChatID of the existing chat is returned</p><!--description-->
            <p>Method: <code></code></p>
            <p>Parameters:</p>
            <ul>
                <li><code>User1ID</code> int </li>
                <li><code>User2ID</code> int </li>
            </ul>
            <h3>Returned JSON format:</h3>
            <pre>
                "ChatID": int, //the id of the new or existing chat
                "Status": string //'Successful' if new chat was created, otherwise an error message
            </pre>
        </div>

        <hr>

        <h2>Database/CreateGroupChat.php</h2>
        <div class="api-details">
            <p>Creates a new group chat with the given user in it, user AddUserToGroupChat.php to add more users to the chat</p><!--description-->
            <p>Method: <code>POST</code></p>
            <p>Parameters:</p>
            <ul>
                <li><code>UserID</code> int </li>
            </ul>
            <h3>Returned JSON format:</h3>
            <pre>
                "ChatID": int, //the id of the new chat
                "Status": string //'Successful' if new chat was created, otherwise an error message
            </pre>
        </div>

        <hr>

        <h2>Database/AddUserToGroupChat.php</h2>
        <div class="api-details">
            <p>Adds the given user to the Given group chat, chat must not be a private chat, and user must not already be in the chat</p><!--description-->
            <p>Method: <code>POST</code></p>
            <p>Parameters:</p>
            <ul>
                <li><code>UserID</code> int </li>
                <li><code>ChatID</code> int </li>
            </ul>
            <h3>Returned JSON format:</h3>
            <pre>
                "Status": string //'Successful' if request was successful, otherwise an error message
            </pre>
        </div>

        <hr>

        <h1>Analytics System</h1>

        <hr>

        <h2>Database/FetchAllProjectsInfo.php</h2>
        <div class="api-details">
            <p>Gets information about each project on the server</p><!--description-->
            <p>Method: <code>N/a</code></p>
            <p>Parameters: None</p>
            <h3>Returned JSON format:</h3>
            <pre>
                "ProjectID": int,
                "ProjectName": string,
                "ProjectDeadline": date,
                "Leaders":[ //A Json of all team leaders assigned to the project
                    {
                        "UserID": int,
                        "Name": string                    
                    },
                    ...
                ]
                "TaskCount": int, //the total number of tasks on the project
                "Complete": int, //the number of complete tasks on the project
                "InProgress": int, //the number of in progress tasks on the project
                "Halted": int, //the number of halted tasks on the project
                "Pending": int //the number of pending tasks on the project
            </pre>
        </div>

        <hr>

        <h2>Database/FetchProjectTasks.php</h2>
        <div class="api-details">
            <p>Gets information about every task on a given project</p><!--description-->
            <p>Method: <code>POST</code></p>
            <p>Parameters:</p>
            <ul>
                <li><code>ProjectID</code> int </li>
            </ul>
            <h3>Returned JSON format:</h3>
            <pre>
                "TaskID": int,
                "TaskName": string,
                "MaxAssignedEmployees": int,
                "PersonHoursEstimation": int,
                "TaskStatus": string,
                "CompleteDate": date, // null if task is not Completed
                "StartDate": date,
                "AssignedEmployees":[
                    {
                        "UserID": int,
                        "Name": string,
                        "Email": string,
                        "Location": string // 3 letter iso code
                    },
                    ...
                ]

            </pre>
        </div>

        <hr>

        <h2>Database/FetchUserTasks.php</h2>
        <div class="api-details">
            <p>Gets all the tasks assigned to the given user</p><!--description-->
            <p>Method: <code>POST</code></p>
            <p>Parameters:</p>
            <ul>
                <li><code>UserID</code> int </li>
            </ul>
            <h3>Returned JSON format:</h3>
            <pre>
                "TaskID": int,
                "TaskName": string,
                "ProjectID": int,
                "ProjectName", string,
                "MaxAssignedEmployees": int,
                "PersonHoursEstimation", int,
                "TaskStatus": string, // complete, inprogress, halted, or pending
                "Deadline": date,
                "CompletedDate": date, //null if task is not complete
                "StartDate": date
            </pre>
        </div>

        <hr>

        <h2>Database/FetchProjectTasksByUser.php</h2>
        <div class="api-details">
            <p>Gets task by status on a given project for each user connected to the project</p><!--description-->
            <p>Method: <code>POST</code></p>
            <p>Parameters:</p>
            <ul>
                <li><code>ProjectID</code> int </li>
            </ul>
            <h3>Returned JSON format:</h3>
            <pre>

                "UserID": int,
                "Name": string, //name of the user
                "TaskCount": int, //the amount of tasks the user is assigned
                "Complete": int, //the amount of complete tasks the user is assigned
                "InProgress": int, //the amount of in progress tasks the user is assigned
                "Halted": int, //the amount of halted tasks the user is assigned
                "Pending": int //the amount of pending tasks the user is assigned

            </pre>
        </div>

        <hr>

        <h2>Database/UpdateTaskStatus.php</h2>
        <div class="api-details">
            <p>Changes the status of a given task</p><!--description-->
            <p>Method: <code>POST</code></p>
            <p>Parameters:</p>
            <ul>
                <li><code>TaskID</code> int </li>
                <li><code>Status</code> string //must be either "complete", "inprogress", "halted", or "pending" </li>

            </ul>
            <h3>Returned JSON format:</h3>
            <pre>
                "Status": string //'Successful' if request was successful, otherwise an error message
            </pre>
        </div>

        
    </body>
</html>