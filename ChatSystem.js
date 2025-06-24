/*
document.querySelector("#newMessageButton").addEventListener("click", newMessage);
function newMessage() {
    document.getElementById("navbarButton").style.display = "none";
    document.getElementById("centreHome").style.display = "none";
    document.getElementById("centreNewGroup").style.display = "none";
    document.getElementById("createGroupButton").style.display = "none";
    document.getElementById("centrePersonalChat").style.display = "none";

    document.getElementById("backButton").style.display = "block";
    document.getElementById("newGroupButton").style.display = "block";
    document.getElementById("centreNewMessage").style.display = "block";
}

document.querySelector("#backButton").addEventListener("click", backHome);
function backHome() {
    document.getElementById("navbarButton").style.display = "block";
    document.getElementById("centreHome").style.display = "block";

    document.getElementById("backButton").style.display = "none";
    document.getElementById("newGroupButton").style.display = "none";
    document.getElementById("centreNewMessage").style.display = "none";
    document.getElementById("centreNewGroup").style.display = "none";
    document.getElementById("createGroupButton").style.display = "none";
    document.getElementById("centrePersonalChat").style.display = "none";
}

document.querySelector("#newGroupButton").addEventListener("click", newGroup);
function newGroup() {
    document.getElementById("centreNewGroup").style.display = "block";
    document.getElementById("createGroupButton").style.display = "block";

    document.getElementById("centreNewMessage").style.display = "none";
    document.getElementById("newGroupButton").style.display = "none";
}

document.querySelector("#ex1").addEventListener("click", openChat);
function openChat() {
    document.getElementById("centrePersonalChat").style.display = "block";
    document.getElementById("backButton").style.display = "block";

    document.getElementById("navbarButton").style.display = "none";
    document.getElementById("centreHome").style.display = "none";
}*/

window.onload = function () {
    document.getElementById("backButton").style.display = "none";
    document.getElementById("newGroupButton").style.display = "none";
    document.getElementById("centreNewMessage").style.display = "none";
    document.getElementById("centreNewGroup").style.display = "none";
    document.getElementById("createGroupButton").style.display = "none";
    document.getElementById("centrePersonalChat").style.display = "none";
}

//gets and returns an array from the server of 
function getChats(userID){
    //run after the server call
    function callback(array){
        console.log(array);//received data is printed to the console
        return array;
    }
    //using get in the url fetch
    url = "Database/FetchChatsFromUser.php" + "?userID=" + userID;
    //make request to server
    DatabaseRequest(url, callback);
}

