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

        <!-- chat bubble imports-->
        <script src = "SentChatBubble.js"></script>
        <script src = "ReceivedChatBubble.js"></script>

        <script>
            var pageUserID = 13;//the user id that is used in fetches
            var pageUserName = "TeamLeader";


            document.addEventListener("DOMContentLoaded", ()=>{
                console.log("page loaded")
                document.getElementById("topbar-user-name").innerHTML = `<b>${pageUserName}</b>`
                loadPrivateChats()//load the first private chats page on chat load
            })
        </script>

        <title>Chat System</title>
        
    </head>

    <body>

        <!--Navigation Menu Import-->
        <script src = "TopBar.js"></script>
        <script src = "SideBar.js"></script>
        <script src = "BottomNavBar.js"></script>



        <!--holds the tabs that are switch between from the bottom navbar -->
        <div id="centreHome">
            <!-- div for showing list of private chats -->
            <div id="private-chat-container" class="tab-content" style="display:none">

                    <form action = "#" id="chatSearch">
                        <input type = "text" placeholder = "Search for Chats" id = "chatSearchBar">
                    </form>

                    <div id = "private-chat-div">
                        placeholder, private chats screen
                    </div>

            </div>

            <!-- div for showing list of group chats -->
            <div id="group-chat-container" class="tab-content" style="display:none">
                <div id = "centreHome">

                    <form action = "#" id="chatSearch">
                        <input type = "text" placeholder = "Search for Chats" id = "chatSearchBar">
                    </form>

                    <div id = "group-chat-div">
                        placeholder, group chats screen
                    </div>

                </div>
            </div>

            <!-- div for showing messages in a chat -->
            <div id="messages-chat-container" class="tab-content" style="display:none">
                <h2 id="messages-title"></h2>
                <div id="messages-div">
                    No chats selected, select a chat from the bottom nav bar.
                </div>
                <!-- mesasge input goes here -->
                <div class="message-input-container">
                    <input type="text" id="messageInput" placeholder="Type a message...">
                </div>
            </div>


        </div>


        <div id = "backHome">

            <button id = "backButton">Back</button>

        </div>

        <div id = "newGroup">

            <button id = "newGroupButton">New Group</button>

        </div>

            <!-- set as hidden so the example can be shown, add these to the relevant tab-content above -->
        <div id = "centreNewMessage" style="display:none">

            <form action = "#" id = "employeeSearch">

                <input type = "text" placeholder = "Search for Employees" id = "employeeSearchBar">

            </form>   

            <button id = "exem1">Example Employee 1</button>
            <button id = "exem2">Example Employee 2</button>
            <button id = "exem3">Example Employee 3</button>
            <button id = "exem4">Example Employee 4</button>

        </div>

            <!-- set as hidden so the example can be shown -->
        <div id = "createGroup">

            <button id = "createGroupButton">Create Group</button> 

        </div>

            <!-- set as hidden so the example can be shown -->
        <div id = "centreNewGroup" style="display:none">

            <form action = "#" id = "groupSearch">

                <input type = "text" placeholder = "Search for Groups" id = "groupSearchBar">

            </form>

            <button id = "exgr1">Example Group Employee 1</button>
            <button id = "exgr2">Example Group Employee 2</button>
            <button id = "exgr3">Example Group Employee 3</button>
            <button id = "exgr4">Example Group Employee 4</button>

        </div>
            <!-- set as hidden so the example can be shown -->
        <div id = "centrePersonalChat" style="display:none">

            <button id = "exmsg1">Example Message 1</button>
            <button id = "exmsg2">Example Message 2</button>
            <button id = "exmsg3">Example Message 3</button>
            <button id = "exmsg4">Example Message 4</button>

            <form action = "#" id="messageForm">

                <input type = "text" placeholder = "Chat Here!" id = "messageText">
                <button id = "messageSendButton">Send</button>

            </form>

        </div>

        <div id="group-chat-creation" style="width:600px;height:600px;display:none;position:absolute;top:50%;left:50%; transform: translate(-50%, -50%); border:grey 1px solid; flex-direction:column;background-color:white;text-align:center">
            <p>Select users to add to group</p>
            <select id="group-user-select" multiple></select>
            <button onclick="createGroupClicked()">Create Group</button>
            <button onclick="hideCreateGroupChat()">Close menu</button>
        </div>

        <?php 
        include "BottomNavBar.php";//import the bottom nav bar into the page
        ?>

    </body>

</html>