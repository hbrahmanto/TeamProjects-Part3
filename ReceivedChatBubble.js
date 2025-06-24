var receivedChatBubble = document.createElement("receivedChatBubble");
/*
document.addEventListener("DOMContentLoaded",() => {
    getMessages();
})
*/
receivedChatBubble.innerHTML = `

<!--
Apply the following import to the body to include a Received Chat Bubble in your page:
<script src = "ReceivedChatBubble.js"></script>
-->

<!--
!!READ ME!! This component cannot be imported inside of a div as far as I am aware. It will be 
loaded globally. As such, I have included the 'chatSystem' and 'chatWindow' divs in this file 
until a solution can be found as they are needed for the CSS. 
Ideally, these two divs would be located in the HTML/PHP file.
-->

<div id = chatSystem>

    <div id = chatWindow>

        <div id = receivedChatBubbleExt>

            <img src = "Assets/ProfilePicture2.png" id = "profilePicture2" alt = "Profile Picture">

            <div id = "receivedChatBubble">

                <div id = "chatMessage">

                    Hey, I'm settling in quite well thank you, Maybe we could meet up for coffee soon?
                    
                    <div id = sentTime>

                        04:46pm

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>
        
`;

//document.body.appendChild(receivedChatBubble);
/*
function getMessages(){
    //preset data as an example
    chatID= 1;

    //run after the server call
    function callback(array){
        console.log(array)//received data is printed to the console
    }
    //using get in the url fetch
    url = "Database/FetchMessagesFromChat.php" + "?=" + chatID;
    //make request to server
    DatabaseRequest(url, callback);
}

document.body.appendChild(receivedChatBubble);*/

//creates a received chatbubble and appends it to the given chatDiv
//invlude sendername puts the name on the message, use in group chats
//message id saved in chatbubble.value
function createReceivedChatBubble(chatDiv, messageContents, sendTime, messageID, includeSenderName = false, senderName = ""){

    var sendTimeDiv = document.createElement("div");
    sendTimeDiv.className = "sentTime";
    sendTimeDiv.textContent = sendTime;

    var chatMessage = document.createElement("div");
    chatMessage.className = "chatMessage";
    chatMessage.textContent = messageContents;
    chatMessage.appendChild(sendTimeDiv);

    if (includeSenderName){
        var sendNameDiv = document.createElement("div");
        sendNameDiv.className = "sentTime sentName";
        sendNameDiv.textContent = senderName;
        chatMessage.appendChild(sendNameDiv)
    }

    var chatBubble = document.createElement("div");
    chatBubble.className = "receivedChatBubble";
    chatBubble.value = messageID;
    chatBubble.appendChild(chatMessage);

    var chatBubbleExt = document.createElement("div");
    chatBubbleExt.className = "receivedChatBubbleExt";
    chatBubbleExt.appendChild(chatBubble);

    chatDiv.appendChild(chatBubbleExt);
}