//populates the private chats screen with data from the server
function loadPrivateChats(){
    console.log("loading private chats")
    switchTab('private-chat');//switch to chat screen

    //run after the server call
    function callback(array){
        console.log(array);//received data is printed to the console
        chatDiv = document.getElementById("private-chat-div");
        chatDiv.innerHTML = "";//clear the chats

        //--//
        //Add the chat buttons
        array.forEach((chat)=>{
            if (chat["ChatType"] == "private"){
                //create button for chat here
                console.log("Chat: " + chat["ChatID"])

                //Create a container for each message
                chatContainer = document.createElement('div');
                chatContainer.className = 'chat-container';

                //Create button for toggling message
                chatToggle = document.createElement("button");
                chatToggle.className = "chat-toggle";
                chatToggle.value = chat["ChatID"];

                //Profile picture
                imgElement = document.createElement("img");
                imgElement.src = "Assets/ProfilePicture.png";
                imgElement.alt = "Profile Picture";
                imgElement.className = "profile-pic";

                //name of the person being talked to
                chatName = document.createElement("span");
                chatName.className = "chat-name";
                chatName.textContent = chat["OtherUsersInChat"][0]["Name"]

                //lastMessagediv
                lastMessageDiv = document.createElement("div");
                lastMessageDiv.className = "last-message-div";

                //Sender name of the last message
                senderName = document.createElement("span");
                senderName.className = "sender-name";
                
                //Message text (hidden initially)
                chatText = document.createElement("div");
                chatText.className = "message-text";
                console.log(chat["LastMessage"]);

                if (chat["LastMessage"]){
                    senderName.textContent = chat["LastMessage"]["SenderName"];
                    chatText.textContent = chat["LastMessage"]["MessageContents"];
                }else{
                    chatText.textContent = "No messages in chat";
                }
                lastMessageDiv.appendChild(senderName);
                lastMessageDiv.appendChild(document.createTextNode(": " + chatText.textContent))

                //Append message text to the message button
                chatToggle.appendChild(imgElement);
                chatToggle.appendChild(chatName);
                chatToggle.appendChild(lastMessageDiv);

                //Toggle visibility on click
                chatToggle.onclick = function() {
                    //load the chat for this button
                    chatID = this.value
                    console.log("chat id for clicked button is " + chatID)
                    loadChat(chatID, "Private")

                };

                //Append elements to the chat container
                chatContainer.appendChild(chatToggle);
                chatDiv.appendChild(chatContainer);

            }
                
        })

        //Button for creating a private chat
        buttonContainer = document.createElement('div');
        buttonContainer.className = 'chat-container';

        createButton = document.createElement("button");
        createButton.className = 'chat-toggle';

        buttonText = document.createElement("span");
        buttonText.className = 'chat-name';
        buttonText.textContent = 'Create New Chat';

        createButton.appendChild(buttonText);

        createButton.onclick = function() {
            newUserID = document.getElementById("private-user-select").value;
            console.log("new userID: " + newUserID + " page user id" + pageUserID)
            createNewPrivateChat(parseInt(newUserID));
        };

        //name select
        nameSelect = document.createElement("select");
        nameSelect.id = "private-user-select";

        function usersCallback(array){
            array.forEach((user)=>{
                const option = document.createElement("option");
                option.value = user["UserID"];
                option.text = user["Name"];
                nameSelect.appendChild(option);
            })
        }

        url = "Database/FetchAllUsers.php"
        DatabaseRequest(url, usersCallback)
        buttonContainer.appendChild(nameSelect);
        buttonContainer.appendChild(createButton);
        chatDiv.appendChild(buttonContainer);
    }
    //using get in the url fetch
    url = "Database/FetchChatsFromUser.php" + "?userID=" + pageUserID;
    //make request to server
    DatabaseRequest(url, callback);
}

