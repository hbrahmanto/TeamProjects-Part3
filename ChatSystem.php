<!doctype html>
<html lang = en>

    <head>

        <!--Initialization-->
        <meta charset = "utf-8">
        <meta name = "viewport" content = "width=device-width, initial-scale = 1.0">

        <!--Bootstrap Import-->
        <link href = "https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel = "stylesheet" integrity = "sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin = "anonymous">
        <script src = "https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity = "sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin = "anonymous"></script>

        <!--CSS Import-->
        <link rel = "stylesheet" type = "text/css" href = "Stylesheet.css">

        <!--JavaScript Import-->
        <script src = "ChatSystem.js" defer></script>

        <!--Page Icon-->
        <link rel = "icon" href = "Assets/Logo.ico" type = "image/x-icon">

        <!--Database Calling-->
        <script src="Database/DatabaseRequest.js"></script>

        <title>Chat System</title>
        
    </head>

    <body>

        <!--Navigation Menu Import-->
        <script src = "TopBar.js"></script>
        <script src = "SideBar.js"></script>
        <script src = "BottomNavBar.js"></script>

        <div id = "centreHome">

            <form action = "#" id="chatSearch">
                <input type = "text" placeholder = "Search for Chats" id = "chatSearchBar">
            </form>

            <div id = "chatsdiv">
            </div>

        </div>

        <div id = "backHome">

            <button id = "backButton">Back</button>

        </div>

        <div id = "newGroup">

            <button id = "newGroupButton">New Group</button>

        </div>

        <div id = "centreNewMessage">

            <form action = "#" id = "employeeSearch">

                <input type = "text" placeholder = "Search for Employees" id = "employeeSearchBar">

            </form>   

            <button id = "exem1">Example Employee 1</button>
            <button id = "exem2">Example Employee 2</button>
            <button id = "exem3">Example Employee 3</button>
            <button id = "exem4">Example Employee 4</button>

        </div>

        <div id = "createGroup">

            <button id = "createGroupButton">Create Group</button> 

        </div>

        <div id = "centreNewGroup">

            <form action = "#" id = "groupSearch">

                <input type = "text" placeholder = "Search for Groups" id = "groupSearchBar">

            </form>

            <button id = "exgr1">Example Group Employee 1</button>
            <button id = "exgr2">Example Group Employee 2</button>
            <button id = "exgr3">Example Group Employee 3</button>
            <button id = "exgr4">Example Group Employee 4</button>

        </div>

        <div id = "centrePersonalChat">

            <button id = "exmsg1">Example Message 1</button>
            <button id = "exmsg2">Example Message 2</button>
            <button id = "exmsg3">Example Message 3</button>
            <button id = "exmsg4">Example Message 4</button>

            <form action = "#" id="messageForm">

                <input type = "text" placeholder = "Chat Here!" id = "messageText">
                <button id = "messageSendButton">Send</button>

            </form>

        </div>

    </body>

</html>