function loadGroupChats(){
    console.log("loading group chats")
    switchTab('group-chat');//switch to chat screen

    //run after the server call
    function callback(array){
        console.log(array);//received data is printed to the console
        chatDiv = document.getElementById("group-chat-div");
        chatDiv.innerHTML = "";//clear the chats

        //--//
        //Add the chat buttons
        if(array){    
            array.forEach((chat)=>{
                if (chat["ChatType"] == "group"){
                    //create button for chat here
                    console.log("Chat: " + chat["ChatID"])

                    //Group Chat Container
                    gcContainer = document.createElement("div");
                    gcContainer.className = 'chat-container';

                    //Group Chat Toggle Button
                    gcToggle = document.createElement("button");
                    gcToggle.className = "chat-toggle";
                    gcToggle.value = chat["ChatID"];
                    console.log(chat["ChatID"]);

                    //Group Chat Icon
                    gcImage = document.createElement("img");
                    gcImage.src = "Assets/GroupPicture.png";
                    gcImage.alt = "Profile Picture";
                    gcImage.className = "profile-pic";
                    
                    //Append message text to the message button
                    gcToggle.appendChild(gcImage);

                    //name of the person being talked to
                    chat.OtherUsersInChat.forEach(function(user) {
                        gcName = document.createElement("span");
                        gcName.className = "chat-name";
                        gcName.textContent = user.Name;
                        gcToggle.appendChild(gcName);

                        coma = document.createElement("span");
                        coma.textContent = ', ';
                        gcToggle.appendChild(coma);
                    });

                    //lastMessagediv
                    gcMessageDiv = document.createElement("div");
                    gcMessageDiv.className = "last-message-div";

                    //Sender name of the last message
                    gcSenderName = document.createElement("span");
                    gcSenderName.className = "sender-name";
                    
                    

                    //Message text (hidden initially)
                    gcText = document.createElement("div");
                    gcText.className = "message-text";

                    if(chat["LastMessage"]){
                        gcSenderName.textContent = chat["LastMessage"]["SenderName"];
                        console.log(chat["LastMessage"]);
                        gcText.textContent = chat["LastMessage"]["MessageContents"];  
                    }else{
                        gcText.textContent = "No Messages in chat"
                    }
                    gcMessageDiv.appendChild(document.createTextNode(": " + gcText.textContent))
                    gcMessageDiv.appendChild(gcSenderName);

                    //Append message text to the message button
                    gcToggle.appendChild(gcMessageDiv);
                    
                    gcToggle.onclick = function(){
                        //LOAD THE CHAT HERE
                        chatID = this.value
                        console.log("chat id for clicked button is " + chatID)
                        loadChat(chatID, "Group")
                    }

                    //Append elements to the chat container
                    gcContainer.appendChild(gcToggle);
                    chatDiv.appendChild(gcContainer);

                }
                    
            })
        }

        //Button for creating a group chat
        gcbuttonContainer = document.createElement('div');
        gcbuttonContainer.className = 'chat-container';

        gcCreateButton = document.createElement("button");
        gcCreateButton.className = 'chat-toggle';

        gcCreateButton.onclick= function(){
            document.getElementById("group-chat-creation").style.display = "flex";
            var selectElement = document.getElementById("group-user-select");
            selectElement.innerHTML = "";
            function callback(array){
                array.forEach((user)=>{
                    
                    var userID = user["UserID"];
                    var userName = user["Name"];
                    console.log(userID + " " + userName);
                    if(userID != pageUserID){
                        var option = document.createElement("option");
                        option.value = userID;
                        option.text = userName
                        selectElement.appendChild(option);
                    }

                })
            }
            url = "Database/FetchAllUsers.php";
            DatabaseRequest(url,callback);
        }

        gcbuttonText = document.createElement("span");
        gcbuttonText.className = 'chat-name';
        gcbuttonText.textContent = 'Create New Chat';

        gcCreateButton.appendChild(gcbuttonText);

        gcbuttonContainer.appendChild(gcCreateButton);
        chatDiv.appendChild(gcbuttonContainer);

    }
    //using get in the url fetch
    url = "Database/FetchChatsFromUser.php" + "?userID=" + pageUserID;
    //make request to server
    DatabaseRequest(url, callback);
}

function loadChat(ChatID, chatType){
    //setup the message box
    //Message Box Input
    messageInput = document.getElementById("messageInput");
    if (messageInput) {
        messageInput.placeholder = 'Message...'; // Update placeholder to reflect current chat
        messageInput.focus();

        //Making sure that enter key is pressed to send message
        messageInput.onkeypress = function(event) {
            if (event.key == "Enter") {
                event.preventDefault();
                if (messageInput.value.trim()) {
                    sendMessage(chatID, messageInput.value);
                    messageInput.value = '';
                }
            }
        }
    }

    switchTab('messages-chat')
    messagesDiv = document.getElementById("messages-div");
    messagesDiv.innerHTML = "" // clear messages

    messagesTitle = document.getElementById("messages-title");
    messagesTitle.innerHTML = chatType + " Chat "+ ChatID;

    function callback(array){
        console.log(array)
        if (array.length == 0){
            messagesDiv.innerHTML = "no messages in this chat yet";
        }
        array.forEach((message)=>{
            //create the message
            //this is a placeholder with just a p element, replace with jaidens chat bubbles
            if (message["UserID"] == pageUserID){
                //message was sent by logged in user
                createSentChatBubble(messagesDiv, message["MessageContents"], message["SendingTime"], message["MessageID"]);
            }else{
                //message was sent by someone else
                createReceivedChatBubble(messagesDiv, message["MessageContents"], message["SendingTime"], message["MessageID"]);
            }
            

        })
    }
    //using get in the url fetch
    url = "Database/FetchMessagesFromChat.php" + "?ChatID=" + ChatID;
    //make request to server
    DatabaseRequest(url, callback);

}

// Simple MessageBox Sender
function sendMessage(chatID, messageContents) {
    messagesDiv = document.getElementById("messages-div");
    console.log("message: " + messageContents + "sent to chat " + chatID);
    message = document.getElementById("messageInput").value;

    function callback(array){
        if(array["Status"] == "Success"){
            currentDateTime = new Date();
            year = currentDateTime.getFullYear();
            month = String(currentDateTime.getMonth() + 1).padStart(2, '0');
            day = String(currentDateTime.getDate()).padStart(2, '0');
            hours = String(currentDateTime.getHours()).padStart(2, '0');
            minutes = String(currentDateTime.getMinutes()).padStart(2, '0');
            seconds = String(currentDateTime.getSeconds()).padStart(2, '0');
            dateString = `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;

            createSentChatBubble(messagesDiv, messageContents, dateString)
            document.getElementById("messageInput").value = ''; // Clear the input 
        }else{
            console.log("error: " + array["Status"]);
        }
        
    }
    var data = {}
    data["UserID"] = pageUserID;
    data["ChatID"] = chatID;
    data["MessageContents"] = messageContents;
    url = "Database/CreateMessage.php";
    DatabaseRequestPost(url, callback, data);   
}

// Simple JavaScript function for tab switching
function switchTab(tabName) {
    const tabs = document.querySelectorAll('.tab-content');
    tabs.forEach(tab => {
        tab.style.display = 'none';
    });
    document.getElementById(`${tabName}-container`).style.display = 'block';
}

//Function that creates private chat
function createNewPrivateChat(otherUserID){
    function callback(array){
        if(array["Status"] == "Success"){
            loadPrivateChats();//force reload the chats, would be more efficient to just add the single new element
        }else{
            console.log("Error in CreatePrivateChat.php: " + array["Status"]);
        }
        
    }
    data = {};
    data["User1ID"] = pageUserID;
    data["User2ID"] = otherUserID;
    console.log(typeof(data["User1ID"]))
    console.log(typeof(data["User1ID"]))
    url = "Database/CreatePrivateChat.php";
    DatabaseRequestPost(url, callback, data);
}

//Function that creates group chat
function createNewGroupChat(selectedOptions){
    if(selectedOptions.length <=0){
        console.log("selected option was empty");
        return
    }
    var data = {}
    data["UserID"] = pageUserID;
    console.log("userId: ", typeof(data["UserID"]), data["UserID"])
    function callback(array){
        if(array["Status"] == "Success"){
            var newChatID = array["ChatID"]
            selectedOptions.forEach((user)=>{
                function addUserCallback(array){
                    if(array["Status"] == "Success"){
                        console.log(user, " Added to group chat ", newChatID)
                    }else{
                        console.log("Error in addusertogroupchat: ", array["Status"])
                    }
                    
                }
                var url = "Database/AddUserToGroupChat.php"
                var dataArray = {}
                dataArray["UserID"] = parseInt(user);
                dataArray["ChatID"] = parseInt(newChatID);
                console.log("userID is : ", user, typeof(user))
                DatabaseRequestPost(url, addUserCallback, dataArray);
            })
        }else{
            console.log("Error in CreateGroupChat.php: " + array["Status"]);
        }
    }
    url = "Database/CreateGroupChat.php";
    DatabaseRequestPost(url, callback, data);
}

function hideCreateGroupChat(){
    document.getElementById("group-chat-creation").style.display = "none";
}

function createGroupClicked(){
    var selectElement = document.getElementById("group-user-select");
    var selectedOptions = Array.from(selectElement.selectedOptions).map(option => option.value);
    console.log("selected users = ", selectedOptions)
    createNewGroupChat(selectedOptions)

}